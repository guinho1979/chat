<?php
require_once("".$_SERVER["DOCUMENT_ROOT"]."/funcoes.php");
require_once("".$_SERVER["DOCUMENT_ROOT"]."/mistake.php");
seg($meuid);
$audiom = $_POST['name'];
$audio = $_FILES['file']['tmp_name'];
$who = $_POST["id"];
$path = "msgs/";

move_uploaded_file($audio,$path.$audiom);
$shtxt = "Enviou mensagem de voz : [link=/chat?a=sala&id=$who&audio=/".$path.$audiom."] OUVIR [/link]";
$res = $mistake->prepare("INSERT INTO w_mchat (txt,por,hr,p,schat) VALUES (?, ?, ?, ?,?)");
$arrayName = array($shtxt,$meuid,time(),0,$who);
$ii = 0;
for($i=1; $i <=5; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();