<html lang="hr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Natječi se u komunikaciji znanosti. Pokaži što možeš.">
    <meta name="author" content="Organizacija natjecanja Znanstvenik u meni">
    <meta name="generator" content="">
    <title>Prijavljeni radovi · Znanstvenik u meni</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <style>
        <?php echo file_get_contents('frontend/css/compiled.css'); ?>

    </style>
<body class="frontpage">

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
        <p class="lead">Sve prijave</p>
        <p>Poredane obrnuto kronološki.</p>
        <?php
        array_reverse($Applications);
          foreach($Applications as $Application){
          ?>
          <div class="card bg-dark">
            <div class="card-header">
              Prijava
            </div>
            <div class="card-body">
              <h5 class="card-title"><?php new HTMLString($Application->title, true); ?></h5>
              <p class="card-text"><?php new HTMLString($Application->description, true); ?></p>
              <p class="card-text">Nositelj: <?php $teamMembers=json_decode($Application->teamMembers); new HTMLString($teamMembers->carrier->name . ' <'.$teamMembers->carrier->aai.'>', true) ?></p>
              <p class="card-text">Podaci</p>
              <p class="card-text"><b>Mentori: </b> <?php $mentors=json_decode($Application->mentors); new HTMLString(var_export($mentors), true); ?></p>
              <p class="card-text"><b>Članovi: </b> <?php new HTMLString(var_export($teamMembers), true); ?></p>
              <p class="card-text"><b>Godina: </b> <?php new HTMLString($Application->year, true); ?></p>
              <p class="card-text"><b>Podaci: </b> <?php new HTMLString(var_export($Application->data), true); ?></p>
              <p class="card-text"><b>Videi: </b>
              <?php
            $vmssID = $Application->vmssID;
            $requestEndpoint = $config->vmssBaseURL."/video/".$vmssID;
            $response = file_get_contents($requestEndpoint);
            $response = json_decode($response);
            $response->video->files = json_decode($response->video->files);
            $videoLink = $response->video->files->mp4->{'1080p'};
            $Application->data = json_decode($Application->data);
            new HTMLString(var_export($response));
            ?>
                  <br><br><b><a href="<?php echo $config->vmssBaseURL; echo '/'; new HTMLString($videoLink, true); ?>">Klikni da pogledaš video</a></b>
            </p>
                <p class="card-text"><a href="/cdn/<?php new HTMLString($Application->data->pdf, true); ?>.pdf">PDF rada (ako je dostupan)</a></p>
              <p class="card-text">
              <?php if($Application->status == 1){
              ?>
              <br>Ova prijava <b>nije predana</b> te ju učenici koji u njoj sudjeluju mogu uređivati.
              <?php
              }
              else{
                ?>
                <br>Ova prijava <b>je predana</b> i više se ne može uređivati.
                <?php

              }
              ?>
            </div>
          </div>
        <?php
          }
        if(count($Applications) == 0){echo '<p>Nema radova na natjecanju.</p>';} 
        ?>
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