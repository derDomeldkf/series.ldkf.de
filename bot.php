<?php
	$bot_id = "187000985:AAFhG3pmW3jBJ_ZJkcFzzMuB-WyqZ_cTvR8";
	$web_id=$argv[1]; //got from website
	$id=$argv[2]; //telegra,-user-id
	$username=$argv[3];
	$first_name=$argv[4];
	$last_name=$argv[5];
	$url = 'https://api.telegram.org/bot'.$bot_id.'/sendMessage?chat_id=78597075&text=test'; 
	$result = file_get_contents($url);
    

?>