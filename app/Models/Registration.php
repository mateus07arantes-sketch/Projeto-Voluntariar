<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\VoluntaryAction;

class Registration extends Model
{
    protected $fillable = [
        'user_id',
        'voluntary_action_id',
        'participated',
        'status',
        'registered_at'
    ];

    protected $casts = [
        'participated' => 'boolean',
        'registered_at' => 'datetime',
    ];

    // relacionamento com usuário (voluntário)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // relacionamento com ação voluntária
    public function voluntaryAction()
    {
        return $this->belongsTo(VoluntaryAction::class);
    }
}
