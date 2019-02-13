<?php

$text = $_POST['text'];

function tts_say($text){

  //Место для фильтра входящих данных =)

$cmd = 'wget -q -U Mozilla -O - "http://translate.google.com/translate_tts?ie=UTF-8&total=1&idx=0&textlen=32&client=tw-ob&q='.$text.'&tl=Ru-gb"|madplay -';  
  
system($text);
return "ok";

}


echo "
<html>
<head><title>PHPTTS</title></head>

<body>

<center>
<form action='' method='post'>
<input type='text' name='text'>
<br/>
<input type='submit' value='SAY'>
</form>
</center>

</body>
</html>
"


;?>
