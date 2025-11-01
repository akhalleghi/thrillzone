<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $transactions = Transaction::query()
            ->with(['plan'])
            ->where('user_id', $user->id)
            ->latest('paid_at')
            ->latest('created_at')
            ->paginate(12)
            ->withQueryString();

        return view('user.transactions', [
            'transactions' => $transactions,
        ]);
    }
}
