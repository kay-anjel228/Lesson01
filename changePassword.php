<?php 

session_start();

require_once "functions.php";

if (!isAuth()) {
    header("Location: login.php");
    exit;
}

$currentUser = getCurrentUser();

if ($currentUser === null) {
    unset($_SESSION["login"]);
    session_destroy();

    header("Location: login.php");
    exit;
}

$message = "";
$messageClass = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $oldPassword = isset($_POST["old_password"])
        ? $_POST["old_password"]
        : "";
    $newPassword = isset($_POST["new_password"])
        ? $_POST["new_password"]
        : "";
    $confirmPassword = isset($_POST["confirm_password"])
        ? $_POST["confirm_password"]
        : "";

    if ($oldPassword === "" || $newPassword === "" || $confirmPassword) {
        $message = "Заполните все поля";
        $messageClass = "error";
    } elseif (!password_verify($oldPassword, $currentUser["password"])) {
        $message = "Старый пароль указан неверно";
        $messageClass = "error";
    } elseif (strlen($newPassword) < 4) {
        $message = "Новый пароль должен содержать минимум 4 символа";
        $messageClass = "error";
    } elseif ($newPassword !== $confirmPassword) {
        $message = "Новый пароль и подтверждение не совпадают";
        $messageClass = "error";
    } elseif (password_verify($newPassword, $currentUser["password"])) {
        $message = "Новый пароль должен отличаться от старого";
        $messageClass = "error";
    } else {
        $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);

        updateUserPassword($currentUser["id"], $newPassword);
        $message = "Пароль успешно изменён";
        $messageClass = "success";

        $currentUser = getCurrentUser();
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Смена пароля</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Смена пароля</h1>

        <nav class="menu">
            <a href="index.php">Главная</a>
            <a href="showUsers.php">Пользователи</a>
            <a href="searchUsers.php">Поиск</a>
            <a href="cabinet.php">Личный кабинет</a>
            <a href="changePassword.php">Смена пароля</a>
            <a href="logout.php">Выход</a>
        </nav>

        <div class="card">
            <h2>
                Изменение пароля пользователя
                <?php echo htmlspecialchars($currentUser["login"]); ?>
            </h2>

            <?php if ($message !== ""): ?>
                <p class="<?php echo $messageClass ?>">
                    <?php echo htmlspecialchars($message); ?>
                </p>
            <?php endif; ?>

            <form action="changePassword.php" method="post">
                <div class="form-group">
                    <label for="old_password">Старый пароль: </label>
                    <input 
                        id="old_password"
                        type="password" 
                        name=""     
                        autocomplete="current-password"
                    >
                </div>
                <div class="form-group">
                    <label for="new-password">Новый пароль: </label>
                    <input
                        id="new_password"
                        type="password"
                        name="new_password"
                        autocomplete="current-password">
                </div>
                <div class="form-group">
                    <label for="confirm_password">Подтверждение нового пароля: </label>
                    <input
                        id="confirm_password"
                        type="password" 
                        name="confirm_password"
                        autocomplete="current-password"> 
                </div>

                <button type="submit">Изменить пароль</button>
            </form>
        </div>
    </div>
</body>
</html>