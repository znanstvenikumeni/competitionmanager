<!doctype html>
<html lang="hr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <script src="https://use.fontawesome.com/f689d206fb.js"></script>

    <link rel="stylesheet" href="/frontend/css/compiled.css" />
    <link rel="stylesheet" href="/frontend/css/app.css" />

    <title>Korisnici pod traženim uvjetima &middot; Znanstvenik u meni</title>
</head>
<body class="frontpage">
<div class="container">
    <nav>
        <ul>
            <li class="navli">
                <img src="<?php echo $config->logoURL; ?>" class="logo">
            </li>
            <li class="navli">
                <a href="/organiserpanel">Organizatorska ploča</a>
            </li>
            <li class="navli">
                <a href="/organiserpanel/users">Korisnici</a>
            </li>
            <li class="navli">
                <a href="/preferences">Postavke</a>
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


            <h1 class="hugetext">Korisnici</h1>
            <p>Za traženi dio AAI-ja</p>

        </div>

        <div class="col-md-8">


            <?php
            if(!empty($Users)){
                foreach($Users as $User){
                    ?>
                    <div class="card bg-dark">
                        <div class="card-header">
                            Korisnik
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?php new HTMLString($User->firstName.' '.$User->lastName, true); ?></h5>
                            <p class="card-text">AAI: <?php new HTMLString($User->aai, true); ?> &middot; Email: <?php new HTMLString($User->email, true); ?> &middot; Telefon: <?php new HTMLString($User->phone, true); ?></p>
                            <p class="card-text">Metadata: <?php new HTMLString(var_export($User->metadata), true); ?></p>
                        </div>
                    </div>
                    <?php
                }
            }
            else{
                echo 'Nema korisnika za upit.';
            }
            ?>

        </div>
    </div>
</div>
</div>

</div>



<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<script>
    <?php
    include 'js/shared.js';
    ?>
</script>

</body>
</html>