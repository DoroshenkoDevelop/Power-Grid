<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
        'account_name',
        'account_number',
        'user_id'
    ];
    use HasFactory;

    public function user()
    {
        return $this->hasMany(User::class);
    }


    public function client()
    {
        return $this->hasMany(Client::class);
    }

}
