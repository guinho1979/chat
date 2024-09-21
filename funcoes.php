<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
//error_reporting(E_ALL);
if(basename($_SERVER["PHP_SELF"])==basename(__FILE__)){
exit("<script>alert('Não Permitido')</script>\n<script>window.location=('/')</script>");
}
function bd_connect(){
try{
global $mistake;
$dbname = "chatpipoca_bd";
$dbhost = "localhost";
$dbuser = "chatpipoca_bd";
$dbpass = "U9h]Ch&(-7H7";
$mistake = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8",$dbuser,$dbpass, array(PDO::ATTR_EMULATE_PREPARES => true,PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'));
return true;
}
catch(PDOException $e){
return false;
}
}
if(!bd_connect()){
?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Cache-control" content="no-cache">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="0">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<title>Manutenção</title>
</head>
<style type="text/css">
body{font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:1.428571429;background-color:#fff;color:#2F3230;padding:0;margin:0}section{display:block;padding:0;margin:0}.container{margin-left:auto;margin-right:auto;padding:0 10px}.additional-info{background-repeat:no-repeat;background-color:#293A4A;color:#FFF}.additional-info-items{padding:20px;min-height:193px}.info-heading{font-weight:700;text-align:left;word-break:break-all;width:100%}.status-reason{font-size:200%;display:block;color:#CCC}.reason-text{margin:20px 0;font-size:16px}.info-heading{font-size:190%}.reason-text{font-size:140%}@media (min-width: 768px){.additional-info{position:relative;overflow:hidden;background-image:none}.additional-info-items{padding:20px}.container{width:90%}.status-reason{display:inline}}@media (min-width: 992px){.additional-info{background-image:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAPAAAADqCAMAAACrxjhdAAAAt1BMVEUAAAAAAAD////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////5+fn////////////////////////////////6+vr///////////////////////////////////////+i5edTAAAAPXRSTlMAAQECAwQFBgcICQoLDA0ODxAREhMUFRYXGBkaGxwdHh8gISIjJCUmJygoKSorLC0uLzAwMTIzNDU2Nzg5H7x0XAAACndJREFUeAHtXXlzGs8R7TQ3CFkHxpKxhIwtIBwgIuYY4u//uVJ2qpLKD7Q8t2Z7xpD3n6ska9/2bM9Mvz6oGEyXFoKHfmheoewx9cYehVuPHMT4jphyBtNHxHQmDGgBvZjXBuWN2gogbPy6RtcOejNPxFkb+CEYhHCfmJ6DQShfEGfMt71FOPgpE1PHOMTEY8oZ3yCr2UtiInqEftj3iLM18Afsu/xKv9B4QUzsV1XKFTzDPG+LfoLpE/LjJnzO08QCAugLalKeqP/mEmW6Qj+BPIE7IYmTyw1MFwbaksaybSxDCA4STF+wg8rH7EzMwqNibY38mlvXKDdU5pDH3TRkl40vxJkZ+DO2Nu/3HnyC7t15obGBtqRFRXo6+0Z5YQh5LHd9YGWOsF+9Is5oQXctZKbvdAAtbHHM8+GLfojWdIgPff7YifRTNiZmusW+w8fDj1xdevNnbU3VFfTEL/W33pfH31cGYBpgW9Lba3Ic8C8iA77NLe514vu8BPj6/n3lCd/VkgKXGkwYUQHAaM+yQunBmNSwbRVYh+kOcgMhvRDB1Md20YfiR+UFfvdIizp2v1vVjt0usa1pmNzAX2IFl5/xaE9aqQGSD6bxI0RZSw3uuF0YjQHepjMxHmd9IgC1NbY1VSkdeB4vXMH0KSQVIvQfERciMpcaFtW4H8iI0gB2MzfEcV3gB+IkfDtbyCATgtHB7l3TrKUG2yWOe7O2KYQIPE7xFD12Yvy6SvqoLOMf95k+BvgqogCFCx22NdltO1epYc7ycEKSaI9+UAYPGOlKDQYyxDP9Npqv0NKZkS7GuNRQig5pvaYQwdTztjRnCrr/l0b2UgO+wRtMiFCAzqpLL0So+hWmi61Nn3aqKGEzDfFrmEoKqcWSFDRONSrAU0iFYLrHU2RKB3q+HxDHT4JKEe2prhxY1aCS5lY+HnXu6N+x6IJCRQQmEEz+YjIE/xs/MmD8qHRYK5CAHuaTY5jfQxFC/YoIQSSVafrD+WK4H0Piv8SATRZChEXiOs39L/IYwiOxRHgeEKcmbMI9ccHRCdxUeYanFpQJMBUDIFxw1chJiBAomkz3x43l+nuWGmWhkQs0a6Y7YHVe772m1tZlUBEhKI9k6nuLE8bzKVSECEHeCZSysr04qJGnTzsVxJoQwm7bPhQ7cza5ECGQGpg6TnjzmWBbU7tExkhVw36yz3HCm0qEvEZ9C7vDYZeWAQhnKkQUG/i7NDnCL/hwbvJr6miPKHTaOE54xpBGrl8RIXKX1bk3+A1aUhHxUte3sHEvNSIp4REdBNONA9NOWYEwuq54AhPex3NaIQLwHIIQlQkPbwsRFpdmdb/hD8TSDCwTBu8W30sSIiS7P9NwZ7CgAeDjlaM9ktAD0+Mxwrse8XsTaMoRIoCaZmg3BQgLqrHVCBu3qhW3+AAOhwp52QIAfQkAwoDHKzfNEYck4ZPp5qh5Cp4VFiL8WM/Cl8SF4pgthvtHm4qQUIiQdY+5NMfu/228Pkq3NZNMqD1W7rMnrwJeQEmIwKsacMI/TVOLlHjQjM1YVtVQ3RwhvORo3ckiQ5ZOUzlCOMyi9Z+LXREhS5iqrI4QnuNlf8oVEbK8A556QQK0LNrTj2tiWfcFnh0hPIpYEVGjmBAe2b95U3wMxioiErRm2nuhd8QRCA8IwTRAW1O7PAsbtCPyMMgJp+1/IaxqGARzrFttphUR+MvEPSx+6m/pCxEi3Y7p485ESAVmuldvzSTKw2fqHSGM5hBW1IUI0f/LdONtEUKXGC95jK+Rg4QBVwNmlePZVjTxuo24kWMrQHg/nZzxDqmqFRFC799+dbEirMoVEXhVA07Y+GWNMOBCxIIpCgCpAX5KgHB6IQILHwE3HXk2XQVszdSkGECjUABhPLMdT/uKL0RIQ8DzYOKJu98V006LbSIkvBsRlzBPYkIRIH1743iEielBT4iQRkNHwUQMUtTWXqsiQugBiwl73OOrV0RIq/6+BIPPVVLrbAVAulQKIwAO/9jUKyJk51SmO5wwhpHXac0E3EQEfRIu6TfBYLQn/J3eCcFdE7i4dwmHckWErJsmU7eIsGnLxpVpVETI4kVM3VCUw1+XdRPRaM0k64jL1LEFkBBGRw7ad1ZE+AVH74Xh8NQM/dZMxVKDkPCyWmbPJ/8uIQJ/XbiL8bNKvv0vWlLCb0fQjR9zuU1y+sSkjcqsgPAzCVGFWzPpYxJM9GAMXhGRinD85xkrCxEomEY7I7j/40IEvjWlJ7wDzjJZtmbCW/cChOPPtlICMGXIAX3QFYQIRcI3Cq2ZNk3tYduunPxIpus8JoLi5e1u2yWN1kxd3UV9VXAdvnjntIksh1V3BSe/DIUIHBdRCMMV6OnHrtW3bxc8VJVmPQ+IFQmbtyUgejem6VszwaNJ5IQT9r8AUF04/DoMI+Nh1ZW5M4chJ5yuNRMAnv7Th0PwP74pTl9UjPZ8Gj19PYSn0S1FQG2VfGvSPqxrp52mBN6I25n2CTBOORE0/6GiVn9YNf8bFBd4RURFlWzBvyBEqIi4I9aky+2r29597/ZD62+xKVfBtNM6qaHRG61erXPBOfO6HN7UYlJmuslpWDUTdYab4L2z1v40hPPBvwzqOluTvhDBVB2a4Iyx/4UxLrx8goycW0UEgO4y2L3H+Ul5XI/4voc6rZkA3Bpv3njfS/nhR781E54N6t4OeWxQxuknguJ1S84ARR4RwAqtmaCFZnRiL2lbM+HaAC5npq+IwF+6hhfBWzNNlW6qCrGXRyza0yNOd1E1fsYUC7UV2Jop7XyXbsw90KYUInjpkRcecWfkEmdCAehgueuTmNt+shkReKd3v67nP9cNDJHvoD++xdvpovXKCp5SfoGxHsj0yF+IwHUus7smVh8IHVGIwJtLy7uN6Pe/wAnrBxOnAayISLWkQ8woBKyR++dUTsuEK+L8p2BD4fGdsfqhxGQTQZluHULXrRsUFfBE0OgzIlraR8vkw6qnXmuDSF8RgS8th+d+phci8FJf1fwapi44rFpfqTZAnW+JFRG3kf94Z+sSqdR1UIiI/dc/B6N/M9WsiADO00A3QU0hohX5RTdeCrstyT1WphURTBevBaV4iwYJGGctRDC1FsGaQ3RtGFfL4os34g6T+AkAT84bs0fX2weS88X7X6hXRDDRzdwHZ/5D2hjjght3Mb5y1NINq+beZBu8d84657wPYfN8pZBc0g+JKiKYiNr9r4v1Zrvdbtazp16TSCOfZppMiGD6iVqr271oVokU6AJ9U5FGnXIww5mH+kLEhxI1cl20QCGCTgRMA/3+F2lRXXtzXhURPTTt9GQA6h+d/1dE5An9GRH5o5mwIgKHvhCBi5j60Bci8oe+EKEPrYmg+QNNOw3PdCLgpBUROPQ18mX1ZEx8p9//Ii0qc3Qi6CmAU1dEpD9SA1tT98/GZadvf29GxPYPh9n+MjAuRNg/Hc4WYm8WjT0pABNB7WkAb81kz8fEo5Na0rAQYU8KQEWEPSkAaafnRPiXEGHPCCbcnxphIEPPnhXc9XkRNuHh3Cw8JXteeCV7Zjg/wua8YGl3XvDUPy/c/Avd4/hNDSqegQAAAABJRU5ErkJggg==)}.container{width:70%}.status-reason{font-size:450%}.info-heading{font-size:200%}.reason-text{font-size:160%}}
</style>
<body>
<div class="container">
<span class="status-reason">
<i class="fa fa-user-times fa-2x"></i> Manutenção
</span>
</div>
<section class="additional-info">
<div class="container">
<div class="additional-info-items">
<div class="info-heading">
Este site está em manutenção aguarde!
</div>
<div class="reason-text">
Entre em contato com o seu provedor de hospedagem para mais informações.
</div>
<div class="reason-text">
Acesse <a style="color:white" href="google.com">Google</a>
</div>
</div>
</div>
</section>
</body>
</html>
<?
exit();
}
function nome_site() {
$testearray = include("".$_SERVER["DOCUMENT_ROOT"]."/novoarray.php");
//$siteurl = ucfirst($_SERVER['USER']);
//$siteurl = $_SERVER['SERVER_NAME'];
$siteurl = $testearray[71];
echo $siteurl;
}
function site_url() {
$siteurl = $_SERVER['SERVER_NAME'];
echo $siteurl;
}
function getuid_sid($sid){
global $mistake;	
$uid = $mistake->prepare("SELECT id FROM w_usuarios WHERE onl='$sid'");
$uid->execute();
$uid = $uid->fetch();
if($uid[0]>0){
return $uid[0];
}else{
return false;   
}
}
function seg($meuid) {
global $mistake;
if(getuid_sid($_COOKIE['on'])==false) { 
/*
foreach ($_COOKIE as $cookie_name => $cookie_value) {
if($cookie_name!='autologin' && $cookie_name!='auto_usuario' && $cookie_name!='auto_senha' && $cookie_name!='Maior-de-18' && $cookie_name!='diretorio'){
setcookie($cookie_name,null, -1,"/",".".str_replace("www.","",$_SERVER["HTTP_HOST"])."");
}
}
*/
session_destroy();
?>
<div align="center"><br/>Você não está logado(a)<br/>Ou sua sessão expirou.<br/><br/><a href="/">Voltar a logar</a></div><br />
<?php rodape();
header("Location:/");
exit();
}
}
function rodape() { ?>
<div align="center">Baixar nosso APK <BR> <a href="https://<?php echo site_url();?>/app/CHAT PIPOCA_2_1.1.apk"><img src="/app/apk1.jpg"></a><br/><small><?php echo nome_site();?> - <?php echo date('Y');?><br /></small></div>
<?php 
}
function gerarnome($meuid){
global $mistake;	
$unome = $mistake->prepare("SELECT * FROM w_usuarios WHERE id='$meuid'");
$unome->execute();
$unome = $unome->fetch();
$avatar = $unome['av']==true ? "<img src='/".$unome['av']."' alt='*' alt='img' style='max-width:35px;max-height:35px'/>" : "";
$veri = $unome['verificado']==true ? "<img src='/style/verificado.png' width='16' height='16'>" : "";
$equip = $unome['perm']==true&&$unome['mostrastatus']==0 ? "<span style='background: green; color: white; box-shadow: 1px 1px 1px brown; font-size: 12px; vertical-align: middle; border-radius: 11px; padding: 2px 4px;'><font style=\"color: #FFFFFF\">Equipe</font></span>" : "";
$vip = $unome['vip']==true ? "<span style='background: red; color: white; box-shadow: 1px 1px 1px brown; font-size: 12px; vertical-align: middle; border-radius: 11px; padding: 2px 4px;'><font style=\"color: #FFFFFF\">Vip</font></span>" : "";
$newmM = $unome['corn6']==true && $unome['corn7']==true ? "<style>.misfram-$meuid {background: ".$unome['corn7'].";animation: mymove-$meuid 5s infinite;border-radius: 100%;}@keyframes mymove-$meuid {from {background-color: ".$unome['corn6'].";}to {background-color: ".$unome['corn5'].";}}</style>" : "";
if($unome['num_ativ']==1){
$nick = "<img src='/temp/".$unome['nm'].".gif'>";
return "$avatar$nick$veri";    
}else
if($unome['corn2']==true && $unome['corn3']==false){
$colors = array($unome['corn'],$unome['corn2'],$unome['corn'],$unome['corn2'],$unome['corn'],$unome['corn2'],$unome['corn'],$unome['corn2'],$unome['corn'],$unome['corn2'],$unome['corn'],$unome['corn2'],$unome['corn'],$unome['corn2'],$unome['corn'],$unome['corn2'],$unome['corn'],$unome['corn2'],$unome['corn'],$unome['corn2'],$unome['corn'],$unome['corn2'],$unome['corn'],$unome['corn2'],$unome['corn'],$unome['corn2'],$unome['corn'],$unome['corn2'],$unome['corn'],$unome['corn2'],$unome['corn'],$unome['corn2'],$unome['corn'],$unome['corn2'],$unome['corn'],$unome['corn2'],$unome['corn'],$unome['corn2'],$unome['corn'],$unome['corn2'],$unome['corn'],$unome['corn2'],$unome['corn'],$unome['corn2'],$unome['corn'],$unome['corn2'],$unome['corn'],$unome['corn2'],$unome['corn'],$unome['corn2'],$unome['corn'],$unome['corn2'],$unome['corn'],$unome['corn2'],$unome['corn'],$unome['corn2'],$unome['corn'],$unome['corn2'],$unome['corn'],$unome['corn2'],$unome['corn'],$unome['corn2'],$unome['corn'],$unome['corn2'],$unome['corn'],$unome['corn2'],$unome['corn'],$unome['corn2'],$unome['corn'],$unome['corn2'],$unome['corn'],$unome['corn2'],$unome['corn'],$unome['corn2'],$unome['corn'],$unome['corn2'],$unome['corn'],$unome['corn2'],$unome['corn'],$unome['corn2'],$unome['corn'],$unome['corn2'],$unome['corn']);
$ii = 0;
for($i=0;$i<=mb_strlen($unome['nm'])-1;$i++){
$new .= "<b style='color:$colors[$ii]'>".$unome['nm'][$ii]."</b>";
$ii++;
}
$new = preg_replace("~<b style='color:".$unome['corn']."'>&</b><b style='color:".$unome['corn2']."'>#</b><b style='color:".$unome['corn']."'>([0-9]+)</b><b style='color:".$unome['corn2']."'>([0-9]+)</b><b style='color:".$unome['corn']."'>([0-9]+)</b><b style='color:".$unome['corn2']."'>;</b>~","<b style='color:".$unome['corn']."'>&#$1$2$3;</b>",$new);
$new = preg_replace("~<b style='color:".$unome['corn2']."'>&</b><b style='color:".$unome['corn']."'>#</b><b style='color:".$unome['corn2']."'>([0-9]+)</b><b style='color:".$unome['corn']."'>([0-9]+)</b><b style='color:".$unome['corn2']."'>([0-9]+)</b><b style='color:".$unome['corn']."'>;</b>~","<b style='color:".$unome['corn2']."'>&#$1$2$3;</b>",$new);
$new = preg_replace("~<b style='color:".$unome['corn']."'>&</b><b style='color:".$unome['corn2']."'>#</b><b style='color:".$unome['corn']."'>([0-9]+)</b><b style='color:".$unome['corn2']."'>([0-9]+)</b><b style='color:".$unome['corn']."'>([0-9]+)</b><b style='color:".$unome['corn2']."'>([0-9]+)</b><b style='color:".$unome['corn']."'>;</b>~","<b style='color:".$unome['corn2']."'>&#$1$2$3$4;</b>",$new);
$new = preg_replace("~<b style='color:".$unome['corn2']."'>&</b><b style='color:".$unome['corn']."'>#</b><b style='color:".$unome['corn2']."'>([0-9]+)</b><b style='color:".$unome['corn']."'>([0-9]+)</b><b style='color:".$unome['corn2']."'>([0-9]+)</b><b style='color:".$unome['corn']."'>([0-9]+)</b><b style='color:".$unome['corn2']."'>;</b>~","<b style='color:".$unome['corn']."'>&#$1$2$3$4;</b>",$new);
$new = preg_replace("~<b style='color:".$unome['corn']."'>&</b><b style='color:".$unome['corn2']."'>#</b><b style='color:".$unome['corn']."'>([0-9]+)</b><b style='color:".$unome['corn2']."'>([0-9]+)</b><b style='color:".$unome['corn']."'>([0-9]+)</b><b style='color:".$unome['corn2']."'>([0-9]+)</b><b style='color:".$unome['corn']."'>([0-9]+)</b><b style='color:".$unome['corn2']."'>;</b>~","<b style='color:".$unome['corn']."'>&#$1$2$3$4$5;</b>",$new);
$new = preg_replace("~<b style='color:".$unome['corn2']."'>&</b><b style='color:".$unome['corn']."'>#</b><b style='color:".$unome['corn2']."'>([0-9]+)</b><b style='color:".$unome['corn']."'>([0-9]+)</b><b style='color:".$unome['corn2']."'>([0-9]+)</b><b style='color:".$unome['corn']."'>([0-9]+)</b><b style='color:".$unome['corn2']."'>([0-9]+)</b><b style='color:".$unome['corn']."'>;</b>~","<b style='color:".$unome['corn2']."'>&#$1$2$3$4$5;</b>",$new);
$new = preg_replace("~<b style='color:".$unome['corn']."'>&</b><b style='color:".$unome['corn2']."'>#</b><b style='color:".$unome['corn']."'>([0-9]+)</b><b style='color:".$unome['corn2']."'>([0-9]+)</b><b style='color:".$unome['corn']."'>([0-9]+)</b><b style='color:".$unome['corn2']."'>([0-9]+)</b><b style='color:".$unome['corn']."'>([0-9]+)</b><b style='color:".$unome['corn2']."'>([0-9]+)</b><b style='color:".$unome['corn']."'>;</b>~","<b style='color:".$unome['corn2']."'>&#$1$2$3$4$5$6;</b>",$new);
$new = preg_replace("~<b style='color:".$unome['corn2']."'>&</b><b style='color:".$unome['corn']."'>#</b><b style='color:".$unome['corn2']."'>([0-9]+)</b><b style='color:".$unome['corn']."'>([0-9]+)</b><b style='color:".$unome['corn2']."'>([0-9]+)</b><b style='color:".$unome['corn']."'>([0-9]+)</b><b style='color:".$unome['corn2']."'>([0-9]+)</b><b style='color:".$unome['corn']."'>([0-9]+)</b><b style='color:".$unome['corn2']."'>;</b>~","<b style='color:".$unome['corn']."'>&#$1$2$3$4$5$6;</b>",$new);
$newm .= "$newmM<span class='user' style='text-shadow: 1px 1px 1px #111111'><b class='misfram-$meuid' letter-spacing: 0.1rem>$new</b></span>";
return "$equip $vip $avatar $newm $veri";
}else
if($unome['corn3']==true){
$colors = array($unome['corn'],$unome['corn2'],$unome['corn3'],$unome['corn'],$unome['corn2'],$unome['corn3'],$unome['corn'],$unome['corn2'],$unome['corn3'],$unome['corn'],$unome['corn2'],$unome['corn3'],$unome['corn'],$unome['corn2'],$unome['corn3'],$unome['corn'],$unome['corn2'],$unome['corn3'],$unome['corn'],$unome['corn2'],$unome['corn3'],$unome['corn'],$unome['corn2'],$unome['corn3'],$unome['corn'],$unome['corn2'],$unome['corn3'],$unome['corn'],$unome['corn2'],$unome['corn3'],$unome['corn'],$unome['corn2'],$unome['corn3'],$unome['corn'],$unome['corn2'],$unome['corn3'],$unome['corn'],$unome['corn2'],$unome['corn3'],$unome['corn'],$unome['corn2'],$unome['corn3'],$unome['corn'],$unome['corn2'],$unome['corn3'],$unome['corn'],$unome['corn2'],$unome['corn3'],$unome['corn'],$unome['corn2'],$unome['corn3'],$unome['corn'],$unome['corn2'],$unome['corn3'],$unome['corn2'],$unome['corn3'],$unome['corn'],$unome['corn2'],$unome['corn3'],$unome['corn'],$unome['corn2'],$unome['corn3']);
$ii = 0;
for($i=0;$i<=mb_strlen($unome['nm'])-1;$i++){
$new .= "<b style='color:$colors[$ii]'>".$unome['nm'][$ii]."</b>";
$ii++;
}
$new = preg_replace("~<b style='color:".$unome['corn']."'>&</b><b style='color:".$unome['corn2']."'>#</b><b style='color:".$unome['corn3']."'>([0-9]+)</b><b style='color:".$unome['corn']."'>([0-9]+)</b><b style='color:".$unome['corn2']."'>([0-9]+)</b><b style='color:".$unome['corn3']."'>;</b>~","<b style='color:".$unome['corn']."'>&#$1$2$3;</b>",$new);
$new = preg_replace("~<b style='color:".$unome['corn2']."'>&</b><b style='color:".$unome['corn3']."'>#</b><b style='color:".$unome['corn']."'>([0-9]+)</b><b style='color:".$unome['corn2']."'>([0-9]+)</b><b style='color:".$unome['corn3']."'>([0-9]+)</b><b style='color:".$unome['corn']."'>;</b>~","<b style='color:".$unome['corn2']."'>&#$1$2$3;</b>",$new);
$new = preg_replace("~<b style='color:".$unome['corn3']."'>&</b><b style='color:".$unome['corn']."'>#</b><b style='color:".$unome['corn2']."'>([0-9]+)</b><b style='color:".$unome['corn3']."'>([0-9]+)</b><b style='color:".$unome['corn']."'>([0-9]+)</b><b style='color:".$unome['corn2']."'>;</b>~","<b style='color:".$unome['corn3']."'>&#$1$2$3;</b>",$new);
$new = preg_replace("~<b style='color:".$unome['corn']."'>&</b><b style='color:".$unome['corn2']."'>#</b><b style='color:".$unome['corn3']."'>([0-9]+)</b><b style='color:".$unome['corn']."'>([0-9]+)</b><b style='color:".$unome['corn2']."'>([0-9]+)</b><b style='color:".$unome['corn3']."'>([0-9]+)</b><b style='color:".$unome['corn']."'>;</b>~","<b style='color:".$unome['corn']."'>&#$1$2$3$4;</b>",$new);
$new = preg_replace("~<b style='color:".$unome['corn2']."'>&</b><b style='color:".$unome['corn3']."'>#</b><b style='color:".$unome['corn']."'>([0-9]+)</b><b style='color:".$unome['corn2']."'>([0-9]+)</b><b style='color:".$unome['corn3']."'>([0-9]+)</b><b style='color:".$unome['corn']."'>([0-9]+)</b><b style='color:".$unome['corn2']."'>;</b>~","<b style='color:".$unome['corn2']."'>&#$1$2$3$4;</b>",$new);
$new = preg_replace("~<b style='color:".$unome['corn3']."'>&</b><b style='color:".$unome['corn']."'>#</b><b style='color:".$unome['corn2']."'>([0-9]+)</b><b style='color:".$unome['corn3']."'>([0-9]+)</b><b style='color:".$unome['corn']."'>([0-9]+)</b><b style='color:".$unome['corn2']."'>([0-9]+)</b><b style='color:".$unome['corn3']."'>;</b>~","<b style='color:".$unome['corn3']."'>&#$1$2$3$4;</b>",$new);
$new = preg_replace("~<b style='color:".$unome['corn']."'>&</b><b style='color:".$unome['corn2']."'>#</b><b style='color:".$unome['corn3']."'>([0-9]+)</b><b style='color:".$unome['corn']."'>([0-9]+)</b><b style='color:".$unome['corn2']."'>([0-9]+)</b><b style='color:".$unome['corn3']."'>([0-9]+)</b><b style='color:".$unome['corn']."'>([0-9]+)</b><b style='color:".$unome['corn2']."'>;</b>~","<b style='color:".$unome['corn']."'>&#$1$2$3$4$5;</b>",$new);
$new = preg_replace("~<b style='color:".$unome['corn2']."'>&</b><b style='color:".$unome['corn3']."'>#</b><b style='color:".$unome['corn']."'>([0-9]+)</b><b style='color:".$unome['corn2']."'>([0-9]+)</b><b style='color:".$unome['corn3']."'>([0-9]+)</b><b style='color:".$unome['corn']."'>([0-9]+)</b><b style='color:".$unome['corn2']."'>([0-9]+)</b><b style='color:".$unome['corn3']."'>;</b>~","<b style='color:".$unome['corn2']."'>&#$1$2$3$4$5;</b>",$new);
$new = preg_replace("~<b style='color:".$unome['corn3']."'>&</b><b style='color:".$unome['corn']."'>#</b><b style='color:".$unome['corn2']."'>([0-9]+)</b><b style='color:".$unome['corn3']."'>([0-9]+)</b><b style='color:".$unome['corn']."'>([0-9]+)</b><b style='color:".$unome['corn2']."'>([0-9]+)</b><b style='color:".$unome['corn3']."'>([0-9]+)</b><b style='color:".$unome['corn']."'>;</b>~","<b style='color:".$unome['corn3']."'>&#$1$2$3$4$5;</b>",$new);
$new = preg_replace("~<b style='color:".$unome['corn']."'>&</b><b style='color:".$unome['corn2']."'>#</b><b style='color:".$unome['corn3']."'>([0-9]+)</b><b style='color:".$unome['corn']."'>([0-9]+)</b><b style='color:".$unome['corn2']."'>([0-9]+)</b><b style='color:".$unome['corn3']."'>([0-9]+)</b><b style='color:".$unome['corn']."'>([0-9]+)</b><b style='color:".$unome['corn2']."'>([0-9]+)</b><b style='color:".$unome['corn3']."'>;</b>~","<b style='color:".$unome['corn']."'>&#$1$2$3$4$5$6;</b>",$new);
$new = preg_replace("~<b style='color:".$unome['corn2']."'>&</b><b style='color:".$unome['corn3']."'>#</b><b style='color:".$unome['corn']."'>([0-9]+)</b><b style='color:".$unome['corn2']."'>([0-9]+)</b><b style='color:".$unome['corn3']."'>([0-9]+)</b><b style='color:".$unome['corn']."'>([0-9]+)</b><b style='color:".$unome['corn2']."'>([0-9]+)</b><b style='color:".$unome['corn3']."'>([0-9]+)</b><b style='color:".$unome['corn']."'>;</b>~","<b style='color:".$unome['corn2']."'>&#$1$2$3$4$5$6;</b>",$new);
$new = preg_replace("~<b style='color:".$unome['corn3']."'>&</b><b style='color:".$unome['corn']."'>#</b><b style='color:".$unome['corn2']."'>([0-9]+)</b><b style='color:".$unome['corn3']."'>([0-9]+)</b><b style='color:".$unome['corn']."'>([0-9]+)</b><b style='color:".$unome['corn2']."'>([0-9]+)</b><b style='color:".$unome['corn3']."'>([0-9]+)</b><b style='color:".$unome['corn']."'>([0-9]+)</b><b style='color:".$unome['corn2']."'>;</b>~","<b style='color:".$unome['corn3']."'>&#$1$2$3$4$5$6;</b>",$new);
$newm .= "$newmM<span class='user' style='text-shadow: 1px 1px 1px #111111'><b class='misfram-$meuid' letter-spacing: 0.1rem>$new</b></span>";
return "$equip $vip $avatar $newm $veri";
}else
if($unome['sx']=='M' || $unome['sx']=='0'){
return "$newmM<span class='user' style='text-shadow: 1px 1px 1px #111111'><b class='misfram-$meuid' letter-spacing: 0.1rem>$avatar".$unome['nm']."$veri</b></span>";
}else 
if($unome['sx']=='F'){
return "$newmM<span class='user' style='text-shadow: 1px 1px 1px #111111'><b class='misfram-$meuid' letter-spacing: 0.1rem>$avatar".$unome['nm']."$veri</b></span>";
}
}
function gstat($meuid,$id=null){
global $mistake;	
$unome = $mistake->prepare("SELECT * FROM w_usuarios WHERE id='$meuid' and vs='0'");
$unome->execute();
$unome = $unome->fetch();
if($unome['stats']==0&&$unome['inativo']>0){
return $id==0 ? '<i class="ion-person-stalker" style="font-size:22px;font-weight: bold;color:#00FF7F"></i>&nbsp;' : '<img src="/style/online.gif">&nbsp;';
}else 
if($unome['stats']==1&&$unome['inativo']>0){
return $id==0 ? '<i class="ion-android-person" style="font-size:22px;font-weight: bold;color:#FF8C00"></i>&nbsp;' : '<img src="/style/ocupado.gif">&nbsp;';
}else 	
if($unome['stats']==2&&$unome['inativo']>0){
return $id==0 ? '<i class="ion-clock" style="font-size:22px;font-weight: bold;color:#696969"></i>&nbsp;' : '<img src="/style/ausente.gif">&nbsp;';
}else{
return $id==0 ? '<i class="ion-android-alarm-clock" style="font-size:22px;font-weight: bold;color:#DC143C"></i>&nbsp;' : '<img src="/style/offline.gif">&nbsp;';
}
}
function online($meuid){
global $mistake;	
$inativo = time()-tempoativo();
$banido = $mistake->prepare("SELECT COUNT(*) FROM w_usuarios WHERE id='$meuid' and inativo>'$inativo' and vs='0'");
$banido->execute();
$banido = $banido->fetch();
return $banido[0];
}
function tempoativo(){
$testearray = include("".$_SERVER["DOCUMENT_ROOT"]."/novoarray.php");
$somando = $testearray[18];
return $somando;
}
function tempoativovisitas(){
$testearray = include("".$_SERVER["DOCUMENT_ROOT"]."/novoarray.php");
$somando = $testearray[19];
return $somando;
}
function vip($meuid){
global $mistake;	
$banido = $mistake->prepare("SELECT vip FROM w_usuarios WHERE id='$meuid'");
$banido->execute();
$banido = $banido->fetch();
if($banido[0]>0 || perm($meuid)>0){    
return true;
}else{
return false;
}
}
function perm($meuid){
global $mistake;	
$banido = $mistake->prepare("SELECT perm FROM w_usuarios WHERE id='$meuid'");
$banido->execute();
$banido = $banido->fetch();
return $banido[0];
}
function permdono($meuid){
if(perm($meuid)==3 || perm($meuid)==4){    
return true;
}else{
return false;
}
}
function gerarfoto($meuid,$width='40',$height='40'){
global $mistake;	
$banido = $mistake->prepare("SELECT * FROM w_usuarios WHERE id='$meuid'");
$banido->execute();
$banido = $banido->fetch();
$foto = $banido['ft']==true && file_exists($banido['ft'])?$banido['ft']:'semfoto.jpg';
return "<img src='/".$foto."' title=\"".$banido['nm']."\" style='width:".$width."px;height:".$height."px' class='misfoto' oncontextmenu='return false' onselectstart='return false' ondragstart='return false'>";
}
function sexo($meuid){
global $mistake;	
$banido = $mistake->prepare("SELECT sx FROM w_usuarios WHERE id='$meuid'");
$banido->execute();
$banido = $banido->fetch();
return $banido[0];
}
function pts($meuid){
global $mistake;	
$banido = $mistake->prepare("SELECT pt FROM w_usuarios WHERE id='$meuid'");
$banido->execute();
$banido = $banido->fetch();
return $banido[0];
}
function ptscavalo($meuid){
global $mistake;	
$banido = $mistake->prepare("SELECT caballo FROM w_usuarios WHERE id='$meuid'");
$banido->execute();
$banido = $banido->fetch();
return $banido[0];
}
function moedas($meuid){
global $mistake;	
$banido = $mistake->prepare("SELECT moedas FROM w_usuarios WHERE id='$meuid'");
$banido->execute();
$banido = $banido->fetch();
return $banido[0];
}
function privacidade($meuid){
global $mistake;	
$banido = $mistake->prepare("SELECT duelo FROM w_usuarios WHERE id='$meuid'");
$banido->execute();
$banido = $banido->fetch();
return $banido[0];
}
function relac($meuid){
global $mistake;	
$banido = $mistake->prepare("SELECT CASE relac WHEN 1 THEN 'Solteiro(a)' WHEN 2 THEN 'Casado(a)' WHEN 3 THEN 'Namorando' WHEN 4 THEN 'Relacionamento Aberto' ELSE 'Casamento Aberto' END as status FROM w_usuarios WHERE id='$meuid'");
$banido->execute();
$banido = $banido->fetch();
return $banido[0];
}
function status($meuid){
global $mistake;	
$status = $mistake->prepare("SELECT perm,pt,vip,sx,perm2,gato,banido,mostrastatus FROM w_usuarios WHERE id='$meuid'");
$status->execute();
$status = $status->fetch();
$status_alugado = $mistake->prepare("SELECT*, COUNT(*) FROM status_alugado WHERE uid='".$meuid."'");
$status_alugado->execute();
$status_alugado = $status_alugado->fetch();
if($status[6]>0){
if ($status[3]=='M'){
return "<span style='background: #1E90FF; color: white; box-shadow: 1px 1px 1px brown; font-size: 15px; vertical-align: middle; border-radius: 11px; padding: 2px 4px;'><font style=\"color: #FFFFFF\">BANIDO!</font></span>";
}else{
return "<span style='background: #1E90FF; color: white; box-shadow: 1px 1px 1px brown; font-size: 15px; vertical-align: middle; border-radius: 11px; padding: 2px 4px;'><font style=\"color: #FFFFFF\">BANIDA!</font></span>";
}
}
if($status_alugado["COUNT(*)"]>0)
{
return " <span style='background: #00008B; color: white; box-shadow: 1px 1px 1px brown; font-size: 18px; vertical-align: middle; border-radius: 11px; padding: 2px 4px;'><font style=\"color: #FFFFFF\"> $status_alugado[nome] </font></span>";
    
}
if($status[2]==3){
if ($status[3]=='M'){
return "<span style='background: #00BFFF; color: white; box-shadow: 1px 1px 1px brown; font-size: 15px; vertical-align: middle; border-radius: 11px; padding: 2px 4px;'><font style=\"color: #FFFFFF\">Entrevistado!</font></span>";
}else{
return "<span style='background: #00BFFF; color: white; box-shadow: 1px 1px 1px brown; font-size: 15px; vertical-align: middle; border-radius: 11px; padding: 2px 4px;'><font style=\"color: #FFFFFF\">Entrevistada!</font></span>";
}
}
if($status[4]==1){
return "<span style='background: #87CEEB; color: white; box-shadow: 1px 1px 1px brown; font-size: 15px; vertical-align: middle; border-radius: 11px; padding: 2px 4px;'><font style=\"color: #FFFFFF\">Sub-Moderador(a)</font></span>";
}else 
if($status[4]==3){
return "<span style='background: #87CEEB; color: white; box-shadow: 1px 1px 1px brown; font-size: 15px; vertical-align: middle; border-radius: 11px; padding: 2px 4px;'><font style=\"color: #FFFFFF\">Supervisor</font></span>";
}else 
if($status[4]==2){
return  "<span style='background: #006400; color: white; box-shadow: 1px 1px 1px brown; font-size: 15px; vertical-align: middle; border-radius: 11px; padding: 2px 4px;'><font style=\"color: #FFFFFF\">Moderador(a) de chat</font></span>";
}else 
if($status[2]==2){
return "<span style='background: #B22222; color: white; box-shadow: 1px 1px 1px brown; font-size: 15px; vertical-align: middle; border-radius: 11px; padding: 2px 4px;'><font style=\"color: #FFFFFF\">Divulgador</font></span>";
}else 
if($status[2]==1){
return "<span style='background: #9400D3; color: white; box-shadow: 1px 1px 1px brown; font-size: 15px; vertical-align: middle; border-radius: 11px; padding: 2px 4px;'><font style=\"color: #FFFFFF\">Usuário V.I.P !</font></span>";
}else 
if($status[0]==1){
if ($status[3]=='M'){
return "<span style='background: #006400; color: white; box-shadow: 1px 1px 1px brown; font-size: 15px; vertical-align: middle; border-radius: 11px; padding: 2px 4px;'><font style=\"color: #FFFFFF\">Moderador!</font></span>";
}else 
if ($status[3]=='F'){
return "<span style='background: #006400; color: white; box-shadow: 1px 1px 1px brown; font-size: 15px; vertical-align: middle; border-radius: 11px; padding: 2px 4px;'><font style=\"color: #FFFFFF\">Moderadora!</font></span>";
}
}else 
if($status[0]==2){
if ($status[3]=='M'){
return "<span style='background: #FF0000; color: white; box-shadow: 1px 1px 1px brown; font-size: 15px; vertical-align: middle; border-radius: 11px; padding: 2px 4px;'><font style=\"color: #FFFFFF\">Administrador!</font></span>";
}else 
if ($status[3]=='F'){
return "<span style='background: #FF0000; color: white; box-shadow: 1px 1px 1px brown; font-size: 15px; vertical-align: middle; border-radius: 11px; padding: 2px 4px;'><font style=\"color: #FFFFFF\">Administradora!</font></span>";
}
}else 
if($status[0]==4 && $status[7]==0){
if ($status[3]=='M'){
return "<span style='background: #2F4F4F; color: white; box-shadow: 1px 1px 1px brown; font-size: 15px; vertical-align: middle; border-radius: 11px; padding: 2px 4px;'><font style=\"color: #FFFFFF\">Dono!</font></span>";
}else 
if ($status[3]=='F'){
return "<span style='background: #2F4F4F; color: white; box-shadow: 1px 1px 1px brown; font-size: 15px; vertical-align: middle; border-radius: 11px; padding: 2px 4px;'><font style=\"color: #FFFFFF\">Dona!</font></span>";
}
}else 
if($status[0]==5){
if ($status[3]=='M'){
return "<span style='background: #00FF00; color: white; box-shadow: 1px 1px 1px brown; font-size: 15px; vertical-align: middle; border-radius: 11px; padding: 2px 4px;'><font style=\"color: #FFFFFF\">Supervisor!</font></span>";
}else 
if ($status[3]=='F'){
return "<span style='background: #00FF00; color: white; box-shadow: 1px 1px 1px brown; font-size: 15px; vertical-align: middle; border-radius: 11px; padding: 2px 4px;'><font style=\"color: #FFFFFF\">Supervisora!</font></span>";
}
}else 
if($status[0]==6){
if ($status[3]=='M'){
return "<span style='background: #708090; color: white; box-shadow: 1px 1px 1px brown; font-size: 15px; vertical-align: middle; border-radius: 11px; padding: 2px 4px;'><font style=\"color: #FFFFFF\">Sub-Dono!</font></span>";
}else 
if ($status[3]=='F'){
return "<span style='background: #708090; color: white; box-shadow: 1px 1px 1px brown; font-size: 15px; vertical-align: middle; border-radius: 11px; padding: 2px 4px;'><font style=\"color: #FFFFFF\">Sub-Dona!</font></span>";
}
}else 
if($status[0]==7){
if ($status[3]=='M'){
return "<span style='background: #FF6347; color: white; box-shadow: 1px 1px 1px brown; font-size: 15px; vertical-align: middle; border-radius: 11px; padding: 2px 4px;'><font style=\"color: #FFFFFF\">Adimistrador Lider!</font></span>";
}else 
if ($status[3]=='F'){
return  "<span style='background: #FF6347; color: white; box-shadow: 1px 1px 1px brown; font-size: 15px; vertical-align: middle; border-radius: 11px; padding: 2px 4px;'><font style=\"color: #FFFFFF\">Adimistradora Lider!'</font></span>";
}
}else if($status[0]==4 && $status[7]==0){
if ($status[3]=='M'){
return "<span style='background: #1E90FF; color: white; box-shadow: 1px 1px 1px brown; font-size: 15px; vertical-align: middle; border-radius: 11px; padding: 2px 4px;'><font style=\"color: #FFFFFF\">Programador</font></span>";
}else if ($status[3]=='F'){
return "<span style='background: #1E90FF; color: white; box-shadow: 1px 1px 1px brown; font-size: 15px; vertical-align: middle; border-radius: 11px; padding: 2px 4px;'><font style=\"color: #FFFFFF\">Programadora</font></span>";
}
}else if($status[5]==1){
if ($status[3]=='M'){
return "<span style='background: #BFEFFF; color: white; box-shadow: 1px 1px 1px brown; font-size: 15px; vertical-align: middle; border-radius: 11px; padding: 2px 4px;'><font style=\"color: #FFFFFF\">Gato do site</font></span>";
}else if ($status[3]=='F'){
return "<span style='background: #BFEFFF; color: white; box-shadow: 1px 1px 1px brown; font-size: 15px; vertical-align: middle; border-radius: 11px; padding: 2px 4px;'><font style=\"color: #FFFFFF\">Gata do site</font></span>";
}
}else{
if($status[1]<10){
return "<span style='background: #00008B; color: white; box-shadow: 1px 1px 1px brown; font-size: 15px; vertical-align: middle; border-radius: 11px; padding: 2px 4px;'><font style=\"color: #FFFFFF\">Novato</font></span>";
}else if($status[1]<25){
return "<span style='background: #00008B; color: white; box-shadow: 1px 1px 1px brown; font-size: 15px; vertical-align: middle; border-radius: 11px; padding: 2px 4px;'><font style=\"color: #FFFFFF\">Visitante</font></span>";
}else if($status[1]<50){
return "<span style='background: #00008B; color: white; box-shadow: 1px 1px 1px brown; font-size: 15px; vertical-align: middle; border-radius: 11px; padding: 2px 4px;'><font style=\"color: #FFFFFF\">Visitante Prata</font></span>";
}else if($status[1]<75){
return "<span style='background: #00008B; color: white; box-shadow: 1px 1px 1px brown; font-size: 15px; vertical-align: middle; border-radius: 11px; padding: 2px 4px;'><font style=\"color: #FFFFFF\">Visitante Ouro</font></span>";
}else if($status[1]<250){
return "<span style='background: #00008B; color: white; box-shadow: 1px 1px 1px brown; font-size: 15px; vertical-align: middle; border-radius: 11px; padding: 2px 4px;'><font style=\"color: #FFFFFF\">Frequente</font></span>";
}else if($status[1]<500){
return "<span style='background: #00008B; color: white; box-shadow: 1px 1px 1px brown; font-size: 15px; vertical-align: middle; border-radius: 11px; padding: 2px 4px;'><font style=\"color: #FFFFFF\">Super membro</font></span>";
}else if($status[1]<750){
return "<span style='background: #00008B; color: white; box-shadow: 1px 1px 1px brown; font-size: 15px; vertical-align: middle; border-radius: 11px; padding: 2px 4px;'><font style=\"color: #FFFFFF\">Membro plugado</font></span>";
}else if($status[1]<1000){
return "<span style='background: #00008B; color: white; box-shadow: 1px 1px 1px brown; font-size: 15px; vertical-align: middle; border-radius: 11px; padding: 2px 4px;'><font style=\"color: #FFFFFF\">Membro Diamante</font></span>";
}else if($status[1]<1500){
return "<span style='background: #00008B; color: white; box-shadow: 1px 1px 1px brown; font-size: 15px; vertical-align: middle; border-radius: 11px; padding: 2px 4px;'><font style=\"color: #FFFFFF\">Membro Top User</font></span>";
}else if($status[1]<2000){
return "<span style='background: #00008B; color: white; box-shadow: 1px 1px 1px brown; font-size: 15px; vertical-align: middle; border-radius: 11px; padding: 2px 4px;'><font style=\"color: #FFFFFF\">FaNáticO</font></span>";
}else if($status[1]<2500){
return "<span style='background: #00008B; color: white; box-shadow: 1px 1px 1px brown; font-size: 15px; vertical-align: middle; border-radius: 11px; padding: 2px 4px;'><font style=\"color: #FFFFFF\">Membro Guerreiro</font></span>";
}else if($status[1]<3000){
return "<span style='background: #00008B; color: white; box-shadow: 1px 1px 1px brown; font-size: 15px; vertical-align: middle; border-radius: 11px; padding: 2px 4px;'><font style=\"color: #FFFFFF\">VeteRaNo</font></span>";
}else if($status[1]<4000){
return "<span style='background: #00008B; color: white; box-shadow: 1px 1px 1px brown; font-size: 15px; vertical-align: middle; border-radius: 11px; padding: 2px 4px;'><font style=\"color: #FFFFFF\">Membro eXpelleR</font></span>";
}else if($status[1]<5000){
return "<span style='background: #00008B; color: white; box-shadow: 1px 1px 1px brown; font-size: 15px; vertical-align: middle; border-radius: 11px; padding: 2px 4px;'><font style=\"color: #FFFFFF\">Membro MasteR</font></span>";
}else if($status[1]<10000){
return "<span style='background: #00008B; color: white; box-shadow: 1px 1px 1px brown; font-size: 15px; vertical-align: middle; border-radius: 11px; padding: 2px 4px;'><font style=\"color: #FFFFFF\">Membro ic0N</font></span>";
}else{
return "<span style='background: #00008B; color: white; box-shadow: 1px 1px 1px brown; font-size: 15px; vertical-align: middle; border-radius: 11px; padding: 2px 4px;'><font style=\"color: #FFFFFF\">Membro volcaNo</font></span>";
}
}
}
function gerarmes($meuid){
global $mistake;	
$banido = $mistake->prepare("SELECT CASE SUBSTR(nasc,6,2) WHEN 01 THEN 'Janeiro' WHEN 02 THEN 'Fevereiro' WHEN 03 THEN 'Março' WHEN 04 THEN 'Abril' WHEN 05 THEN 'Maio' WHEN 06 THEN 'Junho' WHEN 07 THEN 'Julho' WHEN 08 THEN 'Agosto' WHEN 09 THEN 'Setembro' WHEN 10 THEN 'Outubro' WHEN 11 THEN 'Novembro' ELSE 'Dezembro' END as status FROM w_usuarios WHERE id='$meuid'");
$banido->execute();
$banido = $banido->fetch();
return $banido[0];
}
function gerarip() {
$ip = '';
if (getenv('HTTP_CLIENT_IP'))
$ip = getenv('HTTP_CLIENT_IP');
else 
if(getenv('HTTP_X_FORWARDED_FOR'))
$ip = getenv('HTTP_X_FORWARDED_FOR');
else 
if(getenv('GEOIP_ADDR'))
$ip = getenv('GEOIP_ADDR');
else
if(getenv('HTTP_CF_CONNECTING_IP'))
$ip = getenv('HTTP_CF_CONNECTING_IP');
else
if(getenv('HTTP_X_FORWARDED'))
$ip = getenv('HTTP_X_FORWARDED');
else 
if(getenv('HTTP_FORWARDED_FOR'))
$ip = getenv('HTTP_FORWARDED_FOR');
else 
if(getenv('HTTP_FORWARDED'))
$ip = getenv('HTTP_FORWARDED');
else 
if(getenv('REMOTE_ADDR'))
$ip = getenv('REMOTE_ADDR');
else
$ip = 'UNKNOWN';
$ext = explode(",",$ip);
$ip = $ext[0];
return $ip;
}
function uchat($meuid){
global $mistake;	
$banido = $mistake->prepare("SELECT bchat,bchat1,bchat2,bchat3,bchat4 FROM w_usuarios WHERE id='$meuid'");
$banido->execute();
$banido = $banido->fetch();
if($banido[0]==1) {
return 1;
//chat
}else
if($banido[1]==2) {
return 2;
// pm
}else
if($banido[2]==3) {
return 3;
// forum
}else
if($banido[3]==4) {
return 4;
// mural
}else
if($banido[4]==5) {
return 5;
// nick
}else{
return 0;   
}
}
function mbm_ord($char,$encoding = 'UTF-8') {
if ($encoding === 'UCS-4BE') {
list(,$ord) = (strlen($char) === 4) ? @unpack('N',$char) : @unpack('n',$char);
return $ord;
}else{
return mbm_ord(mb_convert_encoding($char,'UCS-4BE',$encoding), 'UCS-4BE');
}
}
function mb_htmlentities($string,$hex = false,$encoding = 'UTF-8') {
return preg_replace_callback('/[\x{80}-\x{10FFFF}]/u', function ($match) use ($hex) {
return sprintf($hex ? '&#x%X;' : '&#%d;',mbm_ord($match[0]));
}, $string);
}
function ubloq($meuid,$id,$imginicio=null){
global $mistake;
$bloq = $mistake->prepare("SELECT COUNT(*) FROM w_ubloq WHERE (aid='$meuid' and uid='$id' or aid='$id' and uid='$meuid')");
$bloq->execute();
$bloq = $bloq->fetch();
if(perm($meuid)!=4 and $bloq[0]>0) { 
$bloq2 = $mistake->prepare("SELECT * FROM w_ubloq WHERE uid='$meuid' and aid='$id'"); 
$bloq2->execute();
$bo = $bloq2->rowCount();
if($bo>0){
?>
<div align="center"><br/>Você bloqueou <?php echo gerarnome($id);?>!<br/><br/>
<a href="/bd/perfilbd?id=<?php echo $id;?>&b=<?php echo $bo>0?'d':'b';?>"><?php echo $bo>0?'Desbloquear':'Bloquear';?> <?php echo gerarnome($id);?></a>
<?
}else{
?>
<div align="center"><br/><?php echo gerarnome($id);?> Te bloqueou!
<?    
}
?>
<br/><br/><?php echo $imginicio;?><a href="/home?">Página principal</a></div><br>
<?php 
rodape(); 
exit();
} 
}
function maiortempo(){
global $mistake;  
$tempom = time()-tempoativo();
$deloff = $mistake->exec("UPDATE w_usuarios SET onlf='desconectado',to1='0',onl='0',inativo='0' WHERE inativo < $tempom");
$maxmem = $mistake->prepare("SELECT maioron FROM w_geral WHERE id='1'");
$maxmem->execute();
$maxmem = $maxmem->fetch();
$tempo = time()-86400;
$result = $mistake->prepare("SELECT COUNT(*) FROM w_usuarios WHERE ativo > $tempo");
$result->execute();
$result = $result->fetch();
if($result[0]>$maxmem[0]){
$tnow = date("D d M Y - H:i:s");
$res = $mistake->exec("UPDATE w_geral set dataon='".$tnow."',maioron='".$result[0]."' WHERE id='1'");
}
$resultm = $mistake->prepare("SELECT COUNT(*) FROM w_usuarios WHERE tempoativo > $tempom");
$resultm->execute();
$resultm = $resultm->fetch();
$maxtoday = $mistake->prepare("SELECT maiorhoje FROM w_geral WHERE datahoje='".date("d m y")."' AND id='1'");
$maxtoday->execute();
$maxtoday = $maxtoday->fetch();
if($resultm[0]>$maxtoday[0]){
$mistake->exec("UPDATE w_geral SET maiorhoje='".$resultm[0]."',horahoje='".date("H:i:s")."',datahoje='".date("d m y")."' WHERE id='1'");
}    
}
function ativo($meuid,$acao){
global  $mistake;
$to1 =  $mistake->prepare("SELECT to1,ton,tempon,vs FROM w_usuarios WHERE id='$meuid'");
$to1->execute();
$to1 = $to1->fetch();
if($to1[3]==0){
if($to1[0]==true){
$tp = time()-$to1[0];
$mt = $tp + $to1[1];
### pontos por hora
$tpp = time()-$to1[0];
$mtt = $tpp + $to1[2];
###
$time = time();
$update =  $mistake->prepare("UPDATE w_usuarios SET ton = ?,onlf = ?,to1 = ?,ativo = ?,inativo = ?,tempon = ?,tempoativo = ? WHERE id = ?");
$update->execute(array($mt,$acao,$time,$time,$time,$mtt,$time,$meuid));
}
$tempon = floor($to1[2]/60);
if($tempon>59)
{ 
$pontos = pts($meuid) + 300;
$razao="Ficou 1 hora online!";
 $mistake->exec("UPDATE w_usuarios SET tempon='0', pt='".$pontos."', pontoon=pontoon+1 WHERE id='".$meuid."'");
$msg="<b>Olá, você permaneceu 1 hora online no site e ganhou:<br/> 300 pontos de perfil.</b>";

automsg($msg,1,$meuid);
$nav = explode(" ",$_SERVER['HTTP_USER_AGENT'] );
 $mistake->exec("INSERT INTO w_pontos (uid,aid,hr,rz,ip,nv,dt,pt) values('1','".$meuid."','".time()."','".$razao."','".gerarip()."','$nav[0]','1','300')");
}
}
}
function idade($strdate){
$dob = explode("-",$strdate);
if(count($dob)!=3){
return 0;
}
$y = $dob[0];
$m = $dob[1];
$d = $dob[2];
if(mb_strlen($y)!=4){
return 0;
}
if(mb_strlen($m)!=2){
return 0;
}
if(mb_strlen($d)!=2){
return 0;
}
$y += 0;
$m += 0;
$d += 0;
if($y==0) return 0;
$rage = date("Y") - $y;
if(date("m")<$m){
$rage-=1;
}else{
if((date("m")==$m)&&(date("d")<$d)){
$rage-=1;
}
}
return "$rage Anos";
}
function gerartempo($sec){
$num = $sec/86400;
$days = intval($num);
$num2 = ($num - $days)*24;
$hours = intval($num2);
$num3 = ($num2 - $hours)*60;
$mins = intval($num3);
$num4 = ($num3 - $mins)*60;
$secs = intval($num4);
$sdia=$days>1?'s':'';
$shora=$hours>1?'s':'';
$smin=$mins>1?'s':'';
$sseg=$secs>1?'s':'';
if(($days==0) and ($hours==0) and ($mins==0)){
return "<b>$secs</b> segundo$sseg";
}else
if(($days==0) and ($hours==0)){
return "<b>$mins</b> minuto$smin, <b>$secs</b> segundo$sseg";
}elseif(($days==0)){
return "<b>$hours</b> hora$shora, <b>$mins</b> minuto$smin, <b>$secs</b> segundo$sseg";
}else{
return "<b>$days</b> dia$sdia, <b>$hours</b> hora$shora, <b>$mins</b> minuto$smin, <b>$secs</b> segundo$sseg";
}
}
function contamigos($meuid, $tid){
global $mistake;	
$banido = $mistake->prepare("SELECT COUNT(*) FROM w_amigos WHERE (uid='".$meuid."' AND tid='".$tid."' AND ac='1') OR (uid='".$tid."' AND tid='".$meuid."' AND ac='1')");
$banido->execute();
$banido = $banido->fetch();
if($banido[0]>0){
return true;
}
return false;
}
function editamigos($meuid,$tid){
global $mistake;	
if($meuid==$tid){
return 3;
}
if (contamigos($meuid, $tid)){
return 2;
}
$banido = $mistake->prepare("SELECT COUNT(*) FROM w_amigos WHERE (uid='".$meuid."' AND tid='".$tid."') OR (uid='".$tid."' AND tid='".$meuid."') AND ac='0'");
$banido->execute();
$banido = $banido->fetch();
if($banido[0]>0){
return 1;
}
return 0;
}
function isspam($text,$meuid){
global $mistake;
$sfil = array();
$comando = $mistake->prepare("SELECT p FROM w_pbloq");
$comando->execute();
while($spam = $comando->fetch()){
$sfil[] = $spam[0];
}
$text = mb_strtolower($text);
for($i=0;$i<count($sfil);$i++){
$nosf = mb_substr_count($text,$sfil[$i]);
if($nosf>0 && !permdono($meuid)){
return true;
}
}
return false;
}
function visitante($meuid){
global $mistake;	
$banido = $mistake->prepare("SELECT visitante FROM w_usuarios WHERE id='$meuid'");
$banido->execute();
$banido = $banido->fetch();
return $banido[0];
}
function textot($text,$meuid,$on){
global $mistake;
$banido = $mistake->prepare("SELECT ocemo FROM w_usuarios WHERE id='$meuid'");
$banido->execute();
$banido = $banido->fetch();
if($banido[0]==0){
$smilies = $mistake->prepare("SELECT * FROM w_emocoes");
$smilies->execute();
while ($smilie = $smilies->fetch(PDO::FETCH_OBJ)){
$text = str_replace($smilie->cod,"<div class='tituloWrapper'><img src='/e/".$smilie->id.".".$smilie->ext."' class='smilies' oncontextmenu='return false' onselectstart='return false' ondragstart='return false'/><span class='titulo' style='font-size:10px'>".$smilie->cod."</span></div>",$text);
}
}
$text = preg_replace("/\[bingo\](.*?)\[\/bingo\]/i","<div style=\"width:35px;height:35px;background-color:#00FFFF;border:1px solid black;border-radius:50px;line-height: 35px;text-align: center;\">\\1</div>", $text);
$text = preg_replace("/\[bingowap](.*?)\[\/bingowap\]/is","<a href=\"/bingowap?a=menu\">$1</a>",$text);
$text = preg_replace("/\[chatbingo](.*?)\[\/chatbingo\]/is","<a href=\"/chatbingo?a=a\">$1</a>",$text);
$text = preg_replace("/\[cor=preto\](.*?)\[\/cor\]/i","<font color='black'>\\1</font>", $text);
$text = preg_replace("/\[cor=azul\](.*?)\[\/cor\]/i","<font color='blue'>\\1</font>", $text);
$text = preg_replace("/\[cor=vermelho\](.*?)\[\/cor\]/i","<font color='red'>\\1</font>", $text);
$text = preg_replace("/\[cor=amarelo\](.*?)\[\/cor\]/i","<font color='yellow'>\\1</font>", $text);
$text = preg_replace("/\[cor=verde\](.*?)\[\/cor\]/i","<font color='green'>\\1</font>", $text);
$text = preg_replace("/\[cor=limao\](.*?)\[\/cor\]/i","<font color='lime'>\\1</font>", $text);
$text = preg_replace("/\[cor=magenta\](.*?)\[\/cor\]/i","<font color='magenta'>\\1</font>", $text);
$text = preg_replace("/\[cor=marron\](.*?)\[\/cor\]/i","<font color='brown'>\\1</font>", $text);
$text = preg_replace("/\[cor=cinza\](.*?)\[\/cor\]/i","<font color='grey'>\\1</font>", $text);
$text = preg_replace("/\[cor=rosa\](.*?)\[\/cor\]/i","<font color='pink'>\\1</font>", $text);
$text = preg_replace("/\[cor=laranja\](.*?)\[\/cor\]/i","<font color='orange'>\\1</font>", $text);
$text = preg_replace("/\[cor=roxo\](.*?)\[\/cor\]/i","<font color='purple'>\\1</font>", $text);
$text = preg_replace("/\[cor=aqua\](.*?)\[\/cor\]/i","<font color='aqua'>\\1</font>", $text);
$text = preg_replace("/\[cor\=(.*?)\](.*?)\[\/cor\]/is","<font color=\"$1\">$2</font>",$text);
$text = preg_replace("/\[b\](.*?)\[\/b\]/i","<b>\\1</b>", $text);
$text = preg_replace("/\[i\](.*?)\[\/i\]/i","<i>\\1</i>", $text);
$text = preg_replace("/\[u\](.*?)\[\/u\]/i","<u>\\1</u>", $text);
$text = preg_replace("/\[big\](.*?)\[\/big\]/i","<big>\\1</big>", $text);
$text = preg_replace("/\[centro\](.*?)\[\/centro\]/i","<div style='text-align:center'>\\1</div>", $text);
$text = preg_replace("/\[esq\](.*?)\[\/esq\]/i","<div style='text-align:left'>\\1</div>", $text);
$text = preg_replace("/\[dir\](.*?)\[\/dir\]/i","<div style='text-align:right'>\\1</div>", $text);
$text = preg_replace("/\[direita\](.*?)\[\/direita\]/i","<marquee direction='right'>\\1</marquee>", $text);
$text = preg_replace("/\[subir\](.*?)\[\/subir\]/i","<marquee direction='up'>\\1</marquee>", $text);
$text = preg_replace("/\[piscar\](.*?)\[\/piscar\]/i","<blink>\\1</blink>", $text);
$text = preg_replace("/\[descer\](.*?)\[\/descer\]/i","<marquee direction='down'>\\1</marquee>", $text);
$text = preg_replace("/\[pular\](.*?)\[\/pular\]/i","<marquee direction='down'><marquee behavior='alternate'>\\1</marquee></marquee>", $text);
$text = preg_replace("/\[esquerda\](.*?)\[\/esquerda\]/i","<marquee direction='left'>\\1</marquee>", $text);
$text = preg_replace("/\[album\=(.*?)\](.*?)\[\/album\]/is","<a href=\"/galeria?a=album&id=$1\">$2</a>",$text);
$text = preg_replace("/\[bolinha](.*?)\[\/bolinha\]/is","<a href=\"/bolinha?\">$1</a>",$text);
$text = preg_replace("/\[pouc](.*?)\[\/pouc\]/is","<a href=\"/pouc?\">$1</a>",$text);
$text = preg_replace("/\[banco](.*?)\[\/banco\]/is","<a href=\"/banco?\">$1</a>",$text);
$text = preg_replace("/\[bbb](.*?)\[\/bbb\]/is","<a href=\"/bbb?\">$1</a>",$text);
$text = preg_replace("/\[calculadora](.*?)\[\/calculadora\]/is","<a href=\"/calculadora?\">$1</a>",$text);
$text = preg_replace("/\[futaovivo](.*?)\[\/futaovivo\]/is","<a href=\"/cb?a=aovivo\">$1</a>",$text);
$text = preg_replace("/\[loteria](.*?)\[\/loteria\]/is","<a href=\"/loteria?\">$1</a>",$text);
$text = preg_replace("/\[cassino](.*?)\[\/cassino\]/is","<a href=\"/cassino1?\">$1</a>",$text);
$text = preg_replace("/\[penaltis](.*?)\[\/penaltis\]/is","<a href=\"/penaltis?\">$1</a>",$text);
$text = preg_replace("/\[dado](.*?)\[\/dado\]/is","<a href=\"/dado?\">$1</a>",$text);
$text = preg_replace("/\[forca](.*?)\[\/forca\]/is","<a href=\"/forca?\">$1</a>",$text);
$text = preg_replace("/\[f1](.*?)\[\/f1\]/is","<a href=\"f1?\">$1</a>",$text);
$text = preg_replace("/\[friendzoo](.*?)\[\/friendzoo\]/is","<a href=\"/friendzoo?\">$1</a>",$text);
$text = preg_replace("/\[libertadores](.*?)\[\/libertadores\]/is","<a href=\"/libertadores?\">$1</a>",$text);
$text = preg_replace("/\[loja](.*?)\[\/loja\]/is","<a href=\"/lojas?\">$1</a>",$text);
$text = preg_replace("/\[meutime](.*?)\[\/meutime\]/is","<a href=\"/entretenimento/apptime\">$1</a>",$text);
$text = preg_replace("/\[noticias](.*?)\[\/noticias\]/is","<a href=\"/noticias?\">$1</a>",$text);
$text = preg_replace("/\[novelas](.*?)\[\/novelas\]/is","<a href=\"/novelas?\">$1</a>",$text);
$text = preg_replace("/\[ppt](.*?)\[\/ppt\]/is","<a href=\"/ppt?\">$1</a>",$text);
$text = preg_replace("/\[cavalos](.*?)\[\/cavalos\]/is","<a href=\"/cdc?\">$1</a>",$text);
$text = preg_replace("/\[fazenda](.*?)\[\/fazenda\]/is","<a href=\"/fazenda?\">$1</a>",$text);
$text = preg_replace("/\[quiz](.*?)\[\/quiz\]/is","<a href=\"/entretenimento/quiz\">$1</a>",$text);
$text = preg_replace("/\[wapet](.*?)\[\/wapet\]/is","<a href=\"/wapet?\">$1</a>",$text);
$text = preg_replace("/\[enquete\=(.*?)\](.*?)\[\/enquete\]/is","<a href=\"/enquete/ver/$1\">$2</a>",$text);
$text = preg_replace("/\[cm\=(.*?)\](.*?)\[\/cm\]/is","<a href=\"/comunidades/cmn/$1\">$2</a>",$text);
$text = preg_replace("/\[topico\=(.*?)\](.*?)\[\/topico\]/is","<a href=\"/forum/topico/$1\">$2</a>",$text);
$text = preg_replace("/\[paginas\=(.*?)\](.*?)\[\/paginas\]/is","<a href=\"/paginas.php?a=comentarios&id=$1\">$2</a>",$text);
$text = preg_replace("/\[imagem\=((.*?)(.jpg|jpeg|png|gif|bmp))\]/i"," <img src=\"http://\\1\"/>", $text);
$text = preg_replace("/\[imagem\=(.*?)\]/i","<br/><img alt='foto' src=\"$1\";\"/><br/>",$text);
$text = preg_replace("/\[image\=(.*?)\]/i","<a href=\"$1\" target='_blank'/><img src=\"$1\" alt=\"\"/  height=\"91\" width=\"110\"></a>",$text);
$text = preg_replace("/\[img\=(.*?)\]/i","<br/><img alt='foto' src=\"$1\" style='width:90px;height:90px;' pbsrc=\"$1\" class='PopBoxImageSmall' title='Clique para ampliar/diminuir' onclick=\"Pop(this,50,'PopBoxPopImage');\"/><br/>",$text);
$text = preg_replace("/\[link\=(.*?)\](.*?)\[\/link\]/is","<a href=\"$1\">$2</a>",$text);
$text = preg_replace("/\[boteco\=(.*?)\](.*?)\[\/boteco\]/is","<a href=\"/boteco?a=du3&id=$1\">$2</a>",$text);
$text = preg_replace("/\[aposta\=(.*?)\](.*?)\[\/aposta\]/is","<a href=\"/apostas?a=jogo&jid=$1\">$2</a>",$text);
$text = preg_replace("/\[emoji\=(.*?)\]/i","<span style='background-image: url(//socialcrazy.net/emojis/$1.png);height:32px;width:32px;display:inline-block'></span>",$text);
$text = preg_replace("/\[pergunte\=(.*?)\](.*?)\[\/pergunte\]/is","<a href=\"/pergunte_me?a=perguntas&id=$1\">$2</a>",$text);
$text = preg_replace("/\#([ABCDEFGHIJKLMNOPQRSTUVWXYZabcÐ“Â§defghijklmnopqrstuvwxyzÁÉÍÓÚáéíóúÂÊÔâêôÀàÜüÇçÑñÃÕãõ0123456789_-]+)/is","<a href='/mural/hashtag/$1'><b><font color='#20B2AA'><big>#$1</big></font></b></a>",$text );
$text = preg_replace("/\@([-ABCDEFGHIJKLMNOPQRSTUVWXYZabcÐ“Â§defghijklmnopqrstuvwxyzÁÉÍÓÚáéíóúÂÊÔâêôÀàÜüÇçÑñÃÕãõ0123456789_ ]+)/is","<a href='/$1'><b><font color='red'><big>@$1</big></font></b></a>",$text );
$text = preg_replace("/\[gif\=(.*?)\]/i","<img src='//media.tenor.com/images/$1/tenor.gif' class='smilies'>",$text);
$text = str_ireplace("[br/]","<br />",$text);
$text = str_ireplace("[br2/]","<br /><br />",$text);
$text = preg_replace_callback("/\[chamada\=(.*?)\](.*?)\[\/chamada\]/is",function($matches) {
return "<a href='".str_replace('%','#',$matches[1])."' data-turbolinks='false'>".$matches[2]."</a>";},$text);
return minhaurl($text);
}
function anti_injection($texto){
$texto = htmlspecialchars($texto);
return $texto;
}
function minhaurl($text){
//$meutexto = "/(https?:\/\/(?:www\.|(?!www))[^\s\.]+\.[^\s]{2,}|www\.[^\s]+\.[^\s]{2,})/";
//preg_match_all($meutexto,$text,$matches);
preg_match_all("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$text,$matches);
foreach($matches[0] as $partes){  
if(strripos($partes,'.jpg') == true || strripos($partes,'.png') == true || strripos($partes,'.jpeg') == true || strripos($partes,'.webp') == true){
$text = str_replace($partes,"<br /><img alt='foto' src='".$partes."' style='width:90px;height:90px;' pbsrc='".$partes."' class='PopBoxImageSmall' title='Clique para ampliar/diminuir' onclick=\"Pop(this,50,'PopBoxPopImage');\"/><br />",$text);
}else{
if(strripos($partes,'/nandotracks/') == true || strripos($partes,'/vkmusic/') == true || strripos($partes,'/mp3-tut.net/') == true || strripos($partes,'.mp3') == true || strripos($partes,'.m4a') == true || strripos($partes,'.ogg') == true){
$text = str_replace($partes,"<br /><audio controls controlslist='nodownload' src='".$partes."'></audio><br />",$text);
}else{
if(strripos($partes,'ouvir?audio=') == true || strripos($partes,'ouvir?video=') == true){
$text = str_replace($partes,"<br /><a href='javascript:void(0)' onclick=\"window.open ('".$partes."','pagina','width=550, height=521, top=100, left=110, scrollbars=no');\"><span style='background-image: url(//socialcrazy.net/emojis/1f3b8.png);height:32px;width:32px;display:inline-block'></span>Clique para ouvir</a><br />",$text);
}else{
if(strripos($partes,'.mp4') == true || strripos($partes,'.webm') == true){
$text = str_replace($partes,"<br /><video controls width='200' height='165' src='".$partes."'></video><br />",$text);
}else{
if(strripos($partes,'.gif') == true){
$text = str_replace($partes, '<br /><img src="'.$partes.'" class="smilies"><br/>',$text); 
}else{
if($_SERVER['PHP_SELF']!="/chat.php"){
if(strripos($partes,'/channel/') == false AND strripos($partes,'youtube.com') == true || strripos($partes,'youtu.be') == true){ 	
$text = str_replace($partes, "<br /><iframe width='200' height='165' src='https://www.youtube.com/embed/".mb_substr($partes,-11)."?&amp;autoplay='0' showinfo='0' frameborder='0' allowfullscreen='allowfullscreen'></iframe><br />",$text);
}}else{
$text = str_replace($partes, '<br /><a href="'.$partes.'" target="_blank"><font color="green">'.str_ireplace('http://','',str_ireplace('https://','',$partes)).'</font></a><br />',$text);
}   
}
}
}
}
}
}
return $text;            
}
function automsg($msg,$meuid,$pr,$cor='#000000'){
global  $mistake;   
$res =  $mistake->prepare("INSERT INTO w_msgs (txt,por,pr,hr,dl,cor) VALUES (?,?,?,?,?,?)");
$arrayName = array($msg,$meuid,$pr,time(),1,$cor);
$ii = 0;
for($i=1; $i <=6; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
}
function validaemail($email){
$mail_correcto = 0;
if ((strlen($email) >= 6) && (substr_count($email,"@") == 1) && (substr($email,0,1) != "@") && (substr($email,strlen($email)-1,1) != "@")){
if ((!strstr($email,"'")) && (!strstr($email,"\"")) && (!strstr($email,"\\")) && (!strstr($email,"\$")) && (!strstr($email," "))) {
if (substr_count($email,".")>= 1){
$term_dom = substr(strrchr ($email, '.'),1);
if (strlen($term_dom)>1 && strlen($term_dom)<5 && (!strstr($term_dom,"@")) ){
$antes_dom = substr($email,0,strlen($email) - strlen($term_dom) - 1);
$caracter_ult = substr($antes_dom,strlen($antes_dom)-1,1);
if ($caracter_ult != "@" && $caracter_ult != "."){
$mail_correcto = 1;
}
}
}
}
}
if ($mail_correcto)
return true;
else
return false;
}
function open_url($url,$timeout = 100){
$cookie_dir = "".$_SERVER["DOCUMENT_ROOT"]."/downsm/tmp";
if(!is_dir($cookie_dir)) {
@mkdir($cookie_dir, 0777, true);
}
//$cookie = tempnam($cookie_dir, "CURLCOOKIE");
$ch = curl_init();
if(strripos($url,'api.vk.com') == true){
curl_setopt($ch, CURLOPT_USERAGENT, "KateMobileAndroid / 50-500 (Android 5.0; SDK 20; arm64; Xiaomi Mi5; ru)"); 
}else{
curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
}
curl_setopt( $ch, CURLOPT_URL,$url);
//curl_setopt( $ch, CURLOPT_COOKIEJAR, $cookie);
//curl_setopt( $ch, CURLOPT_FOLLOWLOCATION,true);
curl_setopt( $ch, CURLOPT_ENCODING,"");
curl_setopt( $ch, CURLOPT_RETURNTRANSFER,true);
curl_setopt( $ch, CURLOPT_AUTOREFERER,true);
curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER,false);
curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT,$timeout);
curl_setopt( $ch, CURLOPT_TIMEOUT,$timeout);
curl_setopt( $ch, CURLOPT_MAXREDIRS,10);
$content = curl_exec ($ch);
$resposta = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$erros = array("401", "402", "403", "404", "405", "406", "407", "408", "409", "410", "411", "412", "413", "414", "415", "500", "501", "502", "503", "504", "505");
curl_close($ch);
if(in_array($resposta,$erros)) {
return "Erro $resposta: Ouve um erro no servidor";
}else{ 
return $content;
}
}
function open_ip($ip) {
$ip = isset($ip) ? $ip : gerarip();
$url = 'http://ip-api.com/json/'.$ip;
$response = open_url($url);
$ip_info = json_decode($response);
?>
<style>
table {border-collapse: collapse;max-width: 100%;}thead {background: #ccc url(https://www.devfuria.com.br/html-css/tabelas/bar.gif) repeat-x left center;border-top: 1px solid #a5a5a5;border-bottom: 1px solid #a5a5a5;}th {font-weight: bold;text-align: left;}th, td {padding: 0.1em 1em;}
</style>
<table align="center">
<thead>
<tr>
<th>Pais</th>
<th>Estado</th>
</tr>
</thead>
<tbody>
<tr>
<td><?php echo $ip_info->country;?></td>
<td><?php echo $ip_info->regionName;?></td>
</tr>
</tbody>
<thead>
<tr>
<th>Cidade</th>
<th>Operadora</th>
</tr>
</thead>
<tr>
<td><?php echo $ip_info->city;?></td>
<td><?php echo $ip_info->isp;?></td>
</tr>     
</tbody>
</table>
<?
}
function sendMessage($uid,$libert,$url,$noti){
global $mistake;	
$unome = $mistake->prepare("SELECT nm FROM w_usuarios WHERE id='$uid'"); 
$unome->execute();
$unome = $unome->fetch();
$info = $mistake->prepare("SELECT * FROM w_geral where id='1'");
$info->execute();
$info = $info->fetch();
$setu = "".html_entity_decode($unome[0])."";
$content = array("en" => ''.$noti.' '.$setu.'');
$fields = array('app_id' => "".$info['api']."",'include_player_ids' => array("$libert"),'data' => array("foo" => "bar"),'url' => "".$url."",'contents' => $content);
$fields = json_encode($fields);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8','Authorization: Basic '.$info['one'].''));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS,$fields);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
$response = curl_exec($ch);
$resposta = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$erros = array("401","402","403","404","405","406","407","408","409","410","411","412","413","414","415","500","501","502","503","504","505");
curl_close($ch);
if(in_array($resposta,$erros)) {
return "Erro $resposta: Ouve um erro no servidor";
}else{ 
return $response;
}
}
function confirJS($id = "", $texto, $link)
{
	?>
	<script>
	function <?php echo $id; ?>() {
    var txt;
    var r = confirm("<?php echo $texto; ?>");
    if (r == true) {
		window.location.href = "<?php echo $link; ?>";
        txt = "";
    } else {
		window.location.pathname;
        txt = "";
    }
    document.getElementById("status").innerHTML = txt;
}
</script>
<?php
}
function sendMessageAll($uid,$url,$noti){
global $mistake;	
$unome = $mistake->prepare("SELECT nm FROM w_usuarios WHERE id='$uid'"); 
$unome->execute();
$unome = $unome->fetch();
$info = $mistake->prepare("SELECT * FROM w_geral where id='1'");
$info->execute();
$info = $info->fetch();
$setu = "".html_entity_decode($unome[0])."";
$content = array("en" => ''.$noti.' '.$setu.'');
$fields = array('app_id' => "".$info['api']."",'included_segments' => array('All'),'data' => array("foo" => "bar"),'url' => "".$url."",'contents' => $content);
$fields = json_encode($fields);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8','Authorization: Basic '.$info['one'].''));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS,$fields);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
$response = curl_exec($ch);
$resposta = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$erros = array("401","402","403","404","405","406","407","408","409","410","411","412","413","414","415","500","501","502","503","504","505");
curl_close($ch);
if(in_array($resposta,$erros)) {
return "Erro $resposta: Ouve um erro no servidor";
}else{ 
return $response;
}
}
function s2d($s){
$c = $s / 86400;
if(strstr($c,".")){
$e = explode(".",$c);
$p1 = $e[0];
$p2 = $e[1];
if($p1=="0"){
$ret = "".$p1.".".$p2[0]."";
return $ret;
}else{
return $p1;
}
}else{
return $c;
}
}
function s2h($s){
$c = $s / 3600;
if(strstr($c,".")){
$e = explode(".",$c);
$p1 = $e[0];
$p2 = $e[1];
if($p1=="0"){
$ret = "".$p1.".".$p2[0]."";
return $ret;
}else{
return $p1;
}
}else{
return $c;
}
}
function s2m($s){
$c = $s / 60;
if(strstr($c,".")){
$e = explode(".",$c);
$p1 = $e[0];
$p2 = $e[1];
if($p1=="0"){
$ret = "".$p1.".".$p2[0]."";
return $ret;
}else{
return $p1;
}
}else{
return $c;
}
}
function timepm($time){
$timenow = time();
$c = $timenow - $time;
$type = "";
if($c<0) return false;
if($c>0 && $c<60){
$type = "seg";
$res = $c;
return array($res,$type);
}
if($c>59 && $c<3600){
$type = "min";
$res = s2m($c);
return array($res,$type);
}
if($c>3599 && $c<86400){
$res = s2h($c);
if($res>1){
$type = "horas";
}else{
$type = "hora";
}
return array($res,$type);
}
if($c>86399){
$res = s2d($c);
if($res>1){
$type = "dias";
}else{
$type = "dia";
}
return array($res,$type);
}
}
function gosteimural($mistaid,$hora,$a,$meuid){
global $mistake;    
$testearray = include("".$_SERVER["DOCUMENT_ROOT"]."/novoarray.php");
$comentario = $mistake->prepare("SELECT COUNT(*) FROM w_comentarios WHERE idrec='".$mistaid."'");
$comentario->execute();
$comentario = $comentario->fetch();
$gostou = $mistake->prepare("SELECT COUNT(id) FROM w_comentarios_logs WHERE idrecado='".$mistaid."' AND carinha='1'");
$gostou->execute();
$gostou = $gostou->fetch();
$naogostou = $mistake->prepare("SELECT COUNT(id) FROM w_comentarios_logs WHERE idrecado='".$mistaid."' AND carinha='2'");
$naogostou->execute();
$naogostou = $naogostou->fetch();
$haha = $mistake->prepare("SELECT COUNT(id) FROM w_comentarios_logs WHERE idrecado='".$mistaid."' AND carinha='3'");
$haha->execute();
$haha = $haha->fetch();
$uau = $mistake->prepare("SELECT COUNT(id) FROM w_comentarios_logs WHERE idrecado='".$mistaid."' AND carinha='4'");
$uau->execute();
$uau = $uau->fetch();
$triste = $mistake->prepare("SELECT COUNT(id) FROM w_comentarios_logs WHERE idrecado='".$mistaid."' AND carinha='5'");
$triste->execute();
$triste = $triste->fetch();
$grr = $mistake->prepare("SELECT COUNT(id) FROM w_comentarios_logs WHERE idrecado='".$mistaid."' AND carinha='6'");
$grr->execute();
$grr = $grr->fetch();
$rec = $mistake->prepare("SELECT * FROM w_mural WHERE id='".$mistaid."'");
$rec->execute();
$rec = $rec->fetch();
$tempo2 = timepm($hora);
$tempo = "".$tempo2[0]."&nbsp;".$tempo2[1]."";
if($testearray[66]==1){
?> 
<hr>
<small>
<? if($a=='pensamentos'){
?>
<a href='/mural/comentarios/<?php echo $mistaid; ?>'><i class='ion-ios-chatbubble' style='font-size:20px;font-weight: bold;'></i>&nbsp;Comentários(<?php echo $comentario[0]; ?>)</a>
<?
}
if($rec['drec']==$meuid OR perm($meuid)>0) { 
?>
<br /><a href='/mural/editar/<?php echo $mistaid; ?>'>[&nbsp;E&nbsp;]</a>&nbsp;-&nbsp;<a href='/mural/excluir/<?php echo $mistaid; ?>'>[&nbsp;X&nbsp;]</a>
<?
}
if($rec['para']==$meuid OR perm($meuid)>0 and $a=='historicochatmural') { 
?>
<?
}
?>
<div align="right"><i class="ion-ios-alarm" style="font-size:18px;font-weight: bold;"></i>&nbsp;há <?php echo "$tempo atr&aacute;s";?></div>
</small>
<?
}
if($testearray[66]==2){
?> 
<hr>
<div style='text-align:center'>
<?php if($gostou[0]>0) { ?> <a href="/mural/curtiu/<?php echo $mistaid; ?>"><img src='/images/reacoes/curtir.png' alt='Curtir' title='Curtir' width='20px' height='20px' />&nbsp;<?php echo $gostou[0];?></a> &nbsp;<?php } ?> 
<?php if($naogostou[0]>0) { ?> <a href="/mural/curtiu/<?php echo $mistaid; ?>"><img src='/images/reacoes/amei.png' alt='Amei' title='Amei' width='20px' height='20px' /><?php echo $naogostou[0];?></a> &nbsp;<?php } ?> 
<?php if($haha[0]>0) { ?> <a href="/mural/curtiu/<?php echo $mistaid; ?>"><img src='/images/reacoes/haha.png' alt='Haha' title='Haha' width='20px' height='20px' />&nbsp;<?php echo $haha[0];?></a> &nbsp;<?php } ?> 
<?php if($uau[0]>0) { ?> <a href="/mural/curtiu/<?php echo $mistaid; ?>"><img src='/images/reacoes/uau.png' alt='Uau' title='Uau' width='20px' height='20px' />&nbsp;<?php echo $uau[0];?></a> &nbsp;<?php } ?> 
<?php if($triste[0]>0) { ?> <a href="/mural/curtiu/<?php echo $mistaid; ?>"><img src='/images/reacoes/triste.png' alt='Triste' title='Triste' width='20px' height='20px' />&nbsp;<?php echo $triste[0];?></a> &nbsp;<?php } ?> 
<?php if($grr[0]>0) { ?> <a href="/mural/curtiu/<?php echo $mistaid; ?>"><img src='/images/reacoes/grr.png' alt='Grr' title='Grr' width='20px' height='20px' />&nbsp;<?php echo $grr[0];?></a> <?php } ?>
<hr>
<?php echo $rec['drec']==$meuid ? "<a href='/mural/curtiu/".$mistaid."'>" : "<a href='/home/curtir/".$mistaid."/1'>" ?><img src='/images/reacoes/curtir.png' alt='Curtir' title='Curtir' width='20px' height='20px' /></a>&nbsp;
<?php echo $rec['drec']==$meuid ? "<a href='/mural/curtiu/".$mistaid."'>" : "<a href='/home/curtir/".$mistaid."/2'>" ?><img src='/images/reacoes/amei.png' alt='Amei' title='Amei' width='20px' height='20px' /></a>&nbsp;
<?php echo $rec['drec']==$meuid ? "<a href='/mural/curtiu/".$mistaid."'>" : "<a href='/home/curtir/".$mistaid."/3'>" ?><img src='/images/reacoes/haha.png' alt='Haha' title='Haha' width='20px' height='20px' /></a>&nbsp;
<?php echo $rec['drec']==$meuid ? "<a href='/mural/curtiu/".$mistaid."'>" : "<a href='/home/curtir/".$mistaid."/4'>" ?><img src='/images/reacoes/uau.png' alt='Uau' title='Uau' width='20px' height='20px' /></a>&nbsp;
<?php echo $rec['drec']==$meuid ? "<a href='/mural/curtiu/".$mistaid."'>" : "<a href='/home/curtir/".$mistaid."/5'>" ?><img src='/images/reacoes/triste.png' alt='Triste' title='Triste' width='20px' height='20px' /></a>&nbsp;
<?php echo $rec['drec']==$meuid ? "<a href='/mural/curtiu/".$mistaid."'>" : "<a href='/home/curtir/".$mistaid."/6'>" ?><img src='/images/reacoes/grr.png' alt='Grr' title='Grr' width='20px' height='20px' /></a>
</div>
<small>
<? if($a=='pensamentos'){
?>
<a href='/mural/comentarios/<?php echo $mistaid; ?>'><i class='ion-ios-chatbubble' style='font-size:20px;font-weight: bold;'></i>&nbsp;Comentários(<?php echo $comentario[0]; ?>)</a>
<?
}
if($rec['drec']==$meuid OR perm($meuid)>0) { 
?>
<br /><a href='/mural/editar/<?php echo $mistaid; ?>'>[&nbsp;E&nbsp;]</a>&nbsp;-&nbsp;<a href='/mural/excluir/<?php echo $mistaid; ?>'>[&nbsp;X&nbsp;]</a>
<?
}
if($rec['para']==$meuid OR perm($meuid)>0 and $a=='historicochatmural') { 
?>
&nbsp;-&nbsp;<a href='/mural/responder/<?php echo $mistaid; ?>'>[&nbsp;R&nbsp;]</a>
<?
}
?>
<div align="right"><i class="ion-ios-alarm" style="font-size:18px;font-weight: bold;"></i>&nbsp;há <?php echo "$tempo atr&aacute;s";?></div>
</small>
<?
}
if($testearray[66]==3){
if($rec['drec']==$meuid OR perm($meuid)>0) {  
$equi = "<a href='/mural/excluir/$mistaid'><button><img src='/style/deletar.png' width='18px' height='18px'/></button></a>";
}else{
$equi = "";
}
if($rec['drec']==$meuid OR perm($meuid)>0) { 
$tesm = "<a href='/mural/editar/$mistaid'><button><img src='/style/editar1.png' width='18px' height='18px'/></button></a>$equi";
}else{
$tesm = "";    
}
?> 
<div style='text-align:center'>
<?php if($gostou[0]>0) { ?> <a href="/mural/curtiu/<?php echo $mistaid; ?>"><img src='/images/reacoes/curtir.png' alt='Curtir' title='Curtir' width='20px' height='20px' /><?php echo $gostou[0];?></a> <?php } ?> 
<?php if($naogostou[0]>0) { ?> <a href="/mural/curtiu/<?php echo $mistaid; ?>"><img src='/images/reacoes/amei.png' alt='Amei' title='Amei' width='20px' height='20px' /><?php echo $naogostou[0];?></a> <?php } ?> 
<?php if($haha[0]>0) { ?> <a href="/mural/curtiu/<?php echo $mistaid; ?>"><img src='/images/reacoes/haha.png' alt='Haha' title='Haha' width='20px' height='20px' /><?php echo $haha[0];?></a> <?php } ?> 
<?php if($uau[0]>0) { ?> <a href="/mural/curtiu/<?php echo $mistaid; ?>"><img src='/images/reacoes/uau.png' alt='Uau' title='Uau' width='20px' height='20px' /><?php echo $uau[0];?></a> <?php } ?> 
<?php if($triste[0]>0) { ?> <a href="/mural/curtiu/<?php echo $mistaid; ?>"><img src='/images/reacoes/triste.png' alt='Triste' title='Triste' width='20px' height='20px' /><?php echo $triste[0];?></a> <?php } ?> 
<?php if($grr[0]>0) { ?> <a href="/mural/curtiu/<?php echo $mistaid; ?>"><img src='/images/reacoes/grr.png' alt='Grr' title='Grr' width='20px' height='20px' /><?php echo $grr[0];?></a> <?php } ?>
</div><hr><button><div class='dropdown'><img src='/images/reacoes/curtir.png' alt='Curtir' title='Curtir' width='18px' height='18px' />
<div class='dropdown-content'><div style='float:left;width:33%'>
<?php echo $rec['drec']==$meuid ? "<a href='/mural/curtiu/".$mistaid."'>" : "<a href='/home/curtir/".$mistaid."/1'>" ?><img src='/images/reacoes/curtir.png' alt='Curtir' title='Curtir' width='20px' height='20px' class='mistakehover'></a>
<?php echo $rec['drec']==$meuid ? "<a href='/mural/curtiu/".$mistaid."'>" : "<a href='/home/curtir/".$mistaid."/2'>" ?><img src='/images/reacoes/amei.png' alt='Amei' title='Amei' width='20px' height='20px' class='mistakehover'></a></div>
<div style='float:left;width:33%'>
<?php echo $rec['drec']==$meuid ? "<a href='/mural/curtiu/".$mistaid."'>" : "<a href='/home/curtir/".$mistaid."/3'>" ?><img src='/images/reacoes/haha.png' alt='Haha' title='Haha' width='20px' height='20px' class='mistakehover'></a>
<?php echo $rec['drec']==$meuid ? "<a href='/mural/curtiu/".$mistaid."'>" : "<a href='/home/curtir/".$mistaid."/4'>" ?><img src='/images/reacoes/uau.png' alt='Uau' title='Uau' width='20px' height='20px' class='mistakehover'></a></div>
<div style='float:left;width:33%'>
<?php echo $rec['drec']==$meuid ? "<a href='/mural/curtiu/".$mistaid."'>" : "<a href='/home/curtir/".$mistaid."/5'>" ?><img src='/images/reacoes/triste.png' alt='Triste' title='Triste' width='20px' height='20px' class='mistakehover'></a> 
<?php echo $rec['drec']==$meuid ? "<a href='/mural/curtiu/".$mistaid."'>" : "<a href='/home/curtir/".$mistaid."/6'>" ?><img src='/images/reacoes/grr.png' alt='Grr' title='Grr'  width='20px' height='20px'class='mistakehover'></a></div>
</div></div></button><?php echo $tesm; ?><? if($rec['para']==$meuid OR perm($meuid)>0 and $a=='historicochatmural'){?><a href='/mural/responder/<?php echo $mistaid; ?>'><button><img src='/style/res.png' width='18px' height='18px'/></button></a><a href="/mural/<?php echo $a;?>"><button><img src='/style/plus3.png' width='18px' height='18px'></button></a><?}if($a!='historicochatmural'){?><br><a href="/mural/comentarios/<?php echo $mistaid; ?>" ><i class='ion-ios-chatbubble' style='font-size:20px;font-weight: bold;'></i>&nbsp;Comentários(<?php echo $comentario[0]; ?>)</a><?}?>
<div align="right"><small><i class="ion-ios-alarm" style="font-size:18px;font-weight: bold;"></i>&nbsp;há <?php echo "$tempo atr&aacute;s";?></small></div>
<?    
}
}
function tradutor($text,$sl,$tl){
$text = str_replace(" ", "%20",preg_replace('/<.*?>/', '',str_replace('#','',$text)));
open_url($host);
$texto = open_url("https://translate.google.com/m?hl=pt-BR&sl=$sl&tl=$tl&ie=UTF-8&prev=_m&q=$text");
$texto = explode("<br><div dir=\"ltr\" class=\"t0\">", $texto);
$texto = explode("</div><", $texto[1]);
return $texto[0];
}
function gerarlogin($meuid){
global $mistake;
$testearray = include("".$_SERVER["DOCUMENT_ROOT"]."/novoarray.php");
$id = $mistake->prepare("SELECT lg FROM w_usuarios WHERE id=:id");
$id->execute(array(":id" => "".$meuid.""));
$id = $id->fetch();
if($testearray[69]==1 or $_SESSION['on']==true) return $id[0];
return false;
}
function gerarnome2($meuid){
global $mistake;
$id = $mistake->prepare("SELECT nm FROM w_usuarios WHERE id=:id");
$id->execute(array(":id" => "".$meuid.""));
$id = $id->fetch();
return $id[0];
}
function paginas($url,$a,$numpag,$id,$pag,$limite=null){
$limite = isset($limite) ? '/'.$limite.'' : ''; 
echo"<div class='wrappaginacaoml'><hr><div class='paginacaoml'>";
if(1 != $pag){
echo "<a class='prev page-numbers' href='/".$url."/".$a."/".$id."/1".$limite."'>&#10150; 1</a>";
}else{
echo "<span class='page-numbers current'>&#10150; 1</span>";
}
for($i = $pag - 2; $i <= $pag - 1; $i++){
if($i <=0){
}else {
echo "<a class='page-numbers' href='/".$url."/".$a."/".$id."/".$i."".$limite."'>".$i."</a>";
}
}
for($i = $pag + 1; $i <= $pag + 2; $i++){
if($i > $numpag){
}else{
echo "<a class='page-numbers' href='/".$url."/".$a."/".$id."/".$i."".$limite."'>".$i."</a>";
}
}
if($numpag != $pag){
echo "<a class='next page-numbers' href='/".$url."/".$a."/".$id."/".$numpag."".$limite."'>&#10150; $numpag</a>";
}else{
echo "<span class='page-numbers current'>&#10150; $numpag</span>";
}
echo"</div></div>";
}
function isdigitf($word){
if(preg_match("/[^\w ]/u",$word)){
return true;
}else{
return false;
}
}
function visitas(){
global $mistake;
if(empty($_SESSION['visita_'.gerarip().'']) && $_COOKIE['visita']==true){
$tempo = time() - tempoativovisitas();
$res = $mistake->prepare("DELETE FROM mmistake_online WHERE tempo < $tempo");
$res->execute();    
$_SESSION['visita_'.gerarip().''] = 'visita_'.gerarip().'';  
$on = $mistake->prepare("SELECT COUNT(*) FROM mmistake_online WHERE ip='".gerarip()."'");
$on->execute();
$on = $on->fetch();
if($on[0]==0){
$res = $mistake->prepare("INSERT INTO mmistake_online (ip,navegador,tempo) VALUES (?,?,?)");
$arrayName = array(gerarip(),$_SERVER['HTTP_USER_AGENT'],time());
$ii = 0;
for($i=1; $i <=3; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
}
}
}
function editandopostagem($meuid,$texto){
global $mistake;
$res = $mistake->prepare("INSERT INTO w_ltpc (a,txt) VALUES (?,?)");
$arrayName = array($meuid,$texto);
$ii = 0;
for($i=1; $i <=2; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
}
function gerador_password($tamanho){
$chars = "abcdefghijklmnopqrstuvxz!@$*()_+=-0123456789";
$exemplo_s = str_shuffle($chars);
$retorno = mb_substr($exemplo_s, 1,$tamanho);
return $retorno;
}
?>