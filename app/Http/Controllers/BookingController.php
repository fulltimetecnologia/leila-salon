<?php

namespace App\Http\Controllers;

use App\Actions\CreateBookingAction;
use App\Actions\UpdateBookingAction;
use App\Models\Booking;
use App\Models\Service;
use App\Rules\ValidBookingTime;
use App\Services\BookingService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    public function __construct(
        private BookingService $bookingService,
        private CreateBookingAction $createAction,
        private UpdateBookingAction $updateAction
    ) {}

    public function index(Request $request)
    {
        $bookings = Booking::where('user_id', currentUserId())
            ->with('service')
            ->latest('scheduled_at')
            ->paginate(10);

        return view('bookings.index', compact('bookings'));
    }

    public function create()
    {
        $services = Service::active()->get();

        return view('bookings.create', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'scheduled_at' => ['required', 'date', 'after:now', new ValidBookingTime($request->service_id)],
            'notes' => 'nullable|string|max:500',
        ]);

        $service = Service::findOrFail($validated['service_id']);
        $scheduledAt = Carbon::parse($validated['scheduled_at']);

        $suggestedDate = $this->bookingService->suggestSameDate(currentUser(), $scheduledAt);

        $booking = $this->createAction->execute(
            currentUser(),
            $service,
            $scheduledAt,
            $validated['notes'] ?? null
        );

        return redirect()->route('bookings.index')
            ->with('success', __('booking.messages.created_success'));
    }

    public function edit(Booking $booking)
    {
        $this->authorize('update', $booking);

        if (! $this->bookingService->canModifyBooking($booking)) {
            return redirect()->route('bookings.index')
                ->with('error', __('booking.messages.cannot_modify_contact'));
        }

        $services = Service::active()->get();

        return view('bookings.edit', compact('booking', 'services'));
    }

    public function update(Request $request, Booking $booking)
    {
        $this->authorize('update', $booking);

        if (! $this->bookingService->canModifyBooking($booking)) {
            return back()->with('error', __('booking.messages.cannot_modify'));
        }

        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'scheduled_at' => 'required|date|after:now',
            'notes' => 'nullable|string|max:500',
        ]);

        $this->updateAction->execute($booking, $validated);

        return redirect()->route('bookings.index')
            ->with('success', __('booking.messages.updated_success'));
    }

    public function destroy(Booking $booking)
    {
        $this->authorize('delete', $booking);

        if (! $this->bookingService->canModifyBooking($booking)) {
            return back()->with('error', __('booking.messages.cannot_cancel'));
        }

        $this->updateAction->cancel($booking);

        return redirect()->route('bookings.index')
            ->with('success', __('booking.messages.cancelled_success'));
    }

    public function history(Request $request)
    {
        $startDate = $request->input('start_date', now()->subMonth());
        $endDate = $request->input('end_date', now());

        $bookings = Booking::where('user_id', currentUserId())
            ->with('service')
            ->inPeriod($startDate, $endDate)
            ->latest('scheduled_at')
            ->get();

        return view('bookings.history', compact('bookings', 'startDate', 'endDate'));
    }

    public function show(Booking $booking)
    {
        $this->authorize('view', $booking);

        return view('bookings.show', compact('booking'));
    }

    public function availableSlots(Request $request)
    {
        $request->validate([
            'date' => 'required|date|after:yesterday',
            'service_id' => 'required|exists:services,id',
        ]);

        $date = Carbon::parse($request->date);
        $serviceId = $request->service_id;

        $slots = $this->bookingService->getAvailableSlots($date, $serviceId);

        Log::info('Available slots request', [
            'date' => $date->format('Y-m-d'),
            'day_of_week' => strtolower($date->format('l')),
            'service_id' => $serviceId,
            'slots_count' => count($slots),
            'slots' => $slots,
        ]);

        return response()->json([
            'success' => true,
            'slots' => $slots,
            'date' => $date->format('Y-m-d'),
        ]);
    }

    public function checkSuggestedDate(Request $request)
    {
        $request->validate([
            'date' => 'required|date|after:yesterday',
        ]);

        $proposedDate = Carbon::parse($request->date);
        $suggestedDate = $this->bookingService->suggestSameDate(currentUser(), $proposedDate);

        if ($suggestedDate) {
            return response()->json([
                'has_suggestion' => true,
                'suggested_date' => $suggestedDate->format('Y-m-d'),
                'suggested_time' => $suggestedDate->format('H:i'),
                'message' => __('booking.messages.suggestion_message', [
                    'datetime' => $suggestedDate->format('d/m/Y H:i')
                ])
            ]);
        }

        return response()->json([
            'has_suggestion' => false
        ]);
    }
}
