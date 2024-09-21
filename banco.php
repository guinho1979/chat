<?php
require_once("".$_SERVER["DOCUMENT_ROOT"]."/funcoes.php");
require_once("".$_SERVER["DOCUMENT_ROOT"]."/mistake.php");
seg($meuid);
ativo($meuid,'Banco '); 
if(pts($meuid)<800){
echo "<div align='center'><b>Voce precisa ter no minimo 800 Pontos!</b></div>";
?>
<div align="center">
<a href="/entretenimento?"><?php echo $imgservicos;?>Entretenimento</a><br/>
<a href="/home?"><?php echo $imginicio;?>Página principal</a><br><br>
<?php 
require 'rodape.php';
exit();
}
$i = $mistake->query("SELECT ocimg, bank FROM w_usuarios WHERE id='$meuid'")->fetch();
?> <br/><div align="center">
<?php if($a==false) { ?>
<div id="titulo"><b>Banco</b></div><br/>
Olá <?php echo gerarnome($meuid);?> Deposite seus pontos e ganhe 5% de juros por mês.<br/><br/>
Você tem <?php echo pts($meuid);?> pontos em mãos<br/>
e <?php echo $i[1];?> depositados.<br/><br/>
<a href="/banco?a=depositar">Depositar pontos</a><br/>
<a href="/banco?a=retirar">Retirar pontos</a><br/><br/>
<?php } else if($a=='depositar') { ?>
<div id="titulo"><b>Depositar pontos</b></div><br/>
Você tem <?php echo pts($meuid);?> pontos em mãos<br/>
e <?php echo $i[1];?> depositados.<br/><br/>
<form action="banco?a=depositar2" method="post">
Informe o valor a ser depositado.<br/>
<input name="ptg" maxlength="5"><br/>
<input type="submit" value="Depositar">
</form>
<?php }else 
if($a=='retirar') {
$banco = $mistake->query("SELECT bank FROM w_usuarios WHERE id='$meuid'")->fetch(); ?>
<div id="titulo"><b>Retirar pontos</b></div><br/>
Você tem <?php echo pts($meuid);?> pontos em mãos!<br/>
e <?php echo $banco[0];?> depositados.
<form action="banco?a=retirar2" method="post">
Informe a quantidade a ser retirada<br/><input name="ptg" maxlength="5">
<br/><input type="submit" value="Retirar"></form>
<?php 
}else 
if($a=='depositar2') {
$ptg = $_POST['ptg'];
if(pts($meuid)>$ptg && $ptg>100){
$res = $mistake->exec("UPDATE w_usuarios SET bank=bank+$ptg WHERE id='$meuid'");
$mistake->exec("UPDATE w_usuarios SET pt=pt-$ptg WHERE id='$meuid'");
if($res){
echo $imgok;?>pontos depositados com sucesso!
<?php 
}else{ 
echo $imgerro;?>Erro ao depositar pontos, tente novamente!
<?php 
} 
}else{ 
echo $imgerro;?>Você não tem pontos suficientes para depositar!
<?php 
} 
?> 
<br/><br/> 
<?php
}else 
if($a=='retirar2') {
$ptg = $_POST['ptg'];
$gpsf = $mistake->query("SELECT bank FROM w_usuarios WHERE id='$meuid'")->fetch();
if($gpsf[0]>$ptg && $ptg>100){
$res = $mistake->exec("UPDATE w_usuarios SET pt=pt+$ptg WHERE id='$meuid'");
$mistake->exec("UPDATE w_usuarios SET bank=bank-$ptg WHERE id='$meuid'");
if($res){
echo $imgok;?>pontos retirados com sucesso!
<?php 
}else{ 
echo $imgerro;?>Erro no banco de dados, tente novamente!
<?php
} 
}else{ 
echo $imgerro;?>Você não tem esses pontos no banco!
<?php 
}  
?> 
<br/><br/> 
<?php
} 
?>
<div align="center">
<div class="col-12 text-center" style="margin-top: 20px"><a href="javascript:window.history.back();"><?php echo $imgsetavoltar;?> Voltar</a></div><br/>
<?php echo rodape();?>
</body>
</html>