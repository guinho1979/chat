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
$page=$pag;
$uid=$meuid;
	////////termina atalho
 echo "<div id='titulo'>Boliche</div>";
if($a == "menu"){
$uPt =  $mistake->query("SELECT pt FROM w_usuarios WHERE id='".$uid."'")->fetch();
$cost = 10; 
?><center>Seus pontos: <?php echo $uPt[0];?><br/>
<img src="juegos/boliche/bolos1.gif"" alt="*"><br/> <br />
<div id='div1'><center><a href='?a=tirar&t='.time().'&id='.$uid.'">JOGAR</a></center></div><br />
<div id='div2'><center><img src='imagens/aposta_link.png' alt='*'/><a href='?a=top'>Tops strike</a></center></div><br/>


</div></center>
<?php
}else if($a == "tirar"){
?>
<p align="center">
<?php
$user =  $mistake->query("SELECT stid FROM pc_tirada WHERE id='".$uid."' AND stid>='30'")->fetch();
$tempo = time() + 30;
if($user[0]){
 $mistake->query("UPDATE pc_tirada SET  minhadata='".$tempo."' WHERE id='".$uid."'");
}else
$userr =  $mistake->query("SELECT minhadata FROM pc_tirada WHERE id='".$uid."'")->fetch();
if($userr[0] >= time()){
?>
<p align='center'><img src='style/avruim.gif' alt='home'/><b>ATENÇÃO</b> <big>Pressione Excessivamente aguarde 30 segundos!</big><br/><br/>
<a href="?a=a">&#187;Volver</a></p>
<?php
}else{
 $uPt =  $mistake->query("SELECT pt FROM w_usuarios WHERE id='".$uid."'")->fetch();
$costas = 300;
 echo 'Seus pontos: '.$uPt[0].'<br/>';
if($uPt[0] <= $costas){
echo "<center><img src='style/avruim.gif' alt='antencao'/><br/>É preciso $costas PONTOS PARA JOGAR</center><br/>";
}else{
$rand = rand(1,13);
if($rand==13){
echo '<img src="juegos/boliche/'.$rand.'.gif" "alt="*">';?><br/>
<div id='div1'><center><b><img src="style/avruim.gif" alt="ok"/>Opa, que pena que você fez um tiro terrível, e você perdeu 150 pontos.</div><br/>
<?php
$nPl=$uPt[0] - 150;
 $mistake->query("UPDATE w_usuarios SET pt='".$nPl."'  WHERE id='".$uid."' ");
echo '<p align="center"><a href="?a=tirar&t='.time().'&id='.$uid.'"><img src="juegos/boliche/boton.gif">Jogar</a></p>';
}else
if($rand==12){
echo '<img src="juegos/boliche/'.$rand.'.gif" "alt="*"><br/>';
echo '<div id="div1"><center><b><img src="style/avruim.gif" alt="ok"/>Você não derrubou nenhum pinheiro, e você perdeu 50 pontos.</div><br/>';
$nPl=$uPt[0] - 50;
 $mistake->query("UPDATE w_usuarios SET pt='".$nPl."' WHERE id='".$uid."' ");
echo '<p align="center"><a href="?a=tirar&t='.time().'&id='.$uid.'"><img src="juegos/boliche/boton.gif">Jogar</a></p>';
}else if($rand==11){
echo '<img src="juegos/boliche/'.$rand.'.gif" "alt="*"><br/>';
echo '<div id="div1"><center><b><img src="style/avbom.gif" alt="ok"/>Você derrubou 6 pinheiros, e ganhou 150 pontos.</div><br/>';
$nPl=$uPt[0] +150;
 $mistake->query("UPDATE w_usuarios SET pt='".$nPl."' WHERE id='".$uid."' ");
echo '<p align="center"><a href="?a=tirar&t='.time().'&id='.$uid.'"><img src="juegos/boliche/boton.gif">Jogar</a></p>';
}else if($rand==10){
echo '<img src="juegos/boliche/'.$rand.'.gif" "alt="*"><br/>';
echo '<div id="div1"><center><b><img src="style/avbom.gif" alt="ok"/>quase derrubou todos os pinheiros, e ganhou 140 pontos.</div><br/>';
$nPl=$uPt[0] + 140;
 $mistake->query("UPDATE w_usuarios SET pt='".$nPl."' WHERE id='".$uid."' ");
echo '<p align="center"><a href="?a=tirar&t='.time().'&id='.$uid.'"><img src="juegos/boliche/boton.gif">Jogar</a></p>';
}else if($rand==9){
echo '<img src="juegos/boliche/'.$rand.'.gif" "alt="*"><br/>';
echo '<div id="div1"><center><b><img src="style/avbom.gif" alt="ok"/> Opa, você conseguiu 1 ponto, ganhou 110 pontos.</div><br/>';
$nPl=$uPt[0] + 110;
 $mistake->query("UPDATE w_usuarios SET pt='".$nPl."' WHERE id='".$uid."' ");
echo '<p align="center"><a href="?a=tirar&t='.time().'&id='.$uid.'"><img src="juegos/boliche/boton.gif">Jogar</a></p>';
}else
if($rand==8){
echo '<img src="juegos/boliche/'.$rand.'.gif" "alt="*"><br/>';
echo '<div id="div1"><center><b><img src="style/avruim.gif" alt="ok"/> Você não derrubou nenhum pinheiro, e você perdeu 50 pontos.</div><br/>';
$nPl=$uPt[0] - 50;
 $mistake->query("UPDATE w_usuarios SET pt='".$nPl."' WHERE id='".$uid."' ");
echo '<p align="center"><a href="?a=tirar&t='.time().'&id='.$uid.'"><img src="juegos/boliche/boton.gif">Jogar</a></p>';
}else if($rand==7){
echo '<img src="juegos/boliche/'.$rand.'.gif" "alt="*"><br/>';
echo '<div id="div1"><center><b><img src="style/avruim.gif" alt="ok"/> Você não derrubou nenhum pinheiro, e você perdeu 10 pontos.</div><br/>';
$nPl=$uPt[0] - 10;
 $mistake->query("UPDATE w_usuarios SET pt='".$nPl."' WHERE id='".$uid."' ");
echo '<p align="center"><a href="?a=tirar&t='.time().'&id='.$uid.'"><img src="juegos/boliche/boton.gif">Jogar</a></p>';
}else
if($rand==6){
echo '<img src="juegos/boliche/'.$rand.'.gif"" alt="*"><br/>';
echo '<div id="div1"><center><b><img src="style/avbom.gif" alt="ok"/> Você derrubou 4 pinheiros e ganhou 51 pontos.</div><br/>';
$nPl=$uPt[0] + 51;
 $mistake->query("UPDATE w_usuarios SET pt='".$nPl."' WHERE id='".$uid."' ");
echo '<p align="center"><a href="?a=tirar&t='.time().'&id='.$uid.'"><img src="juegos/boliche/boton.gif">Jogar</a></p>';
}else
if($rand==5){
echo '<img src="juegos/boliche/'.$rand.'.gif" "alt="*"><br/>';
echo '<div id="div1"><center><b><img src="style/avruim.gif" alt="ok"/> Você não derrubou nenhum pinheiro, e você perdeu 20 pontos.</div><br/>';
$nPl=$uPt[0] - 20;
 $mistake->query("UPDATE w_usuarios SET pt='".$nPl."' WHERE id='".$uid."' ");
echo '<p align="center"><a href="?a=tirar&t='.time().'&id='.$uid.'"><img src="juegos/boliche/boton.gif">Jogar</a></p>';
}else
if($rand==4){
echo '<img src="juegos/boliche/'.$rand.'.gif" "alt="*"><br/>';
echo '<div id="div1"><center><b><img src="style/avbom.gif" alt="ok"/> Você jogou uma bola com um prêmio, e você ganhou 101 pontos.</div><br/>';
$nPl=$uPt[0] + 101;
 $mistake->query("UPDATE w_usuarios SET pt='".$nPl."' WHERE id='".$uid."' ");

echo '<p align="center"><a href="?a=tirar&t='.time().'&id='.$uid.'"><img src="juegos/boliche/boton.gif">Jogar</a></p>';
}else
if($rand==3){
echo '<img src="juegos/boliche/'.$rand.'.gif"" alt="*"><br/>';
echo '<div id="div1"><center><b><img src="style/avbom.gif" alt="ok"/> Você derrubou 7 pinheiros e ganhou 200 pontos.</div><br/>';
$nPl=$uPt[0] + 200;
 $mistake->query("UPDATE w_usuarios SET pt='".$nPl."' WHERE id='".$uid."' ");

echo '<p align="center"><a href="?a=tirar&t='.time().'&id='.$uid.'"><img src="juegos/boliche/boton.gif">Jogar</a></p>';
}else
if($rand==2){
echo '<img src="juegos/boliche/'.$rand.'.gif" "alt="*"><br/>';
echo '<div id="div1"><center><b><img src="style/avbom.gif" alt="ok"/> Você derrubou 9 pinheiros e ganhou 300 pontos.</div><br/>';
$nPl=$uPt[0] + 300;
 $mistake->query("UPDATE w_usuarios SET pt='".$nPl."' WHERE id='".$uid."' ");

echo '<p align="center"><a href="?a=tirar&t='.time().'&id='.$uid.'"><img src="juegos/boliche/boton.gif">Jogar</a></p>';
}else
if($rand==1)
{
echo '<img src="juegos/boliche/strike.gif" alt="*"><br/>';
$nPl=$uPt[0] + 1500;
$uPtr =  $mistake->query("SELECT strike FROM w_usuarios WHERE id='".$uid."'")->fetch();
$nPll=$uPtr[0] + 1;
 $mistake->query("UPDATE w_usuarios SET strike='".$nPll."',pt='".$nPl."' WHERE id='".$uid."' ");

echo '<div id="div1"><center><b><img src="style/avbom.gif" alt="ok"/> Parabéns! você fez um strike e ganhou 1500 pontos</div><br/>';
echo '<p align="center"><a href="?a=tirar&t='.time().'&id='.$uid.'"><img src="juegos/boliche/boton.gif">Jogar</a></p>';
} 

}
}
?>
<?php  } else if($a=='top') { ?>

<br/><div id="titulo"><b>Raking strike</b></div><br/>

<?php
$contmsg =  $mistake->query("SELECT count(*) FROM w_usuarios where strike>'0'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contmsg[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens =  $mistake->query("SELECT id, strike FROM w_usuarios where strike>'0' order by strike desc limit $limit, $itensporpag");
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>

<div id="<?php echo $i%2==0?'div1':'div2';?>">
<?php echo gerarnome($item->id, $mistake);?> - Fez <?php echo $item->strike;?> strike
</div>

<?php $i++; } ?>

<br/><div align="center"><br/>

<?php if($pag>1) { $ppag = $pag-1; ?>

<a href="rato?a=ranking&pag=<?php echo $ppag;?>">&#171;Anterior</a>

<?php } if($pag<$numpag) { $npag = $pag+1; ?>

<a href="rato?a=ranking&pag=<?php echo $npag;?>">Próxima&#187;</a>

<?php } ?>

<br/><?php echo $pag.'/'.$numpag;?><br/>

<?php if($numpag>2) { ?>

<form action="rato" method="get">
Pular para página<input name="pag" size="3">
<input type="submit" value="IR">
<input type="hidden" name="a" value="<?php echo $a;?>">
</form>

<?php } } else { ?>

<div align="center">Nenhum usuário ainda fez strike!<br/><br/>
<?php 
}
 }?>
<center>
<a href='boliche?a=menu'>Menu Boliche</a><br/>
<?php 
echo "<center><img src='style/inicio.gif' alt='home'/><a href='home?'>Pagina principal</a></center><br/>";
echo rodape();
echo "</body></html>";
?>
