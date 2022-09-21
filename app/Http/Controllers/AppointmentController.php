<?php

namespace App\Http\Controllers;

use App\Repositories\AppointmentRepository;
use Illuminate\Support\Facades\Request;

class AppointmentController extends Controller
{
    private AppointmentRepository $appointmentRepository;

    public function __construct(AppointmentRepository $appointmentRepository)
    {
        $this->appointmentRepository = $appointmentRepository;
    }

    public function create(Request $request)
    {
        return $this->response($this->appointmentRepository->create($request->all()));
    }

    public function update(Request $request, int $id)
    {
        return $this->response($this->appointmentRepository->update($request->all(), $id));
    }

    public function delete(int $id)
    {
        return $this->response($this->appointmentRepository->delete($id));
    }

    public function show(int $id)
    {
        return $this->response($this->appointmentRepository->find($id));
    }
}
