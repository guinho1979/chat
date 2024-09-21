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
ativo($meuid,'Pedra, papel e tesoura ');
if($a==false) { ?>
<br/><div id="titulo"><b>Ranking</b></div><br/>
<a href="/ppt/ranking/ppta">&#187;Vitórias</a><br/>
<a href="/ppt/ranking/ppte">&#187;Derrotas</a><br/>
<br/><div id="titulo"><b>Jogar</b></div><br/>
<form method="post" action="/ppt/jogar">
<select name="jogo">
<option value="1">Pedra</option>
<option value="2">Papel</option>
<option value="3">Tesoura</option></select><br/>
<input type="submit" value="Jogar"></form>
<?php } else if($a=='duelar') { ?>
<br/><div id="titulo"><b>Duelando com <?php echo gerarnome($id);?></b></div><br/>
<form method="post" action="/ppt/duelar2/<?php echo $id;?>">
<select name="jogo">
<option value="1">Pedra</option>
<option value="2">Papel</option>
<option value="3">Tesoura</option></select><br/>
<input type="submit" value="Jogar"></form>
<?php } else if($a=='duelar2') {
$mistake->exec("INSERT INTO w_ppt (uid,aid,op,dt) values('$meuid','$id','".$_POST['jogo']."','".time()."')");
$idj = $mistake->query("SELECT id FROM w_ppt WHERE uid='$meuid' order by id desc")->fetch();
$dn = $mistake->query("SELECT nm FROM w_usuarios WHERE id='$id'")->fetch();
$msg = "Olá ".html_entity_decode($dn[0]).", desafiei você no jogo Pedra, papel e tesoura. Para aceitar o desafio entre [link=/ppt/duelar3/".$idj[0]."]aqui[/link]";
automsg($msg,$meuid,$id); ?>
<br/><div align="center"><?php echo $imgok;?>Você desafiou <?php echo gerarnome($id);?><br/>
<?php } else if($a=='duelar3') {
$ct = $mistake->query("SELECT count(*) FROM w_ppt WHERE id='$id'")->fetch();
if($ct[0]==0) { ?>
<br/><div align="center"><?php echo $imgerro;?>Este desafio já foi aceito ou cancelado!<br/>
<?php } else { $ctt = $mistake->query("SELECT uid FROM w_ppt WHERE id='$id'")->fetch(); ?>
<br/><div id="titulo"><b>Duelando com <?php echo gerarnome($ctt[0]);?></b></div><br/>
<form method="post" action="/ppt/duelar4/<?php echo $id;?>">
<select name="jogo">
<option value="1">Pedra</option>
<option value="2">Papel</option>
<option value="3">Tesoura</option></select><br/>
<input type="submit" value="Jogar"></form>
<?php } } else if($a=='duelar4') {
$jogo = $_POST['jogo'];
$op = $mistake->query("SELECT op, uid FROM w_ppt WHERE id='$id'")->fetch();
$nm = $mistake->query("SELECT nm FROM w_usuarios WHERE id='$op[1]'")->fetch();
$jogopc = $op[0]; ?>
<br/><div id="titulo"><b>Duelando com <?php echo gerarnome($op[1]);?></b></div><br/>
<?php if($jogo==1) { if($jogopc==1) {
$msg = "Olá ".html_entity_decode($nm[0]).", eu escolhi pedra. Deu empate";
automsg($msg,$meuid,$op[1]);
?>
<a href="/<?php echo gerarlogin($meuid);?>"><?php echo gerarnome($meuid);?></a> : Pedra<br/>
<a href="/<?php echo gerarlogin($op[1]);?>"><?php echo gerarnome($op[1]);?></a> : Pedra<br/><br/>
<b>Deu empate!</b><br/>
Pontos: <?php echo pts($meuid);?>+0 = <?php echo pts($meuid);?><br/>
<?php } else if($jogopc==2) {
$mistake->exec("UPDATE w_usuarios SET pt=pt-1, ppte=ppte+1 WHERE id='$meuid'");
$mistake->exec("UPDATE w_usuarios SET pt=pt+1, ppta=ppta+1 WHERE id='$op[1]'");
$msg = "Olá ".html_entity_decode($nm[0]).", eu escolhi pedra. Você ganhou! Seus Pontos aumentaram para ".pts($op[1]).".";
automsg($msg,$meuid,$op[1]);
?>
<a href="/<?php echo gerarlogin($meuid);?>"><?php echo gerarnome($meuid);?></a> : Pedra<br/>
<a href="/<?php echo gerarlogin($op[1]);?>"><?php echo gerarnome($op[1]);?></a> : Papel<br/><br/>
<b>Você perdeu!</b><br/>
Pontos: <?php echo (pts($meuid)+1);?>-1 = <?php echo pts($meuid);?><br/>
<?php } else if($jogopc==3) {
$mistake->exec("UPDATE w_usuarios SET pt=pt+1, ppta=ppta+1 WHERE id='$meuid'");
$mistake->exec("UPDATE w_usuarios SET pt=pt-1, ppte=ppte+1 WHERE id='$op[1]'");
$msg = "Olá ".html_entity_decode($nm[0]).", eu escolhi pedra. Você perdeu! Seus Pontos diminuiram para ".pts($op[1]).".";
automsg($msg,$meuid,$op[1]);
?>
<a href="/<?php echo gerarlogin($meuid);?>"><?php echo gerarnome($meuid);?></a> : Pedra<br/>
<a href="/<?php echo gerarlogin($op[1]);?>"><?php echo gerarnome($op[1]);?></a> : Tesoura<br/><br/>
<b>Parabéns, você ganhou!</b><br/>
Pontos: <?php echo (pts($meuid)-1);?>+1 = <?php echo pts($meuid);?><br/>
<?php } } else if($jogo==2) { if($jogopc==1) {
$mistake->exec("UPDATE w_usuarios SET pt=pt+1, ppta=ppta+1 WHERE id='$meuid'");
$mistake->exec("UPDATE w_usuarios SET pt=pt-1, ppte=ppte+1 WHERE id='$op[1]'");
$msg = "Olá ".html_entity_decode($nm[0]).", eu escolhi papel. Você perdeu! Seus Pontos diminuiram para ".pts($op[1]).".";
automsg($msg,$meuid,$op[1]);
?>
<a href="/<?php echo gerarlogin($meuid);?>"><?php echo gerarnome($meuid);?></a> : Papel<br/>
<a href="/<?php echo gerarlogin($op[1]);?>"><?php echo gerarnome($op[1]);?></a> : Pedra<br/><br/>
<b>Parabéns, você ganhou!</b><br/>
Pontos: <?php echo (pts($meuid)-1);?>+1 = <?php echo pts($meuid);?><br/>
<?php } else if($jogopc==2) {
$msg = "Olá ".html_entity_decode($nm[0]).", eu escolhi papel. Deu empate!";
automsg($msg,$meuid,$op[1]);
?>
<a href="/<?php echo gerarlogin($meuid);?>"><?php echo gerarnome($meuid);?></a> : Papel<br/>
<a href="/<?php echo gerarlogin($op[1]);?>"><?php echo gerarnome($op[1]);?></a> : Papel<br/><br/>
<b>Deu empate!</b><br/>
Pontos: <?php echo pts($meuid);?>+0 = <?php echo pts($meuid);?><br/>
<?php } else if($jogopc==3) {
$mistake->exec("UPDATE w_usuarios SET pt=pt-1, ppte=ppte+1 WHERE id='$meuid'");
$mistake->exec("UPDATE w_usuarios SET pt=pt+1, ppta=ppta+1 WHERE id='$op[1]'");
$msg = "Olá ".html_entity_decode($nm[0]).", eu escolhi papel. Você ganhou! Seus Pontos aumentaram para ".pts($op[1]).".";
automsg($msg,$meuid,$op[1]);
?>
<a href="/<?php echo gerarlogin($meuid);?>"><?php echo gerarnome($meuid);?></a> : Papel<br/>
<a href="/<?php echo gerarlogin($op[1]);?>"><?php echo gerarnome($op[1]);?></a> : Tesoura<br/><br/>
<b>Você perdeu!</b><br/>
Pontos: <?php echo (pts($meuid)+1);?>-1 = <?php echo pts($meuid);?><br/>
<?php } } else if($jogo==3) { if($jogopc==1) {
$mistake->exec("UPDATE w_usuarios SET pt=pt-1, ppte=ppte+1 WHERE id='$meuid'");
$mistake->exec("UPDATE w_usuarios SET pt=pt+1, ppta=ppta+1 WHERE id='$op[1]'");
$msg = "Olá ".html_entity_decode($nm[0]).", eu escolhi tesoura. Você ganhou! Seus Pontos aumentaram para ".pts($op[1]).".";
automsg($msg,$meuid,$op[1]);
?>
<a href="/<?php echo gerarlogin($meuid);?>"><?php echo gerarnome($meuid);?></a> : Tesoura<br/>
<a href="/<?php echo gerarlogin($op[1]);?>"><?php echo gerarnome($op[1]);?></a> : Pedra<br/><br/>
<b>Você perdeu!</b><br/>
Pontos: <?php echo (pts($meuid)+1);?>-1 = <?php echo pts($meuid);?><br/>
<?php } else if($jogopc==2) {
$mistake->exec("UPDATE w_usuarios SET pt=pt+1, ppta=ppta+1 WHERE id='$meuid'");
$mistake->exec("UPDATE w_usuarios SET pt=pt-1, ppte=ppte+1 WHERE id='$op[1]'");
$msg = "Olá ".html_entity_decode($nm[0]).", eu escolhi tesoura. Você perdeu! Seus Pontos diminuiram para ".pts($op[1]).".";
automsg($msg,$meuid,$op[1]);
?>
<a href="/<?php echo gerarlogin($meuid);?>"><?php echo gerarnome($meuid);?></a> : Tesoura<br/>
<a href="/<?php echo gerarlogin($op[1]);?>"><?php echo gerarnome($op[1]);?></a> : Papel<br/><br/>
<b>Parabéns, você ganhou!</b><br/>
Pontos: <?php echo (pts($meuid)-1);?>+1 = <?php echo pts($meuid);?><br/>
<?php } else if($jogopc==3) {
$msg = "Olá ".html_entity_decode($nm[0]).", eu escolhi tesoura. Deu empate!";
automsg($msg,$meuid,$op[1]);
?>
<a href="/<?php echo gerarlogin($meuid);?>"><?php echo gerarnome($meuid);?></a> : Tesoura<br/>
<a href="/<?php echo gerarlogin($op[1]);?>"><?php echo gerarnome($op[1]);?></a> : Tesoura<br/><br/>
<b>Deu empate!</b><br/>
Pontos: <?php echo pts($meuid);?>+0 = <?php echo pts($meuid);?><br/>
<?php } }
$mistake->exec("DELETE FROM w_ppt WHERE id='$id'");
} else if($a=='jogar') {
$jogo = $_POST['jogo'];
$jogopc = rand(1,3);
?>
<br/><div id="titulo"><b>Pedra, Papel ou Tesoura</b></div><br/>
<?php if($jogo==1) { if($jogopc==1) { ?>
<a href="/<?php echo gerarlogin($meuid);?>"><?php echo gerarnome($meuid);?></a> : Pedra<br/>
<b>Sistema</b> : Pedra<br/><br/>
<b>Deu empate!</b><br/>
Pontos: <?php echo pts($meuid);?>+0 = <?php echo pts($meuid);?><br/>
<?php } else if($jogopc==2) {
$mistake->exec("UPDATE w_usuarios SET pt=pt-1, ppte=ppte+1 WHERE id='$meuid'"); ?>
<a href="/<?php echo gerarlogin($meuid);?>"><?php echo gerarnome($meuid);?></a> : Pedra<br/>
<b>Sistema</b> : Papel<br/><br/>
<b>Você perdeu!</b><br/>
Pontos: <?php echo (pts($meuid)+1);?>-1 = <?php echo pts($meuid);?><br/>
<?php } else if($jogopc==3) {
$mistake->exec("UPDATE w_usuarios SET pt=pt+1, ppta=ppta+1 WHERE id='$meuid'"); ?>
<a href="/<?php echo gerarlogin($meuid);?>"><?php echo gerarnome($meuid);?></a> : Pedra<br/>
<b>Sistema</b> : Tesoura<br/><br/>
<b>Parabéns, você ganhou!</b><br/>
Pontos: <?php echo (pts($meuid)-1);?>+1 = <?php echo pts($meuid);?><br/>
<?php } } else if($jogo==2) { if($jogopc==1) {
$mistake->exec("UPDATE w_usuarios SET pt=pt+1, ppta=ppta+1 WHERE id='$meuid'"); ?>
<a href="/<?php echo gerarlogin($meuid);?>"><?php echo gerarnome($meuid);?></a> : Papel<br/>
<b>Sistema</b> : Pedra<br/><br/>
<b>Parabéns, você ganhou!</b><br/>
Pontos: <?php echo (pts($meuid)-1);?>+1 = <?php echo pts($meuid);?><br/>
<?php } else if($jogopc==2) { ?>
<a href="/<?php echo gerarlogin($meuid);?>"><?php echo gerarnome($meuid);?></a> : Papel<br/>
<b>Sistema</b> : Papel<br/><br/>
<b>Deu empate!</b><br/>
Pontos: <?php echo pts($meuid);?>+0 = <?php echo pts($meuid);?><br/>
<?php } else if($jogopc==3) {
$mistake->exec("UPDATE w_usuarios SET pt=pt-1, ppte=ppte+1 WHERE id='$meuid'"); ?>
<a href="/<?php echo gerarlogin($meuid);?>"><?php echo gerarnome($meuid);?></a> : Papel<br/>
<b>Sistema</b> : Tesoura<br/><br/>
<b>Você perdeu!</b><br/>
Pontos: <?php echo (pts($meuid)+1);?>-1 = <?php echo pts($meuid);?><br/>
<?php } } else if($jogo==3) { if($jogopc==1) {
$mistake->exec("UPDATE w_usuarios SET pt=pt-1, ppte=ppte+1 WHERE id='$meuid'"); ?>
<a href="/perfil?/<?php echo gerarlogin($meuid);?>"><?php echo gerarnome($meuid);?></a> : Tesoura<br/>
<b>Sistema</b> : Pedra<br/><br/>
<b>Você perdeu!</b><br/>
Pontos: <?php echo (pts($meuid)+1);?>-1 = <?php echo pts($meuid);?><br/>
<?php } else if($jogopc==2) {
$mistake->exec("UPDATE w_usuarios SET pt=pt+1, ppta=ppta+1 WHERE id='$meuid'"); ?>
<a href="/<?php echo gerarlogin($meuid);?>"><?php echo gerarnome($meuid);?></a> : Tesoura<br/>
<b>Sistema</b> : Papel<br/><br/>
<b>Parabéns, você ganhou!</b><br/>
Pontos: <?php echo (pts($meuid)-1);?>+1 = <?php echo pts($meuid);?><br/>
<?php } else if($jogopc==3) { ?>
<a href="/<?php echo gerarlogin($meuid);?>"><?php echo gerarnome($meuid);?></a> : Tesoura<br/>
<b>Sistema</b> : Tesoura<br/><br/>
<b>Deu empate!</b><br/>
Pontos: <?php echo pts($meuid);?>+0 = <?php echo pts($meuid);?><br/>
<?php } } ?>
<br/><a href="/ppt?">Novo jogo</a><br/>
<?php } else if($a=='ranking') {
if($id=='ppta'){
$contmsg = $mistake->query("SELECT count(*) FROM w_usuarios where ppta>'0'")->fetch();
$qz = 'ppta';
$ea = 'vitória';
$tt = 'Vitórias';
}else{
$contmsg = $mistake->query("SELECT count(*) FROM w_usuarios where ppte>'0'")->fetch();
$qz = 'ppte';
$ea = 'derrota';
$tt = 'Derrotas';
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
if($id=='ppta'){
$itens = $mistake->query("SELECT id, $qz FROM w_usuarios where ppta>'0' order by ppta desc limit $limit, $itensporpag");
}else{
$itens = $mistake->query("SELECT id, $qz FROM w_usuarios where ppte>'0' order by ppte desc limit $limit, $itensporpag");
}
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<a href="/<?php echo gerarlogin($item->id);?>"><?php echo gerarnome($item->id);?></a> - <?php echo $item->$qz.' '.$ea.($item->$qz>1?'s':'');?>
</div>
<?php $i++; } 
if($numpag>1) {
paginas('ppt',$a,$numpag,$id,$pag);     
} } else { ?>
<div align="center">Nenhum usuário!<br/><br/>
<?php } ?>
<br/><div align="center"><a href="/ppt?">Pedra, papel e tesoura</a>
<?php } ?>
<br/><div align="center"><a href="/home?"><?php echo $imginicio;?>Página principal</a><br><br>
<?php echo rodape();?>
</body>
</html>