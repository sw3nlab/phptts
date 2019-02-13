<?php

$text = $_POST['text'];

function tts_say($text){

//link

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
