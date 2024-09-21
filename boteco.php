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
ativo($meuid,'Boteco');
if(pts($meuid)<800){
echo "<div align='center'><b>Voce precisa ter no minimo 800 Pontos!</b></div>";
?>
<div align="center">
<a href="/entretenimento?"><?php echo $imgservicos;?>Entretenimento</a><br/>
<a href="/home?"><?php echo $imginicio;?>Página principal</a><br><br>
<?php 
echo 
rodape();
exit();
}
if($a==false) {
$numeros = rand(1000,9999);
$mistake->exec("UPDATE w_usuarios SET boteco='".rand(1,5)."' WHERE id='$meuid'");?>

<br/><div id="titulo"><b>Boteco <?php nome_site();?></b></div><br/>

<div align="center"><br/>
Advinhe qual bebida será servida para você e ganhe pontos!
<br/>
<img src="imgs/boteco.jpg">
<br/><br/>
Escolha uma das bebidas abaixo
<br/>

<a href="boteco?a=jogar&e=1"><img src="imgs/cerveja.png"></a> - <a href="boteco?a=jogar&e=2"><img src="imgs/choop.png"></a> - <a href="boteco?a=jogar&e=3"><img src="imgs/margarita.png"></a> - <a href="boteco?a=jogar&e=4"><img src="imgs/refrigerante.png"></a> - <a href="boteco?a=jogar&e=5"><img src="imgs/vinho.png"></a>
<br/><br/>

<?php } else if($a=='jogar') { $boteco = $mistake->query("SELECT boteco FROM w_usuarios WHERE id='$meuid'")->fetch();?>

<br/><div id="titulo"><b>Boteco <?php  nome_site();?></b></div><br/>

<div align="center">

<?php
if($boteco[0]=='1'){
$bebidaok = "cerveja";
}else if($boteco[0]=='2'){
$bebidaok = "choop";
}else if($boteco[0]=='3'){
$bebidaok = "margarita";
}else if($boteco[0]=='4'){
$bebidaok = "refrigerante";
}else if($boteco[0]=='5'){
$bebidaok = "vinho";
}else{
$bebidaok = "cerveja";
}
$nav = explode(" ",$_SERVER['HTTP_USER_AGENT'] );
if($e==$boteco[0] && $boteco[0]>0){
$mistake->exec("INSERT INTO w_pontos (uid,aid,hr,rz,ip,nv,dt,pt) values('1','$meuid','".time()."','Acertou no jogo do boteco','".gerarip()."','$nav[0]','1','20')");
$mistake->exec("UPDATE w_usuarios SET pt=pt+20, boteco='0', boteco2=boteco2+1 where id='$meuid'");
$textoatividades = 'Jogou na brincadeira do boteco e ganhou 1 ponto de atividade';
?>
<br/>
<?php echo $imgok;?> Parabéns você acertou a bebida e ganhou 20 pontos!<br/><br/>
<img src="imgs/<?php echo $bebidaok;?>.png"><br/>
A bebida é: <?php echo $bebidaok;?><br/><br/>
<?php }else{
$mistake->exec("INSERT INTO w_pontos (uid,aid,hr,rz,ip,nv,dt,pt) values('1','$meuid','".time()."','Errou no jogo do boteco','".gerarip()."','$nav[0]','0','10')"); 
$mistake->exec("UPDATE w_usuarios SET pt=pt-10, boteco='0', boteco2=boteco2-1 where id='$meuid'");
$textoatividades = 'Jogou na brincadeira do boteco e ganhou 1 ponto de atividade';
?>
<br/>
<?php echo $imgerro;?> Você errou a bebida e perdeu 10 pontos!<br/><br/>
<img src="imgs/<?php echo $bebidaok;?>.png"><br/>
A bebida certa era <?php echo $bebidaok;?><br/><br/>

<?php } ?>
<br/>
<a href="boteco">Jogar novamente</a><br/><br/>

<?php }else if($a=='regras'){ ?>
<br/><div id="titulo"><b>Regras boteco</b></div><br/>
<div align="center">
<br/>No boteco você ganha 20 pontos ao acertar qual bebida será servida para você e ganha uma bebida no ranking.
<br/>Caso você erre perderá 10 pontos e perderá uma bebida no ranking do boteco.
<br/>Você pode jogar contra o computador ou desafiar um amigo para o jogo.
<br/>É necessário ter no mínimo 20 pontos para jogar.
<br/>Para qualquer outra dúvida entre em contato com a equipe do <?php echo nome_site();?>
<br/><br/>
<?php }  else if($a=='ranking') { ?>

<br/> <div id="titulo">
<b>Ranking boteco</b></div><br/>

<?php
$contmsg = $mistake->query("SELECT count(*) FROM w_usuarios where boteco>'0'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contmsg[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->query("SELECT id, boteco FROM w_usuarios where boteco>'0' order by boteco desc limit $limit, $itensporpag");
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>

<div id="<?php echo $i%2==0?'div1':'div2';?>">
<a href="perfil?id=<?php echo $item->id;?>"><?php echo gerarnome($item->id);?></a> - Acertou <?php echo $item->boteco;?> bebidas(s)
</div>

<?php $i++; } ?>

<br/><div align="center"><br/>

<?php if($pag>1) { $ppag = $pag-1; ?>

<a href="boteco?a=ranking&pag=<?php echo $ppag;?>">&#171;Anterior</a>

<?php } if($pag<$numpag) { $npag = $pag+1; ?>

<a href="boteco?a=ranking&pag=<?php echo $npag;?>">Próxima&#187;</a>

<?php } ?>

<br/><?php echo $pag.'/'.$numpag;?><br/>

<?php if($numpag>2) { ?>

<form action="boteco" method="get">
Pular para página<input name="pag" size="3">
<input type="submit" value="IR">
<input type="hidden" name="a" value="<?php echo $a;?>">
</form>

<?php } } else { ?>

<div align="center">Nenhum usuário ainda acertou bebidas!<br/><br/>

<?php } ?>

<br/><div align="center"><a href="boteco">Boteco <?php echo nome_site();?></a>

<?php } else if($a=='du') { ?>

<br/><div id="titulo"><b>Boteco contra usuário</b></div><br/>
<div align="center">
<br/>
Escolha uma bebida para um amigo, se ele acertar qual bebida você escolheu ele irá ganhar os pontos se ele errar você ganha.
<br/><br/>
<img src="imgs/cerveja.png"> Cerveja<br/><hr>
<img src="imgs/choop.png"> Choop<br/><hr>
<img src="imgs/margarita.png"> Margarita<br/><hr>
<img src="imgs/refrigerante.png"> Refrigerante<br/><hr>
<img src="imgs/vinho.png"> Vinho<br/><hr>
<br/>

<form action="boteco?a=du2" method="post">

Enviar para:<br/><select name="ami">
<option value="0">Amigo(a)</option>
<?php
$amigos = $mistake->prepare("SELECT b.id,b.nm FROM w_amigos a inner join w_usuarios b WHERE (a.uid='".$meuid."' OR a.tid='".$meuid."') AND a.ac='1' AND (b.id=a.tid OR b.id=a.uid) AND b.id!='$meuid' order by b.nm asc");
$amigos->execute();
while ($amg = $amigos->fetch(PDO::FETCH_OBJ)) { ?>
<option value="<?php echo $amg->id;?>"><?php echo $amg->nm;?></option>
<?php } ?>
</select><br/><br/>

Valor da aposta:<br/>
<input type="text" name="val" maxlength="3" size="3"><br/><br/>

Bebida:<br/>
<select name="bebida">
<option value="1">Cerveja</option>
<option value="2">Choop</option>
<option value="3">Margarita</option>
<option value="4">Refrigerante</option>
<option value="5">Vinho</option>
</select><br/><br/>

<input type="submit" value="Jogar"></form>

<?php } else if($a=='duid') { ?>

<br/><div id="titulo"><b>Boteco contra <?php echo gerarnome($id);?></b></div><br/>
<div align="center">
<br/>
Escolha uma bebida para <?php echo gerarnome($id);?>, se ele acertar qual bebida você escolheu ele irá ganhar os pontos se ele errar você ganha.
<br/><br/>
<img src="imgs/cerveja.png"> Cerveja<br/><hr>
<img src="imgs/choop.png"> Choop<br/><hr>
<img src="imgs/margarita.png"> Margarita<br/><hr>
<img src="imgs/refrigerante.png"> Refrigerante<br/><hr>
<img src="imgs/vinho.png"> Vinho<br/><hr>
<br/>

<form action="boteco?a=du2" method="post">

<input type="hidden" name="ami" value="<?php echo $id;?>">
<br/>
Valor da aposta:<br/>
<input type="text" name="val" maxlength="3" size="3"><br/><br/>

Bebida:<br/>
<select name="bebida">
<option value="1">Cerveja</option>
<option value="2">Choop</option>
<option value="3">Margarita</option>
<option value="4">Refrigerante</option>
<option value="5">Vinho</option>
</select><br/><br/>

<input type="submit" value="Jogar"></form>

<?php } else if($a=='du2') { ?>

<br/><div id="titulo"><b>Boteco contra usuário</b></div><br/>
<div align="center">

<?php if($_POST['val']>20) { ?>
<br/><?php echo $imgerro;?> O limite máximo da aposta é de 20 Pontos!<br/><br/>
<?php } else {
$mistake->exec("INSERT INTO w_boteco (uid,aid,dt,qt,pt) values('$meuid','".$_POST['ami']."','".time()."','".$_POST['bebida']."','".$_POST['val']."')");
$idj = $mistake->query("SELECT id FROM w_boteco WHERE uid='$meuid' order by id desc limit 1")->fetch();
$msg = "Olá $dn[0], desafiei você no jogo do boteco, valendo ".$_POST['val']." pontos, quero ver você adivinhar qual bebida irei lhe servir. Para aceitar o desafio entre [boteco=/boteco?a=du3&id=$idj[0]]AQUI[/boteco]";
automsg($msg,$meuid,$_POST['ami']);

?>

Desafio feito com sucesso.

<?php } } else if($a=='du3') { ?>

<br/><div id="titulo"><b>Boteco contra usuário</b></div><br/>

<div align="center"><b>
<br/>
Tente adivinhar qual bebida foi servida para você.
<br/><br/>
<img src="imgs/cerveja.png"> Cerveja<br/><hr>
<img src="imgs/choop.png"> Choop<br/><hr>
<img src="imgs/margarita.png"> Margarita<br/><hr>
<img src="imgs/refrigerante.png"> Refrigerante<br/><hr>
<img src="imgs/vinho.png"> Vinho<br/><hr>
<br/>

<form action="boteco?a=du4&id=<?php echo $id;?>" method="post">

Bebida:<br/>
<select name="bebida">
<option value="1">Cerveja</option>
<option value="2">Choop</option>
<option value="3">Margarita</option>
<option value="4">Refrigerante</option>
<option value="5">Vinho</option>
</select><br/><br/>

<input type="submit" value="Jogar"></form>

<?php } else if($a=='du4') {

$cont = $mistake->query("SELECT count(*) FROM w_boteco WHERE id='$id'")->fetch();
$qtt = $mistake->query("SELECT * FROM w_boteco WHERE id='$id'")->fetch();

?>

<br/><div id="titulo"><b>Boteco contra usuário</b></div><br/>

<div align="center"><br/>

<?php if($cont[0]==0) { ?>

Esta aposta não existe mais<br/>

<?php } else if($qtt['aid']!=$meuid) { ?>

Este desafio não foi feito pra você<br/>

<?php } else if($cont[0]>0) {
if($qtt['qt']=='1'){
$bebidaok = "cerveja";
}else if($qtt['qt']=='2'){
$bebidaok = "choop";
}else if($qtt['qt']=='3'){
$bebidaok = "margarita";
}else if($qtt['qt']=='4'){
$bebidaok = "refrigerante";
}else if($qtt['qt']=='5'){
$bebidaok = "vinho";
}else{
$bebidaok = "cerveja";
}

if($_POST['bebida']=='1'){
$bebidaok2 = "cerveja";
}else if($_POST['bebida']=='2'){
$bebidaok2 = "choop";
}else if($_POST['bebida']=='3'){
$bebidaok2 = "margarita";
}else if($_POST['bebida']=='4'){
$bebidaok2 = "refrigerante";
}else if($_POST['bebida']=='5'){
$bebidaok2 = "vinho";
}else{
$bebidaok2 = "cerveja";
}
 
$qttt = $qtt['pt']; ?>

Jogo valendo <b><?php echo $qtt['pt'];?></b> pontos.<br/><br/>

<b><?php echo gerarnome($qtt['uid']);?></b> serviu para você <b><?php echo $bebidaok;?>
<img src="imgs/<?php echo $bebidaok;?>.png"><br/><br/>
<hr>
Você jogou <b><?php echo $bebidaok2;?></b>
<img src="imgs/<?php echo $bebidaok2;?>.png"><br/><br/>

<?php

if($_POST['bebida']==$qtt['qt'])
{
echo 'Você acertou a bebida! Parabéns';
$msg = "Olá $dn[0], você perdeu [b]".$qtt['pt']."[/b] Pontos no jogo do boteco, você me serviu $bebidaok e eu acertei!";
automsg($msg,$meuid,$qtt['uid']);
$mistake->exec("delete from w_boteco where id='$id'");
$mistake->exec("update w_usuarios set pt=pt+$qttt, boteco2=boteco2+1 where id='$meuid'");
$textoatividades = 'Jogou na brincadeira do boteco e ganhou 1 ponto de atividade';
$mistake->exec("update w_usuarios set pt=pt-$qttt, boteco2=boteco2-1 where id='".$qtt['uid']."'");
$textoatividades2 = 'Jogou na brincadeira do boteco e ganhou 1 ponto de atividade';
$nav = explode(" ",$_SERVER['HTTP_USER_AGENT'] );
$mistake->exec("INSERT INTO w_pontos (uid,aid,hr,rz,ip,nv,dt,pt) values('1','$meuid','".time()."','Acertou no jogo do boteco','".gerarip()."','$nav[0]','1','$qttt')");
$mistake->exec("INSERT INTO w_pontos (uid,aid,hr,rz,ip,nv,dt,pt) values('1','".$qtt['uid']."','".time()."','Errou no jogo do boteco','".gerarip()."','$nav[0]','0','$qttt')");
}
else if($_POST['bebida']!=$qtt['qt'])
{
echo "".gerarnome($qtt['uid'])." ganhou a aposta sozinho(a).";
$msg = "Olá $dn[0], você ganhou [b]".$qtt['pt']."[/b] Pontos no jogo do boteco, você me serviu $bebidaok e eu achei que fosse $bebidaok2!";
automsg($msg,$meuid,$qtt['uid']);
$mistake->exec("delete from w_boteco where id='$id'");
$mistake->exec("update w_usuarios set pt=pt-$qttt, boteco2=boteco2-1 where id='$meuid'");
$textoatividades = 'Jogou na brincadeira do boteco e ganhou 1 ponto de atividade';
$mistake->exec("update w_usuarios set pt=pt+$qttt, boteco2=boteco2+1 where id='".$qtt['uid']."'");
$textoatividades2 = 'Jogou na brincadeira do boteco e ganhou 1 ponto de atividade';
$nav = explode(" ",$_SERVER['HTTP_USER_AGENT'] );
$mistake->exec("INSERT INTO w_pontos (uid,aid,hr,rz,ip,nv,dt,pt) values('1','".$qtt['uid']."','".time()."','Acertou no jogo do boteco','".gerarip()."','$nav[0]','1','$qttt')");
$mistake->exec("INSERT INTO w_pontos (uid,aid,hr,rz,ip,nv,dt,pt) values('1','$meuid','".time()."','Errou no jogo do boteco','".gerarip()."','$nav[0]','0','$qttt')");
}}} ?>

<div align="center">
<?php if($a!=false){ ?>
<br/>
<a href="boteco">Jogar</a><br/><br/>
<?php } ?>
<a href="boteco?a=ranking">Ranking</a><br/><br/>
<a href="boteco?a=du">Desafiar amigo</a><br/><br/>
<a href="boteco?a=regras">Como funciona?</a><br/><br/>
<a href="entretenimento"><?php echo $imgservicos;?>Entretenimento</a><br/><br/>
<a href="home"><?php echo $imginicio;?>Página principal</a>

<?php echo rodape();?>

</body>
</html>