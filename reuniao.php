<?php
require_once("".$_SERVER["DOCUMENT_ROOT"]."/funcoes.php");
require_once("".$_SERVER["DOCUMENT_ROOT"]."/mistake.php");
require_once("".$_SERVER["DOCUMENT_ROOT"]."/emoji.php");
seg($meuid);
if(perm($meuid)==0) { 
ativo($meuid,'Tentando entrar na moderação '); ?>
<div align="center"><br/><?php echo $imgerro;?>Você não é um membro da equipe!<br/>
<a href="home?"><?php echo $imginicio;?>Página principal</a><br><br>
<?php 
rodape(); 
exit(); 
}
if($_GET['acao']=='ocultar') {
$res =  $mistake->exec("update w_usuarios set vschat='1' where id='$meuid'");    
unset($_SESSION["hall"]);
header('Location:reuniao');
}else if($_GET['acao']=='mostrar') {
$res =  $mistake->exec("update w_usuarios set vschat='0' where id='$meuid'");
$_SESSION["hall"] = $meuid;
header('Location:reuniao');
}
ativo($meuid,'Em reuniao ');
$gato =  $mistake->prepare("SELECT id,ft FROM w_usuarios WHERE gato='1' AND sx='M'");
$gato->execute();
$gato = $gato->fetch();
$gata =  $mistake->prepare("SELECT id,ft FROM w_usuarios WHERE gato='1' AND sx='F'");
$gata->execute();
$gata = $gata->fetch();
$amigos =  $mistake->prepare("SELECT COUNT(*) FROM w_amigos WHERE (uid='".$meuid."' OR tid='".$meuid."') AND ac='1'");
$amigos->execute();
$amigos = $amigos->fetch();
$pedidos =  $mistake->prepare("SELECT COUNT(*) FROM w_amigos WHERE tid='$meuid' AND ac='0'");
$pedidos->execute();
$pedidos = $pedidos->fetch();
$nu =  $mistake->prepare("SELECT max(id) FROM w_usuarios WHERE liberado='1'");
$nu->execute();
$nu = $nu->fetch();
$pmnaolida =  $mistake->prepare("SELECT COUNT(*) FROM w_msgs WHERE pr='$meuid' AND ld='0' and dl='0'");
$pmnaolida->execute();
$pmnaolida = $pmnaolida->fetch();
$todaspms =  $mistake->prepare("SELECT COUNT(*) FROM w_msgs WHERE pr='$meuid' and dl='0'");
$todaspms->execute();
$todaspms = $todaspms->fetch();
$pmnaolida2 =  $mistake->prepare("SELECT COUNT(*) FROM w_msgs WHERE pr='$meuid' AND ld='0' and dl='1'");
$pmnaolida2->execute();
$pmnaolida2 = $pmnaolida2->fetch();
$todaspms2 =  $mistake->prepare("SELECT COUNT(*) FROM w_msgs WHERE pr='$meuid' and dl='1'");
$todaspms2->execute();
$todaspms2 = $todaspms2->fetch();
$rec =  $mistake->prepare("SELECT COUNT(*) FROM w_recados WHERE pr='$meuid'");
$rec->execute();
$rec = $rec->fetch();
$pensa =  $mistake->prepare("SELECT COUNT(*) FROM w_mural WHERE tipo='4'");
$pensa->execute();
$pensa = $pensa->fetch();
$comu =  $mistake->prepare("SELECT COUNT(*) FROM w_comu");
$comu->execute();
$comu = $comu->fetch();
$emo =  $mistake->prepare("SELECT COUNT(*) FROM w_emocoes");
$emo->execute();
$emo = $emo->fetch();
$albuns =  $mistake->prepare("SELECT COUNT(*) FROM w_albuns");
$albuns->execute();
$albuns = $albuns->fetch();
$fotos =  $mistake->prepare("SELECT COUNT(*) FROM w_fotos");
$fotos->execute();
$fotos = $fotos->fetch();
$segredos =  $mistake->prepare("SELECT COUNT(*) FROM bymistake_segredos");
$segredos->execute();
$segredos = $segredos->fetch();
$downs =  $mistake->prepare("SELECT COUNT(*) FROM w_downs");
$downs->execute();
$downs = $downs->fetch();
$chaton =  $mistake->prepare("SELECT COUNT(*) FROM w_ochat");
$chaton->execute();
$chaton = $chaton->fetch();
$inativo = time()-28800;
$inativo2 = time()-3600;
$online =  $mistake->prepare("SELECT COUNT(*) FROM w_usuarios where inativo>'$inativo'");
$online->execute();
$online = $online->fetch();
$equipe =  $mistake->prepare("SELECT COUNT(*) FROM w_usuarios WHERE (perm>'0' or perm2>'0') and inativo>'$inativo2'");
$equipe->execute();
$equipe = $equipe->fetch();
$vips =  $mistake->prepare("SELECT COUNT(*) FROM w_usuarios WHERE vip='1' and inativo>'$inativo'");
$vips->execute();
$vips = $vips->fetch();
$miguxoson =  $mistake->prepare("SELECT COUNT(*) FROM w_amigos a inner join w_usuarios b WHERE (a.uid='".$meuid."' OR a.tid='".$meuid."') AND a.ac='1' AND (b.id=a.tid OR b.id=a.uid) AND b.id!='$meuid' and b.inativo>'$inativo'");
$miguxoson->execute();
$miguxoson = $miguxoson->fetch();
$cma =  $mistake->prepare("SELECT COUNT(*) FROM w_comu_m a, w_comu b where b.dn='$meuid' and b.id=a.cm and a.ac='0'");
$cma->execute();
$cma = $cma->fetch();
$perguntas =  $mistake->prepare("SELECT count(*) FROM w_pergunte_me where para='$meuid'");
$perguntas->execute();
$perguntas = $perguntas->fetch();
$sgostei = $i['sx']=='M'?'F':'M';
if (!empty($_GET['gostou'])) {
$gostouget = $_GET['gostou'];
$certo =  $mistake->prepare("SELECT COUNT(*) FROM w_comentarios_logs WHERE meuid='$meuid' AND idrecado='".$gostouget."'");
$certo->execute();
$certo = $certo->fetch();
if ($certo[0]>0) {
header("Location: /reuniao?");	
}else{
 $mistake->exec("update w_mural set si=si+1 where id='".$gostouget."'");
 $mistake->exec("INSERT INTO w_comentarios_logs (meuid,idrecado) values('$meuid','".$gostouget."')");
header("Location: /reuniao?");	
}
}
if (!empty($_GET['naogostou'])) {
$naogostouget = $_GET['naogostou'];
$certo =  $mistake->prepare("SELECT COUNT(*) FROM w_comentarios_logs WHERE meuid='$meuid' AND idrecado='".$naogostouget."'");
$certo->execute();
$certo = $certo->fetch();
 $mistake->exec("update w_mural set si=si-1 where id='".$naogostouget."'");
$res =  $mistake->exec("DELETE FROM w_comentarios_logs WHERE meuid='$meuid' AND idrecado='".$naogostouget."'");
header("Location: /reuniao?");	
}
if($a=='curtir' && $_GET['carinha']>0 && $_GET['carinha']<7){
$certo =  $mistake->prepare("SELECT COUNT(*) FROM w_comentarios_logs WHERE meuid='$meuid' AND idrecado='".$_GET['id']."'");
$certo->execute();
$certo = $certo->fetch();
if ($certo[0]>0) {   
 $mistake->exec("update w_comentarios_logs set carinha='".$_GET['carinha']."' where meuid='$meuid' AND idrecado='".$_GET['id']."'"); 
header("Location: /reuniao?");
}else{
 $mistake->exec("INSERT INTO w_comentarios_logs (meuid,idrecado,carinha) values('$meuid','".$_GET['id']."','".$_GET['carinha']."')");
header("Location: /reuniao?");
}
}
?>

<?php
$endereco = $_SERVER ['REQUEST_URI'];
?>
<center><a href="<?php echo $endereco; ?>"><img src="style/atualizar.gif" alt="*"/>Atualizar</a></center>

<center><img src="style/emocoes.gif"/><a href="configuracoes?a=catemocoes" >Emoções</a> - <img src="style/bbcode.gif"/><a href="configuracoes?a=dicas" >BBCodes</a></center>
<?php
///status remov
?>
</div>
<?php
if($_SESSION['reuniao']=='nao'){?>
<div align="center">
<a href="reuniao?acao=mostrar">Mostrar bate-papo</a>
</div>
<?php }else{ ?>
<div align="center"><b>
</div>
<br/><fieldset><legend><div id="barra_mural">Reuniao da equipe</div></legend>
<form action="mural?a=reuniao" method="post"  enctype="multipart/form-data" id="formID">
Texto: <input type="text" name='rec' cols='5' rows='5' maxlength="240"><br/>
<b>Para:</b> <select name="para">
<option value="0">Todos</option>
<?php
$itens =  $mistake->query("SELECT id, nm FROM w_usuarios WHERE (perm>'0' or perm2>'0') and ativo>'$inativo2' ORDER BY ativo desc");
while($item = $itens->fetch(PDO::FETCH_OBJ)) {
?>
<option value="<?php echo $item->id;?>"><?php echo $item->nm;?></option>
<?php
}
?>
</select>
<br/><b>Cor: </b><select name="cortexto">
<option value="black">Preto<selected></option>
<option value="blue">Azul</option>
<option value="red">Vermelho</option>
<option value="yellow">Amarelo</option>
<option value="green">Verde</option>
<option value="lime">Limão</option>
<option value="magenta">Magenta</option>
<option value="brown">Marron</option>
<option value="grey">Cinza</option>
<option value="pink">Rosa</option>
<option value="orange">Laranja</option>
<option value="purple">Roxo</option>
<option value="aqua">Aqua</option></select>
<br/><input type='hidden' name='acao' value='0'><input type="radio" value="1" name="formato" /><b>b</b><input type="radio" value="2" name="formato" /><i>i</i><input type="radio" value="3" name="formato" /><u>u</u><input type="radio" value="4" name="formato" /><big>big</big>
<br /><input type="file" name="arquivo" />
<br/><input type="submit" value="Enviar">
</form><br/><?php echo $treino;?><br/>
</fieldset>
<?php
$endereco = $_SERVER ['REQUEST_URI'];
$itens =  $mistake->prepare("SELECT * FROM w_mural WHERE tipo='6' ORDER BY id DESC limit 15");
$itens->execute();
$xxx=0; 
while ($item = $itens->fetch(PDO::FETCH_OBJ)) { 
?>
<script>
 $(document).ready(function(){
 $("#div_refresh").load(" #div_refresh");
 setInterval(function() {
 $("#div_refresh").load(" #div_refresh");
 }, 15000);
 });
 </script>
 

 <div id="div_refresh">

<div id="<?php echo $xxx%2==0?'div1':'div2';?>">
<?php
$foto =  $mistake->prepare("SELECT ft FROM w_usuarios WHERE id='".$item->drec."'");
$foto->execute();
$foto = $foto->fetch();
$foto2 =  $mistake->prepare("SELECT ft FROM w_usuarios WHERE id='".$item->para."'");
$foto2->execute();
$foto2= $foto2->fetch();
if($item->ac==0){ 
?>
<?php echo gerarnome($item->drec);?>
<?php 
if($item->para==0) { 
echo ''; 
} else { 
?> 
para <?php echo gerarnome($item->para);?>
<?php 
} 
?>
<div class="chatt-up">
<span style="color:<?php echo $item->cor; ?>"><?php echo textot($item->rec,$meuid,$on);?></span>
</div>
<?php 
}else{ 
?>
<?php echo gerarnome($item->drec);?>
<span style="color:<?php echo $item->cor; ?>"><?php echo textot($item->rec,$meuid,$on);?></span> 
<?php echo gerarnome($item->para);?><br>
<?php
} 
if($_POST["sl"]==TRUE && $_POST["tl"]==TRUE){
echo"<b>Tradução :</b> ".tradutor($item->rec,$_POST["sl"],$_POST["tl"])."";	
}
gosteimural($item->id,$item->hora,'historicochatmural',$meuid);
echo'</div>';
$xxx++;
}}
?>

<center> 

<a href="home"style="color:#FF0000;">
 <img src="style/sair.gif" alt="img" /><strong>Sair da reuniao</strong></a>
 </center>
<?php echo rodape();?>
</body>
</html>