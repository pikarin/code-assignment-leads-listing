<?php

namespace App\Repositories;

use App\Models\Lead;
use Illuminate\Support\Arr;

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
        return $this->model->query()
            ->with('address')
            ->where('id', $id)
            ->first();
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

    public function update(array $data): bool
    {
        return $this->model->update(Arr::only($data, [
            'first_name',
            'last_name',
            'email',
            'phone',
            'electrict_bill',
        ]));
    }

    public function delete(int $id): ?bool
    {
        $lead = $this->find($id);

        $lead->address->delete();

        return $lead->delete();
    }
}
