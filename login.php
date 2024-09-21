<?php
require_once("".$_SERVER["DOCUMENT_ROOT"]."/funcoes.php");
require_once("".$_SERVER["DOCUMENT_ROOT"]."/mistake.php");
$senha = md5($_GET['senha']);
$usuario = $_GET['usuario'];
$salvar = $_GET['salvar'];
$armazenar = $_GET['armazenar'];
$autologin = $_GET['autologin'];
/*
if(isset($_COOKIE['spam'])==1){
echo "<br /><div align='center'>".$imgerro." Este ip <b>".gerarip()."</b> esta banido no site aguarde sua punição!<br/><br/><a href='/'>".$imginicio."Inicio</a></div><br />";
rodape(); 
exit();
}*/
maiortempo();
$frases = $mistake->query("SELECT txt FROM w_frases WHERE cartas='0' order by rand()")->fetch();
function pega_brw($navegador){
if (preg_match('?MSIE ([0-9].[0-20]{1,2})?',$navegador,$matched)){
$browser_version = $matched[1];
$browser = 'Internet Explorer';
}else
if (preg_match('?Trident/([0-9\.]+)?',$navegador,$matched)){
$browser_version = $matched[1];
$browser = 'Internet Explorer';
}else
if (preg_match('?Opera/([0-9].[0-9]{1,2})?',$navegador,$matched)){
$browser_version = $matched[1];
$browser = 'Opera';
}else
if (strrpos($navegador,'OPR')){
$posicao_inicial = strpos($navegador,'OPR') + strlen('OPR');
$browser_version = substr($navegador,$posicao_inicial,14);
$browser = 'Opera';
}else
if (preg_match('?Firefox/([0-9\.]+)?',$navegador,$matched)){
$browser_version = $matched[1];
$browser = 'Mozilla Firefox';
}else
if (preg_match('?Edge/([0-9\.]+)?',$navegador,$matched)){
$browser_version = $matched[1];
$browser = 'Edge';
}else
if (preg_match('?UCBrowser/([0-9\.]+)?',$navegador,$matched)){
$browser_version = $matched[1];
$browser = 'UC Browser';
}else
if (preg_match('?UBrowser/([0-9\.]+)?',$navegador,$matched)){
$browser_version = $matched[1];
$browser = 'UC Browser';
}else
if (preg_match('?Chrome/([0-9\.]+)?',$navegador,$matched)){
$browser_version = $matched[1];
$browser = 'Chrome';
}else
if (preg_match('?Safari/([0-9\.]+)?',$navegador,$matched)){
$browser_version = $matched[1];
$browser = 'Safari';
}else{
$browser_version = 0;
$browser = 'Navegador Desconhecido';
}
return "$browser $browser_version";
}
/*
?>
<br /><fieldset><legend><strong><img src="/style/informacao.gif" alt="img" />Dicas</strong></legend>
<?
echo textot($frases['txt'],1,$on);
?>
</div></fieldset>
<?*/
$id = $mistake->prepare("SELECT * FROM w_usuarios WHERE id=:id AND sh=:sh OR lg=:lg AND sh=:sh OR email=:email AND sh=:sh OR celular=:celular AND sh=:sh");
$id->execute(array(":id" => "".$usuario."",":sh"=>"".$senha."",":lg" => "".$usuario."",":sh"=>"".$senha."",":email" => "".$usuario."",":sh"=>"".$senha."",":celular" => "".$usuario."",":sh"=>"".$senha.""));
$id = $id->fetch();
if($id['id'] == TRUE){
if($id['liberado']==0) { 
?>
<br/><div align="center"><b><big>Cadastro pendente</b></big><br/>Seu cadastro será analizado pela equipe do site e caso tudo esteja dentro das normas estabelecidas em nossas regras será liberado em breve.<br/>Por favor aguarde alguns minutos.<br/><br/><a href="/login?usuario=<?php echo $usuario;?>&senha=<?php echo $_GET['senha'];?>">Recarregar....</a></div>
<?php 
rodape(); 
exit();
}
$conta = $mistake->prepare("SELECT COUNT(*) FROM w_ban WHERE uid='".$id['id']."'");
$conta->execute();
$conta = $conta->fetch();
if($conta[0]>0){
?><div align="center">Você está banido, aguarde o fim da punição.<br/><br/><a href="/"><?php echo $imginicio;?>Página inicial</a><br><br><?
rodape();
exit();
}
if($id['banido']==1) { 
setcookie("spam",1,(time() + (86400 * 7)),"/",".".str_replace("www.","",$_SERVER["HTTP_HOST"])."");
?>
<br/><div align="center"><?php echo $imgerro;?>Você está banido...<br/><br/><a href="/">Inicio</a></div>
<?php 
rodape(); 
exit(); 
}
if (!empty($salvar)) {
setcookie("autologin",(1),time() + 86400 * 60,"/",".".str_replace("www.","",$_SERVER["HTTP_HOST"])."");
setcookie("auto_usuario","".$id['id']."",time() + 86400 * 60,"/",".".str_replace("www.","",$_SERVER["HTTP_HOST"])."");
setcookie("auto_senha","".$_GET["senha"]."",time() + 86400 * 60,"/",".".str_replace("www.","",$_SERVER["HTTP_HOST"])."");
}	
setcookie("auto_usuario","".$id['id']."",time() + 86400 * 60,"/",".".str_replace("www.","",$_SERVER["HTTP_HOST"])."");
setcookie("auto_senha","".$_GET["senha"]."",time() + 86400 * 60,"/",".".str_replace("www.","",$_SERVER["HTTP_HOST"])."");
$xtm = time();
$tdid = $id['id'].$xtm.$id['id'];
$gerar = md5($tdid);
$_SESSION["on"] = $gerar;
setcookie("on",$_SESSION["on"],(time() + (86400 * 7)));
if($id['vschat']==0){
setcookie("hall","".$id['id']."",(time() + (86400 * 7)),"/",".".str_replace("www.","",$_SERVER["HTTP_HOST"])."");
$vschat = 0;
}else{
setcookie("hall",null, -1,"/",".".str_replace("www.","",$_SERVER["HTTP_HOST"])."");
$vschat = 1;    
}
if($id['perm']==4){
setcookie("diretorio","".$id['id']."",(time() + (86400 * 7)),"/",".".str_replace("www.","",$_SERVER["HTTP_HOST"])."");
}
if($id['vip']==4){
$dados = $mistake->prepare("SELECT data,dias FROM vipalugado WHERE uid='".$id['id']."'");
$dados->execute();
$dados = $dados->fetch();
$tempo6 = ($dados[0] + $dados[1]*24*60*60);
if($tempo6 < time()){
$mistake->exec("UPDATE w_usuarios SET vip='0',senhaequipe='MISTAKE' WHERE id='".$id['id']."'");
$mistake->exec("DELETE FROM vipalugado WHERE uid='".$id['id']."'");
$nick = gerarnome2($id['id']);
$msg = "Oi seu Vip Alugado Expirou Alugue Novamente Obrigado.";
automsg($msg,1,$id['id']);
}
}
setcookie("reg",1,(time() + (86400 * 7)),"/",".".str_replace("www.","",$_SERVER["HTTP_HOST"])."");
if($id['codigo']==1){
$ip = isset($ip) ? $ip : gerarip();
$url = 'http://ip-api.com/json/'.$ip;
$response = open_url($url);
$ip_info = json_decode($response);
}
$cityM = isset($ip_info->city) ? $ip_info->city : 'Indefinido';
$regionM = isset($ip_info->regionName) ? $ip_info->regionName : 'Indefinido';
/*
$cityM = isset($_SERVER["GEOIP_CITY"]) ? $_SERVER["GEOIP_CITY"] : 'Indefinido';
$regionM = isset($_SERVER["GEOIP_REGION_NAME"]) ? $_SERVER["GEOIP_REGION_NAME"] : 'Indefinido';
*/
$mistake->exec("UPDATE w_usuarios SET onl='".$_SESSION['on']."',to1='".time()."',vschat='$vschat',inativo='".time()."',ativo='".time()."',ultimologin='".time()."',onlf='Entrando no site',nav='".$_SERVER['HTTP_USER_AGENT']."',ip='".gerarip()."',navr='".pega_brw($_SERVER['HTTP_USER_AGENT'])."',cid='".$cityM."',est='".$regionM."' where id='".$id['id']."'");
$timeoutti = time()-604800;
$mistake->exec("DELETE FROM w_harem WHERE tempo <'".$timeoutti."'");
$mistake->exec("DELETE FROM w_novoreg WHERE hr<'$timeoutti'");
$timeoutt = time()-300;
$mistake->exec("DELETE FROM w_ochat WHERE um<'$timeoutt'");
$mistake->exec("DELETE FROM w_mchat WHERE hr<'$timeoutt'");
$mistake->exec("DELETE FROM w_depo WHERE hr<'$timeoutt'");
if($id['vs']==0){
$mistake->exec("UPDATE w_geral SET entrou='".$id['id']."'");
}
if($id['visitante']==1){
header("Location:/home?");
} 
if($testearray[70]==3){
$ale = time()-1209600;
$usual = $mistake->prepare("SELECT id FROM w_usuarios WHERE ativo < '".$ale."' and banido='0' order by rand() limit 1");
$usual->execute();
$usual = $usual->fetch();
if(rand(0,8)==1 && $usual[0]>0){
$alem = 'Página principal';
$mistake->exec("UPDATE w_usuarios SET ativo='".time()."',inativo='".time()."',onlf='".$alem."' where id='".$usual[0]."'");
$mistake->exec("UPDATE w_geral SET entrou='".$usual[0]."'");
}else
if(rand(0,8)==2 && $usual[0]>0){
$alem = 'Lendo mensagem';
$mistake->exec("UPDATE w_usuarios SET ativo='".time()."',inativo='".time()."',onlf='".$alem."' where id='".$usual[0]."'");
$mistake->exec("UPDATE w_geral SET entrou='".$usual[0]."'");
}else
if(rand(0,8)==3 && $usual[0]>0){
$alem = 'Sessão porno';
$mistake->exec("UPDATE w_usuarios SET ativo='".time()."',inativo='".time()."',onlf='".$alem."' where id='".$usual[0]."'");
$mistake->exec("UPDATE w_geral SET entrou='".$usual[0]."'");
}
}
$dir = new DirectoryIterator("".$_SERVER["DOCUMENT_ROOT"]."/msgs/");
foreach ($dir as $item) {
if ($item->isDot()) {
continue;
}
$teste = $item->getFilename();
$teste1 = $item->getMTime();
$altm = time()-(5 * 24 * 60 * 60);
if($altm>$teste1&&$teste!='index.html'){
@unlink("".$_SERVER["DOCUMENT_ROOT"]."/msgs/$teste");
}
}
if ($autologin=='1'){
header("Location:/home");
}
if ($autologin=='0'){
header("Location:/home");
}
?>
<div id="div1" align="center">Olá <a href="/<?php echo gerarlogin($id['id']);?>"><?php echo gerarnome($id['id']);?></a>, Seja bem vind<?php echo $id['sx']=='M'?'o':'a';?>.<br/>
</div><div id="div2" align="center"><a href="/home?"><?php echo $imginicio;?>Ir para o chat</a></div><br/>
<?php 
}else{ 
if (!isset($_SESSION['tentativas'])) {
$_SESSION['tentativas'] = 1;
}
if (isset($_GET['usuario'])) {
$_SESSION['tentativas']++;
}
if ($_SESSION['tentativas'] > 4) {
foreach ($_COOKIE as $cookie_name => $cookie_value) {
setcookie($cookie_name,null,-1,"/",".".str_replace("www.","",$_SERVER["HTTP_HOST"])."");
}
session_destroy();
setcookie("spam",1,(time() + (3600 * 1)),"/",".".str_replace("www.","",$_SERVER["HTTP_HOST"])."");
}
header("Location:/online?a=login2&erro=1");
?>
<br/><div align="center"><?php echo $imgerro;?>Usuário incorreto<br/><br/><a href="/">Tentar novamente</a></div><br />
<?php    
} 
rodape(); ?>
</body>
</html>