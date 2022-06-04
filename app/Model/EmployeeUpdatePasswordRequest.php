<?php

namespace KBInsurance\PHP\MVC\Model;

class EmployeeUpdatePasswordRequest
{
    public ?string $nik = null;
    public ?string $oldPassword = null;
    public ?string $newPassword = null;
}