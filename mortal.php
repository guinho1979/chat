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
$luta = $_GET["pag"];
ativo($meuid,'Mortal Kombat');
?><div id='titulo'><img width="20px" src="/juegos/kombat/logo.gif">MK <img width="20px" src="/juegos/kombat/logo.gif"></div><br><?
if($a =="elegir"){
$probar =  $mistake->query("SELECT id_user1 FROM mortal_kombat WHERE id_user1='".$meuid."' AND abierta='1'")->fetch();
if($probar){
?><center>Você já tem uma luta armada.<br />esperar para ser aceito para montar outro<br />(você só pode armar 1 de cada vez)<br /><?
}else{
$nome_user =  $mistake->query("SELECT id,nm,perm  FROM w_usuarios WHERE id='".$meuid."'")->fetch();
$whonick = gerarnome($meuid);
?><b><?php echo $whonick;?></b> escolha seu lutador.<br/><br/>
<table border="1"><tr>
<td><a href="/mortal/parti/<?php echo $nome_user[0];?>/cyrax.gif"><img width="50px" src="/juegos/kombat/lutador/cyrax.gif"><br />Cyrax</a></td>
<td><a href="/mortal/parti/<?php echo $nome_user[0];?>/jade.gif"><img width="50px" src="/juegos/kombat/lutador/jade.gif"><br />Jade</a></td>
<td><a href="/mortal/parti/<?php echo $nome_user[0];?>/kabal.gif"><img width="50px" src="/juegos/kombat/lutador/kabal.gif"><br />Kabal</a></td>
<td><a href="/mortal/parti/<?php echo $nome_user[0];?>/kitana.gif"><img width="50px" src="/juegos/kombat/lutador/kitana.gif"><br />Kitana</a></td>
<td><a href="/mortal?/parti/<?php echo $nome_user[0];?>/liukang.gif"><img width="50px" src="/juegos/kombat/lutador/liukang.gif"><br />Liu Kang</a></td>
</tr><tr>
<td><a href="/mortal/parti/<?php echo $nome_user[0];?>/raiden.gif"><img width="50px" src="/juegos/kombat/lutador/raiden.gif"><br />Raiden</a></td>
<td><a href="/mortal/parti/<?php echo $nome_user[0];?>/sheeva.gif"><img width="50px" src="/juegos/kombat/lutador/sheeva.gif"><br />Sheeva</a></td>
<td><a href="/mortal/parti/<?php echo $nome_user[0];?>/baraka.gif"><img width="50px" src="/juegos/kombat/lutador/baraka.gif"><br />Baraka</a></td>
<td><a href="/mortal/parti/<?php echo $nome_user[0];?>/stryker.gif"><img width="50px" src="/juegos/kombat/lutador/stryker.gif"><br />Stryker</a></td>
<td><a href="/mortal/parti/<?php echo $nome_user[0];?>/subzero.gif"><img width="50px" src="/juegos/kombat/lutador/subzero.gif"><br />Subzero</a></td>
</tr><tr>
<td><a href="/mortal/parti/<?php echo $nome_user[0];?>/goro.gif"><img width="50px" src="/juegos/kombat/lutador/goro.gif"><br />Goro</a></td>
<td><a href="/mortal/parti/<?php echo $nome_user[0];?>/kano.gif"><img width="50px" src="/juegos/kombat/lutador/kano.gif"><br />Kano</a></td>
<td><a href="/mortal/parti/<?php echo $nome_user[0];?>/kunglao.gif"><img width="50px" src="/juegos/kombat/lutador/kunglao.gif"><br />Kunglao</a></td>
<td><a href="/mortal/parti/<?php echo $nome_user[0];?>/mileena.gif"><img width="50px" src="/juegos/kombat/lutador/mileena.gif"><br />Mileena</a></td>
<td><a href="/mortal/parti/<?php echo $nome_user[0];?>/nightwolf.gif"><img width="50px" src="/juegos/kombat/lutador/nightwolf.gif"><br />Nightwolf</a></td>
</tr></table>
<?
}
}else if ($a == "parti"){
$probar =  $mistake->query("SELECT id_user1 FROM mortal_kombat WHERE id_user1='".$meuid."' AND abierta='1'")->fetch();
if($probar){
?><center>Você já tem uma luta armada.<br />esperar para ser aceito para montar outro<br />(você só pode armar 1 de cada vez)<br /><?

}else{

$pontos =  $mistake->query("SELECT pt FROM w_usuarios WHERE id='".$meuid."'")->fetch();
$puntos = $pontos[0] - 50; 
 $mistake->query("UPDATE w_usuarios SET pt='".$puntos."' WHERE id='".$meuid."'");

 $mistake->query("INSERT INTO mortal_kombat SET id_user1='".$meuid."', lutador1='juegos/kombat/lutador/".$luta."',vida1='10',vida2='10', abierta='1', time='0'");
echo '<br/>';
$img= "juegos/kombat/lutador/".$luta."";
$max =  $mistake->query("SELECT MAX(id) FROM mortal_kombat WHERE id_user1='".$meuid."'")->fetch();
?><table border="1"><tr><td><img src="/juegos/kombat/lutador/<?php echo $luta;?>"></td><td>
VS</td><td><img src="/juegos/kombat/logo.gif"></td></tr></table><br/>
Luta armada ... espere por outro jogador<br/>
<form action="/mortal/convidar" method="post">
<input type="hidden" name="num" value="<?php echo $max[0];?>">
<input type="hidden" name="img" value="<?php echo $img;?>">
<input type="submit" value="convidar no chat">
</form></center><br /><?
}
} 
if($a=="unirse"){  
$plus =  $mistake->query("SELECT pt FROM w_usuarios WHERE id='".$meuid."'")->fetch();
if($plus[0] < 300){
?>E necesario ter 300 pontos para jogar!<?
}else{  
if($pag=="" || $pag<=0)$pag=1;
$noi =  $mistake->query("SELECT COUNT(*) FROM mortal_kombat WHERE abierta='1'")->fetch();
$num_items = $noi[0];
$items_per_page= 10;
$num_pages = ceil($num_items/$items_per_page);
if(($pag>$num_pages)&&$pag!=1)$pag= $num_pages;
$limit_start = ($pag-1)*$items_per_page;
$sql = "SELECT id, id_user1, lutador1 FROM mortal_kombat WHERE abierta=1 ORDER BY id DESC LIMIT $limit_start, $items_per_page";
$nick= gerarnome($meuid); 
if($noi[0]>0){
$items =  $mistake->query($sql);
$i = 0; 
while ($item = $items->fetch()){   
$part = $item[0];
?>
<div id="<?php echo $i%2==0?'div1':'div2';?>"><a href="/mortal/pelear/<?php echo $part;?>">Luta <?php echo $part;?>:<img src="/<?php echo $item[2];?>" height="30"/><?php echo gerarnome($item[1]);?>esperando adversario</a></div><?
$i++;
}
if($num_pages>1){
paginas('mortal',$a,$num_pages,$id,$pag);
}
} else {
?><p align=\"center\"><img src="imagens/notok.gif"/>Nao ha partidas armadas!<br/><?
}
}
}
 else if ($a=="elegir2"){
 ?><table border="1"><tr>
<td><a href="/mortal/aceptar/<?php echo $id;?>/cyrax.gif"><img width="50px" src="/juegos/kombat/lutador/cyrax.gif"><br />Cyrax</a></td>
<td><a href="/mortal/aceptar/<?php echo $id;?>/jade.gif"><img width="50px" src="/juegos/kombat/lutador/jade.gif"><br />Jade</a></td>
<td><a href="/mortal/aceptar/<?php echo $id;?>/kabal.gif"><img width="50px" src="/juegos/kombat/lutador/kabal.gif"><br />Kabal</a></td>
<td><a href="/mortal/aceptar/<?php echo $id;?>/kitana.gif"><img width="50px" src="/juegos/kombat/lutador/kitana.gif"><br />Kitana</a></td>
<td><a href="/mortal/aceptar/<?php echo $id;?>/liukang.gif"><img width="50px" src="/juegos/kombat/lutador/liukang.gif"><br />Liu Kang</a></td>
</tr><tr>
<td><a href="/mortal/aceptar/<?php echo $id;?>/raiden.gif"><img width="50px" src="/juegos/kombat/lutador/raiden.gif"><br />Raiden</a></td>
<td><a href="/mortal/aceptar/<?php echo $id;?>/sheeva.gif"><img width="50px" src="/juegos/kombat/lutador/sheeva.gif"><br />Sheeva</a></td>
<td><a href="/mortal/aceptar/<?php echo $id;?>/baraka.gif"><img width="50px" src="/juegos/kombat/lutador/baraka.gif"><br />Baraka</a></td>
<td><a href="/mortal/aceptar/<?php echo $id;?>/stryker.gif"><img width="50px" src="/juegos/kombat/lutador/stryker.gif"><br />Stryker</a></td>
<td><a href="/mortal/aceptar/<?php echo $id;?>/subzero.gif"><img width="50px" src="/juegos/kombat/lutador/subzero.gif"><br />Subzero</a></td>
</tr><tr>
<td><a href="/mortal/aceptar/<?php echo $id;?>/goro.gif"><img width="50px" src="/juegos/kombat/lutador/goro.gif"><br />Goro</a></td>
<td><a href="/mortal/aceptar/<?php echo $id;?>/kano.gif"><img width="50px" src="/juegos/kombat/lutador/kano.gif"><br />Kano</a></td>
<td><a href="/mortal/aceptar/<?php echo $id;?>/kunglao.gif"><img width="50px" src="/juegos/kombat/lutador/kunglao.gif"><br />Kunglao</a></td>
<td><a href="/mortal/aceptar/<?php echo $id;?>/mileena.gif"><img width="50px" src="/juegos/kombat/lutador/mileena.gif"><br />Mmileena</a></td>
<td><a href="/mortal/aceptar/<?php echo $id;?>/nightwolf.gif"><img width="50px" src="/juegos/kombat/lutador/nightwolf.gif"><br />Nightwolf</a></td>
</tr></table><?
  }
else if($a=="aceptar") {
?><p align=\"center\"><?
$id = $_GET["id"];
$r7 =  $mistake->query("SELECT id,id_user1,id_user2,lutador1,lutador2,vida1,vida2,num,num2,tipo,time,turno,abierta,ganador FROM mortal_kombat WHERE id='".$id."'")->fetch();
if($meuid==$r7[1]){
?><img src="/imagens/notok.gif"/>Você não pode competir contra você!<br/><?
}else if($r7[12]=="3"){
?><img src="/imagens/notok.gif"/><b>Este duelo acabou!</b><br/><?
} else if( $r7[2]<>0 ){
?><img src="/imagens/notok.gif"/><b>Eles já ocuparam esta luta!</b><br/><?
} else
if(pts($meuid)<500){
?><p align="center">
<img src="/imagens/notok.gif"/><b>Esta luta tem um valor maior que seus pontos!</b><br/><?
}else {
$tempo2 = 30;
$atual2 = time();
$apagar2 = $atual2 + $tempo2;
 $mistake->query("UPDATE w_usuarios SET  pt=pt-50 WHERE id='".$meuid."'"); 
$res =  $mistake->query("UPDATE mortal_kombat SET time='".$apagar2."',id_user2='".$meuid."', lutador2='juegos/kombat/lutador2/".$luta."',abierta='2' WHERE id='".$id."'");
if($res){
$lutador1a = str_replace(".gif", "", $r7[3]);
$lutador2a = str_replace(".gif", "", $luta);
$lutador1 = str_replace("juegos/kombat/lutador/", "", $lutador1a);
$lutador2 = str_replace("juegos/kombat/lutador2/", "", $lutador2a);
if (rand(1,25)<12){
$lut1 = "juegos/kombat/ganhou/".$lutador1."2.gif";
$lut2= "juegos/kombat/perdeu/".$lutador2."3.gif";
 $mistake->query("UPDATE w_usuarios SET mortal=mortal+1,pt=pt+100 WHERE id='".$r7[1]."'");
$log= "$lutador1 contra-atacou $lutador2 com um golpe fatality<br />E ganhou a luta!!!";
if (rand(1,3)==1){
$log= "$lutador1 contra-atacou $lutador2 com um soco<br />E ganhou a luta!!!";
}
if (rand(1,3)==2){
$log= "$lutador1 contra-atacou $lutador2 com um chute<br />E ganhou a luta!!!";
}
if (rand(1,3)==3){
$log= "$lutador1 contra-atacou $lutador2 com um golpe mortal<br />E ganhou a luta!!!";
}
$res =  $mistake->query("UPDATE mortal_kombat SET vida2= '0',abierta='3',lutador1='".$lut1."',turno='".$lutador1."',lutador2='".$lut2."',ganador='".$r7[1]."', log='".$log."' WHERE id='".$id."'");
}else{
$lut1= "juegos/kombat/perdeu/".$lutador1."3.gif";
$lut2= "juegos/kombat/ganhou2/".$lutador2."2.gif";
 $mistake->query("UPDATE w_usuarios SET mortal=mortal+1,pt=pt+100 WHERE id='".$meuid."'");
$log= "$lutador2 acertou $lutador1 com um golpe fatality<br />E ganhou a luta!!!";
if (rand(1,3)==1){
$log= "$lutador2 acertou um chute na cabeça de $lutador1<br />E ganhou a luta!!!";
}
if (rand(1,3)==2){
$log= "$lutador2 acertou $lutador1 com um soco<br />E ganhou a luta!!!";
}
if (rand(1,3)==3){
$log= "$lutador2 acertou $lutador1 com um golpe mortal<br />E ganhou a luta!!!";
}
$res =  $mistake->query("UPDATE mortal_kombat SET vida1= '0',abierta='3',turno='".$lutador2."',lutador1='".$lut1."',lutador2='".$lut2."',ganador='".$meuid."', log='".$log."' WHERE id='".$id."'");
} 
?><center>...Lutadores lutando...espere...</center><? 
$msg = "Entraram na sua luta. [link=/mortal/pelear/$id]AQUI [/link]";
automsg(''.$msg.' [br/](Esta é uma mensagem automatica, não é necessário respondê-la).',$meuid,$r7[1]);
?><meta http-equiv="refresh" content="1; url=/mortal/pelear/<?php echo $id;?>"><?
}
}
}else 
if($a=="convidar") {
if(isset($_POST['num'])!=''){
echo "<p align=\"center\">";
$num = $_POST["num"];
$val = $_POST["img"];
$texto = '[link=/mortal/pelear/'.$num.']<br /><b><u>Mortal Kombat Entre nessa luta</u></b><br /><img src="/'.$val.'"/>[/link]';
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
if($a=="pelear") {
$pelea =  $mistake->query("SELECT id,id_user1,id_user2,lutador1,lutador2,vida1,vida2,num,num2,tipo,time,turno,abierta,ganador,log FROM mortal_kombat WHERE id='".$id."'")->fetch();
if($pelea[12]==1){
$nick = gerarnome($pelea[1]);
?>
<center>
<table border="1"><tr><td><?php echo $nick;?><br /><img src="/<?php echo $pelea[3];?>"></td><td>
VS</td><td><a href="/mortal/elegir2/<?php echo $id;?>"><img src="/juegos/kombat/logo.gif"><br />Entrar</a></td></tr></table><br/>
<form action="/mortal/convidar" method="post">
<input type="hidden" name="num" value="<?php echo $id;?>">
<input type="hidden" name="img" value="<?php echo $pelea[3];?>">
<input type="submit" value="convidar no chat">
</form></center><br /><?
}else if($pelea[12]==3){
$lucador1 = $pelea[3];
$lucador2 = $pelea[4];
$vida1 = $pelea[5];
$vida2 = $pelea[6];
if($pelea[1]==$pelea[13]){ 
$lutador1a = str_replace("2.gif", "", $lucador1);
$lutador2a = str_replace("3.gif", "", $lucador2);
$lutador1 = str_replace("juegos/kombat/ganhou/", "", $lutador1a);
$lutador2 = str_replace("juegos/kombat/perdeu/", "", $lutador2a);
}else {
$lutador1a = str_replace("3.gif", "", $lucador1);
$lutador2a = str_replace("2.gif", "", $lucador2);
$lutador1 = str_replace("juegos/kombat/perdeu/", "", $lutador1a);
$lutador2 = str_replace("juegos/kombat/ganhou2/", "", $lutador2a);
}
$total1 = 10;
$valor1 = floor(($vida1 / $total1) * 100);
$total2 = 10;
$valor2 = floor(($vida2 / $total2) * 100);
if($vida1 <= 0){
$cor1 = "#FFFFFF";
}else{
$cor1 = "red";
}
if($vida2 <= 0){
$cor2 = "#FFFFFF";
}else{
$cor2 = "red";
}
$novo= "Ganhador: ".gerarnome($pelea[13])."";
$novo1 = "";
$img = "<img src=\"/$pelea[3]\">";
$img1 = "<img src=\"/$pelea[4]\">";
?><center><b><?php echo $pelea[14];?></b></center>
<center><table><tr><td><?php echo gerarnome($pelea[1]);?></td><td><?php echo gerarnome($pelea[2]);?></td></tr><tr><td><?php echo $lutador1;?></td><td><?php echo $lutador2;?></td></tr>
<tr><td><table width="116px" height="5px" style="border:1px solid #000000;"><tr><td>
<table width="<?php echo $valor1;?>" border="0"><tr><td bgcolor="<?php echo $cor1;?>" height="5px"></td></tr></table>
</td></tr></table></td><td><table width="116px" height="5px" style="border:1px solid #000000;">
<tr><td><table width="<?php echo $valor2;?>" border="0"><tr><td bgcolor="<?php echo $cor2;?>" height="5px"></td></tr></table></td></tr></table></td></tr></table><?php echo $teste;?><br/><br/>
<?php echo $img;?> VS <?php echo $img1;?><br/><?php echo "$novo $novo1";?></center><?
}
}else if($a=="menum"){                                           
?><p align="center">
<div id="div2"><center><a href="/mortal/elegir">Iniciar uma luta</a></div><?
$noi =  $mistake->query("SELECT COUNT(*) FROM mortal_kombat WHERE abierta='1'")->fetch();
?><div id="div1"><center><a href="/mortal/unirse">Unirse a uma luta(<?php echo $noi[0];?>)</a></div>
<div id="div2"><center><a href="/mortal/terminadas">Lutas Terminadas</a></div>
<div id="div1"><center><a href="/mortal/top">Top Lutadores</a></div>
<div id="div2"><center><a href="/mortal/borrar">Zerar top</a></div><?
}
else if($a=="top") {  
?><center>Top ganhadores</center><?
if($pag=="" || $pag<=0)$pag=1;
$noi =  $mistake->query("SELECT COUNT(*) FROM w_usuarios WHERE mortal>='1'")->fetch();
$num_items = $noi[0];
$items_per_page= 10;
$num_pages = ceil($num_items/$items_per_page);
if(($pag>$num_pages)&&$pag!=1)$pag= $num_pages;
$limit_start = ($pag-1)*$items_per_page;
$sql = "SELECT id, mortal FROM w_usuarios WHERE mortal>='1' ORDER BY mortal DESC LIMIT $limit_start, $items_per_page";
$nick= gerarnome($meuid); 
if($noi[0]>0){
$items =  $mistake->query($sql);
$i= 0;
while ($item = $items->fetch()){ 
$masluch =  $mistake->query("SELECT turno,COUNT(*) as nops FROM mortal_kombat WHERE ganador='".$item[0]."' AND abierta='3' GROUP BY turno ORDER BY nops DESC LIMIT 0,1")->fetch(); 
?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<?
echo"<a href='".gerarlogin($item[0])."'>".gerarnome($item[0]).": $item[1] Vitorias</a>";
echo "<br />Lutador preferido: <img src=\"/juegos/kombat/ganhou2/$masluch[0]2.gif\" height=\"40px\"/><b>$masluch[0]</b>($masluch[1])";
echo "</div>";
$i++;
}
}
if($num_pages>1){
paginas('mortal',$a,$num_pages,$id,$pag);
}
}else if($a=="terminadas"){  
if($pag=="" || $pag<=0)$pag=1;
$noi =  $mistake->query("SELECT COUNT(*) FROM mortal_kombat WHERE abierta='3'")->fetch();
$num_items = $noi[0]; 
$items_per_page= 10;
$num_pages = ceil($num_items/$items_per_page);
if(($pag>$num_pages)&&$pag!=1)$pag= $num_pages;        
$limit_start = ($pag-1)*$items_per_page;
$sql = "SELECT id, id_user1, lutador1, id_user2, lutador2  FROM mortal_kombat WHERE abierta=3 ORDER BY id DESC LIMIT $limit_start, $items_per_page";
$nick= gerarnome($meuid); 
if($noi[0]>0){
$items =  $mistake->query($sql);
$i = 0; 
while ($item = $items->fetch()){   
$part = $item[0];
?>
<div id="<?php echo $i%2==0?'div1':'div2';?>"><a href="/mortal/pelear/<?php echo $part;?>">Luta <?php echo $part;?>:<img src="/<?php echo $item[2];?>" height="30"/><?php echo gerarnome($item[1]);?>vs <img src="/<?php echo $item[4];?>" height="30"/> <?php echo gerarnome($item[3]);?></a></div><?
$i++;   
}
if($num_pages>1){
paginas('mortal',$a,$num_pages,$id,$pag);
}
} else {
?><p align="center"><img src="/imagens/notok.gif"/>No ha partidas armadas!<br/><p align="center"><?
}
}
else if($a=="topa")
{ 
?><p align='center'>Top reclutadores</p><?

$sql = "SELECT ganador, COUNT(*) as nops FROM mortal_kombat GROUP BY ganador ORDER BY nops DESC";
$items =  $mistake->query($sql);
while ($item = $items->fetch()){
echo "".gerarnome($item[0])." tiene $item[1]<br />";
}
}   
if($a!="menum"){
?><br /><center><a href="/mortal/menum">Menu Mortal Kombat</a><br></center><br /><? }else{
?><br /><br /><?
}
?>
<br/><div align="center">
<a href="/home"><?php echo $imginicio;?>Página principal</a></center><br/>
<?php echo rodape();?>
</body>
</html>