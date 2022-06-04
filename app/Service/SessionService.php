<?php

namespace KBInsurance\PHP\MVC\Service;

use KBInsurance\PHP\MVC\Domain\Employee;
use KBInsurance\PHP\MVC\Domain\Session;
use KBInsurance\PHP\MVC\Repository\EmployeeRepository;
use KBInsurance\PHP\MVC\Repository\SessionRepository;

class SessionService
{
    public static $COOKIE_NAME = "X-PZN-SESSION";

    private SessionRepository $sessionRepository;
    private EmployeeRepository $employeeRepository;

    public function __construct(SessionRepository $sessionRepository, EmployeeRepository $employeeRepository)
    {
        $this->sessionRepository = $sessionRepository;
        $this->employeeRepository = $employeeRepository;
    }

    public function create(string $employeeId): Session
    {
        $session = new Session();
        $session->id = uniqid();
        $session->employeeId = $employeeId;

        $this->sessionRepository->save($session);

        setcookie(self::$COOKIE_NAME, $session->id, time() + (60 * 60 * 24 * 30), "/"); // waktu: detik, menit, jam, hari
        
        return $session;
    }

    public function destroy()
    {
        $sessionId = $_COOKIE[self::$COOKIE_NAME] ?? '';
        $this->sessionRepository->deleteById($sessionId);

        setcookie(self::$COOKIE_NAME, '', 1, "/"); // for reset cookie
    }

    public function current(): ?Employee
    {
        $sessionId = $_COOKIE[self::$COOKIE_NAME] ?? '';

        $session = $this->sessionRepository->findById($sessionId);
        if ($session == null) {
            return null;
        }

        return $this->employeeRepository->findByNik($session->employeeId);
    }
}