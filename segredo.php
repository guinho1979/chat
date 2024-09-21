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
ativo($meuid,'Vendo segredos');

?> 
<style type="text/css">
.section ul {
position: relative;
margin: 0 auto;
}
ul {
padding-left: 5px;
}
.figures {
display: inline;
}

.figures span {
font-size: 18px;
font-family: "Book Antiqua", "Palatino Linotype", Georgia, serif;
letter-spacing: 0.1em;
}

.figures img{
display: block;
vertical-align: top;
width: 300px;
height: 300px;

}
.figcaption {
display:block;
width: 300px;
text-align: center;
background: rgba(0,0,0,0.8);
text-decoration: none !important;
color: #fff;
opacity: 1.0;
-webkit-transition: 0.5s;
-moz-transition: 0.5s;
-o-transition: 0.5s;
-ms-transition: 0.5s;
}
.figcaption2 {
display:block;
width: 300px;
text-align: left;
background: #ffffff;
text-decoration: none !important;
color: #000000;
opacity: 1.0;
-webkit-transition: 0.5s;
-moz-transition: 0.5s;
-o-transition: 0.5s;
-ms-transition: 0.5s;
}

.curtiu_btn {
    background-image: url(/segredos/curtidas_vermelho.png);
    background-color: hsl(0, 0%, 100%);
    background-repeat: no-repeat; 
    background-size: 30px;
	background-position: left;
    border: none;           
    cursor: pointer;       
    height: 25px;          
    padding-left: 40px;     
}

.ncurtiu_btn {
    background-image: url(/segredos/curtidas_cinza.png);
    background-color: hsl(0, 0%, 100%);
    background-repeat: no-repeat; 
    background-size: 25px;
	background-position: left;
    border: none;           
    cursor: pointer;       
    height: 25px;          
    padding-left: 40px; 
}

.comentou_btn {
    background-image: url(/segredos/comentou_btn.png);
    background-color: hsl(0, 0%, 100%);
    background-repeat: no-repeat; 
    background-size: 30px;
	background-position: left;
    border: none;           
    cursor: pointer;       
    height: 25px;          
    padding-left: 40px;     
}
.ver_btn {
    background-image: url(/segredos/visualizar.png);
    background-color: hsl(0, 0%, 100%);
    background-repeat: no-repeat; 
    background-size: 30px;
	background-position: left;
    border: none;           
    cursor: pointer;       
    height: 25px;          
    padding-left: 40px;     
}
.ncomentou_btn {
    background-image: url(/segredos/ncomentou_btn.png);
    background-color: hsl(0, 0%, 100%);
    background-repeat: no-repeat; 
    background-size: 35px;
	background-position: left;
    border: none;           
    cursor: pointer;       
    height: 35px;          
    padding-left: 40px; 
}
.apagar_btn {
    background-image: url(/style/x.gif);
    background-color: hsl(0, 0%, 100%);
    background-repeat: no-repeat; 
    background-size: 25px;
	background-position: left;
    border: none;           
    cursor: pointer;       
    height: 25px;          
    padding-left: 40px; 
}
.icon{
display:block;
height:50px;
width:50px;
border-radius:25px;
float: center;
}
.icon img{
width: 40px;
height: 40px;
}
</style>
<?php if($a==false) {  ?>

<br/><div style="background-color:<?php echo $fundodestaque;?>;color:<?php echo $textodestaque;?>;text-align:center;<?php echo $borda;?>"><div id="titulo">Segredos</div></div><br/>
<div align="center"><center><br/>
<select onChange="location=options[selectedIndex].value">
<option value="">Opções</option>
<option value="/segredo">Aleatório</option>
<option value="/segredo?e=curtidos">Top curtidos</option>
<option value="/segredo?e=comentados">Top comentados</option>
<option value="/segredo?e=recentes">Recentes</option>
<option value="/segredo?e=meus">Meus segredos</option>
<option value="/segredo?e=todos">Todos</option>
<option value="/segredo?a=adicionar">Adicionar segredo</option>
<option value="/segredo?a=comofunciona">Como funciona?</option>
</select>
<br/><br/>
<?php
$postarid = isset($_POST['id'])?$_POST['id']:'';
if($postarid==true){
$vercurtidas2 = $mistake->query("SELECT count(*) FROM bymistake_segredos_curtidas WHERE segredo=".$_POST['id']." and por='$meuid'")->fetch();
$verdequemeh = $mistake->query("SELECT por FROM bymistake_segredos WHERE id=".$_POST['id']."")->fetch();
if($vercurtidas2[0]=='0'){
$mistake->exec("UPDATE bymistake_segredos SET curtidas=curtidas+1 where id=".$_POST['id']."");
$mistake->exec("INSERT INTO bymistake_segredos_curtidas (segredo,por) values('".$_POST['id']."','$meuid')");
if($meuid!=$verdequemeh['por']){
$textoatividades = 'Ganhou 1 ponto de atividade, na brincadeira de segredos';
$msgoknotificacao = " Um segredo adicionado por você foi curtido, você ganhou 1 ponto de atividade. Para visualizar este segredo clique [b][u][link=/segredo?a=segredo&id=$postarid]AQUI[/link][/u][/b]";
$res = $mistake->exec("update w_usuarios set atividades=atividades+1 where id='".$verdequemeh['por']."'");
automsg($msgoknotificacao,$verdequemeh['por'],$verdequemeh['por']);
}
echo ''.$imgok.' Segredo curtido com sucesso.<br/><br/>';
}else{
$mistake->exec("UPDATE bymistake_segredos SET curtidas=curtidas-1 where id=".$_POST['id']."");
$mistake->exec("DELETE FROM bymistake_segredos_curtidas WHERE segredo=".$_POST['id']." and por='$meuid'");
if($meuid!=$verdequemeh['por']){
$res = $mistake->exec("update w_usuarios set atividades=atividades-1 where id='".$verdequemeh['por']."'");
}
echo ''.$imgok.' Segredo descurtido com sucesso.<br/><br/>';
}}
$postarapagar = isset($_POST['apagar'])?$_POST['apagar']:'';
if($postarapagar==true){ ?>
<br/>Você tem certeza que deseja apagar este segredo?<br/>
<a href="segredo?apagar=<?php echo $postarapagar;?>"><font color="green"><b>SIM</b></font></a>  -  <a href="segredos"><font color="#FF0000"><b>NÃO</b></font></a><br/><br/>
<?php }
$getapagar = isset($_GET['apagar'])?$_GET['apagar']:'';
if($getapagar==true and perm($meuid)>0){
$dadosapagar = $mistake->query("SELECT id, texto, por, imagem, curtidas, comentarios, data FROM bymistake_segredos WHERE id='$getapagar'")->fetch();
if($dadosapagar['imagem']!='0'){
unlink("segredos/segredos/".$dadosapagar['imagem']."");
}
$itensapagar = $mistake->query("SELECT id, segredo FROM bymistake_segredos_cmt WHERE segredo='$getapagar'");
$iapagar=0; while ($itemapagar = $itensapagar->fetch(PDO::FETCH_OBJ)) {
$pegarcurtidasparaapagar = $mistake->query("SELECT count(*) FROM bymistake_segredos_cmt_curtidas WHERE cmt='".$itemapagar->id."'")->fetch();
if($pegarcurtidasparaapagar[0]>0){
$mistake->exec("DELETE FROM bymistake_segredos_cmt_curtidas WHERE cmt='".$itemapagar->id."'");
}
$iapagar++; }
$mistake->exec("DELETE FROM bymistake_segredos_cmt WHERE segredo='$getapagar'");
$mistake->exec("DELETE FROM bymistake_segredos_curtidas WHERE segredo='$getapagar'");
$mistake->exec("DELETE FROM bymistake_segredos_identificacao WHERE segredo='$getapagar'");
$mistake->exec("DELETE FROM bymistake_segredos WHERE id='$getapagar'");
echo ''.$imgok.' Segredo apagado com sucesso.<br/><br/>';
}
$contarquantos = $mistake->query("SELECT count(*) FROM bymistake_segredos")->fetch();
if($contarquantos[0]>0){
if($postarid==true){
$itens = $mistake->query("SELECT id, texto, por, imagem, curtidas, comentarios, data ,view FROM bymistake_segredos WHERE id!='$postarid' ORDER by RAND() limit 9");
}else if($postarapagar==true){
$itens = $mistake->query("SELECT id, texto, por, imagem, curtidas, comentarios, data ,view FROM bymistake_segredos WHERE id='$postarapagar'");
}else if($e==false){
$itens = $mistake->query("SELECT id, texto, por, imagem, curtidas, comentarios, data ,view FROM bymistake_segredos ORDER by RAND() limit 10");
}else if($e=='curtidos'){
$itens = $mistake->query("SELECT id, texto, por, imagem, curtidas, comentarios, data ,view FROM bymistake_segredos ORDER by curtidas desc limit 10");
}else if($e=='comentados'){
$itens = $mistake->query("SELECT id, texto, por, imagem, curtidas, comentarios, data ,view FROM bymistake_segredos ORDER by comentarios desc limit 10");
}else if($e=='recentes'){
$itens = $mistake->query("SELECT id, texto, por, imagem, curtidas, comentarios, data ,view FROM bymistake_segredos ORDER by data desc limit 10");
}else if($e=='todos'){
$itens = $mistake->query("SELECT id, texto, por, imagem, curtidas, comentarios, data ,view FROM bymistake_segredos ORDER by id asc limit 5000");
}else if($e=='meus'){
$itens = $mistake->query("SELECT id, texto, por, imagem, curtidas, comentarios, data ,view FROM bymistake_segredos WHERE por='$meuid' ORDER by id asc limit 5000");
}
?>
<div class="section">
<ul>
<?php
if($postarid==true){
$dadosidpostado = $mistake->query("SELECT id, texto, por, imagem, curtidas, comentarios, data FROM bymistake_segredos WHERE id='$postarid'")->fetch();
$vercurtidasdoid = $mistake->query("SELECT count(*) FROM bymistake_segredos_curtidas WHERE segredo='".$postarid."' and por='$meuid'")->fetch();
$vercomentariosdoid = $mistake->query("SELECT count(*) FROM bymistake_segredos_cmt WHERE segredo='".$postarid."' and por='$meuid'")->fetch();
?>
<li id="<?php echo $dadosidpostado['id'];?>" class="figures" >
<span class="figcaption"><?php echo textot($dadosidpostado['texto'],$meuid,$on);?></span>
<?php if($dadosidpostado['imagem']!='0'){ ?>
<img src="/segredos/segredos/<?php echo $dadosidpostado['imagem'];?>" alt="" class="figures"/>
<?php } ?>
<span class="figcaption2"><br/>
<form action="segredo" method="post">
<input type="submit" value="<?php echo $dadosidpostado['curtidas']; if($dadosidpostado['curtidas']==1 and $vercurtidasdoid[0]>0){ echo ' você curtiu'; }else if($dadosidpostado['curtidas']==1 and $vercurtidasdoid[0]=='0'){ echo ' curtida'; }else if($dadosidpostado['curtidas']=='0'){ echo ' ninguém curtiu'; }else{ echo ' curtidas'; }?>" name="curtir_<?php echo $dadosidpostado['id'];?>" class="<?php if ($vercurtidasdoid[0]=='0'){ echo 'ncurtiu_btn';}else{ echo 'curtiu_btn';}?>" />
<input type="hidden" name="id" value="<?php echo $dadosidpostado['id'];?>">
</form>
<hr>
<form action="segredo?a=segredo&id=<?php echo $dadosidpostado['id'];?>" method="post">
<input type="submit" value="<?php echo $dadosidpostado['comentarios']; if($dadosidpostado['comentarios']==1 and $vercomentariosdoid[0]>0){ echo ' você comentou'; }else if($dadosidpostado['comentarios']==1 and $vercomentariosdoid[0]=='0'){ echo ' comentário'; }else if($dadosidpostado['comentarios']=='0'){ echo ' ninguém comentou'; }else{ echo ' comentários'; }?>" name="comentar_<?php echo $dadosidpostado['id'];?>" class="<?php if ($vercomentariosdoid[0]=='0'){ echo 'ncomentou_btn';}else{ echo 'comentou_btn';}?>" />
</form>
<hr>
<form action="segredo?a=segredo&id=<?php echo $dadosidpostado['id'];?>" method="post">
<input type="submit" value="<?php echo $dadosidpostado['view'];?> Visualizações" name="ver" class="ver_btn" />
</form>
<?php
if(perm($meuid)>0){ ?>
<hr>
<form action="segredo" method="post">
<input type="submit" value="Apagar" name="excluir_<?php echo $dadosidpostado['id'];?>" class="apagar_btn" />
<input type="hidden" name="apagar" value="<?php echo $dadosidpostado['id'];?>">
</form>
<?php } ?>
</span>
<hr>
</li>
<?php }
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) {
$vercurtidas = $mistake->query("SELECT count(*) FROM bymistake_segredos_curtidas WHERE segredo=".$item->id." and por='$meuid'")->fetch(); 
$vercomentarios = $mistake->query("SELECT count(*) FROM bymistake_segredos_cmt WHERE segredo=".$item->id." and por='$meuid'")->fetch();
?>
<li id="<?php echo $item->id;?>" class="figures" >
<span class="figcaption"><?php echo textot($item->texto,$meuid,$on);?></span>
<?php if($item->imagem!='0'){ ?>
<img src="/segredos/segredos/<?php echo $item->imagem;?>" alt="" class="figures"/>
<?php } ?>
<span class="figcaption2"><br/>
<form action="segredo" method="post">
<input type="submit" value="<?php echo $item->curtidas; if($item->curtidas==1 and $vercurtidas[0]>0){ echo ' você curtiu'; }else if($item->curtidas==1 and $vercurtidas[0]=='0'){ echo ' curtida'; }else if($item->curtidas=='0'){ echo ' ninguém curtiu'; }else{ echo ' curtidas'; }?>" name="curtir_<?php echo $item->id;?>" class="<?php if ($vercurtidas[0]=='0'){ echo 'ncurtiu_btn';}else{ echo 'curtiu_btn';}?>" />
<input type="hidden" name="id" value="<?php echo $item->id;?>">
</form>
<hr>
<form action="segredo?a=segredo&id=<?php echo $item->id;?>" method="post">
<input type="submit" value="<?php echo $item->comentarios; if($item->comentarios==1 and $vercomentarios[0]>0){ echo ' você comentou'; }else if($item->comentarios==1 and $vercomentarios[0]=='0'){ echo ' comentário'; }else if($item->comentarios=='0'){ echo ' ninguém comentou'; }else{ echo ' comentários'; }?>" name="comentar_<?php echo $item->id;?>" class="<?php if ($vercomentarios[0]=='0'){ echo 'ncomentou_btn';}else{ echo 'comentou_btn';}?>" />
</form>
<hr>
<form action="segredo?a=segredo&id=<?php echo $item->id;?>" method="post">
<input type="submit" value="<?php echo $item->view;?> Visualizações" name="ver" class="ver_btn" />
</form>
<?php
if(perm($meuid)>0){ ?>
<hr>
<form action="segredo" method="post">
<input type="submit" value="Apagar" name="excluir_<?php echo $item->id;?>" class="apagar_btn" />
<input type="hidden" name="apagar" value="<?php echo $item->id;?>">
</form>
<?php } ?>
</span>
<hr>
</li>
<?php $i++; } ?>
</ul>
</div>
<?php }else{ ?>
<br/><?php echo $imgerro;?>Ainda não existe nenhum segredo.<br/>
Clique <a href="segredo?a=adicionar"><u>AQUI</u></a> e adicione.<br/>
<?php } ?>

</div></center><br/><br/>

<?php } else if($a=='segredo') { 
?>
<br/><div style="background-color:<?php echo $fundodestaque;?>;color:<?php echo $textodestaque;?>;text-align:center;<?php echo $borda;?>">
<div align="center"><center><br/>
<select onChange="location=options[selectedIndex].value">
<option value="">Opções</option>
<option value="segredo">Aleatório</option>
<option value="segredo?e=curtidos">Top curtidos</option>
<option value="segredo?e=comentados">Top comentados</option>
<option value="segredo?e=recentes">Recentes</option>
<option value="segredo?e=meus">Meus segredos</option>
<option value="segredo?e=todos">Todos</option>
<option value="segredo?a=adicionar">Adicionar segredo</option>
<option value="segredo?a=comofunciona">Como funciona?</option>
</select>
<br/><br/>
<?php
$msgok = isset($_GET['msg'])?$_GET['msg']:'';
$postarid = isset($_POST['id'])?$_POST['id']:'';
if(empty($_SESSION['visita_'.$id.''])){
$mistake->exec("UPDATE bymistake_segredos SET view=view+1 where id=".$id."");
$_SESSION['visita_'.$id.''] = 'visita_'.$id.''; 	
}
if($postarid==true){
$vercurtidas2 = $mistake->query("SELECT count(*) FROM bymistake_segredos_curtidas WHERE segredo=".$postarid." and por='$meuid'")->fetch();
$verdequemeh = $mistake->query("SELECT por FROM bymistake_segredos WHERE id=".$postarid."")->fetch();
if($vercurtidas2[0]=='0'){
$mistake->exec("UPDATE bymistake_segredos SET curtidas=curtidas+1 where id=".$_POST['id']."");
$mistake->exec("INSERT INTO bymistake_segredos_curtidas (segredo,por) values('".$_POST['id']."','$meuid')");
if($meuid!=$verdequemeh['por']){
$msgoknotificacao = "Um segredo adicionado por você foi curtido, você ganhou 1 ponto de atividade. Para visualizar este segredo clique [b][u][link=/segredo?a=segredo&id=$postarid]AQUI[/link][/u][/b]";
$res = $mistake->exec("update w_usuarios set atividades=atividades+1 where id='".$verdequemeh['por']."'");
automsg($msgoknotificacao,$verdequemeh['por'],$verdequemeh['por']);
}
echo ''.$imgok.' Segredo curtido com sucesso.<br/><br/>';
}else{
$mistake->exec("UPDATE bymistake_segredos SET curtidas=curtidas-1 where id=".$_POST['id']."");
$mistake->exec("DELETE FROM bymistake_segredos_curtidas WHERE segredo=".$_POST['id']." and por='$meuid'");
if($meuid!=$verdequemeh['por']){
$textoatividades = 'Um segredo adicionado por você foi descurtido, Perdeu 1 ponto de atividade. Para visualizar este segredo clique [b][u][link=/segredo?a=segredo&id=$postarid]AQUI[/link][/u][/b]';
$res = $mistake->exec("update w_usuarios set atividades=atividades-1 where id='".$verdequemeh['por']."'");
automsg($textoatividades,$verdequemeh['por'],$verdequemeh['por']);
}
echo ''.$imgok.' Segredo descurtido com sucesso.<br/><br/>';
}}
if($e==true){
$vercurtidascomentarios = $mistake->query("SELECT count(*) FROM bymistake_segredos_cmt_curtidas WHERE cmt=".$e." and por='$meuid'")->fetch();
$verdequemeh = $mistake->query("SELECT por FROM bymistake_segredos_cmt WHERE id=".$e."")->fetch();
$verdequalsegredoeh = $mistake->query("SELECT segredo FROM bymistake_segredos_cmt WHERE id=".$e."")->fetch();
if($vercurtidascomentarios[0]=='0'){
$mistake->exec("UPDATE bymistake_segredos_cmt SET curtidas=curtidas+1 where id=".$e."");
$mistake->exec("INSERT INTO bymistake_segredos_cmt_curtidas (cmt,por) values('$e','$meuid')");
if($meuid!=$verdequemeh['por']){
$msgoknotificacao = " Um comentário adiconado por você em um segredo foi curtido. Você ganhou 1 ponto de atividade. Para visualizar este comentário clique [b][u][link=/segredo?a=segredo&id=".$verdequalsegredoeh[0]."]AQUI[/link][/u][/b]";
$res = $mistake->exec("update w_usuarios set atividades=atividades+1 where id='".$verdequemeh['por']."'");
automsg($msgoknotificacao,$verdequemeh['por'],$verdequemeh['por']);
}
}else{
$mistake->exec("UPDATE bymistake_segredos_cmt SET curtidas=curtidas-1 where id=".$e."");
$mistake->exec("DELETE FROM bymistake_segredos_cmt_curtidas WHERE cmt=".$e." and por='$meuid'");
if($meuid!=$verdequemeh['por']){
$res = $mistake->exec("update w_usuarios set atividades=atividades-1 where id='".$verdequemeh['por']."'");
}
}}
$dadossegredo = $mistake->query("SELECT id, texto, por, imagem, curtidas, comentarios, data,view FROM bymistake_segredos WHERE id='$id'")->fetch(); 
if($dadossegredo['id']==false){
header("Location:segredo");
}
$comentarok = isset($_POST['texto'])?anti_injection($_POST['texto']):'';
$verdequemeh = $mistake->query("SELECT por FROM bymistake_segredos WHERE id=".$id."")->fetch();
$verdesejaexiste = $mistake->query("SELECT COUNT(*) FROM bymistake_segredos_cmt WHERE segredo='$id' and texto='$comentarok' and por='$meuid'")->fetch();
if($comentarok==true and $comentarok!=''){
if($verdesejaexiste[0]>0){
echo ''.$imgerro.' Você já fez este comentário antes.<br/><br/>';
}else{
$mistake->exec("INSERT INTO bymistake_segredos_cmt (segredo,texto,por,identidade,data) values('$id','$comentarok','$meuid','".md5($meuid)."','".time()."')");
$verdesejaexistem = $mistake->query("SELECT COUNT(*) FROM bymistake_segredos_identificacao WHERE por='$meuid'")->fetch();
if($verdesejaexistem[0]==0){
$corokl = "".rand(1,99).",".rand(100,300).",".rand(200,483).",".rand(1,9)."";
$mistake->exec("INSERT INTO bymistake_segredos_identificacao (segredo,imagem,por,identificacao,data,cor) values('$id','".rand(1,20)."','$meuid','".md5($meuid)."','".time()."','$corokl')");
}
$mistake->exec("UPDATE bymistake_segredos SET comentarios=comentarios+1 where id='$id'");
$idcomentariomaximo = $mistake->query("SELECT max(id) FROM bymistake_segredos_cmt WHERE segredo='$id'")->fetch();
if($meuid!=$verdequemeh['por']){
$msgoknotificacao = " Um segredo adicionado por você, foi comentado. Você ganhou 2 pontos de atividade. Para visualizar este comentário clique [b][u][link=/segredo?a=segredo&id=".$id."]AQUI[/link][/u][/b]";
$res = $mistake->exec("update w_usuarios set atividades=atividades+1 where id='".$verdequemeh['por']."'");
automsg($msgoknotificacao,$verdequemeh['por'],$verdequemeh['por']);
}
header("Location:segredo?a=segredo&id=$id&msg=".$idcomentariomaximo[0]."#comentario_".$idcomentariomaximo[0]."");
}}
$vercurtidasdoid = $mistake->query("SELECT count(*) FROM bymistake_segredos_curtidas WHERE segredo=".$dadossegredo['id']." and por='$meuid'")->fetch();
$vercomentariosdoid = $mistake->query("SELECT count(*) FROM bymistake_segredos_cmt WHERE segredo=".$dadossegredo['id']." and por='$meuid'")->fetch();
$postarapagar = isset($_POST['apagar'])?$_POST['apagar']:'';
if($postarapagar==true){ ?>
<br/>Você tem certeza que deseja apagar este segredo?<br/>
<a href="segredo?apagar=<?php echo $postarapagar;?>"><font color="green"><b>SIM</b></font></a>  -  <a href="/segredo?a=segredo&id=<?php echo $postarapagar;?>"><font color="#FF0000"><b>NÃO</b></font></a><br/><br/>
<?php } ?>
<div align="center">
<div class="section">
<ul>
<li id="<?php echo $dadossegredo['id'];?>" class="figures" >
<span class="figcaption"><?php echo textot($dadossegredo['texto'],$meuid,$on);?></span>
<?php if($dadossegredo['imagem']!='0'){ ?>
<img src="/segredos/segredos/<?php echo $dadossegredo['imagem'];?>" alt="" class="figures"/></img>
<?php } ?>
<div class="tituloWrapper">
<span class="figcaption2"><br/>
<form action="segredo?a=segredo&id=<?php echo $dadossegredo['id'];?>" method="post">
<input type="submit" value="<?php echo $dadossegredo['curtidas']; if($dadossegredo['curtidas']==1 and $vercurtidasdoid[0]>0){ echo ' você curtiu'; }else if($dadossegredo['curtidas']==1 and $vercurtidasdoid[0]=='0'){ echo ' curtida'; }else if($dadossegredo['curtidas']=='0'){ echo ' ninguém curtiu'; }else{ echo ' curtidas'; }?>" name="curtir_<?php echo $dadossegredo['id'];?>" class="<?php if ($vercurtidasdoid[0]=='0'){ echo 'ncurtiu_btn';}else{ echo 'curtiu_btn';}?>" />
<input type="hidden" name="id" value="<?php echo $dadossegredo['id'];?>">
</form>
<hr>
<input type="button" value="<?php echo $dadossegredo['comentarios']; if($dadossegredo['comentarios']==1 and $vercomentariosdoid[0]>0){ echo ' você comentou'; }else if($dadossegredo['comentarios']==1 and $vercomentariosdoid[0]=='0'){ echo ' comentário'; }else if($dadossegredo['comentarios']=='0'){ echo ' ninguém comentou'; }else{ echo ' comentários'; }?>" name="comentar_<?php echo $dadossegredo['id'];?>" class="<?php if ($vercomentariosdoid[0]=='0'){ echo 'ncomentou_btn';}else{ echo 'comentou_btn';}?>" />
<hr>
<form action="segredo?a=segredo&id=<?php echo $dadossegredo['id'];?>" method="post">
<input type="submit" value="<?php echo $dadossegredo['view'];?> Visualizações" name="ver" class="ver_btn" />
</form>
<?php
if(perm($meuid)>0){ ?>
<hr>
<form action="segredo?a=segredo&id=<?php echo $dadossegredo['id'];?>" method="post">
<input type="submit" value="Apagar" name="excluir_<?php echo $dadossegredo['id'];?>" class="apagar_btn" />
<input type="hidden" name="apagar" value="<?php echo $dadossegredo['id'];?>">
</form>
<?php } ?>
</span>
<span class="titulo" style="font-size:10px">
<?php echo empty(permdono($meuid)) ? 'Segredo' : gerarnome2($dadossegredo['por']);?>
</span>
</div>
</li>
</ul>
</div>
</div>
<?php
if($dadossegredo['por']!=$meuid){
if($vercomentariosdoid[0]==0){
$itens333 = $mistake->query("SELECT id, identificacao FROM bymistake_segredos_identificacao WHERE identificacao!='da0fd438186368b860d24fe68bd346b1dde55aa1' ORDER by RAND() limit 500");
$i333=0; while ($item333 = $itens333->fetch(PDO::FETCH_OBJ)) {
$checarjausado = $mistake->query("SELECT count(*) FROM bymistake_segredos_cmt WHERE identidade='".$item333->identificacao."'")->fetch();
if($checarjausado[0]==0){
define('identificacaominha',$item333->identificacao);
break;
}
$i333++; 
}
//$minhaidentificacao = @constant("identificacaominha");
}else{
$idcomentarioquemjapostou = $mistake->query("SELECT identidade FROM bymistake_segredos_cmt WHERE segredo=".$dadossegredo['id']." and por='$meuid'")->fetch();
$minhaidentificacao = $idcomentarioquemjapostou['identidade'];
}}else{
$minhaidentificacao = 'da0fd438186368b860d24fe68bd346b1dde55aa1';
} 
if($dadossegredo['comentarios']>0){ ?>
<br/><div style="background-color:<?php echo $fundodestaque;?>;color:<?php echo $textodestaque;?>;text-align:center;<?php echo $borda;?>"><b>Comentários</b></div><br/>
<?php
$itens = $mistake->query("SELECT id, segredo, texto, por, identidade, curtidas, data FROM bymistake_segredos_cmt where segredo='".$dadossegredo['id']."' order by id asc limit 99999");
$i=0; 
while ($item = $itens->fetch(PDO::FETCH_OBJ)) { 
$dadosidentidade = $mistake->query("SELECT id, imagem, cor, identificacao FROM bymistake_segredos_identificacao WHERE identificacao='".$item->identidade."'")->fetch();
$tempo2 = timepm($item->data);
$tempo = "".$tempo2[0]." ".$tempo2[1]."";
$verseeucurtirocmt = $mistake->query("SELECT count(*) FROM bymistake_segredos_cmt_curtidas WHERE por='$meuid' and cmt='".$item->id."'")->fetch();
if($verseeucurtirocmt[0]==0){
$iconecurtidasok = 'curtidas_cinza.png';
$textocurtir = 'curtir';
$textocurtir2 = 'descurtido';
}else{
$iconecurtidasok = 'curtidas_vermelho.png';
$textocurtir = 'descurtir';
$textocurtir2 = 'curtido';
}
?>
<div id="comentario_<?php echo $item->id;?>"></div>
<?php if($msgok==$item->id){ echo $imgok;?> Comentário adicionado com sucesso.<br/><?php } ?>
<?php if($e==$item->id){ echo $imgok;?> Comentário <?php echo $textocurtir2;?> com sucesso.<br/><?php } ?>
<table style="width:80%"  align="center" bgcolor="#FFFFFF">
<tr>
<td width="6%" align="center">
<div class="tituloWrapper">    
<div class="icon" style="background:rgba(<?php echo $dadosidentidade['cor'];?>)">
<img src="/segredos/<?php echo $dadosidentidade['imagem']==true?$dadosidentidade['imagem']:"segre";?>.png" width="40" height="40"/>
</div>
<span class="titulo" style="font-size:10px">
<?php echo empty(permdono($meuid)) ? 'Segredo' : gerarnome2($item->por);?>
</span>
</div>
</td>
<td width="94%" align="left">
<?php echo $dadossegredo['por']==$item->por ? '<font color="#58B6E1">'.textot($item->texto,$meuid,$on).'</font>' : textot($item->texto,$meuid,$on);?>
</td>
</tr>
</table>
<table style="width:-webkit-fill-available"  align="center" bgcolor="#FFFFFF">
<tr>
<td width="100%" align="center">
<small><?php echo $tempo;?> atrás <span>•</span> <a href="segredo?a=segredo&id=<?php echo $dadossegredo['id'];?>&e=<?php echo $item->id;?>#comentario_<?php echo $item->id;?>"><img src="/segredos/<?php echo $iconecurtidasok;?>" width="10" height="10" title="<?php echo $textocurtir;?>"/></a> <?php echo $item->curtidas;?><?php if($dadossegredo['por']==$item->por){ ?> <span>•</span> Autor<?php } ?></small>
</td>
</tr>
</table>
<hr>
<?php $i++; } } ?>
<br/><div style="background-color:<?php echo $fundodestaque;?>;color:<?php echo $textodestaque;?>;text-align:center;<?php echo $borda;?>"><b>Comentar</b></div><br/>
<form action="segredo?a=segredo&id=<?php echo $dadossegredo['id'];?>" method="post">
<textarea style="width:-webkit-fill-available" name="texto" cols="25" rows="5"></textarea>
<br/><br/>
<input type="hidden" name="identidade" value="<?php echo $minhaidentificacao;?>">
<input type="submit" name="comentar" value="Comentar">
</form>


</div></center><br/><br/>
<?php } else if($a=='adicionar') { ?>
<br/><div style="background-color:<?php echo $fundodestaque;?>;color:<?php echo $textodestaque;?>;text-align:center;<?php echo $borda;?>"><b>Adicionar segredo</b></div><br/>
<div align="center"><center><br/>
<select onChange="location=options[selectedIndex].value">
<option value="">Opções</option>
<option value="/segredo">Aleatório</option>
<option value="/segredo?e=curtidos">Top curtidos</option>
<option value="/segredo?e=comentados">Top comentados</option>
<option value="/segredo?e=recentes">Recentes</option>
<option value="/segredo?e=meus">Meus segredos</option>
<option value="/segredo?e=todos">Todos</option>
<option value="/segredo?a=adicionar">Adicionar segredo</option>
<option value="/segredo?a=comofunciona">Como funciona?</option>
</select>
<br/><br/>
Adicione um segredo, conte aquilo que você esconde de todos e saiba qual a reação das pessoas.<br/>
Fique tranquilo(a) pois ninguém vai saber quem é você, nem mesmo a equipe do site<br/><br/>

<form action="segredo?a=adicionar2" method="post" enctype="multipart/form-data">
<textarea style="width:-webkit-fill-available" name="texto" maxlength="500" value="" rows="5" cols="25"></textarea><br/>Você pode postar ou não uma imagem<br/><input type="file" name="arq"><br/>
<input type="submit" value="Enviar">
</form><br/><br/>

</div></center><br/>
<?php } else if($a=='adicionar2') { 
$verificarsejapostei = $mistake->query("SELECT count(*) FROM bymistake_segredos WHERE texto='".$_POST['texto']."' and por='$meuid'")->fetch();
?>
<br/><div style="background-color:<?php echo $fundodestaque;?>;color:<?php echo $textodestaque;?>;text-align:center;<?php echo $borda;?>"><b>Adicionar segredo</b></div><br/>
<div align="center"><center><br/>
<?php if($_POST['texto']==''){ ?>
<br/><?php echo $imgerro;?>Você deve inserir um texto!<br/>
<?php }else if($verificarsejapostei[0]>0){ ?>
<br/><?php echo $imgerro;?>Você já postou este segredo antes!<br/>
<?php }else{
if($_FILES['arq']['error'] != 0){
$mistake->exec("INSERT INTO bymistake_segredos (texto,por,data) values('".anti_injection($_POST['texto'])."','$meuid','".time()."')");
$res = $mistake->exec("update w_usuarios set atividades=atividades+3 where id='".$meuid."'");
}else{
$_UP['extensoes'] = array('jpg', 'png', 'gif', 'jpeg', 'JPG', 'PNG', 'GIF', 'JPEG');
$nebymistake_name = $_FILES['arq']['name'];
$file_ext = explode('.', $nebymistake_name);
$extensao = strtolower($file_ext[count($file_ext) - 1]);
if (array_search($extensao, $_UP['extensoes']) === false) { ?>
<br/><?php echo $imgerro;?>Adicione somente imagens com os formatos jpg, gif ou png.<br/>
Seu segredo foi adicionado sem imagem.<br/>
<?php }else{
$segredosmaximo = $mistake->query("SELECT max(id) FROM bymistake_segredos")->fetch();
$segredosmaximook = $segredosmaximo[0]+1;
copy($_FILES['arq']['tmp_name'], "segredos/segredos/".$segredosmaximook.".".$extensao."");
$mistake->exec("INSERT INTO bymistake_segredos (texto,por,imagem,data) values('".anti_injection($_POST['texto'])."','$meuid','".$segredosmaximook.".".$extensao."','".time()."')");
$res = $mistake->exec("update w_usuarios set atividades=atividades+3 where id='".$meuid."'");
}} ?>
<br/><?php echo $imgok;?>Segredo adicionado com sucesso.<br/>
Você ganhou 5 pontos de atividade.<br/>
<?php } ?>
</div></center><br/>
<?php }else if($a=='comofunciona'){ ?>
<br/><div style="background-color:<?php echo $fundodestaque;?>;color:<?php echo $textodestaque;?>;text-align:center;<?php echo $borda;?>"><b>Como funciona os segredo?</b></div><br/>
<div align="center"><center><br/>
<select onChange="location=options[selectedIndex].value">
<option value="">Opções</option>
<option value="/segredo">Aleatório</option>
<option value="/segredo?e=curtidos">Top curtidos</option>
<option value="/segredo?e=comentados">Top comentados</option>
<option value="/segredo?e=recentes">Recentes</option>
<option value="/segredo?e=meus">Meus segredos</option>
<option value="/segredo?e=todos">Todos</option>
<option value="/segredo?a=adicionar">Adicionar segredo</option>
<option value="/segredo?a=comofunciona">Como funciona?</option>
</select>
<br/><br/>
.Segredos é uma brincadeira onde você poderá expressar o que sente sobre tudo e todos, de forma totalmente anônima e segura.<br/>
.Nesta brincadeira nem mesmo pessoas da equipe saberão quem é você, desta forma você vai poder falar o que pensa avontade.<br/>
.Caso você fizer algum spam postando um segredo ou comentário, este texto será reportado e a equipe vai poder identificar você.<br/>
.Para cada pessoa que comentar o segredo postado por você, o sistema vai determinar um avatar e uma cor de fundo para o avatar. Com isso o sistema vai criar um avatar único para cada pessoa, desta forma sempre que aquela pessoa comentar o segredo, ela vai ter o mesmo avatar e a mesma cor de fundo.<br/>
.O autor do segredo sempre terá sempre seus textos na cor azul, e o avatar dele sempre será o mesmo.<br/>
.Cada vez que seu segredo for curtido você ganha 2 pontos de atividade.<br/>
.Cada vez que seu segredo for comentado você ganha 3 pontos de atividade.<br/>
.Cada vez que você adicionar um novo segredo irá ganhar 5 pontos de aticidade.<br/>
.Cada vez que um comentário seu for curtido você ganha 2 pontos de atividade.<br/>
.Somente a equipe do site poderá excluir algum segredo ou comentário.<br/>
.O autor do segredo sempre terá o seguinte avatar:
<table align="hight" cellpadding="3" cellspacing="1" bgcolor="#ffffff">
<tr>
<td bgcolor="#ffffff" align="hight">
<div class="icon" style="background:rgba(88, 182, 225, .8)"><img src="/segredos/segre.png" width="40" height="40"/></div><br/>
</td></tr></table><br/>
.Caso haja outras dúvidas favor consultar a equipe do <?php echo nome_site();?><br/>

</div></center><br/>
<?php } ?>

<div align="center"><center>
<a href="/segredo">Aleatórios</a><br/>
<a href="/segredo?e=curtidos">Top curtidos</a><br/>
<a href="/segredo?e=comentados">Top comentados</a><br/>
<a href="/segredo?e=recentes">Recentes</a><br/>
<a href="/segredo?e=meus">Meus segredos</a><br/>
<a href="/segredo?e=todos">Todos</a><br/>
<a href="/segredo?a=adicionar">Adicionar segredo</a><br/>
<a href="/segredo?a=comofunciona">Como funciona?</a><br/><br/>
<div class="col-12 text-center" style="margin-top: 20px"><a href="javascript:window.history.back();"><?php echo $imgsetavoltar;?> Voltar</a><br/>
<a href="/home"><?php echo $imginicio;?>Página principal</a><br><br></div><br/>

<?php echo rodape();?>

</body>
</html>