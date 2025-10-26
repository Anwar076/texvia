<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        
        // Get or create subscription
        $subscription = $user->subscription ?? Subscription::create([
            'user_id' => $user->id,
            'plan' => 'free',
            'limit' => 10, // Free plan gets 10 generations per month
            'used' => 0,
            'renew_date' => now()->addMonth(),
        ]);

        // Get recent content
        $recentContent = $user->contents()
            ->latest()
            ->take(5)
            ->get();

        // Get content statistics
        $contentStats = [
            'total' => $user->contents()->count(),
            'this_month' => $user->contents()->whereMonth('created_at', now()->month)->count(),
            'by_type' => $user->contents()
                ->selectRaw('type, COUNT(*) as count')
                ->groupBy('type')
                ->pluck('count', 'type')
                ->toArray(),
        ];

        return view('dashboard', compact('subscription', 'recentContent', 'contentStats'));
    }
}
