<html lang="fr">
<head>
  <meta charset=utf-8>
  <meta name="robots" content="noarchive">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Visio-conférences Jitsi Meet avec Moodle">
  <meta name="author" content="Julien Guillod">
  <title><?= $title ?></title>
  <meta name="description" content="Visio-conférence">
  <link href="https://stackpath.bootstrapcdn.com/bootswatch/4.4.1/flatly/bootstrap.min.css" rel="stylesheet" integrity="sha384-yrfSO0DBjS56u5M+SjWTyAHujrkiYVtRYh2dtB3yLQtUz3bodOeialO59u5lUCFF" crossorigin="anonymous">
  <?php if(isset($head)) {echo $head;} ?>
</head>
<body>
  <div class="container">
    <?= $content ?>
  </div>
</body>
</html>
