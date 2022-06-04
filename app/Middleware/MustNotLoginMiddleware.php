<?php

namespace KBInsurance\PHP\MVC\Middleware;

use KBInsurance\PHP\MVC\App\View;
use KBInsurance\PHP\MVC\Config\Database;
use KBInsurance\PHP\MVC\Repository\EmployeeRepository;
use KBInsurance\PHP\MVC\Repository\SessionRepository;
use KBInsurance\PHP\MVC\Service\SessionService;

class MustNotLoginMiddleware implements Middleware
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
        $user = $this->sessionService->current();
        if ($user != null) {
            View::redirect("/employees/index");
        }
    }
}