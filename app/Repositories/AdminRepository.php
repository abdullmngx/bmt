<?php 

namespace App\Repositories;

use App\Models\Admin;

class AdminRepository
{
    protected $admin;

    public function __construct(Admin $admin)
    {
        $this->admin = $admin;    
    }

    public function store(array $details)
    {
        return $this->admin->create($details);
    }

    public function all()
    {
        return $this->admin->all();
    }

    public function single($idOrEmail)
    {
        return $this->admin->where('id', $idOrEmail)->orWhere('email', $idOrEmail);
    }

    public function update($id, array $details)
    {
        return $this->admin->where('id', $id)->update($details);
    }

    public function delete($id)
    {
        return $this->admin->where('id', $id)->delete();
    }
}