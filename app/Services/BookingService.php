<?php

namespace App\Services;

use App\Models\Booking;
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

        return $bookingsInWeek->first()->scheduled_at;
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
}
