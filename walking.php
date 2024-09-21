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
ativo($meuid,'The walking zumbi');
echo "<div id='titulo'>The Walking Dead Chibi<br /><img src=\"/twd/logotwd.gif\">";
if($a==false) {  ?>
<br/><br/>
Neste momento a brincadeira The walking zumbi esta <?php echo $testearray[29]==1?'<b><u>Ativada</u></b>':'<b><u>Desativada</u></b>';?><br/><br/>
Agora basta você começar a navegador no site e não deixe o zumbi escapar!<br/>
<br/>
<?php
}
echo"</div>";
if($a=="menu"){
$aconta1 = $mistake->query("SELECT COUNT(*) FROM twdcap WHERE uid='".$id."' AND walker='twd/1.gif'")->fetch();
if($aconta1[0]==0){ $aimagen1 ="<img width=\"56px\" src=\"/twd/1.gif\" style=\"opacity:0.4;border: yellow 2px solid;\">";
} else { $aimagen1 ="<img width=\"56px\"  style=\"border: yellow 2px solid;\" src=\"/twd/1.gif\">";  $asuma1 =1;
}
$aconta2 = $mistake->query("SELECT COUNT(*) FROM twdcap WHERE uid='".$id."' AND walker='twd/2.gif'")->fetch();
if($aconta2[0]==0){ $aimagen2 ="<img width=\"56px\" src=\"/twd/2.gif\" style=\"opacity:0.4;border: yellow 2px solid;\">";
} else { $aimagen2 ="<img width=\"56px\"  style=\"border: yellow 2px solid;\" src=\"/twd/2.gif\">";  $asuma2 =1;
}
$aconta3 = $mistake->query("SELECT COUNT(*) FROM twdcap WHERE uid='".$id."' AND walker='twd/3.gif'")->fetch();
if($aconta3[0]==0){ $aimagen3 ="<img width=\"56px\" src=\"/twd/3.gif\" style=\"opacity:0.4;border: yellow 2px solid;\">";
} else { $aimagen3 ="<img width=\"56px\"  style=\"border: yellow 2px solid;\" src=\"/twd/3.gif\">";  $asuma3 =1;
}
$aconta4 = $mistake->query("SELECT COUNT(*) FROM twdcap WHERE uid='".$id."' AND walker='twd/4.gif'")->fetch();
if($aconta4[0]==0){ $aimagen4 ="<img width=\"56px\" src=\"/twd/4.gif\" style=\"opacity:0.4;border: yellow 2px solid;\">";
} else { $aimagen4 ="<img width=\"56px\"  style=\"border: yellow 2px solid;\" src=\"/twd/4.gif\">";  $asuma4 =1;
}
$aconta5 = $mistake->query("SELECT COUNT(*) FROM twdcap WHERE uid='".$id."' AND walker='twd/5.gif'")->fetch();
if($aconta5[0]==0){ $aimagen5 ="<img width=\"56px\" src=\"/twd/5.gif\" style=\"opacity:0.4;border: yellow 2px solid;\">";
} else { $aimagen5 ="<img width=\"56px\"  style=\"border: yellow 2px solid;\" src=\"/twd/5.gif\">";  $asuma5 =1;
}
$aconta6 = $mistake->query("SELECT COUNT(*) FROM twdcap WHERE uid='".$id."' AND walker='twd/6.gif'")->fetch();
if($aconta6[0]==0){ $aimagen6 ="<img width=\"56px\" src=\"/twd/6.gif\" style=\"opacity:0.4;border: yellow 2px solid;\">";
} else { $aimagen6 ="<img width=\"56px\"  style=\"border: yellow 2px solid;\" src=\"/twd/6.gif\">";   $asuma6 =1;
}
$aconta7 = $mistake->query("SELECT COUNT(*) FROM twdcap WHERE uid='".$id."' AND walker='twd/7.gif'")->fetch();
if($aconta7[0]==0){ $aimagen7 ="<img width=\"56px\" src=\"/twd/7.gif\" style=\"opacity:0.4;border: yellow 2px solid;\">";
} else { $aimagen7 ="<img width=\"56px\"  style=\"border: yellow 2px solid;\" src=\"/twd/7.gif\">";  $asuma7 =1;
}
$aconta8 = $mistake->query("SELECT COUNT(*) FROM twdcap WHERE uid='".$id."' AND walker='twd/8.gif'")->fetch();
if($aconta8[0]==0){  $aimagen8 ="<img width=\"56px\" src=\"/twd/8.gif\" style=\"opacity:0.4;border: green 2px solid;\">";
} else { $aimagen8 ="<img width=\"56px\"  style=\"border: green 2px solid;\" src=\"/twd/8.gif\" >";  $asuma8 =1;
}
$aconta9 = $mistake->query("SELECT COUNT(*) FROM twdcap WHERE uid='".$id."' AND walker='twd/9.gif'")->fetch();
if($aconta9[0]==0){ $aimagen9 ="<img width=\"56px\" src=\"/twd/9.gif\" style=\"opacity:0.4;border: green 2px solid;\">";
} else { $aimagen9 ="<img width=\"56px\"  style=\"border: green 2px solid;\" src=\"/twd/9.gif\">";$asuma9 =1;
}
$aconta10 = $mistake->query("SELECT COUNT(*) FROM twdcap WHERE uid='".$id."' AND walker='twd/10.gif'")->fetch();
if($aconta10[0]==0){ $aimagen10 ="<img width=\"56px\" src=\"/twd/10.gif\" style=\"opacity:0.4;border: green 2px solid;\">";
} else { $aimagen10 ="<img width=\"56px\"  style=\"border: green 2px solid;\" src=\"/twd/10.gif\">";   $asuma10 =1;
}
$aconta11 = $mistake->query("SELECT COUNT(*) FROM twdcap WHERE uid='".$id."' AND walker='twd/11.gif'")->fetch();
if($aconta11[0]==0){ $aimagen11 ="<img width=\"56px\" src=\"/twd/11.gif\" style=\"opacity:0.4;border: green 2px solid;\">";
} else { $aimagen11 ="<img width=\"56px\"  style=\"border: green 2px solid;\" src=\"/twd/11.gif\">";    $asuma11 =1;
}
$aconta12 = $mistake->query("SELECT COUNT(*) FROM twdcap WHERE uid='".$id."' AND walker='twd/12.gif'")->fetch();
if($aconta12[0]==0){ $aimagen12 ="<img width=\"56px\" src=\"/twd/12.gif\" style=\"opacity:0.4;border: green 2px solid;\">";
} else { $aimagen12 ="<img width=\"56px\"  style=\"border: green 2px solid;\" src=\"/twd/12.gif\">";   $asuma12 =1;
}
$aconta13 = $mistake->query("SELECT COUNT(*) FROM twdcap WHERE uid='".$id."' AND walker='twd/13.gif'")->fetch();
if($aconta13[0]==0){ $aimagen13 ="<img width=\"56px\" src=\"/twd/13.gif\" style=\"opacity:0.4;border: red 2px solid;\"\">";
} else {  $aimagen13 ="<img width=\"56px\"  style=\"border: red 2px solid;\" src=\"/twd/13.gif\">";$asuma13 =1;
}
$aconta14 = $mistake->query("SELECT COUNT(*) FROM twdcap WHERE uid='".$id."' AND walker='twd/14.gif'")->fetch();
if($aconta14[0]==0){ $aimagen14 ="<img width=\"56px\" src=\"/twd/14.gif\" style=\"opacity:0.4;border: red 2px solid;\"\">";
} else { $aimagen14 ="<img width=\"56px\"  style=\"border: red 2px solid;\" src=\"/twd/14.gif\">";    $asuma14 =1;
}
$aconta15 = $mistake->query("SELECT COUNT(*) FROM twdcap WHERE uid='".$id."' AND walker='twd/15.gif'")->fetch();
if($aconta15[0]==0){ $aimagen15 ="<img width=\"56px\" src=\"/twd/15.gif\" style=\"opacity:0.4;border: red 2px solid;\"\">";
} else { $aimagen15 ="<img width=\"56px\"  style=\"border: red 2px solid;\" src=\"/twd/15.gif\">";$asuma15 =1;
}
$atotales = $asuma1+$asuma2+$asuma3+$asuma4+$asuma5+$asuma6+$asuma7+$asuma8+$asuma9+$asuma10+$asuma11+$asuma12+$asuma13+$asuma14+$asuma15;
$zom =  $mistake->query("SELECT twd, zom FROM w_usuarios WHERE id='".$id."'")->fetch();
echo "<br/><center>".gerarnome($id)." Tem <b>".$zom[0]."</b> Pontos Walkers<br /><b>".$zom[1]."</b> Zombies Aniquilados e <b>$atotales</b> personagens<br/><br/>";
echo "<table align=\"center\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\" bordercolor=\"#0066FF\"><tr>";
echo "<td>$aimagen1<br /><small><small>Hershel</small></small></td>";
echo "<td>$aimagen2<br /><small><small>Lee y<br />Clementine</small></small></td>";
echo "<td>$aimagen3<br /><small><small>Maggie</small></small></td>";
echo "<td>$aimagen4<br /><small><small>Merle</small></small></td>";
echo "<td>$aimagen5<br /><small><small>Morgan</small></small></td>";
echo "</tr><tr>";
echo "<td>$aimagen6<br /><small><small>T-Dog</small></small></td>";
echo "<td>$aimagen7<br /><small><small>Jesus</small></small></td>";
echo "<td>$aimagen8<br /><small><small>Carl</small></small></td>";
echo "<td>$aimagen9<br /><small><small>Carol</small></small></td>";
echo "<td>$aimagen10<br /><small><small>Gleen</small></small></td>";
echo "</tr><tr>";
echo "<td>$aimagen11<br /><small><small>Daryl</small></small></td>";
echo "<td>$aimagen12<br /><small><small>Michonne</small></small></td>";
echo "<td>$aimagen13<br /><small><small>Gobernador</small></small></td>";
echo "<td>$aimagen14<br /><small><small>Negan</small></small></td>";
echo "<td>$aimagen15<br /><small><small>Rick</small></small></td>";
echo "</tr></table>";
echo "<small>Amarelos: Personagens(nivel 1)<br />Verde: Segundos(nivel 2)<br />Roxo: Lideres(nivel 3)</small><div id='div1'><a href='/walking/top'>Top Pontos Walkers</a></div><div id='div2'><a href='/walking/topa'>Top Zombies aniquilados</a></div>";
} else if($a=="matar"){
$timeout = time() - 25;
$sql = "SELECT id FROM twd WHERE time<'".$timeout."' AND uid='".$meuid."'";
    $items = $mistake->query($sql);
    if($items->rowCount()>0)
    {
    while ($item = $items->fetch())
    {
      $mistake->query("DELETE FROM twd WHERE id='".$item[0]."'");
    
    }
    }
$conta = $mistake->query("SELECT COUNT(*) FROM twd WHERE uid='".$meuid."'")->fetch();
$info_item = $mistake->query("SELECT uid, tipo FROM twd WHERE id='".$id."'")->fetch();
if($conta[0]==0)
{
   echo "<p align=\"center\">";
   echo "<b>O zumbi foi retirado pacificamente!</b><br /><br />";
   echo "<meta http-equiv=\"refresh\" content=\"3; url=/home\">";
  echo "</p>";

} else
if($info_item[0]!=$meuid)
{
  echo "<p align=\"center\">";
  echo "<b>O zumbi foi retirado pacificamente!</b><br /><br />";
   echo "<meta http-equiv=\"refresh\" content=\"3; url=/home\">";
  echo "</p>";


}  else {
echo "<p align=\"center\">";                                  
$razao = 'Lost Jogar walker';
$razao2 = 'gan&oacute; jogando walker';
$tipo = $info_item[1];
$walker =  $mistake->query("SELECT uid, walker, tipo FROM twd WHERE id='".$id."'")->fetch();

if ($walker[2]=="lider"){
$ganancia1 = 4;
$imgst = 150;
} else if ($walker[2]=="segundos"){
$ganancia1 = 3;
$imgst = 30;
} else if ($walker[2]=="participantes"){
$ganancia1 = 2;
$imgst = 5;
} else if ($walker[2]=="zombie"){ 
$ganancia1 = 1;
$imgst = 1;
}
$ganancia=$ganancia1;
$final="voce ganhou $ganancia pontos";
$puni = $mistake->query("SELECT pt FROM w_usuarios WHERE id='".$meuid."'")->fetch();

$zom =  $mistake->query("SELECT twd, zom FROM w_usuarios WHERE id='".$meuid."'")->fetch();
$puni2 = $puni[0] + $ganancia;
$zom2= $zom[0] + $imgst;
$zom2s= $zom[1] + 1;
$ahi = time();
if ($walker[2]=="zombie"){

$mistake->query("UPDATE w_usuarios SET pt='".$puni2."' WHERE id='".$meuid."'");
$mistake->query("UPDATE w_usuarios SET twd='".$zom2."', zom='".$zom2s."' WHERE id='".$meuid."'");
echo "<center><br />Você matou um zumbi<br /><img src=\"/twd/zom.gif\"><br /> e você ganhou $ganancia1 pontos<br />e você tem $zom2s aniquilados";

}else{
if($walker[1]=="twd/1.gif"){$nombre = "Hershel";}else
if($walker[1]=="twd/2.gif"){$nombre = "Lee y<br />Clementine";}else
if($walker[1]=="twd/3.gif"){$nombre = "Maggie";}else
if($walker[1]=="twd/4.gif"){$nombre = "Merle";}else
if($walker[1]=="twd/5.gif"){$nombre = "Morgan";}else
if($walker[1]=="twd/6.gif"){$nombre = "T-Dog";}else
if($walker[1]=="twd/7.gif"){$nombre = "Jesus";}else
if($walker[1]=="twd/8.gif"){$nombre = "Carl";}else
if($walker[1]=="twd/9.gif"){$nombre = "Carol";}else
if($walker[1]=="twd/10.gif"){$nombre = "Gleen";}else
if($walker[1]=="twd/11.gif"){$nombre = "Daryl";}else
if($walker[1]=="twd/12.gif"){$nombre = "Michonne";}else
if($walker[1]=="twd/13.gif"){$nombre = "Gobernador";}else
if($walker[1]=="twd/14.gif"){$nombre = "Negan";}else
if($walker[1]=="twd/15.gif"){$nombre = "Rick";}
$sitiene =  $mistake->query("SELECT COUNT(*) FROM twdcap WHERE uid='".$meuid."' AND walker='".$walker[1]."'")->fetch();
if($sitiene[0]==0){
$mistake->query("INSERT INTO twdcap SET uid='".$walker[0]."', walker='".$walker[1]."', tipo='".$walker[2]."', time='".$ahi."'");
$nuevo ="Novo!";
}else{
$nuevo ="Você já possui esse personagem";
}
$mistake->query("UPDATE w_usuarios SET pt='".$puni2."' WHERE id='".$meuid."'");
$mistake->query("UPDATE w_usuarios SET twd='".$zom2."' WHERE id='".$meuid."'");
echo "<center><br />Você tem um personagem<br /><img src=\"/$walker[1]\"><br />Nome: <b>$nombre</b><br />Tipo:<b> $walker[2]<small>($imgst pts. walk)</small></b><br />ganhou $ganancia1 pontos<br />
Tem $zom2 pontos walkers.<br />
$nuevo";
}
$res = $mistake->query("DELETE FROM twd WHERE id='".$id."'");
if($res)
{

}else{
echo "<b>Error!</b>";
}
}  
}else if($a=="top"){  
echo "<center>Top walkers</center>"; 
if($pag=="" || $pag<=0)$pag=1;
$noi = $mistake->query("SELECT COUNT(*) FROM w_usuarios WHERE twd>='1'")->fetch();
$num_items = $noi[0];
$items_per_page= 10;
$num_pages = ceil($num_items/$items_per_page);
if(($pag>$num_pages)&&$pag!=1)$pag= $num_pages;
$limit_start = ($pag-1)*$items_per_page;
$sql = "SELECT id, twd FROM w_usuarios WHERE twd>='1' ORDER BY twd DESC LIMIT $limit_start, $items_per_page";
$cor = "<div id=\"div1\">"; 
$items = $mistake->query($sql);
$nick= gerarnome($meuid); 
if($noi[0]>0) {
echo "<p>";
while ($item = $items->fetch()){
if ($cor == "<div id=\"div1\">"){
$cor = "<div id=\"div2\">";
}else{
$cor = "<div id=\"div1\">";
}
echo"$cor<a href=\"/walking/menu/$item[0]\">".gerarnome($item[0]).": $item[1] pontos walkers</a></div>";
}
}
if($num_pages>1){
paginas('walking',$a,$num_pages,$id,$pag);
}
}else if($a=="topa"){  
echo "<center>Top aniquilador</center>"; 
if($pag=="" || $pag<=0)$pag=1;
$noi = $mistake->query("SELECT COUNT(*) FROM w_usuarios WHERE zom>='1'")->fetch();
$num_items = $noi[0];
$items_per_page= 10;
$num_pages = ceil($num_items/$items_per_page);
if(($pag>$num_pages)&&$pag!=1)$pag= $num_pages;
$limit_start = ($pag-1)*$items_per_page;
$sql = "SELECT id, zom FROM w_usuarios WHERE zom>='1' ORDER BY zom DESC LIMIT $limit_start, $items_per_page";
$cor = "<div id=\"div1\">"; 
$items = $mistake->query($sql);
$nick= gerarnome($meuid); 
if($noi[0]>0) {
echo "<p>";
while ($item = $items->fetch()){
if ($cor == "<div id=\"div1\">"){
$cor = "<div id=\"div2\">";
}else{
$cor = "<div id=\"div1\">";
}
echo"$cor<a href=\"/walking/menu/$item[0]\">".gerarnome($item[0]).": $item[1] zombies aniquilados</a></div>";
}
}
if($num_pages>1){
paginas('walking',$a,$num_pages,$id,$pag);
}
}
echo "<p align=\"center\">";
echo "<a href=\"/walking/menu/$meuid\" class=\"small button green\">Menu TWD</a><br>";
echo "</p>
<p align=\"center\">";
echo "<center>$imginicio<a href='/home?'>Pagina principal</a><br><br></center>";
echo rodape();
echo "</body></html>";
?>