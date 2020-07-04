<?
session_start();
require_once 'connection.php';


if (isset($_SESSION['username']))
{
    $login = $_SESSION['username'];
    $query_role = "SELECT id_role FROM users WHERE login_user = '$login'";
    $result_role = mysqli_query($link, $query_role);
    $role_data = mysqli_fetch_row($result_role);
    $role = $role_data[0];

    if ($role == 2)
    {
        header('Location: chat.php');
        exit();
    }

    if ($role == 1)
    {
        header('Location: admin.php');
        exit();
    }
}

/* СКРИПТ АВТОРИЗАЦИИ */


$login = $_POST['auth-login'];
$password = $_POST['auth-pass'];
$button_auth = $_POST['auth-button'];

$query = "SELECT login_user, password_user FROM users";
$result = mysqli_query($link, $query);

while ($row = mysqli_fetch_row($result))
{
    if (($login == $row[0]) and ($password == $row[1]))
    {
        session_start();
        $_SESSION['username'] = "$row[0]";
        $_SESSION['theme'] = 1;
        header('Location: auth.php');
    }
}


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title> АВТОРИЗАЦИЯ </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesheets\style_auth.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
</head>

<body>
<div id="main">
    <h1 id="logo">АВТОРИЗАЦИЯ</h1>

    <form id="auth" method="POST">
        <?
        if (isset($button_auth) and isset($result))
        {
            echo "<h1> ПОБРОБУЙТЕ СНОВА. </h1>";
        }
        ?>
        <input type="text" name="auth-login" id="a-name" required="" autofocus placeholder="ЛОГИН">
        <input type="password" name="auth-pass" id="a-pass" required="" placeholder="ПАРОЛЬ">
        <input type="submit" name="auth-button" id="i-button" value="ВОЙТИ">
        <a href="register.php" id="reg-button"> <span> НЕТ АККАУНТА? </span> РЕГИСТРАЦИЯ! </a>
    </form>
</div>
</body>

</html>