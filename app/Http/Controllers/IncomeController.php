<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Income;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\IncomeStoreRequest;
use App\Http\Requests\IncomeUpdateRequest;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Income::class);

        $search = $request->get('search', '');

        $incomes = Income::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.incomes.index', compact('incomes', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Income::class);

        $users = User::pluck('name', 'id');

        return view('app.incomes.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(IncomeStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Income::class);

        $validated = $request->validated();

        $income = Income::create($validated);

        return redirect()
            ->route('incomes.edit', $income)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Income $income): View
    {
        $this->authorize('view', $income);

        return view('app.incomes.show', compact('income'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Income $income): View
    {
        $this->authorize('update', $income);

        $users = User::pluck('name', 'id');

        return view('app.incomes.edit', compact('income', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        IncomeUpdateRequest $request,
        Income $income
    ): RedirectResponse {
        $this->authorize('update', $income);

        $validated = $request->validated();

        $income->update($validated);

        return redirect()
            ->route('incomes.edit', $income)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Income $income): RedirectResponse
    {
        $this->authorize('delete', $income);

        $income->delete();

        return redirect()
            ->route('incomes.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
