<?php

session_start();

require_once "functions.php";

$message = "";
$messageClass = "";

if (!isAuth()) {
    header("Location: login.php");
    exit;
}

if (!isAdmin()) {
    http_response_code(403);

    echo "Доступ запрещён. Редактировать пользователей может только администратор.";
    exit;
}

$id = isset($_GET["id"])
    ? (int)$_GET["id"]
    : 0;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = isset($_POST["id"])
        ? (int)$_POST["id"]
        : 0;
}

$user = findUserByIdWithRole($id);
$roles = readRoles();

$message = "";
$messageClass = "";

if ($user == null) {
    $message = "Пользователь не найден";
    $messageClass = "error";
}

if (
    $_SERVER["REQUEST_METHOD"] === "POST"
    && $user !== null
) {
    $login = trim($_POST["login"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $name = trim($_POST["name"] ?? "");
    $age= trim($_POST["age"] ?? "");
    $city = trim($_POST["city"] ?? "");
    $roleId= trim($_POST["role_id"])
        ? (int)$_POST["role_id"]
        : 0;

    if ($login === "") {
        $message = "Логин не должен быть пустым";
        $messageClass = "error";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Введите корректный email";
        $messageClass = "error";
    } elseif ($name === "") {
        $message = "Имя не должно быть пустым";
        $messageClass = "error";
    } elseif ($roleId <= 0) {
        $message = "Выберите роль пользователя";
        $messageClass = "error";
    } else {
        $existingUser = findUserByLoginWithRole($login);

        if (
            $existingUser !== null 
            && (int)$existingUser["id"] !== $id
        ) {
            $message = "Пользователь с таким логином уже существует";
            $messageClass = "error";
        } else {
            $oldLogin = $user["login"];

            updateUserWithRole([
                "id" => $id,
                "login" => $login,
                "email" => $email,
                "name" => $name,
                "age" => $age,
                "city" => $city,
                "role_id" => $roleId
            ]);

            if ($_SESSION["login"] === $oldLogin) {
                $_SESSION["login"] = $login;
            }

            $user = findUserByIdWithRole($id);

            $message = "Данные пользователя успешно обновлены";
            $messageClass = "success";
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
                <a href="searchUsers.php">Поиск</a>
                <a href="cabinet.php">Личный кабинет</a>
                <a href="adminPanel.php">Админ-панель</a>
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

                 <div class="form-group">
                    <label for="role_id">Role:</label>
                    <select id="role_id" name="role_id">
                        <?php foreach ($roles as $role): ?>
                            <option value="<?php echo htmlspecialchars($role["id"]); ?>
                            <?php
                                if ((int)$role["id"] === (int)$user["role_id"]) {
                                    echo "selected";
                                }
                            ?>"
                        >
                            <?php echo htmlspecialchars($role["name"]); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
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