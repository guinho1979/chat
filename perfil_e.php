<?php
require_once("".$_SERVER["DOCUMENT_ROOT"]."/funcoes.php");
require_once("".$_SERVER["DOCUMENT_ROOT"]."/mistake.php");
seg($meuid);
$contid = $mistake->query("SELECT count(*) FROM w_usuarios WHERE id='$id'")->fetch();
if($contid[0]==0){
header("Location:home?");
}
ubloq($meuid,$id);
$info = $mistake->query("SELECT * FROM w_usuarios WHERE id='$id'")->fetch();
$ign = $mistake->query("SELECT COUNT(*) FROM w_ubloq WHERE uid='$meuid' and aid='$id'")->fetch();
?>
<br/><div id="titulo"><b>
<?php echo online($id)>0?gstat($id):$imgoff;?> Editando <?php echo gerarnome($id);?> <?php echo $info['sbn'];?>
</b></div>
<?php
if($info['ft']==true) {
$foto = $info['ft'];
}else{
$foto = 'semfoto.jpg';
}
?>
<br/><div align="center">
<?php 
if($i[0]==1) { 
?>
<img alt="foto" id="profile-img" class="profile-img" src="/<?php echo $foto;?>" oncontextmenu="return false" onselectstart="return false" ondragstart="return false" style="width:103px;height:136px;border-radius:50%; margin:1px; border:2px solid #FFF;" pbsrc="/<?php echo str_replace('m_','',$foto);?>" class="PopBoxImageSmall" title="Clique para ampliar/diminuir" onclick="Pop(this,50,'PopBoxPopImage');" />
<?php 
} 
?>
<br/>
<?php
if($meuid!=$id) {
/*
?>
<br />
<form action="/acao?a=enviar&id=<?php echo $id; ?>" method="post">
Ação: <select name="acao">
<option value="recebeu um abraço">Abraçar</option>
<option value="recebeu um aperto de mão">Apertar mão</option>
<option value="recebeu um beijo">Beijar</option>
<option value="recebeu um beijo na boca">Beijar na boca</option>
<option value="recebeu flores">Dar flores</option>
<option value="brigou">Brigar</option>
<option value="recebeu uma cantada">Cantada</option>
<option value="recebeu um cascudo">Cascudo</option>
<option value="recebeu Feliz Aniversário">Felicitar</option>
<option value="recebeu um convite para o teclar">Convidar para teclar</option>
<option value="recebeu um soco">Dar soco</option>
<option value="recebeu um carinho">Fazer carinho</option>
<option value="recebeu uma careta">Fazer careta</option>
<option value="brigou">Gritar</option>
<option value="recebeu um pisão no pé">Pisar no pé</option>
<option value="recebeu uma serenata">Serenata</option>
<option value="recebeu um selin">Selin</option>
<option value="recebeu boas vindas">Bem vindo</option>
</select>
<br><br />
<input value="Enviar ação" type="submit"></form>
<br />
<?php
*/
?>
<?
if(editamigos($meuid,$id)==0) { 
?>
<a href="/amigos/editaramigo/<?php echo $id;?>/add">Adicionar amigo</a><br/><br/>
<?php } else if(editamigos($meuid,$id)==1) { ?>Em espera<br/><br/>
<?php } else if(editamigos($meuid,$id)==2) { ?>
<a href="/amigos/editaramigo/<?php echo $id;?>/excluir">Excluir amigo</a><br/><br/>
<?php } if($ign[0]==0 and $meuid!=$id) { ?>
<a href="bd/perfilbd?id=<?php echo $id;?>&b=b">Bloquear usuário</a><br/><br/>
<?php } else if($ign[0]>0 and $meuid!=$id) { ?>
<a href="bd/perfilbd?id=<?php echo $id;?>&b=d">Desbloquear usuário</a><br/><br/>
<?php
} 
?>
<hr><b>Opções de relacionamento</b></hr><br><br>
<?
$namoro = $mistake->query("SELECT COUNT(*) FROM w_igreja WHERE (uid='$id' or aid='$id') and s='1'")->fetch();
if($namoro[0]==0) { 
?>
<br/><a href="relacionamento?a=namorar&id=<?php echo $id;?>&e=namorar">Pedir em namoro</a><br/>
<br/><a href="relacionamento?a=namorar&id=<?php echo $id;?>&e=casar">Pedir em casamento</a><br/>
<br/><a href="relacionamento?a=namorar&id=<?php echo $id;?>&e=ficar">Pedir para ficar</a><br/>
<br/><a href="relacionamento?a=namorar&id=<?php echo $id;?>&e=enrolar">Pedir para enrolar</a><br/>
<br/><a href="relacionamento?a=namorar&id=<?php echo $id;?>&e=aberto">Pedir relacionamento aberto</a>
<?php
}
}
if(vip($meuid)) {
echo'<br><br><hr><b>Opções de Bloqueio</b></hr><br><br>';	
if($info['bchat']==0) { 
?>
<a href="bd/perfilbd?id=<?php echo $id;?>&e=bchat&bloque=1">Bloquear no chat</a><br/>
<?php 
}else 
if($info['bchat']==1) { 
?>
<br/><a href="bd/perfilbd?id=<?php echo $id;?>&e=desbchat&bloque=1">Desbloquear no chat</a><br/>
<?php 
}
if($info['bchat1']==0) { 
?>
<br/><a href="bd/perfilbd?id=<?php echo $id;?>&e=bchat&bloque=2">Bloquear nas mensagens</a><br/>
<?php 
}else 
if($info['bchat1']==2) { 
?>
<br/><a href="bd/perfilbd?id=<?php echo $id;?>&e=desbchat&bloque=2">Desbloquear as mensagens</a><br/>
<?php 
}
if($info['bchat2']==0) { 
?>
<br/><a href="bd/perfilbd?id=<?php echo $id;?>&e=bchat&bloque=3">Bloquear no forum</a><br/>
<?php 
}else 
if($info['bchat2']==3) { 
?>
<br/><a href="bd/perfilbd?id=<?php echo $id;?>&e=desbchat&bloque=3">Desbloquear no forum</a><br/>
<?php 
}
if($info['bchat3']==0) { 
?>
<br/><a href="bd/perfilbd?id=<?php echo $id;?>&e=bchat&bloque=4">Bloquear no mural</a><br/>
<?php 
}else 
if($info['bchat3']==4) { 
?>
<br/><a href="bd/perfilbd?id=<?php echo $id;?>&e=desbchat&bloque=4">Desbloquear do mural</a><br/>
<?php 
}
if($info['bchat4']==0) { 
?>
<br/><a href="bd/perfilbd?id=<?php echo $id;?>&e=bchat&bloque=5">Bloquear mudar nick</a><br/>
<?php 
}else 
if($info['bchat4']==5) { 
?>
<br/><a href="bd/perfilbd?id=<?php echo $id;?>&e=desbchat&bloque=5">Desbloquear mudar nick</a><br/>
<?php 
} 
if($info['verificado']==0) { 
?>
<br/><a href="bd/perfilbd?id=<?php echo $id;?>&e=verificado&bloque=1">Marcar como verificado</a><br/>
<?php 
}else 
if($info['verificado']==1) { 
?>
<br/><a href="bd/perfilbd?id=<?php echo $id;?>&e=verificado&bloque=0">Desmarcar verificado</a><br/>
<?php 
} 
}  
?>
<br/><a href="home?"><?php echo $imginicio;?>Página principal</a><br><br>
<?php 
echo rodape();?>
</body>
</html>