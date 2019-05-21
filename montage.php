<?php include_once('navigation.php'); ?>
<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>MONTAGE</title>
		<link rel="stylesheet" href="montage.css" type="text/css" media="all">
  <link rel="stylesheet" href="montage.css" type="text/css" media="all">
		<link rel="stylesheet" href="montage.css" type="text/css" media="all">
  <link rel="stylesheet" href="montage.css" type="text/css" media="all">
		<link rel="stylesheet" href="montage.css" type="text/css" media="all">
	</head>

<body>

	<div class="container">
		<div class="menu"></div>

		<div class="content">
            <div class="orga">
                <video class="vidpic" id="sourcevid" width='400' height='300' autoplay="true"></video>
                <p class="message">message:</p>
			<div>
			<canvas class="vidpic" id="canvas" width='400'  height='300' style='display:inline-block'></canvas></div>
		</div>

		<div>
			<button onclick="ouvrir_camera()">ouvrir camera</button>
			<button onclick="fermer()">fermer camera</button>
			<br>
			<button onclick="photo()">prise de photo</button>
			<button onclick="sauver()">sauvegarder</button>
			<button onclick="effacer()">effacer photo</button>
			<button onclick="prepare_envoi()">envoyer</button>
		</div>
        <!-- <div id="jaxa" style='width:80%;margin:5px;'>message:</div> -->
    </div>


    <div class="img_stickers">
		<?php
			$tableau=array("stickers/1.png","stickers/2.png","stickers/3.png","stickers/4.png");
			for($i=0;$i<count($tableau);$i++) {
				echo "<div id='bouton$i' onclick='setImage('bouton$i','image$i','$tableau[$i]','$tableau[$i]');'>";
				echo "<img src='$tableau[$i]'>";
				echo "</div>";
				echo "<div id='image$i'></div>";
			}
		?>
    </div>

    <div class="footer">ABOUT US . SUPPORT . PRESS . API . JOBS . PRIVACY . TERMS . DIRECTORY . PROFILES . HASHTAGS . LANGUAGE</div>
</div>

</body>
<script async src="script.js"></script>
<script src="importation.js"></script>
</html>