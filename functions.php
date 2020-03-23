<?php

use \Firebase\JWT\JWT;

//generate hash with only a-z characters
function hash_az($str) {
    $hash = md5($str);
    $nb = base_convert($hash, 16, 26);
    $r = range('a','z');
    $out = str_replace(array_keys($r), $r, $nb);
    return $out;
}

// function to generate jwt token
// $session must have at least [id,subject,start,duration]
// return [title,room,name,iat,nbf,exp]
function connect_jwt($session,$name) {
    global $config;
    $title = $session["id"].' - '.$session["subject"];
    if(array_key_exists('group',$session)) { $title .= ' - '.$session['group']; }
    $room = hash_az($title.$session["start"]);
    $connect_session = array("title" => $title, "room" => $room, "name" => $name);
    //token time
    $connect_session["iat"] = time();
    $connect_session["nbf"] = strtotime($session["start"]) - $config["epsilon"]*60;
    if($session["duration"]!="INF") {
        $connect_session["exp"] = strtotime($session["start"]) + $session["duration"]*60 + $config["epsilon"]*60;
    }
    return JWT::encode($connect_session,$config["key"]);
}

function base64_url_encode($data) {
    //trim padding equal signs at the end
    return trim(strtr(base64_encode($data), '+/', '-_,'), '=');
}

function base64_url_decode($data) {
    return base64_decode(strtr($data, '-_', '+/'));
}

?>
