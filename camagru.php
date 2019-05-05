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
  <link rel="stylesheet" href="camagru.css" type="text/css" media="all">	
</head>

<body>
<div class="container">
    <div class="header"></div>
    <div class="menu">
 
      <canvas id="canvas2"></canvas>
       <div class="output">
             <img id="photo" alt="The screen capture will appear in this box.">
              
            </div>
    </div>
    <div class="content">
          
        <div class="camera">
          <video id="video">Video stream not available.</video>
        
          <button class="button" id="startbutton">Take Photo</button>

        
        </div>
          <canvas id="canvas"></canvas>
          <button class="button" id="deletebutton">Delete Photo</button>
           
    </div>


    <div class="img_stickers">
      <div><button class="button" id="stickersbutton"><img src="stickers/dubitatif.png" class="stickers" id="source" alt="dubitatif"></div></button>
      <div><img src="stickers/blase.png" class="stickers" id="can_sticker" alt="blase">
      </div>
      <div><img src="stickers/intello.png" class="stickers" id="can_sticker" alt="intello"></div>
      <div><img src="stickers/wesh.png" class="stickers" id="can_sticker" alt="wesh"></div>
    </div>


    <div class="footer">ABOUT US . SUPPORT . PRESS . API . JOBS . PRIVACY . TERMS . DIRECTORY . PROFILES . HASHTAGS . LANGUAGE
    </div>
</div>
  


</body>
<script src="script.js"></script>
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
formul.submit(); -->