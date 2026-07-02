<?php
function readUsers() {
    $fileName = "users.txt";

    if (!file_exists($fileName)) {
        return [];
    }

    $lines = file($fileName, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    $users = [];

    foreach ($lines as $line) {
        $parts = explode(":", $line);
        if (count($parts) < 6) {
            continue;
        }

        $users[] = [
            "login" => $parts[0],
            "password" => $parts[1],
            "email" => $parts[2],
            "name" => $parts[3],
            "age" => $parts[4],
            "city" => $parts[5],
        ];
    }

    return $users;
}

function findUserByLogin(string $login) {
    $users = readUsers();

    foreach ($users as $user) {
        if ($user["login"] === $login) {
            return $user;
        }
    }

    return null;
    
}

function checkUser(string $login, string $password) 
{
    $user = findUserByLogin($login);

    if ($user === null) {
        return false;
    }

    return password_verify($password, $user["password"]);
}

function addUser(array $user)
{
    $fileName = "users.txt";

    $line =
        $user["login"] . ":" .
        $user["password"] . ":" .
        $user["email"] . ":" .
        $user["name"] . ":" .
        $user["age"] . ":" .
        $user["city"] .
        PHP_EOL;

    file_put_contents($fileName, $line, FILE_APPEND);
}
?>