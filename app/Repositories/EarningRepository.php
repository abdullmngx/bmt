<?php 

namespace App\Repositories;

use App\Models\Earning;

class EarningRepository
{
    protected $earning;

    public function __construct(Earning $earning)
    {
        $this->earning = $earning;
    }

    public function create(array $details)
    {
        return $this->earning->create($details);
    }

    public function all()
    {
        return $this->earning->with('deposit')->get();
    }

    public function show($id)
    {
        return $this->earning->where('id', $id)->with('deposit')->first();
    }

    public function getByUserId($user_id)
    {
        return $this->earning->where('user_id', $user_id)->with('deposit')->orderBy('id','DESC')->paginate(5);
    }

    public function getTotalUserEarningByDeposit($user_id, $deposit_id)
    {
        return $this->earning->where(['user_id' => $user_id, 'deposit_id' => $deposit_id])->sum('amount');
    }

    public function update($id, array $details)
    {
        return $this->earning->where('id', $id)->update($details);
    }

    public function todayExists($user_id, $day, $deposit_id)
    {
        return $this->earning->where('user_id', $user_id)->where('day_posted', $day)->where('deposit_id', $deposit_id)->where('type', 'deposit')->exists();
    }

    public function delete($id)
    {
        return $this->earning->where('id', $id)->delete();
    }
}