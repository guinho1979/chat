<?php
require_once("".$_SERVER["DOCUMENT_ROOT"]."/funcoes.php");
require_once("".$_SERVER["DOCUMENT_ROOT"]."/mistake.php");
seg($meuid);
ativo($meuid,'Pet Virtual ');
if($a==false) {
if($e=='matar')
{
$mistake->exec("DELETE FROM w_wapet WHERE uid='$meuid'");
}
?>
<br/><div id="titulo"><b>Virtual Pet</b></div><br/>
<div align="center">Aqui você pode criar seu Virtual Pet<br/>
<a href="wapet?a=regras">Regras</a><br/>
<?php
$dal = $mistake->query("SELECT COUNT(*) FROM w_wapet WHERE uid='$meuid' AND ziv='1'")->fetch();
if($dal[0]==0) { ?>
<a href="wapet?a=criar">Crie seu Virtual Pet</a><br/><br/>
<?php
$imal = $mistake->query("SELECT rodjen, smrt FROM w_wapet WHERE uid='$meuid' AND ziv='0'")->fetch();
$zivio = $imal[1] - $imal[0];
if($zivio==0)
{
echo "";
}
else
{
     $nopl = $mistake->query("SELECT rodjen, smrt FROM w_wapet WHERE uid='$meuid'")->fetch();
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
$meragochi = $mistake->query("SELECT ziv, ime, boja, tezina, rodjen, raspolozenje, broj FROM w_wapet WHERE uid='$meuid'")->fetch();
?>
</div>
<br/>Nome: <b><?php echo $meragochi[1];?></b><br/>
<?php
     $nopl = $mistake->query("SELECT rodjen FROM w_wapet WHERE uid='$meuid'")->fetch();
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
Idade: <b><?php echo $ofll1;?></b><br/>
Cor: <b><?php echo $meragochi[2];?></b><br/>
Peso: <b><?php echo $meragochi[3];?> gramas</b><br/>
Grau de felicidade: <b><?php echo $meragochi[5];?>%</b><br/>
Este é seu: <b><?php echo $meragochi[6];?>º</b> Virtual Pet<br/><br/>
<a href="wapet?a=alimentar">Alimenta-lo</a><br/>
<a href="wapet?a=divertir">Diverti-lo</a><br/>
<a href="wapet?a=banhar">Banha-lo</a><br/>
<a href="wapet?a=matar">Excluir seu Virtual Pet</a><br/>
<?php }
$ukupno = $mistake->query("SELECT COUNT(*) FROM w_wapet WHERE ziv='1'")->fetch(); ?>
<div align="center">
<br/><b>Estatísticas</b><br/>
<a href="wapet?a=estatisticas">Virtual pets criados no site: <b><?php echo $ukupno[0];?></b></a><br/>
<?php
$memid = $mistake->query("SELECT uid, ime FROM w_wapet ORDER BY rodjen DESC LIMIT 0,1")->fetch(); ?>
O mais novo Virtual Pet criado é <b><?php echo $memid[1];?></b>, do membro
<a href="/<?php echo gerarlogin($memid[0]);?>"><?php echo gerarnome($memid[0]);?></a>
<?php
$nopl = $mistake->query("SELECT rodjen FROM w_wapet WHERE uid='$memid[0]'")->fetch();
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
$memid = $mistake->query("SELECT uid, ime FROM w_wapet WHERE ziv='1' ORDER BY rodjen LIMIT 0,1")->fetch(); ?>
O Virtual Pet mais velho é <b><?php echo $memid[1];?></b> do membro <a href="/<?php echo gerarlogin($memid[0]);?>"><?php echo gerarnome($memid[0]);?></a>
<?php
     $nopl = $mistake->query("SELECT rodjen FROM w_wapet WHERE uid='$memid[0]'")->fetch();
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
$memid = $mistake->query("SELECT uid, ime, raspolozenje FROM w_wapet ORDER BY raspolozenje DESC LIMIT 0,1")->fetch();
?>
O Virtual Pet mais feliz é <b><?php echo $memid[1];?></b> do membro <a href="/<?php echo gerarlogin($memid[0]);?>"><?php echo gerarnome($memid[0]);?></a> (<?php echo $memid[2];?>%)
<br/>
<?php } else if($a=='regras') {  ?>
<br/><div id="titulo"><b>Regras</b></div><br/>
<div align="center"><img src="style/wapet.gif">
<br/><b>Virtual Pet</b><br/><br/>
Virtual Pet é seu bichinho virtual, você deve cuidar bem dele, com uma boa alimentação, dando banho e se divertindo com ele.<br/>
O peso de seu Virtual Pet não pode ultrapassar 5.000 gramas, se não, ele morre.<br/>
<?php } else if($a=='matar') {  ?>
<div align="center"><img src="style/triste.gif">
<br/><br/>Deseja realmente excluir seu Virtual Pet?<br/>
<a href="wapet?&e=matar">Excluir Virtual Pet</a><br/>
<?php } else if($a=='estatisticas') { $ukupno = $mistake->query("SELECT COUNT(*) FROM w_wapet WHERE ziv='1'")->fetch(); ?>
<div align="center">
<img src="style/wapet.gif"><br/>
<b>Virtual Pet</b><br/>
Estatisticas<br/>
Total de pets criados: <?php echo $ukupno[0];?> </div><br/>
<?php
if($pag==false || $pag<=0)$pag=1;
$numitens = $ukupno[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->query("SELECT uid, ime, tezina, rodjen, boja, broj, raspolozenje FROM w_wapet WHERE ziv='1' ORDER BY rodjen DESC LIMIT $limit, $itensporpag");
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<?php
     $nopl = $mistake->query("SELECT rodjen FROM w_wapet WHERE uid='".$item->uid."'")->fetch();
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
echo '<b>'.$item->ime;?></b> foi o <?php echo $item->broj;?>º Virtual Pet de
<b><a href="/<?php echo gerarlogin($item->uid);?>"><?php echo gerarnome($item->uid);?></a></b>,
 com <?php echo $item->tezina;?> gramas, da cor <?php echo $item->boja;?>, com idade de <?php echo $ofll1;?> e sua felicidade é de <?php echo $item->raspolozenje;?>%
</div>
<?php $i++; } ?>
<div align="center"><br/>
<?php if($pag>1) { $ppag = $pag-1; ?>
<a href="wapet?a=estatisticas&pag=<?php echo $ppag;?>">&#171;Anterior</a>
<?php } if($pag<$numpag) { $npag = $pag+1; ?>
<a href="wapet?a=estatisticas&pag=<?php echo $npag;?>">Próxima&#187;</a>
<?php } ?>
<br/><?php echo $pag.'/'.$numpag;?><br/>
<?php if($numpag>2) { ?>
<form action="wapet.php" method="get">
Pular para página<input name="pag" size="3">
<input type="submit" value="IR">
<input type="hidden" name="a" value="<?php echo $a;?>">
<input type="hidden" name="on" value="<?php echo $on;?>">
</form>
<?php } } else { ?>
<div align="center"><br/>Nenhum Virtual Pet criado!<br/><br/>
<?php } } else if($a=='criar') { ?>
<br/><div id="titulo"><b>Criar Virtual Pet</b></div><br/>
<form action="wapet?a=criar2" method="post">
Nome do Virtual Pet:<br/>
<input type="text" name="ime"><br/>
Cor:<br/>
<select name="boja">
<option value="Marrom">Marrom</option>
<option value="Rosa">Rosa</option>
<option value="Vermelho">Vermelho</option>
<option value="Verde">Verde</option>
<option value="Roxo">Roxo</option>
</select><br/>
<input type="submit" value="Criar">
</form><br/>
<?php } else if($a=='criar2') { ?>
<div align="center">
<?php
$hrana = time() - (7*60*60);
$exs = $mistake->query("SELECT COUNT(*) FROM w_wapet WHERE uid='$meuid'")->fetch();
if($exs[0]>0)
{
$cc = $mistake->query("SELECT broj FROM w_wapet WHERE uid='$meuid'")->fetch();
$cc = $cc[0]+1;
$res = $mistake->exec("UPDATE w_wapet SET rodjen='".time()."', tezina='500', ime='".$_POST['ime']."', ziv='1', nahranjen='".$hrana."', boja='".$_POST['boja']."', igra='".$hrana."', kupanje='".$hrana."', smrt='0', raspolozenje='5', broj='".$cc."' WHERE uid='$meuid'");
}
else
{
$res = $mistake->exec("INSERT INTO w_wapet (uid,rodjen,tezina,ime,ziv,nahranjen,boja,igra,kupanje,broj) values('$meuid','".time()."','500','".$_POST['ime']."','1','$hrana','".$_POST['boja']."','$hrana','$hrana','1')");
}
if($res) { ?>
<br/><?php $imgok;?>Seu Virtual Pet foi criado com sucesso, com nome <b><?php echo $_POST['ime'];?></b><br/>
<?php } else { echo $imgerro;?>
Erro no banco de dados, tente novamente!
<?php } }  else if($a=='alimentar') { ?>
<br/><div id="titulo"><b>Alimentar Virtual Pet</b></div>
<div align="center"><img src="style/alimentar.gif"><br/>
<?php
$nopl = $mistake->query("SELECT nahranjen FROM w_wapet WHERE uid='$meuid'")->fetch();
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
A última refeição que seu Virtual Pet fez foi a <?php echo $ofll1;?><br/>
<a href="wapet?a=alimentar2">Alimenta-lo</a><br/>
<?php } else if($a=='alimentar2') {  ?>
<div align="center"><img src="style/wapet.gif"><br/>
<?php
$nopl = $mistake->query("SELECT tezina FROM w_wapet WHERE uid='$meuid'")->fetch();
if($nopl[0]>'4999')
{
$mistake->exec("UPDATE w_wapet SET ziv='0', smrt='".time()."' WHERE uid='$meuid'");
echo 'Seu Virtual Pet morreu por ter se alimentado muito, ultrapassou 5.000 gramas.';
}
else if($nopl[0]<'300')
{
$mistake->exec("UPDATE w_wapet SET ziv='0', smrt='".time()."' WHERE uid='$meuid'");
echo 'Seu Virtual Pet morreu por falta de alimentação, ficou com menos de 300 gramas.';
}
else if($nopl[0]>'299' AND $nopl[0]<'5000')
{
$nopl = $mistake->query("SELECT nahranjen FROM w_wapet WHERE uid='$meuid'")->fetch();
$nopl1 = time() - $nopl[0];
$tezina = $mistake->query("SELECT tezina FROM w_wapet WHERE uid='$meuid'")->fetch();
if($nopl1<'28800')
{
$mistake->exec("UPDATE w_wapet SET tezina=tezina+250, nahranjen='".time()."' WHERE uid='$meuid'");
echo "Seu Virtual Pet tem comido demais. Está com ".($tezina[0]+250)." gramas.";
}
else if($nopl1<'43200' AND $nopl1>'28799')
{
$mistake->exec("UPDATE w_wapet SET nahranjen='".time()."' WHERE uid='$meuid'");
echo "Seu Virtual Pet tem ganhado muito peso. Está com $tezina[0] gramas";
}
else if($nopl1<'54000' AND $nopl1>'43199')
{
$mistake->exec("UPDATE w_wapet SET tezina=tezina-100, nahranjen='".time()."' WHERE uid='$meuid'");
echo "Seu Virtual Pet só comeu, e agora é diabético. Está com ".($tezina[0]-100)." gramas.";
}
else if($nopl1<'64800' AND $nopl1>'53999')
{
$mistake->exec("UPDATE w_wapet SET tezina=tezina-200, nahranjen='".time()."' WHERE uid='$meuid'");
echo "Seu Virtual Pet estava a mais de 15 horas sem comer, perdeu 200 gramas. Agora está com ".($tezina[0]-200)." gramas.";
}
else
{
$mistake->exec("UPDATE w_wapet SET smrt='".time()."', ziv='0' WHERE uid='$meuid'");
echo "Seu Virtual Pet morreu por ter ficado mais de 18 horas sem comer.";
}
echo "<br/>Alimente novamente seu Virtual Pet daqui a 8-12 horas, ou pelo menos duas vez ao dia.<br/><br/>";
}
} else if($a=='divertir') { ?>
<br/><div id="titulo"><b>Divertir seu Virtual Pet</b></div>
<div align="center"><img src="style/divertir.gif"><br/>
<?php
     $nopl = $mistake->query("SELECT igra FROM w_wapet WHERE uid='$meuid'")->fetch();
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
  
A última vez que seu Virtual Pet se divertiu foi a <?php echo $ofll1;?><br/>
<a href="wapet?a=divertir2">Divertir seu Virtual Pet</a><br/>
<?php } else if($a=='divertir2') { ?>
<div align="center"><img src="style/wapet.gif"><br/>
<?php
$nopl = $mistake->query("SELECT igra FROM w_wapet WHERE uid='$meuid'")->fetch();
$nopl1 = time() - $nopl[0];
if($nopl1<'600')
{
$res = $mistake->exec("UPDATE w_wapet SET igra='".time()."' WHERE uid='$meuid'");
$tezina = $mistake->query("SELECT raspolozenje FROM w_wapet WHERE uid='$meuid'")->fetch();
$tezina = $tezina[0] + 0;
$res = $mistake->exec("UPDATE w_wapet SET raspolozenje='$tezina' WHERE uid='$meuid'");
$rasp = $mistake->query("SELECT raspolozenje FROM w_wapet WHERE uid='$meuid'")->fetch();
echo "Seu Virtual Pet está satisfeito, está em $rasp[0]% de felicidade.<br/>";
}
else if($nopl1<'43200' AND $nopl1>'599')
{
$res = $mistake->exec("UPDATE w_wapet SET igra='".time()."' WHERE uid='$meuid'");
$tezina = $mistake->query("SELECT raspolozenje FROM w_wapet WHERE uid='$meuid'")->fetch();
$tezina = $tezina[0] + 2;
$res = $mistake->exec("UPDATE w_wapet SET raspolozenje='$tezina' WHERE uid='$meuid'");
$rasp = $mistake->query("SELECT raspolozenje FROM w_wapet WHERE uid='$meuid'")->fetch();
echo "Seu Virtual Pet está satisfeito, está com $rasp[0]% de felicidade.<br/>";
}
else if($nopl1<'86400' AND $nopl1>'43199')
{
$res = $mistake->exec("UPDATE w_wapet SET igra='".time()."' WHERE uid='$meuid'");
$tezina = $mistake->query("SELECT raspolozenje FROM w_wapet WHERE uid='$meuid'")->fetch();
$tezina = $tezina[0] + 1;
$res = $mistake->exec("UPDATE w_wapet SET raspolozenje='$tezina' WHERE uid='$meuid'");
$rasp = $mistake->query("SELECT raspolozenje FROM w_wapet WHERE uid='$meuid'")->fetch();
echo "Seu Virtual Pet está satisfeito, está com $rasp[0]% de felicidade.<br/>";
}
else if($nopl1>'86399')
{
$res = $mistake->exec("UPDATE w_wapet SET igra='".time()."' WHERE uid='$meuid'");
$tezina = $mistake->query("SELECT raspolozenje FROM w_wapet WHERE uid='$meuid'")->fetch();
$tezina = $tezina[0] - 1;
$res = $mistake->exec("UPDATE w_wapet SET raspolozenje='$tezina' WHERE uid='$meuid'");
$rasp = $mistake->query("SELECT raspolozenje FROM w_wapet WHERE uid='$meuid'")->fetch();
echo "Seu Virtual Pet está satisfeito, está com $rasp[0]% de felicidade.<br/>";
}
} else if($a=='banhar') { ?>
<br/><div id="titulo"><b>Banhar seu Virtual Pet</b></div>
<div align="center"><img src="style/banhar.gif"><br/>
<?php
$nopl = $mistake->query("SELECT kupanje FROM w_wapet WHERE uid='$meuid'")->fetch();
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
A última vez que seu Wapet banhou foi a <?php echo $ofll1;?><br/>
<a href="wapet?a=banhar2">Banhar Virtual Pet</a><br/>
<?php } else if($a=='banhar2') { ?>
<div align="center"><img src="style/wapet.gif"><br/>
<?php
$nopl = $mistake->query("SELECT kupanje FROM w_wapet WHERE uid='$meuid'")->fetch();
$nopl1 = time() - $nopl[0];
if($nopl1<'21599')
{
$res = $mistake->exec("UPDATE w_wapet SET kupanje='".time()."' WHERE uid='$meuid'");
$tezina = $mistake->query("SELECT raspolozenje FROM w_wapet WHERE uid='$meuid'")->fetch();
$tezina = $tezina[0] - 1;
$res = $mistake->exec("UPDATE w_wapet SET raspolozenje='$tezina' WHERE uid='$meuid'");
$rasp = $mistake->query("SELECT raspolozenje FROM w_wapet WHERE uid='$meuid'")->fetch();
echo "Seu Virtual Pet foi banhado, está com $rasp[0]% de felicidade.<br/>";
}
if($nopl1<'86400' AND $nopl1>'21600')
{
$res = $mistake->exec("UPDATE w_wapet SET kupanje='".time()."' WHERE uid='$meuid'");
$tezina = $mistake->query("SELECT raspolozenje FROM w_wapet WHERE uid='$meuid'")->fetch();
$tezina = $tezina[0] + 2;
$res = $mistake->exec("UPDATE w_wapet SET raspolozenje='$tezina' WHERE uid='$meuid'");
$rasp = $mistake->query("SELECT raspolozenje FROM w_wapet WHERE uid='$meuid'")->fetch();
echo "Seu Virtual Pet foi banhado, está com $rasp[0]% de felicidade.<br/>";
}
else if($nopl1<'172800' AND $nopl1>'86399')
{
$res = $mistake->exec("UPDATE w_wapet SET igra='".time()."' WHERE uid='$meuid'");
$tezina = $mistake->query("SELECT raspolozenje FROM w_wapet WHERE uid='$meuid'")->fetch();
$tezina = $tezina[0] + 1;
$res = $mistake->exec("UPDATE w_wapet SET raspolozenje='$tezina' WHERE uid='$meuid'");
$rasp = $mistake->query("SELECT raspolozenje FROM w_wapet WHERE uid='$meuid'")->fetch();
echo "Seu Virtual Pet foi banhado, está com $rasp[0]% de felicidade.<br/>";
}
else if($nopl1>'172799')
{
$res = $mistake->exec("UPDATE w_wapet SET ziv='0', smrt='".time()."' WHERE uid='$meuid'");
echo "Seu Virtual Pet nao sobreviveu.<br/>";
}
}
?>
<br/><div align="center">
<?php if($a==true) { ?>
<a href="wapet?"><?php echo $imgwapet;?>Menu Virtual Pet</a><br/>
<?php } ?>
<a href="entretenimento?"><?php echo $imgservicos;?>Entretenimento</a><br/>
<a href="home?"><?php echo $imginicio;?>Página principal</a><br><br>
<?php echo rodape();?>
</body>
</html>