<?php 

namespace App\Repositories;

use App\Models\User;

class UserRepository 
{
    protected $user;

    public function  __construct(User $user)
    {
        $this->user = $user;
    }

    public function create(array $details)
    {
        return $this->user->create($details);
    }

    public function all()
    {
        return $this->user->all();
    }

    public function show($idOrEmail)
    {
        return $this->user->where('id', $idOrEmail)->orWhere('email', $idOrEmail)->with(['deposits' => function ($query) {
            $query->where('status', 'active');
        }])->with('withdrawals')->first();
    }

    public function update($id, array $details)
    {
        return $this->user->where('id', $id)->update($details);
    }

    public function delete($id)
    {
        return $this->user->where('id', $id)->delete();
    }

    public function getRefs($user_id)
    {
        return $this->user->where('ref', $user_id)->paginate(5);
    }

    public function count()
    {
        return $this->user->count();
    }
}