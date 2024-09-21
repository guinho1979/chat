<?php
if(basename($_SERVER["PHP_SELF"])==basename(__FILE__)){
exit("<script>alert('Não Permitido')</script>\n<script>window.location=('/')</script>");
}
echo '<body data-turbolinks="false">';
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
if($info['id']==true){
ativo($meuid,'Vendo perfil de '.$info['nm'].'');
ubloq($meuid,$info['id'],$imginicio);
$foto = $info['ft']==true ? $info['ft'] : 'semfoto.jpg';
?>
<script>document.title = '<?php echo html_entity_decode($info['nm']);?> - <?php echo ucfirst($_SERVER['USER']);?>';document.querySelector('link[rel="icon"]').setAttribute('href','/<?php echo $foto;?>');document.querySelector('meta[name="theme-color"]').setAttribute('content','<?php echo $info['fundo'];?>');</script>
<style>#fundo{background-image: url(/<?php echo $info['fundo_bg'];?>);background-size:contain;background-repeat: round;border-radius: 5px;}.fundo{min-width: 100%;min-height: 100%;position: relative}.mistakep {background-image: linear-gradient(to bottom,#E0E0E0,#F9F9F9 70%);border: 1px solid #CCCCCE;border-radius: 3px;box-shadow: 0 3px 0 rgba(0,0,0,.3), 0 2px 7px rgba(0,0,0,0.2);color: #616165;display: block;font: bold 13px/25px "Trebuchet MS";text-align: center;text-decoration: none;text-shadow: 1px 1px 0 #FFF;padding: 5px 10px;position: relative;width: 80px;}body {background:<?php echo $info['fundo'];?>;}#rodape,#titulo{background:<?php echo $info['fundo'];?>;color:<?php echo $info['texto'];?>}</style>
<div id="titulo" align="left"><b>
Perfil de <?php echo gerarnome($info['id']);?>
</b></div>
<?php 
if($info['music']==true){
?>
<div align="center"><audio id="id022" controls controlslist="nodownload" src="<?php echo $info['music'];?>"></audio></div>
<?php
}
if($info['video']==true){
?>
<style>
.Mmistake-modal{z-index:3;display:none;padding-top:100px;position:fixed;left:0;top:0;width:100%;height:100%;overflow:auto;background-color:rgba(0,0,0,0.4)}
.Mmistake-modal-content{border-radius: 5px;margin:auto;background-color:#fff;position:relative;padding:0;outline:0;}
.Mmistake-teal,.Mmistake-hover-teal:hover{border-radius: 5px;color:<?php echo $info['texto'];?>!important;background-color:<?php echo $info['fundo'];?>!important}
.Mmistake-display-topright{position:absolute;right:0;top:0}.Mmistake-container{padding:0.01em 16px}
.Mmistake-button {border-radius: 5px;display: inline-block;padding: 8px 16px;vertical-align: middle;overflow: hidden;text-decoration: none;color: inherit;background-color: inherit;text-align: center;cursor: pointer;white-space: nowrap;}
@media (max-width:600px){.Mmistake-modal-content{margin:0 10px;width:auto!important}.Mmistake-modal{padding-top:30px}}
@media (max-width:768px){.Mmistake-modal-content{width:500px}.Mmistake-modal{padding-top:50px}}
@media (min-width:993px){.Mmistake-modal-content{width:600px}}.modal-footer {border-top: #eee solid 1px;text-align: right;}
</style>
<div id="id01" class="Mmistake-modal">
<div class="Mmistake-modal-content">
<header class="Mmistake-container Mmistake-teal"> 
<span onclick="document.getElementById('id01').style.display='none';" class="Mmistake-button Mmistake-display-topright">&times;</span>
<h2>Vídeo do perfil</h2>
</header>
<div class="Mmistake-container">
<p id="playdown">Perfil com vídeo se deseja assiti-lo clique em assitir...</p>
</div>
<footer class="Mmistake-container Mmistake-teal">
<p><?php echo $info['nm'];?></p>
<div class="modal-footer">
<button id="image_id" onclick="document.getElementById('id02').pause();" class="btn">Assitir!</button>
</div>
</footer>
</div>
</div>
<script>
setTimeout(function(){ document.getElementById('id01').style.display = 'block'; },7000);
$('#image_id').click(function() {
document.getElementById('playdown').innerHTML='<?php echo $info['video'];?>';
document.getElementById('image_id').innerHTML='By Nandosp';
});
$('.Mmistake-button').click(function(){
if(document.getElementById('misframe') !== null){ 
$('#misframe')[0].contentWindow.postMessage('{"event":"command","func":"' + 'stopVideo' + '","args":""}', '*');
}
if(document.getElementById('misvideo') !== null){ 
document.getElementById('misvideo').pause();
}
document.getElementById('id02').play();
});
</script>
<?
}
if($info['id']==$meuid || $info['ppri']==0 || contamigos($meuid, $info['id'])==true || perm($meuid)>0) { 
if($info['fundo_bg']==true or $testearray[55]==true){
$linha1 = '';
$linha2 = ''; 
}else{
$linha1 = ''.$info['linha1'].'';
$linha2 = ''.$info['linha2'].'';    
}
if($info['visi']==1 and $im['visi']==1 and $meuid!=$info['id']){
$arq = $mistake->prepare("SELECT uid FROM w_visitas WHERE aid='".$info['id']."' AND uid='".$meuid."' ORDER BY hr DESC");
$arq->execute();
$arq = $arq->fetch(); 
if($arq[0]==TRUE){
$mistake->exec("UPDATE w_visitas SET hr='".time()."' WHERE uid='".$arq[0]."' AND aid='".$info['id']."'");
}else{
$mistake->exec("INSERT INTO w_visitas SET aid='".$info['id']."',uid='".$meuid."',hr='".time()."'");
}
}
$pres = $mistake->prepare("SELECT COUNT(*) FROM w_loja_cc WHERE aid='".$info['id']."'");
$pres->execute();
$pres = $pres->fetch();
$amigos = $mistake->prepare("SELECT COUNT(*) FROM w_amigos WHERE (tid='".$info['id']."' or uid='".$info['id']."') AND ac='1'");
$amigos->execute();
$amigos = $amigos->fetch();
$acoes = $mistake->prepare("SELECT COUNT(*) FROM w_acoes WHERE para='".$info['id']."'");
$acoes->execute();
$acoes = $acoes->fetch();
$fas = $mistake->prepare("SELECT COUNT(*) FROM w_fas WHERE uid='".$info['id']."'");
$fas->execute();
$fas = $fas->fetch();
$rec = $mistake->prepare("SELECT COUNT(*) FROM w_recados WHERE pr='".$info['id']."'");
$rec->execute();
$rec = $rec->fetch();
$ign = $mistake->prepare("SELECT COUNT(*) FROM w_ubloq WHERE uid='".$meuid."' and aid='".$info['id']."'");
$ign->execute();
$ign = $ign->fetch();
$albuns = $mistake->prepare("SELECT COUNT(*) FROM w_albuns WHERE dn='".$info['id']."'");
$albuns->execute();
$albuns = $albuns->fetch();
$visitas = $mistake->prepare("SELECT COUNT(*) FROM w_visitas WHERE aid='".$info['id']."'");
$visitas->execute();
$visitas = $visitas->fetch();
$visitar = $mistake->prepare("SELECT COUNT(*) FROM w_visitas WHERE uid='".$info['id']."'");
$visitar->execute();
$visitar = $visitar->fetch();
$namoro = $mistake->prepare("SELECT COUNT(*) FROM w_igreja WHERE (uid='".$info['id']."' or aid='".$info['id']."') and s='1'");
$namoro->execute();
$namoro = $namoro->fetch();
$vou = $mistake->prepare("SELECT COUNT(*) FROM w_vounaovou WHERE aid='".$info['id']."' and e='1'");
$vou->execute();
$vou = $vou->fetch();
$naovou = $mistake->prepare("SELECT COUNT(*) FROM w_vounaovou WHERE aid='".$info['id']."' and e='0'");
$naovou->execute();
$naovou = $naovou->fetch();
if($info['orient']==0){
$or='Heterossexual';
}else if($info['orient']==1){
$or='Homossexual';
}else if($info['orient']==4){
$or='Lésbica';
}else if($info['orient']==2){
$or='Bissexual';
}else{
$or='Curioso';
}
?>
<div align="center">
<img alt="foto" id="profile-img" class="profile-img" src="/<?php echo $foto;?>" oncontextmenu="return false" onselectstart="return false" ondragstart="return false" style="width:136px;height:156px;border-radius:50%; margin:1px; border:2px solid #FFF;" pbsrc="/<?php echo str_replace('m_','',$foto);?>" class="PopBoxImageSmall" title='<?php echo $info['nm'];?>' onclick="Pop(this,50,'PopBoxPopImage');" />
<br/>

<?php echo gerarnome($info['id']);?><br/>
<?
if($info['tm']==true){  
?>
<tr><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha2; ?>">Torcedor do: <a href="/entretenimento/apptime"><img src='/times/<?php echo $info['tm'];?>.gif' width='50px' height='50px'></a></td></tr>
<?
}
?>
<br/>
<a href="/perfil_e?id=<?php echo $info['id'];?>" style="color:<?php echo $info['links'];?>;"><b> Opções usuários</a></b><br/>
<br/><?php echo $cpi[0];?></font><br/>
<?php } if($meuid!=$info['id'] && $info['vvnv']==1) { 
?>
<a href="/jogovelha/convite/<?php echo $info['id'];?>">Jogo da velha</a><br/>
<a href="/mensagens1/lermsg/<?php echo $info['id'];?>" style="color:<?php echo $info['links'];?>;">Enviar mensagem</a><br/>
<a href="/bd/perfilbd?id=<?php echo $info['id'];?>&e=vou"><font color="#006600"><strong><img src="/style/curtir.png"></strong></font></a>&emsp;<a href="/bd/perfilbd?id=<?php echo $info['id'];?>&e=naovou"><font color="#ff0000"><strong><img src="/style/curtirnao.png"></strong></font></a>
<?php } if($info['vvnv']==1) { ?>
<font color="<?php echo $info['texto'];?>"><br/><font color="#006600">Curtiu: <strong><?php echo $vou[0];?></strong></font> - <font color="#ff0000">Não curtiu: <strong><?php echo $naovou[0];?></strong></font><br/>

<b>Procura por:</b> <?php echo $info['qm'];?><br/>
<tr><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha1; ?>">Id: <b><?php echo $info['id'];?></b><br/>
<tr><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha1; ?>">Status: <b><?php echo status($info['id']);?></b>&nbsp;&nbsp;<br/>
<tr><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha2; ?>">Pontos: <b><?php echo $info['pt'];?></b><br/>
<tr><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha1; ?>"><img src="/style/moedas.png" width="12" height="15" />Moedas: <b><?php echo $info['moedas'];?></b> / Atividades: <b><?php echo $info['atividades'];?></b><br/>
<tr><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha1; ?>">Idade/Sexo: <b>
<?php echo idade($info['nasc']);?>/<?php echo sexo($info['id'])=='F'?'Feminino':'Masculino';?></b></td></tr><br/>
<tr><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha1; ?>">Relacionamento: <b><?php echo relac($info['id']);?></b><br/>
<?php if($namoro[0]==0) { ?>
<tr><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha2; ?>">Relacionamento no site: <b>Solteiro(a)</b><br/>
<?php 
} else { 
$nmr = $mistake->prepare("SELECT uid, aid FROM w_igreja WHERE uid='".$info['id']."' or aid='".$info['id']."' and s='1'");
$nmr->execute();
$nmr = $nmr->fetch();
$nam=$nmr[0]==$info['id']?$nmr[1]:$nmr[0];
$sexooo = sexo($info['id'])=='M'?'o':'a';
if($info['relacaotipo']=='1') {
$nome_ralacao = 'Casad'.$sexooo.' no site com';
}else if($info['relacaotipo']=='2') {
$nome_ralacao = 'Namorando no site com';
}else if($info['relacaotipo']=='3') {
$nome_ralacao = 'Está ficando no site com';
}else if($info['relacaotipo']=='4') {
$nome_ralacao = 'Está enrolado no site com';
}else if($info['relacaotipo']=='5') {
$nome_ralacao = 'Está em relacionamento aberto com';
}else{
$nome_ralacao = 'Namorando no site com';
}
?>
<tr><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha2; ?>"><?php echo $nome_ralacao;?>: <a href="/<?php echo gerarlogin($nam);?>"><?php echo gerarnome($nam);?></a><br/>
<?php } ?>
<a href="/pokemon/meus/<?php echo $info['id'];?>" style="color:<?php echo $info['links'];?>;">Meus Pokemons</a><br/>
<a href="/walking/menu/<?php echo $info['id'];?>" style="color:<?php echo $info['links'];?>;">Zumbis</a><br/>
<a href="/lojas?a=presentes&id=<?php echo $info['id'];?>" style="color:<?php echo $info['links'];?>;">Presentes recebidos (<?php echo $pres[0];?>)</a><br/>
<?php
$mimos = $mistake->prepare("SELECT COUNT(*) FROM compra_mimos WHERE who='".$info['id']."'");
$mimos->execute();
$mimos = $mimos->fetch();
if($mimos[0]>0){?>
<a href="/mimos/meus/<?php echo $info['id'];?>"  style="color:<?php echo $info['links'];?>;">Mimos (<?php echo $mimos[0];?>)</a><br/><br/>
<?php
}
?>
<?
###
$ativo = time() - $testearray[18];
$itens = $mistake->query("SELECT a.id, b.uid, b.tid, a.cid, a.est, a.onlf,a.ft,a.ativo FROM w_usuarios a INNER JOIN w_amigos b WHERE ((a.id=b.uid AND b.tid='".$info['id']."') OR (a.id=b.tid AND uid='".$info['id']."')) AND b.ac='1' AND a.id<>'$info[id]' and a.inativo>'$ativo' and a.vs='0' ORDER BY a.inativo DESC LIMIT 0, 5");
if($itens->rowCount()>0)
{
?><table cellspacing="1" cellpadding="3" width="100%">
<tr><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha2; ?>" align="center"><b><?php echo $imgplus;?>AMIGOS ATIVOS</b><td></tr><br/><tr><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha1; ?>" align="center"><?
while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<a href="/<?php echo gerarlogin($item->id);?>"> <?php echo gerarfoto($item->id,40,40);?></a>
<?php 
$i++; 
}
?><td></tr></table>
<?
}
?>
<b>Último login:</b> <?php echo date("d/m/Y - H:i:s",$info['ultimologin']);?><br/>
<?
if(perm($meuid)>0) { ?><br/><a href="/mod/editarusuario/<?php echo $info['id'];?>" style="color:<?php echo $info['links'];?>;">Opções da equipe</a><br/> <?php }
?>
<div class="col-12 text-center" style="margin-top: 20px"><a href="javascript:window.history.back();"><?php echo $imgsetavoltar;?> Voltar</a></div><br/>
<?php
rodape();
exit;
if($info['perm']==3 && $info['sx']=='M' && $info['mostrastatus']==0){
?>
<br/><img src="/style/donosite.gif?time=<?php echo time();?>" style="max-width:150px" oncontextmenu="return false" onselectstart="return false" ondragstart="return false"><br/><br />
<?php
}
if($info['perm']==3 && $info['sx']=='F' && $info['mostrastatus']==0){
?>
<br/><img src="/style/dona.gif?time=<?php echo time();?>" style="max-width:150px" oncontextmenu="return false" onselectstart="return false" ondragstart="return false"><br/><br />
<?php
}
if($info['perm']==4 && $info['mostrastatus']==0){
?>
<br/><img src="/style/programador.gif?time=<?php echo time();?>" style="max-width:150px" oncontextmenu="return false" onselectstart="return false" ondragstart="return false"><br/><br />
<?php
}
if($info['perm']==5){
?>
<br/><img src="/style/supervisora.gif?time=<?php echo time();?>" style="max-width:150px" oncontextmenu="return false" onselectstart="return false" ondragstart="return false"><br/><br />
<?php
}
if($info['perm']==6){
?>
<br/><img src="/style/subdono.gif?time=<?php echo time();?>" style="max-width:150px" oncontextmenu="return false" onselectstart="return false" ondragstart="return false"><br/><br />
<?php
}
if($info['perm']==7){
?>
<br/><img src="/style/administrator1.gif?time=<?php echo time();?>" style="max-width:150px" oncontextmenu="return false" onselectstart="return false" ondragstart="return false"><br/><br />
<?php
}
if($info['perm']==1){
?>
<br/><img src="/style/modera.gif?time=<?php echo time();?>" style="max-width:150px" oncontextmenu="return false" onselectstart="return false" ondragstart="return false"><br/><br />
<?php
}
if($info['perm']==2){
?>
<br/><img src="/style/master.gif" style="max-width:150px" oncontextmenu="return false" onselectstart="return false" ondragstart="return false"><br/><br />
<?php
}
if($info['vip']==1){
?>
<br/><img src="/style/vvip.gif?time=<?php echo time();?>" style="max-width:150px" oncontextmenu="return false" onselectstart="return false" ondragstart="return false"><br/><br />
<?php
}
if($info['vip']==2){
?>
<br/><img src="/style/divulgador.gif?time=<?php echo time();?>" style="max-width:150px" oncontextmenu="return false" onselectstart="return false" ondragstart="return false"><br/><br />
<?php
}
if($info['banido']==1){
?>
<br/><img src="/style/banned.gif?time=<?php echo time();?>" style="max-width:150px" oncontextmenu="return false" onselectstart="return false" ondragstart="return false"><br/><br />
<?php
}
if($info['perm']==0 && $info['vip']==false && $info['banido']==false){
?>
<br/><img src="/style/membro.gif?time=<?php echo time();?>" style="max-width:150px" oncontextmenu="return false" onselectstart="return false" ondragstart="return false"><br/><br />
<?php
}
if($testearray[52]==$info['id'] && $info['sx']=='M'){
?>
<br/><img src="/style/gatodomes.gif?time=<?php echo time();?>" style="max-width:150px" oncontextmenu="return false" onselectstart="return false" ondragstart="return false"><br/><br />
<?php
}
if($testearray[53]==$info['id'] && $info['sx']=='F'){
?>
<br/><img src="/style/gatadomes.gif?time=<?php echo time();?>" style="max-width:150px" oncontextmenu="return false" onselectstart="return false" ondragstart="return false"><br/><br />
<?php    
}
if((strlen($info['humor'])) > 0){
?>
<br/><img src="/style/humor/<?php echo $info['humor'];?>"><br/><br />
<?php
}
if($meuid!=$info['id']) {
?>
<a href="/doar_m?id=<?php echo $info['id'];?>" style="color:<?php echo $info['links'];?>;">Doar moedas</a><br/><br/>
<a href="/mensagens/lermsg/<?php echo $info['id'];?>" style="color:<?php echo $info['links'];?>;">Enviar mensagem</a><br/><br/>
<?php 
}
?>
<a href="/perfil_e?id=<?php echo $info['id'];?>" style="color:<?php echo $info['links'];?>;">Opções usuários</a>
<br/><br/><a href="/pergunte_me?a=perguntas&id=<?php echo $info['id'];?>"><div class="mistakep"><span style="color:<?php echo $info['links'];?>">Pergunte-me algo</span></div></a><br/>
<font color="<?php echo $info['texto'];?>">
<?php
if($info['banido']>0) { 
?>
<br/>Banido(a): <?php echo $info['razaoban'];?><br/>
<?php 
} 
$cpi = $mistake->prepare("SELECT rz FROM w_pontos where aid='".$info['id']."' order by id desc limit 1"); 
$cpi->execute();
$cpi = $cpi->fetch();
if($cpi) { 
?>
<br/><?php echo $cpi[0];?>
<?php 
} 
?>
</font><br/>
<?
if($meuid!=$info['id'] && $info['vvnv']==1) { 
?>
<br/>
<a href="/bd/perfilbd?id=<?php echo $info['id'];?>&e=vou"><font color="#006600"><strong><img src="/style/curtir.png"></strong></font></a>&emsp;<a href="/bd/perfilbd?id=<?php echo $info['id'];?>&e=naovou"><font color="#ff0000"><strong><img src="/style/curtirnao.png"></strong></font></a>
<?php } if($info['vvnv']==1) { ?>
<font color="<?php echo $info['texto'];?>"><br/><font color="#006600">Curtiu: <strong><?php echo $vou[0];?></strong></font> - <font color="#ff0000">Não curtiu: <strong><?php echo $naovou[0];?></strong></font>
<?php } ?>
</div><br/>
<?php
$pensamento = $mistake->prepare("SELECT id, rec, drec, para FROM w_mural WHERE tipo='4' AND drec='".$info['id']."' ORDER BY id DESC limit 1");
$pensamento->execute();
$pensamento = $pensamento->fetch();
if($pensamento[2]==true){
?>
<div align="center">
<font color="<?php echo $info['texto'];?>">Esta pensando em:<br /> <?php echo textot($pensamento[1],1,$on);?></font><br />
</div>
<br />
<?php
}
?>
<div align="center">
<?
for($i=1; $i<=$info['star']; ++$i) { ?>
<img src="/style/medalha.gif"/>
<?php 
}
?>
</div>
<div class='container'>
<div id='fundo' class='fundo'>
<table cellspacing="1" cellpadding="3" width="100%">
<?
if($info['tm']==true){  
?>
<tr><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha2; ?>">Torcedor do: <a href="/entretenimento/apptime"><img src='/times/<?php echo $info['tm'];?>.gif' style='width:50px;height:50px' div id='fotogato'></a></td></tr>
<?
}
?>
<tr><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha1; ?>">Id: <b><?php echo $info['id'];?></b></td></tr>
<tr><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha2; ?>">Quem sou eu: <b><?php echo textot($info['qm'],1,$on);?></b></td></tr>
<tr><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha1; ?>">Status: <b><?php echo status($info['id']);?></b>&nbsp;&nbsp;</td></tr>
<tr><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha2; ?>">Pontos: <b><?php echo $info['pt'];?></b></td></tr>
<tr><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha1; ?>"><img src="/style/moedas.png" width="12" height="15" />Moedas: <b><?php echo $info['moedas'];?></b> / Atividades: <b><?php echo $info['atividades'];?></b></td></tr>
<?php
if($info['pt']<5999) {
$img = "roca";
$nome = "rocha";
}else if($info['pt']>5999 && $info['pt']<10999){
$img = "perola1000";
$nome = "perola";
}else if($info['pt']>10999 && $info['pt']<17999){
$img = "onix2000";
$nome = "onix";
}else if($info['pt']>17999 && $info['pt']<26999){
$img = "turmalina3000";
$nome = "turmalina";
}else if($info['pt']>26999 && $info['pt']<35999){
$img = "agata5000";
$nome = "agata";
}else if($info['pt']>35999 && $info['pt']<48999){
$img = "jade6000";
$nome = "jade";
}else if($info['pt']>48999 && $info['pt']<59999){
$img = "ambar7000";
$nome = "ambar";
}else if($info['pt']>59999 && $info['pt']<79999){
$img = "turmalina_rosa8000";
$nome = "turmalinarosa";
}else if($info['pt']>79999 && $info['pt']<85999){
$img = "agua_marinha10000";
$nome = "aguamarinha";
}else if($info['pt']>85999 && $info['pt']<95999){
$img = "safira15000";
$nome = "safira";
}else if($info['pt']>95999 && $info['pt']<120999){
$img = "topazio20000";
$nome = "topazio";
}else if($info['pt']>120999 && $info['pt']<340999){
$img = "rubi25000";
$nome = "rubi";
}else if($info['pt']>340999 && $info['pt']<564346){
$img = "ametista30000";
$nome = "ametista";
}else if($info['pt']>564346 && $info['pt']<1147483){
$img = "esmeralda40000";
$nome = "esmeralda";
}else if($info['pt']>1147483){
$img = "diamante50000";
$nome = "diamante";
}
list($year,$month,$day)=explode('-',$info['nasc']);
if(($month==1 && $day>21)||($month==2&& $day<19)) {
$linksigno = 'horoscopo/aquario';
$signo =' Aquário';
}else
if(($month==2 && $day>20)||($month==3&& $day<20)) {
$linksigno = 'horoscopo/peixes';
$signo = 'Peixes';
}else
if(($month==3 && $day>21)||($month==4&& $day<20)) {
$linksigno = 'horoscopo/aries';
$signo = 'Áries';
}else
if(($month==4 && $day>21)||($month==5&& $day<20)) {
$linksigno = 'horoscopo/touro';
$signo = 'Touro';
}else
if(($month==5 && $day>21)||($month==6&& $day<20)) {
$linksigno = 'horoscopo/gemeos';
$signo = 'Gêmeos';
}else
if(($month==6 && $day>21)||($month==7&& $day<21)) {
$linksigno = 'horoscopo/cancer';
$signo = 'Câncer';
}else
if(($month==7 && $day>22)||($month==8&& $day<22)) {
$linksigno = 'horoscopo/leao';
$signo = 'Leão';
}else
if(($month==8 && $day>23)||($month==9&& $day<22)) {
$linksigno = 'horoscopo/virgem';
$signo = 'Virgem';
}else
if(($month==9 && $day>23)||($month==10&& $day<22)) {
$linksigno = 'horoscopo/libra';
$signo = 'Libra';
}else
if(($month==10 && $day>23)||($month==11&& $day<21)) {
$linksigno = 'horoscopo/escorpiao';
$signo = 'Escorpião';
}else
if(($month==11 && $day>22)||($month==12&& $day<21)) {
$linksigno = 'horoscopo/sagitario';
$signo = 'Sagitário';
}else
if(($month==12 && $day>22)||($month==1&& $day<20)) {
$linksigno = 'horoscopo/capricornio';
$signo = 'Capricórnio';
}else{
$signo = '';
$linksigno = "";
}
?>
<tr><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha2; ?>">Pedra preciosa: <b><?php echo "<img style='width:50px;height:50px' div id='fotogato' src='/style/pedras/".$img.".jpg'>".$nome."";?></b></td></tr>
<tr><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha1; ?>">Idade/Sexo/Signo: <b><?php echo idade($info['nasc']);?>/<?php echo sexo($info['id'])=='F'?'Feminino':'Masculino';?>/<a style="color:<?php echo $info['links'];?>;" href="javascript:void(0)" onclick="window.open ('/<?php echo $linksigno;?>','pagina','width=550, height=521, top=100, left=110, scrollbars=no');"><?php echo $signo;?></a></b></td></tr>
<tr><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha2; ?>">Localização: <? if($info['codigo']==1 or contamigos($meuid, $info['id']) or $info['id']==$meuid or perm($meuid)>0) {?><b><a href="/busca?nome=<?php echo $info['cid'];?>&estado=<?php echo $info['est'];?>&por=cid&a=busca" style="color:<?php echo $info['links'];?>;"><?php echo $info['cid'];?> - <?php echo $info['est'];?></a></b><?}else{?>desabilitado<?}?></td></tr>
<tr><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha1; ?>">Orientação sexual: <b><?php echo $or;?></b></td></tr>
<tr><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha2; ?>">E-mail: <b>
<?php if($info['vemail']==0) { echo $info['email'];
} else if($info['vemail']==1 and contamigos($meuid, $info['id']) or $info['id']==$meuid or perm($meuid)>0) { 
echo $info['email'];
} ?>
</b></b></td></tr>
<tr><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha1; ?>">Tempo online: <b><?php echo gerartempo($info['ton']);?></b></td></tr>
<tr><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha2; ?>">Cadastrou-se em: <b><?php echo date("d/m/Y - H:i:s",$info['rg']);?></b></td></tr>
<tr><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha1; ?>">Amigos: <b><a href="/amigos/0/<?php echo $info['id'];?>" style="color:<?php echo $info['links'];?>;"><?php echo $amigos[0];?></a></b></td></tr>
<?php
if($info['visi']==1) { ?>
<tr><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha2; ?>">Visitantes recentes: <b><a href="/visitas/visita/<?php echo $info['id'];?> " style="color:<?php echo $info['links'];?>;"><?php echo $visitas[0];?></a> / <a href="/visitas/visitei/<?php echo $info['id'];?> " style="color:<?php echo $info['links'];?>;"><?php echo $visitar[0];?></a></b></td></tr>
<?php } else { ?>
<tr><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha2; ?>">Visitas desabilitadas!</td></tr>
<?php }
if($info['id']!=$meuid) {
?>
<tr><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha1; ?>"><a href="/ppt?a=duelar&id=<?php echo $info['id'];?>"  style="color:<?php echo $info['links'];?>;">Duelar com <?php echo gerarnome($info['id']);?></a></td></tr>
<?php
} else if($info['id']=$meuid) {
?>
<tr><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha1; ?>">Seu IP: <b><?php echo $info['ip'];?></b></td></tr>
<?php
}
?>
<tr><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha2; ?>">Navegador: <small><b><?php echo $info['nav'];?></b></small></td></tr>
<?php
$meuemail = $_SERVER['SERVER_NAME'];
$murais = $mistake->prepare("SELECT COUNT(*) FROM w_mural WHERE drec='".$info['id']."' AND tipo='1'");
$murais->execute();
$murais = $murais->fetch();
$pensamentos = $mistake->prepare("SELECT COUNT(*) FROM w_mural WHERE drec='".$info['id']."' AND tipo='4'");
$pensamentos->execute();
$pensamentos = $pensamentos->fetch();
?>
<tr><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha1; ?>">
Recados Mural: <a href="/mural/recados/<?php echo $info['id']; ?>" style="color:
<?php echo $info['links'];?>;">(<?php echo $murais[0]; ?>)</a> - 
Pensamentos: <a href="/mural/pensamentos/<?php echo $info['id']; ?>" style="color:
<?php echo $info['links'];?>;">(<?php echo $pensamentos[0]; ?>)</a>
</td></tr>
<?
$nmr = $mistake->prepare("SELECT uid, aid, id, tempo FROM w_harem WHERE uid='".$info['id']."' or aid='".$info['id']."' and s='1'");
$nmr->execute();
$nmr = $nmr->fetch();
$nam=$nmr[0]==$info['id']?$nmr[1]:$nmr[0];
if($nmr[3]>0) {
if($info['tipoharem']=='1') {
$hnome_ralacao = sexo($info['id'])=='M'?'Marido de ':'Esposa de ';
}else if($info['tipoharem']=='2') {
$hnome_ralacao = sexo($info['id'])=='M'?'Namorado de ':'Namorada de ';
}else if(($info['tipoharem']=='3') and ($info['id']==$nmr[0])) {
$hnome_ralacao = sexo($info['id'])=='M'?'Filho de ':'Filha de ';
}else if(($info['tipoharem']=='3') and ($info['id']==$nmr[1])) {
$hnome_ralacao = sexo($info['id'])=='M'?'Pai de ':'Mãe de ';
}
else if(($info['tipoharem']=='4') and ($info['id']==$nmr[1])) {
$hnome_ralacao = sexo($info['id'])=='M'?'Filho de ':'Filha de ';
}else if(($info['tipoharem']=='4') and ($info['id']==$nmr[0])) {
$hnome_ralacao = sexo($info['id'])=='M'?'Pai de ':'Mãe de ';
}else if(($info['tipoharem']=='5') and ($info['id']==$nmr[0])) {
$hnome_ralacao = sexo($info['id'])=='M'?'Sobrinho de ':'Sobrinha de ';
}else if(($info['tipoharem']=='5') and ($info['id']==$nmr[1])) {
$hnome_ralacao = sexo($info['id'])=='M'?'Tio de ':'Tia de ';
}else if(($info['tipoharem']=='6') and ($info['id']==$nmr[1])) {
$hnome_ralacao = sexo($info['id'])=='M'?'Sobrinho de ':'Sobrinha de ';
}else if(($info['tipoharem']=='6') and ($info['id']==$nmr[0])) {
$hnome_ralacao = sexo($info['id'])=='M'?'Tio de ':'Tia de ';
}else if(($info['tipoharem']=='7') and ($info['id']==$nmr[1])) {
$hnome_ralacao = sexo($info['id'])=='M'?'Amigo de ':'Amiga de ';
}else if(($info['tipoharem']=='7') and ($info['id']==$nmr[0])) {
$hnome_ralacao = sexo($info['id'])=='M'?'Amigo de ':'Amiga de ';
}else if(($info['tipoharem']=='8') and ($info['id']==$nmr[1])) {
$hnome_ralacao = sexo($info['id'])=='M'?'Irmão de ':'Irmã de ';
}else if(($info['tipoharem']=='8') and ($info['id']==$nmr[0])) {
$hnome_ralacao = sexo($info['id'])=='M'?'Irmão de ':'Irmã de ';
}
?>
<tr><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha2; ?>"><b>No Harém você é <?php echo $hnome_ralacao; ?> <a href="/<?php echo gerarlogin($nam);?>"><?php echo gerarnome($nam);
?>
</a>
</td>
</tr>
<?
}
$mimo = $mistake->prepare("SELECT * FROM w_m_voto WHERE uid='".$info['id']."' ORDER BY RAND() LIMIT 4");
$mimo->execute();
if($mimo->rowCount()>0){
?>
<tr><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha1; ?>">Mimos:<a href="/mimos/meus/<?php echo $info['id']; ?>">
<? 
while ($item = $mimo->fetch(PDO::FETCH_OBJ)) { 
?>
<img src='/mimo/<?php echo $item->cat;?>.png' style='width:30px;height:30px' class='misfoto'>&nbsp;
<?php 
}
?>
</a></td></tr>
<?
}
?>
</table>
</div>
</div>
<div align="center">
<?
$inativo = time()-$testearray[18];
$itens = $mistake->prepare("SELECT a.id, b.uid, b.tid, a.cid, a.est, a.onlf,a.ft FROM w_usuarios a INNER JOIN w_amigos b WHERE ((a.id=b.uid AND b.tid='".$info['id']."') OR (a.id=b.tid AND uid='".$info['id']."')) AND b.ac='1' AND a.inativo > '$inativo' and a.vs='0' and a.ft!='semfoto.jpg' and a.ft is not null ORDER BY rand() DESC LIMIT 5");
$itens->execute();
if($itens->rowCount()>0){
?>
<div style="background-color:#<?php echo $linha2;?>;color:<?php echo $info['texto'];?>;height: 32px;text-align:center;"><strong><?php echo $imgsaldacao; ?>AMIGOS ATIVOS</strong></div>
<div style="background-color:#<?php echo $linha1;?>;text-align:center;">
<?
while ($item = $itens->fetch(PDO::FETCH_OBJ)) { 
?>
<a href="/<?php echo gerarlogin($item->id);?>"><?php echo gerarfoto($item->id,50,50);?></a>&nbsp;
<?php 
}
?>
</div>
<?

?>
<br /><a href="/perfil3?id=<?php echo $info['id'];?>" style="color:<?php echo $info['links'];?>;">Mais informações</a><br/><br/>
<a href="/acao/ver/<?php echo $info['id'];?>" style="color:<?php echo $info['links'];?>;">Ações (<?php echo $acoes[0];?>)</a><br/><br/>
<a href="/galeria/0/<?php echo $info['id'];?>" style="color:<?php echo $info['links'];?>;">Álbuns (<?php echo $albuns[0];?>)</a><br/><br/>
<a href="/fas?id=<?php echo $info['id'];?>" style="color:<?php echo $info['links'];?>;">Fãs (<?php echo $fas[0];?>)</a><br/><br/>
<a href="/recados?id=<?php echo $info['id'];?>" style="color:<?php echo $info['links'];?>;">Recados (<?php echo $rec[0];?>)</a><br/><br/>
<?php if(perm($meuid)>0) { ?> <a href="/mod/editarusuario/<?php echo $info['id'];?>" style="color:<?php echo $info['links'];?>;">Opções da equipe</a><br/> <?php }
?>
</div><br/>
<?php 
}
}else{
?>
<div id='fundo' class='fundo'>
<div align="center">
<img alt="foto" id="profile-img" class="profile-img" src="/<?php echo $foto;?>" oncontextmenu="return false" onselectstart="return false" ondragstart="return false" style="width:136px;height:156px;border-radius:50%; margin:1px; border:2px solid #FFF;" pbsrc="/<?php echo str_replace('m_','',$foto);?>" class="PopBoxImageSmall" title='<?php echo $info['nm'];?>' onclick="Pop(this,50,'PopBoxPopImage');" />
<br/>
<font color="<?php echo $info['texto'];?>"><strong>Este perfil só pode ser visualizado por amigos de <?php echo gerarnome($info['id']);?></strong></font><br /><br />
<font color="<?php echo $info['texto'];?>"> Id: <?php echo $info['id'];?></font><br /><br />
<font color="<?php echo $info['texto'];?>"> Quem sou eu: <b><?php echo textot($info['qm'],1,$on);?></font><br /><br />
<?
if($ign[0]==0 and $meuid!=$info['id']) { ?>
<a href="/bd/perfilbd?id=<?php echo $info['id'];?>&b=b">Bloquear usuário</a><br/><br/>
<?php } else if($ign[0]>0 and $meuid!=$info['id']) { ?>
<a href="/bd/perfilbd?id=<?php echo $info['id'];?>&b=d">Desbloquear usuário</a><br/><br/>
<?php
} 
?>
<a href="/amigos/editaramigo/<?php echo $info['id'];?>/add" style="color:<?php echo $info['links'];?>;">Adicionar amigo</a><br /><br />
<a href="/mensagens/lermsg/<?php echo $info['id'];?>" style="color:<?php echo $info['links'];?>;">Enviar mensagem</a><br/><br />
</div>
<?php 
}
}else{
 ?>
<br/><div align="center"><font color="red"><strong>Este perfil não existe...</strong></font></div><br />
<?
}
?>
<div align="center"><a href="<?php echo $meuid ? '/home' : '/';?>"  style="color:<?php echo $info['links'];?>;"><?php echo $imginicio;?>Página principal</a><br><br></div></div>