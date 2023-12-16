<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Expense;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExpensePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the expense can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list expenses');
    }

    /**
     * Determine whether the expense can view the model.
     */
    public function view(User $user, Expense $model): bool
    {
        return $user->hasPermissionTo('view expenses');
    }

    /**
     * Determine whether the expense can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create expenses');
    }

    /**
     * Determine whether the expense can update the model.
     */
    public function update(User $user, Expense $model): bool
    {
        return $user->hasPermissionTo('update expenses');
    }

    /**
     * Determine whether the expense can delete the model.
     */
    public function delete(User $user, Expense $model): bool
    {
        return $user->hasPermissionTo('delete expenses');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete expenses');
    }

    /**
     * Determine whether the expense can restore the model.
     */
    public function restore(User $user, Expense $model): bool
    {
        return false;
    }

    /**
     * Determine whether the expense can permanently delete the model.
     */
    public function forceDelete(User $user, Expense $model): bool
    {
        return false;
    }
}
