<html lang="fr">
<head>
  <meta charset=utf-8>
  <meta name="robots" content="noarchive">
  <meta name=viewport content="width=device-width, initial-scale=1">
  <title><?= $session["title"]; ?></title>
  <meta name="description" content="Visio-conférence">
  <script src='https://meet.jit.si/external_api.js'></script>
</head>

<body>
    <div id="meet"></div>

    <script>
    const domain = 'meet.jit.si';
    const options = {
        roomName: '<?= $session["room"] ?>',
        noSSL: false,
        configOverwrite: {
            startWithAudioMuted: true,
            startWithVideoMuted: true,
            disableSuspendVideo: true,
            defaultLanguage: 'fr',
            fileRecordingsEnabled: false,
            liveStreamingEnabled: false,
            enableCalendarIntegration: false,
            disableThirdPartyRequests: true,
            analytics: {disabled: true},
        },
        interfaceConfigOverwrite: {
            TOOLBAR_BUTTONS: ['microphone', 'camera', 'closedcaptions', 'desktop', 'fullscreen', 'fodeviceselection', 'hangup', 'profile', 'chat', 'sharedvideo', 'settings', 'raisehand', 'videoquality', 'shortcuts', 'tileview', 'download', 'help', 'mute-everyone'],
            SETTINGS_SECTIONS: ['devices', 'language'],
            //OPTIMAL_BROWSERS: ['chrome', 'chromium', 'firefox'],
            SHOW_PROMOTIONAL_CLOSE_PAGE: false,
            CLOSE_PAGE_GUEST_HINT: false,
            AUTO_PIN_LATEST_SCREEN_SHARE: false
        },
        parentNode: document.querySelector('#meet')
    };
    const api = new JitsiMeetExternalAPI(domain, options);
    api.executeCommand('subject', '<?= $session["title"] ?>');
<?php if($session["name"]!=""): ?>
    api.executeCommand('displayName', '<?= $session["name"] ?>');
<?php endif; ?>
    </script>
</body>
</html>
