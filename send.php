<?
# Готовая релазация фильтра мата.
# https://github.com/vearutop/php-obscene-censor-rus
namespace Wkhooy;
include 'lib/ObsceneCensorRus.php';
# https://github.com/vearutop/php-obscene-censor-rus

require_once "connection.php";


session_start();
$message_init = $_GET['chat-text'];

if (isset($message_init))
{
    $name = $_SESSION['username'];
    $message = htmlentities(mysqli_real_escape_string($link, $message_init));
    $new_message = ObsceneCensorRus::getFiltered($message);

# Собственная реализация фильтра мата.
#   $words[] = '[плохое лово_1]';
#   $words[] = '[плохое слово_2]';
#   $new_message = preg_replace ($words, "[ЦЕНЗУРА]", $message);

    $query_id = "SELECT id_user FROM users WHERE login_user = '$name'";
	$row_id = mysqli_query($link, $query_id);
	$row_data_id = mysqli_fetch_row($row_id);
	$result_name_id = $row_data_id[0];

    $query = "INSERT INTO `messages` (`id_message`, `text_message`, `time_message`, `id_author`) VALUES (NULL, '$new_message', NOW(), '$result_name_id');";
    $result = mysqli_query($link, $query);

    mysqli_close($link);
    header('Location: auth.php');
    exit();
}
?>
