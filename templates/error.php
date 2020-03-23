<?php
  $title = 'Visio-conférences - Erreur';
  ob_start();
?>

    <h1 class="my-5 text-center">Visio-conférences</h1>
    <div class="alert alert-danger" role="alert">
      <h4 class="alert-heading">Erreur</h4>
      <p class="mb-0"><?= $error ?></p>
    </div>

<?php
  $content = ob_get_clean();
  include 'basepage.php'
?>
