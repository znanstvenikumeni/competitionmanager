<?php
header('Access-Control-Allow-Origin: '.$config->vmssBaseURL);
?>
<!doctype html>
<html lang="hr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <?php 
        echo '<style>';
        include 'css/shared.css'; 
        include 'css/app.css'; 
        echo '</style>'; 
    ?>
    
    <title>Nova prijava &middot; Znanstvenik u meni!</title>
    <link href="https://transloadit.edgly.net/releases/uppy/v1.3.0/uppy.min.css" rel="stylesheet">

  </head>
  <body>
<nav class="navbar navbar-dark bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="/">Znanstvenik u meni!</a>
  <ul class="navbar-nav px-3">
    <li class="nav-item text-nowrap">
      <a class="nav-link" href="/accounts/signout">Odjava (<?php new HTMLString($User->firstName.' '.$User->lastName, true); ?>)</a>
    </li>
  </ul>
</nav>
<div class="container-fluid">
    <form action="/addApplication" method="post">
    <input type="hidden" name="csrftoken" value="<?php echo $formtoken; ?>">
    <input type="hidden" id="vmssid" name="vmssid">
    <h1>Podaci o radu</h1>
    <label for="title">Naslov rada</label>
    <input type="text" name="title" id="title" class="form-control">
    <label for="description">Opis rada</label>
    <textarea name="description" id="description" class="form-control"></textarea>
    <label for="category">Kategorija rada</label>
    <select name="category" id="category" class="form-control">
        <option disabled selected>Odaberite...</option>
        <option value="humanisticke">Humanističke znanosti</option>
        <option value="kemija">Kemija i srodne znanosti</option>
        <option value="biomed">Biologija, medicina i srodne znanosti</option>
        <option value="mathcs">Matematika, informatika, elektrotehnika i srodne znanosti</option>
        <option value="ostale">Ostale znanosti / Interdisciplinaran rad</option>
    </select>
    <label for="drag-drop-area">Video zapis rada</label>
    <div id="drag-drop-area"></div>
    <h1>Podaci o natjecateljima</h1>
    <b>Natjecatelj 1</b><br>
    <label for="name1">Ime i prezime</label>
    <input type="text" id="name1" class="form-control" disabled value="<?php new HTMLString($User->firstName.' '.$User->lastName, true); ?>">
    <label for="age1">Dob prvog natjecatelja</label>
    <input type="number" id="age1" class="form-control" name="age1" onkeypress="age('1')">
    <div id="agehelp1" style="display:none;">Budući da imaš manje od 16 godina, tvoji roditelji/skrbnici će morati potpisati <a href="/suglasnost">suglasnost</a> da sudjeluješ na natjecanju i poslati je na mbm@educateam.hr.</div>
    <br>
    <div class="form-check">
        <input type="checkbox" name="zsem" id="zsem" value="Y" class="form-check-input"><label for="zsem" class="form-check-label">Suglasan/a sam
da se moja e-mail adresa podijeli sa Zagrebačkom školom ekonomije i managementa
u svrhe ostvarenja nagrade budem li nagrađen/a na natjecanju.</label>
    </div>
    <label for="school1">Škola prvog natjecatelja</label>
    <input type="text" id="school1" name="school1" class="form-control">
    <br>
    <b>Natjecatelj 2</b><br>
    <p>Preskoči ovaj dio ako radiš samostalno.</p>
    <label for="name2">Ime i prezime</label>
    <input type="text" id="name2" class="form-control">
    <label for="aai2">AAI drugog natjecatelja</label>
    <input type="text" id="aai2" class="form-control">
    <label for="age2">Dob drugog natjecatelja</label>
    <input type="number" id="age2" class="form-control" name="age1" onkeypress="age('2')">
    <div id="agehelp2" style="display:none;">Budući da imaš manje od 16 godina, tvoji roditelji/skrbnici će morati potpisati <a href="/suglasnost">suglasnost</a> da sudjeluješ na natjecanju i poslati je na mbm@educateam.hr.</div>
    <br>
    <div class="form-check">
        <input type="checkbox" name="zsem" id="zsem" value="Y" class="form-check-input"><label for="zsem" class="form-check-label">Suglasan/a sam
da se moja e-mail adresa podijeli sa Zagrebačkom školom ekonomije i managementa
u svrhe ostvarenja nagrade budem li nagrađen/a na natjecanju.</label>
    </div>
    <label for="school2">Škola drugog natjecatelja</label>
    <input type="text" id="school2" name="school2" class="form-control">
    <br>
    <h1>Podaci o mentorima</h1>
    <label for="aaiMentor1">AAI prvog mentora</label>
    <input type="text" name="aaiMentor1" class="form-control">
    <label for="aaiMentor2">AAI drugog mentora</label>
    <input type="text" name="aaiMentor2" class="form-control">
    <p>Tvoj mentor odnosno mentori moraju imati otvoren korisnički račun i popunjen profil u ovoj aplikaciji prije nego što predaš prijavu.</p>
</div>
    <script src="https://transloadit.edgly.net/releases/uppy/v1.3.0/uppy.min.js"></script>
    <script>

          var uppy = Uppy.Core().use(Uppy.Dashboard, {
          inline: true,
          target: '#drag-drop-area',
          allowMultipleUploads: false,
          restrictions: {
            maxFileSize: 500000000,
            maxNumberOfFiles: 1,
            minNumberOfFiles: 1,
            allowedFileTypes: [".webm", ".mkv", ".avi", ".wmv", ".mov", ".mp4", ".m4v", ".mpg", ".mp2", ".mpeg", ".mpv", ".m2v", ".m4v"]
        },

        }).use(Uppy.XHRUpload, {
             endpoint: '<?php echo $EndpointURL; ?>'
})
uppy.on('complete', (result) => {
        $('#vmssid').val(result.successful[0].response.body.id)
      })


      
    </script>
   <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>
    function age(comp){
        if($('#age'+comp).val()<16){
            $('#agehelp'+comp).css('display','block')
        }
        else{
            $('#agehelp'+comp).css('display','none')
        }
    }
        <?php
            include 'js/shared.js'; 
        ?>
    </script>

  </body>
</html>