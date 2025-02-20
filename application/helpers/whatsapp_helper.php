<?php

function send_whatsapp_message($number, $message) {
    $instance_id = "instance107789"; // Ganti dengan Instance ID dari UltraMsg
    $token = "r6papxbl3ltyislz"; // Ganti dengan API Token dari UltraMsg

    $url = "https://api.ultramsg.com/$instance_id/messages/chat";
    $data = [
        'token' => $token,
        'to' => $number,
        'body' => $message
    ];

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query($data),
        CURLOPT_HTTPHEADER => ["Content-Type: application/x-www-form-urlencoded"]
    ]);

    $response = curl_exec($curl);
    curl_close($curl);

    return json_decode($response, true);
}
?> 