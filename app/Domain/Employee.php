<?php

namespace KBInsurance\PHP\MVC\Domain;

class Employee
{
    public string $nik;
    public string $name;
    public ?string $image = null;
    public int $role_id = 2;
}