<?php
require_once("".$_SERVER["DOCUMENT_ROOT"]."/funcoes.php");
require_once("".$_SERVER["DOCUMENT_ROOT"]."/mistake.php");
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
ativo($meuid,'Mario Kart');
?>
<div id="titulo"><b style='font-family:JackintheBoxa;font-size:11pt;'>Mario Kart</b><br /><img width="120px" src='/juegos/kart/mario.png'></div><br />
Escolha entre os 8 corredores de Mario Kart, a corrida paga o primeiro lugar 5 vezes a aposta, o segundo lugar 2 vezes a aposta e o terceiro lugar, uma vez que a aposta.<br /><?
if ($a=="crear"){
$csA =  $mistake->query("SELECT  COUNT(*) FROM kart WHERE (uid1='".$meuid."' AND abierta='1') OR (uid2='".$meuid."' AND abierta='1') OR (uid3='".$meuid."' AND abierta='1') OR (uid4='".$meuid."' AND abierta='1') OR (uid5='".$meuid."' AND abierta='1') OR (uid6='".$meuid."' AND abierta='1') OR (uid7='".$meuid."' AND abierta='1') OR (uid8='".$meuid."' AND abierta='1')")->fetch(); 
if($csA[0]>8){
?>
<center><b>Apenas 8 corridas podem ser criadas</b></center>
<?
}else{
echo $csA[0];
?>
<table align="center" border="2" style="border-collapse: collapse;">
<tr><td height="50px">
<a href="/kart/armarc/1" ><img width="50px" src="/juegos/kart/1a.gif"></a>
</td><td height="50px">
<a href="/kart/armarc/2" ><img width="50px" src="/juegos/kart/2a.gif"></a>
</td><td height="50px">
<a href="/kart/armarc/3" ><img width="50px" src="/juegos/kart/3a.gif"></a>
</td></tr><tr><td height="50px">
<a href="/kart/armarc/4" ><img width="50px" src="/juegos/kart/4a.gif"></a>
</td><td height="50px">
</td><td height="50px">
<a href="/kart/armarc/5" ><img width="50px" src="/juegos/kart/5a.gif"></a>
</td></tr><tr><td height="50px">
<a href="/kart/armarc/6" ><img width="50px" src="/juegos/kart/6a.gif"></a>
</td><td height="50px">
<a href="/kart/armarc/7" ><img width="50px" src="/juegos/kart/7a.gif"></a>
</td><td height="50px">
<a href="/kart/armarc/8" ><img width="50px" src="/juegos/kart/8a.gif"></a>
</td></tr></table>
<?
}
} else if($a=="armarc"){
$csA =  $mistake->query("SELECT  COUNT(*) FROM kart WHERE (uid1='".$meuid."' AND abierta='1') OR (uid2='".$meuid."' AND abierta='1') OR (uid3='".$meuid."' AND abierta='1') OR (uid4='".$meuid."' AND abierta='1') OR (uid5='".$meuid."' AND abierta='1') OR (uid6='".$meuid."' AND abierta='1') OR (uid7='".$meuid."' AND abierta='1') OR (uid8='".$meuid."' AND abierta='1')")->fetch(); 
if($csA[0]>8){
echo "<br /><b>Apenas 8 corridas podem ser criadas</b>";
}else{
$cabu=$_GET['id'];
echo "<center><img width=\"50px\" src=\"/juegos/kart/".$cabu."a.gif\"><br />";
echo "<form action=\"/kart/armarc2/$cabu\" method=\"post\">";
echo "Pontos: <select name=\"puntos\">";
echo "<option name=\"10\">10</option>";
echo "<option name=\"20\">20</option>";
echo "<option name=\"30\">30</option>";
echo "<option name=\"40\">40</option>";
echo "<option name=\"50\">50</option>";
echo "</select><br/>";
echo "<input type=\"submit\" value=\"Armar\"/></form>";
}
} else if($a=="armarc2"){
$csA =  $mistake->query("SELECT COUNT(*) FROM kart WHERE (uid1='".$meuid."' AND abierta='1') OR (uid2='".$meuid."' AND abierta='1') OR (uid3='".$meuid."' AND abierta='1') OR (uid4='".$meuid."' AND abierta='1') OR (uid5='".$meuid."' AND abierta='1') OR (uid6='".$meuid."' AND abierta='1') OR (uid7='".$meuid."' AND abierta='1') OR (uid8='".$meuid."' AND abierta='1')")->fetch(); 
if($csA[0]>8){
echo "Apenas 8 corridas podem ser criadas";
}else{
$pontos =  $mistake->query("SELECT pt FROM w_usuarios WHERE id='".$meuid."'")->fetch();
$cabu=$_GET['id'];
$puntos=$_POST['puntos'];
if($puntos>$pontos[0]){
echo "Você não pode apostar mais do que você tem"; 
}else{
$meuidc= "uid$cabu";
echo "<center><br /><br />";
$pontos =  $mistake->query("SELECT pt FROM w_usuarios WHERE id='".$meuid."'")->fetch();
$pun= $pontos[0] -$puntos;
$res =  $mistake->query("UPDATE w_usuarios SET pt='".$pun."' WHERE id='".$meuid."'");
if($res){
 $mistake->query("INSERT INTO kart SET $meuidc='".$meuid."',apuesta='".$puntos."', abierta='1'");
echo "corrida por $puntos pontos criada!!<br />";  
echo "Seus pontos passaram de $pontos[0] a $pun<br/>";
echo "<img width=\"50px\" src=\"/juegos/kart/".$cabu."a.gif\">";
$max =  $mistake->query("SELECT MAX(id) FROM kart WHERE $meuidc='".$meuid."' AND apuesta='".$puntos."' AND abierta='1'")->fetch();
?>
<form action="/kart/convidar" method="post">
<input type="hidden" name="num" value="<?php echo $max[0];?>">
<input type="hidden" name="img" value="<?php echo $cabu;?>">
<input type="hidden" name="apu" value="<?php echo $puntos;?>">
<input type="submit" value="Convidar no Chat">
</form></center><br /> 
<? 
}
}
}
}
if ($a=="elegir"){ 
$apuesta =  $mistake->query("SELECT apuesta FROM kart WHERE id='".$id."'")->fetch();
echo "<center><br />Escolha um karting para participar<br />Ingresso: $apuesta[0] pontos<br />";
$pil1 =  $mistake->query("SELECT uid1 FROM kart WHERE id='".$id."'")->fetch();
if ($pil1[0]==0){
$auto1= "<a class=\"small button yellow\" href=\"/kart/elegir2/$id/1\" ><img width=\"50px\" src=\"/juegos/kart/1a.gif\"></a>"; 
} else { 
$auto1 = "<img width=\"50px\" src=\"/juegos/kart/1a.gif\"><br/><small>".gerarnome2($pil1[0])."</small>";
}  
$pil2 =  $mistake->query("SELECT uid2, car2 FROM kart WHERE id='".$id."'")->fetch();
if ($pil2[0]==0){
$auto2= "<a class=\"small button yellow\" href=\"/kart/elegir2/$id/2\" ><img width=\"50px\" src=\"/juegos/kart/2a.gif\"></a>"; 
} else { 
$auto2 = "<img width=\"50px\" src=\"/juegos/kart/2a.gif\"><br/><small>".gerarnome2($pil2[0])."</small>";
} 
$pil3 =  $mistake->query("SELECT uid3, car3 FROM kart WHERE id='".$id."'")->fetch(); 
if ($pil3[0]==0){
$auto3= "<a class=\"small button yellow\" href=\"/kart/elegir2/$id/3\" ><img width=\"50px\" src=\"/juegos/kart/3a.gif\"></a>"; 
} else { 
$auto3 = "<img width=\"50px\" src=\"/juegos/kart/3a.gif\"><br/><small>".gerarnome2($pil3[0])."</small>";
}   
$pil4 =  $mistake->query("SELECT uid4, car4 FROM kart WHERE id='".$id."'")->fetch();
if ($pil4[0]==0){
$auto4= "<a class=\"small button yellow\" href=\"/kart/elegir2/$id/4\" ><img width=\"50px\" src=\"/juegos/kart/4a.gif\"></a>"; 
} else { 
$auto4 = "<img width=\"50px\" src=\"/juegos/kart/4a.gif\"><br/><small>".gerarnome2($pil4[0])."</small>";
} 
$pil5 =  $mistake->query("SELECT uid5, car5 FROM kart WHERE id='".$id."'")->fetch();
if ($pil5[0]==0){
$auto5= "<a class=\"small button yellow\" href=\"/kart/elegir2/$id/5\" ><img width=\"50px\" src=\"/juegos/kart/5a.gif\"></a>"; 
} else { 
$auto5 = "<img width=\"50px\" src=\"/juegos/kart/5a.gif\"><br/><small>".gerarnome2($pil5[0])."</small>";
} 
$pil6 =  $mistake->query("SELECT uid6, car6 FROM kart WHERE id='".$id."'")->fetch();
if ($pil6[0]==0){
$auto6= "<a class=\"small button yellow\" href=\"/kart/elegir2/$id/6\" ><img width=\"50px\" src=\"/juegos/kart/6a.gif\"></a>"; 
} else { 
$auto6 = "<img width=\"50px\" src=\"/juegos/kart/6a.gif\"><br/><small>".gerarnome2($pil6[0])."</small>";
}  
$pil7 =  $mistake->query("SELECT uid7, car7 FROM kart WHERE id='".$id."'")->fetch();
if ($pil7[0]==0){
$auto7= "<a class=\"small button yellow\" href=\"/kart/elegir2/$id/7\" ><img width=\"50px\" src=\"/juegos/kart/7a.gif\"></a>"; 
} else { 
$auto7 = "<img width=\"50px\" src=\"/juegos/kart/7a.gif\"><br/><small>".gerarnome2($pil7[0])."</small>";
} 
$pil8 =  $mistake->query("SELECT uid8, car8 FROM kart WHERE id='".$id."'")->fetch();
if ($pil8[0]==0){
$auto8= "<a class=\"small button yellow\" href=\"/kart/elegir2/$id/8\" ><img width=\"50px\" src=\"/juegos/kart/8a.gif\"></a>"; 
} else { 
$auto8 = "<img width=\"50px\" src=\"/juegos/kart/8a.gif\"><br/><small>".gerarnome2($pil8[0])."</small>";
}  
?>
<table align="center" border="2" style="border-collapse: collapse;">
<tr><td height="50px">
<?php echo $auto1;?>
</td><td height="50px">
<?php echo $auto2;?>
</td><td height="50px">
<?php echo $auto3;?>
</td></tr><tr><td height="50px">
<?php echo $auto4;?>
</td><td height="50px">
</td><td height="50px">
<?php echo $auto5;?>
</td></tr><tr><td height="50px">
<?php echo $auto6;?>
</td><td height="50px">
<?php echo $auto7;?>
</td><td height="50px">
<?php echo $auto8;?>
</td></tr></table>
<?
}
if($a=="elegir2"){
$cabu=$_GET['pag']; 
$car=$_GET['id'];
$meuidc= "uid$cabu";  
$cs =  $mistake->query("SELECT uid1,uid2,uid3,uid4,uid5,uid6,uid7,uid8, apuesta FROM kart WHERE id='".$car."'")->fetch(); 
if($cs[0]==$meuid OR $cs[1]==$meuid OR $cs[2]==$meuid OR $cs[3]==$meuid OR $cs[4]==$meuid OR $cs[5]==$meuid OR $cs[6]==$meuid OR $cs[7]==$meuid) {
?>
<br /><center>você já está participando<br />
<form action="/kart/convidar" method="post">
<input type="hidden" name="num" value="<?php echo $car;?>">
<input type="hidden" name="img" value="<?php echo rand(1,8);?>">
<input type="hidden" name="apu" value="<?php echo $cs[8];?>">
<input type="submit" value="Convidar no Chat">
</form></center><br /> 
<? 
}else{
$cs2 =  $mistake->query("SELECT $meuidc FROM kart WHERE id='".$car."'")->fetch();
if($cs2[0]>0){
?>
<br />já ocupou aquele lugar, selecione outro
<?
}else{
$pund =  $mistake->query("SELECT pt FROM w_usuarios WHERE id='".$meuid."'")->fetch();
if($cs[8]>$pund[0]){
?>
Você não pode apostar mais do que você tem
<?  
}else{
$res= $mistake->query("UPDATE kart SET $meuidc='".$meuid."' WHERE id='".$car."'");
if ($res){
$pontos =  $mistake->query("SELECT pt FROM w_usuarios WHERE id='".$meuid."'")->fetch();
$pun= $pontos[0] -$cs[8];
 $mistake->query("UPDATE w_usuarios SET pt='".$pun."' WHERE id='".$meuid."'");
?><center><br />MUITO BEM!<br />Você está correndo com <img width="50px" src="/juegos/kart/<?php echo $cabu;?>.gif"><br />
Seus pontos foram deixados <?php echo $pontos[0];?> a  <?php echo $pun;?> <br /><?
$cs1 =  $mistake->query("SELECT uid1,uid2,uid3,uid4,uid5,uid6,uid7,uid8 FROM kart WHERE id='".$car."'")->fetch();
if($cs1[0]!=0 AND $cs1[1]!=0 AND $cs1[2]!=0 AND $cs1[3]!=0 AND $cs1[4]!=0 AND $cs1[5]!=0 AND $cs1[6]!=0 AND $cs1[7]!=0) {
$array1 = array(1,2,3,4,5,6,7,8);
$val = shuffle($array1); 
$a1 = "uid$array1[0]";
$a2 = "uid$array1[1]";
$a3 = "uid$array1[2]";
$a4 = "uid$array1[3]";
$a5 = "uid$array1[4]";
$a6 = "uid$array1[5]";
$a7 = "uid$array1[6]";
$a8 = "uid$array1[7]";
$b1 = "car$array1[0]";
$b2 = "car$array1[1]";
$b3 = "car$array1[2]";
$b4 = "car$array1[3]";
$b5 = "car$array1[4]";
$b6 = "car$array1[5]";
$b7 = "car$array1[6]";
$b8 = "car$array1[7]";
$gan =  $mistake->query("SELECT $a1,$a2,$a3,$a4,$a5,$a6,$a7,$a8, apuesta FROM kart WHERE id='".$car."'")->fetch();
 $mistake->query("UPDATE kart SET res1='".$gan[0]."',res2='".$gan[1]."',res3='".$gan[2]."',res4='".$gan[3]."',res5='".$gan[4]."',res6='".$gan[5]."',res7='".$gan[6]."',res8='".$gan[7]."',car1='".$array1[0]."',car2='".$array1[1]."',car3='".$array1[2]."',car4='".$array1[3]."',car5='".$array1[4]."',car6='".$array1[5]."',car7='".$array1[6]."',car8='".$array1[7]."',ganador='".$gan[0]."',kart='".$array1[0]."',segundo='".$gan[1]."',tercero='".$gan[2]."', abierta='2', time='".time()."' WHERE id='".$car."'"); 
$por5=  $gan[8]*5;
$por3 = $gan[8]*2; 
$pontos1 =  $mistake->query("SELECT pt, kartin FROM w_usuarios WHERE id='".$gan[0]."'")->fetch();
$pontos2 =  $mistake->query("SELECT pt, kartin FROM w_usuarios WHERE id='".$gan[1]."'")->fetch();
$pontos3 =  $mistake->query("SELECT pt, kartin FROM w_usuarios WHERE id='".$gan[2]."'")->fetch();  
$puntos1a= $pontos1[0]+$por5;
$puntos1b= $pontos1[1]+1;
$puntos2a= $pontos2[0]+$por3;
$puntos3a= $pontos3[0]+$gan[8];
 $mistake->query("UPDATE w_usuarios SET pt='".$puntos1a."',kartin='".$puntos1b."' WHERE id='".$gan[0]."'");
 $mistake->query("UPDATE w_usuarios SET pt='".$puntos2a."' WHERE id='".$gan[1]."'");
 $mistake->query("UPDATE w_usuarios SET pt='".$puntos3a."' WHERE id='".$gan[2]."'");  
$msg = "[b]Mario Kart a corrida terminou..[link=/kart/resultado/$car] VER RESULTADO[/link]...mensagem automática[/b]";
automsg($msg,1,$gan[0]);
automsg($msg,1,$gan[1]);
automsg($msg,1,$gan[2]);
automsg($msg,1,$gan[3]);
automsg($msg,1,$gan[4]);
automsg($msg,1,$gan[5]);
automsg($msg,1,$gan[6]);
automsg($msg,1,$gan[7]);
automsg($msg,1,$gan[8]);
echo "a corrida terminou...<br /><a href=\"/kart/resultado/$car\">VER RESULTADO</a>"; 
}else{
?>
<form action="/kart/convidar" method="post">
<input type="hidden" name="num" value="<?php echo $car;?>">
<input type="hidden" name="img" value="<?php echo $cabu;?>">
<input type="hidden" name="apu" value="<?php echo $cs[8];?>">
<input type="submit" value="Convidar no Chat">
</form></center><br />
<?
} 
}
}
}
}
} else if($a=="convidar") {
if(isset($_POST['num'])!=''){
echo "<p align=\"center\">";
$num = $_POST["num"];
$val = $_POST["img"];
$apu = $_POST["apu"];
$texto = '[link=/kart/elegir/'.$num.']<br /><b><u>Mario Kart Entre nessa corrida</u></b><br /><img src="/juegos/kart/'.$val.'.gif"/> [br/][b]Correr por '.$apu.' pontos[/b][/link]';
$res = $mistake->prepare("INSERT INTO w_mchat (txt,por,hr,p,schat) VALUES (?, ?, ?, ?,?)");
$arrayName = array($texto,$meuid,time(),0,1);
$ii = 0;
for($i=1; $i <=5; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
echo $imgok;?>O jogo foi postado com sucesso!<br>
<?
}
}else if ($a=="resultado"){
?><center>Posições</center><?
$car=$_GET['id'];
$cs =  $mistake->query("SELECT uid1,uid2,uid3,uid4,uid5,uid6,uid7,uid8,res1,res2,res3,res4,res5,res6,res7,res8,car1,car2,car3,car4,car5,car6,car7,car8, apuesta, segundo, tercero FROM kart WHERE id='".$car."'")->fetch();
$res1 =  $cs[16];
$res2 =  $cs[17];
$res3 = $cs[18];
$res4 =  $cs[19];
$res5 = $cs[20];
$res6 = $cs[21];
$res7 = $cs[22];
$res8 =  $cs[23];
?>
</center>
<table border="0" style="border-collapse:collapse;padding:0px;">
<tr><td style="background-image:url(/juegos/kart/sp2.gif); background-repeat: no-repeat;vertical-align: bottom;width:100px;height:100px;padding:0px;">
<div align="right" style="text-align:botton;"><img src="/juegos/kart/<?php echo $res6;?>v.gif"></div>
</td><td style="background-image:url(/juegos/kart/sp4.gif); background-repeat: no-repeat;vertical-align: bottom;width:100px;height:100px;padding:0px;">
<div align="right"><img src="/juegos/kart/<?php echo $res8;?>ul.gif"></div>
<div align="left"><img src="/juegos/kart/<?php echo $res7;?>ul.gif"></div>
</td><td style="background-image:url(/juegos/kart/sp3.gif); background-repeat: no-repeat;vertical-align: bottom;width:100px;height:100px;padding:0px;">
</td></tr><tr><td style="background-image:url(/juegos/kart/sp1.gif); background-repeat: no-repeat;vertical-align: bottom;width:100px;height:100px;padding:0px;">
<div align="left"><img src="/juegos/kart/<?php echo $res5;?>v.gif"></div>
<div align="right"><img src="/juegos/kart/<?php echo $res4;?>v.gif"></div>
</td><td style="vertical-align: bottom;width:100px;height:100px;padding:0px;">
</td><td style="background-image:url(/juegos/kart/sp1.gif); background-repeat: no-repeat;vertical-align: bottom;width:100px;height:100px;padding:0px;">
</td></tr><tr><td style="background-image:url(/juegos/kart/sp6.gif); background-repeat: no-repeat;vertical-align: bottom;width:100px;height:100px;padding:0px;">
<div align="right"><img src="/juegos/kart/<?php echo $res3;?>.gif"></div>
</td><td style="background-image:url(/juegos/kart/sp7.gif); background-repeat: no-repeat;vertical-align: bottom;width:100px;height:100px;padding:0px;">
<div align="right"><img src="/juegos/kart/<?php echo $res1;?>b.gif"></div>
<div align="left"><img src="/juegos/kart/<?php echo $res2;?>.gif"></div>
</td><td style="background-image:url(/juegos/kart/sp5.gif); background-repeat: no-repeat;vertical-align: bottom;width:100px;height:100px;padding:0px;">
</td></tr></table>
<small>Aposta:<?php echo $cs[24];?> pontos</small>
<?
$pri = $cs[24]*5;
$seg= $cs[24]*2;
?>
<table border='1' width='100%'><tr><td style="background:url(/juegos/kart/copa.png) no-repeat;">
<?php echo gerarnome($cs[8], $mistake);?><br /><font color="#ff0000"><b>1º Posição</b><img src="/juegos/kart/<?php echo $res1;?>b.gif">(<?php echo $pri;?> pontos)</font>
</td></tr><tr><td style="text-align-last: left;">
<?php echo gerarnome($cs[9], $mistake);?><br /><font color="#ff6c00">2º Posição</font><img src="/juegos/kart/<?php echo $res2;?>b.gif">(<?php echo $seg;?> pontos)
</td></tr><tr><td style="text-align-last: left;">
<?php echo gerarnome($cs[10], $mistake);?><br /><font color="#ffae00"><small>3º Posição<img src="/juegos/kart/<?php echo $res3;?>b.gif">(<?php echo $cs[24];?> pontos)</small></font>
</td></tr></table>
<small>
<div id='div2'>4º Posição <?php echo gerarnome($cs[11]);?><img src="/juegos/kart/<?php echo $res4;?>.gif"></div>
<div id='div1'>5º Posição <?php echo gerarnome($cs[12]);?><img src="/juegos/kart/<?php echo $res5;?>.gif"></div>
<div id='div2'>6º Posição <?php echo gerarnome($cs[13]);?><img src="/juegos/kart/<?php echo $res6;?>.gif"></div>
<div id='div1'>7º Posição <?php echo gerarnome($cs[14]);?><img src="/juegos/kart/<?php echo $res7;?>.gif"></div>
<div id='div2'>8º Posição <?php echo gerarnome($cs[15]);?><img src="/juegos/kart/<?php echo $res8;?>.gif"></div>
<?
}
if($a=="terminadas") {  
?><center>Corridas Terminadas</center><?
if($pag=="" || $pag<=0)$pag=1;
$noi =  $mistake->query("SELECT COUNT(*) FROM kart WHERE abierta='2'")->fetch();
$num_items = $noi[0];
$items_per_page= 7;
$num_pages = ceil($num_items/$items_per_page);
if(($pag>$num_pages)&&$pag!=1)$pag= $num_pages;
$limit_start = ($pag-1)*$items_per_page;
$sql = "SELECT id, ganador, segundo FROM kart WHERE abierta=2 ORDER BY id DESC LIMIT $limit_start, $items_per_page";
$items =  $mistake->query($sql);
if($num_items>0){
$i=0;
while ($item = $items->fetch()){   
?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">Corrida N° <?php echo $part;?>:<a href="/kart/resultado/<?php echo $item[0];?>">1°:<?php echo gerarnome($item[1]);?>-2°:<?php echo gerarnome($item[2]);?></a></div>
<?
$i++;    
}
if($num_pages>1){
paginas('kart',$a,$num_pages,$id,$pag);
}
} else {
?>
<p align="center"><img src="/style/x.gif" alt="*"/>Nao ha partidas armadas!<br/><p align="center"><?
}
}
if($a=="unirse") {  
?><center>Corridas Abertas</center><?
if($pag=="" || $pag<=0)$pag=1;
$noi =  $mistake->prepare("SELECT COUNT(*) FROM kart WHERE abierta='1'");
$noi->execute();
$noi = $noi->fetch();
$num_items = $noi[0];
$items_per_page= 10;
$num_pages = ceil($num_items/$items_per_page);
if(($pag>$num_pages)&&$pag!=1)$pag= $num_pages;
$limit_start = ($pag-1)*$items_per_page;
$sql = "SELECT id, apuesta FROM kart WHERE abierta=1 ORDER BY id DESC LIMIT $limit_start, $items_per_page";
$items =  $mistake->prepare($sql);
$items->execute();
$i=0;
while ($item = $items->fetch()){   
$pil1 =  $mistake->query("SELECT uid1 FROM kart WHERE id='".$item[0]."'")->fetch();
if ($pil1[0]==0){
$auto1= "<img src=\"/juegos/kart/1.gif\">";    
$sum0 = 0;
} else { 
$auto1 = ""; 
$sum0 = 1;
}
$pil2 =  $mistake->query("SELECT uid2 FROM kart WHERE id='".$item[0]."'")->fetch();
if ($pil2[0]==0){
$auto2= "<img src=\"/juegos/kart/2.gif\">"; 
$sum1 = 0;
} else { 
$auto2 = ""; 
$sum1 = 1;
}
$pil3 =  $mistake->query("SELECT uid3 FROM kart WHERE id='".$item[0]."'")->fetch(); 
if ($pil3[0]==0){
$auto3= "<img src=\"/juegos/kart/3.gif\">";   
$sum2 = 0;
} else { 
$auto3 = ""; 
$sum2 = 1;
}
$pil4 =  $mistake->query("SELECT uid4 FROM kart WHERE id='".$item[0]."'")->fetch();
if ($pil4[0]==0){
$auto4= "<img src=\"/juegos/kart/4.gif\">";   
$sum3 = 0;
} else { 
$auto4 = ""; 
$sum3 = 1;
}
$pil5 =  $mistake->query("SELECT uid5 FROM kart WHERE id='".$item[0]."'")->fetch();
if ($pil5[0]==0){
$auto5= "<img src=\"/juegos/kart/5.gif\">";   
$sum4 = 0;
} else { 
$auto5 = ""; 
$sum4 = 1;
}
$pil6 =  $mistake->query("SELECT uid6 FROM kart WHERE id='".$item[0]."'")->fetch();
if ($pil6[0]==0){
$auto6= "<img src=\"/juegos/kart/6.gif\">"; 
$sum5 = 0;
} else { 
$auto6 = "";
$sum5 = 1;
}
$pil7 =  $mistake->query("SELECT uid7 FROM kart WHERE id='".$item[0]."'")->fetch();
if ($pil7[0]==0){
$auto7= "<img src=\"/juegos/kart/7.gif\">";  
$sum6 = 0;
} else { 
$auto7 = ""; 
$sum6 = 1;
}
$pil8 =  $mistake->query("SELECT uid8 FROM kart WHERE id='".$item[0]."'")->fetch();
if ($pil8[0]==0){
$auto8= "<img src=\"/juegos/kart/8.gif\">";   
$sum7 = 0;
} else { 
$auto8 = ""; 
$sum7 = 1;
}
$lug = $sum0+$sum1+$sum2+$sum3+$sum4+$sum5+$sum6+$sum7; ?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">&ensp;Corrida N°<?php echo  $item[0];?>:<a href="/kart/elegir/<?php echo $item[0];?>"><small>(<?php echo $lug;?> corredores) - <?php echo $item[1];?> pontos.<br />Livres: </small><?php echo "$auto1$auto2$auto3$auto4$auto5$auto6$auto7$auto8";?></a></div>
<?php 
$i++;
}
if($num_pages>1){
paginas('kart',$a,$num_pages,$id,$pag);
}
}  
if($a=="top") {  
?><center>Top ganhadores</center><br />Apenas o primeiro lugar recebe 1 ponto.<br /><?
if($pag=="" || $pag<=0)$pag=1;
$noi =  $mistake->query("SELECT COUNT(*) FROM w_usuarios WHERE kartin>='1'")->fetch();
$num_items = $noi[0];
$items_per_page= 10;
$num_pages = ceil($num_items/$items_per_page);
if(($pag>$num_pages)&&$pag!=1)$pag= $num_pages;
$limit_start = ($pag-1)*$items_per_page;
$sql = "SELECT id, kartin FROM w_usuarios WHERE kartin>='1' ORDER BY kartin DESC LIMIT $limit_start, $items_per_page";
if($noi[0]>0){
$items =  $mistake->query($sql);
$i=0;
while ($item = $items->fetch()){   
$masluch =  $mistake->query("SELECT kart,COUNT(*) as nops FROM kart WHERE ganador='".$item[0]."' AND abierta='2' GROUP BY kart ORDER BY nops DESC LIMIT 0,1")->fetch();
?><div id="<?php echo $i%2==0?'div1':'div2';?>"><a href="/<?php echo gerarlogin($item[0]);?>"><?php echo gerarnome($item[0]);?>: <?php echo $item[1];?> Pontos</a>
<br />Personagem preferido: <img src="/juegos/kart/<?php echo $masluch[0];?>b.gif">(<?php echo $masluch[1];?>)
</div>
<?php 
$i++;
}
}
if($num_pages>1){
paginas('kart',$a,$num_pages,$id,$pag);
}
}
if ($a=="menu")   {
$noi =  $mistake->query("SELECT COUNT(*) FROM kart WHERE abierta='1'")->fetch();
?>
<br /><br /><div id='div1'><center><a href="/kart/crear">Criar corrida</a></center></div>
<div id='div2'><center><a href="/kart/unirse">Unirse a uma corrida(<?php echo $noi[0];?>)</a></center></div>
<div id='div1'><center><a href="/kart/terminadas">Ultimas corridas</a></center></div>
<div id='div2'><center><a href="/kart/top">Top Corredores</a></center></div>
</p><?
}
?>
</p><p align="center">
<br /><a href="/kart/menu">Menu Mario Kart</a><br />
</p>
<br/><div align="center">
<a href="/home?"><?php echo $imginicio;?>Página principal</a><br><br>
<?php echo rodape();?>
</body>
</html>