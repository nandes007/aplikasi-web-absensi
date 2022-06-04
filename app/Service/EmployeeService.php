<?php

namespace KBInsurance\PHP\MVC\Service;

use Exception;
use KBInsurance\PHP\MVC\Config\Database;
use KBInsurance\PHP\MVC\Domain\Employee;
use KBInsurance\PHP\MVC\Exception\ValidationException;
use KBInsurance\PHP\MVC\Model\EmployeeLoginRequest;
use KBInsurance\PHP\MVC\Model\EmployeeLoginResponse;
use KBInsurance\PHP\MVC\Model\EmployeeRegisterRequest;
use KBInsurance\PHP\MVC\Model\EmployeeRegisterResponse;
use KBInsurance\PHP\MVC\Model\EmployeeUpdatePasswordRequest;
use KBInsurance\PHP\MVC\Model\EmployeeUpdatePasswordResponse;
use KBInsurance\PHP\MVC\Repository\EmployeeRepository;

class EmployeeService
{
    private EmployeeRepository $employeeRepository;

    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    public function register(EmployeeRegisterRequest $request): EmployeeRegisterResponse
    {
        $this->validateEmployeeRegistrationRequest($request);

        try {
            Database::beginTransaction();
            $employee = $this->employeeRepository->findByNik($request->nik);
            if ($employee != null) {
                throw new ValidationException('Employee with nik ' . $request->nik . ' already exists');
            }

            $employee = new Employee();
            $employee->nik = $request->nik;
            $employee->name = $request->name;
            $employee->image = $request->image;
            $employee->password = password_hash($request->password, PASSWORD_BCRYPT);

            $this->employeeRepository->save($employee);

            $response = new EmployeeRegisterResponse();
            $response->employee = $employee;

            Database::commitTransaction();
            return $response;
        } catch (Exception $exception) {
            Database::rollbackTransaction();
            throw new ValidationException($exception->getMessage());
        }
    }

    private function validateEmployeeRegistrationRequest(EmployeeRegisterRequest $request): void
    {
        if ($request->nik == null || $request->name == null || $request->password == null || trim($request->nik) == '' || trim($request->name) == '' || trim($request->password) == '') {
            throw new ValidationException('Nik, name, and password are required.');
        }
    }

    public function login(EmployeeLoginRequest $request): EmployeeLoginResponse
    {
        $this->validationEmployeeLoginRequest($request);

        $employee = $this->employeeRepository->findByNik($request->nik);
        if ($employee == null) {
            throw new ValidationException("Nik or password is wrong");
        }

        if (password_verify($request->password, $employee->password)) {
            $response = new EmployeeLoginResponse();
            $response->employee = $employee;
            return $response;
        } else {
            throw new ValidationException("Nik or password is wrong");
        }
    }

    private function validationEmployeeLoginRequest(EmployeeLoginRequest $request): void
    {
        if ($request->nik == null || $request->password == null || trim($request->nik) == '' || trim($request->password) == '') {
            throw new ValidationException('Nik and password are required');
        }
    }

    public function updatePassword(EmployeeUpdatePasswordRequest $request): EmployeeUpdatePasswordResponse
    {
        $this->validateEmployeePasswordUpdateRequest($request);

        try {
            Database::beginTransaction();

            $employee = $this->employeeRepository->findByNik($request->nik);
            if ($employee == null) {
                throw new ValidationException('Employee with Nik ' . $request->nik . ' not found');
            }

            if (!password_verify($request->oldPassword, $employee->password)) {
                throw new ValidationException('Old password is wrong');
            }

            $employee->password = password_hash($request->newPassword, PASSWORD_BCRYPT);
            $this->employeeRepository->update($employee);

            Database::commitTransaction();

            $response = new EmployeeUpdatePasswordResponse();
            $response->employee = $employee;
            return $response;
        } catch(Exception $e) {
            Database::rollbackTransaction();
            throw $e;
        }
    }

    private function validateEmployeePasswordUpdateRequest(EmployeeUpdatePasswordRequest $request)
    {
        if ($request->nik == null || $request->oldPassword == null || $request->newPassword == null || trim($request->nik) == '' || trim($request->oldPassword) == '' || trim($request->newPassword) == '') {
            throw new ValidationException('Nik, Old Passowrd, and New Password are required');
        }
    }
}