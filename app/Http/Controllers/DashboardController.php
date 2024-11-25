<?php

namespace App\Http\Controllers;

use App\Models\Unite;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get statistics
        $totalUnits = Unite::count();
        $activeBookings = Booking::where('status', 'active')->count();
        $totalBookings = Booking::count();

        // تجهيز البيانات للرسم البياني
        $labels = [
            'يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو',
            'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'
        ];

        // Get monthly bookings data
        $monthlyData = DB::table('bookings')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // تجهيز مصفوفة البيانات
        $data = array_fill(0, 12, 0); // ملء المصفوفة بأصفار
        foreach ($monthlyData as $item) {
            $data[$item->month - 1] = $item->count;
        }

        return view('dashboard', compact(
            'totalUnits',
            'activeBookings',
            'totalBookings',
            'labels',
            'data'
        ));
    }
}