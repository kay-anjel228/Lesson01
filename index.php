<?php

require_once "functions.php";

$users = readUsers();
$usersCount = count($users);

$lastUserText = "";

if (isset($_COOKIE["last_login"])) {
    $lastLogin = $_COOKIE["last_login"];
    $user = findUserByLogin($lastLogin);

    if ($user !== null) {
        $lastUserText = $user["name"];
    } else {
        $lastUserText = $lastLogin;
    }
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная страница</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Регистрация пользователей</h1>
    
    <nav class="menu">
        <a href="index.php">Главная</a>
        <a href="addUser.php">Регистрация</a>
        <a href="login.php">Вход</a>
        <a href="showUsers.php">Пользователи</a>
    </nav>

    <div class="card">
        <h2>Главная страница</h2>

        <h4>Это php приложение для регистрации пользователей.</h4>
        
        <p class='count'>Количество пользователей: <?php echo $usersCount; ?></p>
        
        <?php if ($lastUserText !== ""): ?>
            <p class="success">
                Последний вошедший пользователь:
                <?php echo htmlspecialchars($lastUserText); ?>
            </p>
        <?php endif; ?>

        <p>
            Используйте страницу регистрации, чтобы добавить нового пользователя.
            После этого перейдите на страницу входа и проверьте логин и пароль.
        </p>
    </div>
</div>
</body>
</html>