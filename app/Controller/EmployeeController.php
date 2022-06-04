<?php

namespace KBInsurance\PHP\MVC\Controller;

use KBInsurance\PHP\MVC\App\View;
use KBInsurance\PHP\MVC\Config\Database;
use KBInsurance\PHP\MVC\Exception\ValidationException;
use KBInsurance\PHP\MVC\Model\EmployeeLoginRequest;
use KBInsurance\PHP\MVC\Repository\EmployeeRepository;
use KBInsurance\PHP\MVC\Repository\PresentRepository;
use KBInsurance\PHP\MVC\Repository\SessionRepository;
use KBInsurance\PHP\MVC\Service\EmployeeService;
use KBInsurance\PHP\MVC\Service\PresentService;
use KBInsurance\PHP\MVC\Service\SessionService;

class EmployeeController
{
    private EmployeeService $employService;
    private SessionService $sessionService;
    private PresentService $presentService;

    public function __construct()
    {
        $connection = Database::getConnection();
        $employeeRepository = new EmployeeRepository($connection);
        $this->employService = new EmployeeService($employeeRepository);

        $sessionRepository = new SessionRepository($connection);
        $this->sessionService = new SessionService($sessionRepository, $employeeRepository);

        $presentRepository = new PresentRepository($connection);
        $this->presentService = new PresentService($presentRepository);
    }

    public function index()
    {
        date_default_timezone_set("Asia/Jakarta");
        $date = date('Y-m-d');
        $employee = $this->sessionService->current();

        $present = $this->presentService->status($employee->nik, $date);

        if ($employee->role_id == 1) {
            View::redirect("/employees/admin");
        }

        View::render('Employee/index', [
            "title" => "Aplikasi Absensi",
            "employee" => [
                "id" => $employee->nik,
                "name" => $employee->name,
                "role_id" => $employee->role_id
            ],
            "attr" => [
                "date" => date('Y-m-d'),
                "time" => date("h:i:s"),
            ],
            "present" => $present
        ]);
    }

    public function login()
    {
        View::render('Employee/login', [
            "title" => "Login Employee"
        ]);
    }

    public function postLogin()
    {
        $request = new EmployeeLoginRequest();
        $request->nik = $_POST['nik'];
        $request->password = $_POST['password'];

        try {
            $response = $this->employService->login($request);
            $this->sessionService->create($response->employee->nik);
            $employee = $this->sessionService->current();

            if ($employee != null && $employee->role_id = 1) {
                View::redirect("/employees/admin");
            } else {
                View::redirect("/employees/index");
            }

            // View::redirect('/employees/index');
        } catch (ValidationException $e) {
            View::render('Employee/login', [
                "title" => "Login user",
                "error" => $e->getMessage()
            ]);
        }
    }

    public function logout()
    {
        $this->sessionService->destroy();
        View::redirect("/employees/login");
    }
}