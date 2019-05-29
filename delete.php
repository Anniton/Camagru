<?php
session_start();
include_once("db.php");

if($_SESSION['auth']) {
	if (!empty($_POST['pic_id'])) {
		$pic_id = $_POST['pic_id'];
		$req = $bdd->prepare('SELECT author_id FROM photos WHERE id=?');
		$req->execute([$pic_id]);
		$data = $req->fetchAll();
		if ($data[0]->author_id == $_SESSION['auth']->id)
			$ret = $bdd->prepare('DELETE FROM photos WHERE id=?')->execute([$pic_id]);
		else
			error_log("Delete failed !");
	}
}
?>