<?php
require_once("".$_SERVER["DOCUMENT_ROOT"]."/funcoes.php");
require_once("".$_SERVER["DOCUMENT_ROOT"]."/mistake.php");
seg($meuid);
$id=$id==true?$id:$meuid;
if($a==false) { ativo($meuid,'Vendo relacionamento ');
if($e=='1')
{
$mistake->exec("UPDATE w_igreja SET s='1' WHERE id='$del'");
$mistake->exec("update w_usuarios set relacaotipo='".$_GET['tipo']."' where id='$meuid'"); 
$nm2 = $mistake->query("SELECT nm FROM w_usuarios WHERE id='$id'")->fetch();
$msg = "Oi ".html_entity_decode($nm2[0]).", aceitei seu pedido de relacionamento.";
automsg($msg,$meuid,$id);
}
else if($e=='0')
{
$nm2 = $mistake->query("SELECT nm FROM w_usuarios WHERE id='$id'")->fetch();
$msg = "Oi ".html_entity_decode($nm2[0]).", recusei seu pedido de relacionamento.";
automsg($msg,$meuid,$id);
$mistake->exec("DELETE FROM w_igreja WHERE id='$del'");
}
$namoro = $mistake->query("SELECT count(*) FROM w_igreja WHERE (aid='$meuid' or uid='$meuid') and s='1'")->fetch();
?>
<br/><div id="titulo"><b>Pedidos de relacionamento</b></div><br/>
<?php if($namoro[0]>0) {
$nmr = $mistake->query("SELECT uid, aid, id FROM w_igreja WHERE uid='$id' or aid='$id' and s='1'")->fetch();
$nam=$nmr[0]==$meuid?$nmr[1]:$nmr[0];
?>
<a href="relacionamento?del=<?php echo $nmr[2];?>&e=0&id=<?php echo $nam;?>">Separar de <?php echo gerarnome($nam);?></a><br/><br/>
<?php } ?>
<?php
$contfas = $mistake->query("SELECT count(*) FROM w_igreja WHERE aid='$meuid' and s='0'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contfas[0];
$itensporpag = 8;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->query("SELECT id, uid FROM w_igreja WHERE aid='$meuid' and s='0' ORDER BY id desc LIMIT $limit, $itensporpag");
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) {
$loc = $mistake->query("SELECT cid, est FROM w_usuarios WHERE id='".$item->uid."'")->fetch(); ?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<?php echo online($item->uid)>0?gstat($item->uid):$imgoff;?>
<?php 
$info = $mistake->query("SELECT * FROM w_usuarios WHERE id='".$item->uid."'")->fetch();
?>
<a href="perfil?id=<?php echo $item->uid;?>"><?php echo gerarnome($item->uid);?></a><br/><?php echo relac($item->uid);?><br/>
<?php echo $loc[0];?>, <?php echo $loc[1];?><br/>
<a href="relacionamento?del=<?php echo $item->id;?>&e=1&id=<?php echo $item->uid;?>&tipo=<?php echo $info['relacaotipo']; ?>"><font color="ff0000">Aceitar</font></a> - <a href="relacionamento?del=<?php echo $item->id;?>&e=0&id=<?php echo $item->uid;?>"><font color="ff0000">Recusar</font></a>
</div> <?php $i++; } ?>
<br/><div align="center"><br/>
<?php if($pag>1) { $ppag = $pag-1; ?>
<a href="relacionamento?pag=<?php echo $ppag;?>">&#171;Anterior</a>
<?php } if($pag<$numpag) { $npag = $pag+1; ?>
<a href="relacionamento?pag=<?php echo $npag;?>">Próxima&#187;</a>
<?php } ?> <br/> <?php echo $pag.'/'.$numpag;?><br/>
<?php if($numpag>2) { ?>
<form action="relacionamento.php" method="get">
Pular para página<input name="pag" size="3">
<input type="hidden" name="on" value="<?php echo $on;?>">
<input type="submit" value="IR">
</form>
<?php } } else { ?>
<div align="center">
Nenhum pedido de relacionamento!<br/>
<?php } } else if($a=='namorar') { ativo($meuid,'Pedindo relacionamento a usuário(a) '); ?>
<br/><div align="center">
<?php
if($e=='casar') {
$mensagem = 'você aceita casar comigo?';
$tiporela = '1';
}
else if($e=='namorar') {
$mensagem = 'você aceita namorar comigo?';
$tiporela = '2';
}
else if($e=='ficar') {
$mensagem = 'você aceita ficar comigo?';
$tiporela = '3';
}
else if($e=='enrolar') {
$mensagem = 'você deixa eu te enrolar?';
$tiporela = '4';
}
else if($e=='aberto') {
$mensagem = 'você aceita ter um relacionamento aberto comigo?';
$tiporela = '5';
}
$fan = $mistake->query("SELECT COUNT(*) FROM w_igreja WHERE (aid='$id' or uid='$id') and s='1'")->fetch();
if ($id==$meuid) { echo $imgerro;?>
Você não pode namorar você mesmo!
<?php } else if($fan[0]>0) { echo $imgerro;?>
<a href="perfil?id=<?php echo $id;?>"><?php echo gerarnome($id);?></a> já está namorando!
<?php } else {
$mistake->exec("DELETE FROM w_igreja WHERE uid='$meuid' or aid='$meuid'");
$res = $mistake->exec("INSERT INTO w_igreja (uid,aid) values('$meuid','$id')");
if($res) { 
$mistake->exec("update w_usuarios set relacaotipo='".$tiporela."' where id='$meuid'"); 
echo $imgok;?>
Foi enviado um pedido de relacionamento para <a href="perfil?id=<?php echo $id;?>"><?php echo gerarnome($id);?></a>!
<?php
$nm2 = $mistake->query("SELECT nm FROM w_usuarios WHERE id='$id'")->fetch();
$msg = "Oi ".html_entity_decode($nm2[0]).", ".$mensagem." aceite o pedido [link=/relacionamento?]aqui[/link]";
automsg($msg,$meuid,$id);
} else { echo $imgerro;?>
Erro ao pedir <a href="perfil?id=<?php echo $id;?>"><?php echo gerarnome($id);?></a> em relacionamento, tente novamente!
<?php } } ?> <br/><br/><a href="perfil?id=<?php echo $id;?>">Perfil de <?php echo gerarnome($id);?></a> <?php } ?>
<div class="col-12 text-center" style="margin-top: 20px"><a href="javascript:window.history.back();"><?php echo $imgsetavoltar;?> Voltar</a></div><br/>
<?php echo rodape();?>
</body>
</html>