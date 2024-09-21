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
ubloq($meuid,$id);
 $mistake =  $mistake;
///excluir status expirados
 $mistake->query("DELETE FROM status_alugado WHERE validade<'".time()."'");
$action = $_GET["action"];

$page = $_GET["page"];
 $mistake =  $mistake;
if($action == "alugar")
{
	echo "<p align='center' id='titulo'>";
	echo "Alugando status<br />";
	echo "</p>";
	$id = (int)$_GET["id"];
	$dados =  $mistake->query("SELECT *, COUNT(*) FROM status_a_alugar WHERE id='".$id."'")->fetch();
	$veralu =  $mistake->query("SELECT COUNT(*) FROM status_alugado WHERE uid='".$meuid."'")->fetch();
	echo "<p align='center'>";
	if($dados["COUNT(*)"] == 0)
	{
		echo"<img src=\"images/notok.gif\" alt=\"*\"/>Status não encontrado!<br />";
	}
	else if($dados["valor"]>pts($meuid))
	{
		echo  "<img src=\"images/notok.gif\" alt=\"*\"/> Você não têm pontos suficientes!<br />";
	}
	else if($veralu[0]>0)
	{
		echo  "<img src=\"images/notok.gif\" alt=\"*\"/> Você já possui um status alugado, Exclua ou aguarde expirar para poder comprar outro!<br />";
	}
	else if(perm($mmeuid)>0)
	{
		echo  "<img src=\"images/notok.gif\" alt=\"*\"/> Membros da equipe não pode usar esse serviço pois já possui status!<br />";
	}
	else
	{
		$periodo = ($dados["periodo"]*24*60*60) + time();
		$res =  $mistake->query("INSERT INTO status_alugado SET uid='".$meuid."', nome='".$dados["nome"]."', validade='".$periodo."', data='".time()."'");
		if($res)
		{
			$pontos = pts($meuid) - $dados["valor"];
			 $mistake->query("UPDATE  w_usuarios set pt='".$pontos."' WHERE id='".$meuid."'");
			echo  "<img src=\"images/ok.gif\" alt=\"*\"/> Status alugado com sucesso! <br /> Irá expirar em ".date("d/m/Y", $periodo)."!<br />";
		}
		else
		{
			echo  "<img src=\"images/notok.gif\" alt=\"*\"/> Ocorreu um erro!<br />";
		}
	}
}
////lista de alugados
else if($action=="alugados")
{
ativo($meuid,"Vendo lista de status alugados","");
echo "<p align=\"center\" id='titulo'><b>Usuários com status alugado</b></p><br/>";
$page = $_GET["p"];
if($page=="" || $page<=0)$page=1;
$noi =  $mistake->query("SELECT COUNT(*) FROM status_alugado")->fetch();
$num_items = $noi[0];
$items_per_page= 10;
$num_pages = ceil($num_items/$items_per_page);
if(($page>$num_pages)&&$page!=1)$page= $num_pages;
$limit_start = ($page-1)*$items_per_page;
$sql = "SELECT uid, nome,validade,data FROM status_alugado ORDER BY data DESC LIMIT $limit_start, $items_per_page";

$items =  $mistake->query($sql);

if($items->rowCount()>0)
{
while($item = $items->fetch())
{
$color = ($num % 2 == 0)? "<div id='div1'>"  : "<div id='div2'>";
echo "$color Alugado por: <a href=\"".gerarlogin($item[0])."\">".gerarnome($item[0])."</a><br/>Status: <font style=\"color: #990000\"><b>$item[1]</b></font><br/>Alugado em: <b>".date("d/m/Y", $item[3])."</b><br/> Irá expirar em: <b>".date("d/m/Y", $item[2])."</b></div>";
$num++;
}
}
echo "<p align=\"center\">";
if($page>1)
{
$ppage = $page-1;
echo "<a href=\"?action=$action&p=$ppage\">&#171;Voltar</a> ";
}
if($page<$num_pages)
{
$npage = $page+1;
echo "<a href=\"?action=$action&p=$npage\">Mais&#187;</a> ";
}
echo "<br/>$page/$num_pages<br/>";
if($num_pages>2)
{
$rets = "<form action=\"aluguel?\" method=\"get\">";
$rets .= "Pular para página: <input name=\"p\" format=\"*N\" size=\"3\"/>";
$rets .= "<input type=\"submit\" value=\"OK\"/>";
$rets .= "<input type=\"hidden\" value=\"$action\" name=\"action\"/>";
$rets .= "</form>";
echo $rets;
}
//echo "<p align=\"center\"><a href=\"?\">Alugar status</a></p>";
}
else if($action == "painel")
{
	echo "<p align='center' id='titulo'>";
	echo "Painel dos status<br />";
	echo "</p>";
	if(perm($meuid)==0)
	{
		echo "<p align='center'>";
		echo  "<img src=\"images/notok.gif\" alt=\"*\"/> Você não tem permissão pra acessar essa página!<br />";
		echo "</p>";
	}
	else
	{
		if(isset($_POST["ok"]))
		{
			$nome = (string)$_POST["nome"];
			$periodo = (int)$_POST["periodo"];
			$valor = (int)$_POST["valor"];
			echo "<p align='center'>";
			if(strlen($nome)<3)
			{
				echo  "<img src=\"images/notok.gif\" alt=\"*\"/> O nome do status está muito curto!<br />";
			}
			else if($periodo == 0)
			{
				echo  "<img src=\"images/notok.gif\" alt=\"*\"/> Insira um período­ que o status deve ficar no perfil do usuário.<br />";
			}
			else
			{
				$res =  $mistake->query("INSERT INTO status_a_alugar SET nome='".$nome."', periodo='".$periodo."', valor='".$valor."'");
				if($res)
				{
					echo  "<img src=\"images/ok.gif\" alt=\"*\"/> Status criado com sucesso!<br />";

				}
				else
				{
					echo  "<img src=\"images/notok.gif\" alt=\"*\"/> Ocorreu um erro!<br />";
				}
			}
		}else{}
		echo "</p>";
		
		echo "<form action='' method='POST'>";
		echo "Nome do status: <input type='text' name='nome' value='' maxlength='40' required/><br />";
		echo "Período: <input type='text' name='periodo' value='' maxlength='2' required/> dia(s)<br />";
		echo "Valor: <input type='text' name='valor' value='' maxlength='5' required/> pontos<br />";
		echo "<input type='submit' name='ok' value='Criar' />";
		echo "</form><br />";
	}
}
else if($action == "meu-status")
{
echo "<p align='center' id='titulo'>";
echo "<b>Dados do seu status</b></p><br/>";

$dados =  $mistake->query("SELECT *, COUNT(*) FROM status_alugado WHERE uid='".$meuid."'")->fetch();
if($dados["COUNT(*)"]>0)
{
	if($_GET["acao"] == "excluir")
	{
	$res =  $mistake->query("DELETE FROM status_alugado WHERE uid='".$meuid."'");
	if($res)
	{

		exit(header("Location: ?#".time()));
	}
	else
	{
		echo "<script>alert('Ocorreu um erro ao excluir!')</script>";
	}
	}else{}
	echo "Status atual: <b>".$dados["nome"]."</b><br />";
	echo "Alugado em: <b>".date("d/m/Y", $dados["data"])."</b><br />";
	echo "Válido até: <b>".date("d/m/Y", $dados["validade"])."</b><br /><br />";
	echo "<a href='#' onclick='excluir()'>[EXCLUIR STATUS]</a>";
	echo confirJS("excluir", "Você têm absoluta certeza que deseja excluir seu status atual?", "?action=$action&acao=excluir");
	echo "<br />";
}
else{
	echo "<center>Você não têm status!</center>";
}
}
else
{
//ativo($meuid,"Vendo status para alugar","");
echo "<p align='center' id='titulo'>";
echo "<b>Status para Aluguel</b></p>";
$dados =  $mistake->query("SELECT *, COUNT(*) FROM status_alugado WHERE uid='".$meuid."'")->fetch();
if($dados["COUNT(*)"]>0)
{
	echo "<center><a href='?action=meu-status'>[Meu status]</a></center><br />";
}
echo "</p>";
if($_GET["acao"] == "apagar" && perm($meuid)>0)
{
	$res =  $mistake->query("DELETE FROM status_a_alugar WHERE id='".$_GET["id"]."'");
	if($res)
	{

		exit(header("Location: ?#".time()));
	}
	else
	{
		echo "<script>alert('Ocorreu um erro ao excluir!')</script>";
	}
}
//////ALL LISTS SCRIPT <<
if($page=="" || $page<=0)$page=1;
$nor =  $mistake->query("SELECT COUNT(*) FROM status_a_alugar")->fetch();; //changable
$num_items = $nor[0];
$items_per_page= 10;
$num_pages = ceil($num_items/$items_per_page);
if(($page>$num_pages)&&$page!=1)$page= $num_pages;
$limit_start = ($page-1)*$items_per_page;
//changable sql
$sql = "SELECT * FROM status_a_alugar ORDER BY id DESC LIMIT $limit_start, $items_per_page";
echo "<p>";
$items =  $mistake->query($sql);
if($items->rowCount()>0)
{
while($item = $items->fetch())
{
$color = ($num % 2 == 0)? "<div id='div1'>"  : "<div id='div2'>";
if(perm($meuid)>2) $excluir = " - <a href='#' onclick='excluir_$item[id]()'>[APAGAR]</a>"; else $excluir = "";
echo "$color Status: <b>".$item["nome"]."</b><br />";
echo "Período.: <b>".$item["periodo"]."</b> dia(s)<br />";
echo "Valor: <b>".$item["valor"]."</b> pontos<br />";
echo "<a href='#' onclick='compra_$item[id]()'>[ALUGAR]</a> $excluir </div>";
echo confirJS("compra_$item[id]", "Tem certeza que deseja alugar?", "?action=alugar&id=".$item["id"]."");
if(perm($meuid)>0) echo confirJS("excluir_$item[id]", "Têm certeza que deseja excluir?", "?acao=apagar&id=$item[id]");
$num++;
}
}
else
{
	echo "<center>";
	echo "<img src=\"images/notok.gif\" alt=\"*\"/>Não há status disponível para aluguel no momento!<br />";
	echo "</center>";
}
echo "</p>";
echo "<p align=\"center\">";
if($page>1)
{
$ppage = $page-1;
echo "<a href=\"?page=$ppage\">&#171;Anterior</a> ";
}
if($page<$num_pages)
{
$npage = $page+1;
echo "<a href=\"?page=$npage\">Próxima&#187;</a>";
}
echo "<br/>$page/$num_pages<br/>";
echo "</p>";
if(perm($meuid)>0) echo "<p align=\"center\"><a href=\"?action=painel\">Adicionar status</a></p>";
}
if($action!="alugados" or $action==false)echo "<p align=\"center\"><a href=\"?action=alugados\">Lista de alugados</a></p>";
if($action!=false)echo "<p align=\"center\"><a href=\"?\">".$imgsetavoltar."Lista de status</a></p>";
echo "<p align='center'>";
echo "<a href=\"home?\">".$imginicio."Página principal</a>";
echo "</p>";
rodape();
?>
