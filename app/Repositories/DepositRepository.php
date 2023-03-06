<?php 

namespace App\Repositories;

use App\Models\Deposit;

class DepositRepository
{
    protected $deposit;

    public function __construct(Deposit $deposit)
    {
        $this->deposit = $deposit;
    }

    public function create(array $details)
    {
        return $this->deposit->create($details);
    }

    public function all()
    {
        return $this->deposit->with('plan')->get();
    }

    public function show($id)
    {
        return $this->deposit->where('id', $id)->with('plan')->first();
    }

    public function getByUserId($user_id)
    {
        return $this->deposit->where('user_id', $user_id)->with('plan')->get();
    }

    public function update($id, array $details)
    {
        return $this->deposit->where('id', $id)->update($details);
    }

    public function delete($id)
    {
        return $this->deposit->where('id', $id)->delete();
    }

    public function count()
    {
        return $this->deposit->count();
    }

    public function countActive()
    {
        return $this->deposit->where('status', 'active')->count();
    }

    public function countExpired()
    {
        return $this->deposit->where('status', 'expired')->count();
    }

    public function checkRef($ref)
    {
        return $this->deposit->where('reference', $ref)->exists();
    }

    public function getUserPaid($user_id)
    {
        return $this->deposit->where('user_id',$user_id)->where('amount', '>', 0)->exists();
    }

    public function updateExpiring()
    {
        $this->deposit->whereDate('expiry', '<=', now())->update(['status' => 'expired']);
    }

    public function getActive()
    {
        return $this->deposit->where('status', 'active')->get();
    }
}