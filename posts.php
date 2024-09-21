<?php
require_once("".$_SERVER["DOCUMENT_ROOT"]."/funcoes.php");
require_once("".$_SERVER["DOCUMENT_ROOT"]."/mistake.php");
require_once("".$_SERVER["DOCUMENT_ROOT"]."/emoji.php");
seg($meuid);
if($a==false){
$arquivo = $_FILES["arquivo"];
if (!empty($arquivo["name"])){
$pasta = "msgs/";
$nome = $_FILES['arquivo']['name'];
$nome = "By-Nando-".$meuid."-".$nome."";
$nome = str_replace(' ','-',$nome);
$nome = preg_replace("/[^a-zA-Z0-9.]/", "-", $nome);
$_UP['extensoes'] = array('mp3','ogg','wmv','jpeg','png','gif','bmp','jpg','mp4','webm','mpeg','3gp','3gpp','3ggp','apk','zip','webp');
$extensao = substr(strrchr($_FILES['arquivo']['name'],'.'),1);
if (array_search($extensao, $_UP['extensoes']) === false) {
echo "Extenção inválida!";
}else{
$url = $pasta.$nome;
if(preg_match("/^image\/(jpeg|png|bmp|jpg)$/", $_FILES["arquivo"]["type"])){
$bbcodemulti = '<br /><b><u>'.str_ireplace('.'.$extensao.'','',$_FILES['arquivo']['namee']).'</u></b>https://'.$_SERVER['SERVER_NAME'].'/'.$url.' ';
exec("montage -geometry +0+0 -background \"".$testearray[2]."\" -label \"".$_SERVER['SERVER_NAME']."\" ".escapeshellarg($_FILES['arquivo']['tmp_name'])." ".escapeshellarg($pasta.$nome)."");
}else{ 
if(preg_match("/^image\/(gif|webp)$/", $_FILES["arquivo"]["type"])){
$bbcodemulti = '<br /><b><u>'.str_ireplace('.'.$extensao.'','',$_FILES['arquivo']['namee']).'</u></b>https://'.$_SERVER['SERVER_NAME'].'/'.$url.' ';
}else{
if(preg_match("/^audio\/(mp3|wmv|mpeg|ogg)$/", $_FILES["arquivo"]["type"])){
$bbcodemulti = '<br /><b><u>'.str_ireplace('.'.$extensao.'','',$_FILES['arquivo']['namee']).'</u></b>https://'.$_SERVER['SERVER_NAME'].'/'.$url.' ';
}else{ 
if(preg_match("/^video\/(mp4|mpeg|webm)$/", $_FILES["arquivo"]["type"])){
$bbcodemulti = '<br /><b><u>'.str_ireplace('.'.$extensao.'','',$_FILES['arquivo']['namee']).'</u></b>https://'.$_SERVER['SERVER_NAME'].'/'.$url.' ';
}else{ 
if(preg_match("/^application\/(vnd.android.package-archive|x-zip-compressed)$/", $_FILES["arquivo"]["type"])){
$bbcodemulti = '[br/][link=/'.$url.']'.$_FILES['arquivo']['name'].'[/link][br/]';
}else{
if(preg_match("/^video\/(3gp|3gpp|3ggp)$/", $_FILES["arquivo"]["type"])){
$bbcodemulti = '[br/][link=/'.$url.']'.$_FILES['arquivo']['name'].'[/link][br/]';
}
}
}
}
}
move_uploaded_file($_FILES['arquivo']['tmp_name'], $pasta.$nome);
}
}
}else{
$bbcodemulti = '';
}  
$cortexto = !empty($_POST['cor']) ? $_POST['cor'] :'#000000';
$text = anti_injection($_POST['post']);
$text = "".$bbcodemulti."".$text."";

if($_POST['post']==true) {
if(strripos($text,'youtube.com') == true || strripos($text,'youtu.be') == true){
header("Location:/posts?");
exit;
}
$res = $mistake->prepare("INSERT INTO w_depo2 (txt,uid,cor,hora) VALUES (?,?,?,?)");
$arrayName = array($text,$meuid,$cortexto,time());
$ii = 0;
for($i=1; $i <=4; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
}
if($_POST['youtube']==true) {

$res = $mistake->prepare("INSERT INTO w_depo2 (txt,uid,cor,hora) VALUES (?,?,?,?)");
$arrayName = array($_POST['youtube'],$meuid,$cortexto,time());
$ii = 0;
for($i=1; $i <=4; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
}
if($_GET['curtir']==true){

$curtis = $mistake->query("SELECT COUNT(*) FROM curtidas WHERE msg='".$_GET['curtir']."' AND uid='".$meuid."' AND tipo='0' AND local='posts'")->fetch();
if($curtis[0]==0){
$mistake->exec("INSERT INTO curtidas (uid,msg,local,tipo) values('$meuid','".$_GET['curtir']."','posts','0')");
}
}

?>
<section class="container-fluid">
<div id="titulo">Publicações</div>
<div class="col-12">
<form style="margin: 20px 0" action="/posts?" method="post" enctype="multipart/form-data">
<div class="input-group input-group-sm mb-3"><div class="input-group-prepend"><span class="input-group-text"><a href="/posts.php?a=catemocoes"><i style="color: #555555" class="far fa-grin-alt"></i></a></span></div>
<input type="text" class="form-control" placeholder="Digite algo..." name="post" max-length="200"><div class="input-group-append"><span class="input-group-text youtube" data-toggle="collapse" href="#youtube"><i class="fab fa-youtube"></i></span><span class="input-group-text file-chooser"><i class="fas fa-paperclip"></i></span><button class="btn btn-secondary send-message-chat" type="submit"><i class="fas fa-paper-plane"></i></button></div></div><div class="collapse" id="youtube" style="margin-bottom: 1rem"><input type="text" class="form-control form-control-sm" placeholder="Link do YouTube" name="youtube"></div><input type="file" id="file" name="arquivo" style="display: none"><input type="hidden" id="color" name="cor" value="#000000"><div class="row"><div class="col-12 text-center"><input type="color" id="color_"></div></div></form>
<?
$contrec = $mistake->query("SELECT count(*) FROM w_depo2")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contrec[0];
$itensporpag = 15;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
?><ul class="list-group shadow posts"><?
$itens = $mistake->query("SELECT * FROM w_depo2 order by id desc LIMIT $limit, $itensporpag");
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) {
$curtiu = $mistake->query("SELECT count(*) FROM curtidas where tipo='0' and local='posts' and msg='".$item->id."'")->fetch();
$coment = $mistake->query("SELECT count(*) FROM w_comentarios where  idrec='".$item->id."'")->fetch();
?>
<li class="list-group-item">
<a href="/<?php echo gerarlogin($item->uid);?>"><?php echo gerarfoto($item->uid,30,30);?><?php echo gerarnome($item->uid);?></a><br/><?php echo textot($item->txt,$meuid,$on); if(perm($meuid)>0 or $item->uid==$meuid) { ?>
 - <span class="badge badge-danger badge-notification users-number" style="font-size: 10px"><a href="/posts?a=excluir&id=<?php echo $item->id;?>"><font color="white">[apagar]</font></span></a><br/>
<?php } ?>
<center><a href="/posts.php?a=comentarios&id=<?php echo $item->id;?>"> Comentários (<?php echo $coment[0];?>)</a>&nbsp<a href="/posts.php?curtir=<?php echo $item->id;?>"> Curtiu (<span class="post-<?php echo $item->id;?>"><?php echo $curtiu[0];?></span>)</a></center></div></li>
<?php $i++; } } else {?>
<div class="col-12"><div class="card shadow"><div class="card-body">Nenhum post.</div></div></div>
<?php 
} 
if($numpag>1) { 
paginas('posts',$a,$numpag,$id,$pag);   
}
?>

<div class="col-12 text-center" style="margin-top: 20px">
<a href="/home"><?php echo $imginicio;?>Página principal</a><br><br></div> </section><footer><?
}
else if($a=='catemocoes') { ?>

<section class="container-fluid"><h2 class="title"><b>Categoria de smilies</b></h2><div class="col-12 text-center">
<form action='/paginas' method='GET'><input type='hidden' class='bt3' name='a' value='buscaemocoes' />
<input type='text' class="form-control" name='id' placeholder='Buscar smilie'/><button class="btn btn-dark btn-block btn-sm" type="submit">Pesquisar</button></form></div><br/>
<?php
$contemo = $mistake->query("SELECT COUNT(*) FROM w_emo_cat WHERE venda='0'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contemo[0];
$itensporpag = 15;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->query("SELECT id, nm FROM w_emo_cat WHERE venda='0' ORDER BY nm asc LIMIT $limit, $itensporpag");
$i=0; while($item = $itens->fetch(PDO::FETCH_OBJ)) {
?>
<div id="<?php echo $i%2==0?'div1':'div1';?>">
<?php
$contemo2 = $mistake->query("SELECT COUNT(*) FROM w_emocoes where cat='".$item->id."'")->fetch(); ?>
<a href="/posts/emocoes/<?php echo $item->id;?>"><?php echo $item->nm;?>(<?php echo $contemo2[0];?>)</a><br/>
</div><?php $i++; 
} 
if($numpag>1) {
paginas('paginas',$a,$numpag,$id,$pag);
}
}else{
?>
<div class="col-12"><div class="card shadow"><div class="card-body">Nenhuma categoria.</div></div></div>
<?php    
}
?>
<div align="center">
<a href="/home"><?php echo $imginicio;?>Página principal</a><br><br></div>
<?
}
else 
if($a=='buscaemocoes') { 
$query="SELECT COUNT(*) FROM w_emocoes WHERE cod LIKE :cod";
$stmt= $mistake->prepare($query);
$stmt->execute(array(":cod" => "%".$id."%"));
$num = $stmt->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $num[0];
$itensporpag = 15;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
?>
<br/><div id="titulo"><b>Busca de Emoções <?php echo $id;?> encontarados <?php echo $numitens;?></b></div><br/><div style='text-align:center'><b>Busca de smile</b>
<form action='/paginas' method='GET'><input type='hidden' class='bt3' name='a' value='buscaemocoes' />
<input type='text' class='bt3' name='id' placeholder='Digite um Texto'/><input type='submit' class='bt3' value='Buscar'></form></div><br/>
<?php
if($num[0]>0){
$sql = "SELECT * FROM w_emocoes WHERE cod LIKE :cod ORDER BY cod LIMIT $limit, $itensporpag";
$items = $mistake->prepare($sql);
$items->execute(array(":cod" => "%".$id."%"));
$i = 0;
while ($item = $items->fetch(PDO::FETCH_OBJ)){
?>
<div id="<?php echo $i%2==0?'div1':'div1';?>">
<img src="/e/<?php echo $item->id;?>.<?php echo $item->ext;?>" class="smilies" oncontextmenu='return false' onselectstart='return false' ondragstart='return false'><br><? if(perm($meuid)>0){?><a href="/mod/emocoes/<?php echo $id;?>/<?php echo $pag;?>/<?php echo $item->id;?>"><font color="red">[apagar]</font></a> 
<a href="/mod/edit_emocao/<?php echo $item->id;?>"><font color="red">[editar]</font></a><br><?}?><b>Codigo :</b> <?php echo $item->cod;?></div>
<?php
$i++;
}
if($numpag>1) { 
paginas('paginas',$a,$numpag,$id,$pag);     
}
}else{
echo "<p align='center'>";
echo $imgerro;?>Erro nada encontrado!<br><?php 
echo "</p>";
}
?>
<div align="center"><a class="badge badge-secondary" href="/posts/catemocoes"><?php echo $imgsetavoltar;?> Voltar</a></div>
<?
}
else
if($a=='emocoes') { 
ativo($meuid,'Vendo emoções '); 
?>

<section class="container-fluid"><h2 class="title"><b>Smilies</b></h2><div class="col-12 text-left">
<div class="col-12"><ul class="list-group shadow" style="margin-bottom: 20px">
<?php 
$contemo = $mistake->query("SELECT COUNT(*) FROM w_emocoes where cat='$id'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contemo[0];
$itensporpag = 15;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->query("SELECT id,cod,ext FROM w_emocoes where cat='$id' ORDER BY cod LIMIT $limit, $itensporpag");	
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<li class="list-group-item">
<img src="/e/<?php echo $item->id;?>.<?php echo $item->ext;?>" class="smilies" oncontextmenu='return false' onselectstart='return false' ondragstart='return false'><br><? if(perm($meuid)>0){?><a href="/mod/emocoes/<?php echo $id;?>/<?php echo $pag;?>/<?php echo $item->id;?>"><font color="red">[apagar]</font></a> 
<a href="/mod/edit_emocao/<?php echo $item->id;?>"><font color="red">[editar]</font></a><br><?}?><b>Código :</b> <?php echo $item->cod;?></li>
<?php $i++; }?></ul><?
if($numpag>1) { 
paginas('chat',$a,$numpag,$id,$pag);     
} } else { ?>
<div class="col-12"><div class="card shadow"><div class="card-body">Nenhum emoção nessa categoria</div></div></div>
<?php 
} 
$tipo = $_POST["cate"];
$smile = trim($_POST["smile"]);
if(!empty($smile)){
if(perm($meuid)<1){
echo $imgerro;?>Você não é da equipe<br><?php
}else{    
if (strpos($smile,".")=== false) {
echo $imgerro;?>Coloque os pontinhos no inicio e no final do codigo.<br><?php
}else{
$texto1 = mb_strlen($smile);
if ($texto1 < 2){
echo "$imgerro Desculpa no minimo 2 caracteres para codigo!<br>";
}else{
$conta_ts = $mistake->prepare("SELECT id,ext FROM w_emocoes WHERE cod='".$smile."'");
$conta_ts->execute();
$conta_ts = $conta_ts->fetch();
if($conta_ts[0]>0){
echo "$imgerro ja existe um smilie com este codigo... <img src='/e/".$conta_ts[0].".".$conta_ts[1]."' class='smilies' oncontextmenu='return false' onselectstart='return false' ondragstart='return false'><br>";
}else{
$arquivo = isset($_FILES["foto"]) ? $_FILES["foto"] : FALSE;
$config["tamanho"] = 5000000;
$config["largura"] = 800;
$config["altura"]  = 800;
if($arquivo){ 
if(!preg_match("/^image\/(jpg|jpeg|png|gif|webp)$/", $arquivo["type"])){
echo "$imgerro Arquivo em formato invalido! A imagem deve ser  (jpg|jpeg|png|gif|webp) . Envie outro arquivo<br>";
}else{
if($arquivo["size"] > $config["tamanho"]){
echo "$imgerro O arquivo e muito grande! A imagem deve ser de no maximo " . $config["tamanho"] . " bytes. Envie outro arquivo<br>";
}else{
$tamanhos = getimagesize($arquivo["tmp_name"]);
if($tamanhos[0] > $config["largura"]){
echo "$imgerro Largura da imagem nao deve ultrapassar " . $config["largura"] . " pixels<br>";
}else{
if($tamanhos[1] > $config["altura"]){
echo "$imgerro Altura da imagem nao deve ultrapassar " . $config["altura"] . " pixels<br>";
}else{
preg_match("/.(gif|png|jpg|jpeg|webp){1}$/i", $arquivo["name"], $ext);
$res = $mistake->exec("INSERT INTO w_emocoes SET cod='".$smile."',ext='".$ext[1]."',cat='".$tipo."'");
$resok = $mistake->lastInsertId();
$imagem_dir = "e/".$resok.".".$ext[1]."";
if($tamanhos["mime"]=='image/webp'){
move_uploaded_file($arquivo["tmp_name"],$imagem_dir);    
}else{
if($tamanhos["mime"]=='image/gif'){
//exec("gif2webp -q 85 ".escapeshellarg($arquivo["tmp_name"])." -o ".escapeshellarg($imagem_dir)."");
//exec("gifsicle -O3 ".escapeshellarg($arquivo["tmp_name"])." -o ".escapeshellarg($imagem_dir)."");
move_uploaded_file($arquivo["tmp_name"],$imagem_dir); 

}else{
//exec("cwebp -q 85 ".escapeshellarg($arquivo["tmp_name"])." -o ".escapeshellarg($imagem_dir)."");
move_uploaded_file($arquivo["tmp_name"],$imagem_dir); 
}
}
echo "$imgok Smilie adicionado com sucesso <img src='/".$imagem_dir."' class='smilies' oncontextmenu='return false' onselectstart='return false' ondragstart='return false'> Codigo = ".$smile."!<br>";
}
}
}
}
}
}
}
}
}
}
if(perm($meuid)>0){
?>
<br><form action="/posts/emocoes/<?php echo $id;?>/<?php echo $pag;?>" method="post" enctype="multipart/form-data">
Smile: <input type="text" class="bt3" name="smile" /><br>
Arquivo:
<input id='input-file' name='foto' type='file' value=''><br>
<input type="hidden" name="cate" value="<?php echo $id;?>" readonly>
<input type="submit" class="bt3" value="Adicionar smile">
</form><br>
<?
}
?>
<div align="center"><a class="badge badge-secondary" href="/paginas/catemocoes"><?php echo $imgsetavoltar;?> Voltar</a></div>
<?
} 
else 
if($a=='excluir'){
$data = date("d/m/Y - H:i:s",time());
$dele = $mistake->query("SELECT uid, txt FROM w_depo2 WHERE id='$id'")->fetch();
if(perm($meuid)>0 or $dele['uid']==$meuid){
$dono = $mistake->query("SELECT nm FROM w_usuarios WHERE id='$dele[0]'")->fetch();
$txtt = "deletou um depoimento de [b] $dono[0] [/b]. Depoimento: $dele[1]. Data [i] $data [/i]";
$mistake->exec("INSERT INTO w_ltpc (a,txt) values('$meuid','$txtt')");
$mistake->exec("DELETE FROM w_depo2 WHERE id='$id'");
$mistake->exec("DELETE FROM w_comentarios WHERE idrec='$id'");
$mistake->exec("DELETE FROM curtidas WHERE msg='$id' and local='posts'");
header("Location:/posts.php?");
}
}
else 
if($a=='excluircomentario'){
$data = date("d/m/Y - H:i:s",time());
$dele = $mistake->query("SELECT por FROM w_comentarios WHERE id='$id'")->fetch();
if(perm($meuid)>0 or $dele['por']==$meuid){
$dono = $mistake->query("SELECT nm FROM w_usuarios WHERE id='$dele[0]'")->fetch();
$txtt = "deletou um comentario de [b] $dono[0] [/b]. Depoimento: $dele[1]. Data [i] $data [/i]";
$mistake->exec("INSERT INTO w_ltpc (a,txt) values('$meuid','$txtt')");
$mistake->exec("DELETE FROM w_comentarios WHERE id='$id'");

header("Location:/posts.php?");
}
}
else 
if($a=='comentarios') { 
ativo($meuid,'Vendo comentários do mural'); ?>
<?php
$comentario = $_POST['comentario'];
$comentarioo = "".$bbcodemulti."".$comentario."";
if (!empty($_POST['comentario'])) {

$res = $mistake->prepare("INSERT INTO w_comentarios (por,idrec,comentario,hr) VALUES (?, ?, ?, ?)");
$arrayName = array($meuid,$id,nl2br(emoji_unified_to_html($comentarioo)),time());
$ii = 0;
for($i=1; $i <=4; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
}

?>
<section class="container-fluid"><h2 class="title"><b>Comentários</b></h2><div class="col-12"><ul class="list-group shadow"><?
if(privacidade($_POST['para'])==0 || contamigos($meuid,$_POST['para'])==true || vip($meuid)) {
?>
</b></div><br/>
<div align="center"><?
$dele = $mistake->query("SELECT * FROM w_depo2 WHERE id='$id'")->fetch();
echo gerarfoto($dele['uid'],30,30);?><a href="/<?php echo gerarlogin($dele['uid']);?>"><?php echo gerarnome($dele['uid']);?></a> -  <small><?php echo date("d/m - H:i:s", $dele['hora']);?></small><br/><em style="color: <?php echo $dele['cor']; ?>;background-color:<?php echo $dele['contorno']; ?>;"><?php echo textot($dele['txt'],$meuid,$on);?></em><br/><strong>Postar comentário</strong><br/>
<form action="/posts?a=comentarios&id=<?php echo $id;?>" method="post" enctype="multipart/form-data">
<div class="upload-btn-wrapper"><button class="btn"><i class="bt_upload"></i></button><input type="file" name="arquivo" id="arquivo" /></div><input name="comentario" maxlength="60"> 
<input type="submit" value="Postar"></form>
</div>
<br />
<?php
}else{
?>
<div align="center">Somente amigos podem comentar</div>	
<?
}
if($id==false){
$contrec = $mistake->query("SELECT count(*) FROM w_comentarios WHERE idrec='$id'")->fetch();
}else{
$contrec = $mistake->query("SELECT count(*) FROM w_comentarios where idrec='$id'")->fetch();
}
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contrec[0];
$itensporpag = 1000;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
if($id==false){
$itens = $mistake->query("SELECT * FROM w_comentarios WHERE idrec='$id' ORDER BY id desc LIMIT $limit, $itensporpag");
}else{
$itens = $mistake->query("SELECT * FROM w_comentarios where idrec='$id' ORDER BY id desc LIMIT $limit, $itensporpag");
}
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<li class="list-group-item">
<a href="/<?php echo gerarlogin($item->por);?>"><?php echo gerarfoto($item->por,30,30);?>
<?php echo gerarnome($item->por);?></a> - <small><?php echo date("d/m - H:i:s", $item->hr);?></small><br/><?php echo textot($item->comentario,$meuid,$on);?><br/>
<?php if(perm($meuid)>0 or $item->por==$meuid) { ?>

<span class="badge badge-danger badge-notification users-number" style="font-size: 10px"><a href="/posts?a=excluircomentario&id=<?php echo $item->id; ?>"><font color="white">[excluir]</font></span></a>
<?php } ?> </div></ul></li><?php $i++; } } else { ?>
<div class="col-12"><div class="card shadow"><div class="card-body">Nenhum comentário.</div></div></div>
<?php 
} 
if($numpag>1) { 
paginas('mural',$a,$numpag,$id,$pag);   
}
?><div class="col-12 text-center" style="margin-top: 20px"><a 
<a href="/home"><?php echo $imginicio;?>Página principal</a><br><br></div> </section><footer><?
}

?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script><script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script><script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script><script type="text/javascript"> 				$(document).ready(function() { 					var lastId = 94; 					var loading = false; 					 					$("#color_").change(function() { 						var color = $(this).val(); 						 						$("#color").val(color); 					}); 					 					function loadMore() { 						if (loading == true) { 							return; 						} 						 						var loading = true; 						 						$.ajax({ 							url: 'system/posts.php?acao=Carregar&offset=' + lastId, 							type: 'GET', 							dataType: 'json', 							success: function(data) { 								if (data.lastId != 0) { 									lastId = data.lastId; 								 									if (data.posts != '') { 										$("ul.posts").append(data.posts); 									} 								} 								else { 									$('.more').css("display", "none"); 								} 								 								loading = false; 							}, 							error: function(data) { 								loading = false; 							} 						}); 					} 					 					$(document).on('click', '.like', function(e) { 						e.preventDefault(); 						 						var post_id = $(this).attr('value'); 						 						$.ajax({ 							url: 'system/posts.php?acao=Like&id=' + post_id, 							type: 'GET', 							dataType: 'json', 							success: function(data) { 								$(".like span.post-" + data.post_id).html(data.likes); 							} 						}); 					}); 					 					$('.file-chooser').click(function() { 						$('#file').trigger('click'); 					}); 					 					$('.more').click(function(e) { 						e.preventDefault(); 						 						loadMore(); 					}); 					 					/* 					$(window).scroll(function() { 						if ($(window).scrollTop() + $(window).height() == $(document).height()) { 							loadMore(); 						} 					}); 					*/ 				}); 			</script>
<?
echo rodape();
?>
</body>
</html>