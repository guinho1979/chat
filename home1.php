<?php
require_once("".$_SERVER["DOCUMENT_ROOT"]."/funcoes.php");
require_once("".$_SERVER["DOCUMENT_ROOT"]."/mistake.php");
seg($meuid);
$Hour = date("G");
ativo($meuid,'Página principal');
$amigos = $mistake->prepare("SELECT COUNT(*) FROM w_amigos WHERE (uid='".$meuid."' OR tid='".$meuid."') AND ac='1'");
$amigos->execute();
$amigos = $amigos->fetch();
$pedidos = $mistake->prepare("SELECT COUNT(*) FROM w_amigos WHERE tid='$meuid' AND ac='0'");
$pedidos->execute();
$pedidos = $pedidos->fetch();
$nu = $mistake->prepare("SELECT max(id) FROM w_usuarios WHERE liberado='1'");
$nu->execute();
$nu = $nu->fetch();
$pensa = $mistake->prepare("SELECT COUNT(*) FROM w_mural WHERE tipo='4'");
$pensa->execute();
$pensa = $pensa->fetch();
$comu = $mistake->prepare("SELECT COUNT(*) FROM w_comu");
$comu->execute();
$comu = $comu->fetch();
$emo = $mistake->prepare("SELECT COUNT(*) FROM w_emocoes");
$emo->execute();
$emo = $emo->fetch();
$pmnaolida = $mistake->prepare("SELECT COUNT(*) FROM w_msgs WHERE pr='$meuid' AND ld='0' and dl='0'");
$pmnaolida->execute();
$pmnaolida = $pmnaolida->fetch();
$todaspms = $mistake->prepare("SELECT COUNT(*) FROM w_msgs WHERE pr='$meuid' and dl='0'");
$todaspms->execute();
$todaspms = $todaspms->fetch();
$albuns = $mistake->prepare("SELECT COUNT(*) FROM w_albuns");
$albuns->execute();
$albuns = $albuns->fetch();
$downs = $mistake->prepare("SELECT COUNT(*) FROM w_downs");
$downs->execute();
$downs = $downs->fetch();
$fotos = $mistake->prepare("SELECT COUNT(*) FROM w_fotos");
$fotos->execute();
$fotos = $fotos->fetch();
$segredos = $mistake->prepare("SELECT COUNT(*) FROM bymistake_segredos");
$segredos->execute();
$segredos = $segredos->fetch();
$chaton = $mistake->prepare("SELECT COUNT(*) FROM w_ochat");
$chaton->execute();
$chaton = $chaton->fetch();
$inativo = time()-$testearray[18];
$inativo2 = time()-3600;
$online = $mistake->prepare("SELECT COUNT(*) FROM w_usuarios where inativo>'$inativo'");
$online->execute();
$online = $online->fetch();
$equipe = $mistake->prepare("SELECT COUNT(*) FROM w_usuarios WHERE (perm>'0' or perm2>'0') and mostrastatus='0' and inativo>'$inativo2'");
$equipe->execute();
$equipe = $equipe->fetch();
$vips = $mistake->prepare("SELECT COUNT(*) FROM w_usuarios WHERE vip='1' and inativo>'$inativo'");
$vips->execute();
$vips = $vips->fetch();
$miguxoson = $mistake->prepare("SELECT COUNT(*) FROM w_amigos a inner join w_usuarios b WHERE (a.uid='".$meuid."' OR a.tid='".$meuid."') AND a.ac='1' AND (b.id=a.tid OR b.id=a.uid) AND b.id!='$meuid' and b.inativo>'$inativo'");
$miguxoson->execute();
$miguxoson = $miguxoson->fetch();
$cma = $mistake->prepare("SELECT COUNT(*) FROM w_comu_m a, w_comu b where b.dn='$meuid' and b.id=a.cm and a.ac='0'");
$cma->execute();
$cma = $cma->fetch();
$perguntas = $mistake->prepare("SELECT count(*) FROM w_pergunte_me where para='$meuid'");
$perguntas->execute();
$perguntas = $perguntas->fetch();
//$on = $mistake->prepare("SELECT COUNT(*) FROM Mmistake_online");
//$on->execute();
//$on = $on->fetch();
$topicos = $mistake->prepare("SELECT COUNT(*) FROM w_topicos");
$topicos->execute();
$topicos = $topicos->fetch();
$posts = $mistake->prepare("SELECT COUNT(*) FROM w_posts");
$posts->execute();
$posts = $posts->fetch();
$comu = $mistake->prepare("SELECT COUNT(*) FROM w_comu");
$comu->execute();
$comu = $comu->fetch();
$conton = $mistake->prepare("SELECT COUNT(*) FROM w_ochat");
$conton->execute();
$conton = $conton->fetch();
$total_perguntas3 = $mistake->prepare("SELECT COUNT(*) FROM w_pergunte_me WHERE para='$meuid' AND resposta<'0'");
$total_perguntas3->execute();
$total_perguntas3 = $total_perguntas3->fetch();
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
setcookie('hall',null, -1, '/');
unset($_COOKIE['hall']);
$clean_text = "</span> Saiu Do Hall <a href='/".gerarlogin($meuid)."'> ".gerarnome($meuid)." </a>";
$res = $mistake->prepare("INSERT INTO w_mural (rec,hora,tipo) VALUES (?, ?, ?)");
$arrayName = array($clean_text,time(),5);
$ii = 0;
for($i=1; $i <=3; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
header('Location:/home');
}else if($a=='mostrar') {
$res = $mistake->exec("update w_usuarios set vschat='0' where id='$meuid'");
$clean_text = "</span> Entrou no Hall <a href='/".gerarlogin($meuid)."'> ".gerarnome($meuid)." </a>";
$res = $mistake->prepare("INSERT INTO w_mural (rec,hora,tipo) VALUES (?, ?, ?)");
$arrayName = array($clean_text,time(),5);
$ii = 0;
for($i=1; $i <=3; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
setcookie('hall',$meuid,(time() + (86400 * 7)), '/');
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
if($i[6]==1) { 
$itens = $mistake->prepare("SELECT * FROM w_visitas WHERE aid='$meuid' ORDER BY hr DESC LIMIT 5");
$itens->execute();
if($itens->rowCount()>0){
?>
<div align="center" id="barra_mural">
<small>Últimas visitas no seu perfil</small><br/>
<?php    
while ($item = $itens->fetch(PDO::FETCH_OBJ)) {
?>
<a href='/<?php echo gerarlogin($item->uid);?>'> <?php echo gerarfoto($item->uid);?></a>
<?php
}
?>
</div>
<?php
}
}
?>
<div align="center">
<?
if($i[1]==1) {
?>
<?php echo $testearray[30] ? "<img src='/style/".$testearray[30]."' style='max-width:100%;max-height:200px' alt='logo'>" : "";?>
<?php
}
?>
</div>
<?php
if($i[2]==1) { 
if($testearray[15]==true) { 
echo "<br><div align='center'>".textot($testearray[15],$meuid,$on)."</div>";
} 
} 
?>
<div align="center">
<br><?php echo $saldacao; ?> <?php echo online($meuid)>0?gstat($meuid):$imgoff;?><a href="/<?php echo gerarlogin($meuid);?>"><?php echo gerarnome($meuid);?></a>!<br>    
<br><a href="/home/<?php echo time();?>"><img src="/style/atualizar.png" width="20px" height="20px"/></a><br />
</div>
<?php
if(isset($_POST['quizmural'])==TRUE){
$mistake->exec("update w_usuarios set quizmural='1' WHERE id='$meuid'");
}
$info = $mistake->prepare("SELECT * FROM w_usuarios WHERE id='$meuid'");
$info->execute();
$info = $info->fetch();
$quizmural = $mistake->prepare("SELECT * FROM bymistake_quizmural ORDER by id desc limit 1");
$quizmural->execute();
$quizmural = $quizmural->fetch();
 if($quizmural[0]>0 and $info['quizmural']==0){ 
 ?>
 <fieldset><legend><strong>Quiz Mural</strong></legend>
 <table align="center" cellpadding="3" cellspacing="1" bgcolor="">
 <tr><td bgcolor="" align="center">
 <?php echo $quizmural['prg'];?><br/><br/><i style="font-size:small;">Valendo <?php echo $quizmural['pontos'];?> pontos</i><br/><br/>
 <form action="/quizmural" method="post">
  <div align="left">
 <input type="radio" value="1" name="r" /> <?php echo $quizmural['r1'];?><br/>
 <input type="radio" value="2" name="r" /> <?php echo $quizmural['r2'];?><br/>
 <input type="radio" value="3" name="r" /> <?php echo $quizmural['r3'];?><br/><br/>
 <input type="hidden" name="id" value="<?php echo $quizmural['id'];?>" />
 </div>
 <input type="submit" value="Responder" />
 </form>
 <form action="/homepage" method="post">
 <input type="hidden" name="quizmural" value="1" />
 <input type="submit" value="Pular" />
 </form>
 </td></tr></table></fieldset>
 <?php 
 }else{
if($i[5]==1) {
if($testearray[20]=='1'){
$frases = array("1","2","3");
srand ((float)microtime()*1000000);
shuffle ($frases);
$limit = $frases[0];
$mural = $mistake->prepare("SELECT id, rec, drec, para, cor,contorno FROM w_mural WHERE tipo='3' ORDER BY id DESC limit $limit,1");
}else{
$mural = $mistake->prepare("SELECT id, rec, drec, para, cor,contorno FROM w_mural WHERE tipo='3' ORDER BY id DESC limit 1");
}
$mural->execute();
$mural = $mural->fetch();
?>
<div id="barra_mural">Mural da Equipe</div>
<div id="fundo_mural">
<?
if($mural[2]==true){
echo gerarfoto($mural[2]);?> <a href="/<?php echo gerarlogin($mural[2]);?>"><?php echo gerarnome($mural[2]);?></a>:&ensp;
<em style="color: <?php echo $mural[4]; ?>;background-color:<?php echo $mural[5]; ?>;"><?php echo textot($mural[1],$meuid,$on);?></em>
<?
}
?>
<hr>
<a href="/mural/equipe">Mais</a>
<?php  if (perm($meuid)>0) { ?>
, <a href="/mural/recado_equipe">Enviar</a>
, <a href="/mural/excluir/<?php echo $mural[0];?>">Deletar</a>
<?php } ?>
</div>
<?php  
}
} 
if($_COOKIE['hall']==$meuid){
if(uchat($meuid)==1) {
?>
<br/><div align="center"><?php echo $imgerro;?>Você foi bloqueado para acessar o chat.</div><br/>
<?
}else{
$treino="<form action='/homepage' method='post'><input type='hidden' name='sl' value='auto'><select name='tl'><option  value='af'>africanes</option><option  value='de'>alemao</option><option  value='ar'>arabe</option><option  value='bg'>bulgaro</option><option  value='zh-CN'>chines (simplificado)</option><option  value='zh-TW'>chines (tradicional)</option><option  value='ko'>coreano</option><option  value='hr'>croata</option><option  value='da'>dinamarques</option><option  value='sk'>eslovaco</option><option  value='es'>espanhol</option><option  value='fr'>frances</option><option  value='el'>grego</option><option  value='nl'>holandes</option><option  value='en'>ingles</option><option  value='it'>italiano</option><option  value='ja'>japones</option><option  value='pl'>polones</option><option SELECTED value='pt'>portugues</option><option  value='ro'>romeno</option><option  value='ru'>russo</option><option  value='cs'>tcheco</option></select><input type='submit' value='Traduzir'></form>";
?>
<br/><a name="batepapo"></a><fieldset><legend><strong>Hall de Entrada</strong></legend>
<form action="/mural/hall" method="post" enctype="multipart/form-data" id="formID">
<b>Texto:</b><textarea name='rec' maxlength='2000' class='inserirtexto'></textarea>
<br />
<b>Para:</b> <select name="para">
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
</select><br/>
Cor:
<style>
.gif-image{cursor: pointer;}.gif-selector{position: relative}.gif-selector > i{border: solid 1px;border-radius: 4px;padding: 0px 2px;line-height: 14px;font-size: 10px;vertical-align: 2px;display: inline-block}.gif-selector > i:before{content: "GIF"}.gif-box{position: absolute;bottom: 30px;right: 0px;background-color: #FFFFFF;display: none;z-index: 100;border: solid 1px rgba(0, 0, 0, .2);border-radius: 4px}.gif-box-head{padding: 2px 100px;background-color: rgba(0, 0, 0, .1);text-align: center;font-size: 14pt;color: #808080}.gif-box-close-button{position: absolute;top: 0px;right: 6px;font-size: 14pt !important;z-index: 1}.gif-box-arrow{position: absolute;bottom: -10px;right: 4px4pxdth: 0;height: 0;border-left: 10px solid transparent !important;;border-right: 10px solid transparent !important;border-top: 10px solid #CCCCCC}.gif-box-body{padding: 4px}.gif-search-result{width: calc(100% + 2px);height: 300px;overflow: auto}.gif-search-result img{margin: 1px 0px;width: 100%;height: 120px;object-fit: cover}.alt-chat-gif-selector{top: -11px;margin-left: 0px}
</style>
<div style="display: inline-block"><button id="chat-gif-selector" href="javascript:void(0)" class="btn gif-selector">
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
</button></div></center>
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
<div id="opc4"><b><a href="/mural/acaohall"><button><img src="/style/bbb.gif" width="20px" height="20px"/></button></a><a href="/configuracoes/catemocoes"><button><img src="/style/emocoes.gif" width="20px" height="20px"/></button></a><a href="/configuracoes/dicas"><button><img src="/style/bbcode.gif" width="20px" height="20px"/></button></a><a href="/home/<?php echo time();?>#batepapo"><button><img src="/style/atualizar.png" width="20px" height="20px"/></button></a></b></div>
<?php
$itens = $mistake->prepare("SELECT * FROM w_mural WHERE tipo='5' ORDER BY id DESC limit 6");
$itens->execute();
if($itens->rowCount()>0){
$num = 0;
while ($item = $itens->fetch(PDO::FETCH_OBJ)){
$canc = true;
$tempo2 = timepm($item->hora);
$tempo = "".$tempo2[0]." ".$tempo2[1]."";
if($item->drec!=$meuid&&$item->para!=$meuid&&perm($meuid)!=3&&!permdono($meuid)){
if($item->privado!=0){
$canc = false;
}
}
if($canc){
?>
<div id="<?php echo $num%2==0?'div1':'div2';?>">
<?
if(($item->privado==1)&&(($item->drec==$meuid)||($item->para==$meuid)||(perm($meuid)==4) or permdono($meuid))&&$item->para){
echo gerarfoto($item->drec,30,30);?><a href="/<?php echo gerarlogin($item->drec);?>"><?php echo gerarnome($item->drec);?></a>
<?php 
if($item->para==0){
}else{
?> 
<b>(reservadamente)</b>
<?php echo gerarfoto($item->para,30,30);?><a href="/<?php echo gerarlogin($item->para);?>"><?php echo gerarnome($item->para);?></a>
<?php 
}
?>
<b>:</b>
<em style="color: <?php echo $item->cor; ?>;background-color:<?php echo $item->contorno; ?>;"><?php echo textot($item->rec,$meuid,$on);?></em> 
<br>
<small>
<div align="right"><small><img src="/style/tempo.gif"/>há <?php echo "$tempo atr&aacute;s";?></small></div>
</small>
<?php
}else{
if($item->ac==1){
if(!empty($item->resposta)){
?><img src="/style/res.png" width="20px" height="20px"><?php echo gerarfoto($item->idresposta,30,30);?><a href="/<?php echo gerarlogin($item->idresposta);?>"><?php echo gerarnome($item->idresposta);?></a> <b>Respondeu</b> <strong style="color:#F00;">
<?php echo textot($item->resposta,$meuid,$on);?>
</strong><br>
<?php 
}else{
}
echo gerarfoto($item->drec,30,30);?><a href="/<?php echo gerarlogin($item->drec);?>"><?php echo gerarnome($item->drec);?></a>
<?php 
if($item->para==0){
}else{
?> 
<b><font color='red'><?php echo textot($item->rec,$meuid,$on);?></font></b> 
<?php echo gerarfoto($item->para,30,30);?><a href="/<?php echo gerarlogin($item->para);?>"><?php echo gerarnome($item->para);?></a> 
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
<div align="right"><small><img src="/style/tempo.gif"/>há <?php echo "$tempo atr&aacute;s";?></small></div>
</small>
<?
}else{   
if(!empty($item->resposta)){
?><img src="/style/res.png" width="20px" height="20px"><?php echo gerarfoto($item->idresposta,30,30);?><a href="/<?php echo gerarlogin($item->idresposta);?>"><?php echo gerarnome($item->idresposta);?></a> <b>Respondeu</b> <strong style="color:#F00;">
<?php echo textot($item->resposta,$meuid,$on);?>
</strong><br>
<?php 
}else{
}
echo gerarfoto($item->drec,30,30);?><a href="/<?php echo gerarlogin($item->drec);?>"><?php echo gerarnome($item->drec);?></a>
<?php 
if($item->para==0){
}else{
?> 
<b>Falou Para</b>
<?php echo gerarfoto($item->para,30,30);?><a href="/<?php echo gerarlogin($item->para);?>"><?php echo gerarnome($item->para);?></a> 
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
}else{
}
?>
<div align="center" id="opc4">
<b><a href='whatsapp://send?text=Ola venha voce tambem conhecer este super site wap amizades namoro diversao chat de bate papo em um so lugar ! aproveite e gratis cadastre se aqui => https://baladawap.com'><img src="/style/zap.png" width="20px" height="20px" title='Whatsapp' /> Whatsapp</a> <img src="/style/pensando.gif" width="20px" height="20px" title='ocultar' /><a href="/home?a=ocultar"> Ocultar hall</a></b><br/>
<?php 
} 
}else{

$itens = $mistake->prepare("SELECT * FROM w_mural WHERE tipo='4' ORDER BY id DESC limit 1");
$itens->execute();
$item = $itens->fetch(PDO::FETCH_OBJ);
?>
<div id="barra_mural">Pensamento</div>
<div align="center">
<div id="fundo_mural">
O que você está pensando agora?
<form action="/mural/pensamento" method="post"><input name="rec" maxlength="200"><input type="submit" value="Postar"></form><br />
<?php 
if($item){
echo gerarfoto($item->drec,30,30);?><a href="/<?php echo gerarlogin($item->drec);?>"> <?php echo gerarnome($item->drec);?></a>
<font color='red'>Está pensando em:</font> <?php echo textot($item->rec,$meuid,$on);?></font>
<?
gosteimural($item->id,$item->hora,'pensamentos',$meuid);
?>
<?php echo $imgcorreiov;?><a href="/mural/pensamentos" >Pensamentos(<?php echo $pensa[0];?>)
<?php
}
?>
</div>
</div>
<div id="opc4">
<div align="center">
<b><a href='whatsapp://send?text=Ola venha voce tambem conhecer este super site wap amizades namoro diversao chat de bate papo em um so lugar ! aproveite e gratis cadastre se aqui => https://baladawap.com'><img src="/style/zap.png" width="20px" height="20px" title='Whatsapp' /> Whatsapp</a> <img src="/style/pensando.gif" width="20px" height="20px" title='ocultar' /><a href="/home/mostrar">Mostrar hall</a></b>
</div>
<?php
}
?>
<br/><div id="ad"><small><b><img src="/style/novo.gif" width="20px" height="20px"/>Vamos enviar ação e dar boas vindas para o mais novo membro: <a href="/<?php echo gerarlogin($nu[0]);?>"> <?php echo gerarnome($nu[0]);?></a></b></small></div>
</div>
<div id="barra_mural">Menu principal</div>
<div id="div1"><?php echo $imgcorreio;?><a href="/mensagens/entrada" >Mensagens(<?php echo $pmnaolida[0].'/'.$todaspms[0];?>)</a></div>
<div id="div2"><?php echo $imgsegredos;?><a href="/segredo" >segredos(<?php echo $segredos[0];?>)</a></div>
<div id="div1"><?php echo $imgcorreiov;?><a href="/mural/pensamentos" >Pensamentos(<?php echo $pensa[0];?>)</a></div>
<div id="div2"><?php echo $imgquiz;?><a href="/pergunte_me?a=perguntas&id=<?php echo $meuid; ?>">Pergunte-me algo(<?php echo $perguntas[0];?>)</a>
<?php
$car = $mistake->prepare("SELECT time FROM caballos WHERE abierta='1' ORDER BY id DESC LIMIT 0,1");
$car->execute();
$car = $car->fetch();
if($total_perguntas3[0]>0) { ?> : <a href="/pergunte_me?a=perguntas&id=<?php echo $meuid; ?>"><?php echo $total_perguntas3[0];?></a> <?php } ?> </div>
<div id="div1"><?php echo $imgavbom;?><a href="/gostei">Gostou?</a></div>
<div id="div2"><?php echo $imgforum;?><a href="/chat">Bate-Papo(<?php echo $conton[0];?>)</a></div>
<div id="div1"><?php echo $imgforum;?><a href="/forum/inicio">Fórum(<?php echo $topicos[0];?>/<?php echo $posts[0];?>)</a></div>
<div id="div2"><?php echo $imgcomunidades;?><a href="/comunidades">Comunidades(<?php echo $comu[0];?>)</a></div>
<div id="div1"><?php echo $imgamigos;?><a href="/amigos?">Amigos(<?php echo $miguxoson[0].'/'.$amigos[0];?>)</a><?php if($pedidos[0]>0) { ?> : <a href="/amigos/pedidos" ><?php echo $pedidos[0];?></a> <?php } ?></div>
<div id="div2"><?php echo $imgalbuns;?><a href="/galeria?">Álbuns/Fotos(<?php echo $albuns[0].'/'.$fotos[0];?>)</a></div>
<div id="div1"><?php echo $imgemo;?><a href="/configuracoes/catemocoes" >Emoções(<?php echo $emo[0];?>)</a></div>
<div id="div2"><?php echo $imgdownloads;?><a href="/downs?">Downloads(<?php echo $downs[0];?>)</a></div>
<div id="div1"><?php echo $imgmoedas;?><a href="/configuracoes/moedas" >Ganhe moedas</a></div>
<div id="div2"><?php echo $imgloja;?><a href="/lojas?">Loja de Presentes</a></div>
<div id="div1"><?php echo $imgdiversao;?><a href="/entretenimento/diversao">Games/Diversão</a></div>
<div id="div2"><?php echo $imghipod;?><a href='/caballos/<?php if(time()>$car[0]) echo 'elegir'; else echo 'menu'; ?>'>Hipodromo</a><?php if(time()>$car[0]) echo '&nbsp;(A)' ?></div>
<div id="div1"><?php echo $imgextra;?><a href="/entretenimento/diversos">Menu Extra</a></div>
<div id="div2"><?php echo $imgpreferencias;?><a href="/configuracoes?">Painel do usuário</a></div><?
if(perm($meuid)>0) { 
?>
<div id="div1"><a href="mod?">&#11088 Painel da equipe</a></div>
<?php 
}
?>
<small><table width="100%">
<tr>
<td id="opc4" width="50%">
<?php
$r=rand(1,7);
if($r==1) {
echo $imgtime;?><a href="/apostas" >Apostas</a>
<?php } else if($r==2) {
echo $imgppt;?><a href="/ppt?" >Pedra, papel, tesoura</a>
<?php } else if($r==3) {
echo $imgtime;?><a href="/entretenimento/apptime">Meu time do coração</a>
<?php } else if($r==4) {
echo $imgnoticias;?><a href="/noticias?">Notícias</a>
<?php } else if($r==5) {
echo $imgquiz;?><a href="/entretenimento/quiz">Quiz</a>
<?php } else if($r==6) {
echo $imgforca;?><a href="/forca?">Forca</a>
<?php } else if($r==7) {
echo $imgbanco;?><a href="/banco?">Banco</a>
<?php } ?>
</td>
<td id="opc4" width="50%">
<?php
$r=rand(8,14);
if($r==8) {
echo $imgwapet;?><a href="/wapet?">Virtual pet</a>
<?php } else if($r==9) {
echo $imgcalc;?><a href="/calculadora?">Calculadora</a>
<?php } else if($r==10) {
echo $imgcassino;?><a href="/cassino1?">Cassino</a>
<?php } else if($r==11) {
echo $imgloja;?><a href="/lojas?">Lojas de presente</a>
<?php } else if($r==12) {
echo $imgdado;?><a href="/dado?">Jogo do dado</a>
<?php } else if($r==13) {
echo $imgtime;?><a href="/penaltis?">Jogo dos Pênaltis</a>
<?php } else if($r==14) {
echo $imgparouimpar;?><a href="/parouimpar?">Par ou Ímpar</a>
<?php } ?>
</td>
</tr>
</table></small>
<div align="center">
<?php if($i[4]==1) {
if($testearray[21]==true) { 
$muralauto = "AND '".date("H:i:s")."' >= inicio AND '".date("H:i:s")."' < fim";  
}else{
$muralauto = ""; 
}
$mural = $mistake->prepare("SELECT * FROM w_mural WHERE tipo='2' $muralauto ORDER BY id DESC limit 1"); 
$mural->execute();
$mural = $mural->fetch();
if($testearray[21]==true) { 
$simauto = "<small><b><u>De  ".$mural['inicio']." as ".$mural['fim']."</small></u></b>";
}else{
$simauto = "";
}
?>
<div id="barra_mural">Mural de Divulgações</div>
<div id="fundo_mural">
<?
if($mural) { 
echo gerarfoto($mural['drec']);?> <a href="/<?php echo gerarlogin($mural['drec']);?>"><?php echo gerarnome($mural['drec']);?></a>:&ensp;
<em style="color: <?php echo $mural['cor']; ?>;background-color:<?php echo $mural['contorno']; ?>;"><?php echo textot($mural['rec'],$meuid,$on);?></em>
<hr>
<?php echo $simauto;?><br />
<?php 
}
if (perm($meuid)>0) { 
?>
<a href="/mural/divulgacao">Histórico</a>
, <a href="/mural/recado_divulgacao">Enviar</a>
, <a href="/mural/editar/<?php echo $mural['id'];?>/divulgacao">Editar</a>
, <a href="/mural/excluir/<?php echo $mural['id'];?>">Deletar</a>
<?php 
} 
?>
</div>
<?php  
}
if($i[3]==1) {
echo"<div id='barra_mural'>Recados</div><div id='fundo_mural'>";
$itens = $mistake->prepare("SELECT * FROM w_mural WHERE tipo='1' ORDER BY id DESC limit 1");
$itens->execute();
$i=0; 
while ($item = $itens->fetch(PDO::FETCH_OBJ)) { 
echo gerarfoto($item->drec);?><a href="/<?php echo gerarlogin($item->drec); ?>"><?php echo gerarnome($item->drec);?></a>
&ensp;Para&ensp;
<?php 
if($item->para==0) { 
echo 'Todos'; 
}else{ 
echo gerarfoto($item->para);?><a href="/<?php echo gerarlogin($item->para); ?>"><?php echo gerarnome($item->para);?></a><?php } ?>:&ensp; 
<em style="color: <?php echo $item->cor; ?>;background-color:<?php echo $item->contorno; ?>;"><?php echo textot($item->rec,$meuid,$on);?></em>
<?php 
gosteimural($item->id,$item->hora,'recados',$meuid);
}
?>
<a href="/mural/recado">Enviar</a> , <a href="/mural/recados">Histórico</a></div>
<?php 
}
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
<br />
<?$onsomo = $online[0]+$on[0];?>
<b>Entrou:</b> <a href="/<?php echo gerarlogin($geral['entrou']);?>"><?php echo gerarfoto($geral['entrou'],28,28);?><?php echo gerarnome($geral['entrou']);?></a><br/>
<b>Saiu:</b> <a href="/<?php echo gerarlogin($geral['saiu']);?>"><?php echo gerarfoto($geral['saiu'],28,28);?><?php echo gerarnome($geral['saiu']);?></a><br/>
<b>Ganhador do cassino:</b><a href="/<?php echo gerarlogin($geral['cgan']);?>"><?php echo gerarfoto($geral['cgan'],28,28);?><?php echo gerarnome($geral['cgan']);?></a><br/><br/>
<a href="/online?"><b>Usuários Online: (<?php echo $onsomo;?>)</a></b><br/>
<a href="/online/equipe"><b>Equipe Online: (<?php echo $equipe[0];?>)</a></b><br/>
<a href="/online/vips"><b>Membros V.I.P's: (<?php echo $vips[0];?>)</a></b><br/>
<a href="/online/visitas"><b>Visitantes Online: (<?php echo $on[0];?>)</a></b><br/><br/><b>
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
</b><br /><div align="center">
<a href="/ajuda?"><img src="/style/ajuda.png" alt="img" /><strong>Ajuda</strong></a> - 
<a href="/estatisticas?"><img src="/style/estatisticas.gif" alt="img" />
<strong>Estatísticas</strong></a> - <a href="/busca?"><img src="/style/busca.gif" alt="img" />
<strong>Busca</strong></a> <br/><br/> <a href="/estatisticas?a=niver"><img src="/style/bolo.png"/>
<strong>Aniversariantes</strong></a> - <a href="/configuracoes/catemocoes">
<img src="/style/emocoes.gif"/><strong>Emoções</strong></a>
<br/><br/> 
<div align="center"><a href="/sair?a=sair"style="color:#FF0000;">
<img src="/style/sair.gif" alt="img" />Sair do site</a></div>
<?php
/*
if(vip($meuid)) { 
?>
<br><div align="center"><a href="/mod?">&#187;Painel da equipe</a></div>
<?php 
}*/
if($_COOKIE['atividades']==false){
setcookie('atividades',$meuid,(time() + (1800 * 1)), '/');
$res = $mistake->exec("update w_usuarios set atividades=atividades+1 where id='$meuid'"); 
}
echo rodape(); 
?>
</body> 
</html>