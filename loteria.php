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
ativo($meuid,'Loteria ');
if($a==false) { ?>
<br/><div id="titulo"><b>Loteria</b></div><br/>
<div align="center"><b>Escolha 5 números entre 1 e 50</b><br/><br/></div>
<form action="loteria?a=jogar" method="post">
Número 1: <input type="text" name="valor1" size="2"><br/>
Número 2: <input type="text" name="valor2" size="2"><br/>
Número 3: <input type="text" name="valor3" size="2"><br/>
Número 4: <input type="text" name="valor4" size="2"><br/>
Número 5: <input type="text" name="valor5" size="2"><br/><br/>
Pagar: <select name="pagar">
<option value="1">1 Ponto</option>
<option value="2">2 Pontos</option>
</select><br/><br/>
<input type="submit" value="jogar"><br/><br/>
<b>*1 Ponto:</b> Pague 1 ponto por número errado, ganhe 3 pontos por número acertado e ganhe 20 pontos se acertar os 5.<br/>
<b>*2 Pontos:</b> Pague 2 pontos por número errado, ganhe 10 pontos por número acertado e ganhe 70 pontos se acertar os 5.<br/>
</form><br/><br/>
<?php } else if($a=='jogar') {
$res = rand(1,50);
for($i=1; $i<2; $i++)
{
$res2 = rand(1,50);
if($res2==$res) { --$i; }
}
for($i=1; $i<2; $i++)
{
$res3 = rand(1,50);
if($res3==$res or $res3==$res2) { --$i; }
}
for($i=1; $i<2; $i++)
{
$res4 = rand(1,50);
if($res4==$res or $res4==$res2 or $res4==$res3) { --$i; }
}
for($i=1; $i<2; $i++)
{
$res5 = rand(1,50);
if($res5==$res or $res5==$res2 or $res5==$res3 or $res5==$res4) { --$i; }
}
if($res==$_POST['valor1'] or $res==$_POST['valor2'] or $res==$_POST['valor3'] or $res==$_POST['valor4'] or $res==$_POST['valor5'])
{
$ptss = 1;
}
else
{
$ptss = 0;
}
if($res2==$_POST['valor1'] or $res2==$_POST['valor2'] or $res2==$_POST['valor3'] or $res2==$_POST['valor4'] or $res2==$_POST['valor5'])
{
$ptss2 = 1;
}
else
{
$ptss2 = 0;
}
if($res3==$_POST['valor1'] or $res3==$_POST['valor2'] or $res3==$_POST['valor3'] or $res3==$_POST['valor4'] or $res3==$_POST['valor5'])
{
$ptss3 = 1;
}
else
{
$ptss3 = 0;
}
if($res4==$_POST['valor1'] or $res4==$_POST['valor2'] or $res4==$_POST['valor3'] or $res4==$_POST['valor4'] or $res4==$_POST['valor5'])
{
$ptss4 = 1;
}
else
{
$ptss4 = 0;
}
if($res5==$_POST['valor1'] or $res5==$_POST['valor2'] or $res5==$_POST['valor3'] or $res5==$_POST['valor4'] or $res5==$_POST['valor5'])
{
$ptss5 = 1;
}
else
{
$ptss5 = 0;
}
$resultado = $ptss+$ptss2+$ptss3+$ptss4+$ptss5;
if($_POST['pagar']==1)
{
if($resultado==0)
{
$mistake->exec("UPDATE w_usuarios SET pt=pt-5 where id='$meuid'");
$result = '<b>Você perdeu 5 pontos</b>';
$result2 = 'não acertou nenhum número';
}
else if($resultado==1)
{
$mistake->exec("UPDATE w_usuarios SET pt=pt+3 where id='$meuid'");
$result = '<b>Você ganhou 3 pontos</b>';
$result2 = 'acertou 1 número';
}
else if($resultado==5)
{
$mistake->exec("UPDATE w_usuarios SET pt=pt+20 where id='$meuid'");
$result = "<b>Você ganhou 20 pontos</b>";
$result2 = "acertou todos os números";
}
else
{
$resultadoo = $resultado*3;
$mistake->exec("UPDATE w_usuarios SET pt=pt+$resultadoo where id='$meuid'");
$result = "<b>Você ganhou $resultadoo pontos</b>";
$result2 = "acertou $resultado números";
}
}
else
{
if($resultado==0)
{
$mistake->exec("UPDATE w_usuarios SET pt=pt-10 where id='$meuid'");
$result = '<b>Você perdeu 10 pontos</b>';
$result2 = 'não acertou nenhum número';
}
else if($resultado==1)
{
$mistake->exec("UPDATE w_usuarios SET pt=pt+10 where id='$meuid'");
$result = '<b>Você ganhou 10 pontos</b>';
$result2 = 'acertou 1 número';
}
else if($resultado==5)
{
$mistake->exec("UPDATE w_usuarios SET pt=pt+70 where id='$meuid'");
$result = "<b>Você ganhou 70 pontos</b>";
$result2 = "acertou todos os números";
}
else
{
$resultadoo = $resultado*10;
$mistake->exec("UPDATE w_usuarios SET pt=pt+$resultadoo where id='$meuid'");
$result = "<b>Você ganhou $resultadoo pontos</b>";
$result2 = "acertou $resultado números";
}
}
?>
<br/><div align="center"><b>Você <?php echo $result2;?></b><br/><br/></div>
Você jogou: <?php echo $_POST['valor1'];?>, <?php echo $_POST['valor2'];?>, <?php echo $_POST['valor3'];?>, <?php echo $_POST['valor4'];?> e <?php echo $_POST['valor5'];?>.
<br/><br/>
Sorteados: <?php echo $res;?>, <?php echo $res2;?>, <?php echo $res3;?>, <?php echo $res4;?> e <?php echo $res5;?>.
<br/><br/>
<?php echo $result;?><br/><br/>
<?php } else if($a=='ranking') { ?>
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
<a href="entretenimento?"><?php echo $imgservicos;?>Entretenimento</a><br/>
<a href="home?"><?php echo $imginicio;?>Página principal</a><br><br>
<?php echo rodape();?>
</body>
</html>