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

    <title>Prijavi se &middot; Znanstvenik u meni</title>
</head>
<body class="frontpage">
<div class="container">
    <nav>
        <ul>
            <li class="navli">
                <img src="<?php echo $config->logoURL; ?>" class="logo">
            </li>
            <li class="navli">
                <a href="/preferences">Postavke korisničkog računa</a>
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


            <h1 class="hugetext">Vaša prijava nije predana</h1>


        </div>

        <div class="col-md-8">
    <h1 class="morebreathingspace">Uočili smo neke pogreške u vašoj prijavi.</h1>
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
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<script>
    <?php
    include 'js/shared.js';
    ?>
</script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script>
    AOS.init();
</script>

  </body>
</html>