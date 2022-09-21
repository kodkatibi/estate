<?php

namespace App\Http\Controllers;

use App\Repositories\AppointmentRepository;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

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
        $this->appointmentRepository->delete($id);
        return $this->response(null,Response::HTTP_NO_CONTENT);
    }

    public function show(int $id)
    {
        return $this->response($this->appointmentRepository->find($id));
    }
}
