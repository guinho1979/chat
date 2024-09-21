<?php
require_once("".$_SERVER["DOCUMENT_ROOT"]."/funcoes.php");
require_once("".$_SERVER["DOCUMENT_ROOT"]."/mistake.php");
if(urldecode(basename($_SERVER['REQUEST_URI']))){
$info = $mistake->prepare("SELECT * FROM w_usuarios WHERE lg=:lg");
$info->execute(array(":lg"=>"".urldecode(basename($_SERVER['REQUEST_URI'])).""));
$info = $info->fetch();
require_once("".$_SERVER["DOCUMENT_ROOT"]."/perfil.php");
rodape(); 
}else{
require_once("".$_SERVER["DOCUMENT_ROOT"]."/principal.php");
rodape(); 
$sql = "SELECT * FROM w_parceiros WHERE banner IS NOT NULL ORDER BY rand() LIMIT 1";
$query = $mistake->prepare($sql);
$query->execute();
if($query->rowCount()>0){
$x = 0;
while ($item = $query->fetch()){
echo"<a href='".$item['url']."' target='_blank' title='".$item['nm']."'><div style='background-image:url(/".$item['banner'].");background-size:33% 100%;height:70px;padding:10px;'></div></a>";	
$x++;
}
}
}
?>
</body>
</html>
