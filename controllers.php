<?php

use \Firebase\JWT\JWT;

// error controller
function error($error) {
    require "templates/error.php";
    exit();
}

//connect controller
function action_connect($jwt) {
    global $config;
    // try to extract session
    try {
        $session = JWT::decode($jwt, $config['key'], array('HS256'));
    } catch(\Firebase\JWT\BeforeValidException $e) {
        //too early
        $start = $e->payload["nbf"];
        $msg = strftime("%A %d %B à %H:%M", $start);
        $minutes = intdiv($start-time(),60);
        error("Cette session n'est pas encore disponible: elle sera disponible dans {$minutes} minutes le {$msg}.");
    } catch(\Firebase\JWT\ExpiredException $e) {
        //too late
        $msg = strftime("%A %d %B à %H:%M", $e->payload["exp"]);
        error("Cette session n'est plus disponible: elle s'est terminée le {$msg}.");
    } catch(Exception $e) {
        error("Token connect23 invalide");
    }
    //check required fields and connect
    if(!array_diff(["title","room","name"], array_keys($session))) {
        require "templates/connect.php";
        exit();
    }
}

//create controller
function action_create($login) {
    require "templates/create.php";
    exit();
}

//moodle manual controller
function action_moodle() {
  require "templates/moodle_manual.php";
  exit();
}

//user manual controller
function action_manual() {
  require "templates/user_manual.php";
  exit();
}

//submit controller
function action_submit($post) {
    global $config;
    //check required fields
    if(!array_diff(["login","id","subject","start","duration"], array_keys($post))) {
        $login = filter_var($_POST['login'], FILTER_SANITIZE_STRING);
        $id = filter_var($_POST['id'], FILTER_SANITIZE_STRING);
        $subject = filter_var($_POST['subject'], FILTER_SANITIZE_STRING);
        $start = filter_var($_POST['start'], FILTER_SANITIZE_STRING);
        $duration = filter_var($_POST['duration'], FILTER_SANITIZE_STRING);
        //login
        if($login===$config['login']) {
            // start date
            $date = date_create_from_format('d/m/Y H:i', $start);
            $start = date_format($date, 'Y-m-d H:i');
            $session = ["id" => $id, "subject" => $subject, "start" => $start, "duration" => $duration];
            $token = JWT::encode($session,$config['key']);
            $url = $config["host"]."?session=".$token;
            $urltest = "/?session=".$token."&id=".$id."&name=Test Test";
            echo json_encode(['success' => true, 'url' => $url, 'urltest' => $urltest]);
        } else {
            echo json_encode(['success' => false, 'error' => "Authentification invalide"]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => "Paramètres incorrects"]);
    }
    exit();
}

//list controller
function action_list($id,$nid,$name) {
    //sanitize
    $id = filter_var($_GET['id'], FILTER_SANITIZE_STRING);
    $id = preg_replace("/[^a-zA-Z0-9-]+/", "", $id);
    $nid = filter_var($_GET['nid'], FILTER_SANITIZE_STRING);
    $name = filter_var($_GET['name'], FILTER_SANITIZE_STRING);

    //remove last part of $id "-S2"
    try {
        $id = explode('-',$id)[0];
    } catch (Exception $e) {
        error("Format de cours invalide");
    }

    // load json
    $file = "data/".$id.".json";
    if (file_exists($file)) {
        $json = json_decode(file_get_contents($file), true);
    } else {
        error("Cours indisponible");
    }

    //basic authentification if students and professors in json
    if (array_key_exists("students",$json) and array_key_exists("professors",$json)) {
        //student
        if(array_key_exists($nid,$json["students"])) {
            $group = $json["students"][$nid];
        //prof
        } else if(array_key_exists($name,$json["professors"])) {
            $group = $json["professors"][$name];
        //not auth
        } else {
            error("Accès restreint");
        }
        //add group to name
        $name = $name." (".$group.")";
    }

    //classify json sessions by subject and date
    if(array_key_exists("sessions",$json)) {
        $sessions = array();
        foreach($json["sessions"] as $session) {
            $subject = $session["subject"];
            $date = ucfirst(strftime("%A %d %B", strtotime($session["start"])));
            $session['id'] = $id;
            $session["connect"] = connect_jwt($session,$name);
            //add to sessions
            $sessions[$subject][$date][] = $session;
        }
        //list sessions
        require "templates/list_sessions.php";
        exit();

    } else {
        error("Aucune session définie");
    }

}

//basic session controller
function action_session($id,$name,$token) {
    global $config;
    //sanitize
    $id = filter_var($id, FILTER_SANITIZE_STRING);
    $id = preg_replace("/[^a-zA-Z0-9-]+/", "", $id);
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $token = filter_var($token, FILTER_SANITIZE_STRING);

    //remove last part of $id "-S2"
    try {
        $id = explode('-',$id)[0];
    } catch (Exception $e) {
        error("Format de cours invalide");
    }

    // decrypt token
    try {
        $session = JWT::decode($token, $config['key'], array('HS256'));
    } catch(Exception $e) {
        error("Session invalide");
    }
    //check required fields
    if(!array_diff(["id","subject","start","duration"], array_keys($session)) and $id==$session["id"]) {
        $session["connect"] = connect_jwt($session,$name);
        $session["date"] = strftime("%A %d %B à %H:%M", strtotime($session["start"]));
        //display one session
        require "templates/session.php";
        exit();
    } else {
        error("Session invalide");
    }
}

//action home
function action_home() {
    global $config;
    // test session
    $test_session = ["id" => "LU2MAXXX", "subject" => "Cours test", "start" => 'now'.strftime("%Y-%m-%d %H:%M"), "duration" => "0"];
    $test_token = JWT::encode($test_session,$config["key"]);
    $test_url = "/?session=".$test_token."&id=".$test_session['id']."&name=Test Test";
    //display home
    require "templates/home.php";
    exit();
}

?>
