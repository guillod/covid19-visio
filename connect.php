<?php

if(!isset($_GET['token'])) {
    exit();
}

$key = base64_decode("24lmYJjvpmU14JGnc0Or/8enKKk6IfrtAJ3nNj+mk2w=");
$token = filter_var($_GET['token'], FILTER_SANITIZE_STRING);
try {
    list($encrypted_data, $iv) = explode('::', base64_url_decode($token), 2);
    $data = openssl_decrypt($encrypted_data, 'aes-256-cbc', $key, 0, $iv);
    list($room,$subject,$name) = explode('::', $data, 3);
} catch (Exception $e) {
    echo "Invalid token";
    exit();
}

$subject = filter_var($subject, FILTER_SANITIZE_STRING);
$room = filter_var($room, FILTER_SANITIZE_STRING);
$name = filter_var($name, FILTER_SANITIZE_STRING);

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
  <title><?php echo $subject; ?></title>
  <meta name="description" content="Visio-conférence">
  <script src='https://meet.jit.si/external_api.js'></script>
</head>

<body>
    <div id="meet"></div>

    <script>
    const domain = 'meet.jit.si';
    const options = {
        roomName: '<?php echo $room; ?>',
        noSSL: false,
        configOverwrite: {
            startWithAudioMuted: true,
            startWithVideoMuted: true,
            defaultLanguage: 'fr',
            fileRecordingsEnabled: false,
            liveStreamingEnabled: false,
            enableCalendarIntegration: false,
            disableThirdPartyRequests: true,
            analytics: {disabled: true},
        },
        interfaceConfigOverwrite: {
            TOOLBAR_BUTTONS: ['microphone', 'camera', 'closedcaptions', 'desktop', 'fullscreen', 'fodeviceselection', 'hangup', 'profile', 'chat', 'recording', 'etherpad', 'sharedvideo', 'settings', 'raisehand', 'videoquality', 'shortcuts', 'tileview', 'download', 'help', 'mute-everyone'],
            SETTINGS_SECTIONS: ['devices', 'language'],
            OPTIMAL_BROWSERS: [ 'chrome', 'chromium', 'firefox', 'nwjs', 'electron'],
            SHOW_PROMOTIONAL_CLOSE_PAGE: false,
            CLOSE_PAGE_GUEST_HINT: false
	    },
        parentNode: document.querySelector('#meet')
    };
    const api = new JitsiMeetExternalAPI(domain, options);
    api.executeCommand('subject', '<?php echo $subject; ?>');
<?php
if($name!="") {
    echo "    api.executeCommand('displayName', '".$name."');";
}
?>
    </script>
</body>
</html>
