
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>TEST</title>
  <link rel="stylesheet" href="montage.css" type="text/css" media="all">	
  <!-- <link rel="stylesheet" href="navigation.css" type="text/css" media="all"> -->
</head>

<body>
<div class = "page_content">
	<h2>Montage</h2>
	<div class="main">
		<div class="images">
				<div class="incrust_image"/>
					<img id="incrust" src="" width="500" height="auto">
				</div>
				<div class="video"  alt="webcam">
				    <video autoplay id="videoElement" width="500" height="auto"></video>
			    </div>
			    <div class="selected_image">
		    		<img id="imgtag" src="" width="500" height="auto"/>
		    	</div>
		    	<div class="resulting_image">
			       	<canvas id="canvas" width="500" height="375"></canvas>
		    	</div>
		</div>
		<div class="boutons_montage">
		        <input type="button" value="Prenez une photo" id="save" />
			    <input id="fileselect" type="file" accept=".png" capture="camera">
		       	<input id="save_to_server" type="submit" value="Enregistrez votre montage">
		</div>
		<div class="miniatures">
		<?php
		require "affiche_miniatures.php";
		?>
		</div>
	</div>
	<div class="side">
			<p>Liste des images déja crées (cliquez sur une image pour la supprimer)</p>
			<?PHP
			listPhotos();
			?>
	</div>
</div>
</body>


<script type="text/javascript">
// var video = document.getElementById('videoElement');
// var video = document.querySelector("#videoElement");
// navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia || navigator.oGetUserMedia;

navigator.mediaDevices.getUserMedia({ audio: false, video: { width: 400 } }).then(function(mediaStream) {

var video = document.getElementById('videoElement');

// if (navigator.getUserMedia) {
    navigator.getUserMedia({video: true}, handleVideo, videoError);
// }


function handleVideo(stream) {
    // video.src = window.URL.createObjectURL(stream);
	video.srcObject = mediaStream;
}
function videoError(e) {
    // no webcam found - do something
    alert("Erreur ! Impossible d'utiliser la caméra...");
}


var v,canvas,context,w,h;
var imgtag = document.getElementById('imgtag');
var imgtagsrc_initial = imgtag.src;
var sel = document.getElementById('fileselect');
var incrust = document.getElementById('incrust');
document.addEventListener('DOMContentLoaded', function(){
	// au chargement du DOM, afficher la video dans le canvas
    v = document.getElementById('videoElement');
    canvas = document.getElementById('canvas');
    context = canvas.getContext('2d');
    w = canvas.width;
    h = canvas.height;
},false);
function draw(v,c,w,h) {
	if(v.paused || v.ended) return false;
	// affiche le cliche de la video dans le canvas
    context.drawImage(v,0,0,w,h);
    var uri = canvas.toDataURL("image/png");
	// et met l'image obtenue dans imtag
    imgtag.src = uri;
}
var save=document.getElementById('save');
save.addEventListener('click',function(e){
		// affiche le cliche de la video dans le canvas
        draw(v,context,w,h);
		
		// afficher l'image
        imgtag.style.display='initial';
});
var save_to_server=document.getElementById('save_to_server');
save_to_server.addEventListener('click',function(e){
	// ici, on a une image d'incrustation et une image dans le imgtag
	// => les envoyer au serveur
	if (imgtag.src !== imgtagsrc_initial) // on n'envoie que si une image a ete prise
	{
		var xhr = new XMLHttpRequest();
		xhr.open('POST', '../control/generate_image.php', true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr.onreadystatechange = function() {
	            if (this.readyState == 4 && this.status == 200) {
					console.log(this.responseText);
					window.location.pathname = '/camagru/view/montage.php';
	            }
	        };
		var params = 'image='+imgtag.src+'&image_incrustee='+incrust.src;
		console.log(params);
		xhr.send(params);
	}
	else
		alert("Veuillez prendre une photo ou selectionner un fichier");
});
var fr;
sel.addEventListener('change',function(e) {
    var f = sel.files[0];
	var extensions_ok		= 'png'; // n'autoriser que les png
	var file_name			= f.name.toLowerCase(); // nom du fichier 
	if(file_name!='') {
		var file_array 		= file_name.split('.');
		var file_extension	= file_array[file_array.length-1]; // extension du fichier (dernier élément)
		if(extensions_ok.indexOf(file_extension)===-1) { 
			alert('Type de fichier incorrect');
		}
		else {
			fr = new FileReader();
			fr.onload = receivedData;
			fr.readAsDataURL(f);
			
			// cacher la video
			video.style.display='none';
			imgtag.style.display='initial';
		}
	}
});
function receivedData() {
      imgtag.src = fr.result;
}
function select_image(elem){
	console.log("selection d une image");
	incrust.style.display='initial';
    incrust.src=elem.src;
    save_to_server.style.display='initial'; // afficher le bouton pour sauver le montage
}
function delete_image(elem) {
	if (elem) {
		if (confirm("Voulez vous supprimer cette image ?")){
			//console.log("Suppression d'une image");
			var xhr = new XMLHttpRequest();
			xhr.open('POST', '../control/delete_image.php', true);
			xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			xhr.onreadystatechange = function() {
	        	if (this.readyState == 4 && this.status == 200) {
					console.log(this.responseText);
					window.location.pathname = '/camagru/view/montage.php';
	 	       	}
	 	    };
			var params = 'image_name='+elem.src;
			xhr.send(params);
			// elem.parentNode.removeChild(elem);
		}
	}
}	
</script>