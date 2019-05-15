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
    <div class="navigation"><?php include('navigation.php'); ?></div>
    <div class="menu">
    
    
    
    </div>
    <div class="content">
    <div style='display:inline-block'>

          <video id="sourcevid" width='400' autoplay="true"></video>

          <div id="message" style='height:20px;width:350px;margin:5px;'>message:</div>
          </div>

          <canvas id="canvas" style='display:inline-block'></canvas>

          <div>
          <button onclick='ouvrir_camera()' >ouvrir camera</button>
          <button onclick='fermer()' >fermer camera</button>
          <br>
          <button onclick='photo()' >prise de photo</button>
          <button onclick='sauver()' >sauvegarder</button>
          <button onclick='prepare_envoi()' >envoyer</button>
          </div>

          <!-- <div id="jaxa" style='width:80%;margin:5px;'>message:</div> -->

     
    </div>


    <div class="img_stickers">


    <?php foreach ($stickers as $stick) {
                        if ($stick == "." || $stick == "..")
                            continue;
                        else {
                        ?> <img name="stick"class="stick", src="stickers/<?php echo $stick;?>">
                        <?php }
                        } ?>

      <div><button class="stickers" id="stickersbutton1"><img src="stickers/1.png" class="stickers" id="can_sticker" alt="blase">
      </div></button>
      <div><button class="stickers" id="stickersbutton2"><img src="stickers/2.png" class="stickers" id="can_sticker" alt="blase">
      </div></button>
      <div><button class="stickers" id="stickersbutton3"><img src="stickers/3.png" class="stickers" id="can_sticker" alt="intello"></div></button>
      <div><button class="stickers" id="stickersbutton4"><img src="stickers/4.png" class="stickers" id="can_sticker" alt="wesh"></div></button>
    </div>


    <div class="footer">ABOUT US . SUPPORT . PRESS . API . JOBS . PRIVACY . TERMS . DIRECTORY . PROFILES . HASHTAGS . LANGUAGE
    </div>
</div>
  
</body>
<!-- <script async src="script.js"></script> -->
<!-- <script src="importation.js"></script> -->

<script>
function ouvrir_camera() {

navigator.mediaDevices.getUserMedia({ audio: false, video: { width: 400 } }).then(function(mediaStream) {

var video = document.getElementById('sourcevid');
video.srcObject = mediaStream;

var tracks = mediaStream.getTracks();

document.getElementById("message").innerHTML="message: "+tracks[0].label+" connecté"

console.log(tracks[0].label)
console.log(mediaStream)

video.onloadedmetadata = function(e) {
video.play();
};

}).catch(function(err) { console.log(err.name + ": " + err.message);
document.getElementById("message").innerHTML="message: connection refusé"});
};

function photo(){
var vivi = document.getElementById('sourcevid');
//var canvas1 = document.createElement('canvas');
var canvas1 = document.getElementById('canvas')
var ctx = canvas1.getContext('2d');
canvas1.height=vivi.videoHeight
canvas1.width=vivi.videoWidth
console.log(vivi.videoWidth)
ctx.drawImage(vivi, 0,0, vivi.videoWidth, vivi.videoHeight);

//var base64=canvas1.toDataURL("image/png"); //l'image au format base 64
//document.getElementById('tar').value='';
//document.getElementById('tar').value=base64;
};

function sauver(){
        if(navigator.msSaveOrOpenBlob){
        var blobObject=document.getElementById("canvas").msToBlob()
        window.navigator.msSaveOrOpenBlob(blobObject, "image.png");
        }
        else{
        var canvas = document.getElementById("canvas");
        var elem = document.createElement('a');
        elem.href = canvas.toDataURL("image/png");
        elem.download = "nom.png";
        var evt = new MouseEvent("click", { bubbles: true,cancelable: true,view: window,});
        elem.dispatchEvent(evt);
        }
};

function prepare_envoi(){
    var canvas = document.getElementById('canvas');
    canvas.toBlob(function(blob){envoi(blob)}, 'image/jpeg');
};


function envoi(blob){

        console.log(blob.type)

        var formImage = new FormData();
        formImage.append('image_a', blob, 'image_a.jpg');

        var ajax = new XMLHttpRequest();

        ajax.open("POST","http://scriptevol.free.fr/contenu/reception/upload_camera.php",true);

        ajax.onreadystatechange=function(){

        if (ajax.readyState == 4 && ajax.status==200){

        document.getElementById("jaxa").innerHTML+=(ajax.responseText);
        }
};

ajax.onerror=function(){
        alert("la requette a échoué")
};

ajax.send(formImage);
console.log("ok");
};


function fermer(){

var video = document.getElementById('sourcevid');
var mediaStream=video.srcObject;
console.log(mediaStream)
var tracks = mediaStream.getTracks();
console.log(tracks[0])
tracks.forEach(function(track) {
track.stop();
document.getElementById("message").innerHTML="message: "+tracks[0].label+" déconnecté"
});
video.srcObject = null;
}

let stick = document.getElementsByClassName('stick');
for (let i=0; i < stick.length; i++)
{
    stick[i].addEventListener('click', function() {
        let sticker = document.querySelector('.sticked');
        let button = document.getElementsByClassName("test");
        if (button[0]) {
            button[0].disabled = false;
        }
        sticker.setAttribute('src', this.src);
        dragElement(sticker);
    });
}

if (canvas){
  var id = document.getElementById('stickersbutton1');
  var sticker;
  id.addEventListener('click', function(ev){
      draw();
      ev.preventDefault();
    }, false);
}
function draw(nm) {
var a = document.getElementById('canvas')
var ctx = a.getContext("2d");
var image = new Image();

image.src = 'stickers/1.png';
image.onload = function(){
   sticker = ctx.drawImage(this,0,0,50,50);
};

}

</script>


</html>
