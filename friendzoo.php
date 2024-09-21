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
ativo($meuid,'Friend zoo');

$who = $_GET["who"];

$id = $_GET["id"];
$e = $_GET["e"];
$a = $_GET["a"];
$page = $_GET["page"];
$action  = $_GET["a"];
$pagina = "?";

 $mistake =  $mistake;

if($e == "participar")
{
	$ver =  $mistake->query("SELECT zoo,petzoo FROM w_usuarios WHERE id='".$meuid."'")->fetch();
if($_GET['acao'] == "sair" AND $ver[0] ==1)
	{
 $mistake->exec("DELETE FROM meus_zoo WHERE uid='".$meuid."' ");
	 $mistake->exec("UPDATE w_usuarios SET zoo='0',valorzoo='0', petzoo='0' WHERE id='".$meuid."'");
 $mistake->exec("UPDATE w_usuarios SET petzoo='0' WHERE petzoo='".$meuid."'");
echo "<p align=\"center\">";
echo "<img src='images/ok.gif' alt='*'/> Você saiu do friend zoo com sucesso!";
echo "</p>";

echo "<p align=\"center\">";
echo "<a href='friendzoo.php?'> Friend zoo</a><br/>";

    ?>
<a href="home?"><?php echo $imginicio;?>Página principal</a><br><br>
<?php echo rodape();
	}
	else if($ver[0] == 1)
	{
echo "<p align=\"center\">";
echo "<img src='images/notok.gif' alt='*'/> Você já está participando do friend zoo!";
echo "</p>";

echo "<p align=\"center\">";
echo "<a href='friendzoo.php?'> Friend zoo</a><br/>";

    ?>
<a href="home?"><?php echo $imginicio;?>Página principal</a><br><br>
<?php echo rodape();
exit();
	}

	else if(pts($meuid)<200)
	{
echo "<p align=\"center\">";
echo "<img src='images/notok.gif' alt='*'/> Você precisa ter 200 pontos para participar!";
echo "</p>";

echo "<p align=\"center\">";
echo "<p align=\"center\">";
echo "<a href='friendzoo.php?'> Friend zoo</a><br/>";

    ?>
<a href="home?"><?php echo $imginicio;?>Página principal</a><br><br>
<?php echo rodape();
exit();
	}
	else{
		$res =  $mistake->exec("UPDATE w_usuarios SET zoo='1', valorzoo='50' WHERE id='".$meuid."'");
		if($res)
		{
			$pontos = pts($meuid) - 200;
			$res =  $mistake->query("UPDATE w_usuarios SET pt='".$pontos."' WHERE id='".$meuid."'");

echo "<p align=\"center\">";
echo "<img src='images/ok.gif' alt='*'/>Você agora está participando do friend zoo, foi descontado 200 pontos do seu perfil!";
echo "</p>";
echo "<p align=\"center\">";
echo "<a href='friendzoo.php?'> Friend zoo</a><br/>";

    ?>
<a href="home?"><?php echo $imginicio;?>Página principal</a><br><br>
<?php echo rodape();
exit();
		}

		else
		{

echo "<p align=\"center\">";
echo "<img src='images/notok.gif' alt='*'/>Deu erro!";
echo "</p>";
echo "<p align=\"center\">";
echo "<a href='friendzoo.php?'> Friend zoo</a><br/>";

    ?>
<a href="home?"><?php echo $imginicio;?>Página principal</a><br><br>
<?php echo rodape();
exit();
	}
	}
}
else if($e == "meus")
{
$who = (int)$_GET["who"];
echo "<div id='titulo'>";
echo "<b>Pets de ".gerarnome($who,  $mistake)."</b></div><br/>";
echo "</p>";
$page = $_GET["page"];
//////ALL LISTS SCRIPT <<
if($page=="" || $page<=0)$page=1;
$num_items =  $mistake->query("SELECT COUNT(*) FROM meus_zoo WHERE uid='".$who."'")->fetch(); //changable
$num_items = $num_items[0];
$items_per_page= 10;
$num_pages = ceil($num_items/$items_per_page);
if(($page>$num_pages)&&$page!=1)$page= $num_pages;
$limit_start = ($page-1)*$items_per_page;
//changable sql
if($_GET["acao"] == "remover" OR perm($meuid,  $mistake))
{
	 $mistake->query("DELETE FROM meus_zoo WHERE who='".(int)$_GET["id"]."' AND uid='".$meuid."' ");
}else{}
$sql = "SELECT * FROM meus_zoo WHERE uid='".$who."' ORDER BY data DESC LIMIT $limit_start, $items_per_page";
echo "<p>";
$items =  $mistake->query($sql);
if($items->rowCount()>0)
{
while ($item = $items->fetch())
{
if(perm($meuid,  $mistake)>0) $LinkRemover = "<a href='?id=$item[id]&acao=remover&e=$e&who=$who&page=$page&id=$item[who]'>[REMOVER PET]</a>";
echo "$color <a href=\"".gerarlogin($item["id"])."\">".gerarnome($item["who"])." </a><br/>";
echo "Valor: <b>".$item["valor"]."</b> pontos<br />";
echo "Comprado em: <b>".date("d/m/Y - H:i:s", $item["data"])."</b> $LinkRemover <br />";
echo "<hr>";
}
}
else
{
echo "<p align=\"center\">";
echo "<img src=\"images/notok.gif\" alt=\"\"><br />";
echo "<b>O usuário ".gerarnome($who,  $mistake)." não comprou pets!</b><br/>";
echo "</p>";
}
echo "</p>";
echo "<p align=\"center\">";
if($page>1)
{
$ppage = $page-1;
echo "<a href=\"?action=$action&page=$ppage&who=$who\">&#171;Anterior</a> ";
}
if($page<$num_pages)
{
$npage = $page+1;
echo "<a href=\"?action=$action&page=$npage&who=$who\">Proximo&#187;</a>";
}
echo "<br/>$page/$num_pages<br/>";
if($num_pages>2)
{
$rets = "<form action=\"?\" method=\"get\">";
$rets .= "Pular a pagina: <input name=\"page\" format=\"*N\" size=\"3\"/>";
$rets .= "<input type=\"submit\" value=\"OK\"/>";
$rets .= "<input type=\"hidden\" name=\"action\" value=\"$action\"/>";
$rets .= "<input type=\"hidden\" name=\"who\" value=\"$who\"/>";
$rets .= "</form>";
echo $rets;
}
echo "<p align=\"center\">";


    ?>
<a href="home?"><?php echo $imginicio;?>Página principal</a><br>
<?php echo rodape();
}

else if($e=="lista")
{
$t = $_GET["t"];
ativo($meuid,"Lista de Friend zoo","");
echo "<div id='titulo'><b>Lista de Friend zoo</b></div><br/>";
?>
<div align="center">
Filtrar por:<select onChange="location=options[selectedIndex].value">
<option value="">Selecione</option>
<option value="/friendzoo?e=lista">Todos</option>
<option value="/friendzoo?e=lista&t=barato">Mais baratos</option>
<option value="/friendzoo?e=lista&t=caro">Mais caros</option>
<option value="/friendzoo?e=lista&t=H">Homens</option>

<option value="/friendzoo?e=lista&t=M">Mulheres</option>
</select></div>
<br/><?php
if($t=='H')
{
$where = "where zoo>'0' and sx='M'";
$pr = "<input type='hidden' name='t' value='H'>";
$prr = "&s=H";
$ord = 'valorzoo desc';
}
else if($t=='M')
{
$where = "where zoo>'0' and sx='F'";
$pr = "<input type='hidden' name='t' value='F'>";
$prr = "&s=F";
$ord = 'valorzoo desc';
}
else if($t=='caro')
{
$where = "where zoo>'0'";
$pr = "<input type='hidden' name='t' value='caro'>";
$prr = "&s=caro";
$ord = 'valorzoo desc';
}
else if($t=='barato')
{
$where = "where zoo>'0'";
$pr = "<input type='hidden' name='t' value='barato'>";
$prr = "&s=barato";
$ord = 'valorzoo asc';
}
else
{
$where = "where zoo>'0'";
$ord = 'valorzoo desc';
}
$zoo =  $mistake->query("SELECT zoo,petzoo, valorzoo FROM w_usuarios WHERE id='".$meuid."'")->fetch();
$page = $_GET["p"];
if($page=="" || $page<=0)$page=1;
$noi =  $mistake->query("SELECT COUNT(*) FROM w_usuarios $where")->fetch();
$num_items = $noi[0];
$items_per_page= 5;
$num_pages = ceil($num_items/$items_per_page);
if(($page>$num_pages)&&$page!=1)$page= $num_pages;
$limit_start = ($page-1)*$items_per_page;
$sql = "SELECT id, zoo,valorzoo,ft,x_zoo,petzoo FROM w_usuarios $where ORDER BY $ord  LIMIT $limit_start, $items_per_page";

$items =  $mistake->query($sql);

if($items->rowCount()>0)
{
while($item = $items->fetch())
{
if($item['ft']==true) {
$foto = $item['ft'];
}else{
$foto = 'semfoto.jpg';
}
$avatar = "<img src=\"/$foto\" style=\"width:100px;height:90px;padding:4px;\">";
if ($color == "<div id='div1'>"){$color = "<div id='div2'>";}else{$color = "<div id='div1'>";}
echo "$color <a href=\"".gerarlogin($item[0])."\">".$avatar."".gerarnome($item[0])." </a><br/>
Preço: <b>".$item[2]."</b> pontos <br/>Alugado(a) <b>".$item[4]."</b> vez(es)<br/>";
if(!empty($item[5])){
echo"<br/>Último comprador: <b>".gerarnome($item[5])."</b><br/>";
}

if($zoo[0]=="1"){
echo"<a href='?e=alugar&id=$item[0]'>[ALUGAR]</a><br />";
}
else{
echo"<font color='red'><b>Para comprar esse pet você precisa participar do friend zoo.</b></font><br/>";
}
echo"</div>";
}
}
echo "<p align=\"center\">";
if($page>1)
{
$ppage = $page-1;
echo "<a href=\"?e=$e&p=$ppage&t=$t\">&#171;Voltar</a> ";
}
if($page<$num_pages)
{
$npage = $page+1;
echo "<a href=\"?e=$e&p=$npage&t=$t\">Mais&#187;</a> ";
}
echo "<br/>$page/$num_pages<br/>";
if($num_pages>2)
{
$rets = "<form action=\"?\" method=\"get\">";
$rets .= "Pular para página: <input name=\"p\" format=\"*N\" size=\"3\"/>";
$rets .= "<input type=\"submit\" value=\"OK\"/>";
$rets .= "<input type=\"hidden\" value=\"$e\" name=\"e\"/>";
$rets .= "<input type=\"hidden\" value=\"$t\" name=\"t\"/>";
$rets .= "</form>";
echo $rets;
}
echo "<p align=\"center\">";
echo "<a href='friendzoo.php?'> Friend zoo</a><br/>";

    ?>
<a href="home?"><?php echo $imginicio;?>Página principal</a><br><br>
<?php echo rodape();
exit();
}
else if($e == "alugar")
{
$id = (int)$_GET["id"];
	echo "<p align='center'>";
	echo "<b>Alugar ".gerarnome($id)."</b><br />";
	echo "</p>";

$conta =  $mistake->query("SELECT COUNT(*) FROM meus_zoo WHERE who='".$id."' and uid='".$meuid."'")->fetch(); //
	$verzoo =  $mistake->query("SELECT zoo,petzoo, valorzoo FROM w_usuarios WHERE id='".$id."'")->fetch();
$meuzoo =  $mistake->query("SELECT zoo,petzoo FROM w_usuarios WHERE id='".$meuid."'")->fetch();
$petatual =  $mistake ->query("SELECT uid FROM meus_zoo WHERE who='".$id."' order by id desc limit 1")->fetch();
	echo "<p align='center'>";
	 if($verzoo[1]>pts($meuid))
	{
		echo  "<img src=\"images/notok.gif\" alt=\"*\"/> Você não têm pontos suficientes!<br />";
	}
	else if($verzoo[0]==0)
	{
		echo  "<img src=\"images/notok.gif\" alt=\"*\"/> ".gerarnome($id)." não está no friend zoo.<br />";
	}
else if($id==$meuid)
	{
		echo  "<img src=\"images/notok.gif\" alt=\"*\"/> Você não pode alugar você mesmo no friend zoo.<br />";
	}
else if($meuzoo[0]==0)
	{
		echo  "<img src=\"images/notok.gif\" alt=\"*\"/> Você não está no friend zoo.<br />";
	}
else if($verzoo[1]==$meuidd)
	{
		echo  "<img src=\"images/notok.gif\" alt=\"*\"/> ".gerarnome($id)." está alugado por você atualmente, escolha outro pet.<br />";
	}
else if($petatual[0]==$meuid)
	{
		echo  "".$imgerro."Você não pode alugar o mesmo ususúario 2 vezes seguidas,aguarde algum membro alugar para você alugar novamente.<br />";
	}
	else
	{
$pontosadd =  $verzoo[2] + 5;
$pontostira =  pts($meuid) - 5;

		$res =  $mistake->exec("UPDATE w_usuarios set pt='".$pontostira."' WHERE id='".$meuid."'");
		if($res)
		{
 $mistake->exec("INSERT INTO meus_zoo SET uid='".$meuid."', who='".$id."', valor='".$pontosadd."', data='".time()."'");
 $mistake->exec("UPDATE w_usuarios set valorzoo='".$pontosadd."', petzoo='".$meuid."', x_zoo=x_zoo+1,pt=pt+500 WHERE id='".$id."'");
$nm2 =  $mistake->query("SELECT nm FROM w_usuarios WHERE id='$meuid'")->fetch();
$msg = "Oi, você foi alugado por  ".html_entity_decode($nm2[0])." no friend zoo por ".$pontosadd." pontos.";
//automsg($msg,$meuid,$id);
 $mistake->exec("INSERT INTO w_notificacoes (texto,para,data,lida) values('".$msg."','".$id."','".time()."','0')");
			echo  "<img src=\"images/ok.gif\" alt=\"*\"/>!<br />Você alugou ".gerarnome($id)." no friend zoo com sucesso.";
			
		}
		else
		{
			echo  "<img src=\"images/notok.gif\" alt=\"*\"/> Ocorreu um erro!<br />";
		}
	}
echo "<p align=\"center\">";
echo "<a href='friendzoo.php?'> Friend zoo</a><br/>";

    ?>
<a href="home?"><?php echo $imginicio;?>Página principal</a><br><br>
<?php echo rodape();
exit();
}
else
{
echo "<div id='titulo'>";
echo "<b>Friend zoo</b></div><br/>";
$ver =  $mistake->query("SELECT zoo,petzoo FROM w_usuarios WHERE id='".$meuid."'")->fetch();
$contar =  $mistake->query("SELECT count(*) FROM w_usuarios WHERE zoo>'0'")->fetch();
$meus =  $mistake->query("SELECT count(*) FROM meus_zoo WHERE uid='".$meuid."'")->fetch();
$petatual =  $mistake->query("SELECT who FROM meus_zoo WHERE uid='".$meuid."' order by id desc limit 1")->fetch();
    echo "<br/>";
echo "<a href='?e=lista'>&#187;Lista de Friend zoo($contar[0])</a><br />";
if($petatual[0]>0)
{
echo"Pet mais recente: <b>".gerarnome($petatual[0])."</b><br/>";
}
else{}
	if($ver[0] == 0)
	{
echo confirJS("participar", "Você têm absoluta certeza que deseja participar do friend zoo?", "?e=participar");
		echo "<a href='#' onclick='participar()''>Participar do Friend zoo</a><br />";
	}
	else{
echo confirJS("sair", "Você têm absoluta certeza que deseja sair do friend zoo? isso apagará seus pets atuais.", "?e=participar&acao=sair");
		echo "<a href='#' onclick='sair()'>Sair do Friend zoo</a><br />";
	}
    echo "<p align=\"center\">";
if($meus[0]>0)echo "<a href='?e=meus&who=$meuid'>Meus pets(".$meus[0].")</a><br />";

    ?>
BBCode:<br /><input type="text" value="[friendzoo]Friend Zoo[/friendzoo]"><br/>
<a href="home?"><?php echo $imginicio;?>Página principal</a><br>
<?php echo rodape();
}
echo "</body>";
	echo "</html>";
?>