<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Ong;

class OngPolicy
{
    // Apenas admin pode ver a lista de pendentes
    public function viewAny(User $user)
    {
        return $user->role === 'admin';
    }

    // Apenas admin pode aprovar
    public function approve(User $user, Ong $ong)
    {
        return $user->role === 'admin';
    }

    // Apenas admin pode rejeitar
    public function reject(User $user, Ong $ong)
    {
        return $user->role === 'admin';
    }

    // ONG pode atualizar seus próprios dados
    public function update(User $user, Ong $ong)
    {
        return $user->id === $ong->user_id;
    }

    // ONG pode deletar seu cadastro (opcional)
    public function delete(User $user, Ong $ong)
    {
        return $user->id === $ong->user_id;
    }

    public function viewPending(User $user)
    {
        // Permite apenas admins
        return $user->role === 'admin';
    }

}
