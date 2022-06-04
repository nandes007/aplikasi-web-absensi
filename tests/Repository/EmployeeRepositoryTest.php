<?php

namespace KBInsurance\PHP\MVC\Repository;

use KBInsurance\PHP\MVC\Config\Database;
use KBInsurance\PHP\MVC\Domain\Employee;
use PHPUnit\Framework\TestCase;

class EmployeeRepositoryTest extends TestCase
{

    private EmployeeRepository $employeeRepository;
    private SessionRepository $sessionRepository;

    protected function setUp(): void
    {
        $this->sessionRepository = new SessionRepository(Database::getConnection());
        $this->employeeRepository = new EmployeeRepository(Database::getConnection());
        $this->sessionRepository->deleteAll();
        $this->employeeRepository->deleteAll();
    }

    public function testSaveSuccess()
    {
        $employee = new Employee();
        $employee->nik = '123456789';
        $employee->name = 'John Doe';
        $employee->password = '123456';
        $employee->image = 'default.jpg';

        $this->employeeRepository->save($employee);

        $result = $this->employeeRepository->findByNik($employee->nik);

        self::assertEquals($employee->nik, $result->nik);
        self::assertEquals($employee->name, $result->name);
        self::assertEquals($employee->password, $result->password);
        self::assertEquals($employee->image, $result->image);
    }

    public function testFindByNikNotFound()
    {
        $employee = $this->employeeRepository->findByNik('notfound');
        self::assertNull($employee);
    }

    public function testUpdate()
    {
        $employee = new Employee();
        $employee->nik = '10430037';
        $employee->name = 'Nandes';
        $employee->password = 'nandes';
        $employee->image = 'default.jpg';
        $this->employeeRepository->save($employee);

        $employee->name = "putra";
        $this->employeeRepository->update($employee);

        $result = $this->employeeRepository->findByNik($employee->nik);

        self::assertEquals($employee->nik, $result->nik);
        self::assertEquals($employee->name, $result->name);
        self::assertEquals($employee->password, $result->password);
        self::assertEquals($employee->image, $result->image);
    }

}