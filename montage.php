<?php
	include_once('navigation.php');
	include_once("db.php");

	if ($_SESSION['auth']){
		if(!empty($_POST['photo'])){
			$user_id = $_SESSION['auth']->id;
			$photo = ($_POST['photo']);
			var_dump($photo);
			// $photo = htmlspecialchars($_POST['photo']);
			$bdd->prepare('INSERT INTO photos SET photo = ?, author_id = ?')->execute([$photo, $user_id]);
			header('Location: montage.php');
		  }
		}
		else{
			header('Location:gallery.php');
		}
?>


<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>MONTAGE</title>
	<link rel="stylesheet" href="montage.css" type="text/css" media="all">
	<!-- <script src="script.js"></script> -->
</head>

<body>

	<div class="container">
		<div class="menu"></div>
		<div class="content">
			<div class="orga">
				<video class="vidpic" id="sourcevid" width='400' height='300' autoplay="true"></video>
				<p id="message" class="message"></p>
				<div><canvas class="vidpic" id="canvas" width='400'  height='300' style='display:inline-block'></canvas></div>
			</div>

			<div id="buttons" class='fuckCss'>
				<button class="btn" onclick="ouvrir_camera()"><img src="logo_gal/open_cam.svg" alt="open_cam" max-width=100% height=45;></button>
				<button class="btn" onclick="fermer()"><img src="logo_gal/close_cam.svg" alt="close_cam" max-width=100% height=45;></button>
				<br>
				<button class="btn" onclick="photo()"><img src="logo_gal/take_pic.svg" alt="take_pic" max-width=100% height=45;></button>
				<button class="btn" onclick="effacer()"><img src="logo_gal/trash.svg" alt="delete" max-width=100% height=45;></button>
				<button class="btn" onclick="sauver()"><img src="logo_gal/save.svg" alt="save" max-width=100% height=45;></button>
				<button class="btn" onclick="prepare_envoi()"><img src="logo_gal/save_pic.svg" alt="save_pic" max-width=100% height=45;></button>
				<label for="input" class="label-file"><img src="logo_gal/add_gallery.svg" alt="choose_pic" max-width=100% height=45;></label>
				<input id="input" class="input-file" type="file" accept="image/*">
			</div>
		</div>

		<div class="img_stickers">
		<?php
			/**
			 * setImage Function:
			 *
			 * @bouton est l'id du bouton,
			 * @id l'id de l'emplacement de l'image,
			 * @titre le titre de l'image,
			 * @image le lien
			 */
			$tableau=array("stickers/1.png","stickers/2.png","stickers/3.png","stickers/4.png");
			for($i=0;$i<count($tableau);$i++){
		?>
			<div id="bouton<?php echo $i; ?>" onclick="setImage('bouton<?php echo $i; ?>','image<?php echo $i; ?>','<?php echo $tableau[$i]; ?>','<?php echo $tableau[$i]; ?>');">
			<img src="<?php echo $tableau[$i];?>"></div>
			<div id="image<?php echo $i; ?>"></div>
		<?php
			}
		?>
		</div>

		<div class="footer">ABOUT US . SUPPORT . PRESS . API . JOBS . PRIVACY . TERMS . DIRECTORY . PROFILES . HASHTAGS . LANGUAGE</div>
	</div>
</body>
<script async src="script.js"></script>
<script src="importation.js"></script>
</html>