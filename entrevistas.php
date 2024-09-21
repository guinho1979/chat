<?php
require_once("".$_SERVER["DOCUMENT_ROOT"]."/funcoes.php");
require_once("".$_SERVER["DOCUMENT_ROOT"]."/mistake.php");
require_once("".$_SERVER["DOCUMENT_ROOT"]."/emoji.php");
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
 $mistake = $mistake;
$page = $_GET["pag"];
if($a == "main" OR $a==false)
{
echo "<p align=\"center\" id='titulo'>";
echo "<b>Entrevistas </b><br/>";
echo "</p>";
$id = $_GET["id"];

if($_GET["pag"] == "apagar" AND perm($meuid)>1)
{
	 $mistake->exec("DELETE FROM entrevista WHERE id='".$id."'");

echo "<script>alert('Entrevista apagada com sucesso!')</script>";
}else{}
if($page=="" || $page<=0)$page=1;
$noi =  $mistake->query("SELECT COUNT(*) FROM entrevista")->fetch();
$num_items = $noi[0];
$items_per_page= 5;
$num_pages = ceil($num_items/$items_per_page);
if(($page>$num_pages)&&$page!=1)$page= $num_pages;
$limit_start = ($page-1)*$items_per_page;

$comando =  $mistake->query("SELECT * FROM entrevista ORDER BY data DESC LIMIT $limit_start, $items_per_page");
if($comando->rowCount() > 0)
{
echo "<p>";
while($res = $comando->fetch())
{
$color = ($num++ % 2 == 0)? "<div id='div1'>"  : "<div id='div2'>";
echo "$color<a href='/entrevistas/ver/$res[id]'><i class=\"ion-mic-c\" style=\"font-size:22px;font-weight: bold;\"></i>&nbsp;Entrevista com ". gerarnome($res["uid"])."</a><br />";
echo "</div>";
$x++;
}
echo "</p>";
echo "<p align=\"center\">";
if($num_pages>1)
{
paginas('entrevistas',0,$num_pages,$id,$pag);
}
echo "</p>";
}
else
{
echo"<p align='center'>";
echo $imgerro."Nenhuma entrevista até o momento!<br />"; 
echo"</p>"; 
}
////// UNTILL HERE >>
echo "<p align=\"center\">";
if(perm($meuid)>1) echo "<a href=\"/entrevistas/novo\">".$imgsaldacao."Criar nova entrevista</a><br/>";

echo "</p>";
}
else 
if($a=='excluirp') {
ativo($meuid,'Excluindo pergunta da entrevista '); 

$info = $mistake->query("SELECT * FROM perguntas_entrevista WHERE id='$id'")->fetch();
if($info['uid']==$meuid OR perm($meuid)>0) { 
$data = date("d/m/Y - H:i:s",time());
$txtt = "deletou a pergunta [b] ".$info['pergunta']." [/b], Dono: [b] ".html_entity_decode(gerarnome2($info['uid']))." [/b]. Data: [i] $data [/i] ";
editandopostagem($meuid,$txtt);
$mistake->exec("DELETE FROM perguntas_entrevista WHERE id='$id'");
$perg = $id - 1;
header('Location:/entrevistas/perguntas/'.$pag.'#pergunta_'.$perg.'');
}
}
else 
if($a=='editarp') { ativo($meuid,' Editando pergunta da entrevista '); ?>
<br/><div id="titulo"><b>Editar pergunta</b></div><br/>
<?php $recc = $mistake->query("SELECT * FROM perguntas_entrevista WHERE id='$id'")->fetch();
if($recc['uid']==$meuid OR perm($meuid)>0) {
if(!empty($_POST['rec'])){
echo'<center>';
if(isspam($_POST['rec'],$meuid)) {
$mistake->exec("UPDATE w_usuarios SET bchat3='4' WHERE id='".$meuid."'");  
$res = $mistake->prepare("INSERT INTO Mmistake_logs (texto,meuid,para,acao,data) VALUES (?,?,?,?,?)");
$arrayName = array(anti_injection($_POST['rec']),$meuid,0,'mural',time());
$ii = 0;
for($i=1; $i <=5; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
}else{
$data = date("d/m/Y - H:i:s",time());
$txtt = "editou uma pergunta da entrevista [b] ".$info['pergunta']." [/b], Dono: [b] ".html_entity_decode(gerarnome2($info['uid']))." [/b]. Data: [i] $data [/i] ";
editandopostagem($meuid,$txtt);

$update = $mistake->prepare("UPDATE perguntas_entrevista SET pergunta = ? WHERE id = ?");
$update->execute(array(anti_injection(emoji_unified_to_html(html_entity_decode($_POST['rec']))),$id));
echo $imgok;?> Pergunta editada com sucesso<br/><br/>
<a href="/entrevistas/perguntas/<?php echo $pag;?>#pergunta_<?php echo $id;?>">Voltar para entrevista</a></center><br/>
<?php 
}
}
$recc = $mistake->query("SELECT * FROM perguntas_entrevista WHERE id='$id'")->fetch();
?>
<form action="/entrevistas/editarp/<?php echo $id;?>/<?php echo $pag;?>" method="post">
<div style="text-align:center">
<textarea style="width:-webkit-fill-available" name='rec'><?php echo $recc['pergunta'];?></textarea><br />

<input type="submit" value="Editar">
</form></div>
<?php } else { ?>
Você não pode editar esta pergunta
<?php } } 
else if($a == "editar" && perm($meuid)>1)
{
$id = $_GET["id"];
$DADOS =  $mistake->query("SELECT *, COUNT(*) FROM entrevista WHERE id='".$id."'")->fetch();
echo "<p align=\"center\">";
if($DADOS["COUNT(*)"] == 0)
	{
		echo $imgerro."Entrevista não existe!<br />";

	}
else
{
echo "<div id='titulo'><b>Editar entrevista</b></div><br/>";

if(isset($_POST["texto"]))
	{
echo"<div align='center'>"; 
			//$res =  $mistake->exec("UPDATE entrevista SET texto='".$_POST["texto"]."' WHERE id='".$id."'");
$update =  $mistake->prepare("UPDATE entrevista SET texto = ? WHERE id = ?");
 $res = $update->execute(array(anti_injection(emoji_unified_to_html(html_entity_decode($_POST['texto']))),$id));
			if($res)
			{			 
echo $imgok."Texto da entrevista atualizado com sucesso!<br />";
			}
			else
			{
		echo $imgerro."Ocorreu um erro!<br />";
			}
echo"<br/></div>"; 
		}
$dados =  $mistake->query("SELECT * FROM entrevista WHERE id='".$id."'")->fetch();
echo "<form action=\"/entrevistas/$a/$id\" method=\"POST\">";
echo "Texto da entrevista: <input name=\"texto\" value=\"$dados[texto]\"><br>";
echo "<input value=\"Atualizar\" type=\"submit\"></form><br>";
echo "<p align=\"center\">";
echo "<a href='#' onclick='excluir_$id()'><font color='red'>Apagar entrevista</font></a><br><br/>";
echo confirJS("excluir_$id", "Você têm absoluta certeza que deseja excluir essa entrevista?", "/entrevistas/main/$id/apagar");
echo "<a href=\"/entrevistas/ver/$id\">Voltar a entrevista </a><br/>";
}

echo "</p>";
}
else if($a == "ver")
{
$id = (int)$_GET["id"];
$dados =  $mistake->query("SELECT * FROM entrevista WHERE id='".$id."'")->fetch();
$DADOS =  $mistake->query("SELECT *, COUNT(*) FROM entrevista WHERE id='".$id."'")->fetch();
$COUNTPERG =  $mistake->query("SELECT COUNT(*) FROM perguntas_entrevista WHERE idpapo='".$id."'")->fetch();

echo "<p align=\"center\">";
	if($DADOS["COUNT(*)"] == 0)
	{
echo $imgerro."Entrevista não existe!<br />";
	}
	else
	{
###atualiza visitas
$total_visitas = $dados["visitas"] + 1; 
 $mistake->exec("UPDATE entrevista SET visitas='".$total_visitas."' WHERE id='".$id."'");
    echo "<p align=\"center\" id='titulo'>";
    echo "<b>Entrevista com ". gerarnome($dados["uid"])."</b>";
	echo "</p><br/>";
 if(perm($meuid)>1) $editar = "<a href=\"/entrevistas/editar/$id\">[Editar]</a>";
		echo "".gerarnome($DADOS["por"]).": ".textot($DADOS["texto"],$on,$meuid)."</b> $editar<br /><br/>";
      echo "ID: <b>".$id."</b><br />";

echo "Visitas: <b> ".$DADOS["visitas"]."</b><br />";
echo "Status: <b>".$DADOS["status"]."!</b><br />";
echo "Criada em: ".date("d/m/Y", $DADOS["data"])."</small><br />";
if(perm($meuid)>1)
{
if($_POST["acao"] == "Editar")
	{
			$res =  $mistake->exec("UPDATE entrevista SET status='".$_POST["status"]."' WHERE id='".$id."'"); 
			if($res)
			{			 
exit(header("Location: ".$_SERVER["HTTP_REFERER"].""));
			}
			else
			{
				echo $imgerro."Ocorreu um erro!<br />";
			}
		}
	echo "</p>";
	echo "<form action='/entrevistas/$a/$id' method='POST'\">";
echo "Status:";
echo "<select name='status'>"; 
echo "<option value='Em andamento'>Em andamento</option>"; 
echo "<option value='Fechado'>Fechado</option>";
echo "<option value='Terminou'>Terminou</option>";
echo "</select><br />"; 
	echo "<input type='submit' name='acao' value='Editar'/>";
	echo "</form><br/>";
}
echo"<div id='div1'><a href=\"/entrevistas/perguntas/$id\">&#187;Perguntas(".$COUNTPERG[0].")</div><br/>"; 

	}
}
else if($a == "perguntas")
{
	
 $id = (int)$_GET["id"];
$usuario = (string)$_POST["usuario"];
    echo "<p align=\"center\" id='titulo'>";
    echo "<b>Perguntas</b>";
echo "</p><center><br/><a href=\"/entrevistas/perguntas/$id/$pag\">".$imgatualizar."Atualizar</a><br/>";
	echo "</center>";
$dados =  $mistake->query("SELECT * FROM entrevista WHERE id='".$id."'")->fetch();
$countp =  $mistake->query("SELECT COUNT(*) FROM perguntas_entrevista WHERE uid='".$meuid."' AND idpapo='".$id."' AND resposta=''")->fetch();
if(!empty($_POST["pergunta"]))
	{
if($dados["status"] == "Terminou" OR $dados["status"] == "Fechado")
{
echo"<p align='center'>";
echo $imgerro."Essa entrevista está fechada ou já terminou!<br>"; 
 echo"</p>";
}
else if($countp[0]>4)
{
echo"<p align='center'>";
echo $imgerro."Você possui 5 perguntas aguardando resposta, aguarde ser respondida para perguntar novamente.<br>"; 
 echo"</p>";
}
else
{

 ####
$count =  $mistake->query("SELECT COUNT(*) FROM perguntas_entrevista WHERE uid='".$uid."' AND idpapo='".$id."'")->fetch();

if($count[0]==0)
{
 $mistake->exec("UPDATE w_usuarios SET pt=pt+200 WHERE id='".$meuid."'");
}else{}

$res =  $mistake->prepare("INSERT INTO perguntas_entrevista (uid,idpapo,data,usuario,idpergunta,para,pergunta) VALUES (?,?,?,?,?,?,?)");
$arrayName = array($meuid,$id,time(),$usuario,time(),$dados["uid"],anti_injection($_POST["pergunta"]),);
$ii = 0;
for($i=1; $i <=7; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
echo"<p align='center'>";
echo $imgok."Pergunta enviada com sucesso!<br>"; 
 echo"</p>";
}
 echo"</p>";
	}
	else{
		echo '';
	}
	echo "</p>";

	if($page=="" || $page<=0)$page=1;
	$noi =  $mistake->query("SELECT COUNT(*) FROM perguntas_entrevista WHERE idpapo='".$id."'")->fetch();
	$num_items = $noi[0];
	$items_per_page= 5;
	$num_pages = ceil($num_items/$items_per_page);
	if(($page>$num_pages)&&$page!=1)$page= $num_pages;
	$limit_start = ($page-1)*$items_per_page;
	
    $sql =  $mistake->query("SELECT * FROM perguntas_entrevista WHERE idpapo='".$id."' ORDER BY idpergunta DESC LIMIT $limit_start, $items_per_page");
    if($sql->rowCount() == 0)
	{
echo"<center>";
echo $imgerro."Não há perguntas no momento! Seja o primeiro a perguntar<br/></center>"; 
// echo"</p>"; 
	}
	else
	{
$total =  $mistake->query("SELECT COUNT(*) FROM perguntas_entrevista WHERE idpapo='".$id."'")->fetch();
$totalr =  $mistake->query("SELECT COUNT(*) FROM perguntas_entrevista WHERE idpapo='".$id."' AND resposta>'0'")->fetch();
      echo"<p align='center'>"; 
		echo "<b>Total de perguntas (".$total[0].")</b>";

      echo "<br/><b>Total de respostas (".$totalr[0].")</b>";
      echo"</p>"; 
		while($res = $sql->fetch())
		{
$color = ($num++ % 2 == 0)? "<div id='div1'>"  : "<div id='div2'>";

echo"$color<a name ='pergunta_".$res["idpergunta"]."'></a><a name ='pergunta_".$res["id"]."'></a>";
if(perm($meuid) or $res["uid"]==$meuid)
{
$equipe= "<br/><a href=\"/entrevistas/excluirp/".$res['id']."/$id\" onclick=\"return confirm('Você realmente quer apagar essa pergunta?')\">[APAGAR]</a> -  <a href=\"/entrevistas/editarp/".$res['id']."/$id\">[EDITAR]</a>";
}
else{
$equipe = "";
}
			$txt =  textot($res["pergunta"],$meuid,$on);
			echo "<br/><a href=\"/".gerarlogin($res["uid"])."\">".gerarnome($res["uid"])."</a> <b>perguntou:</b> <b><font color='#000000'>".$txt."</font></b>$equipe<br />";
if(!empty($res["resposta"]))
{
$texto = textot($res["resposta"],$meuid,$on);
			echo "<a href='/".gerarlogin($res["para"])."'>". gerarnome($res["para"])."</a> <b>respondeu:</b> <b><font color='red'>".$texto."</font></b><br />";
     
}
if(!empty($_POST["resposta"]))
	{
		  $mistake->exec("UPDATE perguntas_entrevista SET resposta='".anti_injection($_POST["resposta"])."' WHERE idpergunta='".$pag."'");
exit(header("Location: ".$_SERVER["HTTP_REFERER"].""));
	}
	else{
		echo '';
	}
if($meuid==$res["para"] AND empty($res["resposta"]))
{
echo "<br /><form action='/entrevistas/$a/$id/$res[idpergunta]#pergunta_$res[idpergunta]' method='POST'>";
	echo "Resposta: <input type='text' name='resposta' placeholder='Digite sua resposta' maxlength='500' required/><br />";

	 echo "<input type='submit' name='acao' value='Responder' />";
	echo "</form><br />";
}
			echo "</div>";
		}
	}
echo"</div>"; 
///perguntar
echo "<br /><form action='/entrevistas/$a/$id/$pag' method='POST'>";

	echo "Pergunta: <input type='text' name='pergunta' placeholder='Digite sua pergunta' maxlength='500' required/><br />";
	 echo "<input type='submit' name='acao' value='Perguntar' />";
	echo "</form>";
/////
echo "<p align=\"center\">";
if($num_pages>1)
{
paginas('entrevistas',$a,$num_pages,$id,$page);
}
echo "</p>";
////// UNTILL HERE >>
echo "<p align=\"center\">";

echo "</p>";
}

if($a == "novo")
{
	if(perm($meuid)<2) {echo "Voce não é da equipe!"; exit(); }

	echo "<p align='center' id='titulo'>";
	echo "<b>Nova entrevista</b></p>";
		echo "<p align='center'>";
	
	if($_POST["acao"] == "Criar")
	{
		$textoentrevista = anti_injection($_POST["textoentrevista"]);

      $entrevistado = anti_injection($_POST["entrevistado"]);
       $status = (string)$_POST["status"];
		if(empty($textoentrevista))
		{
			echo $imgerro."Digite o texto da entrevista!<br />";
		}
else if(empty($entrevistado))
		{
			echo $imgerro."Digite a ID do entrevistado!<br />";
		}/*
else if(!isuser($entrevistado))
		{
			echo $imgerro."ID do entrevistado não existe!<br />";
		}*/
		else
		{

$res =  $mistake->prepare("INSERT INTO entrevista (texto,status,visitas,data,por,uid) VALUES (?,?,?,?,?,?)");
$arrayName = array($textoentrevista,$status,0,time(),$meuid,$entrevistado,);
$ii = 0;
for($i=1; $i <=6; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
			if($res)
			{
				echo $imgok."Nova entrevista criada com sucesso!<br />";
			}
			else
			{
				echo $imgerro."Ocorreu um erro :(<br />";
			}
		}
	}
	echo "</p>";
	echo "<form action='/entrevistas/novo' method='POST'\">";
	echo "Texto da entrevista:<br><input type='text' name='textoentrevista'/> <br />";
echo "ID do entrevistado: <br><input type='number'  name='entrevistado'/> <br />";
echo "Status da entrevista:";
echo "<select name='status'>"; 
echo "<option value='Aberto'>Aberto</option>"; 
echo "<option value='Fechado'>Fechado</option>";
echo "</select><br />"; 
	echo "<input type='submit' name='acao' value='Criar'/>";
	echo "</form>";
	
 echo "<p align=\"center\">";
//echo"IMPORTANTE: Está liberado o uso de BBCode e smilies no texto da entrevista!<br/>";


echo "</p>";
}
echo"<p align=\"center\">";
if(isset($a))echo "<a href=\"/entrevistas\">".$imgsetavoltar."Entrevistas</a><br/><br/>";
echo "<a href=\"/home?\">".$imginicio."";
echo "Página principal</a>";

echo "</p>";
rodape();
?>