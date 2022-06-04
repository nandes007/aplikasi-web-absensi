<?php

namespace KBInsurance\PHP\MVC\Repository;

use KBInsurance\PHP\MVC\Config\Database;
use KBInsurance\PHP\MVC\Domain\Employee;
use KBInsurance\PHP\MVC\Domain\Session;
use PHPUnit\Framework\TestCase;

class SessionRepositoryTest extends TestCase
{

    private SessionRepository $sessionRepository;
    private EmployeeRepository $employeeRepository;

    protected function setUp(): void
    {
        $this->employeeRepository = new EmployeeRepository(Database::getConnection());
        $this->sessionRepository = new SessionRepository(Database::getConnection());

        $this->sessionRepository->deleteAll();
        $this->employeeRepository->deleteAll();

        $employee = new Employee();
        $employee->nik = "10420047";
        $employee->name = "Nandes";
        $employee->image = "default.jpg";
        $employee->password = "nandes";
        $this->employeeRepository->save($employee);
    }

    public function testSaveSuccess()
    {
        $session = new Session();
        $session->id = uniqid();
        $session->employeeId = "10420047";

        $this->sessionRepository->save($session);

        $result = $this->sessionRepository->findById($session->id);
        self::assertEquals($session->id, $result->id);
        self::assertEquals($session->employeeId, $result->employeeId);
    }

    public function testDeleteByIdSuccess()
    {
        $session = new Session();
        $session->id = uniqid();
        $session->employeeId = "10420047";

        $this->sessionRepository->save($session);

        $result = $this->sessionRepository->findById($session->id);
        self::assertEquals($session->id, $result->id);
        self::assertEquals($session->employeeId, $result->employeeId);

        $this->sessionRepository->deleteById($session->id);

        $result = $this->sessionRepository->findById($session->id);
        self::assertNull($result);
    }

    public function testFindByIdNotFound()
    {
        $result = $this->sessionRepository->findById("not-found");
        self::assertNull($result);
    }

}