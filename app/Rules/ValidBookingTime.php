<?php

namespace App\Rules;

use App\Models\Service;
use App\Services\BookingService;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidBookingTime implements ValidationRule
{
    public function __construct(
        private ?int $serviceId = null,
        private ?int $excludeBookingId = null
    ) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! $value) {
            $fail(__('booking.validation.time_required'));
            return;
        }

        try {
            $scheduledAt = Carbon::parse($value);
        } catch (\Exception $e) {
            $fail(__('booking.validation.invalid_datetime'));
            return;
        }

        if ($scheduledAt->minute !== 0) {
            $fail(__('booking.validation.must_be_full_hour'));
            return;
        }

        if ($scheduledAt->isPast()) {
            $fail(__('booking.validation.past_time'));
            return;
        }

        $dayOfWeek = strtolower($scheduledAt->format('l'));
        $businessHours = config("booking.business_hours.{$dayOfWeek}");

        if (! $businessHours) {
            $fail(__('booking.validation.closed_day'));
            return;
        }

        [$openTime, $closeTime] = $businessHours;
        $openDateTime = $scheduledAt->copy()->setTimeFromTimeString($openTime);
        $closeDateTime = $scheduledAt->copy()->setTimeFromTimeString($closeTime);

        if ($scheduledAt->lessThan($openDateTime) || $scheduledAt->greaterThanOrEqualTo($closeDateTime)) {
            $fail(__('booking.validation.outside_hours', ['open' => $openTime, 'close' => $closeTime]));
            return;
        }

        if ($this->serviceId) {
            $service = Service::find($this->serviceId);
            
            if (! $service) {
                $fail(__('booking.validation.service_not_found'));
                return;
            }

            $bookingService = app(BookingService::class);
            
            if (! $bookingService->isTimeSlotAvailable($scheduledAt, $service->duration_minutes, $this->excludeBookingId)) {
                $fail(__('booking.validation.slot_not_available'));
                return;
            }
        }
    }
}
