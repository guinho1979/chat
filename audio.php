<?php
require_once("".$_SERVER["DOCUMENT_ROOT"]."/funcoes.php");
require_once("".$_SERVER["DOCUMENT_ROOT"]."/mistake.php");
seg($meuid);
?>
<br/><div id="titulo"><b>Adicionar musica</b></div><br/>
<?
ativo($meuid,'Adicionando musica');
$google_client_id = '868388745973-ea9inpe8gmtvrd7vubb653tc1ue53flk.apps.googleusercontent.com';
$google_client_secret = 'BGIcrsG6peMdQNPjEEZckPM1';
$google_redirect_url = 'https://'.$_SERVER["HTTP_HOST"].'/audio';
require_once 'Google/autoload.php';
require_once 'Google/src/Google/Service/drive.php';
$client = new Google_Client();
$client->setClientId($google_client_id);
$client->setClientSecret($google_client_secret);
$client->setRedirectUri($google_redirect_url);
$client->setScopes(array('https://www.googleapis.com/auth/drive.file'));
$client->setAccessType('offline');
if (isset($_GET['code']) || (isset($_SESSION['access_token']) && $_SESSION['access_token'])) {
if (isset($_GET['code'])) {
$client->authenticate($_GET['code']);
$_SESSION['access_token'] = $client->getAccessToken();
}
if (!empty($_POST['des']) and isset($_SESSION['access_token'])) {
$arquivo = isset($_FILES["arquivo"]) ? $_FILES["arquivo"] : FALSE;
$_UP['extensoes'] = array('mp3','m4a','mp4');
$extensao = substr(strrchr($_FILES['arquivo']['name'],'.'),1);
if (array_search($extensao, $_UP['extensoes']) === false) {
echo "Extenção inválida!";
}else{
$client->setAccessToken($_SESSION['access_token']);
$service = new Google_Service_Drive($client);
$file = new Google_Service_Drive_DriveFile();
$data = file_get_contents($arquivo["tmp_name"]);
$file->setName('By-AnDeRsOn-'.uniqid().'.'.$extensao.'');
$file->setDescription('upload no drive '.$_SERVER["HTTP_HOST"].'');
$file->setMimeType(''.$_FILES["arquivo"]["type"].'');
$createdFile = $service->files->create($file,array('data' => $data,'mimeType' => ''.$_FILES["arquivo"]["type"].'','uploadType' => 'multipart'));
$url = 'https://docs.google.com/uc?id='.$createdFile['id'];	
$newPermission = new Google_Service_Drive_Permission();
$newPermission->setType('anyone');
$newPermission->setRole('writer');
try {
$service->permissions->create($createdFile['id'],$newPermission);
} 
catch (Exception $e) {
print "ocorreu um erro: " . $e->getMessage();
}
$res =  $mistake->prepare("INSERT INTO w_downs (dn,dt,nm,tmh,cmt,ct,tp,uple) VALUES (?,?,?,?,?,?,?,?)");
$arrayName = array($meuid,time(),$_POST['des'],$url,$_POST['des'],1,'mp3',1);
$ii = 0;
for($i=1; $i <=8; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute();
$sql =  $mistake->prepare("UPDATE w_usuarios SET music=:music WHERE id=:id");
$sql->bindParam(":music",$url);
$sql->bindParam(":id",$meuid);
$sql->execute();
?>
Sucesso adicionado em seu drive do google!<br><br>
<?php 
}
}
} else {
$authUrl = $client->createAuthUrl();
header('Location: ' . $authUrl);
exit();
}
?>
<form action="/audio" method="post" enctype="multipart/form-data">
Arquivo:<br/><input type="file" name="arquivo"><br/>
Nome:<br/><input type="text" name="des"><br/>
<input type="submit" value="Adicionar"></form>
<br/><div align="center"><a href="/"><?php echo $imginicio;?>Página principal</a><br><br>
<?php echo rodape();?>
</body>
</html>