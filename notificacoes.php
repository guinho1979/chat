<?php
require_once("".$_SERVER["DOCUMENT_ROOT"]."/funcoes.php");
require_once("".$_SERVER["DOCUMENT_ROOT"]."/mistake.php");
seg($meuid);
ativo($meuid,'Ativando notificaçoes ');
?>
<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async></script>
<script>
var OneSignal = window.OneSignal || [];
OneSignal.push(["init", {
appId: "<?php echo $testearray[38];?>",
subdomainName: "<?php nome_site();?>",
autoRegister: true,
welcomeNotification: {
title: "<?php nome_site();?>",
message: "Olá <?php echo gerarnome2($meuid);?> Notificações ativadas com sucesso!"
},
promptOptions: {
actionMessage: "Olá <?php echo gerarnome2($meuid);?> Deseja ativar Notificações?.",
acceptButtonText: "ACEITAR",
cancelButtonText: "NÃO OBRIGADO"
}
}]);
OneSignal.push(["init", {
safari_web_id: "web.onesignal.auto.65a2ca34-f112-4f9d-a5c6-253c0b61cb9f"
}]);
OneSignal.push(function() {
OneSignal.getUserId(function(userId) {
document.cookie="userId="+userId+";domain=."+window.location.hostname.replace("www.","")+";path=/;";
});
});
function subscribe() {
OneSignal.push(["registerForPushNotifications"]);
event.preventDefault();
}
function unsubscribe(){
OneSignal.setSubscription(true);
}
var OneSignal = OneSignal || [];
OneSignal.push(function() {
OneSignal.on('subscriptionChange', function (isSubscribed) {
console.log("O estado da assinatura do usuário é agora:", isSubscribed);
OneSignal.sendTag("user_id","<?php echo $meuid;?>", function(tagsSent){
console.log("As tags acabaram de enviar!");
});
});
var isPushSupported = OneSignal.isPushNotificationsSupported();
if (isPushSupported){
OneSignal.isPushNotificationsEnabled().then(function(isEnabled){
if (isEnabled){
console.log("As notificações push são ativadas!");
document.getElementById("inscrito").style.display = '';
}else{
OneSignal.showHttpPrompt();
console.log("As notificações de envio ainda não estão ativadas.");
}
});
}else{
console.log("As notificações push não são suportadas.");
}
});
</script>
<br/><div id="titulo"><b>Notificações</b></div><br/><br><p align="center">Ative as notificações em seu navegador e seja informado sempre que receber um novo torpedo ou comentario de recados quando não estiver online.<br><br>Para continuar, primeiro clique no botão "ACEITAR", seu navegador deverá solicitar permissão, basta clicar em "PERMITIR". Após fazer isto, clique em "Atualizar Status" e confirme se as notificações realmente foram ativadas em navegador.<br><br>
<text id="inscrito" style="display: none;"><b>STATUS: ATIVO NESTE NAVEGADOR!</b></text>
<br><br><b><a href="/notificacoes?a=<?php echo time();?>">Atualizar Status</a></b><br><br><b><a href="/notificacoes?a=ativar">Ativar seu id</a></b><br><br><b><a href="/notificacoes?a=desativar">Desativar Status</a></b><br><br><p align="center">As notificações são compatíveis com os navegadores <b>Google Chrome</b>,<b>Safari</b> e <b>Mozilla Firefox.</b><br>
<?
if($a=='ativar' && $_COOKIE['userId']==true){
$res = $mistake->exec("UPDATE w_usuarios SET userId='".$_COOKIE["userId"]."' WHERE id='".$meuid."'");    
}else
if($a=='desativar'){
$res = $mistake->exec("UPDATE w_usuarios SET userId=null WHERE id='".$meuid."'");
}
?>
<br/>
<div align="center">
<a href="home?"><?php echo $imginicio;?>Página principal</a><br><br>
<?php echo rodape();?>
</body>
</html>