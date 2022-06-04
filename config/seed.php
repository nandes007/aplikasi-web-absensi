<?php

require_once __DIR__ . '/../vendor/autoload.php';

use KBInsurance\PHP\MVC\Config\Database;
use KBInsurance\PHP\MVC\Domain\Role;

class seed
{
    private \PDO $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function addRole(int $id, string $name): void
    {
        $statement = $this->connection->prepare("INSERT INTO roles(id, role_name) VALUES (?, ?)");
        $statement->execute([
            $id,
            $name
        ]);
        echo 'Seeder Success' . PHP_EOL;
    }

    public function addEmployee(string $nik = "10420047", string $name = "Administrator", string $password = "password", string $image="default.jpg", int $role = 1): void
    {
        $statement = $this->connection->prepare("INSERT INTO employees(nik, name, password, image, role_id) VALUES (?, ?, ?, ?, ?)");
        $statement->execute([
            $nik,
            $name,
            password_hash($password, PASSWORD_BCRYPT),
            $image,
            $role
        ]);
        echo 'Seeder Success' . PHP_EOL;
    }

}

$connection = Database::getConnection('prod');
$role = new Seed($connection);
$role->addRole(1, 'Administrator');
$role->addRole(2, 'Employee');

$seed = new Seed($connection);
$seed->addEmployee(nik:"10420047", name:"Administrator", password:"password", image:"default.jpg", role:1);
$seed->addEmployee(nik:"10420042", name:"Udin", password:"password", image:"default.jpg", role:2);