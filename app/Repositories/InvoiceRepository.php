<?php 

namespace App\Repositories;

use App\Models\Invoice;

class InvoiceRepository
{
    protected $invoice;

    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    public function create(array $details)
    {
        return $this->invoice->create($details);
    }

    public function all()
    {
        return $this->invoice->all();
    }

    public function show($id)
    {
        return $this->invoice->where('id', $id)->with(['plan', 'user'])->first();
    }

    public function getByUserId($user_id)
    {
        return $this->invoice->where('user_id', $user_id)->paginate(5);
    }

    public function update($id, array $details)
    {
        return $this->invoice->where('id', $id)->update($details);
    }

    public function delete($id)
    {
        return $this->invoice->where('id', $id)->delete();
    }
    
    public function getByRef($ref)
    {
        return $this->invoice->where('reference', $ref)->first();
    }
    
    public function updateByRef($ref, array $details)
    {
        return $this->invoice->where('reference', $ref)->update($details);
    }
}