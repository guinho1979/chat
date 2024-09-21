<?php 
require_once("".$_SERVER["DOCUMENT_ROOT"]."/funcoes.php");
$explode  = explode("-",$_SERVER['REQUEST_URI']); 
if(isset($explode[2])){
$unome =  $mistake->query("SELECT nm,ft FROM w_usuarios WHERE id='".$explode[2]."'")->fetch();
ativo($meuid,'chamada de '.$explode[1].' com '.$unome[0].'');
?>
<!DOCTYPE html><html class="no-js" dir="ltr" loc="pt-BR"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><meta name="theme-color" content="#303030">
<meta name="viewport" content="width=device-width, initial-scale=1.0"><meta http-equiv="x-ua-compatible" content="ie=edge">
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
<title>Chamada de <?php echo html_entity_decode($explode[1], ENT_QUOTES) ?> Com <?php echo html_entity_decode($unome[0], ENT_QUOTES) ?></title>
</head><body>
<style>
body{background-color:navy;}
* {word-wrap:break-word;}
.mistak {padding-top:15%;}
video {max-width: calc(70% - 100px);box-sizing: border-box;border-radius: 2px;padding: 0;box-shadow: rgba(156, 172, 172, 0.2) 0px 2px 2px, rgba(156, 172, 172, 0.2) 0px 4px 4px, rgba(156, 172, 172, 0.2) 0px 8px 8px, rgba(156, 172, 172, 0.2) 0px 16px 16px, rgba(156, 172, 172, 0.2) 0px 32px 32px, rgba(156, 172, 172, 0.2) 0px 64px 64px;}
.avatar{width: 100px;height: 100px;max-width: 100px;max-height: 100px;-webkit-border-radius: 50%;-moz-border-radius: 50%;border-radius: 50%;border: 3px solid rgba(255, 255, 255, 0.5)}
.content {position: absolute;top: 30%;left: 60%;transform: translate(-50%, -50%);line-height: 40px; color: #ecf0f1;height: 60px;overflow: hidden;}
.visible { overflow: hidden; height: 40px; padding: 0 40px;}.visible:before {  content: '['; left: 0;  line-height: 40px;}.visible:after {  content: ']';  position: absolute;  right: 0;  line-height: 40px;}
.visible:after, .visible:before {  position: absolute;  top: 0;  color: #16a085;  font-size: 22px;  animation: 2s linear 0s normal none infinite opacity;}
ul {  margin-top: 0;  padding-left: 110px;  text-align: left;  list-style: none;  animation: 6s linear 0s normal none infinite change;}
ul li {  line-height: 40px;  margin: 0;} @keyframes opacity {  0%, 100% {    opacity: 0;  }  50% {    opacity: 1;  }} @keyframes change {  0%, 12%, 100% {    transform: translateY(0);  }  17%,29% {    transform: translateY(-25%);  }  34%,46% {    transform: translateY(-50%);  }  51%,63% {    transform: translateY(-75%);  }  68%,80% {    transform: translateY(-50%);  }  85%,97% {    transform: translateY(-25%);  }}
.bt3{cursor:pointer;background-color: #eeeeee;background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #eeeeee), color-stop(100%, #cccccc));background-image: -webkit-linear-gradient(top, #eeeeee, #cccccc); background-image: -moz-linear-gradient(top, #eeeeee, #cccccc);background-image: -ms-linear-gradient(top, #eeeeee, #cccccc);background-image: -o-linear-gradient(top, #eeeeee, #cccccc);background-image: linear-gradient(top, #eeeeee, #cccccc);border: 1px solid #ccc;border-bottom: 1px solid #bbb;border-radius: 3px;color: #333;color: #000;padding: 7px 7px 7px 7px;text-decoration: none;margin: 1px;text-shadow: 0 1px 0 #eee;font-weight: 700;vertical-align: middle;display: table-cell;border: 1px solid #CDC9C9;}
</style>  
<script type='text/javascript' src='https://cdn.scaledrone.com/scaledrone.min.js'></script>
<script>
document.onkeydown = function(e) {
if (e.ctrlKey && (e.keyCode === 67 || e.keyCode === 86 || e.keyCode === 85 || e.keyCode === 117 || e.keycode === 17 || e.keycode === 85)) {
alert('Proibida copia deste site va copiar na puta que te pariu.');
}
return false;
};
document.onmousedown=function(e){
if(e.button == 2)   {
alert('Proibida copia deste site va copiar na puta que te pariu.'); 
}
return false; 
};
var tipo = '<?php echo $explode[1];?>';
const roomHash = window.location.hash.substring(1);
const drone = new ScaleDrone('Q1pjlTIpGCUwfVCj');
const roomName = 'observable-' + roomHash;
const configuration = { iceServers: [{ urls: 'stun:stun.l.google.com:19302'}]};
let room;
let pc;
function onSuccess() {
console.log('Conectado');    
}
function onError(error) {
console.error(error);
}
drone.on('open', error => {
if (error) {
return console.error(error);
}
room = drone.subscribe(roomName);
room.on('open', error => {
if (error) {
onError(error);
}
});
room.on('members', members => {
console.log('MEMBERS', members);
const isOfferer = members.length === 2;
startWebRTC(isOfferer);
});
});
function sendMessage(message) {
drone.publish({room: roomName,message});
}
function startWebRTC(isOfferer) {
pc = new RTCPeerConnection(configuration);
pc.onicecandidate = event => {
if (event.candidate) {
sendMessage({'candidate': event.candidate});
}
};
if (isOfferer) {
pc.onnegotiationneeded = () => {
pc.createOffer().then(localDescCreated).catch(onError);
}
}
pc.ontrack = event => {
const stream = event.streams[0];
if (!remoteVideo.srcObject || remoteVideo.srcObject.id !== stream.id) {
remoteVideo.srcObject = stream;
}
};
if(tipo == 'video'){
navigator.mediaDevices.getUserMedia({audio: true,video: true}).then(stream => {
localVideo.srcObject = stream;
stream.getTracks().forEach(track => pc.addTrack(track, stream));
}, onError);
document.getElementById('mediachat-full').innerHTML = "&ensp;<button class='bt3' onclick=\"fscreen('remoteVideo');\"><i class='ion-arrow-expand'></i> Full Screen</button>";
}else{
navigator.mediaDevices.getUserMedia({audio: true,video: false}).then(stream => {
localVideo.srcObject = stream;
stream.getTracks().forEach(track => pc.addTrack(track, stream));
}, onError);
}
room.on('data', (message, client) => {
if (client.id === drone.clientId) {
return;
}
if (message.sdp) {
pc.setRemoteDescription(new RTCSessionDescription(message.sdp), () => {
if (pc.remoteDescription.type === 'offer') {
pc.createAnswer().then(localDescCreated).catch(onError);
}
}, onError);
} else if (message.candidate) {
pc.addIceCandidate(new RTCIceCandidate(message.candidate), onSuccess, onError);
var segundos = 0;
window.setInterval(function() {
document.getElementById('mediachat-time').innerHTML = formatatempo(segundos);
segundos++;
},1000);
document.getElementById("chamadacss").style.display = 'block';	
}
});
}
function localDescCreated(desc) {
pc.setLocalDescription(desc,() => sendMessage({'sdp': pc.localDescription}),onError);
}
function fscreen(miopl) {
var elem = document.getElementById(miopl);
if (elem.requestFullscreen) {
elem.requestFullscreen();
} else if (elem.mozRequestFullScreen) {
elem.mozRequestFullScreen();
} else if (elem.webkitRequestFullscreen) {
elem.webkitRequestFullscreen();
}
}
function formatatempo(segs) {
min = 0;
hr = 0;
while(segs>=60) {
if (segs >=60) {
segs = segs-60;
min = min+1;
}
}
while(min>=60) {
if (min >=60) {
min = min-60;
hr = hr+1;
}
}
if (hr < 10) {
hr = "0"+hr;}
if (min < 10) {
min = "0"+min;
}
if (segs < 10) {
segs = "0"+segs;
}
fin = hr+":"+min+":"+segs;
return fin;
}
</script>
<div class="mistak"><img src="<?php echo $unome[1]==true?$unome[1]:'semfoto.jpg';?>" class="avatar"><br /><br /><div class='content'>
<div id="chamadacss" style="display:none" class='visible'>
<ul>
<li>Conectado Com </li>
<li><?php echo html_entity_decode($unome[0], ENT_QUOTES)?></li></ul>
</div>
</div></div>
<div style="text-align: center;color:white"><span id='mediachat-time'>Conectando</span></div>
<br />
<video id="localVideo" autoplay muted></video>
<video id="remoteVideo" autoplay></video><br />
<br>
<button class="bt3" onclick="window.location.reload();"><i class='ion-android-person'></i>&ensp;Recarregar</button><span id="mediachat-full"></span>&ensp;<button onclick="window.close()" class="bt3"><i class='ion-android-call'></i>&ensp;Desligar</button>
<?
}else{
?>
<div class='error'>Você Não tem nada oque fazer aqui com licença!!!</div>
<?php
}	
?>
</body>
</html>