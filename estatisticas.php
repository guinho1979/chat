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
if($meuid>0&&$i['visitante']==1){
header("Location:/home?");
exit();
}
if($a==false) { 
ativo($meuid,'Estatísticas ');
$maxmem =  $mistake->prepare("SELECT maioron,dataon FROM w_geral");
$maxmem->execute();
$maxmem = $maxmem->fetch();
echo "<p align='center'>Maior numero de usuarios ativos foi<br><b>".$maxmem[0]."</b> em <b>".$maxmem[1]."</b><br>";
$maxtoday =  $mistake->prepare("SELECT maiorhoje,datahoje,horahoje FROM w_geral");
$maxtoday->execute();
$maxtoday = $maxtoday->fetch();
echo "Maior numero de usuarios ativos hoje<br><b>".$maxtoday[0]."</b> as <b>".$maxtoday[2]."</b> - <b>".$maxtoday[1]."</b></p>";
$h =  $mistake->query("SELECT count(*) FROM w_usuarios where sx='M'")->fetch();
$m =  $mistake->query("SELECT count(*) FROM w_usuarios where sx='F'")->fetch();
$nu =  $mistake->query("SELECT max(id) FROM w_usuarios")->fetch();
$contu =  $mistake->query("SELECT COUNT(*) FROM w_usuarios WHERE visitante='0'")->fetch();
$msgs =  $mistake->query("SELECT COUNT(*) FROM w_msgs")->fetch();
$rec =  $mistake->query("SELECT COUNT(*) FROM w_recados")->fetch();
$mural =  $mistake->query("SELECT COUNT(*) FROM w_mural")->fetch();
$eq =  $mistake->query("SELECT COUNT(*) FROM w_usuarios where (perm>'0' or perm2>'0') and mostrastatus='0'")->fetch();
$con =  $mistake->query("SELECT COUNT(*) FROM w_usuarios where verificado='1'")->fetch();
$vip =  $mistake->query("SELECT COUNT(*) FROM w_usuarios where vip='1'")->fetch();
$ani =  $mistake->query("SELECT count(*) FROM w_usuarios where DAYOFYEAR(nasc) BETWEEN DAYOFYEAR(NOW()) AND DAYOFYEAR(NOW())+7")->fetch();
$enq =  $mistake->query("SELECT count(*) FROM w_enquetes")->fetch();
$banidos =  $mistake->query("SELECT COUNT(*) FROM w_usuarios where banido='1'")->fetch();
?>
<div id="titulo"><b>Estatísticas</b></div><br/>
Usuários cadastrados: <b><?php echo number_format($contu[0],0,",",".");?></b><br/>
Novo usuário: <b><a href="/<?php echo gerarlogin($nu[0]);?>"><?php echo gerarnome($nu[0]);?></a></b><br/>
Mensagens: <b><?php echo $msgs[0];?></b><br/>
Recados: <b><?php echo $rec[0];?></b><br/>
Mensagens no mural: <b><?php echo $mural[0];?></b><br/>
<?php if(perm($meuid)==3 OR perm($meuid)==4) {
$msn =  $mistake->query("SELECT count(*) FROM w_msn where bloq='0' and e='0'")->fetch();
$msn2 =  $mistake->query("SELECT count(*) FROM w_msn2")->fetch();
$tm30 = time()-2592000;
$inaa =  $mistake->query("SELECT COUNT(*) FROM w_usuarios WHERE ativo<'".$tm30."' and email like '%@%'")->fetch();
?>
E-mails: <b><?php echo $msn2[0];?></b><br/>
E-mails a enviar: <b><?php echo $msn[0];?></b><br/>
Inativos a mais de um mês: <b><?php echo $inaa[0];?></b><br/>
<?php } ?>
<br/>
<?php if(perm($meuid)>0) { ?>
<a href="/estatisticas/fonte"><?php echo $imgseta;?> Novos Usuários</a> (<i>só equipe</i>)<br/><br/>
<?php } ?>
<div id="div1"><a href="/estatisticas/24h"><?php echo $imgseta;?> Últimas 24 horas</a></div>
<div id="div1"><a href="/estatisticas/usuarios"><?php echo $imgseta;?> Usuários</a>(<?php echo number_format($contu[0],0,",",".");?>)</div>
<div id="div1"><a href="/estatisticas/usuarios/m"><?php echo $imgseta;?> Homens</a>(<?php echo $h[0];?>)</div>
<div id="div1"><a href="/estatisticas/usuarios/f"><?php echo $imgseta;?> Mulheres</a>(<?php echo $m[0];?>)</div>
<div id="div1"><a href="/estatisticas/usuarios/v"><?php echo $imgseta;?> Usuários VIP</a>(<?php echo $vip[0];?>)</div>
<div id="div1"><a href="/estatisticas/usuarios/e"><?php echo $imgseta;?> Equipe do site</a>(<?php echo $eq[0];?>)</div>
<div id="div1"><a href="/estatisticas/usuarios/c"><?php echo $imgseta;?> Usuários verificados</a>(<?php echo $con[0];?>)</div>
<div id="div1"><a href="/estatisticas/status"><?php echo $imgseta;?> Status dos usuários</a></div>
<div id="div1"><a href="/estatisticas/top"><?php echo $imgseta;?> Top do site</a></div>
<div id="div1"><a href="/estatisticas/niver"><?php echo $imgseta;?> Próximos aniversários</a>(<?php echo $ani[0];?>)</div>
<div id="div1"><a href="/enquete?a=categorias"><?php echo $imgseta;?> Enquetes</a>(<?php echo $enq[0];?>)</div>
<div id="div1"><a href="/estatisticas/banidos"><?php echo $imgseta;?> Banidos</a>(<?php echo $banidos[0];?>)</div>
<?php 
}else 
if($a=='banidos') {
?>
<br/><div id="titulo"><b>Usuários banidos</b></div><br/>
<?php
$contvip =  $mistake->query("SELECT count(*) FROM w_usuarios where banido='1'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contvip[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens =  $mistake->prepare("SELECT * FROM w_usuarios where banido='1' ORDER BY id desc LIMIT $limit, $itensporpag");
$itens->execute();
$i=0; 
while ($item = $itens->fetch(PDO::FETCH_OBJ)) { 
?>
<div id="<?php echo $i%2==0?'div1':'div1';?>">
<a href="/<?php echo gerarlogin($item->banidopor);?>"><?php echo gerarnome($item->banidopor);?></a> baniu
<a href="/<?php echo gerarlogin($item->id);?>"><?php echo gerarnome($item->id);?></a> dia <?php echo date("d/m/Y", $item->databan);?> as <?php echo date("H:i:s", $item->databan);?>.
<br/>
Razão: <?php echo $item->razaoban;?>
</div>
<?php 
$i++; 
} 
} else { 
?>
<div align="center">Nenhum usuário banido <?php }
if($numpag>1) { 
paginas('estatisticas',$a,$numpag,$id,$pag);    
} 
}else 
if($a == "toponline"){
ativo($meuid,'Vendo top online');
$tempo =  $mistake->prepare("SELECT ton FROM w_usuarios WHERE id='".$meuid."'");
$tempo->execute();
$tempo = $tempo->fetch();
$tempo = floor($tempo[0]/60);
?>
<center>
<?
echo "<br><b>Top Online</b><br>Voce tem <strong>$tempo minutos</strong> no top online!</center><br><br>";
if($pag=='' || $pag<=0)$pag=1;
$user =  $mistake->prepare("SELECT COUNT(*) FROM w_usuarios WHERE ton>0");
$user->execute();
$user = $user->fetch();
$numitens = $user[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
$sql = "SELECT id,nm,sx,ton FROM w_usuarios WHERE ton>0 and visitante='0' ORDER BY ton DESC LIMIT $limit, $itensporpag";
$query =  $mistake->prepare($sql);
$query->execute();
if($query->rowCount()>0){
$num = 0;
while ($mods = $query->fetch()){
if($mods[2]=='M'){
$usex = "<img src='/style/masc.gif' alt='(M)'/>";
}else 
if($mods[2]=='F'){
$usex = "<img src='/style/fem.gif' alt='(F)'/>";
}
$jdt = floor($mods[3]/60);
$color = ($num % 2 == 0)? "<div id='div1'>"  : "<div id='div1'>";
$lnk = "$usex<a href='/".gerarlogin($mods[0])."'>".gerarnome($mods[0])."</a><br> - <strong>$jdt minutos</strong> no top online!";
echo "$color $lnk</div>";
$num++;
}
if($numpag>1) {
paginas('estatisticas',$a,$numpag,$id,$pag);    
} 
}
}else
if($a=='usuarios') { ativo($meuid,'Vendo usuários '); ?>
<br/><div id="titulo"><b>Usuários</b></div><br/>
<?php
if($id=='m'){
$where = "where sx='M' and visitante='0'";
$ord = 'id desc';
}else if($id=='f'){
$where = "where sx='F' and visitante='0'";
$ord = 'id desc';
}else if($id=='c'){
$where = "where verificado='1' and visitante='0'";
$ord = 'id desc';
}else if($id=='e'){
$where = "where (perm>'0' or perm2>'0') and mostrastatus='0' and visitante='0'";
$ord = 'perm desc,nm asc';
}else if($id=='indicado'){
$where = "where indicado='$id' and visitante='0'";
$ord = 'id desc';
}else if($id=='v'){
$where = "where vip='1' and visitante='0'";
$ord = 'id desc';
}else{
$where = 'where visitante=0';
$ord = 'id desc';
}
$contrec =  $mistake->query("SELECT count(*) FROM w_usuarios $where")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contrec[0];
$itensporpag = 12;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens =  $mistake->query("SELECT id, rg FROM w_usuarios $where ORDER BY $ord LIMIT $limit, $itensporpag");
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div1';?>">
<?php echo online($item->id)>0?gstat($item->id):$imgoff; echo sexo($item->id)=='M'?$imgmasc:$imgfem;?><a href="/<?php echo gerarlogin($item->id);?>">
<?php echo gerarnome($item->id);?></a> - <?php echo status($item->id);?> <br/><?php echo date("d/m/Y - H:i:s", $item->rg);?></div>
<?php $i++; } } else { ?>
<div align="center">Não ah usuários  <?php } 
if($numpag>1) {
paginas('estatisticas',$a,$numpag,$id,$pag);    
} } else if($a=='fonte') { ativo($meuid,'Vendo novos usuários '); ?>
<br/><div id="titulo"><b>Novos Usuários</b></div><br/>
<div align="center">Fique sabendo como os novos usuários ficaram sabendo do site</div><br/>
<?php
$contrec =  $mistake->query("SELECT count(*) FROM w_usuarios WHERE visitante='0'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contrec[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens =  $mistake->query("SELECT id, fnt FROM w_usuarios WHERE visitante='0' ORDER BY id desc LIMIT $limit, $itensporpag");
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { $contem =  $mistake->query("SELECT count(*) FROM w_msn2 where uid='".$item->id."'")->fetch(); ?>
<div id="<?php echo $i%2==0?'div1':'div1';?>">
<?php echo online($item->id)>0?gstat($item->id):$imgoff;?><a href="/<?php echo gerarlogin($item->id);?>">
<?php echo gerarnome($item->id);?></a> - <?php echo $item->fnt;?> - <?php echo $contem[0];?></div>
<?php $i++; } } else { ?>
<div align="center">Não ah usuários  <?php }
if($numpag>1) {
paginas('estatisticas',$a,$numpag,$id,$pag);    
} } else if($a=='to') { ativo($meuid,'Vendo tempo online de usuários '); ?>
<br/><div id="titulo"><b>Total tempo online</b></div><br/>
<?php
$contrec =  $mistake->query("SELECT count(*) FROM w_usuarios where ton>'0'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contrec[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens =  $mistake->query("SELECT id, ton FROM w_usuarios where ton>'0' ORDER BY ton desc LIMIT $limit, $itensporpag");
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div1';?>">
<?php echo online($item->id)>0?gstat($item->id):$imgoff; echo sexo($item->id)=='M'?$imgmasc:$imgfem;?><a href="/<?php echo gerarlogin($item->id);?>">
<?php echo gerarnome($item->id);?></a><br/>
<?php echo gerartempo($item->ton);?> online</div>
<?php $i++; } } else { ?>
<div align="center">Não ah usuários  <?php }
if($numpag>1) {
paginas('estatisticas',$a,$numpag,$id,$pag);    
} } else if($a=='to2') { ativo($meuid,'Vendo Top Tempo Online '); ?>
<br/><div id="titulo"><b>Concurso Top Tempo Online</b></div><br/>
<?php
$contrec =  $mistake->query("SELECT count(*) FROM w_usuarios where ton2>'0' and visitante='0'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contrec[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens =  $mistake->query("SELECT id, ton2 FROM w_usuarios where ton2>'0' and visitante='0' ORDER BY ton2 desc LIMIT $limit, $itensporpag");
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div1';?>">
<?php echo online($item->id)>0?gstat($item->id):$imgoff; echo sexo($item->id)=='M'?$imgmasc:$imgfem;?><a href="/<?php echo gerarlogin($item->id);?>">
<?php echo gerarnome($item->id);?></a><br/>
<?php echo gerartempo($item->ton2);?> online</div>
<?php $i++; } } else { ?>
<div align="center">Não ah usuários  <?php }
if($numpag>1) {
paginas('estatisticas',$a,$numpag,$id,$pag);    
} } else if($a=='24h') {
$tm24 = time()-(24*60*60);
$aut =  $mistake->query("SELECT COUNT(*) FROM w_usuarios WHERE ativo>'".$tm24."' and visitante='0'")->fetch();
$rg =  $mistake->query("SELECT COUNT(*) FROM w_usuarios WHERE rg>'".$tm24."' and visitante='0'")->fetch();
$cmnc =  $mistake->query("SELECT COUNT(*) FROM w_comu WHERE cri>'".$tm24."'")->fetch();
$msgs =  $mistake->query("SELECT COUNT(*) FROM w_msgs WHERE hr>'".$tm24."'")->fetch();
$recados =  $mistake->query("SELECT COUNT(*) FROM w_recados WHERE hr>'".$tm24."'")->fetch();
$posts =  $mistake->query("SELECT COUNT(*) FROM w_posts WHERE dt>'".$tm24."'")->fetch();
$mural =  $mistake->query("SELECT COUNT(*) FROM w_mural WHERE hora>'".$tm24."'")->fetch();
$downs =  $mistake->query("SELECT COUNT(*) FROM w_downs WHERE dt>'".$tm24."'")->fetch();
$down_cmt =  $mistake->query("SELECT COUNT(*) FROM w_down_cmt WHERE dt>'".$tm24."'")->fetch();
$albuns =  $mistake->query("SELECT COUNT(*) FROM w_albuns WHERE dt>'".$tm24."'")->fetch();
$albuns_at =  $mistake->query("SELECT COUNT(*) FROM w_albuns WHERE at>'".$tm24."'")->fetch();
$cmt_foto =  $mistake->query("SELECT COUNT(*) FROM w_cmt_fotos WHERE hora>'".$tm24."'")->fetch();
?>
<br/><div id="titulo"><b>Últimas 24 horas no site</b></div><br/>
Usuários ativos: <b><?php echo $aut[0];?></b><br/>
Usuários registrados: <b><?php echo $rg[0];?></b><br/>
Comunidades criadas: <b><?php echo $cmnc[0];?></b><br/>
Mensagens enviadas: <b><?php echo $msgs[0];?></b><br/>
Recados enviados: <b><?php echo $recados[0];?></b><br/>
Recados no mural: <b><?php echo $mural[0];?></b><br/>
Postagens em tópicos: <b><?php echo $posts[0];?></b><br/>
Downloads adicionados: <b><?php echo $downs[0];?></b><br/>
Comentários em downloads: <b><?php echo $down_cmt[0];?></b><br/>
Álbuns criados: <b><?php echo $albuns[0];?></b><br/>
Álbuns atualizados: <b><?php echo $albuns_at[0];?></b><br/>
Comentários em fotos: <b><?php echo $cmt_foto[0];?></b><br/>
<?php } else if($a=='status') { ativo($meuid,'Vendo status de usuários '); ?>
<br/><div id="titulo"><b>Status dos usuários</b></div><br/><br/>
0 Pontos = Novato<br/>
10 Pontos = Visitante<br/>
25 Pontos = Visitante Prata<br/>
50 Pontos = Visitante Ouro<br/>
75 Pontos = Frequente<br/>
250 Pontos = Super Membro<br/>
500 Pontos = Membro Plugado<br/>
750 Pontos = Membro Diamante<br/>
1000 Pontos = Membro Top User<br/>
1500 Pontos = FaNáticO<br/>
2000 Pontos = Membro Guerreiro<br/>
2500 Pontos = VeteRaNo<br/>
3000 Pontos = Membro eXpelleR<br/>
4000 Pontos = Membro MasteR<br/>
5000 Pontos = Membro Icon<br/>
10000 Pontos = Membro volcaNo<br/><br/>
<?php } else if($a=='top') { ativo($meuid,'Vendo top do site '); ?>
<br/><div id="titulo"><b>Top do site</b></div><br/><br/>
<div id="div1"><a href="/estatisticas/topquiza"><?php echo $imgseta;?> Acertos</a> - <a href="/estatisticas/topquize">Erros</a></div>
<div id="div1"><a href="/estatisticas/topvou"><?php echo $imgseta;?> Vou</a> - <a href="/estatisticas/topnaovou">Não Vou</a></div>
<div id="div1"><a href="/apostadores?"><?php echo $imgseta;?> Apostadores</a></div>
<div id="div1"><a href="/estatisticas/top2/indicacoes"><?php echo $imgseta;?> Divulgadores</a></div>
<div id="div1"><a href="/estatisticas/topdown"><?php echo $imgseta;?> Downloads</a></div>
<div id="div1"><a href="/estatisticas/toploja"><?php echo $imgseta;?> Compradores</a></div>
<div id="div1"><a href="/estatisticas/top2/pts"><?php echo $imgseta;?> Pontos</a></div>
<div id="div1"><a href="/estatisticas/toptopicos"><?php echo $imgseta;?> Tópicos</a></div>
<div id="div1"><a href="/estatisticas/toppostagens"><?php echo $imgseta;?> Postagens</a></div>
<div id="div1"><a href="/estatisticas/topchat"><?php echo $imgseta;?> Chat</a></div>
<div id="div1"><a href="/estatisticas/toponline"><?php echo $imgseta;?> Tempo online</a></div>
<div id="div1"><a href="/fas?a=top"><?php echo $imgseta;?> Fãs</a></div>
<div id="div1"><a href="/estatisticas/topmural"><?php echo $imgseta;?> Mural</a></div>
<div id="div1"><a href="/estatisticas/top2/banco"><?php echo $imgseta;?> Depositantes</a></div>
<!--<div id="div1"><a href="/estatisticas/top2/xp"><?php //echo $imgseta;?> Xp's Sexual</a></div>!-->
<div id="div1"><a href="/estatisticas/top2/pontoonl"><?php echo $imgseta;?> Top pontos online</a></div>
<?php } else if($a=='top2') { ativo($meuid,'Vendo top do site ');
if($id=='pts'){
$order = 'pt';
$tit = 'Pontos';
}else if($id=='indicacoes'){
$order = 'indicacoes';
$tit = 'Indicações';
}else if($id=='tpc'){
$order = 'tpc';
$tit = 'Tópicos';
}else if($id=='banco'){
$order = 'bank';
$tit = 'Pontos no banco';
}
else if($id=='pontoonl'){
$order = 'pontoon';
$tit = 'Pontos online';
}
else if($id=='xp'){
$order = 'xp_sexual';
$order2 = 'AND brincar_sexual>0';
$tit = '';
$tit1 = 'Top XP Sexual';
$tit2 = 'XP Sexual';
}
?>
<br/><div id="titulo"><b><?php echo $tit;?><?php echo $tit1;?></b></div><br/>
<?php
$contrec =  $mistake->query("SELECT count(*) FROM w_usuarios where $order>'0' $order2 and visitante='0'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contrec[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens =  $mistake->query("SELECT id, $order FROM w_usuarios where $order>'0' $order2 and visitante='0' ORDER BY $order desc LIMIT $limit, $itensporpag");
$i=0; while($item = $itens->fetch(PDO::FETCH_OBJ)) {
if($id=='xp'){
$tit3 = ' - <font color="red"><b>'.status_sexual($item->id).'</b></font>';}
 ?>
<div id="<?php echo $i%2==0?'div1':'div1';?>">
<?php echo online($item->id)>0?gstat($item->id):$imgoff;?><a href="/<?php echo gerarlogin($item->id);?>">
<?php echo gerarnome($item->id);?></a><br/>
<b><?php echo $item->$order;?></b> <?php echo $tit;?><?php echo $tit2;?><?php echo $tit3;?>
</div>
<?php $i++; } } else { ?>
<div align="center">Não ah usuários  <?php }
if($numpag>1) { 
paginas('estatisticas',$a,$numpag,$id,$pag);    
?>

<?php } 
?>
<?php  } else if($a=='toppostagens') { ativo($meuid,'Vendo top postagens '); ?>
<br/><div id="titulo"><b>Top Postagens</b></div><br/>
<form action="/estatisticas" method="get">
<select name="id">
<option value="1">Hoje</option>
<option value="2" <?php echo $id==2?' selected ':'';?> >Últimos 7 dias</option>
<option value="3" <?php echo $id==3?' selected ':'';?> >Mês</option>
<option value="4" <?php echo $id==4?' selected ':'';?> >Geral</option>
</select>
<input type="hidden" value="<?php echo $a;?>" name="a">
<input type="submit" value="IR">
</form><br/>
<?php
if($id==false or $id==1){
$diaa = time()-86400;
}else if($id==2){
$diaa = time()-604800;
}else if($id==3){
$diaa = time()-2592000;
}else if($id==4){
$diaa = 0;
}
$contrec =  $mistake->query("SELECT COUNT(DISTINCT(por)) FROM w_posts where dt>'$diaa'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contrec[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens =  $mistake->query("SELECT COUNT(*) as notp, b.id FROM w_posts a INNER JOIN w_usuarios b where a.dt>'$diaa' and a.por=b.id GROUP BY b.id ORDER BY notp DESC LIMIT $limit, $itensporpag");
$i=0; while($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div1';?>">
<?php echo online($item->id)>0?gstat($item->id):$imgoff;?><a href="/<?php echo gerarlogin($item->id);?>">
<?php echo gerarnome($item->id);?></a><br/>
<b><?php echo $item->notp;?></b> postagens
</div>
<?php $i++; } } else { ?>
<div align="center">Não ah usuários  <?php }
if($numpag>1) { 
paginas('estatisticas',$a,$numpag,$id,$pag);    
?>
<a href="/estatisticas/top">Top do site</a><br/>
<?php
} 
} 
else 
if($a=='topmural') { ativo($meuid,'Vendo top mural '); ?>
<br/><div id="titulo"><b>Top Mural</b></div><br/>
<form action="/estatisticas" method="get">
<select name="id">
<option value="1">Hoje</option>
<option value="2" <?php echo $id==2?' selected ':'';?> >Últimos 7 dias</option>
<option value="3" <?php echo $id==3?' selected ':'';?> >Mês</option>
<option value="4" <?php echo $id==4?' selected ':'';?> >Geral</option>
</select>
<input type="hidden" value="<?php echo $a;?>" name="a">
<input type="submit" value="IR">
</form><br/>
<?php
if($id==false or $id==1){
$diaa = time()-86400;
}else if($id==2){
$diaa = time()-604800;
}else if($id==3){
$diaa = time()-2592000;
}else if($id==4){
$diaa = 0;
}
$contrec =  $mistake->query("SELECT COUNT(DISTINCT(drec)) FROM w_mural where hora>'$diaa'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contrec[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens =  $mistake->query("SELECT COUNT(*) as notp, b.id FROM w_mural a INNER JOIN w_usuarios b where a.hora>'$diaa' and a.drec=b.id GROUP BY b.id ORDER BY notp DESC LIMIT $limit, $itensporpag");
$i=0; while($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div1';?>">
<?php echo online($item->id)>0?gstat($item->id):$imgoff;?><a href="/<?php echo gerarlogin($item->id);?>">
<?php echo gerarnome($item->id);?></a><br/>
<b><?php echo $item->notp;?></b> mensagens no mural
</div>
<?php $i++; } } else { ?>
<div align="center">Não ah usuários  <?php }
if($numpag>1) {
paginas('estatisticas',$a,$numpag,$id,$pag);    
?>
<a href="/estatisticas/top">Top do site</a><br/>
<?php } } else if($a=='topchat') { ativo($meuid,'Vendo top chat '); ?>
<br/><div id="titulo"><b>Top Chat</b></div><br/>
<form action="estatisticas.php" method="get">
<select name="id">
<option value="1">Hoje</option>
<option value="2" <?php echo $id==2?' selected ':'';?> >Últimos 7 dias</option>
<option value="3" <?php echo $id==3?' selected ':'';?> >Mês</option>
<option value="4" <?php echo $id==4?' selected ':'';?> >Geral</option>
</select>
<input type="hidden" value="<?php echo $a;?>" name="a">
<input type="submit" value="IR">
</form><br/>
<?php
if($id==false or $id==1){
$diaa = time()-86400;
}else if($id==2){
$diaa = time()-604800;
}else if($id==3){
$diaa = time()-2592000;
}else if($id==4){
$diaa = 0;
}
$contrec =  $mistake->query("SELECT COUNT(DISTINCT(por)) FROM w_mchat where hr>'$diaa'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contrec[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens =  $mistake->query("SELECT COUNT(*) as notp, b.id FROM w_mchat a INNER JOIN w_usuarios b where a.hr>'$diaa' and a.por=b.id GROUP BY b.id ORDER BY notp DESC LIMIT $limit, $itensporpag");
$i=0; while($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div1';?>">
<?php echo online($item->id)>0?gstat($item->id):$imgoff;?><a href="/<?php echo gerarlogin($item->id);?>">
<?php echo gerarnome($item->id);?></a><br/>
<b><?php echo $item->notp;?></b> mensagens no chat
</div>
<?php $i++; } } else { ?>
<div align="center">Não ah usuários  <?php }
if($numpag>1) { 
paginas('estatisticas',$a,$numpag,$id,$pag);    
?>
<a href="/estatisticas/top">Top do site</a><br/>
<?php } } else if($a=='topdown') { ativo($meuid,'Vendo top downloads '); ?>
<br/><div id="titulo"><b>Top Downloads</b></div><br/>
<form action="/estatisticas" method="get">
<select name="id">
<option value="1">Hoje</option>
<option value="2" <?php echo $id==2?' selected ':'';?> >Últimos 7 dias</option>
<option value="3" <?php echo $id==3?' selected ':'';?> >Mês</option>
<option value="4" <?php echo $id==4?' selected ':'';?> >Geral</option>
</select>
<input type="hidden" value="<?php echo $a;?>" name="a">
<input type="submit" value="IR">
</form><br/>
<?php
if($id==false or $id==1){
$diaa = time()-86400;
}else if($id==2){
$diaa = time()-604800;
}else if($id==3){
$diaa = time()-2592000;
}else if($id==4){
$diaa = 0;
}
$contrec =  $mistake->query("SELECT COUNT(DISTINCT(dn)) FROM w_downs where dt>'$diaa'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contrec[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens =  $mistake->query("SELECT COUNT(*) as notp, b.id FROM w_downs a INNER JOIN w_usuarios b where dt>'$diaa' and a.dn=b.id GROUP BY b.id ORDER BY notp DESC LIMIT $limit, $itensporpag");
$i=0; while($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div1';?>">
<?php echo online($item->id)>0?gstat($item->id):$imgoff;?><a href="/<?php echo gerarlogin($item->id);?>">
<?php echo gerarnome($item->id);?></a><br/>
<b><?php echo $item->notp;?></b> downloads
</div>
<?php $i++; } } else { ?>
<div align="center">Não ah usuários  <?php }
if($numpag>1) { 
paginas('estatisticas',$a,$numpag,$id,$pag);    
?>
<a href="/estatisticas/top">Top do site</a><br/>
<?php } } else if($a=='toptopicos') { ativo($meuid,'Vendo top tópicos '); ?>
<br/><div id="titulo"><b>Top Tópicos</b></div><br/>
<form action="/estatisticas" method="get">
<select name="id">
<option value="1">Hoje</option>
<option value="2" <?php echo $id==2?' selected ':'';?> >Últimos 7 dias</option>
<option value="3" <?php echo $id==3?' selected ':'';?> >Mês</option>
<option value="4" <?php echo $id==4?' selected ':'';?> >Geral</option>
</select>
<input type="hidden" value="<?php echo $a;?>" name="a">
<input type="submit" value="IR">
</form><br/>
<?php
if($id==false or $id==1){
$diaa = time()-86400;
}else if($id==2){
$diaa = time()-604800;
}else if($id==3){
$diaa = time()-2592000;
}else if($id==4){
$diaa = 0;
}
$contrec =  $mistake->query("SELECT COUNT(DISTINCT(por)) FROM w_topicos where dt>'$diaa'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contrec[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens =  $mistake->query("SELECT COUNT(*) as notp, b.id FROM w_topicos a INNER JOIN w_usuarios b where dt>'$diaa' and a.por=b.id GROUP BY b.id ORDER BY notp DESC LIMIT $limit, $itensporpag");
$i=0; while($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div1';?>">
<?php echo online($item->id)>0?gstat($item->id):$imgoff;?><a href="/<?php echo gerarlogin($item->id);?>">
<?php echo gerarnome($item->id);?></a><br/>
<b><?php echo $item->notp;?></b> tópico<?php echo $item->notp>1?'s':'';?>
</div>
<?php $i++; } } else { ?>
<div align="center">Não ah usuários  <?php } 
if($numpag>1) { 
paginas('estatisticas',$a,$numpag,$id,$pag);
?>
<a href="/estatisticas/top">Top do site</a><br/>
<?php } } else if($a=='topvou') { ativo($meuid,'Vendo top vou '); ?>
<br/><div id="titulo"><b>Top vou</b></div><br/>
<?php
$contrec =  $mistake->query("SELECT COUNT(DISTINCT(aid)) FROM w_vounaovou where e='1'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contrec[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens =  $mistake->query("SELECT COUNT(*) as notp, b.id FROM w_vounaovou a INNER JOIN w_usuarios b where a.aid=b.id and a.e='1' GROUP BY b.id ORDER BY notp DESC LIMIT $limit, $itensporpag");
$i=0; while($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div1';?>">
<?php echo online($item->id)>0?gstat($item->id):$imgoff;?><a href="/<?php echo gerarlogin($item->id);?>">
<?php echo gerarnome($item->id);?></a><br/>
<b><?php echo $item->notp;?></b> vou
</div>
<?php $i++; } } else { ?>
<div align="center">Não ah usuários  <?php }
if($numpag>1) { 
paginas('estatisticas',$a,$numpag,$id,$pag);
?>
<a href="/estatisticas/top">Top do site</a><br/>
<?php } } else if($a=='topnaovou') { ativo($meuid,'Vendo top Não vou '); ?>
<br/><div id="titulo"><b>Top Não vou</b></div><br/>
<?php
$contrec =  $mistake->query("SELECT COUNT(DISTINCT(aid)) FROM w_vounaovou where e='0'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contrec[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens =  $mistake->query("SELECT COUNT(*) as notp, b.id FROM w_vounaovou a INNER JOIN w_usuarios b where a.aid=b.id and a.e='0' GROUP BY b.id ORDER BY notp DESC LIMIT $limit, $itensporpag");
$i=0; while($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div1';?>">
<?php echo online($item->id)>0?gstat($item->id):$imgoff;?><a href="/<?php echo gerarlogin($item->id);?>">
<?php echo gerarnome($item->id);?></a><br/>
<b><?php echo $item->notp;?></b> vou
</div>
<?php $i++; } } else { ?>
<div align="center">Não ah usuários  <?php }
if($numpag>1) { 
paginas('estatisticas',$a,$numpag,$id,$pag);
?>
<a href="/estatisticas/top">Top do site</a><br/>
<?php } } else if($a=='topquiza') { ativo($meuid,'Vendo top quiz '); ?>
<br/><div id="titulo"><b>Top quiz</b></div><br/>
<?php
$contrec =  $mistake->query("SELECT count(*) FROM w_usuarios where qzaa>'0'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contrec[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens =  $mistake->query("SELECT id, qzaa FROM w_usuarios where qzaa>'0' order by qzaa desc limit $limit, $itensporpag");
$i=0; while($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div1';?>">
<?php echo online($item->id)>0?gstat($item->id):$imgoff;?><a href="/<?php echo gerarlogin($item->id);?>">
<?php echo gerarnome($item->id);?></a><br/>
<b><?php echo $item->qzaa;?></b> acertos
</div>
<?php $i++; } } else { ?>
<div align="center">Não ah usuários  <?php }
if($numpag>1) { 
paginas('estatisticas',$a,$numpag,$id,$pag);    
?>
<a href="/estatisticas/top">Top do site</a><br/>
<?php } } else if($a=='topquize') { ativo($meuid,'Vendo top quiz '); ?>
<br/><div id="titulo"><b>Top quiz</b></div><br/>
<?php
$contrec =  $mistake->query("SELECT count(*) FROM w_usuarios where qzee>'0'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contrec[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens =  $mistake->query("SELECT id, qzee FROM w_usuarios where qzee>'0' order by qzee desc limit $limit, $itensporpag");
$i=0; while($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div1';?>">
<?php echo online($item->id)>0?gstat($item->id):$imgoff;?><a href="/<?php echo gerarlogin($item->id);?>">
<?php echo gerarnome($item->id);?></a><br/>
<b><?php echo $item->qzee;?></b> erros
</div>
<?php $i++; } } else { ?>
<div align="center">Não ah usuários  <?php }
if($numpag>1) {
paginas('estatisticas',$a,$numpag,$id,$pag);    
} } else if($a=='toploja') { ativo($meuid,'Vendo top compradores '); ?>
<br/><div id="titulo"><b>Top compradores</b></div><br/>
<?php
$contrec =  $mistake->query("SELECT COUNT(*) FROM w_usuarios")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contrec[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens =  $mistake->query("SELECT COUNT(*) as notp, b.id FROM w_loja_cc a INNER JOIN w_usuarios b where a.uid=b.id GROUP BY b.id ORDER BY notp DESC LIMIT $limit, $itensporpag");
$i=0; while($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div1';?>">
<?php echo online($item->id)>0?gstat($item->id):$imgoff;?><a href="/<?php echo gerarlogin($item->id);?>">
<?php echo gerarnome($item->id);?></a><br/>
<b><?php echo $item->notp;?></b> presentes
</div>
<?php $i++; } } else { ?>
<div align="center">Não ah usuários  <?php } ?>
<div align="center"><br/>
<?php if($pag>1) { $ppag = $pag-1; ?>
<a href="/estatisticas/toploja&pag=<?php echo $ppag;?>"><?php echo $imgsetavoltar;?> Anterior</a>
<?php } if($pag<$numpag) { $npag = $pag+1; ?>
<a href="/estatisticas/toploja&pag=<?php echo $npag;?>">Próxima <?php echo $imgseta;?></a>
<?php } ?>
<br/><?php echo $pag.'/'.$numpag;?><br/>
<?php if($numpag>1) { 
paginas('estatisticas',$a,$numpag,$id,$pag);
?>
<a href="/estatisticas/top">Top do site</a><br/>
<?php } } else if($a=='niver') { ativo($meuid,'Aniversáriantes do dia '); ?>
<br/><div id="titulo"><b>Aniversáriantes do dia</b></div><br/>
<?php
$contrec =  $mistake->query("SELECT count(*) FROM w_usuarios where DAYOFYEAR(nasc) BETWEEN DAYOFYEAR(NOW()) AND DAYOFYEAR(NOW())+7")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contrec[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens =  $mistake->query("SELECT id, sbn, nasc FROM w_usuarios where DAYOFYEAR(nasc) BETWEEN DAYOFYEAR(NOW()) AND DAYOFYEAR(NOW())+7 order by SUBSTR(nasc,6,2),SUBSTR(nasc,9,2) asc LIMIT $limit, $itensporpag");
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div1';?>">
<?php echo online($item->id)>0?gstat($item->id):$imgoff;?><a href="/<?php echo gerarlogin($item->id);?>">
<?php echo gerarnome($item->id);?></a> - <?php
if(substr($item->nasc,5,5)==date('m-d'))
{
echo '<b>Hoje</b>';
}
else if(substr($item->nasc,5,5)==date("m-0".(date('d')+1).""))
{
echo 'Amanhã';
}
else
{
echo substr($item->nasc,8,2).' de '.gerarmes($item->id);
}
?><br/>
</div>
<?php $i++; } } else { ?>
<div align="center">Nenhum aniversariante para hoje <?php }
if($numpag>1) {
paginas('estatisticas',$a,$numpag,$id,$pag);    
} } if($a==true) { ?>
<br/><div class="col-12 text-center" style="margin-top: 20px"><a href="javascript:window.history.back();"><?php echo $imgsetavoltar;?> Voltar</a></div><br/><?php } ?>

<b><center><img src="/style/inicio.gif" width="20px" height="20px" title='ocultar' /><a href="/home"> Pagina Principal</a></center><br/>
<?php echo rodape();?>
</body>
</html>