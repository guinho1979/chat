<?php
require_once("".$_SERVER["DOCUMENT_ROOT"]."/funcoes.php");
require_once("".$_SERVER["DOCUMENT_ROOT"]."/mistake.php");
require_once("".$_SERVER["DOCUMENT_ROOT"]."/emoji.php");
//require_once("".$_SERVER["DOCUMENT_ROOT"]."/tema.php");

seg($meuid);
$ban = $mistake->query("SELECT count(*) FROM w_ban WHERE tipo='2' and uid='$meuid'")->fetch();
if($ban[0]>0) {
$ban1 = $mistake->query("SELECT hora FROM w_ban WHERE tipo='2' and uid='$meuid'")->fetch();
$tempo = gerartempo($ban1[0] - time());
?>
<br/><div align="center"><?php echo $imgerro;?>Você foi bloqueado para acessar o chat, seu ban irá terminar em <?php echo $tempo;?> <br/><br/>

<div class="col-12 text-center" style="margin-top: 20px"><a href="javascript:window.history.back();"><?php echo $imgsetavoltar;?> Voltar</a></div><br/>
<?php
rodape();
exit(); }
if($a==false) {
?>


<header> <nav class="navbar" style="margin-bottom: 20px"></header><?

ativo($meuid,'Salas de chat ');

$mistake->exec("DELETE FROM w_ochat WHERE uid='$meuid'");
?>
<section class="container-fluid">
<h2 class="title" style="font-size: 24px">
<div id="titulo">Salas Privadas<a class="btn btn-light btn-sm float-right" href="chat?a=criar">Criar Sala</a></h2></div>

<?
$schats = $mistake->query("SELECT id, nm,dn FROM w_schat where tipo='1'");
if($schats->rowCount()>0){
$i=0; while ($schat = $schats->fetch(PDO::FETCH_OBJ)) {
$conta = $mistake->query("SELECT COUNT(*) FROM perm_sala WHERE sala='$schat->id' and uid='$meuid'")->fetch();
$contonc = $mistake->query("SELECT COUNT(*) FROM w_ochat WHERE schat='".$schat->id."'")->fetch();
?><li class="list-group-item"><div id="<?php echo $i%2==0?'div1':'div1';?>"><?if($conta[0]>0 or $schat->dn==$meuid){?><a style="font-size: 16px" href="/chat?a=sala&id=<?php echo $schat->id;?>"><i class="fas fa-lock-open" style="color: #B18904"></i><?php echo $schat->nm;?></span></a><?}else{?><i class="fas fa-lock" style="color: #00587C"></i> <?php echo $schat->nm;?><span class="badge badge-light" style="float: right"><font color="red"><?php echo $contonc[0];?></font></a>
</span><?}?></li><?
$i++;
}

}else{
?>
<div class="col-12"><div class="card shadow"><div class="card-body">Nenhuma sala privada.</div></div></div>
<?php
}
?></ul>
<br/>
<center><a href="/home">Sair</a></center>


<?php
}
else if($a=='editar'){
$sala = $mistake->query("SELECT nm,dn FROM w_schat WHERE tipo='1' and id='$id'")->fetch();
$conta = $mistake->query("SELECT COUNT(*) FROM w_schat WHERE nm='".$_POST['sala']."'")->fetch();
if($sala[1]!=$meuid){
header("Location:/chat?a=sala&id=".$id."");
}
?>
<header><nav class="navbar navbar-light bg-light" style="margin-bottom: 20px"><a class="navbar-brand" href="#"><img src="/style/<?php echo $testearray[30];?>" width="32" height="" alt=""></a><ul class="nav navbar-nav navbar-right user-menu"></ul></header>
<section class="container-fluid"><h2 class="title"><b>Editar sala</b></h2><div class="col-12"><div class="col-12 text-center"><span>Sala </span><b><?php echo $sala[0];?></b><br><a href="/chat?a=editar&id=<?php echo $id;?>&acao=apagar" class="btn btn-outline-danger btn-sm"><i class="fas fa-trash"></i> Excluir</a></div><?
if($_SERVER['REQUEST_METHOD'] == 'POST') {
if($conta[0]>0 or empty($_POST['sala'])){
echo $imgerro;?>
Já existe uma sala com esse nome!<br/>
<?php
}else{
$mistake->exec("update w_schat set nm='".$_POST['sala']."' where id='$id'");
header("Location:/chat?a=sala&id=".$id."");
}
}
?>
<form action="/chat?a=editar&id=<?php echo $id;?>" method="post"><div class="form-group">
<label>Nome da Sala</label><input type="text" class="form-control" name="sala"></div><button type="submit" class="btn btn-primary btn-sm active btn-block" role="button" aria-pressed="true">Editar</button></form></div><div class="col-12 text-center" style="margin-top: 20px"><a href="/chat?a=sala&id=<?php echo $id;?>"><?php echo $imgsetavoltar;?> Voltar</a></div> </section>
<?
}
else if($a=='convidarusuario') { ?>
<header><nav class="navbar navbar-light bg-light" style="margin-bottom: 20px"><a class="navbar-brand" href="#"><img src="/style/<?php echo $testearray[30];?>" width="32" height="" alt=""></a></nav></header>
<section class="container-fluid"><h2 class="title"><b>Convidar usuário</b></h2>
<?php
$dn = $mistake->query("SELECT dn FROM w_schat WHERE tipo='1' and id='$id'")->fetch();
if(perm($meuid)>0 or $dn[0]==$meuid){
if($_GET['acao']==true){
$res = $mistake->exec("INSERT INTO perm_sala (uid,sala) values('".$_GET['user']."','".$id."')");
$msg = "Olá te convidei pra minha sala privada  [link=/chat?a=sala&id=$id]CLIQUE AQUI PARA ENTRAR[/link]";
automsg($msg,$meuid,$_GET['user']);
}
}
if($_GET['acao']=='desbloquear' && perm($meuid)>0){
$mistake->exec("DELETE FROM w_ubloq WHERE uid='".$meuid."' and aid='".$_GET['user']."'");
}
$contemo = $mistake->query("SELECT COUNT(*) FROM w_ochat WHERE schat='".$_GET['sala']."'")->fetch();

if($pag=='' || $pag<=0)$pag=1;
$numitens = $contemo[0];
$itensporpag = 5000;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->query("SELECT uid FROM w_ochat WHERE schat='".$_GET['sala']."' ORDER BY id asc LIMIT $limit, $itensporpag");

?><div class="col-12"><ul class="list-group shadow" style="margin-bottom: 20px"><?
$i=0; while($item = $itens->fetch(PDO::FETCH_OBJ)) {
$info = $mistake->prepare("SELECT * FROM w_usuarios where id='".$item->uid."'");
$info->execute();
$info = $info->fetch();
$foto = $info['ft'];
$conta = $mistake->query("SELECT COUNT(*) FROM w_ubloq where uid='$meuid' and aid='".$item->uid."'")->fetch();
?>
<li class="list-group-item"><?php echo gerarnome($item->uid);?></a><a class="badge badge-outline-primary float-right" href="/chat?a=convidarusuario&id=<?php echo $id;?>&sala=<?php echo $_GET['sala'];?>&user=<?php echo $item->uid;?>&acao=convidar">Convidar</a></li>
<?php $i++; 
} 
if($numpag>1) {
paginas('chat',$a,$numpag,$id,$pag);
}
}else{
?>

<div class="col-12"><div class="card shadow"><div class="card-body">Nenhum usuário nessa sala.</div></div></div>


<?php
}
?></ul>

<center> <a href="/chat?a=sala&id=<?php echo $id;?>"><?php echo $imgsetavoltar;?> Voltar sala</a></center>


</div><?
}
else if($a=='convidar'){
?>
<header><nav class="navbar navbar-light bg-light" style="margin-bottom: 20px"><a class="navbar-brand" href="#"><img src="/style/<?php echo $testearray[30];?>" width="32" height="" alt=""></a><ul class="nav navbar-nav navbar-right user-menu"></ul></header>
<section class="container-fluid">
<h2 class="title" style="font-size: 24px">Usuários na sala</h2><ul class="alert alert-light" role="alert"><?
$schats = $mistake->query("SELECT id, nm,dn FROM w_schat where tipo='0'");
if($schats->rowCount()>0){
$i=0; while ($schat = $schats->fetch(PDO::FETCH_OBJ)) {
$contonc = $mistake->query("SELECT COUNT(*) FROM w_ochat WHERE schat='".$schat->id."'")->fetch();
?>
<div id="<?php echo $i%2==0?'div1':'div1';?>"><?
$contonc = $mistake->query("SELECT COUNT(*) FROM w_ochat WHERE schat='".$schat->id."'")->fetch();
?><a style="font-size: 16px" href="/chat?a=convidarusuario&id=<?php echo $id;?>&sala=<?php echo $schat->id;?>"><?php echo $imgsalas;?> <?php echo $schat->nm;?></a></li></div><?
$i++;
}

}else{
?>
<div class="col-12"><div class="card shadow"><div class="card-body">Nenhuma sala </div></div></div>
<?php
}
?></ul>

<center> <a href="/chat?a=sala&id=<?php echo $id;?>"><?php echo $imgsetavoltar;?> Voltar sala</a></center>

<?php
}
else if($a=='sair'){
$mistake->exec("DELETE FROM w_ochat WHERE uid='".$meuid."'");
//$mistake->exec("DELETE FROM w_mchat WHERE por='".$meuid."' or para='".$meuid."'");
header("Location:/home?");
}
else if($a=='criar'){
?>
<header><nav class="navbar navbar-light bg-light" style="margin-bottom: 20px"><a class="navbar-brand" href="#"><img src="/style/<?php echo $testearray[30];?>" width="32" height="" alt=""></a><ul class="nav navbar-nav navbar-right user-menu"></ul></header>
<section class="container-fluid"><h2 class="title"><b>Criar sala</b></h2><div class="col-12"><?
if(isset($_POST['nome'])==TRUE){
$privado = isset($_POST['privado']) ? $_POST['privado'] : 0;
$res = $mistake->prepare("INSERT INTO w_schat (nm,perm,tipo,dn,time) VALUES (?,?,?,?,?)");
$arrayName = array($_POST['nome'],0,1,$meuid,time());
$ii = 0;
for($i=1; $i <=5; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
$sala = $mistake->query("SELECT max(id) FROM w_schat WHERE tipo='1' and dn='$meuid'")->fetch();
$mistake->exec("INSERT INTO perm_sala (uid,sala) values('".$meuid."','".$sala[0]."')");
header("Location:/chat?a=sala&id=".$sala[0]."");
}
?>
<form action="/chat?a=criar" method="post"><div class="form-group"><label>Nome</label><input type="text" class="form-control" name="nome" maxlength="14"></div><button type="submit" class="btn btn-primary btn-sm active btn-block" role="button" aria-pressed="true">Criar sala</button></form></div><div class="col-12 text-center" style="margin-top: 20px"><a href="/chat.php">Ver Salas privadas</a><br/>
<a href="/home">Página inicial</a>
</div> </section>



<?php
}
else if($a=='youtube'){
?>
<header>
<nav class="navbar navbar-light bg-light" style="margin-bottom: 20px"><a class="navbar-brand" href="#"><img src="/style/<?php echo $testearray[30];?>" width="32" height="" alt=""></a><ul class="nav navbar-nav navbar-right user-menu"></ul></header>
<section class="container-fluid"><h2 class="title"><b>YouTube</b></h2><div class="col-12 text-center"><iframe width="85%" height="280" src="https://www.youtube.com/embed/<?php echo $_GET['video'];?>" frameborder="0"></iframe></div><div class="col-12 text-center" style="margin-top: 20px"> <a href="/chat?a=sala&id=<?php echo $id;?>"><?php echo $imgsetavoltar;?> Voltar</a></div></section>
<?
}
else if($a=='sala') {
$tiposala = $mistake->query("SELECT tipo,dn FROM w_schat WHERE id='$id'")->fetch();
$contperm = $mistake->query("SELECT COUNT(*) FROM perm_sala WHERE sala='".$id."' and uid='$meuid'")->fetch();
if($tiposala[0]==1 && $contperm[0]==0) { ?>
<header><nav class="navbar navbar-light bg-light" style="margin-bottom: 20px"><a class="navbar-brand" href="#"><img src="/style/<?php echo $testearray[30];?>" width="32" height="" alt=""></a><ul class="nav navbar-nav navbar-right user-menu"></ul></header>
<div align="center"><?php echo $imgerro;?>Voce não tem permissão para entrar nessa sala.<br/>

<div class="col-12 text-center" style="margin-top: 20px"> <a href="javascript:window.history.back();"><?php echo $imgsetavoltar;?> Voltar</a></div><br/>
<?php
rodape();
exit(); }
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
$imag1="<a href='/amigos?' ".$amigos."</a>";
}
if($reqs[0]>0){
$imag1="<a href='/amigos/pedidos' ".$amigos." &nbsp;<span class='pms pmsn'>$reqs[0]</span></a>";
}
?>


<?
if($urll!='/porno/minhasfotos.php' and $urll!='/porno/adulto.php' and $urll!='/porno/meusvideos.php'){
?>

<script>
(adsbygoogle = window.adsbygoogle || []).push({
          google_ad_client: "ca-pub-9595143495770750",
          enable_page_level_ads: true
     });
</script>
<?
}
?>
<?
echo '</head><body>';
?>
<small><div id='rodape'><div id='relogiodata'>...</div><div id='relogio'>Olá Mundo!</div></small>
<a href="" id="scroll-top"><mis class="up"></mis></a>
<script>
var data = new Date();
var meses = new Array("Janeiro","Fevereiro","Mar&#231;o","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro");
var dsem = new Array("Domingo","Segunda","Ter&#231;a","Quarta","Quinta","Sexta","Sab&#225;do");
document.getElementById('relogiodata').innerHTML = dsem[data.getDay()] + ", " + data.getDate() + " de " + meses[data.getMonth()] + " de " + data.getFullYear() + "";
var minhaVar = setInterval(meutempo, 1000);function meutempo() {var d = new Date();document.getElementById('relogio').innerHTML = d.toLocaleTimeString();} document.cookie = 'visita=1; path=/';
$(window).scroll(function() {
if ($(window).scrollTop() > 100) {
$("#scroll-top").fadeIn();
} else {
$("#scroll-top").fadeOut();
}
});
$(function() {
$(document).on("click", '#scroll-top', function() {
$("html,body").animate({scrollTop : '0px'},300);
return false;
});
});
</script>
<?php
if($meuid!=0){
$i = $mistake->prepare("SELECT ocimg,oclogo,ocme,ocmu,ocmu2,ocmu3,visi,stats,bg,atlh,notifica,dest,pt,paginas,nm FROM w_usuarios WHERE id='$meuid'");
$i->execute();
$i = $i->fetch();
require ("".$_SERVER["DOCUMENT_ROOT"]."/ferramenta.php");
}
?>
</div>

</header><section class="container-fluid" style="padding: 0" ><div class="col-12 text-center room-name"><div id="titulo"><b>
<?php echo $nmsala[0];?></b>
<a class="btn btn-light btn-sm float-right" href="/chat?a=sair" style="color: #00587C"> Sair</a>
</div></div>
<?if($dono[0]==$meuid){?><br/><a class="btn btn-primary btn-sm active" role="button" aria-pressed="true" href="/chat?a=convidar&id=<?php echo $id;?>">Convidar</a> <a class="btn btn-primary btn-sm active" role="button" aria-pressed="true" href="chat?a=editar&id=<?php echo $id;?>"><i class="fas fa-edit"></i> Editar</a><?}?></div><?
if($conton[0]>279999)
{
$conteu = $mistake->query("SELECT COUNT(*) FROM w_ochat WHERE schat='$id' AND uid='$meuid'")->fetch();
if($conteu[0]==0) { ?>
<br/><div align="center"><?php echo $imgerro;?>Esta sala está cheia, por favor escolha outra com menos de 50 usuários online</div><br/><br/> 
<a href="chat"> <img src='style/chat.gif'>
Salas de chat</a><br/>
<div class="col-12 text-center" style="margin-top: 20px"> <a href="javascript:window.history.back();"><?php echo $imgsetavoltar;?>Voltar</a></div><br/>
<?php exit(); } }
$sperm = $mistake->query("SELECT perm FROM w_schat WHERE id='$id'")->fetch();
$vip = $mistake->query("SELECT vip, perm2 FROM w_usuarios WHERE id='$meuid'")->fetch();
if($sperm[0]==1) {
if($vip[0]==0 and perm($meuid)==0 and $vip[1]==0) { ?>
<br/><div align="center"><?php echo $imgerro;?>Somente é permitido usuários vip e membros da equipe nesta sala.</div><br/><br/>
<a href="chat"> <?php echo $imgbatepapo;?>
Salas de chat</a><br/>
<div class="col-12 text-center" style="margin-top: 20px"> <a href="javascript:window.history.back();"><?php echo $imgsetavoltar;?> Voltar</a></div><br/>
<?php exit(); } } else if($sperm[0]==2 and perm($meuid)==0 and $vip[1]==0) { ?>
<br/><div align="center"><?php echo $imgerro;?>Somente é permitido membros da equipe nesta sala.</div><br/><br/>
<a href="chat"> <?php echo $imgbatepapo;?>
Salas de chat</a><br/>
<div class="col-12 text-center" style="margin-top: 20px"> <a href="javascript:window.history.back();"><?php echo $imgsetavoltar;?> Voltar</a></div><br/>
<?php exit(); }
$arquivo = $_FILES["arquivo"];
$ver = $mistake->query("SELECT max(id) FROM w_mchat WHERE por='".$meuid."' and schat='$id'")->fetch();
$ver2 = $ver[0] + 1;
if (!empty($arquivo["name"])){
$pasta = "msgs/";
$nome = $_FILES['arquivo']['name'];
$nome = "By-Nando-".$meuid."-".$nome."";
$nome = str_replace(' ','-',$nome);
$nome = preg_replace("/[^a-zA-Z0-9.]/", "-", $nome);
$_UP['extensoes'] = array('mp3','ogg','wmv','jpeg','png','gif','bmp','jpg','mp4','webm','mpeg','3gp','3gpp','3ggp','apk','zip','webp');
$extensao = substr(strrchr($_FILES['arquivo']['name'],'.'),1);
if (array_search($extensao, $_UP['extensoes']) === false) {
echo "Extenção inválida!";
}else{
$url = $pasta.$nome;
if(preg_match("/^image\/(jpeg|png|bmp|jpg)$/", $_FILES["arquivo"]["type"])){
$bbcodemulti = '<br /><b><u>'.str_ireplace('.'.$extensao.'','',$_FILES['arquivoo']['name']).'</u></b>[link=/chat?a=arquivo&foto='.$url.'&sala='.$id.'&msg='.$ver2.']Imagem('.$extensao.')[/link] ';
//exec("montage -geometry +0+0 -background \"".$testearray[2]."\" -label \"".$_SERVER['SERVER_NAME']."\" ".escapeshellarg($_FILES['arquivo']['tmp_name'])." ".escapeshellarg($pasta.$nome)."");
move_uploaded_file($_FILES['arquivo']['tmp_name'], $pasta.$nome);
}else{ 
if(preg_match("/^image\/(gif|webp)$/", $_FILES["arquivo"]["type"])){
$bbcodemulti = '<br /><b><u>'.str_ireplace('.'.$extensao.'','',$_FILES['arquivoo']['name']).'</u></b>https://'.$_SERVER['SERVER_NAME'].'/'.$url.' ';
}else{
if(preg_match("/^audio\/(mp3|wmv|mpeg|ogg)$/", $_FILES["arquivo"]["type"])){
$bbcodemulti = '<br /><b><u>'.str_ireplace('.'.$extensao.'','',$_FILES['arquivoo']['name']).'</u></b>[link=/chat?a=arquivo&audio='.$url.'&sala='.$id.'&msg='.$ver2.']Música(mp3)[/link] ';
}else{ 
if(preg_match("/^video\/(mp4|mpeg|webm)$/", $_FILES["arquivo"]["type"])){
$bbcodemulti = '<br /><b><u>'.str_ireplace('.'.$extensao.'','',$_FILES['arquivoo']['name']).'</u></b>[link=/chat?a=arquivo&video='.$url.'&sala='.$id.'&msg='.$ver2.']Multimídia(mp4)[/link] ';
}else{ 
if(preg_match("/^application\/(vnd.android.package-archive|x-zip-compressed)$/", $_FILES["arquivo"]["type"])){
$bbcodemulti = '[br/][link=/'.$url.']'.$_FILES['arquivo']['name'].'[/link][br/]';
}else{
if(preg_match("/^video\/(3gp|3gpp|3ggp)$/", $_FILES["arquivo"]["type"])){
//$bbcodemulti = '[br/][link=/'.$url.']'.$_FILES['arquivo']['name'].'[/link][br/]';
}
}
}
}
}
move_uploaded_file($_FILES['arquivo']['tmp_name'], $pasta.$nome);
}
}
}else{
$bbcodemulti = '';
}
$cortexto = !empty($_POST['cortexto']) ? $_POST['cortexto'] :'#000000';
$contorno = $_POST["contorno"];
if($contorno=="#000000"){
$contorno = "";    
}else{
$contorno = $contorno;      
}
$text = anti_injection($_POST['msg']);
$text = str_replace('ด้้้้้็็็็็้้้้้็็็็็้้้้้้้้็็็็็้้้้้็็็็็้้้้้้้','-',$text);
$text = "".$bbcodemulti."".$text."";
//$text = nl2br(emoji_unified_to_html($text));	
ativo($meuid,'Sala de chat ');
$nmsala = $mistake->query("SELECT nm FROM w_schat WHERE id='$id'")->fetch();
$conta = $mistake->query("SELECT COUNT(*) FROM w_ubloq where (uid='$meuid' and aid='".$_POST['dest']."') or (aid='$meuid' and uid='".$_POST['dest']."')")->fetch();
$conta1 = $mistake->query("SELECT COUNT(*) FROM w_ubloq where (uid='$meuid' and aid='".$_GET['para']."') or (aid='$meuid' and uid='".$_GET['para']."')")->fetch();
$mp = $mistake->query("SELECT mp FROM w_usuarios where id='".$_GET['para']."'")->fetch();
$mp1 = $mistake->query("SELECT mp FROM w_usuarios where id='".$_POST['dest']."'")->fetch();
$flood = $mistake->query("SELECT COUNT(*) FROM w_mchat WHERE txt='".$_POST['msg']."' and  por='$meuid'")->fetch();
$msgc=isset($_POST['msg'])?anti_injection($_POST['msg']):'';

if($msgc==true && $flood[0]==0)
{
if($conta[0]>0 or $conta1[0]>0)
{
header("Location:/chat?a=sala&id=".$id."");
exit;
}
if(strlen($msgc)>300){
header("Location:/chat?a=sala&id=".$id."");
exit;
}
if(strripos($msgc,'youtube.com') == true || strripos($msgc,'youtu.be') == true){
header("Location:/chat?a=sala&id=".$id."");
exit;
}
$para = isset($_POST['dest'])&&$conta[0]==0 ? $_POST['dest'] : 0;
$privado = isset($_POST['p'])&&$mp1[0]==0 ? $_POST['p'] : 0;
$mistake->exec("INSERT INTO w_mchat (por,para,txt,hr,schat,p,cor,contorno) values('$meuid','".$para."','$text','".time()."','$id','".$privado."','".$cortexto."','".$contorno."')");
$mistake->exec("UPDATE w_usuarios SET pt=pt+1 WHERE id='$meuid'");
$mistake->exec("UPDATE w_ochat SET um='".time()."' WHERE uid='$meuid'");
$mistake->exec("update w_schat set time='".time()."' where id='$id'");
header("Location:/chat?a=sala&id=".$id."");
}
$msgy=isset($_POST['youtube'])?anti_injection($_POST['youtube']):'';
if($msgy==true)
{
if($conta[0]>0 or $conta1[0]>0)
{
header("Location:/chat?a=sala&id=".$id."");
exit;
}

$texto = "[link=/chat?a=youtube&id=$id&video=".mb_substr($msgy,-11)."]https://i3.ytimg.com/vi/".mb_substr($msgy,-11)."/hqdefault.jpg[/link]";
$para = isset($_POST['dest'])&&$conta[0]==0 ? $_POST['dest'] : 0;
$privado = isset($_POST['p']) ? $_POST['p'] : 0;
$mistake->exec("INSERT INTO w_mchat (por,para,txt,hr,schat,p) values('$meuid','".$para."','$texto','".time()."','$id','".$privado."')");
$mistake->exec("UPDATE w_usuarios SET pt=pt+1 WHERE id='$meuid'");
$mistake->exec("UPDATE w_ochat SET um='".time()."' WHERE uid='$meuid'");
$mistake->exec("update w_schat set time='".time()."' where id='$id'");
header("Location:/chat?a=sala&id=".$id."");
}
###acao
if($_GET['acao']==true)
{
if($conta[0]>0 or $conta1[0]>0)
{
header("Location:/chat?a=sala&id=".$id."");
exit;
}
$textoacao = $mistake->query("SELECT texto FROM fun_batepapo_acoes WHERE id='".$_GET['acao']."'")->fetch();
$para = isset($_GET['para'])&&$conta1[0]==0 ? $_GET['para'] : 0;
$mistake->exec("INSERT INTO w_mchat (por,para,txt,hr,schat,p) values('$meuid','".$para."','".$textoacao[0]."','".time()."','$id','0')");
$mistake->exec("UPDATE w_usuarios SET pt=pt+1 WHERE id='$meuid'");
$mistake->exec("UPDATE w_ochat SET um='".time()."' WHERE uid='$meuid'");
header("Location:/chat?a=sala&id=".$id.""); 
}
$conteu = $mistake->query("SELECT COUNT(*) FROM w_ochat WHERE uid='$meuid' AND schat='$id'")->fetch();
if($conteu[0]==false){
$nm = $mistake->query("SELECT perm FROM w_usuarios WHERE id='$meuid'")->fetch();
if($nm[0]==1) { $eq = "(moderador)"; } else if($nm[0]==2) { $eq = "(administrador)"; }
$nav = explode(" ",$_SERVER['HTTP_USER_AGENT'] );
$txt = "<small>".html_entity_decode(gerarnome2($meuid))." ".$eq." entrou na sala com ".$nav[0]."</small>";
//$mistake->exec("INSERT INTO w_mchat (por,para,hr,txt,schat) values('0','0','".time()."','$txt','$id')");
$mistake->exec("INSERT INTO w_ochat (uid,schat,hr,um) values('$meuid','$id','".time()."','".time()."')");
}
/*$contmsg = $mistake->query("SELECT COUNT() FROM privado WHERE para='".$meuid."' AND dl='0' and dl='0'")->fetch();
if($contmsg[0]>0) { ?>
<a href="mensagens?menu=entrada">Mensagens(<?php echo $contmsg[0];?>)</a><br/><br/>
<?php } */?>
<br/>
<div class="col-md-6 offset-md-3 message-container" style="margin-bottom: 12px"><form  id="sendMessage" action="chat.php?a=sala&id=<?php echo $id;?>" method="post" enctype="multipart/form-data"><div class="row"><div class="col-12 text-center" style="margin-bottom: 8px"><div class="dropdown" style="display: inline-flex"><button class="btn btn-secondary btn-micro dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span style="color: #ffffff">Ações</span></button><div class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdownMenuButton"><a class="dropdown-item msg-action" style="font-size: 16px" href="#" value="0">Selecionar</a><>
<?
$sqlacao = $mistake->query("SELECT * FROM fun_batepapo_acoes ORDER BY nome");
if($sqlacao->rowCount()>0)
{
while($resao = $sqlacao->fetch())
{?>
<a class="dropdown-item msgg-actionn" style="font-size: 16px" href="chat.php?a=sala&id=<?php echo $id;?>&acao=<?php echo $resao['id'];?>&para=<?php echo $_GET['para'];?>"><?php echo $resao['nome'];?></a><?
}
}
$acao = $mistake->query("SELECT texto FROM fun_batepapo_acoes WHERE id='".$_GET['acao']."'")->fetch();
?>
</div></div>
<style>
.gif-image{cursor: pointer;}.gif-selector{position: relative}.gif-selector > i{border: solid 1px;border-radius: 4px;padding: 0px 2px;line-height: 14px;font-size: 10px;vertical-align: 2px;display: inline-block}.gif-selector > i:before{content: "GIF"}.gif-box{position: absolute;bottom: 30px;right: 0px;background-color: #FFFFFF;display: none;z-index: 100;border: solid 1px rgba(0, 0, 0, .2);border-radius: 4px}.gif-box-head{padding: 2px 100px;background-color: rgba(0, 0, 0, .1);text-align: center;font-size: 14pt;color: #808080}.gif-box-close-button{position: absolute;top: 0px;right: 6px;font-size: 14pt !important;z-index: 1}.gif-box-arrow{position: absolute;bottom: -10px;right: 4px4pxdth: 0;height: 0;border-left: 10px solid transparent !important;;border-right: 10px solid transparent !important;border-top: 10px solid #CCCCCC}.gif-box-body{padding: 4px}.gif-search-result{width: calc(100% + 2px);height: 250px;overflow: auto}.gif-search-result img{margin: 1px 0px;width: 100%;height: 120px;object-fit: cover}.alt-chat-gif-selector{top: -11px;margin-left: 0px}
</style>
 
<div class="input-group input-group-sm mb-3 msg"><div class="input-group-prepend"><span class="input-group-text"><a href="/chat/catemocoes" class="smilies"><?php echo $imgsmilies;?></a></span></div>
<input style="width:68%;height:40px;" placeholder="Digite Sua Mensagem" name="msg" maxlength="1000" class="inserirtexto" onfocus="Escrevendo();" onblur="ParouEscrever();" rows="5" cols="25" onkeypress="return checkearTecla(event)"></input><div class="input-group-append"><span class="input-group-text file-chooser"><a style="margin: 0 4px" data-toggle="collapse"href="#youtube"><i class="ion-social-youtube" style="color: #000000"></i></a></span></div><button class="btn btn-secondary btn-sm" name="envio" type="submit"><i class="fas fa-paper-plane"></i></button></div></div></div>
<div class="collapse" id="youtube" style="margin-bottom: 1rem"><input type="text" class="form-control form-control-sm" placeholder="Link do YouTube" name="youtube"></div><div class="collapse" id="multimidia" style="margin-bottom: 1rem"><br/><input type="file" name="arquivo" id="arquivo" /></div></div>

<script>
function gif_new_page_loaded()  {
$('.gif-search-result').scroll(function() { 
if ($(this).scrollTop() + $(this).height() == $(this).get(0).scrollHeight) {
if($('.gif-search-result').attr('data-offset') < 50){
$('.gif-search-result').attr('data-offset',function(n,v){
return (+v)+15;
});	
$.ajax({url: "https://api.tenor.com/v1/search?tag="+ $('.gif-search-result').attr('data-search') + "&key=" + tenorGifApiKey + "&limit=" + $('.gif-search-result').attr('data-offset'),success: function(data) {
$('.gif-search-result').html('');
if(data.results) {
data.results.forEach(function(result) {
var media = result.media[0].gif;
$('.gif-search-result').append('<img class="gif-image" id="' + media.url + '" src="' + media.url + '" data-url ="' + media.url + '">');
});
}
$('.gif-search-result').animate({scrollTop: 0}, 2000);
}
});
}
}
});
}
window.emoticon = {
init: function() {
gif_new_page_loaded();
this.attachEvents();
this.gif.init();
},attachEvents: function() {
},gif: {
init: function() {
this.attachEvents();
},attachEvents: function() {
$(document).on('click', '.gif-selector', function(e) {
e.preventDefault();
if($(e.target).hasClass('gif-selector') || $(e.target).hasClass('gif-icon')) {
var gifBox = $(this).find('.gif-box');
var gifSearchResult = $(this).find('.gif-search-result');
gifBox.fadeIn();
window.emoticon.gif.loadTenorGIFs('ola', 15, gifSearchResult);
gifSearchResult.attr('data-offset','15').attr('data-search','ola');
}
});
$(document).on('keyup', '.gif-search-input', function(e) {
e.preventDefault();
var gifSearchResult = $(this).closest('.gif-box').find('.gif-search-result');
window.emoticon.gif.loadTenorGIFs($(this).val(), 15, gifSearchResult);
gifSearchResult.attr('data-offset','15').attr('data-search',$(this).val());
});
$(document).on('click', '.gif-box-close-button', function(e) {
e.preventDefault();
var gifBox = $(this).closest('.gif-box');
gifBox.fadeOut();
});
$(document).on('click', '.gif-box .gif-image', function(e) {
e.preventDefault();    
$('.inserirtexto').val($('.inserirtexto').val() +''+ $(this).data('url').replace('https://media.tenor.com/images/', '[gif=').replace('/tenor.gif', ']'));
});
},loadTenorGIFs: function (term, limit, container) {
if(term.length >= 2) {	
$.ajax({url: "https://api.tenor.com/v1/search?tag=" + term + "&key=" + tenorGifApiKey + "&limit=" + limit,success: function(data) {
container.html('');
if(data.results) {
data.results.forEach(function(result) {
var media = result.media[0].gif;
container.append('<img class="gif-image" id="' + media.url + '" src="' + media.url + '" data-url ="' + media.url + '">');
container.attr('data-offset',limit).attr('data-search',term);
});
}
}
});
}
}
}
};
window.emoticon.init();
</script>
<body onload="EventosDigitando()">
        <center><div id="digitando"></div></center>
<input type="hidden" id="to" name="para" value="0"><input type="hidden" id="action" value="0" name="acoes"><input type="hidden" id="audio" value="0" name="audio"><div class="row"><div class="col-6 text-center" style="font-size: 16px; word-wrap: break-word"><span class="nick" name="dest" value="<?php echo $_GET["para"]==true ? "".$_GET["para"]."" : "0";?>"><?php echo $_GET["para"]==true ? "".gerarnome($_GET["para"])."" : "";?></span></div><div class="col-6 text-center" style="font-size: 16px"><input type="hidden" name="dest" value="<?php echo $_GET["para"]==true ? "".$_GET["para"]."" : "0";?>"/><input type="checkbox" name="p" value="1"> Privada</div></div>
<center><div class="upload-btn-wrapper"><button class="btn"><i class="bt_upload"></i></button><input type="file" name="arquivo"></div><div class="color-btn-wrapper"><button class="btn"><i class="bt_color"></i></button><input type="color" name="cortexto" value="#000000"></div><div class="gravador-btn-wrapper"><button type="button" style="cursor :pointer" class="btn recordm"><i class="record"></i></i></button></div>
<script src="/img.js"></script>
<div style="display: inline-block"><button id="chat-gif-selector" href="javascript:void(0)" class="btn gif-selector">
<i class="gif-icon"></i>
<div class="chat-gif-box gif-box">
<div class="gif-box-head">
<span><font color="red">GIF</fon></span>
<i class="gif-box-close-button ion-close-circled"></i>
</div>
<div class="gif-box-body">
<input type="text" class="form-control chat-gif-search-input gif-search-input" placeholder="Busca GIF"/>
<div class="gif-search-result"></div>
</div>
<div class="gif-box-arrow"></div>
</div>
</button></div><br />
</div></div></center>
<br/><center><div id="voz"></div></center>
<style>
.gravador-btn-wrapper {position: relative;display: inline-block;}.record {background-image: url('imgs/gravador.png');background-size: 15px;background-position: center;color: #6B6B6B;border-radius: 3px;width: 15px;height: 15px;cursor: pointer;margin-left: 2px;display: inline-block;}.save {background-image: url('imgs/gravadoroff.png');background-size: 15px;background-position: center;color: #6B6B6B;border-radius: 3px;width: 15px;height: 15px;cursor: pointer;margin-left: 2px;display: inline-block;}
</style>
<script>
var EVENTO ='1';
    function EventosDigitando() {
    if (EVENTO == true) {
        var source = new EventSource('https://chatpipoca.net/eventos/digitando.php');
        source.onmessage = function(event) {
            if (event.lastEventId >0) {
                $("#digitando").html('<br/><small><i><img id="img" src="style/chat.png" alt="">' + event.data + '</i></small>');
            } else {
                $("#digitando").html('');
            }
        };
    }
}
function Escrevendo() {
$.get('https://chatpipoca.net/eventos/geradigitacao.php?acao=add');
}
function ParouEscrever() {
$.get('https://chatpipoca.net/eventos/geradigitacao.php?acao=del');
    setInterval(() => {
$.get('https://chatpipoca.net/eventos/geradigitacao.php?acao=del');
    }, 10000);
}
</script>
<script>
$(document).ready(function(){
navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia;
var constraints = {audio:true};
function errorCallback(error){
console.error(error);    
}
var mediaRecorder;
var chunks = [];
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
function startRecording(stream) {
if (typeof MediaRecorder.isTypeSupported == 'function'){
if (MediaRecorder.isTypeSupported('audio/webm;codecs=opus')) {
var options = {audioBitsPerSecond: 128000,mimeType: 'audio/webm;codecs=opus'};
}else if (MediaRecorder.isTypeSupported('audio/ogg;codecs=opus')) {
var options = {mimeType: 'audio/ogg;codecs=opus'};
}
mediaRecorder = new MediaRecorder(stream, options);
}else{
mediaRecorder = new MediaRecorder(stream);
}
mediaRecorder.start(10);
mediaRecorder.ondataavailable = function(e) {
chunks.push(e.data);
};
mediaRecorder.onerror = function(e){
};
}
$(document).on("click",".recordm",function(){
$(".recordm").removeClass("recordm").addClass("savem");
$(".record").removeClass("record").addClass("save");
document.getElementById("voz").innerHTML = '<font color="red">Gravando...<br><span id="clock"></span></font>';
var segundos = 0;
window.setInterval(function() {
document.getElementById('clock').innerHTML = formatatempo(segundos);
segundos++;
},1000);
if (typeof MediaRecorder === 'undefined' || !navigator.getUserMedia) {
alert('A API de áudio não é suportada por este navegador ou por sua configuração atual');
}else{
navigator.getUserMedia(constraints, startRecording, errorCallback);
}
});
$(document).on("click",".savem",function(){
elem=$(this);
var valor = this.type;
var nome = this.name;
var titi = this.title;
mediaRecorder.stop(0);
$(".savem").removeClass("savem").addClass("recordm");
$(".save").removeClass("save").addClass("record");
document.getElementById("voz").innerHTML = "Enviando...";
mediaRecorder.onstop = function(){
var blob = new Blob(chunks, {type: "audio/webm; codecs=opus"});
chunks = [];
var formData = new FormData(); 
var name = 'By-nandao1501-<?php echo $meuid;?>-<?php echo time();?>.mp3';
formData.append('file', blob);
formData.append('name', name);
formData.append('id',<?php echo $id;?>);
mistakeaudio('/nandovoznovahall2',formData, function (fileURL) {window.open(fileURL);});
this.stream.getTracks().forEach(track => track.stop());
}
});
function mistakeaudio(Murl,data,callback) {
var request = new XMLHttpRequest();
request.onreadystatechange = function () {
if (request.readyState == 4 && request.status == 200) {
setTimeout(function() {
window.location = '/chat?a=sala&id=<?php echo $id;?>';
}, 5000)
}};
request.open('POST',Murl);
request.send(data);
}
});
</script>
<?php
if($_GET['audio']==true){
?>
<div align="center"><audio id="id022" controls controlslist="nodownload" src="<?php echo $_GET['audio'];?>"></audio><br/><a href="/chat?a=sala&id=<?php echo $id;?>">Parar áudio</a></div>
<?php
}
?>
<?php
$umsg21 = $mistake->prepare("SELECT COUNT(*) FROM w_amigos WHERE tid='$meuid' AND ac='0'");
$umsg21->execute();
$umsg21 = $umsg21->fetch();
if($umsg21[0]>0){
$simdeum = "/mensagens/coletiva";
echo'<div align="center" id="opc4"><a href="/amigos/pedidos" style="padding:7px 0;">('.$umsg21[0].')&nbsp;Solicitações de Amizade!!</a></div>';
}
?>

<?php
if(isset($_POST['quizmural'])==TRUE){
$mistake->exec("update w_usuarios set quizmural='1' WHERE id='$meuid'");
}
$info = $mistake->prepare("SELECT * FROM w_usuarios WHERE id='$meuid'");
$info->execute();
$info = $info->fetch();
$quizmural = $mistake->prepare("SELECT * FROM bymistake_quizmural ORDER by id desc limit 1");
$quizmural->execute();
$quizmural = $quizmural->fetch();
 if($quizmural[0]>0 and $info['quizmural']==0){ 
 ?>
 <fieldset><legend><strong>Quiz Mural</strong></legend>
 <table align="center" cellpadding="3" cellspacing="1" bgcolor="">
 <tr><td bgcolor="" align="center">
 <?php echo $quizmural['prg'];?><br/><br/><i style="font-size:small;">Valendo <?php echo $quizmural['pontos'];?> pontos</i><br/><br/>
 <form action="/quizmural" method="post">
  <div align="left">
 <input type="radio" value="1" name="r" /> <?php echo $quizmural['r1'];?><br/>
 <input type="radio" value="2" name="r" /> <?php echo $quizmural['r2'];?><br/>
 <input type="radio" value="3" name="r" /> <?php echo $quizmural['r3'];?><br/><br/>
 <input type="hidden" name="id" value="<?php echo $quizmural['id'];?>" />
 </div>
 <input type="submit" value="Responder" />
 </form>
 <form action="/homepage" method="post">
 <input type="hidden" name="quizmural" value="1" />
 <input type="submit" value="Pular" />
 </form>
 </td></tr></table></fieldset>
 <?php
 }
 ?>
  <?php 
$reuniao =  $mistake->prepare("SELECT reuniao FROM w_geral WHERE id='1'");
$reuniao->execute();
$reuniao = $reuniao->fetch();
if($reuniao[0]==1){
if(perm($meuid)>0) { 
 ?>
<center><div id="div2"><?php echo gerarnome($meuid);?>  <a href='reuniao'><img src='images/confici.png' alt='img'/> Reunião sábado às 14hr, é solicitado a sua presença!</a></div></center>
<?php 
}}
?>
 <?php 
$entrevista =  $mistake->prepare("SELECT entrevista FROM w_geral WHERE id='1'");
$entrevista->execute();
$entrevista = $entrevista->fetch();
if($entrevista[0]==1){
 ?>
<center><div id="div2"> <a href='entrevistas'><img src='/images/confici.png' alt='img'/> Entrevista <font color="green">Em andamento!</font></a></div></center>
<?php 
}
?>
<?php 
  $bingo = $mistake->prepare("SELECT bingo FROM w_geral WHERE id='1'");
$bingo->execute();
$bingo = $bingo->fetch();
if($bingo[0]==1){
	?>
	<?php
	 }
 $bingo = $mistake->query("SELECT bingo FROM w_geral WHERE id='1'")->fetch();

if($bingo[0]==1){
?>
<center><div id="div2"><a href='bingowap?a=menu'><img src='imagens/bingo.gif' alt='img'/>Bingo<font color="green"> ( entre para jogar ) </font></a></div>

<div id="div1"><a href='chatbingo?a=a'><img src='imagens/bingo.gif' alt='img'/>Sala de sorteio do bingo</a></div></center><?

}else {

 if(perm($meuid)>0) { 

?>
<center><div id="div2"><a href='bingowap?a=menu'><img src='imagens/bingo.gif' alt='img'/>Bingo-<font color="red">(c)</font></a></center></div>
<?php
}}
?>
<?
if($tipo[0]==0){
?>
<?php 
$car = $mistake->query("SELECT time FROM caballos WHERE abierta='1'  ORDER BY id DESC LIMIT 0,1")->fetch();
$hora = time();
if($hora<$car[0]){
?>
<center>
    <div style="background-color:<?php echo $linha2;?>;padding:4px;margin:1px;<?php echo $borda;?>"><a href='caballos?a=menu'><img height="20px" src='juegos/cab/uid1a.gif' alt='img' >Hipodromo</a> <font color="red">(fechado)</font></div>  </div></center>
<?php
}else{
?>
<center><div style="background-color:<?php echo $linha2;?>;padding:4px;margin:1px;<?php echo $borda;?>"><a href='caballos?a=elegir'><img height="20px" src="juegos/cab/uid2.gif"> Hipodromo <font color="green">(Aberto)</font></a></div></center></div> </div>
<?php
}
?>
<center><a href="/chat?a=sala&id=<?php echo $id;?>"><img src="/style/atualizar.png" width="20px" height="20px"/></a></center><hr>

<?
}?>

 <script>
 $(document).ready(function(){
 $("#div_refresh").load(" #div_refresh");
 setInterval(function() {
 $("#div_refresh").load(" #div_refresh");
 }, 15000);
 });
 </script>
 

 <div id="div_refresh">
<?php
$mchats = $mistake->query("SELECT id, por, para, hr, txt, cor, contorno, p FROM w_mchat WHERE schat='$id' and (para='$meuid' or por='$meuid' or p='0') ORDER BY id DESC LIMIT 30");
if($mchats->rowCount()>0){
$i=0;  while ($mchat = $mchats->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<a href="/chat?a=sala&id=<?php echo $id;?>&para=<?php echo $mchat->por;?>"><?php echo $mchat->p==1?'<i class="fas fa-lock" style="color: #00587C"></i>':'';?> <?php echo gerarnome($mchat->por);?></a><?php if($mchat->para==0) {?><?php } else { ?> para <a href="/chat?a=sala&id=<?php echo $id;?>&para=<?php echo $mchat->para;?>">
<?php echo gerarnome($mchat->para); } ?></a><br/>
<em style="color: <?php echo $mchat->cor; ?>;background-color:<?php echo $mchat->contorno; ?>;"><b><b><?php echo textot($mchat->txt,$meuid,$on);?></b></b></em><?if($mchat->por==$meuid or perm($meuid)>0){?> <a class="badge badge-light float-right" href="/chat?a=sala&id=<?php echo $id;?>&ac=apagar&ok=<?php echo $mchat->id;?>">         
<font color="red">x</font></a></span><?}?><br/>
</div>
<?php $i++; }
}else{
?>
<div class="list">Sem mensagens na sala</div>
<?
}
?>
</div></div>
<?php
if($_GET['ac']=='apagar'){
$dn = $mistake->query("SELECT por FROM w_mchat WHERE id='".$_GET['ok']."'")->fetch();
if($dn[0]==$meuid or perm($meuid)>0){
$mistake->exec("DELETE FROM w_mchat WHERE id='".$_GET['ok']."'");
header("Location:/chat?a=sala&id=".$id."");
}
}
} else if($a=='arquivo') { ativo($meuid,'Buscando no chat ');
$dn = $mistake->query("SELECT por FROM w_mchat WHERE id='".$_GET['msg']."'")->fetch();
if($_GET['acao']=='apagar'){
if($dn[0]==$meuid or perm($meuid)>0){
$mistake->exec("DELETE FROM w_mchat WHERE id='".$_GET['msg']."'");
header("Location:/chat?a=sala&id=".$id."");
}
}
else{}
?>
<header><nav class="navbar navbar-light bg-light" style="margin-bottom: 20px"><a class="navbar-brand" href="#"><img src="/style/<?php echo $testearray[30];?>" width="32" height="" alt=""></a></nav></header>
<section class="container-fluid"><h2 class="title"><b><?if(!empty($_GET['foto'])){?>Foto<?}if(!empty($_GET['audio'])){?>Música<?}if(!empty($_GET['video'])){?>Vídeo<?}?></b></h2><div class="col-12 text-center"><?if($_GET['audio']==true){
?>
<audio id="id022" controls controlslist="nodownload" src="/<?php echo $_GET['audio'];?>"></audio>
<?php
}if(!empty($_GET['foto'])){?><img src="/<?php echo $_GET['foto'];?>" style="max-width: 100%"><?}if(!empty($_GET['video'])){?><iframe src="/<?php echo $_GET['video'];?>" style="width: 100%; height: 320px"></iframe><?}?><br><br><a href="/chat?a=arquivo&acao=apagar&msg=<?php echo $_GET['msg'];?>&id=<?php echo $_GET['sala'];?>" class="btn btn-outline-danger btn-sm"><i class="fas fa-trash-alt"></i> Excluir</a></div><div class="col-12 text-center" style="margin-top: 20px"> <a href="/chat?a=sala&id=<?php echo $_GET['sala'];?>"><?php echo $imgsetavoltar;?> Voltar Sala</a></div></section>
<?php }
else
if($a=='emocoes') { 
ativo($meuid,'Vendo emoções '); 
?>
<header><nav class="navbar navbar-light bg-light" style="margin-bottom: 20px"><a class="navbar-brand" href="#"><img src="/style/<?php echo $testearray[30];?>" width="32" height="" alt=""></a></nav></header>
<section class="container-fluid"><h2 class="title"><b>Smilies</b></h2><div class="col-12 text-left">
<div class="col-12"><ul class="list-group shadow" style="margin-bottom: 20px">
<?php 
$contemo = $mistake->query("SELECT COUNT(*) FROM w_emocoes where cat='$id'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contemo[0];
$itensporpag = 20;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->query("SELECT id,cod,ext FROM w_emocoes where cat='$id' ORDER BY cod LIMIT $limit, $itensporpag");	
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<li class="list-group-item">
<img src="/e/<?php echo $item->id;?>.<?php echo $item->ext;?>" class="smilies" oncontextmenu='return false' onselectstart='return false' ondragstart='return false'><br><? if(perm($meuid)>0){?><a href="/mod/emocoes/<?php echo $id;?>/<?php echo $pag;?>/<?php echo $item->id;?>"><font color="red">[apagar]</font></a> 
<a href="/mod/edit_emocao/<?php echo $item->id;?>"><font color="red">[editar]</font></a><br><?}?><b>Código :</b> <?php echo $item->cod;?></li>
<?php $i++; }?></ul><?
if($numpag>1) { 
paginas('chat',$a,$numpag,$id,$pag);     
} } else { ?>
<div class="col-12"><div class="card shadow"><div class="card-body">Nenhum emoção nessa categoria</div></div></div>
<?php 
} 
$tipo = $_POST["cate"];
$smile = trim($_POST["smile"]);
if(!empty($smile)){
if(perm($meuid)<1){
echo $imgerro;?>Você não é da equipe<br><?php
}else{    
if (strpos($smile,".")=== false) {
echo $imgerro;?>Coloque os pontinhos no inicio e no final do codigo.<br><?php
}else{
$texto1 = mb_strlen($smile);
if ($texto1 < 2){
echo "$imgerro Desculpa no minimo 2 caracteres para codigo!<br>";
}else{
$conta_ts = $mistake->prepare("SELECT id,ext FROM w_emocoes WHERE cod='".$smile."'");
$conta_ts->execute();
$conta_ts = $conta_ts->fetch();
if($conta_ts[0]>0){
echo "$imgerro ja existe um smilie com este codigo... <img src='/e/".$conta_ts[0].".".$conta_ts[1]."' class='smilies' oncontextmenu='return false' onselectstart='return false' ondragstart='return false'><br>";
}else{
$arquivo = isset($_FILES["foto"]) ? $_FILES["foto"] : FALSE;
$config["tamanho"] = 5000000;
$config["largura"] = 800;
$config["altura"]  = 800;
if($arquivo){ 
if(!preg_match("/^image\/(jpg|jpeg|png|gif|webp)$/", $arquivo["type"])){
echo "$imgerro Arquivo em formato invalido! A imagem deve ser  (jpg|jpeg|png|gif|webp) . Envie outro arquivo<br>";
}else{
if($arquivo["size"] > $config["tamanho"]){
echo "$imgerro O arquivo e muito grande! A imagem deve ser de no maximo " . $config["tamanho"] . " bytes. Envie outro arquivo<br>";
}else{
$tamanhos = getimagesize($arquivo["tmp_name"]);
if($tamanhos[0] > $config["largura"]){
echo "$imgerro Largura da imagem nao deve ultrapassar " . $config["largura"] . " pixels<br>";
}else{
if($tamanhos[1] > $config["altura"]){
echo "$imgerro Altura da imagem nao deve ultrapassar " . $config["altura"] . " pixels<br>";
}else{
preg_match("/.(gif|png|jpg|jpeg|webp){1}$/i", $arquivo["name"], $ext);
$res = $mistake->exec("INSERT INTO w_emocoes SET cod='".$smile."',ext='".$ext[1]."',cat='".$tipo."'");
$resok = $mistake->lastInsertId();
$imagem_dir = "e/".$resok.".".$ext[1]."";
if($tamanhos["mime"]=='image/webp'){
move_uploaded_file($arquivo["tmp_name"],$imagem_dir);    
}else{
if($tamanhos["mime"]=='image/gif'){
//exec("gif2webp -q 85 ".escapeshellarg($arquivo["tmp_name"])." -o ".escapeshellarg($imagem_dir)."");
//exec("gifsicle -O3 ".escapeshellarg($arquivo["tmp_name"])." -o ".escapeshellarg($imagem_dir)."");
move_uploaded_file($arquivo["tmp_name"],$imagem_dir); 

}else{
//exec("cwebp -q 85 ".escapeshellarg($arquivo["tmp_name"])." -o ".escapeshellarg($imagem_dir)."");
move_uploaded_file($arquivo["tmp_name"],$imagem_dir); 
}
}
echo "$imgok Smilie adicionado com sucesso <img src='/".$imagem_dir."' class='smilies' oncontextmenu='return false' onselectstart='return false' ondragstart='return false'> Codigo = ".$smile."!<br>";
}
}
}
}
}
}
}
}
}
}
if(perm($meuid)>0){
?>
<br><form action="/chat/emocoes/<?php echo $id;?>/<?php echo $pag;?>" method="post" enctype="multipart/form-data">
Smile: <input type="text" class="bt3" name="smile" /><br>
Arquivo:
<input id='input-file' name='foto' type='file' value=''><br>
<input type="hidden" name="cate" value="<?php echo $id;?>" readonly>
<input type="submit" class="bt3" value="Adicionar smile">
</form><br>
<?
}
?>
<div class="col-12 text-center" style="margin-top: 20px"> <a href="/chat/catemocoes"><?php echo $imgsetavoltar;?> Voltar</a></div><br/>
<?php
} 
else if($a=='catemocoes') { ?>
<header><nav class="navbar navbar-light bg-light" style="margin-bottom: 20px"><a class="navbar-brand" href="#"><img src="/style/<?php echo $testearray[30];?>" width="32" height="" alt=""></a></nav></header>
<section class="container-fluid"><div id="titulo">Categoria de Smiles</div><div class="col-12 text-center">
</div><br/>
<?php
$contemo = $mistake->query("SELECT COUNT(*) FROM w_emo_cat WHERE venda='0'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contemo[0];
$itensporpag = 50;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->query("SELECT id, nm FROM w_emo_cat WHERE venda='0' ORDER BY nm asc LIMIT $limit, $itensporpag");
$i=0; while($item = $itens->fetch(PDO::FETCH_OBJ)) {
?>
<div id="<?php echo $i%2==0?'div1':'div1';?>">
<?php
$contemo2 = $mistake->query("SELECT COUNT(*) FROM w_emocoes where cat='".$item->id."'")->fetch(); ?>
<a href="/chat/emocoes/<?php echo $item->id;?>"><?php echo $item->nm;?>(<?php echo $contemo2[0];?>)</a><br/>
</div><?php $i++; 
} 
if($numpag>1) {
paginas('chat',$a,$numpag,$id,$pag);
}
}else{
?>
<div class="col-12"><div class="card shadow"><div class="card-body">Nenhuma categoria.</div></div></div>
<?php    
}
?>
<div class="col-12 text-center" style="margin-top: 20px"> <a <a href="/home"><?php echo $imgsetavoltar;?> Voltar chat</a><br/>
</div><br/>
<?php
}
else if($a=='usuarios') { ?>
<header><nav class="navbar navbar-light bg-light" style="margin-bottom: 20px"><a class="navbar-brand" href="#"><img src="/style/<?php echo $testearray[30];?>" width="32" height="" alt=""></a></nav></header>
<section class="container-fluid"><div class="col-12 text-center">
<?php
if($_GET['acao']=='bloquear' && perm($_GET['user'])==0){
$res = $mistake->exec("INSERT INTO w_ubloq (uid,aid) values('".$meuid."','".$_GET['user']."')");
}
if($_GET['acao']=='desbloquear'){
$mistake->exec("DELETE FROM w_ubloq WHERE uid='".$meuid."' and aid='".$_GET['user']."'");
}
if($_GET['remover']==true){
if(perm($meuid)>2){
$mistake->exec("DELETE FROM w_ochat WHERE schat='".$id."' and uid='".$_GET['remover']."'");
$cotas = $mistake->query("SELECT COUNT(*) FROM perm_sala WHERE sala='$id' and uid='".$_GET['remover']."'")->fetch();
if(cotas[0]>0){
$mistake->exec("DELETE FROM perm_sala WHERE sala='".$id."' and uid='".$_GET['remover']."'");
}}
}
$contemo = $mistake->query("SELECT COUNT(*) FROM w_ochat WHERE schat='$id'")->fetch();
?><div id="titulo">Usuários online (<?php echo $contemo[0];?>)</span></div><?
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contemo[0]; 
$itensporpag = 50;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->query("SELECT id, uid FROM w_ochat WHERE schat='$id' ORDER BY id asc LIMIT $limit, $itensporpag");
$i=0; while($item = $itens->fetch(PDO::FETCH_OBJ)) {
$info = $mistake->prepare("SELECT * FROM w_usuarios where id='".$item->uid."'");
$info->execute();
$info = $info->fetch();
$foto = $info['ft']; 
$conta = $mistake->query("SELECT COUNT(*) FROM w_ubloq where uid='$meuid' and aid='".$item->uid."'")->fetch();
$visi = $mistake->query("SELECT visitante FROM w_usuarios where id='$meuid'")->fetch();
if($item->id==$meuid){
$testar= '<button class="new-button"><img src="/style/add-user.png" height="22" width="22"></button>';
}else{
$verrecc = $mistake->query("SELECT COUNT(*) FROM w_amigos WHERE (uid='$meuid' AND tid='".$item->id."') OR (tid='$meuid' AND uid='".$item->id."')")->fetch();
if($verrecc[0]==0) {
$testar = '<a href="/amigos/editaramigo/'.$item->uid.'/add" title="Enviar Pedido Amizade"><button class="new-button"><img src="/style/add-user.png" height="22" width="22"></button></a>';
}else
$testar= '<a href="/amigos/editaramigo/'.$item->uid.'/excluir" title="Excluir Amigo"><button class="new-button"><img src="/style/del-user.png" height="22" width="22"></button></a>';
}
if($item->id==$meuid){
$testar1='<button class="new-button"><img src="/style/send.png" height="22" width="l22"></button>';
}else{
$testar1='<a href="/mensagens1/lermsg/'.$item->uid.'" title="Enviar Mensagem"><button class="new-button"><img src="/style/send.png" height="22" width="22"></button></a>';
}
?>
<ul class="list-group shadow"><li class="list-group-item"><center><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha1; ?>">Id: <b><?php echo $info['id'];?></b></center>
<a href="/chat?a=sala&para=<?php echo $item->uid;?>&id=<?php echo $id;?>" style="font-size: 16px; display: block; text-align: center"><?php echo gerarnome($item->uid);?></a><?if($visi[0]==0){?><br/><center><a href="/<?php echo gerarlogin($item->uid);?>">Ver perfil</a><br/>
<a href="/doar_p?id=<?php echo $info['id'];?>" style="color:<?php echo $info['links'];?>;">Doar pontos</a><br/>
<a href="/doar_m?id=<?php echo $info['id'];?>" style="color:<?php echo $info['links'];?>;">Doar Moedas</a><br/>
<td width="50%"><?php echo $testar1;?></td><td width="50%">    <?php echo $testar?></center><?}if($info['ft']==true){?><img class="img-circle" style="width: 42px; height: 42px" src="/<?php echo $foto;?>" oncontextmenu="return false" onselectstart="return false" ondragstart="return false" style="width:86px;height:100px;border-radius:50%; margin:1px; border:2px solid #FFF;" pbsrc="/<?php echo str_replace('m_','',$foto);?>" class="PopBoxImageSmall" title='<?php echo $info['nm'];?>' onclick="Pop(this,50,'PopBoxPopImage');" /><?}else{?><i class="fas fa-user-circle" style="color: #c0c0c0; font-size: 42px; margin-right: 12px; float: left"></i><?} ?><?if($item->uid!=$meuid){if($conta[0]==0){?><a href="/chat?a=usuarios&acao=bloquear&user=<?php echo $item->uid;?>&id=<?php echo $id;?>" class="btn btn-danger btn-sm" style="float: right; margin: 8px 0 0 6px"><i class="fas fa-ban" style="color: #ffffff" style="font-size: 14px"></i></a><?}else{?><a href="/chat?a=usuarios&acao=desbloquear&user=<?php echo $item->uid;?>&id=<?php echo $id;?>" class="btn btn-dark btn-sm" style="float: right; margin: 8px 0 0 6px"><i class="fas fa-ban" style="color: #ffffff" style="font-size: 14px"></i></a><?}}?><?if(perm($meuid)>0){?><b style="float: right; margin: 8px 0 0 6px"><div class='tituloWrapper'><!--<i class="fas fa-cog" style="color: #1e90ff; font-size: 26px"></i>--><br/><span class='tituloo' style='font-size:10px'><a href="/mod/editarusuario/<?php echo $item->uid;?>">Editar usuário</a><br/><a href="/chat?a=usuarios&id=<?php echo $id;?>&remover=<?php echo $item->uid;?>">Remover da sala</a></span></div></div></b><?}?></li>
<?php $i++; 
} 
if($numpag>1) {
paginas('chat',$a,$numpag,$id,$pag);
}
}else{
?>
<div class="col-12"><div class="card shadow"><div class="card-body">Nenhum usuário</div></div></div>
<?php    
}
?>
<center> <a href="/chat?a=sala&id=<?php echo $id;?>"><?php echo $imgsetavoltar;?> Voltar pro chat</a></center>
<?php
}
else if($a=='buscar2') { ativo($meuid,'Buscando no chat ');
if($pag==FALSE)
{
$_SESSION['txtbusca'] = $_POST['txtbusca'];
}
if(trim($_SESSION['txtbusca'])==FALSE) { ?>
<br/><div align="center">Digite um texto para concluir a pesquisa<br/>
<?php } else { ?>
<div class="menu"><b>Resultado da Busca por <?php echo $_SESSION['txtbusca'];?></b></div><br/>
<?php
if(perm($meuid)>0)
{
$noi = $mistake->query("SELECT COUNT(*) FROM w_mchat WHERE txt LIKE '%".$_SESSION['txtbusca']."%'")->fetch();
}
else
{
$noi = $mistake->query("SELECT COUNT(*) FROM w_mchat a, w_schat b WHERE a.p='0' and a.schat=b.id and b.perm='0' and a.txt LIKE '%".$_SESSION['txtbusca']."%'")->fetch();
}
if($pag=='' || $pag<1)$pag=1;
$num_items = $noi[0];
$items_per_page = 20;
$numpag = ceil($num_items/$items_per_page);
if(($pag>$numpag)&&$pag!=1)$pag= $numpag;
$limit_start = ($pag-1)*$items_per_page;
if($num_items>0) {
if(perm($meuid)>0)
{
$itens = $mistake->query("SELECT * FROM w_mchat WHERE txt LIKE '%".$_SESSION['txtbusca']."%' ORDER BY id desc LIMIT $limit_start, $items_per_page");
}
else
{
$itens = $mistake->query("SELECT * FROM w_mchat a, w_schat b WHERE a.p='0' and a.schat=b.id and b.perm='0' and a.txt LIKE '%".$_SESSION['txtbusca']."%' ORDER BY a.id desc LIMIT $limit_start, $items_per_page");
}
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) {
if($item->por=='00') { ?>
<div style="background-color:#ffffcc;padding:2px;margin-top:4px;">
<font size="1"><i><?php echo textot($item->txt,$meuid,$on);?></i><br/>
<?php echo date("d/m/Y - H:i:s", $item->hr);?></font></div>
<?php } else { ?>
<span class="<?php echo $i%2==0?'user':'div2';?>">
<i><a href="/<?php echo gerarlogin($item->por);?>"><?php echo gerarnome($item->por);?></a></i> para <i><?php if($item->para==0) {?>todos<?php } else { ?><a href="/<?php echo gerarlogin($item->para);?>">
<?php echo gerarnome($item->para); } ?></a></i>: <?php echo textot($item->txt,$meuid,$on);?><br/>
<font size="1"><?php echo date("d/m/Y - H:i:s", $item->hr);?></font></span>
<?php } $i++; } } else { ?>
<div align="center">Não foi encontrada nenhuma mensagem com o texto <?php echo $_SESSION['txtbusca']; } ?>
<br/><div align="center">
<?php if($pag>1) { $ppag = $pag-1; ?>
<a href="chat?a=buscar2&pag=<?php echo $ppag;?>">&#171;Anterior</a>
<?php } if($pag<$numpag) { $npag = $pag+1; ?>
<a href="chat?a=buscar2&pag=<?php echo $npag;?>">Próxima&#187;</a>
<?php } ?>
<br/><?php echo $pag.'/'.$numpag;?><br/><br/>
<?php if($numpag>2) { ?>
<form action="chat" method="get">
Pular para página<input name="pag" size="3">
<input type="submit" value="IR">
<input type="hidden" name="a" value="<?php echo $a;?>">
</form>
<?php } } } ?>
<br/><div align="center">
<?php 
?>
<button type="button" class="btn btn-dark btn-circle up" style="position: fixed; bottom: 14px; right: 14px; z-index: 2; display: none"><i class="fas fa-arrow-up"></i></button> </section><script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script><script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script><script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
<!--<script src="https://<?php //echo $_SERVER["HTTP_HOST"];?>/js/funcoes.js?tm=<?php echo time();?>"></script>-->
<?php
echo "<center><a href='#'>Topo</a></center>";
echo "<center>";
if(perm($meuid)>0) { ?><a href="/mod" style="color:<?php echo $info['links'];?>;">Opções da equipe</a><br/> <?php }
echo "</center>";
?>
<?php
if($_COOKIE['atividades']==false){
setcookie('atividades',$meuid,(time() + (1800 * 1)), '/');
$res =  $mistake->exec("update w_usuarios set atividades=atividades+1 where id='$meuid'"); 
}
?>
<?php echo rodape($meuid);
?>