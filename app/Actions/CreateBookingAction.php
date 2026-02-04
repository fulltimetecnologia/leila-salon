<?php

namespace App\Actions;

use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CreateBookingAction
{
    public function execute(User $user, Service $service, Carbon $scheduledAt, ?string $notes = null): Booking
    {
        return DB::transaction(function () use ($user, $service, $scheduledAt, $notes) {
            return Booking::create([
                'user_id' => $user->id,
                'service_id' => $service->id,
                'scheduled_at' => $scheduledAt,
                'status' => 'pending',
                'notes' => $notes,
            ]);
        });
    }
}
