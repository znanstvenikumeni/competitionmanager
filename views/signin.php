<!doctype html>
<html lang="hr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <?php 
        echo '<style>';
        include 'css/shared.css'; 
        include 'css/flows.css'; 
        echo '</style>'; 
    ?>
    

    <title>Prijavi se u korisnički račun &middot; Znanstvenik u meni!</title>
  </head>
  <body class="text-center">

    <div class="flow-container">
        <img src="<?php echo $config->logoURL; ?>" class="logo">
        <h1>Bok.</h1>
        <p class="lead">Prijava</p>
        <?php if(isset($msg)) echo $msg; ?>
        <p>Za nastavak, potrebna je prijava u korisnički račun.</p>
        <p><b>Nemaš korisnički račun?</b> <a href="/accounts/new">Registriraj se</a></p>
        <form action="/addSession" method="post" id="signup">
            <input type="hidden" name="csrftoken" value="<?php echo $formtoken; ?>">
            <label for="aai">AAI@EduHR email adresa na @skole.hr domeni</label>
            <input type="email" name="aai" id="aai" class="form-control" placeholder="npr. ivana.horvat@skole.hr">
        
            <label for="password">Lozinka</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Unesite svoju lozinku." required>
            
            <button class="btn btn-primary" type="submit" required>Nastavi &rarr;</button>

        </div>
        </form>
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