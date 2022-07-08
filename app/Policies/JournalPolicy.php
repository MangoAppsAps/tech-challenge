<?php

namespace App\Policies;

use App\Journal;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class JournalPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Journal  $journal
     * @return mixed
     */
    public function view(User $user, Journal $journal)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Journal  $journal
     * @return mixed
     */
    public function update(User $user, Journal $journal)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Journal  $journal
     * @return mixed
     */
    public function delete(User $user, Journal $journal)
    {
        // Can delete, if the Journal was created by a Client that belongs to the Auth User
        return (bool)$user->clients()->where('id', $journal->client_id)->count();
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Journal  $journal
     * @return mixed
     */
    public function restore(User $user, Journal $journal)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Journal  $journal
     * @return mixed
     */
    public function forceDelete(User $user, Journal $journal)
    {
        //
    }
}
