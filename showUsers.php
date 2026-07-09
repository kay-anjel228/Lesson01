<?php

session_start();

require_once "functions.php";

$users = readUsers();

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
            <a href="cabinet.php">Личный кабинет</a>
            <a href="logout.php">Выход</a>
        <?php else: ?>    
            <a href="addUser.php">Регистрация</a>
            <a href="login.php">Вход</a>
            <a href="showUsers.php">Пользователи</a>
        <?php endif; ?>
    </nav>

    <div class="card">

        <h2>Зарегистрированные пользователи</h2>

        <?php
            if(count($users) === 0) {
                echo "<p>Пользователей пока нету</p>";
            } else {
                echo "<table>";
                    echo "<tr>";
                        echo "<th>Логин</th>";
                        echo "<th>Пароль</th>";
                        echo "<th>Email</th>";
                        echo "<th>Имя</th>";
                        echo "<th>Возраст</th>";
                        echo "<th>Город</th>";
                        echo "<th>Profile</th>";
                        echo "<th>Edit</th>";
                        echo "<th>Delete</th>";
                    echo "</tr>";

                    foreach($users as $user) {
                        $id = htmlspecialchars($user["id"]);
                        $login = htmlspecialchars($user["login"]);
                        $password = htmlspecialchars($user["password"]);
                        $email = htmlspecialchars($user["email"]);
                        $name = htmlspecialchars($user["name"]);
                        $age = htmlspecialchars($user["age"]);
                        $city = htmlspecialchars($user["city"]);

                        $profileURL = "profile.php?id=" . urldecode($id);
                        $editURL = "editUser.php?id=" . urldecode($id); 
                        $deleteURL = "deleteUser.php?id=" . urldecode($id); 


                        echo "<tr>";
                            echo "<td>$id</td>";
                            echo "<td>$login</td>";
                            echo "<td class='hash'>$password</td>";
                            echo "<td>$email</td>";
                            echo "<td>$name</td>";
                            echo "<td>$age</td>";
                            echo "<td>$city</td>";
                            echo "<td><a href='$profileURL'>Открыть</a></td>";
                            echo "<td><a href='$editURL'>Открыть</a></td>";
                            echo "<td><a class='delete-link' href='$deleteURL'>Открыть</a></td>";
                        echo "</tr>";
                    }
                echo "</table>";
            }
        ?>
    </div>
</div>

</body>
</html>