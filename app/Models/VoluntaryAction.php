<?php

namespace App\Models;

use App\Enums\ActionStatus;
use Illuminate\Database\Eloquent\Model;

class VoluntaryAction extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'category',
        'description',
        'image',
        'location',
        'event_datetime',
        'vacancies',
        'status',
        'cancel_reason',
    ];

    protected $casts = [
        'status' => ActionStatus::class,
        'event_datetime' => 'datetime',
    ];

    protected $appends = ['computed_status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ong()
    {
        return $this->hasOneThrough(Ong::class, User::class, 'id', 'user_id', 'user_id', 'id');
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class, 'voluntary_action_id');
    }

    // Scopes
    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeActive($query)
    {
        return $query->where('status', ActionStatus::Active)
                    ->where('event_datetime', '>=', now());
    }

    public function scopeFromOng($query, $ongUserId)
    {
        return $query->where('user_id', $ongUserId);
    }

    public function scopeVisibleToUsers($query)
    {
        return $query->where(function($q) {
            $q->where('status', ActionStatus::Active)
              ->where('event_datetime', '>=', now());
        });
    }

 public function getComputedStatusAttribute()
{
    // Se estiver ativa mas já passou da data → considerar finalizada
    if ($this->status === ActionStatus::Active && $this->event_datetime < now()) {
        return ActionStatus::Finished; // ⬅️ Verifique se está retornando o enum correto
    }

    return $this->status;
}

    public function isVisibleToUser()
    {
        return $this->computed_status === ActionStatus::Active && 
               $this->event_datetime >= now();
    }
}