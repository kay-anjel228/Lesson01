<?php

session_start();

require_once "functions.php";

$users = readUsersWithRoles();

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Список пользователей</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <h1>Список пользователей</h1>

    <nav class="menu">
        <a href="index.php">Главная</a>

        <?php if (isAuth()): ?>
            <a href="showUsers.php">Пользователи</a>
            <a href="searchUsers.php">Поиск</a>
            <a href="cabinet.php">Личный кабинет</a>
            <a href="changePassword.php">Сменить пароль</a>

            <?php if (isAdmin()): ?>
                <a href="adminPanel.php">Админ-пароль</a>
            <?php endif; ?>

            <a href="logout.php">Выход</a>
        <?php else: ?>    
            <a href="addUser.php">Регистрация</a>
            <a href="login.php">Вход</a>
            <a href="showUsers.php">Пользователи</a>
            <a href="searchUsers.php">Поиск</a>
        <?php endif; ?>
    </nav>

    <div class="card">

        <h2>Зарегистрированные пользователи</h2>

        <?php if (count($users) === 0): ?>
            <p>Пользователей пока нет</p>
        <?php else: ?>
            <table>
                <tr>
                    <th>Id</th>
                    <th>Login</th>
                    <th>Email</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>City</th>
                    <th>Role</th>
                    <th>Profile</th>
                    <?php if (isAdmin()): ?>
                        <th>Edit</th>
                        <th>Delete</th>         
                    <?php endif; ?>           
                </tr>

                <?php foreach($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user["id"]); ?></td>
                        <td><?php echo htmlspecialchars($user["login"]); ?></td>
                        <td><?php echo htmlspecialchars($user["email"]); ?></td>
                        <td><?php echo htmlspecialchars($user["name"]); ?></td>
                        <td><?php echo htmlspecialchars($user["age"]); ?></td>
                        <td><?php echo htmlspecialchars($user["city"]); ?></td>
                        <td><?php echo htmlspecialchars($user["role_name"]); ?></td>

                        <td>
                            <a href="profile.php?id=<?php echo urldecode($user["id"]); ?>">
                                Открыть
                            </a>
                        </td>
                        <?php if (isAdmin()): ?>
                        <td>
                            <a href="editUser.php?id=<?php echo urldecode($user["id"]); ?>">
                                Изменить
                            </a>
                        </td>
                        <td>
                            <form
                                method="post"
                                action="deleteUser.php"
                                onsubmit="return confirm('Вы действительно хотите удалить пользователя?');"
                            >
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($user["id"]); ?>">
                                <button type="submit" class="delete-button">Удалить</button>
                            </form>
                        </td>
                    <?php endif; ?>    
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>

</div>

</body>
</html>