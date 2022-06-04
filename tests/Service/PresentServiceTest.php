<?php

namespace KBInsurance\PHP\MVC\Service;

use Exception;
use KBInsurance\PHP\MVC\Config\Database;
use KBInsurance\PHP\MVC\Domain\Employee;
use KBInsurance\PHP\MVC\Domain\Present;
use KBInsurance\PHP\MVC\Exception\ValidationException;
use KBInsurance\PHP\MVC\Model\PresentCheckInRequest;
use KBInsurance\PHP\MVC\Model\PresentCheckOutRequest;
use KBInsurance\PHP\MVC\Repository\EmployeeRepository;
use KBInsurance\PHP\MVC\Repository\PresentRepository;
use PHPUnit\Framework\TestCase;

class PresentServiceTest extends TestCase
{
    private PresentService $presentService;
    private PresentRepository $presentRepository;
    private EmployeeRepository $employeeRepository;

    protected function setUp(): void
    {
        $this->employeeRepository = new EmployeeRepository(Database::getConnection());
        $this->presentRepository = new PresentRepository(Database::getConnection());
        $this->presentService = new PresentService($this->presentRepository);

        $this->employeeRepository->deleteAll();
        $this->presentRepository->deleteAll();

        $employee = new Employee();
        $employee->nik = "10420047";
        $employee->name = "Nandes";
        $employee->image = "default.png";
        $employee->password = "nandes";
        $this->employeeRepository->save($employee);
    }

    public function testCheckin()
    {
        date_default_timezone_set("Asia/Jakarta");

        $request = new PresentCheckInRequest();
        $request->employeeId = '10420047';
        $request->date = date('Y-m-d');
        $request->checkin = date("h:i:s");

        $result = $this->presentService->checkin($request);

        $this->assertEquals("10420047", $result->present->employeeId);
        $this->assertEquals($request->date, $result->present->date);
        $this->assertEquals($request->checkin, $result->present->checkin);
    }

    public function testCheckinFailed()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('You are already checked in');

        date_default_timezone_set("Asia/Jakarta");

        $request = new PresentCheckInRequest();
        $request->employeeId = '10420047';
        $request->date = date('Y-m-d');
        $request->checkin = date("h:i:s");

        $this->presentService->checkin($request);

        $this->presentService->checkin($request);
    }

    public function testCheckout()
    {
        date_default_timezone_set("Asia/Jakarta");

        $time = strtotime("+2 Hours");
        $duajam = date("H:i:s", $time);

        $present = new Present();
        $present->employeeId = '10420047';
        $present->date = date('Y-m-d');
        $present->checkin = date("h:i:s");
        $this->presentRepository->save($present);

        $request = new PresentCheckOutRequest();
        $request->employeeId = $present->employeeId;
        $request->date = $present->date;
        $request->checkin = $present->checkin;
        $request->checkout = $duajam;

        $result = $this->presentService->checkout($request);

        $this->assertEquals("10420047", $result->present->employeeId);
        $this->assertEquals($request->date, $result->present->date);
        $this->assertEquals($request->checkin, $result->present->checkin);
        $this->assertEquals($request->checkout, $result->present->checkout);
    }

    public function testCheckoutFailed()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('You are not checked in');

        date_default_timezone_set("Asia/Jakarta");

        $request = new PresentCheckOutRequest();
        $request->employeeId = '10420047';
        $request->date = date('Y-m-d');
        $request->checkin = date("h:i:s");

        $this->presentService->checkout($request);
    }

    public function testCheckoutAgain()
    {
        date_default_timezone_set("Asia/Jakarta");

        $time = strtotime("+2 Hours");
        $duajam = date("H:i:s", $time);

        $present = new Present();
        $present->employeeId = '10420047';
        $present->date = date('Y-m-d');
        $present->checkin = date("h:i:s");
        $this->presentRepository->save($present);

        // $this->expectException(Exception::class);
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('You are already checked out');

        $request = new PresentCheckOutRequest();
        $request->employeeId = $present->employeeId;
        $request->date = $present->date;
        $request->checkin = $present->checkin;
        $request->checkout = $duajam;

        $this->presentService->checkout($request);
        $this->presentService->checkout($request);
    }
}