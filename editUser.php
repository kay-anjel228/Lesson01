<?php

session_start();

require_once "functions.php";

$message = "";
$messageClass = "";

if (!isAuth()) {
    $message = "Необходимо авторизоваться";
    $messageClass = "error";
    $user = null;
} else {
    $id = isset($_GET["id"]) ? (int)$_GET["id"] : 0;

    $user = findUserById($id);

    if ($user === null) {
        $message = "Пользователь не найден";
        $messageClass = "error";
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isAuth())
{
    $id = (int)$_POST["id"];

    $login = trim($_POST["login"]);
    $email = trim($_POST["email"]);
    $name = trim($_POST["name"]);
    $age = trim($_POST["age"]);
    $city = trim($_POST["city"]);

    $user = findUserById($id);

    if ($user === null) {
        $message = "Пользователь не найден";
        $messageClass = "error";
    } elseif ($login === "") {
        $message = "Пользователь не должен быть пустым";
        $messageClass = "error";
    } elseif (!is_numeric($age)) {
        $message = "Возраст должен быть числом";
        $messageClass = "error";
    } else {
        $existingUser = findUserById($login);

        if ($existingUser !== null && (int)$existingUser["id"] !== $id) {
            $message = "Пользователь с таким логином уже существует";
            $messageClass = "error";
        } else {
            $updateUser = [
                "id" => $id,
                "login" => $login,
                "email" => $email,
                "name" => $name,
                "age" => $age,
                "city" => $city
            ];

            updateUser($updateUser);

            $message = "Данные пользователя успешно обновлены";
            $messageClass = "success";

            $user = findUserById($id);

            if (isset($_SESSION["login"]) && $_SESSION["login"] !== $user["login"]) {
                $currentUser = getCurrentUser();

                if ($currentUser !== null && (int)$currentUser["id"] === $id) {
                    $_SESSION["login"] = $user["login"]; 
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Редактирование пользователя</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
    <h1>Редактирование пользователя</h1>
        <div class="menu">
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
        </div>

        <div class="card">
            <h2>Форма редактирования</h2>

            <?php if ($message !== ""): ?>
                <p class="<?php echo $messageClass; ?>">
                    <?php echo htmlspecialchars($message) ?>
                </p>
            <?php endif; ?>

            <?php if ($user !== null): ?>
                <form method="post" action="editUser.php?id=<?php echo urldecode($user["id"]); ?>">

                <input type="hidden" name="id" value="<?php echo htmlspecialchars($user["id"]); ?>">

                <div class="form-group">
                    <label>Id:</label>
                    <input type="text" name="id" value="<?php echo htmlspecialchars($user["id"]); ?>">
                </div>

                <div class="form-group">
                    <label>Login:</label>
                    <input type="text" name="login" value="<?php echo htmlspecialchars($user["login"]); ?>">
                </div>

                <div class="form-group">
                    <label>Email:</label>
                    <input type="text" name="email" value="<?php echo htmlspecialchars($user["email"]); ?>">
                </div>

                <div class="form-group">
                    <label>Name:</label>
                    <input type="text" name="name" value="<?php echo htmlspecialchars($user["name"]); ?>">
                </div>

                <div class="form-group">
                    <label>Age:</label>
                    <input type="text" name="age" value="<?php echo htmlspecialchars($user["age"]); ?>">
                </div>

                <div class="form-group">
                    <label>City:</label>
                    <input type="text" name="city" value="<?php echo htmlspecialchars($user["city"]); ?>">
                </div>

                <button type="submit">Сохранить изменения</button>

            </form>

            <p>
                <a href="profile.php?id=<?php echo urldecode($user["id"]); ?>">Открыть профиль</a>
            </p>
        <?php else: ?>
            <p>
                <a href="showUsers.php">Вернуться к списку пользователей</a>
            </p>
        <?php endif; ?>
        </div>
    </div>
</body>
</html>