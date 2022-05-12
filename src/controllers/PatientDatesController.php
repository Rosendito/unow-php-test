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
        $user = (new User)->find($body['patient_id']);

        if (!$this->validateRole($user)) {
            return $this->response('El usuario no tiene el rol de paciente', 403);
        }

        $body['status'] = Date::STATUS_PENDING;

        $date = (new Date)->create($body);

        return $this->response($date->toArray(), 201);
    }

    /**
     * Validate if the user has patient role
     *
     * @param User $user
     * @return boolean
     */
    protected function validateRole(User $user): bool
    {
        return $user->role === User::ROLE_PATIENT;
    }
}