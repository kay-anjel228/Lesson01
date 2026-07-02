<?php
setcookie("last_login", "", time() - 3600);

header("Location: login.php");
?>