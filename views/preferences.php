<?php
header('Access-Control-Allow-Origin: '.$config->vmssBaseURL);
?>
<html lang="hr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <script src="https://use.fontawesome.com/f689d206fb.js"></script>

    <link rel="stylesheet" href="/frontend/css/compiled.css" />
    <link rel="stylesheet" href="/frontend/css/app.css" />
    <link href="https://transloadit.edgly.net/releases/uppy/v1.3.0/uppy.min.css" rel="stylesheet">

    <title>Postavke &middot; Znanstvenik u meni</title>
</head>
<body class="frontpage">
<div class="container">
    <nav>
        <ul>
            <li class="navli">
                <img src="<?php echo $config->logoURL; ?>" class="logo">
            </li>
            <li class="navli">
                <a href="/">&larr; Povratak na prijave</a>
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


            <h1 class="hugetext">Uredi postavke</h1>


        </div>

        <div class="col-md-8">
            <h1 class="morebreathingspace">Korisnički račun</h1>
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
        <small>Promjena broja mobitela tražit će potvrdu.</small>
        <hr>
        <h1 class="morebreathingspace">Korisnički račun</h1>
        <label for="aai">AAI@EduHR identitet</label>
        <input type="text" class="form-control" id="aai" value="<?php new HTMLString($User->aai, true); ?>" disabled>

        <label for="password">Promjena lozinke</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Unesi novu lozinku ako želiš promijeniti postojeću.">
        <br><small>Lozinka mora sadržavati minimalno 8 znakova, mora sadržavati barem jedan broj ili posebni znak te ne smije biti laka za pogoditi.</small><br>
        <hr>
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