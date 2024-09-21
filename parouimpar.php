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
if(pts($meuid)<800){
echo "<div align='center'><b>Voce precisa ter no minimo 800 Pontos!</b></div>";
?>
<div align="center">
<a href="/entretenimento?"><?php echo $imgservicos;?>Entretenimento</a><br/>
<a href="/home?"><?php echo $imginicio;?>Página principal</a><br><br>
<?php 
echo 
rodape();
exit();
}
if($a==false) { ?>
<br/><div id="titulo"><b>Par ou ímpar</b></div><br/>
<a href="parouimpar?a=jcc">Jogar com o computador</a><br/>
<a href="parouimpar?a=du">Desafiar usuário</a><br/>
<?php } else if($a=='jcc') { ?>
<br/><div id="titulo"><b>Par ou ímpar</b></div><br/>
<div align="center">
Jogue par ou ímpar contra o cpu!<br/>
Você podera apostar de 1 a 150 pontos.<br/><br/>
<form action="parouimpar?a=jcc2" method="post">
Valor da aposta:<br/>
<input type="text" name="val" maxlength="3" size="3"><br/><br/>
Par ou impar:<br/>
<select name="pi">
<option value="Par">Par</option>
<option value="Ímpar">Ímpar</option>
</select><br/><br/>
Número:<br/>
<select name="num">
<option value="0">0</option>
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
</select><br/>
<input type="submit" value="Jogar"></form>
<?php } else if($a=='jcc2') { ?>
<br/><div id="titulo"><b>Contra CPU</b></div><br/>
<div align="center">
Você jogou valendo <b><?php echo $_POST['val'];?></b> pontos.<br/><br/>
<?php if($_POST['val']>150||$_POST['val']<1) { ?>
O limite máximo da aposta é de 150 pontos e minimo 1 ponto
<?php } else {
$cpu = rand(0,5);
$res = ($_POST['num']+$cpu)%2==0?'Par':'Ímpar';
$qttt = $_POST['val'];
?>
Você jogou <b><?php echo $_POST['num'];?></b> e escolheu <b><?php echo $_POST['pi'];?></b><br/>
O computador jogou <b><?php echo $cpu;?></b> e escolheu <b><?php echo $_POST['pi']=='Par'?'Ímpar':'Par';?></b><br/><br/>
<?php echo $_POST['num'];?> +  <?php echo $cpu;?> = <?php echo $_POST['num']+$cpu;?> (<?php echo $res;?>)<br/><br/>
<b>Você
<?php
if($_POST['pi']==$res)
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
<a href="parouimpar?a=jcc">Jogar novamente</a>
<?php } else if($a=='du') { ?>
<br/><div id="titulo"><b>Contra Usuário</b></div><br/>
<div align="center">
<form action="parouimpar?a=du2" method="post">
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
Par ou impar:<br/>
<select name="pi">
<option value="1">Par</option>
<option value="2">Ímpar</option>
</select><br/><br/>
Número:<br/>
<select name="num">
<option value="0">0</option>
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
</select><br/>
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
$mistake->exec("INSERT INTO w_parouimpar (uid,aid,dt,qt,qt2,pt) values('$meuid','".$_POST['ami']."','".time()."','".$_POST['pi']."','".$_POST['num']."','".$_POST['val']."')");
$idj = $mistake->query("SELECT id FROM w_parouimpar WHERE uid='$meuid' order by id desc limit 1")->fetch();
$res = $_POST['pi']==1?'Par':'Ímpar';
$res2 = $_POST['pi']==1?'Ímpar':'Par';
$dn = $mistake->query("SELECT nm FROM w_usuarios WHERE id='".$_POST['ami']."'")->fetch();
$msg = "Olá ".html_entity_decode($dn[0]).", desafiei você no par ou ímpar, valendo ".$_POST['val']." pontos, eu escolhi $res e você será $res2. Para aceitar o desafio entre [link=/parouimpar?a=du3&id=$idj[0]&on=onsubon]aqui[/link]";
automsg($msg,$meuid,$_POST['ami']);
?>
Desafio feito com sucesso.
<?php }
} } else if($a=='du3') { ?>
<br/><div id="titulo"><b>Contra Usuário</b></div><br/>
<div align="center">
<form action="parouimpar?a=du4&id=<?php echo $id;?>" method="post">
Número:<br/>
<select name="num">
<option value="0">0</option>
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
</select><br/>
<input type="submit" value="Jogar"></form>
<?php } else if($a=='du4') {
$cont = $mistake->query("SELECT count(*) FROM w_parouimpar WHERE id='$id'")->fetch();
$qtt = $mistake->query("SELECT * FROM w_parouimpar WHERE id='$id'")->fetch();
?>
<br/><div id="titulo"><b>Contra Usuário</b></div><br/>
<div align="center">
<?php if($cont[0]==0) { ?>
Esta aposta não existe mais
<?php } else if($qtt['aid']!=$meuid) { ?>
Este desafio não foi feito pra você
<?php } else if($cont[0]>0) { ?>
Jogou valendo <b><?php echo $qtt['pt'];?></b> pontos.<br/><br/>
<?php
$resuid = $qtt['qt']==1?'Par':'Ímpar';
$resuid2 = $qtt['qt']==1?'Ímpar':'Par';
$res = ($_POST['num']+$qtt['qt2'])%2==0?'Par':'Ímpar';
$qttt = $qtt['pt'];
?>
<?php echo gerarnome($qtt['uid']);?> jogou <b><?php echo $qtt['qt2'];?></b> e escolheu <b><?php echo $resuid;?></b><br/>
Você jogou <b><?php echo $_POST['num'];?></b> e ficou com <b><?php echo $resuid2;?></b><br/><br/>
<?php echo $qtt['qt2'];?> +  <?php echo $_POST['num'];?> = <?php echo $_POST['num']+$qtt['qt2'];?> (<?php echo $res;?>)<br/><br/>
<b>Você
<?php
if($resuid2==$res)
{
echo 'ganhou';
$qttt = $qtt['pt'];
$dn = $mistake->query("SELECT nm FROM w_usuarios WHERE id='".$qtt['uid']."'")->fetch();
$msg = "Olá ".html_entity_decode($dn[0]).", você perdeu [b]".$qtt['pt']."[/b] pontos no par ou ímpar, você jogou [b]".$qtt['qt2']."[/b] e escolheu $resuid. Eu joguei [b]".$_POST['num']."[/b] e fiquei com $resuid2. ".$qtt['qt2']." + ".$_POST['num']." = ".($_POST['num']+$qtt['qt2'])." ($res)";
automsg($msg,$meuid,$qtt['uid']);
$mistake->exec("delete from w_parouimpar where id='$id'");
$mistake->exec("update w_usuarios set pt=pt+$qttt where id='$meuid'");
$mistake->exec("update w_usuarios set pt=pt-$qttt where id='".$qtt['uid']."'");
}
else
{
echo 'Perdeu';
$qttt = $qtt['pt'];
$dn = $mistake->query("SELECT nm FROM w_usuarios WHERE id='".$qtt['uid']."'")->fetch();
$msg = "Olá ".html_entity_decode($dn[0]).", você ganhou [b]".$qtt['pt']."[/b] pontos no par ou ímpar, você jogou [b]".$qtt['qt2']."[/b] e escolheu $resuid. Eu joguei [b]".$_POST['num']."[/b] e fiquei com $resuid2. ".$qtt['qt2']." + ".$_POST['num']." = ".($_POST['num']+$qtt['qt2'])." ($res)";
automsg($msg,$meuid,$qtt['uid']);
$mistake->exec("delete from w_parouimpar where id='$id'");
$mistake->exec("update w_usuarios set pt=pt+$qttt where id='$meuid'");
$mistake->exec("update w_usuarios set pt=pt-$qttt where id='".$qtt['uid']."'");
}
?></b>
<?php } } ?>
<div align="center"><br/><br/>
<a href="parouimpar?">Par ou Ímpar</a><br/>
<a href="entretenimento?">Entretenimento</a><br/>
<a href="home?"><?php echo $imginicio;?>Página principal</a><br><br>
<?php echo rodape();?>
</body>
</html>