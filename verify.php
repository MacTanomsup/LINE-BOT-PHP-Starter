<?php
$access_token = 'yjk8NS5XKcuVuv3OL6rKoGGbsQ/lbrMflQcFRk4u1fzHBL2umyUeDEQqupHzp33ac3tZlrdP9/ci+8PODxkxt1gda+3qeiTjtX2TjY08s4xLTu55w9/YvXOvkSlbqb7Jh//fkpLl1AUBoBTV5CkdGQdB04t89/1O/w1cDnyilFU=';

$url = 'https://api.line.me/v1/oauth/verify';

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);

echo $result;
