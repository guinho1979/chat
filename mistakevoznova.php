<?php
require_once("".$_SERVER["DOCUMENT_ROOT"]."/funcoes.php");
require_once("".$_SERVER["DOCUMENT_ROOT"]."/mistake.php");
seg($meuid);
$audiom = $_POST['name'];
$audio = $_FILES['file']['tmp_name'];
$who = $_POST["id"];
$path = "msgs/";
if($_POST["id"]){
move_uploaded_file($audio,$path.$audiom);
$shtxt = "Voz https://".$_SERVER['SERVER_NAME']."/".$path.$audiom."";
$res = $mistake->prepare("INSERT INTO  w_msgs (txt,por,pr,hr) VALUES (?, ?, ?, ?)");
$arrayName = array($shtxt,$meuid,$who,time());
$ii = 0;
for($i=1; $i <=4; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
}
if($_POST["hall"]){
move_uploaded_file($audio,$path.$audiom);
$shtxt = "Voz https://".$_SERVER['SERVER_NAME']."/".$path.$audiom."";
$res = $mistake->prepare("INSERT INTO w_mural (rec,drec,hora,tipo) VALUES (?, ?, ?, ?)");
$arrayName = array($shtxt,$meuid,time(),5);
$ii = 0;
for($i=1; $i <=4; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
}
/*
foreach(array('video','audio') as $type) {
if (isset($_FILES["${type}-blob"])) {
$who = $_POST["${type}-US"];
$fileName = $_POST["${type}-name"];
$uploadDirectory = "msgs/$fileName";
$filename = $fileName;
if($who!="" && $type=="audio"){
//exec("ffmpeg -i ".$_FILES["${type}-blob"]["tmp_name"]." ".$uploadDirectory."");
move_uploaded_file($_FILES["${type}-blob"]["tmp_name"], $uploadDirectory);
$shtxt = "Voz[br/]<audio controls src='/msgs/$filename'></audio>";
$res = $mistake->prepare("INSERT INTO  w_msgs (txt,por,pr,hr) VALUES (?, ?, ?, ?)");
$arrayName = array($shtxt,$meuid,$who,time());
$ii = 0;
for($i=1; $i <=4; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
}
}
}
*/
?>