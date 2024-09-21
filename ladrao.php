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

$i =  $mistake->query("SELECT ocimg, ladrao FROM w_usuarios WHERE id='$meuid'")->fetch();
if($i[0]==1){ require 'imgs/home.php'; }

ativo($meuid,'Caça ao ladrao');

if($a==false) {  ?>

<br/><div id="titulo"><b>Caça ao ladrao <?php echo $nomedosite;?></b></div><br/>

<div align="center"><img src="imgs/ladron.gif"><br/><br/>

<a href="ladrao?a=ativar&e=<?php echo $i[1]==0?'1':'0';?>"><?php echo $i[1]==0?'Ativar':'Desativar';?> Caça ao ladrao</a><br/>

<br/>

<?php } else if($a=='ativar') { ?>

<br/><div id="titulo"><b>Caça ao ladrao <?php echo $nomedosite;?></b></div><br/>

<?php 
if($e==1){
$ativar = '1';
$frase = 'ativado';
}else{
$ativar = '0';
$frase = 'desativado';
}
 $mistake->exec("UPDATE w_usuarios SET ladrao='$ativar' where id='$meuid'");
$textoatividades = 'Jogou na brincadeira Caça ao ladrao e ganhou 1 ponto de atividade';
//iatividades($meuid,$textoatividades,'1','+');
?>
<div align="center">
<b>Caça ao ladrao <?php echo $frase;?> com sucesso!</b><br/><br/>
<br/><div align="center"><a href="ladrao">Caça ao ladrao <?php echo $nomedosite;?></a><br/>
<?php }else if($a=='regras'){ ?>
<br/><div id="titulo"><b>Regras do Caça ao ladrao</b></div><br/>
<div align="center">
<br/>No Caça ao ladrao você pode ganhar 20 pontos ou perder 5 ao tentar pegar uma ladrao. Mais você precisa ser rápido, após ativar a Caça ao ladrao ela vai aparecer em vários lugares do site e você terá apenas 10 segundos, se a ladrao fugir você perde 5 pontos e se você pega-la ganha 20 pontos. Você pode desativar ou ativar a Caça ao ladrao quando quiser e não paga nada.
<br/><br/>
<br/><div align="center"><a href="ladrao">Caça ao ladrao <?php echo $nomedosite;?></a><br/>

<?php } else if($a=='capturar') { ?>

<br/><div id="titulo"><b>Captura da ladrao</b></div><br/>
<div align="center"
<?php
$temporato = $_SESSION['tempoladrao'];
if($temporato<time()-10){
$_SESSION['tempoladrao'] = time()-10;
 $mistake->exec("update w_usuarios set pt=pt-5 where id='$meuid'");
$textoatividades = 'Jogou na brincadeira Caça ao ladrao e ganhou 1 ponto de atividade';
//iatividades($meuid,$textoatividades,'1','+');
?>
<br/><?php echo $imgerro;?>Você não capturou a ladrao em menos de 10 segundos, perdeu 5 pontos<br/><br/>
<?php }else{ 
$_SESSION['tempoladrao'] = time()-10;
 $mistake->exec("update w_usuarios set pt=pt+20, ladrao2=ladrao2+1 where id='$meuid'");
$textoatividades = 'Jogou na brincadeira Caça ao ladrao e ganhou 1 ponto de atividade';
//iatividades($meuid,$textoatividades,'1','+');
?>
<br/><?php echo $imgok;?>Você capturou a ladrao! Parabéns acaba de ganhar 20 pontos.<br/><br/>

<?php } } else if($a=='ranking') { ?>

<br/><div id="titulo"><b>Raking Caça ao ladrao</b></div><br/>

<?php
$contmsg =  $mistake->query("SELECT count(*) FROM w_usuarios where ladrao2>'0'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contmsg[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens =  $mistake->query("SELECT id, ladrao2 FROM w_usuarios where ladrao2>'0' order by ladrao2 desc limit $limit, $itensporpag");
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>

<div id="<?php echo $i%2==0?'div1':'div2';?>">
<a href="<?php echo gerarlogin($item->id);?>"><?php echo gerarnome($item->id);?></a> - Pegou <?php echo $item->ladrao2;?> ladrao
</div>

<?php $i++; } ?>

<br/><div align="center"><br/>

<?php if($pag>1) { $ppag = $pag-1; ?>

<a href="ladrao?a=ranking&pag=<?php echo $ppag;?>">&#171;Anterior</a>

<?php } if($pag<$numpag) { $npag = $pag+1; ?>

<a href="ladrao?a=ranking&pag=<?php echo $npag;?>">Próxima&#187;</a>

<?php } ?>

<br/><?php echo $pag.'/'.$numpag;?><br/>

<?php if($numpag>2) { ?>

<form action="ladrao" method="get">
Pular para página<input name="pag" size="3">
<input type="submit" value="IR">
<input type="hidden" name="a" value="<?php echo $a;?>">
</form>

<?php } } else { ?>

<div align="center">Nenhum usuário ainda pegou ladrao!<br/><br/>

<?php } ?>

<br/><div align="center"><a href="ladrao">Caça ao ladrao <?php echo $nomedosite;?></a><br/>

<?php } ?>
	
<div align="center">
<a href="ladrao?a=ranking">Ranking</a><br/>
<a href="ladrao?a=regras">Como funciona?</a><br/>
<a href="entretenimento"><?php echo $imgservicos;?>Entretenimento</a><br/>
<a href="home"><?php echo $imginicio;?>Página principal</a>

<?php echo rodape(); ?>

</body>
</html>
