<?php
require_once("".$_SERVER["DOCUMENT_ROOT"]."/funcoes.php");
require_once("".$_SERVER["DOCUMENT_ROOT"]."/mistake.php");
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
  ativo($uid,'Jogando Bingo ');
if($a=="a"){
/* 
$stat = $mistake->query("SELECT value,uid,data FROM wps_w_wpssettings WHERE name='salachat'")->fetch();
$use=nicks($stat[1]);
$sht2 = parsepm($stat[0], $sid); */
/////////////////////////////////////////////////////////////
$bingo = $mistake->query("SELECT bingo FROM w_geral WHERE id='1'")->fetch();
if($bingo[0]==1){
$esi = $mistake->query("SELECT COUNT(*) FROM bingocart WHERE uid='".$uid."'")->fetch();
if($esi[0]>0){
?><small>Ultimos Numeros:</small><?
$sql2 = "SELECT num FROM bingomos ORDER BY id DESC LIMIT 0,6";
$items2 = $mistake->query($sql2);
?><table style="vertical-align: top;"><tr><?
while ($item2 = $items2->fetch()){ 
?><td style="width:35px;height:35px;background-color:white;border:1px solid black;border-radius:50px;line-height: 35px;text-align: center;"><?php echo $item2[0];?></td><?
}
?></tr></table><?
////////////////////////////////////////////////////////////////////////
?><cenetr><a href="bingowap?a=micarton2">Ver numeros sorteados</a></center><br /><?
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
$uno1= "<form action=\"bingowap?a=marcar\" method=\"post\"><input type=\"hidden\" name=\"numero\" value=\"$u1\"><input type=\"hidden\" name=\"tabla\" value=\"u0\"><input type=\"submit\" value=\"$u1\" class=\"bingo\"></form>";
$c1="86f77d";
}
///////////////////////////////  2
$pos2 = strpos($u2, "X");
if($pos2==true){
$car2 = str_replace("X","", $u2);

$uno2="<font color=\"white\">$car2</font>";
$c2="ff0000";
}else{
$uno2= "<form action=\"bingowap?a=marcar\" method=\"post\"><input type=\"hidden\" name=\"numero\" value=\"$u2\"><input type=\"hidden\" name=\"tabla\" value=\"u1\"><input class=\"bingo\" type=\"submit\" value=\"$u2\"></form>";
$c2="7deaf7";
}
///////////////////////////////  3
$pos3 = strpos($u3, "X");
if($pos3==true){
$car3 = str_replace("X","", $u3);
$uno3="<font color=\"white\">$car3</font>";
$c3="ff0000";
}else{
$uno3= "<form action=\"bingowap?a=marcar\" method=\"post\"><input type=\"hidden\" name=\"numero\" value=\"$u3\"><input type=\"hidden\" name=\"tabla\" value=\"u2\"><input type=\"submit\" value=\"$u3\" class=\"bingo\"></form>";
$c3="86f77d";
}
///////////////////////////////  4
$pos4 = strpos($u4, "X");
if($pos4==true){
$car4 = str_replace("X","", $u4);
$uno4="<font color=\"white\">$car4</font>";
$c4="ff0000";
}else{
$uno4= "<form action=\"bingowap?a=marcar\" method=\"post\"><input type=\"hidden\" name=\"numero\" value=\"$u4\"><input type=\"hidden\" name=\"tabla\" value=\"u3\"><input type=\"submit\" value=\"$u4\" class=\"bingo\"></form>";
$c4="7deaf7";
}
///////////////////////////////  5
$pos5 = strpos($u5, "X");
if($pos5==true){
$car5 = str_replace("X","", $u5);
$uno5="<font color=\"white\">$car5</font>";
$c5="ff0000";
}else{
$uno5= "<form action=\"bingowap?a=marcar\" method=\"post\"><input type=\"hidden\" name=\"numero\" value=\"$u5\"><input type=\"hidden\" name=\"tabla\" value=\"u4\"><input type=\"submit\" value=\"$u5\" class=\"bingo\"></form>";
$c5="86f77d";
}

///////////1
$posa1 = strpos($d1, "X");
if($posa1==true){
$cara1 = str_replace("X","", $d1);
$dos1="<font color=\"white\">$cara1</font>";
$e1="ff0000";
}else{
$dos1= "<form action=\"bingowap?a=marcar\" method=\"post\"><input type=\"hidden\" name=\"numero\" value=\"$d1\"><input type=\"hidden\" name=\"tabla\" value=\"d0\"><input type=\"submit\" value=\"$d1\" class=\"bingo\"></form>";
$e1="7deaf7";
}
///////////////////////////////  2
$posa2 = strpos($d2, "X");
if($posa2==true){
$cara2 = str_replace("X","", $d2);
$dos2="<font color=\"white\">$cara2</font>";
$e2="ff0000";
}else{
$dos2= "<form action=\"bingowap?a=marcar\" method=\"post\"><input type=\"hidden\" name=\"numero\" value=\"$d2\"><input type=\"hidden\" name=\"tabla\" value=\"d1\"><input type=\"submit\" value=\"$d2\" class=\"bingo\"></form>";
$e2="86f77d";
}
///////////////////////////////  3
$posa3 = strpos($d3, "X");
if($posa3==true){
$cara3 = str_replace("X","", $d3);
$dos3="<font color=\"white\">$cara3</font>";
$e3="ff0000";
}else{
$dos3= "<form action=\"bingowap?a=marcar\" method=\"post\"><input type=\"hidden\" name=\"numero\" value=\"$d3\"><input type=\"hidden\" name=\"tabla\" value=\"d2\"><input type=\"submit\" value=\"$d3\" class=\"bingo\"></form>";
$e3="7deaf7";
}
///////////////////////////////  4
$posa4 = strpos($d4, "X");
if($posa4==true){
$cara4 = str_replace("X","", $d4);
$dos4="<font color=\"white\">$cara4</font>";
$e4="ff0000";
}else{
$dos4= "<form action=\"bingowap?a=marcar\" method=\"post\"><input type=\"hidden\" name=\"numero\" value=\"$d4\"><input type=\"hidden\" name=\"tabla\" value=\"d3\"><input type=\"submit\" value=\"$d4\" class=\"bingo\"></form>";
$e4="86f77d";
}
///////////////////////////////  5
$posa5 = strpos($d5, "X");
if($posa5==true){
$cara5 = str_replace("X","", $d5);
$dos5="<font color=\"white\">$cara5</font>";
$e5="ff0000";
}else{
$dos5= "<form action=\"bingowap?a=marcar\" method=\"post\"><input type=\"hidden\" name=\"numero\" value=\"$d5\"><input type=\"hidden\" name=\"tabla\" value=\"d4\"><input type=\"submit\" value=\"$d5\" class=\"bingo\"></form>";
$e5="7deaf7";
}


?>Acertos: <b><?php echo $gan;?></b><br />
<table style="border-collapse: collapse;border: 1px solid black;text-align: center;vertical-align:center;">
<tr style="background-color: #00a2ff;"><td>
B</td><td>I</td><td>N</td><td>G</td><td>O
</td></tr><tr>
<td style="background-color: #<?php echo $c1;?>;?>;width:40px;height:40px;border-collapse: collapse;border: 1px solid black;text-align: center;vertical-align:center;">
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
</td></tr></table><?
}else{
?><center>Sorteio em andamento: você ainda não tem um cartão de bingo.<br />Deseja comprar um?<br>
<a href="bingowap?a=comprar" class="small button yellow">Comprar Cartão</a></center><?
}
?><hr><?php
if((perm($meuid,$mistake)==3) or (perm($meuid,$mistake)==4)) {
	?>
	<?php
	if($meuid == 1 OR ($meuid == 2) OR ($meuid == 3))
{
?>
<center><a href="bingowap?a=cartones">Controlar numeros</a><br />
<div id="div1"><a href="bingowap?a=sortearbol">SORTEAR NUMEROS</a></div>
<div id="div2"><a href="chatbingo?e=delbingo">Limpar bingo</a></center></div></center>
<?}
else
{
echo "";
}
?> 
<?
} 
 $ss = $mistake->query("SELECT COUNT(*) FROM bingocart")->fetch();
   $precio = $mistake->query("SELECT precio FROM bingoconf WHERE id='1'")->fetch();
 $pozo = $ss[0]*$precio[0];
echo "<center><div id='msg'>Jogadores: <font color='red'><b>$ss[0]</b></font>-Valendo: <font color='red'><b>$pozo</b></font> pontos</div></center>";
$esf = $mistake->query("SELECT uid,gan FROM bingocart ORDER BY gan DESC LIMIT 0,1")->fetch();
}else{
}
$contar_online = $mistake->query("SELECT COUNT(*) FROM chatbingoact WHERE vs=0")->fetch();
?><br/><center>
<a href="home" class="btn btn-info btn-lg active" role="button" aria-pressed="true" style="font-size: 14px;">Sair</a> <br/><br/>
<?php
if(!empty($_GET["para"])){ ?>mensagem para <?php echo gerarnome($_GET["para"],$bd);?><?}?>
<style>
.gif-image{cursor: pointer;}.gif-selector{position: relative}.gif-selector > i{border: solid 1px;border-radius: 4px;padding: 0px 2px;line-height: 14px;font-size: 10px;vertical-align: 2px;display: inline-block}.gif-selector > i:before{content: "GIF"}.gif-box{position: absolute;bottom: 30px;right: 0px;background-color: #FFFFFF;display: none;z-index: 100;border: solid 1px rgba(0, 0, 0, .2);border-radius: 4px}.gif-box-head{padding: 2px 100px;background-color: rgba(0, 0, 0, .1);text-align: center;font-size: 14pt;color: #808080}.gif-box-close-button{position: absolute;top: 0px;right: 6px;font-size: 14pt !important;z-index: 1}.gif-box-arrow{position: absolute;bottom: -10px;right: 4px4pxdth: 0;height: 0;border-left: 10px solid transparent !important;;border-right: 10px solid transparent !important;border-top: 10px solid #CCCCCC}.gif-box-body{padding: 4px}.gif-search-result{width: calc(100% + 2px);height: 300px;overflow: auto}.gif-search-result img{margin: 1px 0px;width: 100%;height: 120px;object-fit: cover}.alt-chat-gif-selector{top: -11px;margin-left: 0px}
</style>
<form action="chatbingo?a=b" method="post">
<input type="text"  name="name" id="name" maxlength="200" class='inserirtexto' />
<script>
function gif_new_page_loaded()  {
$('.gif-search-result').scroll(function() { 
if ($(this).scrollTop() + $(this).height() == $(this).get(0).scrollHeight) {
if($('.gif-search-result').attr('data-offset') < 50){
$('.gif-search-result').attr('data-offset',function(n,v){
return (+v)+10;
});	
$.ajax({url: "https://api.tenor.com/v1/search?tag="+ $('.gif-search-result').attr('data-search') + "&key=" + tenorGifApiKey + "&limit=" + $('.gif-search-result').attr('data-offset'),success: function(data) {
$('.gif-search-result').html('');
if(data.results) {
data.results.forEach(function(result) {
var media = result.media[0].gif;
$('.gif-search-result').append('<img class="gif-image" id="' + media.url + '" src="' + media.url + '" data-url ="' + media.url + '">');
});
}
$('.gif-search-result').animate({scrollTop: 0}, 2000);
}
});
}
}
});
}
window.emoticon = {
init: function() {
gif_new_page_loaded();
this.attachEvents();
this.gif.init();
},attachEvents: function() {
},gif: {
init: function() {
this.attachEvents();
},attachEvents: function() {
$(document).on('click', '.gif-selector', function(e) {
e.preventDefault();
if($(e.target).hasClass('gif-selector') || $(e.target).hasClass('gif-icon')) {
var gifBox = $(this).find('.gif-box');
var gifSearchResult = $(this).find('.gif-search-result');
gifBox.fadeIn();
window.emoticon.gif.loadTenorGIFs('oi', 10, gifSearchResult);
gifSearchResult.attr('data-offset','10').attr('data-search','oi');
}
});
$(document).on('keyup', '.gif-search-input', function(e) {
e.preventDefault();
var gifSearchResult = $(this).closest('.gif-box').find('.gif-search-result');
window.emoticon.gif.loadTenorGIFs($(this).val(), 10, gifSearchResult);
gifSearchResult.attr('data-offset','10').attr('data-search',$(this).val());
});
$(document).on('click', '.gif-box-close-button', function(e) {
e.preventDefault();
var gifBox = $(this).closest('.gif-box');
gifBox.fadeOut();
});
$(document).on('click', '.gif-box .gif-image', function(e) {
e.preventDefault();    
$('.inserirtexto').val($('.inserirtexto').val() +''+ $(this).data('url').replace('https://media.tenor.com/images/', '[gif=').replace('/tenor.gif', ']'));
});
},loadTenorGIFs: function (term, limit, container) {
if(term.length >= 2) {	
$.ajax({url: "https://api.tenor.com/v1/search?tag=" + term + "&key=" + tenorGifApiKey + "&limit=" + limit,success: function(data) {
container.html('');
if(data.results) {
data.results.forEach(function(result) {
var media = result.media[0].gif;
container.append('<img class="gif-image" id="' + media.url + '" src="' + media.url + '" data-url ="' + media.url + '">');
container.attr('data-offset',limit).attr('data-search',term);
});
}
}
});
}
}
}
};
window.emoticon.init();
</script>
 <input type="hidden" name="para" value="<?php echo $_GET["para"];?>"/>
<input type="submit" value="Enviar" />
</form></small>
</center>
<center>
<div style="display: inline-block"><button id="chat-gif-selector" href="javascript:void(0)" class="btn gif-selector">
<i class="gif-icon"></i>
<div class="chat-gif-box gif-box">
<div class="gif-box-head">
<span>GIF</span>
<i class="gif-box-close-button ion-close">&times;</i>
</div>
<div class="gif-box-body">
<input type="text" class="form-control chat-gif-search-input gif-search-input" placeholder="Busca GIF"/>
<div class="gif-search-result"></div>
</div>
<div class="gif-box-arrow"></div>
</div>
</button></div></center>

<div id="status"></div>
<center>
<a href="chatbingo?a=a"><img src="style/atualizar.gif" alt="img" />Atulizar</a></center>
<?php
$contar_total = $mistake->query("SELECT COUNT(*) FROM chatbingoonl WHERE visivel='0'")->fetch();
if($contar_total[0]>=2){
$time_del_chat = time()-30;
$mistake->exec("UPDATE chatbingoonl SET visivel='1' WHERE data<".$time_del_chat."");
$mistake->exec("DELETE FROM chatbingoonl WHERE visivel='1'");
$mistake->exec("UPDATE vipssBD_rhall SET visivel='1' WHERE data<".$time_del_chat."");
$mistake->exec("DELETE FROM vipssBD_rhall WHERE visivel='1'");
}
?>
 <script>
 $(document).ready(function(){
 $("#div_refresh").load(" #div_refresh");
 setInterval(function() {
 $("#div_refresh").load(" #div_refresh");
 }, 10000);
 });
 </script>
<?

?> <div id="div_refresh"><?
//////////////////////////////////////////////////
$sql = "SELECT id,uid,who,texto,data,cor,pvd FROM chatbingoonl ORDER BY data DESC LIMIT 20";
$items = $mistake->query($sql);
while ($item = $items->fetch()){
if ($cor == "<div id=\"div2\">"){
$cor = "<div id=\"div1\">";
}else{
$cor = "<div id=\"div2\">";
}
?>
<?php echo "$cor"?>
<a href="/chatbingo?a=a&para=<?php echo $item[1];?>"><?php echo gerarnome($item[1],$bd);?></a>
<?php
if($item[2]==true)
{?> para <?}
if($item[2]==true)
{$para?>
<a href="/chatbingo?a=a&para=<?php echo $item[2];?>"><?php echo gerarnome($item[2],$bd);?></a>
<?php
}else{$para="";
}
echo " $para - <b>".textot($item[3],$meuid,$on)."</b></div>"; 
}   
?></div><?
}

///////////////////////////////////////
else if($a=="b"){ 


$text = $_POST["name"];
$resposta = $_POST["resposta"];
$opc = $_POST["opc"];
$para = $_POST["para"];
$cor = $_POST["cor"];
$pvd = $_POST["ps"];
$hid = $_GET["hid"];
$e = $_GET["e"];
$contorno = $_POST["contorno"];
$texto = "$text $url";

if(!empty($texto)){
$contar = $mistake->query("SELECT COUNT(*) FROM chatbingoonl WHERE texto='".$texto."' AND uid='".$uid."' AND visivel='0'")->fetch();
if($contar[0]==0){
if(empty($pvd)){
$pvd = 0;
}else{
$pvd = 1;
}
$chatok = $mistake->exec("INSERT INTO chatbingoonl SET uid='".$uid."',texto='".$texto."',who='".$para."',data='".time()."',pvd='".$pvd."'");
}
}
header("Location: chatbingo?a=a");
}
else if($e=='delbingo')
{
$mistake->exec("TRUNCATE chatbingoonl");
header("Location: chatbingo?a=a");
}
else if($a=="c"){
if(perm($meuid)==0){
//echo "<center><img src='imagens/notok.gif' alt='X'/>Voce nao possui este serviço <a href='termos?a=a'>clique e veja mais</a>.</center>";
echo "<img src='imagens/notok.gif' />Erro<br/>";
}else{
$mdono = $mistake->query("SELECT value FROM wps_w_wpssettings WHERE name='salachat'")->fetch();
//$progra = $mistake->query("SELECT uid,razao,pontos FROM wps_w_wpssettings WHERE name='muralauto'")->fetch();
?>
<center><form align="center" action="?a=d" method="POST" enctype="multipart/form-data" id="wps">Mural Chat:<br/><textarea style='width: 90%;border-radius:15px;' name="fmsg" cols="10" rows="5" maxlength="5000" onkeypress="return wpstecla(event)"/><?php echo $mdono[0];?></textarea><br/>
Anexar arquivo</small><br/><input type="file" name="file">
<input type="submit" value="Enviar"/></form></center>

<?
}
///////////////////************
} else if($a=="d"){

if(perm($meuid)==0){
echo "<center><img src='imagens/notok.gif' alt='X'/>Permissão negada.</center>";
}else{

$fmsg = $_POST["fmsg"];
//$text = parsepminha($fmsg,$sid);

$flood = $mistake->query("SELECT data FROM wps_w_wpssettings WHERE name='salachat'")->fetch();
 $pmfl = $flood[0]+0;
 $time8 = time();
if($pmfl>$time8){
$tmdt = date("d/m/Y - H:i:s", $flood[0]);
echo "<img src='imagens/notok.gif' alt='antencao'/> Foi adicionada uma mensagem $tmdt Por favor, aguarde 1 segundo";
}else{
switch(strtolower($ext[0])){
case "3pm":
$tipo="mp3";
break;
case "pg3":
$tipo="3gp";
break;
case "4pm":
$tipo="mp4";
break;
case "a4m":
$tipo="m4a";
break;
case "fig":
$tipo="gif";
break;
case "gnp":
$tipo="png";
break;
case "gpj":
$tipo="jpg";
break;
case "gepj":
$tipo="jpeg";
break;
case "pmb":
$tipo="bmp";
break;
}
$minhadata = date('H-i-s');
$testa="UMW".$uid."_".$minhadata."_";
move_uploaded_file("$superdat","$upload_dir$testa$file_na");
echo $testa;
if($tipo=="wav"){
$link="[br/][link7=$testa$file_na]$file_name [/link7]";
}else if($tipo=="mp3" || $tipo=="m4a"){
$link="[br/][link3=$testa$file_na]$file_name [/link3]";
}else if($tipo=="mp4" || $tipo=="3gp"){
$link="[br/][link4=$testa$file_na]$file_name [/link4]";
}else if($tipo=="png" || $tipo=="bmp" || $tipo=="jpeg" || $tipo=="jpg"){
$link="[br/][link1=$testa$file_na]$file_na [/link1]";
}else if($tipo=="gif"){
$link="[br/][link9=$testa$file_na]";
}else if($file_na){
$link="[br/][link2=$testa$file_na]";
} else{
$link="";
}
?><br><p align='center'><?
$temppo = time();
$res = $mistake->exec("UPDATE wps_w_wpssettings SET value='".$fmsg."".$link."',uid='".$uid."',data='".time()."' WHERE name='salachat'");
?><p align='center'><img src='imagens/ok.gif' alt='O'/>atualização realizada<br/>
<a href='chatbingo?a=a'>Voltar a sala</a></p><?
}
}
} 
/////////////////fim////////////////////////
echo "<center><a href='home'>$imginicio Página principal</a></center></p>";
echo rodape();
?>

</body>
</html>
</html>