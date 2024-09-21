<?php
require_once("".$_SERVER["DOCUMENT_ROOT"]."/funcoes.php");
require_once("".$_SERVER["DOCUMENT_ROOT"]."/mistake.php");
seg($meuid);
if(uchat($meuid)==3) { ?>
<br/><div align="center"><?php echo $imgerro;?>Você foi bloqueado.<br/><br/>
<a href="chat"> <img src='style/chat.gif'>
Salas de chat</a><br/>
<a href="home"> <img src='style/inicio.gif'>
Página principal</a><br><br>
<?php 
rodape();
exit(); }
$contid = $mistake->query("SELECT count(*) FROM w_usuarios WHERE id='$id'")->fetch();
if($contid[0]==0){
header("Location:home");
}
ubloq($meuid,$id);
ativo($meuid,'Vendo página de Recados ');
$verrec = $mistake->query("SELECT vrec, erec FROM w_usuarios WHERE id='$id'")->fetch();
$verrecc = $mistake->query("SELECT COUNT(*) FROM w_amigos WHERE (uid='$meuid' AND tid='$id') OR (tid='$meuid' AND uid='$id')")->fetch();
?>
<br/><div id="titulo"><b>
<?php echo $id==$meuid?'Meus recados':"Recados de ".gerarnome($id)."";?>
</b></div><br/>
<?php
$contrec = $mistake->query("SELECT COUNT(*) FROM w_recados WHERE pr='$id'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contrec[0];
$itensporpag = 8;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($id!=$meuid and $verrec['vrec']==1 and $verrecc[0]==0 and perm($meuid)==0) { ?>
<div align="center">
Somente amigos de <a href="/<?php echo gerarlogin($id);?>"><?php echo gerarnome($id);?></a> podem ver estes recados!<br/>
<?php } else if($numitens>0) {
$itens = $mistake->query("SELECT * FROM w_recados WHERE pr='$id' ORDER BY hr desc LIMIT $limit, $itensporpag");
$i=0; while($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<?php echo online($item->por)>0?gstat($item->por):$imgoff;?><a href="/<?php echo gerarlogin($item->por);?>">
<?php echo gerarnome($item->por);?></a><br/><?php echo textot($item->rec,$meuid,$on);?><br/>
<?php echo date("d/m/Y - H:i:s", $item->hr);?>
<?php if($item->por==$meuid or $item->pr==$meuid or perm($meuid)>0) { ?>
<a href="/bd/recadosbd?id=<?php echo $id;?>&del=<?php echo $item->id;?>"><font color="#FF0000">[x]</font></a>
<?php } ?> </div> <?php $i++; } ?>
<div align="center"><br/>
<?php if($pag>1)  { $ppag = $pag-1; ?>
<a href="recados?id=<?php echo $id;?>&pag=<?php echo $ppag;?>">&#171;Anterior</a>
<?php } if($pag<$numpag) { $npag = $pag+1; ?>
<a href="recados?id=<?php echo $id;?>&pag=<?php echo $npag;?>">Próxima&#187;</a>
<?php } ?>
<br/><?php echo $pag.'/'.$numpag;?><br/>
<?php if($numpag>2) { ?>
<form action="/recados.php" method="get">
Pular para página<input name="pag" size="3">
<input type="hidden" name="id" value="<?php echo $id;?>">
<input type="submit" value="IR">
</form>
<?php } } else { ?>
<div align="center">
<?php echo $id==$meuid?('Você não possui recados!'):("<a href='/".gerarlogin($id)."'>".gerarnome($id)."</a> não possui recados");?>
<?php }
if($id!==$meuid and $verrec['erec']==1 and $verrecc[0]==0) { ?>
<br/><div align="center">Somente amigos de
<a href="/<?php echo gerarlogin($id);?>"><?php echo gerarnome($id);?></a> podem enviar recados para el<?php echo sexo($id)=='M'?'e':'a';?>!<br/>
<?php } else { ?>
<br/><div align="center"><form action="/bd/recadosbd?id=<?php echo $id;?>" method="post">
Recado:
<br/><textarea style="width:-webkit-fill-available" name="rec" maxlength="500" value="" rows="5" cols="25"></textarea><br/><br/>
<input type="submit" value="Enviar">
</form>
<?php } ?>
<br/><div align="center"><a class="badge badge-secondary" href="javascript:window.history.back();"><?php echo $imgsetavoltar;?> Voltar</a><br/>
<a href="/home"><?php echo $imginicio;?>Página principal</a><br><br></div>
<?php echo rodape();?>
</body>
</html>