<?php

session_start();

require_once "functions.php";

$city = "";
$users = [];
$searchStared = false;

if (isset($_GET["city"])) {
    $searchStared = true;
    $city = trim($_GET["city"]);

    if ($city !== "") {
        $users = searchUserByCity($city);
    }
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Поиск пользователей</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <h1>Поиск пользователей</h1>

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

        <h2>Поиск по городу</h2>

        <form action="searchUsers.php" method="get">
            <div class="form-group">
                <label for="form-group">Город</label>
                <input
                    id="city"
                    type="text"
                    name="city"
                    value="<?php echo htmlspecialchars($city) ?>"
                    placeholder="Например: Москва"
                >
            </div>
            
            <button type="submit">Найти</button>

            <?php if ($city !== ""): ?>
                <a href="searchUsers.php" class="reset-link">Сбросить</a>
            <?php endif; ?>
        </form>

        <?php if ($searchStared): ?>
            <h2>Результаты поиска</h2>

            <?php if ($city === ""): ?>
                <p class="error">Введите название города.</p>
            <?php elseif (count($users) === 0): ?>
                <p>Пользователи из города "<?php echo htmlentities($city) ?>" не найдены</p>
        <?php else: ?>
            <p class="success">Найдено пользователей : <?php count($users); ?></p>

            <table>
                <tr>
                    <th>Id</th>
                    <th>Login</th>
                    <th>Email</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>City</th>
                    <th>Profile</th>
                    <th>Edit</th>
                    <th>Delete</th>                    
                </tr>

                <?php foreach($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user["id"]); ?></td>
                        <td><?php echo htmlspecialchars($user["login"]); ?></td>
                        <td><?php echo htmlspecialchars($user["email"]); ?></td>
                        <td><?php echo htmlspecialchars($user["name"]); ?></td>
                        <td><?php echo htmlspecialchars($user["age"]); ?></td>
                        <td><?php echo htmlspecialchars($user["city"]); ?></td>
                        <td>
                            <a href="profile.php?id=<?php echo urldecode($user["id"]); ?>">
                                Открыть
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    <?php endif; ?>
    </div>

</div>

</body>
</html>