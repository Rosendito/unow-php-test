<?php

namespace App\Controllers\Kernel;

use App\Controllers\DoctorDatesController;
use App\Controllers\PatientDatesController;
use App\Controllers\UsersController;

class Kernel
{
    /**
     * Init kernel.
     */
    public function __construct()
    {
        $this->router = new Router(new Request);
    }

    /**
     * Register all routes.
     *
     * @return void
     */
    public function register(): void
    {
        $usersController = new UsersController();
        $patientDatesController = new PatientDatesController();
        $doctorDatesController = new DoctorDatesController();

        $this->router->get('/', fn() => 'Hello world!');

        $this->router->get('/api/users', fn(Request $request) =>
            $usersController->index($request)
        );

        $this->router->post('/api/users', fn(Request $request) =>
            $usersController->store($request)
        );

        $this->router->post('/api/patients/dates', fn(Request $request) =>
            $patientDatesController->store($request)
        );

        $this->router->get('/api/doctors/dates', fn(Request $request) =>
            $doctorDatesController->index($request)
        );

        $this->router->patch('/api/doctors/dates', fn(Request $request) =>
            $doctorDatesController->update($request)
        );
    }
}