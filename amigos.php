<?php
require_once("".$_SERVER["DOCUMENT_ROOT"]."/funcoes.php");
require_once("".$_SERVER["DOCUMENT_ROOT"]."/mistake.php");
seg($meuid);
$id=$id==true?$id:$meuid;
if($a=='editaramigo' and $meuid!=$id) { ativo($meuid,'Editando amigo '); ?>
<br/><div align="center">
<?php
if($pag=='add') { 
if(editamigos($meuid,$id)==0) {
$mistake->exec("INSERT INTO w_amigos (uid,tid) values('$meuid','$id')");
 ?>
Um pedido de amizade foi enviado a <a href="/<?php echo gerarlogin($id);?>"><?php echo gerarnome($id);?></a>
<?php 
} 
}else 
if($pag=='excluir') {
$mistake->exec("DELETE FROM w_amigos WHERE (uid='".$meuid."' AND tid='".$id."') OR (uid='".$id."' AND tid='".$meuid."')");
?>
<a href="/<?php echo gerarlogin($id);?>"><?php echo gerarnome($id);?></a> foi excluído(a) da sua lista de amigos
<?php 
}else 
if($pag=='aceitar') {
$mistake->exec("UPDATE w_amigos SET ac='1' WHERE (uid='".$meuid."' AND tid='".$id."') OR (uid='".$id."' AND tid='".$meuid."')");
 ?>
<a href="/<?php echo gerarlogin($id);?>"><?php echo gerarnome($id);?></a> foi adicionado(a) a sua lista de amigos com sucesso
<?php }else 
if($pag=='recusar') {
$mistake->exec("DELETE FROM w_amigos WHERE (uid='".$meuid."' AND tid='".$id."') OR (uid='".$id."' AND tid='".$meuid."')");
?>
<a href="/<?php echo gerarlogin($id);?>"><?php echo gerarnome($id);?></a> foi excluído(a) da sua lista de amigos
<?php } } else if($a=='pedidos') { ativo($meuid,'Vendo pedidos de amizade '); ?>
<br/><div id="titulo"><b>Pedidos de amizade</b></div><br/>
<?php
$contamigos = $mistake->query("SELECT COUNT(*) FROM w_amigos WHERE tid='".$meuid."' AND ac='0'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contamigos[0];
$itensporpag= 10;
$numpag = ceil($numitens/$itensporpag);
if(($pag>$numpag)&&$pag!=1)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->prepare("SELECT uid FROM w_amigos WHERE tid='".$meuid."' AND ac='0' LIMIT $limit, $itensporpag");
$itens->execute();
$i=0; 
while ($item = $itens->fetch(PDO::FETCH_OBJ)) {
$email = $mistake->query("SELECT em FROM w_usuarios WHERE id='".$item->uid."'")->fetch();
?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<?php echo gstat($item->uid);?><a href="/<?php echo gerarlogin($item->uid);?>">
<?php echo gerarnome($item->uid);?></a><br/>
<?php echo $email[0]!=''?"$email[0]<br/>":'';?>
<a href="/amigos/editaramigo/<?php echo $item->uid;?>/aceitar">Aceitar</a> - <a href="/amigos/editaramigo/<?php echo $item->uid;?>/recusar">Recusar</a>
</div> <?php $i++; 
} 
} else { 
?>
<div align="center">Não ah pedidos de amizade
<?php
}
if($numpag>1) {
paginas('amigos',$a,$numpag,$id,$pag);    
} } else { ativo($meuid,'Vendo amigos '); 
?>
<style>
.new-button{background-color: #eeeeee;background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #eeeeee), color-stop(100%, #cccccc));background-image: -webkit-linear-gradient(top, #eeeeee, #cccccc);background-image: -moz-linear-gradient(top, #eeeeee, #cccccc);background-image: -ms-linear-gradient(top, #eeeeee, #cccccc);background-image: -o-linear-gradient(top, #eeeeee, #cccccc);background-image: linear-gradient(top, #eeeeee, #cccccc);border: 1px solid #ccc;border-bottom: 1px solid #bbb;border-radius: 3px;color: #333;color: #000;padding: 4px 4px 4px 4px;text-decoration: none;margin: 1px;text-shadow: 0 1px 0 #eee;font-weight: 700;vertical-align: middle;display: table-cell;border: 1px solid #CDC9C9;width: 100%;}
</style>
<br/><div id="titulo"><b>
<?php echo $id==$meuid?'Meus amigos':"Amigos de ".gerarnome($id)."";?>
</b></div><br/>
<?php
$contamigos = $mistake->query("SELECT COUNT(*) FROM w_amigos WHERE (uid='".$id."' OR tid='".$id."') AND ac='1'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contamigos[0];
$itensporpag= 10;
$numpag = ceil($numitens/$itensporpag);
if(($pag>$numpag)&&$pag!=1)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->prepare("SELECT a.id, b.uid, b.tid, a.cid, a.est, a.onlf,a.ft FROM w_usuarios a INNER JOIN w_amigos b WHERE ((a.id=b.uid AND b.tid='".$id."') OR (a.id=b.tid AND uid='".$id."')) AND b.ac='1' AND a.id<>'$id' ORDER BY a.inativo DESC LIMIT $limit, $itensporpag");
$itens->execute();
$x=0; 
while ($item = $itens->fetch(PDO::FETCH_OBJ)) { 
?>
<div id="<?php echo $x%2==0?'div1':'div2';?>" style="padding: 0px !important;"><table style="width:100%" align="center"><tr><td width="100%" align="center"><a href="/<?php echo gerarlogin($item->id);?>"><?php echo gerarnome($item->id);?></a></td></tr></table><table style="width:100%" align="center"><tr><td width="5%" style="height:45px;vertical-align:bottom;" align="left"><img style="float: center;" src="/<?php echo $item->ft==true?$item->ft:'semfoto.jpg';?>" alt="foto" div id="fotofila" width="65" height="65"/></td><td width="90%" align="left"><img src="/style/local.png" alt="x" width="16" height="16"><?php echo $item->onlf;?></td><td width="90%" align="left"><?php echo gstat($item->id);?></td></tr></table><table style="width:100%" align="center"><tr><td width="50%"><a href="/mensagens1/lermsg/<?php echo $item->id;?>" title="Enviar Mensagem"><button class="new-button"><img src="/style/send.png" height="22" width="22"></button></a></td><td width="50%"><a href="/amigos/editaramigo/<?php echo $item->id;?>/excluir"><button class="new-button"><img src="/style/del-user.png" height="22" width="22"></button></a></td></tr></table></div>
<?php $x++; } 
} else { ?>
<div align="center"><?php echo $id==$meuid?'Você não possui amigos':"<a href='/".gerarlogin($id)."'>".gerarnome($id)."</a> não possui amigos";?>
<?php }
if($numpag>1) {
paginas('amigos',0,$numpag,$id,$pag);    
} } ?>
<div align="center"><a class="badge badge-secondary" href="javascript:window.history.back();"><?php echo $imgsetavoltar;?> Voltar</a><br/>
<a href="/home?"><?php echo $imginicio;?>Página principal</a></div><br>
<?php echo rodape();?>
</body>
</html>