<?php

namespace App\Repositories;

use App\Models\Withdrawal;

class WithdrawalRepository
{
    protected $withdrawal;

    public function __construct(Withdrawal $withdrawal)
    {
        $this->withdrawal = $withdrawal;
    }

    public function create(array $details)
    {
        return $this->withdrawal->create($details);
    }

    public function all()
    {
        return $this->withdrawal->all();
    }

    public function getPending()
    {
        return $this->withdrawal->where('status', 'pending')->get();
    }

    public function show($id)
    {
        return $this->withdrawal->where('id', $id)->first();
    }

    public function getByUserId($user_id)
    {
        return $this->withdrawal->where('user_id', $user_id)->get();
    }

    public function update($id, array $details)
    {
        return $this->withdrawal->where('id', $id)->update($details);
    }

    public function delete($id)
    {
        return $this->withdrawal->where('id', $id)->delete();
    }

    public function getUserPending($user_id)
    {
        return $this->withdrawal->where(['user_id' => $user_id, 'status' => 'pending'])->exists();
    }
}