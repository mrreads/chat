<?php
session_start();

/* ЕСЛИ СЕССИЯ ПУСТА - РЕДИРЕКТ НА СТРАНИЦУ АВТОРИЗАЦИИ */
if (empty($_SESSION['username'])) 
{
    header('Location: auth.php');
    exit();
}

$username = $_SESSION['username'];

require_once "connection.php";

/* СКРИПТ ИЗМЕНЕНИЯ НИКНЕЙМА */
$query_login = "SELECT name_user FROM users WHERE login_user = '$username'";
$row = mysqli_query($link, $query_login);
$row_data = mysqli_fetch_row($row);

$name = $row_data[0];
@$new_name = $_GET['cn-text'];

if (isset($new_name)) 
{
    $query_cn = "UPDATE `users` SET `name_user` = '$new_name' WHERE `login_user` = '$username';";
    $result_cn = mysqli_query($link, $query_cn);
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title> ЧАТ </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesheets\style_setting.css">
    <?
    if ($_SESSION['theme'] == 1)
        echo '<link rel="stylesheet" href="stylesheets\style_setting.css">';
    if ($_SESSION['theme'] == 2)
        echo '<link rel="stylesheet" href="stylesheets\style_chat_dark.css">';
    if ($_SESSION['theme'] == 3)
        echo '<link rel="stylesheet" href="stylesheets\style_chat_blue.css">';
    ?>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
</head>

<body>


    <?
    /* БЕРЁТ ОСНОВНУЮ ИНФОРМАЦИЮ О ПОЛЬЗОВАТЕЛЕ ИЗ БАЗЫ */
    $query =
        "SELECT
    login_user, name_user, number_grupi, name_role
FROM
    users,
    grupi,
    roles
WHERE
    users.id_grupi = grupi.id_grupi
AND users.id_role = roles.id_role
AND login_user = '$username';";

    $row = mysqli_query($link, $query);
    $row_data = mysqli_fetch_row($row);
    $result_login = $row_data[0];
    $result_name = $row_data[1];
    $result_group = $row_data[2];
    $result_role = $row_data[3];
    ?>

    <div id="main">
        <div id="first">
            <div id='chat-box'>

                <div class='block-info'>
                    <? echo "<h1> Ваш логин: $result_login </h1> "; ?>
                </div>

                <div class='block-info'>
                    <? echo "<h1> Ваш ник: $result_name </h1> "; ?>
                </div>

                <div class='block-info'>
                    <? echo "<h1> Ваш группа: $result_group </h1> "; ?>
                </div>

                <div class='block-info'>
                    <? echo "<h1> Ваш роль: $result_role </h1> "; ?>
                </div>

                <form id="cn-name" method="GET">
                    <h1> СМЕНА ЛОГИНА </h1>
                    <input type="text" name="cn-text" id="cn-text" required="" placeholder="ВВЕДИТЕ НОВЫЙ ИМЯ">
                    <input type="submit" name="cn-button" id="cn-button" value="ПОМЕНЯТЬ">
                </form>

                <form id="cp-name" method="POST">
                    <?
                    /* СКРИПТ СМЕНЫ ПАРОЛЯ */
                    @$old_password = $_POST['cp-text-old'];
                    @$new_password = $_POST['cp-text-new'];

                    $query_password = "SELECT password_user FROM users WHERE login_user = '$username'";

                    $row = mysqli_query($link, $query_password);
                    $row_data = mysqli_fetch_row($row);

                    $password_db = $row_data[0];

                    if (isset($new_password) and isset($old_password)) 
                    {
                        if ($password_db == $old_password) 
                        {
                            $query_cp = "UPDATE `users` SET `password_user` = '$new_password' WHERE `login_user` = '$username';";
                            $result_cp = mysqli_query($link, $query_cp);
                        }
                    }
                    ?>
                    <h1> СМЕНА ПАРОЛЯ </h1>
                    <input type="password" name="cp-text-old" id="cp-text" required="" placeholder="ВВЕДИТЕ СТАРЫЙ ПАРОЛЬ">
                    <input type="password" name="cp-text-new" id="cp-text" required="" placeholder="ВВЕДИТЕ НОВЫЙ ПАРОЛЬ">
                    <input type="submit" name="cp-button" id="cp-button" value="ПОМЕНЯТЬ">
                    <?
                    /* ЕСЛИ СМЕНИЛИ ПАРОЛЬ - НАПИСАТЬ ОБ ЭТОМ */
                    if (@$result_cp)
                    {
                        echo "<h1> ВЫ СМЕНИЛИ ПАРОЛЬ </h1>";
                    }
                    ?>
                </form>

            </div>
        </div>

        <div id='second'>
            <? echo "<a href='auth.php' class='back'>  </a>"; ?>
        </div>
    </div>


</body>

</html>