<?php

namespace KBInsurance\PHP\MVC\Middleware;

interface Middleware
{

    function before(): void;

}