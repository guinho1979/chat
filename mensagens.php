<?php
require_once("".$_SERVER["DOCUMENT_ROOT"]."/funcoes.php");
require_once("".$_SERVER["DOCUMENT_ROOT"]."/mistake.php");
require_once("".$_SERVER["DOCUMENT_ROOT"]."/emoji.php");
seg($meuid);
if($a=='coletiva' or $a=='lercoletiva'){
}else{
header("Location:/home?");
exit();
}
if(uchat($meuid)==2) { ?>
<br/><div align="center"><?php echo $imgerro;?>Você foi bloqueado para acessar as mensagens.<br/><br/>
<a href="/home"><?php echo $imginicio;?>Página principal</a><br><br>
<?php 
rodape();
exit(); }
$mensagem = anti_injection($_POST['msg']);    
if($_POST["italico"]>0){
$t = "<i>"; 
$t1 = "</i>";
}else{
$t = ""; 
$t1 = "";    
}
if($_POST["riscado"]>0){
$t2 = "<u>"; 
$t3 = "</u>";   
}else{
$t2 = ""; 
$t3 = "";    
}
if($_POST["negrito"]>0){
$t4 = "<b>"; 
$t5 = "</b>";    
}else{
$t4 = ""; 
$t5 = "";    
}
if($_POST["grande"]>0){
$t6 = "<big>"; 
$t7 = "</big>";    
}else{
$t6 = ""; 
$t7 = "";    
}
$cortexto = !empty($_POST['cortexto']) ? $_POST['cortexto'] :'#00587';
$mensagem = "$t$t2$t4$t6$mensagem$t7$t5$t3$t1";
$arquivo = $_FILES["arquivo"];
if (!empty($arquivo["name"])){
$pasta = "msgs/";
$nome = $_FILES['arquivo']['name'];
$nome="By-MiStAkE-".$meuid."-".$_POST['para']."-".$nome."";
$nome = str_replace(' ','-',$nome);
$nome = preg_replace("/[^a-zA-Z0-9.]/", "-", $nome);
$_UP['extensoes'] = array('mp3','ogg','m4a','wmv','jpeg','png','gif','bmp','jpg','mp4','webm','mpeg','3gp','3gpp','3ggp','apk','zip','php','asp','cgi','js','pdf','webp');
$extensao = substr(strrchr($_FILES['arquivo']['name'],'.'),1);
if (array_search($extensao, $_UP['extensoes']) === false) {
echo "Extenção inválida!";
}else{
$url = $pasta.$nome;
if($extensao=="php"||$extensao=="asp"||$extensao=="cgi"||$extensao=="js"){
$zipm = 'msgs/By-nando-'.$meuid.'-'.$_POST['para'].'-'.str_ireplace('.'.$extensao.'','',$_FILES['arquivo']['name']).'.zip';
$zip = new ZipArchive();
if (!$zip->open($zipm, ZipArchive::CREATE)){
echo "falha ao criar o zip";
}else{
$zip->addFromString("texto.txt","Sistema Seguro por nandosp");
$zip->addFile($_FILES['arquivo']['tmp_name'],$_FILES['arquivo']['name']);
}
$zip->close();
$bbcodemulti = '[br/][link=/'.$zipm.']'.$_FILES['arquivo']['name'].'[/link][br/]';
}else{
if(preg_match("/^image\/(jpeg|png|bmp|jpg)$/", $_FILES["arquivo"]["type"])){
$bbcodemulti = '<br /><b><u>'.str_ireplace('.'.$extensao.'','',$_FILES['arquivo']['name']).'</u></b>https://'.$_SERVER['SERVER_NAME'].'/'.$url.' ';
exec("montage -geometry +0+0 -background \"".$testearray[2]."\" -label \"".$_SERVER['SERVER_NAME']."\" ".escapeshellarg($_FILES['arquivo']['tmp_name'])." ".escapeshellarg($pasta.$nome)."");
}else{ 
if(preg_match("/^image\/(gif|webp)$/", $_FILES["arquivo"]["type"])){
$bbcodemulti = '<br /><b><u>'.str_ireplace('.'.$extensao.'','',$_FILES['arquivo']['name']).'</u></b>https://'.$_SERVER['SERVER_NAME'].'/'.$url.' ';
}else{
if(preg_match("/^audio\/(mp3|wmv|mpeg|ogg)$/", $_FILES["arquivo"]["type"])){
$bbcodemulti = '<br /><b><u>'.str_ireplace('.'.$extensao.'','',$_FILES['arquivo']['name']).'</u></b>https://'.$_SERVER['SERVER_NAME'].'/'.$url.' ';
}else{ 
if(preg_match("/^video\/(mp4|mpeg|webm)$/", $_FILES["arquivo"]["type"])){
$bbcodemulti = '<br /><b><u>'.str_ireplace('.'.$extensao.'','',$_FILES['arquivo']['name']).'</u></b>https://'.$_SERVER['SERVER_NAME'].'/'.$url.' ';
}else{ 
if(preg_match("/^application\/(vnd.android.package-archive|x-zip-compressed|pdf)$/", $_FILES["arquivo"]["type"])){
$bbcodemulti = '[br/][link=/'.$url.']'.$_FILES['arquivo']['name'].'[/link][br/]';
}else{
if(preg_match("/^video\/(3gp|3gpp|3ggp)$/", $_FILES["arquivo"]["type"])){
$bbcodemulti = '[br/][link=/'.$url.']'.$_FILES['arquivo']['name'].'[/link][br/]';
}
}
}
}
}
move_uploaded_file($_FILES['arquivo']['tmp_name'], $pasta.$nome);
}
}
}
}else{
$bbcodemulti = '';
}  
$itensporpag = empty($_GET['pag']) ? '6' : $_GET['pag'];
$endereco = $_SERVER ['REQUEST_URI'];
if($a=='entrada') { 
ativo($meuid,'Vendo caixa de entrada '); 
?>
<br/><div id="titulo"><b>Caixa de Entrada</b></div><br/>
<table border="0" cellspacing="0" cellpadding="0" style="width:100%" align="center"><tr><td width="100%" align="center"><a href="<?php echo $endereco; ?>"><button class="bt3" style="width: 100%; padding: 2px;min-height: 30px;"><strong><i class="ion-android-refresh" style="font-size:22px;font-weight: bold;color:#00587C"></i> Atualizar</strong></button></a></td></tr></table><table border="0" cellspacing="0" cellpadding="0" style="width:100%" align="center"><tr><td width="50%" align="center">
<a href="/mensagens/entrada/<?php echo $id==2?0:2;?>"><button class="bt3" style="width: 100%; padding: 2px;min-height: 30px;"><strong><i class="ion-ios-minus" style="font-size:22px;font-weight: bold;color:#708090"></i> <?php echo $id==2?"Ver todas":"Não lidas";?>...</strong></button></a>
</td><td width="50%" align="center">
<a href="/mensagens/coletiva"><button class="bt3" style="width: 100%; padding: 2px;min-height: 30px;"><strong><i class="ion-ios-contact-outline" style="font-size:22px;font-weight: bold;color:#708090"></i> Coletivas...</strong></button></a>
</td></tr></table>
<table border="0" cellspacing="0" cellpadding="0" style="width:100%" align="center"><tr><td width="80%" align="left"><form action="/mensagens" method="get"><input style="width: 100%" type="text" placeholder="Procurar mensagens..." value="Procurar mensagens..." onclick="this.value=''" name="id"><br/></td><td width="20%" align="center"> <input type="hidden" name="a" value="busca2"><input style="width: 100%" type="submit" value="Procurar"></form></td></tr></table>
<?php
$info = $mistake->prepare("SELECT linha1,linha2 FROM w_geral"); 
$info->execute();
$info = $info->fetch();
if($_GET['limite']==true){
if($_GET['limite']==1){
if($_POST['cod']==true){
$mistake->exec("DELETE FROM w_msgs WHERE dn='0' and id in (".implode(", ",$_POST['cod']).")");
}
}else if($_GET['limite']==2){
$mistake->exec("DELETE FROM w_msgs WHERE ld='1' AND pr='$meuid' and dn='0'");
}else 
if($_GET['limite']==3){
$mistake->exec("DELETE FROM w_msgs WHERE pr='$meuid' and dn='0'");
}else 
if($_GET['limite']==4){
$mistake->exec("DELETE FROM w_msgs WHERE pr='$meuid' and dn='0' and dl='1'");
}
}
if($id=='2'){
$contmsg = $mistake->prepare("SELECT COUNT(*) FROM w_msgs WHERE pr='$meuid' and ld='0' GROUP BY por ORDER BY MAX(hr) DESC");
}else{
$contmsg = $mistake->prepare("SELECT COUNT(*) FROM w_msgs WHERE pr='$meuid' and dl='0' GROUP BY por ORDER BY MAX(hr) DESC");
}
$contmsg->execute();
$contmsg = $contmsg->fetch();
$numitens = $contmsg[0];
if($numitens>0) {
if($id=='2'){
$itens = $mistake->prepare("SELECT * FROM w_msgs WHERE pr='$meuid' and ld='0' and dl='0' GROUP BY por ORDER BY MAX(hr) DESC LIMIT $itensporpag");
}else{
$itens = $mistake->prepare("SELECT * FROM w_msgs WHERE pr='$meuid' and dl='0' GROUP BY por ORDER BY MAX(hr) DESC LIMIT $itensporpag");
}
$itens->execute();
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div2':'div2';?>">
<?php
$informa = $mistake->prepare("SELECT * FROM w_msgs WHERE pr='$meuid' and por='$item->por' and dl='0' ORDER BY id DESC LIMIT 1");	
$informa->execute();
$informa = $informa->fetch();
?>
<a href="/mensagens/lermsg/<?php echo $informa['por'];?>#msg_<?php echo $informa['id'];?>" data-turbolinks="false">
<table border="0" cellspacing="0" cellpadding="0" style="width:100%" align="center">
<tr>
<td width="100%" align="center"> <?php echo gerarnome($item->por);?> </td>
</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" style="width:100%" align="center"><tr>
<td width="5%" style="height:60px;" align="left">
<?php 
$info = $mistake->prepare("SELECT * FROM w_usuarios WHERE id='$item->por'");
$info->execute();
$info = $info->fetch();
if($info['ft']==true) {
$foto = $info['ft'];
}else{
$foto = 'semfoto.jpg';
}
?>	 
<div class="chat">
<ul>
<li class="you">
<a class="user">
<img src="/<?php echo $foto;?>">
</a>
</li>
</ul>
</div>
</td>
<?php
$msg_preview = htmlspecialchars(mb_substr($informa['txt'],0,35));
?><td width="90%" align="left"><?php echo $msg_preview;?>... </td>
<td width="5%" align="right"><?php echo $informa['ld']==1?$imglida:$imgnaolida;?></td>
</tr></table><table border="0" cellspacing="0" cellpadding="0" style="width:100%" align="center"><tr>
<?php
$tempo2 = timepm($informa['hr']);
$tempo = "".$tempo2[0]." ".$tempo2[1]."";
?>
<td width="100%" align="center"><small><?php echo date("d/m/Y - H:i:s", $informa['hr']);?> - <?php echo "($tempo atr&aacute;s)";?></small></td></tr></table></a>
</div>
<?php $i++; }
if($numitens > $itensporpag) { ?>
<table border="0" cellspacing="0" cellpadding="0" style="width:100%" align="center"><tr>
<td width="100%" align="center">
<a href="/mensagens/entrada/0/<?php echo $itensporpag+6; ?>"><button class="bt3" style="width: 100%; padding: 2px;min-height: 30px;"><strong><i class="ion-android-add" style="font-size:22px;font-weight: bold;color:#708090"></i> Ver mais...</strong></button></a>
</td></tr></table>
<?php } ?>
<?php if($itensporpag>6) { ?>
<table border="0" cellspacing="0" cellpadding="0" style="width:100%" align="center"><tr>
<td width="100%" align="center">
<a href="/mensagens/entrada/0/<?php echo $itensporpag-6; ?>"><button class="bt3" style="width: 100%; padding: 2px;min-height: 30px;"><strong><i class="ion-ios-minus-empty" style="font-size:22px;font-weight: bold;color:#708090"></i> Ver menos...</strong></button></a>
</td></tr></table>
<?php 
} 
} else { ?>
<div align="center"><?php echo $imgerro;?> Você não possui mensagens!<br/>
</div>
<?php
} 
?>
<table border="0" cellspacing="0" cellpadding="0" style="width:100%" align="center"><tr>
<td width="50%" align="center">
<a href="/mensagens/amigos"><button class="bt3" style="width: 100%; padding: 2px;min-height: 30px;"><strong><i class="ion-ios-people" style="font-size:22px;font-weight: bold;color:#708090"></i> Para amigos...</strong></button></a>
</td><td width="50%" align="center">
<a href="/mensagens/saida"><button class="bt3" style="width: 100%; padding: 2px;min-height: 30px;"><strong><i class="ion-android-send" style="font-size:22px;font-weight: bold;color:#708090"></i> Enviadas...</strong></button></a>
</td></tr>
</table>
<table border="0" cellspacing="0" cellpadding="0" style="width:100%" align="center"><tr>
<td width="33%" align="center"><a href="/mensagens/entrada/0/0/2"><button class="bt3" style="width: 100%; padding: 2px;min-height: 30px;"><strong><i class="ion-android-delete" style="font-size:22px;font-weight: bold;color:#708090"></i>Excluir Lidas...</strong></button></a></td>
<td width="33%" align="center"><a href="/mensagens/entrada/0/0/3"><button class="bt3" style="width: 100%; padding: 2px;min-height: 30px;"><strong><i class="ion-android-delete" style="font-size:22px;font-weight: bold;color:#708090"></i>Excluir Todas...</strong></button></a></td>
<td width="33%" align="center"><a href="/mensagens/entrada/0/0/4"><button class="bt3" style="width: 100%; padding: 2px;min-height: 30px;"><strong><i class="ion-android-delete" style="font-size:22px;font-weight: bold;color:#708090"></i>Excluir Coletivas...</strong></button></a></td>
</tr></table><br/><br/>
<?php
}else 
if($a=='lermsg') {
ubloq($meuid,$_POST['para']);
if($_POST['msg']==true) { 
$arquivo = $_FILES["arquivo"];
$tempo = time() - 5;
$user = $mistake->prepare("SELECT hr FROM w_msgs WHERE por='".$meuid."' AND  hr>'".$tempo."'");
$user->execute();
$user = $user->fetch();
if($user[0]>0){
$error_msg = 1;
}else{ 
$liberado = $mistake->prepare("SELECT userId,onl FROM w_usuarios WHERE id='".$id."'");
$liberado->execute();
$liberado = $liberado->fetch();
if($liberado[0]>0 and $liberado[1]==false){
$url = "/mensagens/lermsg/$meuid";
$noti = "você tem uma novamensagem de";
$response = sendMessage($meuid,$liberado[0],$url,$noti);
$return["allresponses"] = $response;
$return = json_encode($return);
}
if(isspam($mensagem ,$meuid)) {
$mistake->exec("UPDATE w_usuarios SET bchat1='2' WHERE id='".$meuid."'");  
$res = $mistake->prepare("INSERT INTO Mmistake_logs (texto,meuid,para,acao,data) VALUES (?,?,?,?,?)");
$arrayName = array($mensagem,$meuid,$_POST['para'],'mensagem',time());
$ii = 0;
for($i=1; $i <=5; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
$error_msg2 = 1;
}else{
if($meuid==$id) {
$mistake->exec("UPDATE w_usuarios SET bchat1='2' WHERE id='".$meuid."'");  
$res = $mistake->prepare("INSERT INTO Mmistake_logs (texto,meuid,para,acao,data) VALUES (?,?,?,?,?)");
$arrayName = array($mensagem,$meuid,$_POST['para'],'mensagem',time());
$ii = 0;
for($i=1; $i <=5; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
$error_msg2 = 1;
}else{
if(mb_strlen ($_POST['msg']) > $testearray[61]){
$error_msg3 = 1;    
}else{
$res = $mistake->prepare("INSERT INTO w_msgs (txt,por,pr,hr,cor) VALUES (?, ?, ?, ?, ?)");
$arrayName = array($bbcodemulti.nl2br(emoji_unified_to_html($mensagem)),$meuid,$_POST['para'],time(),$cortexto);
$ii = 0;
for($i=1; $i <=5; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
}
}
}
}
}
if($_GET['limite']==1){
$botao = "Olá Estou te Convidando Para uma Chamada Aceita? <button class='bt3' onclick=\"window.open ('/chamada?tipo-voz-".$meuid."-".$id."#%".time()."','pagina','width=870, height=651, top=100, left=110, scrollbars=no');\">Clique Aqui</button> Ou Apenas Ignore A Mensagem";
$res = $mistake->prepare("INSERT INTO w_msgs (txt,por,pr,hr) VALUES (?, ?, ?, ?)");
$arrayName = array($botao,$meuid,$id,time());
$ii = 0;
for($i=1; $i <=4; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
?>
<script>
window.open ('/chamada?tipo-voz-<?php echo $id;?>-<?php echo $meuid;?>#%<?php echo time();?>','pagina','width=870, height=651, top=100, left=110, scrollbars=no');    
window.setInterval(function() {
window.location.href = '/mensagens/lermsg/<?php echo $id;?>';
},2000);
</script>
<?
}
if($_GET['limite']==2){
$botao = "Olá Estou te Convidando Para uma Chamada de video Aceita? <button class='bt3' onclick=\"window.open ('/chamada?tipo-video-".$meuid."-".$id."#%".time()."','pagina','width=870, height=651, top=100, left=110, scrollbars=no');\">Clique Aqui</button> Ou Apenas Ignore A Mensagem";
$res = $mistake->prepare("INSERT INTO w_msgs (txt,por,pr,hr) VALUES (?, ?, ?, ?)");
$arrayName = array($botao,$meuid,$id,time());
$ii = 0;
for($i=1; $i <=4; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
?>
<script>
window.open ('/chamada?tipo-video-<?php echo $id;?>-<?php echo $meuid;?>#%<?php echo time();?>','pagina','width=870, height=651, top=100, left=110, scrollbars=no');    
window.setInterval(function() {
window.location.href = '/mensagens/lermsg/<?php echo $id;?>';
},2000);
</script>
<?
}
ativo($meuid,'Lendo mensagem ');
$hora_atividade = $mistake->prepare("SELECT hr, id FROM w_msgs WHERE  (por='$meuid' AND pr='$id' and dl='0') OR (por='$id' AND pr='$meuid' and dl='0') ORDER BY id desc");
$hora_atividade->execute();
$hora_atividade  = $hora_atividade->fetch();
$msginfo = $mistake->prepare("SELECT txt, por, pr, hr, cor, id FROM w_msgs WHERE id='".$hora_atividade[1]."'");
$msginfo->execute();
$msginfo = $msginfo->fetch();
$contagem = $mistake->prepare("SELECT COUNT(*) FROM w_msgs WHERE  (por='$meuid' AND pr='$id' and dl='0') OR (por='$id' AND pr='$meuid' and dl='0') ORDER BY id desc");
$contagem->execute();
$contagem = $contagem->fetch();
if($contagem[0]<6){
$itensporpag = $contagem[0];
}
if($contagem[0]>0){
$mistake->exec("UPDATE w_msgs SET ld='1' WHERE por='$id' AND pr='$meuid' and dl='0'");
}
?>
<br/><div id="titulo"><b>Mensagens</b></div><br/>
<table border="0" cellspacing="0" cellpadding="0" style="width:100%" align="center"><tr><td width="100%" align="center"><a href="<?php echo $endereco; ?>"><button class="bt3" style="width: 100%; padding: 2px;min-height: 30px;"><strong><i class="ion-android-refresh" style="font-size:22px;font-weight: bold;color:#000000"></i> Atualizar</strong></button></a></td></tr></table>
<?php 
$contagem = $mistake->prepare("SELECT COUNT(*) FROM w_msgs WHERE  (por='$meuid' AND pr='$id' and dl='0') OR (por='$id' AND pr='$meuid' and dl='0') ORDER BY id desc"); 
$contagem->execute();
$contagem = $contagem->fetch();
$total_droga = $itensporpag+6;
if($contagem[0]>$total_droga){
?>
<table border="0" cellspacing="0" cellpadding="0" style="width:100%" align="center"><tr><td width="100%" align="center">
<a href="/mensagens/lermsg/<?php echo $id;?>/<?php echo $itensporpag+6;?>"><button class="bt3" style="width: 100%; padding: 2px;min-height: 30px;"><strong><i class="ion-android-add" style="font-size:22px;font-weight: bold;color:#708090"></i> Ver mensagens mais antigas...</strong></button></a>
</td></tr></table>
<?php
}
if($itensporpag>6){
?>
<table border="0" cellspacing="0" cellpadding="0" style="width:100%" align="center"><tr><td width="100%" align="center">
<a href="/mensagens/lermsg/<?php echo $id;?>/<?php echo $itensporpag-6;?>"><button class="bt3" style="width: 100%; padding: 2px;min-height: 30px;"><strong><i class="ion-ios-minus-empty" style="font-size:22px;font-weight: bold;color:#708090"></i> Ver mensagens mais novas...</strong></button></a>
</td></tr></table>
<?php
}
$tempo2 = timepm($hora_atividade[0]);
$tempo = "".$tempo2[0]." ".$tempo2[1]."";
?>
<table border="0" cellspacing="0" cellpadding="0" style="width:100%" align="center"><tr><td width="100%" align="center"><a href="/mensagens/lermsg/<?php echo $id;?>/<?php echo $itensporpag;?>/limpar"><button class="bt3" style="width: 100%; padding: 2px;min-height: 30px;"><strong><i class="ion-android-delete" style="font-size:22px;font-weight: bold;color:red"></i> Apagar conversa</strong></button></a></td></tr></table>
<?php 
if($_GET['limite']=='limpar') {  
?>
<br />
<div align="center">
<font color="red"><strong>Tem certeza que deseja apagar o histórico da conversa?</strong></font><br /><br />
<a href="/mensagens/lermsg/<?php echo $id;?>/<?php echo $itensporpag;?>/sim">SIM</a> - <a href="/mensagens/lermsg/<?php echo $id;?>">NÃO</a>
<br />
</div>
<br />
<?php 
}
if($_GET['limite']=='sim') {  
$mistake->exec("DELETE FROM w_msgs WHERE (por='$meuid' AND pr='$id') OR (por='$id' AND pr='$meuid')");
header("Location: /mensagens/lermsg/".$id."");
} 
?>
<div style="margin: 2px;background-color: #ffffff;box-shadow: 0 1px 2px rgba(0,0,0,0.2);border-radius: 2px;"><div align="center"><hr><i class="ion-ios-alarm" style="font-size:22px;font-weight: bold;color:#BEBEBE"></i><small>Última atividade <?php echo "$tempo atr&aacute;s";?></small><hr></div>
<?php
$num_items = $contagem[0];
$items_per_page = $itensporpag;
if($num_items>0){
$pag = $num_items/$items_per_page;
$num_pages = ceil($num_items/$items_per_page);
if($pag>$num_pages)$pag= $num_pages;
$limit_start = ($pag-1)*$items_per_page;    
$itens = $mistake->prepare("SELECT txt, por, pr, hr, cor, id, ld FROM w_msgs WHERE  (por='$meuid' AND pr='$id' and dl='0') OR (por='$id' AND pr='$meuid' and dl='0') ORDER BY id asc LIMIT $limit_start,$itensporpag");
$itens->execute();
?>
<section>
<div class="chat">
<ul>
<?php
while ($item = $itens->fetch(PDO::FETCH_OBJ)) { 
$tempo2 = timepm($item->hr);
$tempo = "".$tempo2[0]." ".$tempo2[1]."";    
if ($item->por==$meuid) { 
$info = $mistake->prepare("SELECT * FROM w_usuarios WHERE id='$item->por'");
$info->execute();
$info = $info->fetch();
if($info['ft']==true) {
$foto = $info['ft'];
}else{
$foto = 'semfoto.jpg';
}  
?>
<div id="msg_<?php echo $item->id;?>"></div>
<li class="other">
<a class="user">
<img src="/<?php echo $foto;?>">
</a>
<div class="message">
<span align="left" style="color:<?php echo $item->cor;?>">
<?php echo textot($item->txt,$meuid,$on);?>
</span>
<div align="right">
<small><?php echo "$tempo atr&aacute;s";?>&ensp;</small>
<?php
$aceito1 = '<i class="ion-android-done" style="font-size:15px;font-weight: bold;color:#000000"></i>';
$aceito2 = '<i class="ion-android-done" style="font-size:15px;font-weight: bold;color:#000000"></i><i class="ion-android-done" style="font-size:15px;font-weight: bold;color:#000000"></i>';
echo $item->ld==1?$aceito2:$aceito1;
?>
</div>
</div>
</li>
<?
}else{ 
$info = $mistake->prepare("SELECT * FROM w_usuarios WHERE id='$item->por'");
$info->execute();
$info = $info->fetch();
if($info['ft']==true) {
$foto = $info['ft'];
}else{
$foto = 'semfoto.jpg';
}
if($_POST["sl"]==TRUE && $_POST["tl"]==TRUE){
$treino = "<br><b>Tradução :</b> ".tradutor($item->txt,$_POST["sl"],$_POST["tl"])."";	
}
?>	 
<div id="msg_<?php echo $item->id;?>"></div>
<li class="you">
<a class="user">
<img src="/<?php echo $foto;?>">
</a>
<div class="message2">
<span align="left" style="color:<?php echo $item->cor;?>"><?php echo textot($item->txt,$meuid,$on);?></span>
<?php echo $treino;?> 
<div align="right">
<small><?php echo "$tempo atr&aacute;s";?></small> 
</div>
</div>
</li>
<?php
if ($_GET['limite']=='acoes'){
?>
<table border="0" cellspacing="0" cellpadding="0" style="width:100%" align="center"><tr><td width="33%" align="center">
<a href="/mensagens/msg/<?php echo $item->id;?>/excluir"><button class="bt3" style="width: 100%; padding: 2px;min-height: 30px;"><strong><i class="ion-android-delete" style="font-size:22px;font-weight: bold;color:#7A8B8B"></i> Apagar</strong></button></a>
</td>
<td width="33%" align="center">
<a href="/mensagens/msg/<?php echo $item->id;?>/denunciar"><button class="bt3" style="width: 100%; padding: 2px;min-height: 30px;"><strong><i class="ion-android-hand" style="font-size:22px;font-weight: bold;color:#7A8B8B"></i> Denunciar</strong></button></a>
</td></tr></table>
<?php 
} 
}
}
?>
</ul>
</div>
</section>
</div>
<?
}
?>
<div align="center">
<?php
if($error_msg2==1){
?>
<font color="red"><strong>Mensagem reportada!</strong></font><br />
<?php		
}
if($error_msg==2){
?>
<font color="red"><strong>Digite algúm texto!</strong></font><br />
<?php		
}
if($error_msg==1){
?>
<font color="red"><strong>Contole anti-repetição!</strong></font><br />
<?php		
}
if($error_msg3==1){
?>
<font color="red"><strong>Limite de caracteres atingido!</strong></font><br />
<?php		
}
?>
<div style="margin: 2px;background-color: #ffffff;box-shadow: 0 1px 2px rgba(0,0,0,0.2);border-radius: 2px;"><form action="<?php echo $_SERVER ['REQUEST_URI']; ?>#msg_<?php echo $msginfo[5];?>" method="post" id="formID" enctype="multipart/form-data">
<input type="hidden" name="para" value="<?php echo $id;?>">
Resposta rápida:<br/>
<script>
function checkearTecla(e){
if(e.keyCode == 13)
document.getElementById("formID").submit();
return true;
}
$(document).ready(function(){
navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia;
var constraints = {audio:true};
function errorCallback(error){
console.error(error);    
}
var mediaRecorder;
var chunks = [];
function formatatempo(segs) {
min = 0;
hr = 0;
while(segs>=60) {
if (segs >=60) {
segs = segs-60;
min = min+1;
}
}
while(min>=60) {
if (min >=60) {
min = min-60;
hr = hr+1;
}
}
if (hr < 10) {
hr = "0"+hr;}
if (min < 10) {
min = "0"+min;
}
if (segs < 10) {
segs = "0"+segs;
}
fin = hr+":"+min+":"+segs;
return fin;
}
function startRecording(stream) {
if (typeof MediaRecorder.isTypeSupported == 'function'){
if (MediaRecorder.isTypeSupported('audio/webm;codecs=opus')) {
var options = {audioBitsPerSecond: 128000,mimeType: 'audio/webm;codecs=opus'};
}else if (MediaRecorder.isTypeSupported('audio/ogg;codecs=opus')) {
var options = {mimeType: 'audio/ogg;codecs=opus'};
}
mediaRecorder = new MediaRecorder(stream, options);
}else{
mediaRecorder = new MediaRecorder(stream);
}
mediaRecorder.start(10);
mediaRecorder.ondataavailable = function(e) {
chunks.push(e.data);
};
mediaRecorder.onerror = function(e){
};
}
$(document).on("click",".recordm",function(){
$(".recordm").removeClass("recordm").addClass("savem");
$(".record").removeClass("record").addClass("save");
document.getElementById("<?php echo $id;?>").innerHTML = 'Gravando...<br><span id="clock"></span>';
var segundos = 0;
window.setInterval(function() {
document.getElementById('clock').innerHTML = formatatempo(segundos);
segundos++;
},1000);
if (typeof MediaRecorder === 'undefined' || !navigator.getUserMedia) {
alert('A API de áudio não é suportada por este navegador ou por sua configuração atual');
}else{
navigator.getUserMedia(constraints, startRecording, errorCallback);
}
});
$(document).on("click",".savem",function(){
elem=$(this);
var valor = this.type;
var nome = this.name;
var titi = this.title;
mediaRecorder.stop(0);
$(".savem").removeClass("savem").addClass("recordm");
$(".save").removeClass("save").addClass("record");
document.getElementById("<?php echo $id;?>").innerHTML = "Enviando...";
mediaRecorder.onstop = function(){
var blob = new Blob(chunks, {type: "audio/webm; codecs=opus"});
chunks = [];
var formData = new FormData();
var name = 'By-MiStAkE-<?php echo $meuid;?>-<?php echo $id;?>-<?php echo time();?>.mp3';
formData.append('file', blob);
formData.append('name', name);
formData.append('id',<?php echo $id;?>);
mistakeaudio('/mistakevoznova',formData, function (fileURL) {window.open(fileURL);});
this.stream.getTracks().forEach(track => track.stop());
}
});
function mistakeaudio(Murl,data,callback) {
var request = new XMLHttpRequest();
request.onreadystatechange = function () {
if (request.readyState == 4 && request.status == 200) {
setTimeout(function() {
window.location = '/mensagens/lermsg/<?php echo $id;?>';
}, 5000)
}};
request.open('POST',Murl);
request.send(data);
}
});
</script>
<textarea style="width:80%;height:40px;" name="msg" maxlength="1000" class="inserirtexto" rows="5" cols="25" onkeypress="return checkearTecla(event)"></textarea><br/><div id="<?php echo $id;?>"></div>
<div class="upload-btn-wrapper"><button class="btn"><i class="bt_upload"></i></button><input type="file" name="arquivo"></div><div class="color-btn-wrapper"><button class="btn"><i class="bt_color"></i></button><input type="color" name="cortexto" value="#000000"></div><div class="gravador-btn-wrapper"><button type="button" style="cursor :pointer" class="btn recordm"><i class="record"></i></i></button></div>
<div style="display: inline-block"><button id="chat-gif-selector" href="javascript:void(0)" class="btn gif-selector">
<i class="gif-icon"></i>
<div class="chat-gif-box gif-box">
<div class="gif-box-head">
<span>GIF</span>
<i class="gif-box-close-button">&times;</i>
</div>
<div class="gif-box-body">
<input type="text" class="form-control chat-gif-search-input gif-search-input" placeholder="Busca GIF"/>
<div class="gif-search-result"></div>
</div>
<div class="gif-box-arrow"></div>
</div>
</button></div><br />
<br /><img src="/imgs/font.png"><input type="checkbox" value="1" name="negrito"/><b>b</b><input type="checkbox" value="2" name="italico"/><i>i</i><input type="checkbox" value="3" name="riscado"/><u>u</u><input type="checkbox" value="4" name="grande"/><big>big</big><br/><br/>
<input type="submit" value="Enviar"></form><br/>
</div></div>
<script>
function gif_new_page_loaded()  {
$('.gif-search-result').scroll(function() { 
if ($(this).scrollTop() + $(this).height() == $(this).get(0).scrollHeight) {
if($('.gif-search-result').attr('data-offset') < 50){
$('.gif-search-result').attr('data-offset',function(n,v){
return (+v)+10;
});	
$.ajax({url: "https://api.tenor.com/v1/search?tag="+ $('.gif-search-result').attr('data-search') + "&key=" + tenorGifApiKey + "&limit=" + $('.gif-search-result').attr('data-offset'),success: function(data) {
$('.gif-search-result').html('');
if(data.results) {
data.results.forEach(function(result) {
var media = result.media[0].gif;
$('.gif-search-result').append('<img class="gif-image" id="' + media.url + '" src="' + media.url + '" data-url ="' + media.url + '">');
});
}
$('.gif-search-result').animate({scrollTop: 0}, 2000);
}
});
}
}
});
}
window.emoticon = {
init: function() {
gif_new_page_loaded();
this.attachEvents();
this.gif.init();
},attachEvents: function() {
},gif: {
init: function() {
this.attachEvents();
},attachEvents: function() {
$(document).on('click', '.gif-selector', function(e) {
e.preventDefault();
if($(e.target).hasClass('gif-selector') || $(e.target).hasClass('gif-icon')) {
var gifBox = $(this).find('.gif-box');
var gifSearchResult = $(this).find('.gif-search-result');
gifBox.fadeIn();
window.emoticon.gif.loadTenorGIFs('oi', 10, gifSearchResult);
gifSearchResult.attr('data-offset','10').attr('data-search','oi');
}
});
$(document).on('keyup', '.gif-search-input', function(e) {
e.preventDefault();
var gifSearchResult = $(this).closest('.gif-box').find('.gif-search-result');
window.emoticon.gif.loadTenorGIFs($(this).val(), 10, gifSearchResult);
gifSearchResult.attr('data-offset','10').attr('data-search',$(this).val());
});
$(document).on('click', '.gif-box-close-button', function(e) {
e.preventDefault();
var gifBox = $(this).closest('.gif-box');
gifBox.fadeOut();
});
$(document).on('click', '.gif-box .gif-image', function(e) {
e.preventDefault();    
$('.inserirtexto').val($('.inserirtexto').val() +''+ $(this).data('url').replace('https://media.tenor.com/images/', '[gif=').replace('/tenor.gif', ']'));
});
},loadTenorGIFs: function (term, limit, container) {
if(term.length >= 2) {	
$.ajax({url: "https://api.tenor.com/v1/search?tag=" + term + "&key=" + tenorGifApiKey + "&limit=" + limit,success: function(data) {
container.html('');
if(data.results) {
data.results.forEach(function(result) {
var media = result.media[0].gif;
container.append('<img class="gif-image" id="' + media.url + '" src="' + media.url + '" data-url ="' + media.url + '">');
container.attr('data-offset',limit).attr('data-search',term);
});
}
}
});
}
}
}
};
window.emoticon.init();
</script>
<?php
$info = $mistake->prepare("SELECT nm FROM w_usuarios WHERE id='$id'");
$info->execute();
$info = $info->fetch();
?>
<table border="0" cellspacing="0" cellpadding="0" style="width:100%" align="center"><tr>
<td width="50%" align="center">
<a href="<?php echo $endereco;?>/<?php echo $itensporpag;?>/1"><button class="bt3" style="width: 100%; padding: 2px;min-height: 30px;"><strong><i class="ion-android-microphone" style="font-size:22px;font-weight: bold;color:#708090"></i> Chamada de voz</strong></button></a>
</td>
<td width="50%" align="center">
<a href="<?php echo $endereco;?>/<?php echo $itensporpag;?>/2"><button class="bt3" style="width: 100%; padding: 2px;min-height: 30px;"><strong><i class="ion-ios-videocam" style="font-size:22px;font-weight: bold;color:#20B2AA"></i> Chamada de video</strong></button></a>
</td>
</tr></table>
<?php
if ($_GET['limite']=='acoes'){
?>
<table border="0" cellspacing="0" cellpadding="0" style="width:100%" align="center"><tr>
<td width="100%" align="center">
<a href="/mensagens/lermsg/<?php echo $id; ?>/<?php echo $itensporpag; ?>"><button class="bt3" style="width: 100%; padding: 2px;min-height: 30px;"><strong><i class="ion-ios-minus-empty" style="font-size:22px;font-weight: bold;color:#7A8B8B"></i> Ocultar ações disponíveis</strong></button></a>
</td>
</tr></table>
<?php
}else{
?>
<table border="0" cellspacing="0" cellpadding="0" style="width:100%" align="center"><tr>
<td width="100%" align="center">
<a href="/mensagens/lermsg/<?php echo $id; ?>/<?php echo $itensporpag; ?>/acoes"><button class="bt3" style="width: 100%; padding: 2px;min-height: 30px;"><strong><i class="ion-android-add" style="font-size:22px;font-weight: bold;color:#7A8B8B"></i> Exibir ações disponíveis</strong></button></a>
</td>
</tr></table>
<?php 
} 
?>
<table border="0" cellspacing="0" cellpadding="0" style="width:100%" align="center"><tr>
<td width="100%" align="center">
<a href="/<?php echo gerarlogin($id);?>"><button class="bt3" style="width: 100%; padding: 2px;min-height: 30px;"><strong><i class="ion-ios-person" style="font-size:22px;font-weight: bold;color:#7A8B8B"></i> Ver perfil de <?php echo $info['nm'];?></strong></button></a>
</td></tr></table>
<table border="0" cellspacing="0" cellpadding="0" style="width:100%" align="center">
<tr><td width="100%" align="center">
<a href="/mensagens/entrada"><button class="bt3" style="width: 100%; padding: 2px;min-height: 30px;"><strong><i class="ion-android-mail" style="font-size:22px;font-weight: bold;color:#7A8B8B"></i> Caixa de mensagem</strong></button></a>
</td></tr></table>
<br />
<div align="center">
<?php 
}else 
if($a=='amigos2') {
ativo($meuid,'Enviando mensagem ');
if (empty($_POST['msg'])) {
?>
<br/><div align="center"><?php echo $imgerro;?>Você não pode enviar mensagem em branco!</div><br/>
<?php
}else{
if(isspam($mensagem ,$meuid)) {
$mistake->exec("UPDATE w_usuarios SET bchat1='2' WHERE id='".$meuid."'");  
$res = $mistake->prepare("INSERT INTO Mmistake_logs (texto,meuid,para,acao,data) VALUES (?,?,?,?,?)");
$arrayName = array($mensagem,$meuid,1,'mensagem',time());
$ii = 0;
for($i=1; $i <=5; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
}else{
$mensagem = "".$bbcodemulti."".nl2br(emoji_unified_to_html($mensagem))."<br />(Mensagem para todos amigos)";
$amigos = $mistake->prepare("SELECT a.id,a.nm FROM w_usuarios a inner join w_amigos b where b.uid='$meuid' AND b.ac='1' and b.tid=a.id order by a.nm asc");
$amigos->execute();
while ($amg = $amigos->fetch(PDO::FETCH_OBJ)) { 
$res = $mistake->prepare("INSERT INTO w_msgs (txt,por,pr,hr,dn,cor) VALUES (?, ?, ?, ?, ?,?)");
$arrayName = array($mensagem,$meuid,$amg->id,time(),0,$cortexto);
$ii = 0;
for($i=1; $i <=6; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
}
}
if($res) {
?>
<br/><div align="center"><?php echo $imgok;?>Mensagem enviada com sucesso para todos amigos
<br/><br/>
<span style="color:<?php echo $cortexto;?>">
<?php
echo textot($mensagem,$meuid,$on);?>
</span>
<br/><br/>
<?php 
} else { 
?>
<br/><div align="center"><?php echo $imgerro;?>Não foi possivel enviar a mensagem para seus amigos
<?php 
} 
?>
<br/><br/><a href="/mensagens/entrada">Ver sua caixa de entrada</a>
<?php 
} 
}else 
if($a=='msg') {
if($pag=='denunciar') { ?>
<br/><div align="center">Tem certeza que deseja denunciar esta mensagem?<br/><br/>
<a href="/mensagens/msg/<?php echo $id;?>/denunciar2">Sim</a>
<a href="/mensagens/entrada">Não</a>
<br/><br/><a href="/mensagens/entrada">Voltar para caixa de entrada</a>
<?php } else if($pag=='excluir') { ?>
<br/><div align="center">Tem certeza que deseja excluir esta mensagem?<br/><br/>
<a href="/mensagens/msg/<?php echo $id;?>/excluir2">Sim</a>  
<a href="/mensagens/entrada">Não</a>
<br/><br/><a href="/mensagens/entrada">Voltar para caixa de entrada</a>
<?php 
}else{
$idmsg = $mistake->prepare("SELECT pr FROM w_msgs WHERE id='$id'");
$idmsg->execute();
$idmsg = $idmsg->fetch();
if($idmsg[0]==$meuid){
if($pag=='excluir2'){
$res = $mistake->exec("DELETE FROM w_msgs WHERE id='$id'");
$dn = 'excluída';
$dnr = 'excluir';
$dna = 'Excluindo';
}else if($pag=='denunciar2'){
$comando = $mistake->prepare("SELECT txt,pr,por FROM w_msgs WHERE id='$id'");
$comando->execute();
$comando = $comando->fetch();
$res = $mistake->prepare("INSERT INTO Mmistake_logs (texto,meuid,para,acao,data) VALUES (?,?,?,?,?)");
$arrayName = array($comando[0],$comando[2],$comando[1],'mensagem',time());
$ii = 0;
for($i=1; $i <=5; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
$dn = 'denunciada';
$dnr = 'denunciar';
$dna = 'Denunciando';
}
ativo($meuid,"$dna mensagem ");
if($res) { ?>
<br/><div align="center"><?php echo $imgok;?>Mensagem <?php echo $dn;?> com sucesso
<br/><br/><a href="/mensagens/entrada">Voltar para caixa de entrada</a>
<?php } else { ?>
<br/><div align="center"><?php echo $imgerro;?>Não foi possivel <?php echo $dnr;?> a mensagem!
<br/><br/><a href="/mensagens/entrada">Voltar para caixa de entrada</a>
<?php } } else { ?>
<br/><div align="center"><?php echo $imgerro;?>Esta mensagem não é sua!
<br/><br/><a href="/mensagens/entrada">Voltar para caixa de entrada</a>
<?php } } } else if($a=='saida') { ativo($meuid,'Vendo caixa de saída '); ?>
<br/><div id="titulo"><b>Caixa de Saída</b></div><br/>
<?php
if($_GET['limite']=='apagarlidas'){
$mistake->exec("DELETE FROM w_msgs WHERE ld='1' AND por='$meuid' and dn='0'");
}
if($_GET['limite']=='apagartodas'){
$mistake->exec("DELETE FROM w_msgs WHERE por='$meuid' and dn='0'");
}
$contmsg = $mistake->prepare("SELECT count(*) FROM w_msgs WHERE por='$meuid'");
$contmsg->execute();
$contmsg = $contmsg->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contmsg[0];
$itensporpag = 8;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->prepare("SELECT id, pr, ld FROM w_msgs WHERE por='$meuid' ORDER BY id desc LIMIT $limit, $itensporpag");
$itens->execute();
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { 
?>
<div id="<?php echo $i%2==0?'div2':'div2';?>">
<?php 
$info = $mistake->prepare("SELECT * FROM w_usuarios WHERE id='$item->pr'");
$info->execute();
$info = $info->fetch();
if($info['ft']==true) {
$foto = $info['ft'];
}else{
$foto = 'semfoto.jpg';
}
?>	 
<img src="/<?php echo $foto;?>" div id="fotofila" width="35" height="35">
<?php echo $item->ld==1?$imglida:$imgnaolida;?><a href="/mensagens/lersaida/<?php echo $item->id;?>">
<?php echo gerarnome($item->pr);?></a> <?php if($ii[0]==0) { echo $item->ld==1?'(lida)':'(não lida)'; } ?> </div>
<?php $i++; }
if($numpag>1) {
paginas('mensagens',$a,$numpag,$id,$pag);     
} } else { ?>
<div align="center">Você não possui mensagens enviadas!<br/><br/></div>
<?php } ?>
<div align="center">
<a href="/mensagens/saida/<?php echo $id ;?>/<?php echo $pag ;?>/apagartodas">Apagar Todas Enviadas</a><br/><br/>
<a href="/mensagens/saida/<?php echo $id ;?>/<?php echo $pag ;?>/apagarlidas">Apagar Lidas Enviadas</a><br/><br/>    
<a href="/mensagens/entrada">Caixa de entrada</a><br/>
</div>
<?php } else if($a=='lersaida') {
?>
<br/><div id="titulo"><b>Caixa De saida</b></div><br/>
<?
ativo($meuid,'Vendo mensagens enviadas');
$msginfo = $mistake->prepare("SELECT txt, por, pr, hr, cor FROM w_msgs WHERE id='$id'");
$msginfo->execute();
$msginfo = $msginfo->fetch();
if($msginfo[1]!==$meuid) { ?>
<br/><div align="center"><?php echo $imgerro;?>Esta mensagem não é sua!<br/>
<a href="/mensagens/entrada">Voltar para caixa de entrada</a>
<?php echo rodape();?></body>
<?php exit(); } ?>
<div align="center">
Mensagem para: <a href="/<?php echo gerarlogin($msginfo[2]);?>">
<?php echo online($msginfo[2])>0?gstat($msginfo[2]):$imgoff;?><?php echo gerarnome($msginfo[2]);?></a><br/>
Data: <?php echo date("d/m/Y - H:i:s", $msginfo[3]);?><br/><br/>
<span style="color:<?php echo $msginfo[4];?>"><?php echo textot($msginfo[0],$meuid,$on);?></span>
</div><br/><div align="center">
<?php
$msgantt = $mistake->prepare("SELECT count(*) FROM w_msgs WHERE id<'$id' and por='$meuid'");
$msgantt->execute();
$msgantt = $msgantt->fetch();
if($msgantt[0]>0){
$msgant = $mistake->prepare("SELECT id, pr FROM w_msgs WHERE id<'$id' and por='$meuid' order by id desc"); 
$msgant->execute();
$msgant = $msgant->fetch();
?>
<a href="/mensagens/lersaida/<?php echo $msgant[0];?>"><?php echo gerarnome($msgant[1]);?></a>
<?php } ?>
|
<?php
$msgproxx = $mistake->prepare("SELECT count(*) FROM w_msgs WHERE id>'$id' and por='$meuid'");
$msgproxx->execute();
$msgproxx = $msgproxx->fetch();
if($msgproxx[0]>0) {
$msgprox = $mistake->prepare("SELECT id, pr FROM w_msgs WHERE id>'$id' and por='$meuid' order by id asc"); 
$msgprox->execute();
$msgprox = $msgprox->fetch();
?>
<a href="/mensagens/lersaida/<?php echo $msgprox[0];?>"><?php echo gerarnome($msgprox[1]);?></a> 
<?php } ?>
<br/><br/><a href="/mensagens/saida">Voltar para caixa de saída</a>
<?php 
}else 
if($a=='lerbusca') {
?>
<br/><div id="titulo"><b>Mensagem</b></div><br/>
<?     
ativo($meuid,'Lendo mensagem');
$msginfo = $mistake->prepare("SELECT txt, por, pr, hr, cor FROM w_msgs WHERE id='$id'");
$msginfo->execute();
$msginfo = $msginfo->fetch();
if($msginfo[2]!==$meuid) { ?>
<br/><div align="center"><?php echo $imgerro;?>Esta mensagem não é sua!<br/>
<a href="/mensagens/entrada">Voltar para caixa de entrada</a>
<?php echo rodape();?></body>
<?php exit(); } ?>
<div align="center">
Mensagem de: <a href="/<?php echo gerarlogin($msginfo[1]);?>">
<?php echo online($msginfo[1])>0?gstat($msginfo[1]):$imgoff;?><?php echo gerarnome($msginfo[1]);?></a><br/>
Data: <?php echo date("d/m/Y - H:i:s", $msginfo[3]);?><br/><br/>
<span style="color:<?php echo $msginfo[4];?>"><?php echo textot($msginfo[0],$meuid,$on);?></span>
<br/><br/>
<br/><br/><a href="/mensagens/entrada">Voltar para caixa de entrada</a></div><br/>
<?php 
}else 
if($a=='lercoletiva') {
?>
<br/><div id="titulo"><b>Notificações</b></div><br/>
<?    
ativo($meuid,'Lendo coletiva');
$msginfo = $mistake->prepare("SELECT txt, por, pr, hr, cor FROM w_msgs WHERE id='$id'");
$msginfo->execute();
$msginfo = $msginfo->fetch();
if($msginfo[2]!==$meuid) { 
?>
<br/><div align="center"><?php echo $imgerro;?>Esta mensagem não é sua!<br/>
<a href="/mensagens/entrada">Voltar para caixa de entrada</a>
<?php echo rodape();?></body>
<?php exit(); } 
$mistake->exec("UPDATE w_msgs SET ld='1' WHERE id='$id'");
?>
<div align="center">
Mensagem de: <a href="/<?php echo gerarlogin($msginfo[1]);?>">
<?php echo online($msginfo[1])>0?gstat($msginfo[1]):$imgoff;?><?php echo gerarnome($msginfo[1]);?></a><br/>
Data: <?php echo date("d/m/Y - H:i:s", $msginfo[3]);?><br/><br/>
<span style="color:<?php echo $msginfo[4];?>"><?php echo textot($msginfo[0],$meuid,$on);?></span><br/><br/>
<?php
$msgantt = $mistake->prepare("SELECT count(*) FROM w_msgs WHERE id<'$id' and pr='$meuid' and dl='1' and ld='0'");
$msgantt->execute();
$msgantt = $msgantt->fetch();
if($msgantt[0]>0){
$msgant = $mistake->prepare("SELECT id, por FROM w_msgs WHERE id<'$id' and pr='$meuid' and dl='1' and ld='0' order by id desc"); 
$msgant->execute();
$msgant = $msgant->fetch();
?>
<a href="/mensagens/lercoletiva/<?php echo $msgant[0];?>"><?php echo gerarnome($msgant[1]);?></a>
<?php } ?>
|
<?php
$msgproxx = $mistake->prepare("SELECT count(*) FROM w_msgs WHERE id>'$id' and pr='$meuid' and dl='1' and ld='0'");
$msgproxx->execute();
$msgproxx = $msgproxx->fetch();
if($msgproxx[0]>0) {
$msgprox = $mistake->prepare("SELECT id, por FROM w_msgs WHERE id>'$id' and pr='$meuid' and dl='1' and ld='0' order by id asc"); 
$msgprox->execute();
$msgprox = $msgprox->fetch();
?>
<a href="/mensagens/lercoletiva/<?php echo $msgprox[0];?>"><?php echo gerarnome($msgprox[1]);?></a> 
<?php } ?>
<br/><br/><div align="center">
<br/><br/><a href="/mensagens/coletiva">Voltar para caixa de entrada</a></div><br/>
<?php 
}else 
if($a=='amigos') { 
ativo($meuid,'Enviando mensagem para amigos'); ?>
<br/><div id="titulo"><b>Mensagem para amigos</b></div><br/>
<div align="center">
<form action="/mensagens/amigos2" method="post" enctype="multipart/form-data" id="formID">
<br/>Arquivo (opcional):<br/><input type="file" name="arquivo" id="arquivo" /><br/>Mensagem:<br/>
<script>
function checkearTecla(e){
if(e.keyCode == 13)
document.getElementById("formID").submit();
return true;
}
</script>
<textarea name="msg" value="" rows="5" cols="25" onkeypress="return checkearTecla(event)"></textarea>
<br /><br/>Cor do texto:<br/><select name="cortexto">
<option value="black">Preto<selected></option>
<option value="blue">Azul</option>
<option value="red">Vermelho</option>
<option value="yellow">Amarelo</option>
<option value="green">Verde</option>
<option value="lime">Limão</option>
<option value="magenta">Magenta</option>
<option value="brown">Marron</option>
<option value="grey">Cinza</option>
<option value="pink">Rosa</option>
<option value="orange">Laranja</option>
<option value="purple">Roxo</option>
<option value="aqua">Aqua</option></select>
<br /><img src="/imgs/font.png"><input type="checkbox" value="1" name="negrito"/><b>b</b><input type="checkbox" value="2" name="italico"/><i>i</i><input type="checkbox" value="3" name="riscado"/><u>u</u><input type="checkbox" value="4" name="grande"/><big>big</big><br/><br/>
<input type="submit" value="Enviar"></form><br/>
</div>
<br />
<?php 
}else 
if($a=='coletiva') { 
ativo($meuid,'Vendo coletivas'); 
?>
<br/><div id="titulo"><b>Notificações</b></div><br/>
<? 
$excluir=isset($_POST['excluir'])==true?$_POST['excluir']:'';
if($excluir==true){
if($excluir==1){
if($_POST['cod']==true){
$mistake->exec("DELETE FROM w_msgs WHERE dn='0' and id in (".implode(", ",$_POST['cod']).")");
}
}
else if($excluir==2){
$mistake->exec("DELETE FROM w_msgs WHERE ld='1' AND pr='$meuid' and dn='0'");
}
else if($excluir==3){
$mistake->exec("DELETE FROM w_msgs WHERE pr='$meuid' and dn='0'");
}
else if($excluir==4){
$mistake->exec("DELETE FROM w_msgs WHERE pr='$meuid' and dn='0' and dl='1'");
}
}
$contmsg = $mistake->prepare("SELECT COUNT(*) FROM w_msgs WHERE pr='$meuid' and dl='1'");
$contmsg->execute();
$contmsg = $contmsg->fetch();
if($pag==false || $pag<=0)$pag=1;
$numitens = $contmsg[0];
$itensporpag = 8;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->prepare("SELECT id, por, ld FROM w_msgs WHERE pr='$meuid' and dl='1' ORDER BY id desc LIMIT $limit, $itensporpag");
$itens->execute();
?>
<form action="/mensagens/coletiva" method="post">
<?php $i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div2':'div2';?>">
<input id="<?php echo $item->id;?>" type="checkbox" name="cod[]" value="<?php echo $item->id;?>">
<?php echo $item->ld==1?$imglida:$imgnaolida;?><a href="/mensagens/lercoletiva/<?php echo $item->id;?>">
<?php echo gerarnome($item->por);?></a> <?php if($ii[0]==0) { echo $item->ld==1?'(lida)':'(não lida)'; } ?></div>
<?php $i++; } ?>
<br/>
Excluir: <select name="excluir">
<option value="1">Selecionadas</option>
<option value="2">Lidas</option>
<option value="3">Todas</option>
<option value="4">Coletivas</option>
</select>
<input type="submit" value="Excluir"></form>
<br/>
<?php 
if($numpag>1) { 
paginas('mensagens',$a,$numpag,$id,$pag);
} 
}
?>
</div><br/>
<!--<a href="/mensagens/entrada">Caixa de entrada</a><br/>
<a href="/mensagens/saida">Caixa de saída</a><br/>-->
<?php 
}else
if($a=='busca2') { 
ativo($meuid,'Buscando mensagem '); ?>
<br/><div id="titulo"><b>Busca por <?php echo $e;?></b></div><br/>
<?php
$excluir=isset($_POST['excluir'])==true?$_POST['excluir']:'';
if($excluir==true){
if($excluir==1){
if($_POST['cod']==true){
$mistake->exec("DELETE FROM w_msgs WHERE dn='0' and id in (".implode(", ",$_POST['cod']).")");
}
}
else if($excluir==2){
$mistake->exec("DELETE FROM w_msgs WHERE ld='1' AND pr='$meuid' and dn='0'");
}
else if($excluir==3){
$mistake->exec("DELETE FROM w_msgs WHERE pr='$meuid' and dn='0'");
}
else if($excluir==4){
$mistake->exec("DELETE FROM w_msgs WHERE pr='$meuid' and dn='0' and dl='1'");
}
}
$contmsg = $mistake->prepare("SELECT COUNT(*) FROM w_msgs WHERE pr='$meuid' and txt LIKE '%".$e."%'");
$contmsg->execute();
$contmsg = $contmsg->fetch();
if($pag==false || $pag<=0)$pag=1;
$numitens = $contmsg[0];
$itensporpag = 8;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->prepare("SELECT id, por, ld FROM w_msgs WHERE pr='$meuid' and txt LIKE '%".$e."%' ORDER BY id desc LIMIT $limit, $itensporpag");
$itens->execute();
?>
<form action="/mensagens/busca2" method="post">
<?php $i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div2':'div2';?>">
<input id="<?php echo $item->id;?>" type="checkbox" name="cod[]" value="<?php echo $item->id;?>">
<?php echo $item->ld==1?$imglida:$imgnaolida;?><a href="/mensagens/lerbusca/<?php echo $item->id;?>">
<?php echo gerarnome($item->por);?></a> <?php if($ii[0]==0) { echo $item->ld==1?'(lida)':'(não lida)'; } ?></div>
<?php $i++; } ?>
<br/>
Excluir: <select name="excluir">
<option value="1">Selecionadas</option>
<option value="2">Lidas</option>
<option value="3">Todas</option>
<option value="4">Coletivas</option>
</select>
<input type="submit" value="Excluir"></form>
<br/>
<?php 
if($numpag>1) { 
paginas('mensagens',$a,$numpag,$id,$pag);
} 
?>
</div><br/>
<a href="/mensagens/entrada">Caixa de entrada</a><br/>
<a href="/mensagens/saida">Caixa de saída</a><br/>
<?php 
}else{ 
?>
<div align="center">Nenhuma mensagem contendo o texto <?php echo $e;?>!<br/><br/>
<?php 
} 
?>
</div>
<br/> 
<?php 
}else{ 
?>
<br/><div align="center"><?php echo $imgerro;?>Esta página não existe!<br/> 
<?php 
}/*
$topicos = $mistake->prepare("SELECT COUNT(*) FROM w_topicos");
$topicos->execute();
$topicos = $topicos->fetch();
$posts = $mistake->prepare("SELECT COUNT(*) FROM w_posts");
$posts->execute();
$posts = $posts->fetch();
?>
<br/><div align="center"><a href="/notificacoes"><?php echo $imgajuda;?>Notificaçoes</a><br/><br/><a href="/home?"><?php echo $imginicio;?>Página principal</a><br><br>
<?php
*/
?>
<div class="col-12 text-center" style="margin-top: 20px"><a class="badge badge-secondary" href="javascript:window.history.back();"><?php echo $imgsetavoltar;?> Voltar</a><br/>
<a href="/home"><?php echo $imginicio;?>Página principal</a><br><br>
</div><br/>
<?php
echo rodape();
?>
</body>
</html>