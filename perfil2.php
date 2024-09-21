<?php
require_once("".$_SERVER["DOCUMENT_ROOT"]."/funcoes.php");
require_once("".$_SERVER["DOCUMENT_ROOT"]."/mistake.php");
$info = $mistake->query("SELECT sbn, ft, qm, perm, vip, ano, relac, orient, nav, em, ip, pt, cid, est, ativo, rg, ton, visi, ta FROM w_usuarios WHERE id='$id'")->fetch();
$amigos = $mistake->query("SELECT COUNT(*) FROM w_amigos WHERE (uid='$id' OR tid='$id') AND ac='1'")->fetch();
$fas = $mistake->query("SELECT COUNT(*) FROM w_fas WHERE uid='$id'")->fetch();
$comu = $mistake->query("SELECT COUNT(*) FROM w_comu WHERE dn='$id'")->fetch();
$rec = $mistake->query("SELECT COUNT(*) FROM w_recados WHERE pr='$id'")->fetch();
$comumem = $mistake->query("SELECT COUNT(*) FROM w_comu_m WHERE uid='$id' and ac='1'")->fetch();
$albuns = $mistake->query("SELECT COUNT(*) FROM w_albuns WHERE dn='$id'")->fetch();
$downs = $mistake->query("SELECT COUNT(*) FROM w_downs WHERE dn='$id'")->fetch();
$msgen = $mistake->query("SELECT COUNT(*) FROM w_msgs WHERE por='$id'")->fetch();
$msgre = $mistake->query("SELECT COUNT(*) FROM w_msgs WHERE pr='$id'")->fetch();
$mural = $mistake->query("SELECT COUNT(*) FROM w_mural WHERE drec='$id'")->fetch();
$visitas = $mistake->query("SELECT COUNT(*) FROM w_visitas WHERE aid='$id'")->fetch();
$posts = $mistake->query("SELECT COUNT(*) FROM w_posts WHERE por='$id'")->fetch();
$namoro = $mistake->query("SELECT COUNT(*) FROM w_igreja WHERE (uid='$id' or aid='$id') and s='1'")->fetch();
$apostas = $mistake->query("SELECT COUNT(*) FROM w_ta WHERE uid='$id'")->fetch();
if($info[7]==0){
$or='Heterossexual';
}else if($info[7]==1){
$or='Gay';
}else if($info[7]==2){
$or='Bissexual';
}else{
$or='Curioso';
} 
?>
<br/><div id="titulo"><b>
<?php echo online($id)>0?gstat($id):$imgoff;?> Perfil de <?php echo gerarnome($id);?> <?php echo $info[0];?>
</b></div><br/><div align="center"><img src="fotoperfil/<?php echo $info[1];?>"><br/><br/>
<a href="/mensagens/enviarmsg/<?php echo $id;?>">Enviar mensagem</a></div><br/>
<table cellspacing="1" cellpadding="3" width="100%">
<tr><td bgcolor="#EAF3FA">Quem sou eu: <b><?php echo textot($info[2],$id,$on);?></b></td></tr>
<tr><td bgcolor="#EBF9DF">Status: <b><?php echo status($id);?></b></td></tr>
<tr><td bgcolor="#EAF3FA">Idade/Sexo: <b><?php echo $info[5];?>/<?php echo sexo($id)=='M'?'Masculino':'Feminino';?></b></td></tr>
<tr><td bgcolor="#EBF9DF">Localização: <b><?php echo $info[12];?> - <?php echo $info[13];?></b></td></tr>
<tr><td bgcolor="#EAF3FA">Relacionamento: <b><?php echo relac($id);?></b></td></tr>
<?php if($namoro[0]==0) { ?>
<tr><td bgcolor="#EBF9DF">Relacionamento no site: <b>Solteiro(a)</b></td></tr>
<?php } else { $nmr = $mistake->query("SELECT uid, aid FROM w_igreja WHERE uid='$id' or aid='$id' and s='1'")->fetch();
$nam=$nmr[0]==$id?$nmr[1]:$nmr[0];
?>
<tr><td bgcolor="#EBF9DF">Namorando no site com: <a href="/<?php echo gerarlogin($nam);?>"><?php echo gerarnome($nam);?></a></td></tr>
<?php } ?>
<tr><td bgcolor="#EAF3FA">Orientação sexual: <b><?php echo $or;?></b></td></tr>
<tr><td bgcolor="#EBF9DF">E-mail: <b><?php echo $info[9];?></b></b></td></tr>
<tr><td bgcolor="#EAF3FA">Navegador: <b><?php echo $info[8];?></b></td></tr>
<tr><td bgcolor="#EBF9DF">Cadastrou-se em: <b><?php echo date("d/m/Y - H:i:s",$info[15]);?></b></td></tr>
<tr><td bgcolor="#EAF3FA">Inativo por: <b><?php echo gerartempo(time()-$info[14]);?></b></td></tr>
<tr><td bgcolor="#EBF9DF">Mensagens enviadas: <b><?php echo $msgen[0];?></b> - Recebidas: <b><?php echo $msgre[0];?></b></td></tr>
<tr><td bgcolor="#EAF3FA">Recados no mural: <a href="/mural/recados/<?php echo $id;?>"><b><?php echo $mural[0];?></b></a></td></tr>
<tr><td bgcolor="#EBF9DF">Postagens: <a href="/forum/tpcperfil/<?php echo $id;?>"><b><?php echo $posts[0];?></b></a></td></tr>
<tr><td bgcolor="#EAF3FA">Pontos: <b><?php echo $info[11];?></b></td></tr>
<tr><td bgcolor="#EBF9DF">Amigos: <b><a href="/amigos/<?php echo $id;?>"><?php echo $amigos[0];?></a></b></td></tr>
<tr><td bgcolor="#EAF3FA">Visitantes recentes: <b><a href="visitas?id=<?php echo $id;?>"><?php echo $visitas[0];?></a></b></td></tr>
<tr><td bgcolor="#EBF9DF">Tempo online: <?php echo gerartempo($info[16]);?></td></tr>
<tr><td bgcolor="#EAF3FA">Apostas: <a href="/apostadores?a=historico&id=<?php echo $id;?>"><?php echo $apostas[0];?></a></td></tr>
<tr><td bgcolor="#EBF9DF"><a href="/relacionamento?a=namorar&id=<?php echo $id;?>">Pedir <?php echo gerarnome($id);?> em namoro</a></td></tr>
<tr><td bgcolor="#EAF3FA"><a href="/ppt?a=duelar&id=<?php echo $id;?>">Duelar com <?php echo gerarnome($id);?></a></td></tr>
</table>
<br/><br/><div align="center">
<a href="/fas?id=<?php echo $id;?>">Fãs (<?php echo $fas[0];?>)</a><br/>
<a href="/recados?id=<?php echo $id;?>">Recados (<?php echo $rec[0];?>)</a><br/>
<a href="/galeria/<?php echo $id;?>">Álbuns (<?php echo $albuns[0];?>)</a><br/>
<a href="/downloads?id=<?php echo $id;?>">Downloads (<?php echo $downs[0];?>)</a><br/>
<a href="/comunidades?a=cmns&id=<?php echo $id;?>&d=d">Comunidades del<?php echo sexo($id)=='M'?'e':'a';?> (<?php echo $comu[0];?>)</a><br/>
<a href="/comunidades?a=cmns&id=<?php echo $id;?>&d=m">Membros em <?php echo $comumem[0];?> comunidades</a><br/>
<a href="/home"><?php echo $imginicio;?>Página principal</a><br><br>
<?php echo rodape();?>
</body>
</html>