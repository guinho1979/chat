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
echo "<br><div id='titulo'> Entrevista </div><br>";
ativo($meuid,'entrevistado');
if($a=="a"||$a==FALSE){
$result = $mistake->prepare("select * from Mmistake_gato where categoria='m2g'");
$result->execute();
$mg =  $result->rowCount();
$result = $mistake->prepare("select * from Mmistake_gato where categoria='f2g'");
$result->execute();
$fg =  $result->rowCount();
echo "<p align='center'>";
echo "<img src='/imagens/entrevista.gif' alt='entrevista'/></br>";
echo "</p>";
echo "<div><img src='/imagens/atencao.png' alt='sobre'/> <a href=\"/gato?a=regras\">Regras sobre a entrevista </a></div>";
echo "<div><img src=\"/imagens/gato.png\" alt=\"\"/><a title=\"Entre\" href=\"/gato?a=gatover&id=m2g\">Homens inscritos</a>($mg)<br></div>";
echo "<div><img src=\"/imagens/gata.png\" alt=\"\"/><a title=\"Entre\" href=\"/gato?a=gatover&id=f2g\">mulheres inscritas</a>($fg)<br></div>";
$abrir1 = $mistake->prepare("SELECT gatov FROM Mmistake_gato");
$abrir1->execute();
$abrir1 = $abrir1->fetch();
if($abrir1[0]!= "0"){
echo "<div><img src='/imagens/cadasto.png' alt='cadastro'/><a href=\"/gato?a=inscrever\">Inscrever-se</a></div>";
}else{
echo "<div><img src='/imagens/cadasto.png' alt='cadastro'/><a href=\"/gato?a=add\">Inscrever-se</a></div>";
}
echo "<p align='center'>";
if($testearray[53] > 0){
$whonick = gerarnome($testearray[53]);
$link = "<a href='/".gerarlogin($testearray[53])."'>$whonick</a>";
echo "Gata do Mes: $link<br>";
}
if($testearray[52] > 0){
$whonick = gerarnome($testearray[52]);
$lnk = "<a href='/".gerarlogin($testearray[52])."'>$whonick</a>";
echo "Gato do Mes: $lnk<br>";
}
}else 
if($a=="main"){
$result = $mistake->prepare("select * from Mmistake_gato where categoria='m2g'");
$result->execute();
$mg =  $result->rowCount();
$result = $mistake->prepare("select * from Mmistake_gato where categoria='f2g'");
$result->execute();
$fg =  $result->rowCount();
echo "<div><img src=\"/imagens/gato.png\" alt=\"\"/><a title=\"Enter\" href=\"/gato?a=gatover&id=m2g\">Homens Inscritos</a>($mg)<br></div>";
echo "<div><img src=\"/imagens/gata.png\" alt=\"\"/><a title=\"Enter\" href=\"/gato?a=gatover&id=f2g\">Mulheres Inscritas</a>($fg)<br></div>";
echo "<p align='center'>";
echo "<img src='imagens/entrevista.gif' alt='Gato e Gata'/></br><a href=\"/gato\">Entrevista</a></br>";
echo "</p>";
}else 
if($a=="gatover"){
if($pag==""){
$pag=1;
}
$max_results = 50;
$from = (($pag * $max_results) - $max_results);
echo "<p>";
$total_results = $mistake->prepare("SELECT COUNT(*) FROM Mmistake_gato WHERE categoria='$id'");
$total_results->execute();
$total_results = $total_results->fetch();
if($total_results[0]<1){
echo "Não há membros nesta categoria<br>";
}else{
$num_pages = ceil($total_results[0] / $max_results);
$sql = $mistake->prepare("SELECT * FROM Mmistake_gato WHERE categoria='$id'  ORDER BY id desc LIMIT $from, $max_results");
$sql->execute();
while ($row = $sql->fetch()){
$key = $row['id'];
$sqlthing = $mistake->prepare("SELECT * FROM w_usuarios WHERE id='".$row['uid']."'");
$sqlthing->execute();
$sqlthing = $sqlthing->fetch();
$age=idade($sqlthing["nasc"]);
$color = ($num % 2 == 0)? "<div id='div1'>"  : "<div id='div2'>";
echo "$color".gerarfoto($row['uid'])."".gerarnome($row['uid'])."<a href=\"/gato?a=card&id=".$row['uid']."\">Ver Mais</a>" ;
$fan = $mistake->prepare("SELECT COUNT(uid) FROM Mmistake_gatov WHERE who='".$row['uid']."'");
$fan->execute();
$fan = $fan->fetch();
$abrir = $mistake->prepare("SELECT gatov FROM Mmistake_gato");
$abrir->execute();
$abrir = $abrir->fetch();
if($abrir[0] != "0"){
echo "<br><a href='/gatov?a=a&id=".$row['uid']."'>Ver votos/votar($fan[0])</b></a></div>";
}else{
echo "<br><b>Votação Fechada</b></div>";
}
$num++;
}
?>
<br/>
<div align="center"><br/>
<?php if($pag>1) { $ppag = $pag-1; ?>
<a href="gato?pag=<?php echo $ppag;?>">&#171;Anterior</a>
<?php } if($pag<$num_pages) { $npag = $pag+1; ?>
<a href="gato?pag=<?php echo $npag;?>">Próxima&#187;</a>
<?php } ?> <br/> <?php echo $pag.'/'.$from;?><br/>
<?php if($num_pages>2) { ?>
<form action="gato?" method="get">
Pular para página<input name="pag" size="3">
<input type="submit" value="IR">
</form>
<?php 
}
echo "<p align='center'>";
echo "<img src='/imagens/entrevista.gif' alt='gatogata'/></br><a href=\"/gato\">Entrevista</a></br>";
echo "</p>";
}
}else 
if($a=="card"){
$sql = $mistake->prepare("SELECT * FROM Mmistake_gato WHERE uid='".$id."'");
$sql->execute();
$sql = $sql->fetch();
$usid = $sql["uid"];
echo "<p>";
echo "<div><b>*Nick*:</b> <a href='/".gerarlogin($usid)."'>".gerarnome($usid)."</a><br></div>";
$age = $mistake->prepare("SELECT nasc FROM w_usuarios WHERE id='".$usid."'");
$age->execute();
$age = $age->fetch();
$uage = idade($age[0]);
if(perm($meuid)==3 or perm($meuid)==4){
$del = "<a href='/gato?a=e&id=$id'>[x]</a>";
}else{
$del = "";
}
echo "<div><b>*Idade:</b> $uage $del</div>";
$nopl = $mistake->prepare("SELECT id FROM w_albuns WHERE dn='".$usid."'");
$nopl->execute();
$nopl = $nopl->fetch();
$fotos = $mistake->prepare("SELECT COUNT(*) FROM w_fotos WHERE dono='".$usid."'");
$fotos->execute();
$fotos = $fotos->fetch();
//echo "<div><a href='/galeria?a=album&id=".$nopl[0]."'>Ver album($fotos[0])</b></a></div>";
$fan = $mistake->prepare("SELECT COUNT(uid) FROM Mmistake_gatov WHERE who='".$usid."'");
$fan->execute();
$fan = $fan->fetch();
$abrir = $mistake->prepare("SELECT gatov FROM Mmistake_gato");
$abrir->execute();
$abrir = $abrir->fetch();
if($abrir[0] != "0"){
echo "<div><a href='/gatov?a=a&id=".$usid."'>Ver votos/votar($fan[0])</b></a></div>";
}else{
echo "<div><b>Votação Fechada</b></div>";
}
echo "<p align='center'>";
echo "<img src='/imagens/entrevista.gif' alt='gatogata'/></br><a href=\"/gato\">Entrevista</a></br>";
echo "</p>";
}else 
if($a=="add"){
echo "<p>";
echo "Inscreva-se para a entrevista da semana</p><br><br>";
echo "<a href='/gato?a=add2'>»Inscrever</a><br><br>";
if(perm($meuid)==3 or perm($meuid)==4){
echo "<a href='/gato?a=inscri'>»Abrir votação</a><br><br>";
}
echo "<p align='center'>";
echo "<img src='/imagens/entrevista.gif' alt='gatogata'/></br><a href=\"/gato\">Entrevista</a></br>";
echo "</p>";
}else 
if($a=="add2"){
$uiw = 1;
$nopls = $mistake->prepare("SELECT sx FROM w_usuarios WHERE id='".$meuid."'");
$nopls->execute();
$nopls = $nopls->fetch();
if($nopls[0]=="M"){
$categoria = "m2g";
}else
if($nopls[0]=="F"){
$categoria = "f2g";
}
$result = $mistake->prepare("select * from Mmistake_gato where uid='".$meuid."'");
$result->execute();
$number_of_rows = $result->rowCount();
if ($number_of_rows>0){
$problems="1";
echo "<p align='center'>";
echo "Voce ja esta inscrito(a)!<br>";
echo "<img src='/imagens/entrevista.gif' alt='gato'/></br><a href=\"/gato\">Entrevista</a></br>";
echo "</p>";
}
if ($problems==""){
$sql = "INSERT INTO Mmistake_gato (uid,categoria) VALUES ('$meuid','$categoria')";
$result = $mistake->exec($sql);
echo "<p align='center'>";
echo "Sua inscriçao foi efetuada com sucesso</br>";
echo "<img src='/imagens/entrevista.gif' alt='gatogata'/></br><a href=\"/gato\">Entrevista</a></br>";
echo "</p>";
}
}else 
if($a == "regras"){
echo "<div><center><b>Regras</b>
</br>Você poderá votar em apenas um usuário para entrevista, Será adicionado automaticamente <b>500 pontos</b> em seu perfil. 2 votos no mesmo candidato será anulado, e você perderá <b> 2000 pontos </b> encerrado a votação será feito uma página onde o ganhador responderá as perguntas dos usuários, a cada pergunta respondida pelo entrevistado ele ganha <b> 50 pontos </b> + bônus de <b>5000 pontos</b></center></div><br>";
echo "<p align='center'>";
echo "<img src='/imagens/entrevista.gif' alt='gatogata'/></br><a href=\"/gato\">Entrevista</a></br>";
echo "</p>";
}else 
if($a == "inscrever"){
$result = $mistake->prepare("select * from Mmistake_gato where categoria='m2g'");
$result->execute();
$mg = $result->rowCount();
$result = $mistake->prepare("select * from Mmistake_gato where categoria='f2g'");
$result->execute();
$fg = $result->rowCount();
echo "<p align='center'>";
echo "<img src='/imagens/notok.gif' alt='x'/><br>As inscriçôes dessa semana já terminaram<br>";
echo "</p>";
echo "<div>Você poderá votar em uma pessoa e a cada voto sera adicionado automaticamente 500 pontos em seu perfil.</div><br>";
echo "<div><img src=\"/imagens/gato.png\" alt=\"\"/><a title=\"Enter\" href=\"/gato?a=gatover&id=m2g\">Escolha um  pra votar</a>($mg)<br></div>";
echo "<div><img src=\"/imagens/gata.png\" alt=\"\"/><a title=\"Enter\" href=\"/gato?a=gatover&id=f2g\">Escolha um pra votar</a>($fg)<br></div>";
if(perm($meuid)==3 or perm($meuid)==4){
echo "<a href='/gato?a=inscri'>»Abrir Inscrições</a><br><br>";
}
echo "<p align='center'>";
echo "<img src='/imagens/entrevista.gif' alt='gatogata'/></br><a href=\"/gato\">Entrevista</a></br>";
echo "</p>";
}else 
if($a == "inscri"){
if(perm($meuid)==3 or perm($meuid)==4){
if($e == "limpar"){
$res = $mistake->exec("TRUNCATE TABLE Mmistake_gato");
if($res){
echo "<p align='center'>";
echo "<img src='/imagens/ok.gif' alt='ok'/><br>Entrevista zerado com sucesso<br>";
echo "</p>";
}else{
echo "<p align='center'>";
echo "<img src='/imagens/notok.gif' alt='atencao'/><br>Erro ao zerar entrevista<br>";
echo "</p>";
}
}
if($e == "limparv"){
$res = $mistake->exec("TRUNCATE TABLE Mmistake_gatov");
if($res){
echo "<p align='center'>";
echo "<img src='/imagens/ok.gif' alt='ok'/><br>Votos zerados com sucesso<br>";
echo "</p>";
}else{
echo "<p align='center'>";
echo "<img src='/imagens/notok.gif' alt='atencao'/><br>Erro ao zerar votos<br>";
echo "</p>";
}
}
if($e == "limpart"){
$res = $mistake->exec("INSERT INTO Mmistake_gato SET uid='1',categoria='f2g'");	
if($res){
echo "<p align='center'>";
echo "<img src='/imagens/ok.gif' alt='ok'/><br>Inscriçoes liberadas com sucesso<br>";
echo "</p>";
}else{
echo "<p align='center'>";
echo "<img src='/imagens/notok.gif' alt='atencao'/><br>Erro ao liberar inscrições<br>";
echo "</p>";
}
}
if($e == "vot"){
$res = $mistake->exec("UPDATE Mmistake_gato SET gatov='1'");
if($res){
echo "<p align='center'>";
echo "<img src='/imagens/ok.gif' alt='ok'/><br>Votações liberadas com sucesso<br>";
echo "</p>";
}else{
echo "<p align='center'>";
echo "<img src='/imagens/notok.gif' alt='atencao'/><br>Erro ao liberar votações<br>";
echo "</p>";
}
}
echo "<div>Ferramentas para liberar inscrições:<br></div><br><br>";
echo "<div><a href='/gato?a=inscri&e=limpar'>[limpar todos inscritos]</a></div><br>";
echo "<div><a href='/gato?a=inscri&e=limparv'>[limpar todos votos]</a></div><br>";
echo "<div><a href='/gato?a=inscri&e=limpart'>[liberar inscrições]</a></div><br>";
echo "<div><a href='/gato?a=inscri&e=vot'>[fechar inscrições e abrir votação]</a></div>";
}else{
echo "<p align='center'>";
echo "<img src='/imagens/notok.gif' alt='atencao'/>Voce nao tem permissao para vizualizar essa pagina<br>";
echo "</p>";
}
echo "<p align='center'>";
echo "<img src='/imagens/entrevista.gif' alt='gatogata'/></br><a href=\"/gato\">Entrevista </a></br>";
echo "</p>";
}else 
if($a=="e"){
if(perm($meuid)==3 or perm($meuid)==4){
echo "<p align='center'>";
$res = $mistake->exec("DELETE FROM Mmistake_gato WHERE uid='".$id."'");
if($res){
echo "<img src='/imagens/ok.gif' alt='ok'/><br>Excluido com sucesso";
}else{
echo "<img src='/imagens/notok.gif' alt='antencao'/><br>Erro no Banco de Dados!";
}
}
}
?>
<br/><div align="center"><a href="home?"><?php echo $imginicio;?>Página principal</a><br><br>
<?php echo rodape();?>
</body>
</html>