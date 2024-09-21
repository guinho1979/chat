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
ativo($meuid,'Motos');
?>
<style>
#marco{
width:90%;
position: absolute;
z-index: 2;
}
#imagen{
width:90%;
position: relative;
z-index: 1;
}
</style>
<?
echo "<div id=\"titulo\">Corrida de Motos<br />
<div id='marco'><marquee scrollamount='3' direction='right'><img width=\"30px\" src=\"/juegos/motos/moto1.gif\"></marquee></div>
<div id='marco'><marquee scrollamount='4' direction='right'><img width=\"30px\" src=\"/juegos/motos/moto3.gif\"></marquee></div>
<div id='imagen'><marquee scrollamount='5' direction='right'><img width=\"30px\" src=\"/juegos/motos/moto2.gif\"></marquee></div>
</div><br />";
 if ($a=="armar"){
 $mot =  $mistake->query("SELECT moto FROM w_usuarios WHERE id='".$meuid."'")->fetch();
 if($mot[0]<50){
  $nna = 0;
 }else if($mot[0]>49 AND $mot[0]<100){
  $nna = 2;
 }else  if($mot[0]>100){
  $nna = 4;
 }
 $probar =  $mistake->query("SELECT COUNT(*) FROM fun_formula WHERE (uid='".$meuid."' OR uid2='".$meuid."' OR uid3='".$meuid."' OR uid4='".$meuid."' OR uid5='".$meuid."') AND abierta='1'")->fetch();
if($probar[0]>$nna){
$cre = $nna+1;
echo "<center>Você já tem um jogo armado. <br /> espere até que eles o aceitem para montar outro (você só pode construir $cre por vez)<br />";
}else{
echo "<img src=\"/juegos/motos/moto1.gif\" alt=\"\"/><b>moto-1</b><br/><img src=\"/juegos/motos/moto2.gif\" alt=\"\"/><b>moto-2</b><br/><img src=\"/juegos/motos/moto3.gif\" alt=\"\"/><b>moto-3</b><br/><img src=\"/juegos/motos/moto4.gif\" alt=\"\"/><b>moto-4</b><br/><img src=\"/juegos/motos/moto5.gif\" alt=\"\"/><b>moto-5</b>";
echo "<br/>";
echo "<form action=\"/motos/armar2\" method=\"post\">";
echo "Moto: <select name=\"carro\">";
echo "<option name=\"1\">1</option>";
echo "<option name=\"2\">2</option>";
echo "<option name=\"3\">3</option>";
echo "<option name=\"4\">4</option>";
echo "<option name=\"5\">5</option>";
echo "</select><br/>";
echo "Pontos: <select name=\"puntos\">";
echo "<option name=\"10\">10</option>";
echo "<option name=\"20\">20</option>";
echo "<option name=\"30\">30</option>";
echo "<option name=\"40\">40</option>";
echo "<option name=\"50\">50</option>";

echo "</select><br/>";
echo "<input type=\"submit\" value=\"Go!!!\"/></form>";
}

}
else if ($a=="armar2"){
 $mot =  $mistake->query("SELECT moto FROM w_usuarios WHERE id='".$meuid."'")->fetch();
 if($mot[0]<50){
  $nna = 0;
 }else if($mot[0]>49 AND $mot[0]<100){
  $nna = 2;
 }else  if($mot[0]>100){
  $nna = 4;
 }
 $probar =  $mistake->query("SELECT COUNT(*) FROM fun_formula  WHERE (uid='".$meuid."' OR uid2='".$meuid."' OR uid3='".$meuid."' OR uid4='".$meuid."' OR uid5='".$meuid."') AND abierta='1'")->fetch();
if($probar[0]>$nna){
$cre = $nna+1;
echo "<center>Você já tem um jogo armado. <br /> espere até que eles o aceitem para montar outro (você só pode construir $cre por vez)<br />";
}else{
$carro = $_POST['carro'];
$puntos = $_POST['puntos'];
if ($carro=="1"){
 $mistake->query("INSERT INTO fun_formula SET uid='".$meuid."', puntos='".$puntos."', abierta='1', time='".time()."'");
} else if ($carro=="2"){
 $mistake->query("INSERT INTO fun_formula SET uid2='".$meuid."', puntos='".$puntos."', abierta='1', time='".time()."'");
} else if ($carro=="3"){
 $mistake->query("INSERT INTO fun_formula SET uid3='".$meuid."', puntos='".$puntos."', abierta='1', time='".time()."'");
} else if ($carro=="4"){
 $mistake->query("INSERT INTO fun_formula SET uid4='".$meuid."', puntos='".$puntos."', abierta='1', time='".time()."'");
} else if ($carro=="5"){
 $mistake->query("INSERT INTO fun_formula SET uid5='".$meuid."', puntos='".$puntos."', abierta='1', time='".time()."'");
}
$pont =  $mistake->query("SELECT pt FROM w_usuarios WHERE id='".$meuid."'")->fetch();
$ns = $pont[0] - $puntos;
 $mistake->query("UPDATE w_usuarios SET pt='".$ns."' WHERE id='".$meuid."'");
$max =  $mistake->query("SELECT id,puntos FROM fun_formula WHERE abierta='1' ORDER BY id DESC LIMIT 0,1")->fetch();
echo "corrida criada! ... quando todos os jogadores se juntarem a você, uma mensagem será enviada para você advertindo <br /> você foi deduzido $pontos para a entrada deixando $pont[0] pontos para $ns pontos"; 
echo "<center>"; 
echo "<form action=\"/motos/motos\" method=\"post\">";
echo "<input type=\"hidden\" name=\"apu\" value=\"$max[1]\">";
echo "<input type=\"hidden\" name=\"num\" value=\"$max[0]\">";  
echo "<input type=\"submit\" value=\"Convidar no Chat\">";
echo "</form></center>"; 
}
}
if($a=="unirse"){  
$pos =  $mistake->query("SELECT pt FROM w_usuarios WHERE id='".$meuid."'")->fetch();
if($pos[0] < 300){
echo "<p align=\"center\">";
echo "É necessário ter 300 pontos em jogo!";
echo "</p>";
}   else  {  
echo "<center>Corrida de Motos</center>"; 
if($page=="" || $page<=0)$page=1;
$noi =  $mistake->query("SELECT COUNT(*) FROM fun_formula WHERE abierta='1'")->fetch();
$num_items = $noi[0]; //changable
$items_per_page= 10;
$num_pages = ceil($num_items/$items_per_page);
if(($page>$num_pages)&&$page!=1)$page= $num_pages;
$limit_start = ($page-1)*$items_per_page;
$sql = "SELECT id, uid, uid2, uid3, uid4, uid5, carro, carro2, carro3, carro4, carro5, puntos, abierta FROM fun_formula WHERE abierta=1 ORDER BY id LIMIT $limit_start, $items_per_page";
$nick= gerarnome($meuid); 
if($noi[0]>0){
$items =  $mistake->query($sql);
$i = 0;
while ($item = $items->fetch()){   
$part = $item[0];
if ($item[1]=="0"){
$img1=0;
} else { 
$img1=1;
}
if ($item[2]=="0"){
$img2=0;
} else { 
$img2=1;
}
if ($item[3]=="0"){
$img3=0;
} else { 
$img3=1;
}
if ($item[4]=="0"){
$img4=0;
} else { 
$img4=1;
}
if ($item[5]=="0"){
$img5=0;
} else { 
$img5=1;
}
$total= $img1+$img2+$img3 +$img4 +$img5;
?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<?
echo"<a href=\"/motos/elegir/$part\">Corrida num: $part $total participantes($item[11] pontos)</a></div>";
$i++;
}
if($num_pages>1){
paginas('motos',$a,$num_pages,$id,$pag);
}
    } }  }else if($a=="elegir") {
$num=$_GET['id'];
$item =  $mistake->query("SELECT id, uid, uid2, uid3, uid4, uid5, puntos, abierta FROM fun_formula WHERE id='".$num."'")->fetch();
if ($item[1]=="0")
{$img1="<a href=\"/motos/partida/$num/1\" class=\"small button green\"><img src=\"/juegos/motos/ssinmoto.gif\">-<small>UNIRSE</small></a>";} else { $img1="<img src=\"/juegos/motos/moto1.gif\">";
}
echo "</hr>";
if ($item[2]=="0")
{$img2="<a href=\"/motos/partida/$num/2\" class=\"small button green\"><img src=\"/juegos/motos/ssinmoto.gif\">-<small>UNIRSE</small></a>";} else { $img2="<img src=\"/juegos/motos/moto2.gif\">";
}
echo "</hr>";
if ($item[3]=="0")
{$img3="<a href=\"/motos/partida/$num/3\" class=\"small button green\"><img src=\"/juegos/motos/ssinmoto.gif\">-<small>UNIRSE</small></a>";} else { $img3="<img src=\"/juegos/motos/moto3.gif\">";
}
echo "</hr>";
if ($item[4]=="0")
{$img4="<a href=\"/motos/partida/$num/4\" class=\"small button green\"><img src=\"/juegos/motos/ssinmoto.gif\">-<small>UNIRSE</small></a>";} else { $img4="<img src=\"/juegos/motos/moto4.gif\">";
}
echo "</hr>";
if ($item[5]=="0"){
$img5="<a href=\"/motos/partida/$num/5\" class=\"small button green\"><img src=\"/juegos/motos/ssinmoto.gif\">-<small>UNIRSE</small></a>";
} else { 
$img5="<img src=\"/juegos/motos/moto5.gif\">";
}
$nick1= gerarnome($item[1]);
$nick2= gerarnome($item[2]);
$nick3= gerarnome($item[3]);
$nick4= gerarnome($item[4]); 
$nick5= gerarnome($item[5]);
echo "1-$img1-$nick1<br />2-$img2-$nick2<br />3-$img3-$nick3<br />4-$img4-$nick4<br />5-$img5-$nick5<br /> ";
echo "<center>";
echo "<form action=\"/motos/motos\" method=\"post\">";
echo "<input type=\"hidden\" name=\"apu\" value=\"$item[6]\">";
echo "<input type=\"hidden\" name=\"num\" value=\"$num\">";  
echo "<input type=\"submit\" value=\"Convidar no Chat\">";
echo "</form></center>";  
} else if($a=="partida"){
$num=$_GET['id'];
$item2 =  $mistake->query("SELECT id, uid, uid2, uid3, uid4, uid5, carro, carro2, carro3, carro4, carro5, puntos, abierta, ganador FROM fun_formula WHERE id='".$num."'")->fetch();
if ($meuid==$item2[1] OR $meuid==$item2[2] OR $meuid==$item2[3] OR $meuid==$item2[4]  OR $meuid==$item2[5]){
echo "<center><br /><br />Você já está participando desta corrida<br /></center>";
} else {
$moto= $_GET['pag'];
if($moto=="1"){
 $mistake->query("UPDATE fun_formula SET uid='".$meuid."' WHERE id='".$num."'");
} else if($moto=="2"){
 $mistake->query("UPDATE fun_formula SET uid2='".$meuid."' WHERE id='".$num."'");
} else if($moto=="3"){
 $mistake->query("UPDATE fun_formula SET uid3='".$meuid."' WHERE id='".$num."'");
} else if($moto=="4"){
 $mistake->query("UPDATE fun_formula SET uid4='".$meuid."' WHERE id='".$num."'");
} else if($moto=="5"){
 $mistake->query("UPDATE fun_formula SET uid5='".$meuid."' WHERE id='".$num."'");
}
$ponti =  $mistake->query("SELECT pt FROM w_usuarios WHERE id='".$meuid."'")->fetch();
$ns = $ponti[0] - $item2[11];
 $mistake->query("UPDATE w_usuarios SET pt='".$ns."' WHERE id='".$meuid."'");
header("location: /motos/entre/$num");
}
} else if ($a=="ver") {
$num=$_GET['id'];
$gann =  $mistake->query("SELECT id, uid, uid2, uid3, uid4, uid5, carro, ganador, puntos, abierta FROM fun_formula WHERE id='".$num."'")->fetch();
if ($gann[9]=="1"){
echo "Ainda não terminei a corrida";
exit();
} else {
$num=$_GET['id'];
if($gann[7]!=$gann[1]) {
$a= rand(1,15);
$yo1 =  str_repeat("&rsaquo;", $a);
}else{
$yo1 =  str_repeat("&rsaquo;", 18);
}
if($gann[7]!=$gann[2]) {
$a= rand(1,15);
$yo2 =  str_repeat("&rsaquo;", $a);
}else{
$yo2 =  str_repeat("&rsaquo;", 18);
}
if($gann[7]!=$gann[3]) {
$a= rand(1,15);
$yo3 =  str_repeat("&rsaquo;", $a);
}else{
$yo3 =  str_repeat("&rsaquo;", 18);
}
if($gann[7]!=$gann[4]) {
$a= rand(1,15);
$yo4 =  str_repeat("&rsaquo;", $a);
}else{
$yo4 =  str_repeat("&rsaquo;", 18);
}
if($gann[7]!=$gann[5]) {
$a= rand(1,15);
$yo5 =  str_repeat("&rsaquo;", $a);
}else{
$yo5 =  str_repeat("&rsaquo;", 18);
}
$img1="<img width=\"50px\" src=\"/juegos/motos/moto1.gif\">";
$img2="<img width=\"50px\" src=\"/juegos/motos/moto2.gif\">";
$img3="<img width=\"50px\" src=\"/juegos/motos/moto3.gif\">";
$img4="<img width=\"50px\" src=\"/juegos/motos/moto4.gif\">";
$img5="<img width=\"50px\" src=\"/juegos/motos/moto5.gif\">";
$nick1= gerarnome($gann[1]);
$nick2= gerarnome($gann[2]);
$nick3= gerarnome($gann[3]);
$nick4= gerarnome($gann[4]); 
$nick5= gerarnome($gann[5]); 
echo "1-$yo1$img1<br /><small>$nick1</small><hr>2-$yo2$img2<br /><small>$nick2</small><hr>3-$yo3$img3<br /><small>$nick3</small><hr>4-$yo4$img4<br /><small>$nick4</small><hr>5-$yo5$img5<br /><small>$nick5</small><hr>";
$monto = $gann[8]*5;
$nickgan= gerarnome($gann[7]);
echo "Ganhador: $nickgan com o número da moto $gann[6]<br /><img src=\"/juegos/motos/moto$gann[6].gif\"><br />";
echo "Eles apostam $gann[8] e eu ganho uma quantia de $monto pontos" ;
}
} else if ($a=="entre"){
$num=$_GET['id'];
$item2 =  $mistake->query("SELECT id, uid, uid2, uid3, uid4, uid5, carro, carro2, carro3, carro4, carro5, puntos, abierta, ganador FROM fun_formula WHERE id='".$num."'")->fetch();
if($item2[1]<>"0" AND $item2[2]<>"0" AND $item2[3]<>"0" AND $item2[4]<>"0" AND $item2[5]<>"0") {
$rc = rand(1,5);
if($rc=="1"){
$ganar= $item2[11]*5;
$pontos =  $mistake->query("SELECT pt, id, moto FROM w_usuarios WHERE id='".$item2[1]."'")->fetch();
$np = $pontos[0] + $ganar;
$mot = $pontos[2]+1;
 $mistake->query("UPDATE w_usuarios SET pt='".$np."', moto='".$mot."' WHERE id='".$item2[1]."'");
$ganador= $item2[1];
} else if($rc=="2"){
$ganar= $item2[11]*5;
$pontos =  $mistake->query("SELECT pt, id, moto FROM w_usuarios WHERE id='".$item2[2]."'")->fetch();
$np = $pontos[0] + $ganar;
$mot = $pontos[2]+1;
 $mistake->query("UPDATE w_usuarios SET pt='".$np."', moto='".$mot."' WHERE id='".$item2[2]."'");
$ganador= $item2[2];
} else if($rc=="3"){
$ganar= $item2[11]*5;
$pontos =  $mistake->query("SELECT pt, id, moto FROM w_usuarios WHERE id='".$item2[3]."'")->fetch();
$np = $pontos[0] + $ganar;
$mot = $pontos[2]+1;
 $mistake->query("UPDATE w_usuarios SET pt='".$np."', moto='".$mot."' WHERE id='".$item2[3]."'");
$ganador= $item2[3];
} else if($rc=="4"){
$ganar= $item2[11]*5;
$pontos =  $mistake->query("SELECT pt, id, moto FROM w_usuarios WHERE id='".$item2[4]."'")->fetch();
$np = $pontos[0] + $ganar;
$mot = $pontos[2]+1;
 $mistake->query("UPDATE w_usuarios SET pt='".$np."', moto='".$mot."' WHERE id='".$item2[4]."'");
$ganador= $item2[4];
} else if($rc=="5"){
$ganar= $item2[11]*5;
$pontos =  $mistake->query("SELECT pt, id, moto FROM w_usuarios WHERE id='".$item2[5]."'")->fetch();
$np = $pontos[0] + $ganar;
$mot = $pontos[2]+1;
 $mistake->query("UPDATE w_usuarios SET pt='".$np."', moto='".$mot."' WHERE id='".$item2[5]."'");
$ganador= $item2[5];
} 
 $mistake->query("UPDATE fun_formula SET abierta='2', ganador='".$ganador."', carro='".$rc."' WHERE id='".$num."'");  
$msg = "Olá, a corrida número $item2[0] terminou[br/][link=/motos/ver/$item2[0]].clik.[/link] para ver resultado";
automsg($msg,1,$item2[1]);
automsg($msg,1,$item2[2]);
automsg($msg,1,$item2[3]);
automsg($msg,1,$item2[4]);
automsg($msg,1,$item2[5]);
header("location:/motos/preterm/$num");
} else {  
echo "<center><br />pronto você está participando<br />";
echo "Você foi deduzido $item2[11] pontos, por participar";
echo "<br />Enviaremos uma mensagem quando os participantes estiverem concluídos para que você possa ver o resultado<br />
<br /><br />";
echo "<center>"; 
echo "<form action=\"/motos/motos\" method=\"post\">";
echo "<input type=\"hidden\" name=\"apu\" value=\"$val3\">";
echo "<input type=\"hidden\" name=\"num\" value=\"$num\">";  
echo "<input type=\"submit\" value=\"Convidar no Chat\">";
echo "</form></center>";  
}
} else 
if($a=="motos") {
if(isset($_POST['num'])!=''){
echo "<p align=\"center\">";
$num = $_POST["num"];
$apu = $_POST["apu"];
$texto = '[link=/motos/elegir/'.$num.']<br /><b><u>Motos Entre nessa corrida</u></b><br /><img src="/juegos/motos/moto'.rand(1,5).'.gif"/> [br/][b]Correr por '.$apu.' pontos[/b][/link]';
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
}else
if ($a=="menu"){
$noi1 =  $mistake->query("SELECT COUNT(*) FROM fun_formula WHERE abierta='1'")->fetch();      
 $mot =  $mistake->query("SELECT moto FROM w_usuarios WHERE id='".$meuid."'")->fetch();
 if($mot[0]<50){
  $nna = 1;
 }else if($mot[0]>49 AND $mot[0]<100){
  $nna = 3;
 }else  if($mot[0]>100){
  $nna = 5;
 }
echo "<center><br />";
echo "<br /><img src='/imagens/notok.gif' alt='Atención!'/> Ultrapassando 50 pontos você pode armar 3 corridas, excedendo 100 pontos que você pode armar 5 <br /> Você tem: $mot[0] vitórias, você pode armar $nna corridas <br /><br />";
echo "<a href=\"/motos/armar\" class=\"small button red\">CRIAR CORRIDA</a><br /><br />";
echo "<a href=\"/motos/unirse\" class=\"small button green\">UNIRSE A CORRIDA<small>($noi1[0])</small></a><br /><br />";
echo "<a href=\"/motos/top\"  class=\"small button green\">TOP CORREDORES GANHADORES</a><br /><br />";
echo "<a href=\"/motos/terminadas\"  class=\"small button green\">Terminadas</a><br /><br />";
}
if($a=="top") {  
echo "<center>Top ganhadores</center>"; 
if($page=="" || $page<=0)$page=1;
$noi =  $mistake->query("SELECT COUNT(*) FROM w_usuarios WHERE moto>='1'")->fetch();
$num_items = $noi[0];
$items_per_page= 7;
$num_pages = ceil($num_items/$items_per_page);
if(($page>$num_pages)&&$page!=1)$page= $num_pages;
$limit_start = ($page-1)*$items_per_page;
$sql = "SELECT id, moto FROM w_usuarios WHERE moto>='1' ORDER BY moto DESC LIMIT $limit_start, $items_per_page";
$nick= gerarnome($meuid); 
if($noi[0]>0){
$items =  $mistake->query($sql);
$i= 0;
while ($item = $items->fetch()){   
$part = $item[0];
?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<?
echo"<a href=\"perfil?id=$part\">".gerarnome($part).": $item[1] Victorias</a></div>";
$i++;
}
}
if($num_pages>1){
paginas('motos',$a,$num_pages,$id,$pag);
}
}
else if($a=="preterm"){
$num=$_GET['id'];
echo "<center><br /><br /><br />PARTIDA TERMINADA<br /><a href=\"/motos/ver/$num\">VER RESULTADO</a><br />";
} 
 if($a=="terminadas") {  
echo "<center>Corrida de Motos</center>"; 
if($page=="" || $page<=0)$page=1;
$noi =  $mistake->query("SELECT COUNT(*) FROM fun_formula WHERE abierta='2'")->fetch();
$num_items = $noi[0];
$items_per_page= 7;
$num_pages = ceil($num_items/$items_per_page);
if(($page>$num_pages)&&$page!=1)$page= $num_pages;
$limit_start = ($page-1)*$items_per_page;
$sql = "SELECT id, uid, uid2, uid3, uid4, uid5, carro, carro2, carro3, carro4, carro5, puntos, abierta FROM fun_formula WHERE abierta=2 ORDER BY id DESC LIMIT $limit_start, $items_per_page";
$items =  $mistake->query($sql);
$nick= gerarnome($meuid); 
if($noi[0]>0){
$items =  $mistake->query($sql);
$i = 0;
while ($item = $items->fetch()){
$part = $item[0];
?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<?
echo"<a href=\"/motos/ver/$part\">Corrida num: $part $total(ids:$item[1]-$item[2]-$item[3]-$item[4]-$item[5])</a></div>";
$i++;
}
if($num_pages>1){
paginas('motos',$a,$num_pages,$id,$pag);
}
} 
}
?>
</p><p align="center">
<br /><a href="/motos/menu">Menu Motos</a><br />
</p>
<br/><div align="center">
<a href="/home?"><?php echo $imginicio;?>Pagina principal</a><br><br>
<?php echo rodape();?>
</body>
</html>