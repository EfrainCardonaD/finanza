<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExpenseResource;
use App\Http\Resources\ExpenseCollection;

class CategoryExpensesController extends Controller
{
    public function index(
        Request $request,
        Category $category
    ): ExpenseCollection {
        $this->authorize('view', $category);

        $search = $request->get('search', '');

        $expenses = $category
            ->expenses()
            ->search($search)
            ->latest()
            ->paginate();

        return new ExpenseCollection($expenses);
    }

    public function store(Request $request, Category $category): ExpenseResource
    {
        $this->authorize('create', Expense::class);

        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'amount' => ['required', 'numeric'],
        ]);

        $expense = $category->expenses()->create($validated);

        return new ExpenseResource($expense);
    }
}
