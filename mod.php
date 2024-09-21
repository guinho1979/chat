<?php
require_once("".$_SERVER["DOCUMENT_ROOT"]."/funcoes.php");
require_once("".$_SERVER["DOCUMENT_ROOT"]."/mistake.php");
if($a=='ipvisitante') { 
if($meuid==true){ 
ativo($meuid,'Vendo dados do ip '.$id.'');
}
?>
<br/><div id="titulo"><b>Dados sobre o Ip <?php echo $id;?></b></div><div align="center"><br/>
<?php
echo "".open_ip($id)." <br><a href='/busca?nome=".$id."&por=ip&a=busca'>ver todos usuários com este ip</a><br /><br />";
?>
<a href="<?php echo $meuid ? '/home' : '/';?>"><?php echo $imginicio;?>Página principal</a></div><br />
<?
rodape(); 
exit();
}
seg($meuid);
$senha = $mistake->query("SELECT senhaequipe FROM w_usuarios WHERE id='$meuid'")->fetch();
if($_POST["senha_equipe"]==$senha['senhaequipe']) {
$_SESSION["senha"] = $meuid;
setcookie("senha_equipe",$meuid,(time() + (3600 * 1)),"/",".".str_replace("www.","",$_SERVER["HTTP_HOST"])."");
}
if($_SESSION["senha"]!=$meuid and $_COOKIE['senha_equipe']!=$meuid) { 
?>
<div id="titulo"><b>Senha da equipe</b></div><br/>
<div align="center">
Por questões de segurança digite a senha do painel da equipe.<br /><br />
<form action="<?php echo $_SERVER ['REQUEST_URI']; ?>" method="post">
Senha: <br/><input type="text" name="senha_equipe" required><br />
<input type="submit" value="Desbloquear"></form>
<br/>
<a href="/home?"><?php echo $imginicio;?>Página principal</a><br><br>
<?php 
rodape(); 
exit(); 
}
if(vip($meuid)==false) { 
ativo($meuid,'Tentando entrar na moderação'); ?>
<div align="center"><br/><?php echo $imgerro;?>Você não é um membro da equipe!
<?php 
rodape(); 
exit(); 
}
unset($_SESSION["senha"]);
ativo($meuid,'Moderação');
$data = date("d/m/Y - H:i:s",time());
function apagardevez($id){
global $mistake;
if($id > 0){
$info = $mistake->query("SELECT ft,fundo_bg,av,nm FROM w_usuarios WHERE id='".$id."'")->fetch();
@unlink($info[1]);
@unlink($info[0]);
@unlink(str_replace('m_','',$info[0]));
if(strripos($info[2],'/users/') == true){
@unlink($info[2]);
}
$filename = "".$_SERVER["DOCUMENT_ROOT"]."/temp/".$info[3].".gif";
if (file_exists($filename)) {
unlink($filename);
}
$albuns = $mistake->prepare("SELECT id FROM w_albuns WHERE dn='".$id."'");
$albuns->execute();
while ($alb=$albuns->fetch(PDO::FETCH_OBJ)){
$dir = "".$_SERVER["DOCUMENT_ROOT"]."/albuns/".$alb->id."";
exec("rm -rf {$dir}");
}
$mistake->exec("DELETE FROM w_downs WHERE dn='".$id."'");
$comun = $mistake->prepare("SELECT id, lg FROM w_comu WHERE dn='".$id."'");
$comun->execute();
while($comu=$comun->fetch(PDO::FETCH_OBJ)){
@unlink("cmn/".$comu->id.$comu->lg."");
}
$mistake->exec("DELETE FROM w_comu WHERE dn='".$id."'");
$tpcs = $mistake->query("SELECT id FROM w_topicos WHERE por='".$id."'");
while ($tpc = $tpcs->fetch(PDO::FETCH_OBJ)){
$mistake->exec("DELETE FROM w_posts WHERE tpc='".$tpc->id."'");
$mistake->exec("DELETE FROM w_topicos WHERE id='".$tpc->id."'");
}
$itensapagar = $mistake->query("SELECT id,imagem FROM bymistake_segredos WHERE por='".$id."'");
while ($itemapagar = $itensapagar->fetch(PDO::FETCH_OBJ)) {
if($itemapagar->imagem!='0'){
@unlink("segredos/segredos/".$itemapagar->imagem."");
}
$mistake->exec("DELETE FROM bymistake_segredos_identificacao WHERE segredo='".$itemapagar->id."'");
$mistake->exec("DELETE FROM bymistake_segredos_cmt WHERE segredo='".$itemapagar->id."'");
$mistake->exec("DELETE FROM bymistake_segredos_curtidas WHERE segredo='".$itemapagar->id."'");
$mistake->exec("DELETE FROM bymistake_segredos_cmt_curtidas WHERE segredo='".$itemapagar->id."'");
}
$mistake->exec("DELETE FROM bymistake_segredos_cmt WHERE por='".$id."'");
$mistake->exec("DELETE FROM bymistake_segredos_identificacao WHERE por='".$id."'");
$mistake->exec("DELETE FROM bymistake_segredos_curtidas WHERE por='".$id."'");
$mistake->exec("DELETE FROM bymistake_segredos_cmt_curtidas WHERE por='".$id."'");
$mistake->exec("DELETE FROM bymistake_segredos WHERE por='".$id."'");
$dadol = $mistake->query("SELECT id FROM w_loja_m WHERE dn='".$id."'")->fetch();
$itens = $mistake->query("SELECT * FROM w_loja WHERE valorloja='".$dadosl['id']."'");
while ($item = $itens->fetch(PDO::FETCH_OBJ)) {
@unlink('loja/'.$item->id.'.'.$item->ext.'');
$mistake->exec("DELETE FROM w_loja_c WHERE cat='".$item->cat."'");
}
$mistake->exec("DELETE FROM w_loja_m WHERE dn='".$id."'");
$mistake->exec("DELETE FROM w_loja_cc WHERE valorloja='".$dadosl['id']."'");
$itens = $mistake->query("SELECT id,ext FROM w_emocoes WHERE uid='".$id."'");
while($item = $itens->fetch()) {
@unlink("e/$item[0].$item[1]");
}
$mistake->exec("DELETE FROM w_depo3 WHERE uid='".$id."'");
 $mistake->exec("DELETE FROM w_comentarios_p WHERE por='".$id."'");
$mistake->exec("DELETE FROM w_mchat WHERE por='".$id."'");
$mistake->exec("DELETE FROM w_ochat WHERE uid='".$id."'");
$mistake->exec("DELETE FROM w_premios WHERE uid='".$id."'");
$mistake->exec("DELETE FROM w_loja_cc WHERE uid='".$id."' or aid='".$id."'");
$mistake->exec("DELETE FROM w_fas WHERE uid='".$id."' or aid='".$id."'");
$mistake->exec("DELETE FROM w_emocoes WHERE uid='".$id."'");
$mistake->exec("DELETE FROM w_loja WHERE valorloja='".$id."'");
$mistake->exec("DELETE FROM w_premios WHERE por='".$id."'");
$mistake->exec("DELETE FROM w_acoes WHERE de='".$id."' or para='".$id."'"); 
$mistake->exec("DELETE FROM w_albuns WHERE dn='".$id."'"); 
$mistake->exec("DELETE FROM w_comentarios WHERE por='".$id."'"); 
$mistake->exec("DELETE FROM w_amigos WHERE tid='".$id."' or uid='".$id."'");  
$mistake->exec("DELETE FROM w_comentarios_logs WHERE meuid='".$id."'");    
$mistake->exec("DELETE FROM w_msgs WHERE por='".$id."' or pr='".$id."'");
$mistake->exec("DELETE FROM w_forum WHERE dono='".$id."'");
$mistake->exec("DELETE FROM w_posts WHERE por='".$id."'");
$mistake->exec("DELETE FROM w_mural WHERE drec='".$id."'");
$mistake->exec("DELETE FROM mmistake_pokemon WHERE pegou='".$id."'");
$mistake->exec("DELETE FROM w_pergunte_me WHERE de='".$id."' or para='".$id."'");
$mistake->exec("DELETE FROM w_cmt_fotos WHERE dono='".$id."'");
$mistake->exec("DELETE FROM w_fotos WHERE dono='".$id."'");
$mistake->exec("DELETE FROM w_depo2 WHERE uid='".$id."'");
$mistake->exec("DELETE FROM w_duelo_logs WHERE eu_votei='".$id."'"); 
$mistake->exec("DELETE FROM w_friendzoo_logs WHERE dono='".$id."'"); 
$mistake->exec("DELETE FROM w_perguntas_logs WHERE eu_votei='".$id."' or dono='".$id."'");
$mistake->exec("DELETE FROM w_vounaovou WHERE aid='".$id."' or uid='".$id."'"); 
$mistake->exec("DELETE FROM w_perg WHERE aid='".$id."' or uid='".$id."'"); 
$mistake->exec("DELETE FROM w_visitas WHERE aid='".$id."' or uid='".$id."'"); 
$mistake->exec("DELETE FROM w_ubloq WHERE aid='".$id."' or uid='".$id."'"); 
$mistake->exec("DELETE FROM w_recados WHERE por='".$id."' or pr='".$id."'"); 
$mistake->exec("DELETE FROM w_gperfil WHERE aid='".$id."' or uid='".$id."'");
$mistake->exec("DELETE FROM w_enquetes WHERE uid='".$id."'"); 
$mistake->exec("DELETE FROM w_m_voto WHERE meuid='".$id."' or uid='".$id."'");
}
}
if($a==false) {
if(permdono($meuid)){
if($id=='toponline') {
$mistake->exec("UPDATE w_usuarios SET ton='0'");
} 
if ($id=='onhall') {
$mistake->exec("update w_usuarios set vs='$pag',vschat='$pag' where id='$meuid'");
}
if ($id=='onstatus') {
$mistake->exec("update w_usuarios set mostrastatus='$pag' where id='$meuid'");
}
if ($id=='delvisitas') {
$mistake->exec("TRUNCATE TABLE w_visitas");
}
if($id=='limparlogs'){
$mistake->exec("TRUNCATE TABLE w_ltpc");
$mistake->exec("TRUNCATE TABLE mmistake_logs");
$mistake->exec("TRUNCATE TABLE w_pontos");
}
if($id=='limpar'){
$mistake->exec("TRUNCATE TABLE w_ltpc");
$mistake->exec("TRUNCATE TABLE mmistake_logs");
$mistake->exec("TRUNCATE TABLE w_comentarios");    
$mistake->exec("TRUNCATE TABLE w_comentarios_logs");    
$mistake->exec("TRUNCATE TABLE w_pontos");
$mistake->exec("TRUNCATE TABLE w_mural");
$mistake->exec("TRUNCATE TABLE bymistake_quizmural");
}
if($id=='limparm'){
$mistake->exec("TRUNCATE TABLE w_ltpc");
$mistake->exec("TRUNCATE TABLE mmistake_logs");
$mistake->exec("TRUNCATE TABLE w_msgs");
}
if ($e=='desativar_entrevista') {
$mistake->exec("update w_geral set entrevista='0' where id='1'");
}
if ($e=='ativar_entrevista') {
$mistake->exec("update w_geral set entrevista='1' where id='1'");
}
if ($e=='desativar_reuniao') {
$mistake->exec("update w_geral set reuniao='0' where id='1'");
}
if ($e=='ativar_reuniao') {
$mistake->exec("update w_geral set reuniao='1' where id='1'");
}
if($id=='delduelo'){
$mistake->exec("TRUNCATE TABLE w_duelo_logs");
}
if($id=='delfriendzoo'){
$mistake->exec("TRUNCATE TABLE w_friendzoo_logs");
}
if($id=='deltopjogos'){
$mistake->exec("update w_usuarios set qzaa='0',qzee='0',qza='0',qze='0',moto='0',bolia='0',bolie='0',fora='0',fore='0',cassa='0',casse='0',core='0',cora='0',dada='0',dede='0',pena='0',pene='0',pouca='0',pouce='0',ppte='0',ppta='0',kartin='0',mortal='0',caballo='0',pombo='0',twd='0',zom='0',cartas='0'");
$mistake->exec("TRUNCATE TABLE fun_formula");
$mistake->exec("TRUNCATE TABLE twd");
$mistake->exec("TRUNCATE TABLE twdcap");
$mistake->exec("TRUNCATE TABLE mmistake_pokemon");
$mistake->exec("TRUNCATE TABLE caballos");
$mistake->exec("TRUNCATE TABLE kart");
$mistake->exec("TRUNCATE TABLE mmistake_apostas");
$mistake->exec("TRUNCATE TABLE mortal_kombat");
}
if($id=='delhall'){
$mistake->exec("DELETE FROM w_mural WHERE tipo='5'");
}
if($id=='delchat'){
$mistake->exec("TRUNCATE TABLE w_mchat");	
}
if($id=='midias'){
$dir = new DirectoryIterator("".$_SERVER["DOCUMENT_ROOT"]."/msgs/");
foreach ($dir as $item) {
if ($item->isDot()) {
continue;
}
$teste = $item->getFilename();
if($teste!='index.html'){
@unlink("".$_SERVER["DOCUMENT_ROOT"]."/msgs/$teste");
}
}
exec("rm -rf ".$_SERVER["DOCUMENT_ROOT"]."/downsm/tmp");	
}
if($id=='delmsg'){
$mistake->exec("DELETE FROM w_msgs WHERE por='$meuid' and dl='1'");
}
if($id=='delmsgs'){
$timeout = time()-172800;
$mistake->exec("DELETE FROM w_msgs WHERE hr<'".$timeout."' and ld='0'");
}
if($id=='delmsgslidas'){
$timeout = time()-172800;
$mistake->exec("DELETE FROM w_msgs WHERE hr<'".$timeout."' and ld='1'");
}
if($id=='delrecuser'){
$timeout = time()-172800;
$mistake->exec("DELETE FROM w_mural WHERE tipo='1' and hora<'".$timeout."'");
$mistake->exec("DELETE FROM w_comentarios WHERE hr<'".$timeout."'");
$mistake->exec("TRUNCATE TABLE w_comentarios_logs");
}
if($id=='delrecequipe'){
$timeout = time()-172800;
$mistake->exec("DELETE FROM w_mural WHERE tipo='3' and hora<'".$timeout."'");
$mistake->exec("DELETE FROM w_comentarios WHERE hr<'".$timeout."'");
$mistake->exec("TRUNCATE TABLE w_comentarios_logs");
}
if($id=='delrecdivul'){
$timeout = time()-172800;
$mistake->exec("DELETE FROM w_mural WHERE tipo='2' and hora<'".$timeout."'");
$mistake->exec("DELETE FROM w_comentarios WHERE hr<'".$timeout."'");
$mistake->exec("TRUNCATE TABLE w_comentarios_logs");
}
if($id=='delrecpensa'){
$timeout = time()-172800;
$mistake->exec("DELETE FROM w_mural WHERE tipo='4' and hora<'".$timeout."'");
$mistake->exec("DELETE FROM w_comentarios WHERE hr<'".$timeout."'");
$mistake->exec("TRUNCATE TABLE w_comentarios_logs");
}
}
}
if($a=='jogos'){
?>
<br/><div id="titulo"><b>Add Jogos No Hall</b></div><br/>
<?
if($_POST) {
if($_POST["tipo"]==1) {
$texto = '[link=/caballos/elegir]<br /><b><u>Escolha seu Cavalo Ganhe Pontos e Fique em Primeiro do Rank</u></b><br /><img src="/juegos/cab/uid1.gif" width="50px"/>[/link]';
}else
if($_POST["tipo"]==2) {
$texto = '[link=/bolinha]<br /><b><u>Ache a Bolinha e Fature</u></b><br /><img src="/imgs/bol3.jpg"/>[/link]';
}else
if($_POST["tipo"]==3) {
$texto = '[link=/cassino1]<br /><b><u>Fature Alguns Pontos no Cassino</u></b><br /><table border="1"><tr><td><img src="/cassino/t2.gif" /></td><td><img src="/cassino/t3.gif" /></td><td><img src="/cassino/t5.gif" /></td></tr></table>[/link]';
}else
if($_POST["tipo"]==4) {
$texto = '[link=/dado]<br /><b><u>Desafie Um Amigo No Jogo De Dados</u></b><br /><img src="/dado2/6.jpg"/>[/link]';
}else
if($_POST["tipo"]==5) {
$texto = '[link=/forca]<br /><b><u>Jogo Da Forca Teste Seu Conhecimento e Não Morra Enforcado</u></b><br /><img src="/style/forca_4.gif"/>[/link]';
}else
if($_POST["tipo"]==6) {
$texto = '[link=/wapet]<br /><b><u>Mostre Que Você e Um Bom Dono Crie Seu Pet,Alimente De Banho E o Faça Feliz</u></b><br /><img src="/style/wapet.gif"/>[/link]';
}else
if($_POST["tipo"]==7) {
$texto = '[link=/pescaria]<br /><b><u>Mostre Que Você e Um Bom Pescador</u></b><br /><img src="/imagens/pesca/r_pescar.jpg"/>[/link]';
}
$res = $mistake->prepare("INSERT INTO w_mural (rec,hora,tipo,drec) VALUES (?,?,?,?)");
$arrayName = array($texto,time(),5,$meuid);
$ii = 0;
for($i=1; $i <=4; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
echo $imgok;?>O jogo foi postado com sucesso!<br>
<?
}
?>
<form action="/mod/jogos" method="post">
<select name="tipo">
<option value="1">Hipodromo<selected></option>
<option value="2">Ache a Bolinha</option>
<option value="3">Cassino</option>
<option value="4">Dados</option>
<option value="5">Forca</option>
<option value="6">Pet Virtual</option>
<option value="7">Pescaria</option>
</select><br />
<input type="submit" value="Enviar">
</form>
<?php
}
else
if($a=='pix' && $meuid==1) { ?>
<?php
$nando =  $mistake;
if($pag=='apagar'&&permdono($meuid)){
$ac = $nando->exec("DELETE FROM w_pix WHERE id='".$id."'");
}
if($pag=='confirmar'&&permdono($meuid)){
$ac = $nando->exec("update w_pix set status='1' where id='".$id."'");
$usu= $nando->query("SELECT uid,pix,valor FROM w_pix WHERE id='$id'")->fetch();
$msg = "Oi ".html_entity_decode(gerarnome2($usu[0])).", o pagamento do seu pix para a chave [b] ".$usu[1]." [/b] no valor de [b] ".$usu[2]." [/b] reais foi concluído com sucesso, favor verificar no seu extrato bancário, ou no aplicativo de seu banco.</b>";
automsg($msg,1,$usu[0]);
}
?>
<br/><div id="titulo"><b>Transações PIX</b></div><br/>
<?php
$contmsg = $nando->query("SELECT COUNT(*) FROM w_pix")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contmsg[0];
$itensporpag = 8;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $nando->query("SELECT * FROM w_pix ORDER BY id desc LIMIT $limit, $itensporpag");
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) {
if($item->status==0){
$status="<font color='orange'>Em processamento</font>";
}else if($item->status==1){
$status="<font color='green'>Concluído</font>";
}else if($item->status==2){
$status="<font color='red'>Cancelado</font>";
}
?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
Por: <a href="/<?php echo gerarlogin($item->uid);?>"><?php echo gerarnome($item->uid);?></a><br/>Status da transação: <b><?php echo $status;?></b><br/>
PIX: <b><?php echo $item->pix;?></b>
<br />
Valor: <b><?php echo $item->valor;?></b> <?php echo $item->valor>1 ? 'reais' : 'real';?>
<br />
Data/hora da transação: <b><?php echo date("d/m/Y - H:i:s",$item->data);?></b><br/>
<a href="/mod/pix/<?php echo $item->id;?>/apagar">[apagar transação]</a> - <a href="/mod/pix/<?php echo $item->id;?>/confirmar">[confirmar pagamento]</a>
</div>
<?php $i++; }
if($numpag>1) {
paginas('mod',$a,$numpag,$id,$pag);
} 
}else{
?>
<div align="center"><?php echo $imgerro;?>Nenhuma transação pix até o momento!<br/>
<?php     
}
}
else
if($a=='liberar') { 
if($pag=='excluir'){
if(permdono($meuid)) { 
$res = $mistake->exec("DELETE FROM w_usuarios where id='".$id."' AND liberado='0'");
if($res) {
echo $imgok;?>Excluido com sucesso!<br /><br />
<?php } else { 
echo $imgerro;?> Opss... algo saiu errado!<br /><br />
<?php } 
}
}
if($pag=='liberar'){
$res = $mistake->exec("update w_usuarios set liberado='1' where id='".$_GET['id']."'"); 
if($res) {
echo $imgok;?>Liberado com sucesso!<br /><br />
<?php } else { 
echo $imgerro;?> Opss... algo saiu errado!<br /><br />
<?php 
} 
}
?>
<?php $itens = $mistake->query("SELECT * FROM w_usuarios WHERE liberado='0' ORDER BY id");
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<a href="/<?php echo gerarlogin($item->id);?>"><?php echo gerarnome($item->id);?></a> - <a href="/mod/liberar/<?php echo $item->id;?>/liberar"> [liberar]</a> - <a href="/mod/liberar/<?php echo $item->id;?>/excluir"> [excluir]</a>
</div>
<?php
$i++;
}
} else if($a=='addsmile'){
$tipo = $_POST["cate"];
$smile = trim($_POST["smile"]);
if(!empty($smile)){
if(perm($meuid)<1){
echo $imgerro;?>Você não é da equipe<br><?php
}else{    
if (strpos($smile,".") === false) {
echo $imgerro;?>Coloque os pontinhos no inicio e no final do codigo.<br><?php
}else{
$texto1 = mb_strlen($smile);
if ($texto1 < 2){
echo "$imgerro Desculpa no minimo 2 caracteres para codigo!<br>";
}else{
$conta_ts = $mistake->prepare("SELECT id,ext FROM w_emocoes WHERE cod='".$smile."'");
$conta_ts->execute();
$conta_ts = $conta_ts->fetch();
if($conta_ts[0]>0){
echo "$imgerro ja existe um smilie com este codigo... <img src='/e/".$conta_ts[0].".".$conta_ts[1]."' class='smilies' oncontextmenu='return false' onselectstart='return false' ondragstart='return false'><br>";
}else{
$arquivo = isset($_FILES["arquivo"]) ? $_FILES["arquivo"] : FALSE;
$config["tamanho"] = 5000000;
$config["largura"] = 800;
$config["altura"]  = 800;
if (!empty($arquivo["name"])){
if(!preg_match("/^image\/(jpg|jpeg|png|gif|webp)$/", $arquivo["type"])){
echo "$imgerro Arquivo em formato invalido! A imagem deve ser  (jpg|jpeg|png|gif|webp) . Envie outro arquivo<br>";
}else{
if($arquivo["size"] > $config["tamanho"]){
echo "$imgerro O arquivo e muito grande! A imagem deve ser de no maximo " . $config["tamanho"] . " bytes. Envie outro arquivo<br>";
}else{
$tamanhos = getimagesize($arquivo["tmp_name"]);
if($tamanhos[0] > $config["largura"]){
echo "$imgerro Largura da imagem nao deve ultrapassar " . $config["largura"] . " pixels<br>";
}else{
if($tamanhos[1] > $config["altura"]){
echo "$imgerro Altura da imagem nao deve ultrapassar " . $config["altura"] . " pixels<br>";
}else{
preg_match("/.(gif|png|jpg|jpeg|webp){1}$/i", $arquivo["name"], $ext);
$res = $mistake->exec("INSERT INTO w_emocoes SET cod='".$smile."',ext='".$ext[1]."',cat='".$tipo."'");
$emoc = $mistake->query("SELECT max(id) FROM w_emocoes")->fetch();
$imagem_dir = "e/".$emoc[0].".".$ext[1]."";
if($tamanhos["mime"]=='image/webp'){
move_uploaded_file($arquivo["tmp_name"],$imagem_dir);    
}else{
if($tamanhos["mime"]=='image/gif'){
//exec("gifsicle -O3 ".escapeshellarg($arquivo["tmp_name"])." -o ".escapeshellarg($imagem_dir)."");
move_uploaded_file($arquivo["tmp_name"],$imagem_dir); 
}else{
//exec("cwebp -q 85 ".escapeshellarg($arquivo["tmp_name"])." -o ".escapeshellarg($imagem_dir)."");
move_uploaded_file($arquivo["tmp_name"],$imagem_dir); 
}
}
echo "$imgok Smilie adicionado com sucesso <img src='/".$imagem_dir."' class='smilies' oncontextmenu='return false' onselectstart='return false' ondragstart='return false'> Codigo = ".$smile."!<br>";
}
}
}
}
}
}
}
}
}
}	
?>
<br><form action="/mod/addsmile" method="post" enctype="multipart/form-data">
Categoria:<br/><select name="cate">
<?php
$kat = $mistake->query("SELECT id, nm FROM w_emo_cat ORDER BY id desc");
while ($ka = $kat->fetch(PDO::FETCH_OBJ)) { ?>
<option value="<?php echo $ka->id;?>"><?php echo $ka->nm;?></option>
<?php 
} 
?>
</select>
<br>Smile: <input type="text" class="bt3" name="smile" required><br>
Arquivo: <label for='input-file'>
<input id='input-file' name='arquivo' type='file' value=''></label><br>
<input type="submit" class="bt3" value="Adicionar smile">
</form><br>
<?php	
}else
if($a=='fonte'){
?>
<br/><div id="titulo"><b>Fontes De Nick</b></div><br/>
<?
$upload_dir = 'estilo/';
$superdat = $_FILES['file']['tmp_name'];
$file_name = $_FILES['file']['name'];
$kbsize = (round($_FILES['file']['size']/1024));
$file_na = strrev("$file_name");
$file_na = strrev("$file_na");
$ext = explode(".",strrev($file_na));
switch(mb_strtolower($ext[0])){
case "ftt":
$tipo="ttf";
break;
case "piz":
$tipo="zip";
break;
}
if($tipo=="zip"){
$zip = new ZipArchive();
if($zip->open($superdat)  === true){
for ($i = 0; $i < $zip->numFiles; $i++) {
$tpozip =  $zip->getNameIndex($i);
if(strripos($tpozip,'.ttf') == true){
if(file_exists("estilo/".mb_strtoupper(str_ireplace('.ttf','',$tpozip),'UTF-8').".TTF")){
echo "<div align='center'>".mb_strtoupper(str_ireplace('.ttf','',$tpozip),'UTF-8')." ja existe renomeie o arquivo e tente novamente</div>";
}else{
$zip->extractTo('estilo/', array($tpozip));
rename("estilo/".$tpozip,"estilo/".mb_strtoupper(str_ireplace('.ttf','.TTF',$tpozip)));
echo"<div align='center'>Fonte ".mb_strtoupper(str_ireplace('.ttf','',$tpozip),'UTF-8')." Adicionada com sucesso</div>";
@unlink($testearray[62]);
$arquivo = glob('estilo/*.*'); 
$x=0;
foreach($arquivo as $file){ 
$file = str_replace("estilo/","",$file);
$file = str_replace(".TTF","",$file);
$textoarray .= "@font-face{font-family:'$file';src:url('/estilo/$file.TTF') format('truetype')}";
$x++;
} 
$namearray = 'fontes-by-nandosp-'.md5(time()).'.css';
$res = file_put_contents($namearray,$textoarray);
$textoarrayy = '<?php return array("'.$testearray[0].'","'.$testearray[1].'","'.$testearray[2].'","'.$testearray[3].'","'.$testearray[4].'","'.$testearray[5].'","'.$testearray[6].'","'.$testearray[7].'","'.$testearray[8].'","'.$testearray[9].'","'.$testearray[10].'","'.$testearray[11].'","'.$testearray[12].'","'.$testearray[13].'","'.$testearray[14].'","'.$testearray[15].'","'.$testearray[16].'","'.$testearray[17].'","'.$testearray[18].'","'.$testearray[19].'","'.$testearray[20].'","'.$testearray[21].'","'.$testearray[22].'","'.$testearray[23].'","'.$testearray[24].'","'.$testearray[25].'","'.$testearray[25].'","'.$testearray[27].'","'.$testearray[28].'","'.$testearray[29].'","'.$testearray[30].'","'.$testearray[31].'","'.$testearray[32].'","'.$testearray[33].'","'.$testearray[34].'","'.$testearray[35].'","'.$testearray[36].'","'.$testearray[37].'","'.$testearray[38].'","'.$testearray[39].'","'.$testearray[40].'","'.$testearray[41].'","'.$testearray[42].'","'.$testearray[43].'","'.$testearray[44].'","'.$testearray[45].'","'.$testearray[46].'","'.$testearray[47].'","'.$testearray[48].'","'.$testearray[49].'","'.$testearray[50].'","'.$testearray[51].'","'.$testearray[52].'","'.$testearray[53].'","'.$testearray[54].'","'.$testearray[55].'","'.$testearray[56].'","'.$testearray[57].'","'.$testearray[58].'","'.$testearray[59].'","'.$testearray[60].'","'.$testearray[61].'","'.$namearray.'","'.$testearray[63].'","'.$testearray[64].'","'.$testearray[65].'","'.$testearray[66].'","'.$testearray[67].'","'.$testearray[68].'","'.$testearray[69].'","'.$testearray[70].'");';
$namearrays = 'novoarray.php';
$namearrays = 'novoarray.php';
$res = file_put_contents($namearrays,print_r($textoarrayy, true));
}
$zip->close();
}
}
}else{
echo "<div align='center'>Erro: ao abrir $file_name </div>";
}
}else{
if($kbsize > 150){
echo "<div align='center'><b>Tamanho do arquivo utrapassa limite de 150 kb</b></div>";
}else{
if(file_exists("estilo/".mb_strtoupper(str_ireplace('.ttf','',$file_name),'UTF-8').".TTF")){
echo "<div align='center'>".mb_strtoupper(str_ireplace('.ttf','',$file_name),'UTF-8')." ja existe renomeie o arquivo e tente novamente</div>";
}else{
if($tipo=="ttf"){
move_uploaded_file("$superdat","".$upload_dir."".mb_strtoupper(str_ireplace('.ttf','',$file_name),'UTF-8').".TTF");
echo"<div align='center'>Fonte ".mb_strtoupper(str_ireplace('.ttf','',$file_name),'UTF-8')." Adicionada com sucesso</div>";
@unlink($testearray[62]);
$arquivo = glob('estilo/*.*'); 
$x=0;
foreach($arquivo as $file){ 
$file = str_replace("estilo/","",$file);
$file = str_replace(".TTF","",$file);
$textoarray .= "@font-face{font-family:'$file';src:url('/estilo/$file.TTF') format('truetype')}";
$x++;
} 
$namearray = 'fontes-by-nandosp-'.md5(time()).'.css';
$res = file_put_contents($namearray,$textoarray);
$textoarrayy = '<?php return array("'.$testearray[0].'","'.$testearray[1].'","'.$testearray[2].'","'.$testearray[3].'","'.$testearray[4].'","'.$testearray[5].'","'.$testearray[6].'","'.$testearray[7].'","'.$testearray[8].'","'.$testearray[9].'","'.$testearray[10].'","'.$testearray[11].'","'.$testearray[12].'","'.$testearray[13].'","'.$testearray[14].'","'.$testearray[15].'","'.$testearray[16].'","'.$testearray[17].'","'.$testearray[18].'","'.$testearray[19].'","'.$testearray[20].'","'.$testearray[21].'","'.$testearray[22].'","'.$testearray[23].'","'.$testearray[24].'","'.$testearray[25].'","'.$testearray[25].'","'.$testearray[27].'","'.$testearray[28].'","'.$testearray[29].'","'.$testearray[30].'","'.$testearray[31].'","'.$testearray[32].'","'.$testearray[33].'","'.$testearray[34].'","'.$testearray[35].'","'.$testearray[36].'","'.$testearray[37].'","'.$testearray[38].'","'.$testearray[39].'","'.$testearray[40].'","'.$testearray[41].'","'.$testearray[42].'","'.$testearray[43].'","'.$testearray[44].'","'.$testearray[45].'","'.$testearray[46].'","'.$testearray[47].'","'.$testearray[48].'","'.$testearray[49].'","'.$testearray[50].'","'.$testearray[51].'","'.$testearray[52].'","'.$testearray[53].'","'.$testearray[54].'","'.$testearray[55].'","'.$testearray[56].'","'.$testearray[57].'","'.$testearray[58].'","'.$testearray[59].'","'.$testearray[60].'","'.$testearray[61].'","'.$namearray.'","'.$testearray[63].'","'.$testearray[64].'","'.$testearray[65].'","'.$testearray[66].'","'.$testearray[67].'","'.$testearray[68].'","'.$testearray[69].'","'.$testearray[70].'");';
$namearrays = 'novoarray.php';
$namearrays = 'novoarray.php';
$res = file_put_contents($namearrays,print_r($textoarrayy, true));
}
}
}
}
?>
<form method="post" name="form1" enctype="multipart/form-data" action="/mod/fonte"> 
Somente Fontes em TTF ou ARQUIVO ZIP<br>
Fonte:<br><input id='input-file' name='file' type='file' value=''><br>
<input type="submit" class="bt3" value="Enviar" /> 
</form><br>
<?php 
}else
if($a=='edit_emocao') { 
$emocoes = $mistake->query("SELECT id, cod, cat FROM w_emocoes WHERE id='".$id."' ORDER BY id DESC limit 1")->fetch();
?>
<br/><div id="titulo"><b>Editar Emoções</b></div><br/>
<div align="center">
<?php
if($_POST['cod']==true){
$emocoes2 = $mistake->query("SELECT id, cod, cat FROM w_emocoes WHERE cod='".trim($_POST['cod'])."' ORDER BY id DESC limit 1")->fetch();
if($emocoes2[0]==true){
echo '<strong>Código já útilizado!</strong>';	
}else{
$mistake->exec("UPDATE w_emocoes SET cod='".trim($_POST['cod'])."' WHERE id='".$_GET['id']."'");
echo '<strong>Codigo atualizada com sucesso!</strong>';
}
}
if($_POST['cat']==true){	
$update = $mistake->prepare("UPDATE w_emocoes SET cat = ? WHERE id = ?");
$update->execute(array($_POST['cat'],$_GET['id'])); 
echo '<strong>Categoria atualizada com sucesso!</strong>';
}
$emocoes = $mistake->query("SELECT id, cod, cat FROM w_emocoes WHERE id='".$id."' ORDER BY id DESC limit 1")->fetch();
?>
</div>
<div align="center">
<img src="/e/<?php echo $id; ?>.gif" alt="x" ><br />
<?php echo $emocoes[1];?>
</div>
<br /><br />
<form action="/mod/edit_emocao/<?php echo $id;?>" method="post" enctype="multipart/form-data">
Código: <input type="text" name="cod" value="<?php echo $emocoes[1];?>" required><br/>
<input type="submit" value="Editar"></form>
<form action="/mod/edit_emocao/<?php echo $id;?>" method="post" enctype="multipart/form-data">
<?php
$emocoes22 = $mistake->query("SELECT id, nm FROM w_emo_cat WHERE id='".$emocoes[2]."' and venda='0' ORDER BY id DESC limit 1")->fetch();
?>
Categoria Atual <?php echo $emocoes22['nm'];?><br>
Categoria: <select name="cat">
<?php
$itens = $mistake->query("SELECT id, nm FROM w_emo_cat WHERE venda='0' ORDER BY nm");
while($item = $itens->fetch(PDO::FETCH_OBJ)) {
?>
<option value="<?php echo $item->id;?>"><?php echo $item->nm;?></option>
<?php
}
?>
</select><br/>
<input type="submit" value="Editar"></form><br><div align="center"><a href="/configuracoes/catemocoes">&#187;Voltar Emoções</a></div>
<?php
}else
if($a=='push') {
?>
<br/><div id="titulo"><b>Notificações Push</b></div><br/>Obs: este sistema permite enviar notificaçoes<br/>poup estilo <font color="red">WhatsApp</font> a todos usuarios inativos ou ativos que tenham as notificaçoes ativadas<br/><br/>
<?
if($_POST['texto']==true) {    
$url = "https://".$_SERVER['SERVER_NAME']."";
$response = sendMessageAll($meuid,$url,$_POST['texto']);
$return["allresponses"] = $response;
$return = json_encode($return);
echo "$imgok sucesso no envio<br/>";
}  
?>
<form action="/mod/push" method="post" enctype="multipart/form-data">
Texto: <input type="text" name="texto" value="" required><br/>
<input type="submit" value="Editar"></form>
<?php
}else if($a=='logs') {
$inaativoo = time()-15552000;
$inativoo = $mistake->query("SELECT count(*) FROM w_usuarios where ativo<'$inaativoo'")->fetch();
?>
<br/><div id="titulo"><b>Logs</b></div><br/>
<div id="div1"><a href="/mod/regpontos"><?php echo $imgseta;?> Pontos de usuários</a></div>
<div id="div2"><a href="/mod/usuinativos"><?php echo $imgseta;?> Usuários inativos(<?php echo $inativoo[0];?>)</a></div>
<div id="div1"><a href="/mod/acoescf"><?php echo $imgseta;?> Ações da Equipe</a></div><br/>
<?php 
}else 
if($a=='backup') {
?>
<br/><div id="titulo"><b>Backup Mysql</b></div><div align="center"><br/><b>Obs: faça esse procedimento apenas 1 vez por dia de preferencia apos as 22 horas</b><br/><br/>
Fazer backup agora ? <a href="/mod/backup/fazer">SIM</a> , <a href="/mod">NÃO</a>
<?
if($id=='fazer' and permdono($meuid)) {
require_once("".$_SERVER["DOCUMENT_ROOT"]."/backup_mysql_site.php");    
}
}else
if($a=='edicoes') {
$catemo = $mistake->query("SELECT count(*) FROM w_emo_cat WHERE venda='0'")->fetch();
$schat = $mistake->query("SELECT count(*) FROM w_schat")->fetch();
$pbloq = $mistake->query("SELECT count(*) FROM w_pbloq")->fetch();
$comucat = $mistake->query("SELECT count(*) FROM w_comu_cat")->fetch();
$forumcat = $mistake->query("SELECT count(*) FROM w_cat_forum")->fetch();
$forumsubcat = $mistake->query("SELECT count(*) FROM w_sub_forum")->fetch();
$quiz = $mistake->query("SELECT count(*) FROM w_quiz")->fetch();
$quiz1 = $mistake->query("SELECT count(*) FROM w_quiz2")->fetch();
$lojas = $mistake->query("SELECT count(*) FROM w_loja_m")->fetch();
$parceiros = $mistake->query("SELECT count(*) FROM w_parceiros")->fetch();
$frases = $mistake->query("SELECT COUNT(*) FROM w_frases")->fetch();
?>
<br/><div id="titulo"><b>Edições</b></div><br/>
<?
if(perm($meuid)>2){
?>
<!--<div id="div2"><a href="/mod/backup"><?php echo $imgseta;?> Fazer Backup do Banco de dados</a></div>-->
<div id="div1"><a href="/mod/geral"><?php echo $imgseta;?> Configurações gerais</a></div>
<div id="div2"><a href="/mod/catemocoes"><?php echo $imgseta;?> Categorias de emoções(<?php echo $catemo[0];?>)</a></div>
<div id="div1"><a href="/mod/pbloq"><?php echo $imgseta;?> Palavras bloqueadas(<?php echo $pbloq[0];?>)</a></div>
<div id="div2"><a href="/mod/schat"><?php echo $imgseta;?> Salas de chat(<?php echo $schat[0];?>)</a></div>
<div id="div1"><a href="/mod/comunidades"><?php echo $imgseta;?> Cat. de comunidades(<?php echo $comucat[0];?>)</a></div>
<div id="div2"><a href="/mod/cat_forum"><?php echo $imgseta;?> Categorias do fórum(<?php echo $forumcat[0];?>)</a></div>
<div id="div1"><a href="/mod/cat_sub_forum"><?php echo $imgseta;?> Sub-Categorias do fórum(<?php echo $forumsubcat[0];?>)</a></div>
<?
}
?>
<div id="div2"><a href="/mod/quiz"><?php echo $imgseta;?> Quiz(<?php echo $quiz[0].'/'.$quiz1[0];?>)</a></div>
<div id="div1"><a href="/mod/loja_m"><?php echo $imgseta;?> Lojas de presente(<?php echo $lojas[0];?>)</a></div>
<div id="div2"><a href="/mod/parceiros"><?php echo $imgseta;?> Parceiros(<?php echo $parceiros[0];?>)</a></div>
<div id="div1"><a href="/mod/frases"><?php echo $imgseta;?> Frases do site(<?php echo $frases[0];?>)</a></div>
<?php 
$entrevista= $mistake->query("SELECT entrevista FROM w_geral WHERE id='1'")->fetch();
if($entrevista[0]=='1')
{
?>
<div id="div2"><a href="/mod?e=desativar_entrevista"><?php echo $imgseta;?>Desativar entrevista</a></div>
<?php
}else{
?>
<div id="div2"><a href="/mod?e=ativar_entrevista"><?php echo $imgseta;?>Ativar entrevista</a></div>
<?php 
}
?>
<?php 
$reuniao= $mistake->query("SELECT reuniao FROM w_geral WHERE id='1'")->fetch();
if($reuniao[0]=='1')
{
?>
<div id="div2"><a href="/mod?e=desativar_reuniao"><?php echo $imgseta;?>Desativar reuniao</a></div>
<?php
}else{
?>
<div id="div2"><a href="/mod?e=ativar_reuniao"><?php echo $imgseta;?>Ativar reuniao</a></div>
<?php 
}
?>
<?php
}else 
if($a=='deletartime'){
$pasta = "times/".$id.".gif";   
@unlink($pasta);
$mistake->exec("DELETE FROM w_times WHERE id='".$id."'");
echo "$imgok Time deletado com sucesso";
}else
if($a=='times') { 
?>
<div id="titulo"><b>Times de Futebol</b></div><br/>
<?
$nome = $_FILES['arquivo']['name'];
$ext = explode('.', $nome);
$ext = strtolower($ext[count($ext) - 1]);
$img_type = $_FILES['arquivo']['type'];
if($img_type==true){
if(!preg_match("/^image\/(pjpeg|jpeg|png|gif)$/", $img_type)){
?>
<?php echo $imgerro?>A extenção do arquivo é inválida!<?php
}else{
$res = $mistake->prepare("INSERT INTO w_times SET nm='".$_POST["time"]."',pais='".$ext."'");
$res->execute(); 
$resok = $mistake->lastInsertId();
$imagem_dir = "times/".$resok.".gif";
if($img_type=='image/gif'){
//exec("gif2webp -q 85 ".escapeshellarg($_FILES['arquivo']['tmp_name'])." -o ".escapeshellarg($imagem_dir)."");
move_uploaded_file($arquivo["tmp_name"],$imagem_dir); 
}else{
//exec("cwebp -q 85 ".escapeshellarg($_FILES['arquivo']['tmp_name'])." -o ".escapeshellarg($imagem_dir)."");
move_uploaded_file($arquivo["tmp_name"],$imagem_dir); 
}
echo "$imgok Time adicionado com sucesso <img src='/".$imagem_dir."' width='50px' height='50px'>";
}
}
?>
<div align="center">
<form action="/mod/times" method="post" enctype="multipart/form-data">
Nome Time:
<input type="text" name="time" required><br/>    
Imagem:
<input type="file" name="arquivo"><br/>
<input type="submit" value="Inserir">
</div>
</form>   
</div>
<?
}else
if($a=='delquizmural') { 
$mistake->exec("DELETE FROM bymistake_quizmural WHERE id='".$id."'");
echo "<br/><center><big><b>quiz deletado!</b></big></center><br/>";
}else
if($a=='zerarquizmural') { 
if($id=='1'){
$mistake->exec("UPDATE w_usuarios set quizmural='0', quizmuralacertoshj='0', quizmuralerroshj='0'");
echo "<br/><center><big><b>Erros e acertos zerados!</b></big></center><br/>";
}else if($id=='2'){
$mistake->exec("update w_usuarios set quizmural='1'");
echo "<br/><center><big><b>Quiz encerrado com sucesso!</b></big></center><br/>";
}
}else
if($a=='quizmural') { 
?>
<div id="titulo"><b>Quiz Mural</b></div><br/>
<div align="center">
<br/>No quiz mural você posta as perguntas e os usuários podem responde-las através do mural da equipe. E ainda você pode acompanhar quem acertou ou errou atráves do raking.<br/><br/>
<i>OBS: Lembre-se de zerar os erros e acertos do quiz antes de inicia-lo pela primeira vez em um dia</i><br/> 
<a href="/mod/zerarquizmural/1"><b>Zerar erros e acertos do quiz mural de hoje</b></a><br/>
<i>Ao final do quiz por favor clique em fechar o quiz, para que todos usuários possam voltar a visualizar o mural da equipe.</i><br/>
<a href="/mod/zerarquizmural/2"><b>Fechar quiz de hoje</b></a><br/><br/>
<form action="/mod/quizmural" method="post">
Pergunta:<br/>
<textarea style="width:-webkit-fill-available" name="prg" maxlength="300" value="" rows="5" cols="25"></textarea><br/>
1º resposta:<br/>
<input type="text" size="35" name="pr" required><br/>
2º resposta:<br/>
<input type="text" size="35" name="sr" required><br/>
3º resposta:<br/>
<input type="text" size="35" name="tr" required><br/>
Resposta certa:<br/><select name="rc">
<option value="1">Primeira</option>
<option value="2">Segunda</option>
<option value="3">Terceira</option>
</select><br/>
<br/>Valendo: <input type="text" size="5" name="pontos"> pontos<br/><br/>
<input type="submit" value="Add"></form></div>
<?php
if(isset($_POST['prg'])!=''){
$mistake->exec("update w_usuarios set quizmural='0'");
$res = $mistake->prepare("INSERT INTO bymistake_quizmural (prg,r1,r2,r3,ct,pontos) VALUES (?,?,?,?,?,?)");
$arrayName = array($_POST['prg'],$_POST['pr'],$_POST['sr'],$_POST['tr'],$_POST['rc'],$_POST['pontos']);
$ii = 0;
for($i=1; $i <=6; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
}
$contemo = $mistake->query("SELECT COUNT(*) FROM bymistake_quizmural")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contemo[0];
$itensporpag = 8;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->query("SELECT id, prg FROM bymistake_quizmural ORDER BY id desc LIMIT $limit, $itensporpag");
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<?php echo $item->prg;?> - <a href="/mod/delquizmural/<?php echo $item->id;?>"><font color="red">[x]</font></a></div>
<?php $i++; } 
if($numpag>1) {
paginas('mod',$a,$numpag,$id,$pag);    
} } else { ?>
<div align="center"><br/><?php echo $imgerro;?>Nenhuma pergunta!<br/>
<?php } ?>
<div align="center">
<br/><a href="/quizmural/ranking">Ranking</a><br/><br/>
<?php } else 
if($a=='ajuda') { ?>
<div id="titulo"><b>Sugestões de usuários</b></div><br/>
<?php
if($pag=='resolvido'){
$mistake->exec("update w_ajuda set ac='1', eqp='$meuid' WHERE id='".$id."'");
}
if($pag=='apagar'){
$mistake->exec("DELETE FROM w_ajuda WHERE id='".$id."'");   
}
$contemo = $mistake->query("SELECT COUNT(*) FROM w_ajuda WHERE smile='0'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contemo[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->query("SELECT * FROM w_ajuda WHERE smile='0' ORDER BY id desc LIMIT $limit, $itensporpag");
$i=0; 
while ($item = $itens->fetch(PDO::FETCH_OBJ)) { 
?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<a href="/<?php echo gerarlogin($item->uid);?>"><?php echo gerarnome($item->uid);?></a>: <?php echo $item->txt;?>
<?php 
if($item->ac==1 && perm($meuid)==3 or perm($meuid)==4) { 
?>
<a href="/mod/ajuda/<?php echo $item->id;?>/apagar"><font color="#FF0000"> [Apagar]</font></a>
<?php 
}
?>
</div><hr>
<?php 
$i++; 
}
if($numpag>1) { 
paginas('mod',$a,$numpag,$id,$pag);    
} 
} else { 
?>
<div align="center"><?php echo $imgerro;?>Nenhum pedido de ajuda!<br/>
<?php
} 
}else 
if($a=='excluirdados') {
$msgcol = $mistake->query("SELECT count(*) FROM w_msgs where por='$meuid' and dl='1'")->fetch(); 
?>
<br/><div id="titulo"><b>Excluir dados</b></div><br/>
<div id="div1"><a href="/mod/0/toponline"><?php echo $imgseta;?> Zerar Top Online</a></div>
<div id="div2"><a href="/mod/0/delmsg"><?php echo $imgseta;?> Excluir minhas mensagens coletivas(<?php echo $msgcol[0];?>)</a></div>
<div id="div1"><a href="/mod/0/delmsgslidas"><?php echo $imgseta;?> Excluir mensagens com mais de 2 dias lidas</a></div>
<div id="div2"><a href="/mod/0/delmsgs"><?php echo $imgseta;?> Excluir mensagens com mais de 2 dias não lidas</a></div>
<div id="div1"><a href="/mod/0/deltopjogos"><?php echo $imgseta;?> Excluir Tops Jogos</a></div>
<div id="div2"><a href="/mod/0/delfriendzoo"><?php echo $imgseta;?> Excluir Friendzoo</a></div>
<div id="div1"><a href="/mod/0/delduelo"><?php echo $imgseta;?> Excluir Duelo de Fotos</a></div>
<div id="div2"><a href="/mod/0/delhall"><?php echo $imgseta;?> Excluir hall</a></div>
<div id="div1"><a href="/mod/0/delvisitas"><?php echo $imgseta;?> Excluir Visitas</a></div>
<div id="div2"><a href="/mod/0/delrecuser"><?php echo $imgseta;?> Excluir murais usuarios com mais de 2 dias</a></div>
<div id="div1"><a href="/mod/0/delrecequipe"><?php echo $imgseta;?> Excluir murais equipe com mais de 2 dias</a></div>
<div id="div2"><a href="/mod/0/delrecdivul"><?php echo $imgseta;?> Excluir murais divulgaçao com mais de 2 dias</a></div>
<div id="div1"><a href="/mod/0/delrecpensa"><?php echo $imgseta;?> Excluir pensamentos com mais de 2 dias</a></div>
<div id="div2"><a href="/mod/0/limpar"><?php echo $imgseta;?> zerar murais</a></div>
<div id="div1"><a href="/mod/0/limparm"><?php echo $imgseta;?> zerar mensagens</a></div>
<div id="div2"><a href="/mod/0/delchat"><?php echo $imgseta;?> Zerar salas de bate papo</a></div>
<div id="div1"><a href="/mod/0/midias"><?php echo $imgseta;?> Apagar Multimidias</a></div>
<div id="div2"><a href="/mod/0/limparlogs"><?php echo $imgseta;?> Apagar Logs</a></div>
<?php 
}else 
if($a=='excluirusu') {
if(permdono($meuid) and !permdono($id)) { 
$txtt = "excluiu [b] ".gerarnome2($id)." [/b], ID: [b] $id [/b]. Data: [i] $data [/i] ";
editandopostagem($meuid,$txtt);
apagardevez($id);
$res = $mistake->exec("DELETE FROM w_usuarios WHERE id='".$id."'");
if($res) { 
?>
<br/><div align="center"><?php echo $imgok;?>Usuário excluído com sucesso!<br/>
<?php 
} else { 
?>
<br/><div align="center"><?php echo $imgerro;?>Erro ao excluir usuário<br/>
<?php 
} 
}else{
?>
<br/><div align="center"><?php echo $imgerro;?>Permição negada.!<br/>
<?php     
}
}else if($a=='mensagem') { 
?>
<br/><div id="titulo"><b>Mensagem para todos</b></div><br/>
<form action="/mod/mensagem2" method="post">
Mensagem:<br/><input type="text" name="msg" required><br/>
Para:<br/>
<select name="para">
<option value="1">Somente Equipe</option>
<option value="2">Equipe e Vips</option>
<option value="3">Todos Usuários</option></select><br/>
<div class="color-btn-wrapper"><button class="btn"><i class="bt_color"></i></button><input type="color" name="cortexto" id="cortexto" value="#000000"></div>
<br /><img src="/imgs/font.png"><input type="checkbox" value="1" name="negrito" id="formato"/><b>b</b><input type="checkbox" value="2" name="italico" id="formato"/><i>i</i><input type="checkbox" value="3" name="riscado" id="formato"/><u>u</u><input type="checkbox" value="4" name="grande" id="formato"/><big>big</big><br/><br/>
<input type="submit" value="Enviar">
</form>
<?php } else if($a=='mensagem2') {
$mensagem = $_POST['msg'];    
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
$mensagem = "$t$t2$t4$t6$mensagem$t7$t5$t3$t1";
if($_POST['para']==1){
$msgs = $mistake->prepare("SELECT id FROM w_usuarios WHERE (perm>'0' or perm2>'0')");
$suc = "membros da equipe";
}else if($_POST['para']==2){
$msgs = $mistake->prepare("SELECT id FROM w_usuarios WHERE (perm>'0' or vip>'0')");
$suc = "usuários vip e equipe";
}else{
$msgs = $mistake->prepare("SELECT id FROM w_usuarios WHERE banido='0'");
$suc = "usuários";
}
$msgs->execute();
while ($msg = $msgs->fetch(PDO::FETCH_OBJ)) {
automsg(''.$mensagem.' [br/](Esta é uma mensagem coletiva, enviada por um membro da equipe, não é necessário respondê-la).',$meuid,$msg->id,$_POST['cortexto']);
}
?>
<br/><div align="center"><?php echo $imgok;?>Mensagem enviada com sucesso para todos <?php echo $suc;?> <br/><br/><?php echo $_POST['msg'];?><br/>
<?php } else
if($a=='cores_site') { 
?>
<br/><div id="titulo"><b>Cores do site</b></div><br/>
<?php
if(perm($meuid)>0){
if($_POST){
$arquivo = isset($_FILES["arquivo"]) ? $_FILES["arquivo"] : FALSE;
$pasta = "style/";
if (!empty($arquivo["name"])){
$_UP['extensoes'] = array('jpeg','png','gif','bmp','jpg');
$extensao = strtolower(end(explode('.', $_FILES['arquivo']['name'])));
if (array_search($extensao, $_UP['extensoes']) === false) {
echo "Extenção inválidade!";
}else{  
$nome = "".time().".$extensao";    
$url = $pasta.$nome;
@unlink($pasta.$testearray[55]);
if($extensao=='gif'){
exec("gif2webp -q 85 ".escapeshellarg($_FILES['arquivo']['tmp_name'])." -o ".escapeshellarg($url)."");
}else{
exec("cwebp -q 85 ".escapeshellarg($_FILES['arquivo']['tmp_name'])." -o ".escapeshellarg($url)."");
}
if($_POST["imagem"]==1){
$imagemfundo = "background: url(/$url) repeat;";    
}else
if($_POST["imagem"]==2){
$imagemfundo = "background: url(/$url) no-repeat center;";    
}else
if($_POST["imagem"]==3){
$imagemfundo = "background: url(/$url) no-repeat;background-size:cover;";   
}else
if($_POST["imagem"]==4){
$imagemfundo = "background: url(/$url);background-size:contain;background-repeat: round;"; 
}
$bfundo = "rgba(0,0,0,0)";
}
}else{
@unlink($pasta.$testearray[55]);    
$imagemfundo = "";
$nome = "";
$bfundo = $_POST["corfundo"];
}
if($_POST["gradiente"]==1){
$gradiente = "background: linear-gradient(135deg,  ".$_POST["linha1"]." 0%,".$_POST["linha2"]." 50%,".$_POST["linha1"]." 51%,".$_POST["linha2"]." 100%);";
$gradiente1 = "background: linear-gradient(135deg,  ".$_POST["linha2"]." 0%,".$_POST["linha1"]." 50%,".$_POST["linha2"]." 51%,".$_POST["linha1"]." 100%);";
$gradiente2 = "background: linear-gradient(135deg,  ".$_POST["rodape"]." 0%,".$_POST["linha1"]." 50%,".$_POST["linha2"]." 51%,".$_POST["rodape"]." 100%);";
$gradiente3 = "background: linear-gradient(135deg,  ".$_POST["balao2"]." 0%,".$_POST["balao1"]." 50%,".$_POST["balao2"]." 51%,".$_POST["balao1"]." 100%);";
$gradiente4 = "background: linear-gradient(135deg,  ".$_POST["balao2"]." 0%,".$_POST["balao1"]." 50%,".$_POST["balao2"]." 51%,".$_POST["balao1"]." 100%);";
$gradiente5 = "background: linear-gradient(135deg,  ".$_POST["murais"]." 0%,".$_POST["balao1"]." 50%,".$_POST["balao2"]." 51%,".$_POST["murais"]." 100%);";
$gradiente6 = "background: linear-gradient(135deg,  ".$_POST["fieldset"]." 0%,".$_POST["linha1"]." 50%,".$_POST["linha2"]." 51%,".$_POST["fieldset"]." 100%);";
$gradiente7 = "background: linear-gradient(135deg,  ".$_POST["fundo"]." 0%,".$_POST["linha2"]." 50%,".$_POST["linha1"]." 51%,".$_POST["fundo"]." 100%);";
$gradiente8 = "background: linear-gradient(135deg,  ".$_POST["titulo"]." 0%,".$_POST["murais"]." 50%,".$_POST["rodape"]." 51%,".$_POST["titulo"]." 100%);";
}else
if($_POST["gradiente"]==2){
$gradiente = "background-image: radial-gradient(#f3f3f3,".$_POST["linha2"].",".$_POST["linha1"].");";
$gradiente1 = "background-image: radial-gradient(#D6DADC,".$_POST["linha1"].",".$_POST["linha2"].");";
$gradiente2 = "background-image: radial-gradient(".$_POST["linha1"].", ".$_POST["linha2"].",".$_POST["rodape"].");";
$gradiente3 = "background-image: radial-gradient(#D6DADC,#f3f3f3,".$_POST["balao1"].");";
$gradiente4 = "background-image: radial-gradient(#D6DADC,#f3f3f3,".$_POST["balao2"].");";
$gradiente5 = "background-image: radial-gradient(".$_POST["balao1"].",".$_POST["balao2"].",".$_POST["murais"].");";
$gradiente6 = "background-image: radial-gradient(#D6DADC,#f3f3f3,".$_POST["fieldset"].");";
$gradiente7 = "background-image: radial-gradient(#D6DADC,#f3f3f3,".$_POST["fundo"].");";
$gradiente8 = "background-image: radial-gradient(".$_POST["murais"].",#f3f3f3,".$_POST["titulo"].");";
}else
if($_POST["gradiente"]==3){
$gradiente = "background: linear-gradient(to right, ".$_POST["linha1"]." 0%, ".$_POST["linha2"]." 50%, ".$_POST["linha2"]." 51%, ".$_POST["linha1"]." 100%);";
$gradiente1 = "background: linear-gradient(to right, ".$_POST["linha2"]." 0%, ".$_POST["linha1"]." 50%, ".$_POST["linha1"]." 51%, ".$_POST["linha2"]." 100%);";
$gradiente2 = "background: linear-gradient(to right, ".$_POST["rodape"]." 0%, ".$_POST["fieldset"]." 50%, ".$_POST["fieldset"]." 51%, ".$_POST["rodape"]." 100%);";
$gradiente3 = "background: linear-gradient(to right, ".$_POST["balao1"]." 0%, ".$_POST["balao2"]." 50%, ".$_POST["balao2"]." 51%, ".$_POST["balao1"]." 100%);";
$gradiente4 = "background: linear-gradient(to right, ".$_POST["balao2"]." 0%, ".$_POST["balao1"]." 50%, ".$_POST["balao1"]." 51%, ".$_POST["balao2"]." 100%);";
$gradiente5 = "background: linear-gradient(to right, ".$_POST["murais"]." 0%, ".$_POST["fieldset"]." 50%, ".$_POST["fieldset"]." 51%, ".$_POST["murais"]." 100%);";
$gradiente6 = "background: linear-gradient(to right, ".$_POST["fieldset"]." 0%, ".$_POST["balao2"]." 50%, ".$_POST["balao2"]." 51%, ".$_POST["fieldset"]." 100%);";
$gradiente7 = "background: linear-gradient(to right, ".$_POST["fundo"]." 0%, ".$_POST["balao1"]." 50%, ".$_POST["balao1"]." 51%, ".$_POST["fundo"]." 100%);";
$gradiente8 = "background: linear-gradient(to right, ".$_POST["titulo"]." 0%, ".$_POST["fieldset"]." 50%, ".$_POST["fieldset"]." 51%, ".$_POST["titulo"]." 100%);";
}else{
$gradiente = "background: ".$_POST["linha1"].";";
$gradiente1 = "background: ".$_POST["linha2"].";";
$gradiente2 = "background: ".$_POST["rodape"].";";
$gradiente3 = "background: ".$_POST["balao1"].";";
$gradiente4 = "background: ".$_POST["balao2"].";";
$gradiente5 = "background: ".$_POST["murais"].";";
$gradiente6 = "background: ".$_POST["fieldset"].";";
$gradiente7 = "background: ".$_POST["fundo"].";";
$gradiente8 = "background: ".$_POST["titulo"].";";
}
if($_POST["menuone"]==0){
$div1 ="#div1{".$gradiente."margin: 2px;padding: 5px;border-top: 1px solid ".$_POST["linha1"].";border-radius: 5px;border: 1px solid ".$_POST["linha1"]."}#div2{".$gradiente1."margin: 2px;padding: 5px;border-top: 1px solid ".$_POST["linha2"].";border-radius: 5px;border: 1px solid ".$_POST["linha2"]."}#rodape{padding:8px;height:auto;border-radius: 5px;border: 1px solid ".$_POST["rodape"].";".$gradiente2."color: ".$_POST["fonte_barras"].";font-weight: bold;font-size: 13pt;text-align: center;}#titulo {".$gradiente8."color: ".$_POST["fonte_barras"].";border-radius: 5px;border: 1px solid ".$_POST["titulo"].";margin: 2px;padding: 6px;text-align: center;font-weight: bold;}#barra_mural {".$gradiente5."color: ".$_POST["fonte_barras"].";border-radius: 5px;border: 1px solid ".$_POST["murais"].";padding: 7px;margin:2px;text-align: center;font-weight: bold;text-decoration: none}#fundo_mural {".$gradiente7."border-top: 1px solid #FFFAFA;border-radius: 5px;border: 1px solid #828282;text-align: center}#barra_mural, #rodape, #titulo {box-shadow: inset 0 2px 3px 0 rgba(255,255,255,.3), inset 0 -3px 6px 0 rgba(0,0,0,.2), 0 3px 2px 0 rgba(0,0,0,.2);}";
}else if($_POST["menuone"]==1){	
$div1 ="#div1,#div2{padding: 5px;}#titulo,#rodape,#barra_mural{padding: 5px;text-align: center;font-weight: bold;}";
}else if($_POST["menuone"]==2){	
$div1 ="#div1,#div2{padding: 5px;}#titulo,#rodape,#barra_mural{".$gradiente2."border-radius: 5px;padding: 5px;text-align: center;font-weight: bold;}#rodape{".$gradiente2."}#titulo{".$gradiente8."}#barra_mural{".$gradiente5."}";
}
$div2 = ".confirm {display: none;background-color: #000;color:white;position: fixed;max-width: 300px;padding: 8px;bottom: 8%;left: 50%;margin-left: -158px;border-radius: 5px;text-align: center;}.confirm button {background-color: #a3d1d1;display: inline-block;border-radius: 5px;padding: 5px;text-align: center;width: 100%;cursor: pointer;}.confirm .message {text-align: center}fieldset,legend {padding: 5px;height: auto;border-radius:5px;border:1px solid ".$_POST["fieldset"].";".$gradiente6."}";
if(!empty($_POST['ads'])){
$adsm ="<div class='confirm'><div class='message'></div><div id='mistake'></div><img src='/aviso.png' width='90'/><!-- SocialCrazy --><ins class='adsbygoogle' style='display:inline-block;width:300px;height:250px' data-ad-client='".$_POST['ads']."' data-ad-slot='1666938726'></ins><button class='yes'>Fechar</button></div>";
$ads = $_POST['ads'];
}else{
$ads = '';
$adsm = '';    
}
@unlink($testearray[59]);
$arrayname = ''.md5(time()).'.css';
$texto = "<meta name='theme-color' content='".$_POST["rodape"]."'><link href='/".$arrayname."' type='text/css' rel='stylesheet'/>".$adsm."";
$textoarray = '<?php return array("'.$_POST["tamanhofonte"].'","'.$_POST["fonte"].'","'.$_POST["rodape"].'","'.$_POST["titulo"].'","'.$_POST["murais"].'","'.$_POST["fundo"].'","'.$_POST["balao1"].'","'.$_POST["balao2"].'","'.$_POST["linha1"].'","'.$_POST["linha2"].'","'.$_POST["links"].'","'.$_POST["fonte_barras"].'","'.htmlspecialchars($_POST["textobody"]).'","'.$bfundo.'","'.$ads.'","'.$testearray[15].'","'.$testearray[16].'","'.$testearray[17].'","'.$testearray[18].'","'.$testearray[19].'","'.$testearray[20].'","'.$testearray[21].'","'.$testearray[22].'","'.$testearray[23].'","'.$testearray[24].'","'.$testearray[25].'","'.$testearray[26].'","'.$testearray[27].'","'.$testearray[28].'","'.$testearray[29].'","'.$testearray[30].'","'.$testearray[31].'","'.$testearray[32].'","'.$testearray[33].'","'.$testearray[34].'","'.$testearray[35].'","'.$testearray[36].'","'.$_POST["fieldset"].'","'.$testearray[38].'","'.$testearray[39].'","'.$_POST["menuone"].'","'.$testearray[41].'","'.$_POST["textoperga"].'","'.$_POST["perga"].'","'.htmlspecialchars($texto).'","'.$_POST["rolagem"].'","'.$testearray[46].'","'.$testearray[47].'","'.$_POST["gradiente"].'","'.$testearray[49].'","'.$testearray[50].'","'.$testearray[51].'","'.$testearray[52].'","'.$testearray[53].'","'.$testearray[54].'","'.$nome.'","'.$testearray[56].'","'.$testearray[57].'","'.$testearray[58].'","'.$arrayname.'","'.$testearray[60].'","'.$testearray[61].'");';
$arraytexto = ".container{".$imagemfundo."}body {background:".$bfundo.";max-width:100%;height:auto;width:auto;font-family:".$_POST["textobody"]."; font-size: ".$_POST["tamanhofonte"]."; font-weight: normal; color: ".$_POST["fonte"]."; margin: 0px ;padding: 3px}".$div1."".$div2."section{max-width:auto;background-color:#fff}.turbolinks-progress-bar {background: ".$_POST["rolagem"].";}::-webkit-scrollbar {width: 6px !important;height: 6px !important;}::-webkit-scrollbar-thumb {background: ".$_POST["rolagem"]."!important;box-shadow: unset;border-radius: 4px;}::-webkit-scrollbar-track {background: #D6DADC;}#scroll-top {background:".$_POST["titulo"].";line-height: 22px;position: fixed;bottom: 50px;padding: 5px 10px;border-radius: 5px;z-index: 9999;right: 0px;display: none;}.up { transform: rotate(-135deg);}mis{ border: solid white;border-width: 0 3px 3px 0;display: inline-block;padding: 3px;}.chat ul{list-style:none;padding:0;margin:0}.chat ul li{margin:45px 0 0}.chat ul li a.user{margin:-30px 0 0;display:block;color:#333}.chat ul li a.user img{width:55px;height:55px;border-radius:50%;background-color:#f3f3f3;box-shadow:0 2px 6px rgba(0,0,0,.3)}.chat ul li .date{color:#a6a6a6}.chat ul li .message{display:block;padding:10px;position:relative;".$gradiente3."}.chat ul li .message:before{content:'';position:absolute;border-top:16px solid rgba(0,0,0,.15);border-left:16px solid transparent;border-right:16px solid transparent}.chat ul li .message:after{content:'';position:absolute;top:0;border-top:17px solid ".$_POST['balao1'].";border-left:17px solid transparent;border-right:17px solid transparent}.chat ul li .message.blur p{-webkit-filter:blur(3px);-moz-filter:blur(3px);-o-filter:blur(3px);-ms-filter:blur(3px);filter:blur(3px)}.chat ul li .message.blur .hider{opacity:1;z-index:1}.chat ul li .message p{margin:0;padding:0;transition:all .1s}.chat ul li .message .hider{opacity:0;z-index:-1;position:absolute;height:100%;width:100%;margin:-10px;text-align:center;cursor:pointer;transform-style:preserve-3d;transition:all .1s}.chat ul li .message .hider span{display:block;position:relative;top:50%;transform:translateY(-50%)}.chat ul li .message2{display:block;padding:10px;position:relative;".$gradiente4."}.chat ul li .message2:before{content:'';position:absolute;border-top:16px solid rgba(0,0,0,.15);border-left:16px solid transparent;border-right:16px solid transparent}.chat ul li .message2:after{content:'';position:absolute;top:0;border-top:17px solid ".$_POST['balao2'].";border-left:17px solid transparent;border-right:17px solid transparent}.chat ul li .message2.blur p{-webkit-filter:blur(3px);-moz-filter:blur(3px);-o-filter:blur(3px);-ms-filter:blur(3px);filter:blur(3px)}.chat ul li .message2.blur .hider{opacity:1;z-index:1}.chat ul li .message2 p{margin:0;padding:0;transition:all .1s}.chat ul li .message2 .hider{opacity:0;z-index:-1;position:absolute;height:100%;width:100%;margin:-10px;text-align:center;cursor:pointer;transform-style:preserve-3d;transition:all .1s}.chat ul li .message2 .hider span{display:block;position:relative;top:50%;transform:translateY(-50%)}.chat ul li.other a.user{float:right}.chat ul li.other .date{float:right;margin:-20px 10px 0 0}.chat ul li.other .message{margin:0 90px 0 0}.chat ul li.other .message:before{margin:-9px -16px 0 0;right:0}.chat ul li.other .message:after{content:'';right:0;margin:0 -15px 0 0}.chat ul li.other .message2{margin:0 90px 0 0}.chat ul li.other .message2:before{margin:-9px -16px 0 0;right:0}.chat ul li.other .message2:after{content:'';right:0;margin:0 -15px 0 0}.chat ul li.you a.user{float:left}.chat ul li.you .date{float:left;margin:-20px 0 0 10px}.chat ul li.you .message{margin:0 0 0 90px}.chat ul li.you .message:before{margin:-9px 0 0 -16px;left:0}.chat ul li.you .message:after{content:'';left:0;margin:0 0 0 -15px}.chat ul li.you .message2{margin:0 0 0 90px}.chat ul li.you .message2:before{margin:-9px 0 0 -16px;left:0}.chat ul li.you .message2:after{content:'';left:0;margin:0 0 0 -15px}#messagem1{margin: 2px;padding: 7px;".$gradiente3."border-top: 1px solid ".$_POST["balao1"].";border-radius: 5px;border: 1px solid ".$_POST["balao1"]."}#messagem2{margin: 2px;padding: 7px;".$gradiente4."border-top: 1px solid ".$_POST["balao2"].";border-radius: 5px;border: 1px solid ".$_POST["balao2"]."}input[type='file']{display:inline;height:auto;width:208px}a:link {font-weight: bold;text-decoration:none;color:".$_POST["links"]."}a:visited  {font-weight: bold;text-decoration:none;color:".$_POST["fonte"]."}a:hover {text-decoration: none;font-weight: bold;color:".$_POST["links"].";}table,td,tr,input,body{border-radius:5px}blink {animation: blinker 1.4s linear infinite;}@keyframes blinker {50% { opacity: 0; }}audio { width: 180px; }.opc1 { background: #D8D8BF;margin:0px;color: #333333;border-radius:10px;font-weight: bold;margin:2px;padding:3px 3px 3px 3px;border-color:white;border-style:groove ridge ridge groove;border-width:2px;color:black;text-align:center}.opc2 { background:#D8D8BF;margin:0px;color: #333333;border-radius:10px;font-weight: bold;margin:2px;padding:3px 3px 3px 3px;border-color:white;border-style:groove ridge ridge groove;border-width:2px;color:black;text-align:center}.opc3 { background: #E6E6FA;margin:0px;color: #333333;border-radius:15px;font-weight: bold;margin:2px;padding:3px 3px 3px 3px;border-color:white;border-style:groove ridge ridge groove;border-width:2px;color:black;text-align:center}#opc4 {border-top: 1px solid #FFFAFA;border-radius: 5px;border: 1px solid #828282;padding: 5px;margin:2px;text-align: center;text-decoration: none;}#opc44 { background: #CFCFCF;margin:2px;border: 0px solid #333333; padding: 3px; color: #333333; border-top: 1px solid #FFFAFA;border-radius: 5px;border: 1px solid #828282}input, radio, select, textarea ,.bt3{background-color: #eeeeee;background-image: -webkit-linear-gradient(top, #eeeeee, #cccccc);border: 1px solid #ccc;border-bottom: 1px solid #bbb;border-radius: 3px;color: #333;padding: 7px 7px 7px 7px;text-decoration: none;margin: 1px;font-weight: 700;vertical-align: middle;display: table-cell;border: 1px solid #CDC9C9;}.tituloWrapper {display: inline-block;position: relative}.titulo {min-width:80px;position: absolute;display: none;border: 1px solid #000;padding: 5px;background-color:#000;text-align : center; color: #FFF;left: -0%;bottom: -30px;z-index: 99;}.titulo:before{content: ' ';display: block;position: absolute;left: 5px;top: -8px;width: 10px;height: 10px;border-color: #000;border-width: 1px;border-style: solid none none solid;background-color: #000;transform: rotate(45deg)}.tituloWrapper:hover .titulo {display:block}.smilies{max-width:140px;max-height:140px}.dropdown {position: relative;display: inline-block}.dropdown-content {display: none;position: absolute;left: 0;background-color: #f9f9f9;min-width: 120px;box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);z-index: 1}.dropdown-content a {color: black;padding: 8px 10px;text-decoration: none;display: block}.dropdown-content a:hover {background-color: #f1f1f1}.dropdown:hover .dropdown-content {display: block}@keyframes bounce {0%, 20%, 60%, 100% {transform: translateY(0);}40% {transform: translateY(-20px);}80% {transform: translateY(-10px);}}.mistakehover:hover {animation: bounce 3s}.dropdown:hover .dropdown-content {display: block}#fotofila,#fotogato,#fotogata{box-shadow: 0 2px 6px rgba(0,0,0,.3);border-radius: 50%;shape-outside: circle();shape-margin: 15px;text-align: center;}.avisomsj{width:max-230px;bottom:40px;right:5px;position:fixed;z-index:100;background:".$_POST["rodape"].";border:solid 1px #AAC0FE;-webkit-border-radius:10px;-moz-border-radius:10px;border-radius:10px;-color:#000;padding:5px;margin-bottom:10px}.avisomsj:before{content:' ';display:block;position:absolute;left:50%;bottom:-7px;width:10px;height:10px;border:solid 1px #AAC0FE;background:#EBF9DF;transform:rotate(225deg);-webkit-transform:rotate(225deg);-ms-transform:rotate(225deg);-moz-transform:rotate(225deg)}input[type=radio],input[type=checkbox]{height: 18px;width: 18px;}.wrappaginacaoml{clear:both;margin:0 0 30px}.wrappaginacaoml .paginacaoml{line-height:30px;text-align:center;font-size:14px;font-weight:400;text-transform:uppercase;color:#222}.wrappaginacaoml .paginacaoml a,.wrappaginacaoml .paginacaoml span{margin:0 4px;padding:4px 10px;background:#222;border:#222 solid 1px;color:#fff;font-weight:400}.wrappaginacaoml .paginacaoml a:hover,.wrappaginacaoml .paginacaoml .current,.wrappaginacaoml .paginacaoml a.final:hover{margin:0 4px;background:#fff;color:#222;border-color:#222;padding:4px 10px;text-decoration:none}.wrappaginacaoml .paginacaoml a.final,.wrappaginacaoml .paginacaoml a.next,.wrappaginacaoml .paginacaoml a.prev{background:#666;border-color:#666}.wrappaginacaoml .paginacaoml span.inicio{color:#000;background:transparent;border:0;font-weight:400;font-size:.85em;text-align:center;font-variant:small-caps}.upload-btn-wrapper {bottom: -13px;overflow: hidden;position: relative;display: inline-block;}.btn {padding: 8px 15px;font-size: 15px;font-weight: bold;}.upload-btn-wrapper input[type=file] {overflow: hidden;font-size: 100px;position: absolute;left: 0;top: 0;opacity: 0;}.bt_upload {background-image: url('/imgs/arq.png');background-size: 15px;background-position: center;color: #6B6B6B;border-radius: 3px;width: 15px;height: 15px;cursor: pointer;margin-left: 2px;display: inline-block;}.color-btn-wrapper {position: relative;display: inline-block;}.color-btn-wrapper input[type=color] {font-size: 100px;position: absolute;left: 0;top: 0;opacity: 0;}.bt_color {background-image: url('/imgs/cor.png');background-size: 15px;background-position: center;color: #6B6B6B;border-radius: 3px;width: 15px;height: 15px;cursor: pointer;margin-left: 2px;display: inline-block;}.paint-btn-wrapper {position: relative;display: inline-block;}.paint-btn-wrapper input[type=color] {font-size: 100px;position: absolute;left: 0;top: 0;opacity: 0;}.gravador-btn-wrapper {position: relative;display: inline-block;}.record {background-image: url('/imgs/gravador.png');background-size: 15px;background-position: center;color: #6B6B6B;border-radius: 3px;width: 15px;height: 15px;cursor: pointer;margin-left: 2px;display: inline-block;}.save {background-image: url('/imgs/gravadoroff.png');background-size: 15px;background-position: center;color: #6B6B6B;border-radius: 3px;width: 15px;height: 15px;cursor: pointer;margin-left: 2px;display: inline-block;}.pms {background-color: #fa3e3e;border-radius: 2px;box-shadow: -1px 1px 2px 0 rgba(0, 0, 0, .3);color: #fff;cursor: default;height: 12px;line-height: 11px;position: absolute;right: 45%;text-align: center;top: -4px;width: 12px}.pmsn {background-clip: padding-box;display: inline-block;font-size: 11px;line-height: 1.1;min-height: 12px}.pmst {position: relative;padding: 0px 4px;float:center}";
$res = file_put_contents($arrayname,$arraytexto);
$namearray = 'novoarray.php';
$res = file_put_contents($namearray,print_r($textoarray, true));
echo "<div align='center'>$imgok <b><big>Cores atualizadas com sucesso!</b></big><br /><br /><a href='/mod/cores_site'>Atualizar</a></div><br /><br />";
if(!isset($_SESSION['cores'])){
$txtt = "atualizou as cores do site. Data: [i] $data [/i] ";
editandopostagem($meuid,$txtt);
$_SESSION["cores"] = $meuid;
}
}
}
if($id=='color'){
$_SESSION["caixa_cores"] = $meuid;
}else{
unset($_SESSION["caixa_cores"]);    
}
$caixa= isset($_SESSION['caixa_cores']) ? 'text' : 'color';
?>
<a href="/mod/cores_site/<?php echo $caixa;?>">Mudar Caixa de Cores</a><br /><br />
<form action="/mod/cores_site" method="post" enctype="multipart/form-data">
Se nao tem codigo crie uma conta adsence. <a href="https://www.google.com/intl/pt-BR_br/adsense/start/get-started/">Criar Conta Adsence</a><br/><br/>
Codigo adsence somente id cliente: <br /><input type="text" name="ads" maxlength="100" value="<?php echo $testearray[14];?>">
<br/>
Fonte do site: <input name="fonte" type="<?php echo $caixa;?>" maxlength="7" value="<?php echo $testearray[1];?>">
<br/>
Cor de fundo: <input name="corfundo" type="<?php echo $caixa;?>" maxlength="7" value="<?php echo $testearray[13];?>">
<br/>
Fonte das barras & rodapés: <input name="fonte_barras" type="<?php echo $caixa;?>" maxlength="7" value="<?php echo $testearray[11];?>">
<br/>
Cor dos links: <input name="links" type="<?php echo $caixa;?>" maxlength="7" value="<?php echo $testearray[10];?>">
<br/>
Rodapé: <input name="rodape" type="<?php echo $caixa;?>" maxlength="7" value="<?php echo $testearray[2];?>">
<br/>
Barra de titulo: <input name="titulo" type="<?php echo $caixa;?>" maxlength="7" value="<?php echo $testearray[3];?>">
<br/>
Barra dos murais: <input name="murais" type="<?php echo $caixa;?>" maxlength="7" value="<?php echo $testearray[4];?>">
<br/>
Fundo do mural: <input name="fundo" type="<?php echo $caixa;?>" maxlength="7" value="<?php echo $testearray[5];?>">
<br/>
Linha 1: <input name="linha1" type="<?php echo $caixa;?>" maxlength="7" value="<?php echo $testearray[8];?>">
<br/>
Linha 2: <input name="linha2" type="<?php echo $caixa;?>" maxlength="7" value="<?php echo $testearray[9];?>">
<br/>
Balao mensagem 1: <input name="balao1" type="<?php echo $caixa;?>" maxlength="7" value="<?php echo $testearray[6];?>">
<br/>
Balao mensagem 2: <input name="balao2" type="<?php echo $caixa;?>" maxlength="7" value="<?php echo $testearray[7];?>">
<br/>
Cor hall e section: <input name="fieldset" type="<?php echo $caixa;?>" maxlength="7" value="<?php echo $testearray[37];?>">
<br/>
Texto pergaminho: <input name="textoperga" type="<?php echo $caixa;?>" maxlength="7" value="<?php echo $testearray[42];?>">
<br/>
Fundo pergaminho: <input name="perga" type="<?php echo $caixa;?>" maxlength="7" value="<?php echo $testearray[43];?>">
<br/>
Cor barra de rolagem: <input name="rolagem" type="<?php echo $caixa;?>" maxlength="7" value="<?php echo $testearray[45];?>">
<br/>
Familia textos: <input type="text" name="textobody" maxlength="70" value="<?php echo $testearray[12];?>" required>
<br/>
Tamanho fonte: <input type="text" name="tamanhofonte" maxlength="70" value="<?php echo $testearray[0];?>" required>
<br/><hr>
Usar cores gradiente:<br/><select name="gradiente">
<option value="0">Não</option>
<option value="1" <?php echo $testearray[48]==1?' selected ':'';?> >Gradiente 1</option>
<option value="2" <?php echo $testearray[48]==2?' selected ':'';?> >Gradiente 2</option>
<option value="3" <?php echo $testearray[48]==3?' selected ':'';?> >Gradiente 3</option>
</select><br/>
Site Versão Simples:<br/><select name="menuone">
<option value="0">Não</option>
<option value="1" <?php echo $testearray[40]==1?' selected ':'';?> >Sim</option>
<option value="2" <?php echo $testearray[40]==2?' selected ':'';?> >Sim com cores nas barras</option>
</select><br/><hr>
Imagem de fundo(Opcional)<br />Para remover fundo deixe sem imagem<br /><br />
<input type="file" name="arquivo"><br/><br />
<input type="radio" name="imagem" value="1" checked>&emsp;Repete imagem&emsp;<input type="radio" name="imagem" value="2">&emsp;Imagem centralizada&emsp;<input type="radio" name="imagem" value="3">&emsp;Imagem estendida&emsp;<input type="radio" name="imagem" value="4">&emsp;Relativo a tela<br /><br />
<input type="submit" value="Editar">
</form>
<br/><br/>
<?php 
}else 
if($a=='geral') { 
if(permdono($meuid) or perm($meuid)==6){
?>
<br/><div id="titulo"><b>Geral</b></div><br/>
<?
if($_POST){    
$arquivo = isset($_FILES["arquivo"]) ? $_FILES["arquivo"] : FALSE;
if (!empty($arquivo["name"])){
$pasta = "style/";
$_UP['extensoes'] = array('jpeg','png','gif','bmp','jpg','mp4','webm');
$extensao = substr(strrchr($arquivo["name"],'.'),1);
if (array_search($extensao, $_UP['extensoes']) === false) {
echo "$imgerro Arquivo em formato invalido! A imagem deve ser  (jpg|jpeg|png|gif) . Envie outro arquivo<br>";
}else{
@unlink("style/".$testearray[30]."");
if(preg_match("/^image\/(gif)$/",$arquivo["type"])){
$newfile = "by-mistake-".time()."-".$arquivo["name"]."";
exec("gifsicle --scale 0.5 -i ".escapeshellarg($arquivo["tmp_name"])." > ".escapeshellarg($pasta.$newfile)."");
}else{
if(preg_match("/^image\/(jpeg|png|bmp|jpg)$/",$arquivo["type"])){
$newfile = "by-nandosp-".time()."-".$arquivo["name"]."";
//exec("convert ".escapeshellarg($arquivo["tmp_name"])." -resize 40% ".escapeshellarg($pasta.$newfile)."");
move_uploaded_file($arquivo["tmp_name"],$pasta.$newfile); 
}else{
if(preg_match("/^video\/(mp4|mpeg|webm)$/",$arquivo["type"])){
$newfile = "by-nandosp-".time()."-".$arquivo["name"].".gif";
//exec("ffmpeg -i ".escapeshellarg($arquivo["tmp_name"])." ".escapeshellarg($pasta.$newfile)." -hide_banner");
exec("gifsicle -O3 ".escapeshellarg($pasta.$newfile)." -o ".escapeshellarg($pasta.$newfile)."");
move_uploaded_file($arquivo["tmp_name"],$pasta.$newfile); 
}
}
}
}
}else{
$newfile = $testearray[30];    
}
if($_POST['tempoativo'] < 99 || $_POST['tempoativovisitas'] < 99){
$name = 'manifest.json';
$texto = '{
  "name": "'.$_SERVER['SERVER_NAME'].'",
  "short_name": "'.$_SERVER['SERVER_NAME'].'",
  "start_url": "/",
  "display": "standalone",
  "gcm_sender_id": "482941778795",
  "lang": "pt-BR",
  "orientation": "any",
  "background_color": "#343a40",
  "theme_color": "#343a40",
  "description": "Rede Social",
"version": "1.0",
"icons": [{
    "src": "/style/'.$newfile.'",
    "sizes": "192x192",
    "type": "image/png"
  }],
"app": {
"urls": [
"https://'.$_SERVER['SERVER_NAME'].'/"
],
"launch": {
"web_url": "https://'.$_SERVER['SERVER_NAME'].'/"
}
},
"permissions": [
"unlimitedStorage",
"notifications"
]
}';
$somando = 60*60*$_POST['tempoativo'];
$somando1 = 60*60*$_POST['tempoativovisitas'];
$file = file_put_contents($name,$texto);
$leu = empty($_POST['lerpm']) ? 0 : 1;
$a = empty($_POST['aleatorio']) ? 0 : 1;
$b = empty($_POST['automatico']) ? 0 : 1;
$c = empty($_POST['pombo']) ? 0 : 1;
$d = empty($_POST['pokemon']) ? 0 : 1;
$e = empty($_POST['cartas']) ? 0 : 1;
$f = empty($_POST['zumbi']) ? 0 : 1;
$g = empty($_POST['quiz']) ? 0 : 1;
$h = empty($_POST['registro']) ? 0 : 1;
$i = empty($_POST['usuario']) ? 0 : 1;
$j = empty($_POST['proxy']) ? 0 : 1;
$k = empty($_POST['opera']) ? 0 : 1;
$l = $_POST['gostei'];
$m = empty($_POST['paginahall']) ? 0 : 1;
$n = isset($_POST['visitantes']) ? $_POST['visitantes'] : $testearray[68];
$o = isset($_POST['linkusuario']) ? $_POST['linkusuario'] : $testearray[69];
$p = isset($_POST['fantasmas']) ? $_POST['fantasmas'] : $testearray[70];
$ads = empty($_POST['opera']) ? 0 : 1;
$muralequipe = empty($_POST['muralequipe']) ? 0 : 1;
$ftp = isset($_POST["ftp"]) ? $_POST["ftp"] : $testearray[56];
$uftp = isset($_POST["uftp"]) ? $_POST["uftp"] : $testearray[57];
$sftp = isset($_POST["sftp"]) ? $_POST["sftp"] : $testearray[58];
$api = isset($_POST["api"]) ? $_POST["api"] : $testearray[38];
$one = isset($_POST["one"]) ? $_POST["one"] : $testearray[39];
$q = isset($_POST["ns"]) ? $_POST["ns"] : $testearray[71];
$res = $mistake->exec("UPDATE w_geral SET site='".$l."',api='".$api."',one='".$one."',tempoativovisitas='".$somando1."',tempoativo='".$somando."' where id='1'");
$textoarray = '<?php return array("'.$testearray[0].'","'.$testearray[1].'","'.$testearray[2].'","'.$testearray[3].'","'.$testearray[4].'","'.$testearray[5].'","'.$testearray[6].'","'.$testearray[7].'","'.$testearray[8].'","'.$testearray[9].'","'.$testearray[10].'","'.$testearray[11].'","'.$testearray[12].'","'.$testearray[13].'","'.$ads.'","'.htmlspecialchars($_POST["mural"]).'","'.htmlspecialchars($_POST["mbv"]).'","'.$_POST["we"].'","'.$somando.'","'.$somando1.'","'.$a.'","'.$b.'","'.$h.'","'.$j.'","'.$k.'","'.$i.'","'.$c.'","'.$d.'","'.$e.'","'.$f.'","'.$newfile.'","'.$_POST["hid"].'","'.htmlspecialchars($_POST["htit"]).'","'.htmlspecialchars($_POST["htit2"]).'","'.$_POST["hid2"].'","'.htmlspecialchars($_POST["htit3"]).'","'.$_POST["hid3"].'","'.$testearray[37].'","'.$api.'","'.$one.'","'.$testearray[40].'","'.$g.'","'.$testearray[42].'","'.$testearray[43].'","'.$testearray[44].'","'.$testearray[45].'","'.$_POST["pontos"].'","'.$_POST["moedas"].'","'.$testearray[48].'","'.$_POST["shall"].'","'.$_POST["susuer"].'","'.$_POST["sequipe"].'","'.$_POST["gato"].'","'.$_POST["gata"].'","'.$leu.'","'.$testearray[55].'","'.$ftp.'","'.$uftp.'","'.$sftp.'","'.$testearray[59].'","'.$_POST["textomurais"].'","'.$_POST["textomensagem"].'","'.$testearray[62].'","'.$muralequipe.'","'.$_POST["gato1"].'","'.$_POST["gata1"].'","'.$l.'","'.$m.'","'.$n.'","'.$o.'","'.$p.'","'.$q.'");';
$namearray = 'novoarray.php';
$res = file_put_contents($namearray,print_r($textoarray, true));
echo "<div align='center'>$imgok <b><big>Alterações efetuadas com sucesso!</b></big></div><br /><br />"; 
if(!isset($_SESSION['geral'])){
$txtt = "atualizou as configuraçoes gerais do site. Data: [i] $data [/i] ";
editandopostagem($meuid,$txtt);
$_SESSION["geral"] = $meuid;
}
}
}
$somand = $testearray[18]/3600;
$somand1 = $testearray[19]/3600;
?>
<div align="center"><a href='/mod/geral'><?php echo $imgatualizar;?>Atualizar</a></div><br />
<form action="/mod/geral" method="post" enctype="multipart/form-data">
Tempo de inatividade:<br/><input type="number" min="1" max="99" name="tempoativo" value="<?php echo $somand;?>">
<br/>
Tempo de inatividade visitantes:<br/><input type="number" min="1" max="99" name="tempoativovisitas" value="<?php echo $somand1;?>">
<br/>
Pontos para enquete:<br/><input type="number" name="we" min="1" max="999" value="<?php echo $testearray[17];?>">
<br/><hr>   
<br/>
Mural da equipe:<br/><textarea style="width:-webkit-fill-available" name="mural" cols="20" rows="5"><?php echo $testearray[15];?></textarea>
<br/>
Mensagem de boas vindas:<br/><textarea style="width:-webkit-fill-available" name="mbv" cols="20" rows="5"><?php echo $testearray[16];?></textarea>
<br/>
Nome do site:<br/><input type="text" name="ns" value="<?php echo $testearray[71];?>">
<br/> 
<hr>
<br />
Api onesignal:<br/><input type="text" name="api" value="<?php echo $testearray[38];?>">
<br/>   
Chave api onesignal:<br/><input type="text" name="one" value="<?php echo $testearray[39];?>">
<br/> 
<?
if(perm($meuid)==4){
?>  
Ftp:<br/><input type="text" name="ftp" value="<?php echo $testearray[56];?>">
<br/>   
Usuario ftp:<br/><input type="text" name="uftp" value="<?php echo $testearray[57];?>">
<br/>  
Senha ftp:<br/><input type="text" name="sftp" value="<?php echo $testearray[58];?>">
<br/> 
<?
}
if(permdono($meuid)){
?>  
<hr>
<br/>Ler Pm:<br/>
<label class="switch">    
<input type="checkbox" name="lerpm" data-value="1" value="1" <?php echo $testearray[54] == '1' ? 'checked' : '' ?> />
<span class="slider round"></span>
</label><br/>
Ativar menu online para visitantes:<br/>
<label class="switch">    
<input type="checkbox" name="visitantes" data-value="1" value="1" <?php echo $testearray[68] == '1' ? 'checked' : '' ?> />
<span class="slider round"></span>
</label><br/>
Ativar link perfil para visitantes:<br/>
<label class="switch">    
<input type="checkbox" name="linkusuario" data-value="1" value="1" <?php echo $testearray[69] == '1' ? 'checked' : '' ?> />
<span class="slider round"></span>
</label><br/>
Ativar fantasmas no site membros inativos a mais de 1 mês entrarem automático:<br/>
<label class="switch">    
<input type="checkbox" name="fantasmas" data-value="1" value="1" <?php echo $testearray[70] == '1' ? 'checked' : '' ?> />
<span class="slider round"></span>
</label><br/>
<?
}
?>
Hall principal:<br/>
<label class="switch">    
<input type="checkbox" name="paginahall" data-value="1" value="1" <?php echo $testearray[67] == '1' ? 'checked' : '' ?> />
<span class="slider round"></span>
</label><br/>
Mural equipe ativar:<br/>
<label class="switch">    
<input type="checkbox" name="muralequipe" data-value="1" value="1" <?php echo $testearray[63] == '1' ? 'checked' : '' ?> />
<span class="slider round"></span>
</label><br/>
Mural aleatório:<br/>
<label class="switch">    
<input type="checkbox" name="aleatorio" data-value="1" value="1" <?php echo $testearray[20] == '1' ? 'checked' : '' ?> />
<span class="slider round"></span>
</label><br/>
Mural automático:<br/>
<label class="switch">    
<input type="checkbox" name="automatico" data-value="1" value="1" <?php echo $testearray[21] == '1' ? 'checked' : '' ?> />
<span class="slider round"></span>
</label><br/>
Ativar pombo:<br/>
<label class="switch">    
<input type="checkbox" name="pombo" data-value="1" value="1" <?php echo $testearray[27] == '1' ? 'checked' : '' ?> />
<span class="slider round"></span>
</label><br/>
Ativar Pokémon:<br/>
<label class="switch">    
<input type="checkbox" name="pokemon" data-value="1" value="1" <?php echo $testearray[26] == '1' ? 'checked' : '' ?> />
<span class="slider round"></span>
</label><br/>
Ativar pergaminho:<br/>
<label class="switch">    
<input type="checkbox" name="cartas" data-value="1" value="1" <?php echo $testearray[28] == '1' ? 'checked' : '' ?> />
<span class="slider round"></span>
</label><br/>
Ativar zumbis:<br/>
<label class="switch">    
<input type="checkbox" name="zumbi" data-value="1" value="1" <?php echo $testearray[29] == '1' ? 'checked' : '' ?> />
<span class="slider round"></span>
</label><br/>
Pontos no quiz:<br/>
<label class="switch">    
<input type="checkbox" name="quiz" data-value="1" value="1" <?php echo $testearray[41] == '1' ? 'checked' : '' ?> />
<span class="slider round"></span>
</label><br/>
Cadastros:<br/>
<label class="switch">    
<input type="checkbox" name="registro" data-value="1" value="1" <?php echo $testearray[22] == '1' ? 'checked' : '' ?> />
<span class="slider round"></span>
</label><br/>
Liberaçao de usuários automático:<br/>
<label class="switch">    
<input type="checkbox" name="usuario" data-value="1" value="1" <?php echo $testearray[25] == '1' ? 'checked' : '' ?> />
<span class="slider round"></span>
</label><br/>
Login rede sociais:<br/>
<label class="switch">    
<input type="checkbox" name="ads" data-value="1" value="1" <?php echo $testearray[14] == '1' ? 'checked' : '' ?> />
<span class="slider round"></span>
</label><br/>
Proxy liberar:<br/>
<label class="switch">    
<input type="checkbox" name="proxy" data-value="1" value="1" <?php echo $testearray[23] == '1' ? 'checked' : '' ?> />
<span class="slider round"></span>
</label><br/>
Liberar opera:<br/>
<label class="switch">    
<input type="checkbox" name="opera" data-value="1" value="1" <?php echo $testearray[24] == '1' ? 'checked' : '' ?> />
<span class="slider round"></span>
</label><br/>
<hr>
<br />
Curti mural:<br/><select name="gostei">
<option value="1" <?php echo $testearray[66]==1?' selected ':'';?> >Tipo 1</option>
<option value="2" <?php echo $testearray[66]==2?' selected ':'';?> >Tipo 2</option>
<option value="3" <?php echo $testearray[66]==3?' selected ':'';?> >Tipo 3</option>
</select><br/>
Smiles hall:<br/>
<input type="number" name="shall" min="1" max="5" value="<?php echo $testearray[49];?>">
<br/>
Smiles mural usuarios:<br/>
<input type="number" name="susuer" min="1" max="8" value="<?php echo $testearray[50];?>">
<br/>
Smiles mural equipe e divulgação:<br/>
<input type="number" name="sequipe" min="1" max="20" value="<?php echo $testearray[51];?>">
<br/> 
Pontos para novo cadastrado:<br/><input type="number" name="pontos" min="1" max="9999" value="<?php echo $testearray[46];?>">
<br/>   
Moedas para novo cadastrado:<br/><input type="number" name="moedas" min="1" max="99" value="<?php echo $testearray[47];?>">
<br/>   
Limite texto murais:<br/><input type="number" name="textomurais" min="1" max="5000" value="<?php echo $testearray[60];?>">
<br/>   
Limite texto mensagem:<br/><input type="number" name="textomensagem" min="1" max="5000" value="<?php echo $testearray[61];?>">
<br/>
<hr>
<br />
<b>Primeira homenagem</b><br/>
Título da homenagem:<br/><input type="text" name="htit" value="<?php echo $testearray[32];?>" required>
<br/>
Id do usuário:<br/><input type="number" min="0" name="hid" value="<?php echo $testearray[31];?>">
<br/>
<b>Segunda homenagem</b><br/>
Título da homenagem:<br/><input type="text" name="htit2" value="<?php echo $testearray[33];?>" required>
<br/>
Id do usuário:<br/><input type="number" min="0" name="hid2" value="<?php echo $testearray[34];?>">
<br/>
<b>Terceira homenagem</b><br/>
Título da homenagem:<br/><input type="text" name="htit3" value="<?php echo $testearray[35];?>" required>
<br/>
Id do usuário:<br/><input type="number" min="0" name="hid3" value="<?php echo $testearray[36];?>"><br/>
Título mister ou gato:<br/><input type="text" name="gato1" value="<?php echo $testearray[64];?>" required>
<br/>Gato:<br/><input type="number" name="gato" min="0" value="<?php echo $testearray[52];?>"><br/>
Título miss ou gata:<br/><input type="text" name="gata1" value="<?php echo $testearray[65];?>" required>
<br/>Gata:<br/><input type="number" name="gata" min="0" value="<?php echo $testearray[53];?>">
<br/>
<hr>
<br/>
Logo tipo(extensoes permitidas gif,png,jpg,jpeg e mp4):<br/>
<input type="file" name="arquivo"><br/><br/>
<input type="submit" value="Editar">
</form>
<?php 
}else{
?>
<div align="center">
<b><?php echo $imgerro;?> Você não tem permisão para isso!</b><br /><br />
</div>
<?php    
} 
} else 
if($a=='editarusuario') {
if(perm($meuid)>0) {
$limite=isset($_GET['limite'])?$_GET['limite']:'';    
if($pag=='apagarmsgs'){
if(permdono($id)) { ?>
<br/><div align="center"><?php echo $imgerro;?>Não é possivel excluir dados de donos!</div><br/>
<?php 
}else{
$txtt = "excluiu dados de [b] ".gerarnome2($id)." [/b], ID: [b] $id [/b]. Data: [i] $data [/i] ";
editandopostagem($meuid,$txtt);	
$mistake->exec("DELETE FROM w_msgs WHERE por='".$id."' or pr='".$id."'");
$mistake->exec("DELETE FROM w_forum WHERE dono='".$id."'");
$mistake->exec("DELETE FROM w_mural WHERE drec='".$id."'");
$mistake->exec("DELETE FROM w_recados WHERE por='".$id."'");
$mistake->exec("DELETE FROM w_pergunte_me WHERE de='".$id."'");
$mistake->exec("DELETE FROM w_depo2 WHERE uid='".$id."'");
$mistake->exec("DELETE FROM w_cmt_fotos WHERE dono='".$id."'");
$mistake->exec("DELETE FROM w_posts WHERE por='".$id."'");
}
}
if($pag=='banir'){
if(permdono($idd)) { ?>
<br/><div align="center"><?php echo $imgerro;?>Não é possivel banir <?php echo gerarnome($id);?>!</div><br/>
<?php 
}else{
if($meuid==$idd) { ?>
<br/><div align="center"><?php echo $imgerro;?>Não é possivel banir voce mesmo!</div><br/>
<?php 
}else{
if($_POST['rz']=='') { ?>
Especifique uma razão para banir <?php echo gerarnome($id);?><br/>
<?php 
} else {
$txtt = "baniu [b] ".gerarnome2($id)." [/b], ID: [b] $id [/b]. Data: [i] $data [/i] ";
editandopostagem($meuid,$txtt);
/*
apagardevez($id);
$mistake->exec("UPDATE w_usuarios SET dest='0',banido='1',ft=null,fundo_bg=null,razaoban='".$_POST['rz']."',banidopor='$meuid',onl='0',databan='".time()."' where id='".$id."'");
*/
$ip = $mistake->query("SELECT ip FROM w_usuarios WHERE id='".$id."'")->fetch();
$tempo = $_POST['tempo'] + time();
$res = $mistake->prepare("INSERT INTO w_ban (razao,uid,tipo,hora,ip,ipp) VALUES (?,?,?,?,?,?)");
$arrayName = array(anti_injection($_POST['rz']),$id,$_POST['tipo'],$tempo,$ip[0],$_POST['ipp']);
$ii = 0;
for($i=1; $i <=6; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
}
}
}
}
if($pag=='desbanir'){
$txtt = "desbaniu [b] ".gerarnome2($id)." [/b], ID: [b] $id [/b]. Data: [i] $data [/i] ";
editandopostagem($meuid,$txtt);
$mistake->exec("UPDATE w_usuarios SET banido='0',razaoban='0',banidopor='0',databan='0' where id='".$id."'");
}
if($pag=='pontos'){
if($_POST['acao']==0){
$pts = pts($id)-$_POST['pts'];
}else{
$pts = pts($id)+$_POST['pts'];
}
$mistake->exec("UPDATE w_usuarios SET pt='$pts' WHERE id='".$id."'");
$nav = explode(" ",$_SERVER['HTTP_USER_AGENT'] );
$res = $mistake->prepare("INSERT INTO w_pontos (uid,aid,hr,rz,ip,nv,dt,pt) VALUES (?,?,?,?,?,?,?,?)");
$arrayName = array($meuid,$id,time(),$_POST['rz'],gerarip(),$nav[0],$_POST['acao'],$_POST['pts']);
$ii = 0;
for($i=1; $i <=8; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
}
if($pag=='moedas'){
if($_POST['acao']==0){
$pts = moedas($id)-$_POST['pts'];
}else{
$pts = moedas($id)+$_POST['pts'];
}
$mistake->exec("UPDATE w_usuarios SET moedas='$pts' WHERE id='".$id."'");
$nav = explode(" ",$_SERVER['HTTP_USER_AGENT'] );
$res = $mistake->prepare("INSERT INTO w_pontos (uid,aid,hr,rz,ip,nv,dt,pt) VALUES (?,?,?,?,?,?,?,?)");
$arrayName = array($meuid,$id,time(),$_POST['rz'],gerarip(),$nav[0],$_POST['acao'],$_POST['pts']);
$ii = 0;
for($i=1; $i <=8; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
}
if($limite=='destaque'){
$mistake->exec("update w_usuarios set dest='$pag',corn='#20B2AA',corn2='#7B68EE',corn3='#1C1C1C',corn4='#FF0000',fonte='BATMAN',tamanhofonte='16px' WHERE id='".$id."'");
$txtt = "adicionou destaque para [b] ".gerarnome2($id)." [/b], ID: [b] $id [/b]. Data: [i] $data [/i] ";
editandopostagem($meuid,$txtt);
}
if($limite=='vip'){
$mistake->exec("UPDATE w_usuarios SET vip='$pag' WHERE id='".$id."'");
$txtt = "adicionou vip para [b] ".gerarnome2($id)." [/b], ID: [b] $id [/b]. Data: [i] $data [/i] ";
editandopostagem($meuid,$txtt);
}
if($_POST['estrelas']==true){
$mistake->exec("UPDATE w_usuarios SET star='".$_POST['estrelas']."' WHERE id='".$id."'");
} 
if(permdono($meuid) || perm($meuid)==6) {
if($limite=='perm'){
$mistake->exec("UPDATE w_usuarios SET perm='$pag' WHERE id='".$id."'");
$txtt = "adicionou permicao ".$pag." para [b] ".gerarnome2($id)." [/b], ID: [b] $id [/b]. Data: [i] $data [/i] ";
editandopostagem($meuid,$txtt);
}
}
if($pag=='apostas'){
$mistake->exec("UPDATE w_usuarios SET ta=ta + ".$_POST['pts']." WHERE id='".$id."'");
$razao = $_POST['rz'];
$pttt = $_POST['pts'];
$res = $mistake->prepare("INSERT INTO w_ta (uid,rz,dt,pt) VALUES (?,?,?,?)");
$arrayName = array($id,$razao,time(),$pttt);
$ii = 0;
for($i=1; $i <=4; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
$txtt = "adicionou um acerto em apostas para [b] ".gerarnome2($id)." [/b], ID: [b] $id [/b], Acerto: [b] $pttt [/b]. Razão: [i] $razao [/i]. Data: [i] $data [/i] ";
editandopostagem($meuid,$txtt);
}else 
if($pag=='premios'){
$des = $_POST['des'];
$prem = $_POST['prem'];
$img = $_POST['acao'];
$res = $mistake->prepare("INSERT INTO w_premios (uid,des,dt,prem,img) VALUES (?,?,?,?,?)");
$arrayName = array($id,$des,time(),$prem,$img);
$ii = 0;
for($i=1; $i <=5; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
$txtt = "adicionou um prêmio para [b] ".gerarnome2($id)." [/b], ID: [b] $id [/b], Descrição: [b] $des [/b]. Prêmio: [i] $pre [/i]. Data: [i] $data [/i] ";
editandopostagem($meuid,$txtt);
}
}
$vip = $mistake->query("SELECT vip,ta,star,corn,gato,perm,banido,dest FROM w_usuarios WHERE id='".$id."'")->fetch();
$premios = $mistake->query("SELECT count(*) FROM w_premios WHERE uid='".$id."'")->fetch();
?>
<br/><div id="titulo"><b>Usuário<?php echo gerarnome($id);?></b></div>
<?
$ipm = $mistake->query("SELECT ip FROM w_usuarios WHERE id='".$id."'")->fetch();   
if($ipm[0]==true){
$ipmeu =  $ipm[0];   
}else{
$ipmeu = '104.28.6.23';    
}
echo "<center>".open_ip($ipmeu)." <br><a href='/busca?nome=".$ipmeu."&por=ip&a=busca'>ver todos usuarios com este ip</a><br><a href='/mod/navegador/$id'>ver dados reais do navegador</a></center>";
?>
<br/>
<a href="/mod/pontos/<?php echo $id;?>"><?php echo $imgseta;?> Pontos</a>: <?php echo pts($id);?><hr>
<a href="/mod/moedas/<?php echo $id;?>"><?php echo $imgseta;?> Moedas</a>: <?php echo moedas($id);?><hr>
<a href="/mod/<?php echo $vip[6]>0?'editarusuario':'banir';?>/<?php echo $id;?>/desbanir"><?php echo $imgseta;?> <?php echo $vip[6]>0?'Desbanir':'Banir';?></a><hr>
<a href="/mod/editarusuario/<?php echo $id;?>/<?php echo $vip[0]==0?'1':'0';?>/vip"><?php echo $imgseta;?> <?php echo $vip[0]==0?'Dar':'Tirar';?> Vip</a><hr>
<a href="/configuracoes/passo1/<?php echo $id;?>/remover"><?php echo $imgseta;?> Remover plano de fundo</a><hr>
<a href="/configuracoes/remover_foto_perfil/<?php echo $id;?>"><?php echo $imgseta;?> Remover foto do perfil</a><hr>
<?php
if(perm($meuid)==3 or perm($meuid)==4 or perm($meuid)==5 or perm($meuid)==6){
if(perm($id)!=4 and $id!=1){  
?>
<div id='titulo'>STATUS DA EQUIPE:</div><hr>
<?php if(perm($id)==1) { ?>
<a href="/mod/editarusuario/<?php echo $id;?>/0/perm"><?php echo $imgseta;?> Tirar Moderador(a)</a><hr>
<?php }else{ ?>
<a href="/mod/editarusuario/<?php echo $id;?>/1/perm"><?php echo $imgseta;?> Add Moderador(a)</a><hr>
<?php }
if(perm($id)==2) { ?>
<a href="/mod/editarusuario/<?php echo $id;?>/0/perm"><?php echo $imgseta;?> Tirar Administrador(a)</a><hr>
<?php }else{ ?>
<a href="/mod/editarusuario/<?php echo $id;?>/2/perm"><?php echo $imgseta;?> Add Administrador(a)</a><hr>

<?php }
if(permdono($meuid)) { 
if(perm($id)==3) { ?>
<a href="/mod/editarusuario/<?php echo $id;?>/0/perm"><?php echo $imgseta;?> Tirar Dono(a)</a><hr>
<?php }else{ ?>
<a href="/mod/editarusuario/<?php echo $id;?>/3/perm"><?php echo $imgseta;?> Add Dono(a)</a><hr>
<?php
}
}
if(perm($meuid)>1) { ?>
<a href="/configuracoes/editarperfil/<?php echo $id;?>"><?php echo $imgseta;?> Editar perfil</a><hr>
<?php 
} 
}
}
?>
<br /><a href="/mod/senhaequipe/<?php echo $id;?>"><?php echo $imgseta;?> Alterar senha de painel</a><br/>
<br /><a href="/mod/loginsenha/<?php echo $id;?>"><?php echo $imgseta;?> Alterar senha</a><br/><br/>
<a href="/mod/excluirusu/<?php echo $id;?>"><?php echo $imgseta;?> Excluír membro</a><br/><br />
<br/><div align="center"><a href="/<?php echo gerarlogin($id);?>">Perfil de <?php echo gerarnome($id);?></a><br/>
<?php } else if($a=='pontos') { ?>
<br/><div id="titulo"><b>Pontos</b></div><br/>
<form action="/mod/editarusuario/<?php echo $id;?>/pontos" method="post">
Razão:<br/><input type="text" name="rz" required><br/>
Ação:<br/>
<select name="acao">
<option value="0">Tirar</option>
<option value="1">Dar</option></select><br/>
Pontos:<br/><input type="number" min="1" max="9999" name="pts" size="4" maxlength="4" /><br/>
<input type="submit" value="Alterar" /></form><br/>
<?php }
else if($a=='moedas') { ?>
<br/><div id="titulo"><b>Moedas</b></div><br/>
<form action="/mod/editarusuario/<?php echo $id;?>/moedas" method="post">
Razão:<br/><input type="text" name="rz" required><br/>
Ação:<br/>
<select name="acao">
<option value="0">Tirar</option>
<option value="1">Dar</option></select><br/>
Moedas:<br/><input type="number" min="1" max="9999" name="pts" size="4" maxlength="4" /><br/>
<input type="submit" value="Alterar" /></form><br/>
<?php }  else if($a=='editarsubcat') { ?>
<br/><div id="titulo"><b>Renomear sub-categoria</b></div><br/>
<?php
if ($_POST['nome']==true && permdono($meuid)) { 
$update = $mistake->prepare("UPDATE w_sub_forum SET nm = ? WHERE id = ?");
$update->execute(array($_POST['nome'],$id)); 
}
$nome = $mistake->query("SELECT nm FROM w_sub_forum where id='".$id."'")->fetch();
?>
<form action="/mod/editarsubcat/<?php echo $id;?>" method="post">
Renomear:<br/><input type="text" name="nome" value="<?php echo $nome['nm'];?>" required>
<input type="submit" value="Editar" /></form><br/>
<?php } else if($a=='editarcatforum') { ?>
<br/><div id="titulo"><b>Renomear categoria</b></div><br/>
<?php
if ($_POST['nome']==true && permdono($meuid)) { 
$update = $mistake->prepare("UPDATE w_cat_forum SET nm = ? WHERE id = ?");
$update->execute(array($_POST['nome'],$id));
}
$nome = $mistake->query("SELECT nm FROM w_cat_forum where id='".$id."'")->fetch();
?>
<form action="/mod/editarcatforum/<?php echo $id;?>" method="post">
Renomear:<br/><input type="text" name="nome" value="<?php echo $nome['nm'];?>" required>
<input type="submit" value="Editar" /></form><br/>
<?php } else if($a=='editarcatcomu') { ?>
<br/><div id="titulo"><b>Renomear categoria</b></div><br/>
<?php
if ($_POST['nome']==true && permdono($meuid)) { 
$update = $mistake->prepare("UPDATE w_comu_cat SET nm = ? WHERE id = ?");
$update->execute(array($_POST['nome'],$id));
}
$nome = $mistake->query("SELECT nm FROM w_comu_cat where id='".$id."'")->fetch();
?>
<form action="/mod/editarcatcomu/<?php echo $id;?>" method="post">
Renomear:<br/><input type="text" name="nome" value="<?php echo $nome['nm'];?>" required>
<input type="submit" value="Editar" /></form><br/>
<?php } else if($a=='editarcat') { ?>
<br/><div id="titulo"><b>Renomear categoria</b></div><br/>
<?php
if($_POST['nome']==true && permdono($meuid)){
$update = $mistake->prepare("UPDATE w_emo_cat SET nm = ? WHERE id = ?");
$update->execute(array($_POST['nome'],$id));
}
$nome = $mistake->query("SELECT nm FROM w_emo_cat where id='".$id."'")->fetch();
?>
<form action="/mod/editarcat/<?php echo $id;?>" method="post">
Renomear:<br/><input type="text" name="nome" value="<?php echo $nome['nm'];?>" required>
<input type="submit" value="Editar" /></form><br/>
<?php } else if($a=='banir') { 
?>
<section class="container-fluid">
<div id="titulo"><b>Banir <?php echo gerarnome($_SESSION['idperfil']);?></b></div><br/>
<div class="card shadow"><div class="card-body"><div class="alert alert-danger" style="display: none"></div>
<form action="/mod/editarusuario/<?php echo $id;?>/banir" method="post">
Escolha: <select name="tipo">
<option value="1">Site em geral</option>
<option value="2">Nas salas</option>
</select><br/>
Banir IP? <select name="ipp">
<option value="0">Não</option>
<option value="1">Sim</option>
</select><br/>
Tempo : <select name="tempo">
<option value="10">Retirar da sala</option>
<option value="600">10 minutos</option>
<option value="1800">30 minutos</option>
<option value="21600">6 horas</option>
<option value="43200">12 horas</option>
<option value="86400">24 horas</option>
</select><br/>
Motivo:<input type="text" class="form-control" name="rz" required>
<button class="btn btn-info btn-block btn-sm" type="submit">Bloquear</button></form></div></div></section>
<?php  }else if($a=='pbloq') { ?>
<br/><div id="titulo"><b>Palavras Bloqueadas</b></div><br/>
<form action="/mod/pbloq" method="post">
site do spam: <input type="text" name="trocar" required><input type="submit" value="OK"></form>
<?php
if(isset($_POST['trocar'])==TRUE){
$stmt= $mistake->prepare("SELECT COUNT(*) FROM w_pbloq WHERE p=:p");
$stmt->execute(array(":p" => "".mb_strtolower($_POST['trocar']).""));
$contid = $stmt->fetch();
if($contid[0]==0) {    
$res = $mistake->prepare("INSERT INTO w_pbloq (p,data,meuid) VALUES (?,?,?)");
$arrayName = array(mb_strtolower($_POST['trocar']),time(),$meuid);
$ii = 0;
for($i=1; $i <=3; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
}else{
?>
<div align="center"><?php echo $imgerro;?>Palavra ja existe</div><br/>
<?php    
}
}
if($pag=='apagar'){
$mistake->exec("DELETE FROM w_pbloq WHERE id='".$id."'");
}
$contemo = $mistake->query("SELECT COUNT(*) FROM w_pbloq")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contemo[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->query("SELECT * FROM w_pbloq ORDER BY id desc LIMIT $limit, $itensporpag");
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<b><?php echo $item->p;?></b><br>Adicionado por: <?php echo gerarnome($item->meuid);?><br>Data: <?php echo date("d/m/Y - H:i:s", $item->data);?> <a href="/mod/pbloq/<?php echo $item->id;?>/apagar"><font color="red">[apagar]</font></a></div>
<?php $i++; }
if($numpag>1) {
paginas('mod',$a,$numpag,$id,$pag);    
} } else { ?>
<div align="center"><?php echo $imgerro;?>Nenhuma palavra bloqueada!<br/>
<?php } } else if($a=='frases') { ?>
<br/><div id="titulo"><b>Frases</b></div><br/>
Adicione aqui frases informativas para serem mostradas aleatóriamente quando o usuário fizer login no site, frases para o pergaminho e perguntas para usuários.<br/><br/>
<form action="/mod/frases" method="post">
Texto:<br/><input type="text" name="txt" required><br/>
frase do site<br/>
<label class="switch">
<input type="radio" name="privado" data-value="1" value="0" checked/>
<span class="slider round"></span>
</label><br/>
pergaminho<br/>
<label class="switch">
<input type="radio" name="privado" data-value="1" value="1"/>
<span class="slider round"></span>
</label><br/>
pergunta para usuários<br/>
<label class="switch">
<input type="radio" name="privado" data-value="1" value="2"/>
<span class="slider round"></span>
</label><br/>
<input type="submit" value="Adicionar"></form>
<?php
if (!empty($_POST['txt'])){    
$privado = isset($_POST['privado']) ? $_POST['privado'] : 0;
$res = $mistake->prepare("INSERT INTO w_frases (txt,cartas,meuid) VALUES (?,?,?)");
$arrayName = array(anti_injection($_POST['txt']),$privado,$meuid);
$ii = 0;
for($i=1; $i <=3; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
}
if($pag=='apagar'){
$contemo = $mistake->query("SELECT meuid FROM w_frases WHERE id='".$id."'")->fetch();
if($meuid==$contemo[0] or permdono($meuid)){
$mistake->exec("DELETE FROM w_frases WHERE id='".$id."'");
$mistake->exec("DELETE FROM w_perg WHERE cod='".$id."'"); 
}else{
?>
<div align="center">
<b><big><?php echo $imgerro;?> Você não tem permisão para isso so pode apagar as adicionadas por voce!</b></big><br /><br />
</div>
<?php		
}
}
$contemo = $mistake->query("SELECT COUNT(*) FROM w_frases")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contemo[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->query("SELECT * FROM w_frases ORDER BY id desc LIMIT $limit, $itensporpag");
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<?php echo $item->txt;?>&emsp;<?php if($item->cartas==1){?><img src='/juegos/pergaminos.gif' style='width:18px;height:18px'><?}if($item->cartas==2){?><img src='/style/amigos.gif' style='width:18px;height:18px'><?}if($item->cartas==0){?><img src='/style/coment.gif' style='width:18px;height:18px'><?}?><a href="/mod/frases/<?php echo $item->id;?>/apagar"><font color="red">[apagar]</font></a></div>
<?php $i++; }
if($numpag>1) {
paginas('mod',$a,$numpag,$id,$pag);    
} } else { ?>
<div align="center"><?php echo $imgerro;?>Nenhuma frase!<br/>
<?php } } else if($a=='acoescf') { ?>
<br/><div id="titulo"><b>Ações da equipe</b></div><br/>
<form action="/mod" method="GET">
<b>Faça Uma Busca:</b><br/><br/><input type="hidden" name="a" value="acoescf">
Nome: <input type="text" name="id" required>
<input type="submit" value="Buscar"></form><br/>
<?php
$id = isset($_GET["id"]) ? $_GET["id"] : 'deletou';
$query="SELECT COUNT(*) FROM w_ltpc WHERE txt LIKE :txt";
$contemo= $mistake->prepare($query);
$contemo->execute(array(":txt" => "%".$id."%"));
$contemo = $contemo->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contemo[0];
$itensporpag = 10;
echo"<br/>Encontrados <b>$numitens</b> items com a palavra <b>$id</b><br/><br/>";
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$sql = "SELECT * FROM w_ltpc WHERE txt LIKE :txt ORDER BY id DESC LIMIT $limit, $itensporpag";
$itens = $mistake->prepare($sql);
$itens->execute(array(":txt" => "%".$id."%"));
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<a href="/<?php echo gerarlogin($item->a);?>"><?php echo gerarnome($item->a);?></a>
<?php echo textot($item->txt,$meuid,$on);?>
</div>
<?php $i++; }
if($numpag>1) {
paginas('mod',$a,$numpag,$id,$pag);    
} } else { ?>
<div align="center"><?php echo $imgerro;?>Nenhuma ação!<br/>
<?php } } else if($a=='emocoessc') { ?>
<br/><div id="titulo"><b>Emoções sem categoria</b></div><br/>
<?php
if(isset($_POST['cat'])!=''){
$mistake->exec("UPDATE w_emocoes SET cat='".$_POST['cat']."' WHERE id='".$id."'");
}
if($pag=='apagar'){
if(permdono($meuid) or perm($meuid)==6) {
$ctft = $mistake->query("SELECT ext,cod FROM w_emocoes WHERE id='".$id."'")->fetch();
if($ctft[0]==true){
@unlink("e/$id.$ctft[0]");
$mistake->exec("DELETE FROM w_emocoes WHERE id='".$id."'");
editandopostagem($meuid,"deletou o smile [i]$ctft[1][/i]. Data [i] $data [/i]");
}
}else{
?>
<div align="center">
<b><big><?php echo $imgerro;?> Você não tem permisão para isso!</b></big><br /><br />
</div>
<?php
}
}
$contemo = $mistake->query("SELECT COUNT(*) FROM w_emocoes where cat='0'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contemo[0];
$itensporpag = 8;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->query("SELECT id, cod FROM w_emocoes where cat='0' ORDER BY id desc LIMIT $limit, $itensporpag");
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<img src="/e/<?php echo $item->id;?>.gif">
<?php echo $item->cod;?> <a href="/mod/emocoessc/<?php echo $item->id;?>/apagar"><font color="red">[apagar]</font></a>
<table><tr><form action="/mod/emocoessc/<?php echo $item->id;?>/<?php echo $pag;?>" method="post">
<td><select name="cat">
<?php $itenss = $mistake->query("SELECT id,nm FROM w_emo_cat ORDER BY nm");
while($items = $itenss->fetch(PDO::FETCH_OBJ)) { ?>
<option value="<?php echo $items->id;?>"><?php echo $items->nm;?></option>
<?php } ?></select>
<input type="submit" value="Alterar"></td></form></tr></table>
</div>
<?php $i++; }
if($numpag>1) {
paginas('mod',$a,$numpag,$id,$pag);    
} } else { ?>
<div align="center"><?php echo $imgerro;?>Nenhuma emoção sem categoria!<br/>
<?php } } else 
if($a=='catemocoesdel') {
if(permdono($meuid)){
$ctft = $mistake->query("SELECT COUNT(*) FROM w_emo_cat WHERE id='".$id."'")->fetch();
if($ctft[0]>0){
$itens = $mistake->query("SELECT id,ext FROM w_emocoes WHERE cat='".$id."'");
while($item = $itens->fetch()) {
@unlink("e/$item[0].$item[1]");
}    
$mistake->exec("DELETE FROM w_emocoes WHERE cat='".$id."'");
$mistake->exec("DELETE FROM w_emo_cat WHERE id='".$id."'");
?>
<div align="center">
<b><big><?php echo $imgok;?> Categoria e smilies apagados!</b></big><br /><br />
</div>
<?php
}
}else{
?>
<div align="center">
<b><big><?php echo $imgerro;?> Você não tem permisão para isso!</b></big><br /><br />
</div>
<?php
}
}else
if($a=='catemocoes') { ?>
<?php
if(perm($meuid)<2) {
?>
<div align="center">
<b><big><?php echo $imgerro;?> Você não tem permisão para isso!</b></big><br /><br />
</div>
<?php
}else{
?>
<br/><div id="titulo"><b>Categoria de Emoções</b></div><br/>
<form action="/mod/catemocoes" method="post">
<b>Adicionar categoria:</b><br/>
Nome: <input type="text" name="cod" required>
<input type="submit" value="Add"></form>
<?php
if(isset($_POST['cod'])!=''){
$res = $mistake->prepare("INSERT INTO w_emo_cat (nm) VALUES (?)");
$arrayName = array($_POST['cod']);
$ii = 0;
for($i=1; $i <=1; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
}
$contemo = $mistake->query("SELECT COUNT(*) FROM w_emo_cat WHERE venda='0'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contemo[0];
$itensporpag = 20;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->query("SELECT id, nm FROM w_emo_cat WHERE venda='0' ORDER BY id desc LIMIT $limit, $itensporpag");
$i=0; while($item = $itens->fetch(PDO::FETCH_OBJ)) {
$contemo2 = $mistake->query("SELECT COUNT(*) FROM w_emocoes where cat='".$item->id."'")->fetch(); ?>
<a href="/mod/emocoes/<?php echo $item->id;?>"><?php echo $item->nm;?>(<?php echo $contemo2[0];?>)</a>
<a href="/mod/delcatemo/<?php echo $item->id;?>"><font color="red">[apagar]</font></a> - <a href="/mod/editarcat/<?php echo $item->id;?>"><font color="red">[renomear]</font></a><br/>
<?php $i++; }
if($numpag>1) {
paginas('mod',$a,$numpag,$id,$pag);
} } else { ?>
<div align="center"><?php echo $imgerro;?>Não existem categorias de emoções!<br/>
<?php } } } else if($a=='delcatemo') { ?>
<?php
if(perm($meuid)<2) {
?>
<div align="center">
<b><big><?php echo $imgerro;?> Você não tem permisão para isso!</b></big><br /><br />
</div>
<?php
}else{
?>
<div align="center"><br/>
Tem certeza que deseja excluir esta categoria de emoções?<br/><br/>
<a href="/mod/catemocoesdel/<?php echo $id;?>">Sim</a> - <a href="/mod?">Não</a><br/><br/>
<?php } }  else if($a=='emocoes') { ?>
<?php
if($_GET['limite']==true){
if(permdono($meuid) or perm($meuid)==6) {
$ctft = $mistake->query("SELECT ext,cod FROM w_emocoes WHERE id='".$_GET['limite']."'")->fetch();
if($ctft[0]==true){
@unlink("e/".$_GET['limite'].".$ctft[0]");
$mistake->exec("DELETE FROM w_emocoes WHERE id='".$_GET['limite']."'");
editandopostagem($meuid,"deletou o smile [i]$ctft[1][/i]. Data [i] $data [/i]");
}
}else{
?>
<div align="center">
<b><?php echo $imgerro;?> Você não tem permisão para isso!</b><br /><br />
</div>
<?php
}
}
$contemo = $mistake->query("SELECT COUNT(*) FROM w_emocoes where cat='".$id."'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contemo[0];
$itensporpag = 8;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->query("SELECT id,cod,ext FROM w_emocoes where cat='".$id."' ORDER BY cod LIMIT $limit, $itensporpag");
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<img src="/e/<?php echo $item->id;?>.<?php echo $item->ext;?>" class="smilies"><br>
<b>Codigo :</b> <?php echo $item->cod;?><br><a href="/mod/emocoes/<?php echo $id;?>/<?php echo $pag;?>/<?php echo $item->id;?>"><font color="red">[apagar]</font></a> 
<a href="/mod/edit_emocao/<?php echo $item->id;?>"><font color="red">[editar]</font></a></div>
<?php $i++; }
if($numpag>1) {
paginas('mod',$a,$numpag,$id,$pag);
} }else { ?>
<div align="center"><?php echo $imgerro;?>Não existem emoções!<br/>
<?php
}}
else if($a == "lista_acoes")
{
if(perm($meuid)==false) {?>
<div align="center"><?php echo $imgerro;?>Acesso negado!
<?php 
rodape(); 
exit(); 
}
	echo "<p align='center' id='titulo'>";
	echo "<b>Ações</b>";

/*
	echo "BBCode: use <b>[usuario1]</b> para imprimir o nome de quem enviou a ação e <b>[usuario2]</b> para imprimir quem recebe!<br/>";
	echo "Por exemplo: <b>[usuario1]</b> atirou um copo de água em <b>[usuario2]</b>. Faça isso no campo <b>Texto da ação</b>.<br />";
*/
	echo "</p><br/>";
	

	echo "<form action='?a=$a' method='POST'>";
	echo "Nome da ação: <input type='text' name='nome' maxlength='100'/>(Ex: Jogar um copo de água)<br />";
	echo "Texto da ação: <input type='text' name='acao' maxlength='200'/>(Ex: atirou um copo de água em)<br />";
	echo "<input type='submit' name='ok' value='Adicionar' />";
	echo "</form><br />";
	
	if(!empty($_POST["ok"]) AND !empty($_POST["nome"]) AND !empty($_POST["acao"]))
	{
		$res = $mistake->exec("INSERT INTO fun_batepapo_acoes SET nome='".$_POST["nome"]."', texto='".$_POST["acao"]."'");
		if($res)
		{
			echo "<script>alert('Ação adicionada com sucesso!')</script>";
		}
		else
		{
			echo "<script>alert('Erro!')</script>";
		}
	}
	else if($_GET["acao"] == "apagar" AND perm($meuid)>2)
	{
	   $res = $mistake->exec("DELETE FROM fun_batepapo_acoes WHERE id='".$_GET["id"]."'");
	    if($res)
		{
			echo "<script>alert('Ação excluída com sucesso!')</script>";
		}
		else
		{
			echo "<script>alert('Erro ao excluir!')</script>";
		}
	}
	
	echo "<hr>";
	$sqlacao = $mistake->query("SELECT * FROM fun_batepapo_acoes ORDER BY id DESC");
	if($sqlacao->rowCount()>0)
	{
		while($resao = $sqlacao->fetch())
		{
			echo "Nome: <b>".$resao["nome"]."</b><br />";
			echo "Texto da ação: <b>".textot($resao["texto"],$meuid,$on)."</b><br />";
			echo "<a href='?a=$a&acao=apagar&id=".$resao["id"]."'>[x]</a> - <a href='?a=editaracao&acaoid=".$resao["id"]."'>[editar]</a> ";
			echo "<hr>";
		}
	}
	else

	{

		echo" <center>".$imgerro."<br />Nenhuma ação adicionada!</center>";
	}

echo "</p>";
}
else if($a=="editaracao")
{
if(perm($meuid)==false) {?>
<div align="center"><?php echo $imgerro;?>Acesso negado!
<?php 
rodape(); 
exit(); 
}
$acaoid = (int)$_GET["acaoid"];
$acao = $_POST["acao"];
$texto = $_POST["texto"];

echo "<div id='titulo'><b>Editar Ação</b></div>";
echo "<p align=\"center\">";
if($_GET["ok"] == "editar" && perm($meuid)>2)
{
$mistake->exec("UPDATE fun_batepapo_acoes SET nome='".$acao."', texto='".$texto."'  WHERE id='".$acaoid."'");

echo $imgok."Ação editada com sucesso!<br/>";
}else{
$infoacao = $mistake->query("SELECT nome, texto FROM fun_batepapo_acoes WHERE id='".$acaoid."'")->fetch();
echo "<form action=\"?a=$a&acaoid=$acaoid&ok=editar\" method=\"POST\">";
echo "Ação: <input name=\"acao\" value=\"$infoacao[0]\"><br>";
echo "Texto da Ação: <input name=\"texto\" value=\"$infoacao[1]\"><br>";
echo "<input value=\"Editar ação\" type=\"submit\"></form>";
echo"<p align='center'>"; 
echo"<a href=\"?a=lista_acoes\">Lista de ações</a>"; 
//echo "</p>";
}
?>
<?php 
} 
else 
if($a=='loja_mn') {
$mistake->exec("DELETE FROM w_loja_m WHERE id='".$id."'");
$mistake->exec("DELETE FROM w_loja_c WHERE cat='".$id."'");
$mistake->exec("DELETE FROM w_loja_cc WHERE valorloja='".$id."'");
$itens = $mistake->query("SELECT * FROM w_loja WHERE valorloja='".$id."'");
while ($item = $itens->fetch(PDO::FETCH_OBJ)) {
unlink('loja/'.$item->id.'.'.$item->ext.'');
}
$mistake->exec("DELETE FROM w_loja WHERE valorloja='".$id."'");
?>
<div align="center">
<b><big><?php echo $imgok;?>loja excluida com sucesso!</b></big><br /><br />
</div>
<?php
}else
if($a=='loja_m') {
if(perm($meuid)<0) {
?>
<div align="center">
<b><big><?php echo $imgerro;?> Você não tem permisão para isso!</b></big><br /><br />
</div>
<?php
}else{
?>
<?php
if($id=='add'){
$res = $mistake->prepare("INSERT INTO w_loja_m (dn,nm) VALUES (?,?)");
$arrayName = array($_POST['dn'],$_POST['nm']);
$ii = 0;
for($i=1; $i <=2; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
}else if($id=='renomear'){
$update = $mistake->prepare("UPDATE w_loja_m SET nm = ?,dn = ? WHERE id = ?");
$update->execute(array($_POST['nm'],$_POST['dn'],$_POST['lj']));
}
?>
<br/><div id="titulo"><b>Lojas</b></div><br/>
<?php
if(perm($meuid)>1) { ?>
<form action="/mod/loja_m/add" method="post">
<b>Adicionar Loja</b><br/>
Nome: <input type="text" name="nm" required><br/>
Dono: <select name="dn">
<?php $itens = $mistake->query("SELECT id,nm FROM w_usuarios where perm>'0' ORDER BY nm");
while($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<option value="<?php echo $item->id;?>"><?php echo $item->nm;?></option>
<?php } ?></select>
<input type="submit" value="Adicionar"></form>
<form action="/mod/loja_m/renomear" method="post">
<br/><b>Renomear loja</b><br/>
Loja: <select name="lj">
<?php $itens = $mistake->query("SELECT id,nm FROM w_loja_m ORDER BY nm");
while($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<option value="<?php echo $item->id;?>"><?php echo $item->nm;?></option>
<?php } ?></select><br/>
Renomear: <input type="text" name="nm" required><br/>
Dono: <select name="dn">
<?php $itens = $mistake->query("SELECT id,nm FROM w_usuarios where perm>'0' ORDER BY nm");
while($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<option value="<?php echo $item->id;?>"><?php echo $item->nm;?></option>
<?php } ?></select>
<input type="submit" value="OK"></form>
<?php }
$contemo = $mistake->query("SELECT COUNT(*) FROM w_loja_m")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contemo[0];
$itensporpag = 8;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->query("SELECT * FROM w_loja_m ORDER BY nm LIMIT $limit, $itensporpag");
$i=0; while($item = $itens->fetch(PDO::FETCH_OBJ)) {
$contcat = $mistake->query("SELECT COUNT(*) FROM w_loja_c where cat='".$item->id."'")->fetch();
$cont = $mistake->query("SELECT count(*) FROM w_loja_cc a, w_loja b, w_loja_c c WHERE a.prod=b.id and b.cat=c.id and c.cat='".$item->id."'")->fetch(); ?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
Dono: <a href="/<?php echo gerarlogin($item->dn);?>"><?php echo gerarnome($item->dn);?></a><br/>
Nome:
<?php if($item->dn==$meuid or permdono($meuid)) { ?>
<a href="/mod/loja/<?php echo $item->id;?>"><?php echo $item->nm;?> (<?php echo $contcat[0];?>)</a>
<?php } else { ?>
<?php echo $item->nm;?> (<?php echo $contcat[0];?>)
<?php }
if(permdono($meuid)) { ?>
- <a href="/mod/excluirloja/<?php echo $item->id;?>/<?php echo $item->id;?>"><font color="red">[apagar]</font></a>
<?php } ?><br/>
Vendas: <b><?php echo $cont[0];?></b>
</div>
<?php $i++; }
if($numpag>1) {
paginas('mod',$a,$numpag,$id,$pag);
} } else { ?>
<div align="center"><?php echo $imgerro;?>Nenhuma loja criada!<br/>
<?php } } }
 else if($a=='excluirloja') { ?>
<?php
if(perm($meuid)<2) {
?>
<div align="center">
<b><big><?php echo $imgerro;?> Você não tem permisão para isso!</b></big><br /><br />
</div>
<?php
}else{
?>
<div align="center"><br/>
Tem certeza que deseja excluir esta lojas?<br/><br/>
<a href="/mod/loja_mn/<?php echo $id;?>">Sim</a> - <a href="/mod?">Não</a><br/><br/>
 <?php } } else if($a=='loja') {
if(perm($meuid)<0) {
?>
<div align="center">
<b><big><?php echo $imgerro;?> Você não tem permisão para isso!</b></big><br /><br />
</div>
<?php
}else{
?>
<?php
if($_GET['limite']=='msg'){
$update = $mistake->prepare("UPDATE w_loja_m SET msg = ? WHERE id = ?");
$update->execute(array($_POST['msg'],$id));
}
$nm = $mistake->query("SELECT nm, msg FROM w_loja_m where id='".$id."'")->fetch();
?>
<br/><div id="titulo"><b>Loja <?php echo $nm[0];?></b></div><br/>
<form action="/mod/loja/<?php echo $id;?>" method="post">
Categoria: <input type="text" name="nm" required><br/>
<input type="submit" value="Adicionar"></form>
<form action="/mod/loja/<?php echo $id;?>/<?php echo $pag;?>/msg" method="post">
<br/>Descrição: <input type="text" name="msg" value="<?php echo $nm[1];?>" required><br/>
<input type="submit" value="Editar"></form>
<?php
if(isset($_POST['nm'])==TRUE){
$res = $mistake->prepare("INSERT INTO w_loja_c (nm,cat) VALUES (?,?)");
$arrayName = array($_POST['nm'],$id);
$ii = 0;
for($i=1; $i <=2; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
}
if($_GET['limite']==TRUE){
$itens = $mistake->query("SELECT * FROM w_loja where cat='".$_GET['limite']."'");
while ($item = $itens->fetch(PDO::FETCH_OBJ)){
@unlink("loja/".$item->id.'.'.$item->ext."");
$mistake->exec("DELETE FROM w_loja WHERE cat='".$_GET['limite']."'");
}
$mistake->exec("DELETE FROM w_loja_c WHERE id='".$_GET['limite']."'");
}
$contemo = $mistake->query("SELECT COUNT(*) FROM w_loja_c where cat='".$id."'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contemo[0];
$itensporpag = 8;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->query("SELECT * FROM w_loja_c where cat='".$id."' ORDER BY nm LIMIT $limit, $itensporpag");
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { 
$pres = $mistake->query("SELECT count(*) FROM w_loja WHERE cat='".$item->id."'")->fetch();
$cont = $mistake->query("SELECT count(*) FROM w_loja_cc a, w_loja b WHERE a.prod=b.id and b.cat='".$item->id."'")->fetch(); ?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<a href="/mod/loja2/<?php echo $item->id;?>"><?php echo $item->nm;?> (<?php echo $pres[0];?>)</a> - 
<a href="/mod/loja/<?php echo $id;?>/<?php echo $pag;?>/<?php echo $item->id;?>"><font color="red">[apagar]</font></a><br/>
Vendas: <b><?php echo $cont[0];?></b></div>
<?php $i++; }
if($numpag>1) {
paginas('mod',$a,$numpag,$id,$pag);
} } else { ?>
<div align="center"><?php echo $imgerro;?>Nenhuma categoria!<br/>
 <?php } } }
else if($a=='loja2') { 
$cat = $mistake->query("SELECT nm,cat FROM w_loja_c WHERE id='".$id."'")->fetch(); ?>
<?php
if(perm($meuid)<1) {
?>
<div align="center">
<b><big><?php echo $imgerro;?> Você não tem permisão para isso!</b></big><br /><br />
</div>
<?php
}else{
?>
<br/><div id="titulo"><b><?php echo $cat[0];?></b></div><br/>
<form action="/mod/loja2/<?php echo $id;?>" method="post" enctype="multipart/form-data">
Nome: <input type="text" name="nm" required><br/>
<input type="hidden" name="valorloja" value="<?php echo $cat[1];?>" size="3">
Valor: <input type="text" name="valor" size="3"> pontos<br/>
Arquivo: <input type="file" name="arquivo"><br/>
<input type="submit" value="Add"></form>
<?php
if(isset($_POST['nm'])!=''){
$arquivo = isset($_FILES["arquivo"]) ? $_FILES["arquivo"] : FALSE;
if (!empty($arquivo["name"])){
if(!preg_match("/^image\/(jpg|jpeg|png|gif)$/", $arquivo["type"])){
echo "$imgerro Arquivo em formato invalido! A imagem deve ser  (jpg|jpeg|png|gif) . Envie outro arquivo<br>";
}else{
preg_match("/.(gif|png|jpg|jpeg){1}$/i", $arquivo["name"], $ext);
$mistake->exec("INSERT INTO w_loja (valor,nm,ext,cat,valorloja) values('".$_POST['valor']."','".$_POST['nm']."','".$ext[1]."','".$id."','".$_POST['valorloja']."')");
$resok = $mistake->lastInsertId();
$newfile = "loja/".$resok.".".$ext[1]."";
if($arquivo["type"]=='image/gif'){
//exec("gifsicle --scale 0.5 -i ".escapeshellarg($arquivo["tmp_name"])." > ".escapeshellarg($newfile)."");
move_uploaded_file($arquivo["tmp_name"],$newfile); 
}else{
//exec("cwebp -q 85 -resize 200 200 ".escapeshellarg($arquivo["tmp_name"])." -o ".escapeshellarg($newfile)."");
move_uploaded_file($arquivo["tmp_name"],$newfile); 
}
}
}
}
if($_GET['del']==true){
$ctft = $mistake->query("SELECT COUNT(*) FROM w_loja WHERE id='".$_GET['limite']."'")->fetch();
if($ctft[0]>0){
@unlink("loja/".$_GET['limite'].".".$_GET['del']."");
$mistake->exec("DELETE FROM w_loja WHERE id='".$_GET['limite']."'");
}
} 
$contemo = $mistake->query("SELECT COUNT(*) FROM w_loja where cat='".$id."'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contemo[0];
$itensporpag = 8;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->query("SELECT * FROM w_loja where cat='".$id."' ORDER BY id desc LIMIT $limit, $itensporpag");
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { 
$cont = $mistake->query("SELECT count(*) FROM w_loja_cc where prod='".$item->id."'")->fetch(); ?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<img width="50px" src="/loja/<?php echo $item->id;?>.<?php echo $item->ext;?>"><?php echo $item->nm;?> - <a href="/mod/loja2/<?php echo $id;?>/<?php echo $pag;?>/<?php echo $item->id;?>/<?php echo $item->ext;?>">
<font color="red">[apagar]</font></a><br/>
Vendas: <b><?php echo $cont[0];?></b></div>
<?php $i++; } 
if($numpag>1) {
paginas('mod',$a,$numpag,$id,$pag);
} } else { ?>
<div align="center"><?php echo $imgerro;?>Nenhum arquivo!<br/>
<?php } } } 
else if($a=='schat') { ?>
<br/><div id="titulo"><b>Salas de chat</b></div><br/>
<form action="/mod/schat" method="post" enctype="multipart/form-data">
Nome: <input type="text" name="nome" required><br/>
Permição:<br/><select name="perm">
<option value="0">Todos</option>
<option value="1">Vips e equipe</option>
<option value="2">Equipe</option>
</select><br/>
<input type="submit" value="Adicionar"></form>
<?php
if(isset($_POST['nome'])==TRUE){
$res = $mistake->prepare("INSERT INTO w_schat (nm,perm) VALUES (?,?)");
$arrayName = array($_POST['nome'],$_POST['perm']);
$ii = 0;
for($i=1; $i <=2; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
}
if($pag=='apagar'){
$mistake->exec("DELETE FROM w_schat WHERE id='".$id."'");
}
$contemo = $mistake->query("SELECT COUNT(*) FROM w_schat")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contemo[0];
$itensporpag = 8;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->query("SELECT * FROM w_schat ORDER BY id desc LIMIT $limit, $itensporpag");
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<?php echo $item->nm;?> <a href="/mod/schat/<?php echo $item->id;?>/apagar"><font color="red">[apagar]</font></a></div>
<?php $i++; }
if($numpag>1) {
paginas('mod',$a,$numpag,$id,$pag);
} } else { ?>
<div align="center"><?php echo $imgerro;?>Nenhuma sala criada!<br/>
<?php } } 
else 
 if($a=='parceiros') { ?>
<br/><div id="titulo"><b>Parceiros</b></div><br/>
<form action="/mod/parceiros" method="post" enctype="multipart/form-data">
Banner (opcional):<input type="file" name="arquivo"><br/>    
Nome: <input type="text" name="nome" required><br/>
Endereço: <input type="text" name="end" value="https://" required><br/>
Descrição: <input type="text" name="des" required><br/>
<input type="submit" value="Adicionar"></form>
<?php
$arquivo = isset($_FILES["arquivo"]) ? $_FILES["arquivo"] : FALSE;
if (!empty($arquivo["name"])){
$pasta = "temas/";
$newfile = "by-nandosp-".time()."-".$arquivo["name"]."";
if(!preg_match("/^image\/(jpg|jpeg|png|gif)$/", $arquivo["type"])){
echo "$imgerro Arquivo em formato invalido! A imagem deve ser  (jpg|jpeg|png|gif) . Envie outro arquivo<br>";
}else{
if($arquivo["type"]=='image/gif'){
//exec("gifsicle --scale 0.5 -i ".escapeshellarg($arquivo["tmp_name"])." > ".escapeshellarg($pasta.$newfile)."");
move_uploaded_file($arquivo["tmp_name"],$pasta.$newfile); 
}else{
//exec("convert ".escapeshellarg($arquivo["tmp_name"])." -resize 50% ".escapeshellarg($pasta.$newfile)."");
move_uploaded_file($arquivo["tmp_name"],$pasta.$newfile); 
}
}
if(isset($_POST['nome'])==TRUE){
$mistake->exec("INSERT INTO w_parceiros (nm,des,url,dt,banner) values('".$_POST['nome']."','".$_POST['des']."','".$_POST['end']."','".time()."','".$pasta."".$newfile."')");
}
}else{
if(isset($_POST['nome'])==TRUE){
$mistake->exec("INSERT INTO w_parceiros (nm,des,url,dt) values('".$_POST['nome']."','".$_POST['des']."','".$_POST['end']."','".time()."')");
}    
}
if($_GET['limite']=='apagar'){
$contmsg = $mistake->query("SELECT banner FROM w_parceiros WHERE id='".$id."'")->fetch();
@unlink($contmsg[0]);
$mistake->exec("DELETE FROM w_parceiros WHERE id='".$id."'");
}
$contemo = $mistake->query("SELECT COUNT(*) FROM w_parceiros")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contemo[0];
$itensporpag = 8;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->query("SELECT * FROM w_parceiros ORDER BY id desc LIMIT $limit, $itensporpag");
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<?php echo $item->nm;?> <a href="/mod/parceiros/<?php echo $item->id;?>/<?php echo $pag;?>/apagar"><font color="red">[apagar]</font></a></div>
<?php $i++; }
if($numpag>1) {
paginas('mod',$a,$numpag,$id,$pag);
} } else { ?>
<div align="center"><?php echo $imgerro;?>Nenhum parceiro<br/>
<?php } }else 
if($a=='dialogo') {
ativo($meuid,'Página principal'); 
if($meuid==1 or perm($meuid)==4) {
?>
<br/><div id="titulo"><b>Mensagens enviadas por <a href="/<?php echo gerarlogin($id);?>"><?php echo gerarnome($id);?></a></b></div><br/>
<?php
$contmsg = $mistake->query("SELECT COUNT(*) FROM w_msgs WHERE (por='".$id."' or pr='".$id."') and dl='0'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contmsg[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->query("SELECT * FROM w_msgs WHERE (por='".$id."' or pr='".$id."') and dl='0' ORDER BY id desc LIMIT $limit, $itensporpag");
$i=0; 
while ($item = $itens->fetch(PDO::FETCH_OBJ)) {
if(perm($meuid)==4 or perm($item->pr)!=4 and perm($item->por)!=4){
?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<?
if($item->por){
?>
<small>Enviou</small> <a href="/mod/dialogo/<?php echo $item->por;?>"><?php echo gerarnome($item->por);?></a><br/>
<?
}
if($item->pr){
?>
<small>Recebeu</small> <a href="/mod/dialogo/<?php echo $item->pr;?>"><?php echo gerarnome($item->pr);?></a><br/>
<?
}
?>
<span style="color:<?php echo $item->cor;?>"><?php echo textot($item->txt,$meuid,$on);?></span><br/>
Data: <?php echo date("d/m/Y - H:i:s", $item->hr);?>
</div>
<?
$i++; 
}
}
if($numpag>1) {
paginas('mod',$a,$numpag,$id,$pag);
} 
}else{
?>
<div align="center"><?php echo $imgerro;?>Nenhuma mensagem !<br/>
<?php     
}
}else{
?>
<div align="center"><?php echo $imgerro;?>Pagina em construção!<br/>
<?php    
}
} else
if($a=='msgdn') { ?>
<?php
if($pag=='apagar'&&permdono($meuid)){
$ac = $mistake->exec("DELETE FROM mmistake_logs WHERE id='".$id."'");
}
?>
<br/><div id="titulo"><b>Mensagens denunciadas</b></div><br/>
<?php
if($id=='mensagem' || $id=='mural' || $id=='forum'){
$contmsg = $mistake->query("SELECT COUNT(*) FROM mmistake_logs where acao='".$id."'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contmsg[0];
$itensporpag = 8;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->query("SELECT * FROM mmistake_logs where acao='".$id."' ORDER BY id desc LIMIT $limit, $itensporpag");
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
Por: <a href="/<?php echo gerarlogin($item->meuid);?>"><?php echo gerarnome($item->meuid);?></a><br/>
<?
if($item->para>0){
?>
Para: <a href="/<?php echo gerarlogin($item->para);?>"><?php echo gerarnome($item->para);?></a><br/>
<?
}
?>
Texto: <?php echo $item->texto;?>
<br />
<a href="/mod/msgdn/<?php echo $item->id;?>/apagar">[apagar]</a>
</div>
<?php $i++; }
if($numpag>1) {
paginas('mod',$a,$numpag,$id,$pag);
} 
} else { 
?>
<div align="center"><?php echo $imgerro;?>Nenhuma mensagem denunciada!<br/>
<?php 
} 
}else{
?>
<div align="center"><?php echo $imgerro;?>Nenhuma mensagem denunciada!<br/>
<?php     
}
} else if($a=='ips') {
$ip = $mistake->query("SELECT ip FROM w_usuarios where id='".$id."'")->fetch();
?>
<br/><div id="titulo"><b>IP: <?php echo $ip[0];?></b></div><br/>
<?php
$contip = $mistake->query("SELECT count(*) FROM w_usuarios where ip='$ip[0]'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contip[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->query("SELECT id FROM w_usuarios where ip='".$ip[0]."' ORDER BY nm LIMIT $limit, $itensporpag");
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<?php echo online($item->id)>0?gstat($item->id,$im[0]):$imgoff;?><a href="/<?php echo gerarlogin($item->id);?>">
<?php echo gerarnome($item->id);?></a></div>
<?php $i++; } } else { ?>
<div align="center"><?php echo $imgerro;?>Não ah usuários com este ip <?php }
if($numpag>1) {
paginas('mod',$a,$numpag,$id,$pag);
} 
}else 
if($a=='usuinativos') { 
if($id=='apagartodos') {
if(permdono($meuid)){    
$ativoo = time()-15552000;
$itens = $mistake->query("SELECT id,ativo FROM w_usuarios where ativo<'$ativoo'");
while($item = $itens->fetch(PDO::FETCH_OBJ)){
apagardevez($item->id);
$res = $mistake->exec("DELETE FROM w_usuarios WHERE id='".$item->id."'");
}
}else{
?>
<div align="center"><?php echo $imgerro;?>permição negada</div> 
<?php   
}
} 
?>
<br/><a href="/mod/usuinativos/apagartodos"><font color="#FF0000">Excluir todos</font></a><br/>
<br/><div id="titulo"><b>Usuários inativos</b></div><br/>
<?php
$ativoo = time()-15552000;
$cont = $mistake->query("SELECT count(*) FROM w_usuarios where ativo<'$ativoo'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $cont[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->prepare("SELECT id,ativo FROM w_usuarios where ativo<'$ativoo' ORDER BY ativo asc LIMIT $limit, $itensporpag");
$i=0; 
$itens->execute();
while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<a href="/<?php echo gerarlogin($item->id);?>"><?php echo gerarnome($item->id);?></a> -
<?php echo gerartempo(time()-$item->ativo);
if(perm($meuid)==3 OR perm($meuid)==4) { ?>
- <a href="/mod/editarusuario/<?php echo $item->id;?>"><font color="#FF0000">[apagar]</font></a>
<?php } ?>
</div>
<?php $i++; } } else { ?>
<div align="center"><?php echo $imgerro;?>Nenhum usuário inativo a mais de 6 meses <?php }
if($numpag>1) {
paginas('mod',$a,$numpag,$id,$pag);    
} 
}else 
if($a=='cat_forum') { 
if(perm($meuid)<2) {
?>
<div align="center">
<b><big><?php echo $imgerro;?> Você não tem permisão para isso!</b></big><br /><br />
</div>
<?php
}else{
?>
<br/><div id="titulo"><b>Categorias Fórum</b></div><br/>
<form action="/mod/cat_forum" method="post">
Nome: <input type="text" name="nome" required>
<input type="submit" value="Adicionar"></form>
<?php
if(isset($_POST['nome'])==TRUE){
$res = $mistake->prepare("INSERT INTO w_cat_forum (nm) VALUES (?)");
$arrayName = array($_POST['nome']);
$ii = 0;
for($i=1; $i <=1; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
}
if($pag=='apagar' and permdono($meuid)){
$mistake->exec("DELETE FROM w_cat_forum WHERE id='".$id."'");
}
$contemo = $mistake->query("SELECT COUNT(*) FROM w_cat_forum")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contemo[0];
$itensporpag = 8;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->query("SELECT * FROM w_cat_forum ORDER BY id desc LIMIT $limit, $itensporpag");
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) {
$contcomu = $mistake->query("SELECT COUNT(*) FROM w_sub_forum where cat='".$item->id."'")->fetch();
?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<?php echo $item->nm;?>(<?php echo $contcomu[0];?>) <a href="/mod/cat_forum/<?php echo $item->id;?>/apagar"><font color="red">[apagar]</font></a><a href="/mod/editarcatforum/<?php echo $item->id;?>">[renomear]</a></div>
<?php $i++; } 
if($numpag>1) {
paginas('mod',$a,$numpag,$id,$pag);    
} } else { ?>
<div align="center"><?php echo $imgerro;?>Nenhuma categoria de forum!<br/>
<?php } } }
else if($a=='cat_sub_forum') { ?>
<?php
if(perm($meuid)<2) {
?>
<div align="center">
<b><big><?php echo $imgerro;?> Você não tem permisão para isso!</b></big><br /><br />
</div>
<?php
}else{
?>
<br/><div id="titulo"><b>Adicionar Sub-Categorias Fórum</b></div><br/>
<p align="center">Escolha uma categoria para gerenciar suas sub-categorias.</p>
<?php $itens = $mistake->query("SELECT * FROM w_cat_forum ORDER BY nm");
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<a href="/mod/cat_sub_forum2/<?php echo $item->id;?>"><?php echo $item->nm;?></a>
 </div>
 <?php
$i++;
}
?>
<?php } }
else if($a=='cat_sub_forum2') { ?>
<?php
if(perm($meuid)<2) {
?>
<div align="center">
<b><big><?php echo $imgerro;?> Você não tem permisão para isso!</b></big><br /><br />
</div>
<?php
}else{
$nmcomu = $mistake->query("SELECT nm FROM w_cat_forum WHERE id='".$id."'")->fetch();
?>
<br/><div id="titulo"><b>Sub-Categorias <?php echo $nmcomu[0];?>
</b></div><br/>
<form action="/mod/cat_sub_forum2/<?php echo $id;?>" method="post">
Nome: <input type="text" name="nome" required>
<input type="submit" value="Adicionar"></form>
<?php
if(isset($_POST['nome'])==TRUE){
$res = $mistake->prepare("INSERT INTO w_sub_forum (nm,cat) VALUES (?,?)");
$arrayName = array($_POST['nome'],$id);
$ii = 0;
for($i=1; $i <=2; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
}
if($pag=='apagar' and permdono($meuid)){
$mistake->exec("DELETE FROM w_sub_forum WHERE id='".$id."'");
}
$contemo = $mistake->query("SELECT COUNT(*) FROM w_sub_forum WHERE cat='".$id."'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contemo[0];
$itensporpag = 8;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->query("SELECT * FROM w_sub_forum WHERE cat='".$id."' ORDER BY id desc LIMIT $limit, $itensporpag");
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) {
$contcomu = $mistake->query("SELECT COUNT(*) FROM w_topicos where tc='".$item->id."'")->fetch();
?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<?php echo $item->nm;?>(<?php echo $contcomu[0];?>) <a href="/mod/cat_sub_forum2/<?php echo $item->id;?>/apagar"><font color="red">[apagar]</font></a>
<a href="/mod/editarsubcat/<?php echo $item->id;?>">[renomear]</a>
</div>
<?php $i++; }
if($numpag>1) {
paginas('mod',$a,$numpag,$id,$pag);    
} } else { ?>
<div align="center"><?php echo $imgerro;?>Nenhuma sub-categoria de forum!<br/>
<?php } } }
else if($a=='comunidades') { ?>
<?php
if(perm($meuid)<2) {
?>
<div align="center">
<b><big><?php echo $imgerro;?> Você não tem permisão para isso!</b></big><br /><br />
</div>
<?php
}else{
?>
<br/><div id="titulo"><b>Categorias</b></div><br/>
<form action="/mod/comunidades" method="post">
Nome: <input type="text" name="nome" required>
<input type="submit" value="Adicionar"></form>
<?php
if(isset($_POST['nome'])==TRUE){
$res = $mistake->prepare("INSERT INTO w_comu_cat (nm) VALUES (?)");
$arrayName = array($_POST['nome']);
$ii = 0;
for($i=1; $i <=1; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
}
if($pag=='apagar' and permdono($meuid)){
$mistake->exec("UPDATE w_comu SET cat='0' WHERE cat='".$id."'");
$mistake->exec("UPDATE w_enquetes SET cat='0' WHERE cat='".$id."'");
$mistake->exec("DELETE FROM w_comu_cat WHERE id='".$id."'");
}
$contemo = $mistake->query("SELECT COUNT(*) FROM w_comu_cat")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contemo[0];
$itensporpag = 8;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->query("SELECT * FROM w_comu_cat ORDER BY id desc LIMIT $limit, $itensporpag");
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) {
$contcomu = $mistake->query("SELECT COUNT(*) FROM w_comu where cat='".$item->id."'")->fetch();
?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<?php echo $item->nm;?>(<?php echo $contcomu[0];?>) <a href="/mod/comunidades/<?php echo $item->id;?>/apagar"><font color="red">[apagar]</font></a><a href="/mod/editarcatcomu/<?php echo $item->id;?>"><font color="red">[renomear]</font></a></div>
<?php $i++; }
if($numpag>1) {
paginas('mod',$a,$numpag,$id,$pag);    
} } else { ?>
<div align="center"><?php echo $imgerro;?>Nenhuma categoria de comunidades!<br/>
<?php } } }
else if($a=='regpontos') { ?>
<br/><div id="titulo"><b>Pontos de usuários</b></div><br/>
<?php
$contpontos = $mistake->query("SELECT COUNT(*) FROM w_pontos")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contpontos[0];
$itensporpag = 8;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->query("SELECT * FROM w_pontos ORDER BY id desc LIMIT $limit, $itensporpag");
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<a href="/<?php echo gerarlogin($item->uid);?>"><?php echo gerarnome($item->uid);?></a>
 <?php echo ($item->dt==1)?('deu'):('tirou');?> <?php echo $item->pt;?> pontos <?php echo ($item->dt==1)?('para'):('de');?>
 <a href="/<?php echo gerarlogin($item->aid);?>"><?php echo gerarnome($item->aid);?></a> dia
<?php echo date("d/m/Y", $item->hr);?> as <?php echo date("H:i:s", $item->hr);?> com <?php echo $item->nv;?> e ip <?php echo $item->ip;?><br/>
Razão: <?php echo $item->rz;?>
</div>
<?php $i++; }
if($numpag>1) {
paginas('mod',$a,$numpag,$id,$pag);
} } else { ?>
<div align="center"><?php echo $imgerro;?>Nenhuma alteração de pontos!<br/>
<?php } } else if($a=='quiz') {
if(perm($meuid)<2) {
?>
<div align="center">
<b><big><?php echo $imgerro;?> Você não tem permisão para isso!</b></big><br /><br />
</div>
<?php
}else{
?>
<br/><div id="titulo"><b>Quiz - Categorias</b></div><br/>
<form action="/mod/quiz/0/<?php echo $pag;?>" method="post">
<input type="submit" value="Alterar"></form>
<form action="/mod/quiz/0/<?php echo $pag;?>" method="post">
Adicionar categoria:<br/>
<input type="text" name="nm" required>
<input type="submit" value="Add"></form>
<?php
if(isset($_POST['editar'])!=''){
$update = $mistake->prepare("UPDATE w_quiz SET nm = ? WHERE id = ?");
$update->execute(array($_POST['editar'],$_GET['limite']));
}
if(isset($_POST['nm'])!=''){
$res = $mistake->prepare("INSERT INTO w_quiz (nm) VALUES (?)");
$arrayName = array($_POST['nm']);
$ii = 0;
for($i=1; $i <=1; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
}
if($_GET['limite']=='apagar'){
$mistake->exec("DELETE FROM w_quiz2 WHERE cat='".$id."'");
$mistake->exec("DELETE FROM w_quiz WHERE id='".$id."'");
}
$contemo = $mistake->query("SELECT COUNT(*) FROM w_quiz")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contemo[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->query("SELECT id, nm FROM w_quiz ORDER BY id desc LIMIT $limit, $itensporpag");
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { 
$prg = $mistake->query("SELECT COUNT(*) FROM w_quiz2 where cat='".$item->id."'")->fetch(); ?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<a href="/mod/quiz2/<?php echo $item->id;?>"><?php echo $item->nm;?>(<?php echo $prg[0];?>)</a> - <a href="/mod/delcatquiz/<?php echo $item->id;?>/<?php echo $pag;?>/apagar"><font color="red">[apagar]</font></a> <a href="/mod/editarquiz/<?php echo $item->id;?>/<?php echo $pag;?>"><font color="red">[editar]</font></a></div>
<?php $i++; }
if($numpag>1) {
paginas('mod',$a,$numpag,$id,$pag);
} } else { ?>
<div align="center"><?php echo $imgerro;?>Nenhuma categoria!<br/>
<?php } } } else if($a=='editarquiz') { ?>
<?php
if(perm($meuid)<2) {
?>
<div align="center">
<b><big><?php echo $imgerro;?> Você não tem permisão para isso!</b></big><br /><br />
</div>
<?php
}else{
$contemo = $mistake->query("SELECT nm FROM w_quiz where id='".$id."'")->fetch();
?>
<br/><div id="titulo"><b>Quiz - Editar Categoria</b></div><br/>
<form action="/mod/quiz/0/<?php echo $pag;?>/<?php echo $id;?>" method="post">
Editar Categoria:<br/>
<input type="text" name="editar" value="<?php echo $contemo[0];?>" required>
<input type="submit" value="Editar"></form>
<?php } } else if($a=='delcatquiz') { ?>
<?php
if(perm($meuid)<2) {
?>
<div align="center">
<b><big><?php echo $imgerro;?> Você não tem permisão para isso!</b></big><br /><br />
</div>
<?php
}else{
?>
<div align="center"><br/>
Tem certeza que deseja excluir esta categoria do quiz?<br/><br/>
<a href="/mod/quiz/<?php echo $id;?>/<?php echo $pag;?>/apagar">Sim</a> - <a href="/mod?">Não</a><br/><br/>
<?php } } else if($a=='quiz2') { $nm = $mistake->query("SELECT nm FROM w_quiz where id='".$id."'")->fetch(); ?>
<br/><div id="titulo"><b><?php echo $nm[0];?></b></div><br/>
<form action="/mod/quiz2/<?php echo $id;?>" method="post">
Pergunta:<br/>
<input type="text" name="prg" required><br/>
1º resposta:<br/>
<input type="text" name="pr" required><br/>
2º resposta:<br/>
<input type="text" name="sr" required><br/>
3º resposta:<br/>
<input type="text" name="tr" required><br/>
Resposta certa:<br/><select name="rc">
<option value="1">Primeira</option>
<option value="2">Segunda</option>
<option value="3">Terceira</option>
</select><br/>
<input type="submit" value="Add"></form>
<?php
if(isset($_POST['prg'])!=''){
$res = $mistake->prepare("INSERT INTO w_quiz2 (prg,r1,r2,r3,ct,cat) VALUES (?,?,?,?,?,?)");
$arrayName = array($_POST['prg'],$_POST['pr'],$_POST['sr'],$_POST['tr'],$_POST['rc'],$id);
$ii = 0;
for($i=1; $i <=6; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
}
if($pag=='apagar'){
$mistake->exec("DELETE FROM w_quiz2 WHERE id='".$id."'");
}
$contemo = $mistake->query("SELECT COUNT(*) FROM w_quiz2 where cat='".$id."'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contemo[0];
$itensporpag = 8;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->query("SELECT id, prg FROM w_quiz2 where cat='".$id."' ORDER BY id desc LIMIT $limit, $itensporpag");
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<?php echo $item->prg;?> - <a href="/mod/quiz2/<?php echo $item->id;?>/apagar"><font color="red">[apagar]</font></a></div>
<?php $i++; }
if($numpag>1) {
paginas('mod',$a,$numpag,$id,$pag);
} } else { ?>
<div align="center"><?php echo $imgerro;?>Nenhuma pergunta!<br/>
<?php 
} 
}else if($a=='senhaequipe') { ?>
<?php
if(permdono($meuid)){ 
?>
<br/><div id="titulo"><b>Alterar senha de painel de <?php echo gerarnome($id);?></b></div><br/>
<form action="/mod/senhaequipe2/<?php echo $id;?>" method="post">
Nova senha: <input type="password" name="senha" maxlength="15"><br/>
<input type="submit" value="Alterar">
</form>
<?php
}else{
?>
<div align="center">
<b><big><?php echo $imgerro;?> Você não tem permisão para isso!</b></big><br /><br />
</div>
<?php 
}
}else 
if($a=='loginsenha') { ?>
<?php
if(perm($meuid)>0){ 
?>
<br/><div id="titulo"><b>Alterar senha de <?php echo gerarnome($id);?></b></div><br/>
<form action="/mod/loginsenha2/<?php echo $id;?>" method="post">
Nova senha: <input type="password" name="senha" maxlength="15"><br/>
<input type="submit" value="Alterar">
</form>
<?php
}else{
?>
<div align="center">
<b><big><?php echo $imgerro;?> Você não tem permisão para isso!</b></big><br /><br />
</div>
<?php 
}
}else 
 if($a=='navegador') {
?>
<br/><div id="titulo"><b>Dados do navegador de <?= gerarnome($id);?></b></div><br/> 
<?
$usual = $mistake->query("SELECT nav FROM w_usuarios WHERE id='".$id."'")->fetch();     
//$browser = get_browser($usual[0]);
if($usual[0]==true){
    $i=0;
/*
foreach ($browser as $name => $value) {
?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<?
echo "<b>$name</b> $value </div>";
$i++;
}*/
echo "$usual[0]</div><br/>";
}else{
?>
<div align="center">
<?php echo $imgerro;?> Sem dados disponíveis!
<br />
</div>
<?php    
}
}else
if($a=='senhaequipe2') { 
if(permdono($meuid)){
if(perm($id)==4 or $id==1){
?>
<div align="center">
<b><big><?php echo $imgerro;?> Você não tem permisão para isso!</b></big><br /><br />
</div>
<?php   
}else{
?>
<br/><div align="center">
<?php
if(strlen($_POST['senha'])<4 or strlen($_POST['senha'])>15) { 
echo $imgerro;?>
Senha deve ter entre 4 e 15 caracteres!<br/>
<?php 
} else {
$txtt = "trocou a senha de painel de [b] ".gerarnome2($id)." [/b], ID: [b] $id [/b]. Data: [i] $data [/i] ";
editandopostagem($meuid,$txtt);
$res = $mistake->exec("UPDATE w_usuarios SET senhaequipe='".$_POST['senha']."' WHERE id='".$id."'");
if($res) { echo $imgok;?>
A senha de painel de <a href="/<?php echo gerarlogin($id);?>"><?php echo gerarnome($id);?></a> foi alterada com sucesso!<br/>
<?php 
} else { 
echo $imgerro;?>Erro ao atualizar senha!<br/>
<?php 
}
}
}
}
} else
if($a=='loginsenha2') { 
if(perm($meuid)==3 or perm($meuid)==4){
if(perm($id)==4 or $id==1){
?>
<div align="center">
<b><big><?php echo $imgerro;?> Você não tem permisão para isso!</b></big><br /><br />
</div>
<?php   
}else{
?>
<br/><div align="center">
<?php
if(strlen($_POST['senha'])<4 or strlen($_POST['senha'])>15) { echo $imgerro;?>
Sua senha deve ter entre 4 e 15 caracteres!<br/>
<?php } else {
$txtt = "trocou a senha de [b] ".gerarnome2($id)." [/b], ID: [b] $id [/b]. Data: [i] $data [/i] ";
editandopostagem($meuid,$txtt);
$res = $mistake->exec("UPDATE w_usuarios SET sh='".md5($_POST['senha'])."' WHERE id='".$id."'");
if($res) { echo $imgok;?>
A senha de <a href="/<?php echo gerarlogin($id);?>"><?php echo gerarnome($id);?></a> foi alterada com sucesso!<br/>
<?php } else { echo $imgerro;?>
Erro ao atualizar senha!<br/>
<?php 
} 
} 
}
}else{
?>
<div align="center">
<b><big><?php echo $imgerro;?> Você não tem permisão para isso!</b></big><br /><br />
</div>
<?php 
}
}else
if($a=='novidades') {
?>
<br/><div id="titulo"><b>Novidades No Script e Atualizações</b></div><br/> 
<?
//echo file_get_contents('https://socialcrazy.net/novidade.php');    
}else{
$msgdn = $mistake->query("SELECT count(*) FROM w_msgs where dn='1'")->fetch();
$ajuda = $mistake->query("SELECT COUNT(*) FROM w_ajuda where ac='0' and smile='0'")->fetch();
$usu = $mistake->query("SELECT COUNT(*) FROM w_usuarios where liberado='0'")->fetch();
$pix = $mistake->query("SELECT COUNT(*) FROM w_pix where status='0'")->fetch();
?>
<div id="titulo"><b>Painel da equipe</b></div><br/>
<div align="center">
<small><font color="red">OBS: Caso tenha dúvidas ou  não saiba útilizar completamente o painel da equipe entre em contato com o programador do site.</font></small>
</div>
<br />
<?
function get_server_cpu_usage(){ $load = sys_getloadavg(); return $load[1]; }
?><br/><center><div id="load">Carga do servidor: <?= get_server_cpu_usage(); ?><br/>Versão atual do PHP é <?php echo phpversion();?></div></center>
<br /><?
if(permdono($meuid)){
?>
<div id="div1"><a href="/mod/pix"><?php echo $imgseta;?> Transações PIX(<?php echo $pix[0];?>)</a></div>
<div id="div2"><a href="/mod/geral"><?php echo $imgseta;?> Configurações gerais</a></div>
<?
}?>
<div id="div1"><a href="/mod/edicoes"><?php echo $imgseta;?> Gerenciar o site</a></div>
<div id="div2"><a href="/mod/mensagem"><?php echo $imgseta;?> Mensagem p/ todos</a></div>
<div id="div1"><a href="/estatisticas/usuarios"><?php echo $imgseta;?> Usuários Cadastrado</a></div>
<div id="div2"><a href="/mod/times"/><?php echo $imgseta;?> Adicionar Times</a></div>
<div id="div1"><a href="/mod?a=lista_acoes"/><?php echo $imgseta;?> lista de acoes</a></div>
<div id="div2"><a href="/mod/liberar"><?php echo $imgseta;?> Liberar usuários(<?php echo $usu[0];?>)</a></div>
<div id="div1"><a href="/mod/ajuda"><?php echo $imgseta;?> Sugestões de usuários(<?php echo $ajuda[0];?>)</a></div>
<?
if(perm($meuid)>2){
?>
<div id="div2"><a href="/mod/addsmile"><?php echo $imgseta;?> Adicionar Smilies</a></div>
<div id="div1"><a href="/mod/excluirdados"><?php echo $imgseta;?> Excluir dados</a></div>
<div id="div2"><a href="/mod/cores_site"><?php echo $imgseta;?> Alterar cores do site</a></div>
<div id="div1"><a href="/mod/logs"><?php echo $imgseta;?> Logs do sistema</a></div>
<?php 
$libera = $mistake->query("SELECT vs,mostrastatus FROM w_usuarios WHERE id='$meuid'")->fetch();
if($libera[0]=='1'){
?>
<div id="div1"><a href="/mod/0/onhall/0"><?php echo $imgseta;?> Online</a></div>
<?php
}else{
?>
<div id="div1"><a href="/mod/0/onhall/1"><?php echo $imgseta;?> Offline</a></div>
<?php 
}
if($libera[1]=='1'){
?>
<div id="div2"><a href="/mod/0/onstatus/0"><?php echo $imgseta;?> Mostrar status</a></div>
<?php
}else{
?>
<div id="div2"><a href="/mod/0/onstatus/1"><?php echo $imgseta;?> Não Mostrar status</a></div>
<?php 
}
}    
}
?>

<br/><div align="center">
<?php if($a==true) { echo $imgseta;?><a href="/mod?">Painel da equipe</a><br/> <?php }?>
<div class="col-12 text-center" style="margin-top: 20px"><a href="javascript:window.history.back();"><?php echo $imgsetavoltar;?> Voltar</a></div><br/>
<?php echo rodape();?>
</body>
</html>