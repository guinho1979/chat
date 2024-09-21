<?php
require_once("".$_SERVER["DOCUMENT_ROOT"]."/funcoes.php");
require_once("".$_SERVER["DOCUMENT_ROOT"]."/mistake.php");
require_once("".$_SERVER["DOCUMENT_ROOT"]."/tema.php");
seg($meuid);
$uid=$meuid;
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
///////////////////////////////////////////////////
?><div id="titulo">BingoWap</div><?
 $ss = $mistake->query("SELECT COUNT(*) FROM bingocart")->fetch();
 if($ss[0]>0){   
  $precio = $mistake->query("SELECT precio FROM bingoconf WHERE id='1'")->fetch();   
 $pozo = $ss[0]*$precio[0];
?><div id='div1'>Jogadores: <font color='red'><b><?php echo $ss[0];?></b></font>-Valendo: <font color='red'><b><?php echo $pozo;?></b></font> pontos</div><?
$esf = $mistake->query("SELECT uid,gan FROM bingocart ORDER BY gan DESC LIMIT 0,1")->fetch();
}  
  $precio = $mistake->query("SELECT precio FROM bingoconf WHERE id='1'")->fetch();
?><center><b>O cartão custa <?php echo $precio[0];?> pontos</b><br /><?
if($a=="comprar"){   
 $ss = $mistake->query("SELECT COUNT(*) FROM bingocart WHERE uid='".$uid."'")->fetch();
 if($ss[0]>0){
?><br />Você já tem um cartão de bingo<br />
<a href="bingowap?a=micarton">Meu cartão</a><br /><? 
}else{
$bi = $mistake->query("SELECT carton FROM bingoconf WHERE id='1'")->fetch();
if($bi[0]==1){
?><br />O bingo já começou e as cartas não são mais vendidas<br /><? 
}else{
$array1 = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25);
$array2 = array(26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50);
$vali1 = shuffle($array1);
$vali2 = shuffle($array2);
//$vali3 = shuffle($array3);
$nue1 = array($array1[0],$array1[1],$array1[2],$array1[3],$array1[4]);
$nue2 = array($array2[0],$array2[1],$array2[2],$array2[3],$array2[4]);
$precio = $mistake->query("SELECT precio FROM bingoconf WHERE id='1'")->fetch();
?>Valor promocional: <?php echo $precio[0];?><br />
<form action="bingowap?a=guardar"method="post">
<table border="1"><tr><?
sort($nue1); 
foreach ($nue1 as $key1 => $val1) { 
?><td><input type="hidden" name="uno<?php echo $key1;?>" value="<?php echo $val1;?>"><b>?</b></td><?
}
?></tr><tr><?
sort($nue2); 
foreach ($nue2 as $key2 => $val2) { 
?><td><input type="hidden" name="dos<?php echo $key2;?>" value="<?php echo $val2;?>"><b>?</b></td><? 
}
?></tr></table><input type="submit" value="COMPRAR"/></form><?
}
}
?><br /><a href="bingowap?a=menu">Menu Bingo</a><br>
<br /><?
}
/////////////////////////////////////////////////////////////////
else if($a=="guardar"){
 $ss = $mistake->query("SELECT COUNT(*) FROM bingocart WHERE uid='".$uid."'")->fetch();
 if($ss[0]>0){
?><br />Você já tem um cartão de bingo<br />
<a href="bingowap?a=micarton">Meu cartão</a><br /><?
}else{

$puntos = $mistake->query("SELECT pt FROM w_usuarios WHERE id='".$uid."'")->fetch();
$precio = $mistake->query("SELECT precio FROM bingoconf WHERE id='1'")->fetch();
if($puntos[0]<$precio[0]){
?>você não tem os pontos necessários para jogar
<br /><a href="bingowap?a=menu">Menu Bingo</a><br>
<br /><?
exit();
}
$uno0 = $_POST['uno0'];
$uno1 = $_POST['uno1'];
$uno2 = $_POST['uno2'];
$uno3 = $_POST['uno3'];
$uno4 = $_POST['uno4'];

$dos0 = $_POST['dos0'];
$dos1 = $_POST['dos1'];
$dos2 = $_POST['dos2'];
$dos3 = $_POST['dos3'];
$dos4 = $_POST['dos4'];

$res = $mistake->exec("INSERT INTO bingocart SET uid='".$uid."',u0='".$uno0."',u1='".$uno1."',u2='".$uno2."',u3='".$uno3."',u4='".$uno4."',d0='".$dos0."',d1='".$dos1."',d2='".$dos2."',d3='".$dos3."',d4='".$dos4."',time='".time()."'");
if($res){

 $precio = $mistake->query("SELECT precio FROM bingoconf WHERE id='1'")->fetch();
$punt = $puntos[0]-$precio[0];

$mistake->exec("UPDATE w_usuarios SET pt='".$punt."' WHERE id='".$meuid."'");
?>Seus pontos vão de <?php echo $puntos[0];?> a <?php echo $punt;?>.<br />Seu bingo:<br />
<table style="border-collapse: collapse;border: 1px solid black;text-align: center;vertical-align:center;">
<tr style="background-color: #00a2ff;"><td>
B</td><td>I</td><td>N</td><td>G</td><td>O
</td></tr><tr>
<td style="background-color: #7deaf7;width:30px;height:30px;border-collapse: collapse;border: 1px solid black;text-align: center;vertical-align:center;">
<?php echo $uno0;?></td>
<td style="background-color: #86f77d;width:30px;height:30px;border-collapse: collapse;border: 1px solid black;text-align: center;vertical-align:center;"><?php echo $uno1;?></td>
<td style="background-color: #7deaf7;width:30px;height:30px;border-collapse: collapse;border: 1px solid black;text-align: center;vertical-align:center;"><?php echo $uno2;?></td>
<td style="background-color: #86f77d;width:30px;height:30px;border-collapse: collapse;border: 1px solid black;text-align: center;vertical-align:center;"><?php echo $uno3;?></td>
<td style="background-color: #7deaf7;width:30px;height:30px;border-collapse: collapse;border: 1px solid black;text-align: center;vertical-align:center;"><?php echo $uno4;?>
</td></tr><tr>
<td style="background-color: #86f77d;width:30px;height:30px;border-collapse: collapse;border: 1px solid black;text-align: center;vertical-align:center;">
<?php echo $dos0;?></td>
<td style="background-color: #7deaf7;width:30px;height:30px;border-collapse: collapse;border: 1px solid black;text-align: center;vertical-align:center;"><?php echo $dos1;?></td>
<td style="background-color: #86f77d;width:30px;height:30px;border-collapse: collapse;border: 1px solid black;text-align: center;vertical-align:center;"><?php echo $dos2;?></td>
<td style="background-color: #7deaf7;width:30px;height:30px;border-collapse: collapse;border: 1px solid black;text-align: center;vertical-align:center;"><?php echo $dos3;?></td>
<td style="background-color: #86f77d;width:30px;height:30px;border-collapse: collapse;border: 1px solid black;text-align: center;vertical-align:center;"><?php echo $dos4;?>
</td></tr></table><?
 }
?><br /><a href="bingowap?a=menu">Menu Bingo</a><br>
<br /><?
}
}
else if($a=="sortearnu"){
 $ss = $mistake->query("SELECT COUNT(*) FROM bingosort")->fetch();
if($ss[0]>0){
?><br />Já existe uma bingo em andamento ... Sopre as bolas e então jogue novamente.<br /><?
}else{ 
$rand = range(1, 50); 
shuffle($rand); 
foreach ($rand as $val) { 
$mistake->exec("INSERT INTO bingosort SET num='".$val."'");
}
?><br />Números sorteados !! começa a mostrá-los no chat<br /><?
}
?><br /><a href="bingowap?a=menu" class="small button green">Menu Bingo</a><br>
<br /><?
}  else if($a=="borrar"){
if(permdono($meuid)){
$mistake->query("TRUNCATE TABLE bingosort");
$mistake->query("TRUNCATE TABLE bingomos");
$mistake->query("TRUNCATE TABLE bingocart");
$mistake->exec("UPDATE bingoconf SET bingo='0', carton='0' WHERE id='1'");
}
echo "Borrando...<meta http-equiv=\"refresh\" content=\"1; url=bingowap?a=menu\">";
}  else if($a=="borrar2"){
if(permdono($meuid)){
?><center>Certamente você quer apagar cartas, rifas e bolas que saíram?<br /><br /><a href="bingowap?a=borrar">SIM, REINICIAR</a><br /><br /> 
<a href="bingowap?a=menu">NÃO, VOLTAR AO MENU</a><br /><br /><? 
}
}
else if($a=="sortearbol"){
if(permdono($meuid)){
 $p = $mistake->prepare("SELECT COUNT(*) FROM bingomos");
 $p->execute();
$p = $p->fetch();
$idnum = $p[0]+1;
 $pa = $mistake->prepare("SELECT num FROM bingosort WHERE id='".$idnum."'");
 $pa->execute();
$pa = $pa->fetch();
$res = $mistake->exec("INSERT INTO bingomos SET num='".$pa[0]."'");

$chatok = $mistake->exec("INSERT INTO chatbingoonl SET uid='1',texto='Sorteo Numero: [bingo]".$pa[0]."[/bingo]',data='".time()."'");

header("location:chatbingo?a=a");

} }
//////////////////////////////////micarton
 else if($a=="micarton"){
 
?><br /><a href="chatbingo?a=a">Voltar a sala de chat</a><br /><?
$esi = $mistake->query("SELECT COUNT(*) FROM bingocart WHERE uid='".$uid."'")->fetch();
if($esi[0]>0){
?><a href="bingowap?a=micarton2">Veja por ordem numeral</a><br /><?

$es = $mistake->query("SELECT u0,u1,u2,u3,u4,d0,d1,d2,d3,d4,time,gan FROM bingocart WHERE uid='".$uid."' ORDER BY id DESC LIMIT 0,1")->fetch();
$u1 = $es[0];
$u2 = $es[1];
$u3 = $es[2];
$u4 = $es[3];
$u5 = $es[4];
$d1 = $es[5];
$d2 = $es[6];
$d3 = $es[7];
$d4 = $es[8];
$d5 = $es[9];
$gan = $es[11];
///////////1
$pos1 = strpos($u1, "X");
if($pos1==true){
$car1 = str_replace("X","", $u1);
$uno1="<font color=\"white\">$car1</font>";
$c1="ff0000";
}else{
$uno1= "<form action=\"bingowap?a=marcar&urlr=1\" method=\"post\"><input type=\"hidden\" name=\"numero\" value=\"$u1\"><input type=\"hidden\" name=\"tabla\" value=\"u0\"><input type=\"submit\" value=\"$u1\" class=\"bingo\"></form>";
$c1="7deaf7";
}
///////////////////////////////  2
$pos2 = strpos($u2, "X");
if($pos2==true){
$car2 = str_replace("X","", $u2);

$uno2="<font color=\"white\">$car2</font>";
$c2="ff0000";
}else{
$uno2= "<form action=\"bingowap?a=marcar&urlr=1\" method=\"post\"><input type=\"hidden\" name=\"numero\" value=\"$u2\"><input type=\"hidden\" name=\"tabla\" value=\"u1\"><input class=\"bingo\" type=\"submit\" value=\"$u2\"></form>";
$c2="86f77d";
}
///////////////////////////////  3
$pos3 = strpos($u3, "X");
if($pos3==true){
$car3 = str_replace("X","", $u3);
$uno3="<font color=\"white\">$car3</font>";
$c3="ff0000";
}else{
$uno3= "<form action=\"bingowap?a=marcar&urlr=1\" method=\"post\"><input type=\"hidden\" name=\"numero\" value=\"$u3\"><input type=\"hidden\" name=\"tabla\" value=\"u2\"><input type=\"submit\" value=\"$u3\" class=\"bingo\"></form>";
$c3="7deaf7";
}
///////////////////////////////  4
$pos4 = strpos($u4, "X");
if($pos4==true){
$car4 = str_replace("X","", $u4);
$uno4="<font color=\"white\">$car4</font>";
$c4="ff0000";
}else{
$uno4= "<form action=\"bingowap?a=marcar&urlr=1\" method=\"post\"><input type=\"hidden\" name=\"numero\" value=\"$u4\"><input type=\"hidden\" name=\"tabla\" value=\"u3\"><input type=\"submit\" value=\"$u4\" class=\"bingo\"></form>";
$c4="86f77d";
}
///////////////////////////////  5
$pos5 = strpos($u5, "X");
if($pos5==true){
$car5 = str_replace("X","", $u5);
$uno5="<font color=\"white\">$car5</font>";
$c5="ff0000";
}else{
$uno5= "<form action=\"bingowap?a=marcar&urlr=1\" method=\"post\"><input type=\"hidden\" name=\"numero\" value=\"$u5\"><input type=\"hidden\" name=\"tabla\" value=\"u4\"><input type=\"submit\" value=\"$u5\" class=\"bingo\"></form>";
$c5="7deaf7";
}

///////////1
$posa1 = strpos($d1, "X");
if($posa1==true){
$cara1 = str_replace("X","", $d1);
$dos1="<font color=\"white\">$cara1</font>";
$e1="ff0000";
}else{
$dos1= "<form action=\"bingowap?a=marcar&urlr=1\" method=\"post\"><input type=\"hidden\" name=\"numero\" value=\"$d1\"><input type=\"hidden\" name=\"tabla\" value=\"d0\"><input type=\"submit\" value=\"$d1\" class=\"bingo\"></form>";
$e1="86f77d";
}
///////////////////////////////  2
$posa2 = strpos($d2, "X");
if($posa2==true){
$cara2 = str_replace("X","", $d2);
$dos2="<font color=\"white\">$cara2</font>";
$e2="ff0000";
}else{
$dos2= "<form action=\"bingowap?a=marcar&urlr=1\" method=\"post\"><input type=\"hidden\" name=\"numero\" value=\"$d2\"><input type=\"hidden\" name=\"tabla\" value=\"d1\"><input type=\"submit\" value=\"$d2\" class=\"bingo\"></form>";
$e2="7deaf7";
}
///////////////////////////////  3
$posa3 = strpos($d3, "X");
if($posa3==true){
$cara3 = str_replace("X","", $d3);
$dos3="<font color=\"white\">$cara3</font>";
$e3="ff0000";
}else{
$dos3= "<form action=\"bingowap?a=marcar&urlr=1\" method=\"post\"><input type=\"hidden\" name=\"numero\" value=\"$d3\"><input type=\"hidden\" name=\"tabla\" value=\"d2\"><input type=\"submit\" value=\"$d3\" class=\"bingo\"></form>";
$e3="86f77d";
}
///////////////////////////////  4
$posa4 = strpos($d4, "X");
if($posa4==true){
$cara4 = str_replace("X","", $d4);
$dos4="<font color=\"white\">$cara4</font>";
$e4="ff0000";
}else{
$dos4= "<form action=\"bingowap?a=marcar&urlr=1\" method=\"post\"><input type=\"hidden\" name=\"numero\" value=\"$d4\"><input type=\"hidden\" name=\"tabla\" value=\"d3\"><input type=\"submit\" value=\"$d4\" class=\"bingo\"></form>";
$e4="7deaf7";
}
///////////////////////////////  5
$posa5 = strpos($d5, "X");
if($posa5==true){
$cara5 = str_replace("X","", $d5);
$dos5="<font color=\"white\">$cara5</font>";
$e5="ff0000";
}else{
$dos5= "<form action=\"bingowap?a=marcar&urlr=1\" method=\"post\"><input type=\"hidden\" name=\"numero\" value=\"$d5\"><input type=\"hidden\" name=\"tabla\" value=\"d4\"><input type=\"submit\" value=\"$d5\" class=\"bingo\"></form>";
$e5="86f77d";
}


?>Acertos: <b><?php echo $gan;?></b><br />
<table style="border-collapse: collapse;border: 1px solid black;text-align: center;vertical-align:center;">
<tr style="background-color: #00a2ff;"><td>
B</td><td>I</td><td>N</td><td>G</td><td>O
</td></tr><tr>
<td style="background-color: #<?php echo $c1;?>;width:40px;height:40px;border-collapse: collapse;border: 1px solid black;text-align: center;vertical-align:center;">
<?php echo $uno1;?></td>
<td style="background-color: #<?php echo $c2;?>;width:40px;height:40px;border-collapse: collapse;border: 1px solid black;text-align: center;vertical-align:center;">
<?php echo $uno2;?></td>
<td style="background-color: #<?php echo $c3;?>;width:40px;height:40px;border-collapse: collapse;border: 1px solid black;text-align: center;vertical-align:center;">
<?php echo $uno3;?></td>
<td style="background-color: #<?php echo $c4;?>;width:40px;height:40px;border-collapse: collapse;border: 1px solid black;text-align: center;vertical-align:center;">
<?php echo $uno4;?></td>
<td style="background-color: #<?php echo $c5;?>;width:40px;height:40px;border-collapse: collapse;border: 1px solid black;text-align: center;vertical-align:center;">
<?php echo $uno5;?>
</td></tr><tr>
<td style="background-color: #<?php echo $e1;?>;width:40px;height:40px;border-collapse: collapse;border: 1px solid black;text-align: center;vertical-align:center;">
<?php echo $dos1;?></td>
<td style="background-color: #<?php echo $e2;?>;width:40px;height:40px;border-collapse: collapse;border: 1px solid black;text-align: center;vertical-align:center;">
<?php echo $dos2;?></td>
<td style="background-color: #<?php echo $e3;?>;width:40px;height:40px;border-collapse: collapse;border: 1px solid black;text-align: center;vertical-align:center;">
<?php echo $dos3;?></td>
<td style="background-color: #<?php echo $e4;?>;width:40px;height:40px;border-collapse: collapse;border: 1px solid black;text-align: center;vertical-align:center;">
<?php echo $dos4;?></td>
<td style="background-color: #<?php echo $e5;?>;width:40px;height:40px;border-collapse: collapse;border: 1px solid black;text-align: center;vertical-align:center;">
<?php echo $dos5;?>
</td></tr></table>
<hr><?

$noi1 = $mistake->query("SELECT COUNT(*) FROM bingomos WHERE id>0 AND id<11")->fetch();
$noi2 = $mistake->query("SELECT COUNT(*) FROM bingomos WHERE id>10 AND id<21")->fetch();
$noi3 = $mistake->query("SELECT COUNT(*) FROM bingomos WHERE id>20 AND id<31")->fetch();
$noi4 = $mistake->query("SELECT COUNT(*) FROM bingomos WHERE id>30 AND id<41")->fetch();
$noi5 = $mistake->query("SELECT COUNT(*) FROM bingomos WHERE id>40 AND id<51")->fetch();
$noi6 = $mistake->query("SELECT COUNT(*) FROM bingomos WHERE id>50 AND id<61")->fetch();

$sql = "SELECT num FROM bingomos WHERE id>0 AND id<11 ORDER BY id DESC";
$sql2 = "SELECT num FROM bingomos WHERE id>10 AND id<21 ORDER BY id DESC";
$sql3 = "SELECT num FROM bingomos WHERE id>20 AND id<31 ORDER BY id DESC";
$sql4 = "SELECT num FROM bingomos WHERE id>30 AND id<41 ORDER BY id DESC";
$sql5 = "SELECT num FROM bingomos WHERE id>40 AND id<51 ORDER BY id DESC";
$sql6 = "SELECT num FROM bingomos WHERE id>50 AND id<61 ORDER BY id DESC";
$items = $mistake->query($sql);
$items2 = $mistake->query($sql2);
$items3 = $mistake->query($sql3);
$items4 = $mistake->query($sql4);
$items5 = $mistake->query($sql5);
$items6 = $mistake->query($sql6);
$ess = $mistake->query("SELECT num FROM bingomos ORDER BY id DESC LIMIT 0,1")->fetch();
?>Numeros Sorteados:<br />
ULTIMO:<div style="width:35px;height:35px;background-color:white;border:1px solid black;border-radius:50px;line-height: 35px;text-align: center;"><?php echo $ess[0];?></div><br />
<table border=1"><?
if($noi6[0]>0){
echo "<tr style=\"vertical-align: top;\">";
while ($item6 = $items6->fetch()){ 
?><td style="width:35px;height:35px;background-color:white;border:1px solid black;border-radius:50px;line-height: 35px;text-align: center;"><?php echo $item6[0];?></td><?
}?>
</tr><?
}
if($noi5[0]>0){
?><tr style="vertical-align: top;"><?
while ($item5 = $items5->fetch()){ 
?><td style="width:35px;height:35px;background-color:white;border:1px solid black;border-radius:50px;line-height: 35px;text-align: center;"><?php echo $item5[0];?></td><?
}
?></tr><?
}
if($noi4[0]>0){
?><tr style="vertical-align: top;"><?
while ($item4 = $items4->fetch()){ 
?><td style="width:35px;height:35px;background-color:white;border:1px solid black;border-radius:50px;line-height: 35px;text-align: center;"><?php echo $item4[0];?></td><?
}
?></tr><?
}
if($noi3[0]>0){
?><tr style="vertical-align: top;"><?
while ($item3 = $items3->fetch()){ 
?><td style="width:35px;height:35px;background-color:white;border:1px solid black;border-radius:50px;line-height: 35px;text-align: center;"><?php echo $item3[0];?></td><?
}
?></tr><?
}
if($noi2[0]>0){
?><tr style="vertical-align: top;"><?
while ($item2 = $items2->fetch()){ 
?><td style="width:35px;height:35px;background-color:white;border:1px solid black;border-radius:50px;line-height: 35px;text-align: center;"><?php echo $item2[0];?></td><?
}
?></tr><?
}
if($noi1[0]>0){
?><tr style="vertical-align: top;"><?
while ($item = $items->fetch()){ 
?><td style="width:35px;height:35px;background-color:white;border:1px solid black;border-radius:50px;line-height: 35px;text-align: center;"><?php echo $item[0];?></td><?
}
?></tr><?
}
?></table><?
}else{
?><p align="center"><br />Você ainda não tem um cartão de bingo.<br />Deseja comprar um?<br />
<a href="bingowap?a=comprar">Comprar Cartão</a><br />
<br /><a href="bingowap?a=menu">voltar ao menu</a><br />
<br /><a href="chatbingo?a=a">voltar a sala do Bingo</a><br />  
<?
}
}
else if($a=="micarton2"){
?><a href="chatbingo?a=a">voltar a sala do Bingo</a><br />
<a href="bingowap?a=micarton">Ver Por Orden De Saida</a><br /><?
$es = $mistake->query("SELECT u0,u1,u2,u3,u4,d0,d1,d2,d3,d4,time,gan FROM bingocart WHERE uid='".$uid."' ORDER BY id DESC LIMIT 0,1")->fetch();
$u1 = $es[0];
$u2 = $es[1];
$u3 = $es[2];
$u4 = $es[3];
$u5 = $es[4];
$d1 = $es[5];
$d2 = $es[6];
$d3 = $es[7];
$d4 = $es[8];
$d5 = $es[9];
$gan = $es[11];
///////////1
$pos1 = strpos($u1, "X");
if($pos1==true){
$car1 = str_replace("X","", $u1);
$uno1="<font color=\"white\">$car1</font>";
$c1="ff0000";
}else{
$uno1= "<form action=\"bingowap?a=marcar&urlr=2\" method=\"post\"><input type=\"hidden\" name=\"numero\" value=\"$u1\"><input type=\"hidden\" name=\"tabla\" value=\"u0\"><input type=\"submit\" value=\"$u1\" class=\"bingo\"></form>";
$c1="7deaf7";
}
///////////////////////////////  2
$pos2 = strpos($u2, "X");
if($pos2==true){
$car2 = str_replace("X","", $u2);

$uno2="<font color=\"white\">$car2</font>";
$c2="ff0000";
}else{
$uno2= "<form action=\"bingowap?a=marcar&urlr=2\" method=\"post\"><input type=\"hidden\" name=\"numero\" value=\"$u2\"><input type=\"hidden\" name=\"tabla\" value=\"u1\"><input class=\"bingo\" type=\"submit\" value=\"$u2\"></form>";
$c2="86f77d";
}
///////////////////////////////  3
$pos3 = strpos($u3, "X");
if($pos3==true){
$car3 = str_replace("X","", $u3);
$uno3="<font color=\"white\">$car3</font>";
$c3="ff0000";
}else{
$uno3= "<form action=\"bingowap?a=marcar&urlr=2\" method=\"post\"><input type=\"hidden\" name=\"numero\" value=\"$u3\"><input type=\"hidden\" name=\"tabla\" value=\"u2\"><input type=\"submit\" value=\"$u3\" class=\"bingo\"></form>";
$c3="7deaf7";
}
///////////////////////////////  4
$pos4 = strpos($u4, "X");
if($pos4==true){
$car4 = str_replace("X","", $u4);
$uno4="<font color=\"white\">$car4</font>";
$c4="ff0000";
}else{
$uno4= "<form action=\"bingowap?a=marcar&urlr=2\" method=\"post\"><input type=\"hidden\" name=\"numero\" value=\"$u4\"><input type=\"hidden\" name=\"tabla\" value=\"u3\"><input type=\"submit\" value=\"$u4\" class=\"bingo\"></form>";
$c4="86f77d";
}
///////////////////////////////  5
$pos5 = strpos($u5, "X");
if($pos5==true){
$car5 = str_replace("X","", $u5);
$uno5="<font color=\"white\">$car5</font>";
$c5="ff0000";
}else{
$uno5= "<form action=\"bingowap?a=marcar&urlr=2\" method=\"post\"><input type=\"hidden\" name=\"numero\" value=\"$u5\"><input type=\"hidden\" name=\"tabla\" value=\"u4\"><input type=\"submit\" value=\"$u5\" class=\"bingo\"></form>";
$c5="7deaf7";
}

///////////1
$posa1 = strpos($d1, "X");
if($posa1==true){
$cara1 = str_replace("X","", $d1);
$dos1="<font color=\"white\">$cara1</font>";
$e1="ff0000";
}else{
$dos1= "<form action=\"bingowap?a=marcar&urlr=2\" method=\"post\"><input type=\"hidden\" name=\"numero\" value=\"$d1\"><input type=\"hidden\" name=\"tabla\" value=\"d0\"><input type=\"submit\" value=\"$d1\" class=\"bingo\"></form>";
$e1="86f77d";
}
///////////////////////////////  2
$posa2 = strpos($d2, "X");
if($posa2==true){
$cara2 = str_replace("X","", $d2);
$dos2="<font color=\"white\">$cara2</font>";
$e2="ff0000";
}else{
$dos2= "<form action=\"bingowap?a=marcar&urlr=2\" method=\"post\"><input type=\"hidden\" name=\"numero\" value=\"$d2\"><input type=\"hidden\" name=\"tabla\" value=\"d1\"><input type=\"submit\" value=\"$d2\" class=\"bingo\"></form>";
$e2="7deaf7";
}
///////////////////////////////  3
$posa3 = strpos($d3, "X");
if($posa3==true){
$cara3 = str_replace("X","", $d3);
$dos3="<font color=\"white\">$cara3</font>";
$e3="ff0000";
}else{
$dos3= "<form action=\"bingowap?a=marcar&urlr=2\" method=\"post\"><input type=\"hidden\" name=\"numero\" value=\"$d3\"><input type=\"hidden\" name=\"tabla\" value=\"d2\"><input type=\"submit\" value=\"$d3\" class=\"bingo\"></form>";
$e3="86f77d";
}
///////////////////////////////  4
$posa4 = strpos($d4, "X");
if($posa4==true){
$cara4 = str_replace("X","", $d4);
$dos4="<font color=\"white\">$cara4</font>";
$e4="ff0000";
}else{
$dos4= "<form action=\"bingowap?a=marcar&urlr=2\" method=\"post\"><input type=\"hidden\" name=\"numero\" value=\"$d4\"><input type=\"hidden\" name=\"tabla\" value=\"d3\"><input type=\"submit\" value=\"$d4\" class=\"bingo\"></form>";
$e4="7deaf7";
}
///////////////////////////////  5
$posa5 = strpos($d5, "X");
if($posa5==true){
$cara5 = str_replace("X","", $d5);
$dos5="<font color=\"white\">$cara5</font>";
$e5="ff0000";
}else{
$dos5= "<form action=\"bingowap?a=marcar&urlr=2\" method=\"post\"><input type=\"hidden\" name=\"numero\" value=\"$d5\"><input type=\"hidden\" name=\"tabla\" value=\"d4\"><input type=\"submit\" value=\"$d5\" class=\"bingo\"></form>";
$e5="86f77d";
}

?>
Acertos: <b><?php echo $gan;?></b><br />
<table style="border-collapse: collapse;border: 1px solid black;text-align: center;vertical-align:center;">
<tr style="background-color: #00a2ff;"><td>
B</td><td>I</td><td>N</td><td>G</td><td>O
</td></tr><tr>
<td style="background-color: #<?php echo $c1;?>;width:40px;height:40px;border-collapse: collapse;border: 1px solid black;text-align: center;vertical-align:center;">
<?php echo $uno1;?></td>
<td style="background-color: #<?php echo $c2;?>;width:40px;height:40px;border-collapse: collapse;border: 1px solid black;text-align: center;vertical-align:center;">
<?php echo $uno2;?></td>
<td style="background-color: #<?php echo $c3;?>;width:40px;height:40px;border-collapse: collapse;border: 1px solid black;text-align: center;vertical-align:center;">
<?php echo $uno3;?></td>
<td style="background-color: #<?php echo $c4;?>;width:40px;height:40px;border-collapse: collapse;border: 1px solid black;text-align: center;vertical-align:center;">
<?php echo $uno4;?></td>
<td style="background-color: #<?php echo $c5;?>;width:40px;height:40px;border-collapse: collapse;border: 1px solid black;text-align: center;vertical-align:center;">
<?php echo $uno5;?>
</td></tr><tr>
<td style="background-color: #<?php echo $e1;?>;width:40px;height:40px;border-collapse: collapse;border: 1px solid black;text-align: center;vertical-align:center;">
<?php echo $dos1;?></td>
<td style="background-color: #<?php echo $e2;?>;width:40px;height:40px;border-collapse: collapse;border: 1px solid black;text-align: center;vertical-align:center;">
<?php echo $dos2;?></td>
<td style="background-color: #<?php echo $e3;?>;width:40px;height:40px;border-collapse: collapse;border: 1px solid black;text-align: center;vertical-align:center;">
<?php echo $dos3;?></td>
<td style="background-color: #<?php echo $e4;?>;width:40px;height:40px;border-collapse: collapse;border: 1px solid black;text-align: center;vertical-align:center;">
<?php echo $dos4;?></td>
<td style="background-color: #<?php echo $e5;?>;width:40px;height:40px;border-collapse: collapse;border: 1px solid black;text-align: center;vertical-align:center;">
<?php echo $dos5;?>
</td></tr></table>
<hr><?

$noi1 = $mistake->query("SELECT COUNT(*) FROM bingomos")->fetch();
$sql = "SELECT num FROM bingomos ORDER BY num";
$items = $mistake->query($sql);
echo "Numeros Sorteados:<br />";
if($noi1[0]>0){
while ($item = $items->fetch()){ 
echo"<b>$item[0]</b> - ";
}
}
}
///////////////////////////////////////////////
else if($a=="marcar"){
$numero = $_POST['numero'];
$tabla =  $_POST['tabla'];
$urlr =  $_GET['urlr'];
if($urlr==1){
$ir = "bingowap?a=micarton";
}else if($urlr==2){
$ir = "bingowap?a=micarton2";
}else{
$ir="chatbingo?a=a";
}
$bi = $mistake->query("SELECT bingo FROM bingoconf WHERE id='1'")->fetch();
if($bi[0]==1){
header("location:$ir");
exit();
}
$p = $mistake->query("SELECT COUNT(*) FROM bingomos WHERE num='".$numero."'")->fetch();
echo "$numero, $tabla<br />";
if($p[0]==0){
echo "este numero no salio";
header("location:$ir");
exit();
}else{
$es = $mistake->query("SELECT id, gan, $tabla FROM bingocart WHERE uid='".$uid."' ORDER BY id DESC LIMIT 0,1")->fetch();
$posx = strpos($es[2], "X");
if($posx==true){
header("location:$ir");
exit();
}
echo "numero marcado";

 $res=$mistake->exec("UPDATE bingocart SET $tabla='".$numero."X' WHERE id='".$es[0]."'");

 if($res){
 ///////////////////////
$es = $mistake->query("SELECT u0,u1,u2,u3,u4,d0,d1,d2,d3,d4,time,gan FROM bingocart WHERE uid='".$uid."' ORDER BY id DESC LIMIT 0,1")->fetch();
$u1 = $es[0];
$u2 = $es[1];
$u3 = $es[2];
$u4 = $es[3];
$u5 = $es[4];
$d1 = $es[5];
$d2 = $es[6];
$d3 = $es[7];
$d4 = $es[8];
$d5 = $es[9];
$gan = $es[11];
///////////1
$pos1 = strpos($u1, "X");
if($pos1==true){
$to1=1;
}else{
$to1=0;
}
///////////////////////////////  2
$pos2 = strpos($u2, "X");
if($pos2==true){
$to2=1;
}else{
$to2=0;
}
///////////////////////////////  3
$pos3 = strpos($u3, "X");
if($pos3==true){
$to3=1;
}else{
$to3=0;
}
///////////////////////////////  4
$pos4 = strpos($u4, "X");
if($pos4==true){
$to4=1;
}else{
$to4=0;
}
///////////////////////////////  5
$pos5 = strpos($u5, "X");
if($pos5==true){
$to5=1;
}else{
$to5=0;
}

///////////1
$posa1 = strpos($d1, "X");
if($posa1==true){
$to6=1;
}else{
$to6=0;
}
///////////////////////////////  2
$posa2 = strpos($d2, "X");
if($posa2==true){
$to7=1;
}else{
$to7=0;
}
///////////////////////////////  3
$posa3 = strpos($d3, "X");
if($posa3==true){
$to8=1;
}else{
$to8=0;
}
///////////////////////////////  4
$posa4 = strpos($d4, "X");
if($posa4==true){
$to9=1;
}else{
$to9=0;
}
///////////////////////////////  5
$posa5 = strpos($d5, "X");
if($posa5==true){
$to10=1;
}else{
$to10=0;
}
}
////////////////////////////////////////////////////////////////////////////////////
$tot=$to1+$to2+$to3+$to4+$to5+$to6+$to7+$to8+$to9+$to10;
 $res=$mistake->exec("UPDATE bingocart SET gan='".$tot."' WHERE uid='".$uid."'");
if($tot==10){

$chatok = $mistake->exec("INSERT INTO chatbingoonl SET uid='".$uid."',texto='[img=imagens/bingo1.gif][bingo]".$numero."[/bingo][link=bingowap?a=controlar&id=$uid]Meu cartão[/link]',data='".time()."'");
 $res=$mistake->exec("UPDATE bingoconf SET bingo='1' WHERE id='1'");
}

 header("location:$ir");
 }
}

else if($a=="menu"){

?><p align="center">
<div id="div1"><a href="bingowap?a=comprar">Comprar cartão</a></div><br />
<div id="div1"><a href="bingowap?a=micarton">Controlar numeros</a></div><br />
<div id="div1"><a href="chatbingo?a=a">Voltar a sala do Bingo</a></div><br />
<div id="div1"><a href="bingowap?a=cartones">Cartões Vendidos</a></div><br /><?
if(permdono($meuid)){
?><div id="div1"><a href="bingowap?a=comprar2">Asignar cartão</a></div><br /><?
$ss = $mistake->query("SELECT COUNT(*) FROM bingosort")->fetch();
if($ss[0]>0){
?><br />Sorteio em andamento.<br /><?
}else{ 
?><div id="div1"><a href="bingowap?a=sortearnu">Sortear numeros</a></div><br /><?
}
?><div id="div1"><a href="bingowap?a=borrar2">Reiniciar bingo</a></div><br /><?
$esq = $mistake->query("SELECT bingo FROM w_geral WHERE id='1'")->fetch();
if($esq[0]=="0"){
?><div id="div1"><a href="bingowap?a=activar">ATIVAR BINGO</a></div><br /><?
}else{
?><div id="div1"><a href="bingowap?a=desactivar">DESATIVAR BINGO</a></div><br /><?
}
$esqq = $mistake->query("SELECT carton FROM bingoconf WHERE id='1'")->fetch();
if($esqq[0]=="0"){
?><div id="div1"><a href="bingowap?a=desactivarcar">DESATIVAR VENDA DE BINGO</a></div><br /><?
 }else{
?><div id="div1"><a href="bingowap?a=activarcar">ATIVAR VENDA DE BINGO</a></div><br /><?
}
}
}                 
else if($a=="controlar"){
echo"<br /><a href=\"chatbingo?a=a\">Voltar para a sala do Bingo</a><br />"; 

$es = $mistake->query("SELECT u0,u1,u2,u3,u4,d0,d1,d2,d3,d4,time,gan FROM bingocart WHERE uid='".$id."' ORDER BY id DESC LIMIT 0,1")->fetch();
$u1 = $es[0];
$u2 = $es[1];
$u3 = $es[2];
$u4 = $es[3];
$u5 = $es[4];
$d1 = $es[5];
$d2 = $es[6];
$d3 = $es[7];
$d4 = $es[8];
$d5 = $es[9];
$gan = $es[11];
///////////1
$pos1 = strpos($u1, "X");
if($pos1==true){
$car1 = str_replace("X","", $u1);
$uno1="<font color=\"white\">$car1</font>";
$c1="ff0000";
}else{
$uno1= "<b>$u1</b";
$c1="7deaf7";
}
///////////////////////////////  2
$pos2 = strpos($u2, "X");
if($pos2==true){
$car2 = str_replace("X","", $u2);

$uno2="<font color=\"white\">$car2</font>";
$c2="ff0000";
}else{
$uno2= "<b>$u2</b>";
$c2="86f77d";
}
///////////////////////////////  3
$pos3 = strpos($u3, "X");
if($pos3==true){
$car3 = str_replace("X","", $u3);
$uno3="<font color=\"white\">$car3</font>";
$c3="ff0000";
}else{
$uno3= "<b>$u3</b>";
$c3="7deaf7";
}
///////////////////////////////  4
$pos4 = strpos($u4, "X");
if($pos4==true){
$car4 = str_replace("X","", $u4);
$uno4="<font color=\"white\">$car4</font>";
$c4="ff0000";
}else{
$uno4= "<b>$u4</b>";
$c4="86f77d";
}
///////////////////////////////  5
$pos5 = strpos($u5, "X");
if($pos5==true){
$car5 = str_replace("X","", $u5);
$uno5="<font color=\"white\">$car5</font>";
$c5="ff0000";
}else{
$uno5= "<b>$u5</b>";
$c5="7deaf7";
}

///////////1
$posa1 = strpos($d1, "X");
if($posa1==true){
$cara1 = str_replace("X","", $d1);
$dos1="<font color=\"white\">$cara1</font>";
$e1="ff0000";
}else{
$dos1= "<b>$d1</b>";
$e1="86f77d";
}
///////////////////////////////  2
$posa2 = strpos($d2, "X");
if($posa2==true){
$cara2 = str_replace("X","", $d2);
$dos2="<font color=\"white\">$cara2</font>";
$e2="ff0000";
}else{
$dos2= "<b>$d2</b>";
$e2="7deaf7";
}
///////////////////////////////  3
$posa3 = strpos($d3, "X");
if($posa3==true){
$cara3 = str_replace("X","", $d3);
$dos3="<font color=\"white\">$cara3</font>";
$e3="ff0000";
}else{
$dos3= "<b>$d3</b>";
$e3="86f77d";
}
///////////////////////////////  4
$posa4 = strpos($d4, "X");
if($posa4==true){
$cara4 = str_replace("X","", $d4);
$dos4="<font color=\"white\">$cara4</font>";
$e4="ff0000";
}else{
$dos4= "<b>$d4</b>";
$e4="7deaf7";
}
///////////////////////////////  5
$posa5 = strpos($d5, "X");
if($posa5==true){
$cara5 = str_replace("X","", $d5);
$dos5="<font color=\"white\">$cara5</font>";
$e5="ff0000";
}else{
$dos5= "</b>$d5<b>";
$e5="86f77d";
}



?>Acertos: <b><?php echo $gan;?></b><br />
<table style="border-collapse: collapse;border: 1px solid black;text-align: center;vertical-align:center;">
<tr style="background-color: #00a2ff;"><td>
B</td><td>I</td><td>N</td><td>G</td><td>O
</td></tr><tr>
<td style="background-color: #<?php echo $c1;?>;width:40px;height:40px;border-collapse: collapse;border: 1px solid black;text-align: center;vertical-align:center;">
<?php echo $uno1;?></td>
<td style="background-color: #<?php echo $c2;?>;width:40px;height:40px;border-collapse: collapse;border: 1px solid black;text-align: center;vertical-align:center;">
<?php echo $uno2;?></td>
<td style="background-color: #<?php echo $c3;?>;width:40px;height:40px;border-collapse: collapse;border: 1px solid black;text-align: center;vertical-align:center;">
<?php echo $uno3;?></td>
<td style="background-color: #<?php echo $c4;?>;width:40px;height:40px;border-collapse: collapse;border: 1px solid black;text-align: center;vertical-align:center;">
<?php echo $uno4;?></td>
<td style="background-color: #<?php echo $c5;?>;width:40px;height:40px;border-collapse: collapse;border: 1px solid black;text-align: center;vertical-align:center;">
<?php echo $uno5;?>
</td></tr><tr>
<td style="background-color: #<?php echo $e1;?>;width:40px;height:40px;border-collapse: collapse;border: 1px solid black;text-align: center;vertical-align:center;">
<?php echo $dos1;?></td>
<td style="background-color: #<?php echo $e2;?>;width:40px;height:40px;border-collapse: collapse;border: 1px solid black;text-align: center;vertical-align:center;">
<?php echo $dos2;?></td>
<td style="background-color: #<?php echo $e3;?>;width:40px;height:40px;border-collapse: collapse;border: 1px solid black;text-align: center;vertical-align:center;">
<?php echo $dos3;?></td>
<td style="background-color: #<?php echo $e4;?>;width:40px;height:40px;border-collapse: collapse;border: 1px solid black;text-align: center;vertical-align:center;">
<?php echo $dos4;?></td>
<td style="background-color: #<?php echo $e5;?>;width:40px;height:40px;border-collapse: collapse;border: 1px solid black;text-align: center;vertical-align:center;">
<?php echo $dos5;?>
</td></tr></table>
<hr><?
$noi1 = $mistake->query("SELECT COUNT(*) FROM bingomos")->fetch();
$sql = "SELECT num FROM bingomos ORDER BY num";
$items = $mistake->query($sql);
echo "Numeros Sorteados:<br />";
if($noi1[0]>0){
while ($item = $items->fetch()){ 
echo"<b>$item[0]</b> - ";
}
}
}
else if($a=="activar"){ 
?>Coloque o preço em cartão:<br />
<form action="bingowap?a=activar2"method="post">
<input type="text" name="precio"/><br />
<input type="submit" value="ATIVAR"/></form><?
}
else if($a=="activar2"){
$precio = $_POST['precio'];
 $res = $mistake->query("UPDATE w_geral SET bingo='1' WHERE id='1'"); 
$mistake->query("UPDATE bingoconf SET precio='".$precio."' WHERE id='1'"); 
 echo "Activando...<meta http-equiv=\"refresh\" content=\"1; url=bingowap?a=menu\">";
} else if($a=="desactivar"){

 $res = $mistake->exec("UPDATE w_geral SET bingo='0' WHERE id='1'");
 echo "Activando...<meta http-equiv=\"refresh\" content=\"1; url=bingowap?a=menu\">";
}else if($a=="desactivarcar"){

 $res = $mistake->exec("UPDATE bingoconf SET carton='1' WHERE id='1'");
 echo "desactivando venta...<meta http-equiv=\"refresh\" content=\"1; url=bingowap?a=menu\">";
}else if($a=="activarcar"){

 $res = $mistake->query("UPDATE bingoconf SET carton='0' WHERE id='1'");
 echo "desactivando venta...<meta http-equiv=\"refresh\" content=\"1; url=bingowap?a=menu\">";
}else if($a=="cartones"){


  
echo "<center>Cartones</center>"; 
if($pag=="" || $pag<=0)$pag=1;
$noi = $mistake->query("SELECT COUNT(*) FROM bingocart WHERE gan>='0'")->fetch();
$num_items = $noi[0]; //changable
$items_per_page= 20;
$num_pages = ceil($num_items/$items_per_page);
if(($pag>$num_pages)&&$pag!=1)$pag= $num_pages;
$limit_start = ($pag-1)*$items_per_page;
$sql = "SELECT id, uid, gan, time FROM bingocart ORDER BY gan DESC LIMIT $limit_start, $items_per_page";
$cor = "<div id=\"div1\">"; 
$nick= gerarnome($meuid);
if($noi[0]>0)
{
$items = $mistake->query($sql);
$cor = "<div id=\"div1\">"; 
while ($item = $items->fetch()){   
$part = $item[0];
if ($cor == "<div id=\"div1\">"){
$cor = "<div id=\"div2\">";
}else{
$cor = "<div id=\"div1\">";
}
$fes = date("d/m/y-H:i:s",$item[3]);
echo"$cor<a href=\"bingowap?a=controlar&id=$item[1]\">".gerarnome($item[1]).": $item[2] aciertos($fes)</a></div>";
}
}
echo "<p align=\"center\"><b>Paginas:</b><br>";
if($pag>1)
{
$ppage = $pag-1;
echo "<a href=\"bingowap?a=cartones&amp;pag=1\" class=\"small button blue\">[&laquo;]</a>";
echo "<a href=\"bingowap?a=cartones&amp;pag=$ppage\" class=\"small button blue\">[$ppage]</a>";
}
echo"<font class=\"small button blue\">[$pag]</font>";
if($pag<$num_pages)
{
$npage = $pag+1;
echo "<a href=\"bingowap?a=cartones&amp;pag=$npage\" class=\"small button blue\">[$npage]</a>";
}
if($pag<$num_pages)
{
$xpage = $pag+10;
echo "<a href=\"bingowap?a=cartones&amp;pag=$xpage\" class=\"small button blue\">[+10]</a>";
echo "<a href=\"bingowap?a=cartones&amp;pag=$num_pages\" class=\"small button blue\">[&raquo;]</a>";
}
}
/////////////////////////////////////////////////////////////////
if($a=="comprar2"){   

 if(perm($uid)==0){
 echo "<br />Você já tem um cartão de bingo<br />";
   echo"<a href=\"bingowap?a=menu\">Mebu Bingo</a><br />";

 
 }else{
 $bi = $mistake->query("SELECT carton FROM bingoconf WHERE id='1'")->fetch();
 if($bi[0]==1){
 
 echo "<br />Ya inicio el bingo y no se venden cartones<br />";
 
 }else{
 $array1 = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25);
$array2 = array(26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50);
//$array3 = array();
 
//desordeno el array y lo muestro
$vali1 = shuffle($array1);
$vali2 = shuffle($array2);
$vali3 = shuffle($array3);
$nue1 = array($array1[0],$array1[1],$array1[2],$array1[3],$array1[4]);
$nue2 = array($array2[0],$array2[1],$array2[2],$array2[3],$array2[4]);
//$nue3 = array($array3[0],$array3[1],$array3[2],$array3[3],$array3[4]);    
  $precio = $mistake->query("SELECT precio FROM bingoconf WHERE id='1'")->fetch();
?>
<form action="bingowap?a=guardar2"method="post">
<table border="1"><tr><?
sort($nue1); 
foreach ($nue1 as $key1 => $val1) { 
?><td><input type="hidden" name="uno<?php echo $key1;?>" value="<?php echo $val1;?>"><b>?</b></td><?
}
?></tr><tr><?
sort($nue2); 
foreach ($nue2 as $key2 => $val2) { 
?><td><input type="hidden" name="dos<?php echo $key2;?>" value="<?php echo $val2;?>"><b>?</b></td><? 
}
?></tr></table>
Id de usuario:<input type="text" name="who" size="4"/><br />
<input type="submit" value="ASINAR"/></form><?
}
}
}
/////////////////////////////////////////////////////////////////
else if($a=="guardar2"){
$who = $_POST['who'];
 $ss = $mistake->query("SELECT COUNT(*) FROM bingocart WHERE uid='".$who."'")->fetch();
 if($ss[0]>0){
 echo "<br />El usuario ya tiene un carton de bingo<br />";
   echo"<a href=\"bingowap?a=menu\">Menu Bingo</a><br />";

 
 }else{



$uno0 = $_POST['uno0'];
$uno1 = $_POST['uno1'];
$uno2 = $_POST['uno2'];
$uno3 = $_POST['uno3'];
$uno4 = $_POST['uno4'];

$dos0 = $_POST['dos0'];
$dos1 = $_POST['dos1'];
$dos2 = $_POST['dos2'];
$dos3 = $_POST['dos3'];
$dos4 = $_POST['dos4'];
/*
$tres0 = anti_injection($_POST['tres0']);
$tres1 = anti_injection($_POST['tres1']);
$tres2 = anti_injection($_POST['tres2']);
$tres3 = anti_injection($_POST['tres3']);
$tres4 = anti_injection($_POST['tres4']);
*/

$res = $mistake->exec("INSERT INTO bingocart SET uid='".$who."',u0='".$uno0."',u1='".$uno1."',u2='".$uno2."',u3='".$uno3."',u4='".$uno4."',d0='".$dos0."',d1='".$dos1."',d2='".$dos2."',d3='".$dos3."',d4='".$dos4."',time='".time()."'");
if($res){

$msj="Você acaba de receber um cartão de bingo para o próximo sorteio, cosulta com o pessoal quando for o próximo, aqui está o seu cartão -->[link=bingowap?a=micarton]Meu cartão[/link].";
$mistake->exec("INSERT INTO w_msgs (txt,pr,ld) values('".$msj."','$who','".time()."','0')");

$mistake->exec("INSERT INTO w_msgs (txt,pr,ld) values('$meuid','".$_POST['ami']."')");
$idj = $mistake->query("SELECT id FROM w_msgs WHERE id='$meuid' order by id desc limit 1")->fetch();
$msg = "Você acaba de receber um cartão de bingo para o próximo sorteio, cosulta com o pessoal quando for o próximo, aqui está o seu cartão -->[link=bingowap?a=micarton]Meu cartão[/link].";
automsg($msg,$meuid,$_POST['ami']);

?>Cartão atribuído:<br />
<table style="border-collapse: collapse;border: 1px solid black;text-align: center;vertical-align:center;">
<tr style="background-color: #00a2ff;"><td>
B</td><td>I</td><td>N</td><td>G</td><td>O
</td></tr><tr>
<td style="background-color: #7deaf7;width:30px;height:30px;border-collapse: collapse;border: 1px solid black;text-align: center;vertical-align:center;">
<?php echo $uno0;?></td>
<td style="background-color: #86f77d;width:30px;height:30px;border-collapse: collapse;border: 1px solid black;text-align: center;vertical-align:center;"><?php echo $uno1;?></td>
<td style="background-color: #7deaf7;width:30px;height:30px;border-collapse: collapse;border: 1px solid black;text-align: center;vertical-align:center;"><?php echo $uno2;?></td>
<td style="background-color: #86f77d;width:30px;height:30px;border-collapse: collapse;border: 1px solid black;text-align: center;vertical-align:center;"><?php echo $uno3;?></td>
<td style="background-color: #7deaf7;width:30px;height:30px;border-collapse: collapse;border: 1px solid black;text-align: center;vertical-align:center;"><?php echo $uno4;?>
</td></tr><tr>
<td style="background-color: #86f77d;width:30px;height:30px;border-collapse: collapse;border: 1px solid black;text-align: center;vertical-align:center;">
<?php echo $dos0;?></td>
<td style="background-color: #7deaf7;width:30px;height:30px;border-collapse: collapse;border: 1px solid black;text-align: center;vertical-align:center;"><?php echo $dos1;?></td>
<td style="background-color: #86f77d;width:30px;height:30px;border-collapse: collapse;border: 1px solid black;text-align: center;vertical-align:center;"><?php echo $dos2;?></td>
<td style="background-color: #7deaf7;width:30px;height:30px;border-collapse: collapse;border: 1px solid black;text-align: center;vertical-align:center;"><?php echo $dos3;?></td>
<td style="background-color: #86f77d;width:30px;height:30px;border-collapse: collapse;border: 1px solid black;text-align: center;vertical-align:center;"><?php echo $dos4;?>
</td></tr></table><?

}
}}
if($a!="menu"){
}
/////////////////fim////////////////////////
echo "<center><a href='home'>$imginicio Página principal</a></center></p>";
echo rodape();
?>

</body>
</html>