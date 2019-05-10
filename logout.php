<?php
session_start();
unset($_SESSION['auth']);
$_SESSION['flash']['success'] = "Vous etes maintenant deconnecte";
session_destroy();
header('Location: login.php');
?>
