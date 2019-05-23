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
	}).catch(function(err) {
		console.log(err.name + ": " + err.message);
		document.getElementById("message").innerHTML="message: connection refusé"
	});
};

function photo() {
	var vivi = document.getElementById('sourcevid');
	var canvas = document.getElementById('canvas');
	var ctx = canvas.getContext('2d');
	canvas.height = vivi.videoHeight;
	canvas.width = vivi.videoWidth;
	// console.log(vivi.videoWidth);
	ctx.drawImage(vivi, 0,0, vivi.videoWidth, vivi.videoHeight);
	//     var base64=canvas1.toDataURL("image/png"); //l'image au format base 64
	//     document.getElementById('tar').value='';
	//     document.getElementById('tar').value=base64;
};

function sauver() {
	if(navigator.msSaveOrOpenBlob){
		var blobObject = document.getElementById("canvas").msToBlob()
			window.navigator.msSaveOrOpenBlob(blobObject, "image.png");
	}
	else{
		var canvas = document.getElementById("canvas");
		var elem = document.createElement('a');
		elem.href = canvas.toDataURL("image/png");
		elem.download = "nom.png";
		var evt = new MouseEvent("click", { bubbles: true, cancelable: true, view: window,});
		elem.dispatchEvent(evt);
	}
};

function prepare_envoi() {
	var canvas = document.getElementById('canvas');
	canvas.toBlob(function(blob){envoi(blob)}, 'image/jpeg');
};

function envoi(blob) {

	console.log(blob.type)
	var formImage = new FormData();
	var ajax = new XMLHttpRequest();

	formImage.append('image_a', blob, 'image_a.jpg');
	ajax.open("POST","http://scriptevol.free.fr/contenu/reception/upload_camera.php",true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState == 4 && ajax.status==200) {
			document.getElementById("jaxa").innerHTML+=(ajax.responseText);
		}
	};
	ajax.onerror=function() {
		alert("la requette a échoué")
	};
	ajax.send(formImage);
	console.log("ok");
};

function fermer() {
	var video = document.getElementById('sourcevid');
	var mediaStream = video.srcObject;
	console.log(mediaStream)
	var tracks = mediaStream.getTracks();
	console.log(tracks[0])
	tracks.forEach(function(track) {
		track.stop();
		document.getElementById("message").innerHTML="message: "+tracks[0].label+" déconnecté"
	});
	video.srcObject = null;
};

function setImage(bouton,id,titre,srcimage) {
	var id = document.getElementById(bouton);
	var canvas, context, data;
	var isDraggable = false;
	var image = new Image();
	var currentX = 0;
	var currentY = 0;

	id.addEventListener('click', function(ev) {
		// window.onload =
		draw();
		ev.preventDefault();
	}, false);

	function draw() {
		canvas = document.getElementById('canvas')
		context = canvas.getContext("2d");
		data = context.getImageData(0,0,canvas.width, canvas.height);
		image.onload = function() {
			_Go();
		};
		image.src = srcimage;
	};

	function _Go() {
		_ResetCanvas();
		_DrawImage();
		_MouseEvents();
	};

	function _ResetCanvas(canvas1) {
		context.putImageData(data, 0, 0);
	};

	function _MouseEvents() {
		canvas.onmousedown = function(e) {
			var mouseX = e.pageX - this.offsetLeft;
			var mouseY = e.pageY - this.offsetTop;

			if (mouseX >= (currentX - image.width/2) &&
					mouseX <= (currentX + image.width/2) &&
					mouseY >= (currentY - image.height/2) &&
					mouseY <= (currentY + image.height/2)) {
				isDraggable = true;
			}
		};
		canvas.onmousemove = function(e) {
			if (isDraggable) {
				currentX = e.pageX - this.offsetLeft;
				currentY = e.pageY - this.offsetTop;
				_ResetCanvas();
				_DrawImage();
			}
		};
		canvas.onmouseup = function(e) {
			isDraggable = false;
			_ResetCanvas();
			_DrawImage();
		};
		canvas.onmouseout = function(e) {
			isDraggable = false;
		};
	};

	function _DrawImage() {
		var size = 90;
		var	posX = currentX - (size / 2);
		var posY = currentY - (size / 2);
		if (currentX == 0 && currentY == 0) {
			posX = 0;
			posY = 0;
		}
		context.drawImage(image, posX, posY, size, size);
	};
}

function effacer() {
	canvas = document.getElementById('canvas');
	ctx = canvas.getContext('2d');
	ctx.clearRect(0, 0, canvas.width, canvas.height);
};
