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
    

    <title>Otvori korisnički račun &middot; Znanstvenik u meni!</title>
  </head>
  <body class="text-center">

    <div class="flow-container">
        <img src="<?php echo $config->logoURL; ?>" class="logo">
        <h1>Bok.</h1>
        <p class="lead">Registracija</p>
        <p>Za prijavu na natjecanje Znanstvenik u meni natjecatelji i mentori moraju otvoriti korisnički račun.</p>
        <form action="/addUser" method="post" id="signup">
            <input type="hidden" name="csrftoken" value="<?php echo $formtoken; ?>">
            <div class="stepOne">
            <label for="aai">AAI@EduHR email adresa na @skole.hr domeni</label>
            <input type="email" name="aai" id="aai" class="form-control" placeholder="npr. ivana.horvat@skole.hr">
            <p>Tražit ćemo potvrdu ove adrese.</p>
            <div class="aaiHelp" style="display:none;">
                <p class="lead text-danger">Pogrešan AAI@EduHR identitet</p>
                <p>Morate unijeti valjanu @skole.hr email adresu za nastavak.</p>
                <p>Ako je nemate, obratite se administratoru imenika u svojoj ustanovi ili organizaciji natjecanja.</p>
            </div>
            <a class="btn btn-primary" id="aaiValidator" onclick="validateAAI()">Nastavi &rarr;</a>
            </div>
            <div class="stepTwo" style="display:none;">
            <label for="email">Email adresa za kontakt</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="npr. ivana.horvat@gmail.com" required>
            <label for="phone">Broj mobitela za kontakt</label>
            <input type="tel" name="phone" id="phone" class="form-control" placeholder="npr. 095 1000 1234" required>
            <div class="phoneHelp" style="display:none;">
                <p class="lead text-danger">Pogreška</p>
                <p>Morate unijeti valjanu email adresu i broj mobitela za nastavak.</p>
            </div>
            <a class="btn btn-primary" id="continuePersonal" onclick="continueToPersonal()">Nastavi &rarr;</a>
            </div>
        <div class="stepThree" style="display:none;">
            <label for="firstName">Ime</label>
            <input type="text" name="firstName" id="firstName" class="form-control" placeholder="npr. Ivana" required>
            <label for="lastName">Prezime</label>
            <input type="text" name="lastName" id="lastName" class="form-control" placeholder="npr. Horvat" required>
            <label for="password">Lozinka</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Unesite sigurnu lozinku." required>
            <label for="type">Ja sam...</label>
            <select name="type" id="type" class="form-control" required>
            <option value="1">Učenik/učenica</option>
            <option value="2">Mentor(ica)</option>
            </select>
            <div class="dataHelp" style="display:none;">
                <p class="lead text-danger">Pogreška</p>
                <p>Morate unijeti valjano ime i prezime, kao i status u ustanovi.</p>
            </div>
            <a class="btn btn-primary" id="continueSave" onclick="continueSave()" required>Nastavi &rarr;</a>

        </div>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>
        <?php
            include 'js/shared.js'; 
            include 'js/flows.js'; 
        ?>
    </script>

  </body>
</html>