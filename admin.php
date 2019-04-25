<?php

session_start();
require_once 'connection.php';

if (empty($_SESSION['username'])) 
{
    header('Location: auth.php');
    exit();
}

$name = $_SESSION['username'];
$query_role = "SELECT id_role FROM users WHERE login_user = '$name'";
$result_role = mysqli_query($link, $query_role);
$role_data = mysqli_fetch_row($result_role);
$role = $role_data[0];

if ($role != 1) 
{
    header('Location: auth.php');
    exit();
}

include "send.php";

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title> ЧАТ </title>
    <link rel="stylesheet" href="stylesheets\style_chat.css">
    <link rel="stylesheet" href="stylesheets\style_admin.css">
    <?
    if ($_SESSION['theme'] == 1)
        echo '<link rel="stylesheet" href="stylesheets\style_chat.css">';
    if ($_SESSION['theme'] == 2)
        echo '<link rel="stylesheet" href="stylesheets\style_chat_dark.css">';
    if ($_SESSION['theme'] == 3)
        echo '<link rel="stylesheet" href="stylesheets\style_chat_blue.css">';
    ?>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
</head>

<body>
    <div id="main">

        <div id="three">
            <form class="bd-action" method="POST">
                <p class='bda-text'> Введите ID сообщения, которое хотите удалить. </p>
                <input type="text" name='msg-delete' id="m-delete" require='' placeholder="ID ВВЕДИТЕ УДАЛИТЬ КОТОРОГО СООБЩЕНИЕ">
                <input type="submit" name="msg-del-button" id="m-d-buttin" value='УДАЛИТЬ'>

                <?
                $id_message = $_POST['msg-delete'];
                $button_delete_message = $_POST['msg-del-button'];


                if (isset($id_message)) 
                {
                    $msg_del_query = "DELETE FROM messages WHERE id_message = '$id_message'";
                    $relust_msg_del = mysqli_query($link, $msg_del_query);
                    echo "<meta http-equiv='refresh' content='0'>";
                }
                ?>
            </form>

            <form class="bd-action" method="GET">
                <p class='bda-text'> Очистить чат. </p>

                <?
                $clear_button = $_GET['clear-button'];
                if (isset($clear_button)) 
                {
                    $clear_query  = "DELETE FROM messages";
                    $result_clear = mysqli_query($link, $clear_query);
                }
                ?>

                <input type="submit" name="clear-button" id="clear-buttin" value='ОЧИИСТИТЬ?'>

            </form>

        </div>

        <div id="first">
            <?php
            $query = "SELECT name_user, time_message, text_message, id_message  FROM users, messages WHERE users.id_user = messages.id_author ORDER BY id_message";
            $result = mysqli_query($link, $query);
            echo "<div id='chat-box'>";
            if ($result) {
                while ($row_data = mysqli_fetch_row($result)) 
                {

                    echo "	<div>";
                    echo "		<p class='name'> [$row_data[3]] $row_data[0] </p>";
                    echo "		<p class='date'> $row_data[1] </p>";
            ?>
                    <form method='POST' class='del_solo_msg'>
                        <? echo "<input type='submit' name='msg_solo' class='msg_solo' value='$row_data[3]'>"; ?>
                        <?
                        $solo_msg_button = $_POST['msg_solo'];

                        if (isset($solo_msg_button) and $row_data[3] == $solo_msg_button) 
                        {
                            $solo_msg_res  = "DELETE FROM messages WHERE id_message = '$row_data[3]'";
                            $solo_msg_quer = mysqli_query($link, $solo_msg_res);
                            echo "<meta http-equiv='refresh' content='0'>";
                        }
                        ?>
                    </form>

                    <?
                    echo "		<p class='message'> $row_data[2] </p>";
                    echo "	</div>";
                }
                mysqli_free_result($result);
            }
            echo "</div>";
            ?>

            <?php
            /////////////ВЫЧИСЛЕНИЕ КОЛИЧЕСТВА АКТИВНЫХ ПОЛЬЗОВАТЕЛЕЙ В ЧАТЕ/////////////////////
            $dir_patch = opendir(session_save_path());
            $users = 0;
            while ($file = readdir($dir_patch)) {
                if (is_file(session_save_path() . "\/" . $file)) 
                {
                    $arr = stat(session_save_path() . "\/" . $file);
                    if (time() - $arr[9] < 30) // подсчет только тех сессий, которые созданы не более 10 секунд назад.
                        {
                            ++$users;
                        }
                }
            }
            closedir($dir_patch);
            ?>

            <form id="f-chat" method="GET" action="send.php">
                <input type="text" name="chat-text" id="i-text" required="" autofocus placeholder="ВВЕДИТЕ СООБЩЕНИЕ">
                <input type="submit" name="chat-button" id="i-button" value="ОТПРАВИТЬ">
            </form>
        </div>

        <div id='second'>

            <?
            $query = "SELECT name_user FROM users WHERE login_user = '$name'";
            $row = mysqli_query($link, $query);
            $row_data = mysqli_fetch_row($row);
            $result = $row_data[0];

            echo "<p class='user-count'> ВЫ ВОШЛИ КАК АДМИНИСТРАТОР! </p>";
            echo "<p class='user-count'> Ваш ник: $result </p>";
            #echo "<p class='user-count'> Выш логин: " . $_SESSION['username'] . " </p>";
            echo "<p class='user-count'> Активных юзеров: $users </p>";

            ?>

            <form id="change-theme" method="GET" action="theme.php">
                <input type="submit" name="c-theme" id="c-theme" value="">
            </form>

            <? echo "<a href='setting.php' class='setting'>  </a>"; ?>

            <form id="log-out" method="GET" action="logout.php">
                <input type="submit" name="exit-button" id="e-button" value="">
        </form>


        </div>
    </div>

    <script>
        var chat_box = document.querySelector('#chat-box');
        chat_box.scrollTop = chat_box.scrollHeight;
    </script>

</body>

</html>