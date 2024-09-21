<?php
///verificar meuid
if($meuid!=0){
///caca ao rato
$pegarato = $mistake->query("SELECT rato, bruxa, pascoa, ladrao FROM w_usuarios WHERE id='$meuid'")->fetch();
if($pegarato[0]==1){
$sorte=rand(100,200);
if($sorte=='173'){
$_SESSION['temporato'] = time();
?>
<br/><center><a href="/rato?a=capturar"><img src="/imgs/rato1.gif"></a></center><br/>
<?php
$sorte = '0';
 }else if($sorte=='188'){ 
$_SESSION['temporato'] = time();
?>
<br/><center><a href="/rato?a=capturar"><img src="/imgs/raton1.gif"></a></center><br/>
<?php
$sorte2 = '0';
 } }
///caca ovo de pascoa 
if($pegarato[2]==1){
$sorte3=rand(0,100);
if($sorte3=='23'){
$_SESSION['tempopascoa'] = time();
?>
<br/><center><a href="/pascoa?a=capturar"><img src="/imgs/pascoa1.png"></a></center><br/>
<?php
$sorte3 = '0';
}else if($sorte3=='66'){ 
$_SESSION['tempopascoa'] = time();
?>
<br/><center><a href="/pascoa?a=capturar"><img src="/imgs/pascoa2.png"></a></center><br/>
<?php
$sorte = '0';
 } }
 ////caca as bruxas
if($pegarato[1]==1){
$sorte2=rand(100,200);
if($sorte2=='137'){
$_SESSION['tempobruxa'] = time();
?>
<br/><center><a href="/bruxa?a=capturar"><img src="/imgs/bruxa1.gif"></a></center><br/>
<?php
$sorte2 = '0';
}else if($sorte2=='172'){ 
$_SESSION['tempobruxa'] = time();
?>
<br/><center><a href="/bruxa?a=capturar"><img src="/imgs/bruxa2.gif"></a></center><br/>
<?php
$sorte = '0';
 } }
 ////caca aoladrao
if($pegarato[1]==1){
$sorte4=rand(100,200);
if($sorte4=='137'){
$_SESSION['tempoladrao'] = time();
?>
<br/><center><a href="/ladrao?a=capturar"><img src="/imgs/ladrao1.gif"></a></center><br/>
<?php
$sorte4 = '0';
}else if($sorte4=='172'){ 
$_SESSION['tempoladrao'] = time();
?>
<br/><center><a href="/ladrao?a=capturar"><img src="/imgs/ladron.gif"></a></center><br/>
<?php
$sorte = '0';
 } }
 ////caca ao coronavirus
if($pegarato[1]==1){
$sorte5=rand(100,200);
if($sorte5=='137'){
$_SESSION['tempocoronavirus'] = time();
?>
<br/><center><a href="/coronavirus?a=capturar"><img src="/imgs/corona.gif"></a></center><br/>
<?php
$sorte5 = '0';
}else if($sorte5=='172'){ 
$_SESSION['tempocoronavirus'] = time();
?>
<br/><center><a href="/coronavirus?a=capturar"><img src="/imgs/corona1.jpg"></a></center><br/>
<?php
$sorte5 = '0';
}else if($sorte5=='172'){ 
$_SESSION['tempocoronavirus'] = time();
?>
<br/><center><a href="/coronavirus?a=capturar"><img src="/imgs/corona2.gif"></a></center><br/>
<?php
}}}
?>
<?php
if($testearray[29]==1){
$timeout = time() - 55;
$sql = "SELECT id FROM twd WHERE time<'".$timeout."' AND uid='".$meuid."'";
$items = $mistake->prepare($sql);
$items->execute();
if($items->rowCount()>0){
while ($item = $items->fetch()){
$mistake->exec("DELETE FROM twd WHERE id='".$item[0]."'");
}
}
$twd_img[] = "twd/1.gif";
$twd_img[] = "twd/2.gif";
$twd_img[] = "twd/3.gif";
$twd_img[] = "twd/4.gif";
$twd_img[] = "twd/5.gif";
$twd_img[] = "twd/6.gif";
$twd_img[] = "twd/7.gif";
$twd_img1[] = "twd/8.gif";
$twd_img1[] = "twd/9.gif";
$twd_img1[] = "twd/10.gif";
$twd_img1[] = "twd/11.gif";
$twd_img1[] = "twd/12.gif";
$twd_img2[] = "twd/13.gif";
$twd_img2[] = "twd/14.gif";
$twd_img2[] = "twd/15.gif";
$escolhido = rand(1, 1000);
$conta = $mistake->query("SELECT COUNT(*) FROM twd WHERE uid='".$meuid."'")->fetch();
if($conta[0]>0){
}else{
if($escolhido>100){
echo "";
} else if ($escolhido<5){
$rando = rand(1,50);
if ($rando>=3){
$mistake->exec("INSERT INTO twd SET uid='".$meuid."', walker='twd/zombie.gif', tipo='zombie', time='".time()."'");
$id_item = $mistake->query("SELECT id FROM twd WHERE uid='".$meuid."'")->fetch();
echo "<center><a href='/walking/matar/".$id_item[0]."'><img src='/twd/zombie.gif'></a><br /></center>";
}else{
$mistake->exec("INSERT INTO twd SET uid='".$meuid."', walker='".$twd_img2[$rando]."', tipo='lider', time='".time()."'");
$id_item = $mistake->query("SELECT id FROM twd WHERE uid='".$meuid."' AND walker='".$twd_img2[$rando]."'")->fetch();
echo "<center><a href='/walking/matar/".$id_item[0]."'><img src='/twd/zombie.gif'></a><br /></center>";
}
} else if ($escolhido<21 AND $escolhido>5 ){
$rando = rand(1,60);
if ($rando>=5){
$mistake->exec("INSERT INTO twd SET uid='".$meuid."', walker='twd/zombie.gif', tipo='zombie', time='".time()."'");
$id_item = $mistake->query("SELECT id FROM twd WHERE uid='".$meuid."'")->fetch();
echo "<center><a href='/walking/matar/".$id_item[0]."'><img src='/twd/zombie.gif'></a><br /></center>";
}else{
$mistake->exec("INSERT INTO twd SET uid='".$meuid."', walker='".$twd_img1[$rando]."', tipo='segundos', time='".time()."'");
$id_item = $mistake->query("SELECT id FROM twd WHERE uid='".$meuid."' AND walker='".$twd_img1[$rando]."'")->fetch();
echo "<center><a href='/walking/matar/".$id_item[0]."'><img src='/twd/zombie.gif'></a><br /></center>";
}  
}else if ($escolhido<61 AND $escolhido>20 ){
$rando = rand(1,80);
if ($rando>=7){
$mistake->exec("INSERT INTO twd SET uid='".$meuid."', walker='twd/zombie.gif', tipo='zombie', time='".time()."'");
$id_item = $mistake->query("SELECT id FROM twd WHERE uid='".$meuid."'")->fetch();
echo "<center><a href='/walking/matar/".$id_item[0]."'><img src='/twd/zombie.gif'></a><br /></center>";
}else{
$mistake->exec("INSERT INTO twd SET uid='".$meuid."', walker='".$twd_img[$rando]."', tipo='participantes', time='".time()."'");
$id_item = $mistake->query("SELECT id FROM twd WHERE uid='".$meuid."' AND walker='".$twd_img[$rando]."'")->fetch();
echo "<center><a href='/walking/matar/".$id_item[0]."'><img src='/twd/zombie.gif'></a><br /></center>";
}  
} else{
$mistake->exec("INSERT INTO twd SET uid='".$meuid."', walker='twd/zombie.gif', tipo='zombie', time='".time()."'");
$id_item = $mistake->query("SELECT id FROM twd WHERE uid='".$meuid."'")->fetch();
echo "<center><a href='/walking/matar/".$id_item[0]."'><img src='/twd/zombie.gif'></a><br /></center>";
}  
}}
?>
</body>