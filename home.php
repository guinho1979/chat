<?php
require_once("".$_SERVER["DOCUMENT_ROOT"]."/funcoes.php");
require_once("".$_SERVER["DOCUMENT_ROOT"]."/mistake.php");
//require_once("".$_SERVER["DOCUMENT_ROOT"]."/tema.php");

seg($meuid);
$Hour = date("G");
ativo($meuid,'Página principal');
$pedidos = $mistake->prepare("SELECT COUNT(*) FROM w_amigos WHERE tid='$meuid' AND ac='0'");
$pedidos->execute();
$pedidos = $pedidos->fetch();
$pensa = $mistake->prepare("SELECT COUNT(*) FROM w_mural WHERE tipo='4'");
$pensa->execute();
$pensa = $pensa->fetch();
$chaton = $mistake->prepare("SELECT COUNT(*) FROM w_ochat");
$chaton->execute();
$chaton = $chaton->fetch();
$inativo = time()-$testearray[18];
$inativo2 = time()-300;
$online = $mistake->prepare("SELECT COUNT(*) FROM w_usuarios where inativo>'$inativo'");
$online->execute();
$online = $online->fetch();
$equipe = $mistake->prepare("SELECT COUNT(*) FROM w_usuarios WHERE (perm>'0' or perm2>'0') and mostrastatus='0' and vs='0' and inativo>'$inativo2'");
$equipe->execute();
$equipe = $equipe->fetch();
$vips = $mistake->prepare("SELECT COUNT(*) FROM w_usuarios WHERE vip='1' and vs='0' and inativo>'$inativo'");
$vips->execute();
$vips = $vips->fetch();
$cma = $mistake->prepare("SELECT COUNT(*) FROM w_comu_m a, w_comu b where b.dn='$meuid' and b.id=a.cm and a.ac='0'");
$cma->execute();
$cma = $cma->fetch();
$on = $mistake->prepare("SELECT COUNT(*) FROM mmistake_online");
$on->execute();
$on = $on->fetch();
$conton = $mistake->prepare("SELECT COUNT(*) FROM w_ochat");
$conton->execute();
$conton = $conton->fetch();
$geral = $mistake->prepare("SELECT * FROM w_geral where id='1'"); 
$geral->execute();
$geral = $geral->fetch();
$sgostei = $i['sx']=='M'?'F':'M';
if ($Hour <= 4) { $saldacao = "Boa madrugada"; }
else if ($Hour <= 11) { $saldacao = "Bom dia"; }
else if ($Hour <= 12) { $saldacao = "Bom almoço"; }
else if ($Hour <= 17) { $saldacao = "Boa tarde"; }
else if ($Hour <= 22) { $saldacao = "Boa noite"; }
else if ($Hour <= 24) { $saldacao = "Boa madrugada"; }
ativo($meuid,'Página principal');
if($a=='ocultar') {
$res = $mistake->exec("update w_usuarios set vschat='1' where id='$meuid'");    
setcookie("hall",null, -1,"/",".".str_replace("www.","",$_SERVER["HTTP_HOST"])."");
unset($_COOKIE['hall']);
header('Location:/home');
}else if($a=='mostrar') {
$res = $mistake->exec("update w_usuarios set vschat='0' where id='$meuid'");
setcookie("hall",$meuid,(time() + (86400 * 7)),"/",".".str_replace("www.","",$_SERVER["HTTP_HOST"])."");
header('Location:/home');
}
if (!empty($_GET['gostou'])) {
$gostouget = $_GET['gostou'];
$certo = $mistake->prepare("SELECT COUNT(*) FROM w_comentarios_logs WHERE meuid='$meuid' AND idrecado='".$gostouget."'");
$certo->execute();
$certo = $certo->fetch();
if ($certo[0]>0) {
header("Location: /home?");	
}else{
$mistake->exec("update w_mural set si=si+1 where id='".$gostouget."'");
$mistake->exec("INSERT INTO w_comentarios_logs (meuid,idrecado) values('$meuid','".$gostouget."')");
header("Location: /home?");	
}
}
if($a=='curtir' && $pag>0 && $pag<7){
$certo = $mistake->prepare("SELECT COUNT(*) FROM w_comentarios_logs WHERE meuid='$meuid' AND idrecado='".$id."'");
$certo->execute();
$certo = $certo->fetch();
if ($certo[0]>0) {   
$mistake->exec("update w_comentarios_logs set carinha='".$pag."' where meuid='$meuid' AND idrecado='".$id."'"); 
header("Location: /home?");
}else{
$mistake->exec("INSERT INTO w_comentarios_logs (meuid,idrecado,carinha) values('$meuid','".$id."','".$pag."')");
header("Location: /home?");
}
}
$contu = $mistake->prepare("SELECT COUNT(*) FROM w_usuarios");
$contu->execute();
$contu = $contu->fetch();
$conton = $mistake->prepare("SELECT COUNT(*) FROM w_ochat");
$conton->execute();
$conton = $conton->fetch();
$info = $mistake->prepare("SELECT * FROM w_usuarios where id='$meuid'");
$info->execute();
$info = $info->fetch();
$foto = $info['ft'];
visitas();

?>
<br/>
<div class="col-md-4 offset-md-4 text-center"><?if($info['ft']==true){?><img alt="foto" id="profile-img" class="profile-img" src="/<?php echo $foto;?>" oncontextmenu="return false" onselectstart="return false" ondragstart="return false" style="width:86px;height:100px;border-radius:50%; margin:1px; border:2px solid #FFF;" pbsrc="/<?php echo str_replace('m_','',$foto);?>" class="PopBoxImageSmall" title='<?php echo $info['nm'];?>' onclick="Pop(this,50,'PopBoxPopImage');" /><?}else{?><i class="fas fa-user-circle" style="color: #c0c0c0; font-size: 72px; margin-right: 12px; vertical-align: top"></i><?}?><div style="display: inline-block; word-wrap: break-word; max-width: 260px; font-size: 16px">

<div align="center"></div>

<a href="sair.php" class="btn btn-info btn-lg active" role="button" aria-pressed="true" style="font-size: 14px; margin-top: 6px">Sair</a> <br/><br/>

<a href="/<?php echo gerarlogin($meuid);?>"><span class="user" style="text-shadow: 1px 1px 1px #111111"><?php echo gerarnome($meuid);?></span></a> </b></div></div></div><?
?>
<?
$schats = $mistake->query("SELECT id, nm FROM w_schat where tipo='0'");
$i=0; while ($schat = $schats->fetch(PDO::FETCH_OBJ)){ ?>
<div id="<?php echo $i%2==0?'div1':'div1';?>"><?
$contonc = $mistake->query("SELECT COUNT(*) FROM w_ochat WHERE schat='".$schat->id."'")->fetch();
?><a style="font-size: 16px" href="/chat?a=sala&id=<?php echo $schat->id;?>"><?php echo $imgsalas;?> <?php echo $schat->nm;?> <span class="badge badge-light" style="float: right"><font color="red"><?php echo $contonc[0];?></font></span></a></li>
</div>
<?
$i++;
}
?>
<div id="div1"><?php echo $imgsalas;?> <a href="/porno/index?"> Sessão Adulta</a></div>

</ul>
<?php
echo "<center>";
if(perm($meuid)>0) { ?><div id="div2"><a href="/mod" style="color:<?php echo $info['links'];?>;">Painel da equipe</a></div> <?php }
?>
<?php
if($testearray[31]==true){
echo ''.$testearray[32].': <a href="/'.gerarlogin($testearray[31]).'">'.gerarfoto($testearray[31],28,28).''.gerarnome($testearray[31]).'</a><br/>';
}
if($testearray[34]==true){
echo ''.$testearray[33].': <a href="/'.gerarlogin($testearray[34]).'">'.gerarfoto($testearray[34],28,28).''.gerarnome($testearray[34]).'</a><br/>';
}
if($testearray[36]==true){
echo ''.$testearray[35].': <a href="/'.gerarlogin($testearray[36]).'">'.gerarfoto($testearray[36],28,28).''.gerarnome($testearray[36]).'</a><br/>';
}
if($testearray[52]==true && $testearray[53]==true){
echo 'Gato do site: <a href="/'.gerarlogin($testearray[52]).'">'.gerarfoto($testearray[52],28,28).''.gerarnome($testearray[52]).'</a><br />';
echo 'Gata do site: <a href="/'.gerarlogin($testearray[53]).'">'.gerarfoto($testearray[53],28,28).''.gerarnome($testearray[53]).'</a><br />';
}
?>
<?php
echo "</center>";
?>

<div id="barra_mural">Duelo de Fotos</div>
<div id="fundo_mural">
<table border="1" style="width:100%" align="center" color="blue"><tr><td width="50%" align="center">
<?php 
$itens = $mistake->prepare("SELECT * FROM w_duelo_logs WHERE dono>0 AND sx='M' order by rand() limit 1");
$itens->execute();
while ($item = $itens->fetch(PDO::FETCH_OBJ)) { 
$bom = $mistake->prepare("SELECT * FROM w_usuarios WHERE id= '".$item->dono."'");
$bom->execute();
$bom = $bom->fetch(PDO::FETCH_OBJ);
?>
<a href="/<?php echo $bom->lg;?>"><?php echo gerarfoto($item->dono,60,60);?><br><?php echo $bom->nm;?></a><br><a href="/duelodefotos/curtir/<?php echo $item->dono;?>"><img src="/style/bom.png"> <?php echo $item->sim;?></a> | <a href="/duelodefotos/naocurtir/<?php echo $item->dono;?>"><img src="/style/ruim.png"> <?php echo $item->nao;?></a>
<?php
}
?>
</td><td width="50%" align="center">
<?
$itens = $mistake->prepare("SELECT * FROM w_duelo_logs WHERE dono>0 AND sx='F' order by rand() limit 1");
$itens->execute();
while ($item = $itens->fetch(PDO::FETCH_OBJ)) { 
$bom = $mistake->prepare("SELECT * FROM w_usuarios WHERE id= '".$item->dono."'");
$bom->execute();
$bom = $bom->fetch(PDO::FETCH_OBJ);
?>
<a href="/<?php echo $bom->lg;?>"><?php echo gerarfoto($item->dono,60,60);?><br><?php echo $bom->nm;?></a><br><a href="/duelodefotos/curtir/<?php echo $item->dono;?>"><img src="/style/bom.png"> <?php echo $item->sim;?></a> | <a href="/duelodefotos/naocurtir/<?php echo $item->dono;?>"><img src="/style/ruim.png"> <?php echo $item->nao;?></a>
<?php
}
?>
</tr></table>
<a href="/duelodefotos/participar">Participar - </a><a href="/duelodefotos?">Ver fotos</a>
</div>
<?php
if($tipo[0]==0){
?>
<div id="div1"><a href="chat"><?php echo $imgseta;?>Criar sala privada</a></div>
<?php
}
?>
<?php
if($tipo[0]==0){
?>
<div id="div1">
<a href="segredo"><?php echo $imgseta;?>Segredos</a></div>
<?php
}
?>
<?php
if($tipo[0]==0){
?>
<div id="div1"><a href="paginas?a=menu"><?php echo $imgseta;?>Páginas de recado</a></div>
<?php
}
?>
<?php
if($tipo[0]==0){
?>
<div id="div1"><a href="posts.php"><?php echo $imgseta;?>Publicações</a></div>
<?php
}
?>
<div id="div1"><a href="sugestoes"><?php echo $imgseta;?>Sugestões</a></div><br/>
<div align="center">
<b>Entrou:</b><?php echo gerarfoto($geral['entrou'],28,28);?><?php echo gerarnome($geral['entrou']);?><br/>
<b>Saiu:</b><?php echo gerarfoto($geral['saiu'],28,28);?><?php echo gerarnome($geral['saiu']);?></div>
<?
if($_COOKIE['atividades']==false){
setcookie("atividades",$meuid,(time() + (1800 * 1)),"/",".".str_replace("www.","",$_SERVER["HTTP_HOST"])."");
$res = $mistake->exec("update w_usuarios set atividades=atividades+3 where id='$meuid'"); 
}
?>
<?
echo rodape();
?>
</body>
</html>