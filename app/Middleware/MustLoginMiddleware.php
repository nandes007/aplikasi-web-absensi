<?php

namespace KBInsurance\PHP\MVC\Middleware;

use KBInsurance\PHP\MVC\App\View;
use KBInsurance\PHP\MVC\Config\Database;
use KBInsurance\PHP\MVC\Repository\EmployeeRepository;
use KBInsurance\PHP\MVC\Repository\SessionRepository;
use KBInsurance\PHP\MVC\Service\SessionService;

class MustLoginMiddleware implements Middleware
{

    private SessionService $sessionService;

    public function __construct()
    {
        $sessionRepository = new SessionRepository(Database::getConnection());
        $employeeRepository = new EmployeeRepository(Database::getConnection());
        $this->sessionService = new SessionService($sessionRepository, $employeeRepository);
    }

    public function before(): void
    {
        $employee = $this->sessionService->current();
        if ($employee == null) {
            View::redirect("/employees/login");
        }
    }
}