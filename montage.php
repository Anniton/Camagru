<!-- <php?
if(session_start() == FALSE)
	return ;
	
if (isset($_SESSION['pseudo']) && !empty($_SESSION['pseudo'])) {
    header('Location: index.php');
    exit();
    include('header.php');
}
?> -->

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Camagru</title>
  <link rel="stylesheet" href="montage.css" type="text/css" media="all">	
  <!-- <link rel="stylesheet" href="navigation.css" type="text/css" media="all"> -->
</head>

<body>

<div class="container">
    <div class="navigation"> 
    <?php include('navigation.php'); ?>

    </div>
    <div class="menu">
 
      <canvas id="canvas2"></canvas>
       <!-- <div class="output">
             <img id="photo" alt="The screen capture will appear in this box.">
              
            </div> -->
    </div>
    <div class="content">
          
        <div class="camera">
          <video id="video">Video stream not available.</video>
        
          <button class="button" id="startbutton">Take Photo</button>
          <button class="button" id="toggle">pause</button>

        
        </div>
          <canvas id="canvas"></canvas>
          <div class="test">
          <button class="button" id="deletebutton">Delete Photo</button>
          <input class ="" type="file" id="input" accept="image/*">
          <!-- <button class="button" id="importbutton">import Photo</button> -->
          </div>
    </div>


    <div class="img_stickers">
      <div><img src="stickers/1.png" onclick="setStickers('stickers/1.png')" class="stickers" id="source" alt="dubitatif"></div>
      <div><button class="stickers" id="stickersbutton2"><img src="stickers/2.png" class="stickers" id="can_sticker" alt="blase">
      </div></button>
      <div><button class="stickers" id="stickersbutton3"><img src="stickers/3.png" class="stickers" id="can_sticker" alt="intello"></div></button>
      <div><button class="stickers" id="stickersbutton4"><img src="stickers/4.png" class="stickers" id="can_sticker" alt="wesh"></div></button>
    </div>


    <div class="footer">ABOUT US . SUPPORT . PRESS . API . JOBS . PRIVACY . TERMS . DIRECTORY . PROFILES . HASHTAGS . LANGUAGE
    </div>
</div>
  
<!-- 

 <div style='display:inline-block'>

     <video id="sourcevid" width='400' autoplay="true"></video>

     <div id="message" style='height:20px;width:350px;margin:5px;'>message:</div>
    </div>

    <canvas id="cvs" style='display:inline-block'></canvas>

    <div>
     <button onclick='ouvrir_camera()' >ouvrir camera</button>
     <button onclick='fermer()' >fermer camera</button>
     <br>
     <button onclick='photo()' >prise de photo</button>
     <button onclick='sauver()' >sauvegarder</button>
     <button onclick='prepare_envoi()' >envoyer</button>
    </div>

    <div id="jaxa" style='width:80%;margin:5px;'>message:</div>
 -->

</body>
<script src="script.js"></script>
<script src="importation.js"></script>
</html>

<!-- 
// envois de l'image au canvas
image.width = video.videoWidth;
image.height = video.videoHeight;
image.getContext('2d').drawImage(video, 0, 0);

// récupération du contenue du canvas sous la forme d'une string
var img_string = image.toDataURL('image/png', 0)
img_string = img_string.replace("data:image/png base64;", "");

// création d'un formulaire pour l'envois en POST
var formul = document.createElement('form');
formul.setAttribute('method', 'POST');
formul.setAttribute('action', "");

// création du input pour l’envoie de la string
var champCache = document.createElement('input');
champCache.setAttribute('type', 'hidden');
champCache.setAttribute('name', 'image');
champCache.setAttribute('value', img_string);
formul.appendChild(champCache);

// envois du formulaire
document.body.appendChild(formul);
formul.submit();

https://developer.mozilla.org/fr/docs/Apprendre/JavaScript/Client-side_web_APIs/Client-side_storage