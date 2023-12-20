<?php

namespace App\Http\Controllers\Api;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExpenseResource;
use App\Http\Resources\ExpenseCollection;
use App\Http\Requests\ExpenseStoreRequest;
use App\Http\Requests\ExpenseUpdateRequest;

class ExpenseController extends Controller
{
    public function index(Request $request): ExpenseCollection
    {
        $this->authorize('view-any', Expense::class);
        $search = $request->get('search', '');

        $expenses = Expense::where('user_id', auth()->id()) // Filtra por el ID del usuario autenticado
        ->search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return new ExpenseCollection($expenses);
    }

    public function store(ExpenseStoreRequest $request): ExpenseResource
    {
        $this->authorize('create', Expense::class);

        $validated = $request->validated();

        $expense = Expense::create($validated);

        return new ExpenseResource($expense);
    }

    public function show(Request $request, Expense $expense): ExpenseResource
    {
        $this->authorize('view', $expense);

        return new ExpenseResource($expense);
    }

    public function update(
        ExpenseUpdateRequest $request,
        Expense $expense
    ): ExpenseResource {
        $this->authorize('update', $expense);

        $validated = $request->validated();

        $expense->update($validated);

        return new ExpenseResource($expense);
    }

    public function destroy(Request $request, Expense $expense): Response
    {
        $this->authorize('delete', $expense);

        $expense->delete();

        return response()->noContent();
    }
}
