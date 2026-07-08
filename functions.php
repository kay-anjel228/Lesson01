<?php

require_once 'db.php';

function readUsers() {
   $pdo = getDb();

   $sql = "SELECT * FROM users ORDER BY id DESC";

   $stmt = $pdo->query($sql);

   return $stmt->fetchAll();
}

function findUserByLogin(string $login) {
    $pdo = getDb();

    $sql = "SELECT * FROM users WHERE login = :login";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        "login" => $login
    ]);

    $user = $stmt->fetch();

    if ($user === false) {
        return null;
    }

    return $user;
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
    $pdo = getDb();

    $sql = "
        INSERT INTO users (login, password, email, name, age, city)
        VALUE (:login, :password, :email, :name, :age, :city)
    ";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        "login" => $user["login"],
        "password" => $user["password"],
        "email" => $user["email"],
        "name" => $user["name"],
        "age" => $user["age"],
        "city" => $user["city"]
    ]);
}

function isAuth()
{
    return isset($_SESSION["login"]);
}

function getCurrentUser()
{
    if(!isAuth()) {
        return null;
    }

    return findUserByLogin($_SESSION["login"]);
}
?>