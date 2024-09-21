<?php
require_once("".$_SERVER["DOCUMENT_ROOT"]."/funcoes.php");
require_once("".$_SERVER["DOCUMENT_ROOT"]."/mistake.php");
require'rss.php';
seg($meuid);
ativo($meuid,'Notícias ');
if($a==false) { ?>
<br/><div id="titulo"><b>Notícias</b></div><br/>
<?php
$rsss = $mistake->query("select id, tit, img from w_catrss order by ord");
while ($rss = $rsss->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<img src="noticias_icons/<?php echo $rss->img;?>"><a href="noticias?a=noticias2&id=<?php echo $rss->id;?>"><?php echo $rss->tit;?></a><br/>
</div>
<?php $i++; } ?>
<br/><form action="noticias?a=buscar" method="post">
Buscar notícias:<br/><input name="texto" maxlength="15">
<input type="submit" value="Buscar"><br/>
<?php } else if($a=='noticias2') {
$tit = $mistake->query("SELECT tit, img FROM w_catrss WHERE id='$id'")->fetch(); ?>
<br/><div id="titulo">
<b><img src="noticias_icons/<?php echo $tit[1];?>"><?php echo $tit[0];?></b></div><br/>
<?php
$contnotic = $mistake->query("SELECT COUNT(*) FROM w_rss WHERE fid='$id'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contnotic[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->query("SELECT id, title, dscr, imgsrc, pubdate FROM w_rss WHERE fid='$id' ORDER BY title LIMIT $limit, $itensporpag");
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
&#187;<a href="noticias?a=noticias3&rssid=<?php echo $item->id;?>&fid=<?php echo $id;?>"><?php echo $item->title;?></a><br/></div>
<?php $i++; } ?>
<br/>
<div align="center"><br/>
<?php if($pag>1) { $ppag = $pag-1; ?>
<a href="noticias?a=noticias2&id=<?php echo $id;?>&pag=<?php echo $ppag;?>">&#171;Anterior</a>
<?php } if($pag<$numpag) { $npag = $pag+1; ?>
<a href="noticias?a=noticias2&id=<?php echo $id;?>&pag=<?php echo $npag;?>">Próxima&#187;</a>
<?php } ?>
<br/><?php echo $pag.'/'.$numpag;?><br/>
<?php if($numpag>2) { ?>
<form action="noticias.php" method="get">
Pular para página<input name="pag" size="3">
<input type="submit" value="IR">
<input type="hidden" name="a" value="<?php echo $a;?>">
<input type="hidden" name="id" value="<?php echo $id;?>">
<input type="hidden" name="on" value="<?php echo $on;?>">
</form>
<?php } } else { ?>
<div align="center">Esta categoria não possui notícias!<br/><br/>
<?php } } else if($a=='noticias3') {
$rssinfo = $mistake->query("SELECT lupdate, link, fid, title FROM w_rss WHERE id='".$_GET["rssid"]."'")->fetch();
$updt = time() - 3600;
if($rssinfo[0]<$updt)
{
$rss = new lastRSS;
$rss->cache_dir = './rsscache';
$rss->cache_time = 3600;
$rss->date_format = 'd/m/y - H:i';
$rss->stripHTML = true;
$rssurl = $rssinfo[1];
if ($rs = $rss->get($rssurl))
{
$title = $rs["title"];
$pgurl = $rs["link"];
$srcd = $rs["description"];
$pubdate = $rs["lastBuildDate"];
$mistake->exec("UPDATE w_rss SET lupdate='".time()."', pubdate='".$pubdate."' WHERE id='".$_GET["rssid"]."'");
$mistake->exec("DELETE FROM w_rssnt WHERE rssid='".$_GET["rssid"]."'");
$rssitems = $rs["items"];
for($i=0;$i<count($rssitems);$i++)
{
$rssitem = $rssitems[$i];
$iso88591 = $rssitem["title"];
$utf8_1 = utf8_encode($iso88591);
$utf8_2 = iconv('ISO-8859-1', 'UTF-8', $iso88591);
$utf8_2 = mb_convert_encoding($iso88591, 'UTF-8', 'ISO-8859-1');
$iso88591_1 = $rssitem["description"];
$utf8_1_1 = utf8_encode($iso88591_1);
$utf8_2_1 = iconv('ISO-8859-1', 'UTF-8', $iso88591_1);
$utf8_2_1 = mb_convert_encoding($iso88591_1, 'UTF-8', 'ISO-8859-1');
$mistake->exec("INSERT INTO w_rssnt (rssid,title,text,pubdate,fid) values('".$_GET["rssid"]."','".$utf8_2."','".$utf8_2_1."','".$rssitem["pubDate"]."','$rssinfo[2]')");
}
}
else
{
$errt = "Serviço indispinivel";
$mistake->exec("INSERT INTO w_rssnt (rssid,title,text,pubdate) values('".$_GET["rssid"]."','Erro!','$errt','".time()."')");
}
}
$rssinfo = $mistake->query("SELECT pgurl, title, srcd, imgsrc, fid FROM w_rss WHERE id='".$_GET["rssid"]."'")->fetch(); ?>
<br/><div id="titulo"><b><?php echo $rssinfo[1];?></b></div><br/>
<?php
if($pag=='' || $pag<=0)$pag=1;
$contnt = $mistake->query("SELECT COUNT(*) FROM w_rssnt WHERE rssid='".$_GET["rssid"]."'")->fetch();
$numitens = $contnt[0];
$itensporpag= 10;
$numpag = ceil($numitens/$itensporpag);
if(($pag>$numpag)&&$pag!=1)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->query("SELECT id, title,  text, pubdate, fid FROM w_rssnt WHERE rssid='".$_GET["rssid"]."' ORDER BY id LIMIT $limit, $itensporpag");
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<a href="noticias?a=noticias4&id=<?php echo $item->id;?>"><?php echo strip_tags($item->title);?></a>
 (<?php echo $item->pubdate;?>)</div>
<?php $i++; } } ?>
<div align="center"><br/>
<?php if($pag>1) { $ppag = $pag-1; ?>
<a href="noticias?a=noticias3&rssid=<?php echo $_GET['rssid'];?>&fid=<?php echo $_GET['fid'];?>&pag=<?php echo $ppag;?>">&#171;Anterior</a>
<?php } if($pag<$numpag) { $npag = $pag+1; ?>
<a href="noticias?a=noticias3&rssid=<?php echo $_GET['rssid'];?>&fid=<?php echo $_GET['fid'];?>&pag=<?php echo $npag;?>">Próxima&#187;</a>
<?php } ?>
<br/><?php echo $pag.'/'.$numpag;?><br/>
<?php if($numpag>2) { ?>
<form action="noticias.php" method="get">
Pular para página<input name="pag" size="3">
<input type="submit" value="IR">
<input type="hidden" name="a" value="<?php echo $a;?>">
<input type="hidden" name="rssid" value="<?php echo $_GET['rssid'];?>">
<input type="hidden" name="fid" value="<?php echo $_GET['fid'];?>">
<input type="hidden" name="on" value="<?php echo $on;?>">
</form>
<?php } } else if($a=='noticias4') {
$rsss = $mistake->query("SELECT title, text, rssid, pubdate, fid FROM w_rssnt WHERE id='$id'")->fetch();
$voltar = $mistake->query("SELECT title, fid FROM w_rss WHERE id='$rsss[2]'")->fetch();
$katrss = $mistake->query("SELECT tit FROM w_catrss WHERE id='$voltar[1]'")->fetch(); ?>
<br/><div id="titulo"><b><?php echo $rsss[0];?></b></div><br/>
<?php echo $rsss[1];?>
<br/><br/>Data da publicação: <b><?php echo $rsss[3];?></b><br/><br/>
<div align="center">
<a href="noticias?a=noticias3&rssid=<?php echo $rsss[2];?>&fid=<?php echo $voltar[1];?>"><?php echo $voltar[0];?></a><br/>
<?php } else if($a=='buscar') { ($pag=='')?($_SESSION['buscant']=$_POST['texto']):('');
if(trim($_SESSION['buscant'])=='') { ?>
<br/>Digite um texto para concluir a pesquiza
<?php } else { ($pag=='')?($_SESSION['buscant']=$_POST['texto']):(''); ?>
<br/><div id="titulo"><b>Resultado da busca por
<?php echo $_SESSION['buscant'];?></b></div><br/>
<?php
$contmsg = $mistake->query("SELECT COUNT(*) FROM w_rssnt WHERE title LIKE '%".$_SESSION['buscant']."%' OR text LIKE '%".$_SESSION['buscant']."%'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contmsg[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->query("SELECT id, title,  text, pubdate, fid FROM w_rssnt WHERE title LIKE '%".$_SESSION['buscant']."%' OR text LIKE '%".$_SESSION['buscant']."%' ORDER BY id LIMIT $limit, $itensporpag");
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<a href="noticias?a=noticias4&id=<?php echo $item->id;?>"><?php echo $item->title;?></a> (<?php echo $item->pubdate;?>)</div>
</div>
<?php $i++; } ?>
<br/><div align="center"><br/>
<?php if($pag>1) { $ppag = $pag-1; ?>
<a href="noticias?a=buscar&pag=<?php echo $ppag;?>">&#171;Anterior</a>
<?php } if($pag<$numpag) { $npag = $pag+1; ?>
<a href="noticias?a=buscar&pag=<?php echo $npag;?>">Próxima&#187;</a>
<?php } ?>
<br/><?php echo $pag.'/'.$numpag;?><br/>
<?php if($numpag>2) { ?>
<form action="noticias.php" method="get">
Pular para página<input name="pag" size="3">
<input type="submit" value="IR">
<input type="hidden" name="a" value="<?php echo $a;?>">
<input type="hidden" name="on" value="<?php echo $on;?>">
</form>
<?php } } else { ?>
<div align="center">Nenhum resultado!<br/><br/>
<?php } } } if($a!='') { ?>
<br/><div align="center"><a href="noticias?"><?php echo $imgnoticias;?>Notícias</a> <?php } ?>
<br/><div align="center"><a href="home?"><?php echo $imginicio;?>Página principal</a><br><br>
<?php echo rodape();?>
</body>
</html>