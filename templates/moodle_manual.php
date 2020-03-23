<?php
  $title = 'Procédure pour ajouter une visio-conférence à Moodle';
  ob_start();
?>

    <h1 class="my-5 text-center">Manuel pour ajouter une visio-conférence à Moodle</h1>
    <div style="font-size:120%;">
      <ol>
        <li>Aller sur la page moodle de votre cours et sélectionne rle mode édition.
        <li>Cliquer sur <em>Ajouter une activité ou une ressource</em> et ajouter une ressource <img src="https://moodle-sciences.upmc.fr/moodle-2019/theme/image.php/boost/url/1584696210/icon"> URL tout en bas.</li>
        <li>Dans le champs <em>Nom</em> taper le nom du lien tel qu'il apparaitera sur moodle.</li>
        <li>Dans le champs <em>URL externe</em> taper l'adresse générée en remplissant <a href="?create" target="_blank">ce formulaire.</a></li>
        <li>Dans l'onglet <em>Apparence</em> sélectionner l'affichage sur <em>Nouvelle fenêtre</em>.</li>
        <li>Dans l'onglet <em>Variables d'URL</em>, mettre les valeurs comme ci-dessous :
          <img src="fig/moodle-variables-url.png"></li>
        <li>Cliquer sur <em>Enregister et revenir au cours</em> pour terminer.</li>
        <li>Tester que tout fonctionne correctement en cliquant sur l'activité crée</li>
      <ol>
    </div>

<?php
  $content = ob_get_clean();
  include 'basepage.php'
?>
