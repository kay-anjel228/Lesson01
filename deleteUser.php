<?php

session_start();

require_once "functions.php";

if (!isAuth()) {
    header("Locations: login.php");
    exit;
}

$id = isset($_GET["id"]) ? (int)$_GET["id"] : 0;

if ($id > 0) {
    $user = findUserById($id);

    if ($user !== null) {
        deleteUser($id);

        if (isset($_SESSION["login"]) && $_SESSION["login"] === $user["login"]) {
            session_destroy();

            header("Location: login.php");
            exit;
        }
    }
}

header("Location: login.php");
exit;

?>