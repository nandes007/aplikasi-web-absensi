<?php

namespace KBInsurance\PHP\MVC\Domain;

class Present
{
    public int $id;
    public string $employeeId;
    public string $date;
    public ?string $checkin = null;
    public ?string $checkout = null;
}