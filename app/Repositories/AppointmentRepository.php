<?php

namespace App\Repositories;

use App\Interfaces\AppointmentInterface;
use App\Models\Appointment;

class AppointmentRepository implements AppointmentInterface
{

    public function create(array $data)
    {
        $validatedData = validator($data, $this->createRules());
        if ($validatedData->fails()) {
            return $validatedData->errors();
        }

        $data['estimated_distance'] = $this->calculateDistance($data);
        return Appointment::create($data);
    }

    public function update(int $id, array $data)
    {
        // TODO: Implement update() method.
    }

    public function delete(int $id)
    {
        // TODO: Implement delete() method.
    }

    public function find(int $id)
    {
        // TODO: Implement find() method.
    }

    public function all()
    {
        // TODO: Implement all() method.
    }

    public function findByEmployeeId(int $id)
    {
        // TODO: Implement findByEmployeeId() method.
    }

    public function findByCustomerId(int $id)
    {
        // TODO: Implement findByCustomerId() method.
    }

    /**
     * @param array $data
     * @return float|int
     */
    public function calculateDistance(array $data): float|int
    {

        // convert from degrees to radians
        $latFrom = deg2rad($data['latFrom']);
        $lonFrom = deg2rad($data['lonFrom']);
        $latTo = deg2rad($data['latTo']);
        $lonTo = deg2rad($data['lonTo']);

        $lonDelta = $lonTo - $lonFrom;
        $a = pow(cos($latTo) * sin($lonDelta), 2) +
            pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
        $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

        $angle = atan2(sqrt($a), $b);
        return $angle * $data['earthRadius'];
    }

    public function createRules(): array
    {
        return [
            'customer_id' => 'required|integer',
            'employee_id' => 'required|integer',
            'address_id' => 'required|integer',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'duration' => 'required|integer',
            'price' => 'required|numeric',
            'status' => 'required|integer',
        ];
    }

    public function updateRules(): array
    {
        return [
            'customer_id' => 'integer',
            'employee_id' => 'integer',
            'address_id' => 'integer',
            'date' => 'date',
            'time' => 'date_format:H:i',
            'duration' => 'integer',
            'price' => 'numeric',
            'status' => 'integer',
        ];
    }

}
