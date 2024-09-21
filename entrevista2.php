<?php
require_once("".$_SERVER["DOCUMENT_ROOT"]."/funcoes.php");
require_once("".$_SERVER["DOCUMENT_ROOT"]."/mistake.php");
seg($meuid);
?>
<center>
<img src='/imagens/entrevista.gif' alt='entrevista'/></center></br>
  
<ul class="list-group shadow">
<li class="list-group-item">

<a href="entrevistas"> Entrevista Da Semana</a></li>
<li class="list-group-item">
<a href="gato?a=add"> Se inscrever
</a>
<li class="list-group-item">
<a href="gato?"> Vote nos inscritos
 </a>
</li></ul>

 <div class="col-12 text-center" style="margin-top: 20px"><center>
<a href="/home"><?php echo $imgsetavoltar;?><b>Página inicial</b></a><br/><br/>

</center></div>
<?
echo rodape();
?>
<br/>

 </body>
</html>