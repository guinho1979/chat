<?php
require_once("".$_SERVER["DOCUMENT_ROOT"]."/funcoes.php");
require_once("".$_SERVER["DOCUMENT_ROOT"]."/mistake.php");
seg($meuid);



ativo($meuid,'Enviando opiniao ');
if($a==false) { ?>
<div id="titulo"><b>Envie sua opiniao</b></div><br/><center>
<form action="sugestoes?a=enviar" method="post">
Se você tem alguma sugestão de melhorias para nosso site, deixe aqui para nós, que iremos analisar e se possível adicionar no site.<br/><br/>
<input type="text" name="nome" /><br/>
<input type="submit" value="Enviar" />
</form>
<?php } else if($a=='enviar') {
if(empty($_POST['nome'])){
?>
<div align="center"><br/><?php echo $imgerro;?> Você precisa digitar o texto..<br/><br/>
<?php
}else{
$res = $mistake->exec("INSERT INTO w_ajuda (uid,txt) values('$meuid','".$_POST['nome']."')");
if($res) { ?>
<div align="center"><br/><?php echo $imgok;?> Sua opinião foi enviada com sucesso, muito obrigado(a).<br/><br/>
<?php } else { ?>
<div align="center"><br/><?php echo $imgerro;?> Erro, tente novamente.<br/><br/>
<?php } }} if($a==true) { ?>
<div align="center"><a href="?"><?php echo $imgajuda;?>Voltar</a> <?php } ?>
<br/><div align="center"><a href="home?"><?php echo $imginicio;?>Página principal</a><br><br>
<?php echo rodape();?>
</body>
</html>