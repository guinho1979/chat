<?php
require_once("".$_SERVER["DOCUMENT_ROOT"]."/funcoes.php");
require_once("".$_SERVER["DOCUMENT_ROOT"]."/mistake.php");
seg($meuid);
ativo($meuid,'Votando no Gato e Gata');
if($a == "a" || !$a){
$idnick = gerarnome($id);
echo "<div id='titulo'>Votos de <a href='/".gerarlogin($id)."'>$idnick</a></div><br>";
$pontos = $mistake->prepare("SELECT pt FROM w_usuarios WHERE id='".$meuid."'");
$pontos->execute();
$pontos = $pontos->fetch();
if($pontos[0] < "500"){
echo "<p align='center'>";
echo "<img src='/imagens/notok.gif' alt='atencao' title='atencao'/><br>Você não tem pontos suficientes para votar<br>Você precisa ter no minimo 500 pontos<br>";
}else{
if($pag=="" || $pag<=0)$pag=1;
$noi = $mistake->prepare("SELECT COUNT(*) FROM Mmistake_gatov WHERE who='".$id."'");
$noi->execute();
$noi = $noi->fetch();
$num_items = $noi[0];
$items_per_page= 50;
$num_pages = ceil($num_items/$items_per_page);
if(($pag>$num_pages)&&$pag!=1)$pag= $num_pages;
$limit_start = ($pag-1)*$items_per_page;
$sql = "SELECT * FROM Mmistake_gatov WHERE who='".$id."' ORDER BY data DESC LIMIT $limit_start, $items_per_page";
$items = $mistake->prepare($sql);
$items->execute();
if($items->rowCount()>0){
$x = 0;
while ($item = $items->fetch()){
$color = ($x % 2 == 0)? "<div id='div1'>"  : "<div id='div2'>";
if(perm($meuid)==3 or perm($meuid)==4){
$delnk = "<a href='/gatov?a=d&id=".$item["id"]."'>[x]</a>";
}else{
$delnk = "";
}
echo ''.$color.' <a href="/'.gerarlogin($item["uid"]).'">'.gerarnome($item['uid']).'</a> '.$delnk.'<br>Voto dado em: <b>'.date('d/m/Y - H:i:s', $item["data"]).'</b>';
echo '</div>';
$x++;
}
}else{
if($meuid == $id){
echo "<p align='center'>";
echo "<img src='/imagens/notok.gif' alt='atencao!'/><br>Você nao tem votos";
echo "</p>";
}else{
echo "<p align='center'>";
echo "<img src='/imagens/notok.gif' alt='atencao!'/><br>Este candidato(a) nao tem votos";
echo "</p>";
}
}
?>
<br/>
<div align="center"><br/>
<?php if($pag>1) { $ppag = $pag-1; ?>
<a href="gatov?pag=<?php echo $ppag;?>">&#171;Anterior</a>
<?php } if($pag<$num_pages) { $npag = $pag+1; ?>
<a href="gatov?pag=<?php echo $npag;?>">Próxima&#187;</a>
<?php } ?> <br/> <?php echo $pag.'/'.$num_pages;?><br/>
<?php if($num_pages>2) { ?>
<form action="gatov?" method="get">
Pular para página<input name="pag" size="3">
<input type="submit" value="IR">
</form>
<?php 
}
echo "<p align='center'>";
if($meuid == $id){
echo "";
}else{
echo "<a href='/gatov?a=b&id=".$id."'>Votar em $idnick</a><br>";
}  
}
echo "</p>";
}else 
if($a == "b"){
$idnick = gerarnome($id);
echo "<div id='titulo'>Votos de <a href='/".gerarlogin($id)."'>$idnick</a></div><br>";
$cont = $mistake->prepare("SELECT COUNT(*) FROM Mmistake_gatov WHERE uid='".$meuid."' AND who='".$id."'");
$cont->execute();
$cont = $cont->fetch();
echo "<p align='center'>";
if($cont[0]>0){
echo "<img src='/imagens/notok.gif' alt='X'/><br>Você ja votou no gato(a) deste mes<br>";
}else{
if($meuid==$id){
echo "<img src='/imagens/notok.gif' alt='X'/><br>Você não pode votar em você mesmo<br><br>";
}else{
$contx = $mistake->prepare("SELECT sx FROM w_usuarios WHERE id='".$id."'");
$contx->execute();
$contx = $contx->fetch();
$res = $mistake->exec("INSERT INTO Mmistake_gatov SET uid='".$meuid."',who='".$id."',data='".time()."',sexo='".$contx[0]."'");
$mistake->exec("UPDATE w_usuarios SET pt=pt+500 WHERE id='".$meuid."'");
$petatual =  $mistake ->query("SELECT uid FROM Mmistake_gatov WHERE who='".$id."' order by id desc limit 1")->fetch();
if($res){
echo "<img src='/imagens/ok.gif' alt='ok'/><br>Voto efetuado com sucesso em $idnick<br>";
}else{
echo "<img src='/imagens/notok.gif' alt='atencao'/><br>Erro ao ser adicionado voto<br>";
}
}
}
echo "</p>";
}else 
if($a=="d"){
echo "<p align='center'>";
if(perm($meuid)==3 or perm($meuid)==4){
$res = $mistake->exec("DELETE FROM Mmistake_gatov WHERE id='".$id."'");
if($res){
echo "<img src='/imagens/ok.gif' alt='o'/><br>voto removido com sucesso<br>";
}else{
echo "<img src='/imagens/notok.gif' alt='x'/><br>Erro no banco de dados<br>";
}
}else{
echo "<img src='/imagens/notok.gif' alt='X'/><br>Voce nao pode fazer isso";
}
}
echo "<p align='center'>";
echo "<img src='/imagens/gato.gif' alt='gatogata'/><a href=\"/gato\">Gato e Gata</a></br>";
echo "</p>";
?>
<br/><div align="center"><a href="galeria?"><?php echo $imgalbuns;?>Álbuns</a> 
<br/><div align="center"><a href="home?"><?php echo $imginicio;?>Página principal</a><br><br>
<?php echo rodape();?>
</body>
</html>