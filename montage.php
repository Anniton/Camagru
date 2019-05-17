<?php
include_once('navigation.php');
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
  
    <div class="menu">
    
    
    
    </div>
    <div class="content">
    <div style='display:inline-block'>

          <video id="sourcevid" width='400' height='300' autoplay="true"></video>

          <div id="message" style='height:20px;width:350px;margin:5px;'>message:</div>
    </div>
        <canvas id="canvas" width='400'  height='300' style='display:inline-block'></canvas>
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
    <?php $tableau=array("stickers/1.png","stickers/2.png","stickers/3.png","stickers/4.png");
        for($i=0;$i<count($tableau);$i++){?>
        
            <div id="bouton<?php echo $i; ?>"  
			      onclick="setImage('bouton<?php echo $i; ?>','image<?php echo $i; ?>','<?php echo $tableau[$i]; ?>','<?php echo $tableau[$i]; ?>');"> 
            <img src="<?php echo $tableau[$i];?>"></div>
            <div id="image<?php echo $i; ?>"></div>

    <?php } ?>
    </div>


    <div class="footer">ABOUT US . SUPPORT . PRESS . API . JOBS . PRIVACY . TERMS . DIRECTORY . PROFILES . HASHTAGS . LANGUAGE
    </div>
</div>
  
</body>
<script async src="script.js"></script>
<script src="importation.js"></script>

</html>