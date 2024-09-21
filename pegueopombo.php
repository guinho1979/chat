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
ativo($meuid,'Pegue o pombo');
if($a==false) {  ?>
<br/><div id="titulo"><b>Pegue o pombo</b></div><br/>
<div align="center"><img src="/imgs/pombo.gif"><br/><br/>
Neste momento a brincadeira pegue o pombo esta <?php echo $testearray[27]==1?'<b><u>Ativada</u></b>':'<b><u>Desativada</u></b>';?><br/><br/>
Agora basta você começar a navegador no site e não deixe o pombo escapar!<br/>
<br/>
<?php }else if($a=='regras'){ ?>
<br/><div id="titulo"><b>Regras do pegue o pombo</b></div><br/>
<div align="center">
<br/>No pegue o pombo você pode ganhar 20 pontos ou perder 5 ao tentar encontrar capturar o pombo. Mais você precisa ser rápido, os pombos vão aparecer em vários lugares do site, mais você tem apenas 10 segundos, se você não capturar perderá 5 pontos e se você capturar ganha 20 pontos. A equipe do site será responsável por ativar ou desativar o pegue o pombo.
<br/><br/>
<br/><div align="center"><a href="/pegueopombo">Pegue o pombo</a><br/>
<?php } else if($a=='capturar') { ?>
<br/><div id="titulo"><b>Capturar pombo</b></div><br/>
<div align="center"
<?php
$tempopombo = $_SESSION['tempopombo'];
if($tempopombo<time()-10){
$_SESSION['tempopombo'] = time()-10;
$mistake->exec("update w_usuarios set pt=pt-5 where id='$meuid'");
?>
<br/><?php echo $imgerro;?>Você não capturou o pombo em menos de 10 segundos, perdeu 5 pontos<br/><br/>
<?php }else{ 
$_SESSION['tempopombo'] = time()-10;
$mistake->exec("update w_usuarios set pt=pt+20,pombo=pombo+1 where id='$meuid'");
?>
<br/><?php echo $imgok;?>Você capturou o pombo! Parabéns acaba de ganhar 20 pontos.<br/><br/>
<?php } } else if($a=='ranking') { ?>
<br/><div id="titulo"><b>Ranking do pegue o pombo</b></div><br/>
<?php
$contmsg = $mistake->query("SELECT count(*) FROM w_usuarios where pombo>'0'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contmsg[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->query("SELECT id,pombo FROM w_usuarios where pombo>'0' order by pombo desc limit $limit, $itensporpag");
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<a href="/<?php echo gerarlogin($item->id);?>"><?php echo gerarnome($item->id);?></a> - Capturou <?php echo $item->pombo;?> pombo(s)
</div>
<?php $i++; } if($numpag>1) {
paginas('pegueopombo',$a,$numpag,$id,$pag);     
} } else { ?>
<div align="center">Nenhum usuário ainda capturou pombos!<br/><br/>
<?php } ?>
<br/><div align="center"><a href="/pegueopombo">Pegue o pombo <?php echo $nomedosite;?></a><br/>
<?php } ?>
<div align="center"><br/>
<a href="/pegueopombo/ranking">Ranking</a><br/><br/>
<a href="/pegueopombo/regras">Como funciona?</a><br/><br/>
<a href="/entretenimento"><?php echo $imgservicos;?>Entretenimento</a><br/><br/>
<a href="/home"><?php echo $imginicio;?>Página principal</a><br><br>
<?php 
echo rodape();
?>
</body>
</html>