<?php

require_once 'db.php';

function readUsers() {
   return readUsersWithRoles();
}

function readUsersWithRoles() 
{
    $pdo = getDb();

    $sql = "
        SELECT
            users.id,
            users.login,
            users.password,
            users.email,
            users.name,
            users.age,
            users.city,
            users.role_id,
            roles.name AS role_name
        FROM users
        JOIN roles ON users.role_id = roles.id
        ORDER BY users.id DESC
    ";

    $stmt = $pdo->query($sql);

    return $stmt->fetchAll();
}
 
function findUserById(int $id) {
    return findUserByIdWithRole($id);
}

function findUserByIdWithRole(int $id) 
{
        $pdo = getDb();

    $sql = "
        SELECT
            users.id,
            users.login,
            users.password,
            users.email,
            users.name,
            users.age,
            users.city,
            users.role_id,
            roles.name AS role_name
        FROM users
        JOIN roles ON users.role_id = roles.id
        WHERE users.id = :id
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        "id" => $id
    ]);
    $user = $stmt->fetch();

    return $user === false ? null : $user;
}

function findUserByLogin(string $login) 
{
    return findUserByLoginWithRole($login);
}

function findUserByLoginWithRole(string $login) 
{
        $pdo = getDb();

    $sql = "
        SELECT
            users.id,
            users.login,
            users.password,
            users.email,
            users.name,
            users.age,
            users.city,
            users.role_id,
            roles.name AS role_name
        FROM users
        JOIN roles ON users.role_id = roles.id
        WHERE users.login = :login
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        "login" => $login
    ]);
    $user = $stmt->fetch();

    return $user === false ? null : $user;
}

function readRoles()
{
    $pdo = getDb();

    $sql = "
        SELECT id, name
        FROM roles
        ORDER BY id
    ";

    $stmt = $pdo->query($sql);

    return $stmt->fetchAll();
}

function checkUser(string $login, string $password) 
{
    $user = findUserByIdWithRole($login);

    if ($user === null) {
        return false;
    }

    return password_verify($password, $user["password"]);
}

function addUser(array $user) 
{
    $pdo = getDb();

    $sql = "
        INSERT INTO users (login, password, email, name, age, city, role_id)
        VALUES (:login, :password, :email, :name, :age, :city, :role_id)
    ";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        "login" => $user["login"],
        "password" => $user["password"],
        "email" => $user["email"],
        "name" => $user["name"],
        "age" => $user["age"],
        "city" => $user["city"],
        "role_id" => 2
    ]);
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

function updateUserWithRole(array $user)
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
            role_id = :role_id
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
        "role_id" => $user["role_id"]
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

function isAdmin()
{
    $user = getCurrentUser();

    return (
        $user !== null
        && $user["role_name"] === "admin"
    );
}

function getCurrentUser()
{
    if(!isAuth()) {
        return null;
    }

    return findUserByIdWithRole($_SESSION["id"]);
}

function searchUserByCity(string $city) 
{
    $pdo = getDb();

    $sql = "
        SELECT 
            users.id,
            users.login,
            users.password,
            users.email,
            users.name,
            users.age,
            users.city,
            users.role_id,
            roles.name AS role_name
        FROM users
        JOIN roles ON users.role_id = roles.id
        WHERE city LIKE :city
        ORDER BY id DESC
    ";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        "city" => "%" . $city , "%"
    ]);

    return $stmt->fetchAll();
}

function updateUserPassword(int $id, string $passwordHash)
{
    $pdo = getDb();

    $sql = "
        UPDATE users
        SET password = :password
        WHERE id = :id
    ";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        "password" => $passwordHash,
        "id" => $id
    ]);
}
?>