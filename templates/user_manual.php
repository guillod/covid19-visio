<?php
  $title = 'Procédure pour ajouter une visio-conférence à Moodle';
  ob_start();
?>

    <h1 class="my-5 text-center">Manuel d'utilisation</h1>
    <div style="font-size:120%;">
      <h3 class="mt-5 mb-3">Depuis un ordinateur :</h3>
      <ol>
        <li>Ouvrir le lien correspondant à la visio-conférence depuis Moodle.</li>
        <li>Après quelques secondes, il faut commencer par accepter le partage audio avec une fenêtre qui ressemble à cela :<br>
            <img class="mw-100 mx-auto d-block" src="fig/visio-allow.png"></li>
        <li>Ensuite l'écran suivant s'affiche, avec la description des différentes options :<br>
            <img class="mw-100 mx-auto d-block" src="fig/visio-jitsi.svg"></li>
      </ol>

      <h3 class="mt-5 mb-3">Depuis un smartphone :</h3>
      <p>Il faut commencer par installer et paramétrer l'application (à faire une seule fois) :<br></p>
      <ol>
          <li>Installer l'application Jitsi Meet depuis <a href="https://play.google.com/store/apps/details?id=org.jitsi.meet" target="_blank">Google Play</a> ou <a href="https://apps.apple.com/fr/app/jitsi-meet/id1165103905" target="_blank">App Store</a>.</li>
          <li>Ouvrir l'application, sélectionner les trois barres en haut à gauche et sélectionner <i>Paramètres</i>.</li>
          <li>Dans le champs pseudo entrer votre Prénom et votre Nom puis fermer l'application.</li>
      </ol>
      <p>Lorsque l'application est installée et configurée :</p>
      <ol>
          <li>Ouvrir le lien <i>Visio-conférence</i> disponible sur Moodle.</li>
          <li>Sélectionner le bouton correspondant à votre groupe.</li>
          <li>Sélectionner <i>Continuer vers l'application</i> sur l'écran qui ressemble au suivant. C'est aussi possible de rejoindre la visio-conférence en téléphonant à un des numéro indiqués, si vous êtes limité par les données de votre forfait.<br>
              <img class="mw-100 mx-auto d-block" src="fig/visio-appli.png" width="330"></li>
          <li>Il vient alors l'écran suivant, dont les boutons sont similaires à ceux de l'interface sur ordinateur :<br>
              <img class="mw-100 mx-auto d-block" src="fig/visio-smartphone.jpg" width="330"></li>
      </ol>
    </div>

<?php
  $content = ob_get_clean();
  include 'basepage.php'
?>
