<?php
require_once("".$_SERVER["DOCUMENT_ROOT"]."/funcoes.php");
require_once("".$_SERVER["DOCUMENT_ROOT"]."/mistake.php");
//seg($meuid);
$id=$id==true?$id:$meuid;
ubloq($meuid,$id);
if($a=='premios') { 
?>
<br/><div id="titulo"><b>Prêmios</b></div><br/>
<?php
if($_GET['deletar']==true && perm($meuid)>0){
$mistake->exec("DELETE FROM w_premios WHERE id='".$_GET['deletar']."'"); 
}
$cont = $mistake->query("SELECT count(*) FROM w_premios WHERE uid='$id'")->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $cont[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
$itens = $mistake->prepare("SELECT * FROM w_premios where uid='$id' ORDER BY id asc LIMIT $limit, $itensporpag");
$i=0; 
$itens->execute();
while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<?php 
if($item->img==1){
?>
<img src="/1.gif">
<?
}
if($item->img==2){
?>
<img src="/2.gif">
<?
}
if($item->img==3){
?>
<img src="/3.gif">
<?
}
if($item->img==4){
?>
<img src="/4.gif">
<?
}
if($item->img==5){
?>
<img src="/5.gif">
<?
}
if($item->img==6){
?>
<img src="/6.gif">
<?
}
if(perm($meuid)>0){ ?>
- <a href="perfil3?a=premios&id=<?php echo $id;?>&deletar=<?php echo $item->id;?>"><font color="#FF0000">[apagar]</font></a>
<?php } ?>
<br/>
<b>Prêmio :</b> <?php echo $item->prem;?> <br/><b>Descrição :</b> <?php echo $item->des;?><br/><b>Data :</b> <?php echo date('d/m/Y H:i:s', $item->dt);?>
</div>
<?php $i++; } } else { ?>
<div align="center"><?php echo $imgerro;?>Nenhum Prêmio <?php } ?>
<div align="center"><br/>
<?php if($pag>1) { $ppag = $pag-1; ?>
<a href="perfil3?a=<?php echo $a;?>&id=<?php echo $id;?>&pag=<?php echo $ppag;?>">&#171;Anterior</a>
<?php } if($pag<$numpag) { $npag = $pag+1; ?>
<a href="perfil3?a=<?php echo $a;?>&id=<?php echo $id;?>&pag=<?php echo $npag;?>">Próxima&#187;</a>
<?php } ?>
<br/><?php echo $pag.'/'.$numpag;?><br/>
<?php if($numpag>2) { ?>
<form action="perfil3.php" method="get">
Pular para página<input name="pag" size="3">
<input type="submit" value="IR">
<input type="hidden" name="a" value="<?php echo $a;?>">
<input type="hidden" name="id" value="<?php echo $id;?>">
</form>
<?php 
} 
}else{
$info = $mistake->query("SELECT * FROM w_usuarios WHERE id='$id'")->fetch();
$msgen = $mistake->query("SELECT COUNT(*) FROM w_msgs WHERE por='$id'")->fetch();
$msgre = $mistake->query("SELECT COUNT(*) FROM w_msgs WHERE pr='$id'")->fetch();
$mural = $mistake->query("SELECT COUNT(*) FROM w_mural WHERE drec='$id' AND tipo='1'")->fetch();
$pensa = $mistake->query("SELECT COUNT(*) FROM w_mural WHERE drec='$id' AND tipo='4'")->fetch();
$posts = $mistake->query("SELECT COUNT(*) FROM w_posts WHERE por='$id'")->fetch();
$topicos = $mistake->query("SELECT COUNT(*) FROM w_topicos WHERE por='$id'")->fetch();
$apostas = $mistake->query("SELECT COUNT(*) FROM w_ta WHERE uid='$id'")->fetch();
$compras = $mistake->query("SELECT COUNT(*) FROM w_loja_cc WHERE uid='$id'")->fetch();
$pres = $mistake->query("SELECT COUNT(*) FROM w_loja_cc WHERE aid='$id'")->fetch();
$mchat = $mistake->query("SELECT COUNT(*) FROM w_mchat WHERE por='$id'")->fetch();
$downs = $mistake->prepare("SELECT COUNT(*) FROM w_downs WHERE dn='$id'");
$downs->execute();
$downs = $downs->fetch();
$smile = $mistake->prepare("SELECT COUNT(*) FROM w_emocoes WHERE uid='".$info['id']."'");
$smile->execute();
$smile = $smile->fetch();
$comu = $mistake->prepare("SELECT COUNT(*) FROM w_comu WHERE dn='".$info['id']."'");
$comu->execute();
$comu = $comu->fetch();
$comumem = $mistake->prepare("SELECT COUNT(*) FROM w_comu_m WHERE uid='".$info['id']."' and ac='1'");
$comumem->execute();
$comumem = $comumem->fetch();
$enquetes = $mistake->prepare("SELECT COUNT(*) FROM w_enquetes WHERE uid='".$info['id']."'");
$enquetes->execute();
$enquetes = $enquetes->fetch();
$premios = $mistake->prepare("SELECT COUNT(*) FROM w_premios WHERE uid='".$info['id']."'");
$premios->execute();
$premios = $premios->fetch();
$pres = $mistake->prepare("SELECT COUNT(*) FROM w_loja_cc WHERE aid='".$info['id']."'");
$pres->execute();
$pres = $pres->fetch();
if($info['linha1']=='#000000' && $info['linha2']=='#000000' or $info['fundo_bg']==true or $testearray[55]==true){
$linha1 = '';
$linha2 = ''; 
}else{
$linha1 = ''.$info['linha1'].'';
$linha2 = ''.$info['linha2'].'';    
}
ativo($meuid,'Vendo perfil de '.$info['nm'].'');
if(permdono($meuid)&&$info['vs']==0){
$tempo2 = timepm($info['ativo']);
$tempo = "".$tempo2[0]." ".$tempo2[1]." atrás ";
}else{
$tempo = 'Indisponível ';    
}
if(!empty($info['borda']))
{
?>
<style type="text/css">@keyframes blink { 50% { border-color: transparent; } }body { border: 6px solid ;
margin: auto;//padding: 2px;
border-width: 20px; border-image: url(<?php echo $info['borda'];?>) 166 166 166 166 round;}img { border: 0px; }
}</style>
<?
}
?>
<style>body {background-image: url(/<?php echo $info['fundo_bg'];?>);background-size:contain;background-repeat: round;background-color:<?php echo $info['fundo'];?>;}</style>
<body>
<div id="titulo"><b><?php echo online($id)>0?gstat($id):$imgoff;?> Mais informações de <?php echo gerarnome($id);?></b></div><br/>
<table cellspacing="1" cellpadding="3" width="100%">
<tr><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha1; ?>">Mensagens enviadas: <?if($info['vs']==0){?><b><?php echo $msgen[0];?></b> - Recebidas: <b><?php echo $msgre[0];?></b><?}else{?>Indisponível<?}?></td></tr>
<tr><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha2; ?>">Recados no mural: <a href="/mural/recados/<?php echo $id;?>" style="color:<?php echo $info['links'];?>;"><b><?php echo $mural[0];?></b></a></td></tr>
<tr><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha1; ?>">Pensamentos: <a href="/mural/pensamentos/<?php echo $id;?>" style="color:<?php echo $info['links'];?>;"><b><?php echo $pensa[0];?></b></a></td></tr>
<tr><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha2; ?>">Tópicos: <a href="/forum/topicosperfil/<?php echo $id;?>" style="color:<?php echo $info['links'];?>;"><b><?php echo $topicos[0];?></b></a></td></tr>
<tr><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha1; ?>">Postagens no fórum: <a href="/forum/tpcperfil/<?php echo $id;?>" style="color:<?php echo $info['links'];?>;"><b><?php echo $posts[0];?></b></a></td></tr>
<tr><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha2; ?>">Postagens no chat: <b><?php echo $mchat[0];?></b></td></tr>
<tr><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha1; ?>">Pontos: <b><?php echo $info['pt'];?></b></td></tr>
<tr><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha2; ?>">Tempo online: <?php echo gerartempo($info['ton']);?></td></tr>
<tr><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha1; ?>">Inativo a <?php echo $tempo;?><span>•</span></td></tr>
<tr><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha2; ?>">Apostas: <b><a href="/apostadores?a=historico&id=<?php echo $id;?>" style="color:<?php echo $info['links'];?>;"><?php echo $apostas[0];?></a></b></td></tr>
<tr><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha1; ?>">Pontos no Banco: <b><?php echo $info['bank'];?></b></td></tr>
<tr><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha2; ?>">Acertos no Quiz: <b><?php echo $info['qza'];?></b></td></tr>
<tr><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha1; ?>">Erros no Quiz: <b><?php echo $info['qze'];?></b></td></tr>
<tr><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha2; ?>">Acertos total no Quiz: <b><?php echo $info['qzaa'];?></b></td></tr>
<tr><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha1; ?>">Erros total no Quiz: <b><?php echo $info['qzee'];?></b></td></tr>
<tr><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha2; ?>">Compras na loja: <b><a href="/lojas/compras/<?php echo $id;?>" style="color:<?php echo $info['links'];?>;"><?php echo $compras[0];?></a></b></td></tr>
<tr><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha1; ?>">Presentes recebidos: <b><a href="/lojas/presentes/<?php echo $id;?>" style="color:<?php echo $info['links'];?>;"><?php echo $pres[0];?></a></b></td></tr>
<tr><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha2; ?>">Downloads: <b><a href="downs/a/1/1/<?php echo $id;?>" style="color:<?php echo $info['links'];?>;"><?php echo $downs[0];?></a></b></td></tr>
<tr><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha1; ?>">Meus Smiles:<a href="/configuracoes/meusemocoes/<?php echo $info['id'];?>"  style="color:<?php echo $info['links'];?>;"><b><?php echo $smile[0];?></b></a></td></tr>
<tr><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha2; ?>">Enquetes:<a href="/enquete/verid/<?php echo $info['id'];?>" style="color:<?php echo $info['links'];?>;"><b><?php echo $enquetes[0];?></b></a></td></tr>
<tr><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha1; ?>">Prêmios:<a href="/perfil3?a=premios&id=<?php echo $info['id'];?>" style="color:<?php echo $info['links'];?>;"><b><?php echo $premios[0];?></b></a></td></tr>
<tr><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha2; ?>">Comunidades del<?php echo sexo($info['id'])=='M'?'e':'a';?> <a href="/comunidades/cmns/<?php echo $info['id'];?>/1/d" style="color:<?php echo $info['links'];?>;"><b><?php echo $comu[0];?></b></a></td></tr>
<tr><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha1; ?>">Membro em <a href="/comunidades/cmns/<?php echo $info['id'];?>/1/m" style="color:<?php echo $info['links'];?>;"><b><?php echo $comumem[0];?></b></a> comunidades</td></tr>
<tr><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha2; ?>"><a href="/pokemon/meus/<?php echo $info['id'];?>" style="color:<?php echo $info['links'];?>;">Meus Pokémons</a></td></tr>
<tr><td div style="color:<?php echo $info['texto'];?>" bgcolor="<?php echo $linha1; ?>"><a href="/walking/menu/<?php echo $info['id'];?>" style="color:<?php echo $info['links'];?>;">Zumbis</a></td></tr>
</table>
<?
}
?>
<br/><div align="center">
<a href="/<?php echo gerarlogin($id);?>" style="color:<?php echo $info['links'];?>;">Voltar ao perfil de <?php echo gerarnome($id);?></a><br/>
<a href="<?php echo $meuid ? '/home' : '/';?>" style="color:<?php echo $info['links'];?>;"><?php echo $imginicio;?>Página principal</a><br><br>
<?php echo rodape();?>
</body>
</html>