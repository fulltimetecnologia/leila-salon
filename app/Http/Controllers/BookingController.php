<?php

namespace App\Http\Controllers;

use App\Actions\CreateBookingAction;
use App\Actions\UpdateBookingAction;
use App\Models\Booking;
use App\Models\Service;
use App\Services\BookingService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function __construct(
        private BookingService $bookingService,
        private CreateBookingAction $createAction,
        private UpdateBookingAction $updateAction
    ) {}

    public function index(Request $request)
    {
        $bookings = Booking::where('user_id', auth()->id())
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
            'scheduled_at' => 'required|date|after:now',
            'notes' => 'nullable|string|max:500',
        ]);

        $service = Service::findOrFail($validated['service_id']);
        $scheduledAt = Carbon::parse($validated['scheduled_at']);

        $suggestedDate = $this->bookingService->suggestSameDate(auth()->user(), $scheduledAt);

        $booking = $this->createAction->execute(
            auth()->user(),
            $service,
            $scheduledAt,
            $validated['notes'] ?? null
        );

        return redirect()->route('bookings.index')
            ->with('success', 'Agendamento criado com sucesso!')
            ->with('suggested_date', $suggestedDate);
    }

    public function edit(Booking $booking)
    {
        $this->authorize('update', $booking);

        if (! $this->bookingService->canModifyBooking($booking)) {
            return redirect()->route('bookings.index')
                ->with('error', 'Não é possível alterar agendamentos com menos de 2 dias de antecedência. Entre em contato por telefone.');
        }

        $services = Service::active()->get();

        return view('bookings.edit', compact('booking', 'services'));
    }

    public function update(Request $request, Booking $booking)
    {
        $this->authorize('update', $booking);

        if (! $this->bookingService->canModifyBooking($booking)) {
            return back()->with('error', 'Não é possível alterar agendamentos com menos de 2 dias de antecedência.');
        }

        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'scheduled_at' => 'required|date|after:now',
            'notes' => 'nullable|string|max:500',
        ]);

        $this->updateAction->execute($booking, $validated);

        return redirect()->route('bookings.index')
            ->with('success', 'Agendamento atualizado com sucesso!');
    }

    public function destroy(Booking $booking)
    {
        $this->authorize('delete', $booking);

        if (! $this->bookingService->canModifyBooking($booking)) {
            return back()->with('error', 'Não é possível cancelar agendamentos com menos de 2 dias de antecedência.');
        }

        $this->updateAction->cancel($booking);

        return redirect()->route('bookings.index')
            ->with('success', 'Agendamento cancelado com sucesso!');
    }

    public function history(Request $request)
    {
        $startDate = $request->input('start_date', now()->subMonth());
        $endDate = $request->input('end_date', now());

        $bookings = Booking::where('user_id', auth()->id())
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
}
