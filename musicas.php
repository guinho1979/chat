<?php
require_once("".$_SERVER["DOCUMENT_ROOT"]."/funcoes.php");
require_once("".$_SERVER["DOCUMENT_ROOT"]."/mistake.php");
seg($meuid);
ativo($meuid,'Musicas para perfil');
echo"<div id='titulo'>Lista de musicas Disponiveis</div><br>";
if(isset($_GET['pag'])){
$n = "pag=".$_GET['pag']."";    
}
$getm = $_GET['US']==true?$_GET['US']:'MiStAkE';
$GrabURL = @open_url('https://celumaniacos.tk/musicas?'.$n.'&US='.str_replace(' ','',$getm).'&token='.base64_encode($_SERVER['SERVER_ADDR']).'');
echo "$GrabURL";
?>
<br/><div align="center"><a href="configuracoes?"><?php echo $imgpreferencias;?>Painel do Usuário</a>
<br/><div align="center"><a href="home"><?php echo $imginicio;?>Página principal</a><br><br>
<?
rodape();
?>
</html></body>