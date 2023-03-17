<?php

namespace App\Repositories;

interface LeadRepositoryContract
{
    public function all();
    public function find(int $id);
    public function create(array $data);
    public function update(array $data);
    public function delete(int $id);
}