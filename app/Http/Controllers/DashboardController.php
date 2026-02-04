<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Services\BookingService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct(private BookingService $bookingService) {}

    public function index()
    {
        return view('dashboard');
    }

    public function admin(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfWeek());
        $endDate = $request->input('end_date', now()->endOfWeek());

        $startDate = Carbon::parse($startDate);
        $endDate = Carbon::parse($endDate);

        $stats = $this->bookingService->getWeeklyStats($startDate, $endDate);

        $upcomingBookings = Booking::with(['user', 'service'])
            ->upcoming()
            ->orderBy('scheduled_at')
            ->limit(10)
            ->get();

        $recentBookings = Booking::with(['user', 'service'])
            ->latest('created_at')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'upcomingBookings', 'recentBookings', 'startDate', 'endDate'));
    }
}
