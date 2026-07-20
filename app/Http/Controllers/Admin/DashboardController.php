<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRevenue = Transaction::whereIn('status', ['settlement', 'success'])->sum('total_price');
        $ticketsSold = Transaction::whereIn('status', ['settlement', 'success'])->count();
        $activeEvents = Event::where('date', '>=', now())->count();
        $pendingOrders = Transaction::where('status', 'pending')->count();
        $recentTransactions = Transaction::with('event')->latest()->take(5)->get();
        $recentEvents = Event::with('category')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalRevenue',
            'ticketsSold',
            'activeEvents',
            'pendingOrders',
            'recentTransactions',
            'recentEvents'
        ));
    }
}
