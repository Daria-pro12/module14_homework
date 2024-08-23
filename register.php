<?php
session_start();
require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    if (existsUser($username)) {
        $error = "Пользователь с таким именем уже существует";
    } else {
        $users = getUsersList();
        $users[$username] = [
            'password' => $password,
            'birthdate' => '',
        ];
        saveUsersList($users);
        $_SESSION['username'] = $username;
        setLoginTime($username);
        setDiscountEndTime($username);
        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация - Спа-Салон</title>
    <link rel="stylesheet" href="style.css"> <!-- Подключение CSS для общего стиля -->
</head>

<body>
    <header>
        <h1>Регистрация</h1>
        <div class="buttons">
            <a href="index.php">Главная</a>
            <a href="login.php">Авторизация</a>
        </div>
    </header>
    <div class="container-form">
        <h2>Создайте новый аккаунт</h2>
        <?php if (isset($error)): ?>
            <p style="color:red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <p style="color:green;"><?php echo $success; ?></p>
            <a href="index.php">На главную</a>
        <?php endif; ?>
        <form method="post">
            <label for="username">Имя пользователя:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Пароль:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Зарегистрироваться</button>
        </form>
    </div>
</body>

</html>