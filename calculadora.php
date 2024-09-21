<?php
require_once("".$_SERVER["DOCUMENT_ROOT"]."/funcoes.php");
require_once("".$_SERVER["DOCUMENT_ROOT"]."/mistake.php");
seg($meuid);



ativo($meuid,'Calculadora '); ?>
<?php
$act = $_GET = $_SERVER['act'];
$act = $_GET = $_REQUEST['act'];
$do =$_POST = $_SERVER['do'];
$do =$_POST = $_REQUEST['do'];
$ad1 =$_POST = $_SERVER['ad1'];
$ad2 =$_POST = $_SERVER['ad2'];
$get =$_POST = $_SERVER['get'];
$ad1 =$_POST = $_REQUEST['ad1'];
$ad2 =$_POST = $_REQUEST['ad2'];
$get =$_POST = $_REQUEST['get'];
$sa =$_POST = $_REQUEST['sa'];
if($act=='')
{  ?>
<br/><div id="titulo"><b>Calculadora</b></div><br/>
<?php
if($do)
{
if($sa =="+")
{
$id = $ad1 +  $ad2;
}
if($sa =="-")
{
$id = $ad1-$ad2;
}
if($sa =="/")
{
$id = $ad1/$ad2;
}
if($sa =="%")
{
$id = $ad1%$ad2;
}
if($sa =="*")
{
$id = $ad1*$ad2;
}
if($ad1==NULL)
{
$message = '';
}
if($ad2==NULL)
{
$message = '';
}
else
{
$message = '';
}
echo $message; ?>
<b><?php echo $ad1specialchars($sa).$ad2.'='.$id;?></b><br/><br/>
<?php } ?>
<form  method="post" action="calculadora?&act=">
<input type="text" name="ad1" size="2"><br/>
<select name="sa">
<option value="-">Menos (-)</option>
<option value="+">Mais (+)</option>
<option value="%">Porcento (%)</option>
<option value="/">Dividir (/)</option>
<option value="*">Multiplicar (*)</option>
</select><br/>
<input type ="text" name="ad2" size="2"><br/>
<input type="hidden" name="do" value="do">
<input type="submit" value="Calcular">
<br/><br/>
<div align="center">
<a href="calculadora?act=mais">Mais opções</a>
<?php } else if($act=='mais') { ?>
<br/><div style="background:#ffffcc;color:#FFCC00;text-align:center;"><b>Ao quadrado/Cosseno/Seno/Tangente</b></div><br/>
<?php if($do) { ?>
<br/>
<?php $area=$get*$get; ?>
Área ao quadrado de <?php echo $get;?>: <b><?php echo $area;?></b><br/>
Cosseno de <?php echo $get;?>: <b><?php echo cos($get);?></b><br/>
Seno de <?php echo $get;?>: <b><?php echo sin($get);?></b><br/>
Tangente de <?php echo $get;?>: <b><?php echo tan($get);?></b><br/><br/>
<?php } ?>
<form method="post" action="?act=mais">
<input type ="text"  name="get" size="2"><br/>
<input type="hidden" name="do" value="do">
<input type="submit" value="Calcular"><br/>
<div align="center">
<a href="calculadora?">Calculadora</a>
<?php } ?>
<div align="center">
<br/><a href="entretenimento?"><?php echo $imgservicos;?>Entretenimento</a>
<br/><a href="home?"><?php echo $imginicio;?>Página principal</a><br><br>
<?php echo rodape();?>
</body>
</html>