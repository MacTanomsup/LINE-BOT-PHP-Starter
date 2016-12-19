<?php
// const DEFAULT_URL = 'https://highways-d9944.firebaseio.com/';
// const DEFAULT_TOKEN = '2ZQWVxyzKyTVcPZJNOE5IdPn5ZI7DyTQNfVyZikS';
// const DEFAULT_PATH = '/firebase/example';
//
// $firebase = new \Firebase\FirebaseLib(DEFAULT_URL, DEFAULT_TOKEN);
$access_token = 'yjk8NS5XKcuVuv3OL6rKoGGbsQ/lbrMflQcFRk4u1fzHBL2umyUeDEQqupHzp33ac3tZlrdP9/ci+8PODxkxt1gda+3qeiTjtX2TjY08s4xLTu55w9/YvXOvkSlbqb7Jh//fkpLl1AUBoBTV5CkdGQdB04t89/1O/w1cDnyilFU=';

// Get POST body content
$content = file_get_contents('php://input');

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
			$timestamp = $event['timestamp'];

			switch ($text) {
				case 'ฉันชื่ออะไร':
					$messages = [
						'type' => 'text',
						'text' =>  'เธอชื่อแม๊ก สุดน่ารักไง'
					];
					break;
					case 'สมัครการแจ้งเตือน':
						$messages = [
							'type' => 'text',
							'text' =>  'สมัครการแจ้งเตือนเรียบร้อยแล้ว หลังจากนี้คุณจะได้รับการแจ้งเตือนจากเรา'
						];

						$mid = [
							'mid' => $userId,
							'timestamp' => $timestamp,
						];

						$mid_encoded = json_encode($mid);

						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL, "https://highways-d9944.firebaseio.com/line/mid.json?auth=2ZQWVxyzKyTVcPZJNOE5IdPn5ZI7DyTQNfVyZikS");
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($ch, CURLOPT_POSTFIELDS, $mid_encoded);
						curl_setopt($ch, CURLOPT_POST, 1);

						$result = curl_exec($ch);
						if (curl_errno($ch)) {
						    echo 'Error:' . curl_error($ch);
						}
						curl_close ($ch);
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
