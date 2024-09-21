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
ativo($meuid,'Jogo da bolinha :) ');
if($a==false) {
$mistake->exec("UPDATE w_usuarios SET bol='".rand(1,3)."' WHERE id='$meuid'");
$acu = $mistake->query("SELECT bac, bgan, bganq FROM w_geral")->fetch();  ?>
<br/><div id="titulo"><b>Ache a bolinha</b></div><br/>
<div align="center"><img src="imgs/bpd.jpg"><br/><br/>
<form action="bolinha?a=jogar" method="post">
Aonde está a bolinha? <select name="bol">
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
</select><br/><input type="submit" value="Jogar">
</div></form>
<br/><br/>Prêmio acumulado: <b><?php echo $acu[0];?></b> pontos<?php echo $acu[0]>1?'s':'';?><br/>
Último ganhador: <b><a href="perfil?id=<?php echo $acu[1];?>"><?php echo gerarnome($acu[1]);?></a></b><br/>
<a href="perfil?id=<?php echo $acu[1];?>"><?php echo gerarnome($acu[1]);?></a> ganhou: <b><?php echo $acu[2];?></b> pontos<?php echo $acu[2]>1?'s':'';?>
<br/><br/>
<?php } else if($a=='jogar') { $bol = $mistake->query("SELECT bol FROM w_usuarios WHERE id='$meuid'")->fetch();
if($bol[0]==$_POST['bol'])
{
$geral = $mistake->query("SELECT bac FROM w_geral")->fetch();
$mistake->exec("UPDATE w_geral SET bganq=bac");
$mistake->exec("UPDATE w_geral SET bac='0', bgan='$meuid'");
$mistake->exec("UPDATE w_usuarios SET pt=pt+$geral[0], bolia=bolia+1 where id='$meuid'");
$res = 'Acertou';
}
else
{
$mistake->exec("UPDATE w_geral SET bac=bac+1");
$mistake->exec("UPDATE w_usuarios SET pt=pt-1, bolie=bolie+1 WHERE id='$meuid'");
$res = 'Errou';
}
?>
<br/><div id="titulo"><b>Ache a bolinha</b></div><br/>
<div align="center"><b><?php echo $res;?></b>: Você escolheu a número <b><?php echo $_POST['bol'];?></b><br/><br/>
<?php if($bol[0]==1) { ?>
<img src="imgs/bol1.jpg">
<?php } else if($bol[0]==2) { ?>
<img src="imgs/bol2.jpg">
<?php } else if($bol[0]==3) { ?>
<img src="imgs/bol3.jpg">
<?php } else if($bol[0]==0) { ?>
Você já jogou, clique em jogar novamente.
<?php } ?>
<br/><br/>
<a href="bolinha?">Jogar novamente</a><br/><br/>
<?php $mistake->exec("UPDATE w_usuarios SET bol='0' WHERE id='$meuid'");
} else if($a=='ranking') { ?>
<br/><div id="titulo"><b>Ranking</b></div><br/>
<div style="background-color:#EAF3FA;padding-top:2px;margin-top:4px;">
<a href="bolinha?a=ranking2&e=acertos">Acertos</a></div>
<div style="background-color:#EBF9DF;padding-top:2px;margin-top:4px;">
<a href="bolinha?a=ranking2&e=erros">Erros</a></div><br/>
<?php } else if($a=='ranking2') {
if($e=='acertos')
{
$contmsg = $mistake->query("SELECT count(*) FROM w_usuarios where bolia>'0'")->fetch();
$qz = 'bolia';
$ea = 'acertos';
$tt = 'Acertos';
}
else if($e=='erros')
{
$contmsg = $mistake->query("SELECT count(*) FROM w_usuarios where bolie>'0'")->fetch();
$qz = 'bolie';
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
$itens = $mistake->query("SELECT id, $qz FROM w_usuarios where bolia>'0' order by bolia desc limit $limit, $itensporpag");
}
else
{
$itens = $mistake->query("SELECT id, $qz FROM w_usuarios where bolie>'0' order by bolie desc limit $limit, $itensporpag");
}
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<a href="perfil?id=<?php echo $item->id;?>"><?php echo gerarnome($item->id);?></a> - <?php echo $item->$qz.' '.$ea;?>
</div>
<?php $i++; } ?>
<br/><div align="center"><br/>
<?php if($pag>1) { $ppag = $pag-1; ?>
<a href="bolinha?a=ranking2&e=<?php echo $e;?>&pag=<?php echo $ppag;?>">&#171;Anterior</a>
<?php } if($pag<$numpag) { $npag = $pag+1; ?>
<a href="bolinha?a=ranking2&e=<?php echo $e;?>&pag=<?php echo $npag;?>">Próxima&#187;</a>
<?php } ?>
<br/><?php echo $pag.'/'.$numpag;?><br/>
<?php if($numpag>2) { ?>
<form action="bolinha.php" method="get">
Pular para página<input name="pag" size="3">
<input type="submit" value="IR">
<input type="hidden" name="a" value="<?php echo $a;?>">
<input type="hidden" name="e" value="<?php echo $e;?>">
</form>
<?php } } else { ?>
<div align="center">Nenhum usuário!<br/><br/>
<?php } ?>
<br/><div align="center"><a href="bolinha?">Ache a bolinha</a>
<?php } ?>
	
<div align="center">
<a href="bolinha?a=ranking">Ranking</a><br/>
<a href="entretenimento?"><?php echo $imgservicos;?>Entretenimento</a><br/>
<a href="home?"><?php echo $imginicio;?>Página principal</a><br><br>
<?php echo rodape();?>
</body>
</html>