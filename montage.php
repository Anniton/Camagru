<?php
	session_start();
	require 'config/setup.php';

	if ($_SESSION['auth']){
		if(!empty($_POST['photo'])){
			$user_id = $_SESSION['auth']->id;
			$photo = htmlspecialchars($_POST['photo']);
			$req = $bdd->prepare('INSERT INTO photos SET photo = ?, author_id = ?')->execute([$photo, $user_id]);
			$test = $bdd->lastInsertId();
			$data['new_pic_id'] = (int)$test;
			echo json_encode($data);
			exit();
		}
	}
	else{
		header('Location:gallery.php');
	}
	include_once('navigation.php');
?>


<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>MONTAGE</title>
	<link rel="stylesheet" href="montage.css" type="text/css" media="all">
</head>

<body>
	<div id="bloc_page">
		<section>

			<article>
				<video class="vidpic" id="sourcevid"  autoplay="true"></video>
				<p id="message" class="message"></p>
				<div><canvas class="vidpic" id="canvas" width='400' height='300' style='display:inline-block'></canvas></div>

				<div id="buttons" class='fucss'>
					<button class="btn" onclick="open_cam()"><img src="logo_gal/open_cam.svg" alt="open_cam" max-width=100% height=45;></button>
					<button class="btn" onclick="close_cam()"><img src="logo_gal/close_cam.svg" alt="close_cam" max-width=100% height=45;></button>
					<br>
					<button class="btn" onclick="take_picture()"><img src="logo_gal/take_pic.svg" alt="take_pic" max-width=100% height=45;></button>
					<button class="btn" onclick="del()"><img src="logo_gal/trash.svg" alt="delete" max-width=100% height=45;></button>
					<button class="btn" onclick="dl_image()"><img src="logo_gal/save.svg" alt="save" max-width=100% height=45;></button>

					<label for="input" class="label-file"><img src="logo_gal/save_pic.svg" alt="choose_pic" max-width=100% height=45;></label>
					<input id="input" class="input-file" type="file" accept="image/*">
					<button class="btn" onclick="save_image_in_db()"><img src="logo_gal/add_gallery.svg" alt="save_pic" max-width=100% height=45;></button>
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
					$tableau=array("stickers/1.png","stickers/2.png","stickers/3.png","stickers/4.png","stickers/5.png","stickers/6.png","stickers/7.png","stickers/8.png","stickers/9.png","stickers/10.png","stickers/11.png");
					for($i=0;$i<count($tableau);$i++){
				?>
					<div id="bouton<?php echo $i; ?>" onclick="setImage('bouton<?php echo $i; ?>','image<?php echo $i; ?>','<?php echo $tableau[$i]; ?>','<?php echo $tableau[$i]; ?>');">
					<img src="<?php echo $tableau[$i];?>"></div>
					<div id="image<?php echo $i; ?>"></div>
				<?php
					}
				?>
				</div>
			</article>

			<aside id="preview">
			<?php
				$rep = $bdd->prepare('SELECT photo, id FROM photos WHERE author_id=? ORDER BY create_date DESC');
				$rep->execute([$_SESSION['auth']->id]);
				$pic = $rep->fetchAll();
				foreach($pic as $data) {
					echo "<p class='photo_zozor' id='$data->id'>";
					echo "<img src='data:image/jpg;base64, $data->photo' width=500 height=400;/>";
					echo "<button class='delete_preview' onclick='delete_image_in_db($data->id)'><img src='logo_gal/trash.svg' alt='save_pic'></button>";
					echo "</p>";
				}
			?>
			</aside>

		</section>

		<footer>ABOUT AQUAN . SUPPORT . PRESS . API . PRIVACY . TERMS . DIRECTORY . PROFILES . HASHTAGS . LANGUAGE</footer>
	</div>
</body>
<script async src="script.js"></script>
<script src="importation.js"></script>
</html>