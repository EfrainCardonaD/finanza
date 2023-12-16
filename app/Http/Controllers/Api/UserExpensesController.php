<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExpenseResource;
use App\Http\Resources\ExpenseCollection;

class UserExpensesController extends Controller
{
    public function index(Request $request, User $user): ExpenseCollection
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $expenses = $user
            ->expenses()
            ->search($search)
            ->latest()
            ->paginate();

        return new ExpenseCollection($expenses);
    }

    public function store(Request $request, User $user): ExpenseResource
    {
        $this->authorize('create', Expense::class);

        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'amount' => ['required', 'numeric'],
        ]);

        $expense = $user->expenses()->create($validated);

        return new ExpenseResource($expense);
    }
}
