<?php

$act = $_GET['act'];
$text = $_POST['text'];
$say = $_POST['say'];


if($say=="SAY"){$send=1;}else{$send=0;}

function tts_say($text,$send){
  if($send==0){return "";}

	$s1 = "d2dldCAtcSAtVSBNb3ppbGxhIC1PIC0gImh0dHA6Ly90cmFuc2xhdGUuZ29vZ2xlLmNvbS90cmFuc2xhdGVfdHRzP2llPVVURi04JnRvdGFsPTEmaWR4PTAmdGV4dGxlbj0zMiZjbGllbnQ9dHctb2ImcT0=";
	$s2 = "JnRsPVJ1LWdiInxtYWRwbGF5IC0=";
	$cmd = base64_decode($s1).''.str_replace('`','',trim($text)).''.base64_decode($s2);

system($cmd);

return "ok";
}



switch($act){

case "radio":
	$content = "
		<center>
			<h3>Radio Stations List</h3>
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
			".tts_say($text,$send)."
		    </form>
		  </center>
";
break;

case "alarm":
$content = "<b>Функция в разработке ;/</b>";
break;

default:
	$content= "
		<center>
		<tt>PHPTTS WEB player =)</tt>
	<small>
	ОпенСорсный WEB плеер c <br/>синтезом речи, радио и будильником ;)
	<br/>
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
  <title>PHPTTS web player</title>
  </head>

<body>

<center>
<h3>[ PHPTTS Navigation ]</h3>
	<table border='0' width='50%' height='50%'>
<tr>
<td valign='top'>
<br/>
<a href='?main'>Инфо</a>
<br/><br/>
<a href='?act=radio'>Радио</a>
<br/><br/>
<a href='?act=say'>Голосовое сообщение</a>
<br/><br/>
<a href='?act=alarm'>Будильник</a>
</td><br/>
<td valign='top'>
".$content."
</td>
</tr>
	</table>
	</center>

	</body>
</html>
"

;?>
