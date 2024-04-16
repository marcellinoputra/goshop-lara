<?php

namespace App\Repositories;

use App\Interfaces\LocationInterfaces;
use App\Models\LocationModel;

class LocationRepository implements LocationInterfaces
{
    public function index()
    {
        // TODO: Implement index() method.
        return LocationModel::all();
    }

    public function getById(int $id)
    {
        // TODO: Implement getById() method.
        return LocationModel::query()->findOrFail($id);
    }

    public function store(array $data)
    {
        // TODO: Implement store() method.
        return LocationModel::query()->create($data);
    }

    public function update(array $data, int $id)
    {
        // TODO: Implement update() method.
        return LocationModel::query()->where($id)->update($data);
    }

    public function delete(int $id)
    {
        // TODO: Implement delete() method.
        return LocationModel::destroy($id);
    }
}
