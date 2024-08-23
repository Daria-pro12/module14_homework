<?php
session_start();
require 'functions.php';

$username = getCurrentUser();

if (!$username) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['birthdate'])) {
    $birthdate = $_POST['birthdate'];
    setBirthdate($username, $birthdate);
    header('Location: index.php');
    exit();
}

$birthdate = getBirthdate($username);
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Укажите дату рождения</title>
    <link rel="stylesheet" href="style.css"> <!-- Подключение CSS для общего стиля -->
</head>

<body>
    <div class="container-form">
        <h2>Для получения скидки в День рождения, укажите дату вашего рождения:</h2>
        <form method="post">
            <label for="birthdate">Дата рождения:</label>
            <input type="date" id="birthdate" name="birthdate" required>
            <div class="buttons">
                <button type="submit">Сохранить</button>
                <button type="button"><a href="index.php">Не хочу</a></button>
            </div>
        </form>
    </div>
</body>

</html>