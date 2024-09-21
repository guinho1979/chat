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
$timenw = time();
$timeto2 = (1*24*60*60);
$timeout2 = $timenw - $timeto2;
$exec2 = $mistake->exec("DELETE FROM caballos WHERE abierta=2 AND time<'".$timeout2."'");
function countdown($year, $month, $day, $hour, $minute, $second){  
global $return;  
global $countdown_date; 
$countdown_date = mktime($hour, $minute, $second, $month, $day, $year);
$today = time();  
$diff = $countdown_date - $today;   
 if ($diff < 0)$diff = 0; 
$dl = floor($diff/60/60/24);
 $hl = floor(($diff - $dl*60*60*24)/60/60);
$ml = floor(($diff - $dl*60*60*24 - $hl*60*60)/60);
$sl = floor(($diff - $dl*60*60*24 - $hl*60*60 - $ml*60));
$return = array($dl, $hl, $ml, $sl);
return $return;
}  
ativo($meuid,'Hipodromo ');
?> 
<div id='titulo'>Hipodromo<br /><img src='/juegos/cab/cavalos.gif'></div><center>Corridas a cada 10 minutos (reduzido para o desafio)</center><br>
<?
if ($a=="elegir"){
?>
<center><br />Escolha um cavalo para participar<br />Renda: 100 pontos
<?
$car = $mistake->prepare("SELECT id, time FROM caballos WHERE abierta='1'  ORDER BY id DESC LIMIT 0,1");
$car->execute();
$car = $car->fetch();
if($car==false){
$mistake->exec("INSERT INTO caballos (abierta) values('1')");
$car[0] = 1;
}
$hora = time();
if($hora<$car[1]){
$year = date("Y",$car[1]);
$month = date("m",$car[1]);
$day = date("d",$car[1]);
$hour = date("H",$car[1]);
$minute = date("i",$car[1]);
$second = date("s",$car[1]);
countdown($year, $month, $day, $hour, $minute, $second);
list($dl,$hl,$ml,$sl) = $return;
echo "<center>Falta ".$ml.":".$sl.""."\n minutos para a próxima corrida<br />";
 $carw = $mistake->prepare("SELECT ganador,segundo,tercero FROM caballos WHERE abierta='2'  ORDER BY id DESC LIMIT 0,1"); 
 $carw->execute();
$carw = $carw->fetch();
?>
ULTIMA CORRIDA:<br />
<table><tr><td style="background:url(/juegos/cab/copa.png) no-repeat;background-position:center;text-align-last: center;" colspan="2"><?php echo gerarnome($carw[0]);?><br /><font color="#ff0000"><b>1º lugar</b></font></td></tr><tr><td valign="top" style="text-align-last: left;"><?php echo gerarnome($carw[1]);?><br /><font color="#ff6c00">2º lugar</font><br /></td><td valign="botton" style="text-align-last: right;"><br /><?php echo gerarnome($carw[2]);?><br /><font color="#ffae00"><small>3º lugar</small></font></td></tr></table>
<?php
}else{
 
 $pil1 = $mistake->prepare("SELECT uid1, cabn1 FROM caballos WHERE id='".$car[0]."'");
 $pil1->execute();
$pil1 = $pil1->fetch();
if ($pil1[0]==0){
$auto1= "<a href=\"/caballos/elegir2/".$car[0]."/1\" ><img width=\"50px\" src=\"/juegos/cab/uid1a.gif\">entrar</a>"; 
} else { 
 $auto1 = "<img width=\"50px\" src=\"/juegos/cab/uid1a.gif\"><small>".gerarnome2($pil1[0])."</small>";
}  
 $pil2 = $mistake->query("SELECT uid2, cabn2 FROM caballos WHERE id='".$car[0]."'")->fetch();
 if ($pil2[0]==0){
$auto2= "<a href=\"/caballos/elegir2/".$car[0]."/2\" ><img width=\"50px\" src=\"/juegos/cab/uid2a.gif\">entrar</a>"; 
} else { 
 $auto2 = "<img width=\"50px\" src=\"/juegos/cab/uid2a.gif\"><small>".gerarnome2($pil2[0])."</small>";
}  
 $pil3 = $mistake->query("SELECT uid3, cabn3 FROM caballos WHERE id='".$car[0]."'")->fetch(); 
 if ($pil3[0]==0){
$auto3= "<a href=\"/caballos/elegir2/".$car[0]."/3\" ><img width=\"50px\" src=\"/juegos/cab/uid3a.gif\">entrar</a>"; 
} else { 
 $auto3 = "<img width=\"50px\" src=\"/juegos/cab/uid3a.gif\"><small>".gerarnome2($pil3[0])."</small>";
}   
 $pil4 = $mistake->query("SELECT uid4, cabn4 FROM caballos WHERE id='".$car[0]."'")->fetch();
 if ($pil4[0]==0){
$auto4= "<a href=\"/caballos/elegir2/".$car[0]."/4\" ><img width=\"50px\" src=\"/juegos/cab/uid4a.gif\">entrar</a>"; 
} else { 
 $auto4 = "<img width=\"50px\" src=\"/juegos/cab/uid4a.gif\"><small>".gerarnome2($pil4[0])."</small>";
}  
 $pil5 = $mistake->query("SELECT uid5, cabn5 FROM caballos WHERE id='".$car[0]."'")->fetch();
 if ($pil5[0]==0){
$auto5= "<a href=\"/caballos/elegir2/".$car[0]."/5\" ><img width=\"50px\" src=\"/juegos/cab/uid5a.gif\">entrar</a>"; 
} else { 
 $auto5 = "<img width=\"50px\" src=\"/juegos/cab/uid5a.gif\"><small>".gerarnome2($pil5[0])."</small>";
} 
 $pil6 = $mistake->query("SELECT uid6, cabn6 FROM caballos WHERE id='".$car[0]."'")->fetch();
 if ($pil6[0]==0){
$auto6= "<a href=\"/caballos/elegir2/".$car[0]."/6\" ><img width=\"50px\" src=\"/juegos/cab/uid6a.gif\">entrar</a>"; 
} else { 
$auto6 = "<img width=\"50px\" src=\"/juegos/cab/uid6a.gif\"><small>".gerarnome2($pil6[0])."</small>";
} 
 $pil7 = $mistake->query("SELECT uid7, cabn7 FROM caballos WHERE id='".$car[0]."'")->fetch();
 if ($pil7[0]==0){
$auto7= "<a href=\"/caballos/elegir2/".$car[0]."/7\" ><img width=\"50px\" src=\"/juegos/cab/uid7a.gif\">entrar</a>"; 
} else { 
 $auto7 = "<img width=\"50px\" src=\"/juegos/cab/uid7a.gif\"><small>".gerarnome2($pil7[0])."</small>";
} 
 $pil8 = $mistake->query("SELECT uid8, cabn8 FROM caballos WHERE id='".$car[0]."'")->fetch();
 if ($pil8[0]==0){
$auto8= "<a href=\"/caballos/elegir2/".$car[0]."/8\" ><img width=\"50px\" src=\"/juegos/cab/uid8a.gif\">entrar</a>"; 
} else { 
 $auto8 = "<img width=\"50px\" src=\"/juegos/cab/uid8a.gif\"><small>".gerarnome2($pil8[0])."</small>";
}  
?></center>
<div id="div1"><?php echo $auto1;?></div>
<div id="div2"><?php echo $auto2;?></div>
<div id="div1"><?php echo $auto3;?></div>
<div id="div2"><?php echo $auto4;?></div>
<div id="div1"><?php echo $auto5;?></div>
<div id="div2"><?php echo $auto6;?></div>
<div id="div1"><?php echo $auto7;?></div>
<div id="div2"><?php echo $auto8;?></div>
<?php
} 
}
if($a=="elegir2"){
$uidc= "uid$pag";  
$cs = $mistake->prepare("SELECT uid1,uid2,uid3,uid4,uid5,uid6,uid7,uid8 FROM caballos WHERE id='".$id."'"); 
$cs->execute();
$cs = $cs->fetch();
if($cs[0]==$meuid OR $cs[1]==$meuid OR $cs[2]==$meuid OR $cs[3]==$meuid OR $cs[4]==$meuid OR $cs[5]==$meuid OR $cs[6]==$meuid OR $cs[7]==$meuid) {
?>
<center>você já está participando</center>
<?
}else{
$res = $mistake->exec("UPDATE caballos SET $uidc='".$meuid."' WHERE id='".$id."'");    
if ($res){
?>
<center><br />MUITO BEM!<br />Apostou no cavalo<img width="50px" src="/juegos/cab/uid<?php echo $pag;?>.gif"><br />
Seus pontos foram retirados de <b><?php echo pts($meuid);?></b> para  <b><?php echo pts($meuid)-100;?></b> <br />   
<?php 
$mistake->exec("UPDATE w_usuarios SET pt=pt-100 WHERE id='".$meuid."'");
$cs1 = $mistake->prepare("SELECT uid1,uid2,uid3,uid4,uid5,uid6,uid7,uid8 FROM caballos WHERE id='".$id."'");
$cs1->execute();
$cs1 = $cs1->fetch();
if($cs1[0]!=0 AND $cs1[1]!=0 AND $cs1[2]!=0 AND $cs1[3]!=0 AND $cs1[4]!=0 AND $cs1[5]!=0 AND $cs1[6]!=0 AND $cs1[7]!=0) {
$array1 = array(1,2,3,4,5,6,7,8);
$val = shuffle($array1); 
$a1 = "uid".$array1[0]."";
$a2 = "uid".$array1[1]."";
$a3 = "uid".$array1[2]."";
$a4 = "uid".$array1[3]."";
$a5 = "uid".$array1[4]."";
$a6 = "uid".$array1[5]."";
$a7 = "uid".$array1[6]."";
$a8 = "uid".$array1[7]."";
$b1 = "cabn".$array1[0]."";
$b2 = "cabn".$array1[1]."";
$b3 = "cabn".$array1[2]."";
$b4 = "cabn".$array1[3]."";
$b5 = "cabn".$array1[4]."";
$b6 = "cabn".$array1[5]."";
$b7 = "cabn".$array1[6]."";
$b8 = "cabn".$array1[7]."";
$gan = $mistake->prepare("SELECT $a1,$a2,$a3,$a4,$a5,$a6,$a7,$a8 FROM caballos WHERE id='".$id."'");
 $gan->execute();
$gan = $gan->fetch();
$mistake->exec("UPDATE caballos SET res1='".$gan[0]."',res2='".$gan[1]."',res3='".$gan[2]."',res4='".$gan[3]."',res5='".$gan[4]."',res6='".$gan[5]."',res7='".$gan[6]."',res8='".$gan[7]."',$b1='1',$b2='2',$b3='3',$b4='4',$b5='5',$b6='6',$b7='7',$b8='8',ganador='".$gan[0]."',segundo='".$gan[1]."',tercero='".$gan[2]."', abierta='2',time='".time()."' WHERE id='".$id."'"); 
$pontos1 = pts($gan[0]);
$pontos2 = pts($gan[1]);
$pontos3 = pts($gan[2]); 
$puntos1a= $pontos1+500;
$puntos1b= ptscavalo($gan[0])+4;
$puntos2a= $pontos2+200;
$puntos2b= ptscavalo($gan[1])+2;
$puntos3a= $pontos3+100;
$puntos3b= ptscavalo($gan[2])+1;
$mistake->exec("UPDATE w_usuarios SET pt='".$puntos1a."',caballo='".$puntos1b."' WHERE id='".$gan[0]."'");
$mistake->exec("UPDATE w_usuarios SET pt='".$puntos2a."',caballo='".$puntos2b."' WHERE id='".$gan[1]."'");
$mistake->exec("UPDATE w_usuarios SET pt='".$puntos3a."',caballo='".$puntos3b."' WHERE id='".$gan[2]."'");  
$msg="[u][cor=#006400] Hipodromo :[/cor][/u]A corrida terminou..[link=/caballos/resultado/$id].click.[/link][br/][cor=verde][u][i]Mensagem enviada a todos os jogadores.[/i][/u][/cor]";
automsg($msg,1,$gan[0]);
automsg($msg,1,$gan[1]);
automsg($msg,1,$gan[2]);
automsg($msg,1,$gan[3]);
automsg($msg,1,$gan[4]);
automsg($msg,1,$gan[5]);
automsg($msg,1,$gan[6]);
automsg($msg,1,$gan[7]);
$timr=time()+900;
$mistake->exec("INSERT INTO caballos SET abierta='1', time='".$timr."'");
?>
<br /><center>a corrida terminou...<a href="/caballos/resultado/<?php echo $id;?>">VER RESULTADO</a></center>
<?php
} 
}
}
} else if ($a=="resultado"){
?>
<center>Posicoes</center><?php
$cs = $mistake->prepare("SELECT uid1,uid2,uid3,uid4,uid5,uid6,uid7,uid8,res1,res2,res3,res4,res5,res6,res7,res8,cabn1,cabn2,cabn3,cabn4,cabn5,cabn6,cabn7,cabn8, ganador, segundo, tercero FROM caballos WHERE id='".$id."'");
$cs->execute();
$cs = $cs->fetch();
$res1 =  str_repeat("...", $cs[16]);
$res2 =  str_repeat("...", $cs[17]);
$res3 =  str_repeat("...", $cs[18]);
$res4 =  str_repeat("...", $cs[19]);
$res5 =  str_repeat("...", $cs[20]);
$res6 =  str_repeat("...", $cs[21]);
$res7 =  str_repeat("...", $cs[22]);
$res8 =  str_repeat("...", $cs[23]);
?>
</center>
<table width="100%">
<tr><td style="background-color:#9fe18b;text-align: right;">
<img width="50px" src="/juegos/cab/uid1.gif"><font color="#9fe18b"><?php echo $res1;?></font><b><?php echo $cs[16];?>-</b><small><?php echo gerarnome($cs[0]);?></small>
</td></tr><tr><td style="background-color:#43cf18;text-align: right;">
<img width="50px" src="/juegos/cab/uid2.gif"><font color="#43cf18"><?php echo $res2;?></font><b><?php echo $cs[17];?>-</b><small><?php echo gerarnome($cs[1]);?></small>
</td></tr><tr><td style="background-color:#9fe18b;text-align: right;">
<img width="50px" src="/juegos/cab/uid3.gif"><font color="#9fe18b"><?php echo $res3;?></font><b><?php echo $cs[18];?>-</b><small><?php echo gerarnome($cs[2]);?></small>
</td></tr><tr><td style="background-color:#43cf18;text-align: right;">
<img width="50px" src="/juegos/cab/uid4.gif"><font color="#43cf18"><?php echo $res4;?></font><b><?php echo $cs[19];?>-</b><small><?php echo gerarnome($cs[3]);?></small>
</td></tr><tr><td style="background-color:#9fe18b;text-align: right;">
<img width="50px" src="/juegos/cab/uid5.gif"><font color="#9fe18b"><?php echo $res5;?></font><b><?php echo $cs[20];?>-</b><small><?php echo gerarnome($cs[4]);?></small>
</td></tr><tr><td style="background-color:#43cf18;text-align: right;">
<img width="50px" src="/juegos/cab/uid6.gif"><font color="#43cf18"><?php echo $res6;?></font><b><?php echo $cs[21];?>-</b><small><?php echo gerarnome($cs[5]);?></small>
</td></tr><tr><td style="background-color:#9fe18b;text-align: right;">
<img width="50px" src="/juegos/cab/uid7.gif"><font color="#9fe18b"><?php echo $res7;?></font><b><?php echo $cs[22];?>-</b><small><?php echo gerarnome($cs[6]);?></small>
</td></tr><tr><td style="background-color:#43cf18;text-align: right;">
<img width="50px" src="/juegos/cab/uid8.gif"><font color="#43cf18"><?php echo $res8;?></font><b><?php echo $cs[23];?>-</b><small><?php echo gerarnome($cs[7]);?></small>
</td></tr></table>
 <table><tr><td style="background:url(/juegos/cab/copa.png) no-repeat;">
<?php echo gerarnome($cs[24]);?><br /><font color="green"><b>1º lugar</b></font>
</td></tr><tr><td style="text-align-last: left;"><br />
<?php echo gerarnome($cs[25]);?><br /><font color="red">2º lugar</font>
</td></tr><tr><td style="text-align-last: left;"><br />
<?php echo gerarnome($cs[26]);?><br /><font color="#ffae00"><small>3º lugar</small></font>
</td></tr></table>
<?php 
}
if($a=="terminadas") {        
?><center>Corridas</center>
<?php 
if($pag=="" || $pag<=0)$pag=1;
$noi = $mistake->prepare("SELECT COUNT(*) FROM caballos WHERE abierta='2'");
$noi->execute();
$noi = $noi->fetch();
$num_items = $noi[0];
$items_per_page= 10;
$numpag = ceil($num_items/$items_per_page);
if(($pag>$numpag)&&$pag!=1)$pag= $numpag;
$limit_start = ($pag-1)*$items_per_page;
if($num_items>0) {
$sql = "SELECT id, ganador,segundo,tercero FROM caballos WHERE abierta=2 ORDER BY id DESC LIMIT $limit_start, $items_per_page";
$items = $mistake->prepare($sql);
$items->execute();
$nick= gerarnome($meuid);    
$i=0;
while ($item = $items->fetch()){   
?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">&ensp;Corrida N° <?php echo $item[0];?>: &ensp;<a href="/caballos/resultado/<?php echo $item[0];?>"> 1° lugar: &ensp;<?php echo gerarnome($item[1]);?> 2°lugar: &ensp;<?php echo gerarnome($item[2]);?> 3°lugar: &ensp;<?php echo gerarnome($item[3]);?></a></div>
<?php 
$i++;
}
if($numpag>1){
paginas('caballos',$a,$numpag,$id,$pag);
}
} else {
?>
<p align="center">Não há partidas!<br/>
<?php 
}
}
if($a=="top") {  
?>
<center>Top ganhadores</center><br />O primeiro lugar te dá 4 pontos, segundo 2 pontos e terceiro 1 ponto.
<?php 
if($pag=="" || $pag<=0)$pag=1;
$noi = $mistake->prepare("SELECT COUNT(*) FROM w_usuarios WHERE caballo>='1'");
$noi->execute();
$noi = $noi->fetch();
$num_items = $noi[0];
$items_per_page= 10;
$numpag = ceil($num_items/$items_per_page);
if(($pag>$numpag)&&$pag!=1)$pag = $numpag;
$limit_start = ($pag-1)*$items_per_page;
$sql = "SELECT id, caballo FROM w_usuarios WHERE caballo>='1' ORDER BY caballo DESC LIMIT $limit_start, $items_per_page";
if($noi[0]>0){
$items = $mistake->prepare($sql);
$items->execute();
$i=0;
while ($item = $items->fetch()){   
?><div id="<?php echo $i%2==0?'div1':'div2';?>"><a href="/<?php echo gerarlogin($item[0]);?>"><?php echo gerarnome($item[0]);?>: <?php echo $item[1];?> Pontos</a></div>
<?php 
$i++;
}
}
if($numpag>1){
paginas('caballos',$a,$numpag,$id,$pag);
}
}
if ($a=="menu")   {
?></p><p align="center"><?php 
$car = $mistake->prepare("SELECT id, time FROM caballos WHERE abierta='1'  ORDER BY id DESC LIMIT 0,1");
$car->execute();
$car = $car->fetch();
$hora = time();
if($hora<$car[1]){
$year = date("Y",$car[1]);
$month = date("m",$car[1]);
$day = date("d",$car[1]);
$hour = date("H",$car[1]);
$minute = date("i",$car[1]);
$second = date("s",$car[1]);
countdown($year, $month, $day, $hour, $minute, $second);
list($dl,$hl,$ml,$sl) = $return;
?>
<center><b>Faltam <?php echo $ml;?>:<?php echo $sl;?> minutos para a próxima corrida</b><br />
<?php 
}
?>
<div id="div1"><center><a href="/caballos/como" class="small button yellow">Como se joga</a></div>
<div id="div2"><center><a href="/caballos/elegir" class="small button green">Escolher cavalo</a></div>
<div id="div1"><center><a href="/caballos/terminadas" class="small button green">Ultimas corridas</a></div>
<div id="div2"><center><a href="/caballos/top" class="small button green">Os melhores jogadores</a></div>
</p>
<?php 
} else if($a=="como"){
?>Uma corrida é disputada, a admissão é 100, o 1ª vencedor ganha 500, o segundo vencedor ganha 200 e o terceiro vencedor ganha 100. Jogadores  é adicionado a cada vitória para o topo dos melhores jogadores, o primeiro de cada corrida leva 4 pontos, o segundo 2 e o terceiro 1.<br />As corridas abrem 15 minutos depois de terminar uma. Boa sorte!<?php
}
?>
<p align="center">
<br /><a href="/caballos/menu">Menu Hipodromo</a><br />
<br/><a class="badge badge-secondary" href="javascript:window.history.back();"><?php echo $imgsetavoltar;?> Voltar</a></div><br/>
</body>
</html>