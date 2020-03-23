<?php
setlocale(LC_TIME, "fr_CH.utf8");

require "config.php";
require "functions.php";
require "controllers.php";

//connect
if(isset($_GET['connect'])) {
    action_connect($_GET['connect']);
}

//create
if(isset($_GET['create'])) {
    action_create($config['login']);
}

//moodle
if(isset($_GET['moodle'])) {
    action_moodle();
}

//manual
if(isset($_GET['manual'])) {
    action_manual();
}

//submit
if(isset($_GET['submit'])) {
    action_submit($_POST);
}

//list
if(isset($_GET['id']) and isset($_GET['nid']) and isset($_GET['name'])) {
    action_list($_GET['id'],$_GET['nid'],$_GET['name']);
}

//basic session
if(isset($_GET['token'])) {
    if(isset($_GET['id']) and isset($_GET['name'])) {
        action_session($_GET['id'],$_GET['name'],$_GET['token']);
    } else {
        error("Moodle pas configuré correctement");
    }
}

//home
action_home();

?>
