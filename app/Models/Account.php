<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
        'name',
        'account_number',
        'user_id'
    ];
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hasOneUsers()
    {
        return $this->hasOne(User::class);
    }
}
