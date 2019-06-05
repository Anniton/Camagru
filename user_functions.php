<?php
function debug($variable){
    echo var_dump($variable, true);
}

function str_random($length){
    $alphabet = "0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM";
    return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
}

function logged_only(){

    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }

    if(!isset($_SESSION['auth'])){
        $_SESSION['flash']['error'] = "Vous n'avez pas le droit d'acceder a cette page.";
        header('Location: Login.php');

        exit();
    }
}

?>