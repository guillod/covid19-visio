<?php
  $title = 'Visio-conférences pour Moodle';
  ob_start();
?>

    <h1 class="mt-5 text-center">Visio-conférences</h1>
    <h4 class="mb-3 text-center">intégrant <a href="https://jitsi.org/" target="_blank">Jitsi Meet</a> avec <a href="https://moodle.org/" target="_blank">Moodle</a>:</h4>

    <h3 class="mt-5 mb-3 text-center">A destination des étudiant·es</h3>
    <div class="my-4 row text-center justify-content-md-center">
      <div class="col-lg-3 mb-3"><a href="<?= $test_url ?>" role="button" class="btn btn-lg btn-info text-decoration-none" target="_blank">Conférence de test</a></div>
      <div class="col-lg-3 mb-3"><a href="?manual" role="button" class="btn btn-lg btn-info text-decoration-none" target="_blank">Manuel d'utilisation</a></div>
    </div>

    <h3 class="mt-5 mb-3 text-center">A destination des enseignant·es</h3>
    <div class="my-4 row text-center justify-content-md-center">
      <div class="col-lg-3 mb-3"><a href="?create" role="button" class="btn btn-lg btn-primary text-decoration-none" target="_blank">Créer une conférence</a></div>
      <div class="col-lg-3 mb-3"><a href="?moodle" role="button" class="btn btn-lg btn-primary text-decoration-none" target="_blank">Intégration Moodle</a></div>
    </div>

    <h4 class="mb-3 text-center">Spécificités:</h4>
    <div class="d-flex">
      <ul class="mx-auto">
        <li>Basé sur Jitsi Meet</li>
        <li>Destiné à l'enseignement à distance</li>
        <li>Uniquement fonctionalités utiles activées</li>
        <li>Nom d'utilisateur repris de Moodle</li>
        <li>Micro et vidéo désactivés au démarrage</li>
        <li>Possibilité de partage d'écran ou de fenêtre</li>
        <li>Chat publique</li>
        <li>Fonctionalité <em>lever la main</em></li>
      </ul>
    </div>


<?php
  $content = ob_get_clean();
  include 'basepage.php'
?>
