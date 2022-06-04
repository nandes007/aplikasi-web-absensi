<?php

function getDatabaseConfig(): array
{
    return [
        "database" => [
            "test" => [
                "url" => "mysql:host=localhost:3306;dbname=attendance_management_test",
                "username" => "root",
                "password" => "mysql",
            ],
            "prod" => [
                "url" => "mysql:host=localhost:3306;dbname=attendance_management",
                "username" => "root",
                "password" => "mysql"
            ]
        ]
    ];
}