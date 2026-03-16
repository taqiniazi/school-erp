<?php

namespace App\Http\Controllers;

use App\Models\FeeInvoice;
use App\Models\Notice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ParentDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Cache dashboard data for 15 minutes
        $data = Cache::remember('parent_dashboard_'.$user->id, 900, function () use ($user) {
            $children = $user->students()->with(['schoolClass', 'section'])->get(); // Eager load class and section

            // KPIs
            $childrenCount = $children->count();

            $outstandingFees = 0;
            if ($childrenCount > 0) {
                $childrenIds = $children->pluck('id');
                $outstandingFees = FeeInvoice::whereIn('student_id', $childrenIds)
                    ->whereIn('status', ['unpaid', 'partial'])
                    ->sum(DB::raw('(total_amount + fine_amount) - (paid_amount + discount_amount)'));
            }

            // Alerts
            $recentNotices = Notice::whereIn('audience_role', ['all', 'Parent'])
                ->latest()
                ->take(5)
                ->get();

            return compact(
                'children',
                'childrenCount',
                'outstandingFees',
                'recentNotices'
            );
        });

        return view('parent.dashboard', $data);
    }
}
