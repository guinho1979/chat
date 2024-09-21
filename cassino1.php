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
ativo($meuid,'Cassino ');
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
if($a==false) {
$geral = $mistake->query("SELECT cac FROM w_geral")->fetch(); if($e==false) { ?>
<br/><div id="titulo"><b>Ranking</b></div><br/>
<div style="background-color:#EAF3FA;padding-top:2px;margin-top:4px;">
<a href="cassino1?a=rcas&e=acertos">Acertos</a></div>
<div style="background-color:#EBF9DF;padding-top:2px;margin-top:4px;">
<a href="cassino1?a=rcas&e=erros">Erros</a></div>   <?php } ?>
<br/><div id="titulo"><b>Cassino</b></div><br/>
<div align="center">
<?php if($e==false) { ?>
Ganhe todo o prêmio acumulado acertando com 3 imagens iguais.<br/>Ao todo são 6 imagens diferentes de cada categoria.
<?php } else {
$fruta = rand(1,6);
$fruta2 = rand(1,6);
$fruta3 = rand(1,6);
?>
<table border="1"><tr bgcolor="#F4F4F4">
<td><img src="/cassino/<?php echo $pag.$fruta;?>.gif" /></td>
<td><img src="/cassino/<?php echo $pag.$fruta2;?>.gif" /></td>
<td><img src="/cassino/<?php echo $pag.$fruta3;?>.gif" /></td>
</tr></table>
<?php if($fruta==$fruta2 and $fruta==$fruta3) { 
$mistake->exec("UPDATE w_geral SET cganq=cac");
$mistake->exec("UPDATE w_geral SET cac='100', cgan='$meuid'");
$mistake->exec("UPDATE w_usuarios SET pt=pt+$geral[0], cassa=cassa+1 where id='$meuid'");
?>
<b>Parabéns, Você ganhou <?php echo $geral['cac'];?> pontos!</b>
<?php } else { 
$mistake->exec("UPDATE w_geral SET cac=cac+10");
$mistake->exec("UPDATE w_usuarios SET pt=pt-10, casse=casse+1 where id='$meuid'");
?>
Você perdeu 10 pontos!
<?php } } ?>	
	
<br/><br/>
<a href="cassino1?pag=a&e=<?php echo time();?>">Animais</a><br/><br/>
<a href="cassino1?pag=f&e=<?php echo time();?>">Frutas</a><br/><br/>
<a href="cassino1?pag=t&e=<?php echo time();?>">Times</a><br/><br/>
<!--<a href="cassino1?pag=s&e=<?php echo time();?>">Sexy</a><br/><br/>-->
</div>
<?php $acu = $mistake->query("SELECT cac, cgan, cganq FROM w_geral")->fetch(); ?>
<br/><br/>Prêmio acumulado: <b><?php echo $acu[0];?></b> ponto<?php echo $acu[0]>1?'s':'';?><br/>
Último ganhador: <b><a href="perfil?id=<?php echo $acu[1];?>"><?php echo gerarnome($acu[1]);?></a></b><br/>
<a href="perfil?id=<?php echo $acu[1];?>"><?php echo gerarnome($acu[1]);?></a> ganhou: <b><?php echo $acu[2];?></b> ponto<?php echo $acu[2]>1?'s':'';?>
<br/><br/>
<?php } else if($a=='rcas') { 
if($e=='acertos')
{
$contmsg = $mistake->query("SELECT count(*) FROM w_usuarios where cassa>'0'")->fetch();
$qz = 'cassa';
$ea = 'acertos';
$tt = 'Acertos';
}
else if($e=='erros')
{
$contmsg = $mistake->query("SELECT count(*) FROM w_usuarios where casse>'0'")->fetch();
$qz = 'casse';
$ea = 'erros';
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
$itens = $mistake->query("SELECT id, $qz FROM w_usuarios where cassa>'0' order by cassa desc limit $limit, $itensporpag");
}
else
{
$itens = $mistake->query("SELECT id, $qz FROM w_usuarios where casse>'0' order by casse desc limit $limit, $itensporpag");
}
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<a href="perfil?id=<?php echo $item->id;?>"><?php echo gerarnome($item->id);?></a> - <?php echo $item->$qz.' '.$ea;?>
</div>
<?php $i++; } ?>
<br/><div align="center"><br/>
<?php if($pag>1) { $ppag = $pag-1; ?>
<a href="cassino1?a=rcas&e=<?php echo $e;?>&pag=<?php echo $ppag;?>">&#171;Anterior</a>
<?php } if($pag<$numpag) { $npag = $pag+1; ?>
<a href="cassino1?a=rcas&e=<?php echo $e;?>&pag=<?php echo $npag;?>">Próxima&#187;</a>
<?php } ?>
<br/><?php echo $pag.'/'.$numpag;?><br/>
<?php if($numpag>2) { ?>
<form action="cassino.php" method="get">
Pular para página<input name="pag" size="3">
<input type="submit" value="IR">
<input type="hidden" name="a" value="<?php echo $a;?>">
<input type="hidden" name="e" value="<?php echo $e;?>">
</form>
<?php } } else { ?>
<div align="center">Nenhum usuário!<br/><br/>
<?php } ?>
<br/><div align="center"><a href="cassino1?">Cassino</a>
<?php } ?>
 
<div align="center">
<a href="cassino1?">Sobre o cassino</a><br/><br/>
<a href="entretenimento?"><?php echo $imgservicos;?>Entretenimento</a><br/>
<a href="home?"><?php echo $imginicio;?>Página principal</a><br><br>
<?php echo rodape();?>
</body>
</html>