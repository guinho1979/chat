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
if(pts($meuid)<800){
echo "<div align='center'><b>Voce precisa ter no minimo 800 Pontos!</b></div>";
?>
<div align="center">
<a href="/entretenimento?"><?php echo $imgservicos;?>Entretenimento</a><br/>
<a href="/home?"><?php echo $imginicio;?>Página principal</a><br><br>
<?php 
echo 
rodape();
exit();
}
ativo($meuid,'Pescaria');
$e = $_GET["e"];
$del = $_GET["del"];
$pontos = $im[12];
if($e == 1){
$pt = $pontos-10;
$tipo = 1;
}else{
$pt = $pontos-50;
$tipo = 2; 
}
$pescador = $mistake->prepare("SELECT COUNT(*) FROM pescaria WHERE uid='".$meuid."'");
$pescador->execute();
$pescador = $pescador->fetch();
if(!empty($e)&&$pescador[0]==0){
$mistake->exec("INSERT INTO pescaria SET uid='".$meuid."',tipo='".$tipo."'");
$mistake->exec("UPDATE w_usuarios SET pt='".$pt."' WHERE id='".$meuid."'");
}
$pescaria = $mistake->prepare("SELECT tipo FROM pescaria WHERE uid='".$meuid."'");
$pescaria->execute();
$pescaria = $pescaria->fetch();
$peixes = $mistake->prepare("SELECT peixes FROM w_usuarios WHERE id='".$meuid."'");
$peixes->execute();
$peixes = $peixes->fetch();
?>
<div align='center'><div id='titulo'>Pescaria</div>
<?php
if($a == "cfunciona"){
?>
-Para comecar a pescar, voce precisa comprar uma vara de pesca que custa 10 pontos, ou uma rede de pesca que custa 50 pontos.<br>
-Com a vara de pesca voce pega um peixe por vez e com a rede voce pode pegar de 5 a 20 peixes por vez.<br>
-Voce recebera um barco, mas tera que comprar uma nova vara ou rede caso um tubarão chegue de surpresa e corte sua linha ou rasgue sua rede.<br>
-Caso isso aconteca, um novo jogo sera iniciado e voce deve comprar novos materiais de pesca, os peixes pescados voce nao perdera e podera vende-los quando quiser.<br>
<?php
}else if($a == "vender"){
?>
Tem certeza que quer vender todos os seus peixes?<br><br>
<a href="/pescaria?">NAO</a>
<a href="/pescaria?a=vender2">SIM</a><br><br>
<?php
}else 
if($a == "rank"){	
$contmsg = $mistake->query("SELECT count(*) FROM w_usuarios where peixes>'0'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contmsg[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->query("SELECT id,peixes FROM w_usuarios where peixes>'0' order by peixes desc limit $limit, $itensporpag");
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<a href="/<?php echo gerarlogin($item->id);?>"><?php echo gerarnome($item->id);?></a> - pescou <?php echo $item->peixes;?> peixes
</div>
<?php $i++; } ?>
<br/><div align="center"><br/>
<?php if($pag>1) { $ppag = $pag-1; ?>
<a href="pescaria?a=rank&pag=<?php echo $ppag;?>">&#171;Anterior</a>
<?php } if($pag<$numpag) { $npag = $pag+1; ?>
<a href="pescaria?a=rank&pag=<?php echo $npag;?>">Próxima&#187;</a>
<?php } ?>
<br/><?php echo $pag.'/'.$numpag;?><br/>
<?php if($numpag>2) { ?>
<form action="pescaria" method="get">
Pular para página<input name="pag" size="3">
<input type="submit" value="IR">
<input type="hidden" name="a" value="<?php echo $a;?>">
</form>
<?php } } else { ?>
<div align="center">Nenhum usuário!<br/><br/>
<?php }	
?>
<br/><a href="/pescaria">Voltar</a>
<?
}else
if($a == "vender2"){
if($peixes[0]>0){
$ppt = $pontos+$peixes[0];
$res = $mistake->exec("UPDATE w_usuarios SET peixes='0',pt='".$ppt."' WHERE id='".$meuid."'");
if($res){
?>
Peixes vendidos com sucesso!
<?php
}else{
?>
Erro ao vender peixes!
<?php
}
}else{
?>
Voce nao tem peixes!
<?php
}
}else{
?>
<p align="center">
<?php
if($pescador[0]==0){
?>
Para jogar voce precisa comprar uma vara ou rede de pesca<br>
<a href="pescaria?e=1"><img src="/imagens/pesca/v_pescar.jpg" alt="img" /><br>10 pontos</a><br>
<a href="pescaria?e=2"><img src="/imagens/pesca/r_pescar.jpg" alt="img" /><br>50 pontos</a><br>
<?php
}else{
if(empty($del)){
?>
Voce ja comprou a vara ou rede de pescar , agora clique em pescar para começar<br>
<?php
}else{
if($pescaria[0]==1){ 
if($im[12]<200){
echo "Voce nao tem pontos suficientes para jogar na pescaria!";
rodape();
exit();
}
$rand = rand(0,5);
if($rand>0){
?>
<img src="/imagens/pesca/v_pescou.jpg" alt="img" /><br>
Voce pescou <strong><?php echo $rand;?></strong> peixe<?php if($rand>1){?>s<?php }?><br>
<?php
$pe = $peixes[0]+1;
$ps = $peixes[1]+1;
$mistake->exec("UPDATE w_usuarios SET peixes='".$pe."' WHERE id='".$meuid."'");
}else{
?>
<img src="/imagens/pesca/v_tubarao2.jpg" alt="img" /><br><div>Tubarao quebrou sua vara de pesca que pena!</div>
<?php
$mistake->exec("DELETE FROM pescaria WHERE uid='".$meuid."'");
}
}else{ 
if($im[12]<200){
echo"Voce nao tem pontos suficientes para jogar na pescaria!";
rodape();
exit();
}
$rand = rand(3,20);
if($rand>5){
?>
<img src="/imagens/pesca/v_rede<?php echo $rand;?>.jpg" alt="img" /><br>
Voce pescou <strong><?php echo $rand;?></strong> peixe<?php if($rand>1){?>s<?php }?><br>
<?php
$pe = $peixes[0]+$rand;
$mistake->exec("UPDATE w_usuarios SET peixes='".$pe."' WHERE id='".$meuid."'");
}else{
?>
<img src="/imagens/pesca/v_tubaraorede.jpg" alt="img" /><br>Tubarao rasgou sua rede que pena!
<?php
$mistake->exec("DELETE FROM pescaria WHERE uid='".$meuid."'");
}
}
}
?>
<br><br><a href="pescaria?del=1"><strong>PESCAR</strong></a><br>
<?php
}
?>
<br>Voce tem <strong><?php echo $peixes[0];?></strong> peixe<?php if($peixes[0]==0){}else{?>s<?php }?><br><br>
<a href="/pescaria?a=cfunciona">Como funciona?</a><br><br>
<a href="/pescaria?a=vender">Vender peixes</a><br><br>
<a href="/pescaria?a=rank">Rank de pescadores</a><br>
</p>
<?php
}
?>
<br><br><a href="entretenimento?"><?php echo $imgservicos;?>Entretenimento</a><br/>
<a href="home?"><?php echo $imginicio;?>Página principal</a><br><br></div>
<?php echo rodape();?>
</body>
</html>