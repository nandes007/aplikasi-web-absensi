<?php

namespace KBInsurance\PHP\MVC\Service;

require_once __DIR__ . '/../Helper/helper.php';

use KBInsurance\PHP\MVC\Config\Database;
use KBInsurance\PHP\MVC\Domain\Employee;
use KBInsurance\PHP\MVC\Domain\Session;
use KBInsurance\PHP\MVC\Repository\EmployeeRepository;
use KBInsurance\PHP\MVC\Repository\SessionRepository;
use PHPUnit\Framework\TestCase;

class SessionServiceTest extends TestCase
{
    private SessionService $sessionService;
    private SessionRepository $sessionRepository;
    private EmployeeRepository $employeeRepository;

    protected function setUp(): void
    {
        $this->sessionRepository = new SessionRepository(Database::getConnection());
        $this->employeeRepository = new EmployeeRepository(Database::getConnection());
        $this->sessionService = new SessionService($this->sessionRepository, $this->employeeRepository);

        $this->sessionRepository->deleteAll();
        $this->employeeRepository->deleteAll();

        $employee = new Employee();
        $employee->nik = "10420047";
        $employee->name = "Nandes";
        $employee->image = "default.png";
        $employee->password = "nandes";
        $this->employeeRepository->save($employee);
    }

    public function testCreate()
    {
        $session = $this->sessionService->create("10420047");

        $this->expectOutputRegex("[X-PZN-SESSION: $session->id]");

        $result = $this->sessionRepository->findById($session->id);

        self::assertEquals("10420047", $result->employeeId);
    }

    public function testDestroy()
    {
        $session = new Session();
        $session->id = uniqid();
        $session->employeeId = "10420047";

        $this->sessionRepository->save($session);

        $_COOKIE[SessionService::$COOKIE_NAME] = $session->id;

        $this->sessionService->destroy();

        $this->expectOutputRegex("[X-PZN-SESSION: ]");

        $result = $this->sessionRepository->findById($session->id);
        self::assertNull($result);
    }

    public function testCurrent()
    {
        $session = new Session();
        $session->id = uniqid();
        $session->employeeId = "10420047";

        $this->sessionRepository->save($session);

        $_COOKIE[SessionService::$COOKIE_NAME] = $session->id;

        $employee = $this->sessionService->current();

        self::assertEquals($session->employeeId, $employee->nik);
    }
}