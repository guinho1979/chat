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
ativo($meuid,'Corrida ');
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
<br/><div id="titulo"><b>Ranking</b></div><br/>
<a href="corrida?a=ranking&e=acertos">&#187;Vitórias</a><br/>
<a href="corrida?a=ranking&e=erros">&#187;Derrotas</a><br/>
<br/><div id="titulo"><b>Fórmula 1</b></div><br/>
<a href="corrida?a=jcc">Jogar com o computador</a><br/>
<a href="corrida?a=du">Desafiar usuário</a><br/>
<?php } else if($a=='ranking') {
if($e=='acertos')
{
$contmsg = $mistake->query("SELECT count(*) FROM w_usuarios where cora>'0'")->fetch();
$qz = 'cora';
$ea = 'vitória';
$tt = 'Vitórias';
}
else
{
$contmsg = $mistake->query("SELECT count(*) FROM w_usuarios where core>'0'")->fetch();
$qz = 'core';
$ea = 'derrota';
$tt = 'Derrotas';
}
?>
<br/><div id="titulo"><b><?php echo $tt;?></b></div><br/>
<?php
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contmsg[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
if($e=='acertos')
{
$itens = $mistake->query("SELECT id, $qz FROM w_usuarios where cora>'0' order by cora desc limit $limit, $itensporpag");
}
else
{
$itens = $mistake->query("SELECT id, $qz FROM w_usuarios where core>'0' order by core desc limit $limit, $itensporpag");
}
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<a href="perfil?id=<?php echo $item->id;?>"><?php echo gerarnome($item->id);?></a> - <?php echo $item->$qz.' '.$ea.($item->$qz>1?'s':'');?>
</div>
<?php $i++; } ?>
<br/><div align="center"><br/>
<?php if($pag>1) { $ppag = $pag-1; ?>
<a href="corrida?a=ranking&e=<?php echo $e;?>&pag=<?php echo $ppag;?>">&#171;Anterior</a>
<?php } if($pag<$numpag) { $npag = $pag+1; ?>
<a href="corrida?a=ranking&e=<?php echo $e;?>&pag=<?php echo $npag;?>">Próxima&#187;</a>
<?php } ?>
<br/><?php echo $pag.'/'.$numpag;?><br/>
<?php if($numpag>2) { ?>
<form action="corrida.php" method="get">
Pular para página<input name="pag" size="3">
<input type="submit" value="IR">
<input type="hidden" name="a" value="<?php echo $a;?>">
<input type="hidden" name="e" value="<?php echo $e;?>">
</form>
<?php } } else { ?>
<div align="center">Nenhum usuário!<br/><br/>
<?php } ?>
<br/><div align="center"><a href="corrida?">Novo jogo</a>
<?php } else if($a=='jcc') { ?>
<br/><div id="titulo"><b>Contra CPU</b></div><br/>
<div align="center">Escolha o seu carro e ganhe pontos chegando em primeiro lugar!<br/>
Você pode apostar de 1 a 150 pontos.<br/><br/>
<form action="corrida?a=jcc2" method="post">
Carro: <select name="cor">
<option value="Ferrari">Ferrari</option>
<option value="Force&nbsp;India">Force India</option>
<option value="Hispania">Hispania</option>
<option value="Lotus">Lotus</option>
<option value="Mclaren">Mclaren</option>
<option value="Mercedes">Mercedes</option>
<option value="RBR">RBR</option>
<option value="Renault">Renault</option>
<option value="Sauber">Sauber</option>
<option value="STR">STR</option>
<option value="VRT">VRT</option>
<option value="Williams">Williams</option>
</select><br/><br/>
Valor da aposta:<br/>
<input type="text" name="val" maxlength="3" size="3"><br/>
<input type="submit" value="Correr"></form>
<?php } else if($a=='jcc2') {
$res1 = rand(1,12);
$res2 = rand(1,12);
$carropc = rand(1,12);
if($carropc==1)
{
$carropc2 = 'Ferrari';
}
else if($carropc==2)
{
$carropc2 = 'Force India';
}
else if($carropc==3)
{
$carropc2 = 'Hispania';
}
else if($carropc==4)
{
$carropc2 = 'Lotus';
}
else if($carropc==5)
{
$carropc2 = 'Mclaren';
}
else if($carropc==6)
{
$carropc2 = 'Mercedes';
}
else if($carropc==7)
{
$carropc2 = 'RBR';
}
else if($carropc==8)
{
$carropc2 = 'Renault';
}
else if($carropc==9)
{
$carropc2 = 'Sauber';
}
else if($carropc==10)
{
$carropc2 = 'STR';
}
else if($carropc==11)
{
$carropc2 = 'VRT';
}
else if($carropc==12)
{
$carropc2 = 'Williams';
}
?>
<br/><div id="titulo"><b>Contra CPU</b></div><br/>
Você correu valendo <b><?php echo $_POST['val'];?></b> pontos.<br/><br/>
<?php echo $_POST['cor'];?> = <b><?php echo $res1;?></b>º lugar<br/>
<?php echo $res1<$res2?'&nbsp;&nbsp;&nbsp;&nbsp;':'';?><img src="style/corrida.jpg"><br/><br/>
<?php echo $carropc2;?> = <b><?php echo $res2;?></b>º lugar<br/>
<?php echo $res1>$res2?'&nbsp;&nbsp;&nbsp;&nbsp;':'';?><img src="style/corrida.jpg"><br/><br/>
<b><?php if($_POST['val']>150||$_POST['val']<1) { ?>
O limite máximo da aposta é de 150 pontos e minimo 1 ponto
<?php } else if($res1<$res2) {
$qttt = $_POST['val'];
$mistake->exec("update w_usuarios set pt=pt+$qttt, cora=cora+1 where id='$meuid'");
?>
Parabéns, você correu com <?php echo $_POST['cor'];?>, chegou em <?php echo $res1;?>º lugar e ganhou <?php echo $_POST['val'];?> pontos!
<?php } else if($res1==$res2) { ?>
Incrível, vocês chegaram juntos
<?php } else {
$qttt = $_POST['val'];
$mistake->exec("update w_usuarios set pt=pt-$qttt, core=core+1 where id='$meuid'");
?>
Você correu com <?php echo $_POST['cor'];?>, chegou em <?php echo $res1;?>º lugar e perdeu <?php echo $_POST['val'];?> pontos!!
<?php } ?></b><br/><br/>
<a href="corrida?a=jcc">Jogar novamente</a>
<?php } else if($a=='du') { ?>
<br/><div id="titulo"><b>Contra Usuário</b></div><br/>
<div align="center">
<form action="corrida?a=du2" method="post">
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
Carro: <select name="cor">
<option value="Ferrari">Ferrari</option>
<option value="Force&nbsp;India">Force India</option>
<option value="Hispania">Hispania</option>
<option value="Lotus">Lotus</option>
<option value="Mclaren">Mclaren</option>
<option value="Mercedes">Mercedes</option>
<option value="RBR">RBR</option>
<option value="Renault">Renault</option>
<option value="Sauber">Sauber</option>
<option value="STR">STR</option>
<option value="VRT">VRT</option>
<option value="Williams">Williams</option>
</select><br/><br/>
Valor da aposta:<br/>
<input type="text" name="val" maxlength="3" size="5"><br/>
<input type="submit" value="Correr"></form>
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
$res1 = rand(1,12);
$mistake->exec("INSERT INTO w_formula1 (uid,aid,dt,qt,pt,cor) values('$meuid','".$_POST['ami']."','".time()."','$res1','".$_POST['val']."','".$_POST['cor']."')");
$idj = $mistake->query("SELECT id FROM w_formula1 WHERE uid='$meuid' order by id desc limit 1")->fetch();
$dn = $mistake->query("SELECT nm FROM w_usuarios WHERE id='".$_POST['ami']."'")->fetch();
$msg = "Olá ".html_entity_decode($dn[0]).", desafiei você na corrida da fórmula 1, valendo ".$_POST['val']." pontos. Para aceitar o desafio entre [link=corrida?a=du3&id=$idj[0]&on=onsubon]aqui[/link]";
automsg($msg,$meuid,$_POST['ami']); ?>
Você chegou em:<br/>
<?php echo $_POST['cor'];?> = <b><?php echo $res1;?></b>º lugar<br/>
<img src="style/corrida.jpg"><br/><br/>
Vamos ver em que posição seu amigo vai chegar.  <?php } }?>
<?php } else if($a=='du3') {
$cont = $mistake->query("SELECT count(*) FROM w_formula1 WHERE id='$id'")->fetch();
$qtt = $mistake->query("SELECT * FROM w_formula1 WHERE id='$id'")->fetch(); ?>
<br/><div id="titulo"><b>Contra Usuário</b></div><br/>
<div align="center">
<?php if($cont[0]>0) { ?>
<?php echo gerarnome($qtt['uid']);?> correu valendo <b><?php echo $qtt['pt'];?></b> pontos.<br/><br/>
<?php echo $qtt['cor'];?><br/>
<img src="style/corrida.jpg"><br/><br/>
<form action="corrida?a=du4&id=<?php echo $id;?>" method="post">
Escolha seu carro: <select name="cor">
<option value="Ferrari">Ferrari</option>
<option value="Force&nbsp;India">Force India</option>
<option value="Hispania">Hispania</option>
<option value="Lotus">Lotus</option>
<option value="Mclaren">Mclaren</option>
<option value="Mercedes">Mercedes</option>
<option value="RBR">RBR</option>
<option value="Renault">Renault</option>
<option value="Sauber">Sauber</option>
<option value="STR">STR</option>
<option value="VRT">VRT</option>
<option value="Williams">Williams</option>
</select><br/><br/>
<input type="submit" value="Correr"></form>
<?php } ?>
<b><?php if($cont[0]==0) { ?>
Esta corrida não existe mais
<?php } else if($qtt['aid']!=$meuid) { ?>
Este desafio não foi feito pra você
<?php } ?></b><br/><br/> <?php } else if($a=='du4') {
$res1 = rand(1,12);
$cont = $mistake->query("SELECT count(*) FROM w_formula1 WHERE id='$id'")->fetch();
$qtt = $mistake->query("SELECT * FROM w_formula1 WHERE id='$id'")->fetch(); ?>
<br/><div id="titulo"><b>Contra Usuário</b></div><br/>
<div align="center">
<?php if($cont[0]>0) { ?>
Você correu valendo <b><?php echo $qtt['pt'];?></b> pontos.<br/><br/>
<?php echo $_POST['cor'];?> = <?php echo $res1;?>º lugar<br/>
<?php echo $res1<$qtt['qt']?'&nbsp;&nbsp;&nbsp;&nbsp;':'';?><img src="style/corrida.jpg"><br/><br/>
<?php echo $qtt['cor'];?> = <?php echo $qtt['qt'];?>º lugar<br/>
<?php echo $res1>$qtt['qt']?'&nbsp;&nbsp;&nbsp;&nbsp;':'';?><img src="style/corrida.jpg"><br/><br/>
<?php } ?>
<b><?php if($cont[0]==0) { ?>
Esta corrida não existe mais
<?php } else if($qtt['aid']!=$meuid) { ?>
Este desafio não foi feito pra você
<?php } else if($res1<$qtt['qt']) {
$qttt = $qtt['pt'];
$mistake->exec("update w_usuarios set pt=pt+$qttt, cora=cora+1 where id='$meuid'");
$dn = $mistake->query("SELECT nm FROM w_usuarios WHERE id='".$qtt['uid']."'")->fetch();
$msg = "Olá ".html_entity_decode($dn[0]).", você perdeu $qttt pontos na corrida da fórmula 1. Eu corri com ".$_POST['cor']." e cheguei em ".$res1."º lugar.";
automsg($msg,$meuid,$qtt['uid']);
?>
Parabéns, você correu com <?php echo $_POST['cor'];?>, chegou em <?php echo $res1;?>º lugar e ganhou <?php echo $qtt['pt'];?> pontos!
<?php } else if($res1==$qtt['qt']) { ?>
Incrível, vocês chegaram juntos
<?php
$dn = $mistake->query("SELECT nm FROM w_usuarios WHERE id='".$qtt['uid']."'")->fetch();
$msg = "Olá ".html_entity_decode($dn[0]).", chegamos juntos na corrida da fórmula 1. Eu corri com ".$_POST['cor']." e cheguei em ".$res1."º lugar. Você correu com ".$qtt['cor']." e chegou em ".$qtt['qt']."º lugar.";
automsg($msg,$meuid,$qtt['uid']);
} else {
$qttt = $qtt['pt'];
$mistake->exec("update w_usuarios set pt=pt-$qttt, core=core+1 where id='$meuid'");
$mistake->exec("update w_usuarios set pt=pt+$qttt, cora=cora+1 where id='".$qtt['uid']."'");
?>
Você correu com <?php echo $_POST['cor'];?>, chegou em <?php echo $res1;?>º lugar e perdeu <?php echo $qtt['pt'];?> pontos!!
<?php
$dn = $mistake->query("SELECT nm FROM w_usuarios WHERE id='".$qtt['uid']."'")->fetch();
$msg = "Olá ".html_entity_decode($dn[0]).", você ganhou $qttt pontos na corrida da fórmula 1. Eu corri com ".$_POST['cor']." e cheguei em ".$res1."º lugar. Você correu com ".$qtt['cor']." e chegou em ".$qtt['qt']."º lugar.";
automsg($msg,$meuid,$qtt['uid']);
} ?></b><br/><br/>
<?php } ?>
<div align="center"><br/><br/>
<a href="corrida?">Fórmula 1</a><br/>
<a href="entretenimento?">Entretenimento</a><br/>
<a href="home?"><?php echo $imginicio;?>Página principal</a><br><br>
<?php echo rodape();?>
</body>
</html>