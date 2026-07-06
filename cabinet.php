<?php   

session_start();

require_once "functions.php";

$user = getCurrentUser();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Личный кабинет</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Личный кабинет</h1>

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

        <div class="card">
            <?php if ($user === null): ?>
                <p class="error">Доступ запрещён. Необходимо войти в систему</p>
                <p><a href="login.php">Перейти на страницу входа</a></p>
            <?php else: ?>
                <h2>Здравствуйте, <?php echo htmlspecialchars($user["name"]); ?>!</h2>

                <p><strong>Логин:</strong> <?php echo htmlspecialchars($user["login"]); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($user["email"]); ?></p>
                <p><strong>Возраст:</strong> <?php echo htmlspecialchars($user["age"]); ?></p>
                <p><strong>Город:</strong> <?php echo htmlspecialchars($user["city"]); ?></p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>