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
ativo($meuid,'Jogando Forca ');
if(pts($meuid)<800){
echo "<div align='center'><b>Voce precisa ter no minimo 800 Pontos!</b></div>";
?>
<div align="center">
<a href="/entretenimento?"><?php echo $imgservicos;?>Entretenimento</a><br/>
<a href="/home?"><?php echo $imginicio;?>Página principal</a><br><br>
<?php 
echo 
rodape();
exit();
}
if($a==false) { $_SESSION['forca'] = 1; ?>
<br/><div id="titulo"><b>Ranking</b></div><br/>
<a href="forca?a=ranking&e=acertos">&#187;Acertos</a><br/>
<a href="forca?a=ranking&e=erros">&#187;Erros</a><br/>
<br/><div id="titulo">
<b>Selecione a categoria</b></div><br/>
<div align="center"><img src="style/forca.gif"></div><br/>
<a href="forca?a=animais">&#187;Animais</a><br/>
<a href="forca?a=cores">&#187;Cores</a><br/>
<a href="forca?a=info">&#187;Informática</a><br/>
<a href="forca?a=frutas">&#187;Frutas</a><br/>
<a href="forca?a=meses">&#187;Meses</a><br/>
<a href="forca?a=web">&#187;Programação web</a><br/>
<?php } else if($a=='ranking') {
if($e=='acertos')
{
$contmsg = $mistake->query("SELECT count(*) FROM w_usuarios where fora>'0'")->fetch();
$qz = 'fora';
$ea = 'acerto';
$tt = 'Acertos';
}
else
{
$contmsg = $mistake->query("SELECT count(*) FROM w_usuarios where fore>'0'")->fetch();
$qz = 'fore';
$ea = 'erro';
$tt = 'Erros';
}
?>
<br/><div id="titulo"><b><?php echo $tt;?></b></div><br/>
<?php
if($pag=='' || $pag<=0)$pag=1;
$numitens = $contmsg[0];
$itensporpag = 10;
$numpag = ceil($numitens/$itensporpag);
if($pag>$numpag)$pag= $numpag;
$limit = ($pag-1)*$itensporpag;
if($numitens>0) {
if($e=='acertos')
{
$itens = $mistake->query("SELECT id, $qz FROM w_usuarios where fora>'0' order by fora desc limit $limit, $itensporpag");
}
else
{
$itens = $mistake->query("SELECT id, $qz FROM w_usuarios where fore>'0' order by fore desc limit $limit, $itensporpag");
}
$i=0; while ($item = $itens->fetch(PDO::FETCH_OBJ)) { ?>
<div id="<?php echo $i%2==0?'div1':'div2';?>">
<a href="perfil?id=<?php echo $item->id;?>"><?php echo gerarnome($item->id);?></a> - <?php echo $item->$qz.' '.$ea.($item->$qz>1?'s':'');?>
</div>
<?php $i++; } ?>
<br/><div align="center"><br/>
<?php if($pag>1) { $ppag = $pag-1; ?>
<a href="forca?a=ranking&e=<?php echo $e;?>&pag=<?php echo $ppag;?>">&#171;Anterior</a>
<?php } if($pag<$numpag) { $npag = $pag+1; ?>
<a href="forca?a=ranking&e=<?php echo $e;?>&pag=<?php echo $npag;?>">Próxima&#187;</a>
<?php } ?>
<br/><?php echo $pag.'/'.$numpag;?><br/>
<?php if($numpag>2) { ?>
<form action="forca.php" method="get">
Pular para página<input name="pag" size="3">
<input type="submit" value="IR">
<input type="hidden" name="a" value="<?php echo $a;?>">
<input type="hidden" name="e" value="<?php echo $e;?>">
</form>
<?php } } else { ?>
<div align="center">Nenhum usuário!<br/><br/>
<?php } ?>
<br/><div align="center"><a href="forca?">Novo jogo</a>
<?php } else {
if($_SESSION['forca']=='') { ?>
<br/><div align="center"><?php echo $imgerro;?>Este jogo já terminou<br/><br/>
Comece um novo jogo<br/><br/>
<a href="forca?">Novo jogo</a>
<?php } else {
$cat=isset($_GET['a'])?$_GET['a']:'';
if ($cat=='animais')
{
$tit='Animais';
$list = 'ANIMALS
Babuino
URSO
BUFALO
CAMELO
GATO
VACA
CÃO
CAVALO
ELEFANTE
PEIXE
FOCA
GIRAFA
CABRA
CAVALO
Canguru
MACACO
RATO
MULA
PORCO
ELEFANTE
Urso
GambA
Cachorro
COELHO
Guaxinim
RATO
LOBO
TUBARÃO
Esquilo
Morsa
Fuinha
BALEIA
ZEBRA';
}
else if($cat=='cores')
{
$tit='Cores';
$list = 'PRETO
AZUL
ROSA
ROXO
OURO
VERDE
Lavanda
LIME
MARROM
LARANJA
ROSA
VERMELHO
AZUL
TURQUESA
VIOLETA
BRANCO
AMARELO';
}
else if($cat=='info')
{
$tit='Informatica';
$list = 'ACCESS
ANTI-VIRUS
SOFTWARE
BASIC
CD-ROM DRIVE
CHAT
COMPUTADOR
CPU
BANCO DE DADOS
DOS
EMAIL
EXCEL
FIREWALL
FLOPPY DRIVE
FORUMS
FRONTPAGE
GAMES
HACKER
HARD DRIVE
HTML
ICQ
INTERNET
JUNK MAIL
KEYBOARD
LINUX
LOTUS
MICROSOFT
MONITOR
MOTHER BOARD
MOUSEPAD
SISTEMA OPERACIONAL
PORTA PARALELA
PHP
IMPRESSORA
PUBLICAÇÃO
RAM
PORTA
SOLITARE
SPEAKERS
TECHNOLOGY
UNIX
URL
VIRUS
VISUAL BASIC
WINDOWS
WORD
WORD PROCESSING
WORLD WIDE WEB
ZIP';
}
else if($cat=='frutas')
{
$tit='Frutas';
$list = 'Abacate
Ananás
Abiu
Abiu-cutite
Abiu-do-cerrado
Abiu-piloso
Abiu-preto
Abiu-roxo
Aboirana
Abricó
Abricó-da-flórida
Abricó-da-praia
Abricoteiro-do-mato
Abutua-grande
Açaí
Acaíba
Acara-uba
Acerola
Achachairu
Achuá
Acumã
Acuri
Aguaí-guaçu
Ajarí
Ajuru-preto
Aki
Alexia
Alfarroba
Algarobo
Algodãozinho
Amanina
Amapá
Amarula
Ameixa-brava
Ameixa-da-caatinga
Ameixa-da-mata
Amêndoa
Amendoeira-da-praia
Amendoim-de-árvore
Amendoim-de-bugre
amora Amora-do-mato
Anajá
Angá
Angúria
Anona-lisa
Apuruí
Araçá
Araçá-boi
Araçá-cagão
Araçá-da-serra
Araçá-de-água
Araçá-de-anta
Araçá-de-anta-vermelha
Araçá-do-mato
Araçá-do-rio-grande
Araçá-roxo
Araticum
Aroeira-vermelha
Babaçu
Bacaba
Bacupari
Bacupari-miúdo
Bacuri
Banana
Baru
Biribá
Brejaúva
Buriti
Fruta-pão
Burmese uva
Cabeluda
Cacau
Cagaíta
Cajá
Cajá-grande
Cajá-manga
Cajá-redondo
caju
Cajuí
Cambucá
Camu-camu
Caqui-do-cerrado
Caqui-do-mato
Carambola
Carnaúba
Castanha-da-áfrica
Castanha-do-pará
Cempedak
Chupa
Coco
Cuieira
Cuiarana
Cumaru
Cupuaçu
Curiola
Dendê
Durião
Embaúba-vermelha
Feijoa
Fruta-da-condessa
Fruta-de-tatu
Fruta-do-conde
Goiaba
Graviola
Groselha preta
Groselha vermelha
Grumixama
Guabiju
Guabiroba
Guabiroba-branca
Guabiroba-da-mata
Guaçatunga
Guaçatunga-grande
Guaraná
Guariroba
Ibapobó
Ingá
Ingá-branco
Ingá-cipó
Ingá-dedo
Ingá-ferradura
Jaboticabarana
Jabuticaba
Jaca
Jaci
Jambo
Jambolão
Jaracatiá
Jarana-mirim
Jatobá
Jenipapo
Fruto-de-keppel
Jutaí
Langsat
Licuri
Lobeira
Louro-branco
Mabolo
Sapota
Maçã-de-água
Maçaranduba-mirim
Macaúba
Mamão
Mamão-do-mato
Mamoncillo
Manga
Mangaba
Mangostão
Mapati
Maracujá
Marajá
Marang
Fruta-manteiga-de-amendoim
Mari
Maria-preta
Marmelada-nativa
Marmelinho
Marmelinho-do-campo
Marolo
Monguba
Murici
Murici-da-mata
Murici-do-cerrado
Murici-miúdo
Murici-pequeno
Olho-de-boi
Murmuru
Murumuru
Pau-de-jacu
Pepino-do-mato
Pequi
Perta-güela
Pimenta-de-macaco
Pindaíba
Pinha-da-mata
Pitanga
Pitaya
Pitomba
Physalis
Pupunha
Quina
Rambutan
Salak
Sapota-do-solimões
Sapoti
Caimito
Sapucaia
Saputá
Sorvinha
Tamarindo
Tapiá
Tatajuba
Uricuru
Umari_Fruta
Umbu
Umiri
Uvaia
Uxi
Veludo
Xixá';
}
else if($cat=='meses')
{
$tit='Meses';
$list = 'ABRIL
AGOSTO
DEZEMBRO
FEVEREIRO
JANEIRO
JULHO
JUNHO
MARÇO
MAIO
NOVEMBRO
OUTUBRO
SETEMBRO';
}
else if ($cat=='web')
{
$tit='Programação Web';
$list = 'JAVA
NET BEANS
PHP
SCRIPTS
CODIGO FONTE
JAVASCRIPT
JOGOS
SSI IS SERVER SIDE INCLUDES
BILL GATES
COOKIES
HTTP
FILE UPLOADS
DATABASE
CONEXAO
APACHE SERVER
ZIP
FILE
TAR COMPRESSION
FUNCTIONS
ENCRYPTION
MYSQL DATABASE
DEBUGGING
VERIFICATION
HTML VALIDATION
CASCADING STYLE SHEETS';
}
$alpha = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$additional_letters = ' -.,;!?%& 0123456789/';
$len_alpha = strlen($alpha);
if(isset($_GET['n'])) $n=$_GET['n'];
if(isset($_GET['letras'])) $letters=$_GET['letras'];
if(!isset($letters)) $letters='';
if(isset($PHP_SELF)) $self=$PHP_SELF;
else
$links='';
$max=6;
$list = strtoupper($list);
$words = explode("\n",$list);
srand ((double)microtime()*1000000);
$all_letters=$letters.$additional_letters;
$wrong = 0; ?>
<br/><div id="titulo">
<b><?php echo $tit;?></b></div>
<div align="center">
<?php
if (!isset($n)) { $n = rand(1,count($words)) - 1; }
$word_line='';
$word = trim($words[$n]);
$done = 1;
for ($x=0; $x < strlen($word); $x++)
{
if (strstr($all_letters, $word[$x]))
{
if ($word[$x]==" ") $word_line.=" / "; else $word_line.=$word[$x];
}
else { $word_line.="_ "; $done = 0; }
}
if (!$done)
{
for ($c=0; $c<$len_alpha; $c++)
{
if (strstr($letters, $alpha[$c]))
{
if (strstr($words[$n], $alpha[$c])) {$links .= "<b>$alpha[$c]</b> "; }
else { $links .= " $alpha[$c] "; $wrong++; }
}
else
{
$links .= " <a href=\"forca?a=$cat&letras=$alpha[$c]$letters&n=$n&on=$on\">$alpha[$c]</a> "; }
}
$nwrong=$wrong; if ($nwrong>6) $nwrong=6; ?>
<br/><img src="style/forca_<?php echo $nwrong;?>.gif"><br/>
<?php if($wrong >= $max) { $n++; if ($n>(count($words)-1)) $n=0; ?>
<br/><br/><?php echo $word_line;?>
<br/><br/><big>Você está enforcado(a)!!!</big><br/><br/>
<?php
if (strstr($word, " "))
$term='answer';
else
$term='word';
$errou = $mistake->query("SELECT fore FROM w_usuarios WHERE id='$meuid'")->fetch();
$mistake->exec("UPDATE w_usuarios SET pt='".(pts($meuid)-5)."', fore='".($errou[0]+1)."' WHERE id='$meuid'");
unset($_SESSION['forca']);
?>
A palavra certa era <b><?php echo $word;?></b><br/><br/>
Você perdeu 5 pntos<br/><br/>
<a href="forca?">Novo jogo</a>
<?php } else { ?>
Palpites restantes: <b><?php echo ($max-$wrong);?></b><br/><br/>
<?php echo $word_line;?>
<br/><br/>Escolha uma letra:<br/>
<?php echo $links; } } else { $n++; if ($n>(count($words)-1)) $n=0; ?>
<br/><?php echo $word_line;
$ac = $mistake->query("SELECT fora FROM w_usuarios WHERE id='$meuid'")->fetch();
$mistake->exec("UPDATE w_usuarios SET pt='".(pts($meuid)+5)."', fora='".($ac[0]+1)."' WHERE id='$meuid'");
unset($_SESSION['forca']);
?>
<br/><br/><b>Parabéns!!! Você acertou!!!</b><br/><br/>
Você ganhou 5 pontos<br/><br/>
<a href="forca?">Novo jogo</a>
<?php } } } ?>
<br/><br/><div align="center">
<a href="forca?">Forca</a><br/>
<a href="home?"><?php echo $imginicio;?>Página principal</a><br><br>
<?php echo rodape();?>
</body>
</html>