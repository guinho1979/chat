<?php
$senha = md5($_GET['senha']);
$usuario = $_GET['usuario'];
$salvar   = $_GET['salvar'];
$armazenar   = $_GET['armazenar'];
$autologin   = $_GET['autologin'];
if (!empty($salvar)) {
setcookie("autologin",(1),time() + 86400 * 60);
setcookie("auto_usuario",($_GET["usuario"]),time() + 86400 * 60);
setcookie("auto_senha",($_GET["senha"]),time() + 86400 * 60);
}	
if ($armazenar=='1')
{
setcookie("usuario",($_GET["usuario"]),time() + 86400 * 60);
setcookie("senha",($_GET["senha"]),time() + 86400 * 60);
}
if ($autologin=='1')
{
header("Location:login?usuario=$usuario&senha=$senha&autologin=1");
}else{
header("Location:login?usuario=$usuario&senha=$senha");
}
?>