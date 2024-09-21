<?php
require_once("".$_SERVER["DOCUMENT_ROOT"]."/funcoes.php");
require_once("".$_SERVER["DOCUMENT_ROOT"]."/mistake.php");
seg($meuid);
ativo($meuid,'Avatares para nick ');
$limite = $_GET['limite'];
?>
<br/><div id="titulo"><b>Avatares para nick</b></div><br />
<?php
if($a=='inicio') {
?>
<div id="div1"><a href="/avatares/heroes"><?php echo $imgseta;?> Heroes & Heroinas</div></a>
<div id="div2"><a href="/avatares/animados_1"><?php echo $imgseta;?> Animados parte 1</div></a>
<div id="div1"><a href="/avatares/animados_2"><?php echo $imgseta;?> Animados parte 2</div></a>
<div id="div2"><a href="/avatares/times"><?php echo $imgseta;?> Times de Futebol</div></a>
<div id="div1"><a href="/avatares/bandeirinhas"><?php echo $imgseta;?> Bandeirinhas</div></a>
<div id="div2"><a href="/avatares/personagens"><?php echo $imgseta;?> Personagens</div></a>
<div id="div1"><a href="/avatares/diversos"><?php echo $imgseta;?> Diversos</div></a>
<?php
}else
if($a=='heroes') {
$arquivo = glob('avatars/heroes/*.*'); 
$total = 10; 
$atual = isset($_GET['pag']) ? intval($_GET['pag']) : 1; 
$pagopen = array_chunk($arquivo,$total); 
$contar = count($pagopen); 
$resultado = $pagopen[$atual-1]; 
$x=0;
foreach($resultado as $file){ 
$color = ($x % 2 == 0)? "<div id='div1'>"  : "<div id='div2'>";
echo "$color<img src=\"/$file\" /><a href=\"/avatares/add/$file\">[+]</a></div>";
$x++;
} 
paginas('avatares',$a,$contar,$id,$atual);
}else
if($a=='animados_1') {
$arquivo = glob('avatars/animados1/*.*'); 
$total = 10; 
$atual = isset($_GET['pag']) ? intval($_GET['pag']) : 1; 
$pagopen = array_chunk($arquivo,$total); 
$contar = count($pagopen); 
$resultado = $pagopen[$atual-1]; 
$x=0;
foreach($resultado as $file){ 
$color = ($x % 2 == 0)? "<div id='div1'>"  : "<div id='div2'>";
echo "$color<img src=\"/$file\" /><a href=\"/avatares/add/$file\">[+]</a></div>";
$x++;
} 
paginas('avatares',$a,$contar,$id,$atual);
}else
if($a=='animados_2') {
$arquivo = glob('avatars/animados2/*.*'); 
$total = 10; 
$atual = isset($_GET['pag']) ? intval($_GET['pag']) : 1; 
$pagopen = array_chunk($arquivo,$total); 
$contar = count($pagopen); 
$resultado = $pagopen[$atual-1]; 
$x=0;
foreach($resultado as $file){ 
$color = ($x % 2 == 0)? "<div id='div1'>"  : "<div id='div2'>";
echo "$color<img src=\"/$file\" /><a href=\"/avatares/add/$file\">[+]</a></div>";
$x++;
} 
paginas('avatares',$a,$contar,$id,$atual);
}else
if($a=='times') {
$arquivo = glob('avatars/times/*.*'); 
$total = 10; 
$atual = isset($_GET['pag']) ? intval($_GET['pag']) : 1; 
$pagopen = array_chunk($arquivo,$total); 
$contar = count($pagopen); 
$resultado = $pagopen[$atual-1]; 
$x=0;
foreach($resultado as $file){ 
$color = ($x % 2 == 0)? "<div id='div1'>"  : "<div id='div2'>";
echo "$color<img src=\"/$file\" /><a href=\"/avatares/add/$file\">[+]</a></div>";
$x++;
} 
paginas('avatares',$a,$contar,$id,$atual);
}else
if($a=='bandeirinhas') {
$arquivo = glob('avatars/bandeirinhas/*.*'); 
$total = 10; 
$atual = isset($_GET['pag']) ? intval($_GET['pag']) : 1; 
$pagopen = array_chunk($arquivo,$total); 
$contar = count($pagopen); 
$resultado = $pagopen[$atual-1]; 
$x=0;
foreach($resultado as $file){ 
$color = ($x % 2 == 0)? "<div id='div1'>"  : "<div id='div2'>";
echo "$color<img src=\"/$file\" /><a href=\"/avatares/add/$file\">[+]</a></div>";
$x++;
} 
paginas('avatares',$a,$contar,$id,$atual);
}else
if($a=='personagens') {
$arquivo = glob('avatars/personagens/*.*'); 
$total = 10; 
$atual = isset($_GET['pag']) ? intval($_GET['pag']) : 1; 
$pagopen = array_chunk($arquivo,$total); 
$contar = count($pagopen); 
$resultado = $pagopen[$atual-1]; 
$x=0;
foreach($resultado as $file){ 
$color = ($x % 2 == 0)? "<div id='div1'>"  : "<div id='div2'>";
echo "$color<img src=\"/$file\" /><a href=\"/avatares/add/$file\">[+]</a></div>";
$x++;
} 
paginas('avatares',$a,$contar,$id,$atual);
}else
if($a=='diversos') {
$arquivo = glob('avatars/diversos/*.*'); 
$total = 10; 
$atual = isset($_GET['pag']) ? intval($_GET['pag']) : 1; 
$pagopen = array_chunk($arquivo,$total); 
$contar = count($pagopen); 
$resultado = $pagopen[$atual-1]; 
$x=0;
foreach($resultado as $file){ 
$color = ($x % 2 == 0)? "<div id='div1'>"  : "<div id='div2'>";
echo "$color<img src=\"/$file\" /><a href=\"/avatares/add/$file\">[+]</a></div>";
$x++;
} 
paginas('avatares',$a,$contar,$id,$atual);
}else
if($a=='adicionar'){
$upload_dir = 'avatars/users/';
$superdat = $_FILES['file']['tmp_name'];
$file_name = $_FILES['file']['name'];
$kbsize = (round($_FILES['file']['size']/1024));
$file_na = strrev("$file_name");
$file_na = strrev("$file_na");
$ext = explode(".",strrev($file_na));
switch(mb_strtolower($ext[0])){
case "fig":
$tipo="gif";
break;
case "gnp":
$tipo="png";
break;
case "gpj":
$tipo="jpg";
break;
}
if(!empty($superdat)){
if($kbsize > 50){
echo "<div align='center'><b>Tamanho do arquivo utrapassa limite de 50 kb</b></div>";
}else{
if(file_exists("avatars/users/".$file_name."")){
echo "<div align='center'>$imgerro Nome do arquivo ja existe renomeie o arquivo e tente novamente</div>";
}else{
if($tipo=="gif"||$tipo=="png"||$tipo=="jpg"){
$moedas = $mistake->query("SELECT av FROM w_usuarios WHERE id='$meuid'")->fetch();
if(strripos($moedas[0],'/users/') == true){
@unlink($moedas[0]);
}
//move_uploaded_file("$superdat","".$upload_dir."".$file_name."");
system("convert ".escapeshellarg($superdat)." -coalesce  -sample 50x50  ".escapeshellarg("./avatars/users/".$file_name)."");
$res = $mistake->exec("update w_usuarios set av='avatars/users/".$file_name."' where id='$meuid'");
echo"<div align='center'>$imgok ".gerarnome($meuid)." avatar Adicionado com sucesso</div>";
}
}
}
}
?>
<div align="center">
<form method="post" name="form1" enctype="multipart/form-data" action="/avatares/adicionar"> 
Somente imagens em GIF,JPG,PNG<br>
Imagem:<br><input id='input-file' name='file' type='file' value=''><br>
<input type="submit" class="bt3" value="Enviar" /> 
</form></div>
<?php 
}else
if($a=='add') {
if($id=='remover'){
$moedas = $mistake->query("SELECT av FROM w_usuarios WHERE id='$meuid'")->fetch();
if(strripos($moedas[0],'/users/') == true){
@unlink($moedas[0]);
}
$res = $mistake->exec("update w_usuarios set av='0' where id='$meuid'"); 
}else{
$res = $mistake->exec("update w_usuarios set av='".$id."/".$pag."/".$limite."' where id='$meuid'");    
}
?>
<div align="center">
<?php
if($res) { ?>
<?php echo "$imgok ".gerarnome($meuid)."";?>Sucesso!<br /><br />
<?php } else { ?>
<?php echo $imgerro;?> Opss... algo saiu errado!<br /><br />
<?php } 
?>	
</div>
<?php
}
?>
<br/>

<div align="center">
<a href="/avatares/adicionar">Add Avatar Proprio</a><br /><br />    
<a href="/avatares/add/remover">Remover avatar</a><br /><br />
<a href="/avatares/inicio">Avatares para o nick</a><br /><br />
<a href="/home?"><?php echo $imginicio;?>Página principal</a><br><br>
<?php echo rodape(); ?>
</body>
</html>