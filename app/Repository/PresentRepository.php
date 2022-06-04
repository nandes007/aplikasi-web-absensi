<?php

namespace KBInsurance\PHP\MVC\Repository;

use KBInsurance\PHP\MVC\Domain\Employee;
use KBInsurance\PHP\MVC\Domain\Present;
use PDO;

class PresentRepository
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function findAll()
    {
        $sql = "SELECT id, employee_nik, date, checkin, checkout FROM presents";
        $statement = $this->connection->prepare($sql);
        $statement->execute();

        $result = [];

        foreach ($statement as $row) {
            $present = new Present();
            $present->id = $row["id"];
            $present->employeeId = $row["employee_nik"];
            $present->date = $row["date"];
            $present->checkin = $row["checkin"];
            $present->checkout = $row["checkout"];

            $result[] = $present;
        }

        return $result;
    }

    public function save(Present $present): Present
    {
        $statement = $this->connection->prepare("INSERT INTO presents(employee_nik, date, checkin, checkout) VALUES (?, ?, ?, ?)");
        $statement->execute([
            $present->employeeId,
            $present->date,
            $present->checkin,
            $present->checkout,
        ]);

        $id = $this->connection->lastInsertId();
        $present->id = $id;

        return $present;
    }

    public function update(Present $present): Present
    {
        $statement = $this->connection->prepare("UPDATE presents SET checkout = ? WHERE employee_nik = ? AND date = ?");
        $statement->execute([
            $present->checkout,
            $present->employeeId,
            $present->date,
        ]);
        return $present;
    }

    public function findByPresent(string $eployeeId, string $date): ?Present
    {
        $statement = $this->connection->prepare("SELECT id, employee_nik, date, checkin, checkout FROM presents WHERE employee_nik = ? AND date = ?");
        $statement->execute([$eployeeId, $date]);

        try {
            if ($row = $statement->fetch()) {
                $present = new Present();
                $present->id = $row['id'];
                $present->employeeId = $row['employee_nik'];
                $present->date = $row['date'];
                $present->checkin = $row['checkin'];
                $present->checkout = $row['checkout'];
                return $present;
            } else {
                return null;
            }
        } finally {
            $statement->closeCursor();
        }
    }

    public function findById(int $id): ?Present
    {
        $statement = $this->connection->prepare("SELECT id, employee_nik, date, checkin, checkout FROM presents WHERE id = ?");
        $statement->execute([$id]);

        try {
            if ($row = $statement->fetch()) {
                $present = new Present();
                $present->id = $row['id'];
                $present->employeeId = $row['employee_nik'];
                $present->date = $row['date'];
                $present->checkin = $row['checkin'];
                $present->checkout = $row['checkout'];
                return $present;
            } else {
                return null;
            }
        } finally {
            $statement->closeCursor();
        }
    }

    public function deleteAll(): void
    {
        $statement = $this->connection->prepare("DELETE FROM presents");
        $statement->execute();
    }
}