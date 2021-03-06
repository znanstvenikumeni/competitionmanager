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
    
    <title>Organizatorska ploča &middot; Znanstvenik u meni!</title>
  </head>
  <body>
<nav class="navbar navbar-dark bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="/">Znanstvenik u meni</a>
  <ul class="navbar-nav px-3">
    <li class="nav-item text-nowrap">
      <a class="nav-link" href="/accounts/signout">Odjava (<?php new HTMLString($User->firstName.' '.$User->lastName, true); ?>)</a>
    </li>
  </ul>
</nav>

<div class="container-fluid">

  <div class="row">
    <div class="col-2 sidebar">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link" href="/organiserpanel">Organizatorska ploča</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/organiserpanel/users">Korisnici</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/preferences">Postavke</a>
          </li>
        </ul>
      </div>
      <div class="col-10 main">
        <form action="/organiserpanel/user" method="post">
          <input type="text" name="aai" placeholder="Dio AAI-ja korisnika" class="form-control">
          <input type="submit" class="btn btn-primary" value="Traži">
      </div>
    </div>
    
</div>


   <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>
        <?php
            include 'js/shared.js'; 
        ?>
    </script>

  </body>
</html>