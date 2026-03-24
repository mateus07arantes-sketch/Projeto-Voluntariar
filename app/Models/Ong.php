<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ong extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'cnpj',
        'email',
        'phone',
        'address',
        'cebas_certificate',
        'description',
        'status', // novo campo
    ];

    // Relação 1:1 inversa com User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
