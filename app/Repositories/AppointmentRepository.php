<?php

namespace App\Repositories;

use App\Interfaces\AppointmentInterface;
use App\Models\Appointment;

class AppointmentRepository implements AppointmentInterface
{

    public function create(array $data)
    {
        return Appointment::create($data);
    }

    public function update(int $id, array $data)
    {
        $appointment = Appointment::find($id);
        $appointment->update($data);
        return $appointment;
    }

    public function delete(int $id)
    {
        $appointment = Appointment::find($id);
        return $appointment->delete();
    }

    public function find(int $id)
    {
        return Appointment::findOrFail($id);
    }

    public function all()
    {
        return Appointment::all();
    }

    public function findByEmployeeId(int $id)
    {
        return Appointment::where('employee_id', $id)->get();
    }

    public function findByCustomerId(int $id)
    {
        return Appointment::where('customer_id', $id)->get();
    }

    /**
     * @param array $data
     * @return float|int
     */
    public function calculateDistance(array $data, int $earthRadius = 6371000): float|int
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
        return $angle * $earthRadius;
    }

    public function createRules(): array
    {
        return [
            'customer_id' => 'required|integer',
            'employee_id' => 'required|integer',
            'begin_address_id' => 'required|integer',
            'end_address_id' => 'required|integer',
            'start' => 'required|datetime',
            'end' => 'required|datetime',
            'estimate_duration' => 'required|integer',
        ];
    }

    public function updateRules(): array
    {
        return [
            'customer_id' => 'integer',
            'employee_id' => 'integer',
            'begin_address_id' => 'integer',
            'end_address_id' => 'integer',
            'start' => 'datetime',
            'end' => 'datetime',
            'estimate_duration' => 'integer',
        ];
    }

}
