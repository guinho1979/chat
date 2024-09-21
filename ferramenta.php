<?php
require ("".$_SERVER["DOCUMENT_ROOT"]."/img.php");
$conton = $mistake->query("SELECT COUNT(*) FROM w_ochat WHERE schat='$id'")->fetch();
$nmsala = $mistake->query("SELECT nm FROM w_schat WHERE id='$id'")->fetch();
$dono = $mistake->query("SELECT dn FROM w_schat WHERE tipo='1' and id='$id'")->fetch();
$tipo = $mistake->query("SELECT visitante FROM w_usuarios WHERE id='$meuid'")->fetch();
$umsg = $mistake->prepare("SELECT COUNT(*) FROM w_msgs WHERE pr='$meuid' AND ld='0' and dl='0'");
$umsg->execute();
$umsg = $umsg->fetch();
$umsg2 = $mistake->prepare("SELECT COUNT(*) FROM w_msgs WHERE pr='$meuid' AND ld='0' and dl='1'");
$umsg2->execute();
$umsg2 = $umsg2->fetch();
$reqs = $mistake->prepare("SELECT COUNT(*) FROM w_amigos WHERE tid='$meuid' AND ac='0'");
$reqs->execute();
$reqs = $reqs->fetch();
if($reqs[0]==0){
$imga1="<a href='/amigos?' ".$amigos."</a>";
}
if($reqs[0]>0){
$imga1="<a href='/amigos/pedidos' ".$amigos." &nbsp;<span class='pms pmsn'>$reqs[0]</span></a>";
}
?>
<hr><a class="notification" style="margin: 0 8px" href="/chat?a=usuarios&id=<?php echo $id;?>"><?php echo $imgonline;?><span class="badge badge-danger badge-notification users-number" style="font-size: 10px"><?php echo $conton[0];?></span></a>
<a style="margin: 0 8px" href="radio.php" target="_blank"><?php echo $imgradio;?></a>
<a style="margin: 0 8px" href="configuracoes.php"><?php echo $imgpreferencias;?></a><?
if($tipo[0]==0){
?><a style="margin: 0 8px" href="entretenimento/diversao"><?php echo $imgjogos;?></a> 
<a class="notification" style="margin: 0 8px" href="/mensagens1/entrada"><?php echo $imgmensagem;?><span class="badge badge-danger badge-notification users-number" style="font-size: 10px"><?php echo $umsg[0];?></a> 
<a class="notification" style="margin: 0 8px" href="/mensagens/coletiva"><?php echo $imgmnot;?><span class="badge badge-danger badge-notification users-number" style="font-size: 10px"><?php echo $umsg2[0];?></a>
<a style="margin: 0 8px">
<?php echo $imga1;?></span>
<?php
}
?>