<?php

namespace App\Controllers;

use App\Models\User;
use App\Controllers\Kernel\Request;
use App\Models\Date;

class PatientDatesController extends Controller
{
    /**
     * Create new date.
     *
     * @param Request $request
     * @return string
     */
    public function store(Request $request): string
    {
        $body = $request->getBody();
        $patient = (new User)->find($body['patient_id']);
        $doctor = (new User)->find($body['doctor_id']);

        if (!$patient->validateRole(User::ROLE_PATIENT)) {
            return $this->response('El usuario no tiene el rol de paciente', 403);
        }

        if (!$doctor->validateRole(User::ROLE_DOCTOR)) {
            return $this->response('El usuario no tiene el rol de doctor', 403);
        }

        $body['status'] = Date::STATUS_PENDING;

        $date = (new Date)->create($body);

        return $this->response($date->toArray(), 201);
    }
}