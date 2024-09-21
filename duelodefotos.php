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
ativo($meuid,'Duelo de fotos');
?>
<br/><div id="titulo"><b>Duelo de fotos</b></div><br />
<div align="center">
Ver: <select onChange="location=options[selectedIndex].value">
<option value="#">Selecione</option>
<option value="/duelodefotos/0/M">Homens</option>
<option value="/duelodefotos/0/F">Mulheres</option>
</select><br />
<?
if($a=="verbom"||$a=="verruim") { 
if($a=="verbom") {
$contrec = $mistake->query("SELECT COUNT(*) FROM w_duelo_logs WHERE id_elista= '".$id."' AND dono!= '".$id."' AND duelo_sim>0")->fetch();
}else{
$contrec = $mistake->query("SELECT COUNT(*) FROM w_duelo_logs WHERE id_elista= '".$id."' AND dono!= '".$id."' AND duelo_nao>0")->fetch();
}
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contrec[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
if($a=="verbom") { 
$itens = $mistake->query("SELECT * FROM w_duelo_logs WHERE id_elista= '".$id."' AND dono!= '".$id."' AND duelo_sim>0 ORDER BY duelo_sim desc LIMIT $limit, $itensporpag");
}else{ 
$itens = $mistake->query("SELECT * FROM w_duelo_logs WHERE id_elista= '".$id."' AND dono!= '".$id."' AND duelo_nao>0 ORDER BY duelo_nao desc LIMIT $limit, $itensporpag");
}
$i=0; 
while ($item = $itens->fetch(PDO::FETCH_OBJ)) { 
$contrec = $mistake->query("SELECT * FROM w_usuarios WHERE id='".$item->eu_votei."'")->fetch();    
?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<a href="/<?php echo gerarlogin($contrec['id']);?>"><?php echo gerarfoto($contrec['id'],35,35);?><?php echo gerarnome($contrec['id']);?></a><br><b>Data:</b> <?php echo date("d/m/Y - H:i:s", $item->data);?>
</div>
<?php
$i++;
}
if($numpag>1) { 
paginas('duelodefotos',$a,$numpag,$id,$pag);    
}
?>
</div>
<br/>
<?php
}else{
?>
<div align="center">
<br /><br /><?php echo $imgerro;?>Não há votos.
</div>
<?php
}
}else
if($a=='curtir'){
if(pts($meuid)<300){
echo $imgerro;?><b>Opss... necessario 300 pontos!</b><br />
<?php    
} else {     
$certo = $mistake->query("SELECT COUNT(*) FROM w_duelo_logs WHERE id_elista= '".$id."' AND eu_votei='$meuid'")->fetch();
if ($certo[0]>0) {
echo $imgerro;?><b><big>Você  já deu seu voto a esse membro!</b><br />
<?php	
}else{
$res = $mistake->exec("INSERT INTO w_duelo_logs (id_elista,eu_votei,duelo_sim,data) values('".$id."','".$meuid."','1','".time()."')");    
$res = $mistake->exec("update w_usuarios set pt=pt+250 where id='".$id."'"); 
$res = $mistake->exec("update w_usuarios set pt=pt+250 where id='$meuid'");
if($res) {
$res = $mistake->exec("update w_duelo_logs set sim=sim+1 where dono='$id'");     
$msg = "Olá te dei um voto bom no duelo de fotos [link=/duelodefotos/verbom/".$id."]AQUI[/link]";
automsg($msg,$meuid,$id);    
echo $imgok;?><b>Voto aplicado com sucesso!</b><br />
<?php
} else { 
echo $imgerro;?><b>Opss... algo saiu errado!</b><br />
<?php 
} 
}
}
}else
if($a=='naocurtir'){
if(pts($meuid)<300){
echo $imgerro;?><b>Opss... necessario 300 pontos!</b><br />
<?php    
} else { 
$certo = $mistake->query("SELECT COUNT(*) FROM w_duelo_logs WHERE id_elista= '".$id."' AND eu_votei='$meuid'")->fetch();
if ($certo[0]>0) {
?>
<?php echo $imgerro;?><b>Você já deu seu voto a esse membro!</b><br />
<?php	
}else{
$res = $mistake->exec("INSERT INTO w_duelo_logs (id_elista,eu_votei,duelo_nao,data) values('".$id."','".$meuid."','1','".time()."')");
$res = $mistake->exec("update w_usuarios set pt=pt-250 where id='$meuid'");
if($res) { 
$res = $mistake->exec("update w_duelo_logs set nao=nao+1 where dono='$id'");    
$msg = "Olá te dei um voto ruim no duelo de fotos [link=/duelodefotos/verruim/".$id."]AQUI[/link]";
automsg($msg,$meuid,$id);    
echo $imgok;?><b>Voto aplicado com sucesso!</b><br />
<?php 
} else { 
echo $imgerro;?><b>Opss... algo saiu errado!</b><br />
<?php 
} 
}
}
}else
if($a=='participar'){
$certo = $mistake->query("SELECT COUNT(*) FROM w_duelo_logs WHERE dono='".$meuid."' AND eu_votei='".$meuid."'")->fetch();
if ($certo[0]==0) {  
$fechado = $mistake->query("SELECT * FROM w_usuarios WHERE id='$meuid'")->fetch();  
if ($fechado['sx']=='M' && $fechado['ft']!='semfoto.jpg' || $fechado['sx']=='F' && $fechado['ft']!='semfoto.jpg') {
$res = $mistake->exec("INSERT INTO w_duelo_logs (id_elista,eu_votei,duelo_sim,data,dono,sx) values('".$meuid."','".$meuid."','1','".time()."','".$meuid."','".$fechado['sx']."')");
}else{
echo $imgerro;?><b> Opss... arrume seu sexo ou adicione uma foto!</b><br /><?    
}
}
if($res) { 
echo $imgok;?><b>Você agora está participando do duelo.</b><br />
<?php 
} else {
echo $imgerro;?><b> Opss... algo saiu errado!</b><br />
<?php
} 
}else
if($a=='desclassificar'){
if(perm($meuid)==0) { 
ativo($meuid,'Tentando entrar na moderação '); 
echo $imgerro;?><b>Você não é um membro da equipe!</b><br />
<?php 
}else{ 
$res = $mistake->exec("DELETE FROM w_duelo_logs WHERE id_elista='".$id."'");
if($res) { 
echo $imgok;?><b>O membro foi desclassificado com sucesso!</b><br />
<?php 
} else { 
echo $imgerro;?><b>Opss... algo saiu errado!</b><br />
<?php 
} 
}
}else
if($a=='sair'){
if(pts($meuid)<25000){
echo $imgerro;?><b>Opss... necessario 25000 pontos para sair!</b><br />
<?php    
} else {      
$mistake->exec("update w_usuarios set pt=pt-25000 where id='$meuid'"); 
$res = $mistake->exec("DELETE FROM w_duelo_logs WHERE id_elista='$meuid'");
if($res) {
echo $imgok;?><b>Você não está mais participando do duelo.</b><br />
<?php 
} else { 
echo $imgerro;?><b>Opss... algo saiu errado!</b><br />
<?php 
} 
}
}else
if($a=='comofunciona'){
?> 
<div align="center"><b><br />Participe do Duelo de Fotos, ganhe 250 pontos a cada curtir , fique em primeiro no ranking e apareça na página principal!<br /><br />voce nao paga nada para participar mas para sair voce paga 25000 pontos<br /><br />votos bons o usuario ganha 250 pontos pelo voto<br /><br />votos ruins o usuario perde 250 pontos pelo voto</b></div>
<?php 
}else{
?>
<div align="center">
<?
if($id=="M") { 
$itens = $mistake->prepare("SELECT COUNT(*) FROM w_duelo_logs WHERE dono>0 AND sx='F'");
}else 
if($id=="H") { 
$itens = $mistake->prepare("SELECT COUNT(*) FROM w_duelo_logs WHERE dono>0 AND sx='M'");
}else{
$itens = $mistake->prepare("SELECT COUNT(*) FROM w_duelo_logs WHERE dono>0");
}
$itens->execute();
$contrec = $itens->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contrec[0];
$itensporpag = 5;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
if($id=="M") { 
$itens = $mistake->prepare("SELECT * FROM w_duelo_logs WHERE dono>0 AND sx='M' ORDER BY sim DESC LIMIT $limit, $itensporpag");
$itens->execute();
}else 
if($id=="F") {
$itens = $mistake->prepare("SELECT * FROM w_duelo_logs WHERE dono>0 AND sx='F' ORDER BY sim DESC LIMIT $limit, $itensporpag");
$itens->execute();
}else{
$itens = $mistake->prepare("SELECT * FROM w_duelo_logs WHERE dono>0 ORDER BY sim DESC LIMIT $limit, $itensporpag");
$itens->execute();
}
$i=0; 
while ($item = $itens->fetch(PDO::FETCH_OBJ)) { 
?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<?php echo gerarfoto($item->dono,103,136);?>
<br/><a href="/<?php echo gerarlogin($item->dono);?>"><?php echo gerarnome2($item->dono);?></a><br><a href="/duelodefotos/verbom/<?php echo $item->dono;?>"><img src="/style/bom.png"> <?php echo $item->sim;?></a> | <a href="/duelodefotos/verruim/<?php echo $item->dono;?>"><img src="/style/ruim.png"> <?php echo $item->nao;?></a><br/>
<a href="/duelodefotos/curtir/<?php echo $item->dono;?>">Curtir</a> - <a href="/duelodefotos/naocurtir/<?php echo $item->dono;?>">Não curtir</a><br/>
<hr>
 <?php
if(perm($meuid)>0) { 
?>
<a href="/duelodefotos/desclassificar/<?php echo $item->dono;?>">[desclassificar]</a>
<?php
}
?>
</div>
<?php
$i++;
}
if($numpag>1) { 
paginas('duelodefotos','a',$numpag,$id,$pag);     
}
?>
</div>
<br/>
<?php
}else{
?>
<div align="center">
<br /><br /><?php echo $imgerro;?>Não há participantes  ainda.
</div>
<?php
}
}
?>
</div>
<div align="center">
<?php
$fechado = $mistake->query("SELECT * FROM w_duelo_logs WHERE dono='$meuid'")->fetch();
if($fechado['dono']==0) { 
?> 
<br /><a href="/duelodefotos/participar">Participar do duelo</a><br />
<?php 
}else{
?>
<a href="/duelodefotos/sair">Sair do duelo</a><br />
<?php 
} 
?>
<br /><a href="/duelodefotos/comofunciona">Como funciona</a><br />
<?php
if($a==true){ 
?>
<br/><a href="/duelodefotos">Duelodefotos</a><br/><br/>
<?php 
} 
?>
<br /><a href="/home?"><?php echo $imginicio;?>Página principal</a><br><br>
<?php echo rodape();?>
</div></body>
</html>