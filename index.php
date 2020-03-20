<?php
setlocale(LC_TIME, "fr_CH.utf8");

//exit if required parameters not set
if(!isset($_GET['id']) or !isset($_GET['nid']) or !isset($_GET['name'])) {
    exit();
}

//sanitize
$id = filter_var($_GET['id'], FILTER_SANITIZE_STRING);
$nid = filter_var($_GET['nid'], FILTER_SANITIZE_STRING);
$name = filter_var($_GET['name'], FILTER_SANITIZE_STRING);

//remove semestre from id
$id = explode('-',$id)[0];

//exit on no id file
$file = "data/".$id.".json";
if(!file_exists($file)) { exit(); }

$json = json_decode(file_get_contents($file), true);

//student
if(array_key_exists($nid,$json["students"])) {
    $group = $json["students"][$nid];
//prof
} else if(array_key_exists($name,$json["professors"])) {
    $group = $json["professors"][$name];
//not auth
} else {
    exit();
}

// add group to name
$name = $name." (".$group.")";

// classify sessions by subject and date
$sessions = array();
foreach($json["sessions"] as $a) {
    $subject = $a["subject"];
    list($date, $time) = explode("T", $a["start"]);
    $sessions[$subject][$date][] = $a;
}

//$name = "test-tmp-name";
//$pdo = new PDO('sqlite:'.dirname(__FILE__).'/database');

//$query = $pdo->prepare("SELECT * FROM sessions WHERE `ue` = :ue");
//$query->execute(array('ue' => 'LU2MA100'));
//$all = $query->fetchAll();
//$result = array_filter($all, function($a) {return $a['group'] == 'Je1';});

function hash_az($str) {
    $hash = md5($str);
    $nb = base_convert($hash, 16, 26);
    $r = range('a','z');
    $out = str_replace(array_keys($r), $r, $nb);
    return $out;
}

function token($subject,$n) {
    $key = base64_decode("24lmYJjvpmU14JGnc0Or/8enKKk6IfrtAJ3nNj+mk2w=");
    // Generate deterministic room name
    $room = hash_az($subject."46aaad3b2b4270f7e405e8ddb41bf62c");
    // Data to encrypt
    $data = $room . '::' . $subject . '::' . $n;
    // Generate an initialization vector
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    // Encrypt the data using AES 256 encryption in CBC mode using our encryption key and initialization vector.
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
    // The $iv is just as important as the key for decrypting, so save it with our encrypted data using a unique separator (::)
    return base64_url_encode($encrypted . '::' . $iv);
}

function base64_url_encode( $data ) {
    return strtr( base64_encode($data), '+/=', '-_,' );
}

function base64_url_decode( $data ) {
    return base64_decode( strtr($data, '-_,', '+/=') );
}

?>

<html lang="fr">
<head>
  <meta charset=utf-8>
  <meta name="robots" content="noarchive">
  <meta name=viewport content="width=device-width, initial-scale=1">
  <title>Visio-conférence <?= $id ?></title>
  <meta name="description" content="Visio-conférence">
  <link href="https://stackpath.bootstrapcdn.com/bootswatch/4.4.1/flatly/bootstrap.min.css" rel="stylesheet" integrity="sha384-yrfSO0DBjS56u5M+SjWTyAHujrkiYVtRYh2dtB3yLQtUz3bodOeialO59u5lUCFF" crossorigin="anonymous">
</head>
<body>
  <div class="container">
    <h1 class="my-5 text-center">Visio-conférences <?= $id ?></h1>
<?php
foreach($sessions as $subject => $list) {
    echo '    <h3 class="mt-5 mb-3 text-center">'.$subject.'</h3>';
    foreach($list as $date => $grps) {
        $date = ucfirst(strftime("%A %d %B", strtotime($date)));
        echo '    <div class="row mt-3 justify-content-md-center align-items-center">
                  <div class="h5 col-sm-4 mb-0">'.$date.'</div>
                  <div class="col-sm-4">';
        foreach($grps as $s) {
            $token = token($id.' - '.$subject.' - '.$s['group'], $name);
            echo '        <a href="connect.php?token='.$token.'" class="btn btn-info">'.$s['group'].'</a>';
        }
        echo '      </div>
                </div>';
    }
}
?>
  </div>
</body>
</html>
