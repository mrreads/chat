<?
session_start();

if (isset($_SESSION['username']))
{
    header('Location: chat.php');
    exit();
}

/* СКРИПТ РЕГИСТРАЦИИ */
require_once "connection.php";

@$login = $_POST['reg-login'];
@$name = $_POST['reg-name'];
@$password = $_POST['reg-pass'];

@$choose = $_POST['choose'];
@$button = $_POST['reg-button'];

$query = "SELECT login_user FROM users WHERE login_user = '$login';";
$result = mysqli_query($link, $query);
$row = mysqli_num_rows($result);

if ($row == 0 && @$_POST['reg-button'])
{
    $query_reg = "INSERT INTO `users` (`id_user`, `login_user`, `name_user`, `password_user`, `id_role`, `id_grupi`) VALUES (NULL, '$login', '$name', '$password', 2, '$choose');";
    $send = mysqli_query($link, $query_reg);
}

if (@$send)
{
    header('Location: auth.php');
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
    <style>
        body { min-height: 780px; }
    </style>
</head>

<body>
<div id="main">
    <h1 id="logo">РЕГИСТРАЦИЯ</h1>
    <?
    if (@$send)
    {
        echo "<h2>УСПЕШНАЯ РЕГИСТРАЦИЯ</h2>";
    }
    ?>
    <form id="reg" method="POST">
        <input type="text" name="reg-login" id="a-name" required="" autofocus placeholder="ЛОГИН">
        <input type="text" name="reg-name" id="a-name" required="" autofocus placeholder="НИКНЕЙМ">
        <input type="password" name="reg-pass" id="a-pass" required="" placeholder="ПАРОЛЬ">

        <div id="radios">
            <div>
                <input type="radio" class="radio" name="choose" value="1" required="">
                <label for="1">Группа 1</label>
            </div>

            <div>
                <input type="radio" class="radio" name="choose" value="2" required="">
                <label for="2">Группа 2</label>
            </div>
        </div>

        <input type="submit" name="chat-button" id="i-button" value="РЕГИСТРАЦИЯ">
        <a href="auth.php" id="reg-button"> <span> ЕСТЬ АККАУНТ? </span> ВОЙТИ! </a>
    </form>
</div>
</body>

</html>