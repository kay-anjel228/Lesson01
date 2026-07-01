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

        $fileName = "users.txt";

        if (!file_exists($fileName)) {
            echo "<p class='error'>Файл users.txt не найден</p>";
        } else {
            $users = file($fileName, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            if (count($users) === 0) {
                echo "<p>Пользователей пока нет</p>";
            } else {
                echo "<table>";
                    echo "<tr>";
                        echo "<th>Login</th>";
                        echo "<th>Password</th>";
                        echo "<th>Email</th>";
                        echo "<th>Name</th>";
                        echo "<th>Age</th>";
                        echo "<th>City</th>";
                    echo "</tr>";

                    foreach ($users as $user) {
                        $parts = explode(":", $user);

                        $login = isset($parts[0]) ? $parts[0] : "";
                        $password = isset($parts[1]) ? $parts[1] : "";
                        $email = isset($parts[2]) ? $parts[2] : "";
                        $name = isset($parts[3]) ? $parts[3] : "";
                        $age = isset($parts[4]) ? $parts[4] : "";
                        $city = isset($parts[5]) ? $parts[5] : "";

                        echo "<tr>";
                            echo "<td>$login</td>";
                            echo "<td class='hash'>$password</td>";
                            echo "<td>$email</td>";
                            echo "<td>$name</td>";
                            echo "<td>$age</td>";
                            echo "<td>$city</td>";
                        echo "</tr>";
                    }

                echo "</table>";
            }
        }

        ?>

    </div>

</div>

</body>
</html>