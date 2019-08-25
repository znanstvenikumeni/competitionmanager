
<!doctype html>
<html lang="hr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <?php 
        echo '<style>';
        include 'css/shared.css'; 
        include 'css/app.css'; 
        echo '</style>'; 
    ?>
    
    <title>Uređivanje prijave &middot; Znanstvenik u meni!</title>
    <link href="https://transloadit.edgly.net/releases/uppy/v1.3.0/uppy.min.css" rel="stylesheet">

  </head>
  <body>
<nav class="navbar navbar-dark bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="/">Znanstvenik u meni!</a>
  <ul class="navbar-nav px-3">
    <li class="nav-item text-nowrap">
      <a class="nav-link" href="/accounts/signout">Odjava (<?php new HTMLString($User->firstName.' '.$User->lastName, true); ?>)</a>
    </li>
  </ul>
</nav>
<div class="container-fluid">
    <h1>Vaša prijava nije predana.</h1>
    <p>Uočili smo neke pogreške u vašoj prijavi:</p>
    <ul>
    <?php
        foreach($errors as $error){
            echo '<li>'.$error.'</li>';
        }
    ?>
    </ul>
    <p>Spremili smo vaše promjene u prijavnici kao skicu kako biste lakše mogli popraviti ove probleme.</p>
    <p><a href="/dashboard">Nastavite uređivati svoju prijavnicu &rarr;</a></p>
</div>

   <script src="https://code.jquery.com/jquery-3.3.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>
   
        <?php
            include 'js/shared.js'; 
        ?>
    </script>

  </body>
</html>