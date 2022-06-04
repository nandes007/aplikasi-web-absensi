<?php

namespace KBInsurance\PHP\MVC\Repository;

use KBInsurance\PHP\MVC\Config\Database;
use KBInsurance\PHP\MVC\Domain\Employee;
use KBInsurance\PHP\MVC\Domain\Present;
use PHPUnit\Framework\TestCase;

class PresentRepositoryTest extends TestCase
{
    private EmployeeRepository $employeeRepository;
    private PresentRepository $presentRepository;

    protected function setUp(): void
    {
        $this->employeeRepository = new EmployeeRepository(Database::getConnection());
        $this->presentRepository = new PresentRepository(Database::getConnection());

        $this->employeeRepository->deleteAll();
        $this->presentRepository->deleteAll();

        $employee = new Employee();
        $employee->nik = "10420047";
        $employee->name = "Nandes";
        $employee->image = "default.jpg";
        $employee->password = "nandes";
        $this->employeeRepository->save($employee);

        $employee2 = new Employee();
        $employee2->nik = "10420048";
        $employee2->name = "Budi";
        $employee2->image = "default.jpg";
        $employee2->password = "budi";
        $this->employeeRepository->save($employee2);
    }

    public function testSaveSuccess()
    {
        $present = new Present();
        $present->employeeId = "10420047";
        $present->date = "2020-01-01";
        $present->checkin = "08:00:00";
        $present->checkout = "17:00:00";

        $this->presentRepository->save($present);
        var_dump($present->id);
        $result = $this->presentRepository->findById($present->id);
        self::assertEquals($present->id, $result->id);
        self::assertEquals($present->employeeId, $result->employeeId);
        self::assertEquals($present->date, $result->date);
        self::assertEquals($present->checkin, $result->checkin);
        self::assertEquals($present->checkout, $result->checkout);
    }

    public function testFindByPresent()
    {
        $present1 = new Present();
        $present1->employeeId = "10420047";
        $present1->date = "2020-01-01";
        $present1->checkin = "08:00:00";

        $present2 = new Present();
        $present2->employeeId = "10420048";
        $present2->date = "2020-01-02";
        $present2->checkin = "08:00:00";

        $this->presentRepository->save($present1);
        $this->presentRepository->save($present2);

        $result = $this->presentRepository->findByPresent($present1->employeeId, $present1->date);
        self::assertEquals($present1->id, $result->id);
        self::assertEquals($present1->employeeId, $result->employeeId);
        self::assertEquals($present1->date, $result->date);
        self::assertEquals($present1->checkin, $result->checkin);
        self::assertEquals($present1->checkout, $result->checkout);
    }

    public function testUpdate()
    {
        $present = new Present();
        $present->employeeId = "10420047";
        $present->date = "2020-01-01";
        $present->checkin = "08:00:00";

        $present2 = new Present();
        $present2->employeeId = "10420048";
        $present2->date = "2020-01-02";
        $present2->checkin = "08:00:00";

        $this->presentRepository->save($present);
        $this->presentRepository->save($present2);

        $present->checkout = "18:00:00";
        $this->presentRepository->update($present);

        $result = $this->presentRepository->findById($present->id);
        self::assertEquals($present->id, $result->id);
        self::assertEquals($present->employeeId, $result->employeeId);
        self::assertEquals($present->date, $result->date);
        self::assertEquals($present->checkin, $result->checkin);
        self::assertEquals($present->checkout, $result->checkout);
    }
}