<?
require_once "connection.php";
session_start();
$message_init = $_GET['chat-text'];

if (isset($message_init))
{

    $name = $_SESSION['username'];
    $message = htmlentities(mysqli_real_escape_string($link, $message_init));

	$query_id = "SELECT id_user FROM users WHERE login_user = '$name'";
	$row_id = mysqli_query($link, $query_id);
	$row_data_id = mysqli_fetch_row($row_id);
	$result_name_id = $row_data_id[0];

    $query = "INSERT INTO `messages` (`id_message`, `text_message`, `time_message`, `id_author`) VALUES (NULL, '$message', NOW(), '$result_name_id');";
    $result = mysqli_query($link, $query);

    mysqli_close($link);
    header('Location: auth.php');
    exit();
}
?>
