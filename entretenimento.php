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
if($a=='parceiros'){
if($id==true){
$mistake->exec("UPDATE w_parceiros SET vis=vis+1 WHERE id='$id'");
$url = $mistake->query("SELECT url FROM w_parceiros WHERE id='$id'")->fetch();
header("Location:$url[0]");
}
}
if($a=='') { ativo($meuid,'Menu entretenimento '); ?>
<br/><div id="titulo"><b>Menu Entretenimento</b></div><br/>
<div id="div1"><?php echo $imgdiversao;?><a href="/entretenimento/diversao">Diversão</a></div>

<?php } else if($a=='diversao') { ativo($meuid,'Menu entretenimento '); 
$tipo = $mistake->query("SELECT visitante FROM w_usuarios WHERE id='$meuid'")->fetch();
?>
<br/><div id="titulo"><b>Diversão</b></div><br/>
<?
if($tipo[0]==0){
?>
<div id="div1"><?php echo $imgbolinha;?><a href="/bolinha?">Ache a bolinha</a></div>
<div id="div1"><?php echo $imgcassino;?><a href="/cassino1?">Cassino</a></div>
<div id="div1"><?php echo $imgcdc;?><a href="/cdc?">Corrida de cavalos</a></div>
<div id="div1"><?php echo $imgfazenda;?><a href="/fazenda?">Fazendas</a></div>
<div id="div1"><?php echo $imgforca;?><a href="/forca?">Forca</a></div>
<div id="div1"><?php echo $imgcorrida;?><a href="/corrida?">Fórmula 1</a></div>
<div id="div1"><?php echo $imgdado;?><a href="/dado?">Jogo do dado</a></div>
<div id="div1"><?php echo $imgtime;?><a href="/penaltis?">Jogo dos Pênaltis</a></div>
<div id="div1"><?php echo $imgloteria;?><a href="/loteria?">Loteria</a></div>
<div id="div1"><?php echo $imgpouc;?><a href="/pouc?">Para ou continua</a></div>
<div id="div1"><?php echo $imgparouimpar;?><a href="/parouimpar?">Par ou impar</a></div>
<div id="div1"><?php echo $imgppt;?><a href="/ppt?">Pedra, papel, tesoura.</a></div>
<div id="div1"><?php echo $imgquiz;?><a href="/perguntas?">Perguntas sobre seus amigos</a></div>
<div id="div1"><?php echo $imgquiz;?><a href="/entretenimento/quiz">Quiz</a></div>
<div id="div1"><?php echo $imgwapet;?><a href="/wapet?">Virtual pet</a></div>
<div id="div1"><?php echo $imgpesca;?><a href="/pescaria">Pescaria</a></div>
<div id="div1"><?php echo $imgleilao;?><a href="/leilao">Leilao</a></div>
<div id="div1"><?php echo $imgpombo;?><a href="/pegueopombo">Pegue o Pombo</a></div>
<div id="div1"><?php echo $imgpokemon;?><a href="/pokemon">Pokemon</a></div>
<div id="div1"><?php echo $imgzumbi;?><a href="/walking">Zumbis</a></div>
<div id="div1"><?php echo $imgdiversao;?><a href="/mortal/menum">Mortal Kombat</a></div>
<div id="div1"><?php echo $imgdiversao;?><a href="/kart/menu">Mario Kart</a></div>
<div id="div1"><?php echo $imgdiversao;?><a href="/motos/menu">Corrida de Moto</a></div>
<div id="div1"><?php echo $imgbote;?><a href="/boteco">Boteco <?php echo nome_site(); ?></a></div>
<div id="div1"><?php echo $imghipod;?><a href='/caballos/menu'>Hipodromo</a></div>
<div id="div1"><?php echo $imghipod;?><a href='/friendzoo'>Friendzoo</a></div>

<br />
<?
}?>
<?php } else if($a=='informacao') { ativo($meuid,'Menu entretenimento '); ?>
<br/><div id="titulo"><b>Informação</b></div><br/>
<div id="div1"><?php echo $imgtime;?><a href="/apostas">Apostas Futebol</a></div>
<div id="div1"><?php echo $imgnoticias;?><a href="/noticias?">Notícias</a></div>
<div id="div1"><?php echo $imgup;?><a href="/noticias?a=noticias2&id=12">Utilidade Pública</a></div><br/>
<?php } else if($a=='diversos') { ativo($meuid,'Menu entretenimento '); ?>
<br/><div id="titulo"><b>Diversos</b></div><br/>
<div id="div1"><?php echo $imgbanco;?><a href="/banco?">Banco</a></div>
<div id="div1"><?php echo $imgcalc;?><a href="/calculadora?">Calculadora</a></div>
<div id="div1"><?php echo $imgrecados;?><a href="/depoimentos?">Depoimentos</a></div>
<div id="div1"><?php echo $imgenquete;?><a href="/enquete/categorias">Enquetes</a></div>
<div id="div1"><?php echo $imgloja;?><a href="/lojas?">Loja de presentes</a></div>
<div id="div1"><img src="/style/lida.gif"><a href="/sms?">Enviar torpedo sms</a></div>
<div id="div1"><?php echo $imgtime;?><a href="/entretenimento/apptime">Meu time do coração</a></div>
<div id="div1"><img src="/style/estatisticas.gif" alt="img" /><a href="/estatisticas?">Estatísticas do site</a></div>
<div id="div1"><img src="/style/busca.gif" alt="img" /><a href="/busca?">Busca no site</a></div>
<div id="div1"><img src='/imagens/gato.gif' alt='gatogata'/><a href="/gato?">Gato e Gata</a></div><br/>
<?php } else if($a=='apptime') { ativo($meuid,'Meu time de coração '); ?>
<br/><div id="titulo"><b>Meu time de coração</b></div><br/>
<a href="/entretenimento/escolher">&#187;Escolha seu time</a><br/><br/>
<a href="/entretenimento/ranking">&#187;Ranking</a><br/><br/>
<?php
$tm = $mistake->query("SELECT tm FROM w_usuarios WHERE id='$meuid'")->fetch();
if($tm[0]>0) { ?>
<a href="/entretenimento/carteirinha">&#187;Carteirinha</a><br/>
<?php } } else if($a=='escolher') { ativo($meuid,'Meu time de coração '); ?>
<br/><div id="titulo"><b>Times</b></div><br/>
<div align="center">Escolha seu time do coração</div><br/>
<?php
$contmsg = $mistake->query("SELECT COUNT(*) FROM w_times")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contmsg[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->query("SELECT id,nm,pais FROM w_times ORDER BY nm LIMIT $limit, $itensporpag");
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div1';?>">
<img src="/times/<?php echo $item->id;?>.gif" width="50px" height="50px"><?php echo $item->nm;?> <a href="/entretenimento/addtime/<?php echo $item->id;?>">[+] <? if(perm($meuid)>0){?></a><a href="/mod/deletartime/<?php echo $item->id;?>">[D]</a><?php
}
?></div>
<?php $i++; }
if($numpag>1) {
paginas('entretenimento',$a,$numpag,$id,$pag);
}
} else { ?>
<div align="center">Não ah nenhum time cadastrado!<br/><br/>
<?php } } else if($a=='parceiros') { ?>
<br/><div id="titulo"><b>Parceiros</b></div><br/>
<?php
$contmsg = $mistake->query("SELECT COUNT(*) FROM w_parceiros")->fetch();
if($contmsg>0) {
$itens = $mistake->query("SELECT * FROM w_parceiros ORDER BY id desc");
$i=0; while($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div1';?>">
<a href="/entretenimento/parceiros/<?php echo $item->id;?>" target="_blank"><?php echo $item->nm;?></a><br/>
<?php echo $item->des;?><br/>
Visitas: <b><i><?php echo $item->vis;?></i></b><br/>
Adicionado em: <b><i><?php echo date("d/m/Y",$item->dt);?></i></b>
</div>
<?php $i++; } } else { ?>
<div align="center">Nenhum parceiro!<br/><br/>
<?php } } else if($a=='addtime') { ativo($meuid,'Meu time de coração ');
$time = $mistake->query("SELECT id,pais,nm FROM w_times where id='$id'")->fetch(); ?>
<br/><div align="center"><?php echo $imgok;?>Você escolheu <?php echo $time[2];?>!</div><br/>
<?php
$qtdf = $mistake->query("SELECT a.qtd, b.tm FROM w_times a, w_usuarios b where a.id=b.tm and b.id='$meuid'")->fetch();
$mistake->exec("UPDATE w_times SET qtd='".($qtdf[0]-1)."' WHERE id='$qtdf[1]'");
$mistake->exec("UPDATE w_usuarios SET tm='".$time[0]."' WHERE id='$meuid'");
$cart = $mistake->query("SELECT max(ct) FROM w_usuarios where tm='$id' and id!='$meuid'")->fetch();
$mistake->exec("UPDATE w_usuarios SET ct='".($cart[0]+1)."' WHERE id='$meuid'");
$qtd = $mistake->query("SELECT qtd FROM w_times where id='$id'")->fetch();
$mistake->exec("UPDATE w_times SET qtd='".($qtd[0]+1)."' WHERE id='$id'");
} else if($a=='ranking') { ativo($meuid,'Meu time de coração ');
$nm = $mistake->query("SELECT a.nm FROM w_times a, w_usuarios b where a.id=b.tm and b.id='$meuid'")->fetch(); ?>
<br/><div id="titulo"><b>Ranking</b></div><br/>
<div align="center">Veja o <?php echo $nm[0];?> no ranking das maiores torcidas!</div><br/>
<?php
$contmsg = $mistake->query("SELECT COUNT(*) FROM w_times")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contmsg[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->query("SELECT id, nm, qtd FROM w_times ORDER BY qtd desc LIMIT $limit, $itensporpag");
if(($pag=='')||($pag==1)){$o=1;}
else if($pag==2){$o=11;}
else if($pag==3){$o=21;}
else if($pag==4){$o=31;}
else if($pag==5){$o=41;}
else if($pag==6){$o=51;}
$i=0;  while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div1';?>">
<b><?php echo $item->nm;?></b><br/>
<i>A <?php echo $o==1?(''):("".$o."º");?> maior torcida do site | <?php echo $item->qtd;?> torcedor<?php echo ($item->qtd>1)?('es'):('');?>!</i>
</div>
<?php $i++; $o++; }
if($numpag>1) {
paginas('entretenimento',$a,$numpag,$id,$pag);
}
} else { ?>
<div align="center">Não ah nenhum time cadastrado!<br/><br/>
<?php } } else if($a=='carteirinha') { ativo($meuid,'Meu time de coração ');
$info = $mistake->query("SELECT a.nm, a.sbn, a.ct, a.ft, b.nm, a.tm FROM w_usuarios a, w_times b where a.id='$meuid'")->fetch();
$nmtm = $mistake->query("SELECT nm FROM w_times where id='$info[5]'")->fetch();
$sim = $mistake->query("SELECT count(*) FROM w_usuarios a, w_amigos b where (b.uid='$meuid' OR b.tid='$meuid') and (b.uid=a.id OR b.tid=a.id) and a.id!='$meuid' and a.tm='$info[5]'")->fetch();
$nao = $mistake->query("SELECT count(*) FROM w_usuarios a, w_amigos b where (b.uid='$meuid' OR b.tid='$meuid') and (b.uid=a.id OR b.tid=a.id) and a.id!='$meuid' and a.tm!='$info[5]' and a.tm>0")->fetch();
?>
<br/><div id="titulo"><b>Carteirinha</b></div><br/>
<?php if($info[3]==true){?><img alt="foto" id="profile-img" class="profile-img" src="/<?php echo $info[3];?>" oncontextmenu="return false" onselectstart="return false" ondragstart="return false" style="width:103px;height:136px;border-radius:50%; margin:1px; border:2px solid #FFF;" pbsrc="/<?php echo str_replace('m_','',$info[3]);?>" class="PopBoxImageSmall" title="Clique para ampliar/diminuir" onclick="Pop(this,50,'PopBoxPopImage');" />
<br/><?php } ?>
<?php echo $info[0];?> <?php echo $info[1];?><br/>
<?php echo $nmtm[0];?><br/>
Carteira número: <?php echo $info[2];?><br/><br/>
Amigos que torcem para o <?php echo $nmtm[0];?>:<br/>
<?php echo $sim[0];?> amigo<?php echo ($sim[0]>1)?('s'):('');?>.<br/>
<?php
$itens = $mistake->query("SELECT a.id FROM w_usuarios a, w_amigos b where (b.uid='$meuid' OR b.tid='$meuid') and (b.uid=a.id OR b.tid=a.id) and a.id!='$meuid' and a.tm='$info[5]' order by a.ativo desc limit 5");
while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<a href="/<?php echo gerarlogin($item->id);?>"><?php echo gerarnome($item->id);?></a><br/>
<?php } ?>
<i><font size="1"><a href="/entretenimento/tdtorcedores/s">Ver todos</a></font></i><br/><br/>
Amigos sofredores:<br/>
<?php echo $nao[0];?> amigos que torcem para outros times.<br/>
<?php
$itens = $mistake->query("SELECT a.id FROM w_usuarios a, w_amigos b where (b.uid='$meuid' OR b.tid='$meuid') and (b.uid=a.id OR b.tid=a.id) and a.id!='$meuid' and a.tm!='$info[5]' and a.tm>0 order by a.ativo desc limit 5");
while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<a href="/<?php echo gerarlogin($item->id);?>"><?php echo gerarnome($item->id);?></a><br/>
<?php } ?>
<i><font size="1"><a href="/entretenimento/tdtorcedores/n">Ver todos</a></font></i><br/><br/>
<?php } else if($a=='tdtorcedores') { ativo($meuid,'Meu time de coração ');
$info = $mistake->query("SELECT b.nm, a.tm FROM w_usuarios a, w_times b where a.id='$meuid' and b.id=a.tm")->fetch();
 ?>
<br/><div id="titulo">
<b>Amigos <?php if($id=='s') { ?>que torcem para o <?php echo $info[0]; } else { ?>sofredores <?php } ?></b></div><br/>
<?php
if($id=='s'){
$contmsg = $mistake->query("SELECT count(*) FROM w_usuarios a, w_amigos b where (b.uid='$meuid' OR b.tid='$meuid') and (b.uid=a.id OR b.tid=a.id) and a.id!='$meuid' and a.tm='$info[1]'")->fetch();
}else{
$contmsg = $mistake->query("SELECT count(*) FROM w_usuarios a, w_amigos b where (b.uid='$meuid' OR b.tid='$meuid') and (b.uid=a.id OR b.tid=a.id) and a.id!='$meuid' and a.tm!='$info[1]' and a.tm>0")->fetch();
}
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contmsg[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
if($id=='s'){
$itens = $mistake->query("SELECT a.id, a.tm, a.ct FROM w_usuarios a, w_amigos b where (b.uid='$meuid' OR b.tid='$meuid') and (b.uid=a.id OR b.tid=a.id) and a.id!='$meuid' and a.tm='$info[1]' order by a.ativo desc limit $limit, $itensporpag");
}else{
$itens = $mistake->query("SELECT a.id, a.tm, a.ct FROM w_usuarios a, w_amigos b where (b.uid='$meuid' OR b.tid='$meuid') and (b.uid=a.id OR b.tid=a.id) and a.id!='$meuid' and a.tm!='$info[1]' and a.tm>0 order by a.ativo desc limit $limit, $itensporpag");
}
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) {
$time = $mistake->query("SELECT nm FROM w_times where id='".$item->tm."'")->fetch(); ?>
<div id="<?php echo $i%2==0?'div1':'div1';?>">
<?php echo (online($item->id)>0)?gstat($item->id):$imgoff;?><a href="/<?php echo gerarlogin($item->id);?>">
<?php echo gerarnome($item->id);?></a><br/>
Time: <b><?php echo $time[0];?></b><br/>
Carteirinha: <b><?php echo $item->ct;?></b></div>
<?php $i++; }
if($numpag>1) {
paginas('entretenimento',$a,$numpag,$id,$pag);
}
} else { ?>
<div align="center">Não ah amigos!<br/><br/>
<?php } } else if($a=='quiz') { ativo($meuid,'Quiz '); 
$contprg = $mistake->query("SELECT count(*) FROM w_quiz2")->fetch(); ?>
<br/><div id="titulo"><b>Ranking</b></div><br/>
<div style="background-color:#EAF3FA;padding-top:2px;margin-top:4px;">
<?php echo $imgdir;?><a href="/entretenimento/rquiz/acertos">Acertos</a></div>
<div style="background-color:#EBF9DF;padding-top:2px;margin-top:4px;">
<?php echo $imgdir;?><a href="/entretenimento/rquiz/erros">Erros</a></div>
<br/><div id="titulo"><b>Categorias</b></div><br/>
<div style="background-color:#EBF9DF;padding-top:2px;margin-top:4px;">
<?php echo $imgdir;?><a href="/entretenimento/quiz2/todas">Todas(<?php echo $contprg[0];?>)</a>
</div>
<?php
$contmsg = $mistake->query("SELECT count(*) FROM w_quiz")->fetch();
if($contmsg[0]>0) {
$itens = $mistake->query("SELECT id,nm FROM w_quiz order by nm");
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { $quiz2 = $mistake->query("SELECT count(*) FROM w_quiz2 where cat='".$item->id."'")->fetch(); ?>
<div id="<?php echo $i%2==0?'div1':'div1';?>">
<?php echo $imgdir;?><a href="/entretenimento/quiz2/<?php echo $item->id;?>"><?php echo $item->nm;?>(<?php echo $quiz2[0];?>)</a>
</div>
<?php $i++; } ?>
<br/><div align="center">
<?php } else { ?>
<div align="center">Nenhuma categoria!<br/><br/>
<?php } } else if($a=='quiz2') {
ativo($meuid,'Quiz ');
$nm = $mistake->query("SELECT nm FROM w_quiz where id='$id'")->fetch(); ?>
<style type="text/css">
input {
border:0;
}
</style>
<br/><div id="titulo"><b><?php echo ($id=='todas')?('Todas'):($nm[0]);?></b></div><br/>
<?php
if($id==true){
if($_SESSION['quiz']==$_POST['id']) { ?>
<b>Pergunta repetida ou atualização de página!</b><br/><br/>
<?php } else {  
if($_POST['r']==$_POST['ct']) {
$qza = $mistake->query("SELECT qza FROM w_usuarios where id='$meuid'")->fetch();
if($testearray[41]==1){
$mistake->exec("UPDATE w_usuarios SET qza='".($qza[0]+1)."', pt='".(pts($meuid)+1)."' WHERE id='$meuid'");
}else{
$mistake->exec("UPDATE w_usuarios SET qza='".($qza[0]+1)."' WHERE id='$meuid'");
}
?>
<b>Você acertou!</b><br/><br/>
<?php if($testearray[41]==1) { ?>
Pontos: <?php echo (pts($meuid)-1);?> + 1 = <?php echo pts($meuid);?>
<?php } else { ?>
Pontuação inativa
<?php } ?>
<br/><br/>
<?php $_SESSION['quiz'] = $_POST['id'];
} else { 
$ct = $mistake->query("SELECT * FROM w_quiz2 where id='".$_POST['id']."'")->fetch();
if($ct['ct']==1){
$res = $ct['r1'];
}else if($ct['ct']==2){
$res = $ct['r2'];
}else if($ct['ct']==3){
$res = $ct['r3'];
}
$qze = $mistake->query("SELECT qze FROM w_usuarios where id='$meuid'")->fetch();
if($testearray[41]==1){
$mistake->exec("UPDATE w_usuarios SET qze='".($qze[0]+1)."', pt='".(pts($meuid)-1)."' WHERE id='$meuid'");
}else{
$mistake->exec("UPDATE w_usuarios SET qze='".($qze[0]+1)."' WHERE id='$meuid'");
}
?>
<b>Você errou!</b><br/><br/>
<?php if($testearray[41]==1) { ?>
Pontos: <?php echo (pts($meuid)+1);?> - 1 = <?php echo pts($meuid);?>
<?php } else { ?>
Pontuação inativa
<?php } ?>
<br/><br/>Resposta certa: <b><?php echo $res;?></b><br/><br/>
<?php } } }
if($id=='todas'){
$prg = $mistake->query("SELECT * FROM w_quiz2 order by rand()")->fetch();
}else{
$prg = $mistake->query("SELECT * FROM w_quiz2 where cat='$id' order by rand()")->fetch(); 
} ?>
<form action="/entretenimento/quiz2/<?php echo $id;?>" method="post">
<?php echo $prg['prg'];?><br/><br/>
<?php $hand = rand(1,3); if($hand==1) { ?>
<input type="radio" value="1" name="r" /> <?php echo $prg['r1'];?><br/>
<input type="radio" value="2" name="r" /> <?php echo $prg['r2'];?><br/>
<input type="radio" value="3" name="r" /> <?php echo $prg['r3'];?><br/><br/>
<?php } else if($hand==2) { ?>
<input type="radio" value="2" name="r" /> <?php echo $prg['r2'];?><br/>
<input type="radio" value="1" name="r" /> <?php echo $prg['r1'];?><br/>
<input type="radio" value="3" name="r" /> <?php echo $prg['r3'];?><br/><br/>
<?php } else { ?>
<input type="radio" value="3" name="r" /> <?php echo $prg['r3'];?><br/>
<input type="radio" value="1" name="r" /> <?php echo $prg['r1'];?><br/>
<input type="radio" value="2" name="r" /> <?php echo $prg['r2'];?><br/><br/>
<?php } ?>
<input type="hidden" name="ct" value="<?php echo $prg['ct'];?>" />
<input type="hidden" name="id" value="<?php echo $prg['id'];?>" />
<input type="submit" value="Responder" style="border:1px solid #999;" />
</form><br/>
<div align="center"><a href="/entretenimento/quiz">Quiz</a>
<?php } else if($a=='rquiz') { ativo($meuid,'Quiz - Ranking '); if($id=='acertos'){
$contmsg = $mistake->query("SELECT count(*) FROM w_usuarios where qza>'0'")->fetch();
$qz = 'qza';
$ea = 'acertos';
$tt = 'Acertos';
}else{
$contmsg = $mistake->query("SELECT count(*) FROM w_usuarios where qze>'0'")->fetch();
$qz = 'qze';
$ea = 'erros';
$tt = 'Erros';
}
?>
<br/><div id="titulo"><b><?php echo $tt;?></b></div><br/>
<?php
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contmsg[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
if($id=='acertos'){
$itens = $mistake->query("SELECT id, $qz FROM w_usuarios where qza>'0' order by qza desc limit $limit, $itensporpag");
}else{
$itens = $mistake->query("SELECT id, $qz FROM w_usuarios where qze>'0' order by qze desc limit $limit, $itensporpag");
}
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { $quiz2 = $mistake->query("SELECT count(*) FROM w_quiz2 where cat='".$item->id."'")->fetch(); ?>
<div id="<?php echo $i%2==0?'div1':'div1';?>">
<a href="/<?php echo gerarlogin($item->id);?>"><?php echo gerarnome($item->id);?></a> - <?php echo $item->$qz.' '.$ea;?>
</div>
<?php $i++; }
if($numpag>1) {
paginas('entretenimento',$a,$numpag,$id,$pag);
}
} else { ?>
<div align="center">Nenhum usuário!<br/><br/>
<?php } ?>
<br/><div align="center"><a href="/entretenimento/quiz">Quiz</a>
<?php } else if($a=='ppt') { ?>
<br/><div id="titulo"><b>Pedra, Papel ou Tesoura</b></div><br/>
<form method="post" action="/entretenimento/ppt2">
<select name="jogo">
<option value="1">Pedra</option>
<option value="2">Papel</option>
<option value="3">Tesoura</option></select><br/>
<input type="submit" value="Jogar"></form>
<?php } else if($a=='ppt2') {
$jogo = $_POST['jogo'];
$jogopc = rand(1,3); ?>
<br/><div id="titulo"><b>Pedra, Papel ou Tesoura</b></div><br/>
<?php if($jogo==1) { if($jogopc==1) { ?>
<a href="/<?php echo gerarlogin($meuid);?>"><?php echo gerarnome($meuid);?></a> : Pedra<br/>
<b>Sistema</b> : Pedra<br/><br/>
<b>Deu empate!</b><br/>
Pontos: <?php echo pts($meuid);?><br/>
<?php } else if($jogopc==2) {
$mistake->exec("UPDATE w_usuarios SET pt='".(pts($meuid)-1)."' WHERE id='$meuid'"); ?>
<a href="/<?php echo gerarlogin($meuid);?>"><?php echo gerarnome($meuid);?></a> : Pedra<br/>
<b>Sistema</b> : Papel<br/><br/>
<b>Você perdeu!</b><br/>
Pontos: <?php echo pts($meuid);?><br/>
<?php } else if($jogopc==3) {
$mistake->exec("UPDATE w_usuarios SET pt='".(pts($meuid)+1)."' WHERE id='$meuid'"); ?>
<a href="/<?php echo gerarlogin($meuid);?>"><?php echo gerarnome($meuid);?></a> : Pedra<br/>
<b>Sistema</b> : Tesoura<br/><br/>
<b>Parabéns, você ganhou!</b><br/>
Pontos: <?php echo pts($meuid);?><br/>
<?php } } else if($jogo==2) { if($jogopc==1) {
$mistake->exec("UPDATE w_usuarios SET pt='".(pts($meuid)+1)."' WHERE id='$meuid'"); ?>
<a href="/<?php echo gerarlogin($meuid);?>"><?php echo gerarnome($meuid);?></a> : Papel<br/>
<b>Sistema</b> : Pedra<br/><br/>
<b>Parabéns, você ganhou!</b><br/>
Pontos: <?php echo pts($meuid);?><br/>
<?php } else if($jogopc==2) { ?>
<a href="/<?php echo gerarlogin($meuid);?>"><?php echo gerarnome($meuid);?></a> : Papel<br/>
<b>Sistema</b> : Papel<br/><br/>
<b>Deu empate!</b><br/>
Pontos: <?php echo pts($meuid);?><br/>
<?php } else if($jogopc==3) {
$mistake->exec("UPDATE w_usuarios SET pt='".(pts($meuid)-1)."' WHERE id='$meuid'"); ?>
<a href="/<?php echo gerarlogin($meuid);?>"><?php echo gerarnome($meuid);?></a> : Papel<br/>
<b>Sistema</b> : Tesoura<br/><br/>
<b>Você perdeu!</b><br/>
Pontos: <?php echo pts($meuid);?><br/>
<?php } } else if($jogo==3) { if($jogopc==1) {
$mistake->exec("UPDATE w_usuarios SET pt='".(pts($meuid)-1)."' WHERE id='$meuid'"); ?>
<a href="/<?php echo gerarlogin($meuid);?>"><?php echo gerarnome($meuid);?></a> : Tesoura<br/>
<b>Sistema</b> : Pedra<br/><br/>
<b>Você perdeu!</b><br/>
Pontos: <?php echo pts($meuid);?><br/>
<?php } else if($jogopc==2) {
$mistake->exec("UPDATE w_usuarios SET pt='".(pts($meuid)+1)."' WHERE id='$meuid'"); ?>
<a href="/<?php echo gerarlogin($meuid);?>"><?php echo gerarnome($meuid);?></a> : Tesoura<br/>
<b>Sistema</b> : Papel<br/><br/>
<b>Parabéns, você ganhou!</b><br/>
Pontos: <?php echo pts($meuid);?><br/>
<?php } else if($jogopc==3) { ?>
<a href="/<?php echo gerarlogin($meuid);?>"><?php echo gerarnome($meuid);?></a> : Tesoura<br/>
<b>Sistema</b> : Tesoura<br/><br/>
<b>Deu empate!</b><br/>
Pontos: <?php echo pts($meuid);?><br/>
<?php } } ?>
<br/><a href="/entretenimento/ppt">Novo jogo</a><br/>
<?php } if($a==true) { ?>
<br/><div align="center"><a href="/entretenimento?"><?php echo $imgservicos;?>Entretenimento</a> <?php } ?>
<div class="col-12 text-center" style="margin-top: 20px"><a class="badge badge-secondary" href="javascript:window.history.back();"><?php echo $imgsetavoltar;?> Voltar</a></div><br/>
<?php echo rodape();?>
</body>
</html>