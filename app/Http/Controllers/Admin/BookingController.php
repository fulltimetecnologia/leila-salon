<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Service;
use App\Actions\UpdateBookingAction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function __construct(private UpdateBookingAction $updateAction) {}

    public function index(Request $request)
    {
        $status = $request->input('status');
        
        $bookings = Booking::with(['user', 'service'])
            ->when($status, fn($q) => $q->where('status', $status))
            ->latest('scheduled_at')
            ->paginate(20);

        return view('admin.bookings.index', compact('bookings'));
    }

    public function edit(Booking $booking)
    {
        $services = Service::active()->get();
        return view('admin.bookings.edit', compact('booking', 'services'));
    }

    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'scheduled_at' => 'required|date',
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'notes' => 'nullable|string|max:500',
        ]);

        $this->updateAction->execute($booking, $validated);

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Agendamento atualizado com sucesso!');
    }

    public function confirm(Booking $booking)
    {
        $this->updateAction->confirm($booking);

        return back()->with('success', 'Agendamento confirmado!');
    }

    public function complete(Booking $booking)
    {
        $this->updateAction->complete($booking);

        return back()->with('success', 'Agendamento concluído!');
    }

    public function cancel(Booking $booking)
    {
        $this->updateAction->cancel($booking);

        return back()->with('success', 'Agendamento cancelado!');
    }
}

