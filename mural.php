<?php
require_once("".$_SERVER["DOCUMENT_ROOT"]."/funcoes.php");
require_once("".$_SERVER["DOCUMENT_ROOT"]."/mistake.php");
require_once("".$_SERVER["DOCUMENT_ROOT"]."/emoji.php");
seg($meuid);
?>
<style>
.gif-image{cursor: pointer;}.gif-selector{position: relative}.gif-selector > i{border: solid 1px;border-radius: 4px;padding: 0px 2px;line-height: 14px;font-size: 10px;vertical-align: 2px;display: inline-block}.gif-selector > i:before{content: "GIF"}.gif-box{position: absolute;bottom: 30px;right: 0px;background-color: #FFFFFF;display: none;z-index: 100;border: solid 1px rgba(0, 0, 0, .2);border-radius: 4px}.gif-box-head{padding: 2px 0px;background-color: rgba(0, 0, 0, .1);text-align: center;font-size: 14pt;color: #808080}.gif-box-close-button{position: absolute;top: 0px;right: 6px;font-size: 14pt !important;z-index: 1}.gif-box-arrow{position: absolute;bottom: -10px;right: 4px;width: 0;height: 0;border-left: 10px solid transparent !important;;border-right: 10px solid transparent !important;border-top: 10px solid #CCCCCC}.gif-box-body{padding: 4px}.gif-search-result{width: calc(100% + 3px);height: 225px;overflow: auto}.gif-search-result img{margin: 1px 0px;width: 100%;height: 120px;object-fit: cover}.alt-chat-gif-selector{top: -11px;margin-left: 0px}
</style>
<?
$gif = isset($_POST['gif']) ? $_POST['gif'] : ''; 
$arquivo = $_FILES["arquivo"];
if (!empty($arquivo["name"])){
$pasta = "msgs/";
$nome = $_FILES['arquivo']['name'];
$nome = "By-AnDeRsOn-".$meuid."-".$nome."";
$nome = str_replace(' ','-',$nome);
$_UP['extensoes'] = array('mp3','wmv','jpeg','png','gif','bmp','jpg','mp4','webm','mpeg','3gp','3gpp','3ggp','apk','zip');
$extensao = strtolower(end(explode('.', $_FILES['arquivo']['name'])));
if (array_search($extensao, $_UP['extensoes']) === false) {
echo "Extenção inválida!";
}else{
$url = $pasta.$nome;
if(preg_match("/^image\/(jpeg|png|bmp|jpg|mpeg)$/", $_FILES["arquivo"]["type"])){
$bbcodemulti = '<h5>'.str_ireplace('.'.$extensao.'','',$_FILES['arquivo']['name']).'</h5>https://'.$_SERVER['SERVER_NAME'].'/'.$url.' ';
exec("montage -geometry +0+0 -background \"#1E90FF\" -label \"".$_SERVER['SERVER_NAME']."\" ".escapeshellarg($_FILES['arquivo']['tmp_name'])." ".escapeshellarg($pasta.$nome)."");
}else{ 
if(preg_match("/^image\/(gif)$/", $_FILES["arquivo"]["type"])){
$bbcodemulti = '<h5>'.str_ireplace('.'.$extensao.'','',$_FILES['arquivo']['name']).'</h5>https://'.$_SERVER['SERVER_NAME'].'/'.$url.' ';
}else{
if(preg_match("/^audio\/(mp3|wmv|mpeg)$/", $_FILES["arquivo"]["type"])){
$bbcodemulti = '<h5>'.str_ireplace('.'.$extensao.'','',$_FILES['arquivo']['name']).'</h5>https://'.$_SERVER['SERVER_NAME'].'/'.$url.' ';
}else{ 
if(preg_match("/^video\/(mp4|mpeg|webm)$/", $_FILES["arquivo"]["type"])){
$bbcodemulti = '<h5>'.str_ireplace('.'.$extensao.'','',$_FILES['arquivo']['name']).'</h5>https://'.$_SERVER['SERVER_NAME'].'/'.$url.' ';
}else{ 
if(preg_match("/^application\/(vnd.android.package-archive|x-zip-compressed)$/", $_FILES["arquivo"]["type"])){
$bbcodemulti = '[br/][link=/'.$url.']'.$_FILES['arquivo']['name'].'[/link][br/]';
}else{
if(preg_match("/^video\/(3gp|3gpp|3ggp)$/", $_FILES["arquivo"]["type"])){
$bbcodemulti = '[br/][link=/'.$url.']'.$_FILES['arquivo']['name'].'[/link][br/]';
}
$bbcodemulti = '';
}
}
}
}
move_uploaded_file($_FILES['arquivo']['tmp_name'], $pasta.$nome);
}
}
}else{
$bbcodemulti = '';
}  
$cortexto = $_POST['cortexto'];
$text = anti_injection($_POST['rec']);
$text = "".$bbcodemulti."".$text."";
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
$contorno = $_POST["contorno"];
if($contorno=="#000000"){
$contorno = "rgba(0,0,0,0)";    
}else{
$contorno = $contorno;      
}
$text = "$t$t2$t4$t6$text$t7$t5$t3$t1";
if($a=='hall' or $a=='responder' or $a=='curtiu' or $a=='editar' or $a=='editar2' or $a=='comentarios' or $a=='acaohall'){
}else{
if($meuid>0&&$i['visitante']==1){
header("Location:/home?");
exit();
}}
if($a=='hall') { 
ativo($meuid,'Enviando recado no mural ');
$tipo = $pag=='chat1' ? 6 : 5;
$sala = isset($id) ? $id : 0;
?>
<br /><div id="titulo"><b>Enviar hall bate-papo</b></div><br/>
<div align="center"><br/>
<?php
if($_POST['para']==true){
ubloq($meuid,$_POST['para']);
$para = $_POST['para'];
}else{
$para = 0;   
}
if($_POST['acao']==true){
$acao = $_POST['acao'];
}else{
$acao = 0;   
}
$flood = $mistake->query("SELECT max(hora) FROM w_mural")->fetch();
$pmfl = $flood[0]+1;
$time8 = time();
$sml = textot($_POST['rec'],$meuid,$on);
$time_foood = time()-10;
$anti_repeticao = $mistake->query("SELECT COUNT(*) FROM w_mural WHERE drec='$meuid' AND tipo='5' AND hora>'".$time_foood."'")->fetch();
$nos = substr_count($sml,"<img src=");
if($nos>$testearray[49]) { 
echo "".$imgerro." Limite máximo de ".$testearray[49]." emoções por recado!";
} else if ($_POST['para']==$meuid) { echo $imgerro;?>
<?php if($pag=='chat1'){
header('Location:/chat1?a=sala&id='.$id.'');
}else{
header('Location:/home');
} ?>
Você não pode enviar para você mesmo!
<?php }
else if($anti_repeticao[0]>0) {
?>
<?php if($pag=='chat1'){
header('Location:/chat1?a=sala&id='.$id.'');
}else{
header('Location:/home');
}?>
Aguarde o tempo do mural!!
<?php
}
else if($pmfl>$time8) { echo $imgerro;?>
<?php header('Location:/home'); ?>
Um recado acabou de ser adicionado, aguarde!
<?php } else if (empty($_POST['rec'])) {
echo $imgerro;?>
Digite algum texto!
<?php
}else {
if(mb_strlen ($_POST['rec']) > $testearray[60]){
echo $imgerro;?>
Limite de texto atingido!
<?php
}else{
$text = nl2br($text);
$liberado = $mistake->prepare("SELECT userId,onl FROM w_usuarios WHERE id='".$_POST["para"]."'");
$liberado->execute();
$liberado = $liberado->fetch();
if($liberado[0]>0){
$url = "/home?$meuid";
$noti = "Você oi marcado no hall";
$response = sendMessage($meuid,$liberado[0],$url,$noti);
$return["allresponses"] = $response;
$return = json_encode($return);
}
if(isspam($text,$meuid)) {
$mistake->exec("UPDATE w_usuarios SET bchat='1' WHERE id='".$meuid."'");  
$res = $mistake->prepare("INSERT INTO Mmistake_logs (texto,meuid,para,acao,data) VALUES (?,?,?,?,?)");
$arrayName = array($text,$meuid,$para,'mural',time());
$ii = 0;
for($i=1; $i <=5; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
}else{
$clean_text = emoji_unified_to_html($text);
$privado = isset($_POST['privado']) ? $_POST['privado'] : 0;
$res = $mistake->prepare("INSERT INTO w_mural (rec,drec,para,hora,tipo,cor,ac,privado,contorno,sala) VALUES (?,?,?,?,?,?,?,?,?,?)");
$arrayName = array($clean_text.$gif,$meuid,$para,time(),$tipo,$_POST['cortexto'],$acao,$privado,$contorno,$sala);
$ii = 0;
for($i=1; $i <=10; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
$timeoutt = time()-86400;
$mistake->exec("DELETE FROM w_mural WHERE tipo='5' and hora <'".$timeoutt."'");
$mistake->exec("UPDATE w_usuarios SET postshall=postshall+1 where id='$meuid'");
}
if($res) { 
$vermu = $mistake->prepare("SELECT max(id) FROM w_mural WHERE drec='$meuid'");
$vermu->execute();
$vermu = $vermu->fetch();
$msge = "Oi voce foi marcado no hall, [link=mural?a=comentarios&id=$vermu[0]]ENTRE AQUI[/link] e veja oque te Escreveran.";
$mistake->exec("INSERT INTO w_notificacoes (texto,para,data,lida) values('".$msge."','".$_POST['para']."','".time()."','0')");
echo $imgok;?>
Recado enviado com sucesso
<?php if($pag=='chat1'){
header('Location:/chat1?a=sala&id='.$id.'');
}else{
header('Location:/home#batepapo');
}
?>
<?php } else { echo $imgerro;?>
Erro ao enviar recado
<?php } } }
?>
<br />
<?php
}else 
if(uchat($meuid)==4) { 
?>
<br/><div align="center"><?php echo $imgerro;?>Você foi bloqueado para acessar murais.<br/><br/>
<a href="/chat1"> <img src='/style/chat.gif'>
Salas de chat</a><br/>
<a href="/home"> <img src='/style/inicio.gif'>
Página principal</a><br><br>
<?php 
rodape();
exit(); 
}
if($a=='responder') {
?>
<br/><div id="titulo"><b>Responder Hall</b></div><br/>
<?
if($_POST['id']==true){  
$sml = textot($_POST['resposta'],$meuid,$on);
$nos = substr_count($sml,"<img src=");
if($nos>$testearray[49]) { 
echo "".$imgerro." Limite máximo de ".$testearray[49]." emoções por recado!";
} else{
$update = $mistake->prepare("UPDATE w_mural SET resposta = ?,idresposta = ? WHERE id = ?");
$update->execute(array(emoji_unified_to_html($_POST['resposta']),$meuid,$_POST['id']));   
header('Location:/home');
}
}
$dele = $mistake->query("SELECT para FROM w_mural WHERE id='$id'")->fetch();
if(perm($meuid)>0 or $dele[0]==$meuid){
?>
<div align="center">
<form action="/mural/responder" method="post">
<input type="hidden" name="id" value="<?php echo $id;?>">
<input name="resposta" maxlength="200">
<input type="submit" value="Postar">
</form></div><br />
<?
}else{
?>
<br/><div align="center">Voce nao pode responder este recado</div><br/>    
<?
}
}else
if($a=='equipe') { 
ativo($meuid,'Vendo mural da equipe '); 
?>
<br/><div id="titulo"><b>Mural da equipe</b></div><br/>
<?php
$contrec = $mistake->query("SELECT count(*) FROM w_mural WHERE tipo='3'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contrec[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->query("SELECT * FROM w_mural WHERE tipo='3' ORDER BY id desc LIMIT $limit, $itensporpag");
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<?php echo online($item->drec)>0?gstat($item->drec):$imgoff;?><a href="/<?php echo gerarlogin($item->drec);?>">
<?php echo gerarnome($item->drec);?></a>: <em style="color: <?php echo $item->cor; ?>;background-color:<?php echo $item->contorno; ?>;"><?php echo textot($item->rec,$meuid,$on);?></em><br/><?php echo date("d/m/Y - H:i:s", $item->hora);?>
<?php if(perm($meuid)>0) { ?>
<br/><a href="/mural/editar/<?php echo $item->id;?>"><font color="#FF0000">[editar]</font></a>
<a href="/mural/excluir/<?php echo $item->id;?>"><font color="#FF0000">[excluir]</font></a>
<?php } ?> </div> <?php $i++; } 
} else { 
?>
<div align="center">Não ah recados </div> 
<?php 
}
if($numpag>1) { 
paginas('mural',$a,$numpag,$id,$pag);    
} 
}else 
if($a=='comentarios') { 
ativo($meuid,'Vendo comentários do mural'); ?>
</b></div>
<?php

$id = $_GET['id'];
?>
<div id="div1">
<?php
$murall = $mistake->prepare("SELECT * FROM w_mural WHERE id='$id'");
$murall->execute();
$murall = $murall->fetch();
$foto = $mistake->prepare("SELECT ft FROM w_usuarios WHERE id='".$murall['drec']."'");
$foto->execute();
$foto = $foto->fetch(); 
$foto2 = $mistake->prepare("SELECT ft FROM w_usuarios WHERE id='".$murall['para']."'");
$foto2->execute();
$foto2 = $foto2->fetch();
if($murall['pvd'] == "sim" && ($murall['drec'] == $meuid || $murall['para'] == $meuid || perm($meuid)>0))
{
if($murall['ac']==0){ ?>
<img src="/<?php echo $foto[0]==true?$foto[0]:'semfoto.jpg';?>" style="width:40px;height:40px;float: center;border-radius: 50%;shape-outside: circle();shape-margin: 15px;text-align: center;border: <?php echo $info['linha1'];?> 3px solid;" /> <a href="/<?php echo gerarlogin($murall['drec']);?>"><?php echo gerarnome($murall['drec']);?></a> <?php if($murall['para']==0) { echo ''; } else { ?> 
<font color="red">(reservadamente)</font> para <img src="<?php echo $foto2[0]==true?$foto2[0]:'semfoto.jpg';?>" style="width:40px;height:40px;float: center;border-radius: 50%;shape-outside: circle();shape-margin: 15px;text-align: center;border: <?php echo $info['linha1'];?> 3px solid;" /> <a href="/<?php echo gerarlogin($murall['para']); ?>"><?php echo gerarnome($murall['para']);?></a><?php } ?>
<div class="chatt-up">
 <span style="color:<?php echo $murall['cor']; ?>"><?php echo textot($murall['rec'],$meuid,$on);?></span>
 <br/>
<hr>
</div>
<hr>
<?php  if (perm($meuid)>0) { ?>
<a href="mural?a=excluir&del=<?php echo $murall['id']; ?>"> <font color="ff0000">[X]</font></a>
<?php } ?>
</div>
<?php } }

else if($murall['pvd'] != "sim")
{
######################################
?>

<?php if($murall['ac']==0){ ?>
<img src="/<?php echo $foto[0]==true?$foto[0]:'semfoto.jpg';?>" style="width:40px;height:40px;float: center;border-radius: 50%;shape-outside: circle();shape-margin: 15px;text-align: center;border: <?php echo $info['linha1'];?> 3px solid;" /> <a href="/<?php echo gerarlogin($murall['drec']);?>"><?php echo gerarnome($murall['drec']);?></a> <?php if($murall['para']==0) { echo ''; } else { ?> 
 para <img src="/<?php echo $foto2[0]==true?$foto2[0]:'semfoto.jpg';?>" style="width:40px;height:40px;float: center;border-radius: 50%;shape-outside: circle();shape-margin: 15px;text-align: center;border: <?php echo $info['linha1'];?> 3px solid;" /> <a href="/<?php echo gerarlogin($murall['para']); ?>"><?php echo gerarnome($murall['para']);?></a><?php } ?>
 <div class="chatt-up">
 <span style="color:<?php echo $murall['cor']; ?>"><?php echo textot($murall['rec'],$meuid,$on);?></span>

<hr>
<?php  if (perm($meuid)>0) { ?>
<a href="mural?a=excluir&del=<?php echo $murall['id']; ?>"> <font color="ff0000">[X]</font></a>
<?php } ?>
</div>
<?php } else { ?>
<img src="acoes/1.png" alt="*"/>
<img src="/<?php echo $foto[0]==true?$foto[0]:'semfoto.jpg';?>" style="width:40px;height:40px;float: center;border-radius: 50%;shape-outside: circle();shape-margin: 15px;text-align: center;border: <?php echo $info['linha1'];?> 3px solid;" /> <a href="/<?php echo gerarlogin($murall['drec']);?>"><?php echo gerarnome($murall['drec']);?></a>
<?php if($murall['ex']==0) { echo ''; } else { ?>
 <img src="acoes/<?php echo $murall['ex'];?>.png" alt="*" width="45" height="45"/>
<?php } ?>
 <span style="color:<?php echo $murall['cor']; ?>"><?php echo textot($murall['rec'],$meuid,$on);?></span> <?php if($murall['para']==0) { echo 'Todos'; } else { ?> <img src="<?php echo $foto2[0]==true?$foto2[0]:'semfoto.jpg';?>" style="width:40px;height:40px;float: center;border-radius: 50%;shape-outside: circle();shape-margin: 15px;text-align: center;border: <?php echo $info['linha1'];?> 3px solid;" /> <a href="/<?php echo gerarlogin($murall['para']); ?>"><?php echo gerarnome($murall['para']);?></a><?php } ?>
<hr>
<?php  if (perm($meuid)>0) { ?>
<a href="mural?a=excluir&del=<?php echo $murall['id']; ?>"> <font color="ff0000">[X]</font></a>
<?php } ?>
</div>
<?php } } ?>
</div></div>
<?php 
if (!empty($_GET['del'])) {
$mistake->exec("DELETE FROM w_comentarios WHERE id='".$_GET['del']."'");
}
$comentario = $_POST['comentario'];
if (!empty($_POST['comentario'])) {
if(isspam($comentario,$meuid)) {
$mistake->exec("UPDATE w_usuarios SET bchat3='4' WHERE id='".$meuid."'");  
$res = $mistake->prepare("INSERT INTO Mmistake_logs (texto,meuid,para,acao,data) VALUES (?,?,?,?,?)");
$arrayName = array($comentario,$meuid,0,'mural',time());
$ii = 0;
for($i=1; $i <=5; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
}else{
$res = $mistake->prepare("INSERT INTO w_comentarios (por,idrec,comentario,hr) VALUES (?, ?, ?, ?)");
$arrayName = array($meuid,$id,nl2br(emoji_unified_to_html($comentario)),time());
$ii = 0;
for($i=1; $i <=4; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
}
}
?>
<br/><div id="titulo"><b>
<?php echo $id==false?'Comentários':"Comentários";?>
</b></div><br/>
<div align="center">
<strong>Postar comentário</strong><br />
<form action="/mural/comentarios/<?php echo $id;?>" method="post">
<input name="comentario" maxlength="500"> 
<input type="submit" value="Postar"></form>
</div>
<br /><br />
<?php
if($id==false)
{
$contrec = $mistake->query("SELECT count(*) FROM w_comentarios WHERE idrec='$id'")->fetch();
}
else
{
$contrec = $mistake->query("SELECT count(*) FROM w_comentarios where idrec='$id'")->fetch();
}
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contrec[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
if($id==false){
$itens = $mistake->query("SELECT * FROM w_comentarios WHERE idrec='$id' ORDER BY id desc LIMIT $limit, $itensporpag");
}else{
$itens = $mistake->query("SELECT * FROM w_comentarios where idrec='$id' ORDER BY id desc LIMIT $limit, $itensporpag");
}
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<?php echo online($item->por)>0?gstat($item->por):$imgoff;?><a href="/<?php echo gerarlogin($item->por);?>">
<?php echo gerarnome($item->por);?></a>: <?php echo textot($item->comentario,$meuid,$on);?><br/><?php echo date("d/m/Y - H:i:s", $item->hr);?>
<?php if(perm($meuid)>0) { ?>
<br/>
<a href="/mural/excluircomentario/<?php echo $item->id; ?>"><font color="#FF0000">[excluir]</font></a>
<?php } ?> </div> <?php $i++; } } else { ?>
<div align="center">Não ah comentários</div><br/><br/>
  
<?php 
} 
if($numpag>1) { 
paginas('mural',$a,$numpag,$id,$pag);   
} 
}
else if($a=='pensamentos') { ativo($meuid,'Vendo mural de pensamentos '); ?>
<br/><div id="titulo"><b>
<?php echo $id==false?'Mural de pensamentos':"Pensamentos de ".gerarnome($id)."";?>
</b></div><br/>
<div align="center">
<strong>Em que você esta pensando agora?</strong><br />
<form action="/mural/pensamento" method="post">
<input name="rec" maxlength="500"> 
<input type="submit" value="Postar"></form>
</div>
<br /><br />
<div align="left">Para marcar um assunto é só usar <b><big><font color="green">#assunto</font></b></big><br/></div>
<?php
if($id==false){
$contrec = $mistake->query("SELECT count(*) FROM w_mural WHERE tipo='4'")->fetch();
}else{
$contrec = $mistake->query("SELECT count(*) FROM w_mural where drec='$id' AND tipo='4'")->fetch();
}
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contrec[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
if($id==false)
{
$itens = $mistake->query("SELECT * FROM w_mural WHERE tipo='4' ORDER BY id desc LIMIT $limit, $itensporpag");
}
else
{
$itens = $mistake->query("SELECT * FROM w_mural where drec='$id' AND tipo='4' ORDER BY id desc LIMIT $limit, $itensporpag");
}
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<?php echo online($item->drec)>0?gstat($item->drec):$imgoff;?><a href="/<?php echo gerarlogin($item->drec);?>">
<?php echo gerarnome($item->drec);?></a>&ensp;Para&ensp;
<?php if($item->para==0) { echo 'Todos'; } else { echo online($item->para)>0?gstat($item->para):$imgoff;?><a href="/<?php echo gerarlogin($item->para);?>">
<?php echo gerarnome($item->para);?></a><?php } ?>:&ensp;<span style="color:<?php echo $item->cor;?>"><?php echo textot($item->rec,$meuid,$on);?></span><br/><?php echo gosteimural($item->id,$item->hora,'pensamentos',$meuid);?>
 </div> 
 <?php 
 $i++; 
 } 
 } else { 
 ?>
<div align="center">Não ah recados</div>  <?php }
if($numpag>1) { 
paginas('mural',$a,$numpag,$id,$pag);  
} 
}else if($a=='divulgacao') { ativo($meuid,'Vendo mural de divulgação '); ?>
<br/><div id="titulo"><b>Mural de divulgação
</b></div><br/>
<?php
$contrec = $mistake->query("SELECT count(*) FROM w_mural WHERE tipo='2'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contrec[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->query("SELECT * FROM w_mural WHERE tipo='2' ORDER BY id desc LIMIT $limit, $itensporpag");
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { 
$tempo2 = timepm($item->hora);
$tempo = "".$tempo2[0]." ".$tempo2[1]."";
?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<?php echo online($item->drec)>0?gstat($item->drec):$imgoff;?><a href="/<?php echo gerarlogin($item->drec);?>">
<?php echo gerarnome($item->drec);?></a>&ensp;Para&ensp;
<?php if($item->para==0) { echo 'Todos'; } else { echo online($item->para)>0?gstat($item->para):$imgoff;?><a href="/<?php echo gerarlogin($item->para);?>">
<?php echo gerarnome($item->para);?></a><?php } ?>:&ensp;<em style="color: <?php echo $item->cor; ?>;background-color:<?php echo $item->contorno; ?>;"><?php echo textot($item->rec,$meuid,$on);?></em><br/><small><b><u>De <?php echo $item->inicio;?> as <?php echo $item->fim;?></small></u></b><div align="right"><?php if(perm($meuid)>0) { ?><a href="/mural/editar/<?php echo $item->id;?>/divulgacao"><font color="#FF0000">[editar]</font></a><a href="/mural/excluir/<?php echo $item->id;?>"><font color="#FF0000">[excluir]</font></a>&emsp;<?php } ?><small><?php echo $imgtempo;?> há <?php echo "$tempo atr&aacute;s";?></small></div>
</div> <?php $i++; } } else { ?>
<div align="center">Não ah recados</div>  <?php }
if($numpag>1) {
paginas('mural',$a,$numpag,$id,$pag);   
} 
}
else if($a=='reuniao') { 
ativo($meuid,'Enviando recado no mural '); 
?>
<br /><div id="titulo"><b>Reuniao da equipe</b></div><br/>
<div align="center"><br/>
<?php
function msgs($ext){
$ext = strtolower($ext);
switch ($ext){
case 'amr':
case 'mp3':
case 'mid':
case 'wav':
case '3gp':
case 'avi':
case 'wmv':
case 'mp4':
case 'mpg':
case 'jpg':
case 'jpeg':
case 'png':
case 'bmp':
case 'gif':
case 'jar':
case 'jad':
case 'sis':
case 'sisx':
case 'pdf':
case 'doc':
case 'zip':
case 'rar':
case 'pps':
case 'ppt':
case 'xls':
case 'swf':
return '0';
break;
default:
return '1';
break;
}
}
if($_POST['para']==true){
ubloq($meuid,$_POST['para']);
$para = $_POST['para'];
}else{
$para = 0;   
}
$flood = $mistake->query("SELECT max(hora) FROM w_mural")->fetch();
$pmfl = $flood[0]+1;
$time8 = time();
$sml = textot($_POST['rec'],$meuid,$on);
$text = $_POST['rec'];
$cortexto = $_POST['cortexto'];
$formato = $_POST['formato'];
$arquivo = $_FILES["arquivo"];
if (!empty($arquivo["name"])){
$pasta = "msgs/";
$nome = $_FILES['arquivo']['name'];
$nome = str_replace("H", "", $nome);
$nome = str_replace("h", "", $nome);
$ext = explode('.', $nome);
$ext = strtolower($ext[count($ext) - 1]);
$nome = "".rand(11,99)."".time().".".$ext."";
$_UP['extensoes'] = array('mp3', 'wmv', 'jpeg', 'png', 'gif', 'bmp', 'jpg', 'mp4', 'mpeg', '3gp', '3gpp', '3ggp');
$extensao = strtolower(end(explode('.', $_FILES['arquivo']['name'])));
if (array_search($extensao, $_UP['extensoes']) === false) {
echo "Extenção inválidade!";
}else{
if(move_uploaded_file($_FILES['arquivo']['tmp_name'], $pasta.$nome))
{
$url = $pasta.$nome;
if(preg_match("/^audio\/(mp3|wmv)$/", $_FILES["arquivo"]["type"])){
$bbcodemulti = ' [audio='.$url.'] ';
}else if(preg_match("/^image\/(jpeg|png|gif|bmp|jpg|mpeg)$/", $_FILES["arquivo"]["type"])){
$bbcodemulti = ' [image='.$url.'] ';
}else if(preg_match("/^video\/(mp4|mpeg)$/", $_FILES["arquivo"]["type"])){
$bbcodemulti = ' [video='.$url.'] ';
}else if(preg_match("/^video\/(3gp|3gpp|3ggp)$/", $_FILES["arquivo"]["type"])){
$bbcodemulti = ' [link='.$url.']'.$_FILES['arquivo']['name'].'[/link] ';
}
}
}
?>
<br />
<?php
}else{
$bbcodemulti = '';
}
?>
<?php
$text = "".$bbcodemulti."".$text."";
if($formato==1)
{
$text = "[b]".$text."[/b]";
}else if($formato==2)
{
$text = "[i]".$text."[/i]";
}else if($formato==3)
{
$text = "[u]".$text."[/u]";
}else if($formato==4)
{
$text = "[big]".$text."[/big]";
}else{
$text = $text;
}
$time_foood = time()-10;
$anti_repeticao = $mistake->query("SELECT COUNT(*) FROM w_mural WHERE drec='$meuid' AND tipo='6' AND hora>'".$time_foood."'")->fetch();
$nos = substr_count($sml,"<img src=");
if($nos>2) { echo $imgerro;?>
Limite máximo de 2 emoções por recado!
<?php } else if ($_POST['para']==$meuid) { echo $imgerro;?>
<?php header('Location:reuniao'); ?>
Você não pode enviar para você mesmo!
<?php }
else if($anti_repeticao[0]>0) {
?>
<?php header('Location:reuniao'); ?>
Aguarde o tempo do mural!!
<?php
}
else if($pmfl>$time8) { echo $imgerro;?>
<?php header('Location:reuniao'); ?>
Um recado acabou de ser adicionado, aguarde!
<?php } else if (empty($_POST['rec'])) {
?>
Digite algum texto!
<?php
}else {
$text = nl2br($text);	    
if(isspam($text,$meuid)) {
$mistake->exec("UPDATE w_usuarios SET bchat='1' WHERE id='".$meuid."'");  
$res = $mistake->prepare("INSERT INTO Mmistake_logs (texto,meuid,para,acao,data) VALUES (?,?,?,?,?)");
$arrayName = array($text,$meuid,$para,'mural',time());
$ii = 0;
for($i=1; $i <=6; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
}else{
$clean_text = emoji_unified_to_html($text);
$res = $mistake->prepare("INSERT INTO w_mural (rec,drec,para,hora,tipo,cor,ac) VALUES (?, ?, ?, ?,?,?,?)");
$arrayName = array($clean_text,$meuid,$para,time(),6,$_POST['cortexto'],$_POST['acao']);
$ii = 0;
for($i=1; $i <=7; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
}
if($res) { echo $imgok;?>
Recado enviado com sucesso
<?php header('Location:reuniao'); ?>
<?php } else { echo $imgerro;?>
Erro ao enviar recado
<?php } } 
?>
<br />
<?php
}else 
if(uchat($meuid)==4) { 
?>
<br/><div align="center"><?php echo $imgerro;?>Você foi bloqueado para acessar murais.<br/><br/>
<a href="chat1"> <img src='style/chat.gif'>
Salas de chat</a><br/>
<a href="home"> <img src='style/inicio.gif'>
Página principal</a><br><br>
<?php 
rodape();
exit(); 
}
else if($a=='hashtag') { ativo($meuid,'Vendo resultados hashtag '); 
function totaltag($keyword){
global $mistake;
$sql = "SELECT SUM(num) as num FROM (SELECT COUNT(id) as num FROM w_mural WHERE rec LIKE ? UNION ALL SELECT COUNT(id) as num FROM w_comentarios WHERE comentario LIKE ? UNION ALL SELECT COUNT(id) as num FROM w_cmt_fotos WHERE cmt LIKE ? UNION ALL SELECT COUNT(id) as num FROM w_posts WHERE txt LIKE ? UNION ALL SELECT COUNT(id) as num FROM bymistake_segredos WHERE texto LIKE ? UNION ALL SELECT COUNT(id) as num FROM bymistake_segredos_cmt WHERE texto LIKE ?) AS X";
$query = $mistake->prepare($sql);
$query->execute(array("%$keyword%","%$keyword%","%$keyword%","%$keyword%","%$keyword%","%$keyword%"));
$Total = $query->fetch();
return $Total['num'];
}
$numitens = totaltag($id);
?>
<br/><div id="titulo"><b>Hashtag #<?php echo $id;?> Encontrados <?php echo $numitens;?> Items
</b></div><br/>
<?php
if($pag=='' || $pag<=0)$pag=1;
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$sql = "SELECT rec,drec,hora,id FROM w_mural WHERE rec LIKE :rec UNION SELECT comentario,por,hr,id FROM w_comentarios WHERE comentario LIKE :comentario UNION SELECT cmt,dono,hora,id FROM w_cmt_fotos WHERE cmt LIKE :cmt UNION SELECT txt,por,dt,id FROM w_posts WHERE txt LIKE :txt UNION SELECT texto,por,data,id FROM bymistake_segredos WHERE texto LIKE :texto UNION SELECT texto,por,data,id FROM bymistake_segredos_cmt WHERE texto LIKE :texto ORDER BY id DESC LIMIT $limit, $itensporpag";
$dados = $mistake->prepare($sql);
$dados->execute(array(":rec" => "%".$id."%",":comentario" => "%".$id."%",":cmt" => "%".$id."%",":txt" => "%".$id."%",":texto" => "%".$id."%",":texto"=> "%".$id."%"));
$i=0; while ($item = $dados->fetch()) { ?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<?php echo online($item[1])>0?gstat($item[1]):$imgoff;?><a href="/<?php echo gerarlogin($item[1]);?>">
<?php echo gerarnome($item[1]);?></a>: <span><?php echo textot($item[0],$meuid,$on);?></span><br/><?php echo date("d/m/Y - H:i:s", $item[2]);?>
</div> <?php $i++; } } else { ?>
<div align="center">Não ah resultados a essa hashtag!</div>  <?php }
if($numpag>1) {
paginas('mural',$a,$numpag,$id,$pag); 
    } } 
else if($a=='historicochatmural') { ativo($meuid,'Vendo hall de bate-papo '); ?>
<br/><div id="titulo"><b>Histórico hall de bate-papo</b></div><br/>
<?php
$contrec = $mistake->query("SELECT count(*) FROM w_mural WHERE tipo='5'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contrec[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->prepare("SELECT * FROM w_mural WHERE tipo='5' ORDER BY id desc LIMIT $limit, $itensporpag");
$itens->execute();
if($itens->rowCount()>0){
$num = 0;
while ($item = $itens->fetch(PDO::FETCH_OBJ)){
$canc = true;
$tempo2 = timepm($item->hora);
$tempo = "".$tempo2[0]." ".$tempo2[1]."";
if($item->drec!=$meuid&&$item->para!=$meuid&&perm($meuid)!=4&&!permdono($meuid)){
if($item->privado!=0){
$canc = false;
}
}
if($canc){
?>
<div id="<?php echo $num%2==0?'div1':'div2';?>">
<?
if(($item->privado==1)&&(($item->drec==$meuid)||($item->para==$meuid)||(perm($meuid)==4) or permdono($meuid))&&$item->para){
?>
<a href="/<?php echo gerarlogin($item->drec);?>"><?php echo gerarnome($item->drec);?></a>
<?php 
if($item->para==0){
}else{
?> 
<b>(reservadamente)</b>
<a href="/<?php echo gerarlogin($item->para);?>"><?php echo gerarnome($item->para);?></a>
<?php 
}
?>
<b>:</b>
<em style="color: <?php echo $item->cor; ?>;background-color:<?php echo $item->contorno; ?>;"><?php echo textot($item->rec,$meuid,$on);?></em> 
<br>
<small>
<div align="right"><small><?php echo $imgtempo;?> há <?php echo "$tempo atr&aacute;s";?></small></div>
</small>
<?php
}else{
if($item->ac==1){
if(!empty($item->resposta)){
?>
<img src="/style/res.png" width="20px" height="20px"><a href="/<?php echo gerarlogin($item->idresposta);?>"><?php echo gerarnome($item->idresposta);?></a> <b>Respondeu</b> <strong style="color:#F00;">
<?php echo textot($item->resposta,$meuid,$on);?>
</strong><br>
<?php 
}else{
}
?>
<a href="/<?php echo gerarlogin($item->drec);?>"><?php echo gerarnome($item->drec);?></a>
<?php 
if($item->para==0){
}else{
?> 
<b><font color='red'><?php echo textot($item->rec,$meuid,$on);?></font></b> 
<a href="/<?php echo gerarlogin($item->para);?>"><?php echo gerarnome($item->para);?></a> 
<?php 
} 
?>
<br>
<small>
<?php 
gosteimural($item->id,$item->hora,'historicochatmural',$meuid); 
?>
</small>
<?
}else{
if($item->drec==0){
?> 
<em style="color: <?php echo $item->cor; ?>;background-color:<?php echo $item->contorno; ?>;"><?php echo $item->rec;?></em> 
<br>
<small>
<div align="right"><small><?php echo $imgtempo;?> há <?php echo "$tempo atr&aacute;s";?></small></div>
</small>
<?
}else{   
if(!empty($item->resposta)){
?>
<img src="/style/res.png" width="20px" height="20px"><a href="/<?php echo gerarlogin($item->idresposta);?>"><?php echo gerarnome($item->idresposta);?></a> <b>Respondeu</b> <strong style="color:#F00;">
<?php echo textot($item->resposta,$meuid,$on);?>
</strong><br>
<?php 
}else{
}
?>
<a href="/<?php echo gerarlogin($item->drec);?>"><?php echo gerarnome($item->drec);?></a>
<?php 
if($item->para==0){
}else{
?> 
<b>Falou Para</b>
<a href="/<?php echo gerarlogin($item->para);?>"><?php echo gerarnome($item->para);?></a> 
<?php 
}
?>
<b>:</b>
<em style="color: <?php echo $item->cor; ?>;background-color:<?php echo $item->contorno; ?>;"><?php echo textot($item->rec,$meuid,$on);?></em>  
<br>
<small>
<?php 
gosteimural($item->id,$item->hora,'historicochatmural',$meuid); 
}
?>
</small>
<?php
}
}
?>
</div>
<?
$num++;
}
}
}
}else{
?>
<div align="center">Não ah historico</div>  <?php }
if($numpag>1) {
paginas('mural',$a,$numpag,$id,$pag);    
} 
}else 
if($a=='recados') {
ativo($meuid,'Vendo mural de recados '); ?>
<br/><div id="titulo"><b>
<?php echo $id==false?'Mural de recados':"Recados de ".gerarnome($id)."";?>
</b></div><br/>
<?php
if($id==false){
$contrec = $mistake->query("SELECT count(*) FROM w_mural WHERE tipo='1'")->fetch();
}else{
$contrec = $mistake->query("SELECT count(*) FROM w_mural where drec='$id' AND tipo='1'")->fetch();
}
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contrec[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
if($id==false){
$itens = $mistake->query("SELECT * FROM w_mural WHERE tipo='1' ORDER BY id desc LIMIT $limit, $itensporpag");
}else{
$itens = $mistake->query("SELECT * FROM w_mural where drec='$id' AND tipo='1' ORDER BY id desc LIMIT $limit, $itensporpag");
}
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<?php echo online($item->drec)>0?gstat($item->drec):$imgoff;?><a href="/<?php echo gerarlogin($item->drec);?>">
<?php echo gerarnome($item->drec);?></a>&ensp;Para&ensp;
<?php if($item->para==0) { echo 'Todos'; } else { echo online($item->para)>0?gstat($item->para):$imgoff;?><a href="/<?php echo gerarlogin($item->para);?>">
<?php echo gerarnome($item->para);?></a><?php } ?>:&ensp;<em style="color: <?php echo $item->cor; ?>;background-color:<?php echo $item->contorno; ?>;"><?php echo textot($item->rec,$meuid,$on);?></em><br/><?php echo date("d/m/Y - H:i:s", $item->hora);?>
<?php 
gosteimural($item->id,$item->hora,'recados',$meuid);
?> 
</div> <?php $i++; } } else { ?>
<div align="center">Não ah recados</div>  <?php }
if($numpag>1) {
paginas('mural',$a,$numpag,$id,$pag);  
 } 
}else 
if($a=='excluircomentario') {
ativo($meuid,'Excluindo comentario'); 
if($pag==true){
if(perm($meuid)>0){
$mistake->exec("DELETE FROM w_comentarios WHERE id='".$id."'");
header('Location:/mural/recados');
} }
?>
<div align="center"><br/>
Tem certeza que deseja excluir este comentario?<br/><br/>
<a href="/mural/excluircomentario/<?php echo $id;?>/<?php echo $id;?>">Sim</a> - 
<a href="/mural/recados">Não</a><br/><br/>
<?php
}else 
if($a=='excluir') {
ativo($meuid,'Excluindo recado do mural '); 
if($pag==true){
$info = $mistake->query("SELECT * FROM w_mural WHERE id='$id'")->fetch();
if(perm($meuid)>0){
$data = date("d/m/Y - H:i:s",time());
$txtt = "deletou o recado [b] ".$info['rec']." [/b], Dono: [b] ".html_entity_decode(gerarnome2($info['drec']))." [/b]. Data: [i] $data [/i] ";
editandopostagem($meuid,$txtt);
$mistake->exec("DELETE FROM w_mural WHERE id='$id'");
$mistake->exec("DELETE FROM w_comentarios WHERE idrec='".$id."'");
header('Location:/mural/recados');
}else{ 
?>
<div align="center">Este recado pertence a <a href="/<?php echo gerarlogin($dele[0]);?>"><?php echo gerarnome($dele[0]);?></a>!
<br/>Apenas poderá ser apagado por el<?php echo (sexo($dele[0])=='M')?('e'):('a')?>
<br/><br/><a href="/home"> <img src='/style/inicio.gif'>
BATE PAPO HALL</a><br><br>
<a href="/inicio?"><?php echo $imginicio;?>Página principal</a><br><br>
<?php echo rodape();?>
</body>
<?php exit(); } }
?>
<div align="center"><br/>
Tem certeza que deseja excluir este recado?<br/><br/>
<a href="/mural/excluir/<?php echo $id;?>/<?php echo $id;?>">Sim</a> - 
<a href="/mural/recados">Não</a><br/><br/>
<?php
}else 
if($a=='acaohall') { 
?>
<br/><div id="titulo"><b>Açoes Hall</b></div><br/>
<?
ativo($meuid,' Enviando acao no hall');
if($_POST['para']==true){
$clean_text = "<img src='/sentimentos/".$_POST['emotion'].".gif'> <small><b style='color:red;'>".$_POST['sentimentos']."</b> </small>";
$res = $mistake->prepare("INSERT INTO w_mural (rec,drec,para,hora,tipo,cor,ac) VALUES (?, ?, ?, ?,?,?,?)");
$arrayName = array($clean_text,$meuid,$_POST['para'],time(),5,'red',1);
$ii = 0;
for($i=1; $i <=7; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute(); 
header('Location:/home');
}
?>
<form align="center" action="/mural/acaohall" method="POST">
<br/><b>Para:</b> <select name="para">
<option value="0">Todos</option>
<?php
$itens = $mistake->prepare("SELECT id, nm FROM w_usuarios WHERE id<>$meuid AND vschat='0' AND inativo>'$inativo' ORDER BY inativo desc");
$itens->execute();
while($item = $itens->fetch(PDO::FETCH_OBJ)) {
?>
<option value="<?php echo $item->id;?>"><?php echo $item->nm;?></option>
<?php
}
?>
</select><center>
<?
echo "<table>";
echo "<td><input type=\"radio\" value=\"1\"  checked=\"checked\" name=\"emotion\" /><img src=\"/sentimentos/1.gif\" /></td>";
echo "<td><input type=\"radio\" value=\"2\" name=\"emotion\" /><img src=\"/sentimentos/2.gif\" /></td>";
echo "<td><input type=\"radio\" value=\"3\" name=\"emotion\" /><img src=\"/sentimentos/3.gif\" /></td>";
echo "<td><input type=\"radio\" value=\"4\" name=\"emotion\" /><img src=\"/sentimentos/4.gif\" /></td>";
echo "<td><input type=\"radio\" value=\"5\" name=\"emotion\" /><img src=\"/sentimentos/5.gif\" /></td>";
echo "</tr>";
echo "<tr>";
echo "</tr>";
echo "</table>";
echo "<table>";
echo "<td><input type=\"radio\" value=\"6\" name=\"emotion\" /><img src=\"/sentimentos/6.gif\" /></td>";
echo "<td><input type=\"radio\" value=\"7\" name=\"emotion\" /><img src=\"/sentimentos/7.gif\" /></td>";
echo "<td><input type=\"radio\" value=\"8\" name=\"emotion\" /><img src=\"/sentimentos/8.gif\" /></td>";
echo "<td><input type=\"radio\" value=\"9\" name=\"emotion\" /><img src=\"/sentimentos/9.gif\" /></td>";
echo "<td><input type=\"radio\" value=\"10\" name=\"emotion\" /><img src=\"/sentimentos/10.gif\" /></td>";
echo "</tr>";
echo "<tr>";
echo "</tr>";
echo "</table>";
echo "<table>";
echo "<td><input type=\"radio\" value=\"11\" name=\"emotion\" /><img src=\"/sentimentos/11.gif\" /></td>";
echo "<td><input type=\"radio\" value=\"12\" name=\"emotion\" /><img src=\"/sentimentos/12.gif\" /></td>";
echo "<td><input type=\"radio\" value=\"13\" name=\"emotion\" /><img src=\"/sentimentos/13.gif\" /></td>";
echo "<td><input type=\"radio\" value=\"14\" name=\"emotion\" /><img src=\"/sentimentos/14.gif\" /></td>";
echo "<td><input type=\"radio\" value=\"15\" name=\"emotion\" /><img src=\"/sentimentos/15.gif\" /></td>";
echo "</tr>";
echo "<tr>";
echo "</tr>";
echo "</table>";
echo "<table>";
echo "<td><input type=\"radio\" value=\"16\" name=\"emotion\" /><img src=\"/sentimentos/16.gif\" /></td>";
echo "<td><input type=\"radio\" value=\"17\" name=\"emotion\" /><img src=\"/sentimentos/17.gif\" /></td>";
echo "<td><input type=\"radio\" value=\"18\" name=\"emotion\" /><img src=\"/sentimentos/18.gif\" /></td>";
echo "<td><input type=\"radio\" value=\"19\" name=\"emotion\" /><img src=\"/sentimentos/19.gif\" /></td>";
echo "<td><input type=\"radio\" value=\"20\" name=\"emotion\" /><img src=\"/sentimentos/20.gif\" /></td>";
echo "</tr>";
echo "<tr>";
echo "</tr>";
echo "</table>";
echo "<table>";
echo "<td><input type=\"radio\" value=\"21\" name=\"emotion\" /><img src=\"/sentimentos/21.gif\" /></td>";
echo "<td><input type=\"radio\" value=\"22\" name=\"emotion\" /><img src=\"/sentimentos/22.gif\" /></td>";
echo "<td><input type=\"radio\" value=\"23\" name=\"emotion\" /><img src=\"/sentimentos/23.gif\" /></td>";
echo "<td><input type=\"radio\" value=\"24\" name=\"emotion\" /><img src=\"/sentimentos/24.gif\" /></td>";
echo "<td><input type=\"radio\" value=\"25\" name=\"emotion\" /><img src=\"/sentimentos/25.gif\" /></td>";
echo "</tr>";
echo "<tr>";
echo "</tr>";
echo "</table>";
echo "<table>";
echo "<td><input type=\"radio\" value=\"26\" name=\"emotion\" /><img src=\"/sentimentos/26.gif\" /></td>";
echo "<td><input type=\"radio\" value=\"27\" name=\"emotion\" /><img src=\"/sentimentos/27.gif\" /></td>";
echo "<td><input type=\"radio\" value=\"28\" name=\"emotion\" /><img src=\"/sentimentos/28.gif\" /></td>";
echo "<td><input type=\"radio\" value=\"29\" name=\"emotion\" /><img src=\"/sentimentos/29.gif\" /></td>";
echo "<td><input type=\"radio\" value=\"30\" name=\"emotion\" /><img src=\"/sentimentos/30.gif\" /></td>";
echo "</tr>";
echo "<tr>";
echo "</tr>";
echo "</table>";
echo "<table>";
echo "<td><input type=\"radio\" value=\"31\" name=\"emotion\" /><img src=\"/sentimentos/31.gif\" /></td>";
echo "<td><input type=\"radio\" value=\"32\" name=\"emotion\" /><img src=\"/sentimentos/32.gif\" /></td>";
echo "<td><input type=\"radio\" value=\"33\" name=\"emotion\" /><img src=\"/sentimentos/33.gif\" /></td>";
echo "<td><input type=\"radio\" value=\"34\" name=\"emotion\" /><img src=\"/sentimentos/34.gif\" /></td>";
echo "<td><input type=\"radio\" value=\"35\" name=\"emotion\" /><img src=\"/sentimentos/35.gif\" /></td>";
echo "</tr>";
echo "<tr>";
echo "</tr>";
echo "</table>";
echo "<br/>";
echo "<select name=\"sentimentos\">";
echo"<option value='Deu boas vindas para'>Dar Boas vindas</option>";
echo"<option value='Deu um abraco em'> Abraco</option>";
echo"<option value='Convidou Para Almoçar'> Convidar Para Almoçar</option>";
echo"<option value='Deu um beliscao em'>Dar um beliscao</option>";
echo"<option value='Fez caricias em'>Fazer Caricias</option>";
echo"<option value='Puxou o cabelo de'>Puxar cabelo</option>";
echo"<option value='Deu um chute em'>Dar chute</option>";
echo"<option value='Deu um refrigerante para'>Dar refrigerante</option>";
echo"<option value='Deu uma cerveja para'>Dar cerveja</option>";
echo"<option value='Deu flores para'>Dar flores</option>";
echo"<option value='Desejou Feliz Aniversário Para'>Felicitar</option>";
echo"<option value='Deu um soco em'>Dar soco</option>";
echo"<option value='Deu chocolates para'>Dar chocolates</option>";
echo"<option value='Apertou a mao de'>Apertar a mao </option>";
echo"<option value='Pediu perdao para'>Pedir Perdao</option>";
echo"<option value='Deu parabens para'>Felicitar</option>";
echo"<option value='Disse obrigado para'>Dizer obrigado</option>";
echo"<option value='Disse te quero para'>Dizer te quero</option>";
echo"<option value='Disse te amo para'>Dizer te amo</option>";
echo"<option value='Disse te adoro para'>Dizer te adoro</option>";
echo"<option value='Deu selinho em'>Dar selinho</option>";
echo"<option value='Beijou na boca de'>Beijar a boca</option>";
echo"<option value='Beijou de lingua'>Beijar de lingua</option>";
echo"<option value='Deu uma mordida em'>Dar mordida</option>";
echo"<option value='Enforcou '>Enforcar</option>";
echo"<option value='Pediu em namoro'>Pedir em namoro</option>";
echo"<option value='Xingou'>Xingar</option>";
echo"<option value='Fez as pazes com'>Fazer as pazes</option>";
echo"<option value='Pediu uma chance para'>Pedir uma chance</option>";
echo"<option value='Sentou no pau de'>Sentou no pau</option>";
echo"<option value='Alisou a buceta de'>Alisou a buceta</option>";
echo"<option value='Chupou o pau de'>Chupou o pau</option>";
echo"<option value='Pegou nos seios de'>Pegou nos seios</option>";
echo"<option value='Pegou na bunda de'>Pegou na bunda</option>"; 
echo"<option value='Chamou pra moita'>Chamou pra moita</option>";
echo"<option value='Me faz gozar delícia'>Me faz gozar delícia</option>";
echo"<option value='Vamos fazer sexofone'>Vamos fazer sexofone</option>"; 
echo"<option value='Se faz de doido (a)não'>Se faz de doido (a)não</option>"; 
echo"<option value='Tirou a Roupa de'>Tirou a Roupa</option>";
echo"<option value='Casa comigo sei fazer Miojo'>Casa comigo sei fazer Miojo</option>";
echo"<option value='Vem nene'>Vem nene</option>";
echo"<option value='Vamos para o Motel'>Vamos para o Motel</option>";
echo"<option value='Que Foda Gostosa,quero Mais'>Que Foda Gostosa,quero Mais</option>";
echo"<option value='Safada (o)'>Safada (o)</option>";
echo"<option value='Ajoelhou tem que rezar'>Ajoelhou tem que rezar</option>";
echo"<option value='Chamou de BB tem que cuidar'>Chamou de BB tem que cuidar</option>";
echo"<option value='Vc me faz DELIRAR'>Vc me faz DELIRAR</option>";
echo"<option value='Proibido é mas gostoso'>Proibido é mas gostoso</option>";
echo"<option value='Vem saciar meu Desejo'>Vem saciar meu Desejo</option>";
echo"<option value='Sentou e rebolou no pau de'>Sentou e rebolou no pau</option>";
echo"<option value='Tomou seu remedinho Hj?'>Tomou seu remedinho Hj?</option>";
echo"<option value='Vou rir devagar,que é pra durar mais'>Vou rir devagar,que é pra durar mais</option>";
echo"<option value='Hum interessante'>Hum interessante</option>";
echo"<option value='Já acabou Jessica'>Já acabou Jessica</option>";
echo"<option value='Ta seca mísera?'>Ta seca mísera?</option>";
echo"<option value='Que burro da Zero pra Ele (ela)'>Que burro da Zero pra Ele (ela)</option>";
echo"<option value='É Proibido mas se quiser pode'>É Proibido mas se quiser pode</option>";
echo"<option value='Fazer carinho?'>Fez carinho em?</option>";
echo"<option value='Fazer cafuné?'>Fez cafuné em?</option>";
echo "</select><br/><input class='bt3' type='submit' value='Publicar'/></form>";
echo "</center>";
}else
if($a=='recado') { 
ativo($meuid,' Enviando recado no mural '); ?>
<br/><div id="titulo"><b>Enviar recado</b></div><br/>
<div align="center">
<br />
<?php
$limite = $mistake->query("SELECT COUNT(*) FROM w_mural WHERE drec='$meuid' and hora>'".(time()-86400)."'")->fetch();
if (pts($meuid)>49) { echo gerarnome($meuid); ?>, não faça publicidades no mural, são permitidos <?php echo $testearray[50];?> emoções por recado!<br/><br/>
<?php if ($limite[0]==0) { ?>
Você não enviou nenhum recado nas ultimas 24 horas!
<?php } else if ($limite[0]==1) { ?>
Você só enviou <?php echo $limite[0];?> recado nas ultimas 24 horas!
<?php } else if ($limite[0]<3) { ?>
Você enviou <?php echo $limite[0];?> recados nas ultimas 24 horas!
<?php } else if ($limite[0]>2) { ?>
Você enviou <?php echo $limite[0];?> recados nas ultimas 24 horas!
<?php } ?>
<br/><br/><form action="/mural/enviar" method="post" enctype="multipart/form-data">
<?php
$flood = $mistake->query("SELECT max(hora) FROM w_mural WHERE tipo='1'")->fetch();
$pmfl = $flood[0]+30;
$time8 = time();
$test = $pmfl - $time8;
$test2 = 1;
if($pmfl>$time8){
if($test==$test2){ 
?>
falta <?php echo $test;?> segundo para a permição do próximo envio
<?php } else { ?>
ainda faltam <?php echo $test;?> segundos para a permição do próximo envio
<?php } } else { ?>
envio liberado
<?php } ?>
<br/>Texto:<br/>
<textarea style="width:-webkit-fill-available" name="rec" maxlength="2000" class="inserirtexto" rows="5" cols="25"></textarea><br/>
<br /><img src="/imgs/font.png"><input type="checkbox" value="1" name="negrito"/><b>b</b><input type="checkbox" value="2" name="italico"/><i>i</i><input type="checkbox" value="3" name="riscado"/><u>u</u><input type="checkbox" value="4" name="grande"/><big>big</big><br/>
<div class="upload-btn-wrapper"><button class="btn"><i class="bt_upload"></i></button><input type="file" name="arquivo" id="arquivo" /></div><div class="color-btn-wrapper"><button class="btn"><i class="bt_color"></i></button><input type="color" name="cortexto" value="#000000"></div><div class="color-btn-wrapper"><button class="btn"><i class="bt_color"></i></button><input type="color" name="contorno" value="#000000"></div><div style="display: inline-block"><button id="chat-gif-selector" href="javascript:void(0)" class="btn gif-selector">
<i class="gif-icon"></i>
<div class="chat-gif-box gif-box">
<div class="gif-box-head">
<span>GIF</span>
<i class="gif-box-close-button ion-close">&times;</i>
</div>
<div class="gif-box-body">
<input type="text" class="form-control chat-gif-search-input gif-search-input" placeholder="Busca GIF"/>
<div class="gif-search-result"></div>
</div>
<div class="gif-box-arrow"></div>
</div>
</button></div>
<br/><br/>Para amigo:<br/><input type="number" name="para">
<br/><br/>
<input type="hidden" class="feed-editor-gif-value" name="gif" value="">
<input type="submit" value="Enviar">
</form>
<?php } else { ?>
Você precisa no mínimo de 50 pontos para enviar um recado no mural
<?php }  
?>
<br />
<?php
}
else if($a=='recado_equipe') { ativo($meuid,' Enviando recado no mural '); ?>
<br/><div id="titulo"><b>Enviar recado</b></div><br/>
<div align="center">
<br />
<?php
$limite = $mistake->query("SELECT COUNT(*) FROM w_mural WHERE drec='$meuid' and hora>'".(time()-86400)."'")->fetch();
if (pts($meuid)>49) { echo gerarnome($meuid); ?>, não faça publicidades no mural, são permitidos <?php echo $testearray[51];?> emoções por recado!<br/><br/>
<?php if ($limite[0]==0) { ?>
Você não enviou nenhum recado nas ultimas 24 horas!
<?php } else if ($limite[0]==1) { ?>
Você só enviou <?php echo $limite[0];?> recado nas ultimas 24 horas!
<?php } else if ($limite[0]<3) { ?>
Você enviou <?php echo $limite[0];?> recados nas ultimas 24 horas!
<?php } else if ($limite[0]>2) { ?>
Você enviou <?php echo $limite[0];?> recados nas ultimas 24 horas!
<?php } ?>
<br/><br/><form action="/mural/enviar3" method="post" enctype="multipart/form-data">
<?php
$flood = $mistake->query("SELECT max(hora) FROM w_mural")->fetch();
$pmfl = $flood[0]+30;
$time8 = time();
$test = $pmfl - $time8;
$test2 = 1;
if($pmfl>$time8)
{
if($test==$test2)
{ ?>
falta <?php echo $test;?> segundo para a permição do próximo envio
<?php } else { ?>
ainda faltam <?php echo $test;?> segundos para a permição do próximo envio
<?php } } else { ?>
envio liberado
<?php } ?>
<br/><br/>Texto:<br/>
<textarea style="width:-webkit-fill-available" name="rec" maxlength="2000" class="inserirtexto" rows="5" cols="25"></textarea><br/>
<br /><img src="/imgs/font.png"><input type="checkbox" value="1" name="negrito"/><b>b</b><input type="checkbox" value="2" name="italico"/><i>i</i><input type="checkbox" value="3" name="riscado"/><u>u</u><input type="checkbox" value="4" name="grande"/><big>big</big><br/>
<div class="upload-btn-wrapper"><button class="btn"><i class="bt_upload"></i></button><input type="file" name="arquivo" id="arquivo" /></div><div class="color-btn-wrapper"><button class="btn"><i class="bt_color"></i></button><input type="color" name="cortexto" value="#000000"></div><div class="color-btn-wrapper"><button class="btn"><i class="bt_color"></i></button><input type="color" name="contorno" id="cortexto" value="#000000"></div><div style="display: inline-block"><button id="chat-gif-selector" href="javascript:void(0)" class="btn gif-selector">
<i class="gif-icon"></i>
<div class="chat-gif-box gif-box">
<div class="gif-box-head">
<span>GIF</span>
<i class="gif-box-close-button ion-close">&times;</i>
</div>
<div class="gif-box-body">
<input type="text" class="form-control chat-gif-search-input gif-search-input" placeholder="Busca GIF"/>
<div class="gif-search-result"></div>
</div>
<div class="gif-box-arrow"></div>
</div>
</button></div>
<br/><br/>
<input type="hidden" class="feed-editor-gif-value" name="gif" value="">
<input type="submit" value="Enviar">
</form>
<?php } else { ?>
Você precisa no mínimo de 50 pontos para enviar um recado no mural
<?php }  
?>
<br />
<?php
} else if($a=='recado_divulgacao') { ativo($meuid,' Enviando recado no mural '); ?>
<br/><div id="titulo"><b>Enviar recado</b></div><br/>
<div align="center">
<br />
<?php
$limite = $mistake->query("SELECT COUNT(*) FROM w_mural WHERE drec='$meuid' and hora>'".(time()-86400)."'")->fetch();
if (pts($meuid)>49) { echo gerarnome($meuid); ?>, não faça publicidades no mural, são permitidos <?php echo $testearray[51];?> emoções por recado!<br/><br/>
<?php if ($limite[0]==0) { ?>
Você não enviou nenhum recado nas ultimas 24 horas!
<?php } else if ($limite[0]==1) { ?>
Você só enviou <?php echo $limite[0];?> recado nas ultimas 24 horas!
<?php } else if ($limite[0]<3) { ?>
Você enviou <?php echo $limite[0];?> recados nas ultimas 24 horas!
<?php } else if ($limite[0]>2) { ?>
Você enviou <?php echo $limite[0];?> recados nas ultimas 24 horas!
<?php } ?>
<br/><br/><form action="/mural/enviar2" method="post" enctype="multipart/form-data">
<?php
$geral = $mistake->prepare("SELECT * FROM w_geral where id='1'");
$geral->execute();
$geral = $geral->fetch();
$flood = $mistake->query("SELECT max(hora) FROM w_mural")->fetch();
$pmfl = $flood[0]+30;
$time8 = time();
$test = $pmfl - $time8;
$test2 = 1;
if($pmfl>$time8){
if($test==$test2){ 
?>
falta <?php echo $test;?> segundo para a permição do próximo envio
<?php } else { ?>
ainda faltam <?php echo $test;?> segundos para a permição do próximo envio
<?php } } else { ?>
envio liberado
<?php } ?>
<br /><br /><strong>Esse mural vale pontos?</strong><br /><br />
Número de pontos: <input type="number" name="pontos" min="0" max="999" value="0"><br/><br/>
Razão dos pontos: <input name="razao" maxlength="50" value="0"><br/><br/>
Caso o mural não esteja valendo pontos deixe os dois campos acima com 0!<br /><br />
<?php if($testearray[21]==true) {?>Obs: Não colocar dois murais com mesmo horario <br /><br />Inicio:&emsp;&emsp;&emsp;&emsp;&emsp;Fim:<br /><input type="time" step='1' name="inicio" min="00:00:01" value="<?php echo date("H:i:s");?>"><input type="time" step='1' name="fim" min="00:00:01" value="<?php echo date('H:i:s',strtotime('+1 hour'));?>"><br /><br /><?}else{?><input type="hidden" name="inicio" value="<?php echo date("H:i:s");?>"><input type="hidden" name="fim" value="<?php echo date('H:i:s',strtotime('+1 hour'));?>"><?}?>
<br/>Texto:<br/>
<textarea style="width:-webkit-fill-available" name="rec" maxlength="2000" class="inserirtexto" rows="5" cols="25"></textarea><br/>
<br /><img src="/imgs/font.png"><input type="checkbox" value="1" name="negrito"/><b>b</b><input type="checkbox" value="2" name="italico"/><i>i</i><input type="checkbox" value="3" name="riscado"/><u>u</u><input type="checkbox" value="4" name="grande"/><big>big</big><br/>
<div class="upload-btn-wrapper"><button class="btn"><i class="bt_upload"></i></button><input type="file" name="arquivo" id="arquivo" /></div><div class="color-btn-wrapper"><button class="btn"><i class="bt_color"></i></button><input type="color" name="cortexto" value="#000000"></div><div class="color-btn-wrapper"><button class="btn"><i class="bt_color"></i></button><input type="color" name="contorno" value="#000000"></div><div style="display: inline-block"><button id="chat-gif-selector" href="javascript:void(0)" class="btn gif-selector">
<i class="gif-icon"></i>
<div class="chat-gif-box gif-box">
<div class="gif-box-head">
<span>GIF</span>
<i class="gif-box-close-button ion-close">&times;</i>
</div>
<div class="gif-box-body">
<input type="text" class="form-control chat-gif-search-input gif-search-input" placeholder="Busca GIF"/>
<div class="gif-search-result"></div>
</div>
<div class="gif-box-arrow"></div>
</div>
</button></div>
<br/><br/>
<input type="hidden" class="feed-editor-gif-value" name="gif" value="">
<input type="submit" value="Enviar">
</form>
<?php } else { ?>
Você precisa no mínimo de 50 pontos para enviar um recado no mural
<?php }  
?>
<br />
<?php
}
else if($a=='enviar3') { ativo($meuid,'Enviando recado no mural '); ?>
<br /><div id="titulo"><b>Enviar recado</b></div><br/>
<?php
if(perm($meuid)==0) { ativo($meuid,'Tentando entrar na moderação '); ?>
<div align="center"><br/><?php echo $imgerro;?>Você não é um membro da equipe!
<?php }else{ ?>
<div align="center"><br/>
<?php
$flood = $mistake->query("SELECT max(hora) FROM w_mural")->fetch();
$pmfl = $flood[0]+30;
$time8 = time();
$sml = textot($_POST['rec'],$meuid,$on);
$nos = substr_count($sml,"<img src=");
if($nos>$testearray[51]) { 
echo "".$imgerro." Limite máximo de ".$testearray[51]." emoções por recado!";
} else if (empty($_POST['rec'])) {
echo $imgerro;?>
Digite algum texto!
<?php
}else {
if(mb_strlen ($_POST['rec']) > $testearray[60]){
echo $imgerro;?>
Limite de texto atingido!
<?php
}else{
$text = nl2br(emoji_unified_to_html($text));	
$res = $mistake->prepare("INSERT INTO w_mural (rec,drec,hora,tipo,cor,contorno) VALUES (?,?,?,?,?,?)");
$arrayName = array($text.$gif,$meuid,time(),3,$_POST['cortexto'],$contorno);
$ii = 0;
for($i=1; $i <=6; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
if($res) { echo $imgok;?>
Recado enviado com sucesso
<?php } else { echo $imgerro;?>
Erro ao enviar recado
<?php } } }
}
?>
<br />
<?php
}
else if($a=='enviar2') { ativo($meuid,'Enviando recado no mural '); ?>
<br /><div id="titulo"><b>Enviar recado</b></div><br/>
<?php
if(perm($meuid)==0) { ativo($meuid,'Tentando entrar na moderação '); ?>
<div align="center"><br/><?php echo $imgerro;?>Você não é um membro da equipe!
<?php }else{ ?>
<div align="center"><br/>
<?php
$flood = $mistake->query("SELECT max(hora) FROM w_mural")->fetch();
$pmfl = $flood[0]+30;
$time8 = time();
$sml = textot($_POST['rec'],$meuid,$on);
$nos = substr_count($sml,"<img src=");
if($nos>$testearray[51]) { 
echo "".$imgerro." Limite máximo de ".$testearray[51]." emoções por recado!";
} else 
if (empty($_POST['rec'])) {
echo $imgerro;?>
Digite algum texto!
<?php
}else {
$text = nl2br(emoji_unified_to_html($text));   
if(isspam($text,$meuid)) {
$mistake->exec("UPDATE w_usuarios SET bchat3='4' WHERE id='".$meuid."'");  
$res = $mistake->prepare("INSERT INTO Mmistake_logs (texto,meuid,para,acao,data) VALUES (?,?,?,?,?)");
$arrayName = array($text,$meuid,$newid,'mural',time());
$ii = 0;
for($i=1; $i <=5; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
}else{    
if(mb_strlen ($_POST['rec']) > $testearray[60]){
echo $imgerro;?>
Limite de texto atingido!
<?php
}else{
$inicio = isset($_POST['inicio']) ? $_POST['inicio'] : 0;
$fim = isset($_POST['fim']) ? $_POST['fim'] : 0;
$res = $mistake->prepare("INSERT INTO w_mural (rec,drec,hora,tipo,cor,pontos,razao,inicio,fim,contorno) VALUES (?,?,?,?,?,?,?,?,?,?)");
$arrayName = array($text.$gif,$meuid,time(),2,$_POST['cortexto'],$_POST['pontos'],$_POST['razao'],$inicio,$fim,$contorno);
$ii = 0;
for($i=1; $i <=10; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
}
if($res) { echo $imgok;?>
Recado enviado com sucesso
<?php } else { echo $imgerro;?>
Erro ao enviar recado
<?php } } }
}
?>
<br />
<?php
}
else if($a=='pensamento') { ativo($meuid,'Enviando recado no mural '); ?>
<br /><div id="titulo"><b>Enviar Pensamento</b></div><br/>
<div align="center"><br/>
<?php
$sml = textot($_POST['rec'],$meuid,$on);
$text = anti_injection($_POST['rec']);
$text = nl2br(emoji_unified_to_html($text));
$nos = substr_count($sml,"<img src=");
$time_foood = time()-20;
$anti_repeticao = $mistake->query("SELECT COUNT(*) FROM w_mural WHERE drec='$meuid' AND hora>'".$time_foood."'")->fetch();
if($nos>$testearray[49]) { 
echo "".$imgerro." Limite máximo de ".$testearray[49]." emoções por recado!";
 }  else if($anti_repeticao[0]>0) {
?>
Aguarde o tempo do mural!
<?php
} else if (empty($_POST['rec'])) {
echo $imgerro;?>
Digite algum texto!
<?php
}else {
if(isspam($text,$meuid)) {
$mistake->exec("UPDATE w_usuarios SET bchat3='4' WHERE id='".$meuid."'");  
$res = $mistake->prepare("INSERT INTO Mmistake_logs (texto,meuid,para,acao,data) VALUES (?,?,?,?,?)");
$arrayName = array($text,$meuid,$newid,'mural',time());
$ii = 0;
for($i=1; $i <=5; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
}else{   
if(mb_strlen ($_POST['rec']) > $testearray[60]){
echo $imgerro;?>
Limite de texto atingido!
<?php
}else{
$res = $mistake->prepare("INSERT INTO w_mural (rec,drec,hora,tipo) VALUES (?, ?, ?,?)");
$arrayName = array($text.$gif,$meuid,time(),4);
$ii = 0;
for($i=1; $i <=4; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
}
if($res) { echo $imgok;?>
Pensamento enviado com sucesso
<?php header('Location:/mural/pensamentos'); ?>
<?php } else { echo $imgerro;?>
Erro ao enviar pensamento
<?php } } }
?>
<br />
<?php
} 
else if($a=='enviar') { ativo($meuid,'Enviando recado no mural '); ?>
<br /><div id="titulo"><b>Enviar recado</b></div><br/>
<div align="center"><br/>
<?php
$flood = $mistake->query("SELECT max(hora) FROM w_mural WHERE tipo='1'")->fetch();
$pmfl = $flood[0]+30;
$time8 = time();
$sml = textot($_POST['rec'],$meuid,$on);
$time_foood = time()-20;
$anti_repeticao = $mistake->query("SELECT COUNT(*) FROM w_mural WHERE drec='$meuid' AND hora>'".$time_foood."'")->fetch();
$nos = substr_count($sml,"<img src=");
if($nos>$testearray[50]) { 
echo "".$imgerro." Limite máximo de ".$testearray[50]." emoções por recado!";
} else if($anti_repeticao[0]>0) {
?>
Aguarde o tempo do mural!!
<?php
}else if($pmfl>$time8) { echo $imgerro;?>
Um recado acabou de ser adicionado, aguarde!
<?php } else if (empty($_POST['rec'])) {
echo $imgerro;?>
Digite algum texto!
<?php
}else {
$text = nl2br($text);		
if(isspam($text,$meuid)) {
$mistake->exec("UPDATE w_usuarios SET bchat3='4' WHERE id='".$meuid."'");  
$res = $mistake->prepare("INSERT INTO Mmistake_logs (texto,meuid,para,acao,data) VALUES (?,?,?,?,?)");
$arrayName = array($text,$meuid,$_POST['para'],'mural',time());
$ii = 0;
for($i=1; $i <=5; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
}else{
if(mb_strlen ($_POST['rec']) > $testearray[60]){
echo $imgerro;?>
Limite de texto atingido!
<?php
}else{
if($_POST['para']>0){
$para = $_POST['para'];	  
$msg = "Olá [b] ".html_entity_decode(gerarnome2($_POST['para']))." [/b] te marquei no mural.";
automsg($msg,$meuid,$_POST['para']);    
}else{
$para = 0;
}    
$clean_text = emoji_unified_to_html($text);
$res = $mistake->prepare("INSERT INTO w_mural (rec,drec,para,hora,tipo,cor,contorno) VALUES (?,?,?,?,?,?,?)");
$arrayName = array($clean_text.$gif,$meuid,$para,time(),1,$_POST['cortexto'],$contorno);
$ii = 0;
for($i=1; $i <=7; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
}
if($res) {  
if($testearray[21]==true) { 
$muralauto = "AND '".date("H:i:s")."' >= inicio AND '".date("H:i:s")."' < fim";    
}else{
$muralauto = "";    
}
$pont = $mistake->query("SELECT * FROM w_mural WHERE tipo='2' $muralauto ORDER BY id DESC limit 1")->fetch();
if($pont['pontos']>0){
$mistake->exec("UPDATE w_usuarios SET pt=pt+ ".$pont['pontos']." WHERE id='$meuid'");
$nav = explode(" ",$_SERVER['HTTP_USER_AGENT'] );
$mistake->exec("INSERT INTO w_pontos (uid,aid,hr,rz,ip,nv,dt,pt) values('".$pont['drec']."','$meuid','".time()."','".$pont['razao']."','".gerarip()."','".$nav[0]."','1','".$pont['pontos']."')");
}
echo $imgok;?>
Recado enviado com sucesso
<?php } else { echo $imgerro;?>
Erro ao enviar recado
<?php } } }
?>
<br />
<?php
}else 
if($a=='curtiu'){
ativo($meuid,' vendo curtiu de mural '); 
?>
<br/><div id="titulo"><b>Curtidas</b></div><br/>
<?php
$contrec = $mistake->query("SELECT count(*) FROM w_comentarios_logs WHERE idrecado='".$id."'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contrec[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->query("SELECT * FROM w_comentarios_logs WHERE idrecado='".$id."' ORDER BY id desc LIMIT $limit, $itensporpag");
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<?php 
echo online($item->meuid)>0?gstat($item->meuid):$imgoff;
?>
<a href="/<?php echo gerarlogin($item->meuid);?>">
<?php 
echo gerarnome($item->meuid);?></a> clicou em 
<?php if($item->carinha==1) { ?> <img src='/images/reacoes/curtir.png' alt='Curtir' title='Curtir' width='20px' height='20px' /><?php } ?> 
<?php if($item->carinha==2) { ?> <img src='/images/reacoes/amei.png' alt='Amei' title='Amei' width='20px' height='20px' /> <?php } ?> 
<?php if($item->carinha==3) { ?> <img src='/images/reacoes/haha.png' alt='Haha' title='Haha' width='20px' height='20px' /><?php } ?> 
<?php if($item->carinha==4) { ?> <img src='/images/reacoes/uau.png' alt='Uau' title='Uau' width='20px' height='20px' /><?php } ?> 
<?php if($item->carinha==5) { ?> <img src='/images/reacoes/triste.png' alt='Triste' title='Triste' width='20px' height='20px' /><?php } ?> 
<?php if($item->carinha==6) { ?> <img src='/images/reacoes/grr.png' alt='Grr' title='Grr' width='20px' height='20px' /><?php } 
?>
</div> 
<?php $i++; } } else { ?>
<div align="center">Não ah curtidas</div>  <?php }
if($numpag>1) {
paginas('mural',$a,$numpag,$id,$pag);
} 
}else 
if($a=='editar') { ativo($meuid,' Editando recado no mural '); ?>
<br/><div id="titulo"><b>Editar recado</b></div><br/>
<?php $recc = $mistake->query("SELECT * FROM w_mural WHERE id='$id'")->fetch();
if($recc['drec']==$meuid OR perm($meuid)>0) { 
?>
<form action="/mural/editar2/<?php echo $id;?>" method="post">
<div style="text-align:center">
<textarea style="width:-webkit-fill-available" name='rec'><?php echo $recc['rec'];?></textarea><br />
<?
if($_GET['pag']=='divulgacao'){
if($testearray[21]==true) { 
?>
Número de pontos: <input type="number" name="pontos" min="0" max="999" value="<?php echo $recc['pontos'];?>"><br/>
Razão dos pontos: <input name="razao" maxlength="50" value="<?php echo $recc['razao'];?>"><br />
Inicio:&emsp;&emsp;&emsp;&emsp;&emsp;Fim:<br /><input type="time" step='1' name="inicio" min="00:00:01" value="<?php echo $recc['inicio'];?>"><input type="time" step='1' name="fim" min="00:00:01" value="<?php echo $recc['fim'];?>"><br />
<?
}
}
?>
<input type="submit" value="Editar">
</form></div>
<?php } else { ?>
Você não pode editar este recado
<?php } } else if($a=='editar2') { ativo($meuid,' Editando recado no mural '); ?>
<br/><div id="titulo"><b>Editar recado</b></div>
<div align="center"><br/>
<?php 
$info = $mistake->query("SELECT * FROM w_mural WHERE id='$id'")->fetch();
if($info['drec']==$meuid OR perm($meuid)>0) { 
$sml = textot($_POST['rec'],$meuid,$on);
$nos = substr_count($sml,"<img src=");
if($info['tipo']==1){
$ism = $testearray[50];	
}else if($info['tipo']==2 or $info['tipo']==3){ 
$ism = $testearray[51];
}else{
$ism = $testearray[49];	
}
if($nos>$ism) { 
echo "".$imgerro." Limite máximo de ".$ism." emoções por recado!";
}else{
if(isspam($_POST['rec'],$meuid)) {
$mistake->exec("UPDATE w_usuarios SET bchat3='4' WHERE id='".$meuid."'");  
$res = $mistake->prepare("INSERT INTO Mmistake_logs (texto,meuid,para,acao,data) VALUES (?,?,?,?,?)");
$arrayName = array(anti_injection($_POST['rec']),$meuid,0,'mural',time());
$ii = 0;
for($i=1; $i <=5; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
}else{
$data = date("d/m/Y - H:i:s",time());
$txtt = "editou o recado [b] ".$info['rec']." [/b], Dono: [b] ".html_entity_decode(gerarnome2($info['drec']))." [/b]. Data: [i] $data [/i] ";
editandopostagem($meuid,$txtt);
$inicio = isset($_POST['inicio']) ? $_POST['inicio'] : 0;
$fim = isset($_POST['fim']) ? $_POST['fim'] : 0;
$razao = isset($_POST['razao']) ? $_POST['razao'] : 0;
$pontos = isset($_POST['pontos']) ? $_POST['pontos'] : 0;
$update = $mistake->prepare("UPDATE w_mural SET rec = ?,inicio = ?,fim = ?,razao = ?,pontos = ? WHERE id = ?");
$update->execute(array(emoji_unified_to_html(html_entity_decode($_POST['rec'])),$inicio,$fim,$razao,$pontos,$id));
echo $imgok;?> Recado editado com sucesso<br/>
<?php 
}
}
} else { ?>
<?php echo $imgerro;?> Você não pode editar este recado<br/>
<?php } } else {  } ?>
<br/><center><a href="/home"> <img src='/style/inicio.gif'>BATE PAPO HALL</a><br><br></center>
<br/><div align="center"><a href="/inicio?"><?php echo $imginicio;?>Página principal</a><br><br>
<?php echo rodape();?>
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
$('.feed-editor-gif-value').val($(this).data('url').replace('https://media.tenor.com/images/', '[gif=').replace('/tenor.gif', ']'));
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
</body>
</html>