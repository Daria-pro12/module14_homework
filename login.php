<?php
session_start();
require 'functions.php';

if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (checkPassword($username, $password)) {
        $_SESSION['username'] = $username;

        if (!getBirthdate($username)) {
            header('Location: set-birthdate.php');
            exit();
        } else {
            header('Location: index.php');
            exit();
        }
    } else {
        $error = "Неверное имя пользователя или пароль";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация - Спа-Салон</title>
    <link rel="stylesheet" href="/style.css"> <!-- Подключение CSS для общего стиля -->
</head>

<body>
    <header>
        <h1>Авторизация</h1>
        <div class="buttons">
            <a href="index.php">Главная</a>
            <a href="register.php">Регистрация</a>
        </div>
    </header>
    <div class="container-form">
        <h2>Войдите в аккаунт</h2>
        <?php if (isset($error)): ?>
            <p style="color:red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="post">
            <label for="username">Имя пользователя:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Пароль:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Войти</button>
        </form>
    </div>
</body>
</html>