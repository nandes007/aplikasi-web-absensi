<?php

namespace KBInsurance\PHP\MVC\Service;

use Exception;
use KBInsurance\PHP\MVC\Domain\Present;
use KBInsurance\PHP\MVC\Exception\ValidationException;
use KBInsurance\PHP\MVC\Model\PresentCheckInRequest;
use KBInsurance\PHP\MVC\Model\PresentCheckInResponse;
use KBInsurance\PHP\MVC\Model\PresentCheckOutRequest;
use KBInsurance\PHP\MVC\Repository\EmployeeRepository;
use KBInsurance\PHP\MVC\Repository\PresentRepository;

class PresentService
{
    // private EmployeeRepository $employeeRepository;
    private PresentRepository $presentRepository;

    public function __construct(PresentRepository $presentRepository)
    {
        // $this->employeeRepository = $employeeRepository;
        $this->presentRepository = $presentRepository;
    }

    public function showPresent()
    {
        return $this->presentRepository->findAll();
    }

    public function checkin(PresentCheckInRequest $request): PresentCheckInResponse
    {
        $this->validationPresentCheckInRequest($request);
        date_default_timezone_set("Asia/Jakarta");

        try {
            $present = new Present();
            $present->employeeId = $request->employeeId;
            $present->date = $request->date;
            $present->checkin = $request->checkin;

            $this->presentRepository->save($present);

            $response = new PresentCheckInResponse();
            $response->present = $present;

            return $response;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    private function validationPresentCheckInRequest(PresentCheckInRequest $request): void
    {
        if ($this->presentRepository->findByPresent($request->employeeId, $request->date) != null) {
            throw new ValidationException("You are already checked in");
        }
    }

    public function checkout(PresentCheckOutRequest $request): PresentCheckInResponse
    {
        $this->validatePresentCheckOutRequest($request);
        date_default_timezone_set("Asia/Jakarta");

        try {
            $present = $this->presentRepository->findByPresent($request->employeeId, $request->date);
            if ($present->checkout != null) {
                throw new ValidationException("You are already checked out");
            }

            $present->checkout = $request->checkout;

            $this->presentRepository->update($present);

            $response = new PresentCheckInResponse();
            $response->present = $present;

            return $response;
        } catch (Exception $e) {
            throw new ValidationException($e->getMessage());
        }
    }

    private function validatePresentCheckOutRequest(PresentCheckOutRequest $request): void
    {
        if ($this->presentRepository->findByPresent($request->employeeId, $request->date) == null) {
            throw new ValidationException("You are not checked in");
        }
    }

    public function status(string $employeeId, string $date): ?Present
    {
        $present = $this->presentRepository->findByPresent($employeeId, $date);
        if ($present == null) {
            return null;
        } else {
            return $present;
        }
    }
}