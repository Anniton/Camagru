(function() {


  // The width and height of the captured photo. We will set the
  // width to the value defined here, but the height will be
  // calculated based on the aspect ratio of the input stream.

  var width = 400;    // We will scale the photo width to this
  var height = 0;     // This will be computed based on the input stream

  // |streaming| indicates whether or not we're currently streaming
  // video from the camera. Obviously, we start at false.

  var streaming = false;

  // The various HTML elements we need to configure or control. These
  // will be set by the startup() function.

  var video = null;
  var canvas = null;
  var photo = null;
  var startbutton = null;
  var deletebutton = null;

  function startup() {
    video = document.getElementById('video');
    canvas = document.getElementById('canvas');
    photo = document.getElementById('photo');
    startbutton = document.getElementById('startbutton');
    deletebutton = document.getElementById('deletebutton');

    navigator.mediaDevices.getUserMedia({video: true, audio: false})
    .then(function(stream) {
      video.srcObject = stream;
      video.play();
    })
    .catch(function(err) {
      console.log("An error occurred: " + err);
    });

    video.addEventListener('canplay', function(ev){
      if (!streaming) {
        height = video.videoHeight / (video.videoWidth/width);
      
        // Firefox currently has a bug where the height can't be read from
        // the video, so we will make assumptions if this happens.
      
        if (isNaN(height)) {
          height = width / (4/3);
        }
      
        video.setAttribute('width', width);
        video.setAttribute('height', height);
        canvas.setAttribute('width', width);
        canvas.setAttribute('height', height);
        streaming = true;
      }
    }, false);

// function  searchid(){
//   if (document.getElementsById('stickersbutton1')){
//     return('stickersbutton1');}
//   else if (document.getElementsById('stickersbutton2')){
//     return('stickersbutton2');}
//   else if (document.getElementsById('stickersbutton3')){
//     return('stickersbutton3');}
//   else if (document.getElementsById('stickersbutton4')){
//     return('stickersbutton4');}
 //}

if (canvas2){
  var id = null;
  //console.log(id);
  var num = null;
  if (id == document.getElementById('stickersbutton1')){
    num = 1;}  
  else if (id == document.getElementById('stickersbutton2')){
    num = 2;}
  else if (id == document.getElementById('stickersbutton3')){
    num = 3;}
  else if (id == document.getElementById('stickersbutton4')){
    num = 4;}
  else if (id == null){
      id = document.getElementById('stickersbutton1');
      num = 1;}
  console.log(id);
 id.addEventListener('click', function(ev){
      draw(num);
      ev.preventDefault();
    }, false);
}
function draw(num) {
var a = document.getElementById('canvas')
var ctx = a.getContext("2d");
var image = new Image();

image.src = 'stickers/'+ num +'.png';
image.onload = function() {
  ctx.drawImage(this,0,0,50,50);
};
// ctx.beginPath();
// ctx.strokeStyle = "#369";
// ctx.fillStyle="#c00";
// ctx.arc(140,130,30,0,Math.PI*2,false);
// ctx.stroke();
}


  startbutton.addEventListener('click', function(ev){
      takepicture();
      ev.preventDefault();
    }, false);
   deletebutton.addEventListener('click', function(ev){
      clearphoto();
      ev.preventDefault();
    }, false);
    
  }

  // Fill the photo with an indication that none has been
  // captured.

  function clearphoto() {
    var context = canvas.getContext('2d');
    context.fillStyle = "#ffffff";
    context.fillRect(0, 0, canvas.width, canvas.height);

    var data = canvas.toDataURL('image/png');
    if(photo){
    photo.setAttribute('src', data);}
  }
  
  // Capture a photo by fetching the current contents of the video
  // and drawing it into a canvas, then converting that to a PNG
  // format data URL. By drawing it on an offscreen canvas and then
  // drawing that to the screen, we can change its size and/or apply
  // other changes before drawing it.

  function takepicture() {
    var context = canvas.getContext('2d');
    if (width && height) {
      canvas.width = width;
      canvas.height = height;
      context.drawImage(video, 0, 0, width, height);
    
      var data = canvas.toDataURL('image/png');
      if (photo){
      photo.setAttribute('src', data);}
    // } else {
    //   clearphoto();
    }
  }
window.addEventListener('load', startup, false);

}());


// var toggle = document.getElementById("toggle")
//  toggle.addEventListener('click', function(ev){
//       toggle;
//       ev.preventDefault();
//     }, false);

// function toggle() {
//   var video = document.querySelector('video');
//   video.paused ? video.play() : video.pause();
// }



//     function ouvrir_camera() {

//      navigator.mediaDevices.getUserMedia({ audio: false, video: { width: 400 } }).then(function(mediaStream) {

//       var video = document.getElementById('sourcevid');
//       video.srcObject = mediaStream;

//       var tracks = mediaStream.getTracks();

//       document.getElementById("message").innerHTML="message: "+tracks[0].label+" connecté"

//       console.log(tracks[0].label)
//       console.log(mediaStream)

//       video.onloadedmetadata = function(e) {
//        video.play();
//       };
       
//      }).catch(function(err) { console.log(err.name + ": " + err.message);

//      document.getElementById("message").innerHTML="message: connection refusé"});
//     }

    // function photo(){

    //  var vivi = document.getElementById('sourcevid');
    //  //var canvas1 = document.createElement('canvas');
    //  var canvas1 = document.getElementById('cvs')
    //  var ctx =canvas1.getContext('2d');
    //  canvas1.height=vivi.videoHeight
    //  canvas1.width=vivi.videoWidth
    //  console.log(vivi.videoWidth)
    //  ctx.drawImage(vivi, 0,0, vivi.videoWidth, vivi.videoHeight);

    //  //var base64=canvas1.toDataURL("image/png"); //l'image au format base 64
    //  //document.getElementById('tar').value='';
    //  //document.getElementById('tar').value=base64;
    // }

    // function sauver(){

    //  if(navigator.msSaveOrOpenBlob){

    //   var blobObject=document.getElementById("cvs").msToBlob()

    //   window.navigator.msSaveOrOpenBlob(blobObject, "image.png");
    //  }

    //  else{

    //   var canvas = document.getElementById("cvs");
    //   var elem = document.createElement('a');
    //   elem.href = canvas.toDataURL("image/png");
    //   elem.download = "nom.png";
    //   var evt = new MouseEvent("click", { bubbles: true,cancelable: true,view: window,});
    //   elem.dispatchEvent(evt);
    //  }
    // }

    // function prepare_envoi(){

    //  var canvas = document.getElementById('cvs');
    //  canvas.toBlob(function(blob){envoi(blob)}, 'image/jpeg');
    // }
    
    
    // function envoi(blob){

    //  console.log(blob.type)

    //  var formImage = new FormData();
    //  formImage.append('image_a', blob, 'image_a.jpg');

    //  var ajax = new XMLHttpRequest();

    //  ajax.open("POST","http://scriptevol.free.fr/contenu/reception/upload_camera.php",true);

    //  ajax.onreadystatechange=function(){

    //   if (ajax.readyState == 4 && ajax.status==200){

    //    document.getElementById("jaxa").innerHTML+=(ajax.responseText);
    //   }
    //  }

    //  ajax.onerror=function(){

    //   alert("la requette a échoué")
    //  }

    //  ajax.send(formImage);
    //  console.log("ok")
    // }

    
//     function fermer(){

//      var video = document.getElementById('sourcevid');
//      var mediaStream=video.srcObject;
//      console.log(mediaStream)
//      var tracks = mediaStream.getTracks();
//      console.log(tracks[0])
//      tracks.forEach(function(track) {
//       track.stop();
//       document.getElementById("message").innerHTML="message: "+tracks[0].label+" déconnecté"
//      });

//      video.srcObject = null;
//     }


// })();