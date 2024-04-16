<?php

namespace App\Interfaces;

interface LocationInterfaces
{
    public function index();
    public function store(array $data);
    public function getById(int $id);
    public function update(array $data, int $id);
    public function delete(int $id);
}
