<?php
require_once("".$_SERVER["DOCUMENT_ROOT"]."/funcoes.php");
require_once("".$_SERVER["DOCUMENT_ROOT"]."/mistake.php");
seg($meuid);
if($a==false) { ?>
<br/><div id="titulo"><b>Busca</b></div><br/>
<form action="busca" method="get">
<b>Buscar Usuários</b><br/><br/>
Palavra chave:<br/>
<input type="text" name="nome" /><br/>
Por:<br/><select name="por">
<?php if(perm($meuid)>0) { ?>
<option value="id">ID</option>
<?php } ?>
<option value="nm">Nome</option>
<option value="sbn">Sobrenome</option>
<option value="qm">Quem sou eu</option>
<option value="em">E-mail</option>
<option value="cid">Cidade</option>
<option value="est">Estado</option>
<option value="nav">Navegador</option>
<?php if(perm($meuid)>0) { ?>
<option value="navr">Navegador real</option>
<option value="ip">IP</option>
<?php } ?>
</select><br/>
<input type="hidden" name="a" value="busca">
<input type="submit" value="Buscar" />
</form>
<?php } else if($a=='busca') { ativo($meuid,'Buscando usuários '); ?>
<br/><div id="titulo"><b>Busca de usuários</b></div><br/>
<?php
if($_GET['por']=='nm'){
$txt = "Nome";
$buc = 'nm';
}else if($_GET['por']=='id'){
$txt = "ID";
$buc = 'id';
}else if($_GET['por']=='sbn'){
$txt = "Sobrenome";
$buc = 'sbn';
}else if($_GET['por']=='qm'){
$txt = "Quem sou eu";
$buc = 'qm';
}else if($_GET['por']=='em'){
$txt = "E-mail";
$buc = 'em';
}else if($_GET['por']=='cid'){
$txt = "Cidade";
$buc = 'cid';
}else if($_GET['por']=='est'){
$txt = "Estado";
$buc = 'est';
}else if($_GET['por']=='nav'){
$txt = "Navegador";
$buc = 'nav';
}else if($_GET['por']=='navr'){
$txt = "Navegador real";
$buc = 'navr';
}else if($_GET['por']=='ip'){
$txt = "IP";
$buc = 'ip';
}
$contrec = $mistake->prepare("SELECT COUNT(*) FROM w_usuarios WHERE ".$buc." LIKE ?");
$contrec->execute(array("%".$_GET['nome']."%"));
$contrec = $contrec->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contrec[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->prepare("SELECT * FROM w_usuarios WHERE ".$buc." LIKE ? order by nm LIMIT $limit, $itensporpag");
$itens->execute(array("%".$_GET['nome']."%"));
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<?php echo online($item->id)>0?gstat($item->id,$im[0]):$imgoff; echo sexo($item->id)=='M'?$imgmasc:$imgfem;?><a href="/<?php echo gerarlogin($item->id);?>">
<?php echo gerarnome($item->id);?></a><br/>
<?php echo $txt;?>: <?php echo $_GET['por']=='id' ? $item->id : $_GET['nome'];?>
</div>
<?php $i++; } } else { ?>
<div align="center"><?php echo $imgerro;?>Não ah usuários  <?php } ?>
<div align="center"><br/>
<?php if($pag>1) { $ppag = $pag-1; ?>
<a href="busca?a=busca&nome=<?php echo $_GET['nome'];?>&por=<?php echo $_GET['por'];?>&pag=<?php echo $ppag;?>">&#171;Anterior</a>
<?php } if($pag<$numpag) { $npag = $pag+1; ?>
<a href="busca?a=busca&nome=<?php echo $_GET['nome'];?>&por=<?php echo $_GET['por'];?>&pag=<?php echo $npag;?>">Próxima&#187;</a>
<?php } ?>
<br/><?php echo $pag.'/'.$numpag;?><br/>
<?php if($numpag>2) { ?>
<form action="busca" method="get">
Pular para página<input name="pag" size="3">
<input type="submit" value="IR">
<input type="hidden" name="a" value="<?php echo $a;?>">
<input type="hidden" name="nome" value="<?php echo $nome;?>">
<input type="hidden" name="por" value="<?php echo $por;?>">
</form>
<?php } } if($a==true) { ?>
<br/><div align="center"><a href="busca?">Busca</a> <?php } ?>
<br/><div align="center"><a href="home?"><?php echo $imginicio;?>Página principal</a><br><br>
<?php echo rodape();?>
</body>
</html>