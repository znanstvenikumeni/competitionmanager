<?php
header('Access-Control-Allow-Origin: '.$config->vmssBaseURL);
?><html lang="hr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <script src="https://use.fontawesome.com/f689d206fb.js"></script>

    <link rel="stylesheet" href="/frontend/css/compiled.css" />
    <link rel="stylesheet" href="/frontend/css/app.css" />
    <link href="https://transloadit.edgly.net/releases/uppy/v1.3.0/uppy.min.css" rel="stylesheet">

    <title>Mentorska ploča &middot; Znanstvenik u meni</title>
</head>
<body class="frontpage">
<div class="container">
    <nav>
        <ul>
            <li class="navli">
                <img src="<?php echo $config->logoURL; ?>" class="logo">
            </li>
            <li class="navli">
                <a href="/">Mentorska ploča</a>
            </li>
            <li class="navli">
                <a href="https://znanstvenikumeni.org">Web natjecanja</a>
            </li>
            <li class="navli">
                <a href="/accounts/signout">
                    Odjava (<?php new HTMLString($User->firstName.' '.$User->lastName, true); ?>)
                </a>

            </li>
        </ul>
    </nav>
</div>

<div class="container breather">
    <div class="row">
        <div class="col-md-4">


            <h1 class="hugetext">Mentorska ploča</h1>


        </div>

        <div class="col-md-8" style="padding-left: 90px;">
            <h1 class="morebreathingspace">Vaše prijave</h1>

        <?php
          foreach($Applications as $Application){
          ?>
          <div class="card bg-dark">
            <div class="card-header">
              Prijava
            </div>
            <div class="card-body">
              <h5 class="card-title"><?php new HTMLString($Application->title, true); ?></h5>
              <p class="card-text"><?php new HTMLString($Application->description, true); ?></p>
              <p class="card-text">Nositelj prijave: <?php $teamMembers=json_decode($Application->teamMembers); new HTMLString($teamMembers->carrier->name . ' <'.$teamMembers->carrier->aai.'>', true) ?></p>
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
        if(count($Applications) == 0){echo '<p>Niste mentor niti jednom radu.</p>';} 
        ?>
      </div>
    </div>
    
</div>


   <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
         <script>
        <?php
            include 'vendor/jquery-easing/jquery.easing.min.js';
            include 'js/sb-admin-2.min.js';
        ?>
    </script>
    <script>
        <?php
            include 'js/shared.js'; 
        ?>
    </script>

  </body>
</html>