<?php
ini_set("session.cookie_domain",".".str_replace("www.","",$_SERVER["HTTP_HOST"])."");
session_start();
ob_start('comprimir_pagina');
function comprimir_pagina($buffer) {
$search = array("/ +/" => " ","/[\t\r\n]|<!\[CDATA\[|\/\/ \]\]>|\]\]>|\/\/\]\]>|\/\/<!\[CDATA\[/" => "");
$buffer = preg_replace(array_keys($search), array_values($search), $buffer);
return $buffer;
}

header("Content-type: text/html; charset=UTF-8");
header("Pragma: no-cache");
header("Expires: Mon, 20 Jul 2000 03:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, cachehack=" . time());
header("Cache-Control: no-store, must-revalidate");
header("Cache-Control: post-check=-1, pre-check=-1", false);
date_default_timezone_set("America/Sao_Paulo");
if(basename($_SERVER["PHP_SELF"])==basename(__FILE__)){
exit("<script>alert('Não Permitido')</script>\n<script>window.location=('/')</script>");
}
$meuid = isset($_COOKIE['on']) ? getuid_sid($_COOKIE['on']) : 0;
$tema = $mistake->prepare("SELECT tema FROM w_usuarios WHERE id='$meuid'");
$tema->execute();
$tema = $tema->fetch();
$temas=$meuid==0?"padrao":''.$tema[0].'';
$testearray = include_once("".$_SERVER["DOCUMENT_ROOT"]."/novoarray.php");
echo '<!doctype html><html lang="pt-br"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><link rel="icon" href="/favicon.ico"><title>'.ucfirst($_SERVER['USER']).'</title><meta name="turbolinks-cache-control" content="no-cache"><meta name="author" content=""><meta name="HandheldFriendly" content="true"><meta name="MobileOptimized" content="width"><meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=2.0, user-scalable=yes"><meta name="keywords" content="Namoro,Downloads,Rede Social"><meta name="description" content="Rede Social voltada para dispositivos moveis,com muitos downloads,chat webcam,namoros,Diversao e muito mais,tudo isso gratis!"/><link rel="manifest" href="/manifest.json"><meta name="theme-color" content="'.$testearray[44].'"><link href="/'.$testearray[59].'" type="text/css" rel="stylesheet"/><link href="/'.$testearray[62].'" type="text/css" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css"><link rel="preconnect" href="https://fonts.gstatic.com"><link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"><link rel="stylesheet" href="/'.$temas.'.css?60">
';
$meuid = isset($_COOKIE['on']) ? getuid_sid($_COOKIE['on']) : 0;
$urll = $_SERVER['PHP_SELF'];
$a=isset($_GET['a'])?$_GET['a']:'';
$pag=isset($_GET['pag'])?$_GET['pag']:'';
$id=isset($_GET['id'])?$_GET['id']:'0';
$del=isset($_GET['del'])?$_GET['del']:'';
$e=isset($_GET['e'])?$_GET['e']:'';
$amigosmax=200;
if(isset($_COOKIE['ocimg'])==false)  echo '<link href="/ionicons.min.css" type="text/css" rel="stylesheet"/>';
?>
<script src="/mis.jquery.min.js"></script>

<?
echo '</head><body>';
if($_SERVER['PHP_SELF']!='/chat.php' and $urll!='/index.php' and $urll!='/online.php' and $urll!='/home.php'  ){
?>
<div align="left">
<select onChange="location=options[selectedIndex].value">
<option value="#">Selecione</option>
<option value="/home?">Página principal</option>
<option value="/recados?id=<?php echo $meuid;?>">Recados</option>
<option value="/mensagens/entrada">Mensagens</option>
<option value="/entretenimento/diversao">Diversão</option>
<option value="/amigos?">Amigos</option>
<option value="/configuracoes?">Painel do usuário</option>
</select>
</div>
<?php
require_once("games.php");
?>
<a href="" id="scroll-top"><mis class="up"></mis></a>
<?php
}
$umsg2 = $mistake->prepare("SELECT COUNT(*) FROM w_msgs WHERE pr='$meuid' AND ld='0' and dl='1'");
$umsg2->execute();
$umsg2 = $umsg2->fetch();
if($umsg2[0]>0){
$simdeum = "/mensagens/coletiva";
echo'<div align="center" id="opc4"><a href="/mensagens/coletiva" style="padding:7px 0;">('.$umsg2[0].')&nbsp;Avisos!</a></div>';
}
require ("".$_SERVER["DOCUMENT_ROOT"]."/img.php");
if($meuid!=0){
$im = $mistake->prepare("SELECT ocimg,oclogo,ocme,ocmu,ocmu2,ocmu3,visi,stats,bg,atlh,notifica,dest,pt,paginas,nm,cxmsg FROM w_usuarios WHERE id='$meuid'");
$im->execute();
$im = $im->fetch();
$pmnaolida = $mistake->prepare("SELECT COUNT(*) FROM w_msgs WHERE pr='$meuid' AND ld='0' and dl='0'");
$pmnaolida->execute();
$pmnaolida = $pmnaolida->fetch();
$todaspms = $mistake->prepare("SELECT COUNT(*) FROM w_msgs WHERE pr='$meuid' and dl='0'");
$todaspms->execute();
$todaspms = $todaspms->fetch();
$umsg2 = $mistake->prepare("SELECT COUNT(*) FROM w_msgs WHERE pr='$meuid' AND ld='0' and dl='1'");
$umsg2->execute();
$umsg2 = $umsg2->fetch();
$reqs1 = $mistake->prepare("SELECT COUNT(*) FROM w_amigos WHERE tid='$meuid' AND ac='0'");
$reqs1->execute();
$reqs1 = $reqs1->fetch();
$tipo = $mistake->query("SELECT visitante FROM w_usuarios WHERE id='$meuid'")->fetch();

$simdeu = "/mensagens/entrada";    
$simdeum = "/mensagens/coletiva";
if($im[0]==0){
$minhafo='<a href="/'.gerarlogin($meuid).'">'.gerarfoto($meuid,22,20).'</a>';
$novaa='';
$novac='';
$novam='';
if($reqs[0]==0){
$imag1="<div class='pmst'>$amigo</div>";
}
if($reqs[0]>0){
$imag1="<div class='pmst'>$amigos<span class='pms pmsn'>$reqs[0]</span></a></div>";
}
if($pmnaolida[0]==1){
$imag2= "<div class='pmst'>$mensa<span class='pms pmsn'>$pmnaolida[0]</span></a></div>";
}
if($pmnaolida[0]>1){
$imag2= "<div class='pmst'>$mensa<span class='pms pmsn'>$pmnaolida[0]</span></a></div>";
}
if($pmnaolida[0]==0){
$imag2= "<div class='pmst'>$mensa</div>";
}
if($umsg2[0]==1){
$imag3="<div class='pmst'>$notif<span class='pms pmsn'>$umsg2[0]</span></a></div>";
}
if($umsg2[0]>1){
$imag3="<div class='pmst'>$notif<span class='pms pmsn'>$umsg2[0]</span></a></div>";
}
if($umsg2[0]==0){
$imag3="<div class='pmst'>$notif</div>";
}
?>
<?
if($tipo[0]==0){
?>
<?php 
require_once("games.php");

$sorte5=rand(1,999);
if($testearray[26]==1){
if($sorte5=='1' or $sorte5=='79' or $sorte5=='549'){
$_SESSION['tempopoke'] = time();
?>
<br/><center><a href="/pokemon/capturar/<?php echo rand(1,148);?>"><img src="/pokem/<?php echo rand(1,148);?>.png" style="width:70px;height:70px;"></a></center><br/>
<?php
} 
}
if($testearray[27]==1){
if($sorte5=='29' or $sorte5=='99' or $sorte5=='209'){
$_SESSION['tempopombo'] = time();
?>
<br/><center><a href="/pegueopombo/capturar"><img src="/imgs/pombo.gif"></a></center><br/>
<?php
} 
$esti = $mistake->query("SELECT pokemongo FROM w_usuarios WHERE id='".$meuid."'")->fetch(); 
$noi = $mistake->query("SELECT total FROM pokemontabla WHERE uid='".$meuid."'")->fetch();
if($esti[0]==1){
if($noi[0]>"149"){
require_once("pokem2.php");
}else{
require_once("pokem.php"); 
} 
}
?>
<?php
}
if($testearray[28]==1){
if($sorte5=='9' or $sorte5=='199' or $sorte5=='759'){
$_SESSION['cartas'] = time();
?>
<br/><center><a href="/cartas/receber"><img src="/juegos/pergaminos.gif" style="width:60px;height:60px"></a></center><br/>
<?
}
} 
?>
<?php
}
/*
?>
<hr><table style='width:100%' align='center'><tr><td width='20%' align='center'><?php echo $imag1;?></td><td width='20%' align='center'><?php echo $imag2;?></td><td width='20%' align='center'><?php echo $imag3;?></td><td width='20%' align='center'><div class='pmst'><?php echo $conf;?></div></td><td width='20%' align='center'><div class='pmst'><?php echo $minhafo;?></div></td></tr></table>
<?
*/
}else{
if($umsg2[0]>0) { 
$novac='<div align="center" id="opc4"><a href="/mensagens/coletiva" style="padding:7px 0;"><img src="/style/notificacoess.gif">&nbsp;<b>('.$umsg2[0].')&nbsp;Novas Coletivas!</b></a></div>';
}
if($pmnaolida[0]>0) { 
$novam='<div align="center" id="opc4"><a href="/mensagens/entrada" style="padding:7px 0;"><img src="/style/msg1.gif">&nbsp;<b>('.$pmnaolida[0].')&nbsp;Novas Mensagens!</b></a></div>';	
}
?>
<?php
}
echo $novaa;
echo $novac;
echo $novam;
$sorte6=rand(1,12);
}
$ban = $mistake->prepare("SELECT COUNT(*) FROM w_ban WHERE ip='".gerarip()."'");
$ban->execute();
$ban = $ban->fetch();
if($ban[0]>0){
?><div align="center">O seu IP <b><?php echo gerarip();?></b> está banido de nosso site,aguarde o fim da punição.</div><br/><?
rodape();
exit();
}