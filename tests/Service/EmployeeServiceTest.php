<?php

namespace KBInsurance\PHP\MVC\Service;

use KBInsurance\PHP\MVC\Config\Database;
use KBInsurance\PHP\MVC\Domain\Employee;
use KBInsurance\PHP\MVC\Exception\ValidationException;
use KBInsurance\PHP\MVC\Model\EmployeeLoginRequest;
use KBInsurance\PHP\MVC\Model\EmployeeRegisterRequest;
use KBInsurance\PHP\MVC\Model\EmployeeUpdatePasswordRequest;
use KBInsurance\PHP\MVC\Repository\EmployeeRepository;
use KBInsurance\PHP\MVC\Repository\SessionRepository;
use PHPUnit\Framework\TestCase;

class EmployeeServiceTest extends TestCase
{
    private EmployeeService $employeeService;
    private EmployeeRepository $employeeRepository;
    private SessionRepository $sessionRepository;

    protected function setUp(): void
    {
        $connection = Database::getConnection();
        $this->sessionRepository = new SessionRepository($connection);
        $this->employeeRepository = new EmployeeRepository($connection);
        $this->employeeService = new EmployeeService($this->employeeRepository);

        $this->sessionRepository->deleteAll();
        $this->employeeRepository->deleteAll();
    }

    public function testRegisterSuccess()
    {
        $request = new EmployeeRegisterRequest();
        $request->nik = '10420047';
        $request->name = 'Nandes';
        $request->image = 'default.jpg';
        $request->password = '123';

        $response = $this->employeeService->register($request);

        $this->assertEquals('10420047', $response->employee->nik);
        $this->assertEquals('Nandes', $response->employee->name);
        $this->assertEquals('default.jpg', $response->employee->image);
        $this->assertNotEquals('123', $response->employee->password);

        self::assertTrue(password_verify($request->password, $response->employee->password));
    }

    public function testRegisterFailed()
    {
        $this->expectException(ValidationException::class);

        $request = new EmployeeRegisterRequest();
        $request->nik = '';
        $request->name = '';
        $request->password = '';
        
        $this->employeeService->register($request);
    }

    public function testRegisterDuplicateNik()
    {
        $employee = new Employee();
        $employee->nik = '10420047';
        $employee->name = 'Nandes';
        $employee->password = '123';
        $employee->image = 'default.jpg';

        $this->employeeRepository->save($employee);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Employee with nik 10420047 already exists');

        $request = new EmployeeRegisterRequest();
        $request->nik = '10420047';
        $request->name = 'Nandes';
        $request->password = '123';

        $this->employeeService->register($request);

        $this->employeeService->register($request);
    }

    public function testLoginNotFound()
    {
        $this->expectException(ValidationException::class);

        $request = new EmployeeLoginRequest();
        $request->nik = "10420047";
        $request->password = "nandes";

        $this->employeeService->login($request);
    }

    public function testLoginWrongPassword()
    {
        $employee = new Employee();
        $employee->nik = "10420047";
        $employee->name = "Nandes";
        $employee->password = password_hash("nandes", PASSWORD_BCRYPT);

        $this->expectException(ValidationException::class);

        $request = new EmployeeLoginRequest();
        $request->nik = "10420047";
        $request->password = "nandex";

        $this->employeeService->login($request);
    }

    public function testLoginSuccess()
    {
        $user = new Employee();
        $user->nik = "10420047";
        $user->name = "Nandes";
        $user->password = password_hash("nandes", PASSWORD_BCRYPT);

        $this->expectException(ValidationException::class);

        $request = new EmployeeLoginRequest();
        $request->nik = "10420047";
        $request->password = "nandes";

        $response = $this->employeeService->login($request);

        self::assertEquals($request->nik, $response->employee->nik);
        self::assertTrue(password_verify($request->password, $response->employee->password));
    }

    public function testUpdatePasswordSuccess()
    {
        $employee = new Employee();
        $employee->nik = "10420047";
        $employee->name = "Nandes";
        $employee->image = "default.jpg";
        $employee->password = password_hash("nandes", PASSWORD_BCRYPT);
        $this->employeeRepository->save($employee);

        $request = new EmployeeUpdatePasswordRequest();
        $request->nik = "10420047";
        $request->oldPassword = "nandes";
        $request->newPassword = "nandex";

        $this->employeeService->updatePassword($request);

        $result = $this->employeeRepository->findByNik($employee->nik);
        self::assertTrue(password_verify($request->newPassword, $result->password));
    }

    public function testUpdatePasswordValidationError()
    {
        $this->expectException(ValidationException::class);

        $request = new EmployeeUpdatePasswordRequest();
        $request->nik = "10420047";
        $request->oldPassword = "";
        $request->newPassword = "";

        $this->employeeService->updatePassword($request);
    }

    public function testUpdatePasswordWrongOldPassword()
    {
        $this->expectException(ValidationException::class);
        $employee = new Employee();
        $employee->nik = "nandes";
        $employee->name = "Nandes";
        $employee->image = "default.jpg";
        $employee->password = password_hash("nandes", PASSWORD_BCRYPT);
        $this->employeeRepository->save($employee);

        $request = new EmployeeUpdatePasswordRequest();
        $request->nik = "nandes";
        $request->oldPassword = "salah";
        $request->newPassword = "new";

        $this->employeeService->updatePassword($request);
    }

    public function testUpdatePasswordNotFound()
    {
        $this->expectException(ValidationException::class);

        $request = new EmployeeUpdatePasswordRequest();
        $request->nik = "10420047";
        $request->oldPassword = "salah";
        $request->newPassword = "new";

        $this->employeeService->updatePassword($request);
    }
}