<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\IncomeResource;
use App\Http\Resources\IncomeCollection;

class UserIncomesController extends Controller
{
    public function index(Request $request, User $user): IncomeCollection
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $incomes = $user
            ->incomes()
            ->search($search)
            ->latest()
            ->paginate();

        return new IncomeCollection($incomes);
    }

    public function store(Request $request, User $user): IncomeResource
    {
        $this->authorize('create', Income::class);

        $validated = $request->validate([
            'amount' => ['required', 'numeric'],
        ]);

        $income = $user->incomes()->create($validated);

        return new IncomeResource($income);
    }
}
