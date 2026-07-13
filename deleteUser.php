<?php

session_start();

require_once "functions.php";

if (!isAuth()) {
    header("Locations: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: showUsers.php");
    exit;
}

$id = isset($_POST["id"]) ? (int)$_POST["id"] : 0;

if ($id <= 0) {
    header("Location: showUsers.php");
}

$user = findUserById($id);

if ($user === null) {
    header("Location: showUsers.php");
    exit;
}

$isCurrentUser = (
    isset($_SESSION["login"])
    && $_SESSION["login"] === $user["login"]
);

deleteUser($id);

if ($isCurrentUser) {
    unset($_SESSION["login"]);
    session_destroy();

    header("Location: login.php");
    exit;
}

header("Location: showUsers.php");
exit;
?>