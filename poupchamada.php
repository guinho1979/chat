<?php
require_once("".$_SERVER["DOCUMENT_ROOT"]."/funcoes.php");
if($_GET['id']>0){
$pmnaolidas = $mistake->prepare("SELECT COUNT(*) FROM w_depo WHERE pr='".$_GET['id']."'");
$pmnaolidas->execute();
$pmnaolidas = $pmnaolidas->fetch();
if($pmnaolidas[0]>0){
$aver = $mistake->prepare("SELECT * FROM w_depo WHERE pr='".$_GET['id']."' ORDER BY hr DESC LIMIT 0,1");
$aver->execute();
$aver = $aver->fetch();
echo "<div class='avisomsj'><a href=\"/chamada?tipo-".$aver['rec']."-".$aver['pr']."-".$aver['por']."#".$aver['hr']."\"><small>".gerarnome($aver['por'])."&emsp;&emsp;<br />".date("H:i:s", $aver['hr'])."<br />Olá Estou te Convidando Para uma Chamada de ".$aver['rec']." Aceita?</small></a></div>"; 
?>
<audio autoplay loop><source src="/ring.mp3" type="audio/mpeg"></audio>
<?
$mistake->exec("DELETE FROM w_depo WHERE id='".$aver['id']."'");
} 
}