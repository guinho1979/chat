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
ativo($meuid,"Doando Pontos");
if($a==false) { 
?>
<br/><div id="titulo">Doar Pontos</div><br/><div align="center">
Quantos pontos quer doar a <?php echo gerarnome($id);?></a> ?<br/><br/>
Você tem <b> <?php echo pts($meuid);?></b> Pontos<br/><br/>
<?php echo gerarnome2($id);?></a> tem <b><?php echo pts($id);?></b> Pontos<br/><br/>
<form action="/doar_p?a=doar&id=<?php echo $id;?>" method="post">
Pontos: <input type="text" name="mdoarp" size="2"><input type="submit" value="Doar"/>
</form><br />
<?php } 
if($a=="doar"){
if($id!=$meuid){
?>
<br/><div align="center">
<?php
$moedas = $_POST['mdoarp'];
if(ctype_digit($moedas) and $moedas > 1 and pts($meuid) > 1 and pts($meuid) > $moedas){
$total = pts($id)+$moedas;
$txt = "ola ".html_entity_decode(gerarnome2($id))." , ".html_entity_decode(gerarnome2($meuid))." te doou $moedas pontos, seus pontos passaram de ".pts($id)." a $total.";
automsg($txt,1,$id);
 $mistake->exec("UPDATE w_usuarios SET pt=pt+$moedas WHERE id='$id'");
 $mistake->exec("UPDATE w_usuarios SET pt=pt-$moedas WHERE id='$meuid'");
?>
<img src="/style/ok.gif"><br />Pontos doados a <?php echo gerarnome($id);?><br/>
<?php 
}else{ 	
?>
<img src="/style/x.gif"><br />Erro Quantidade minima para doar 1 pontos , provavelmente você não possui <?php echo $moedas ;?><br/>
<?php 
} 
}
}
?>
<div align="center">
<div class="col-12 text-center" style="margin-top: 20px"><a href="javascript:window.history.back();"><< Voltar</a></div><br/>
<?php echo rodape(); ?>
</body>
</html>