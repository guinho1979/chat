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

ativo($meuid,'Fazendas do site ');
if($a==false) { ?>
<br/><div id="titulo"><b>Fazendas do site</b></div><br/>
<div align="center">
<?php
if($e=='vender')
{
$rasp = $mistake->query("SELECT raspolozenje FROM w_fazenda WHERE uid='$meuid'")->fetch();
$pttt = $rasp[0]*5;
$mistake->exec("update w_usuarios set pt=pt+$pttt WHERE id='$meuid'");
$mistake->exec("DELETE FROM w_fazenda WHERE uid='$meuid'");
echo "<b>Você vendeu sua fazenda por $pttt pontos</b><br/><br/>"; }
?>
Aqui você pode criar sua fazenda no site<br/>
<a href="fazenda?a=regras">Regras</a><br/>
<?php
$dal = $mistake->query("SELECT COUNT(*) FROM w_fazenda WHERE uid='$meuid' AND ziv='1'")->fetch();
if($dal[0]==0) { ?>
<a href="fazenda?a=criar">Crie sua Fazenda</a><br/><br/>
<?php
$imal = $mistake->query("SELECT rodjen, smrt FROM w_fazenda WHERE uid='$meuid' AND ziv='0'")->fetch();
$zivio = $imal[1] - $imal[0];
if($zivio==0)
{
echo "";
}
else
{
     $nopl = $mistake->query("SELECT rodjen, smrt FROM w_fazenda WHERE uid='$meuid'")->fetch();
	 $sage = $nopl[1]-$nopl[0];
	 $oflls = ceil(($sage/(1*60))-1);
	 $ofllss = ceil($sage-($oflls*60));
	 $ofllh = ceil(($sage/(1*60*60))-1);
	 $ofllhh = ceil($oflls-($ofllh*60));
	 $oflld = ceil(($sage/(24*60*60))-1);
	 $oflldd = ceil($ofllh-($oflld*24));
if ($sage <= "60") $ofll1 = "$sage segundos";
if ($sage <= "3599" AND $sage > "60") $ofll1 = "$oflls minutos e $ofllss segundos";
if ($sage <= "86399" AND $sage >= "3600") $ofll1 = "$ofllh horas e $ofllhh minutos";
if ($sage >= "86400") $ofll1 = "$oflld dias e $oflldd horas"; ?>
<br/><br/>Seu Pet Virtual<b><?php echo $ofll1;?></b>
<?php } } else {
$meragochi = $mistake->query("SELECT ziv, ime, boja, tezina, rodjen, raspolozenje, broj FROM w_fazenda WHERE uid='$meuid'")->fetch();
?>
</div>
<br/>Nome da fazenda: <b><?php echo $meragochi[1];?></b><br/>
<?php
     $nopl = $mistake->query("SELECT rodjen FROM w_fazenda WHERE uid='$meuid'")->fetch();
	 $sage = time()-$nopl[0];
	 $oflls = ceil(($sage/(1*60))-1);
	 $ofllss = ceil($sage-($oflls*60));
	 $ofllh = ceil(($sage/(1*60*60))-1);
	 $ofllhh = ceil($oflls-($ofllh*60));
	 $oflld = ceil(($sage/(24*60*60))-1);
	 $oflldd = ceil($ofllh-($oflld*24));
if ($sage <= "60") $ofll1 = "$sage segundos";
if ($sage <= "3599" AND $sage > "60") $ofll1 = "$oflls minutos e $ofllss segundos";
if ($sage <= "86399" AND $sage >= "3600") $ofll1 = "$ofllh horas e $ofllhh minutos";
if ($sage >= "86400") $ofll1 = "$oflld dias e $oflldd horas"; ?>
Tempo de plantio: <b><?php echo $ofll1;?></b><br/>
Tipo de semente: <b><?php echo $meragochi[2];?></b><br/>
Total de frutos: <b><?php echo $meragochi[3];?></b><br/>
Estado de crescimento: <b><?php echo $meragochi[5];?>%</b><br/>
Lotes: <b><?php echo $meragochi[6];?></b><br/><br/>
<a href="fazenda?a=regar">Regar</a><br/>
<a href="fazenda?a=adubar">Adubar</a><br/>
<a href="fazenda?a=pragas">Retirar Pragas</a><br/>
<a href="fazenda?a=vender">Vender Sementes</a><br/>
<?php }
$ukupno = $mistake->query("SELECT COUNT(*) FROM w_fazenda WHERE ziv='1'")->fetch(); ?>
<div align="center">
<br/><b>Estatísticas</b><br/>
<a href="fazenda?a=estatisticas">Fazendas criados no site: <b><?php echo $ukupno[0];?></b></a><br/>
<?php
$memid = $mistake->query("SELECT uid, ime FROM w_fazenda ORDER BY rodjen DESC LIMIT 0,1")->fetch(); ?>
A mais nova fazenda criada é <b><?php echo $memid[1];?></b>, do membro
<a href="/<?php echo gerarlogin($memid[0]);?>"><?php echo gerarnome($memid[0]);?></a>
<?php
$nopl = $mistake->query("SELECT rodjen FROM w_fazenda WHERE uid='$memid[0]'")->fetch();
	 $sage = time()-$nopl[0];
	 $oflls = ceil(($sage/(1*60))-1);
	 $ofllss = ceil($sage-($oflls*60));
	 $ofllh = ceil(($sage/(1*60*60))-1);
	 $ofllhh = ceil($oflls-($ofllh*60));
	 $oflld = ceil(($sage/(24*60*60))-1);
	 $oflldd = ceil($ofllh-($oflld*24));
  if ($sage <= "60") $ofll1 = "$sage segundos";
  if ($sage <= "3599" AND $sage > "60") $ofll1 = "$oflls minutos, $ofllss segundos";
  if ($sage <= "86399" AND $sage >= "3600") $ofll1 = "$ofllh horas, $ofllhh minutos";
  if ($sage >= "86400") $ofll1 = "$oflld dias, $oflldd horas";
echo "($ofll1)<br/>";
$memid = $mistake->query("SELECT uid, ime FROM w_fazenda WHERE ziv='1' ORDER BY rodjen LIMIT 0,1")->fetch(); ?>
A Fazenda mais velha é <b><?php echo $memid[1];?></b> do membro <a href="/<?php echo gerarlogin($memid[0]);?>"><?php echo gerarnome($memid[0]);?></a>
<?php
     $nopl = $mistake->query("SELECT rodjen FROM w_fazenda WHERE uid='$memid[0]'")->fetch();
	 $sage = time()-$nopl[0];
	 $oflls = ceil(($sage/(1*60))-1);
	 $ofllss = ceil($sage-($oflls*60));
	 $ofllh = ceil(($sage/(1*60*60))-1);
	 $ofllhh = ceil($oflls-($ofllh*60));
	 $oflld = ceil(($sage/(24*60*60))-1);
	 $oflldd = ceil($ofllh-($oflld*24));
if ($sage <= "60") $ofll1 = "$sage segundos";
if ($sage <= "3599" AND $sage > "60") $ofll1 = "$oflls minutos e $ofllss segundos";
if ($sage <= "86399" AND $sage >= "3600") $ofll1 = "$ofllh horas e $ofllhh minutos";
if ($sage >= "86400") $ofll1 = "$oflld dias e $oflldd horas";
echo "($ofll1)<br/>";
$memid = $mistake->query("SELECT uid, ime, raspolozenje FROM w_fazenda ORDER BY raspolozenje DESC LIMIT 0,1")->fetch();
?>
A Fazenda com mais plantas é <b><?php echo $memid[1];?></b> do membro <a href="/<?php echo gerarlogin($memid[0]);?>"><?php echo gerarnome($memid[0]);?></a> (<?php echo $memid[2];?>%)
<br/>
<?php } else if($a=='regras') {  ?>
<br/><div id="titulo"><b>Regras</b></div><br/>
<div align="center"><b>Fazendas do site</b><br/><br/>
Ola <?php echo gerarnome($meuid);?> crie sua fazenda e cuide bem dela, adube, regue e retire as pragas.<br/>
Não regue demais suas plantas pois sua plantação pode morrer.<br/>
<?php } else if($a=='vender') {  ?>
<div align="center"><br/><br/>Deseja realmente vender sua fazenda?<br/>
<a href="fazenda?&e=vender">Vender fazenda</a><br/>
<?php } else if($a=='estatisticas') { $ukupno = $mistake->query("SELECT COUNT(*) FROM w_fazenda WHERE ziv='1'")->fetch(); ?>
<div align="center"><br/>
<b>Plantas</b><br/>
Estatisticas<br/>
Total de fazendas criadas: <?php echo $ukupno[0];?> </div><br/>
<?php
if($pag==false || $pag<=0)$pag=1;
$numitens = $ukupno[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->query("SELECT uid, ime, tezina, rodjen, boja, broj, raspolozenje FROM w_fazenda WHERE ziv='1' ORDER BY rodjen DESC LIMIT $limit, $itensporpag");
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div style="background-color:#<?php echo $i%2==0?'EAF3FA':'EBF9DF';?>;padding-top:2px;padding-bottom:2px;margin-top:4px;">
<?php
     $nopl = $mistake->query("SELECT rodjen FROM w_fazenda WHERE uid='".$item->uid."'")->fetch();
	 $sage = time()-$nopl[0];
	 $oflls = ceil(($sage/(1*60))-1);
	 $ofllss = ceil($sage-($oflls*60));
	 $ofllh = ceil(($sage/(1*60*60))-1);
	 $ofllhh = ceil($oflls-($ofllh*60));
	 $oflld = ceil(($sage/(24*60*60))-1);
	 $oflldd = ceil($ofllh-($oflld*24));
if ($sage <= "60") $ofll1 = "$sage segundos";
if ($sage <= "3599" AND $sage > "60") $ofll1 = "$oflls minutos e $ofllss segundos";
if ($sage <= "86399" AND $sage >= "3600") $ofll1 = "$ofllh horas e $ofllhh minutos";
if ($sage >= "86400") $ofll1 = "$oflld dias e $oflldd horas";
echo '<b>'.$item->ime;?></b> foi a <?php echo $item->broj;?>º fazenda de
<b><a href="/<?php echo gerarlogin($item->uid);?>"><?php echo gerarnome($item->uid);?></a></b>,
 com <?php echo $item->tezina;?> sementes de <?php echo $item->boja;?>, a <?php echo $ofll1;?> e seu crescimento é de <?php echo $item->raspolozenje;?>%
</div>
<?php $i++; } ?>
<div align="center"><br/>
<?php if($pag>1) { $ppag = $pag-1; ?>
<a href="fazenda?a=estatisticas&pag=<?php echo $ppag;?>">&#171;Anterior</a>
<?php } if($pag<$numpag) { $npag = $pag+1; ?>
<a href="fazenda?a=estatisticas&pag=<?php echo $npag;?>">Próxima&#187;</a>
<?php } ?>
<br/><?php echo $pag.'/'.$numpag;?><br/>
<?php if($numpag>2) { ?>
<form action="fazenda.php" method="get">
Pular para página<input name="pag" size="3">
<input type="submit" value="IR">
<input type="hidden" name="a" value="<?php echo $a;?>">
</form>
<?php } } else { ?>
<div align="center"><br/>Nenhuma fazenda criada!<br/><br/>
<?php } } else if($a=='criar') { ?>
<br/><div id="titulo"><b>Criar Fazenda</b></div><br/>
<form action="fazenda?a=criar2" method="post">
Nome da fazenda:<br/>
<input type="text" name="ime"><br/>
Semente:<br/>
<select name="boja">
<option value="Repolho">Repolho</option>
<option value="Cenoura">Cenoura</option>
<option value="Alface">Alface</option>
<option value="Melancia">Melancia</option>
<option value="Tomate">Tomate</option>
<option value="Agrião">Agrião</option>
<option value="Beterraba">Beterraba</option>
</select><br/>
<input type="submit" value="Criar">
</form><br/>
<?php } else if($a=='criar2') { ?>
<div align="center">
<?php
$hrana = time() - (7*60*60);
$exs = $mistake->query("SELECT COUNT(*) FROM w_fazenda WHERE uid='$meuid'")->fetch();
if($exs[0]>0)
{
$cc = $mistake->query("SELECT broj FROM w_fazenda WHERE uid='$meuid'")->fetch();
$cc = $cc[0]+1;
$res = $mistake->exec("UPDATE w_fazenda SET rodjen='".time()."', tezina='500', ime='".$_POST['ime']."', ziv='1', nahranjen='".$hrana."', boja='".$_POST['boja']."', igra='".$hrana."', kupanje='".$hrana."', smrt='0', raspolozenje='5', broj='".$cc."' WHERE uid='$meuid'");
}
else
{
$res = $mistake->exec("INSERT INTO w_fazenda (uid,rodjen,tezina,ime,ziv,nahranjen,boja,igra,kupanje,broj) values('$meuid','".time()."','500','".$_POST['ime']."','1','$hrana','".$_POST['boja']."','$hrana','$hrana','1')");
}
if($res) { ?>
<br/><?php $imgok;?>Sua fazenda foi criada com sucesso, com nome <b><?php echo $_POST['ime'];?></b><br/>
<?php } else { echo $imgerro;?>
Erro no banco de dados, tente novamente!
<?php } }  else if($a=='regar') { ?>
<br/><div id="titulo"><b>Regar plantas</b></div>
<div align="center"><br/>
<?php
$nopl = $mistake->query("SELECT nahranjen FROM w_fazenda WHERE uid='$meuid'")->fetch();
$sage = time()-$nopl[0];
$oflls = ceil(($sage/(1*60))-1);
$ofllss = ceil($sage-($oflls*60));
$ofllh = ceil(($sage/(1*60*60))-1);
$ofllhh = ceil($oflls-($ofllh*60));
$oflld = ceil(($sage/(24*60*60))-1);
$oflldd = ceil($ofllh-($oflld*24));
if ($sage <= "60") $ofll1 = "$sage segundos";
if ($sage <= "3599" AND $sage > "60") $ofll1 = "$oflls minutos e $ofllss segundos";
if ($sage <= "86399" AND $sage >= "3600") $ofll1 = "$ofllh horas e $ofllhh minutos";
if ($sage >= "86400") $ofll1 = "$oflld dias e $oflldd horas"; ?>
A última vez que as suas plantas foram regadas foi a <?php echo $ofll1;?><br/>
<a href="fazenda?a=regar2">Regar</a><br/>
<?php } else if($a=='regar2') {  ?>
<div align="center"><br/>
<?php
$nopl = $mistake->query("SELECT tezina FROM w_fazenda WHERE uid='$meuid'")->fetch();
if($nopl[0]>'4999')
{
$mistake->exec("UPDATE w_fazenda SET ziv='0', smrt='".time()."' WHERE uid='$meuid'");
echo 'Sua planta morreu por ter sido regada de mais';
}
else if($nopl[0]<'300')
{
$mistake->exec("UPDATE w_fazenda SET ziv='0', smrt='".time()."' WHERE uid='$meuid'");
echo 'Sua planta morreu por falta de água';
}
else if($nopl[0]>'299' AND $nopl[0]<'5000')
{
$nopl = $mistake->query("SELECT nahranjen FROM w_fazenda WHERE uid='$meuid'")->fetch();
$nopl1 = time() - $nopl[0];
$tezina = $mistake->query("SELECT tezina FROM w_fazenda WHERE uid='$meuid'")->fetch();
if($nopl1<'28800')
{
$mistake->exec("UPDATE w_fazenda SET tezina=tezina+250, nahranjen='".time()."' WHERE uid='$meuid'");
echo "Você tem regado bastante sua planta. Ela está com ".($tezina[0]+250)." frutos.";
}
else if($nopl1<'43200' AND $nopl1>'28799')
{
$mistake->exec("UPDATE w_fazenda SET nahranjen='".time()."' WHERE uid='$meuid'");
echo "Você regou sua planta. Ela está com $tezina[0] frutos.";
}
else if($nopl1<'54000' AND $nopl1>'43199')
{
$mistake->exec("UPDATE w_fazenda SET tezina=tezina-100, nahranjen='".time()."' WHERE uid='$meuid'");
echo "Você demorou bastante para regar sua planta, agora chegou a hora de aduba-la. Ela está com ".($tezina[0]-100)." frutos";
}
else if($nopl1<'64800' AND $nopl1>'53999')
{
$mistake->exec("UPDATE w_fazenda SET tezina=tezina-200, nahranjen='".time()."' WHERE uid='$meuid'");
echo "Sua planta estava a mais de 15 horas sem água, perdeu 200 frutos. Agora está com ".($tezina[0]-200)." frutos.";
}
else
{
$mistake->exec("UPDATE w_fazenda SET smrt='".time()."', ziv='0' WHERE uid='$meuid'");
echo "Sua planta morreu por ter ficado mais de 18 horas sem água.";
}
echo "<br/>Regue sua planta de 8-12 horas, ou pelo menos duas vez ao dia.<br/><br/>";
}
} else if($a=='adubar') { ?>
<br/><div id="titulo"><b>Adubar sua planta</b></div>
<div align="center"><br/>
<?php
     $nopl = $mistake->query("SELECT igra FROM w_fazenda WHERE uid='$meuid'")->fetch();
	 $sage = time()-$nopl[0];
	 $oflls = ceil(($sage/(1*60))-1);
	 $ofllss = ceil($sage-($oflls*60));
	 $ofllh = ceil(($sage/(1*60*60))-1);
	 $ofllhh = ceil($oflls-($ofllh*60));
	 $oflld = ceil(($sage/(24*60*60))-1);
	 $oflldd = ceil($ofllh-($oflld*24));
if ($sage <= "60") $ofll1 = "$sage segundos";
if ($sage <= "3599" AND $sage > "60") $ofll1 = "$oflls minutos e $ofllss segundos";
if ($sage <= "86399" AND $sage >= "3600") $ofll1 = "$ofllh horas e $ofllhh minutos";
if ($sage >= "86400") $ofll1 = "$oflld dias e $oflldd horas"; ?>
  
A última vez que você adubou sua planta foi a <?php echo $ofll1;?><br/>
<a href="fazenda?a=adubar2">Adubar</a><br/>
<?php } else if($a=='adubar2') { ?>
<div align="center"><br/>
<?php
$nopl = $mistake->query("SELECT igra FROM w_fazenda WHERE uid='$meuid'")->fetch();
$nopl1 = time() - $nopl[0];
if($nopl1<'600')
{
$res = $mistake->exec("UPDATE w_fazenda SET igra='".time()."' WHERE uid='$meuid'");
$tezina = $mistake->query("SELECT raspolozenje FROM w_fazenda WHERE uid='$meuid'")->fetch();
$tezina = $tezina[0] + 0;
$res = $mistake->exec("UPDATE w_fazenda SET raspolozenje='$tezina' WHERE uid='$meuid'");
$rasp = $mistake->query("SELECT raspolozenje FROM w_fazenda WHERE uid='$meuid'")->fetch();
echo "Sua planta está adubada, está com $rasp[0]% de crescimento.<br/>";
}
else if($nopl1<'43200' AND $nopl1>'599')
{
$res = $mistake->exec("UPDATE w_fazenda SET igra='".time()."' WHERE uid='$meuid'");
$tezina = $mistake->query("SELECT raspolozenje FROM w_fazenda WHERE uid='$meuid'")->fetch();
$tezina = $tezina[0] + 2;
$res = $mistake->exec("UPDATE w_fazenda SET raspolozenje='$tezina' WHERE uid='$meuid'");
$rasp = $mistake->query("SELECT raspolozenje FROM w_fazenda WHERE uid='$meuid'")->fetch();
echo "Sua planta está adubada, está com $rasp[0]% de crescimento.<br/>";
}
else if($nopl1<'86400' AND $nopl1>'43199')
{
$res = $mistake->exec("UPDATE w_fazenda SET igra='".time()."' WHERE uid='$meuid'");
$tezina = $mistake->query("SELECT raspolozenje FROM w_fazenda WHERE uid='$meuid'")->fetch();
$tezina = $tezina[0] + 1;
$res = $mistake->exec("UPDATE w_fazenda SET raspolozenje='$tezina' WHERE uid='$meuid'");
$rasp = $mistake->query("SELECT raspolozenje FROM w_fazenda WHERE uid='$meuid'")->fetch();
echo "Sua planta está adubada, está com $rasp[0]% de crescimento.<br/>";
}
else if($nopl1>'86399')
{
$res = $mistake->exec("UPDATE w_fazenda SET igra='".time()."' WHERE uid='$meuid'");
$tezina = $mistake->query("SELECT raspolozenje FROM w_fazenda WHERE uid='$meuid'")->fetch();
$tezina = $tezina[0] - 1;
$res = $mistake->exec("UPDATE w_fazenda SET raspolozenje='$tezina' WHERE uid='$meuid'");
$rasp = $mistake->query("SELECT raspolozenje FROM w_fazenda WHERE uid='$meuid'")->fetch();
echo "Sua planta está adubada, está com $rasp[0]% de crescimento.<br/>";
}
} else if($a=='pragas') { ?>
<br/><div id="titulo"><b>Retirar pragas</b></div>
<div align="center"><br/>
<?php
$nopl = $mistake->query("SELECT kupanje FROM w_fazenda WHERE uid='$meuid'")->fetch();
$sage = time()-$nopl[0];
$oflls = ceil(($sage/(1*60))-1);
$ofllss = ceil($sage-($oflls*60));
$ofllh = ceil(($sage/(1*60*60))-1);
$ofllhh = ceil($oflls-($ofllh*60));
$oflld = ceil(($sage/(24*60*60))-1);
$oflldd = ceil($ofllh-($oflld*24));
if ($sage <= "60") $ofll1 = "$sage segundos";
if ($sage <= "3599" AND $sage > "60") $ofll1 = "$oflls minutos e $ofllss segundos";
if ($sage <= "86399" AND $sage >= "3600") $ofll1 = "$ofllh horas e $ofllhh minutos";
if ($sage >= "86400") $ofll1 = "$oflld dias e $oflldd horas"; ?>
A última vez que você retirou as pragas de sua planta foi a <?php echo $ofll1;?><br/>
<a href="fazenda?a=pragas2">Retirar pragas</a><br/>
<?php } else if($a=='pragas2') { ?>
<div align="center"><br/>
<?php
$nopl = $mistake->query("SELECT kupanje FROM w_fazenda WHERE uid='$meuid'")->fetch();
$nopl1 = time() - $nopl[0];
if($nopl1<'21599')
{
$res = $mistake->exec("UPDATE w_fazenda SET kupanje='".time()."' WHERE uid='$meuid'");
$tezina = $mistake->query("SELECT raspolozenje FROM w_fazenda WHERE uid='$meuid'")->fetch();
$tezina = $tezina[0] - 1;
$res = $mistake->exec("UPDATE w_fazenda SET raspolozenje='$tezina' WHERE uid='$meuid'");
$rasp = $mistake->query("SELECT raspolozenje FROM w_fazenda WHERE uid='$meuid'")->fetch();
echo "Você retirou as pragas de sua planta, ela está com $rasp[0]% de crescimento.<br/>";
}
if($nopl1<'86400' AND $nopl1>'21600')
{
$res = $mistake->exec("UPDATE w_fazenda SET kupanje='".time()."' WHERE uid='$meuid'");
$tezina = $mistake->query("SELECT raspolozenje FROM w_fazenda WHERE uid='$meuid'")->fetch();
$tezina = $tezina[0] + 2;
$res = $mistake->exec("UPDATE w_fazenda SET raspolozenje='$tezina' WHERE uid='$meuid'");
$rasp = $mistake->query("SELECT raspolozenje FROM w_fazenda WHERE uid='$meuid'")->fetch();
echo "Você retirou as pragas de sua planta, ela está com $rasp[0]% de crescimento.<br/>";
}
else if($nopl1<'172800' AND $nopl1>'86399')
{
$res = $mistake->exec("UPDATE w_fazenda SET igra='".time()."' WHERE uid='$meuid'");
$tezina = $mistake->query("SELECT raspolozenje FROM w_fazenda WHERE uid='$meuid'")->fetch();
$tezina = $tezina[0] + 1;
$res = $mistake->exec("UPDATE w_fazenda SET raspolozenje='$tezina' WHERE uid='$meuid'");
$rasp = $mistake->query("SELECT raspolozenje FROM w_fazenda WHERE uid='$meuid'")->fetch();
echo "Você retirou as pragas de sua planta, ela está com $rasp[0]% de crescimento.<br/>";
}
else if($nopl1>'172799')
{
$res = $mistake->exec("UPDATE w_fazenda SET ziv='0', smrt='".time()."' WHERE uid='$meuid'");
echo "Sua planta não sobreviveu as pragas.<br/>";
}
}
?>
<br/><div align="center">
<?php if($a==true) { ?>
<a href="fazenda?">Menu Fazenda</a><br/>
<?php } ?>
<a href="entretenimento?"><?php echo $imgservicos;?>Entretenimento</a><br/>
<a href="home?"><?php echo $imginicio;?>Página principal</a><br><br>
<?php echo rodape();?>
</body>
</html>