<?php
session_start();
require 'functions.php';

$username = $_SESSION['username'] ?? null;

$loginTime = getLoginTime($username);

if ($username) {
    $discountEndTime = getDiscountEndTime($username);
    $currentTime = time();

    if ($discountEndTime) {
        $timeLeft = max(0, $discountEndTime - $currentTime);
        $timeLeftFormatted = gmdate('H:i:s', $timeLeft);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['birthdate'])) {
        $birthdate = $_POST['birthdate'];
        setBirthdate($username, $birthdate);
        setDiscountEndTime($username);
    }

    $birthdate = getBirthdate($username);
    $daysToBirthday = $birthdate ? calculateDaysToBirthday($birthdate) : null;
    $isBirthdayToday = $daysToBirthday === 0;
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Спа-Салон</title>
    <link rel="stylesheet" href="/style.css">
</head>

<body>
    <header>
        <?php if ($username): ?>
            <h1>Добро пожаловать в наш Спа-Салон, <span><?php echo htmlspecialchars($username); ?>!</span></h1>
            <div class="buttons">
                <a href="logout.php">Выйти</a>
            </div>
        <?php else: ?>
            <h1>Добро пожаловать в наш Спа-Салон!</h1>
            <div class="buttons">
                <a href="login.php">Авторизация</a>
                <a href="register.php">Регистрация</a>
            </div>
        <?php endif; ?>
    </header>
    <div class="container">
        <?php if ($username && $birthdate): ?>
            <?php if ($isBirthdayToday): ?>
                <section class="birthday-congratulations">
                    <h2>С Днем Рождения, <?php echo htmlspecialchars($username); ?>!</h2>
                    <p>Мы дарим вам скидку 5% на все услуги нашего салона!</p>
                </section>
            <?php else: ?>
                <section class="birthday-info">
                    <p>До вашего дня рождения осталось (дней): <strong><?php echo $daysToBirthday; ?> </strong></p>
                </section>
            <?php endif; ?>
        <?php endif; ?>
        <?php if ($username && $timeLeft > 0): ?>
            <section class="promotions personal-promotion">
                <h2>Ваша персональная акция!</h2>
                <p>Дарим вам скидку 20% на первый визит.</p>
                <p>Время до истечения персональной скидки:</p>
                <div class="discount-timer">
                    <p> <?php echo $timeLeftFormatted; ?></p>
                </div>
            </section>
        <?php endif; ?>
        <section class="services">
            <h2>Наши услуги</h2>
            <ul>
                <li>Массаж (Классический, Тайский, Шведский)</li>
                <li>Уход за лицом</li>
                <li>СПА-процедуры для тела</li>
                <li>Маникюр и педикюр</li>
                <li>Ароматерапия</li>
            </ul>
        </section>
        <section class="promotions">
            <h2>Акции</h2>
            <ul>
                <li>Скидка 10% на маникюр</li>
                <li>Подарочный сертификат на 5000 руб при покупке абонемента</li>
                <li>Бесплатный массаж при покупке любых двух услуг</li>
            </ul>
        </section>
        <section class="gallery">
            <h2>Фото салона</h2>
            <img src="images/foto-massage.jpg" alt="Фото Спа-Салона">
            <img src="images/foto-manicure.jpg" alt="Фото Спа-Салона">
            <img src="images/foto-face.png" alt="Фото Спа-Салона">
        </section>
    </div>
</body>

</html>