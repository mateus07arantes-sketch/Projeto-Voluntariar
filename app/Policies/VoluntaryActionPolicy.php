<?php

namespace App\Policies;

use App\Models\VoluntaryAction;
use App\Models\User;
use App\Enums\Role;

class VoluntaryActionPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, VoluntaryAction $action): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        // Apenas ONGs podem criar ações, Admin NÃO pode
        return $user->hasRole(Role::Ong);
    }

    public function update(User $user, VoluntaryAction $action): bool
    {
        // Admin E ONG dona podem editar
        return $action->user_id === $user->id;
    }

    public function delete(User $user, VoluntaryAction $action): bool
    {
        return $user->hasRole(Role::Admin) || $action->user_id === $user->id;
    }

    public function viewParticipants(User $user, VoluntaryAction $action): bool
    {
        // Admin e ONG dona podem ver participantes
        return $user->hasRole(Role::Admin) || $action->user_id === $user->id;
    }
}