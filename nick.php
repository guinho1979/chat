<?php
require_once("".$_SERVER["DOCUMENT_ROOT"]."/funcoes.php");
require_once("".$_SERVER["DOCUMENT_ROOT"]."/mistake.php"); 
seg($meuid);
echo"<br/><div id='titulo'><b>Muitas Fontes Legais...</a><br><b>Valor Descontado 0 pontos</b></div><br/>";
ativo($meuid,'Nick personalizado ');
$comprou = $_POST["comprar"];
$tamanho = $_POST["tamanho"];
$descomprou = $_POST["descomprar"];
$pag = isset($_GET['pag']) ? intval($_GET['pag']) : 1; 
$moedas = $mistake->query("SELECT pt,nm FROM w_usuarios WHERE id='$meuid'")->fetch();
if(!empty($comprou)&&!empty($tamanho)){
if($moedas[0]>0){
$mistake->exec("UPDATE w_usuarios SET pt=pt-0,fonte='".$comprou."',tamanhofonte='".$tamanho."' WHERE id='".$meuid."'");
echo "<div align='center'>Nick Personalizado Comprado com Sucesso ".gerarnome($meuid)."!</div>";
}else{
echo"<div align='center'>pontos insuficientes ".gerarnome($meuid)."</div><br/>";
}
}
if(!empty($descomprou)){
$mistake->exec("UPDATE w_usuarios SET fonte='Times New Roman',tamanhofonte='13pt' WHERE id='".$meuid."'");
echo "<div align='center'>Nick Normal com Sucesso ".gerarnome($meuid)."!</div><br/>";
}
if($_GET['limite']==true){
if(permdono($meuid)){
@unlink("estilo/".$_GET['limite'].".TTF");
}
}
echo"<div align='center'><b>Nick Normal</b><br><form action='/nick/a/$id/$pag' method='POST'>";
echo"<input name='descomprar' value='descomprar' type='hidden'><input value='Descomprar' type='submit'>";
echo"</form></div><br/>";
$arquivo = glob('estilo/*.*'); 
$total = 10; 
$atual = isset($_GET['pag']) ? intval($_GET['pag']) : 1; 
$pagopen = array_chunk($arquivo,$total); 
$contar = count($pagopen); 
$resultado = $pagopen[$atual-1]; 
if($pag>=1){
$x=0;
foreach($resultado as $file){ 
$file = str_replace("estilo/","",$file);
$file = str_replace(".TTF","",$file);
$color = ($x % 2 == 0)? "<div class='color'>"  : "<div class='color1'>";
echo"$color";
echo "<b>Fonte $file</b><a href='/nick/a/".$id."/".$pag."/".$file."'>[x]</a></br>";
echo"<style>@font-face{font-family:'$file';src:url('/estilo/$file.TTF') format('truetype')}</style><b style='font-family:$file; font-size:0.8em;text-shadow: 1px 1px 1px #FFF;'>".$moedas[1]."</b><br/>";
echo"<style>@font-face{font-family:'$file';src:url('/estilo/$file.TTF') format('truetype')}</style><b style='font-family:$file; font-size:1em;text-shadow: 1px 1px 1px #FFF;'>".$moedas[1]."</b><br/>";
echo"<style>@font-face{font-family:'$file';src:url('/estilo/$file.TTF') format('truetype')}</style><b style='font-family:$file; font-size:1.5em;text-shadow: 1px 1px 1px #FFF;'>".$moedas[1]."</b><br/>";
echo"<form action='/nick/a/$id/$pag' method='POST'>";
echo"<select name='tamanho'><option value='0.8em'>0.8 Em</option><option value='1em'>1 Em</option><option value='1.5em'>1.5 Em</option></select>";
echo"<input name='comprar' value='$file' type='hidden'>";
echo"<input value='Comprar' type='submit'>";
echo"</form></div><br/>";
$x++;
} 
paginas('nick','a',$contar,$id,$pag);
}
?>
<br/><div align="center"><a href="/configuracoes?"><?php echo $imgpreferencias;?>Painel do Usuário</a>
<br/><div align="center"><a href="/home?"><?php echo $imginicio;?>Página principal</a><br><br>
<?
rodape();
?>
</html></body>