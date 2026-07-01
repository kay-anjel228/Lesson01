<?php
function checkUser($login, $password) 
{
    $fileName = "users.txt";


    if (!file_exists($fileName)) {
        return false;
    }

    $users = file($fileName, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($users as $user) {
        $parts = explode(":", $user);

        if (count($parts) < 6) {
            continue;
        }

        $storedLogin = $parts[0];
        $storedPasswordHash = $parts[1];

        if ($storedLogin === $login && password_verify($password, $storedPasswordHash)) {
            return true;
        }
    }

    return false;
}

$message = "";
$messageClass = "";

$login = "";
$password = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $login = trim($_POST["login"]);
    $password = trim($_POST["password"]);

    if ($login === "" || $password === "") {
        $message = "Введите логин и пароль";
        $messageClass = "error";
    } elseif (checkUser($login, $password)) {
        $message = "Добро пожаловать, $login";
        $messageClass = "success";
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
            <a href="addUser.php">Регистрация</a>
            <a href="login.php">Вход</a>
            <a href="showUsers.php">Пользователи</a>
        </nav>

        <div class="card">
            <h2>Форма входа</h2>

            <?php 
                if ($message !== "") {
                    echo "<p class='$messageClass'>$message</p>";
                }
            ?>

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
        </div>
    </div>
</body>
</html>