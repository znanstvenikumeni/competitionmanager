<!doctype html>
<html lang="hr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="/frontend/css/compiled.css" />
  <link rel="stylesheet" href="/frontend/css/app.css" />


  <title>Prijavi se u korisnički račun &middot; Znanstvenik u meni!</title>
</head>

<body class="frontpage">

  <div class="container breather">
    <div class="row">
      <div class="col-md-8">
        <img src="<?php echo $config->logoURL; ?>" class="logo">
        <h1 class="hugetext">Prijavi se</h1>
        <?php if (isset($msg)) echo $msg; ?>
        <p>Za nastavak, potrebna je prijava u korisnički račun. Ako se ne natječeš prvi put na ovom natjecanju, prijavi se postojećim podacima.</p>
        <p><b>Prvi put se natječeš i nemaš korisnički račun?</b> <a href="/accounts/new">Registriraj se</a></p>
        <p><b>Ne sjećaš se lozinke?</b> <a href="/accounts/recover">Postavi novu lozinku</a></p>
        <div class="breather">
          <div class="flex flex--align-center icon"><?php echo Component::render('icon', 'fingerprint'); ?> <b>Tvoja privatnost</b></div>
          <p>Nastavkom potvrđuješ da razumiješ i prihvaćaš <a href="https://znanstvenikumeni.org/privatnost">Politiku privatnosti</a> i <a href="https://znanstvenikumeni.org/o-natjecanju">Pravila natjecanja</a> te prihvaćaš da koristimo kolačiće kako bismo osigurali da ova usluga funkcionira.</p>
        </div>
      </div>
      <div class="col-md-4">

        <form action="/addSession" method="post" id="signup" data-aos="fade-up">
          <input type="hidden" name="csrftoken" value="<?php echo $formtoken; ?>">
          <label for="aai">AAI@EduHR email adresa na @skole.hr domeni</label>
          <input type="email" name="aai" id="aai" class="form-control" placeholder="npr. ivana.horvat@skole.hr">

          <label for="password">Lozinka za Znanstvenik u meni</label>
          <input type="password" name="password" id="password" class="form-control" placeholder="Unesite svoju lozinku." required>

          <button class="btn btn-primary" type="submit" required>Nastavi &rarr;</button>
          <br><br>
        </form>

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