<?php
if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on') {
if(!headers_sent()) {
header("Status: 301 Moved Permanently");
header(sprintf('Location: https://%s%s',$_SERVER['HTTP_HOST'],$_SERVER['REQUEST_URI']));
exit();
}
}
$ativoo = time()-7200;
$itens = $mistake->query("SELECT id,ativo FROM w_usuarios where ativo<'$ativoo' and visitante='1'");
if($itens->rowCount()>0){
while($item = $itens->fetch(PDO::FETCH_OBJ)){
$res = $mistake->exec("DELETE FROM w_usuarios WHERE id='".$item->id."' and visitante='1'");
$res = $mistake->exec("DELETE FROM w_mural WHERE drec='".$item->id."'");
$res = $mistake->exec("DELETE FROM w_depo3 WHERE uid='".$item->id."'");
$res = $mistake->exec("DELETE FROM w_comentarios_p WHERE por='".$item->id."'");
}
}
$itens = $mistake->query("SELECT id,nm FROM w_schat where time<'$ativoo' and tipo='1'");
if($itens->rowCount()>0){
while($item = $itens->fetch(PDO::FETCH_OBJ)){
$res = $mistake->exec("DELETE FROM w_schat WHERE id='".$item->id."' and tipo='1'");
}
}
$cont = $mistake->query("DELETE FROM w_ban WHERE hora<'".time()."'")->fetch();
if($cont[0]>0){
$mistake->exec("DELETE FROM w_ban WHERE hora<'".time()."'");
}
$itens = $mistake->query("SELECT count(*) FROM w_schat where time>'$ativoo' and tipo='1'")->fetch();
//echo $itens[0];
$contu = $mistake->prepare("SELECT COUNT(*) FROM w_usuarios");
$contu->execute();
$contu = $contu->fetch();
$conton = $mistake->prepare("SELECT COUNT(*) FROM w_ochat");
$conton->execute();
$conton = $conton->fetch();
visitas();
?>
<br/>
<center>
<img src="/style/logo.png">
</center>



<div id="titulo">Usuários online (<?php echo $conton[0];?>)</span></div>

<?
$schats = $mistake->query("SELECT id, nm FROM w_schat where tipo='0'");
$i=0; while ($schat = $schats->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div1';?>"><?
$contonc = $mistake->query("SELECT COUNT(*) FROM w_ochat WHERE schat='".$schat->id."'")->fetch();
?>
<a style="font-size: 16px" href="/online/login">
<?php echo $imgsalas;?> <?php echo $schat->nm;?> <span class="badge badge-custom" style="float: right"></span>
<a href="/online/espiar/<?php echo $schat->id;?>" class="btn btn-secondary btn-sm float-right" style="margin-right: 12px"><i class="fas fa-eye" style="color: #ffffff"></i><a></a></li>
</div>
<?
$i++;
}
?>
<br/>
 </ul><div class="col-12 text-center" style="margin-top: 12px">
<b>Últimos Visitantes :</b><br><?
$itens = $mistake->prepare("SELECT * FROM w_usuarios WHERE visitante='1' order by id desc limit 8");
$itens->execute();
$i=0; 
while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<?php echo gerarnome($item->id);?>,
<?php 
$i++;
if($i==3 or $i==6 or $i==9){
?><br/><?
}
}
if($meuid>0){
header("Location:/home?");
}
?>
</span></div><div class="col-12 text-center"></div></section><footer>
<?