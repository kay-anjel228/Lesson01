<?php
    function getDb() 
    {
        $host = "MySQL-8.4";
        $dbName = "php_auth_db";
        $port = 3306;
        $user = "root";
        $password = "";

        $dsn = "mysql:host=$host;port=$port;dbname=$dbName;charset=utf8mb4";

        return new PDO($dsn, $user, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }
?>