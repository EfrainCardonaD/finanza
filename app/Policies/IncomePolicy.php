<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Income;
use Illuminate\Auth\Access\HandlesAuthorization;

class IncomePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the income can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list incomes');
    }

    /**
     * Determine whether the income can view the model.
     */
    public function view(User $user, Income $model): bool
    {
        return $user->hasPermissionTo('view incomes');
    }

    /**
     * Determine whether the income can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create incomes');
    }

    /**
     * Determine whether the income can update the model.
     */
    public function update(User $user, Income $model): bool
    {
        return $user->hasPermissionTo('update incomes');
    }

    /**
     * Determine whether the income can delete the model.
     */
    public function delete(User $user, Income $model): bool
    {
        return $user->hasPermissionTo('delete incomes');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete incomes');
    }

    /**
     * Determine whether the income can restore the model.
     */
    public function restore(User $user, Income $model): bool
    {
        return false;
    }

    /**
     * Determine whether the income can permanently delete the model.
     */
    public function forceDelete(User $user, Income $model): bool
    {
        return false;
    }
}
