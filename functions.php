<?php

//generate hash with only a-z characters
function hash_az($str) {
    $hash = md5($str);
    $nb = base_convert($hash, 16, 26);
    $r = range('a','z');
    $out = str_replace(array_keys($r), $r, $nb);
    return $out;
}

function encrypt($data) {
    global $config;
    $key = base64_decode($config["key"]);
    // Generate an initialization vector
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    // Encrypt the data using AES 256 encryption in CBC mode using our encryption key and initialization vector.
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
    // The $iv is just as important as the key for decrypting, so save it with our encrypted data using a unique separator (::)
    return base64_url_encode($encrypted . '::' . $iv);
}

function decrypt($token) {
    global $config;
    $key = base64_decode($config["key"]);
    $token = filter_var($token, FILTER_SANITIZE_STRING);
    $encrypted = explode('::', base64_url_decode($token), 2);
    if(count($encrypted)==2) {
        return openssl_decrypt($encrypted[0], 'aes-256-cbc', $key, 0, $encrypted[1]);
    } else {
        error("Token invalide dec");
    }
}

function base64_url_encode($data) {
    //trim padding equal signs at the end
    return trim(strtr(base64_encode($data), '+/', '-_,'), '=');
}

function base64_url_decode($data) {
    return base64_decode(strtr($data, '-_', '+/'));
}

// function to generate connect token
function connect_token($session,$name) {
    $title = $session["id"].' - '.$session["subject"];
    if(array_key_exists('group',$session)) { $title .= ' - '.$session['group']; }
    $room = hash_az($title);
    $roomsession = array("id" => $session["id"], "title" => $title, "room" => $room, "name" => $name, "start" => $session["start"], "duration" => $session["duration"]);
    return encrypt(json_encode($roomsession));
}

?>
