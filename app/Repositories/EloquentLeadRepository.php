<?php

namespace App\Repositories;

use App\Models\Lead;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;
use Symfony\Component\Routing\Exception\InvalidParameterException;

class EloquentLeadRepository implements LeadRepositoryContract
{
    public function __construct(protected Lead $model)
    {
        //
    }

    public function all(?string $quality = null)
    {
        $leads = $this->model->query()
            ->when($quality, $this->filterElectricBillQuality(...))
            ->get();

        return $leads;
    }

    /**
     * @throws ModelNotFoundException
     */
    public function find(int $id)
    {
        return $this->model->query()
            ->with('address')
            ->where('id', $id)
            ->firstOrFail();
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

    /**
     * @throws InvalidParameterException
     */
    protected function filterElectricBillQuality(Builder $query, string $quality)
    {
        $threshold = config('lead.electrict_bill_threshold');

        $operator = match ($quality) {
            'premium' => '>=',
            'standard' => '<=',
            default => throw new InvalidParameterException('unsupported electric bill quality filter'),
        };

        return $query->where('electric_bill', $operator, $threshold);
    }
}
