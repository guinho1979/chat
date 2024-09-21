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
ativo($meuid,'Jogo dos Pênaltis ');
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
<a href="penaltis?a=ranking&e=acertos">&#187;Vitórias</a><br/>
<a href="penaltis?a=ranking&e=erros">&#187;Derrotas</a><br/>
<br/><div id="titulo"><b>Jogo dos Pênaltis</b></div><br/>
<a href="penaltis?a=jcc">Jogar com o computador</a><br/>
<a href="penaltis?a=du">Desafiar usuário</a><br/>
<?php } else if($a=='ranking') {
if($e=='acertos')
{
$contmsg = $mistake->query("SELECT count(*) FROM w_usuarios where pena>'0'")->fetch();
$qz = 'pena';
$ea = 'vitória';
$tt = 'Vitórias';
}
else
{
$contmsg = $mistake->query("SELECT count(*) FROM w_usuarios where pene>'0'")->fetch();
$qz = 'pene';
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
$itens = $mistake->query("SELECT id, $qz FROM w_usuarios where pena>'0' order by pena desc limit $limit, $itensporpag");
}
else
{
$itens = $mistake->query("SELECT id, $qz FROM w_usuarios where pene>'0' order by pene desc limit $limit, $itensporpag");
}
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<a href="/<?php echo gerarlogin($item->id);?>"><?php echo gerarnome($item->id);?></a> - <?php echo $item->$qz.' '.$ea.($item->$qz>1?'s':'');?>
</div>
<?php $i++; } ?>
<br/><div align="center"><br/>
<?php if($pag>1) { $ppag = $pag-1; ?>
<a href="penaltis?a=ranking&e=<?php echo $e;?>&pag=<?php echo $ppag;?>">&#171;Anterior</a>
<?php } if($pag<$numpag) { $npag = $pag+1; ?>
<a href="penaltis?a=ranking&e=<?php echo $e;?>&pag=<?php echo $npag;?>">Próxima&#187;</a>
<?php } ?>
<br/><?php echo $pag.'/'.$numpag;?><br/>
<?php if($numpag>2) { ?>
<form action="penaltis.php" method="get">
Pular para página<input name="pag" size="3">
<input type="submit" value="IR">
<input type="hidden" name="a" value="<?php echo $a;?>">
<input type="hidden" name="e" value="<?php echo $e;?>">
</form>
<?php } } else { ?>
<div align="center">Nenhum usuário!<br/><br/>
<?php } ?>
<br/><div align="center"><a href="penaltis?">Novo jogo</a>
<?php } else if($a=='jcc') { ?>
<br/><div id="titulo"><b>Contra CPU</b></div><br/>
<div align="center">
Chute no lado certo, faça gols e ganhe pontos!<br/>
Você podera apostar de 1 a 20 pontos.<br/><br/>
<img src="fut/fut.jpg" /><br/><br/>
<form action="penaltis?a=jcc2" method="post">
Valor do chute:<br/>
<input type="text" name="val" maxlength="3" size="3"><br/>
Lado:<br/>
<select name="lado">
<option value="1">Esquerdo</option>
<option value="2">Centro</option>
<option value="3">Direito</option>
</select><br/>
<input type="submit" value="Jogar"></form>
<?php } else if($a=='jcc2') {
$res = $_POST['lado'].rand(1,3);
?>
<br/><div id="titulo"><b>Contra CPU</b></div><br/>
<div align="center">
Você jogou valendo <b><?php echo $_POST['val'];?></b> pontos.<br/><br/>
<img src="fut/<?php echo $res;?>.jpg" /><br/><br/>
<b><?php if($_POST['val']>20||$_POST['val']<1) { ?>
O limite máximo da aposta é de 20 pontos e minimo 1 ponto
<?php 
} else
if($res!=11 and $res!=22 and $res!=33) {
$qttt = $_POST['val'];
$mistake->exec("update w_usuarios set pt=pt+$qttt, pena=pena+1 where id='$meuid'");
?>GOOOOOOOOOLLLLLLL!<br/>
Parabéns, você ganhou <?php echo $_POST['val'];?> pontos!
<?php } else {
$qttt = $_POST['val'];
$mistake->exec("update w_usuarios set pt=pt-$qttt, pene=pene+1 where id='$meuid'");
?>DEFENDEU!<br/>
Você perdeu <?php echo $_POST['val'];?> pontos!!
<?php } ?>
</b><br/><br/>
<a href="penaltis?a=jcc">Jogar novamente</a>
<?php } else if($a=='du') { ?>
<br/><div id="titulo"><b>Contra Usuário</b></div><br/>
<div align="center">
<form action="penaltis?a=du2" method="post">
Amigo:<br/><select name="ami">
<?php
$amigos = $mistake->prepare("SELECT b.id,b.nm FROM w_amigos a inner join w_usuarios b WHERE (a.uid='".$meuid."' OR a.tid='".$meuid."') AND a.ac='1' AND (b.id=a.tid OR b.id=a.uid) AND b.id!='$meuid' order by b.nm asc");
$amigos->execute();
while($amg = $amigos->fetch(PDO::FETCH_OBJ)) { ?>
<option value="<?php echo $amg->id;?>"><?php echo $amg->nm;?></option>
<?php } ?>
</select><br/><br/>
Valor do chute:<br/>
<input type="text" name="val" maxlength="3" size="5"><br/>
Lado:<br/>
<select name="lado">
<option value="1">Esquerdo</option>
<option value="2">Centro</option>
<option value="3">Direito</option>
</select><br/>
<input type="submit" value="Jogar"></form>
<?php } else if($a=='du2') { ?>
<br/><div id="titulo"><b>Contra Usuário</b></div><br/>
<div align="center">
<?php 
if($_POST['ami']=='') { ?>
selecione um amigo
<?php } else {
if($_POST['val']>20||$_POST['val']<1) { ?>
O limite máximo da aposta é de 20 pontos e minimo 1 ponto
<?php } else {
$mistake->exec("INSERT INTO w_penal (uid,aid,dt,qt,pt) values('$meuid','".$_POST['ami']."','".time()."','".$_POST['lado']."','".$_POST['val']."')");
$idj = $mistake->query("SELECT id FROM w_penal WHERE uid='$meuid' order by id desc limit 1")->fetch();
$dn = $mistake->query("SELECT nm FROM w_usuarios WHERE id='".$_POST['ami']."'")->fetch();
$msg = "Olá ".html_entity_decode($dn[0]).", desafiei você no jogo dos pênaltis, valendo ".$_POST['val']." pontos. Para aceitar o desafio entre [link=/penaltis?a=du3&id=".$idj[0]."]aqui[/link]";
automsg($msg,$meuid,$_POST['ami']);
if($_POST['lado']==1)
{
$lado = 'a esquerda';
}
else if($_POST['lado']==2)
{
$lado = 'no centro';
}
else
{
$lado = 'a direita';
}
?>
Você escolheu chutar <b><?php echo $lado;?></b>.  <?php } }?>
<?php } else if($a=='du3') { ?>
<br/><div id="titulo"><b>Contra Usuário</b></div><br/>
<div align="center">
<form action="penaltis?a=du4&id=<?php echo $id;?>" method="post">
Escolha um lado para defender<br/><br/>
<select name="lado">
<option value="1">Esquerdo</option>
<option value="2">Centro</option>
<option value="3">Direito</option>
</select><br/>
<input type="submit" value="Jogar"></form>
<?php } else if($a=='du4') {
$cont = $mistake->query("SELECT count(*) FROM w_penal WHERE id='$id'")->fetch();
$qtt = $mistake->query("SELECT * FROM w_penal WHERE id='$id'")->fetch();
$res = $qtt['qt'].$_POST['lado'];
if($_POST['lado']==1)
{
$lado = 'a esquerda';
}
else if($_POST['lado']==2)
{
$lado = 'no centro';
}
else
{
$lado = 'a direita';
}
if($qtt['qt']==1)
{
$lado2 = 'a esquerda';
}
else if($qtt['qt']==2)
{
$lado2 = 'no centro';
}
else
{
$lado2 = 'a direita';
}
?>
<br/><div id="titulo"><b>Contra Usuário</b></div><br/>
<div align="center">
<?php if($cont[0]==0) { ?>
Esta aposta não existe mais
<?php } else if($qtt['aid']!=$meuid) { ?>
Este desafio não foi feito pra você
<?php } else if($cont[0]>0) { ?>
Jogou valendo <b><?php echo $qtt['pt'];?></b> pontos.<br/><br/>
<img src="fut/<?php echo $res;?>.jpg" /><br/><br/>
<?php if($res!=11 and $res!=22 and $res!=33) {
$qttt = $qtt['pt'];
$dn = $mistake->query("SELECT nm FROM w_usuarios WHERE id='".$qtt['uid']."'")->fetch();
$msg = "Olá ".html_entity_decode($dn[0]).", você ganhou [b]".$qtt['pt']."[/b] pontos no jogo dos pênaltis, você chutou [b]$lado2 [/b] e eu defendi [b]".$lado."[/b]";
automsg($msg,$meuid,$qtt['uid']);
$mistake->exec("delete from w_penal where id='$id'");
$mistake->exec("update w_usuarios set pt=pt-$qttt, pene=pene+1 where id='$meuid'");
$mistake->exec("update w_usuarios set pt=pt+$qttt, pena=pena+1 where id='".$qtt['uid']."'");
?><b>GOOOOOOOOOLLLLLLL!</b><br/>
Você perdeu <?php echo $qtt['pt'];?> pontos!
<?php } else {
$qttt = $qtt['pt'];
$dn = $mistake->query("SELECT nm FROM w_usuarios WHERE id='".$qtt['uid']."'")->fetch();
$msg = "Olá ".html_entity_decode($dn[0]).", eu ganhei [b]".$qtt['pt']."[/b] pontos no jogo dos pênaltis, você chutou [b]$lado2 [/b] e eu defendi [b]".$lado."[/b]";
automsg($msg,$meuid,$qtt['uid']);
$mistake->exec("delete from w_penal where id='$id'");
$mistake->exec("update w_usuarios set pt=pt+$qttt, pena=pena+1 where id='$meuid'");
$mistake->exec("update w_usuarios set pt=pt-$qttt, pene=pene+1 where id='".$qtt['uid']."'");
?><b>DEFENDEU!</b><br/>
Você ganhou <?php echo $qtt['pt'];?> pontos!!
<?php } ?><br/><br/>
<?php } ?>
<br/><br/>
<?php } ?>
<div align="center"><br/><br/>
<a href="penaltis?">Jogo dos Pênaltis</a><br/>
<a href="entretenimento?">Entretenimento</a><br/>
<a href="home?"><?php echo $imginicio;?>Página principal</a><br><br>
<?php echo rodape();?>
</body>
</html>