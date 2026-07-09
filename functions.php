<?php

require_once 'db.php';

function readUsers() {
   $pdo = getDb();

   $sql = "SELECT * FROM users ORDER BY id DESC";

   $stmt = $pdo->query($sql);

   return $stmt->fetchAll();
}

function findUserById(int $id) {
    $pdo = getDb();

    $sql = "SELECT * FROM users WHERE id = :id";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        "id" => $id
    ]);

    $user = $stmt->fetch();

    if ($user === false) {
        return null;
    }

    return $user;
}

function checkUser(string $login, string $password) 
{
    $user = findUserById($login);

    if ($user === null) {
        return false;
    }

    return password_verify($password, $user["password"]);
}

function updateUser(array $user)
{
    $pdo = getDb();

    $sql = "
        UPDATE users
        SET
            login = :login,
            email = :email,
            name = :name,
            age = :age,
            city = :city,
            login = :login,
        WHERE id = :id
    ";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        "id" => $user["id"],
        "login" => $user["login"],
        "email" => $user["email"],
        "name" => $user["name"],
        "age" => $user["age"],
        "city" => $user["city"]
    ]);
}

function deleteUser(int $id)
{
    $pdo = getDb();

    $sql = "DELETE FROM users WHERE id = :id";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        "id" => $id
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

    return findUserById($_SESSION["id"]);
}
?>