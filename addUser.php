<?php

session_start();

require_once "functions.php";

$message = "";
$messageClass = "";

$login = "";
$password = "";
$email = "";
$name = "";
$age = "";
$city = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $login = trim($_POST["login"]);
    $password = trim($_POST["password"]);
    $email = trim($_POST["email"]);
    $name = trim($_POST["name"]);
    $age = trim($_POST["age"]);
    $city = trim($_POST["city"]);

    if ($login === "") {
        $message = "Логин не должен быть пустым";
        $messageClass = "error";
    } elseif (strlen($password) < 4) {
        $message = "Пароль должен быть не меньше 4 символов";
        $messageClass = "error";
    } elseif (strpos($email, "@") === false) {
        $message = "Email должен содержать символ @";
        $messageClass = "error";
    } elseif (!is_numeric($age)) {
        $message = "Возраст должен быть числом";
        $messageClass = "error";
    } elseif (findUserById($login) !== null) {
        $message = "Пользователь с таким логином уже существует";
        $messageClass = "error";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $user = [
            "login" => $login,
            "password" => $hashedPassword,
            "email" => $email,
            "name" => $name,
            "age" => $age,
            "city" => $city
        ];

        updateUser($user);

        $message = "Пользователь успешно добавлен";
        $messageClass = "success";

        $login = "";
        $password = "";
        $email = "";
        $name = "";
        $age = "";
        $city = "";
    }

}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавить пользователя</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <h1>Добавить пользователя</h1>

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

        <h2>Форма регистрации</h2>

        <?php
        if ($message !== "") {
            echo "<p class='$messageClass'>$message</p>";
        }
        ?>

        <form method="post" action="addUser.php">

            <div class="form-group">
                <label>Login:</label>
                <input type="text" name="login" value="<?php echo $login; ?>">
            </div>

            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" value="<?php echo $password; ?>">
            </div>

            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" value="<?php echo $email; ?>">
            </div>

            <div class="form-group">
                <label>Name:</label>
                <input type="text" name="name" value="<?php echo $name; ?>">
            </div>

            <div class="form-group">
                <label>Age:</label>
                <input type="text" name="age" value="<?php echo $age; ?>">
            </div>

            <div class="form-group">
                <label>City:</label>
                <input type="text" name="city" value="<?php echo $city; ?>">
            </div>

            <button type="submit">Добавить пользователя</button>

        </form>

    </div>

</div>

</body>
</html>