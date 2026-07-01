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
        
        <?php
        $fileName = "users.txt";
        $usersCount = 0;
        if (file_exists($fileName)) {
            $users = file($fileName, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $usersCount = count($users);
        }
        echo "<h4 class='count'>Количество пользователей: $usersCount</h4>";
        ?>
        
    </div>
</div>
</body>
</html>