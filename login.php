<?php

session_start();

require_once "functions.php";

$message = "";
$messageClass = "";

$login = "";
$password = "";

if(isAuth()) {
    $user = getCurrentUser();

    if($user !== null) {
        $message = "Вы уже авторизованы как " . $user["name"];
    } else {
        $message = "Вы уже авторизированы";
    }

    $messageClass = "success";
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $login = trim($_POST["login"]);
    $password = trim($_POST["password"]);

    if ($login === "" || $password === "") {
        $message = "Введите логин и пароль";
        $messageClass = "error";
    } elseif (checkUser($login, $password)) {
        $_SESSION["login"] = $login;

        setcookie("last_login", $login, time() + 86400);

        header("Location: cabinet.php");
        exit;
    } else {
        $message = "Логин или пароль неверны";
        $messageClass = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход пользователя</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Вход пользователя</h1>

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
            <h2>Форма входа</h2>

            <?php 
                if ($message !== "") {
                    echo "<p class='$messageClass'>$message</p>";
                }
            ?>

            <?php if (!isAuth()): ?>
                <form action="login.php" method="post">
                    <div class="form-group">
                        <label>Login</label>
                        <input type="text" name="login" value="<?php echo $login; ?>">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" value="<?php echo $password; ?>">
                    </div>
                    <button type="submit">Войти</button>
                </form>
            <?php else: ?>
                <p>
                    <a href="cabinet.php">Перейти в личный кабинет</a>
                </p>
            <?php endif; ?>
             
            <br>

            <form action="logout.php" method="post">
                <button type="submit" class="logout-button">Выход</button>
            </form>
        </div>
    </div>
</body>
</html>