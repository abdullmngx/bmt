<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'account_name',
        'account_number',
        'bank_name',
        'bank_code',
        'bank_status',
        'password',
        'ref'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'total_balance',
        'deposit_earnings_balance',
        'referral_earnings_balance',
        'deposit_balance',
        'withdrawal_balance',
        'active_status', 
        'ref_name',
        'ref_count',
        'count_active_ref'
    ];

    public function getTotalBalanceAttribute()
    {
        return ($this->getAttribute('deposit_earnings_balance') + $this->getAttribute('referral_earnings_balance')) - $this->getAttribute('withdrawal_balance');
    }

    public function getDepositBalanceAttribute()
    {
        return Deposit::where('user_id', $this->id)->where('status', 'active')->sum('amount') ?? 0.00;
    }

    public function getDepositEarningsBalanceAttribute()
    {
        return Earning::where(['user_id' => $this->id, 'type' => 'deposit'])->sum('amount') ?? 0.00;
    }

    public function getReferralEarningsBalanceAttribute()
    {
        return Earning::where(['user_id' => $this->id, 'type' => 'referral'])->sum('amount') ?? 0.00;
    }

    public function getWithdrawalBalanceAttribute()
    {
        return Withdrawal::where(['user_id' => $this->id, 'status' => 'approved'])->sum('amount') ?? 0.00;
    }

    public function getActiveStatusAttribute()
    {
        return Deposit::where('user_id', $this->id)->where('status','active')->where('amount', '>', 0.00)->exists();
    }

    public function getRefNameAttribute()
    {
        return User::where('id', $this->ref)->first()->name ?? "";
    }
    
    public function getCountActiveRefAttribute()
    {
        $refs= User::where('ref', $this->id)->get();
        $active = [];
        foreach ($refs as $ref)
        {
            if ($ref->active_status)
            {
                $active[] = $ref;
            }
        }
        return count($active);
    }

    public function deposits()
    {
        return $this->hasMany(Deposit::class);
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function earnings()
    {
        return $this->hasMany(Earning::class);
    }
    
    public function getRefCountAttribute()
    {
        return User::where('ref', $this->id)->count() ?? 0;
    }
}
