<?php

namespace App\Actions;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UpdateBookingAction
{
    public function execute(Booking $booking, array $data): Booking
    {
        return DB::transaction(function () use ($booking, $data) {
            $booking->update($data);
            return $booking->fresh();
        });
    }

    public function updateScheduledAt(Booking $booking, Carbon $newScheduledAt): Booking
    {
        return $this->execute($booking, ['scheduled_at' => $newScheduledAt]);
    }

    public function updateStatus(Booking $booking, string $status): Booking
    {
        return $this->execute($booking, ['status' => $status]);
    }

    public function confirm(Booking $booking): Booking
    {
        return $this->updateStatus($booking, 'confirmed');
    }

    public function complete(Booking $booking): Booking
    {
        return $this->updateStatus($booking, 'completed');
    }

    public function cancel(Booking $booking): Booking
    {
        return $this->updateStatus($booking, 'cancelled');
    }
}
