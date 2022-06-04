<?php

use KBInsurance\PHP\MVC\App\Router;
use KBInsurance\PHP\MVC\Config\Database;
use KBInsurance\PHP\MVC\Controller\AdminController;
use KBInsurance\PHP\MVC\Controller\EmployeeController;
use KBInsurance\PHP\MVC\Controller\PresentController;
use KBInsurance\PHP\MVC\Middleware\MustAdministrator;
use KBInsurance\PHP\MVC\Middleware\MustLoginMiddleware;
use KBInsurance\PHP\MVC\Middleware\MustNotLoginMiddleware;

require_once __DIR__ . '/../vendor/autoload.php';

Database::getConnection('prod');

Router::add('GET', '/', EmployeeController::class, 'login', [MustNotLoginMiddleware::class]);

// Employee Controller
Router::add('GET', '/employees/login', EmployeeController::class, 'login', [MustNotLoginMiddleware::class]);
Router::add('POST', '/employees/login', EmployeeController::class, 'postLogin', [MustNotLoginMiddleware::class]);
Router::add('GET', '/employees/index', EmployeeController::class, 'index', [MustLoginMiddleware::class]);
Router::add('GET', '/employees/logout', EmployeeController::class, 'logout', [MustLoginMiddleware::class]);

// Present Controller
Router::add('POST', '/presents/checkin', PresentController::class, 'doCheckin', [MustLoginMiddleware::class]);
Router::add('POST', '/presents/checkout', PresentController::class, 'doCheckout', [MustLoginMiddleware::class]);

// Admin Controller
Router::add('GET', '/employees/admin', AdminController::class, 'index', [MustLoginMiddleware::class, MustAdministrator::class]);
Router::add('GET', '/employees/admin/register', AdminController::class, 'register', [MustLoginMiddleware::class, MustAdministrator::class]);
Router::add('POST', '/employees/admin/register', AdminController::class, 'postRegister', [MustLoginMiddleware::class, MustAdministrator::class]);

Router::run();