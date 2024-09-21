<?php
require_once("".$_SERVER["DOCUMENT_ROOT"]."/funcoes.php");
require_once("".$_SERVER["DOCUMENT_ROOT"]."/mistake.php");
?>
<div id="titulo"> Rádio </div></br>

<center>
<iframe name="iframeradio" src="https://chatpipoca.net/radiosertaneja.php"  frameborder="0"  top: 120px; width: 150px; height: 80px;"></iframe>
</center>
  <br>

 <div class="col-12 text-center" style="margin-top: 20px"><center>
<a style="color: #000000" href="/home" target="_blank"><?php echo $imgsetavoltar;?><b>Voltar pro chat</b></a><br/><br/>

</center></div><br/>
<?
echo rodape();
?>
 </body>
</html>