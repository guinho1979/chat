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
ativo($meuid,'Loja de presente ');
if($a==false) { ?>
<br/><div id="titulo"><b>Lojas de presentes</b></div><br/>
<?php
$itens =  $mistake->query("select * from w_loja_m order by nm");
$i=0; while($item = $itens->fetch(PDO::FETCH_OBJ)) {
$cont =  $mistake->query("SELECT count(*) FROM w_loja_cc a, w_loja b, w_loja_c c WHERE a.prod=b.id and b.cat=c.id and c.cat='".$item->id."'")->fetch(); ?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<?php echo $imgloja;?><a href="/lojas/loja/<?php echo $item->id;?>"><?php echo $item->nm;?></a><br/>
Vendas: <b><?php echo $cont[0];?></b><br/>
Dono(a): <b><a href="/<?php echo gerarlogin($item->dn);?>"><?php echo gerarnome($item->dn);?></a></b></div>
<?php $i++; } ?>
<br/><form action="/lojas/buscar" method="post">
Buscar produtos:<br/><input type="text" name="texto" maxlength="15">
<input type="submit" value="Buscar"><br/>
<?php } else if($a=='loja') { $nm =  $mistake->query("SELECT nm, msg FROM w_loja_m WHERE id='$id'")->fetch(); ?>
<br/><div id="titulo"><b>Loja <?php echo $nm[0];?></b></div><br/>
<div align="center"><?php echo textot($nm[1],$meuid,$on);?></div><br/>
<?php
$itens =  $mistake->query("select * from w_loja_c where cat='$id' order by nm");
$i=0; while($item = $itens->fetch(PDO::FETCH_OBJ)) {
$cont =  $mistake->query("SELECT count(*) FROM w_loja WHERE cat='".$item->id."'")->fetch();
$contp =  $mistake->query("SELECT count(*) FROM w_loja_cc a, w_loja b WHERE a.prod=b.id and b.cat='".$item->id."'")->fetch(); ?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<a href="/lojas/produtos/<?php echo $item->id;?>"><?php echo $item->nm;?>(<?php echo $cont[0];?>)</a><br/>
Vendas: <b><?php echo $contp[0];?></b></div>
<?php $i++; } ?>
<br/><form action="/lojas/buscar" method="post">
Buscar produtos:<br/><input type="text" name="texto" maxlength="15">
<input type="submit" value="Buscar"><br/>
<?php } else if($a=='produtos') { $nm =  $mistake->query("SELECT nm FROM w_loja_c WHERE id='$id'")->fetch(); ?>
<br/><div id="titulo"><b><?php echo $nm[0];?></b></div><br/>
<?php
$contnotic =  $mistake->query("SELECT COUNT(*) FROM w_loja WHERE cat='$id'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contnotic[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens =  $mistake->query("SELECT * FROM w_loja WHERE cat='$id' ORDER BY id desc LIMIT $limit, $itensporpag");
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) {
$cont =  $mistake->query("SELECT count(*) FROM w_loja_cc where prod='".$item->id."'")->fetch();?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<?php if($item->ext=='jpg' or $item->ext=='gif' or $item->ext=='png' or $item->ext=='jpeg') { ?>
<img style="height:250px;width:250px" src="/loja/<?php echo $item->id.'.'.$item->ext;?>">
<?php } ?><br/>
Título: <b><?php echo $item->nm;?></b><br/>
Valor: <b><?php echo $item->valor;?> pontos</b><br/>
Tipo: <b><?php echo $item->ext;?></b><br/>
Vendas: <b><?php echo $cont[0];?></b><br/>
<?php echo $imgloja;?> <a href="/lojas/comprar/<?php echo $item->id;?>">Comprar</a><br/>
</div>
<?php $i++; }
if($numpag>1) {
paginas('lojas',$a,$numpag,$id,$pag);
}
 } else { ?>
<div align="center">Esta categoria não possui produtos!<br/><br/>
<?php } } else if($a=='buscar') { ($pag=='')?($_SESSION['buscant']=$_POST['texto']):('');
if(trim($_SESSION['buscant'])=='') { ?>
<br/>Digite um texto para concluir a pesquiza
<?php } else { ($pag=='')?($_SESSION['buscant']=$_POST['texto']):(''); ?>
<br/><div id="titulo"><b>Resultado da busca por <?php echo $_SESSION['buscant'];?></b></div><br/>
<?php
$contmsg =  $mistake->query("SELECT COUNT(*) FROM w_loja WHERE nm LIKE '%".$_SESSION['buscant']."%'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contmsg[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens =  $mistake->query("SELECT * FROM w_loja WHERE nm LIKE '%".$_SESSION['buscant']."%' ORDER BY nm LIMIT $limit, $itensporpag");
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<?php if($item->ext=='jpg' or $item->ext=='gif' or $item->ext=='png' or $item->ext=='jpeg') { ?>
<img style="height:250px;width:250px" src="/loja/<?php echo $item->id.'.'.$item->ext;?>">
<?php } ?><br/>
Título: <b><?php echo $item->nm;?></b><br/>
Valor: <b><?php echo $item->valor;?> pontos</b><br/>
Tipo: <b><?php echo $item->ext;?></b><br/>
<?php echo $imgloja;?> <a href="/lojas/comprar/<?php echo $item->id;?>">Comprar</a><br/>
</div>
<?php $i++; }
if($numpag>1) {
paginas('lojas',$a,$numpag,$id,$pag);
}
} else { ?>
<div align="center">Nenhum resultado!<br/><br/>
<?php } } } else if($a=='comprar') { $nm =  $mistake->query("SELECT nm,ext,valor,valorloja FROM w_loja WHERE id='$id'")->fetch(); ?>
<br/><div id="titulo"><b>Comprar <?php echo $nm[0];?></b></div><br/>
<?php if($nm[1]=='jpg' or $nm[1]=='gif' or $nm[1]=='png' or $nm[1]=='jpeg') { ?>
<div align="center"><img style="height:250px;width:250px" src="/loja/<?php echo $id.'.'.$nm[1];?>"></div>
<?php } ?><br/>
Título: <b><?php echo $nm[0];?></b><br/>
Valor: <b><?php echo $nm[2];?> pontos</b><br/>
Tipo: <b><?php echo $nm[1];?></b><br/><br/>
<form action="/lojas/comprar2/<?php echo $id;?>" method="post">
Mensagem:<br/><input type="hidden" value="<?php echo $nm[3];?>" name="valorloja"><input type="text" name="msg"><br/><br/>
Enviar para:<br/><select name="pr">
<option value="0">Amigo(a)</option>
<?php
$amigos =  $mistake->prepare("SELECT b.id,b.nm FROM w_amigos a inner join w_usuarios b WHERE (a.uid='".$meuid."' OR a.tid='".$meuid."') AND a.ac='1' AND (b.id=a.tid OR b.id=a.uid) AND b.id!='$meuid' order by b.nm asc");
$amigos->execute();
while ($amg = $amigos->fetch(PDO::FETCH_OBJ)) { ?>
<option value="<?php echo $amg->id;?>"><?php echo $amg->nm;?></option>
<?php } ?>
</select><br/><br/>
Ou insira o id do usuário:<br/><input type="text" name="idu" size="4"><br/><br/>
<input type="hidden" name="pts" value="<?php echo $nm[2];?>">
<input type="submit" value="Comprar"></form>
<?php } else if($a=='comprar2') {
$aid = $_POST['pr']==0?$_POST['idu']:$_POST['pr'];
$cont =  $mistake->query("SELECT count(*) FROM w_usuarios WHERE id='$aid'")->fetch();
$ptss =  $mistake->query("SELECT pt FROM w_usuarios WHERE id='$meuid'")->fetch();
if($cont[0]==0) { ?>
<br/><div align="center"><?php echo $imgerro;?>Usuário inexistente<br/><br/>
<?php } else if($_POST['pts']>$ptss[0]) { ?>
<br/><div align="center"><?php echo $imgerro;?>Você não tem <b><?php echo $_POST['pts'];?> pontos</b> para comprar este produto<br/><br/>
<?php } else {
$res =  $mistake->prepare("INSERT INTO w_loja_cc (uid,aid,dt,msg,prod,valorloja) VALUES (?, ?, ?, ?, ? ,?)");
$arrayName = array($meuid,$aid,time(),$_POST['msg'],$id,$_POST['valorloja']);
$ii = 0;
for($i=1; $i <=6; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
if($res) {
automsg("Oi, Comprei um presente pra você, veja na lista em seu perfil.",$meuid,$aid);
$pontos = $_POST['pts'];
 $mistake->exec("UPDATE w_usuarios SET pt=pt-$pontos WHERE id='$meuid'");
?>
<br/><div align="center"><?php echo $imgok;?>Compra efetuada com sucesso<br/>
<?php } else { ?>
<br/><div align="center"><?php echo $imgerro;?>Não foi possivel efetuar a compra<br/>
<?php } } } else if($a=='compras') { ?>
<br/><div id="titulo"><b>Compras de <?php echo gerarnome($id);?></b></div><br/>
<?php
if($_GET['limite']==true){
 $mistake->exec("DELETE FROM w_loja_cc WHERE id='".$_GET['limite']."'");
}
$contnotic =  $mistake->query("SELECT COUNT(*) FROM w_loja_cc WHERE uid='$id'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contnotic[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens =  $mistake->query("SELECT * FROM w_loja_cc WHERE uid='$id' ORDER BY id desc LIMIT $limit, $itensporpag");
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) {
$info =  $mistake->query("SELECT * FROM w_loja WHERE id='".$item->prod."'")->fetch(); ?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<?php if($info['ext']=='jpg' or $info['ext']=='gif' or $info['ext']=='png' or $info['ext']=='jpeg') { ?>
<img style="max-width:100%" src="loja/<?php echo $info['id'].'.'.$info['ext'];?>">
<?php } ?><br/>
Título: <b><?php echo $info['nm'];?></b><br/>
Valor: <b><?php echo $info['valor'];?> pontos</b><br/>
Tipo: <b><?php echo $info['ext'];?></b><br/>
Mensagem: <b><?php echo $item->msg;?></b><br/>
Data da compra: <i><?php echo date("d/m/Y - H:i:s",$item->dt);?></i>
<?php if($id==$meuid) { ?>
- <a href="/lojas/compras/<?php echo $id;?>/<?php echo $pag;?>/<?php echo $item->id;?>"><font color="#FF0000">[x]</font></a>
<?php } ?>
</div>
<?php $i++; }
if($numpag>1) {
paginas('lojas',$a,$numpag,$id,$pag);
}
} else { ?>
<div align="center">Este usuário não efetuou nenhuma compra!<br/><br/>
<?php } } else if($a=='presentes') { ?>
<br/><div id="titulo"><b>Presentes de <?php echo gerarnome($id);?></b></div><br/>
<?php
if($_GET['limite']==true){
 $mistake->exec("DELETE FROM w_loja_cc WHERE id='".$_GET['limite']."'");
}
$contnotic =  $mistake->query("SELECT COUNT(*) FROM w_loja_cc WHERE aid='$id'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contnotic[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens =  $mistake->query("SELECT * FROM w_loja_cc WHERE aid='$id' ORDER BY id desc LIMIT $limit, $itensporpag");
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) {
$info =  $mistake->query("SELECT * FROM w_loja WHERE id='".$item->prod."'")->fetch(); ?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<?php if($info['ext']=='jpg' or $info['ext']=='gif' or $info['ext']=='png' or $info['ext']=='jpeg') { ?>
<img style="height:250px;width:250px" src="/loja/<?php echo $info['id'].'.'.$info['ext'];?>">
<?php } ?><br/>
Comprado por: <b><a href="/<?php echo gerarlogin($item->uid);?>"><?php echo gerarnome($item->uid);?></a></b><br/>
Título: <b><?php echo $info['nm'];?></b><br/>
Valor: <b><?php echo $info['valor'];?> pontos</b><br/>
Tipo: <b><?php echo $info['ext'];?></b><br/>
Mensagem: <b><?php echo $item->msg;?></b><br/>
Data da compra: <i><?php echo date("d/m/Y - H:i:s",$item->dt);?></i>
<?php if($id==$meuid) { ?>
- <a href="/lojas/presentes/<?php echo $id;?>/<?php echo $pag;?>/<?php echo $item->id;?>"><font color="#FF0000">[x]</font></a>
<?php } ?>
</div>
<?php $i++; }
if($numpag>1) {
paginas('lojas',$a,$numpag,$id,$pag);
}
} else { ?>
<div align="center">Este usuário não possui nenhum presente!<br/><br/>
<?php } } if($a!='') { ?>
<br/><div align="center"><a href="/lojas?"><?php echo $imgloja;?>Lojas</a> <?php } ?>
<br/><div align="center"><a href="/home?"><?php echo $imginicio;?>Página principal</a><br><br>
<?php echo rodape();?>
</body>
</html>