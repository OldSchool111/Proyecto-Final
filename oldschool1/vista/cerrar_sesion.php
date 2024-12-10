<?php
session_start();
//session_unset();
unset($_SESSION['username']);
session_destroy();
header("Location: login.php");
exit(); // Asegúrate de usar exit() después de header para detener el script.
?>
