<?php
  $title = 'Visio-conférence '.$session['id'];
  ob_start();
?>

    <h1 class="my-5 text-center">Visio-conférence <?= $session['id'] ?></h1>
    <div class="text-center">
      <a href="?connect=<?= $session['connect'] ?>" class="btn btn-lg btn-info"><?= $session["subject"] ?> : <?= $session["date"] ?></a>

      <p class="mt-3 mb-1">Redirection en cours...</p>
      <div class="progress">
        <div class="progress-bar" role="progressbar" style="width:0%;"></div>
      </div>
    </div>

    <script>
      var width = 0;
      var interval = setInterval(update, 10);
      function update() {
        var bar = document.querySelector(".progress-bar");
        if (width >= 100) {
          clearInterval(interval);
          window.location.href = "?connect=<?= $session['connect'] ?>";
          //window.location.replace("?connect=<?= $session['connect'] ?>");
        } else {
          width++;
          bar.style.width = width+'%';
        }
      }
    </script>


<?php
  $content = ob_get_clean();
  include 'basepage.php'
?>
