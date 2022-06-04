<?php

namespace KBInsurance\PHP\MVC\Controller;

use KBInsurance\PHP\MVC\App\View;
use KBInsurance\PHP\MVC\Config\Database;
use KBInsurance\PHP\MVC\Exception\ValidationException;
use KBInsurance\PHP\MVC\Model\PresentCheckInRequest;
use KBInsurance\PHP\MVC\Model\PresentCheckOutRequest;
use KBInsurance\PHP\MVC\Repository\PresentRepository;
use KBInsurance\PHP\MVC\Service\PresentService;

class PresentController
{
    private PresentService $presentService;

    public function __construct()
    {
        $connection = Database::getConnection();

        $presentRepository = new PresentRepository($connection);
        $this->presentService = new PresentService($presentRepository);
    }

    public function doCheckin()
    {
        $request = new PresentCheckInRequest();
        $request->employeeId = $_POST['nik'];
        $request->date = $_POST['date'];
        $request->checkin = $_POST['checkin'];

        try {
            $this->presentService->checkin($request);
            View::redirect('/employees/index');
        } catch (ValidationException $e) {
            View::render('Employee/index', [
                "title" => "Aplikasi Absensi",
                "error" => $e->getMessage()
            ]);
        }
    }

    public function doCheckout()
    {
        $request = new PresentCheckOutRequest();
        $request->employeeId = $_POST['nik'];
        $request->date = $_POST['date'];
        $request->checkout = $_POST['checkout'];

        try {
            $this->presentService->checkout($request);
            View::redirect('/employees/index');
        } catch (ValidationException $e) {
            View::render('Employee/index', [
                "title" => "Aplikasi Absensi",
                "error" => $e->getMessage()
            ]);
        }
    }
}