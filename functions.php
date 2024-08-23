<?php
function getUsersList()
{
    return include 'users.php';
}
function existsUser($username)
{
    $users = getUsersList();
    return isset($users[$username]);
}
function checkPassword($username, $password)
{
    $users = getUsersList();
    if (isset($users[$username]['password'])) {
        return password_verify($password, $users[$username]['password']);
    }
    return false;
}
function getCurrentUser()
{
    session_start();
    return $_SESSION['username'] ?? null;
}
function saveUsersList($users)
{
    file_put_contents('users.php', '<?php return ' . var_export($users, true) . ';');
}
function setLoginTime($username)
{
    session_start();
    $users = getUsersList();
    $users[$username]['login_time'] = time();
    saveUsersList($users);
}
function getLoginTime($username)
{
    $users = getUsersList();
    return $users[$username]['login_time'] ?? null;
}
function setBirthdate($username, $birthdate)
{
    $users = getUsersList();
    if (isset($users[$username])) {
        $users[$username]['birthdate'] = $birthdate;
        saveUsersList($users);
    }
}
function getBirthdate($username)
{
    $users = getUsersList();
    return $users[$username]['birthdate'] ?? null;
}
function calculateDaysToBirthday($birthdate)
{
    $currentYear = date('Y');
    $birthTimestamp = strtotime($birthdate);
    $currentDate = date('Y-m-d');
    $nextBirthday = date('Y-m-d', mktime(0, 0, 0, date('m', $birthTimestamp), date('d', $birthTimestamp), $currentYear));
    if ($currentDate === $nextBirthday) {
        return 0;
    }
    if (strtotime($nextBirthday) < time()) {
        $nextBirthday = date('Y-m-d', mktime(0, 0, 0, date('m', $birthTimestamp), date('d', $birthTimestamp), $currentYear + 1));
    }
    $daysLeft = (strtotime($nextBirthday) - time()) / 86400;
    return ceil($daysLeft);
}
function setDiscountEndTime($username)
{
    $users = getUsersList();
    $users[$username]['discount_end_time'] = time() + (24 * 60 * 60);
    saveUsersList($users);
}
function getDiscountEndTime($username)
{
    $users = getUsersList();
    return $users[$username]['discount_end_time'] ?? null;
}
