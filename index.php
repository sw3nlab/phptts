<?php

$act = $_GET['act'];
$src = $_GET['src'];
$text = $_POST['text'];
$say = $_POST['say'];

$cfg_player = $_POST['cfg_player'];
$cfg_color = $_POST['cfg_color'];
$cfg_save = $_POST['cfg_save'];
$cfg = file("config.txt");

$stream_url = $_POST['stream_url'];
$stream_save = $_POST['stream_save'];
$stream_cfg = file("radio.txt");
$stream_del_id = $_GET['delete'];


if($say=="SAY"){$send=1;}else{$send=0;}

function tts_say($text,$send,$cfg){
  if($send==0){return "";}

$s1 = "d2dldCAtcSAtVSBNb3ppbGxhIC1PIC0gImh0dHA6Ly90cmFuc2xhdGUuZ29vZ2xlLmNvbS90cmFuc2xhdGVfdHRzP2llPVVURi04JnRvdGFsPTEmaWR4PTAmdGV4dGxlbj0zMiZjbGllbnQ9dHctb2ImcT0=";
$s2 = "JnRsPVJ1LWdiIg==";

  $cmd = base64_decode($s1).''.urlencode(str_replace('`','',trim($text))).''.base64_decode($s2).'|'.trim($cfg[1]).' -';

system($cmd);

return "ok";

}

function stream_play($src){

if(!is_numeric($src)){return "";}

$url = file("radio.txt");

$play_cmd = "wget -O - ".trim($url[$src])."|madplay -";

system($play_cmd);

return "Music is:<br/>".$play_cmd."<br/><a href='?act=stop'>Stop</a>";	

}



function cfg_save($cfg_player,$cfg_color,$cfg_save){

if(!$cfg_save=="save"){return "";}

$buf = "[main]\r\n".htmlspecialchars(trim($cfg_player))."\r\n".htmlspecialchars(trim($cfg_color))."\r\n";

$fp = fopen("config.txt","w");
fwrite($fp,$buf);
fclose($fp);

return "<script>document.write('save complete !');document.location.href='?act=cfg';</script>";

}


function stream_save($stream_url,$stream_save,$stream_cfg){
    if(!$stream_save=="save"){return "";}

    if(!strlen($stream_url)>0){return "";}

    $list = '';

    for($i=0;$i<count($stream_cfg);$i++){
    $list.=$stream_cfg[$i];
    }

    $list.=$stream_url."\r\n";

    $fp = fopen("radio.txt","w");
    fwrite($fp,$list);
    fclose($fp);

    return "<script>document.write('Saved !');document.location.href='?act=radio';</script>";

}

function stream_view($stream_cfg){

    $str = "";
    for($i=0;$i<count($stream_cfg);$i++){
    $str.="<a href='?act=radio&delete=".$i."'>X</a> | <a onclick='httpGet(\"?act=play&src=".$i."\")'  href='#'>".str_replace("\r\n","<br/>",$stream_cfg[$i])."</a><br/>";
    }
return "<small>".$str."</small>";
}

function stream_control($act){

$back = "<script>document.location.href='?act=radio';</script>";

if($act=="stop"){
system("kill -9 $(pidof madplay)");
return $back;
}
if($act=="vp"){system("amixer set Master 10%+>/dev/null");
return $back;}

if($act=="vm"){system("amixer set Master 10%->/dev/null");
return $back;}
}

function stream_delete($stream_cfg,$stream_del_id){

    if(is_numeric($stream_del_id)){

        $bfr = "";
        for($i=0;$i<count($stream_cfg);$i++){

            if($i==$stream_del_id){$out="";}else{$out=$stream_cfg[$i];}
        $bfr.=$out;
        
        }
        $fp = fopen("radio.txt","w");
        fwrite($fp,$bfr);
        fclose($fp);
 
    return "<script>document.write('Delete complete!');document.location.href='?act=radio';</script>";
    }
    
    return "";
}


switch($act){

case "play":
$content = "<center>

<tt>Play<br/>".stream_play($src)."</tt>

</center>";
break;

case "radio":
	$content = "
		<center>
        <br/>".stream_delete($stream_cfg,$stream_del_id)."
".stream_save($stream_url,$stream_save,$stream_cfg)."
<form action='' method='post'>
<small>Radio Stream URL<br/>or<br/>Remote Sound file (.mp3,wav)</small>
<br/>
<input type='text' name='stream_url'>
<input type='hidden' name='stream_save' value='save'>
<input type='submit' value='Добавить'>
</form>
<div align='left'>
<tt>
".stream_view($stream_cfg)."
</tt>
</div>
		</center>";
break;

case "say":
	$content = " 
		 <center>
<br/>
<tt>Введите сообщение</tt>
<br/>
		    <form action='' method='post'>
		      <input type='text' name='text'>
		      <input type='submit' name='say' value='SAY'>
			<br/>
			".tts_say($text,$send,$cfg)."
		    </form>
		  </center>
";
break;

case "alarm":
$content = "<b>Функция в разработке ;/</b>";
break;

case "cfg":
    $content = "
<center>
<br/><br/>
<b>Настройки</b>
<br/>
".cfg_save($cfg_player,$cfg_color,$cfg_save)."
<br/>
<form action='' method='post'>
Player:<input type='text' name='cfg_player' value='".$cfg[1]."'>
<br/><br/>
Color :<input type='text' name='cfg_color' value='".$cfg[2]."'>
<br/><br/>
<input type='hidden' name='cfg_save' value='save'>
<input type='submit' value='Сохранить'>
</form>
</center>
";
break;    

case "inf":
$content = "<center><br/><br/>
<tt>Место Зарезервировано под информер =)</tt>
</center>";
break;


default:
	$content= "
        <center>
    <br/><br/>
		<tt>PHP Micro WEB Player =)</tt><br/>
	<small>
	ОпенСорсный WEB плеер c <br/>синтезом речи, радио и будильником ;)
	<br/><br/>
	<a href='https://github.com/sw3nlab/phptts'>github</a>
 | 
	<a href='https://vk.com/cyberunit'>vk</a>
 |
	<a href='https://discordapp.com/invite/vcUt6kP'>discord</a>
</small>
</center>";
}



echo "
<html>
  <head>
  <title>PHP Micro web player</title>

<script>
function httpGet(stream)
{
	var xhr = new XMLHttpRequest();
	xhr.open('GET',stream, true);
	xhr.send();

}
</script>

<style type='text/css'>
#hdr{width:700px;height:25px;border-top:1px solid black;border-bottom:1px solid black;border-left:1px solid black;border-right:1px solid black;}

#tbl{border-top:1px solid silver;border-left:1px solid silver;
border-right:1px solid silver;border-bottom:1px solid silver;}

</style>
  </head>

<body bgcolor='".$cfg[2]."'>

<center>
<div id='hdr'><b>[ PHP Micro web player ]</b></div>

<table border='0' width='680' height='300'>
<tr>
<td width='150' align='center' id='tbl'>
<tt><b>Navigation<b></tt>
<br/><br/>
<tt>
<a href='?main'>Инфо</a>
<br/><br/>
<a href='?act=radio'>Радио</a>
<br/><br/>
<a href='?act=say'>Голос</a>
<br/><br/>
<a href='?act=alarm'>Будильник</a>
<br/><br/>
<a href='?act=cfg'>Настройки</a>
<br/><br/>
<a href='?act=inf'>Информатор</a>
</tt>
</td>

<td>
<br/>
".stream_control($act)."
<td id='tbl' valign='top'>
".$content."
</td>

	<td width='150' id='tbl' align='center' valign='top'>
	<br/><br/><br/>
	<tt>
	<b>Player Control</b>
	<br/><br/>
		<a href='?act=vm'> <b>-</b> </a> Volume <a href='?act=vp'> <b>+</b> </a>
	<br/><br/>
	<a href='?act=stop'>STOP</a>
	</tt>

	</td>

</tr>	
</table>
<div id='hdr'><b><small>[ v.1.0 /30.03.2019/ ]</small></b></div>
	</center>

	</body>
</html>
"

;?>
