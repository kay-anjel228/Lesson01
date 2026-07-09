<?php

require_once "functions.php";

$user = null;
$message = "";

if (!isAuth())
{
    $message = "Необходимо авторизоваться";
} elseif (isset($_GET["id"])) {
    $id = (int)($_GET["id"]);
    $user = findUserById($id);

    if ($user === null) {
        $message = "Пользователь не найден";
    }
} else {
    $message = "Логин пользователя не передан";
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Профиль пользователя</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Профиль пользователя</h1>

        <nav class="menu">
            <a href="index.php">Главная</a>
            <a href="addUser.php">Регистрация</a>
            <a href="login.php">Вход</a>                        
            <a href="showUsers.php">Пользователи</a>                                  
        </nav>

        <div class="card">
            <?php if ($user !== null): ?>
                <h2><?php echo htmlspecialchars($user["name"]); ?></h2>
                 
                <p><strong>Логин:</strong> <?php echo htmlspecialchars($user["login"]) ?></p>
                <p><strong>Имя:</strong> <?php echo htmlspecialchars($user["name"]) ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($user["email"]) ?></p>
                <p><strong>Возраст:</strong> <?php echo htmlspecialchars($user["age"]) ?></p>
                <p><strong>Город:</strong> <?php echo htmlspecialchars($user["city"]) ?></p>

            <?php else: ?>

                <p class="error"><?php $message ?></p>

            <?php endif; ?>
        </div>
        
    </div>
</body>
</html>