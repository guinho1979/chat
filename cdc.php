<?php
require_once("".$_SERVER["DOCUMENT_ROOT"]."/funcoes.php");
require_once("".$_SERVER["DOCUMENT_ROOT"]."/mistake.php");
seg($meuid);
if(visitante($meuid)>0){
echo "<div align='center'><b>Para visualizar essa página você precisa estar cadastrado!</b></div>";
?>
<div align="center">
<a href="/registrar?">Cadastrar agora</a><br/>
<a href="/home?"><?php echo $imginicio;?>Página principal</a><br><br>
<?php 
echo 
rodape();
exit();
}
ativo($meuid,'Par ou ímpar ');
if($a==false) { ?>
<br/><div id="titulo"><b>Corrida de cavalos</b></div><br/>
<a href="cdc?a=jcc">Jogar com o computador</a><br/>
<a href="cdc?a=du">Desafiar usuário</a><br/>
<?php } else if($a=='jcc') { ?>
<br/><div id="titulo"><b>Corrida de cavalos</b></div><br/>
<div align="center">
Acerte qual cavalo chegará primeiro!<br/>
Você podera apostar de 1 a 150 pontos.<br/><br/>
<div align="center"><b>
<img src="style/cavalo.gif"> 1__________<br/>
<img src="style/cavalo.gif"> 2__________<br/>
<img src="style/cavalo.gif"> 3__________<br/>
<img src="style/cavalo.gif"> 4__________<br/>
<img src="style/cavalo.gif"> 5__________<br/></b>
<form action="cdc?a=jcc2" method="post">
Valor da aposta:<br/>
<input type="text" name="val" maxlength="3" size="3"><br/><br/>
Cavalo:<br/>
<select name="cav">
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
</select><br/><br/>
<input type="submit" value="Jogar"></form>
<?php } else if($a=='jcc2') { ?>
<br/><div id="titulo"><b>Contra CPU</b></div><br/>
<div align="center">
Você jogou valendo <b><?php echo $_POST['val'];?></b> pontos.<br/><br/>
<?php if($_POST['val']>150||$_POST['val']<1) { ?>
O limite máximo da aposta é de 150 pontos e minimo 1 ponto
<?php } else {
$cpu = rand(1,5);
$qttt = $_POST['val'];
?>
<img src="style/cavalo.gif"> <b><?php echo $cpu;?></b><br/><br/>
<?php if($cpu==$_POST['cav']) { ?>
Você acertou o cavalo vencedor
<?php } else { ?>
Você apostou no cavalo <b><?php echo $_POST['cav'];?></b> e o cavalo vencedor foi o <b><?php echo $cpu;?></b>
<?php } ?>
<br/><br/><b>Você
<?php if($cpu==$_POST['cav'])
{
echo 'ganhou';
$mistake->exec("update w_usuarios set pt=pt+$qttt where id='$meuid'");
}
else
{
echo 'Perdeu';
$mistake->exec("update w_usuarios set pt=pt-$qttt where id='$meuid'");
}
?></b>
<?php } ?>
</b><br/><br/>
<a href="cdc?a=jcc">Jogar novamente</a>
<?php } else if($a=='du') { ?>
<br/><div id="titulo"><b>Contra Usuário</b></div><br/>
<div align="center">
<b>
<img src="style/cavalo.gif"> 1__________<br/>
<img src="style/cavalo.gif"> 2__________<br/>
<img src="style/cavalo.gif"> 3__________<br/>
<img src="style/cavalo.gif"> 4__________<br/>
<img src="style/cavalo.gif"> 5__________<br/></b>
<form action="cdc?a=du2" method="post">
Amigo:<br/><select name="ami">
<?php
$amigos = $mistake->prepare("SELECT b.id,b.nm FROM w_amigos a inner join w_usuarios b WHERE (a.uid='".$meuid."' OR a.tid='".$meuid."') AND a.ac='1' AND (b.id=a.tid OR b.id=a.uid) AND b.id!='$meuid' order by b.nm asc");
$amigos->execute();
while ($amg = $amigos->fetch(PDO::FETCH_OBJ)) { 
?>
<option value="<?php echo $amg->id;?>"><?php echo $amg->nm;?></option>
<?php 
} 
?>
</select><br/><br/>
Valor da aposta:<br/>
<input type="text" name="val" maxlength="3" size="3"><br/><br/>
Cavalo:<br/>
<select name="cav">
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
</select><br/><br/>
<input type="submit" value="Jogar"></form>
<?php } else if($a=='du2') { ?>
<br/><div id="titulo"><b>Contra Usuário</b></div><br/>
<div align="center">
<?php 
if($_POST['ami']=='') { ?>
selecione um amigo
<?php } else {
if($_POST['val']>150||$_POST['val']<1) { ?>
O limite máximo da aposta é de 150 pontos e minimo 1 ponto
<?php } else {
$mistake->exec("INSERT INTO w_cavalos (uid,aid,dt,qt,pt) values('$meuid','".$_POST['ami']."','".time()."','".$_POST['cav']."','".$_POST['val']."')");
$idj = $mistake->query("SELECT id FROM w_cavalos WHERE uid='$meuid' order by id desc limit 1")->fetch();
$dn = $mistake->query("SELECT nm FROM w_usuarios WHERE id='".$_POST['ami']."'")->fetch();
$msg = "Olá ".html_entity_decode($dn[0]).", desafiei você na corrida de cavalos, valendo ".$_POST['val']." pontos, eu apostei no cavalo ".$_POST['cav'].". Para aceitar o desafio entre [link=cdc?a=du3&id=$idj[0]&on=onsubon]aqui[/link]";
automsg($msg,$meuid,$_POST['ami']);
?>
Desafio feito com sucesso.
<?php } }} else if($a=='du3') { ?>
<br/><div id="titulo"><b>Contra Usuário</b></div><br/>
<div align="center"><b>
<img src="style/cavalo.gif"> 1__________<br/>
<img src="style/cavalo.gif"> 2__________<br/>
<img src="style/cavalo.gif"> 3__________<br/>
<img src="style/cavalo.gif"> 4__________<br/>
<img src="style/cavalo.gif"> 5__________<br/></b>
<form action="cdc?a=du4&id=<?php echo $id;?>" method="post">
Cavalo:<br/>
<select name="cav">
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
</select><br/><br/>
<input type="submit" value="Jogar"></form>
<?php } else if($a=='du4') {
$cont = $mistake->query("SELECT count(*) FROM w_cavalos WHERE id='$id'")->fetch();
$qtt = $mistake->query("SELECT * FROM w_cavalos WHERE id='$id'")->fetch();
?>
<br/><div id="titulo"><b>Contra Usuário</b></div><br/>
<div align="center">
<?php if($cont[0]==0) { ?>
Esta aposta não existe mais
<?php } else if($qtt['aid']!=$meuid) { ?>
Este desafio não foi feito pra você
<?php } else if($cont[0]>0) { $cpu = rand(1,5); $qttt = $qtt['pt']; ?>
Jogaram valendo <b><?php echo $qtt['pt'];?></b> pontos.<br/><br/>
<img src="style/cavalo.gif"> <b><?php echo $cpu;?></b><br/><br/>
<b><?php echo gerarnome($qtt['uid']);?></b> apostou no cavalo <b><?php echo $qtt['qt'];?></b><br/>
Você apostou no cavalo <b><?php echo $_POST['cav'];?></b><br/><br/>
<?php
if($cpu==$_POST['cav'] and $cpu==$qtt['qt'])
{
echo 'Vocês ganharam a aposta.';
$dn = $mistake->query("SELECT nm FROM w_usuarios WHERE id='".$qtt['uid']."'")->fetch();
$msg = "Olá ".html_entity_decode($dn[0]).", nós ganhamos [b]".$qtt['pt']."[/b] pontos na corrida de cavalos, você apostou no cavalo [b] $cpu [/b], eu apostei no cavalo [b] $cpu [/b], que foi o cavalo vencedor";
automsg($msg,$meuid,$qtt['uid']);
$mistake->exec("delete from w_cavalos where id='$id'");
$mistake->exec("update w_usuarios set pt=pt+$qttt where id='$meuid'");
$mistake->exec("update w_usuarios set pt=pt+$qttt where id='".$qtt['uid']."'");
}
else if($cpu==$_POST['cav'] and $cpu!=$qtt['qt'])
{
echo 'Você ganhou a aposta sozinho(a).';
$dn = $mistake->query("SELECT nm FROM w_usuarios WHERE id='".$qtt['uid']."'")->fetch();
$msg = "Olá ".html_entity_decode($dn[0]).", você perdeu [b]".$qtt['pt']."[/b] pontos na corrida de cavalos, você apostou no cavalo [b]".$qtt['qt']."[/b], eu apostei no cavalo [b]".$_POST['cav']."[/b] e o cavalo vencedor foi o [b] $cpu [/b]";
automsg($msg,$meuid,$qtt['uid']);
$mistake->exec("delete from w_cavalos where id='$id'");
$mistake->exec("update w_usuarios set pt=pt+$qttt where id='$meuid'");
$mistake->exec("update w_usuarios set pt=pt-$qttt where id='".$qtt['uid']."'");
}
else if($cpu!=$_POST['cav'] and $cpu==$qtt['qt'])
{
echo "".gerarnome($qtt['uid'])." ganhou a aposta sozinho(a).";
$dn = $mistake->query("SELECT nm FROM w_usuarios WHERE id='".$qtt['uid']."'")->fetch();
$msg = "Olá ".html_entity_decode($dn[0]).", você ganhou [b]".$qtt['pt']."[/b] pontos na corrida de cavalos, você apostou no cavalo [b]".$qtt['qt']."[/b], eu apostei no cavalo [b]".$_POST['cav']."[/b] e o cavalo vencedor foi o [b] $cpu [/b]";
automsg($msg,$meuid,$qtt['uid']);
$mistake->exec("delete from w_cavalos where id='$id'");
$mistake->exec("update w_usuarios set pt=pt-$qttt where id='$meuid'");
$mistake->exec("update w_usuarios set pt=pt+$qttt where id='".$qtt['uid']."'");
}
else
{
echo 'Ninguém ganhou a aposta';
$dn = $mistake->query("SELECT nm FROM w_usuarios WHERE id='".$qtt['uid']."'")->fetch();
$msg = "Olá ".html_entity_decode($dn[0]).", nós perdemos [b]".$qtt['pt']."[/b] pontos na corrida de cavalos, você apostou no cavalo [b]".$qtt['qt']."[/b], eu apostei no cavalo [b]".$_POST['cav']."[/b] e o cavalo vencedor foi o [b] $cpu [/b]";
automsg($msg,$meuid,$qtt['uid']);
$mistake->exec("delete from w_cavalos where id='$id'");
$mistake->exec("update w_usuarios set pt=pt-$qttt where id='$meuid'");
$mistake->exec("update w_usuarios set pt=pt-$qttt where id='".$qtt['uid']."'");
} } } ?>
<div align="center"><br/><br/>
<a href="cdc?">Corrida de cavalos</a><br/>
<a href="entretenimento?">Entretenimento</a><br/>
<a href="home?"><?php echo $imginicio;?>Página principal</a><br><br>
<?php echo rodape();?>
</body>
</html>