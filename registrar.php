<?php
require_once("".$_SERVER["DOCUMENT_ROOT"]."/funcoes.php");
require_once("".$_SERVER["DOCUMENT_ROOT"]."/mistake.php");
?>
<section class="container-fluid"><div class="col-md-4 offset-md-4"><h2>Cadastro</h2><br><?
$conta = $mistake->prepare("SELECT COUNT(*) FROM w_usuarios WHERE ip='".gerarip()."' and visitante='0'");
$conta->execute();
$conta = $conta->fetch();
if($conta[0]>0){
?><div align="center">Já possui uma conta em nosso site usando o seu ip <b><?php echo gerarip();?></b> você poderá entrar usando o seu login e senha.<br/><br/><a href="/"><?php echo $imginicio;?>Página inicial</a><br><br><?
rodape();
exit();
}
$x = $imgerro;
if($testearray[24]=='0'){
$user_agent = $_SERVER['HTTP_USER_AGENT'];
if((stristr($user_agent,'opera')) or (stristr($user_agent,'Opera')) or (stristr($user_agent,'OPR'))) {
echo "<div align='center'>$x No momento não estamos permitindo cadastros através do navegador Opera, use outro navegador para fazer seu cadastro e depois poderá entra no site com o navegador Opera.<br /><br /><a href='/'>".$imginicio."Página Inicial</a></div>";
rodape(); 
exit();
}
}
/*
if($testearray[23]=='0'){
if(isset($_SERVER['GEOIP_COUNTRY_CODE']) ? $_SERVER['GEOIP_COUNTRY_CODE']!='BR' : $_SERVER['HTTP_CF_IPCOUNTRY']!='BR'){
echo "<div align='center'>$x No momento so estamos permitindo cadastros através de ips Brasileiros.<br /><br /><a href='/'>".$imginicio."Página Inicial</a></div>";    
rodape(); 
exit();
}
}*/
/*
if($_COOKIE['spam']==1){
echo "<div align='center'>$x Este ip ".gerarip()." esta banido no site aguarde sua punição!<br /><a href='/'>".$imginicio."Página Inicial</a></div>";
rodape(); 
exit();
}
$ban = $mistake->prepare("SELECT banido FROM w_usuarios WHERE ip='".gerarip()."'");
$ban->execute();
$ban = $ban->fetch();
if($ban[0]=='1'){
setcookie("spam",1,(time() + (86400 * 1)),"/",".".str_replace("www.","",$_SERVER["HTTP_HOST"])."");
echo "<div align='center'>$x Você tem, uma conta banida impossivel criar outra!<br /><a href='/'>".$imginicio."Página Inicial</a>";
rodape(); 
exit();
}*/
if($a=='reg') {
$_SESSION['nome'] = $_POST['nome'];
$_SESSION['login'] = $_POST['login'];
$_SESSION['senha'] = $_POST['senha'];
$_SESSION['senha2'] = $_POST['senha2'];
$sexo = $_POST['sexo'];
$dtnascimento = $_POST['dtnascimento'];
$dtnascimento2 = $_POST['dtnascimento2'];
$dtnascimento3 = $_POST['dtnascimento3'];
$nascimento = "".$dtnascimento3."-".$dtnascimento2."-".$dtnascimento."";
?>
<div align="center"><br/>
<?php
if(trim($_POST['nome'])=='' or trim($_POST['login'])=='' or trim($_POST['senha'])=='') { echo $x;?>
Todos os campos são obrigatórios!<br/>
<?php } else 
if(strlen($_POST['nome'])<4 or strlen($_POST['login'])<4) { echo $x;?>
Login e Nome deve conter 4 carácteres ou mais!<br />
<?php 
} else
if(strlen($_POST['senha'])<4) { echo $x;?>
A senha deve conter 4 carácteres ou mais!<br />
<?php 
} else {
if(isdigitf($_POST['login']) or strripos($_POST['nome'],'href')){ 
echo $x;?>
Caracteres invalidos no login ou nome!<br />
<?php  
}else{     
$email = $mistake->query("SELECT COUNT(*) FROM w_usuarios WHERE lg='".$_POST['login']."'")->fetch();
if($email[0]>0) { echo $x;?>
Já existe um usuário registrado com este login!<br />
<?php 
}else{
if(isspam($_POST['nome'],1)||isspam($_POST['login'],1)){
setcookie("spam",1,(time() + (86400 * 1)),"/",".".str_replace("www.","",$_SERVER["HTTP_HOST"])."");
$msge = "Atenção este ip: <b>".gerarip()."</b> esta tentando fazer um cadastro com spam <br> usou nick: <b>".$_POST['nome']."</b> e login: <b>".$_POST['login']."</b><br>não se preocupem ele foi bloqueado de acesso ao site.merci.";
$msgs = $mistake->query("SELECT id FROM w_usuarios WHERE (perm>'0' or perm2>'0' or vip>'0')");
while ($msg = $msgs->fetch(PDO::FETCH_OBJ)) {
$res = $mistake->prepare("INSERT INTO w_msgs (txt,por,pr,hr,dl) VALUES (?,?,?,?,?)");
$arrayName = array($msge,4,$msg->id,time(),0);
$ii = 0;
for($i=1; $i <=5; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
}
echo $x;?>Erro!<br />
<?php 
}else{
$login = file_exists("".$_POST['login'].".php") ? mb_strtoupper($_POST['login']) : $_POST['login'];  
$meuemail2 = "".$_SESSION['login']."@".date("Y-m-d H:i:s")."";
if($_COOKIE['indicado']==true){
$ndi = $_COOKIE['indicado']; 
$res = $mistake->exec("update w_usuarios set indicacoes=indicacoes+1 where id='".$ndi."'"); 
}else{
$ndi = 0;      
}
if($sexo=='M'){
$ndim = "#00008B"; 
}else{
$ndim = "#FF00FF";      
}
$res = $mistake->prepare("INSERT INTO w_usuarios (nm,lg,sh,nasc,rg,sx,email,liberado,indicado,ip,corn,pt,moedas) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
$arrayName = array(mb_htmlentities($_POST['nome']),$login,md5($_POST['senha']),$nascimento,time(),$sexo,$meuemail2,$testearray[25],$ndi,gerarip(),$ndim,$testearray[46],$testearray[47]);
$ii = 0;
for($i=1; $i <=13; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
$resok = $mistake->lastInsertId();
if($res) {
setcookie("reg",1,(time() + (86400 * 7)),"/",".".str_replace("www.","",$_SERVER["HTTP_HOST"])."");
automsg($testearray[16],1,$resok);
$msge = "Atenção novo membro cadastrado: [link=/".$login."] [b]".$_POST['nome']."[/b] [/link] vamos dar boas vindas a ele(a) equipe e vips! [br/][br/] [b] Detalhes do registro:[/b] [br/][br/] Email: ".$meuemail2." [br/] Ip: ".gerarip()." [br/] [br/] [link=/mod/liberar/".$resok."] Liberar User [/link]";
$msgs = $mistake->query("SELECT id FROM w_usuarios WHERE (perm>'0' or perm2>'0' or vip>'0') and perm!='4'");
while ($msg = $msgs->fetch(PDO::FETCH_OBJ)) {
$res = $mistake->prepare("INSERT INTO w_msgs (txt,por,pr,hr,dl) VALUES (?,?,?,?,?)");
$arrayName = array($msge,1,$msg->id,time(),1);
$ii = 0;
for($i=1; $i <=5; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
}
if($testearray[25]==1){
$clean_text = "Olá <a href='/".$login."'> ".gerarnome($resok)." </a> sinta-se a vontade conosco! Adoramos você! Seja muito bem-vindo(a) e conte com a gente!<span style='background-image: url(//kasadasprimas.net/emojis/1f970.png);height:32px;width:32px;display:inline-block'></span>";
$res = $mistake->prepare("INSERT INTO w_mchat (txt,por,hr,p,schat) VALUES (?, ?, ?, ?, ?)");
$arrayName = array($clean_text,time(),0,1);
$ii = 0;
for($i=1; $i <=5; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
}
header("Location:/login?usuario=".$_POST['nome']."&senha=".$_POST['senha']."&salvar=1&armazenar=1&autologin=1");
?>
<div id="div1" align="center">
<?php echo $imgok;?>Cadastro efetuado com sucesso no <?php echo nome_site();?><br />
Por favor guarde os dados abaixo em um local seguro, você irá precisar deles para acessar o site ou recuperar sua senha.<br /><br />
OBS: Assim que acessar o site altere seu email para poder recuperar sua senha futuramente caso necessite.<br /><br />
ID: <?php echo $resok;?><br />
Nick: <?php echo $_POST['nome'];?><br />
Nick de usuário: <?php echo $_POST['login'];?><br />
Email: <?php echo $meuemail2;?><br />
Senha: <?php echo $_POST['senha'];?><br /><br />
Clique , <big><u><strong><a href="/login?usuario=<?php echo $_POST['login'];?>&senha=<?php echo $_POST['senha'];?>&salvar=1">AQUI</a></strong></u></big> para logar no site.
</div><br />
<?php 
} else { 
?>
<br/><?php echo $x;?>Não foi possível validar o cadastro, tente novamente!
<?php 
}
}
}
}
}
unset($_SESSION["codigo"]);
}else if($a=='alterarsenha') { 
?>
<div align="center"><br/><strong>Alterar através do email.</strong>
<form action="registrar?a=alterarsenha2" method="post"><br/>
E-mail de cadastro:<br/><input type="email" name="email"><br/>
<input type="submit" value="Enviar"></form>
<br /><a href="registrar?a=sms">Via sms</a></div>
<?php } else
if($a=='alterarsenha2') { 
?>
<br/><div id="titulo"><b>Redefinir via e-mail</b></div><br/><div align="center">
<?
if(validaemail($_POST['email'])){
$contemail = $mistake->query("SELECT count(*) FROM w_usuarios WHERE email='".$_POST['email']."'")->fetch();
if($contemail[0]>0){
$pendente = $mistake->query("SELECT count(*) FROM w_novoreg WHERE email='".$_POST['email']."' and cat='2'")->fetch();
if($pendente[0]>0) { ?>
<?php echo $imgerro;?> Já existe uma solicitação pendente para esse email, verifique sua caixa de entrada ou spam!<br/>
<?php } else {
$info = $mistake->query("SELECT nm,id FROM w_usuarios WHERE email='".$_POST['email']."'")->fetch();
$cod = md5($_POST['email'].date('s'));
$hora = time() + 3600;
$reg = $mistake->exec("INSERT INTO w_novoreg (email,hr,cod,cat,uid) values('".$_POST['email']."','".$hora."','$cod','2','".$info[1]."')");
if($reg) {
function email($msg, $assunto, $email)
{
$email_remetente = "Suporte@Senhas"; //endereço de e-mail do remetente
$headers = "MIME-Version: 1.1\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\n";
$headers .= "From: $email_remetente\n"; // remetente
$headers .= "Return-Path: $email_remetente\n"; // return-path
$headers .= "Reply-To: $email\n"; // Endereço (devidamente validado) que o seu usuário informou no contato
mail($email, $assunto, $msg, $headers, "-f$email_remetente");/// send e-mail
}
$assunto = "Redefinição de senha"; // assunto
$url_site = $_SERVER['SERVER_NAME'];
$msg = '
<html>
<body>
<center><b><font color="green">Solicitação de nova senha</font></b></center>
<br/>
Recebemos sua solicitação de nova senha para acesso ao https://'.$url_site.'.
Caso você não tenha solicitado, por favor ignore este e-mail.<br/><br/>
Dados da solicitação:<br/>
Sua ID: <b>'.$info[1].'</b><br/>
IP: <b>'.gerarip().'</b><br/><br/>
Clique no link abaixo para confirmar e receber uma nova senha:
<a href="https://'.$url_site.'/registrar?a=alterarsenha3&id='.$cod.'">https://'.$url_site.'/registrar?a=alterarsenha3&id='.$cod.'</a><br/><br/>
<b>O link é válido por 60 minutos a partir do envio do e-mail.</b>
<br/>
<br/><small>Por favor não responda esta mensagem, ela foi enviada por um endereço de e-mail não monitorado. Em caso de dúvidas acesse nosso site.</small>
https://'.$url_site.'
<br/><br/>
</body>
</html>';


email($msg, $assunto, $_POST['email']);//função enviar o email
echo $imgok;?>Foi enviado um e-mail para <b><?php echo $_POST['email'];?></b> com instruções para gerar uma nova senha, caso não receba o mesmo verifique a pasta SPAM ou LIXEIRA<br/> A sessão vai expirar em 60 minutos!<br />
<?php } else { ?>
<?php echo $imgerro;?> Não foi possível enviar o e-mail, tente novamente!<br /><br/>
<a href="registrar?a=alterarsenha">Voltar</a>
<?php } }} else { ?>
<?php echo $imgerro;?> Não existe nenhum cadastro com o e-mail <b><?php echo $_POST['email'];?></b><br /><br/><a href="registrar?a=alterarsenha">Voltar</a>
<?php } } else { ?>
<?php echo $imgerro;?> Não existe nenhum cadastro com o e-mail <b><?php echo $_POST['email'];?></b><br /><br/><a href="registrar?a=alterarsenha">Voltar</a>
<?php
}
} else if($a=='alterarsenha3') {
?>
<br/><div id="titulo"><b>Redefinir via e-mail</b></div><br/>
<?
$code = $mistake->query("SELECT COUNT(*) FROM w_novoreg WHERE cod='$id' and cat='2'")->fetch();
if($code[0]==0) { ?>
<div align="center"><?php echo $imgerro;?> Link incorreto ou senha já alterada, tente novamente ou tente fazer seu login <a href="http://<?php site_url();?>">aqui</a>!<br/>
<?php } else {
$user = $mistake->query("SELECT uid,email FROM w_novoreg WHERE cod='".$id."' and cat='2'")->fetch();
$nick = gerarnome($user[0]);
$uid = $user[0];

echo "<center>Olá ".$nick.", essa sessão expira em 60 minutos então troque sua senha preenchendo o formulário abaixo, lembre-se:</center><br>";
echo "<li>Um aviso que sua senha foi trocada será registrado em nosso sistema.</li>";
echo "<li>Não use caracteres especiais na senha.</li>";
echo "<li>Use sempre senhas fortes incluindo letras e números difereciando maiúsculo de minúsculo</li>";
?>
<form action="registrar?a=alterarsenha4&id=<?php echo $id;?>" method="post"><br/>
Nova senha:<br/><input type="password" name="senha"><br/>
Repita a nova senha:<br/><input type="password" name="senhaa"><br/>
<input type="submit" value="Enviar"></form>
<?php } } else if($a=='alterarsenha4') { ?>
<br/><div id="titulo"><b>Redefinir via e-mail</b></div><br/><div align="center">
<?php 
$code = $mistake->query("SELECT COUNT(*) FROM w_novoreg WHERE cod='$id' and cat='2'")->fetch();
if($code[0]==0) { ?>
<div align="center"><?php echo $imgerro;?> Link incorreto ou senha já alterada, tente novamente ou tente fazer seu login <a href="http://<?php site_url();?>">aqui</a>!<br/>
<?php }
else if(trim($_POST['senha'])=='') { ?>
<?php echo $imgerro;?> Por favor escreva sua senha!<br />
<a href="registrar?a=alterarsenha3&id=<?php echo $id;?>">Voltar</a><br/>
<?php } else if(trim($_POST['senhaa'])=='') { ?>
<?php echo $imgerro;?> Por favor repita sua senha!<br />
<a href="registrar?a=alterarsenha3&id=<?php echo $id;?>">Voltar</a><br/>
<?php } /*else if(spacesin($_POST['senha'])||scharin($_POST['senha'])) { ?>
<?php echo $imgerro;?> Senha inválida!<br />
<a href="registrar?a=alterarsenha3&id=<?php echo $id;?>">Voltar</a><br/>
<?php }*/ else if($_POST['senha']!=$_POST['senhaa']) { ?>
<?php echo $imgerro;?> As senhas não combinam!<br />
<a href="registrar?a=alterarsenha3&id=<?php echo $id;?>">Voltar</a><br/>
<?php } else if(strlen($_POST['senha'])<4) { ?>
<?php echo $imgerro;?> A senha deve conter 4 carácteres ou mais!<br />
<a href="registrar?a=alterarsenha3&id=<?php echo $id;?>">Voltar</a><br/>
<?php } else {
$info = $mistake->query("SELECT * FROM w_novoreg WHERE cod='$id'")->fetch();
$idd = $mistake->query("SELECT nm FROM w_usuarios WHERE email='".$info['email']."'")->fetch();
$res = $mistake->exec("UPDATE w_usuarios SET sh='".md5($_POST['senha'])."' WHERE email='".$info['email']."'");
if($res) {
$mistake->exec("DELETE FROM w_novoreg WHERE id='".$info['id']."'"); 
echo $imgok;?>Sua senha foi alterada com sucesso.<br /> <a href="/">Fazer login.</a><br/>
<?php } else { echo $x;?> Não foi possivel alterar sua senha, tente novamente!<br/>
<?php } } } else { ?>
<?php
if(isset($_COOKIE['google']) || isset($_COOKIE['facebook']) || isset($_COOKIE['twitter']) || isset($_COOKIE['instagram']) || isset($_COOKIE['regg'])){
echo '<div align="center">AGUARDE VERIFICAMOS QUE VOCÊ POSSUI UM LOGIN COM OUTRA CONTA </div>';
}else{
if($testearray[22]==0) { 
?>
<div class="card shadow"><div class="card-body"><div class="alert alert-warning">O cadastro está desativado no momento.</div><br><div class="row"><div class="col-6"><a href="/online/login2" class="btn btn-sm btn-block btn-dark">Fazer login</a></div><div class="col-6"><a href="/online/login" class="btn btn-sm btn-block btn-dark">Entrar</a></div></div></div></div></div> </section>
<?
} else {
$indicado = isset($_GET['indicado']) ? $_GET['indicado'] : 0;
setcookie("indicado",$indicado,(time() + (86400 * 7)),"/",".".str_replace("www.","",$_SERVER["HTTP_HOST"])."");
?>
<img src="/style/informacao.gif" alt="img" /> Todos os campos são obrigatórios.<br/>
<b><font color="red">Use apenas letras e números sem acentuação.</font></b>
<form action="/registrar?a=reg" method="post"><br/>
Nick:<br/><input type="text" class="form-control" name="nome" value="<?php echo isset($_SESSION['nome'])?$_SESSION['nome']:'';?>" required><br />
Repetir Nick (login):<br/><input type="text" class="form-control"  name="login" value="<?php echo isset($_SESSION['login'])?$_SESSION['login']:'';?>" required><br />
Senha:<br/><input id="senha" class="form-control" type="password" name="senha" value="<?php echo isset($_SESSION['senha'])?$_SESSION['senha']:'';?>" required><img src="/olho.png" style="width:22px;height:22px" onclick="mudarinput('senha')"><br />
Sexo:<br/><select name="sexo">
<option value="M">Masculino</option>
<option value="F">Feminino</option>
</select><br /><br/>
<input type="submit" value="Registrar"></form></fieldset><br/>
<div align="center"><a href="/online/login"><?php echo $imgsetavoltar;?>Voltar</a></div><br />
<?php 
} 
} 
}
?>
<?php 
rodape(); 
?>
</body>
</html>