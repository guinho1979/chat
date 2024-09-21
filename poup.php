<?php
require_once("".$_SERVER["DOCUMENT_ROOT"]."/funcoes.php");
if($_GET['id']>0){
$pmnaolidas =  $mistake->prepare("SELECT COUNT(*) FROM w_msgs WHERE pr='".$_GET['id']."' AND ld='0' and dl='0'");
$pmnaolidas->execute();
$pmnaolidas = $pmnaolidas->fetch();
if($pmnaolidas[0]>0){
$aver =  $mistake->query("SELECT por, hr, txt, ld, dl, id FROM w_msgs WHERE pr='".$_GET['id']."' AND ld='0' and dl='0' ORDER BY hr DESC LIMIT 0,1")->fetch();
$textoms= "".substr($aver[2], 0, 50)."";
$unomemn =  $mistake->query("SELECT nm FROM w_usuarios WHERE id='".$aver[0]."'")->fetch();
$lnk = "<div class=\"avisomsj\"><center>".html_entity_decode($unomemn[0])."</a>";
echo "$lnk &emsp;&emsp;<small><br/><font color=\"red\"><b>Nova Mensagem</b></font><br/><a href=\"/mensagens?a=lermsg&id=".$aver[0]."\">$textoms...</a><br>".date("H:i:s", $aver[1])."</small></div></center>"; 
echo "<div style=\"display:none\"><audio src=\"/mensagem1.mp3\" autoplay=true></audio></div>";
} 
}