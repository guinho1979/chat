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
if($a==false){ 
ativo($meuid,'pokemon');
?>
<br/><div id="titulo"><b>Regras Do pokemon</b></div><br/>
<div align="center">
Neste momento a brincadeira pokemon esta <?php echo $testearray[26]==1?'<b><u>Ativada</u></b>':'<b><u>Desativada</u></b>';?><br/><br/>No pokemon você pode ganhar 800 pontos ou perder 500 ao tentar encontrar capturar o pokemon. Mais você precisa ser rápido, os pokemon vão aparecer em vários lugares do site, mais você tem apenas 10 segundos, se você não capturar perderá 500 pontos e se você capturar ganha 800 pontos.</div>
<?php 
}else 
if($a=='capturar') { 
ativo($meuid,'pokemon');
if(pts($meuid)<800){
echo "<div align='center'><b>Voce precisa ter no minimo 800 Pontos!</b></div>";
?>
<div align="center">
<a href="/pokemon/ranking">Ranking</a><br/>
<a href="/entretenimento?"><?php echo $imgservicos;?>Entretenimento</a><br/>
<a href="/home?"><?php echo $imginicio;?>Página principal</a><br><br>
<?php 
echo 
rodape();
exit();
}
?>
<br/><div id="titulo"><b>Capturar Pokemon</b></div><br/>
<?php
$tempopoke = $_SESSION['tempopoke'];
if($tempopoke<time()-10){
$_SESSION['tempopoke'] = time()-10;
unset($_SESSION['tempopoke']);
$mistake->exec("UPDATE w_usuarios SET pt=pt-500 WHERE id='$meuid'");
?>
<br/><div align='center'>
<?php 
echo $imgerro;?>Você não capturou o pokemon, perdeu 500 pontos</div><?php 
}else{ 
$_SESSION['tempopoke'] = time()-10;
unset($_SESSION['tempopoke']);
$mistake->exec("UPDATE w_usuarios SET pt=pt+800 WHERE id='$meuid'");
$resm = $mistake->exec("INSERT INTO mmistake_pokemon (pegou,pokemon,data) values ('".$meuid."','".$id."','".time()."')");
?>
<br/><div align='center'><?php echo $imgok;?>Você capturou o pokemon! Parabéns acaba de ganhar 800 pontos.</div>
<?php 
}
}else 
if($a=='foto') { 
ativo($meuid,'foto premiada');
if(pts($meuid)<800){
echo "<div align='center'><b>Voce precisa ter no minimo 800 Pontos!</b></div>";
?>
<div align="center">
<a href="/pokemon/ranking">Ranking</a><br/>
<a href="/entretenimento?"><?php echo $imgservicos;?>Entretenimento</a><br/>
<a href="/home?"><?php echo $imginicio;?>Página principal</a><br><br>
<?php 
echo 
rodape();
exit();
}
?>
<br/><div id="titulo"><b>Foto premiada</b></div><br/>
<?php
$tempopoke = $_SESSION['fotopremiada'];
if($tempopoke==false){
?>
<br/><div align='center'>
<?php 
echo $imgerro;?>Você não pode fazer isso</div><?php 
}else{ 
$id = $mistake->prepare("SELECT * FROM w_usuarios WHERE id=:id OR lg=:lg OR nm=:nm");
$id->execute(array(":id" => "".mb_htmlentities($_POST['nomeuser'])."",":lg" => "".mb_htmlentities($_POST['nomeuser'])."",":nm" => "".mb_htmlentities($_POST['nomeuser']).""));
$id = $id->fetch();
if($id['id'] == base64_decode($_POST['iduser'])){
$_SESSION['fotopremiada'] = time()-10;
unset($_SESSION['fotopremiada']);
$mistake->exec("UPDATE w_usuarios SET pt=pt+300 WHERE id='$meuid'");
?>
<br/><div align='center'><?php echo $imgok;?>Você acertou a foto e de <?php echo gerarnome($id['id']);?>! Parabéns acaba de ganhar 300 pontos.</div>
<?php
}else{ 
unset($_SESSION['fotopremiada']);
$mistake->exec("UPDATE w_usuarios SET pt=pt-300 WHERE id='$meuid'");
?>
<br/><div align='center'>
<?php 
echo $imgerro;?>Você não acertou de quem era a foto, perdeu 300 pontos</div><?php 
}
}
setcookie("fotopremiada",1,(time() + (21600 * 1)),"/",".".str_replace("www.","",$_SERVER["HTTP_HOST"])."");
}else 
if($a=='camisinha') { 
ativo($meuid,'camisinha');
if(pts($meuid)<800){
echo "<div align='center'><b>Voce precisa ter no minimo 800 Pontos!</b></div>";
?>
<div align="center">
<a href="/pokemon/ranking">Ranking</a><br/>
<a href="/entretenimento?"><?php echo $imgservicos;?>Entretenimento</a><br/>
<a href="/home?"><?php echo $imginicio;?>Página principal</a><br><br>
<?php 
echo 
rodape();
exit();
}
?>
<br/><div id="titulo"><b>Capturar Camisinha</b></div><br/>
<?php
$tempopoke = $_SESSION['camisinha'];
if($tempopoke<time()-10){
$_SESSION['camisinha'] = time()-10;
unset($_SESSION['camisinha']);
$mistake->exec("UPDATE w_usuarios SET pt=pt-500 WHERE id='$meuid'");
?>
<br/><div align='center'>
<?php 
echo $imgerro;?>Você não capturou a camisinha, perdeu 500 pontos</div><?php 
}else{ 
$_SESSION['camisinha'] = time()-10;
unset($_SESSION['camisinha']);
$mistake->exec("UPDATE w_usuarios SET pt=pt+800 WHERE id='$meuid'");
?>
<br/><div align='center'><?php echo $imgok;?>Você capturou a camisinha! Parabéns acaba de ganhar 800 pontos.</div>
<?php 
}
}else 
if($a=='coelho') { 
ativo($meuid,'coelho da pascoa');
if(moedas($meuid)<8){
echo "<div align='center'><b>Voce precisa ter no minimo 8 moedas!</b></div>";
?>
<div align="center">
<a href="/pokemon/ranking">Ranking</a><br/>
<a href="/entretenimento?"><?php echo $imgservicos;?>Entretenimento</a><br/>
<a href="/home?"><?php echo $imginicio;?>Página principal</a><br><br>
<?php 
echo 
rodape();
exit();
}
?>
<br/><div id="titulo"><b>Capturar Coelho da pascoa</b></div><br/>
<?php
$tempopoke = $_SESSION['coelho'];
if($tempopoke<time()-10){
$_SESSION['coelho'] = time()-10;
unset($_SESSION['coelho']);
$mistake->exec("UPDATE w_usuarios SET pt=pt-500 WHERE id='$meuid'");
?>
<br/><div align='center'>
<?php 
echo $imgerro;?>Você não capturou o coelho, perdeu 500 pontos</div><?php 
}else{ 
$_SESSION['coelho'] = time()-10;
unset($_SESSION['coelho']);
$mistake->exec("UPDATE w_usuarios SET pt=pt+800,moedas=moedas+2 WHERE id='$meuid'");
?>
<br/><div align='center'><?php echo $imgok;?>Você capturou o coelho! Parabéns acaba de ganhar 800 pontos e 2 moedas.</div>
<?php 
}
}else 
if($a=='meus') { 
ativo($meuid,'pokemon');
$contmsg = $mistake->prepare("SELECT DISTINCT(pokemon),COUNT(DISTINCT pokemon),COUNT(pokemon) FROM mmistake_pokemon WHERE pegou='".$id."'");
$contmsg->execute(); 
$contmsg = $contmsg->fetch();
?>
<br/><div id="titulo"><b>Os <?php echo $contmsg[2];?> Pokemons De <?php echo gerarnome($id);?></b></div><br/>
<?
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contmsg[1];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag = $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->prepare("SELECT DISTINCT(pokemon),COUNT(id),pegou FROM mmistake_pokemon WHERE pegou='".$id."' GROUP BY pokemon HAVING COUNT(id)>0 ORDER BY COUNT(id) DESC LIMIT $limit, $itensporpag");
$itens->execute();
$i=0; 
while ($item = $itens->fetch()) {
?>
<div id="<?php echo $i%2==0?'div1':'div2';?>"><a href='/<?php echo gerarlogin($item['pegou']);?>'><?php echo gerarnome($item['pegou']);?></a><div><img src='/pokem/<?php echo $item['pokemon'];?>.png' style='width:70px;height:70px;'><div style='clear:both'></div><small>Capturou <b><?php echo $item[1];?></b> Desta Especie.</small></div></div>
<?
$i++; 
} 
if($numpag>1) { 
paginas('pokemon',$a,$numpag,$id,$pag); 
}
}else{ 
echo $imgerro;
?>
usuario nao capturou pokemons
<?php 
}  
}else
if($a=='ranking') { 
ativo($meuid,'pokemon');
?>
<br/><div id="titulo"><b>Ranking Do pokemon</b></div><br/>
<?php
$contmsg = $mistake->prepare("SELECT COUNT(DISTINCT pegou) FROM mmistake_pokemon WHERE pegou>0");
$contmsg->execute(); 
$contmsg = $contmsg->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contmsg[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag = $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->prepare("SELECT DISTINCT(pegou) FROM mmistake_pokemon GROUP BY pegou ORDER BY COUNT(pokemon) DESC LIMIT $limit, $itensporpag");
$itens->execute();
$i=0;
while ($item = $itens->fetch()) {
$peguei = $mistake->prepare("SELECT COUNT(pokemon) FROM mmistake_pokemon WHERE pegou='".$item[0]."'");
$peguei->execute();
$peguei = $peguei->fetch();
?>
<div id="<?php echo $i%2==0?'div1':'div2';?>"><a href="/pokemon/meus/<?php echo $item[0];?>"> <?php echo gerarnome($item[0]);?></a><br /><small>Capturou <?php echo $peguei[0];?> pokemons.</small></div>
<?
$i++; 
} 
if($numpag>1) { 
paginas('pokemon',$a,$numpag,$id,$pag); 
}
}else{ 
echo $imgerro;
?>
Nenhum pokemon capturado
<?php 
} 
} 
?>
<br/><div align="center">
<a href="/pokemon/ranking">Ranking</a><br/>
<a href="/entretenimento?"><?php echo $imgservicos;?>Entretenimento</a><br/>
<a href="/home?"><?php echo $imginicio;?>Página principal</a><br><br>
<?php echo rodape();?>
</body>
</html>