<?php

namespace App\Controllers;

use App\Models\Date;
use App\Models\User;
use App\Controllers\Kernel\Request;

class DoctorDatesController extends Controller
{
    /**
     * List all dates assigned to doctor.
     *
     * @param Request $request
     * @return string
     */
    public function index(Request $request): string
    {
        $doctorId = $request->getQuery()['doctor_id'];
        $doctor = (new User)->find($doctorId);
        
        if (!$doctor->validateRole(User::ROLE_DOCTOR)) {
            return $this->response('El usuario no tiene el rol de doctor', 403);
        }

        $dates = (new Date)->all(
            where: 'doctor_id = :doctor_id',
            whereValues: ['doctor_id' => $doctor->id]
        );

        return $this->response($dates, 200);
    }

    /**
     * Reject o approved date.
     *
     * @param Request $request
     * @return string
     */
    public function update(Request $request): string
    {
        $body = $request->getBody();
        $doctor = (new User)->find($body['doctor_id']);
        $date = (new Date)->find($body['date_id']);
        
        if (!$doctor->validateRole(User::ROLE_DOCTOR)) {
            return $this->response('El usuario no tiene el rol de doctor', 403);
        }

        $data = $date->toArray();

        $data['status'] = (int) $body['approved']
            ? Date::STATUS_APPROVED
            : Date::STATUS_REJECTED;


        $date->update($data);

        return $this->response($date->toArray(), 200);
    }
}