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
$idpergunta=isset($_POST['id'])?$_POST['id']:'0';
$qza = $mistake->query("SELECT * FROM bymistake_quizmural where id='".$idpergunta."'")->fetch();
$pontos = $qza['pontos'];
if($a==false) { ativo($meuid,'Respondendo quiz mural');?>
<div id="titulo"><b>Quiz mural</b></div><br/>
<div align="center">
<?php
if($qza!=0){
if($qza['pontos']>$im[12]){ 
echo "<br/>$imgerro Você não possui pontos suficientes para responder esta pergunta do quiz<br/><br/>";
}else if($_SESSION['quizmural']==$idpergunta){
echo "<br/>$imgerro Pergunta já respondida anteriormente.<br/><br/>";
}else{ ?>
<br/>Pergunta: <?php echo $qza['prg']?><br/><br/>

<?php
$_SESSION['quizmural'] = $idpergunta;
if($qza['ct']=='1'){
$correta = $qza['r1'];
}else if($qza['ct']=='2'){
$correta = $qza['r2'];
}else if($qza['ct']=='3'){
$correta = $qza['r3'];
}
if($_POST['r']==$qza['ct']){
$mistake->exec("update w_usuarios set pt=pt+$pontos, quizmural='1', quizmuralacertos=quizmuralacertos+1, quizmuralacertoshj=quizmuralacertoshj+1 WHERE id='$meuid'");
$frase = "<br/>$imgok Parabéns você acertou a resposta!<br/> Você ganhou $pontos pontos.</br>";
}else{
$mistake->exec("update w_usuarios set pt=pt-$pontos, quizmural='1', quizmuralerros=quizmuralerros+1, quizmuralerroshj=quizmuralerroshj+1 WHERE id='$meuid'");
$frase = "<br/>$imgerro Que pena você errou esta pergunta.<br/> A resposta correta é: $correta<br/><br/>Você perdeu $pontos pontos.";
}
?>
Obrigado por participar do Quiz mural<br/>
<?php echo $frase; ?>
<br/>

<?php }}else{ ?>
<div align="center"><br/>
No quiz mural você responde perguntas adicionadas pela equipe através do mural, para cada resposta certa você ganha os pontos que esta valendo e sobe um nível no ranking quiz mural, se você responder errado irá perder os pontos e seu nível de erros aumentar.<br/><br/>
<br/><?php echo $imgerro;?> Não existe nenhum quiz mural em andamento ainda ou a pergunta que você deseja responder já foi encerrada!<br/><br/><br/>
<?php }} else if($a=='ranking') { ativo($meuid,'Ranking Quiz mural');

if($e==false)
{
$pegar = 'quizmuralacertos';
$frase = 'Acertos geral';
$ea = 'acertos';
}
else if($e==1)
{
$pegar = 'quizmuralacertos';
$frase = 'Acertos geral';
$ea = 'acertos';
}
else if($e==2)
{
$pegar = 'quizmuralacertoshj';
$frase = 'Acertos de hoje';
$ea = 'acertos';
}
else if($e==3)
{
$pegar = 'quizmuralerros';
$frase = 'Erros geral';
$ea = 'erros';
}
else if($e==4)
{
$pegar = 'quizmuralerroshj';
$frase = 'Erros de hoje';
$ea = 'erros';
}
?>

<br/><div style="background-color:<?php echo $fundodestaque;?>;color:<?php echo $textodestaque;?>;text-align:center;<?php echo $borda;?>"><b>Ranking Quiz Mural <?php echo $frase;?></b></div><br/>

<div align="center">
<form action="quizmural" align="center" method="get">
<select name="e">
<option value="1">Acertos geral</option>
<option value="2" <?php echo $e==2?' selected ':'';?> >Acertos hoje</option>
<option value="3" <?php echo $e==3?' selected ':'';?> >Erros geral</option>
<option value="4" <?php echo $e==4?' selected ':'';?> >Erros hoje</option>
</select>
<input type="hidden" value="<?php echo $a;?>" name="a">
<input type="submit" value="IR">
</form></div><br/>

<?php
$contmsg = $mistake->query("SELECT count(*) FROM w_usuarios where $pegar>'0'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contmsg[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->query("SELECT id, $pegar FROM w_usuarios where $pegar>'0' order by $pegar desc limit $limit, $itensporpag");
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>

<div id="<?php echo $i%2==0?'div1':'div2';?>">
<a href="/perfil?=<?php echo $item->id;?>"><?php echo gerarnome($item->id);?></a> - <?php echo $item->$pegar.' '.$ea;?>
</div>

<?php $i++; } ?>

<br/><div align="center"><br/>

<?php if($pag>1) { $ppag = $pag-1; ?>

<a href="quizmural?a=ranking&e=<?php echo $e;?>&pag=<?php echo $ppag;?>">&#171;Anterior</a>

<?php } if($pag<$numpag) { $npag = $pag+1; ?>

<a href="quizmural?a=ranking&e=<?php echo $e;?>&pag=<?php echo $npag;?>">Próxima&#187;</a>

<?php } ?>

<br/><?php echo $pag.'/'.$numpag;?><br/>

<?php if($numpag>2) { ?>

<form action="quizmural" method="get">
Pular para página<input name="pag" size="3">
<input type="submit" value="IR">
<input type="hidden" name="a" value="<?php echo $a;?>">
<input type="hidden" name="e" value="<?php echo $e;?>">

</form>

<?php } } else { ?>

<div align="center"><?php echo $imgerro;?>Nenhum usuário!<br/><br/>

<?php } ?>

<br/><div align="center"><a href="quizmural">Quiz mural <?php echo $nomedosite;?></a>

<?php } ?>
	
<div align="center">
<a href="quizmural?a=ranking">Ranking</a><br/>
<a href="entretenimento"><?php echo $imgservicos;?>Entretenimento</a><br/>
<a href="home"><?php echo $imginicio;?>Página principal</a><br><br>

<?php echo rodape($meuid);?>

</body>
</html>
