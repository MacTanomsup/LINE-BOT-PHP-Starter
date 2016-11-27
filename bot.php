<?php
$access_token = 'yjk8NS5XKcuVuv3OL6rKoGGbsQ/lbrMflQcFRk4u1fzHBL2umyUeDEQqupHzp33ac3tZlrdP9/ci+8PODxkxt1gda+3qeiTjtX2TjY08s4xLTu55w9/YvXOvkSlbqb7Jh//fkpLl1AUBoBTV5CkdGQdB04t89/1O/w1cDnyilFU=';

// Get POST body content
$content = file_get_contents('php://input');


	 $to = "nathapol_t@kkumail.com";
	 $subject = "From WebHook Line";

	 $message = $content;

	 $header = "From:mactanomsup@gmail.com \r\n";
	 $header .= "MIME-Version: 1.0\r\n";
	 $header .= "Content-type: text/html\r\n";

	 $retval = mail ($to,$subject,$message,$header);

	 if( $retval == true ) {
			echo "Message sent successfully...";
	 }else {
			echo "Message could not be sent...";
	 }

// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
			$text = $event['message']['text'];
			// Get replyToken
			$replyToken = $event['replyToken'];

			$userId = $event['source']['userId'];

			switch ($text) {
				case 'ฉันชื่ออะไร':
					$messages = [
						'type' => 'text',
						'text' =>  'เธอชื่อแม๊ก สุดน่ารักไง'
					];
					break;
				default:
					$messages = [
						'type' => 'text',
						'text' =>  'ไม่เข้าใจว่าเธอพูดอะไร'
					];
					break;
			}


			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages],
			];
			$post = json_encode($data);
      $headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
      $result = curl_exec($ch);
      curl_close($ch);

      echo $result . "\r\n";
      }
    }
}
echo "OK";
