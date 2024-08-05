<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserCoinWatchlist;
use Illuminate\Auth\Access\Response;

class UserCoinWatchListPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, UserCoinWatchlist $userCoinWatchlist): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, UserCoinWatchlist $userCoinWatchlist): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, UserCoinWatchlist $userCoinWatchlist): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, UserCoinWatchlist $userCoinWatchlist): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, UserCoinWatchlist $userCoinWatchlist): bool
    {
        //
    }
}
