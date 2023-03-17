<?php

namespace App\Repositories;

use App\Models\Lead;

class EloquentLeadRepository implements LeadRepositoryContract
{
    public function __construct(protected Lead $model)
    {
        //
    }

    public function all()
    {
        //
    }

    public function find(int $id)
    {
        //
    }

    public function create(array $data)
    {
        $lead = $this->model->create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'electric_bill' => $data['electric_bill'],
        ]);

        $lead->address()->create([
            'street' => $data['street'],
            'city' => $data['city'],
            'state_abbreviation' => $data['state_abbreviation'],
            'zip_code' => $data['zip_code'],
        ]);

        return $lead->loadMissing('address');
    }

    public function update(array $data)
    {
        //
    }

    public function delete(int $id)
    {
        //
    }
}
