<?php
$bdd = new PDO('mysql:host=localhost;dbname=espace_membre;charset=utf8', 'root', 'camagru');
    // $DB_DSN = "mysql:host=localhost;dbname=espace_membre;charset=utf8";
    // $DB_USER = "root";
    // $DB_PASSWORD = "camagru";
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
?>