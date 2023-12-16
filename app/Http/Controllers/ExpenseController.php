<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Expense;
use App\Models\Category;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\ExpenseStoreRequest;
use App\Http\Requests\ExpenseUpdateRequest;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Expense::class);

        $search = $request->get('search', '');

        $expenses = Expense::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.expenses.index', compact('expenses', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Expense::class);

        $users = User::pluck('name', 'id');
        $categories = Category::pluck('name', 'id');

        return view('app.expenses.create', compact('users', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExpenseStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Expense::class);

        $validated = $request->validated();

        $expense = Expense::create($validated);

        return redirect()
            ->route('expenses.edit', $expense)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Expense $expense): View
    {
        $this->authorize('view', $expense);

        return view('app.expenses.show', compact('expense'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Expense $expense): View
    {
        $this->authorize('update', $expense);

        $users = User::pluck('name', 'id');
        $categories = Category::pluck('name', 'id');

        return view(
            'app.expenses.edit',
            compact('expense', 'users', 'categories')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        ExpenseUpdateRequest $request,
        Expense $expense
    ): RedirectResponse {
        $this->authorize('update', $expense);

        $validated = $request->validated();

        $expense->update($validated);

        return redirect()
            ->route('expenses.edit', $expense)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Expense $expense
    ): RedirectResponse {
        $this->authorize('delete', $expense);

        $expense->delete();

        return redirect()
            ->route('expenses.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
