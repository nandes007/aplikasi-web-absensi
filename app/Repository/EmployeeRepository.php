<?php

namespace KBInsurance\PHP\MVC\Repository;

use KBInsurance\PHP\MVC\Domain\Employee;
use PDO;

class EmployeeRepository
{
    private PDO $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function findAll()
    {
        $sql = "SELECT nik, name FROM employees";
        $statement = $this->connection->prepare($sql);
        $statement->execute();

        $result = [];

        foreach ($statement as $row) {
            $employee = new Employee();
            $employee->id = $row["id"];
            $employee->name = $row["name"];

            $result[] = $employee;
        }

        return $result;
    }

    public function save(Employee $employee): Employee
    {
        $statement = $this->connection->prepare("INSERT INTO employees(nik, name, password, image, role_id) VALUES (?, ?, ?, ?, ?)");
        $statement->execute([
            $employee->nik,
            $employee->name,
            $employee->password,
            $employee->image,
            $employee->role_id
        ]);
        return $employee;
    }

    public function update(Employee $employee): Employee
    {
        $statement = $this->connection->prepare("UPDATE employees SET name = ?, password = ? WHERE nik = ?");
        $statement->execute([
            $employee->name,
            $employee->password,
            $employee->nik,
        ]);
        return $employee;
    }

    public function findByNik(string $nik): ?Employee
    {
        $statement = $this->connection->prepare("SELECT nik, name, image, password, role_id FROM employees WHERE nik = ?");
        $statement->execute([$nik]);
        
        try {
            if ($row = $statement->fetch()) {
                $employee = new  Employee();
                $employee->nik = $row['nik'];
                $employee->name = $row['name'];
                $employee->image = $row['image'];
                $employee->password = $row['password'];
                $employee->role_id = $row['role_id'];
                return $employee;
            } else {
                return null;
            }
        } finally {
            $statement->closeCursor();
        }
        
    }

    public function deleteAll(): void
    {
        $statement = $this->connection->prepare("DELETE FROM employees");
        $statement->execute();
    }
}