<?php

namespace App\Http\Controllers;

use App\Models\FeeInvoice;
use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ParentDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $children = $user->students; // Relationship defined in User model

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

        return view('parent.dashboard', compact(
            'children',
            'childrenCount',
            'outstandingFees',
            'recentNotices'
        ));
    }
}
