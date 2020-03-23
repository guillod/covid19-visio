<?php
  $title = 'Visio-conférences '.$id;
  ob_start();
?>

    <h1 class="my-5 text-center">Visio-conférences <?= $id ?></h1>
<?php foreach($sessions as $subject => $list): ?>
    <h3 class="mt-5 mb-3 text-center"><?= $subject ?></h3>
    <?php foreach($list as $date => $grps): ?>
    <div class="row mt-3 justify-content-md-center align-items-center">
        <div class="h5 col-sm-4 mb-0"><?= $date ?></div>
        <div class="col-sm-4">
        <?php foreach($grps as $s): ?>
          <a href="?connect=<?= $s['connect'] ?>" class="btn btn-info"><?= $s['group'] ?></a>
        <?php endforeach; ?>
        </div>
    </div>
    <?php endforeach; ?>
<?php endforeach; ?>

<?php
  $content = ob_get_clean();
  include 'basepage.php'
?>
