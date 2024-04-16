<?php

namespace App\Repositories;

use App\Interfaces\ProductInterfaces;
use App\Models\ProductModel;

class ProductRepository implements ProductInterfaces
{
    public function index()
    {
        // TODO: Implement index() method.
        return ProductModel::all();
    }

    public function getById(int $id)
    {
//         TODO: Implement getById() method.
        return ProductModel::query()->find($id);

    }

    public function store(array $data)
    {
        // TODO: Implement store() method.
        return ProductModel::query()->create($data);

    }

    public function update(array $data, int $id)
    {
        // TODO: Implement update() method.
        return ProductModel::query()->where($id)->update($data);

    }

    public function delete(int $id)
    {
        // TODO: Implement delete() method.
        return ProductModel::destroy($id);
    }
}
