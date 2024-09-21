<?php
require_once("".$_SERVER["DOCUMENT_ROOT"]."/funcoes.php");
require_once("".$_SERVER["DOCUMENT_ROOT"]."/mistake.php");
seg($meuid);
?>

<?php 
$acao = $_GET['acao'];
if($acao=='respondeu'&& $_POST['resposta']==true){
$res = $mistake->exec("UPDATE w_comentarios_p SET resposta=:resposta,horaresposta=:horaresposta,respondeu=:respondeu WHERE id=:id");
$res->bindParam(":resposta",$_POST['resposta']);
$res->bindParam(":respondeu",$meuid);
$res->bindParam(":horaresposta",time());
$res->bindParam(":id",$_GET['id']);// testa ai pra ver teste
$res->execute();
header("Location: paginas.php");	
}
if($acao=='responder'){
?>
<?php 
if (perm($meuid)>0) { ?>
<br /><div id="titulo"><b>Responder</b></div><br/>

<center><a name='equipe' id='equipe' /></a><form action="/responder.php?acao=respondeu&id=<?php echo $id;?>" method="post">
Resposta: <input type="text" class="bt3" name="resposta" />
 <input type="submit" class="bt3" value="Eviar" />
</form>
<a href="home?"  style="color:#<?php echo $info['links'];?>;"><?php echo $imginicio;?>Página principal</a>
</center>
<?php
}
}
?>
<?php echo rodape();?>
</body>
</html>