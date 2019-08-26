<?php
header('Access-Control-Allow-Origin: '.$config->vmssBaseURL);
?>
<!doctype html>
<html lang="hr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
<script src="https://use.fontawesome.com/f689d206fb.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <link href="https://transloadit.edgly.net/releases/uppy/v1.3.0/uppy.min.css" rel="stylesheet">

    <?php 
        echo '<style>';
        include 'css/sb-admin-2.min.css';
        include 'css/shared.css'; 
        include 'css/app.css'; 
        echo '</style>'; 
    ?>
    
    <title>Uređivanje postavki &middot; Znanstvenik u meni!</title>
  </head>
  <body id="page-top">
    <div id="wrapper">


        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <li class="nav-item">
        <a class="nav-link" href="/">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Prijave za natjecatelje / Mentorska ploča</span></a>
      </li>
      <hr class="sidebar-divider">
        <li class="nav-item active">
        <a class="nav-link" href="/preferences">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Postavke</span></a>
      </li>

        </ul>
   <div id="content-wrapper" class="d-flex flex-column">
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow"">
<button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>


  <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="/">Znanstvenik u meni!</a>
  <ul class="navbar-nav ml-auto">
   <div class="topbar-divider d-none d-sm-block"></div>

            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="/accounts/signout" id="userDropdown" role="button">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Odjava (<?php new HTMLString($User->firstName.' '.$User->lastName, true); ?>)</span>
              </a>

    </li>
  </ul>
</nav>
      <div id="content">
       <div class="container-fluid">
    <form action="/editPreferences" method="post">
        <input type="hidden" name="csrftoken" value="<?php echo $formtoken; ?>">
        <label for="firstName">Ime</label>
        <input type="text" class="form-control" id="firstName" name="firstName" value="<?php new HTMLString($User->firstName, true); ?>">
        <label for="lastName">Prezime</label>
        <input type="text" class="form-control" id="lastName" name="lastName" value="<?php new HTMLString($User->lastName, true); ?>">
        <label for="email">E-mail adresa</label>
        <input type="email" class="form-control" id="email" name="email" value="<?php new HTMLString($User->email, true); ?>">
        <label for="phone">Broj mobitela</label>
        <input type="tel" class="form-control" id="phone" name="phone" value="<?php new HTMLString($User->phone, true); ?>">
        <button class="btn btn-primary">Spremi promjene</button>
    </form>

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