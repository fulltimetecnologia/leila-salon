<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class BookingService
{
    public function canModifyBooking(Booking $booking): bool
    {
        return $booking->canBeModified();
    }

    public function getUserBookingsInWeek(User $user, Carbon $date): Collection
    {
        $startOfWeek = $date->copy()->startOfWeek();
        $endOfWeek = $date->copy()->endOfWeek();

        return Booking::where('user_id', $user->id)
            ->whereBetween('scheduled_at', [$startOfWeek, $endOfWeek])
            ->whereIn('status', ['pending', 'confirmed'])
            ->get();
    }

    public function suggestSameDate(User $user, Carbon $proposedDate): ?Carbon
    {
        $bookingsInWeek = $this->getUserBookingsInWeek($user, $proposedDate);

        if ($bookingsInWeek->isEmpty()) {
            return null;
        }

        $existingBooking = $bookingsInWeek->first()->scheduled_at;
        
        if ($existingBooking->isSameDay($proposedDate)) {
            return null;
        }

        return $existingBooking;
    }

    public function getWeeklyStats(Carbon $startDate, Carbon $endDate): array
    {
        $bookings = Booking::inPeriod($startDate, $endDate)->with('service')->get();

        return [
            'total_bookings' => $bookings->count(),
            'confirmed_bookings' => $bookings->where('status', 'confirmed')->count(),
            'pending_bookings' => $bookings->where('status', 'pending')->count(),
            'completed_bookings' => $bookings->where('status', 'completed')->count(),
            'cancelled_bookings' => $bookings->where('status', 'cancelled')->count(),
            'total_revenue' => $bookings->where('status', 'completed')->sum(fn ($b) => $b->service->price),
        ];
    }

    public function getBookingsForDay(Carbon $date): Collection
    {
        $startOfDay = $date->copy()->startOfDay();
        $endOfDay = $date->copy()->endOfDay();

        return Booking::whereBetween('scheduled_at', [$startOfDay, $endOfDay])
            ->whereIn('status', ['pending', 'confirmed'])
            ->with('service')
            ->orderBy('scheduled_at')
            ->get();
    }

    public function calculateEndTime(Carbon $scheduledAt, int $durationMinutes): Carbon
    {
        return $scheduledAt->copy()->addMinutes($durationMinutes);
    }

    public function isTimeSlotAvailable(Carbon $scheduledAt, int $durationMinutes, ?int $excludeBookingId = null): bool
    {
        $proposedStart = $scheduledAt->copy();
        $proposedEnd = $this->calculateEndTime($scheduledAt, $durationMinutes);

        $bookings = $this->getBookingsForDay($scheduledAt);

        if ($excludeBookingId) {
            $bookings = $bookings->where('id', '!=', $excludeBookingId);
        }

        foreach ($bookings as $booking) {
            $existingStart = $booking->scheduled_at;
            $existingEnd = $this->calculateEndTime($existingStart, $booking->service->duration_minutes);

            if ($proposedStart->lessThan($existingEnd) && $proposedEnd->greaterThan($existingStart)) {
                return false;
            }
        }

        return true;
    }

    public function getAvailableSlots(Carbon $date, int $serviceId): array
    {
        $service = Service::findOrFail($serviceId);
        $dayOfWeek = strtolower($date->format('l'));
        
        $businessHours = config("booking.business_hours.{$dayOfWeek}");
        
        if (! $businessHours) {
            return [];
        }

        [$openTime, $closeTime] = $businessHours;
        
        $slots = [];
        $slotInterval = config('booking.slot_interval_minutes', 60);
        
        $currentSlot = $date->copy()->setTimeFromTimeString($openTime);
        $closeDateTime = $date->copy()->setTimeFromTimeString($closeTime);
        $now = Carbon::now();

        while ($currentSlot->lessThan($closeDateTime)) {
            if ($currentSlot->greaterThan($now)) {
                if ($this->isTimeSlotAvailable($currentSlot, $service->duration_minutes)) {
                    $slots[] = $currentSlot->format('H:i');
                }
            }
            
            $currentSlot->addMinutes($slotInterval);
        }

        return $slots;
    }
}
