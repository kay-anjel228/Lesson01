<?php

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
        <a href="addUser.php">Регистрация</a>
        <a href="login.php">Вход</a>
        <a href="showUsers.php">Пользователи</a>
    </nav>

    <div class="card">

        <h2>Зарегистрированные пользователи</h2>

    <?php

            if(count($users) === 0) {
                echo "<p>Пользователей пока нету</p>";
            } else {
                echo "<table border='1'>";
                    echo "<tr>";
                        echo "<th>Логин</th>";
                        echo "<th>Пароль</th>";
                        echo "<th>Email</th>";
                        echo "<th>Имя</th>";
                        echo "<th>Возраст</th>";
                        echo "<th>Город</th>";
                    echo "</tr>";
                    foreach($users as $user) {
                        $parts = explode(":", $user);

                        echo "<tr>";
                            echo "<td>$parts[0]</td>";
                            echo "<td>$parts[1]</td>";
                            echo "<td>$parts[2]</td>";
                            echo "<td>$parts[3]</td>";
                            echo "<td>$parts[4]</td>";
                            echo "<td>$parts[5]</td>";
                        echo "</tr>";
                    }
                echo "</table>";
            }
    ?>
    </div>
</div>

</body>
</html>