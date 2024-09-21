<?php
require_once("".$_SERVER["DOCUMENT_ROOT"]."/funcoes.php");
require_once("".$_SERVER["DOCUMENT_ROOT"]."/mistake.php");
seg($meuid);
ativo($meuid,'Jogo da velha');    
$id = isset($_GET["id"]) ? $_GET["id"] : $meuid;   
$x = "<img src='/images/x.jpg' alt='X'>";
$o = "<img src='/images/o.jpg' alt='0'>";              
echo "<div id='titulo'>Jogo da velha</div><br />";
$apagar = time() - 600;
$mistake->exec("DELETE FROM tictactoe WHERE lturntime<'".$apagar."'");
if(moedas($meuid)<3){
echo'<div align="center">';
echo "Voce precisa ter no minimo 3 moedas para jogar!";
echo "<br /><br /><a href='/jogovelha'>";
echo "&#187;voltar</a></div><br />";
rodape();
exit();
}
if($a=="convite"){
echo'<div align="center">';
if(online($id) && moedas($id)>5){
$mistake->exec("INSERT INTO tictactoe SET player1='".$meuid."',player2='".$id."',turn='2',lturntime='".time()."', accepted='0'");
$resok = $mistake->lastInsertId();
$msg="olá ".gerarnome2($id)." vamos jogar jogo da velha.[br/]Para aceitar o desafio clique [link=/jogovelha/aceitar/$resok]Aqui[/link] se voce nao quer aceitar basta ignorar esta mensagem.[br/]O convite expira em 10 minutos.";
automsg($msg,$meuid,$id);
$flag=1;
}else{
$flag=0;
}
if($flag){
echo "Seu convite para jogar no jogo da velha foi enviado com sucesso para ".gerarnome($id).". Por favor, aguarde ate a pessoa que voce enviou o jogo aceite o convite. Voce sera notificado quando o convite ele(a) aceitar. Seu convite ira expirar em 10 minutos!";
}else{
echo "Seu convite para jogar jogo da velha com ".gerarnome($id)." nao foi enviado, verifique se este usuario esta ativo no site e possui mais que 5 moedas!";
}
echo'</div>';
}else 
if($a=="aceitar"){
echo'<div align="center">';	
$verificar = $mistake->prepare("SELECT accepted FROM tictactoe WHERE id='".$id."'");
$verificar->execute();
$verificar = $verificar->fetch();
$quer = $mistake->exec("UPDATE tictactoe SET accepted='1' WHERE id='".$id."'");
$sql = $mistake->prepare("SELECT * FROM tictactoe WHERE id='".$id."'");
$sql->execute();
$sql = $sql->fetch();
$msg="Olá ".gerarnome2($sql[1])." aceitei seu convite para jogo da velha.[br/]Clique [link=/jogovelha/game/$id]Aqui[/link] para jogar.!";
if($verificar[0]=="0"){
automsg($msg,$meuid,$sql[1]);
$shtxt = "Um novo confronto entre <a href='".gerarlogin($sql[1])."'>".gerarnome2($sql[1])."</a> e <a href='".gerarlogin($sql[2])."'>".gerarnome2($sql[2])."</a> no jogo da velha esta em andamento<br /><a href='/jogovelha/watch/$id'>Clique Aqui</a> para assitir";
$res = $mistake->prepare("INSERT INTO anderson_mural (rec,drec,hora,tipo) VALUES (?,?,?,?)");
$arrayName = array($shtxt,$meuid,time(),1);
$ii = 0;
for($i=1; $i <=4; $i++){
$res->bindValue($i,$arrayName[$ii]);
$ii++;
} 
$res->execute(); 
}
("Invitation");
echo "Voce aceitou com sucesso o convite do jogo da velha! Clique <a href='/jogovelha/game/$id'><b>aqui</b></a> para comecar o jogo!</div>";
}else 
if ($a=="tutorial"){
echo'<div align="center">';	
echo "No jogo da velha voce pode jogar com todos os membros que estao ativos nos ultimos 10 minutos! Va no perfil do usuario com quem voce quer jogar em clique em duelar > jogo da velha o mesmo recebera um torpedo automatico com o convite do jogo, ele tera ate 10 minutos para aceitar ou nao o convite. Apos 10 minutos o convite sera expirado. Se o usuario aceitar voce recebera um torpedo informando, o usuario que voce convidou vai jogar com o numero zero (0), e voce que convidou com a letra X.Clique na opcao <b>atualizar</b> frequentemente para ver se seu desafiante ja jogou a vez dele, assim que seu desafiante jogar voce podera jogar denovo escolhendo sua opcao e clicando em <b>jogar</b>. O jogo podera ser terminado por inatividade, se houver um vencedor ou empate, os jogadores serao notificados por um torpedo automatico, o vencedor ganhara 3 moedas e o perdedor perder 3 moedas em seu perfil.
Se algum jogador nao jogar o jogo por um periodo de mais de 10 minutos, o jogo sera expirado automaticamente. Durante o jogo voce pode navegar por outros lugares do site e podera voltar ao jogo pelo torpedo automatico do desafio do jogo, mais este tempo nao pode passar de 10 minutos para o jogo nao expirar!";
echo "<br /><br /><a href='/jogovelha'>";
echo "&#187;voltar</a></div><br />";
}else 
if ($a=="ativo"){
echo'<div align="center">';
$query = $mistake->prepare("SELECT id,player1,player2 FROM tictactoe WHERE 1=1");
$query->execute();
if($query->rowCount()==0){
echo "Nenhum jogo esta atualmente em andamento!";
echo "<br /><br /><a href='/jogovelha'>";
echo "&#187;voltar</a><br /><br />";
}else{
echo "<br /><br />Os seguintes jogos estao em andamento:<br />";
while($data=$query->fetch()){
echo "<a href='/jogovelha/watch/$data[0]'>".gerarnome($data[1])." X ".gerarnome($data[2])."</a><br />";
}
}
echo'</div>';
}else 
if ($a=="estatistica"){
$query = $mistake->prepare("SELECT COUNT(*) FROM tttstats");
$query->execute();
$contemo = $query->fetch();
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contemo[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($contemo[0]>0){
$query = $mistake->query("SELECT * FROM tttstats ORDER BY id desc LIMIT $limit, $itensporpag");
$i=0;
while($data=$query->fetch()){
?>
<div id="<?php echo $i%2==0?'div1':'div2';?>"><small>
<?
if($data['result']>0){
echo "Vitória de <a href='/".gerarlogin($data['player1'])."'>".gerarnome($data['player1'])."</a> sobre <a href='/".gerarlogin($data['player2'])."'>".gerarnome($data['player2'])."</a><br />".date('d-m-Y H:i:s',$data['time'])."";
}else{
echo "<a href='/".gerarlogin($data['player1'])."'>".gerarnome($data['player1'])."</a> empatou com <a href='/".gerarlogin($data['player2'])."'>".gerarnome($data['player2'])."</a><br />".date('d-m-Y H:i:s',$data['time'])."";
}
echo '</small></div>';
$i++;
}
if($numpag>1) {
paginas('jogovelha',$a,$numpag,$id,$pag);    
} 
}
}else 
if($a=="watch"){
echo'<div align="center">';
$players = $mistake->prepare("SELECT player1, player2 FROM tictactoe WHERE id='".$id."'");
$players->execute();
$players = $players->fetch();
if(!$players){
echo "Este jogo terminou!";
echo "<br /><br /><a href='/jogovelha'>";
echo "&#187;voltar</a><br />";
rodape();
exit();
}
$move = $_POST["move"];
$mover1 = $_POST["mover1"];
$sql = $mistake->prepare("SELECT * FROM tictactoe WHERE id='".$id."'");
$sql->execute();
$sql = $sql->fetch();
$winner=0;
if($sql[6]==$sql[7] AND $sql[7]==$sql[8]){
$winner=$sql[6];
}else 
if($sql[9]==$sql[10] AND $sql[10]==$sql[11]){
$winner=$sql[9];
}else 
if($sql[12]==$sql[13] AND $sql[13]==$sql[14]){
$winner=$sql[12];
}else 
if($sql[6]==$sql[9] AND $sql[9]==$sql[12]){
$winner=$sql[6];
}else 
if($sql[7]==$sql[10] AND $sql[10]==$sql[13]){
$winner=$sql[7];
}else 
if($sql[8]==$sql[11] AND $sql[11]==$sql[14]){
$winner=$sql[8];
}else 
if($sql[6]==$sql[10] AND $sql[10]==$sql[14]){
$winner=$sql[6];
}else 
if($sql[8]==$sql[10] AND $sql[10]==$sql[12]){
$winner=$sql[8];
}else 
if(($sql[6]>0) AND ($sql[7]>0) AND ($sql[8]>0) AND ($sql[9]>0) AND ($sql[10]>0) AND ($sql[11]>0) AND ($sql[12]>0) AND ($sql[13]>0) AND ($sql[14]>0)){
echo "Este jogo terminou!";
echo "<br /><br /><a href='/jogovelha'>";
echo "&#187;voltar</a><br /><br />";
rodape();
exit();
}
if ($winner){
if($winner==1){
$looser=2;
}else 
if($winner==2){
$looser=1;
}
echo "Este jogo terminou!";
echo "<br /><br /><a href='/jogovelha'>";
echo "&#187;voltar</a><br /><br />";
rodape();
exit();
}
$pls1="<b>".gerarnome($players[0])."</b>:". $x;
$pls2="<b>".gerarnome($players[1])."</b>:". $o;
$quer = $mistake->prepare("SELECT turn FROM tictactoe WHERE id='".$id."'");
$quer->execute();
$quer = $quer->fetch();
$player="player".$quer[0];
$quer1 = $mistake->prepare("SELECT $player FROM tictactoe WHERE id='".$id."'");
$quer1->execute();
$quer1 = $quer1->fetch();
?>
 <script>
 $(document).ready(function(){
 $("#div_refresh").load(" #div_refresh");
 setInterval(function() {
 $("#div_refresh").load(" #div_refresh");
 }, 3500);
 });
 </script>
 

 <div id="div_refresh">
     <?
echo "<b>".gerarnome($quer1[0]).": Sua vez!</b><br /><br />";
echo $pls1."<br />".$pls2;
echo "<br /><br /><a href='/jogovelha/watch/$id'>".$imgatualizar." A pagina atualizar automatica</a><br /><br />";
echo "<table border='1' cellpadding='2' cellspacing='3'><tr><td width='20' height='20'>";
if($sql[6]==1){
echo $x;
}else 
if($sql[6]==2){
echo $o;
}
echo "</td>";
echo "<td width='20' height='20'>";
if($sql[7]==1){
echo $x;
}else 
if($sql[7]==2){
echo $o;
}
echo "</td>";
echo "<td width='20' height='20'>";
if($sql[8]==1){
echo $x;
}else 
if($sql[8]==2){
echo $o;
}
echo "</td></tr>";
echo "<tr><td width='20' height='20'>";
if($sql[9]==1){
echo $x;
}else 
if($sql[9]==2){
echo $o;
}
echo "</td>";
echo "<td width='20' height='20'>";
if($sql[10]==1){
echo $x;
}else 
if($sql[10]==2){
echo $o;
}
echo "</td>";
echo "<td width='20' height='20'>";
if($sql[11]==1){
echo $x;
}else 
if($sql[11]==2){
echo $o;
}
echo "</td></tr>";
echo "<tr><td width='20' height='20'>";
if($sql[12]==1){
echo $x;
}else 
if($sql[12]==2){
echo $o;
}
echo "</td>";
echo "<td width='20' height='20'>";
if($sql[13]==1){
echo $x;
}else 
if($sql[13]==2){
echo $o;
}
echo "</td>";
echo "<td width='20' height='20'>";
if($sql[14]==1){
echo $x;
}else 
if($sql[14]==2){
echo $o;
}
echo "</td></tr></table>";
echo '</div></div>';
}else 
if ($a=="game"){
echo'<div align="center">';
$players = $mistake->prepare("SELECT player1, player2 FROM tictactoe WHERE id='".$id."'");
$players->execute();
$players = $players->fetch();
if($players[0]!=$meuid AND $players[1]!=$meuid){
echo "Este jogo terminou!";
echo "<br /><br /><a href='/jogovelha'>";
echo "&#187;voltar</a><br /><br />";
rodape();
exit();
}
$move = $_POST["move"];
$mover1 = $_POST["mover1"];
$sql = $mistake->prepare("SELECT turn FROM tictactoe WHERE id='".$id."'");
$sql->execute();
$sql = $sql->fetch();
$mover=$sql[0];
$move = $move;
$field="square".$move;
if($move>0){
$blah = $mistake->prepare("SELECT $field FROM tictactoe WHERE id='".$id."'");
$blah->execute();
$blah = $blah->fetch();
if($mover1==$mover){
if($blah[0]==0){
if($mover==1){
$mover2=2;
}else 
$mover2=1;
$time=time();
$mistake->exec("UPDATE tictactoe SET $field='".$mover."',turn='".$mover2."',lturntime='".$time."' WHERE id='".$id."'");
}else{
echo "Este jogo ja acabou, clique <a href='/jogovelha/game/$id'>aqui</a> para ver o resultado do jogo!<br /><br />";
rodape();
exit();
}
}else{
echo "Nao e sua vez!!! Clique <a href='/jogovelha/game/$id'>aqui</a> para voltar ao jogo e fique clicando em <b>atualizar</b> ate ser sua vez!<br /><br />";
rodape();
exit();
}
}
$sql = $mistake->prepare("SELECT * FROM tictactoe WHERE id='".$id."'");
$sql->execute();
$sql = $sql->fetch();
$winner=0;
if($sql[6]==$sql[7] AND $sql[7]==$sql[8]){
$winner=$sql[6];
}else 
if($sql[9]==$sql[10] AND $sql[10]==$sql[11]){
$winner=$sql[9];
}else 
if($sql[12]==$sql[13] AND $sql[13]==$sql[14]){
$winner=$sql[12];
}else 
if($sql[6]==$sql[9] AND $sql[9]==$sql[12]){
$winner=$sql[6];
}else 
if($sql[7]==$sql[10] AND $sql[10]==$sql[13]){
$winner=$sql[7];
}else 
if($sql[8]==$sql[11] AND $sql[11]==$sql[14]){
$winner=$sql[8];
}else 
if($sql[6]==$sql[10] AND $sql[10]==$sql[14]){
$winner=$sql[6];
}else 
if($sql[8]==$sql[10] AND $sql[10]==$sql[12]){
$winner=$sql[8];
}else 
if(($sql[6]>0) AND ($sql[7]>0) AND ($sql[8]>0) AND ($sql[9]>0) AND ($sql[10]>0) AND ($sql[11]>0) AND ($sql[12]>0) AND ($sql[13]>0) AND ($sql[14]>0)){
echo "Este jogo terminou empatado! Ninguem ganhou ou perdeu pontos!";
$fim = $mistake->prepare("SELECT fim FROM tictactoe WHERE id='".$id."'");
$fim->execute();
$fim = $fim->fetch();
if($fim[0]=="1"){
}else{
if($meuid==$sql[1]){
$stat = $mistake->exec("INSERT INTO tttstats SET player1='".$sql[1]."',player2='".$sql[2]."',result='0',time='".time()."'");
$mistake->exec("UPDATE tictactoe SET fim='1' WHERE id='".$id."'");
}
}
echo "<br /><br /><a href='/jogovelha'>";
echo "&#187;voltar</a><br /><br />";
rodape();
exit();
}
if ($winner){
if($winner==1){
$looser=2;
}else 
if($winner==2){
$looser=1;
}
$blah="player".$winner;
$quer1 = $mistake->prepare("SELECT $blah FROM tictactoe WHERE id='".$id."'");
$quer1->execute();
$quer1 = $quer1->fetch();
$winnick=gerarnome($quer1[0]);
$blah="player".$looser;
$quer2 = $mistake->prepare("SELECT $blah FROM tictactoe WHERE id='".$id."'");
$quer2->execute();
$quer2 = $quer2->fetch();
$loosenick=gerarnome($quer2[0]);
echo "$winnick ganhou o jogo, Parabens! 30 moedas foram adicionado ao perfil de $winnick.<br />";
echo "Que pena  $loosenick, perdeu o jogo, 30 moedas serao reduzidos no seu perfil.";
$fim = $mistake->prepare("SELECT fim FROM tictactoe WHERE id='".$id."'");
$fim->execute();
$fim = $fim->fetch();
if($fim[0]=="1"){
}else{
if($meuid==$quer1[0]){
$blah = $mistake->exec("UPDATE w_usuarios SET moedas=moedas+30 WHERE id='".$quer1[0]."'");
$blah = $mistake->exec("UPDATE w_usuarios SET moedas=moedas-30 WHERE id='".$quer2[0]."'");
$stat = $mistake->exec("INSERT INTO tttstats SET player1='".$quer1[0]."',player2='".$quer2[0]."',result='1',time='".time()."'");
$mistake->exec("UPDATE tictactoe SET fim='1' WHERE id='".$id."'");
}
}
echo "<br /><br /><a href='/jogovelha'>";
echo "&#187;voltar</a><br /><br />";
rodape();
exit();
}
$pls1="<b>".gerarnome($players[0])."</b>:". $x;
$pls2="<b>".gerarnome($players[1])."</b>:". $o;
$quer = $mistake->prepare("SELECT turn FROM tictactoe WHERE id='".$id."'");
$quer->execute();
$quer = $quer->fetch();
$player="player".$quer[0];
$player = $player;
$quer1 = $mistake->prepare("SELECT $player FROM tictactoe WHERE id='".$id."'");
$quer1->execute();
$quer1 = $quer1->fetch();
?>
 <script>
 $(document).ready(function(){
 $("#div_refresh").load(" #div_refresh");
 setInterval(function() {
 $("#div_refresh").load(" #div_refresh");
 }, 3500);
 });
 </script>
 

 <div id="div_refresh">
     <?
echo "<b>".gerarnome($quer1[0]).": Sua vez!</b><br /><br />";
echo $pls1."<br />".$pls2;
echo "<br /><br /><a href='/jogovelha/game2/$id'>".$imgatualizar." A pagina atualizar automatica</a><br /><br />";
echo "<form action='/jogovelha/game/$id' method='post'><table border='1' cellpadding='2' cellspacing='3'><tr><td width='20' height='20'>";
if($sql[6]==1){
echo $x;
}else 
if($sql[6]==2){
echo $o;
}else{
echo "<input type='radio' name='move' value='1'>";
}
echo "</td>";
echo "<td width='20' height='20'>";
if($sql[7]==1){
echo $x;
}else 
if($sql[7]==2){
echo $o;
}else{
echo "<input type='radio' name='move' value='2'>";
}
echo "</td>";
echo "<td width='20' height='20'>";
if($sql[8]==1){
echo $x;
}else 
if($sql[8]==2){
echo $o;
}else{
echo "<input type='radio' name='move' value='3'>";
}
echo "</td></tr>";
echo "<tr><td width='20' height='20'>";
if($sql[9]==1){
echo $x;
}else 
if($sql[9]==2){
echo $o;
}else{
echo "<input type='radio' name='move' value='4'>";
}echo "</td>";
echo "<td width='20' height='20'>";
if($sql[10]==1){
echo $x;
}
else if($sql[10]==2){
echo $o;
}else{
echo "<input type='radio' name='move' value='5'>";
}
echo "</td>";
echo "<td width='20' height='20'>";
if($sql[11]==1){
echo $x;
}else 
if($sql[11]==2){
echo $o;
}else{
echo "<input type='radio' name='move' value='6'>";
}
echo "</td></tr>";
echo "<tr><td width='20' height='20'>";
if($sql[12]==1){
echo $x;
}else 
if($sql[12]==2){
echo $o;
}else{
echo "<input type='radio' name='move' value='7'>";
}echo "</td>";
echo "<td width='20' height='20'>";
if($sql[13]==1){
echo $x;
}else 
if($sql[13]==2){
echo $o;
}else{
echo "<input type='radio' name='move' value='8'>";
}echo "</td>";
echo "<td width='20' height='20'>";
if($sql[14]==1){
echo $x;
}else 
if($sql[14]==2){
echo $o;
}else{
echo "<input type='radio' name='move' value='9'>";
}echo "</td></tr></table>";
if($sql[1]==$meuid){
$mover1=1;
}else{
$mover1=2;
}
echo "<input type='hidden' name='mover1' value='$mover1'><input type='submit' name='submit' class='bt3' value='Jogar'>";
echo "</form></div></div>";
}else 
if ($a=="game2"){
echo'<div align="center">';
$players = $mistake->prepare("SELECT player1, player2 FROM tictactoe WHERE id='".$id."'");
$players->execute();
$players = $players->fetch();
if($players[0]!=$meuid AND $players[1]!=$meuid){
echo "Este jogo terminou!";
echo "<br /><br /><a href='/jogovelha'>";
echo "&#187;voltar</a><br /><br />";
rodape();
exit();
}
$move = $_POST["move"];
$mover1 = $_POST["mover1"];
$sql = $mistake->prepare("SELECT turn FROM tictactoe WHERE id='".$id."'");
$sql->execute();
$sql = $sql->fetch();
$mover=$sql[0];
$field="square".$move;
if($move>0){
$blah = $mistake->prepare("SELECT $field FROM tictactoe WHERE id='".$id."'");
$blah->execute();
$blah = $blah->fetch();
if($mover1==$mover){
if($blah[0]==0){
if($mover==1){
$mover2=2;
}else 
$mover2=1;
$time=time();
$mistake->exec("UPDATE tictactoe SET $field='".$mover."',turn='".$mover2."',lturntime='".$time."' WHERE id='".$id."'");
}else{
echo "Este jogo ja acabou, clique <a href='/jogovelha/game/$id'>aqui</a> para ver o resultado do jogo!<br /><br />";
rodape();
exit();
}
}else{
echo "Nao e sua vez!!! Clique <a href='/jogovelha/game/$id'>aqui</a> e volte para o jogo e fique clicando em <b>atualizar</b> ate ser sua vez!<br /><br />";
echo "";
rodape();
exit();
}
}
$sql = $mistake->prepare("SELECT * FROM tictactoe WHERE id='".$id."'");
$sql->execute();
$sql = $sql->fetch();
$winner=0;
if($sql[6]==$sql[7] AND $sql[7]==$sql[8]){
$winner=$sql[6];
}else 
if($sql[9]==$sql[10] AND $sql[10]==$sql[11]){
$winner=$sql[9];
}else 
if($sql[12]==$sql[13] AND $sql[13]==$sql[14]){
$winner=$sql[12];
}else 
if($sql[6]==$sql[9] AND $sql[9]==$sql[12]){
$winner=$sql[6];
}else 
if($sql[7]==$sql[10] AND $sql[10]==$sql[13]){
$winner=$sql[7];
}else 
if($sql[8]==$sql[11] AND $sql[11]==$sql[14]){
$winner=$sql[8];
}else 
if($sql[6]==$sql[10] AND $sql[10]==$sql[14]){
$winner=$sql[6];
}else 
if($sql[8]==$sql[10] AND $sql[10]==$sql[12]){
$winner=$sql[8];
}else 
if(($sql[6]>0) AND ($sql[7]>0) AND ($sql[8]>0) AND ($sql[9]>0) AND ($sql[10]>0) AND ($sql[11]>0) AND ($sql[12]>0) AND ($sql[13]>0) AND ($sql[14]>0)){
echo "Este jogo terminou empatado! Ninguem ganhou ou perdeu moedas.<br />";
$fim = $mistake->prepare("SELECT fim FROM tictactoe WHERE id='".$id."'");
$fim->execute();
$fim = $fim->fetch();
if($fim[0]=="1"){
}else{
if($meuid==$sql[1]){
$stat = $mistake->exec("INSERT INTO tttstats SET player1='".$sql[1]."',player2='".$sql[2]."',result='0',time='".time()."'");
$mistake->exec("UPDATE tictactoe SET fim='1' WHERE id='".$id."'");
}
}
echo "<br /><br /><a href='/jogovelha'>";
echo "&#187;voltar</a><br /><br />";
rodape();
exit();
}
if ($winner){
if($winner==1){
$looser=2;
}else 
if($winner==2){
$looser=1;
}
$blah="player".$winner;
$blah = $blah;
$quer1 = $mistake->prepare("SELECT $blah FROM tictactoe WHERE id='".$id."'");
$quer1->execute();
$quer1 = $quer1->fetch();
$winnick=gerarnome($quer1[0]);
$blah="player".$looser;
$blah = $blah;
$quer2 = $mistake->prepare("SELECT $blah FROM tictactoe WHERE id='".$id."'");
$quer2->execute();
$quer2 = $quer2->fetch();
$loosenick=gerarnome($quer2[0]);
echo "$winnick ganhou o jogo, Parabens! 30 moedas foram adicionado ao seu perfil.<br />";
echo "Que pena  $loosenick, perdeu o jogo, 30 moedas serao reduzidos no seu perfil.";
$fim = $mistake->prepare("SELECT fim FROM tictactoe WHERE id='".$id."'");
$fim->execute();
$fim = $fim->fetch();
if($fim[0]=="1"){
}else{
if($meuid==$quer1[0]){
$blah = $mistake->exec("UPDATE w_usuarios SET moedas=moedas+30 WHERE id='".$quer1[0]."'");
$blah = $mistake->exec("UPDATE w_usuarios SET moedas=moedas-30 WHERE id='".$quer2[0]."'");
$stat = $mistake->exec("INSERT INTO tttstats SET player1='".$quer1[0]."',player2='".$quer2[0]."',result='1',time='".time()."'");
$mistake->exec("UPDATE tictactoe SET fim='1' WHERE id='".$id."'");
}
}
echo "<br /><br /><a href='/jogovelha'>";
echo "&#187;voltar</a><br /><br />";
rodape();
exit();
}
$pls1="<b>".gerarnome($players[0])."</b>:". $x;
$pls2="<b>".gerarnome($players[1])."</b>:". $o;
$quer = $mistake->prepare("SELECT turn FROM tictactoe WHERE id='".$id."'");
$quer->execute();
$quer = $quer->fetch();
$player="player".$quer[0];
$player = $player;
$quer1 = $mistake->prepare("SELECT $player FROM tictactoe WHERE id='".$id."'");
$quer1->execute();
$quer1 = $quer1->fetch();
echo "<b>".gerarnome($quer1[0]).": Sua vez!</b><br /><br />";
echo $pls1."<br />".$pls2;
echo "<br /><br /><a href='/jogovelha/game/$id'>".$imgatualizar." Atualizar</a><br /><br />";
echo "<form action='/jogovelha/game/$id' method='post'><table border='1' cellpadding='2' cellspacing='3'><tr><td width='20' height='20'>";
if($sql[6]==1){
echo $x;
}else 
if($sql[6]==2){
echo $o;
}else{
echo "<input type='radio' name='move' value='1'>";
}
echo "</td>";
echo "<td width='20' height='20'>";
if($sql[7]==1){
echo $x;
}else 
if($sql[7]==2){
echo $o;
}else{
echo "<input type='radio' name='move' value='2'>";
}
echo "</td>";
echo "<td width='20' height='20'>";
if($sql[8]==1){
echo $x;
}else if($sql[8]==2){
echo $o;
}else{
echo "<input type='radio' name='move' value='3'>";
}
echo "</td></tr>";
echo "<tr><td width='20' height='20'>";
if($sql[9]==1){
echo $x;
}else 
if($sql[9]==2){
echo $o;
}else {
echo "<input type='radio' name='move' value='4'>";
}
echo "</td>";
echo "<td width='20' height='20'>";
if($sql[10]==1){
echo $x;
}
else 
if($sql[10]==2){
echo $o;
}else{
echo "<input type='radio' name='move' value='5'>";
}echo "</td>";
echo "<td width='20' height='20'>";
if($sql[11]==1){
echo $x;
}
else 
if($sql[11]==2){
echo $o;
}else{
echo "<input type='radio' name='move' value='6'>";
}echo "</td></tr>";
echo "<tr><td width='20' height='20'>";
if($sql[12]==1){
echo $x;
}else 
if($sql[12]==2){
echo $o;
}else{
echo "<input type='radio' name='move' value='7'>";
}echo "</td>";
echo "<td width='20' height='20'>";
if($sql[13]==1){
echo $x;
}else 
if($sql[13]==2){
echo $o;
}else{
echo "<input type='radio' name='move' value='8'>";
}echo "</td>";
echo "<td width='20' height='20'>";
if($sql[14]==1){
echo $x;
}else 
if($sql[14]==2){
echo $o;
}else{
echo "<input type='radio' name='move' value='9'>";
}echo "</td></tr></table>";
if($sql[1]==$meuid){
$mover1=1;
}else{
$mover1=2;
}
echo "<input type='hidden' name='mover1' value='$mover1'><input type='submit' name='submit' class='bt3' value='Jogar'>";
echo "</form></div>";
}
echo'<div align="center">';
echo "<br /><br /><a href='/jogovelha/tutorial'>";
echo "&#187;Como funciona</a><br />";
echo "<br /><a href='/jogovelha/ativo'>";
echo "&#187;Ver jogos</a><br />";
echo "<br /><a href='/jogovelha/estatistica'>";
echo "&#187;Rank</a><br />";
?>
<br /><br /><a href="/entretenimento"><?php echo $imgservicos;?>Entretenimento</a><br />
<br /><a href="/home"><?php echo $imginicio;?>Página principal</a></div><br />
<?php echo rodape();?>
</body>
</html>