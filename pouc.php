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
ativo($meuid,'Para ou continua ');
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
<br/><div align="center"><img src="style/pouc.gif"><br/><br/>
<b>
<?php if($e=='jogar') {
$bruxa = rand(1,10);
if($bruxa==7) { ?>
<img src="style/bruxa.gif"><br/>
Que pena, a bruxa levou todos os seus pontos acumulados no para ou continua.<br/>
<?php
$saldob = $mistake->query("SELECT pouc FROM w_usuarios WHERE id='$meuid'")->fetch();
$mistake->exec("UPDATE w_usuarios SET pouce=pouce+$saldob[0], pouc='0' WHERE id='$meuid'"); } else {
$res = rand(3,10); ?>
Parabéns, você ganhou <?php echo $res;?> pontos.<br/>
<?php $mistake->exec("UPDATE w_usuarios SET pouc=pouc+$res WHERE id='$meuid'");
} } else if($e=='parar') { $saldoo = $mistake->query("SELECT pouc FROM w_usuarios WHERE id='$meuid'")->fetch();
echo $saldoo[0];?> pontos foram adicionados ao seu perfil.<br/>
<?php $mistake->exec("UPDATE w_usuarios SET pouca=pouca+$saldoo[0], pt=pt+$saldoo[0], pouc='0' WHERE id='$meuid'"); }
$saldo = $mistake->query("SELECT pouc FROM w_usuarios WHERE id='$meuid'")->fetch(); ?>
Saldo no Jogo: <?php echo $saldo[0];?> pontos</b><br/><br/>
<a href="pouc?&e=parar">PARA</a> ou <a href="pouc?&e=jogar&t=<?php echo time();?>">CONTINUA</a><br/><br/>
<a href="pouc?&a=funciona">COMO FUNCIONA</a><br/>
<a href="pouc?&a=ranking">RANKING</a><br/>
<?php } else if($a=='funciona') { ?>
<br/><div align="center"><b>COMO FUNCIONA</b><br/><br/>
Você não precisa ter pontos para jogar o <b>PARA OU CONTINUA</b>, os pontos que você ganha no jogo podem variar de <b>3</b> a <b>10</b>, eles vão acumulando e para
transferi-los para o perfil e só clicar em <b>PARA</b> ou clicar em <b>CONTINUA</b> para ganhar mais.
Mas cuidado com a bruxa se ela aparecer leva todos os pontos que você acumulou no jogo.<br/>
<?php } else if($a=='ranking') { ?>
<br/><div id="titulo"><b>Ranking</b></div><br/>
<div style="background-color:#EAF3FA;padding-top:2px;margin-top:4px;">
<a href="pouc?a=ranking2&e=acertos">Acertos</a></div>
<div style="background-color:#EBF9DF;padding-top:2px;margin-top:4px;">
<a href="pouc?a=ranking2&e=erros">Erros</a></div><br/>
<?php } else if($a=='ranking2') {
if($e=='acertos')
{
$contmsg = $mistake->query("SELECT count(*) FROM w_usuarios where pouca>'0'")->fetch();
$qz = 'pouca';
$ea = 'ganhos';
$tt = 'Acertos';
}
else if($e=='erros')
{
$contmsg = $mistake->query("SELECT count(*) FROM w_usuarios where pouce>'0'")->fetch();
$qz = 'pouce';
$ea = 'perdidos';
$tt = 'Erros';
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
$itens = $mistake->query("SELECT id, $qz FROM w_usuarios where pouca>'0' order by pouca desc limit $limit, $itensporpag");
}
else
{
$itens = $mistake->query("SELECT id, $qz FROM w_usuarios where pouce>'0' order by pouce desc limit $limit, $itensporpag");
}
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<a href="perfil?id=<?php echo $item->id;?>"><?php echo gerarnome($item->id);?></a> - <?php echo $item->$qz;?> pontos <?php echo $ea;?>
</div>
<?php $i++; } ?>
<br/><div align="center"><br/>
<?php if($pag>1) { $ppag = $pag-1; ?>
<a href="pouc?a=ranking2&e=<?php echo $e;?>&pag=<?php echo $ppag;?>">&#171;Anterior</a>
<?php } if($pag<$numpag) { $npag = $pag+1; ?>
<a href="pouc?a=ranking2&e=<?php echo $e;?>&pag=<?php echo $npag;?>">Próxima&#187;</a>
<?php } ?>
<br/><?php echo $pag.'/'.$numpag;?><br/>
<?php if($numpag>2) { ?>
<form action="pouc.php" method="get">
Pular para página<input name="pag" size="3">
<input type="submit" value="IR">
<input type="hidden" name="a" value="<?php echo $a;?>">
<input type="hidden" name="e" value="<?php echo $e;?>">
</form>
<?php } } else { ?>
<div align="center">Nenhum usuário!<br/><br/>
<?php } } if($a==true) { ?>
<br/><div align="center"><a href="pouc?">Para ou continua</a> <?php } ?>
<br/><div align="center"><a href="entretenimento?"><?php echo $imgservicos;?>Entretenimento</a><br/>
<a href="home?"><?php echo $imginicio;?>Página principal</a><br><br>
<?php echo rodape();?>
</body>
</html>