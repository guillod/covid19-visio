<?php
    $title = 'Visio-conférence - Création';

    ob_start();
?>
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment-with-locales.min.js" integrity="sha256-AdQN98MVZs44Eq2yTwtoKufhnU+uZ7v2kXnD5vqzZVo=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>

<?php
    $head = ob_get_clean();
    ob_start();
?>

    <h1 class="my-5 text-center">Création d'une visio-conférence</h1>

    <form id="form" class="my-5" style="font-size: 120%;" action="?submit" method="POST" >

      <div class="form-group">
        <label for="id" class="form-label-lg">Code UE</label>
        <input type="text" class="form-control form-control-lg" id="id" name="id" placeholder="LU2MA100" aria-describedby="id-help" required>
        <small id="id-help" class="text-muted">
            doit correspondre à la première partie du code moodle de l'UE avec le tiret. Par exemple <em>LU2MA100</em> si le code moodle est <em>LU2MA100-S2</em>.
        </small>
      </div>

      <div class="form-group">
        <label for="subject">Sujet</label>
        <input type="text" class="form-control form-control-lg" id="subject" name="subject" placeholder="Cours sur les matrices" aria-describedby="subject-help" required>
        <small id="subject-help" class="text-muted">
            est utilsé comme titre de la visio-conférence.
        </small>
      </div>

      <div class="form-group">
        <label for="start">Date et heure de début</label>
        <div class="input-group date" id="picker" data-target-input="nearest">
          <input type="text" class="form-control form-control-lg datetimepicker-input" data-target="#picker" name="start" placeholder="13/03/2020 13:52" aria-describedby="date-help" required/>
          <div class="input-group-append" data-target="#picker" data-toggle="datetimepicker">
            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
          </div>
        </div>
        <small id="start-help" class="text-muted">
            début de la visio-conférence au format <em>jj/mm/yyyy hh:mm</em>. La visio-conférence ouvre 15 minutes avant.
        </small>
      </div>

      <div class="form-group">
        <label for="duration">Durée</label>
        <input type="text" class="form-control form-control-lg" id="duration" name="duration" placeholder="120" aria-describedby="duration-help" required>
        <small id="duration-help" class="text-muted">
            durée de la visio-conférence en minutes. La visio-conférence ferme 15 minutes après la fin indiquée pour la durée.
        </small>
      </div>

      <input type="hidden" class="form-control" id="login" name="login">

      <hr class="mb-4">
      <button id="button" class="btn btn-primary btn-lg btn-block" type="submit">Créer la visio-conférence</button>
    </form>

    <div id="progress" class="mt-3 text-center" style="display:none;">
      <h4 class="p-2">Envoi en cours...</h4>
    </div>

    <div id="errordiv" class="alert alert-danger" role="alert" style="display:none;">
      <h4 class="alert-heading">Erreur</h4>
      <p id="error" class="mb-0"></p>
    </div>

    <div id="successdiv" class="alert alert-success" role="alert" style="display:none;">
      <h4 class="alert-heading text-center">Visio-conférence crée avec succès</h4>
      <div class="row text-center">
        <div class="col-lg-4 mb-3"><a href="/?moodle" role="button" class="btn btn-warning text-decoration-none" target="_blank">Ajouter à Moodle</a></div>
        <div class="col-lg-4 mb-3"><button id="copy" type="button" class="btn btn-warning">Copier l'URL pour Moodle'</button></div>
        <div class="col-lg-4 mb-3"><a id="urltest" role="button" class="btn btn-warning text-decoration-none" target="_blank">Tester la conférence</a></div>
      </div>
      <p>L'URL pour Moodle est:</p>
      <input id="url" class="form-control">
    </div>

    <script type="text/javascript">
      $(function () {
          $('#picker').datetimepicker({
              locale: 'fr'
          });
      });

      $('#copy').click(function(){
          $('#url').select();
          document.execCommand("copy");
      });

      $('#form').submit(function(){

          $('#login').val("<?= $login ?>");
          $('#progress').show();
          $('#errordiv').hide();
          $('#sucessdiv').hide();

          $.ajax({
              url: "?submit",
              type: "POST",
              dataType: "json",
              data: $('#form').serialize(),
              success: function ( json ){
                  $('#progress').hide();
                  if(json.success) {
                      $('#successdiv').show();
                      $('#url').val(json.url);
                      $('#urltest').attr("href",json.urltest);
                  } else {
                      $('#errordiv').show();
                      $('#error').text(json.error);
                  }
              },
              error: function ( json ){
                  $('#progress').hide();
                  $('#errordiv').show();
                  $('#error').text("Soumission impossible");
              }
          });

          return false;
      });
    </script>


<?php
    $content = ob_get_clean();
    include 'basepage.php'
?>
