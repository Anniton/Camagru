<?php
	require 'database.php';
/**
 * Connexion to MYSQL
 **/
    try {
		$bdd = new PDO("mysql:host=localhost;port=8080", $DB_USER, $DB_PASSWORD);
		$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $ex) { exit($ex); };

/**
 * Create DB
 **/
	try {
		$sql = "CREATE DATABASE IF NOT EXISTS $db;";
		$bdd->prepare($sql)->execute();
	} catch(PDOException $ex) { exit($ex); };

/**
 * Deonnexion to MYSQL
 **/
	$pdo = null;

/**
 * Connexion to DB
 **/
	try {
		$bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
		} catch(PDOException $ex) { exit($ex); };
/**
 * Create table membres
 **/
    try {
        $sql = "CREATE TABLE IF NOT EXISTS espace_membre.membres
        (
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(255) NOT NULL UNIQUE,
            mail VARCHAR(255) NOT NULL,
            password TEXT NOT NULL,
            confirmation_token VARCHAR(60) NULL,
			confirmed_at DATETIME NULL,
			reset_token VARCHAR(60) NULL,
			reset_at DATETIME NULL,
			remember_token VARCHAR(250) NOT NULL,
			mail_active TINYINT(1) DEFAULT 1 NOT NULL
        );";
        $bdd->prepare($sql)->execute();
	} catch(PDOException $ex) { exit($ex); };

/**
 * Create table photos
 **/

    try {
        $sql = "CREATE TABLE IF NOT EXISTS espace_membre.photos
        (
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            photo LONGTEXT NOT NULL,
            author_id INT(11) NOT NULL,
            nb_like BIGINT(20) NOT NULL,
            create_date DATETIME DEFAULT NOW() NOT NULL
        );";
        $bdd->prepare($sql)->execute();
	} catch(PDOException $ex) { exit($ex); };

/**
 * Create table comments
 **/
	try {
        $sql = "CREATE TABLE IF NOT EXISTS espace_membre.comments
        (
            id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            comment VARCHAR(255) NOT NULL,
            date DATETIME DEFAULT NOW() NOT NULL,
            uid INT(11) NOT NULL,
            photo_id INT(11) NOT NULL
        );";
        $bdd->prepare($sql)->execute();
    } catch(PDOException $ex) { exit($ex); };
?>
