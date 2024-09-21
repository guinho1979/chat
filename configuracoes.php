<?php
require_once("".$_SERVER["DOCUMENT_ROOT"]."/funcoes.php");
require_once("".$_SERVER["DOCUMENT_ROOT"]."/mistake.php");
seg($meuid);
if($a=='') { 
ativo($meuid,'Painel do Usuário ');
$albuns = $mistake->query("SELECT COUNT(*) FROM w_albuns WHERE dn='$meuid'")->fetch();
$emo = $mistake->query("SELECT COUNT(*) FROM w_emocoes")->fetch();
$bloq = $mistake->query("SELECT COUNT(*) FROM w_ubloq WHERE uid='$meuid'")->fetch();
$tipo = $mistake->query("SELECT visitante FROM w_usuarios WHERE id='$meuid'")->fetch();
?>
<div id="titulo"<b>Configurações</b></div>
<div id="div1"><a href="/configuracoes/ocultatenor"><?php echo $imgseta;?> Ocultar tenor</a></div>
<div id="div1"><a href="/configuracoes/loginsenha"><?php echo $imgseta;?> Alterar login e senha</a></div>
<div id="div1"><a href="/configuracoes/dicas"><?php echo $imgseta;?> Dicas de formatação</a></div>
<div id="div1"><a href="/configuracoes/mudarnick"><?php echo $imgseta;?> Mudar nick</a></div>
<div id="div1"><a href="/configuracoes/mudarcores"><?php echo $imgseta;?> Mudar cores do nick</a></div></div>
<div id="div1"><a href="/configuracoes/mensagem"><?php echo $imgseta;?> Mensagens Privadas</a></div>
<div id="div1"><a href="/configuracoes/bloqueados"><?php echo $imgseta;?> Usuários Bloqueados</a></div>
<div id="div1"><a href="/configuracoes/mudartema"><?php echo $imgseta;?> Alterar tema</a></div>
<div id="div1"><a href="/configuracoes/opcoes"><?php echo $imgseta;?> Bloquear convites</a></div>
<?
if($tipo[0]==0){
?>
<div id="div1"><a href="/configuracoes/pontoson"><?php echo $imgseta;?> Trocar pontos online por dinheiro</a></div>
<div id="div2"><a href="/configuracoes/foto_perfil/<?php echo $meuid;?>"><?php echo $imgseta;?> Alterar foto do perfil</a></div>
<div id="div1"><a href="/configuracoes/editarperfil/<?php echo $meuid;?>"><?php echo $imgseta;?> Editar perfil</a></div>
<div id="div2"><a href="/relacionamento"><?php echo $imgseta;?> Relacionamento</a></div>
<div id="div1"><a href="/entretenimento/apptime"><?php echo $imgseta;?> Meu time do coração</a></div>
<div id="div2"><a href="/banco"><?php echo $imgseta;?> Banco</a></div>
<div id="div1"><a href="/configuracoes/musica"><?php echo $imgseta;?> Musica no perfil e downlonds</a></div>
<div id="div2"><a href="/configuracoes/moedas"><?php echo $imgseta;?> Ganhe moedas</a></div>
<div id="div1"><a href="/configuracoes/cordonick"><?php echo $imgseta;?> Alterar cor do nick personalizada</a></div>
<div id="div2"><a href="/avatares/inicio"><?php echo $imgseta;?> Avatares</a></div>
<div id="div1"><a href="/lojas?"><?php echo $imgseta;?> Lojas de presentes</a></div>
<div id="div2"><a href="/aluguel?"><?php echo $imgseta;?>  Alugar Status</a></div>
<div id="div2"><a href="/gato?"><?php echo $imgseta;?>  Entrevista da senama</a></div>
<div id="div1"><a href="/mimos?"><?php echo $imgseta;?> Mimos</a></div>
<div id="div2"><a href="/chat/jogos?"><?php echo $imgseta;?> Add Jogos No Chat</a></div>
<div id="div1"><a href="/porno/index?"><?php echo $imgseta;?> Sessão Adulta</a></div>


<?
}?>
</ul></div>
<?php }
else if($a=='pontoson')
{
ativo($meuid,"Vendo pontos online para saque","");
echo "<p align=\"center\">";
echo "<div id='titulo'><b>Trocar pontos online por dinheiro</b></div><br />";
$nando =  $mistake;
?>
<div align="center">
Informe o valor que deseja sacar, para que seja encaminhado ao proprietário do site para ser realizado um pix para sua conta.<br/><br/>
<?
if(isset($_POST['valor']) && $_POST['valor']>0)
{
$ver = $nando->query("SELECT email,pontoon,id FROM w_usuarios WHERE id='".$meuid."'")->fetch();
$val = $_POST['valor']*100;
$nando->exec("UPDATE w_usuarios SET pontoon=pontoon-".$val." WHERE id='".$meuid."'");
$msg = "Olá, o membro ".html_entity_decode(gerarnome2($meuid))." que possui o ID: <b>".$ver[3]."</b>, solicitou um saque para a conta bancária usando a chave PIX: <b>".$_POST['pix']." </b> , para fazer o pagamento vá até seu painel de pagamentos no site.!";
$res = $nando->prepare("INSERT INTO w_pix (uid,pix,valor,data) VALUES (?,?,?,?)");
$arrayName = array($meuid,$_POST['pix'],$_POST['valor'],time());
$ii = 0;
for($i=1; $i <=4; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
automsg($msg,1,1);
 ?>
<? echo $imgok;?>Sua solicitação para saque foi recebida com sucesso em nosso sistema, assim que for concluído,você receberá um torpedo automático com o comprovante do pix em sua conta bancária!<br/><br/>
<?php
}
$ver = $nando->query("SELECT email,pontoon,id FROM w_usuarios WHERE id='".$meuid."'")->fetch();
$pix = $nando->query("SELECT COUNT(*) FROM w_pix WHERE uid='$meuid' AND data>'".(time()-86400)."'")->fetch();
$count = $nando->query("SELECT COUNT(*) FROM w_usuarios WHERE pontoon>'0'")->fetch();
$vale = $ver[1]/100;
?>Cada 100 pontos online você pode trocar por 1 real e poderá realizar até 5 transações por dia.<br/><br/>Você possui <b><?php echo $ver[1];?></b> pontos online e pode trocar por <b><?php echo floor($vale); ?></b> <?php echo floor($vale)>1 ? 'reais' : 'real';?><br/><br/><?
if($pix[0]<6){
if(floor($vale)>0){?>
<form action="/configuracoes/pontoson" method="post">
Valor(em reais): <input name="valor" type="number" size="50" min="1" max="<?php echo floor($vale);?>" maxlength="50"  required/> reais<br/>
Sua chave pix: <input name="pix" min="100" maxlength="50"  required/><br/>
<input type="submit" value="Sacar dinheiro"/>
</form><?
}else{
?><? echo $imgerro;?>Você não possui pontos suficientes para trocar, continue online e fature pontos.<br/><?
}
}else{
?><? echo $imgerro;?>Você só pode realizar 5 transações a cada 24 horas.<br/><?
}
?>
<br/><div align="center"><a href="/estatisticas/top2/pontoonl"><?php echo $imgseta;?> Membros participantes(<?php echo $count[0];?>)</a></div><?
}
else 
if($a=='bloqueados') { ativo($meuid,'Lista de Bloqueados '); ?>
<section class="container-fluid"><h2 class="title"> <b>Usuários Bloqueados</b></h2><div class="col-12">
<?php
if($id==true){
$mistake->exec("DELETE FROM w_ubloq WHERE uid='$meuid' and aid='$id'");
}
$contbloq = $mistake->query("SELECT COUNT(*) FROM w_ubloq where uid='$meuid'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contbloq[0];
$itensporpag = 8;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->query("SELECT id, aid FROM w_ubloq where uid='$meuid' ORDER BY id desc LIMIT $limit, $itensporpag");
?>
<div class="col-12"><ul class="list-group shadow" style="margin-bottom: 20px"><?
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) {
$info = $mistake->prepare("SELECT * FROM w_usuarios where id='$item->aid'");
$info->execute();
$info = $info->fetch();
$foto = $info['ft'];
?>
<li class="list-group-item"><?if($info['ft']==true){?><img class="img-circle" style="width: 42px; height: 42px" src="/<?php echo $foto;?>" oncontextmenu="return false" onselectstart="return false" ondragstart="return false" style="width:86px;height:100px;border-radius:50%; margin:1px; border:2px solid #FFF;" pbsrc="/<?php echo str_replace('m_','',$foto);?>" class="PopBoxImageSmall" title='<?php echo $info['nm'];?>' onclick="Pop(this,50,'PopBoxPopImage');" /><?}else{?><i class="fas fa-user-circle" style="color: #c0c0c0; font-size: 42px; margin-right: 12px; float: left"></i><?}?><?php echo gerarnome($item->aid);?> <a href="/configuracoes/bloqueados&id=<?php echo $item->aid;?>" class="btn btn-dark btn-sm float-right">Desbloquear</a></li>
<?php $i++; }
if($numpag>1) { 
paginas('configuracoes',$a,$numpag,$id,$pag);    
}?></ul><? } else { ?>
<div class="col-12"><div class="card shadow"><div class="card-body"> Nenhum usuário bloqueado.</div></div></div>
<?php }
?>
<?
}
else if($a=='mensagem'){
?>
<section class="container-fluid"><h2 class="title"> <b>Mensagens Privadas</b></h2><div class="col-12"><?
if($_GET['pag']==true) {
?><div align="center"><?
$res = $mistake->exec("UPDATE w_usuarios SET mp='".$id."' WHERE id='$meuid'");
if($res) {  } else { } }

$bloq = $mistake->query("SELECT mp FROM w_usuarios WHERE id='$meuid'")->fetch();
?>
<div class="card shadow"><div class="card-body"><span> Receber mensagens privadas</span><br/><?if($bloq[0]==0){?><a href="/configuracoes/mensagem/1/muda" class="badge badge-primary float-right" style="color: #ffffff">Sim</a></div></div></div><div class="col-12 text-center" style="margin-top: 20px"><?}else{?><a href="/configuracoes/mensagem/0/muda" class="badge badge-danger btn-sm float-right" style="color: #ffffff">Não</a></div></div><?}?></div> </section>
<?
}
else if($a=='mudartema'){
?>
<section class="container-fluid"><h2 class="title"> <b>Mudar cor do chat</b></h2><div class="col-12"><?
if($_SERVER['REQUEST_METHOD'] == 'POST') {
?><div align="center"><?
$res = $mistake->exec("UPDATE w_usuarios SET tema='".$_POST['tema']."' WHERE id='$meuid'");
if($res) { echo $imgok;?>
A cor foi atualizada com sucesso!<br/>
<?php } else { echo $imgerro;?>
Erro!<br/>
<?php } }
?></div>
<form action="/configuracoes/mudartema" method="post"><div class="form-group"><select class="form-control" name="tema"><option value="padrao">Padrão</option><option value="azul">Azul</option><option value="vermelho">Vermelho</option><option value="verde">Verde</option><option value="laranja">Laranja</option><option value="rosa">Rosa</option><option value="marrom">Marrom</option><option value="roxo">Roxo</option><option value="dourado">Dourado</option><option value="cinza">Cinza</option><option value="preto">Preto</option></select></div><input type="hidden" name="action" value="changeTheme"><button type="submit" class="btn btn-primary btn-sm active btn-block" role="button" aria-pressed="true">Salvar</button></form></div><div class="col-12 text-center" style="margin-top: 20px"></div> </section><?
}
else if($a=='mudarcormensagem'){
?>
<section class="container-fluid"><h2 class="title"> <b>Mudar cor da mensagem</b></h2><div class="col-12"><?
if($_SERVER['REQUEST_METHOD'] == 'POST') {
?><div align="center"><?
$res = $mistake->exec("UPDATE w_usuarios SET cormensagem='".$_POST['cor']."' WHERE id='$meuid'");
if($res) { echo $imgok;?>
A cor foi atualizada com sucesso!<br/>
<?php } else { echo $imgerro;?>
Erro!<br/>
<?php } }
?></div>
<form action="/configuracoes/mudarcormensagem" method="post"><div class="form-group"><select class="form-control" name="cor"><option value="padrao">Padrão</option><option value="azul">Azul</option><option value="vermelho">Vermelho</option><option value="verde">Verde</option><option value="laranja">Laranja</option><option value="rosa">Rosa</option><option value="marrom">Marrom</option><option value="roxo">Roxo</option><option value="dourado">Dourado</option><option value="cinza">Cinza</option><option value="preto">Preto</option></select></div><input type="hidden" name="action" value="changeTheme"><button type="submit" class="btn btn-primary btn-sm active btn-block" role="button" aria-pressed="true">Salvar</button></form></div><div class="col-12 text-center" style="margin-top: 20px"><a href="javascript:window.history.back();"><?php echo $imgsetavoltar;?> Voltar</a></div> </section><?
}
else if($a=='opcoes'){
?>
<section class="container-fluid"><h2 class="title"> <b>Bloquear</b></h2><div class="col-12"><?
if($_SERVER['REQUEST_METHOD'] == 'POST') {
?><div align="center"><?
$res = $mistake->exec("UPDATE w_usuarios SET receberconvite='".$_POST['rc']."' WHERE id='$meuid'");
if($res) { echo $imgok;?>
Atualizado com sucesso!<br/>
<?php } else { echo $imgerro;?>
Erro!<br/>
<?php } }
?></div>
Convites para sala privada
<form action="/configuracoes/opcoes" method="post"><div class="form-group"><select class="form-control" name="rc"><option value="1">Não</option><option value="0">Sim</option></select></div><input type="hidden" name="action" value="changeTheme"><button type="submit" class="btn btn-primary btn-sm active btn-block" role="button" aria-pressed="true">Salvar</button></form></div><div class="col-12 text-center" style="margin-top: 20px"></div> </section><?
}
else if($a=='mudarcores'){
?>
<section class="container-fluid"><h2 class="title"><b>Mudar cores</b></h2><div class="col-12 text-center"><?php echo gerarnome($meuid);?></div><div class="col-12"><?
if($_SERVER['REQUEST_METHOD'] == 'POST') {
?><div align="center"><?
if($_POST['cor1']==false && $_POST['cor2']==false){ 
echo $imgerro;?>
Escolha duas cores!
<br/>
<?php  
}else{    
$res = $mistake->exec("UPDATE w_usuarios SET corn='".$_POST['cor1']."', corn2='".$_POST['cor2']."'WHERE id='$meuid'");
if($res) { echo $imgok;?>
Cores alteradas com sucesso!<br/>
<?php } else { echo $imgerro;?>
Erro ao atualizar login e senha!<br/>
<?php } }}
?></div>

<form action="/configuracoes/mudarcores" method="post"><div class="form-group"><label for="cor1">Cor 1</label><input id="cor1" type="hidden" name="cor1" value="default"><div id="color1" style="width: 100%; height: 20px; margin-bottom: 6px; background: #555555"></div><div id="colors1" style="width: 100%; overflow-y: scroll; display: none"><div class="color" value="#000000" style="width: 12.5%; height: 24px; background: #000000; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ffffff" style="width: 12.5%; height: 24px; background: #ffffff; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#111111" style="width: 12.5%; height: 24px; background: #111111; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#263238" style="width: 12.5%; height: 24px; background: #263238; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#37474f" style="width: 12.5%; height: 24px; background: #37474f; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#455a64" style="width: 12.5%; height: 24px; background: #455a64; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#546e7a" style="width: 12.5%; height: 24px; background: #546e7a; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#607d8b" style="width: 12.5%; height: 24px; background: #607d8b; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#78909c" style="width: 12.5%; height: 24px; background: #78909c; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#90a4ae" style="width: 12.5%; height: 24px; background: #90a4ae; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#b0bec5" style="width: 12.5%; height: 24px; background: #b0bec5; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#cfd8dc" style="width: 12.5%; height: 24px; background: #cfd8dc; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#eceff1" style="width: 12.5%; height: 24px; background: #eceff1; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#212121" style="width: 12.5%; height: 24px; background: #212121; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#424242" style="width: 12.5%; height: 24px; background: #424242; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#616161" style="width: 12.5%; height: 24px; background: #616161; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#757575" style="width: 12.5%; height: 24px; background: #757575; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#9e9e9e" style="width: 12.5%; height: 24px; background: #9e9e9e; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#bdbdbd" style="width: 12.5%; height: 24px; background: #bdbdbd; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#e0e0e0" style="width: 12.5%; height: 24px; background: #e0e0e0; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#eeeeee" style="width: 12.5%; height: 24px; background: #eeeeee; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#f5f5f5" style="width: 12.5%; height: 24px; background: #f5f5f5; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#fafafa" style="width: 12.5%; height: 24px; background: #fafafa; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#3e2723" style="width: 12.5%; height: 24px; background: #3e2723; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#4e342e" style="width: 12.5%; height: 24px; background: #4e342e; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#5d4037" style="width: 12.5%; height: 24px; background: #5d4037; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#6d4c41" style="width: 12.5%; height: 24px; background: #6d4c41; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#795548" style="width: 12.5%; height: 24px; background: #795548; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#8d6e63" style="width: 12.5%; height: 24px; background: #8d6e63; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#a1887f" style="width: 12.5%; height: 24px; background: #a1887f; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#bcaaa4" style="width: 12.5%; height: 24px; background: #bcaaa4; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#d7ccc8" style="width: 12.5%; height: 24px; background: #d7ccc8; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#efebe9" style="width: 12.5%; height: 24px; background: #efebe9; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#dd2c00" style="width: 12.5%; height: 24px; background: #dd2c00; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ff3d00" style="width: 12.5%; height: 24px; background: #ff3d00; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ff6e40" style="width: 12.5%; height: 24px; background: #ff6e40; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ff9e80" style="width: 12.5%; height: 24px; background: #ff9e80; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#bf360c" style="width: 12.5%; height: 24px; background: #bf360c; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#d84315" style="width: 12.5%; height: 24px; background: #d84315; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#e64a19" style="width: 12.5%; height: 24px; background: #e64a19; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#f4511e" style="width: 12.5%; height: 24px; background: #f4511e; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ff5722" style="width: 12.5%; height: 24px; background: #ff5722; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ff7043" style="width: 12.5%; height: 24px; background: #ff7043; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ff8a65" style="width: 12.5%; height: 24px; background: #ff8a65; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ffab91" style="width: 12.5%; height: 24px; background: #ffab91; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ffccbc" style="width: 12.5%; height: 24px; background: #ffccbc; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#fbe9e7" style="width: 12.5%; height: 24px; background: #fbe9e7; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ff6d00" style="width: 12.5%; height: 24px; background: #ff6d00; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ff9100" style="width: 12.5%; height: 24px; background: #ff9100; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ffab40" style="width: 12.5%; height: 24px; background: #ffab40; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ffd180" style="width: 12.5%; height: 24px; background: #ffd180; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#e65100" style="width: 12.5%; height: 24px; background: #e65100; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ef6c00" style="width: 12.5%; height: 24px; background: #ef6c00; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#f57c00" style="width: 12.5%; height: 24px; background: #f57c00; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#fb8c00" style="width: 12.5%; height: 24px; background: #fb8c00; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ff9800" style="width: 12.5%; height: 24px; background: #ff9800; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ffa726" style="width: 12.5%; height: 24px; background: #ffa726; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ffb74d" style="width: 12.5%; height: 24px; background: #ffb74d; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ffcc80" style="width: 12.5%; height: 24px; background: #ffcc80; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ffe0b2" style="width: 12.5%; height: 24px; background: #ffe0b2; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#fff3e0" style="width: 12.5%; height: 24px; background: #fff3e0; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ffab00" style="width: 12.5%; height: 24px; background: #ffab00; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ffc400" style="width: 12.5%; height: 24px; background: #ffc400; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ffd740" style="width: 12.5%; height: 24px; background: #ffd740; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ffe57f" style="width: 12.5%; height: 24px; background: #ffe57f; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ff6f00" style="width: 12.5%; height: 24px; background: #ff6f00; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ff8f00" style="width: 12.5%; height: 24px; background: #ff8f00; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ffa000" style="width: 12.5%; height: 24px; background: #ffa000; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ffb300" style="width: 12.5%; height: 24px; background: #ffb300; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ffc107" style="width: 12.5%; height: 24px; background: #ffc107; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ffca28" style="width: 12.5%; height: 24px; background: #ffca28; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ffd54f" style="width: 12.5%; height: 24px; background: #ffd54f; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ffe082" style="width: 12.5%; height: 24px; background: #ffe082; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ffecb3" style="width: 12.5%; height: 24px; background: #ffecb3; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#fff8e1" style="width: 12.5%; height: 24px; background: #fff8e1; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ffd600" style="width: 12.5%; height: 24px; background: #ffd600; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ffea00" style="width: 12.5%; height: 24px; background: #ffea00; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ffff00" style="width: 12.5%; height: 24px; background: #ffff00; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ffff8d" style="width: 12.5%; height: 24px; background: #ffff8d; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#f57f17" style="width: 12.5%; height: 24px; background: #f57f17; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#f9a825" style="width: 12.5%; height: 24px; background: #f9a825; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#fbc02d" style="width: 12.5%; height: 24px; background: #fbc02d; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#fdd835" style="width: 12.5%; height: 24px; background: #fdd835; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ffeb3b" style="width: 12.5%; height: 24px; background: #ffeb3b; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ffee58" style="width: 12.5%; height: 24px; background: #ffee58; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#fff176" style="width: 12.5%; height: 24px; background: #fff176; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#fff59d" style="width: 12.5%; height: 24px; background: #fff59d; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#fff9c4" style="width: 12.5%; height: 24px; background: #fff9c4; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#fffde7" style="width: 12.5%; height: 24px; background: #fffde7; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#aeea00" style="width: 12.5%; height: 24px; background: #aeea00; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#c6ff00" style="width: 12.5%; height: 24px; background: #c6ff00; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#eeff41" style="width: 12.5%; height: 24px; background: #eeff41; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#f4ff81" style="width: 12.5%; height: 24px; background: #f4ff81; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#827717" style="width: 12.5%; height: 24px; background: #827717; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#9e9d24" style="width: 12.5%; height: 24px; background: #9e9d24; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#afb42b" style="width: 12.5%; height: 24px; background: #afb42b; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#c0ca33" style="width: 12.5%; height: 24px; background: #c0ca33; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#cddc39" style="width: 12.5%; height: 24px; background: #cddc39; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#d4e157" style="width: 12.5%; height: 24px; background: #d4e157; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#dce775" style="width: 12.5%; height: 24px; background: #dce775; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#e6ee9c" style="width: 12.5%; height: 24px; background: #e6ee9c; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#f0f4c3" style="width: 12.5%; height: 24px; background: #f0f4c3; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#f9fbe7" style="width: 12.5%; height: 24px; background: #f9fbe7; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#64dd17" style="width: 12.5%; height: 24px; background: #64dd17; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#76ff03" style="width: 12.5%; height: 24px; background: #76ff03; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#b2ff59" style="width: 12.5%; height: 24px; background: #b2ff59; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ccff90" style="width: 12.5%; height: 24px; background: #ccff90; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#33691e" style="width: 12.5%; height: 24px; background: #33691e; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#558b2f" style="width: 12.5%; height: 24px; background: #558b2f; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#689f38" style="width: 12.5%; height: 24px; background: #689f38; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#7cb342" style="width: 12.5%; height: 24px; background: #7cb342; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#8bc34a" style="width: 12.5%; height: 24px; background: #8bc34a; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#9ccc65" style="width: 12.5%; height: 24px; background: #9ccc65; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#aed581" style="width: 12.5%; height: 24px; background: #aed581; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#c5e1a5" style="width: 12.5%; height: 24px; background: #c5e1a5; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#dcedc8" style="width: 12.5%; height: 24px; background: #dcedc8; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#f1f8e9" style="width: 12.5%; height: 24px; background: #f1f8e9; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#00c853" style="width: 12.5%; height: 24px; background: #00c853; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#00e676" style="width: 12.5%; height: 24px; background: #00e676; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#69f0ae" style="width: 12.5%; height: 24px; background: #69f0ae; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#b9f6ca" style="width: 12.5%; height: 24px; background: #b9f6ca; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#1b5e20" style="width: 12.5%; height: 24px; background: #1b5e20; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#2e7d32" style="width: 12.5%; height: 24px; background: #2e7d32; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#388e3c" style="width: 12.5%; height: 24px; background: #388e3c; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#43a047" style="width: 12.5%; height: 24px; background: #43a047; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#4caf50" style="width: 12.5%; height: 24px; background: #4caf50; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#66bb6a" style="width: 12.5%; height: 24px; background: #66bb6a; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#81c784" style="width: 12.5%; height: 24px; background: #81c784; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#a5d6a7" style="width: 12.5%; height: 24px; background: #a5d6a7; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#c8e6c9" style="width: 12.5%; height: 24px; background: #c8e6c9; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#e8f5e9" style="width: 12.5%; height: 24px; background: #e8f5e9; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#00bfa5" style="width: 12.5%; height: 24px; background: #00bfa5; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#1de9b6" style="width: 12.5%; height: 24px; background: #1de9b6; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#64ffda" style="width: 12.5%; height: 24px; background: #64ffda; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#a7ffeb" style="width: 12.5%; height: 24px; background: #a7ffeb; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#004d40" style="width: 12.5%; height: 24px; background: #004d40; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#00695c" style="width: 12.5%; height: 24px; background: #00695c; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#00796b" style="width: 12.5%; height: 24px; background: #00796b; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#00897b" style="width: 12.5%; height: 24px; background: #00897b; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#009688" style="width: 12.5%; height: 24px; background: #009688; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#26a69a" style="width: 12.5%; height: 24px; background: #26a69a; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#4db6ac" style="width: 12.5%; height: 24px; background: #4db6ac; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#80cbc4" style="width: 12.5%; height: 24px; background: #80cbc4; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#b2dfdb" style="width: 12.5%; height: 24px; background: #b2dfdb; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#e0f2f1" style="width: 12.5%; height: 24px; background: #e0f2f1; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#00b8d4" style="width: 12.5%; height: 24px; background: #00b8d4; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#00e5ff" style="width: 12.5%; height: 24px; background: #00e5ff; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#18ffff" style="width: 12.5%; height: 24px; background: #18ffff; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#84ffff" style="width: 12.5%; height: 24px; background: #84ffff; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#006064" style="width: 12.5%; height: 24px; background: #006064; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#00838f" style="width: 12.5%; height: 24px; background: #00838f; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#0097a7" style="width: 12.5%; height: 24px; background: #0097a7; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#00acc1" style="width: 12.5%; height: 24px; background: #00acc1; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#00bcd4" style="width: 12.5%; height: 24px; background: #00bcd4; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#26c6da" style="width: 12.5%; height: 24px; background: #26c6da; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#4dd0e1" style="width: 12.5%; height: 24px; background: #4dd0e1; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#80deea" style="width: 12.5%; height: 24px; background: #80deea; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#b2ebf2" style="width: 12.5%; height: 24px; background: #b2ebf2; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#e0f7fa" style="width: 12.5%; height: 24px; background: #e0f7fa; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#0091ea" style="width: 12.5%; height: 24px; background: #0091ea; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#00b0ff" style="width: 12.5%; height: 24px; background: #00b0ff; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#40c4ff" style="width: 12.5%; height: 24px; background: #40c4ff; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#80d8ff" style="width: 12.5%; height: 24px; background: #80d8ff; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#01579b" style="width: 12.5%; height: 24px; background: #01579b; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#0277bd" style="width: 12.5%; height: 24px; background: #0277bd; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#0288d1" style="width: 12.5%; height: 24px; background: #0288d1; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#039be5" style="width: 12.5%; height: 24px; background: #039be5; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#03a9f4" style="width: 12.5%; height: 24px; background: #03a9f4; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#29b6f6" style="width: 12.5%; height: 24px; background: #29b6f6; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#4fc3f7" style="width: 12.5%; height: 24px; background: #4fc3f7; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#81d4fa" style="width: 12.5%; height: 24px; background: #81d4fa; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#b3e5fc" style="width: 12.5%; height: 24px; background: #b3e5fc; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#e1f5fe" style="width: 12.5%; height: 24px; background: #e1f5fe; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#2962ff" style="width: 12.5%; height: 24px; background: #2962ff; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#2979ff" style="width: 12.5%; height: 24px; background: #2979ff; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#448aff" style="width: 12.5%; height: 24px; background: #448aff; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#82b1ff" style="width: 12.5%; height: 24px; background: #82b1ff; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#0d47a1" style="width: 12.5%; height: 24px; background: #0d47a1; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#1565c0" style="width: 12.5%; height: 24px; background: #1565c0; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#1976d2" style="width: 12.5%; height: 24px; background: #1976d2; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#1e88e5" style="width: 12.5%; height: 24px; background: #1e88e5; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#2196f3" style="width: 12.5%; height: 24px; background: #2196f3; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#42a5f5" style="width: 12.5%; height: 24px; background: #42a5f5; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#64b5f6" style="width: 12.5%; height: 24px; background: #64b5f6; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#90caf9" style="width: 12.5%; height: 24px; background: #90caf9; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#bbdefb" style="width: 12.5%; height: 24px; background: #bbdefb; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#e3f2fd" style="width: 12.5%; height: 24px; background: #e3f2fd; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#304ffe" style="width: 12.5%; height: 24px; background: #304ffe; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#3d5afe" style="width: 12.5%; height: 24px; background: #3d5afe; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#536dfe" style="width: 12.5%; height: 24px; background: #536dfe; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#8c9eff" style="width: 12.5%; height: 24px; background: #8c9eff; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#1a237e" style="width: 12.5%; height: 24px; background: #1a237e; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#283593" style="width: 12.5%; height: 24px; background: #283593; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#303f9f" style="width: 12.5%; height: 24px; background: #303f9f; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#3949ab" style="width: 12.5%; height: 24px; background: #3949ab; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#3f51b5" style="width: 12.5%; height: 24px; background: #3f51b5; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#5c6bc0" style="width: 12.5%; height: 24px; background: #5c6bc0; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#7986cb" style="width: 12.5%; height: 24px; background: #7986cb; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#9fa8da" style="width: 12.5%; height: 24px; background: #9fa8da; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#c5cae9" style="width: 12.5%; height: 24px; background: #c5cae9; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#e8eaf6" style="width: 12.5%; height: 24px; background: #e8eaf6; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#6200ea" style="width: 12.5%; height: 24px; background: #6200ea; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#651fff" style="width: 12.5%; height: 24px; background: #651fff; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#7c4dff" style="width: 12.5%; height: 24px; background: #7c4dff; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#b388ff" style="width: 12.5%; height: 24px; background: #b388ff; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#311b92" style="width: 12.5%; height: 24px; background: #311b92; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#4527a0" style="width: 12.5%; height: 24px; background: #4527a0; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#512da8" style="width: 12.5%; height: 24px; background: #512da8; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#5e35b1" style="width: 12.5%; height: 24px; background: #5e35b1; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#673ab7" style="width: 12.5%; height: 24px; background: #673ab7; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#7e57c2" style="width: 12.5%; height: 24px; background: #7e57c2; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#9575cd" style="width: 12.5%; height: 24px; background: #9575cd; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#b39ddb" style="width: 12.5%; height: 24px; background: #b39ddb; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#d1c4e9" style="width: 12.5%; height: 24px; background: #d1c4e9; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ede7f6" style="width: 12.5%; height: 24px; background: #ede7f6; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#aa00ff" style="width: 12.5%; height: 24px; background: #aa00ff; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#d500f9" style="width: 12.5%; height: 24px; background: #d500f9; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#e040fb" style="width: 12.5%; height: 24px; background: #e040fb; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ea80fc" style="width: 12.5%; height: 24px; background: #ea80fc; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#4a148c" style="width: 12.5%; height: 24px; background: #4a148c; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#6a1b9a" style="width: 12.5%; height: 24px; background: #6a1b9a; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#7b1fa2" style="width: 12.5%; height: 24px; background: #7b1fa2; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#8e24aa" style="width: 12.5%; height: 24px; background: #8e24aa; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#9c27b0" style="width: 12.5%; height: 24px; background: #9c27b0; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ab47bc" style="width: 12.5%; height: 24px; background: #ab47bc; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ba68c8" style="width: 12.5%; height: 24px; background: #ba68c8; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ce93d8" style="width: 12.5%; height: 24px; background: #ce93d8; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#e1bee7" style="width: 12.5%; height: 24px; background: #e1bee7; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#f3e5f5" style="width: 12.5%; height: 24px; background: #f3e5f5; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#c51162" style="width: 12.5%; height: 24px; background: #c51162; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#f50057" style="width: 12.5%; height: 24px; background: #f50057; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ff4081" style="width: 12.5%; height: 24px; background: #ff4081; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ff80ab" style="width: 12.5%; height: 24px; background: #ff80ab; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#880e4f" style="width: 12.5%; height: 24px; background: #880e4f; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ad1457" style="width: 12.5%; height: 24px; background: #ad1457; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#c2185b" style="width: 12.5%; height: 24px; background: #c2185b; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#d81b60" style="width: 12.5%; height: 24px; background: #d81b60; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#e91e63" style="width: 12.5%; height: 24px; background: #e91e63; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ec407a" style="width: 12.5%; height: 24px; background: #ec407a; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#f06292" style="width: 12.5%; height: 24px; background: #f06292; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#f48fb1" style="width: 12.5%; height: 24px; background: #f48fb1; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#f8bbd0" style="width: 12.5%; height: 24px; background: #f8bbd0; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#fce4ec" style="width: 12.5%; height: 24px; background: #fce4ec; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#d50000" style="width: 12.5%; height: 24px; background: #d50000; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ff1744" style="width: 12.5%; height: 24px; background: #ff1744; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ff5252" style="width: 12.5%; height: 24px; background: #ff5252; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ff8a80" style="width: 12.5%; height: 24px; background: #ff8a80; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#b71c1c" style="width: 12.5%; height: 24px; background: #b71c1c; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#c62828" style="width: 12.5%; height: 24px; background: #c62828; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#d32f2f" style="width: 12.5%; height: 24px; background: #d32f2f; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#e53935" style="width: 12.5%; height: 24px; background: #e53935; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#f44336" style="width: 12.5%; height: 24px; background: #f44336; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ef5350" style="width: 12.5%; height: 24px; background: #ef5350; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#e57373" style="width: 12.5%; height: 24px; background: #e57373; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ef9a9a" style="width: 12.5%; height: 24px; background: #ef9a9a; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ffcdd2" style="width: 12.5%; height: 24px; background: #ffcdd2; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ffebee" style="width: 12.5%; height: 24px; background: #ffebee; display: inline-block; border: 1px solid white; box-sizing: border-box"></div> </div></div><div class="form-group"><label for="cor2">Cor 2</label><input id="cor2" type="hidden" name="cor2" value="default"><div id="color2" style="width: 100%; height: 20px; margin-bottom: 6px; background: #555555"></div><div id="colors2" style="width: 100%; overflow-y: scroll; display: none"><div class="color" value="#000000" style="width: 12.5%; height: 24px; background: #000000; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ffffff" style="width: 12.5%; height: 24px; background: #ffffff; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#111111" style="width: 12.5%; height: 24px; background: #111111; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#263238" style="width: 12.5%; height: 24px; background: #263238; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#37474f" style="width: 12.5%; height: 24px; background: #37474f; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#455a64" style="width: 12.5%; height: 24px; background: #455a64; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#546e7a" style="width: 12.5%; height: 24px; background: #546e7a; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#607d8b" style="width: 12.5%; height: 24px; background: #607d8b; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#78909c" style="width: 12.5%; height: 24px; background: #78909c; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#90a4ae" style="width: 12.5%; height: 24px; background: #90a4ae; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#b0bec5" style="width: 12.5%; height: 24px; background: #b0bec5; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#cfd8dc" style="width: 12.5%; height: 24px; background: #cfd8dc; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#eceff1" style="width: 12.5%; height: 24px; background: #eceff1; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#212121" style="width: 12.5%; height: 24px; background: #212121; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#424242" style="width: 12.5%; height: 24px; background: #424242; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#616161" style="width: 12.5%; height: 24px; background: #616161; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#757575" style="width: 12.5%; height: 24px; background: #757575; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#9e9e9e" style="width: 12.5%; height: 24px; background: #9e9e9e; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#bdbdbd" style="width: 12.5%; height: 24px; background: #bdbdbd; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#e0e0e0" style="width: 12.5%; height: 24px; background: #e0e0e0; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#eeeeee" style="width: 12.5%; height: 24px; background: #eeeeee; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#f5f5f5" style="width: 12.5%; height: 24px; background: #f5f5f5; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#fafafa" style="width: 12.5%; height: 24px; background: #fafafa; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#3e2723" style="width: 12.5%; height: 24px; background: #3e2723; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#4e342e" style="width: 12.5%; height: 24px; background: #4e342e; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#5d4037" style="width: 12.5%; height: 24px; background: #5d4037; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#6d4c41" style="width: 12.5%; height: 24px; background: #6d4c41; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#795548" style="width: 12.5%; height: 24px; background: #795548; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#8d6e63" style="width: 12.5%; height: 24px; background: #8d6e63; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#a1887f" style="width: 12.5%; height: 24px; background: #a1887f; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#bcaaa4" style="width: 12.5%; height: 24px; background: #bcaaa4; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#d7ccc8" style="width: 12.5%; height: 24px; background: #d7ccc8; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#efebe9" style="width: 12.5%; height: 24px; background: #efebe9; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#dd2c00" style="width: 12.5%; height: 24px; background: #dd2c00; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ff3d00" style="width: 12.5%; height: 24px; background: #ff3d00; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ff6e40" style="width: 12.5%; height: 24px; background: #ff6e40; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ff9e80" style="width: 12.5%; height: 24px; background: #ff9e80; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#bf360c" style="width: 12.5%; height: 24px; background: #bf360c; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#d84315" style="width: 12.5%; height: 24px; background: #d84315; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#e64a19" style="width: 12.5%; height: 24px; background: #e64a19; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#f4511e" style="width: 12.5%; height: 24px; background: #f4511e; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ff5722" style="width: 12.5%; height: 24px; background: #ff5722; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ff7043" style="width: 12.5%; height: 24px; background: #ff7043; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ff8a65" style="width: 12.5%; height: 24px; background: #ff8a65; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ffab91" style="width: 12.5%; height: 24px; background: #ffab91; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ffccbc" style="width: 12.5%; height: 24px; background: #ffccbc; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#fbe9e7" style="width: 12.5%; height: 24px; background: #fbe9e7; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ff6d00" style="width: 12.5%; height: 24px; background: #ff6d00; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ff9100" style="width: 12.5%; height: 24px; background: #ff9100; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ffab40" style="width: 12.5%; height: 24px; background: #ffab40; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ffd180" style="width: 12.5%; height: 24px; background: #ffd180; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#e65100" style="width: 12.5%; height: 24px; background: #e65100; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ef6c00" style="width: 12.5%; height: 24px; background: #ef6c00; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#f57c00" style="width: 12.5%; height: 24px; background: #f57c00; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#fb8c00" style="width: 12.5%; height: 24px; background: #fb8c00; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ff9800" style="width: 12.5%; height: 24px; background: #ff9800; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ffa726" style="width: 12.5%; height: 24px; background: #ffa726; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ffb74d" style="width: 12.5%; height: 24px; background: #ffb74d; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ffcc80" style="width: 12.5%; height: 24px; background: #ffcc80; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ffe0b2" style="width: 12.5%; height: 24px; background: #ffe0b2; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#fff3e0" style="width: 12.5%; height: 24px; background: #fff3e0; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ffab00" style="width: 12.5%; height: 24px; background: #ffab00; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ffc400" style="width: 12.5%; height: 24px; background: #ffc400; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ffd740" style="width: 12.5%; height: 24px; background: #ffd740; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ffe57f" style="width: 12.5%; height: 24px; background: #ffe57f; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ff6f00" style="width: 12.5%; height: 24px; background: #ff6f00; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ff8f00" style="width: 12.5%; height: 24px; background: #ff8f00; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ffa000" style="width: 12.5%; height: 24px; background: #ffa000; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ffb300" style="width: 12.5%; height: 24px; background: #ffb300; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ffc107" style="width: 12.5%; height: 24px; background: #ffc107; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ffca28" style="width: 12.5%; height: 24px; background: #ffca28; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ffd54f" style="width: 12.5%; height: 24px; background: #ffd54f; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ffe082" style="width: 12.5%; height: 24px; background: #ffe082; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ffecb3" style="width: 12.5%; height: 24px; background: #ffecb3; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#fff8e1" style="width: 12.5%; height: 24px; background: #fff8e1; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ffd600" style="width: 12.5%; height: 24px; background: #ffd600; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ffea00" style="width: 12.5%; height: 24px; background: #ffea00; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ffff00" style="width: 12.5%; height: 24px; background: #ffff00; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ffff8d" style="width: 12.5%; height: 24px; background: #ffff8d; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#f57f17" style="width: 12.5%; height: 24px; background: #f57f17; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#f9a825" style="width: 12.5%; height: 24px; background: #f9a825; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#fbc02d" style="width: 12.5%; height: 24px; background: #fbc02d; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#fdd835" style="width: 12.5%; height: 24px; background: #fdd835; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ffeb3b" style="width: 12.5%; height: 24px; background: #ffeb3b; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ffee58" style="width: 12.5%; height: 24px; background: #ffee58; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#fff176" style="width: 12.5%; height: 24px; background: #fff176; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#fff59d" style="width: 12.5%; height: 24px; background: #fff59d; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#fff9c4" style="width: 12.5%; height: 24px; background: #fff9c4; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#fffde7" style="width: 12.5%; height: 24px; background: #fffde7; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#aeea00" style="width: 12.5%; height: 24px; background: #aeea00; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#c6ff00" style="width: 12.5%; height: 24px; background: #c6ff00; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#eeff41" style="width: 12.5%; height: 24px; background: #eeff41; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#f4ff81" style="width: 12.5%; height: 24px; background: #f4ff81; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#827717" style="width: 12.5%; height: 24px; background: #827717; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#9e9d24" style="width: 12.5%; height: 24px; background: #9e9d24; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#afb42b" style="width: 12.5%; height: 24px; background: #afb42b; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#c0ca33" style="width: 12.5%; height: 24px; background: #c0ca33; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#cddc39" style="width: 12.5%; height: 24px; background: #cddc39; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#d4e157" style="width: 12.5%; height: 24px; background: #d4e157; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#dce775" style="width: 12.5%; height: 24px; background: #dce775; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#e6ee9c" style="width: 12.5%; height: 24px; background: #e6ee9c; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#f0f4c3" style="width: 12.5%; height: 24px; background: #f0f4c3; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#f9fbe7" style="width: 12.5%; height: 24px; background: #f9fbe7; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#64dd17" style="width: 12.5%; height: 24px; background: #64dd17; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#76ff03" style="width: 12.5%; height: 24px; background: #76ff03; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#b2ff59" style="width: 12.5%; height: 24px; background: #b2ff59; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ccff90" style="width: 12.5%; height: 24px; background: #ccff90; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#33691e" style="width: 12.5%; height: 24px; background: #33691e; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#558b2f" style="width: 12.5%; height: 24px; background: #558b2f; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#689f38" style="width: 12.5%; height: 24px; background: #689f38; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#7cb342" style="width: 12.5%; height: 24px; background: #7cb342; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#8bc34a" style="width: 12.5%; height: 24px; background: #8bc34a; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#9ccc65" style="width: 12.5%; height: 24px; background: #9ccc65; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#aed581" style="width: 12.5%; height: 24px; background: #aed581; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#c5e1a5" style="width: 12.5%; height: 24px; background: #c5e1a5; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#dcedc8" style="width: 12.5%; height: 24px; background: #dcedc8; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#f1f8e9" style="width: 12.5%; height: 24px; background: #f1f8e9; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#00c853" style="width: 12.5%; height: 24px; background: #00c853; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#00e676" style="width: 12.5%; height: 24px; background: #00e676; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#69f0ae" style="width: 12.5%; height: 24px; background: #69f0ae; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#b9f6ca" style="width: 12.5%; height: 24px; background: #b9f6ca; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#1b5e20" style="width: 12.5%; height: 24px; background: #1b5e20; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#2e7d32" style="width: 12.5%; height: 24px; background: #2e7d32; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#388e3c" style="width: 12.5%; height: 24px; background: #388e3c; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#43a047" style="width: 12.5%; height: 24px; background: #43a047; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#4caf50" style="width: 12.5%; height: 24px; background: #4caf50; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#66bb6a" style="width: 12.5%; height: 24px; background: #66bb6a; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#81c784" style="width: 12.5%; height: 24px; background: #81c784; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#a5d6a7" style="width: 12.5%; height: 24px; background: #a5d6a7; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#c8e6c9" style="width: 12.5%; height: 24px; background: #c8e6c9; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#e8f5e9" style="width: 12.5%; height: 24px; background: #e8f5e9; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#00bfa5" style="width: 12.5%; height: 24px; background: #00bfa5; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#1de9b6" style="width: 12.5%; height: 24px; background: #1de9b6; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#64ffda" style="width: 12.5%; height: 24px; background: #64ffda; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#a7ffeb" style="width: 12.5%; height: 24px; background: #a7ffeb; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#004d40" style="width: 12.5%; height: 24px; background: #004d40; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#00695c" style="width: 12.5%; height: 24px; background: #00695c; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#00796b" style="width: 12.5%; height: 24px; background: #00796b; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#00897b" style="width: 12.5%; height: 24px; background: #00897b; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#009688" style="width: 12.5%; height: 24px; background: #009688; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#26a69a" style="width: 12.5%; height: 24px; background: #26a69a; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#4db6ac" style="width: 12.5%; height: 24px; background: #4db6ac; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#80cbc4" style="width: 12.5%; height: 24px; background: #80cbc4; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#b2dfdb" style="width: 12.5%; height: 24px; background: #b2dfdb; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#e0f2f1" style="width: 12.5%; height: 24px; background: #e0f2f1; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#00b8d4" style="width: 12.5%; height: 24px; background: #00b8d4; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#00e5ff" style="width: 12.5%; height: 24px; background: #00e5ff; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#18ffff" style="width: 12.5%; height: 24px; background: #18ffff; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#84ffff" style="width: 12.5%; height: 24px; background: #84ffff; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#006064" style="width: 12.5%; height: 24px; background: #006064; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#00838f" style="width: 12.5%; height: 24px; background: #00838f; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#0097a7" style="width: 12.5%; height: 24px; background: #0097a7; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#00acc1" style="width: 12.5%; height: 24px; background: #00acc1; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#00bcd4" style="width: 12.5%; height: 24px; background: #00bcd4; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#26c6da" style="width: 12.5%; height: 24px; background: #26c6da; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#4dd0e1" style="width: 12.5%; height: 24px; background: #4dd0e1; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#80deea" style="width: 12.5%; height: 24px; background: #80deea; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#b2ebf2" style="width: 12.5%; height: 24px; background: #b2ebf2; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#e0f7fa" style="width: 12.5%; height: 24px; background: #e0f7fa; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#0091ea" style="width: 12.5%; height: 24px; background: #0091ea; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#00b0ff" style="width: 12.5%; height: 24px; background: #00b0ff; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#40c4ff" style="width: 12.5%; height: 24px; background: #40c4ff; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#80d8ff" style="width: 12.5%; height: 24px; background: #80d8ff; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#01579b" style="width: 12.5%; height: 24px; background: #01579b; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#0277bd" style="width: 12.5%; height: 24px; background: #0277bd; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#0288d1" style="width: 12.5%; height: 24px; background: #0288d1; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#039be5" style="width: 12.5%; height: 24px; background: #039be5; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#03a9f4" style="width: 12.5%; height: 24px; background: #03a9f4; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#29b6f6" style="width: 12.5%; height: 24px; background: #29b6f6; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#4fc3f7" style="width: 12.5%; height: 24px; background: #4fc3f7; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#81d4fa" style="width: 12.5%; height: 24px; background: #81d4fa; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#b3e5fc" style="width: 12.5%; height: 24px; background: #b3e5fc; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#e1f5fe" style="width: 12.5%; height: 24px; background: #e1f5fe; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#2962ff" style="width: 12.5%; height: 24px; background: #2962ff; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#2979ff" style="width: 12.5%; height: 24px; background: #2979ff; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#448aff" style="width: 12.5%; height: 24px; background: #448aff; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#82b1ff" style="width: 12.5%; height: 24px; background: #82b1ff; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#0d47a1" style="width: 12.5%; height: 24px; background: #0d47a1; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#1565c0" style="width: 12.5%; height: 24px; background: #1565c0; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#1976d2" style="width: 12.5%; height: 24px; background: #1976d2; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#1e88e5" style="width: 12.5%; height: 24px; background: #1e88e5; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#2196f3" style="width: 12.5%; height: 24px; background: #2196f3; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#42a5f5" style="width: 12.5%; height: 24px; background: #42a5f5; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#64b5f6" style="width: 12.5%; height: 24px; background: #64b5f6; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#90caf9" style="width: 12.5%; height: 24px; background: #90caf9; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#bbdefb" style="width: 12.5%; height: 24px; background: #bbdefb; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#e3f2fd" style="width: 12.5%; height: 24px; background: #e3f2fd; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#304ffe" style="width: 12.5%; height: 24px; background: #304ffe; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#3d5afe" style="width: 12.5%; height: 24px; background: #3d5afe; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#536dfe" style="width: 12.5%; height: 24px; background: #536dfe; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#8c9eff" style="width: 12.5%; height: 24px; background: #8c9eff; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#1a237e" style="width: 12.5%; height: 24px; background: #1a237e; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#283593" style="width: 12.5%; height: 24px; background: #283593; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#303f9f" style="width: 12.5%; height: 24px; background: #303f9f; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#3949ab" style="width: 12.5%; height: 24px; background: #3949ab; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#3f51b5" style="width: 12.5%; height: 24px; background: #3f51b5; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#5c6bc0" style="width: 12.5%; height: 24px; background: #5c6bc0; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#7986cb" style="width: 12.5%; height: 24px; background: #7986cb; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#9fa8da" style="width: 12.5%; height: 24px; background: #9fa8da; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#c5cae9" style="width: 12.5%; height: 24px; background: #c5cae9; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#e8eaf6" style="width: 12.5%; height: 24px; background: #e8eaf6; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#6200ea" style="width: 12.5%; height: 24px; background: #6200ea; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#651fff" style="width: 12.5%; height: 24px; background: #651fff; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#7c4dff" style="width: 12.5%; height: 24px; background: #7c4dff; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#b388ff" style="width: 12.5%; height: 24px; background: #b388ff; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#311b92" style="width: 12.5%; height: 24px; background: #311b92; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#4527a0" style="width: 12.5%; height: 24px; background: #4527a0; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#512da8" style="width: 12.5%; height: 24px; background: #512da8; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#5e35b1" style="width: 12.5%; height: 24px; background: #5e35b1; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#673ab7" style="width: 12.5%; height: 24px; background: #673ab7; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#7e57c2" style="width: 12.5%; height: 24px; background: #7e57c2; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#9575cd" style="width: 12.5%; height: 24px; background: #9575cd; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#b39ddb" style="width: 12.5%; height: 24px; background: #b39ddb; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#d1c4e9" style="width: 12.5%; height: 24px; background: #d1c4e9; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ede7f6" style="width: 12.5%; height: 24px; background: #ede7f6; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#aa00ff" style="width: 12.5%; height: 24px; background: #aa00ff; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#d500f9" style="width: 12.5%; height: 24px; background: #d500f9; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#e040fb" style="width: 12.5%; height: 24px; background: #e040fb; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ea80fc" style="width: 12.5%; height: 24px; background: #ea80fc; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#4a148c" style="width: 12.5%; height: 24px; background: #4a148c; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#6a1b9a" style="width: 12.5%; height: 24px; background: #6a1b9a; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#7b1fa2" style="width: 12.5%; height: 24px; background: #7b1fa2; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#8e24aa" style="width: 12.5%; height: 24px; background: #8e24aa; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#9c27b0" style="width: 12.5%; height: 24px; background: #9c27b0; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ab47bc" style="width: 12.5%; height: 24px; background: #ab47bc; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ba68c8" style="width: 12.5%; height: 24px; background: #ba68c8; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ce93d8" style="width: 12.5%; height: 24px; background: #ce93d8; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#e1bee7" style="width: 12.5%; height: 24px; background: #e1bee7; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#f3e5f5" style="width: 12.5%; height: 24px; background: #f3e5f5; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#c51162" style="width: 12.5%; height: 24px; background: #c51162; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#f50057" style="width: 12.5%; height: 24px; background: #f50057; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ff4081" style="width: 12.5%; height: 24px; background: #ff4081; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ff80ab" style="width: 12.5%; height: 24px; background: #ff80ab; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#880e4f" style="width: 12.5%; height: 24px; background: #880e4f; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ad1457" style="width: 12.5%; height: 24px; background: #ad1457; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#c2185b" style="width: 12.5%; height: 24px; background: #c2185b; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#d81b60" style="width: 12.5%; height: 24px; background: #d81b60; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#e91e63" style="width: 12.5%; height: 24px; background: #e91e63; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ec407a" style="width: 12.5%; height: 24px; background: #ec407a; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#f06292" style="width: 12.5%; height: 24px; background: #f06292; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#f48fb1" style="width: 12.5%; height: 24px; background: #f48fb1; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#f8bbd0" style="width: 12.5%; height: 24px; background: #f8bbd0; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#fce4ec" style="width: 12.5%; height: 24px; background: #fce4ec; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#d50000" style="width: 12.5%; height: 24px; background: #d50000; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ff1744" style="width: 12.5%; height: 24px; background: #ff1744; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ff5252" style="width: 12.5%; height: 24px; background: #ff5252; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ff8a80" style="width: 12.5%; height: 24px; background: #ff8a80; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#b71c1c" style="width: 12.5%; height: 24px; background: #b71c1c; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#c62828" style="width: 12.5%; height: 24px; background: #c62828; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#d32f2f" style="width: 12.5%; height: 24px; background: #d32f2f; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#e53935" style="width: 12.5%; height: 24px; background: #e53935; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#f44336" style="width: 12.5%; height: 24px; background: #f44336; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ef5350" style="width: 12.5%; height: 24px; background: #ef5350; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#e57373" style="width: 12.5%; height: 24px; background: #e57373; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ef9a9a" style="width: 12.5%; height: 24px; background: #ef9a9a; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ffcdd2" style="width: 12.5%; height: 24px; background: #ffcdd2; display: inline-block; border: 1px solid white; box-sizing: border-box"></div><div class="color" value="#ffebee" style="width: 12.5%; height: 24px; background: #ffebee; display: inline-block; border: 1px solid white; box-sizing: border-box"></div> </div></div><input type="hidden" name="action" value="changeColors"><button type="submit" class="btn btn-primary btn-sm active btn-block" role="button" aria-pressed="true" settingsColors">Salvar</button></form></div><div class="col-12 text-center" style="margin-top: 20px"></div> </section><footer>
<script type="text/javascript"> 				$(document).ready(function() {						 					$(document).on('click', '#color1', function() { 						$('#colors1').toggle(); 					}); 					 					$(document).on('click', '#color2', function() { 						$('#colors2').toggle(); 					}); 					 					$(document).on('click', '#colors1 .color', function() { 						var color = $(this).attr('value'); 				 						$('#cor1').attr('value', color); 						$('#color1').css('background', color); 						$('#colors1').toggle(); 					}); 					 					$(document).on('click', '#colors2 .color', function() { 						var color = $(this).attr('value'); 				 						$('#cor2').attr('value', color); 						$('#color2').css('background', color); 						$('#colors2').toggle(); 					}); 				}); 			</script>

<?php 
}
else if($a=='ocultatenor') { ativo($meuid,'Painel do Usuário ');
$o = $mistake->query("SELECT tenor FROM w_usuarios WHERE id='$meuid'")->fetch(); ?>
<br/><div id="titulo"><b>Configurar caixa de aviso de mensagem</b></div><br/>
<form action="/configuracoes/ocultatenor2" method="post">
Ativar e desativar notificações de mensagem<br/>
<select name="tenor">
<option value="0">desativado</option>
<option value="1" <?php echo $o[0]==1?'selected':'';?> >Ativado</option>
</select><br/>
<input type="submit" value="Atualizar">
</form>
<?php } else if($a=='ocultatenor2') { ativo($meuid,'Painel do Usuário ');
$res = $mistake->exec("UPDATE w_usuarios SET tenor='".$_POST['tenor']."' WHERE id='$meuid'");
if($res) { ?>
<br/><div align="center"><? echo $imgok;?>Alterações efetuadas com sucesso!<br/>
<?php } else { echo $imgerro;?>
Erro ao fazer alterações<br/>
<?
}}
else 
if($a=="mudarnick"){
?>
<section class="container-fluid"><h2 class="title"><b>Mudar nick</b></h2><div class="col-12 text-center"><?
if($_SERVER['REQUEST_METHOD'] == 'POST') {
$log = $mistake->query("SELECT COUNT(*) FROM w_usuarios WHERE nm='".$_POST['nick']."' and id!='$meuid'")->fetch();
 if ($log[0]>0) { echo $imgerro;?>
Já existe um usuário usando o login <b><?php echo $_POST['login'];?></b><br/>
<?php } else 
if(isdigitf($_POST['nickk'])){ 
echo $imgerro;?>
Caracteres invalidos no nick!
<br/>
<?php  
}else{    
$res = $mistake->exec("UPDATE w_usuarios SET nm='".mb_htmlentities($_POST['nick'])."' WHERE id='$meuid'");
if($res) { echo $imgok;?>
Seu nick foi alterado com sucesso!<br/>
<?php } else { echo $imgerro;?>
Erro ao atualizar login e senha!<br/>
<?php } }}
?><?php echo gerarnome($meuid);?></div><div class="col-12"><form action="/configuracoes/mudarnick" method="post"><div class="form-group"><input type="text" class="form-control" name="nick" placeholder="Nick"></div><input type="hidden" name="action" value="changeNick"><button type="submit" class="btn btn-primary btn-sm active btn-block" role="button" aria-pressed="true">Salvar</button></form></div><div class="col-12 text-center" style="margin-top: 20px"></div> </section>
<?
}else
if($a=="alugarvip"){
ativo($meuid,'alugando vip');
echo "<br/><div id='titulo'><b>Alugar Vip</b></div><br/><div align='center'><b>Alugue seu status tera todos privilegios , painel de equipe e nao pagara por nada no site sendo retirado automatico no prazo.</b></div><br>";
echo "<b>Alugar 1 dia 8 moedas</b></br>";
echo"<form action=\"/configuracoes/participar\" method=\"post\">";
echo"<input name=\"dias\" value=\"1\" type=\"hidden\">";
echo"<input name=\"plusses\" value=\"8\" type=\"hidden\">";
echo"<input value=\"Alugar\" class=\"bt3\" type=\"submit\">";
echo"</form><hr>";
echo "<b>Alugar 3 dias 20 moedas</b></br>";
echo"<form action=\"/configuracoes/participar\" method=\"post\">";
echo"<input name=\"dias\" value=\"3\" type=\"hidden\">";
echo"<input name=\"plusses\" value=\"20\" type=\"hidden\">";
echo"<input value=\"Alugar\" class=\"bt3\" type=\"submit\">";
echo"</form><hr>";
echo "<b>Alugar 7 dias 50 moedas</b></br>";
echo"<form action=\"/configuracoes/participar\" method=\"post\">";
echo"<input name=\"dias\" value=\"7\" type=\"hidden\">";
echo"<input name=\"plusses\" value=\"50\" type=\"hidden\">";
echo"<input value=\"Alugar\" class=\"bt3\" type=\"submit\">";
echo"</form><hr>";
echo "<b>Alugar 14 dias 80 moedas</b></br>";
echo"<form action=\"/configuracoes/participar\" method=\"post\">";
echo"<input name=\"dias\" value=\"14\" type=\"hidden\">";
echo"<input name=\"plusses\" value=\"80\" type=\"hidden\">";
echo"<input value=\"Alugar\" class=\"bt3\" type=\"submit\">";
echo"</form><hr>";
echo "<b>Alugar 30 dias 100 moedas</b></br>";
echo"<form action=\"/configuracoes/participar\" method=\"post\">";
echo"<input name=\"dias\" value=\"30\" type=\"hidden\">";
echo"<input name=\"plusses\" value=\"100\" type=\"hidden\">";
echo"<input value=\"Alugar\" class=\"bt3\" type=\"submit\">";
echo"</form><hr>";
$user = $mistake->query("SELECT COUNT(*) FROM w_usuarios WHERE vip='4'");
$user->execute();
$total = $user->fetch();
echo "<p align=\"center\">Total Vips Alugados: <a href=\"/configuracoes/todos-alugados\">$total[0]</a></p><br>";
}else
if($a == "todos-alugados"){
echo "<div id='titulo'>Vips Alugados</div><br>";    
if($pag=="" || $page<=0)$pag=1;
$user = $mistake->prepare("SELECT COUNT(*) FROM w_usuarios WHERE vip='4'");
$user->execute();
$user = $user->fetch();
$num_items = $user[0];
$items_per_page= 20;
$numpag = ceil($num_items/$items_per_page);
if(($pag>$numpag)&&$pag!=1)$pag= $numpag;
$limit_start = ($pag-1)*$items_per_page;
$sql = "SELECT id FROM w_usuarios WHERE vip='4' ORDER BY id ASC LIMIT $limit_start, $items_per_page";
$items = $mistake->prepare($sql);
$items->execute();
if($items->rowCount()>0){
$num = 0;
while ($item = $items->fetch()){
$color = ($num % 2 == 0)? "<div id='div1'>"  : "<div id='div2'>";
$dados = $mistake->prepare("SELECT data,dias FROM vipalugado WHERE uid='".$item[0]."'");
$dados->execute();
$dados = $dados->fetch();
$tmdtt = date("d m Y - H:i:s", $dados[0]);
$timeto = ($dados[0] + $dados[1]*24*60*60);
$tmdttt = date("d m Y - H:i:s",$timeto);
$lmk="<a href='/configuracoes/retirar/$item[0]'>[x]</a>";
$lnk = "<a href='/".gerarlogin($item[0])."'>".gerarfoto($item[0],50,50)."".gerarnome($item[0])."</a><div style='clear: both'></div>Alugou vip = <b>$tmdtt</b><br> Expira em = <b>$tmdttt</b>";
echo "$color $lnk $lmk</div>";
$num++;
}
echo "</p>";
if($numpag>1) {
paginas('configuracoes',$a,$numpag,$id,$pag);
}
}else{
echo "<div align='center'>Nenhum usuario alugou vip!</div>";   
}
}else
if($a=="retirar"){
if(perm($meuid) < 1){
echo "<div align='center'>$imgerro Permiss&#227;o Negada!</div>";
}else{
$res = $mistake->exec("UPDATE w_usuarios SET vip='0',senhaequipe='MISTAKE' WHERE id='".$id."'");
$mistake->exec("DELETE FROM vipalugado WHERE uid='".$id."'");
$nick = gerarnome2($id);
$msg = "Oi $nick seu Vip Alugado Expirou Alugue Novamente Obrigado.";
automsg($msg,1,$id);
if($res){
echo "<div align='center'>$imgok Vip Alugado Removido com Sucesso!</div>";
}else{
echo "<div align='center'>$imgerro Erro no Banco de Dados</div>";
}
}
}else
if($a=='ocultar') {
?>
<br/><div id="titulo"><b>Ocultar imagens etc...</b></div><br/><div align="center">
<?    
ativo($meuid,'Painel do Usuário ');
$a = empty($_POST['paginas']) ? 0 : 1;
$b = empty($_POST['ocimg']) ? 0 : 1;
$c = empty($_POST['oclogo']) ? 0 : 1;
$d = empty($_POST['ocmequipe']) ? 0 : 1;
$e = empty($_POST['ocmequipe2']) ? 0 : 1;
$f = empty($_POST['ocmusu']) ? 0 : 1;
$g = empty($_POST['ocmudi']) ? 0 : 1;
$h = empty($_POST['ocemo']) ? 0 : 1;
$i = empty($_POST['atlh']) ? 0 : 1;
$j = empty($_POST['duelo']) ? 0 : 1;
$k = empty($_POST['vvnv']) ? 0 : 1;
if($b>=1){
setcookie("ocimg",1,(time() + (86400 * 7)),"/",".".str_replace("www.","",$_SERVER["HTTP_HOST"])."");
}else{
setcookie("ocimg",null, -1,"/",".".str_replace("www.","",$_SERVER["HTTP_HOST"])."");	
}
if($_SERVER['REQUEST_METHOD'] == 'POST') {
$res = $mistake->exec("UPDATE w_usuarios SET cxmsg='".$j."',vvnv='".$k."',paginas='".$a."',ocimg='".$b."',oclogo='".$c."',ocme='".$d."',ocmu='".$f."',ocemo='".$h."',atlh='".$i."',ocmu2='".$g."',ocmu3='".$e."' WHERE id='$meuid'");
if($res) { ?>
<br/><? echo $imgok;?>Alterações efetuadas com sucesso!<br/><br/>
<?php } else { echo $imgerro;?>
Erro ao fazer alterações<br/><br/>
<?php } }
$o = $mistake->query("SELECT * FROM w_usuarios WHERE id='$meuid'")->fetch();
?>
<small>
<form action="/configuracoes/ocultar" method="post">
Responder em todas paginas?<br/>    
<label class="switch">    
<input type="checkbox" name="paginas" data-value="1" value="1" <?php echo $o['paginas'] == '1' ? 'checked' : '' ?> />
<span class="slider round"></span>
</label><br/>
Ocultar imagens do site?<br/>
<label class="switch">
<input type="checkbox" name="ocimg" data-value="1" value="1" <?php echo $o['ocimg'] == '1' ? 'checked' : '' ?> />
<span class="slider round"></span>
</label><br/>
Ocultar logo do site?<br/>
<label class="switch">
<input type="checkbox" name="oclogo" data-value="1" value="1" <?php echo $o['oclogo'] == '1' ? 'checked' : '' ?> />
<span class="slider round"></span>
</label><br/>
Ocultar mural da equipe?<br/>
<label class="switch">
<input type="checkbox" name="ocmequipe" data-value="1" value="1" <?php echo $o['ocme'] == '1' ? 'checked' : '' ?> />
<span class="slider round"></span>
</label><br/>
Ocultar segundo mural da equipe?<br/>
<label class="switch">
<input type="checkbox" name="ocmequipe2" data-value="1" value="1" <?php echo $o['ocmu3'] == '1' ? 'checked' : '' ?> />
<span class="slider round"></span>
</label><br/>
Ocultar mural do usuário?<br/>
<label class="switch">
<input type="checkbox" name="ocmusu" data-value="1" value="1" <?php echo $o['ocmu'] == '1' ? 'checked' : '' ?> />
<span class="slider round"></span>
</label><br/>
Ocultar mural de divulgação?<br/>
<label class="switch">
<input type="checkbox" name="ocmudi" data-value="1" value="1" <?php echo $o['ocmu2'] == '1' ? 'checked' : '' ?> />
<span class="slider round"></span>
</label><br/>
Ocultar duelo de fotos?<br/>
<label class="switch">
<input type="checkbox" name="duelo" data-value="1" value="1" <?php echo $o['cxmsg'] == '1' ? 'checked' : '' ?> />
<span class="slider round"></span>
</label><br/>
Ocultar emoções?<br/>
<label class="switch">
<input type="checkbox" name="ocemo" data-value="1" value="1" <?php echo $o['ocemo'] == '1' ? 'checked' : '' ?> />
<span class="slider round"></span>
</label><br/>
Ocultar atalho no topo da página?<br/>
<label class="switch">
<input type="checkbox" name="atlh" data-value="1" value="1" <?php echo $o['atlh'] == '1' ? 'checked' : '' ?> />
<span class="slider round"></span>
</label><br />
Habilitar vou, não vou?<br/>
<label class="switch">
<input type="checkbox" name="vvnv" data-value="1" value="1" <?php echo $o['vvnv'] == '1' ? 'checked' : '' ?> />
<span class="slider round"></span>
</label><br/>
<input type="submit" value="Atualizar">
</form></small></div>
<?php } else  if($a=='recados') { 
?>
<br/><div id="titulo"><b>Opções de privacidade</b></div><br/><div align="center">
<?
ativo($meuid,'Opções de privacidade');
$a = empty($_POST['duelo']) ? 0 : 1;
$b = empty($_POST['verrec']) ? 0 : 1;
$c = empty($_POST['enviarrec']) ? 0 : 1;
$d = empty($_POST['vemail']) ? 0 : 1;
$e = empty($_POST['verper']) ? 0 : 1;
$f = empty($_POST['pergpri']) ? 0 : 1;
if($_SERVER['REQUEST_METHOD'] == 'POST') {
$res = $mistake->exec("UPDATE w_usuarios SET duelo='".$a."',vrec='".$b."', erec='".$c."', vemail='".$d."',ppri='".$e."',pergpri='".$f."' WHERE id='$meuid'");
if($res) { ?>
<br/><? echo $imgok;?>Alterações efetuadas com sucesso!<br/><br/>
<?php } else { echo $imgerro;?>
Erro ao fazer alterações<br/><br/>
<?php } }
$verrec = $mistake->query("SELECT * FROM w_usuarios WHERE id='$meuid'")->fetch(); 
?>
<small><b>marque para amigos deixe sem marcar para todos.</b><br />
<form action="/configuracoes/recados" method="post">
Quem pode ver meu perfil?<br/>
<label class="switch">
<input type="checkbox" name="verper" data-value="1" value="1" <?php echo $verrec['ppri'] == '1' ? 'checked' : '' ?> />
<span class="slider round"></span>
</label><br/>
Quem pode te marcar e comentar murais?<br/>
<label class="switch">
<input type="checkbox" name="duelo" data-value="1" value="1" <?php echo $verrec['duelo'] == '1' ? 'checked' : '' ?> />
<span class="slider round"></span>
</label><br/>
Quem pode acessar meu Pergunte-ME?<br/>
<label class="switch">
<input type="checkbox" name="pergpri" data-value="1" value="1" <?php echo $verrec['pergpri'] == '1' ? 'checked' : '' ?> />
<span class="slider round"></span>
</label><br/>
Quem pode ver meus recados?<br/>
<label class="switch">
<input type="checkbox" name="verrec" data-value="1" value="1" <?php echo $verrec['vrec'] == '1' ? 'checked' : '' ?> />
<span class="slider round"></span>
</label><br/>
Quem pode me mandar recados?<br/>
<label class="switch">
<input type="checkbox" name="enviarrec" data-value="1" value="1" <?php echo $verrec['erec'] == '1' ? 'checked' : '' ?> />
<span class="slider round"></span>
</label><br/>
Quem pode ver meu e-mail?<br/>
<label class="switch">
<input type="checkbox" name="vemail" data-value="1" value="1" <?php echo $verrec['vemail'] == '1' ? 'checked' : '' ?> />
<span class="slider round"></span>
</label><br/>
<input type="submit" value="Atualizar">
</form></small></div>
<?php } else if($a=='moedas') { ativo($meuid,'Painel do Usuário ');
$consul = $mistake->query("SELECT atividades,pt FROM w_usuarios WHERE id='$meuid'")->fetch();
?>
<br/><div id="titulo"><b>Ganhe moedas</b></div><br/>
<div align="center">
<?php
if($_POST['moedas']==true && $_POST['moedas'] >= 1){
if($consul[0]<$_POST['moedas']*100){
?>
<strong><?php echo $imgerro;?>Você precisa de mais atividades!</strong><br /><br />
<?php
}else{
?>	
<?php
$res = $mistake->exec("update w_usuarios set moedas=moedas+'".$_POST['moedas']."' where id='$meuid'"); ?>
<?php
if($res) { 
echo $imgok;?><b><?php echo $_POST['moedas'];?></b> Moedas adicionadas com sucesso!<br /><br />
<?php
$final = $consul[0] - $_POST['moedas']*100;
$res = $mistake->exec("update w_usuarios set atividades='".$final."' where id='$meuid'"); 
} else { 
echo $imgerro;?> Atividades insuficientes para troca!<br /><br />
<?php
} 
}
}
if($_POST['pontos']==true && $_POST['pontos'] >= 1){
if($consul[1]<$_POST['pontos']*1000){
?>
<strong><?php echo $imgerro;?>Você precisa de mais pontos!</strong><br /><br />
<?php
}else{
$res = $mistake->exec("update w_usuarios set moedas=moedas+'".$_POST['pontos']."' where id='$meuid'"); ?>
<?php
if($res) { 
echo $imgok;?><b><?php echo $_POST['pontos'];?></b> Moedas adicionadas com sucesso!<br /><br />
<?php
$final = $consul[1] - $_POST['pontos']*1000;
$res = $mistake->exec("update w_usuarios set pt='".$final."' where id='$meuid'"); 
} else {
echo $imgerro;?> pontos insuficientes para troca!<br /><br />
<?php 
} 
}
}
$consul = $mistake->query("SELECT atividades,pt FROM w_usuarios WHERE id='$meuid'")->fetch();
?>
Atualmente você possui <?php echo $consul[0];?> atividades<br /><br />A cada 100 atividades você pode trocar por 1 moeda.<br /><br />
<?php
$moedas = $consul[0]/100;
?>
<strong>Você pode trocar por até <?php echo floor($moedas); ?> moedas.</strong><br /><br />
</p>
<form action="/configuracoes/moedas" method="post">
<p align="center"> Número de moedas:
<input name="moedas" value="<?php echo floor($moedas); ?>" size="5" maxlength="150"/>
<input type="submit" value="Trocar"/>
</p>
</form>
<br />Atualmente você possui <?php echo $consul[1];?> pontos<br /><br />A cada 1000 pontos você pode trocar por 1 moeda.<br /><br />
<?php
$moedas1 = $consul[1]/1000;
?>
<strong>Você pode trocar por até <?php echo floor($moedas1); ?> moedas.</strong><br /><br />
</p>
<form action="/configuracoes/moedas" method="post">
<p align="center"> Número de moedas:
<input name="pontos" value="<?php echo floor($moedas1); ?>" size="5" maxlength="150"/>
<input type="submit" value="Trocar"/>
</p>
</form>

</div>
<?php }
else 
if($a=='remover_foto_perfil') { ativo($meuid,'Alterando foto do perfil ');
$id = isset($_GET['id']) ? $id : $meuid;
if($meuid==$id or perm($meuid)>2){
$info = $mistake->query("SELECT * FROM w_usuarios WHERE id='$id'")->fetch(); 
if(stristr($info['ft'],'fotoperfil') == true){
@unlink($info['ft']);
@unlink(str_replace('m_','',$info['ft']));
}
$mistake->exec("UPDATE w_usuarios SET ft=null WHERE id='$id'");
?>
<div align="center"><?php echo $imgok;?>Atualizado com sucesso!</div>
<?php
}else{
echo $imgerro;?>
voce nao pode fazer isso!
<?php
}
}else
if($a=='foto_perfil') { ativo($meuid,'Alterando foto do perfil ');
$info = $mistake->query("SELECT * FROM w_usuarios WHERE id='$meuid'")->fetch(); ?>
<br/><div id="titulo"><b>Alterar foto do perfil</b></div><br/>
<div align="center">
<img src="/<?php echo $info['ft'] ==true ? $info['ft'] : 'semfoto.jpg';?>" id="fotoperfil" width="200">    
<form action="/configuracoes/editarfoto/<?php echo $id;?>" method="post" enctype="multipart/form-data">
<?php echo $info['ft']==false?'Inserir':'Alterar';?> foto:<br/>
<input type="file" onchange="loadMistake(event)" name="img"><br/><br />
<input type="submit" value="<?php echo $info['ft']==false?'Inserir':'Alterar';?>">
</form>
</div>
<script>var loadMistake = function(event) {var reader = new FileReader();reader.onload = function(){var output = document.getElementById('fotoperfil');output.src = reader.result;};reader.readAsDataURL(event.target.files[0]);};</script>
<?php }
else if($a=='tema_padrao') { ativo($meuid,'Painel do Usuário ');
?>
<br/><div id="titulo"><b>Tema padrão</b></div><br/>
<div align="center">
<?php
$bg = $mistake->query("SELECT fundo_bg FROM w_usuarios WHERE id='$meuid'")->fetch();
@unlink($bg[0]);
$res = $mistake->exec("update w_usuarios set linha1='#EBF9DF', linha2='#EAF3FA', fundo=null, links='', texto='', fundo_bg=null where id='$meuid'"); ?>
<?php
if($res) { ?>
<?php echo $imgok;?>Seu perfil voltou a ficar com o tema original do site.<br /><br />
<?php 
}else{	
}
} else if($a=='remove_music') { ativo($meuid,'Painel do Usuário ');
?>
<br/><div id="titulo"><b>Música no perfil</b></div><br/>
<div align="center">
<?php
$res = $mistake->exec("update w_usuarios set music=null where id='$meuid'");
echo $imgok;?>Música removida com sucesso!<br /><br />
<?php 
}else if($a=='remove_video') { ativo($meuid,'Painel do Usuário ');
?>
<br/><div id="titulo"><b>Video no perfil</b></div><br/>
<div align="center">
<?php
$res = $mistake->exec("update w_usuarios set video=null where id='$meuid'"); echo $imgok;?>Video removido com sucesso!<br /><br />
<?php 
 }else if($a=='cordonick') { ativo($meuid,'Painel do Usuário ');
?>
<br/><div id="titulo"><b>Cor do nick</b></div><br/>
<div align="center">
<?php
$moedas =  $mistake->query("SELECT moedas,corn,corn2,corn3,corn4,corn5,corn6,corn7 FROM w_usuarios WHERE id='$meuid'")->fetch();
if($_POST['valor7']==true){
if($moedas[0]<3){
?>
<?php echo $imgerro;?>
Você não possui moedas suficientes!<br />
<?php
}else{
if (empty($_POST['valor7'])) {
echo $imgerro;?>
Por favor escolha uma cor!<br /><br />
<?php
}else{
$res =  $mistake->exec("update w_usuarios set corn4='".$_POST['valor7']."' where id='$meuid'"); ?>
<?php
if($res) { 
echo $imgok;?>Sombra aplicada com sucesso ao nick! <?php echo gerarnome($meuid);?><br /><br />
<?php
$res =  $mistake->exec("update w_usuarios set moedas=moedas-3 where id='$meuid'"); 
} else { 
echo $imgerro;?> Está cor está selecionada atualmente!<br /><br />
<?php 
} 
}
}
}
if($_POST['valor1']==true){
if (empty($_POST['valor1'])) {
echo $imgerro;?>
Por favor escolha uma cor!<br /><br />
<?php
}else{
$res =  $mistake->exec("update w_usuarios set corn='".$_POST['valor1']."',corn2='0',corn3='0',corn4='0',corn5='0',corn6='0',corn7='0' where id='$meuid'"); ?>
<?php
if($res) { 
echo $imgok;?>Cor aplicada com sucesso ao nick! <?php echo gerarnome($meuid);?><br /><br />
<?php
} else { 
echo $imgerro;?> Está cor está selecionada atualmente!<br /><br />
<?php 
} 
}
}
if($_POST['valor2']==true&&$_POST['valor3']==true){
if($moedas[0]<3){
?>
<?php echo $imgerro;?>
Você não possui moedas suficientes!<br />
<?php
}else{
if (empty($_POST['valor2'])||empty($_POST['valor3'])) {
echo $imgerro;?>
Por favor escolha uma cor!<br /><br />
<?php
}else{
$res =  $mistake->exec("update w_usuarios set corn='".$_POST['valor2']."',corn2='".$_POST['valor3']."',corn3='0' where id='$meuid'"); ?>
<?php
if($res) { 
echo $imgok;?>2 Cores aplicada com sucesso ao nick! <?php echo gerarnome($meuid);?><br /><br />
<?php
$res =  $mistake->exec("update w_usuarios set moedas=moedas-3 where id='$meuid'"); 
} else { 
echo $imgerro;?> Está cor está selecionada atualmente!<br /><br />
<?php 
} 
}
}
}
if($_POST['valor4']==true&&$_POST['valor5']==true&&$_POST['valor6']==true){
if($moedas[0]<25){
?>
<?php echo $imgerro;?>
Você não possui moedas suficientes!<br />
<?php
}else{
if (empty($_POST['valor4'])||empty($_POST['valor5'])||empty($_POST['valor6'])) {
echo $imgerro;?>
Por favor escolha uma cor!<br /><br />
<?php
}else{
$res =  $mistake->exec("update w_usuarios set corn='".$_POST['valor4']."',corn2='".$_POST['valor5']."',corn3='".$_POST['valor6']."' where id='$meuid'"); ?>
<?php
if($res) { 
echo $imgok;?>Cor aplicada com sucesso ao nick! <?php echo gerarnome($meuid);?><br /><br />
<?php
$res =  $mistake->exec("update w_usuarios set moedas=moedas-25 where id='$meuid'"); 
} else { 
echo $imgerro;?> Está cor está selecionada atualmente!<br /><br />
<?php 
} 
}
}
}
if($_POST['valor8']==true&&$_POST['valor9']==true&&$_POST['valor10']==true){
if($moedas[0]<25){
?>
<?php echo $imgerro;?>
Você não possui moedas suficientes!<br />
<?php
}else{
if (empty($_POST['valor8'])||empty($_POST['valor9'])||empty($_POST['valor10'])) {
echo $imgerro;?>
Por favor escolha uma cor!<br /><br />
<?php
}else{
$res =  $mistake->exec("update w_usuarios set corn5='".$_POST['valor8']."',corn6='".$_POST['valor9']."',corn7='".$_POST['valor10']."' where id='$meuid'"); ?>
<?php
if($res) { 
echo $imgok;?>Cor aplicada com sucesso ao nick! <?php echo gerarnome($meuid);?><br /><br />
<?php
$res =  $mistake->exec("update w_usuarios set moedas=moedas-25 where id='$meuid'"); 
} else { 
echo $imgerro;?> Está cor está selecionada atualmente!<br /><br />
<?php 
} 
}
}
}
if($id=='color'){
$_SESSION["caixa_cores"] = $meuid;
}else{
unset($_SESSION["caixa_cores"]);    
}
$caixa= isset($_SESSION['caixa_cores']) ? 'text' : 'color';
$moedas =  $mistake->query("SELECT moedas,corn,corn2,corn3,corn4,corn5,corn6,corn7 FROM w_usuarios WHERE id='$meuid'")->fetch();
?>
<a href="/configuracoes/cordonick/<?php echo $caixa;?>">Mudar Caixa de Cores</a><br /><br />
OBS: Uma cor gratuita.<br /><b>1 cor todas outras cores sairam</b><br /><br />
<form action="/configuracoes/cordonick" method="post">
 <b>Cor1:</b><input name="valor1" type="<?php echo $caixa;?>" maxlength="7" value="<?php echo $moedas[1];?>"><br />
 <input type="submit" value="Aplicar cor"/></form><br /><br />

OBS: Cada alteração você paga 3 moedas.<br /><b>2 cores</b><br /><br />
<form action="/configuracoes/cordonick" method="post">
 <b>Cor1:</b><input name="valor2" type="<?php echo $caixa;?>" maxlength="7" value="<?php echo $moedas[1];?>"><br />
 <b>Cor2:</b><input name="valor3" type="<?php echo $caixa;?>" maxlength="7" value="<?php echo $moedas[2];?>"><br />
 <input type="submit" value="Aplicar cores"/></form><br />
 OBS: Sombra no nick você paga 3 moedas.<br /><br />
<form action="/configuracoes/cordonick" method="post">
 <b>Sombra:</b><input name="valor7" type="<?php echo $caixa;?>" maxlength="7" value="<?php echo $moedas[4];?>"><br />
 <input type="submit" value="Aplicar sombra"/></form><br />
 <?php
if(perm($meuid)>0) { 
?>
OBS: Equipe você paga 25 moedas.<br /><b>3 cores</b><br /><br />
<form action="/configuracoes/cordonick" method="post">
 <b>Cor1:</b><input name="valor4" type="<?php echo $caixa;?>" maxlength="7" value="<?php echo $moedas[1];?>"><br />
 <b>Cor2:</b><input name="valor5" type="<?php echo $caixa;?>" maxlength="7" value="<?php echo $moedas[2];?>"><br />
 <b>Cor3:</b><input name="valor6" type="<?php echo $caixa;?>" maxlength="7" value="<?php echo $moedas[3];?>"><br />
 <input type="submit" value="Aplicar cor"/></form>
<br />


 OBS: Cada alteração você paga 25 moedas.<br /><b>3 cores aleatorias de fundo</b><br /><br />
<form action="/configuracoes/cordonick" method="post">
 <b>Cor1:</b><input name="valor8" type="<?php echo $caixa;?>" maxlength="7" value="<?php echo $moedas[5];?>"><br />
 <b>Cor2:</b><input name="valor9" type="<?php echo $caixa;?>" maxlength="7" value="<?php echo $moedas[6];?>"><br />
 <b>Cor3:</b><input name="valor10" type="<?php echo $caixa;?>" maxlength="7" value="<?php echo $moedas[7];?>"><br />
 <input type="submit" value="Aplicar cor"/></form></div>
<br />
 <?php
}}
else 
if($a=='musica') { ativo($meuid,'Música no perfil');
?>
<br/><div id="titulo"><b>Música no perfil</b></div><br/>
<div align="center">
<?php
if($_POST['nome']==true&&is_numeric($_POST['musica'])){
if(!empty($_POST['para'])){
if(privacidade($_POST['para'])==0 || contamigos($meuid,$_POST['para'])==true || vip($meuid)) {
ubloq($meuid,$_POST['para']);
$para = $_POST['para'];
}else{
$para = 0;   
}
}else{
$para = 0; 
}	
$texto = "https://".$_SERVER['SERVER_NAME']."/nandotracks/".$_POST['musica']." <u><i><font color='red'>".$_POST['nome']."</font></i></u> ".$_POST['imagem']."";
$res =  $mistake->prepare("INSERT INTO w_mural (rec,drec,para,hora,tipo) VALUES (?,?,?,?,?)");
$arrayName = array($texto,$meuid,$para,time(),$_POST['posthall']);
$ii = 0;
for($i=1; $i <=5; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute(); 
echo $imgok;?>A música foi postada com sucesso!<br>
<?php
}
if(isset($_GET['hash']) or !empty($_POST['mp3'])){
$musica = isset($_GET['hash']) ? ''.str_replace('https://','/vkmusic/',$_GET['hash']).'' : ''.$_POST['mp3'].'';
$res =  $mistake->prepare("UPDATE w_usuarios SET music=:music WHERE id=:id");
$res->bindParam(":music",$musica);
$res->bindParam(":id",$meuid);
$res->execute();
echo $imgok;?>A música foi adicionada com sucesso!<br><br>
<?php
}
if(!empty($_POST['meump3']) or isset($_GET['query'])){	
$musica = isset($_GET['query']) ? ''.$_GET['query'].'' : ''.$_POST['meump3'].'';
echo "Resultados para <b>".$musica."</b> <br /><br />";
if($_POST['soundcloud']==1){	
function tirarAcentos($string){
return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/","/(ç)/","/(Ç)/"),explode(" ","a A e E i I o O u U n N c C"),$string);
}
$response = open_url("https://api.soundcloud.com/tracks/?q=".tirarAcentos(str_replace(' ', '+', strip_tags(urldecode($musica))))."&client_id=e8d2797b62ce47938f3baa699a725864&limit=".$_POST['total']."");
$searchResponse = json_decode($response,true);
if($searchResponse==TRUE){
foreach ($searchResponse as $searchResult) {
if(empty($searchResult['title']) or !empty($searchResult['original_content_size']) or empty($searchResult['title']))continue;
$init = $searchResult['duration'];
$hours = floor($init / 360000);
$minutes = floor(($init / 60000) % 60000);
$secondss = $init % 60000;
$seconds = date("s",$secondss);
$avatar = $searchResult['artwork_url']==true?$searchResult['artwork_url']:'https://socialcraziwuejs.net/erro.gif';
$adici = "<audio controls controlslist='nodownload' src='https://".$_SERVER['SERVER_NAME']."/nandotracks/".$searchResult['id']."'></audio><div><a href=\"https://".$_SERVER['SERVER_NAME']."/nandotracks/".$searchResult['id']."\"><button class='bt3'>Download</button></a><form action='/configuracoes/musica' method='POST' style='display:inline;'><input type='hidden' name='mp3' value='https://".$_SERVER['SERVER_NAME']."/nandotracks/".$searchResult['id']."'><input type='submit' class='bt3' value='Usar No Perfil'></form> <form action='/configuracoes/musica' method='POST' style='display:inline;'><input type='hidden' name='imagem' value='".$avatar."'><input type='hidden' name='nome' value=\"".$searchResult['title']."\"><input type='hidden' name='musica' value='".$searchResult['id']."'><br /><small> Marque um amigo</small><br />
<input type='number' name='para' value=''><br />
Hall&emsp;&emsp;Mural&emsp;&emsp;Pensamento<br />
<label class='switch'>
<input type='radio' name='posthall' data-value='1' value='5' checked/>
<span class='slider round'></span></label>
<label class='switch'>
<input type='radio' name='posthall' data-value='1' value='1'/>
<span class='slider round'></span></label>
<label class='switch'>
<input type='radio' name='posthall' data-value='1' value='4'/>
<span class='slider round'></span></label><br />
<input type='submit' value='Compartilhar'></form></div>";
echo"<div class='box1 elem'><img alt='Link' title=\"".$searchResult['title']."\" src='".$avatar."' class='avatar' style='width:60px;height:60px;float:left;padding:4px;'/><div class='areaTexto'><br>".$searchResult['title']."<br>$adici<br>Duração: ".$minutes.":".$seconds." min</div></div><hr>";
}
}
}else{	
$GrabURL =  open_url("https://downloadmusicvk.ru/audio/search?q=".urlencode($musica)."&performer_only=0&search_sort=2");
$GrabURL = preg_replace('#<!DOCTYPE html>(.*?)<div id="w1" class="list-view">(.*?)#s','<div id="w1" class="list-view">',$GrabURL);
$GrabURL = preg_replace('#<script(.*?)</script>(.*?)#s','',$GrabURL);
$GrabURL = str_replace('" data-path="','',$GrabURL);
$GrabURL = str_replace('Ничего не найдено',''.$imgerro.'Nada encontrado',$GrabURL);
$GrabURL = preg_replace('#<div class="row audio vcenter"(.*?)data-host="(.*?)#s','<div align="center"><audio controls controlslist="nodownload" src="/vkmusic/',$GrabURL);
$GrabURL = preg_replace('#<ul class="pagination">(.*?)</html>(.*?)#s','',$GrabURL);
$GrabURL = preg_replace('#<div class="row social text-center">(.*?)</html>(.*?)#s','',$GrabURL);
$GrabURL = preg_replace("#<div class='text-center'>(.*?)</html>(.*?)#s","",$GrabURL);
$GrabURL = str_replace('" data-url="','"></audio><br /><a href="/configuracoes?a=musica&hash=',$GrabURL);
$GrabURL = str_replace('<div class="col-lg-9 col-md-8 col-sm-6 col-xs-5">','[Usar no perfil]</a><br /><div class="col-lg-9 col-md-8 col-sm-6 col-xs-5">',$GrabURL);
$GrabURL = preg_replace('#<div class="col-lg-2(.*?)<div data-key="(.*?)#s','<hr><div data-key="',$GrabURL);
$GrabURL = str_replace('<img src="/img/hq.svg">','',$GrabURL);
$GrabURL = preg_replace('#<a href="/audio/recommend(.*?)</a>(.*?)#s','',$GrabURL);
$GrabURL = preg_replace('#<a class="(.*?)</a>(.*?)#s','',$GrabURL);
$GrabURL = str_replace('/audio/search?q=','/configuracoes?a=musica&query=',$GrabURL);
echo $GrabURL;
/*
$response = open_url("https://api.vk.com/method/audio.search?q=".urlencode($musica)."&count=".$_POST['total']."&auto_complete=1&performer_only=1&sort=0&v=5.60&access_token=84386206f10d821c492bc7d6369d13e9834f1ae662df708fbd53145986ca6db9175e166a0be5983649b78");
$searchResponse = json_decode($response, true);
if($searchResponse){
echo "As mais tops <b>".$_POST['meump3']."</b><br/><br/>";
for($i=0;$i<$_POST['total'];$i++){
if($searchResponse['response']['items'][$i]['title']==true){
echo "<hr>".$searchResponse['response']['items'][$i]['artist']." <br/><br/>";
echo "".$searchResponse['response']['items'][$i]['title']." <br/><br/>";
echo "".$searchResponse['response']['items'][$i]['url']." <br/><br/>";
$deumusica = "".$searchResponse['response']['items'][$i]['owner_id']."_".$searchResponse['response']['items'][$i]['id']."";
?>
<a href="javascript:void(0)" onclick="functionConfirmN('<?php echo $searchResponse['response']['items'][$i]['owner_id'].'_'.$searchResponse['response']['items'][$i]['id']?>','<?php echo base64_encode($searchResponse['response']['items'][$i]['title'])?>','<?php echo $i?>')">Ouvir</a><br/><br/>
<?
echo "<div id='$i'></div><form action='/configuracoes/musica' method='POST' style='display:inline;'><input type='hidden' name='imagem' value=\"".$searchResponse['response']['items'][$i]['artist']."\"><input type='hidden' name='nome' value=\"".$searchResponse['response']['items'][$i]['title']."\"><input type='hidden' name='musica' value='".base64_encode($deumusica)."'><small> Marque um amigo</small><br /><input type='number' name='para' value=''><br /> Hall&emsp;&emsp;Mural&emsp;&emsp;Pensamento<br /><label class='switch'><input type='radio' name='posthall' data-value='1' value='5' checked/><span class='slider round'></span></label><label class='switch'><input type='radio' name='posthall' data-value='1' value='1'/><span class='slider round'></span></label><label class='switch'><input type='radio' name='posthall' data-value='1' value='4'/><span class='slider round'></span></label><br /><input type='submit' class='bt3' value='Compartilhar'></form><form action='/configuracoes/musica' method='POST' style='display:inline;'><input name='usarmp3' type='hidden' class='bt3' value='".base64_encode($deumusica)."'><input value='Usar No Perfil' type='submit'></form><br><br>";
}
}
}
*/
}
echo"<br>";
}
?>
Faça busca de sua musica favorita obs: <b>colocar nome da musica ou do cantor</b><br><br>
<form action="/configuracoes/musica" method="post">
<input name="meump3" maxlength="500"> 
<br />Soundcloud&emsp;&emsp;Vk<br />
<label class='switch'>
<input type='radio' name='soundcloud' data-value='1' value='1' checked/>
<span class='slider round'></span></label>
<label class='switch'>
<input type='radio' name='soundcloud' data-value='1' value='2'/>
<span class='slider round'></span></label>
<br>Total de <br />5&emsp;10&emsp;&emsp;15&emsp;&emsp;30 <br />
<label class="switch">
<input type="radio" name="total" data-value="1" value="5" checked/>
<span class="slider round"></span>
</label>
<label class="switch">
<input type="radio" name="total" data-value="1" value="10"/>
<span class="slider round"></span>
</label>
<label class="switch">
<input type="radio" name="total" data-value="1" value="15"/>
<span class="slider round"></span>
</label>
<label class="switch">
<input type="radio" name="total" data-value="1" value="30"/>
<span class="slider round"></span>
</label><br />
<input type="submit" value="Buscar">
</form><br /><a href='/configuracoes/remove_music'>[TIRAR DO PERFIL]</a>&nbsp;&nbsp;<a href='/audio'>[FAZER UPLOAD]</a></div>
<?php
}
else
if($a=='fundo_perfil') { 
ativo($meuid,'Fundo do perfil ');
?>
<br/><div id="titulo"><b>Fundo do perfil</b></div><br/>
<div align="center">
<?php
$arquivo = isset($_FILES["arquivo"]) ? $_FILES["arquivo"] : FALSE;
if($arquivo){
$pasta = "fundoperfil/";
$nome = $_FILES['arquivo']['name'];
$nome = str_replace("H", "", $nome);
$nome = str_replace("h", "", $nome);
$ext = explode('.', $nome);
$ext = strtolower($ext[count($ext) - 1]);
$nome = "".rand(11,99)."".time().".".$ext."";
$img_type = $_FILES['arquivo']['type'];
if(!preg_match("/^image\/(pjpeg|jpeg|png|gif|webp)$/", $img_type)){
echo $imgerro?>A extenção do arquivo é inválida A imagem deve ser (jpg|jpeg|png|gif|webp)!
<?php
}else{
$bg = $mistake->query("SELECT fundo_bg FROM w_usuarios WHERE id='$meuid'")->fetch();
@unlink($bg[0]);
if(preg_match("/^image\/(gif)$/",$img_type)){
//exec("gifsicle --scale 0.5 -i ".escapeshellarg($_FILES['arquivo']['tmp_name'])." > ".escapeshellarg($pasta.$nome)."");
move_uploaded_file($_FILES['arquivo']['tmp_name'],$pasta.$nome);
}else{
if(preg_match("/^image\/(webp)$/",$img_type)){
move_uploaded_file($_FILES['arquivo']['tmp_name'],$pasta.$nome); 
}else{
if(preg_match("/^image\/(jpeg|png|bmp|jpg)$/",$img_type)){
//exec("cwebp -q 85 ".escapeshellarg($_FILES['arquivo']['tmp_name'])." -o ".escapeshellarg($pasta.$nome)."");
move_uploaded_file($_FILES['arquivo']['tmp_name'],$pasta.$nome); 
}
}
}
$url = $pasta.$nome;
$res = $mistake->exec("update w_usuarios set fundo_bg='".$url."' where id='$meuid'"); 
if($res){
echo $imgok;?>A imagem de fundo foi alterada com sucesso! Você terminou de alterar o tema do seu perfil.
<?php
}else{
echo $imgerro?>Ocorreu um erro tente novamente!
<?php
}
}
}
?>
Quer um visual único? aplique uma imagem como plano de fundo ao seu perfil no campo abaixo.
<br /><br />
<form action="/configuracoes/fundo_perfil" method="post" enctype="multipart/form-data">
Imagem:
<input type="file" name="arquivo"><br/>
<input type="submit" value="Inserir">
</form>
</div>
<?php 
}
else
if($a=='musicaperfil') { 
ativo($meuid,'Musica do perfil ');
?>
<br/><div id="titulo"><b>Música do perfil</b></div><br/>
<div align="center">
<?php
$arqnome = $_FILES["musica"]["name"];
	$exte = pathinfo($arqnome, PATHINFO_EXTENSION);
		$array = array("mp3");
		 if(!in_array($exte, $array))
		{
			echo $imgerro."A extensão do seu arquivo de música <b>".$exte."</b> não é aceita! O formato aceito é MP3.</p>";
		}
		else{
			if(!is_dir("musicap/")) mkdir("musicap/");
			$url = "musicap/".rand(000,999).time().".".$exte."";
			$musicaAtual = $mistake->query("SELECT music FROM w_usuarios WHERE id='".$meuid."'")->fetch();
			if(file_exists($musicaAtual[0]))
			{
				@unlink($musicaAtual[0]);
			}
			$res = $mistake->exec("UPDATE w_usuarios SET music='".$url."' WHERE id='".$meuid."'");
			if($res)
			{
				copy($_FILES["musica"]["tmp_name"], $url);
				echo "<p align=\"center\">";
				echo "Música inserida em seu perfil com sucesso.";
				echo "</p>";
			}
else
{
echo "<p align=\"center\">";
echo "Erro!";
echo "</p>";
			}
		}
}
 else if($a=='passo1') { ativo($meuid,'Alterando tema');
?>
<br/><div id="titulo"><b>Tema geral</b></div>
<br />
Personalize as cores do perfil como quiser e o deixe mais interessante...
<br /><br />
<?
if($_POST['fundo']==true && $_POST['linha1']==true && $_POST['linha2']==true && $_POST['links']==true && $_POST['texto']==true){
$res = $mistake->exec("UPDATE w_usuarios SET fundo='".$_POST['fundo']."',linha1='".$_POST['linha1']."',linha2='".$_POST['linha2']."',links='".$_POST['links']."',texto='".$_POST['texto']."' WHERE id='$meuid'");
echo '<div align="center">'.$imgok.' Cores alteradas com sucesso</div><br/>';
}
$id = isset($_GET['id']) ? $id : $meuid;
if($_GET['pag']=='remover'){
if($meuid==$id or perm($meuid)>2){	
$bg = $mistake->query("SELECT fundo_bg FROM w_usuarios WHERE id='$id'")->fetch();
@unlink($bg[0]);
$res = $mistake->exec("update w_usuarios set fundo_bg=null where id='$id'"); 
echo '<div align="center">'.$imgok.' Plano de fundo removido</div><br/>';
}
}
$bg = $mistake->query("SELECT bg,fundo,linha1,linha2,links,texto FROM w_usuarios WHERE id='$meuid'")->fetch(); 
?>
<script>
function caixacor(id){
for (i = 1; i < 6; i++){
var textoinput = document.getElementById('caixa'+i).type;
if(textoinput=="color"){ 
document.getElementById('caixa'+i).type = "text"; 
}else{
document.getElementById('caixa'+i).type = "color"; 
} 
}
}
</script>
<a onclick="caixacor('caixa')" href="javascript:void(0)">Mudar Caixa de Cores</a><br /><br />
<div align="center">
<a href="/configuracoes/tema_padrao" style="color:#ff0000;">[Tema padrão]</a>
</div><br/>
<form action="/configuracoes/passo1" method="post">
Linha 1: <input id="caixa1" type="color" maxlength="7" name="linha1" value="<?php echo $bg[2]?>"><br/>
Linha 2: <input id="caixa2" type="color" maxlength="7" name="linha2" value="<?php echo $bg[3]?>"><br/>
Cor dos links: <input id="caixa3" type="color" maxlength="7" name="links" value="<?php echo $bg[4]?>"><br/>
Cor do texto: <input id="caixa4" type="color" maxlength="7" name="texto" value="<?php echo $bg[5]?>"><br/>
Fundo Perfil: <input id="caixa5" type="color" maxlength="7" name="fundo" value="<?php echo $bg[1]?>"><br/>
<input type="submit" value="Aplicar tema"><br/><br/>
</form>
Quer um visual único? aplique uma imagem como plano de fundo ao seu perfil no campo abaixo.
<br /><br />
<form action="/configuracoes/fundo_perfil" method="post" enctype="multipart/form-data">
Imagem:
<input type="file" name="arquivo"><br/>
<input type="submit" value="Inserir">
</div>
</form>
<br />
<div align="left">
<a href="/configuracoes/passo1/<?php echo $id?>/remover" style="color:#ff0000;">[remover plano de fundo]</a>
</div>
<?php 
}  else  
if($a=='editarperfil') {
ativo($meuid,'Editando perfil ');
$id = isset($_GET['id']) ? $id : $meuid;
if(uchat($meuid)==5) { 
?>
<br/><div align="center"><?php echo $imgerro;?>Você foi bloqueado de mudar nick.<br/><br/>
<a href="/home"><?php echo $imginicio;?>Página principal</a><br><br>
<?php 
rodape();
exit(); 
}
if($id==$meuid or permdono($meuid)) {
$info = $mistake->query("SELECT * FROM w_usuarios WHERE id='$id'")->fetch(); ?>
<br/><div id="titulo"><b>Editar perfil</b></div><br/>
<form action="/configuracoes/editarperfil2/<?php echo $id;?>" method="post">
Nome:<br/>
<input name="nome" maxlength="25" value="<?php echo $info['nm'];?>"><br/><br/>
Sobrenome:<br/>
<input name="sbnome" maxlength="10" value="<?php echo $info['sbn'];?>"><br/><br/>
Cidade:<br/>
<input name="cidade" maxlength="50" value="<?php echo $info['cid'];?>" readonly="true"><br/><br/>
Estado:<br/>
<input name="estado" maxlength="50" value="<?php echo $info['est'];?>" readonly="true"><br/><br/>
Procura por:<br/>
<textarea style="width:-webkit-fill-available" name="quem" cols="20" rows="4"><?php echo $info['qm'];?></textarea><br/><br/>
Sexo:<br/><select name="sexo">
<option value="M">Masculino</option>
<option value="F" <?php echo $info['sx']=='F'?'selected':'';?> >Feminino</option>
</select><br/><br/>
Data de nascimento:<br/>
<select name="dtnascimento">
<option value="<?php echo substr($info['nasc'],8,2);?>"><?php echo substr($info['nasc'],8,2);?></option>
<option value="01">01</option>
<option value="02">02</option>
<option value="03">03</option>
<option value="04">04</option>
<option value="05">05</option>
<option value="06">06</option>
<option value="07">07</option>
<option value="08">08</option>
<option value="09">09</option>
<option value="10">10</option>
<option value="11">11</option>
<option value="12">12</option>
<option value="13">13</option>
<option value="14">14</option>
<option value="15">15</option>
<option value="16">16</option>
<option value="17">17</option>
<option value="18">18</option>
<option value="19">19</option>
<option value="20">20</option>
<option value="21">21</option>
<option value="22">22</option>
<option value="23">23</option>
<option value="24">24</option>
<option value="25">25</option>
<option value="26">26</option>
<option value="27">27</option>
<option value="28">28</option>
<option value="29">29</option>
<option value="30">30</option>
<option value="31">31</option>
</select>
de 
<select name="dtnascimento2">
<option value="<?php echo substr($info['nasc'],5,2);?>"><?php echo gerarmes($info['id']);?></option>
<option value="01">Janeiro</option>
<option value="02">Fevereiro</option>
<option value="03">Março</option>
<option value="04">Abril</option>
<option value="05">Maio</option>
<option value="06">Junho</option>
<option value="07">Julho</option>
<option value="08">Agosto</option>
<option value="09">Setembro</option>
<option value="10">Outubro</option>
<option value="11">Novembro</option>
<option value="12">Dezembro</option>
</select> de 
<select name="dtnascimento3">
<option value="<?php echo substr($info['nasc'],0,4);?>"><?php echo substr($info['nasc'],0,4);?></option>
<?php
$qtd2 = ((date('Y')-18)-47);
$qtd = ((date('Y')-18)-$qtd2);
for($i=1; $i<=$qtd; ++$i) { ?>
<option value="<?php echo ($qtd2+$i);?>"><?php echo ($qtd2+$i);?></option>
<?php } ?> 
</select><br/><br/>
Orientação sexual:<br/><select name="orient" value="<?php echo $info['orient'];?>">
<option value="0">Hetero Sexual</option>
<option value="1" <?php echo $info['orient']=='2'?'selected':'';?> >Homossexual</option>
<option value="4" <?php echo $info['orient']=='4'?'selected':'';?> >Lésbica</option>
<option value="2" <?php echo $info['orient']=='3'?'selected':'';?> >Bissexual</option>
<option value="3" <?php echo $info['orient']=='4'?'selected':'';?> >Curioso</option>
</select><br/><br/>
Relacionamento:<br/><select name="relac">
<option value="1">Solteiro(a)</option>
<option value="2" <?php echo $info['relac']=='2'?'selected':'';?> >Casado(a)</option>
<option value="3" <?php echo $info['relac']=='3'?'selected':'';?> >Namorando</option>
<option value="4" <?php echo $info['relac']=='4'?'selected':'';?> >Relacionamento Aberto</option>
<option value="5" <?php echo $info['relac']=='5'?'selected':'';?> >Casamento Aberto</option></select><br/><br/>
<input type="submit" value="Atualizar">
</form><br/>
<form action="/configuracoes/editarfoto/<?php echo $id;?>" method="post" enctype="multipart/form-data">
<?php echo $info['ft']==false?'Inserir':'Alterar';?> foto:<br/>
<input type="file" name="img"><br/>
<input type="submit" value="<?php echo $info['ft']==false?'Inserir':'Alterar';?>">
</form>
<form action="/configuracoes/musicaperfil/<?php echo $id;?>" method="post" enctype="multipart/form-data">
<?php echo $info['music']==false?'Inserir':'Alterar';?> música:<br/>
<input type="file" name="musica"><br/>
<input type="submit" value="<?php echo $info['music']==false?'Inserir':'Alterar';?>">
</form>
<?php 
} else { 
?>
Este perfil não é seu<br/>
<?php 
} 
} else if($a=='editarperfil2') { ativo($meuid,'Editando perfil ');
if($id==$meuid or permdono($meuid)) { ?>
<br/><div align="center">
<?php
if($_POST['nome']=='' or strripos($_POST['nome'],'href') == true) { echo $imgerro;?>
Insira seu nome<br/>
<?php } else if (strlen($_POST['nome'])<4) { echo $imgerro;?>
Insira no mínimo quatro caracteres em seu nome<br/>
<?php } else {
if(strripos($_POST['quem'],'href') == true||isdigitf($_POST['cidade'])||isdigitf($_POST['estado'])||isdigitf($_POST['sbnome'])){ 
echo $imgerro;?>
Caracteres invalidos no sobre nome , cidade, estado ou quem sou!
<br/>
<?php  
}else{
if(isspam($_POST['nome'],$meuid)) {
$mistake->exec("UPDATE w_usuarios SET bchat4='5' WHERE id='".$meuid."'");  
$res = $mistake->prepare("INSERT INTO Mmistake_logs (texto,meuid,para,acao,data) VALUES (?,?,?,?,?)");
$arrayName = array($_POST['nome'],$meuid,0,'nick',time());
$ii = 0;
for($i=1; $i <=5; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
}else{
$filename = "".$_SERVER["DOCUMENT_ROOT"]."/temp/".$im[14].".gif";
if (file_exists($filename)) {
unlink($filename);
}    
$nasc = $_POST['dtnascimento3'].'-'.$_POST['dtnascimento2'].'-'.$_POST['dtnascimento'];
$res = $mistake->prepare("UPDATE w_usuarios SET relac=:relac,orient=:orient,qm=:qm,cid=:cid,est=:est,sx=:sx,nm=:nm,sbn=:sbn,nasc=:nasc,num_ativ=:num_ativ WHERE id=:id");
$res->execute(array(":id"=>$id,":relac"=>$_POST['relac'],":orient"=>$_POST['orient'],":qm"=>anti_injection($_POST['quem']),":cid"=>$_POST['cidade'],":est"=>$_POST['estado'],":sx"=>$_POST['sexo'],":nm"=>mb_htmlentities($_POST['nome']),":sbn"=>$_POST['sbnome'],":nasc"=>$nasc,":num_ativ"=>0));
if($res) { 
echo $imgok;?>
Perfil editado com sucesso!<br/>
<?php } else { echo $imgerro;?>
Erro ao editar perfil!<br/>
<?php } }}} } else { ?>
Este perfil não é seu<br/>
<?php 
} 
}else 
if($a=='editarfoto') { 
ativo($meuid,'Alterando foto do perfil '); 
?>
<br/><div align="center">
<?php
if(perm($meuid)==3 or perm($meuid)==4 or $meuid == $_GET['id']){
$pasta ="fotoperfil/";
$arquivo = isset($_FILES["img"]) ? $_FILES["img"] : FALSE;
if(!preg_match("/^image\/(jpg|jpeg|png|gif|webp)$/", $arquivo["type"])){
echo $imgerro;?>A foto está com formato desconhecido A imagem deve ser (jpg|jpeg|png|gif|webp)!<br><br>
<?php 
}else{
$tf = $mistake->query("SELECT ft FROM w_usuarios WHERE id='$id'")->fetch();
if(stristr($tf[0],'fotoperfil') == true){
@unlink($tf[0]);
@unlink(str_replace('m_','',$tf[0]));
}
preg_match("/.(gif|png|jpg|jpeg|webp){1}$/i", $arquivo["name"], $ext);
$imagem_nome = "By-Nandosp-".time()."-".$meuid.".".$ext[1]."";
if($arquivo["type"]=='image/webp'){
move_uploaded_file($arquivo["tmp_name"],"./fotoperfil/m_".$imagem_nome); 
copy("./fotoperfil/m_".$imagem_nome,"./fotoperfil/".$imagem_nome);
}else{
if($arquivo["type"]=='image/gif'){
//system("convert ".escapeshellarg($arquivo["tmp_name"])." -coalesce  -sample 300x300  ".escapeshellarg("./fotoperfil/".$imagem_nome)."");  
//exec("gif2webp -q 85 ".escapeshellarg($arquivo["tmp_name"])." -o ".escapeshellarg("./fotoperfil/".$imagem_nome)."");
//system("convert ".escapeshellarg($arquivo["tmp_name"])." -coalesce  -sample 200x200  ".escapeshellarg("./fotoperfil/m_".$imagem_nome)."");
//exec("gifsicle --scale 0.5 -i ".escapeshellarg($arquivo["tmp_name"])." > ".escapeshellarg("./fotoperfil/m_".$imagem_nome)."");
//exec("gifsicle --resize 150x150 ".escapeshellarg($arquivo["tmp_name"])." > ".escapeshellarg("./fotoperfil/m_".$imagem_nome)."");
move_uploaded_file($_FILES['img']['tmp_name'],$pasta.$imagem_nome);
}else{
//exec("montage -geometry +0+0 -background \"".$testearray[2]."\" -label \"".$_SERVER['SERVER_NAME']."\" ".escapeshellarg($arquivo["tmp_name"])." ".escapeshellarg("./fotoperfil/".$imagem_nome)."");
//exec("cwebp -q 85 ".escapeshellarg("./fotoperfil/".$imagem_nome)." -o ".escapeshellarg("./fotoperfil/".$imagem_nome)."");
//exec("cwebp -q 85 -resize 150 150 ".escapeshellarg($arquivo["tmp_name"])." -o ".escapeshellarg("./fotoperfil/m_".$imagem_nome)."");
//system("convert ".escapeshellarg($arquivo["tmp_name"])." -coalesce  -sample 200x200  ".escapeshellarg("./fotoperfil/m_".$imagem_nome)."");
move_uploaded_file($_FILES['img']['tmp_name'],$pasta.$imagem_nome);
}
}
$res = $mistake->exec("UPDATE w_usuarios SET ft='fotoperfil/$imagem_nome' WHERE id='$id'");
}
if($res){
header("Location:/configuracoes/foto_perfil/".$meuid."");
echo $imgok;?>Foto adicionada com sucesso!<br><?php 
}else{
header("Location:/configuracoes/foto_perfil/".$meuid."");
echo $imgerro;?>Erro ao alterar foto do perfil!<br><br><?php 
}
}else{
header("Location:/configuracoes/foto_perfil/".$meuid."");
echo $imgerro;?>Esse perfil não é seu!<br><br><?php    
}
}  else 
if($a=='senhapainel2') { 
?>
<br/><div id="titulo"><b>Alterar senha de painel</b></div><br/><div align="center">
<?php
if(strlen($_POST['senhaa'])<4 or strlen($_POST['senhaa'])>15) { 
echo $imgerro;?>
Senha deve ter entre 4 e 15 caracteres!<br/>
<?php 
} else {
$res = $mistake->exec("UPDATE w_usuarios SET senhaequipe='".$_POST['senhaa']."' WHERE id='$meuid'");
if($res) { echo $imgok;?>
A senha de painel foi alterada com sucesso!<br/>
<?php 
} else { 
echo $imgerro;?>Erro ao atualizar senha!<br/>
<?php 
}
}
} else
if($a=='senhapainel') { ativo($meuid,'Alterando senha de painel');
?>
<br/><div id="titulo"><b>Alterar senha de painel</b></div><br/>
<form action="/configuracoes/senhapainel2" method="post">
Nova senha: <input type="password" name="senhaa" maxlength="15"><br/>
<input type="submit" value="Alterar">
</form>
<?php } else if($a=='loginsenha') { ativo($meuid,'Alterando login e senha ');
$nome = $mistake->query("SELECT lg,sh FROM w_usuarios WHERE id='$meuid'")->fetch();
?>
<br/><div id="titulo"><b>Alterar login e senha</b></div><br/>
<form action="/configuracoes/loginsenha2" method="post">
Login:<br/><input name="login" maxlength="15" value="<?php echo $nome[0];?>"><br/>
<input type="hidden" name="senha" value="<?php echo $nome[1];?>" readonly><br/>
Nova senha: <br/><input type="password" name="senhaa" maxlength="15"><br/>
Confirme a nova senha: <input type="password" name="senhaaa" maxlength="15"><br/><br/>
<input type="submit" value="Alterar">
</form>
<?php } else if($a=='loginsenha2') {
$_POST['login'] = preg_replace("/[^a-zA-Z0-9.]/", "", $_POST['login']);
ativo($meuid,'Alterando login e senha '); ?>
<br/><div align="center">
<?php
$senhat = $mistake->query("SELECT COUNT(*) FROM w_usuarios WHERE sh='".$_POST['senha']."'")->fetch();
$log = $mistake->query("SELECT COUNT(*) FROM w_usuarios WHERE lg='".$_POST['login']."' and id!='$meuid'")->fetch();
if($senhat[0]==0) { echo $imgerro;?>
Sua senha atual está incorreta!<br/>
<?php } else if ($log[0]>0) { echo $imgerro;?>
Já existe um usuário usando o login <b><?php echo $_POST['login'];?></b><br/>
<?php } else if ($_POST['senhaa']!=$_POST['senhaaa']) { echo $imgerro;?>
Sua nova senha e a confirmação de nova senha nao combinam!<br/>
<?php } else if(strlen($_POST['senhaa'])<4 or strlen($_POST['senhaa'])>15) { echo $imgerro;?>
Sua senha deve ter entre 4 e 15 caracteres!<br/>
<?php } else if(strlen($_POST['login'])<4 or strlen($_POST['login'])>15) { echo $imgerro;?>
Seu login deve ter entre 4 e 15 caracteres!<br/>
<?php } else 
if(isdigitf($_POST['login'])){ 
echo $imgerro;?>
Caracteres invalidos no login!
<br/>
<?php  
}else{    
$login = file_exists("".$_POST['login'].".php") ? mb_strtoupper($_POST['login']) : $_POST['login'];
$res = $mistake->exec("UPDATE w_usuarios SET sh='".md5($_POST['senhaa'])."', lg='".$login."' WHERE id='$meuid'");
if($res) { echo $imgok;?>
Seu login e senha foram alterados com sucesso!<br/>
<?php } else { echo $imgerro;?>
Erro ao atualizar login e senha!<br/>
<?php } } } else if($a=='catemocoes') { ?>
<br/><div id="titulo"><b>Categoria de Emoções</b></div><br/><div style='text-align:center'><b>Busca de smile</b>
<form action='/configuracoes' method='GET'><input type='hidden' class='bt3' name='a' value='buscaemocoes' />
<input type='text' class='bt3' name='id' placeholder='Digite um Texto'/><input type='submit' class='bt3' value='Buscar'></form></div><br/>
<?php
$contemo = $mistake->query("SELECT COUNT(*) FROM w_emo_cat WHERE venda='0'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contemo[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->query("SELECT id, nm FROM w_emo_cat WHERE venda='0' ORDER BY nm asc LIMIT $limit, $itensporpag");
$i=0; while($item = $itens->fetch(PDO::FETCH_OBJ)) {
?>
<div id="<?php echo $i%2==0?'div1':'div1';?>">
<?php
$contemo2 = $mistake->query("SELECT COUNT(*) FROM w_emocoes where cat='".$item->id."'")->fetch(); ?>
<a href="/configuracoes/emocoes/<?php echo $item->id;?>"><?php echo $item->nm;?>(<?php echo $contemo2[0];?>)</a><br/>
</div><?php $i++; 
} 
if($numpag>1) {
paginas('configuracoes',$a,$numpag,$id,$pag);
}
}else{
?>
<div align="center">Não existem categorias de emoçoes!<br/>
<?php    
}
}else 
if($a=='buscaemocoes') { 
$query="SELECT COUNT(*) FROM w_emocoes WHERE cod LIKE :cod";
$stmt= $mistake->prepare($query);
$stmt->execute(array(":cod" => "%".$id."%"));
$num = $stmt->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $num[0];
$itensporpag = 8;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
?>
<br/><div id="titulo"><b>Busca de Emoções <?php echo $id;?> encontarados <?php echo $numitens;?></b></div><br/><div style='text-align:center'><b>Busca de smile</b>
<form action='/configuracoes' method='GET'><input type='hidden' class='bt3' name='a' value='buscaemocoes' />
<input type='text' class='bt3' name='id' placeholder='Digite um Texto'/><input type='submit' class='bt3' value='Buscar'></form></div><br/>
<?php
if($num[0]>0){
$sql = "SELECT * FROM w_emocoes WHERE cod LIKE :cod ORDER BY cod LIMIT $limit, $itensporpag";
$items = $mistake->prepare($sql);
$items->execute(array(":cod" => "%".$id."%"));
$i = 0;
while ($item = $items->fetch(PDO::FETCH_OBJ)){
?>
<div id="<?php echo $i%2==0?'div1':'div1';?>">
<img src="/e/<?php echo $item->id;?>.<?php echo $item->ext;?>" class="smilies" oncontextmenu='return false' onselectstart='return false' ondragstart='return false'><br><? if(perm($meuid)>0){?><a href="/mod/emocoes/<?php echo $id;?>/<?php echo $pag;?>/<?php echo $item->id;?>"><font color="red">[apagar]</font></a> 
<a href="/mod/edit_emocao/<?php echo $item->id;?>"><font color="red">[editar]</font></a><br><?}?><b>Codigo :</b> <?php echo $item->cod;?></div>
<?php
$i++;
}
if($numpag>1) { 
paginas('configuracoes',$a,$numpag,$id,$pag);     
}
}else{
echo "<p align='center'>";
echo $imgerro;?>Erro nada encontrado!<br><?php 
echo "</p>";
}
}else
if($a=='emocoes') { 
ativo($meuid,'Vendo emoções '); 
?>
<br/><div id="titulo"><b>Emoções</b></div><br/>
<?php 
$contemo = $mistake->query("SELECT COUNT(*) FROM w_emocoes where cat='$id'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contemo[0];
$itensporpag = 8;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->query("SELECT id,cod,ext FROM w_emocoes where cat='$id' ORDER BY cod LIMIT $limit, $itensporpag");	
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div1';?>">
<img src="/e/<?php echo $item->id;?>.<?php echo $item->ext;?>" class="smilies" oncontextmenu='return false' onselectstart='return false' ondragstart='return false'><br><? if(perm($meuid)>0){?><a href="/mod/emocoes/<?php echo $id;?>/<?php echo $pag;?>/<?php echo $item->id;?>"><font color="red">[apagar]</font></a> 
<a href="/mod/edit_emocao/<?php echo $item->id;?>"><font color="red">[editar]</font></a><br><?}?><b>Codigo :</b> <?php echo $item->cod;?></div>
<?php $i++; } 
if($numpag>1) { 
paginas('configuracoes',$a,$numpag,$id,$pag);     
} } else { ?>
<div align="center">Não existem emoções nesta categoria!</div>
<?php 
} 
$tipo = $_POST["cate"];
$smile = trim($_POST["smile"]);
if(!empty($smile)){
if(perm($meuid)<1){
echo $imgerro;?>Você não é da equipe<br><?php
}else{    
if (strpos($smile,".")=== false) {
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
$arquivo = isset($_FILES["foto"]) ? $_FILES["foto"] : FALSE;
$config["tamanho"] = 5000000;
$config["largura"] = 800;
$config["altura"]  = 800;
if($arquivo){ 
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
$resok = $mistake->lastInsertId();
$imagem_dir = "e/".$resok.".".$ext[1]."";
if($tamanhos["mime"]=='image/webp'){
move_uploaded_file($arquivo["tmp_name"],$imagem_dir);    
}else{
if($tamanhos["mime"]=='image/gif'){
//exec("gif2webp -q 85 ".escapeshellarg($arquivo["tmp_name"])." -o ".escapeshellarg($imagem_dir)."");
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
if(perm($meuid)>0){
?>
<br><form action="/configuracoes/emocoes/<?php echo $id;?>/<?php echo $pag;?>" method="post" enctype="multipart/form-data">
Smile: <input type="text" class="bt3" name="smile" /><br>
Arquivo:
<input id='input-file' name='foto' type='file' value=''><br>
<input type="hidden" name="cate" value="<?php echo $id;?>" readonly>
<input type="submit" class="bt3" value="Adicionar smile">
</form><br>
<?
}
?>
<div align="center"><a href="/configuracoes/catemocoes"><?php echo $imgsetavoltar;?>Voltar Emoções</a></div>
<?
} else 
if($a=='meusemocoes') { 
ativo($meuid,'Vendo emoções '); 
?>
<br/><div id="titulo"><b>Emoções</b></div><br/>
<?php 
$contemo = $mistake->query("SELECT COUNT(*) FROM w_emocoes where cat='0' and uid='".$id."'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contemo[0];
$itensporpag = 8;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->query("SELECT id,cod,ext FROM w_emocoes where cat='0' and uid='".$id."' ORDER BY cod LIMIT $limit, $itensporpag");
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div1';?>">
<img src="/e/<?php echo $item->id;?>.<?php echo $item->ext;?>" class="smilies" oncontextmenu='return false' onselectstart='return false' ondragstart='return false'><br><? if(perm($meuid)>0){?><a href="/mod/emocoes/<?php echo $id;?>/<?php echo $pag;?>/<?php echo $item->id;?>"><font color="red">[apagar]</font></a> 
<a href="/mod/edit_emocao/<?php echo $item->id;?>"><font color="red">[editar]</font></a><br><?}?><b>Codigo :</b> <?php echo $item->cod;?></div>
<?php $i++; } 
if($numpag>1) { 
paginas('configuracoes',$a,$numpag,$id,$pag);     
} } else { ?>
<div align="center"><?php echo $imgerro;?>Não existem emoções para este usuario!</div>
<?php 
} 
?>
<br/><div align="center"><a href="/configuracoes/catemocoes"><?php echo $imgsetavoltar;?> Voltar Emoções</a></div>
<?
}else
if($a=='dicas') {
ativo($meuid,'Vendo dicas de formatação ');
$cm = $mistake->query("SELECT id, comu_nm FROM w_comu order by id desc")->fetch();
$tpc = $mistake->query("SELECT id, nm FROM w_topicos order by id desc limit 1")->fetch();
$album = $mistake->query("SELECT id, nm FROM w_albuns order by id desc limit 1")->fetch();
$enq = $mistake->query("SELECT id, perg FROM w_enquetes order by id desc limit 1")->fetch();
?>
<br/><div id="titulo"><b>Dicas de formatação</b></div><br/>
Veja abaixo dicas de como formatar seu texto<br/><br/><br/>
[b]Texto[/b] = <b>Texto</b><hr>
[i]Texto[/i] = <i>Texto</i><hr>
[u]Texto[/u] = <u>Texto</u><hr>
[big]Texto[/big] = <big>Texto</big><hr>
Quebra de linha simples [br/]<hr>
[paginas=1]seu texto[/paginas]<hr>
Quebra de linha dupla [br2/]<hr>
Link = [link=http://<?php site_url();?>]<?php nome_site();?>[/link] = <a href="http://<?php site_url();?>"><?php nome_site();?></a><br/>este bbcode se aplica a todos links do site ex:<br/>[link=/gato]Gato e Gata[/link]<hr>
Comunidade = [cm=<?php echo $cm[0];?>]<?php echo $cm[1];?>[/cm] = <a href="/comunidades?a=cmn&id=<?php echo $cm[0];?>"><?php echo $cm[1];?></a><hr>
Tópico = [topico=<?php echo $tpc[0];?>]<?php echo $tpc[1];?>[/topico] = <a href="/forum/topico/<?php echo $tpc[0];?>"><?php echo $tpc[1];?></a><hr>
Álbum = [album=<?php echo $album[0];?>]<?php echo $album[1];?>[/album] = <a href="/galeria/album/<?php echo $album[0];?>"><?php echo $album[1];?></a><hr>
Enquete = [enquete=<?php echo $enq[0];?>]<?php echo $enq[1];?>[/enquete] = <a href="/enquete?a=ver&id=<?php echo $enq[0];?>"><?php echo $enq[1];?></a><hr>
Ache a Bolinha = [bolinha]Texto Aqui[/bolinha] = <a href="/bolinha?">Texto Aqui</a><br/><br/>
A mesma forma aplicada no atalho ache a bolinha, se aplica aos demais:<br/>
dado, penaltis, banco, bbb, calculadora, cassino, forca, libertadores, loja, noticias, novelas, quiz, wapet, futaovivo, loteria, f1, meutime, ppt, cavalos e fazenda<hr>
Cores = [cor=vermelho]seu texto aqui[/cor] = <div style="color:red"><b>seu texto aqui</b></div>As cores diponivéis são: vermelho, amarelo, azul, cinza, rosa, verde, laranja, roxo, marron, magenta, limao e aqua.
<br/><br/>Cor com código html:<br/>[cor=FF0000]seu texto aqui[/cor] = <div style="color:red"><b>seu texto aqui</b></div><hr>
Texto para a direita:<br/>[direita]texto para a direita[/direita] = <marquee direction="right">texto para a direita</marquee><hr>Texto para a esquerda:<br/>[esquerda]texto para a esquerda[/esquerda] = <marquee direction="left">texto para a esquerda</marquee><hr>Texto pulando:<br/>[pular]texto pulando[/pular] = <marquee direction='down'><marquee behavior='alternate'>texto pulando</marquee></marquee><hr>Texto subindo:<br/>[subir]texto subindo[/subir] = <marquee direction="up">texto subindo</marquee><hr>Texto descendo:<br/>[descer]texto descendo[/descer] = <marquee direction="down">texto descendo</marquee><hr>
[centro]texto centralizado[/centro]<div style="text-align:center">texto no centro</div><hr>
[esq]texto a esquerda[/esq]<div style="text-align:left">texto a esquerda</div><hr>
[dir]texto a direita[/dir]<div style="text-align:right">texto a direita</div><hr>
[piscar]texto piscando[/piscar]<blink>texto piscando</blink><br/><br/>
<?php }
if($a) { ?>
<br/><div align="center"><a href="/configuracoes?"><?php echo $imgpreferencias;?>Painel do usuário</a><br> <?php } ?>
<div class="col-12 text-center" style="margin-top: 20px"><a class="badge badge-secondary" href="javascript:window.history.back();"><?php echo $imgsetavoltar;?> Voltar</a></div><br/>
<?php
echo rodape();?>
</body>
</html>