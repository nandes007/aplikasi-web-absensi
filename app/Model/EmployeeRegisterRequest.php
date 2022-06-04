<?php

namespace KBInsurance\PHP\MVC\Model;

class EmployeeRegisterRequest
{
    public ?string $nik = null;
    public ?string $name = null;
    public ?string $image = null;
    public ?string $password = null;
    public int $role_id = 2;
}