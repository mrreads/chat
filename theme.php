<?
session_start();

$themeChooser = $_SESSION['theme'];

if ($themeChooser == 1)
    $_SESSION['theme'] = 2;

if ($themeChooser == 2)
    $_SESSION['theme'] = 3;

if ($themeChooser == 3)
    $_SESSION['theme'] = 1;

header('Location: auth.php');
exit();
?>
