<?php
require_once("".$_SERVER["DOCUMENT_ROOT"]."/funcoes.php");
require_once("".$_SERVER["DOCUMENT_ROOT"]."/mistake.php");
require_once("".$_SERVER["DOCUMENT_ROOT"]."/emoji.php");
seg($meuid);
ubloq($meuid,$id);
ativo($meuid,'Pergunte-me algo ');
if(uchat($meuid)==3) { ?>
<br/><div align="center"><?php echo $imgerro;?>Você foi bloqueado.<br/><br/>
<a href="/home"><?php echo $imginicio;?>Página principal</a><br><br>
<?php 
rodape();
exit(); }
$info = $mistake->query("SELECT * FROM w_usuarios WHERE id='$id'")->fetch();
$num2 = $mistake->query("SELECT COUNT(*) FROM w_pergunte_me WHERE para='$id'")->fetch();
$i = $mistake->query("SELECT ocimg, visi, perm2 FROM w_usuarios WHERE id='$meuid'")->fetch();
$privacidade = $mistake->query("SELECT pergpri FROM w_usuarios WHERE id='$id'")->fetch();
if($id!=$meuid and $privacidade['pergpri']==1 and contamigos($meuid, $id)==0 and perm($meuid)==0) { ?>
<br/><div id="titulo"><b>
<?php echo gstat($id);?>Pergunte-Me <?php echo gerarnome($id);?>
</b></div>
<?php
if($info['ft']==true){
$foto = $info['ft'];
}else{
$foto = 'semfoto.jpg';
}
?>
<div align="center">
<img alt="foto" id="profile-img" class="profile-img" src="/<?php echo $foto;?>" oncontextmenu="return false" onselectstart="return false" ondragstart="return false" style="width:103px;height:136px;border-radius:50%; margin:1px; border:2px solid #FFF;" pbsrc="/<?php echo str_replace('m_','',$foto);?>" class="PopBoxImageSmall" title="Clique para ampliar/diminuir" onclick="Pop(this,50,'PopBoxPopImage');" />
<br/>
<strong>Pergunte-me só pode ser visualizado por amigos de <?php echo gerarnome($id);?></strong><br /><br />
 Id: <?php echo $id;?><br /><br />
<a href="/amigos/editaramigo/<?php echo $id;?>/add">Adicionar amigo</a><br /><br />
 <a href="/mensagens/lermsg/<?php echo $id;?>">Enviar mensagem</a><br/><br />
 <?php } else {
	 
if($a=='perguntas') {
?>
<br/><div id="titulo"><b>
Pergunte-Me <?php echo gstat($id);?><?php echo gerarnome($id);?>
</b></div>
<br />
<div align="center">
<?php
if($_GET['acao']=='sim')
{
$certo = $mistake->query("SELECT COUNT(*) FROM w_perguntas_logs WHERE ip_pergunta= '".$_GET['perg']."' AND eu_votei='$meuid'")->fetch();
if ($certo[0]>0) {
?>
<b><big><?php echo $imgerro;?> Você  já deu sua apinião a essa resposta!</b></big>
<?php	
}else{
$res = $mistake->exec("INSERT INTO w_perguntas_logs (ip_pergunta,eu_votei,sim,nao,dono) values('".$_GET['perg']."','".$meuid."','1','0','$id')");
?>
<?php
if($res) { ?>
<b><big><?php echo $imgok;?>Sua opinião foi aplicada com sucesso!</b></big>
<?php } else { ?>
<b><big><?php echo $imgerro;?> Opss... algo saiu errado!</b></big>
<?php } 
} 
}
?>
<?php
if($_GET['acao']=='nao')
{
$certo = $mistake->query("SELECT COUNT(*) FROM w_perguntas_logs WHERE ip_pergunta= '".$_GET['perg']."' AND eu_votei='$meuid'")->fetch();
if ($certo[0]>0) {
?>
<b><big><?php echo $imgerro;?> Você  já deu sua apinião a essa resposta!</b></big>
<?php	
}else{
$res = $mistake->exec("INSERT INTO w_perguntas_logs (ip_pergunta,eu_votei,sim,nao,dono) values('".$_GET['perg']."','".$meuid."','0','1','$id')");
?>
<?php
if($res) { ?>
<b><big><?php echo $imgok;?>Sua opinião foi aplicada com sucesso!</b></big>
<?php } else { ?>
<b><big><?php echo $imgerro;?> Opss... algo saiu errado!</b></big>
<?php } 
} 
}
?>
<?php
if($_GET['acao']=='excluir')
{
$excluir = $mistake->query("SELECT para FROM w_pergunte_me WHERE id='".$_GET['perg']."'")->fetch();
if($meuid!=$excluir['para'] and perm($meuid)==0) { ?>
<b><big><?php echo $imgerro;?> Esta pergunta não é sua!</b></big>
<?php
}else{
?>
<?php
$res = $mistake->exec("DELETE FROM w_pergunte_me WHERE id='".$_GET['perg']."'");
?>
<?php
if($res) { ?>
<b><big><?php echo $imgok;?>Pergunta foi excluida com sucesso!</b></big>
<?php } else { ?>
<b><big><?php echo $imgerro;?> Opss... algo saiu errado!</b></big>
<?php } 
}
}
?>
<?php
if($_GET['acao']=='res')
{
if (empty($_POST['resposta'])) {
?>
<?php echo $imgerro;?>
<b><big>Por favor escreva uma resposta!</b></big>
<?php
}else{
$certo = $mistake->query("SELECT COUNT(*) FROM w_pergunte_me WHERE id= '".$_GET['perg']."' AND para='$meuid'")->fetch();
if ($certo[0]>0) {
if(isspam($_POST['resposta'],$meuid)) {
$mistake->exec("UPDATE w_usuarios SET bchat='3' WHERE id='".$meuid."'");  
$res = $mistake->prepare("INSERT INTO Mmistake_logs (texto,meuid,para,acao,data) VALUES (?,?,?,?,?)");
$arrayName = array(anti_injection($_POST['pergunta']),$meuid,0,'forum',time());
$ii = 0;
for($i=1; $i <=5; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
}else{
$res = $mistake->prepare("UPDATE w_pergunte_me SET resposta = ? WHERE id = ?");
$res->execute(array(nl2br(emoji_unified_to_html(anti_injection($_POST['resposta']))),$_GET['perg']));
}        
if($res) { ?>
<b><big><?php echo $imgok;?>Resposta enviada com sucesso!</b></big>
<?php } else { ?>
<b><big><?php echo $imgerro;?> Opss... algo saiu errado!</b></big>
<?php } 
} else {
?>
<?php echo $imgerro;?>
<b><big>Você não pode responder uma pergunta que não é sua!</b></big>	
	
<?php
}
}
}
?>
<?php
if($_GET['acao']=='post')
{
if (empty($_POST['pergunta'])) {
?>
<?php echo $imgerro;?>
<b><big>Por favor escreva uma pergunta!</b></big>
<?php
} else if ($id==$meuid) {
?>
<?php echo $imgerro;?>
<b><big>Você não pode enviar uma pergunta para você mesmo!</b></big>
<?php	
}else {
if(isspam($_POST['pergunta'],$meuid)) {
$mistake->exec("UPDATE w_usuarios SET bchat='3' WHERE id='".$meuid."'");  
$res = $mistake->prepare("INSERT INTO Mmistake_logs (texto,meuid,para,acao,data) VALUES (?,?,?,?,?)");
$arrayName = array(anti_injection($_POST['pergunta']),$meuid,0,'forum',time());
$ii = 0;
for($i=1; $i <=5; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
}else{
$res = $mistake->prepare("INSERT INTO w_pergunte_me (de,para,pergunte,hora,anonimo) VALUES (?,?,?,?,?)");
$arrayName = array($meuid,$id,nl2br(emoji_unified_to_html(anti_injection($_POST['pergunta']))),time(),$_POST['anonimo']);
$ii = 0;
for($i=1; $i <=5; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
}    
if($res) { ?>
<b><big><?php echo $imgok;?>Pergunta feita com sucesso!</b></big>
<?php } else { ?>
<b><big><?php echo $imgerro;?> Opss... algo saiu errado!</b></big>
<?php } 
?>
<?php
}	
}
?>
</div>
<br />
<?php
if($info['ft']==true) 
{
$foto = $info['ft'];
}
else
{
$foto = 'semfoto.jpg';
}
?>
<br/><div align="center">
<img alt="foto" id="profile-img" class="profile-img" src="/<?php echo $foto;?>" oncontextmenu="return false" onselectstart="return false" ondragstart="return false" style="width:103px;height:136px;border-radius:50%; margin:1px; border:2px solid #FFF;" pbsrc="/<?php echo str_replace('m_','',$foto);?>" class="PopBoxImageSmall" title="Clique para ampliar/diminuir" onclick="Pop(this,50,'PopBoxPopImage');" />
<br/><br />
Quer sabe algo sobre <?php echo gerarnome($id);?> ? Então não perca tempo faça sua pergunta agora mesmo!<br />
Você pode perguntar se identificando ou anonimamente, assim <?php echo gerarnome($id);?> não irá saber quem perguntou.<br /><br />
Nível de <?php echo gerarnome($id);?> no Pergunte-me
<br />
<?php
        if($num2[0]<10) 	{
 		$img = "perguntan1";
 	}
	else if($num2[0]<20)
	{
		$img = "perguntan2";
	}
	else if($num2[0]<30)
	{
		$img = "perguntan3";
	}
	else if($num2[0]<40)
	{
		$img = "perguntan4";
	}
	else if($num2[0]<50)
	{
		$img = "perguntan5";
	}
	else if($num2[0]<60)
	{
		$img = "perguntan6";
	}
	else if($num2[0]<70)
	{
		$img = "perguntan7";
	}
	else if($num2[0]<80)
	{
		$img = "perguntan8";
	}
	else if($num2[0]<90)
	{
		$img = "perguntan9";
	}
	else if($num2[0]<100)
	{
		$img = "perguntan10";
	}
	else if($num2[0]>110)
	{
		$img = "perguntan11";
	}
echo "<img src=\"style/pergunte/$img.gif\"><br>";
$total_perguntas = $mistake->query("SELECT COUNT(*) FROM w_pergunte_me WHERE para='$id'")->fetch();
$total_perguntas3 = $mistake->query("SELECT COUNT(*) FROM w_pergunte_me WHERE para='$id' AND resposta IS NULL")->fetch();
$total_perguntas2 = $mistake->query("SELECT COUNT(*) FROM w_pergunte_me WHERE para='$id' AND resposta IS NOT NULL")->fetch();
?>
<br/><font color="#0011AF">Perguntas: (<?php echo $total_perguntas[0]; ?>)</font> - <font color="#14AF00">Respondidas: (<?php echo $total_perguntas2[0]; ?>)</font> - <font color="#FF0000">Não Respondidas: (<?php echo $total_perguntas3[0]; ?>)</font><br/>
<?php
$sins = $mistake->query("SELECT SUM(sim) FROM w_perguntas_logs WHERE dono='$id'")->fetch();
$nauns = $mistake->query("SELECT SUM(nao) FROM w_perguntas_logs WHERE dono='$id'")->fetch();
if (empty($sins[0])) {
$sins = 0;
}else{
$sins = $sins[0];
}
if (empty($nauns[0])) {
$nauns = 0;
}else{
$nauns = $nauns[0];
}
?>
<br/><img src="/style/bom.png"> <?php echo $sins; ?> | <img src="/style/ruim.png"> <?php echo $nauns; ?><br/>
<?php
if ($id==$meuid) {
?>
<br/>BBCODE: <input type="text" size="30" value="[pergunte=<?php echo $id;?>]Pergunte-ME![/pergunte]"><br/><br />
<?php
}else{
?>
<div align="center">
<br/>Pergunta ae....<br/>
<form action="pergunte_me?a=perguntas&id=<?php echo $id; ?>&acao=post" align="center" method="post">
<textarea style="width:-webkit-fill-available" name="pergunta" maxlength="500" value="" rows="5" cols="25"></textarea>
<br/>Deseja se identificar?<br/>
<select name="anonimo">
<option value="0">Sim</option>
<option value="1">Não</option></select>
<br/><br/>
<center><input type="submit" name="perguntar" value="Perguntar"/></center></form><br/><br/>
</div>
<?php
}
if($total_perguntas[0]>0)
{
?>
Veja as perguntas feitas para <?php echo gerarnome($id);?>:
<?php
$contrec = $mistake->query("SELECT COUNT(*) FROM w_pergunte_me WHERE para='$id'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contrec[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->query("SELECT * FROM w_pergunte_me WHERE para='$id' ORDER BY hora desc LIMIT $limit, $itensporpag");
$i=0; while($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<?php
$cou++;
?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<div align="center"><u><b>Pergunta Nº <?php echo $cou; ?></b></u>
<hr>De: <?php if($item->anonimo=='1') {?><div class="tituloWrapper"><b>Anônimo </b><span class="titulo" style="font-size:10px"><?php echo empty(permdono($meuid)) ? 'Anônimo' : '<a href="/'.gerarlogin($item->de).'" style="color:#FFFFFF">'.gerarnome2($item->de).'</a>'?></span></div><?php } else {?><a href="/<?php echo gerarlogin($item->de);?>"><?php echo gerarnome($item->de);?></a><?php } ?><br/><br/>
<u><b>Pergunta</b></u><br/><br/> <?php echo textot($item->pergunte,$meuid,$on);?><br/><br/>
<?php
if((strlen($item->resposta)) > 0){
?>
<u><b>Resposta</b></u><br/><br/> <?php echo textot($item->resposta,$meuid,$on);?><br/><br/>
<hr>Data que a pergunta foi feita: <?php echo date("d/m/Y - H:i:s", $item->hora);?><hr>
<u>Você acha que <?php echo gerarnome($id);?> foi sincero(a) em sua resposta?</u>
<br/><a href="pergunte_me?a=perguntas&id=<?php echo $id; ?>&acao=sim&perg=<?php echo $item->id; ?>"><b>
<img src="/style/bom.png">
<font color="#14AF00">SIM</font></b></a> - <a href="pergunte_me?a=perguntas&id=<?php echo $id; ?>&acao=nao&perg=<?php echo $item->id; ?>"><b>
<img src="/style/ruim.png"><font color="#ff0000">NÃO</font></b>
<?php
$sins = $mistake->query("SELECT SUM(sim) FROM w_perguntas_logs WHERE ip_pergunta='".$item->id."'")->fetch();
$nauns = $mistake->query("SELECT SUM(nao) FROM w_perguntas_logs WHERE ip_pergunta='".$item->id."'")->fetch();
if (empty($sins[0])) {
$votos_bons = 0;
}else{
$votos_bons = $sins[0];
}
if (empty($nauns[0])) {
$votos_ruins = 0;
}else{
$votos_ruins = $nauns[0];
}
?>
</a><br/>Pessoas que acharam que foi sincero(a): <?php echo $votos_bons; ?><br/>Pessoas que acharam que não foi sincero(a): <?php echo $votos_ruins; ?>   </div>
<?php
}else{
?>
<br /><b>AGUARDANDO RESPOSTA...</b><br />
<?php
if ($id==$meuid) {
?>
<form action="pergunte_me?a=perguntas&id=<?php echo $id; ?>&acao=res&perg=<?php echo $item->id; ?>" method="post"><br/>
Resposta: <input type="text" name="resposta" value=""> <input type="submit" value="Responder">
</form>
<?php
}
?>
<?php
}
?>
<?php if($meuid!=$item->para and perm($meuid)==0) { } else {?>
<div align="center"> <br /><a href="pergunte_me?a=perguntas&id=<?php echo $id; ?>&acao=excluir&perg=<?php echo $item->id; ?>">[EXCLUIR]</a></div>
<?php
}
?>
 </div>
 </div>
 <?php $i++; } ?>
<?php
}
?>
<div align="center"><br/>
<?php if($pag>1)  { $ppag = $pag-1; ?>
<a href="pergunte_me?a=perguntas&id=<?php echo $id;?>&pag=<?php echo $ppag;?>">&#171;Anterior</a>
<?php } if($pag<$numpag) { $npag = $pag+1; ?>
<a href="pergunte_me?a=perguntas&id=<?php echo $id;?>&pag=<?php echo $npag;?>">Próxima&#187;</a>
<?php } ?>
<br/><?php echo $pag.'/'.$numpag;?><br/><br />
<?php if($numpag>2) { ?>
<form action="pergunte_me?" method="get">
Pular para página<input name="pag" size="3">
<input type="hidden" name="a" value="<?php echo $a;?>">
<input type="hidden" name="id" value="<?php echo $id;?>">
<input type="submit" value="IR">
</form>
<?php }?>
<?php	
	
	
}
?>
<?php
}
}
?>
<br/>
<div align="center">
<a href="/<?php echo gerarlogin($id);?>">Voltar ao perfil de <?php echo gerarnome($id);?></a><br/>
<br />
<a href="/home?"><?php echo $imginicio;?>Página principal</a><br><br>
<?php echo rodape();?>
</body>
</html>