<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['event.category'])
            ->latest()
            ->paginate(15);

        return view('admin.transactions.index', compact('transactions'));
    }
}
