/**
 * 	open_cam is a function for open client webcam
 */
function open_cam() {
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

/**
 *	take_picture is a function for take picture from webcam source
 */
function take_picture() {
	var vivi = document.getElementById('sourcevid');
	var canvas = document.getElementById('canvas');
	var ctx = canvas.getContext('2d');
	canvas.height = vivi.videoHeight;
	canvas.width = vivi.videoWidth;
	// console.log(vivi.videoWidth);
	ctx.drawImage(vivi, 0,0, vivi.videoWidth, vivi.videoHeight);
	    var base64=canvas.toDataURL("image/png"); //l'image au format base 64
	//     document.getElementById('tar').value='';
	//     document.getElementById('tar').value=base64;
};

/*
**	dl_image is a function for download image in client pc
*/
function dl_image() {
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

/*
**	save_image_in_db is a function for save image in database
*/
// function save_image_in_db() {
// 	var canvas = document.getElementById('canvas');
// 	var preview = document.getElementById('preview');
// 	var base64 = canvas.toDataURL("image/png");
// 	b64 = base64.split(',')[1];
// 	b64 = encodeURIComponent(b64);
// 	console.log(base64, b64);
// 	// canvas.toBlob(function(blob){envoi(blob)}, 'image/jpeg');
// 	console.log("Les chats c'est mignon !");
// 	req = new XMLHttpRequest();
// 	req.open("POST", "montage.php",  true);
// 	image = "photo=" + b64;
// 	req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
// 	req.onload = function () {
// 		if (req.readyState === req.DONE && req.status === 200) {
// 			res = req.response;
// 			res_data = JSON.parse(res);
// 			html = `<p class='photo_zozor' id=` + res_data.new_pic_id + `>` +
// 			`<img src='data:image/jpg;base64,`+ b64 +`' width=500 height=400;/>` +
// 			`<button class='delete_preview' onclick='delete_image_in_db(` + res_data.new_pic_id + `)'><img src='logo_gal/trash.svg' alt='save_pic'></button>"` +
// 			`</p>`;
// 			preview.insertAdjacentHTML('afterbegin', html);
// 		}
// 	};
// 	req.send(image);
// };
function save_image_in_db() {
	var canvas = document.getElementById('canvas');
	var preview = document.getElementById('preview');
	var base64 = canvas.toDataURL("image/png");
	b64 = base64.split(',')[1];
	b64 = encodeURIComponent(b64);
	console.log(base64, b64);
	// canvas.toBlob(function(blob){envoi(blob)}, 'image/jpeg');
	console.log("Les chats c'est mignon !");
	req = new XMLHttpRequest();
	req.open("POST", "montage.php",  true);
	image = "photo=" + b64;
	req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	req.onload = function () {
		if (req.readyState === req.DONE && req.status === 200) {
			res = req.response;
			res_data = JSON.parse(res);
			html = `<p class='photo_zozor' id=` + res_data.new_pic_id + `>` +
			`<img src='data:image/jpg;base64,`+ b64 +`' width=500 height=400;/>` +
			`<button class='delete_preview' onclick='delete_image_in_db(` + res_data.new_pic_id + `)'><img src='logo_gal/trash.svg' alt='save_pic'></button>` +
			`</p>`;
			preview.insertAdjacentHTML('afterbegin', html);
		}
	};
	req.send(image);
};

function delete_image_in_db(image_id) {
	var data = "pic_id=" + image_id;
	req = new XMLHttpRequest();
	req.open("POST", "delete.php", true);
	req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	req.onload = function () {
		if (req.readyState === req.DONE && req.status === 200) {
			preview_to_delete = document.getElementById(image_id).remove();
		}
	};
	req.send(data);
}

/*
**	close_cam is a function for close webcam
*/
function close_cam() {
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


/**
 *	setImage is a function for add sticker in image
 *
 * @param {it's button id} bouton
 * @param {it's button id} id
 * @param {it's the name of sticker} titre
 * @param {it's the sticker source} srcimage
 */
function setImage(bouton,id,titre,srcimage) {
	var id = document.getElementById(bouton);
	var canvas, context, data;
	var isDraggable = false;
	var image = new Image();
	var currentX = 0;
	var currentY = 0;
	var isactive = false;

	id.addEventListener('click', function(ev) {
		// window.onload =
		// console.log("lol");
				if(!isactive){
		var buttons = document.getElementById("buttons");
		// console.log(buttons);
		buttons.setAttribute('style', "display: flex;");
		isactive = true;
	} else {
		draw();
		ev.preventDefault();}
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

/**
 * del is a function for clean canvas
 */
function del() {
	canvas = document.getElementById('canvas');
	ctx = canvas.getContext('2d');
	ctx.clearRect(0, 0, canvas.width, canvas.height);
};

function enable(){
	var mail = document.getElementById('yes').value;
}