<?php

namespace App\Http\Controllers\Api;

use App\Models\Income;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\IncomeResource;
use App\Http\Resources\IncomeCollection;
use App\Http\Requests\IncomeStoreRequest;
use App\Http\Requests\IncomeUpdateRequest;

class IncomeController extends Controller
{
    public function index(Request $request): IncomeCollection
    {
        $this->authorize('view-any', Income::class);

        $search = $request->get('search', '');

        $incomes = Income::search($search)
            ->latest()
            ->paginate();

        return new IncomeCollection($incomes);
    }

    public function store(IncomeStoreRequest $request): IncomeResource
    {
        $this->authorize('create', Income::class);

        $validated = $request->validated();

        $income = Income::create($validated);

        return new IncomeResource($income);
    }

    public function show(Request $request, Income $income): IncomeResource
    {
        $this->authorize('view', $income);

        return new IncomeResource($income);
    }

    public function update(
        IncomeUpdateRequest $request,
        Income $income
    ): IncomeResource {
        $this->authorize('update', $income);

        $validated = $request->validated();

        $income->update($validated);

        return new IncomeResource($income);
    }

    public function destroy(Request $request, Income $income): Response
    {
        $this->authorize('delete', $income);

        $income->delete();

        return response()->noContent();
    }
}
