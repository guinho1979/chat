<?php
require_once("".$_SERVER["DOCUMENT_ROOT"]."/funcoes.php");
require_once("".$_SERVER["DOCUMENT_ROOT"]."/mistake.php");
maiortempo();
seg($meuid);    
ativo($meuid,'Saindo do site ');
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
$mistake->exec("DELETE FROM w_usuarios WHERE id='".$id."' and visitante='1'");
}
}
$confere = $mistake->query("SELECT visitante FROM w_usuarios WHERE id='".$meuid."'")->fetch();
if($confere[0]==1){
@apagardevez($meuid);
}
$mistake->exec("UPDATE w_usuarios SET to1='0',onl='0',inativo='0' WHERE id='$meuid'");
$mistake->exec("UPDATE w_geral SET saiu='$meuid'");
header("Location:/");
/*
foreach ($_COOKIE as $cookie_name => $cookie_value) {
if($cookie_name!='autologin' && $cookie_name!='auto_usuario' && $cookie_name!='auto_senha' && $cookie_name!='Maior-de-18' && $cookie_name!='diretorio'){
setcookie($cookie_name,null,-1,'/');
}
}
*/
session_destroy();
?>
<p align="center">
Que pena que você saiu do site... 
</p>
<div align="center">
Estamos aguardando você novamente no <?php echo nome_site(); ?><br />
<strong>Seu perfil já foi retirado da lista de usuários online.</strong><br />
<?php
if($_COOKIE['autologin']==1){
?>
Lembrando que você marcou a opção continuar conectado na página de login, para entrar no site é só você acessar nosso endereço <br />
<?php } ?>
<br /><a href="/"><?php echo $_SERVER['SERVER_NAME'];?></a>
</div>
<?php
rodape();