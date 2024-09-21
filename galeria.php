<?php
require_once("".$_SERVER["DOCUMENT_ROOT"]."/funcoes.php");
require_once("".$_SERVER["DOCUMENT_ROOT"]."/mistake.php");
seg($meuid);
$ver = $mistake->query("SELECT visitante FROM w_usuarios WHERE id='$meuid'")->fetch();
$limite=isset($_GET['limite'])?$_GET['limite']:'';
if($a==false) { ativo($meuid,'Vendo álbuns '); ?>
<div id="titulo"><b>Álbuns</b></div><br/>
<div align="center">
Ver: <select onChange="location=options[selectedIndex].value">
<option value="#">Selecione</option>
<option value="/galeria/0/M">Homens</option>
<option value="/galeria/0/F">Mulheres</option>
<option value="/galeria/0/V">Mais visitados</option>
</select></div>
<?php
if($id=="F") { 
$contalbuns = $mistake->prepare("SELECT COUNT(*) FROM w_albuns WHERE sx='F'");
}else 
if($id=="M") { 
$contalbuns = $mistake->prepare("SELECT COUNT(*) FROM w_albuns WHERE sx='M'");
}else
if($id=="V") {
$contalbuns = $mistake->prepare("SELECT COUNT(*) FROM w_albuns WHERE vs>0");
}else
if($id==false){
$contalbuns = $mistake->prepare("SELECT count(*) FROM w_albuns");
}else{
$contalbuns = $mistake->prepare("SELECT count(*) FROM w_albuns WHERE dn='$id'");
if($ver[0]==1&&$id==$meuid){
header("Location:/galeria/menu");
}
}
$contalbuns->execute();
$contalbuns = $contalbuns->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contalbuns[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag=$numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
if($id=="M") { 
$itens = $mistake->prepare("SELECT * FROM w_albuns WHERE sx='M' ORDER BY nm LIMIT $limit, $itensporpag");
}else 
if($id=="F") {
$itens = $mistake->prepare("SELECT * FROM w_albuns WHERE sx='F' ORDER BY nm LIMIT $limit, $itensporpag");
}else
if($id=="V") {
$itens = $mistake->prepare("SELECT * FROM w_albuns WHERE vs>0 ORDER BY vs DESC LIMIT $limit, $itensporpag");
}else
if($id==false){
$itens = $mistake->prepare("SELECT * FROM w_albuns ORDER BY at desc LIMIT $limit, $itensporpag");
}else{
$itens = $mistake->prepare("SELECT * FROM w_albuns WHERE dn='$id' ORDER BY at desc LIMIT $limit, $itensporpag");
}
$itens->execute();
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) {
$contfotos = $mistake->query("SELECT count(*) FROM w_fotos WHERE alb='".$item->id."' and video='0'")->fetch();
$contfotosv = $mistake->query("SELECT count(*) FROM w_fotos WHERE alb='".$item->id."' and video='1'")->fetch();
if($item->lg==false){
$logo ="album_default.png";
}else{
$logo="/albuns/".$item->id."/".$item->lg."";
}
?>
<div class="col-12"><div class="card card-left shadow-sm bg-white"><img width="120" src="<?php echo $logo;?>"><div class="card-body"><a class="card-title" href="/galeria/album/<?php echo $item->id;?>"><?php echo $item->nm;?></a><br>Don<?php echo sexo($item->dn)=='M'?'o':'a';?>: <a href="/<?php echo gerarlogin($item->dn);?>"><?php echo gerarnome($item->dn);?></a> </div></div>
<?php $i++; } 
if($numpag>1) {
paginas('galeria',0,$numpag,$id,$pag);    
} ?>
<br/><a href="/galeria/addalbum">Criar álbum</a>
<?php
$contfotos = $mistake->query("SELECT count(*) FROM w_albuns WHERE dn='$meuid'")->fetch();
if($contfotos[0]>0){ ?>
<br/><a href="/galeria/0/<?php echo $meuid;?>">Meus álbuns (<?php echo $contfotos[0];?>)</a>
<?php } } else { ?><br/>
<div class="col-12"><div class="card shadow"><div class="card-body">Nenhum álbum</div></div></div>
<?php  } }
else if($a=='menu'){
?>
<section class="container-fluid"><h2 class="title"><b>Álbuns</b></h2>
<div class="col-12">
<ul class="list-group shadow"><li class="list-group-item">
<a href="/galeria">
<i class="fas fa-camera-retro" style="font-size: 28px; color: #0B615E"></i> Álbuns (29)</a></li><li class="list-group-item"><a href="/galeria/addalbum"><i class="fas fa-plus-square" style="font-size: 28px; color: #088A08"></i> Criar álbum</a></li><li class="list-group-item"><a href="/galeria/0/<?php echo $meuid;?>"><i class="far fa-user-circle" style="font-size: 28px; color: #555555"></i> Meu álbum</a></li></ul> </section>
<?
}
else if($a=='fotos') { 
if (!empty($_POST["senha"])) {
$_SESSION["senha"] = $_POST["senha"];
}
$nomealb = $mistake->query("SELECT dn,nm,senha,perm FROM w_albuns WHERE id='$id'")->fetch();
if($nomealb['senha']==true and $_SESSION["senha"]!=$nomealb['senha'] and $nomealb['dn']!=$meuid && permdono($meuid)==false) { 
?>
<br />
<div align="center">
<?php echo $imgerro;?>Para ver as fotos deste álbum é necessário informar uma senha, caso não tenha ela, solicite a <a href="/<?php echo gerarlogin($nomealb['dn']);?>"><?php echo gerarnome($nomealb['dn']);?></a> <br />
<form action="/galeria/fotos/<?php echo $id;?>" method="post">
Senha: <br/><input type="text" name="senha"><br />
<input type="submit" value="Desbloquear"></form>
<br/><br />
</div>
<?php 
echo rodape();
exit();
}else    
if($nomealb['dn']!=$meuid and permdono($meuid)==false){
if($nomealb['perm']==1){
if(editamigos($meuid,$nomealb['dn'])<2) { 
?>
<br/><div align="center">Somente amigos de <a href="/<?php echo gerarlogin($nomealb['dn']);?>"><?php echo gerarnome($nomealb['dn']);?></a> podem ver este álbum!
<br/><br/><a href="/galeria?"><?php echo $imgalbuns;?>Álbuns</a>
<br/><a href="/home?"><?php echo $imginicio;?>Página principal</a><br><br>
<?php 
echo rodape();
exit(); 
}
} else 
if($nomealb['perm']==2) { 
?>
<br/><div align="center">Somente <a href="/<?php echo gerarlogin($nomealb['dn']);?>"><?php echo gerarnome($nomealb['dn']);?></a> pode ver este álbum!
<br/><br/><a href="/galeria?"><?php echo $imgalbuns;?>Álbuns</a>
<br/><a href="/home?"><?php echo $imginicio;?>Página principal</a><br><br>
<?php 
echo rodape();
exit(); 
} 
}    
ativo($meuid,'Vendo fotos de álbum ');
if($limite=='excluir'){
$contft = $mistake->query("SELECT COUNT(*) FROM w_fotos WHERE id='".$del."'")->fetch();
if($nomealb['dn']==$meuid or perm($meuid)>0){
if(perm($meuid)>0){
$data = date("d/m/Y - H:i:s",time());
$txtt = "excluiu uma foto, adicionada por [b] ".$nomealb['nm']." [/b]. Data [i] $data [/i]";
editandopostagem($meuid,$txtt);
}
$ctft = $mistake->query("SELECT url FROM w_fotos WHERE id='".$del."'")->fetch();
@unlink("albuns/$id/".$del."$ctft[0]");
@unlink("albuns/$id/m_".$del."$ctft[0]");
$mistake->exec("DELETE FROM w_fotos WHERE id='".$del."'");
}
$info = $mistake->query("SELECT * FROM w_usuarios WHERE id='".$nomealb['dn']."'")->fetch(); 
if(stristr($info['ft'],'albuns') == true){
$mistake->exec("UPDATE w_usuarios SET ft=null WHERE id='".$nomealb['dn']."'");
}
} 
if($limite=='logo'){
if($nomealb['dn']==$meuid or perm($meuid)>0){
$nmft = $mistake->query("SELECT url FROM w_fotos WHERE id='".$del."'")->fetch();
$mistake->exec("UPDATE w_albuns SET lg='".$del."".$nmft[0]."' WHERE id='$id'");
}
}
if($limite=='compartilhar'){
if($nomealb['dn']==$meuid or perm($meuid)>0){
$mistake->exec("UPDATE w_fotos SET perfil='1' WHERE id='$del'");
}
}
if($limite=='descompartilhar'){
if($nomealb['dn']==$meuid or perm($meuid)>0){
$mistake->exec("UPDATE w_fotos SET perfil='0' WHERE id='$del'");
}
}
if($limite=='perfil'){
$tf = $mistake->query("SELECT ft FROM w_usuarios WHERE id='".$nomealb['dn']."'")->fetch();
if(stristr($tf[0],'fotoperfil') == true){
@unlink($tf[0]);
@unlink(str_replace('m_','',$tf[0]));
}
if($nomealb['dn']==$meuid or perm($meuid)>0){
$nmft = $mistake->query("SELECT url FROM w_fotos WHERE id='".$del."'")->fetch();
$res = $mistake->exec("UPDATE w_usuarios SET ft='albuns/".$id."/".$del."".$nmft[0]."' WHERE id='".$nomealb['dn']."'");
}
}
if($limite=='fundo'){
$tf = $mistake->query("SELECT fundo_bg FROM w_usuarios WHERE id='".$nomealb['dn']."'")->fetch();
if(stristr($tf[0],'fundoperfil') == true){
@unlink($tf[0]);
}
if($nomealb['dn']==$meuid or perm($meuid)>0){
$nmft = $mistake->query("SELECT url FROM w_fotos WHERE id='".$del."'")->fetch();
$res = $mistake->exec("UPDATE w_usuarios SET fundo_bg='albuns/".$id."/".$del."".$nmft[0]."' WHERE id='".$nomealb['dn']."'");
}
}
?>
<br/><div id="titulo"><b><?php echo $nomealb['nm'];?></b></div><br/>
<?php
$contfotos = $mistake->query("SELECT count(*) FROM w_fotos WHERE alb='$id' and video='0'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contfotos[0];
$itensporpag = 5;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->query("SELECT * FROM w_fotos WHERE alb='$id' and video='0' ORDER BY id desc LIMIT $limit, $itensporpag");
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) {
$fotocoment = $mistake->query("SELECT COUNT(*) FROM w_cmt_fotos WHERE ft='".$item->id."'")->fetch();
?>
<div class="list"><a href="/galeria/fotozoom/<?php echo $id;?>/<?php echo $item->id;?>"><img src="/albuns/<?php echo $item->alb;?>/<?php echo $item->id.$item->url;?>" width="100" style="float: left; margin-right: 12px"><a href="/galeria/fotozoom/<?php echo $id;?>/<?php echo $item->id;?>"><i class="far fa-eye"></i></a></a><br><small style="color: #AAB7B8"><b>02/05/2021 - 16:58</b></small>
<?php
$dnalb = $mistake->query("SELECT dn FROM w_albuns WHERE id='$id'")->fetch();
if($dnalb[0]==$meuid or perm($meuid)>0) { ?>
<br/><a href="/galeria/fotos/<?php echo $id;?>/<?php echo $pag;?>/perfil/<?php echo $item->id;?>">Foto De Perfil</a>- 
<a href="/galeria/fotos/<?php echo $id;?>/<?php echo $pag;?>/fundo/<?php echo $item->id;?>">Fundo Do Perfil</a> - 
<a href="/galeria/fotos/<?php echo $id;?>/<?php echo $pag;?>/logo/<?php echo $item->id;?>">Capa do álbum</a> - 
<a href="/galeria/fotos/<?php echo $id;?>/<?php echo $pag;?>/excluir/<?php echo $item->id;?>">Excluir</a><br/>
<?php } ?>
<a href="/galeria/fotozoom/<?php echo $id;?>/<?php echo $item->id;?>">Comentários(<?php echo $fotocoment[0];?>)</a></div>
<?php $i++; }
if($numpag>1) {
paginas('galeria',$a,$numpag,$id,$pag);    
} } else { ?>
<div align="center"><?php echo $imgerro;?>Não ah fotos!<br/>
<?php } ?>
<br/><a href="/galeria/album/<?php echo $id;?>">Voltar ao álbum</a><br/><br/>
<a href="/configuracoes/foto_perfil/<?php echo $meuid;?>">Adicionar foto ao perfil</a><br/>
<?php 
}
else
if($a=='fotozoom') { 
if (!empty($_POST["senha"])) {
$_SESSION["senha"] = $_POST["senha"];
}
$nomealb = $mistake->query("SELECT dn,nm,senha,perm FROM w_albuns WHERE id='$id'")->fetch();
if($nomealb['senha']==true and $_SESSION["senha"]!=$nomealb['senha'] and $nomealb['dn']!=$meuid && permdono($meuid)==false) { 
?>
<br />
<div align="center">
<?php echo $imgerro;?>Para ver as fotos deste álbum é necessário informar uma senha, caso não tenha ela, solicite a <a href="/<?php echo gerarlogin($nomealb['dn']);?>"><?php echo gerarnome($nomealb['dn']);?></a> <br />
<form action="/galeria/fotos/<?php echo $id;?>" method="post">
Senha: <br/><input type="text" name="senha"><br />
<input type="submit" value="Desbloquear"></form>
<br/><br />
</div>
<?php 
echo rodape();
exit();
}else     
if($nomealb['dn']!=$meuid and permdono($meuid)==false){
if($nomealb['perm']==1){
if(editamigos($meuid,$nomealb['dn'])<2) { 
?>
<br/><div align="center">Somente amigos de <a href="/<?php echo gerarlogin($nomealb['dn']);?>"><?php echo gerarnome($nomealb['dn']);?></a> podem ver este álbum!
<br/><br/><a href="/galeria?"><?php echo $imgalbuns;?>Álbuns</a>
<br/><a href="/home?"><?php echo $imginicio;?>Página principal</a><br><br>
<?php 
echo rodape();
exit(); 
}
} else 
if($nomealb['perm']==2) { 
?>
<br/><div align="center">Somente <a href="/<?php echo gerarlogin($nomealb['dn']);?>"><?php echo gerarnome($nomealb['dn']);?></a> pode ver este álbum!
<br/><br/><a href="/galeria?"><?php echo $imgalbuns;?>Álbuns</a>
<br/><a href="/home?"><?php echo $imginicio;?>Página principal</a><br><br>
<?php 
echo rodape();
exit(); 
} 
}    
ativo($meuid,'Vendo comentários em fotos ');
$nomealb = $mistake->query("SELECT nm, dn FROM w_albuns WHERE id='$id'")->fetch();
$infoto = $mistake->query("SELECT id, url, des FROM w_fotos WHERE id='$pag'")->fetch();
if(!empty($_POST['cmtft'])){
$inft = $mistake->query("SELECT COUNT(*) FROM w_cmt_fotos WHERE cmt='".$_POST['cmtft']."' AND dono='$meuid'")->fetch();
if($inft[0]==0){
$mistake->exec("INSERT INTO w_atu (uid,aid,dt,cat) values('$nomealb[1]','$id','".time()."','4')");
$mistake->exec("INSERT INTO w_cmt_fotos (dono,cmt,hora,ft) values('$meuid','".$_POST['cmtft']."','".time()."','$pag')");
}
}
if($limite==true){
$dnalb = $mistake->query("SELECT dn FROM w_albuns WHERE id='$id'")->fetch();
$dncmt = $mistake->query("SELECT dono FROM w_cmt_fotos WHERE hora='$limite' and ft='$pag'")->fetch();
if($dncmt[0]==$meuid or $dnalb[0]==$meuid or perm($meuid)>0){
$mistake->exec("DELETE FROM w_cmt_fotos WHERE hora='$limite' and ft='$pag'");
} } ?>
<br/><div id="titulo"><b><?php echo $nomealb[0];?></b></div><br/>
<div align="center"><img style="max-width:100%" src="/albuns/<?php echo $id;?>/<?php echo $infoto[0].$infoto[1];?>" oncontextmenu='return false' onselectstart='return false' ondragstart='return false'><br/><?php echo $infoto[2];?><br/><br/>
<?php
$ant = $mistake->query("SELECT COUNT(*) FROM w_fotos WHERE id>'$pag' and alb='$id'")->fetch();
if($ant[0]>0){
$ftant = $mistake->query("SELECT id FROM w_fotos WHERE id>'$pag' and alb='$id' order by id asc")->fetch(); ?>
<div class='wrappaginacaoml'><div class='paginacaoml'><a class='next page-numbers' href='/galeria/fotozoom/<?php echo $id;?>/<?php echo $ftant[0];?>'>&#10150; Anterior</a></div></div>
<?php }
$ant = $mistake->query("SELECT COUNT(*) FROM w_fotos WHERE id<'$pag' and alb='$id'")->fetch();
if($ant[0]>0){
$ftant = $mistake->query("SELECT id FROM w_fotos WHERE id<'$pag' and alb='$id' order by id desc")->fetch(); ?>
<div class='wrappaginacaoml'><div class='paginacaoml'><a class='prev page-numbers' href='/galeria/fotozoom/<?php echo $id;?>/<?php echo $ftant[0];?>'>&#10150; Próxima</a></div></div>
<?php } ?>   </div><br/>
<?php
$contcmt = $mistake->query("SELECT count(*) FROM w_cmt_fotos WHERE ft='$pag'")->fetch();
if($contcmt[0]>0) {
$cmtt = $mistake->query("SELECT dono, cmt, hora FROM w_cmt_fotos WHERE ft='$pag' ORDER BY hora desc LIMIT 5");
$i=0; while ($cmt = $cmtt->fetch(PDO::FETCH_OBJ)) { ?>
<ul class="list-group shadow"><li class="list-group-item"><a href="/<?php echo gerarlogin($cmt->dono);?>"><?php echo gerarfoto($cmt->dono,30,30);?><?php echo gerarnome($cmt->dono);?></a> - <small><?php echo date("d/m/Y - H:i:s", $cmt->hora);?></small><br/>
<?php echo textot($cmt->cmt,$meuid,$on); ?><br/>
<?php
$dncmt = $mistake->query("SELECT dn FROM w_albuns WHERE id='$id'")->fetch();
if($cmt->dono==$meuid or $dncmt[0]==$meuid or perm($meuid)>0) { ?>
<a href="/galeria/fotozoom/<?php echo $id;?>/<?php echo $pag;?>/<?php echo $cmt->hora;?>"><font color="ff0000">[x]</font></a>
<?php } ?>
</ul></li>
<?php $i++; } ?>
<br/><a href="/galeria/fotocmt/<?php echo $id;?>/1/<?php echo $pag;?>">Ver todos(<?php echo $contcmt[0];?>)</a><br/><br/>
<?php } else { ?>
<div align="center"><?php echo $imgerro;?>Nenhum comentário<br/>
<a href="/galeria/album/<?php echo $id;?>">Voltar ao álbum</a><br/>
<?php } if($ver[0]==0){?>
<div align="center"><form action="/galeria/fotozoom/<?php echo $id;?>/<?php echo $pag;?>" method="post">
Comentário<br/><input type="text" name="cmtft"><br/>
<input type="submit" value="Enviar"></form>
<?php }
} else 
if($a=='album') { 
ativo($meuid,'Vendo álbum');
if (!empty($_POST["senha"])) {
$_SESSION["senha"] = $_POST["senha"];
}
$nomealb = $mistake->query("SELECT dn,nm,senha,perm FROM w_albuns WHERE id='$id'")->fetch();
if($nomealb['senha']==true and $_SESSION["senha"]!=$nomealb['senha'] and $nomealb['dn']!=$meuid && permdono($meuid)==false) { 
?>
<br />
<div align="center">
<?php echo $imgerro;?>Para ver as fotos deste álbum é necessário informa uma senha, caso não tenha ela, solicite a <a href="/<?php echo gerarlogin($nomealb['dn']);?>"><?php echo gerarnome($nomealb['dn']);?></a> <br />
<form action="/galeria/album/<?php echo $id;?>" method="post">
Senha: <br/><input type="text" name="senha"><br />
<input type="submit" value="Desbloquear"></form>
<br/><br />
</div>
<?php 
echo rodape();
exit();
}else    
if($nomealb['dn']!=$meuid and permdono($meuid)==false){
if($nomealb['perm']==1){
if(editamigos($meuid,$nomealb['dn'])<2) { 
?>
<br/><div align="center">Somente amigos de <a href="/<?php echo gerarlogin($nomealb['dn']);?>"><?php echo gerarnome($nomealb['dn']);?></a> podem ver este álbum!
<br/><br/><a href="/galeria?"><?php echo $imgalbuns;?>Álbuns</a>
<br/><a href="/home?"><?php echo $imginicio;?>Página principal</a><br><br>
<?php 
echo rodape();
exit(); 
}
} else 
if($nomealb['perm']==2) { 
?>
<br/><div align="center">Somente <a href="/<?php echo gerarlogin($nomealb['dn']);?>"><?php echo gerarnome($nomealb['dn']);?></a> pode ver este álbum!
<br/><br/><a href="/galeria?"><?php echo $imgalbuns;?>Álbuns</a>
<br/><a href="/home?"><?php echo $imginicio;?>Página principal</a><br><br>
<?php 
echo rodape();
exit(); 
} 
}    
if(empty($_SESSION['visitaalbum_'.$id.''])&&$meuid!=$senha['dn']&&!permdono($meuid)){
@automsg('Olá o usuário '.html_entity_decode(gerarnome2($meuid)).' acaba de visitar teu álbum',1,$nomealb['dn']);
$_SESSION['visitaalbum_'.$id.''] = 'visitaalbum_'.$id.''; 	
}
$contfotos = $mistake->query("SELECT COUNT(*) FROM w_fotos WHERE alb='$id' and video='0'")->fetch();
$contfotosv = $mistake->query("SELECT COUNT(*) FROM w_fotos WHERE alb='$id' and video='1'")->fetch();
$infoal = $mistake->query("SELECT nm, lg, ds, dn, vs, dt, at FROM w_albuns WHERE id='$id'")->fetch();
if($infoal[3]!=$meuid){
$visu = $infoal[4] + 1;
$mistake->exec("UPDATE w_albuns SET vs='$visu' WHERE id='$id'");
}
?>
<br/><div id="titulo"><b><?php echo $infoal[0];?></b></div><br/>
<div align="center"><img alt="foto" id="profile-img" class="profile-img" src="/albuns/<?php echo $id;?>/<?php echo $infoal[1];?>" oncontextmenu="return false" onselectstart="return false" ondragstart="return false" style="width:103px;height:136px;border-radius:50%; margin:1px; border:2px solid #FFF;" pbsrc="/albuns/<?php echo $id;?>/<?php echo $infoal[1];?>" class="PopBoxImageSmall" title="Clique para ampliar/diminuir" onclick="Pop(this,50,'PopBoxPopImage');" /><br/><?php echo $infoal[2];?></div><br/><br/>
ID do álbum: <b><?php echo $id;?></b><br/>
Don<?php echo sexo($infoal[3])=='M'?'o':'a';?>: <a href="/<?php echo gerarlogin($infoal[3]);?>"><?php echo gerarnome($infoal[3]);?></a><br/>
Total de visitas: <b><?php echo $infoal[4];?></b><br/><br/>
<?php echo $imgfotos;?><a href="/galeria/fotos/<?php echo $id;?>">Fotos(<?php echo $contfotos[0];?>)</a><br/><br />
<?php if($infoal[3]==$meuid or perm($meuid)>0) { ?>
<?php echo $imgadd;?><a href="/galeria/addfoto/<?php echo $id;?>">Adicionar foto</a><br/><br />
<?php echo $imgpreferencias;?><a href="/configuracoes/foto_perfil/<?php echo $meuid;?>">Adicionar foto ao perfil</a><br/><br />
<?php echo $imgpreferencias;?><a href="/galeria/editar/<?php echo $id;?>">Editar álbum</a><br/><br />
<?php echo $imgerro;?><a href="/galeria/excluiralbum/<?php echo $id;?>">Excluir álbum</a><br/>
<?php } ?>
<br/>Última atualização: <b><?php echo date("d/m/Y - H:i:s", $infoal[6]);?></i><br/>
Criado em: <i><?php echo date("d/m/Y - H:i:s", $infoal[5]);?></b><br/>
<?php 
} else 
if($a=='addalbum') {
if($ver[0]==1){
header("Location:/galeria/menu");
}
ativo($meuid,'Adicionando álbum '); ?>
<br/><div id="titulo"><b>Adicionar Álbum</b></div><br/>
<div align="center">
<form action="/galeria/addalbum2" method="post">
Nome:<br/><input type="text" name="nome"><br/>
Descrição:<br/>
<textarea name="des" cols="25" rows="5"></textarea><br/>
<input type="submit" value="Criar"></form>
<?php } else if($a=='addalbum2') {
if($ver[0]==1){
header("Location:/galeria/menu");
}
ativo($meuid,'Adicionando álbum ');
$nm = $mistake->query("SELECT COUNT(*) FROM w_albuns WHERE dn='$meuid'")->fetch();
?>
<br/><div align="center">
<?php if($_POST['nome']=='') { echo $imgerro;?>
Insira um nome para o álbum!<br/><br/><a href="/galeria/addalbum">Voltar a criar</a><br/>
<?php } else if($nm[0]>0) { echo $imgerro;?>
Você já possui um álbum!<br/><br/><a href="/galeria">Voltar</a><br/>
<?php } else {
$res = $mistake->exec("INSERT INTO w_albuns (dn,nm,ds,dt,at,sx) values('$meuid','".anti_injection($_POST['nome'])."','".anti_injection($_POST['des'])."','".time()."','".time()."','".sexo($meuid)."')");
$resok = $mistake->lastInsertId();
if($res) { echo $imgok;?>
Álbum criado com sucesso!<br/><br/>
<?
mkdir ("albuns/".$resok."", 0777);
$f = fopen("albuns/".$resok."/index.html", "w");
fclose($f); ?>
<a href="/galeria/album/<?php echo $resok;?>"><?php echo $_POST['nome'];?></a><br/>
<?php } else { echo $imgerro;?>
Erro ao criar álbum, tente novamente!<br/>
<?php } } } else if($a=='editar') {

if($ver[0]==1){
header("Location:/galeria/menu");
}
ativo($meuid,'Editando álbum ');
$if = $mistake->query("SELECT nm, ds, dn, perm, senha FROM w_albuns WHERE id='$id'")->fetch();
if($if[2]==$meuid or perm($meuid)>0) { ?>
<br/><div id="titulo"><b>Editar <?php echo $if[0];?></b></div>
<br/>
<form action="/galeria/editar2/<?php echo $id;?>" method="post">
Nome:<br/><input type="text" name="nomedit" value="<?php echo $if[0];?>"><br/>
Descrição:<br/><input type="text" name="desedit" value="<?php echo $if[1];?>"><br/>
Quem pode ver este álbum?<br/><select name="qm">
<option value="0">Todos do site</option>
<option value="1" <?php echo $if[3]==1?' selected ':'';?> >Somente meus amigos</option>
<option value="2" <?php echo $if[3]==2?' selected ':'';?> >Só eu</option>
</select><br/>
Senha:<br/><input type="text" name="senha" value="<?php echo $if[4];?>"><br/>
<input type="submit" value="Editar"></form>
<br/><div align="center"><a href="/galeria/album/<?php echo $id;?>">Voltar ao álbum</a><br/>
<?php } else { ?>
<br/><div align="center"><?php echo $imgerro;?>Este álbum não é seu!<br/><br/>
<a href="/galeria/album/<?php echo $id;?>">Voltar ao álbum</a><br/>
<?php } } else if($a=='editar2') {
if($ver[0]==1){
header("Location:/galeria/menu");
}
ativo($meuid,'Editando álbum ');
$contn = $mistake->query("SELECT COUNT(*) FROM w_albuns WHERE nm='".$_POST['nomedit']."' AND dn='$meuid' AND id!='$id'")->fetch();
if($contn[0]>0) { ?>
<br/><div align="center"><?php echo $imgerro;?>Você já possui um álbum com esse nome<br/><br/>
<a href="/galeria/album/<?php echo $id;?>">Voltar ao álbum</a><br/>
<?php } else {
$senha = $_POST['senha'];
$nome = anti_injection($_POST['nomedit']);
$descri = anti_injection($_POST['desedit']);
$permic = $_POST['qm'];
if(perm($meuid)>0){
if($permic==0){
$prm = 'todos';
}else if($permic==1){
$prm = 'só amigos';
}else{
$prm = 'só dono';
}
$data = date("d/m/Y - H:i:s",time());
$nomecomu = $mistake->query("SELECT nm, ds, perm FROM w_albuns WHERE id='$id'")->fetch();
$txtt = "atualizou o álbum [b] $nomecomu[0] [/b], ID: [b] $id [/b]. Para, Nome: [b] $nome [/b], Descrição: [b] $descri [/b], Permição: [b] $prm [/b]. Data: [i] $data [/i] ";
editandopostagem($meuid,$txtt);
}
$res = $mistake->exec("UPDATE w_albuns SET nm='$nome', ds='$descri', perm='$permic', senha='$senha' WHERE id='$id'");
if($res) { ?>
<br/><div align="center"><?php echo $imgok;?>Álbum editado com sucesso<br/><br/>
<a href="/galeria/album/<?php echo $id;?>">Voltar ao álbum</a><br/>
<?php } else { ?>
<br/><div align="center"><?php echo $imgerro;?>Erro ao editar álbum<br/><br/>
<a href="/galeria/album/<?php echo $id;?>">Voltar ao álbum</a><br/>
<?php } } } else if($a=='addfoto') {
if($ver[0]==1){
header("Location:/galeria/menu");
}
ativo($meuid,'Adicionando foto em álbum ');
$info = $mistake->query("SELECT dn FROM w_albuns WHERE id='$id'")->fetch();
if($info[0]==$meuid or perm($meuid)>0) { ?>
<br/><div id="titulo"><b>Adicionar foto</b></div>
<br/>
<form action="/galeria/addfoto2/<?php echo $id;?>" method="post" enctype="multipart/form-data">
Foto:<br/><input type="file" name="img"><br/>
Descrição:<br/><input type="text" name="des"><br/>
<input type="submit" value="Adicionar"></form>
<br/><div align="center"><a href="/galeria/album/<?php echo $id;?>">Voltar ao álbum</a><br/>
<?php } else { ?>
<br/><div align="center"><?php echo $imgerro;?>Este álbum não é seu!<br/><br/>
<a href="/galeria/album/<?php echo $id;?>">Voltar ao álbum</a><br/>
<?php 
}    
}
else 
if($a=='addfoto2') {
if($ver[0]==1){
header("Location:/galeria/menu");
}
ativo($meuid,'Adicionando foto em álbum '); ?>
<br/><div align="center">
<?php
$cont = $mistake->query("SELECT count(*) FROM w_fotos WHERE alb='$id'")->fetch();
if($cont[0]>20000) { ?>
<div align="center"><?php echo $imgerro;?>Só é permitido 20 fotos por álbum.<br/><br/>
<a href="/galeria/album/<?php echo $id;?>">Voltar ao álbum</a>
<br/><br/><a href="/galeria?"><?php echo $imgalbuns;?>Álbuns</a>
<br/><a href="/home?"><?php echo $imginicio;?>Página principal</a><br><br>
<?php echo rodape();?>
</body>
</html>
<?php 
exit;
}
$arquivo = isset($_FILES["img"]) ? $_FILES["img"] : FALSE;
if(!preg_match("/^image\/(jpg|jpeg|png|gif)$/", $arquivo["type"])){
echo $imgerro;?>A foto está com formato desconhecido!<br><br>
<?php 
}else{
preg_match("/.(gif|png|jpg|jpeg){1}$/i", $arquivo["name"], $ext);
$donooo = $mistake->query("SELECT dn FROM w_albuns WHERE id='$id'")->fetch();
$resm = $mistake->exec("INSERT INTO w_fotos (dono,url,des,alb,dt) values('$donooo[0]','.$ext[1]','".$_POST['des']."','$id','".time()."')");
$resok = $mistake->lastInsertId();
$tm24 = time()-86400;
$mistake->exec("UPDATE w_albuns SET at='".time()."',lg='".$resok.".".$ext[1]."' WHERE id='$id'");
$contatu = $mistake->query("SELECT count(*) FROM w_atu WHERE uid='$donooo[0]' and aid='$id' and cat='3' and dt>'$tm24'")->fetch();
if($contatu[0]>0){
$mistake->exec("UPDATE w_atu SET dt='".time()."' WHERE uid='$donooo[0]' and aid='$id' and cat='3' order by dt desc limit 1");
}else{
$mistake->exec("INSERT INTO w_atu (uid,aid,dt,cat) values('$donooo[0]','$id','".time()."','3')");
}
$img_thumb = "albuns/".$id."/".$resok.".".$ext[1].""; 
$img_thumbm = "albuns/".$id."/m_".$resok.".".$ext[1]."";
}
if($resm){
copy($_FILES["img"]["tmp_name"], $img_thumb);
echo $imgok;?>Foto adicionada com sucesso!<?php 
} else { 
echo $imgerro;?>Erro ao adicionar foto!<?php 
}
?>
<br/><br/><a href="/galeria/album/<?php echo $id;?>">Voltar ao álbum</a><br/>
<?php 
}
else 
if($a=='addfoto273738') { 
ativo($meuid,'Adicionando foto em álbum '); ?>
<br/><div align="center">
<?php
$arquivo = isset($_FILES["img"]) ? $_FILES["img"] : FALSE;
$_UP['extensoes'] = array('jpeg','png','gif','bmp','jpg','mp4','webm','webp');
$extensao = substr(strrchr($arquivo["name"],'.'),1);
if (array_search($extensao, $_UP['extensoes']) === false) {
echo "$imgerro Arquivo em formato invalido! A imagem deve ser (jpg|jpeg|png|gif|webp|mp4) . Envie outro arquivo<br>";
}else{
if($arquivo["size"] > 2000000){
echo "$imgerro O arquivo e muito grande! A imagem deve ser de no maximo 2000000 bytes. Envie outro arquivo<br>";
}else{
preg_match("/.(gif|png|jpg|jpeg|mp4|webp){1}$/i", $arquivo["name"], $ext);
$est = $ext[1]=='mp4' ? 'gif' : $ext[1];
$donooo = $mistake->query("SELECT dn FROM w_albuns WHERE id='$id'")->fetch();
$resm = $mistake->exec("INSERT INTO w_fotos (dono,url,des,alb,dt) values('$donooo[0]','.$est','".$_POST['des']."','$id','".time()."')");
$resok = $mistake->lastInsertId();
$mistake->exec("UPDATE w_albuns SET at='".time()."',lg='m_".$resok.".".$est."' WHERE id='$id'");
$contatu = $mistake->query("SELECT count(*) FROM w_atu WHERE uid='$donooo[0]' and aid='$id' and cat='3'")->fetch();
if($contatu[0]>0){
$mistake->exec("UPDATE w_atu SET dt='".time()."' WHERE uid='$donooo[0]' and aid='$id' and cat='3' order by dt desc limit 1");
}else{
$mistake->exec("INSERT INTO w_atu (uid,aid,dt,cat) values('$donooo[0]','$id','".time()."','3')");
}
$img_thumb = "albuns/".$id."/".$resok.".".$est.""; 
$img_thumbm = "albuns/".$id."/m_".$resok.".".$est."";  
$img_thumbb = "albuns/".$id."/".$resok.".".$est.""; 
if(preg_match("/^image\/(gif)$/",$arquivo["type"])){
//exec("gifsicle --scale 0.5 -i ".escapeshellarg($arquivo["tmp_name"])." > ".escapeshellarg($img_thumb)."");
//exec("gifsicle --resize 150x150 ".escapeshellarg($arquivo["tmp_name"])." > ".escapeshellarg($img_thumbm)."");
//exec("gif2webp -q 85 ".escapeshellarg($arquivo["tmp_name"])." -o ".escapeshellarg($img_thumb)."");
move_uploaded_file($arquivo["tmp_name"],$img_thumb); 
copy($img_thumb,$img_thumbm);
}else{
if(preg_match("/^image\/(webp)$/",$arquivo["type"])){
move_uploaded_file($arquivo["tmp_name"],$img_thumb); 
copy($img_thumb,$img_thumbm);
}else{
if(preg_match("/^image\/(jpeg|png|bmp|jpg)$/",$arquivo["type"])){
//exec("montage -geometry +0+0 -background \"".$testearray[2]."\" -label \"".$_SERVER['SERVER_NAME']."\" ".escapeshellarg($arquivo["tmp_name"])." ".escapeshellarg($img_thumb)."");
//exec("cwebp -q 85 ".escapeshellarg($img_thumb)." -o ".escapeshellarg($img_thumb)."");
//exec("cwebp -q 85 -resize 150 150 ".escapeshellarg($arquivo["tmp_name"])." -o ".escapeshellarg($img_thumbm)."");
move_uploaded_file($arquivo["tmp_name"],$img_thumb); 
copy($img_thumb,$img_thumbm);
}else{
if(preg_match("/^video\/(mp4|mpeg|webm)$/",$arquivo["type"])){ 
//exec("ffmpeg -i ".escapeshellarg($arquivo["tmp_name"])." ".escapeshellarg($img_thumb)." -hide_banner");
//exec("ffmpeg -i ".escapeshellarg($arquivo["tmp_name"])." ".escapeshellarg($img_thumbb)." -hide_banner");
//exec("gifsicle -O3 ".escapeshellarg($img_thumb)." -o ".escapeshellarg($img_thumb)."");
//exec("gifsicle --resize 150x150 ".escapeshellarg($img_thumbb)." > ".escapeshellarg($img_thumbm)."");
move_uploaded_file($arquivo["tmp_name"],$img_thumb); 
copy($img_thumb,$img_thumbm);
}
}
}
}
}
}
if($resm){
echo $imgok;?>Foto adicionada com sucesso!<?php 
} else { 
echo $imgerro;?>Erro ao adicionar foto!<?php 
}
?>
<br/><br/><a href="/galeria/album/<?php echo $id;?>">Voltar ao álbum</a><br/>
<?php 
}else 
if($a=='excluiralbum') {
if($ver[0]==1){
header("Location:/galeria/menu");
}
 ativo($meuid,'Excluindo álbum ');
$dono = $mistake->query("SELECT * FROM w_albuns WHERE id='$id'")->fetch(); ?>
<br/><div align="center">
<?php if($dono[0]!=$meuid and perm($meuid)==0) { echo $imgerro;?>
Este álbum não é seu!<br/><br/>
<a href="/galeria/album/<?php echo $id;?>">Voltar ao álbum</a><br/>
<?php } else {
$info = $mistake->query("SELECT * FROM w_usuarios WHERE id='".$dono['dn']."'")->fetch();
if(stristr($info['ft'],'albuns') == true){
$mistake->exec("UPDATE w_usuarios SET ft=null WHERE id='".$info['id']."'");
}
if(perm($meuid)>0){
$data = date("d/m/Y - H:i:s",time());
$txtt = "excluiu o álbum [b] ".$dono['nm']." [/b], ID: [b] $id [/b], Dono: [b] ".$info['nm']." [/b]. Data: [i] $data [/i] ";
editandopostagem($meuid,$txtt);
}
$res = $mistake->exec("DELETE FROM w_albuns WHERE id='$id'");
$mistake->exec("DELETE FROM w_fotos WHERE dono='".$dono['dn']."'");
if($res){
$dir = "".$_SERVER["DOCUMENT_ROOT"]."/albuns/".$id."";
exec("rm -rf {$dir}");
echo $imgok;?>
Álbum excluído com sucesso!<br/>
<?php } else { echo $imgerro;?>
Erro ao excluir o álbum, tente novamente!<br/><br/>
<a href="/galeria/album/<?php echo $id;?>">Voltar ao álbum</a><br/>
<?php } } } else if($a=='fotocmt') { ativo($meuid,'Vendo comentários em foto ');
$ainfo = $mistake->query("SELECT nm,dn FROM w_albuns WHERE id='$id'")->fetch();
$ftinfo = $mistake->query("SELECT url, des FROM w_fotos WHERE id='$limite'")->fetch();
if($del==true){
$dncmt = $mistake->query("SELECT dono FROM w_cmt_fotos WHERE hora='$del' and ft='$limite'")->fetch();
if($dncmt[0]==$meuid or $ainfo[1]==$meuid or perm($meuid)>0){
$mistake->exec("DELETE FROM w_cmt_fotos WHERE hora='$del' and ft='$limite'");
}
} 
if(!empty($_POST['cmtft'])){
$inft = $mistake->query("SELECT COUNT(*) FROM w_cmt_fotos WHERE cmt='".$_POST['cmtft']."' AND dono='$meuid'")->fetch();
if($inft[0]==0){
$mistake->exec("INSERT INTO w_atu (uid,aid,dt,cat) values('$ainfo[1]','$id','".time()."','4')");
$mistake->exec("INSERT INTO w_cmt_fotos (dono,cmt,hora,ft) values('$meuid','".$_POST['cmtft']."','".time()."','$limite')");
}
}
?>
<br/><div id="titulo"><b><?php echo $ainfo[0];?></b></div><br/>
<div align="center"><img style="max-width:180px" src="/albuns/<?php echo $id;?>/<?php echo $limite.$ftinfo[0];?>" oncontextmenu='return false' onselectstart='return false' ondragstart='return false'><br/><?php echo $ftinfo[1];?></div><br/>
<?php
$contcmt = $mistake->query("SELECT count(*) FROM w_cmt_fotos WHERE ft='$limite'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contcmt[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag=$numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->query("SELECT dono, cmt, hora FROM w_cmt_fotos WHERE ft='$limite' ORDER BY hora desc LIMIT $limit, $itensporpag");
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<ul class="list-group shadow"><li class="list-group-item">
<a href="/<?php echo gerarlogin($item->dono);?>"><?php echo gerarfoto($item->dono,30,30);?><?php echo gerarnome($item->dono);?></a> - <small><?php echo date("d/m/Y - H:i:s", $item->hora);?></small><br/>
<?php echo textot($item->cmt,$meuid,$on);?><br/>
<?
$dncmt = $mistake->query("SELECT dn FROM w_albuns WHERE id='$id'")->fetch();
if($item->dono==$meuid or $dncmt[0]==$meuid or perm($meuid)>0) { ?>
<a href="/galeria/fotocmt/<?php echo $id;?>/<?php echo $pag;?>/<?php echo $limite;?>/<?php echo $item->hora;?>"><font color="ff0000">[x]</font></a>
<?php } ?>
<ul></li>
<?php $i++; } 
if($numpag>1) { 
paginas('galeria',$a,$numpag,$id,$pag,$limite);    
} } else { ?>
<div align="center"><?php echo $imgerro;?>Não ah comentários!<br/>
<?php } ?>
<div align="center"><form action="/galeria/fotocmt/<?php echo $id;?>/<?php echo $pag;?>/<?php echo $limite;?>" method="post">
Comentário<br/><input type="text" name="cmtft"><br/>
<input type="submit" value="Enviar"></form><br/>
<br/><a href="/galeria/album/<?php echo $id;?>">Voltar ao álbum</a><br/>
<?php } if($a==true && $a!='menu') { ?>
<br/><div align="center"><a href="/galeria/menu"><?php echo $imgalbuns;?>Álbuns</a> <?php } ?>
<br/><div align="center"><a href="/home?"><?php echo $imginicio;?>Página principal</a><br><br>
<?php echo rodape();?>
</body>
</html>