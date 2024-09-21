<?php
require_once("".$_SERVER["DOCUMENT_ROOT"]."/funcoes.php");
require_once("".$_SERVER["DOCUMENT_ROOT"]."/mistake.php");
seg($meuid);
/*
Script criado por Fernando Henrique
Contato: fernandos2rita@gmail.com
*/

$a= $_GET["a"];
//$id= $_GET["id"];
$page = $_GET["p"];
$acao = $_POST["acao"];
$pdo = $mistake;
if($a=="todos")
{
echo "<center><div id=\"div2\"><b>Lista de quem possui o mimo</b></div>";
$mimo =  $mistake->query("SELECT mimo FROM lista_mimos WHERE id='".$id."'")->fetch();
echo"<img src=\"/".$mimo[0]."\" alt=\"*\"/><br/></center>"; 
if($pag=="" || $pag<=0)$pag=1;
$noi =  $mistake->query("SELECT COUNT(*) FROM compra_mimos WHERE mimo='".$id."'")->fetch();
$num_items = $noi[0]; //changable
$items_per_page= 5;
$numpag = ceil($num_items/$items_per_page);
if(($pag>$numpag)&&$pag!=1)$pag= $numpag;
$limit_start = ($pag-1)*$items_per_page;
$sql = "SELECT id, who, uid, data FROM compra_mimos WHERE mimo='".$id."' ORDER BY data DESC LIMIT $limit_start, $items_per_page";
echo "<p>";
$items =  $mistake->query($sql);

if($items->rowCount()>0)
{
while ($item = $items->fetch())
{
if ($color == "<div id='div1'>"){$color = "<div id='div2'>";}else{$color = "<div id='div1'>";
}

echo "$color Dono(a): ".gerarnome($item[1])."<br/> Doado por: <b>".gerarnome($item[2])."</b><br/>Data: <b>".date("d/m/Y - H:i:s", $item[3])."</b></div>";
}
}
echo "<p align=\"center\">";
if($numpag>1)
{
paginas('mimos',$a,$numpag,$id,$pag);
}
}
else if($a=="editar-mimo" && perm($meuid)>0)
{
$mid = $_GET["mid"];
$cat = $_POST["cat"];
$descricao = $_POST["descricao"];
echo "<div id='titulo'><b>Editar mimo</b></div>";
echo "<p align=\"center\">";
if(isset($cat))
{
$res =  $mistake->exec("UPDATE lista_mimos SET cat='".$cat."',descricao='".$descricao."' WHERE id='".$id."'");
if($res)
{
echo "<b>Mimo movido com sucesso!</b><br>";
}
else
{
echo "<b>Erro, tente mais tarde!</b><br>";
}
}
$infom =  $mistake->query("SELECT descricao FROM lista_mimos WHERE id='".$id."'")->fetch();
echo "<form action=\"/mimos/$a/$id\" method=\"POST\">";
echo "Descrição : <input name=\"descricao\" value=\"$infom[0]\"><br>";
echo "Mover para: <select name=\"cat\"><br>";
$sql =  $mistake->query("select * from cat_mimos order by nome asc");
while ($na = $sql->fetch()) {
	echo "<option value='$na[id]'>$na[nome]</option>";
}
echo "</select><br>";
echo "<input value=\"Mover\" type=\"submit\"></form><br>";
}
else if($a=="cat-mimos") { ?>
<?php
if(perm($meuid)<2) {
?>
<div align="center">
<b><?php echo $imgerro;?> Você não tem permisão para isso!</b><br /><br />
</div>
<?php
}else{
?>
<br/><div id="titulo"><b>Categoria de mimos</b></div><br/>
<form action="/mimos/cat-mimos" method="post">
<b>Adicionar categoria:</b><br/>
Nome: <input type="text" name="cod">
<input type="submit" value="Add"></form>
<?php
if(isset($_POST['cod'])!='')
{
 $mistake->exec("INSERT INTO cat_mimos(nome) values('".$_POST['cod']."')");
}
if($id==true)
{
$ctft =  $mistake->query("SELECT COUNT(*) FROM cat_mimos WHERE id='$id'")->fetch();
if($ctft[0]>0)
{
 $mistake->exec("DELETE FROM cat_mimos WHERE id='$id'");
}
}
$contemo =  $mistake->query("SELECT COUNT(*) FROM cat_mimos")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contemo[0];
$itensporpag = 8;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens =  $mistake->query("SELECT id, nome FROM cat_mimos ORDER BY id desc LIMIT $limit, $itensporpag");
$i=0; while($item = $itens->fetch(PDO::FETCH_OBJ)) {
$contmimo =  $mistake->query("SELECT COUNT(*) FROM lista_mimos where cat='".$item->id."'")->fetch(); ?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<a href="/mimos/lista/<?php echo $item->id;?>"><?php echo $item->nome;?>(<?php echo $contmimo[0];?>)</a>
<a href="/mimos/cat-mimos/<?php echo $item->id;?>" onclick="return confirm('Você realmente quer apagar essa categoria?')"><font color="red">[apagar]</font></a> - <a href="/mimos/editarcat/<?php echo $item->id;?>"><font color="red">[renomear]</font></a></div>
<?php $i++; } ?>
<div align="center"><br/>
<?php if($numpag>1)
{
paginas('mimos',$a,$numpag,$id,$pag);
} }else { ?>
<div align="center">Não existem categorias de mimos!<br/>
<?php } } }
else if($a=='editarcat') { ?>
<br/><div id="titulo"><b>Renomear categoria</b></div><br/>
<?php
if (empty($_POST['nome'])) { 
}else{
if($pag=='post'){
 $mistake->exec("UPDATE cat_mimos SET nome='".$_POST['nome']."' WHERE id='$id'");
echo"<center><img src=\"images/ok.gif\" alt=\"\"><br /><b>Categoria editada com sucesso!</b></center><br />";
}
}
$nome =  $mistake->query("SELECT nome FROM cat_mimos where id='$id'")->fetch();
?>
<form action="/mimos/editarcat/<?php echo $id;?>/post" method="post">
Renomear:<br/><input type="text" name="nome" value="<?php echo $nome['nome'];?>"/>
<input type="submit" value="Editar" /></form><br/>
<?php }
else if($a=="meus")
{

echo "<br/><p align='center' id='titulo'><b>Lista de mimos de ".gerarnome($id)."</b></p>";
if($pag=="" || $pag<=0)$pag=1;
$noi =  $mistake->query("SELECT COUNT(*) FROM compra_mimos WHERE who='".$id."'")->fetch();
$num_items = $noi[0]; //changable
$items_per_page= 5;
$numpag = ceil($num_items/$items_per_page);
if(($pag>$numpag)&&$pag!=1)$pag= $numpag;
$limit_start = ($pag-1)*$items_per_page;
$sql = "SELECT id, who, uid, data, mimo FROM compra_mimos WHERE who='".$id."' ORDER BY data DESC LIMIT $limit_start, $items_per_page";
echo "<p>";
$items =  $mistake->query($sql);

if($items->rowCount()>0)
{
while ($item = $items->fetch())
{
if ($color == "<div id='div1'>"){$color = "<div id='div2'>";}else{$color = "<div id='div1'>";
}
if(perm($meuid)>2 OR $who==$meuid OR $item[1]==$meuid)
{
$apagar = "<a href=\"/mimos/apaga/$item[0]\">[X]</a>";
}
else{
$apagar = "";
}
$vermimo =  $mistake->query("SELECT mimo FROM lista_mimos WHERE id='".$item[4]."'")->fetch();
echo "$color <img src=\"/".$vermimo[0]."\" style=\"max-width:120px;max-height:120px;width:auto;height: auto;\" alt=\"img\"><br/> Doado por: <b>".gerarnome($item[2])."</b><br/>Data: <b>".date("d/m/Y - H:i:s", $item[3])."</b> $apagar</div>";
}
}
echo "<p align=\"center\">";
if($numpag>0)
{
paginas('mimos',$a,$numpag,$id,$pag);
}
}
else if($a=="apaga")
{
$mimo = $_GET["mimo"];
$ids =  $mistake->query("SELECT uid, who FROM compra_mimos WHERE id='".$id."'")->fetch();
if($ids[0]==$meuid OR $ids[1]==$meuid OR perm($meuid)>2)
{
 $mistake->exec("DELETE FROM compra_mimos WHERE id='".$id."'");
echo "<p align=\"center\"><b>".$imgok."Mimo apagado com sucesso!</b>";
}
else{
echo "<p align=\"center\"><b>".$imgerro."Erro!</b>";
}
}
else if($a == "add")
{
	if(perm($meuid)<2) {echo "Você não tem permissão!"; exit(); }
$cat = $_POST["cat"];
	echo "<div id='titulo'>";
	echo "<b>Adicionar Mimo</b></div>";
echo "<p align='center'>";

	
	if($_POST["acao"] == "Carregar")
	{
		$extensao = pathinfo($_FILES["img"]["name"], PATHINFO_EXTENSION);
		$extensao_validas = array("jpeg", "jpg", "gif", "png", "bmp");
		$descricao = (string)$_POST["descricao"];
		list($altura, $largura) = @getimagesize($_FILES["img"]["tmp_name"]);
		if(!in_array($extensao, $extensao_validas))
		{
			echo $imgerro."<br />Extensão da imagem não permitida!<br />";
		}
		else if(empty($descricao))
		{
			echo $imgerro."<br />Digite a descrição do Mimo<br />";
		}
		else if($altura>200 AND $largura>200)
		{
			echo $imgerro."<br />As imagens não deve ter dimensão maior que 200x200.<br />";
		}
		else
		{
			$caminho = "images/mimos/".date("dmY-")."".date("His").".".$extensao;
			$res =  $mistake->exec("INSERT INTO lista_mimos SET mimo='".$caminho."', descricao='".$descricao."',cat='".$cat."', data='".time()."'");
			if($res)
			{
				move_uploaded_file($_FILES["img"]["tmp_name"], $caminho);
				echo $imgok."<br />Mimo adicionado com sucesso!<br />";
			}
			else
			{
				echo "<img src=\"images/ok.gif\" alt=\"\"><br />Ocorreu um erro :(<br />";
			}
		}
	}
	echo "</p>";
	echo "<form action='/mimos/add' method='POST' enctype=\"multipart/form-data\">";
	echo "Mimo: <input type='file' name='img'/><br />";
	echo "Descrição: <input type='text' name='descricao'/> <br />";
echo "Categoria: <select name=\"cat\"><br>";
$sql =  $mistake->query("select * from cat_mimos order by nome asc");
while ($na = $sql->fetch()) {
	echo "<option value='$na[id]'>$na[nome]</option>";
}
echo "</select><br>";
	echo "<input type='submit' name='acao' value='Carregar'/>";
	echo "</form>";
	
}
else if($a=="add-user")
{
$who = $_POST["who"];
echo "<p align=\"center\"><div id='titulo'><b>Comprar Mimo</b></div><br/><center><b>Cada mimo custa 200 pontos</b><br/></center>";
if(isset($acao))
{
if(pts($meuid)<200)
{
echo "<p align=\"center\">";
echo "<b>Você precisa ter no mínimo 200 pontos para comprar este mimo!</b><br/>";
}
else if($who==$meuid)
{
echo "<p align=\"center\">";
echo "<b>Você não pode comprar para você mesmo!</b><br/>";
}
else
{
$res =  $mistake->exec("INSERT INTO compra_mimos SET data='".time()."', mimo='".$id."',uid='".$meuid."', who='".$who."'");
echo "<p align=\"center\">";
if($res)
{
$nm2 =  $mistake->query("SELECT nm FROM w_usuarios WHERE id='$meuid'")->fetch();
$msg = "Oi, você recebeu um mimo comprado por ".html_entity_decode($nm2[0])." para ve-lo [link=/mimos?a=meus&who=$who]Clique aqui[/link]";
automsg($msg,1,$who);
$ns = pts($meuid) - 200;

 $mistake->exec("UPDATE w_usuarios SET pt='".$ns."' WHERE id='".$meuid."'");
echo "<b>Compra realizada com sucesso!</b><br/>";
}
else{
echo "<b>Ocorreu um erro!</b><br/>";
}
}
}
echo "<form action=\"/mimos/$a/$id\" method=\"post\">";
echo "ID do usuário: <input name='who' size='5' required/><br/>";
echo"<input type='submit' name='acao' value='CONFIRMAR COMPRA'/></form>"; 
}
else if($a =="apagar-mimo")
{
if(perm($meuid)==0)
{
exit(); 
}
echo"<p align=\"center\">";
$c = $_GET["c"];
if($pag =="sim")
{
$xx =  $mistake->query("SELECT mimo FROM lista_mimos WHERE id='".(int)$_GET["id"]."'")->fetch();
	@unlink($xx[0]);
	$res =  $mistake->exec("DELETE FROM lista_mimos WHERE id='".(int)$_GET["id"]."'");

echo "<b>Mimo apagado com sucesso!</b><br/>";
}
else {
echo "<b>Têm certeza que deseja apagar esse mimo?</b><br/><br/><a href=\"/mimos?\">NÃO</a> <a href=\"/mimos/apagar-mimo/".(int)$_GET["id"]."/sim\">SIM</a>";
}
}
else if($a =="lista")
{
$c= $_GET["c"];
echo "<br/><p align=\"center\" id='titulo'><b>Lista de Mimos</b><br/></p>";
if($pag=="" || $pag<=0)$pag=1;
$noi =  $mistake->query("SELECT COUNT(*) FROM lista_mimos where cat='".$id."'")->fetch();
$num_items = $noi[0]; //changable
$items_per_page= 5;
$numpag = ceil($num_items/$items_per_page);
if(($pag>$numpag)&&$pag!=1)$pag= $numpag;
$limit_start = ($pag-1)*$items_per_page;
$sql = "SELECT id, descricao, data, mimo FROM lista_mimos where cat='".$id."' ORDER BY id DESC LIMIT $limit_start, $items_per_page ";
echo "<p>";
$items =  $mistake->query($sql);

if($items->rowCount()>0)
{
while ($item = $items->fetch())
{
$Total =  $mistake->query("SELECT COUNT(*) FROM compra_mimos WHERE mimo='".$item[0]."'")->fetch();
if ($color == "<div id='div1'>"){$color = "<div id='div2'>";}else{$color = "<div id='div1'>";}
if(perm($meuid)>2)
{
$apagar = "<a href=\"/mimos/apagar-mimo/$item[0]/$pag\">[X]</a> - <a href=\"/mimos/editar-mimo/$item[0]\">[Mover]</a>";
}
else{
$apagar = "";
}
echo "$color <center><img src=\"/".$item[3]."\" alt=\"\" style=\"max-width:80px;max-height:90px;width:auto;height: auto;\"/></center>
<br/>Descrição: ".$item[1]."
<br/>Data: ".date("d/m/Y - H:i:s", $item[2])." $apagar<br/>";
echo "<a href=\"/mimos/todos/$item[0]\">Ver quem têm(".$Total[0].")</a><br/>";
echo "<a href=\"/mimos/add-user/$item[0]/\">[COMPRAR]</a></div>";
}
}
echo "<p align=\"center\">";
if($numpag>1)
{
paginas('mimos',$a,$numpag,$id,$pag);
}
}
else{
echo "<p align=\"center\">";
echo "<b> <div id='titulo'> Categorias de mimos</b></div></p>";
$sql =  $mistake->query("select * from cat_mimos order by nome asc");
$num=0; 
while ($item = $sql->fetch()) {
if ($color == "<div id='div1'>"){$color = "<div id='div2'>";}else{$color = "<div id='div1'>";}
	$conta =  $mistake->query("SELECT COUNT(*) FROM lista_mimos WHERE cat='$item[id]'")->fetch();
echo "$color<a href=\"/mimos/lista/$item[id]/0\">".$imgseta."$item[nome]($conta[0])</a>";
if(perm($meuid)>2){
	echo "<a href=\"/mimos/editarcat/$item[id]\"> <font color='red'>[+]</font></a>";
}else{
}

echo "</div>";

}
//echo "<br/><a href=\"/mimos/lista\">&#187;Todos os mimos </a>";
}
echo "<p align='center'>";
if(perm($meuid)>2) {echo "<a href=\"/mimos/add\">Adicionar mimo</a><br />";
echo "<a href=\"/mimos/cat-mimos\">Gerenciar categorias </a><br />";}

if(!empty($a)) echo "<a href=\"/mimos\">".$imgsetavoltar."Mimos</a><br />";

echo "<a href=\"/home?\">".$imginicio."Página principal</a>";
echo "</p>";
rodape();
echo "</body>";
echo "</html>";
?>