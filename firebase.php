<?php

$mid = [
  'mid' => "userId",
  'messages' => "timestamp",
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
