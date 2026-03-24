<?php

namespace App\Policies;

use App\Models\Registration;
use App\Models\User;
use App\Enums\Role;

class RegistrationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
         return auth()->check();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Registration $registration): bool
    {
        return $user->hasRole(Role::Admin) || $registration->user_id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole(Role::Admin, Role::User);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Registration $registration): bool
    {
        return $user->hasRole(Role::Admin) || $registration->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Registration $registration): bool
    {
         return $user->hasRole(Role::Admin) || 
               $registration->user_id === $user->id ||
               $registration->voluntaryAction->user_id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Registration $registration): bool
    {
        return $this->update($user, $registration);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Registration $registration): bool
    {
        return $user->hasRole(Role::Admin);
    }

    /**
     * Determine whether the user can cancel the registration.
     */
    public function cancel(User $user, Registration $registration): bool
    {
        return $registration->user_id === $user->id ||
               $registration->voluntaryAction->user_id === $user->id ||
               $user->hasRole(Role::Admin);
    }

    /**
     * Determine whether the user can mark participation.
     */
 public function markParticipation(User $user, Registration $registration): bool
{
    $action = $registration->voluntaryAction;

    // Só permite marcar participação se o evento já aconteceu (data passada)
    if (now()->lt($action->event_datetime)) {
        return false; // Bloqueia se ainda não chegou a data do evento
    }

    return $user->hasRole(Role::Admin) || $action->user_id === $user->id;
}
}