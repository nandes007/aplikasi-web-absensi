<?php

namespace KBInsurance\PHP\MVC\Controller;

use KBInsurance\PHP\MVC\App\View;
use KBInsurance\PHP\MVC\Config\Database;
use KBInsurance\PHP\MVC\Exception\ValidationException;
use KBInsurance\PHP\MVC\Model\EmployeeRegisterRequest;
use KBInsurance\PHP\MVC\Repository\EmployeeRepository;
use KBInsurance\PHP\MVC\Repository\PresentRepository;
use KBInsurance\PHP\MVC\Repository\SessionRepository;
use KBInsurance\PHP\MVC\Service\EmployeeService;
use KBInsurance\PHP\MVC\Service\PresentService;
use KBInsurance\PHP\MVC\Service\SessionService;

class AdminController
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
        $employee = $this->sessionService->current();
        $present = $this->presentService->showPresent();
        View::render('Admin/index', [
            "title" => "Aplikasi Absensi",
            "employee" => [
                "id" => $employee->nik,
                "name" => $employee->name
            ],
            "presents" => $present
        ]);
    }

    public function register()
    {
        $employee = $this->sessionService->current();
        View::render('Admin/register', [
            "title" => "Register new Employee",
            "employee" => [
                "id" => $employee->nik,
                "name" => $employee->name
            ],
        ]);
    }
    
    public function postRegister()
    {
        $request = new EmployeeRegisterRequest();
        $request->nik = $_POST['nik'];
        $request->name = $_POST['name'];
        $request->password = $_POST['password'];

        try {
            $this->employService->register($request);
            View::redirect('/employees/admin');
        } catch (ValidationException $e) {
            View::render('Admin/register', [
                "title" => "Register new Employee",
                "error" => $e->getMessage()
            ]);
        }
    }
}