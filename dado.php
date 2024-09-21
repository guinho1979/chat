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
ativo($meuid,'Jogo do dado ');
if($a==false) { ?>
<br/><div id="titulo"><b>Ranking</b></div><br/>
<a href="dado?a=cranking">&#187;Concurso</a><br/><br/>
<a href="dado?a=ranking&e=acertos">&#187;Vitórias</a><br/>
<a href="dado?a=ranking&e=erros">&#187;Derrotas</a><br/>
<br/><div id="titulo"><b>Jogo do dado</b></div><br/>
<a href="dado?a=jcc">Jogar com o computador</a><br/>
<a href="dado?a=du">Desafiar usuário</a><br/>
<?php }    else if($a=='concurso') { ?>
<br/><div id="titulo"><b>Concurso do dado</b></div><br/>
<a href="forum?a=topico&id=16574">&#187;Tópico do concurso</a><br/><br/>
<a href="dado?a=cranking">&#187;Ranking</a><br/>
<?php }
else if($a=='ranking') {
if($e=='acertos')
{
$contmsg = $mistake->query("SELECT count(*) FROM w_usuarios where dada>'0'")->fetch();
$qz = 'dada';
$ea = 'vitória';
$tt = 'Vitórias';
}
else
{
$contmsg = $mistake->query("SELECT count(*) FROM w_usuarios where dade>'0'")->fetch();
$qz = 'dade';
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
$itens = $mistake->query("SELECT id, $qz FROM w_usuarios where dada>'0' order by dada desc limit $limit, $itensporpag");
}
else
{
$itens = $mistake->query("SELECT id, $qz FROM w_usuarios where dade>'0' order by dade desc limit $limit, $itensporpag");
}
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<a href="perfil?id=<?php echo $item->id;?>"><?php echo gerarnome($item->id);?></a> - <?php echo $item->$qz.' '.$ea.($item->$qz>1?'s':'');?>
</div>
<?php $i++; } ?>
<br/><div align="center"><br/>
<?php if($pag>1) { $ppag = $pag-1; ?>
<a href="dado?a=ranking&e=<?php echo $e;?>&pag=<?php echo $ppag;?>">&#171;Anterior</a>
<?php } if($pag<$numpag) { $npag = $pag+1; ?>
<a href="dado?a=ranking&e=<?php echo $e;?>&pag=<?php echo $npag;?>">Próxima&#187;</a>
<?php } ?>
<br/><?php echo $pag.'/'.$numpag;?><br/>
<?php if($numpag>2) { ?>
<form action="dado.php" method="get">
Pular para página<input name="pag" size="3">
<input type="submit" value="IR">
<input type="hidden" name="a" value="<?php echo $a;?>">
<input type="hidden" name="e" value="<?php echo $e;?>">
</form>
<?php } } else { ?>
<div align="center">Nenhum usuário!<br/><br/>
<?php } ?>
<br/><div align="center"><a href="dado?">Novo jogo</a>
<?php }
else if($a=='cranking') { ?>
<br/><div id="titulo"><b>Ranking do concurso</b></div><br/>
<?php
$contmsg = $mistake->query("SELECT count(*) FROM w_usuarios where dada>'0' or dade>'0'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contmsg[0];
$itensporpag = 15;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->query("SELECT id, dada, dade FROM w_usuarios where dada>'0' or dade>'0' order by dada-dade desc limit $limit, $itensporpag");
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<a href="perfil?id=<?php echo $item->id;?>"><?php echo gerarnome($item->id);?></a>: Saldo = <?php echo $item->dada-$item->dade;?>
</div>
<?php $i++; } ?>
<br/><div align="center"><br/>
<?php if($pag>1) { $ppag = $pag-1; ?>
<a href="dado?a=cranking&pag=<?php echo $ppag;?>">&#171;Anterior</a>
<?php } if($pag<$numpag) { $npag = $pag+1; ?>
<a href="dado?a=cranking&pag=<?php echo $npag;?>">Próxima&#187;</a>
<?php } ?>
<br/><?php echo $pag.'/'.$numpag;?><br/>
<?php if($numpag>2) { ?>
<form action="dado.php" method="get">
Pular para página<input name="pag" size="3">
<input type="submit" value="IR">
<input type="hidden" name="a" value="<?php echo $a;?>">
</form>
<?php } } else { ?>
<div align="center">Nenhum usuário!<br/><br/>
<?php } ?>
<br/><div align="center"><a href="dado?">Novo jogo</a>
<?php }
else if($a=='jcc') { ?>
<br/><div id="titulo"><b>Contra CPU</b></div><br/>
<div align="center">
Jogue o dado se você tiver um resultado maior que o computador, você ganha os pontos apostados!<br/>
Você podera apostar de 1 a 150 pontos.<br/><br/>
<form action="dado?a=jcc2" method="post">
Valor da aposta:<br/>
<input type="text" name="val" maxlength="3" size="3"><br/>
<input type="submit" value="Jogar"></form>
<?php } else if($a=='jcc2') {
$res1 = rand(1,6);
$res2 = rand(1,6);
?>
<br/><div id="titulo"><b>Contra CPU</b></div><br/>
<div align="center">
Você jogou valendo <b><?php echo $_POST['val'];?></b> pontos.<br/><br/>
Seu dado<br/>
<img src="dado2/<?php echo $res1;?>.jpg"><br/><br/>
Dado do computador<br/>
<img src="dado2/<?php echo $res2;?>.jpg"><br/><br/>
<b><?php if($_POST['val']>150||$_POST['val']<1) { ?>
O limite máximo da aposta é de 150 pontos e minimo 1 ponto
<?php } else if($res1>$res2) {
$qttt = $_POST['val'];
$mistake->exec("update w_usuarios set pt=pt+$qttt, dada=dada+1 where id='$meuid'");
?>
Parabéns, você ganhou <?php echo $_POST['val'];?> pontos!
<?php } else if($res1==$res2) { ?>
Deu empate!
<?php } else {
$qttt = $_POST['val'];
$mistake->exec("update w_usuarios set pt=pt-$qttt, dade=dade+1 where id='$meuid'");
?>
Você perdeu <?php echo $_POST['val'];?> pontos!!
<?php } ?></b><br/><br/>
<a href="dado?a=jcc">Jogar novamente</a>
<?php } else if($a=='du') { ?>
<br/><div id="titulo"><b>Contra Usuário</b></div><br/>
<div align="center">
<form action="dado?a=du2" method="post">
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
<input type="text" name="val" maxlength="3" size="5"><br/>
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
$res1 = rand(1,6);
$mistake->exec("INSERT INTO w_dado (uid,aid,dt,qt,pt) values('$meuid','".$_POST['ami']."','".time()."','$res1','".$_POST['val']."')");
$idj = $mistake->query("SELECT id FROM w_dado WHERE uid='$meuid' order by id desc limit 1")->fetch();
$dn = $mistake->query("SELECT nm FROM w_usuarios WHERE id='".$_POST['ami']."'")->fetch();
$msg = "Olá ".html_entity_decode($dn[0]).", desafiei você no jogo do dado, valendo ".$_POST['val']." pontos. Para aceitar o desafio entre [link=dado?a=du3&id=$idj[0]&on=onsubon]aqui[/link]";
automsg($msg,$meuid,$_POST['ami']); ?>
Seu dado resultou o valor <b><?php echo $res1;?></b>, torça para seu amigo(a) tirar um valor menor.  <?php 
}
} 
?>
<?php } else if($a=='du3') {
$res1 = rand(1,6);
$cont = $mistake->query("SELECT count(*) FROM w_dado WHERE id='$id'")->fetch();
$qtt = $mistake->query("SELECT * FROM w_dado WHERE id='$id'")->fetch(); ?>
<br/><div id="titulo"><b>Contra Usuário</b></div><br/>
<div align="center">
<?php if($cont[0]>0) { ?>
Jogou valendo <b><?php echo $qtt['pt'];?></b> pontos.<br/><br/>
Seu dado<br/>
<img src="dado2/<?php echo $res1;?>.jpg"><br/><br/>
Dado de <?php echo gerarnome($qtt['uid']);?><br/>
<img src="dado2/<?php echo $qtt['qt'];?>.jpg"><br/><br/>
<?php } ?>
<b><?php if($cont[0]==0) { ?>
Esta aposta não existe mais
<?php } else if($qtt['aid']!=$meuid) { ?>
Este desafio não foi feito pra você
<?php }
else if($res1>$qtt['qt'])
{
$dn = $mistake->query("SELECT nm FROM w_usuarios WHERE id='".$qtt['uid']."'")->fetch();
$msg = "Olá ".html_entity_decode($dn[0]).", ganhei [b]".$qtt['pt']."[/b] pontos no jogo do dado, meu resultado foi [b]$res1 [/b] e o seu foi [b]".$qtt['qt']."[/b]";
automsg($msg,$meuid,$qtt['uid']);
$mistake->exec("delete from w_dado where id='$id'");
$qttt = $qtt['pt'];
$mistake->exec("update w_usuarios set pt=pt+$qttt, dada=dada+1 where id='$meuid'");
$mistake->exec("update w_usuarios set pt=pt-$qttt, dade=dade+1 where id='".$qtt['uid']."'");
?>
Parabéns, você ganhou <?php echo $qtt['pt'];?> pontos!
<?php
}
else if($res1==$qtt['qt'])
{
$dn = $mistake->query("SELECT nm FROM w_usuarios WHERE id='".$qtt['uid']."'")->fetch();
$msg = "Olá ".html_entity_decode($dn[0]).", empatamos no jogo do dado, meu resultado foi [b]$res1 [/b] e o seu também foi [b]".$qtt['qt']."[/b]";
automsg($msg,$meuid,$qtt['uid']);
$mistake->exec("delete from w_dado where id='$id'");
?>
Deu empate!
<?php
}
else
{
$dn = $mistake->query("SELECT nm FROM w_usuarios WHERE id='".$qtt['uid']."'")->fetch();
$msg = "Olá ".html_entity_decode($dn[0]).", você ganhou [b]".$qtt['pt']."[/b] pontos no jogo do dado, meu resultado foi [b]$res1 [/b] e o seu foi [b]".$qtt['qt']."[/b]";
automsg($msg,$meuid,$qtt['uid']);
$mistake->exec("delete from w_dado where id='$id'");
$qttt = $qtt['pt'];
$mistake->exec("update w_usuarios set pt=pt-$qttt, dade=dade+1 where id='$meuid'");
$mistake->exec("update w_usuarios set pt=pt+$qttt, dada=dada+1 where id='".$qtt['uid']."'");
?>
Você perdeu <?php echo $qtt['pt'];?> pontos!
<?php
}
?></b><br/><br/>
<?php } ?>
<div align="center"><br/><br/>
<a href="dado?">Jogo do dado</a><br/>
<a href="entretenimento?">Entretenimento</a><br/>
<a href="home?"><?php echo $imginicio;?>Página principal</a><br><br>
<?php echo rodape();?>
</body>
</html>