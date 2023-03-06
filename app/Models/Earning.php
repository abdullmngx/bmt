<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Earning extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'deposit_id',
        'amount',
        'day_posted',
        'type'
    ];

    protected $appends = [
        'user_name'
    ];

    public function getUserNameAttribute()
    {
        return User::where('id', $this->user_id)->first()->name ?? "NA";
    }

    public function deposit()
    {
        return $this->belongsTo(Deposit::class);
    }
}
