<?php

class Database {
    private static ?PDO $pdo = null;

    public static function getDB(): PDO {
        if (self::$pdo === null) {
            $dsn = 'mysql:host=localhost;dbname=tech_support;charset=utf8mb4';
            $username = 'root';
            $password = '';
            try {
                self::$pdo = new PDO($dsn, $username, $password);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Database connection failed: " . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}