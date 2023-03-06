<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'status', 
        'type'
    ];

    protected $appends = [
        'user_name'
    ];

    public function getUserNameAttribute()
    {
        return User::where('id', $this->user_id)->first()->name ?? "NA";
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
