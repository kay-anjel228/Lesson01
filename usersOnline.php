<?php 

session_start();

require_once "functions.php";

$user = getCurrentUser();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Пользователи онлайн:</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Пользователей онлайн:</h1>

        <nav class="menu">
        <a href="index.php">Главная</a>
        <?php if (isAuth()): ?>
            <a href="showUsers.php">Пользователи</a>
            <a href="cabinet.php">Личный кабинет</a>
            <a href="logout.php">Выход</a>
        <?php else: ?>    
            <a href="addUser.php">Регистрация</a>
            <a href="login.php">Вход</a>
            <a href="showUsers.php">Пользователи</a>
        <?php endif; ?>
        </nav>
    </div>
</body>
</html>