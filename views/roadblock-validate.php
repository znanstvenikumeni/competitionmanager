<!doctype html>
<html lang="hr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="/frontend/css/compiled.css" />
    <link rel="stylesheet" href="/frontend/css/app.css" />


    <title>Potvrdi svoj broj mobitela &middot; Znanstvenik u meni!</title>
</head>
<body class="frontpage">

<div class="container breather">
    <div class="row">
        <div class="col-md-8">
            <img src="<?php echo $config->logoURL; ?>" class="logo">
            <h1 class="hugetext">Potvrdi broj mobitela</h1>
            <?php if(isset($msg)) echo $msg; ?>
            <p>Za nastavak, trebamo potvrditi tvoj broj mobitela. Ne brini, ovo ćemo raditi samo jednom.</p>
        </div>
        <div class="col-md-4 breather">

            <p><b>Poslali smo kod potvrde na <?php echo $Phone; ?>.</b></p>
            <p>Unesi ga ispod za potvrdu broja mobitela.</p>
            <p><?php echo $Message; ?></p>
            <form action="/phoneroadblock/check" method="post" id="signup" data-aos="fade-up">
                <label for="code">Kod</label>
                <input type="text" name="code" id="code" class="form-control" placeholder="Unesi kod" required>

                <button class="btn btn-primary" type="submit" required>Nastavi &rarr;</button>
                <br><br>
                <small>Ako ti kod ne stigne u roku 5 minuta, osvježi ovu stranicu.</small>
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