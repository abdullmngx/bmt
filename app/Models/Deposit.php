<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plan_id',
        'amount',
        'expiry',
        'reference',
        'status'
    ];

    protected $appends = [
        'user_name',
        'plan_name'
    ];

    public function getUserNameAttribute()
    {
        return User::where('id', $this->user_id)->first()->name ?? "NA";
    }

    public function getPlanNameAttribute()
    {
        return Plan::where('id', $this->plan_id)->first()->name ?? "NA";
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
