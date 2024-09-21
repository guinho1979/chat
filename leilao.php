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
ativo($meuid,'Leilão',$mistake);
if($a==false) {
function converterdata($dt) { 
$yr=strval(substr($dt,0,4)); 
$mo=strval(substr($dt,5,2)); 
$da=strval(substr($dt,8,2)); 
$hr=strval(substr($dt,11,2)); 
$mi=strval(substr($dt,14,2)); 
$se=strval(substr($dt,17,2)); 
return mktime($hr,$mi,$se,$mo,$da,$yr); 
}
$lance = $mistake->query("SELECT por, hora, valor FROM bymistake_leilaolances ORDER BY valor DESC LIMIT 1")->fetch();
$leilao = $mistake->query("SELECT * FROM bymistake_leilao")->fetch();?>
<br/><div id="titulo"><b>Leilão <?php echo nome_site();?></b></div><br/>
<div align="center"><br/>
<img src="imgs/lailao.gif">
<br/>
<?php
if ($leilao['objeto']==''){
if (perm($meuid,$mistake)>0){ ?>
<br/><br/><a href="leilao?a=adicionar">Adicionar novo leilão</a><br/><br/>
<?php 
} 
?>
<br/><b>Nenhum objeto esta sendo leiloado no momento.</b><br/><br/>
<?php 
}else{ 
$quandovaiterminarok = $leilao['termina'];
$datparaterminar = converterdata($quandovaiterminarok);
$horaokk = time();
if($horaokk>$datparaterminar){
$objetookk = $leilao['objeto'];
$mistake->exec("UPDATE bymistake_leilao SET objetoganhado='$objetookk', ganhador='$lance[0]', valoroferecido='$lance[2]', horalance='$lance[1]',objeto='' where id='1'");
$msgdoriann = "Você foi o arrematador do leilão. Comprou [b]".$objetookk."[/b] por [b]".$lance[2]."[/b] pontos, parabéns.";
automsg($msgdoriann,2,$lance[0]);
$mistake->exec("UPDATE w_usuarios SET pt=pt-$lance[2] where id='$lance[0]'");
$nav = explode(" ",$_SERVER['HTTP_USER_AGENT'] );
$mistake->exec("TRUNCATE bymistake_leilaolances");
}
?>
<br/>Objeto sendo leiloado<br/><?php echo textot($leilao['objeto'],$meuid,$on);?><br/>Data que termina este leilão<br/>
<?php
$testeok = $leilao['termina'];
$dataantiga = converterdata($testeok);
$nova_data=date("d/m/Y G:i:s", $dataantiga);
echo $nova_data;
?>
<br/>O maior lance até agora foi dado por <a href="/<?php echo gerarlogin($lance[0]);?>"><?php echo gerarnome($lance[0]);?></a> com o valor de <?php echo $lance[2];?> pontos.<br/><br/>Dê seu lance agora mesmo!<br/><br/>
<form action="leilao?a=responder" align="center" method="post">
<input type="text" size="7" name="valor" maxlength="10"><br/><br/>
<input type="submit" value="Enviar" /><br/>
</form>
<br/>
<?php } 
$horadolanceantigo=$leilao['horalance'];
$datadolanceokk=date("d/m/Y G:i:s",$horadolanceantigo);
?>
O último arrematador do leilão foi <a href="/<?php echo gerarlogin($leilao['ganhador']);?>"><?php echo gerarnome($leilao['ganhador']);?></a><br/>que comprou <?php echo textot($leilao['objetoganhado'],$meuid,$on);?><br/>por <?php echo $leilao['valoroferecido'];?> pontos.<br/>Seu lance foi dado em: <?php echo $datadolanceokk;?><br/><br/>
<?php } else if ($a=='adicionar'){ 
if (perm($meuid,$mistake)>0){ ?>
<br/><div id="titulo"><b>Leilão <?php echo nome_site();?></b></div><br/>
<div align="center"><br/>
<form action="leilao?a=enviar" align="center" method="post">
<br/>
Objeto a ser leiloado<br/>
<textarea name="objeto" maxlength="500" value="" rows="5" cols="25"></textarea><br/><br/>
Hora para encerrar o leilão<br/>
Dia: <input type="text" size="3" name="dia" maxlength="2"> Mês: <input type="text" size="3" name="mes" maxlength="2"> Ano: <input type="text" size="5" name="ano" maxlength="4"><br/><br/>
Hora: <input type="text" size="3" name="hora" maxlength="2"> Minutos: <input type="text" size="3" name="minutos" maxlength="2"> Segundos: <input type="text" size="3" name="segundos" maxlength="2"><br/><br/>
<input type="submit" value="Enviar" /><br/>
</form><br/>Ex a ser usado= Dia: 01 - Mês: 01 - Ano: <?php echo date("Y");?><br/>Hora: 06 - Minutos: 01 - Segundos: 01<br/><br/></div>
<?php 
}else{ 
?>
<br/><center>
<?php echo $imgerro;?> Você não faz parte da equipe! </center><br/><br/>
<?php } } else if($a=='enviar'){ ?>
<br/><div id="titulo"><b>Leilão <?php echo nome_site();?></b></div><br/>
<div align="center"><br/>
<?php
if(trim($_POST['objeto'])=='' or trim($_POST['dia'])=='' or trim($_POST['mes'])=='' or trim($_POST['ano'])=='' or trim($_POST['hora'])=='' or trim($_POST['minutos'])=='' or trim($_POST['segundos'])=='') { ?>
<br/>
<?php echo $imgerro;?> Todos os campos são obrigatórios!<br/><br/>

<?php } else if(strlen($_POST['dia'])!=2) {?>
<br/>
<?php echo $imgerro;?> No campo dia você tem postar 2 caracteres!<br/><br/>

<?php } else if(strlen($_POST['mes'])!=2) {?>
<br/>
<?php echo $imgerro;?> No campo mês você tem postar 2 caracteres!<br/><br/>

<?php } else if(strlen($_POST['ano'])!=4) {?>
<br/>
<?php echo $imgerro;?> No campo ano você tem postar 4 caracteres!<br/><br/>

<?php } else if(strlen($_POST['hora'])!=2) {?>
<br/>
<?php echo $imgerro;?> No campo hora você tem postar 2 caracteres!<br/><br/>

<?php } else if(strlen($_POST['minutos'])!=2) {?>
<br/>
<?php echo $imgerro;?> No campo minutos você tem postar 2 caracteres!<br/><br/>

<?php } else if(strlen($_POST['segundos'])!=2) {?>
<br/>
<?php echo $imgerro;?> No campo segundos você tem postar 2 caracteres!<br/><br/>

<?php } else if (number_format($_POST['dia'])==false) { ?>
<br/>
<?php echo $imgerro;?> Na opção dia só é aceito números, acima de 00!<br/><br/>

<?php } else if (number_format($_POST['mes'])==false) { ?>
<br/>
<?php echo $imgerro;?> Na opção mês só é aceito números, acima de 00!<br/><br/>

<?php } else if (number_format($_POST['ano'])==false) { ?>
<br/>
<?php echo $imgerro;?> Na opção ano só é aceito números, acima de 00!<br/><br/>

<?php } else if (number_format($_POST['hora'])==false) { ?>
<br/>
<?php echo $imgerro;?> Na opção hora só é aceito números, acima de 00!<br/><br/>

<?php } else if (number_format($_POST['minutos'])==false) { ?>
<br/>
<?php echo $imgerro;?> Na opção minutos só é aceito números, acima de 00!<br/><br/>

<?php } else if (number_format($_POST['segundos'])==false) { ?>
<br/>
<?php echo $imgerro;?> Na opção segundos só é aceito números, acima de 00!<br/><br/>

<?php }else{
$dataok = ''.$_POST['ano'].'/'.$_POST['mes'].'/'.$_POST['dia'].' '.$_POST['hora'].':'.$_POST['minutos'].':'.$_POST['segundos'].'';
$mistake->exec("UPDATE bymistake_leilao SET objeto='".$_POST['objeto']."', termina='$dataok' where id='1'");
$data = date("d/m/Y - H:i:s",time());
?>
<br/>
<?php echo $imgok;?> Objeto adicionado com sucesso!<br/><br/></div>
<?php } } else if($a=='responder'){ ?>
<br/><div id="titulo"><b>Leilão <?php echo nome_site();?></b></div><br/>
<div align="center"><br/>
<?php
$pontos = $mistake->query("SELECT pt FROM w_usuarios WHERE id='$meuid'")->fetch();
if(trim($_POST['valor'])=='') { ?>
<br/>
<?php echo $imgerro;?> Você deve digitar algo no campo valor!<br/><br/>
<?php } else if (number_format($_POST['valor'])==false) { ?>
<br/>
<?php echo $imgerro;?> No campo valor só será aceito lances maiores do que 01.<br/><br/>
<?php } else if ($pontos[0]<$_POST['valor']) { ?>
<br/>
<?php echo $imgerro;?> Você não possui <?php echo $_POST['valor'];?> pontos, por isso não pode postar este valor!<br/><br/>
<?php }else{
$mistake->exec("INSERT INTO bymistake_leilaolances (por,hora,valor) values('$meuid','".time()."','".$_POST['valor']."')");
?>
<br/>
<?php echo $imgok;?> Seu lance foi adicionado com sucesso!<br/><br/></div>
<?php } }else if($a=='regras'){ ?>
<br/><div id="titulo"><b>Regras leilão</b></div><br/>
<div align="center">
<br/>No leilão você poderá dar seu lance caso interesse no objeto leiloado<br/>
O lance com menor valor fica em destaque na página de ínicido do leilão, assim você sempre saberá qual lance irá dar.<br/>
Você poderá lances de acordo com seu saldo de pontos, ou seja não adianta dar um lance de 10000 mil pontos se você não tem estes para descontar<br/>
Quando leilão atingir a data e hora limite o mesmo será fechado e aquela pessoa que tiver dado o maior lance irá arrecadar o objeto leiloado<br/>
Os pontos serão descontados automaticamente da pessoa que arrecar o objeto o objeto<br/>
Qualquer dúvida procure a equipe do <?php echo nome_site();?>
<br/><br/>
<?php } ?>
<div align="center">
<?php if($a!=false){ ?>
<br/>
<a href="leilao">Leilão</a><br/><br/>
<?php } ?>
<a href="leilao?a=regras">Como funciona?</a><br/><br/>
<a href="entretenimento"><?php echo $imgservicos;?>Entretenimento</a><br/><br/>
<a href="home"><?php echo $imginicio;?>Página principal</a><br><br>
<?php echo rodape();?>
</body>
</html>