<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'username',
        'email',
        'phone',
        'name',
        'internal_id',
        'blocked_at',
        'registration_ip',
        'created_at',
        'updated_at'
    ];

    public function account()
    {
        return $this->hasMany(Account::class);
    }
}
