<?php

$response = file_get_contents('php://input');


$url = 'https://api.telegram.org/bot'.$bot_id.'/sendMessage?chat_id=78597075&text=test'); 
		$result = file_get_contents($url);





?>