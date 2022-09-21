<?php

namespace App\Interfaces;

interface AppointmentInterface
{
    public function create(array $data);

    public function update(int $id, array $data);

    public function delete(int $id);

    public function find(int $id);

    public function all();

    public function findByEmployeeId(int $id);

    public function findByCustomerId(int $id);

    public function calculateDistance(array $data);

    public function createRules(): array;

    public function updateRules(): array;
}
