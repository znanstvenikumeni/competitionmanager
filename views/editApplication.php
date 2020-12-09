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


                   <h1 class="hugetext">Prijavi se</h1>


               </div>

               <div class="col-md-8">
    <form action="/editApplication" method="post">
    <input type="hidden" name="applicationID" value="<?php new HTMLString($route[1], true); ?>">
    <input type="hidden" name="csrftoken" value="<?php echo $formtoken; ?>">
    <input type="hidden" id="vmssid" name="vmssid" value="<?php new HTMLString($Application->vmssID, true); ?>">
        <input type="hidden" id="pdfid" name="pdfid" value="<?php new HTMLString($Application->pdf, true); ?>">
    <input type="hidden" name="status" value="1">
    <div class="applicationData" data-aos="fade-up">
        <h1  class="morebreathingspace">Podaci o radu</h1>
        <label for="title">Naslov rada</label>
        <input type="text" name="title" id="title" class="form-control" value="<?php new HTMLString($Application->title, true); ?>">
        <label for="description">Opis rada</label>
        <textarea name="description" id="description" class="form-control"><?php new HTMLString($Application->description, true); ?></textarea>
        <label for="category">Kategorija rada</label>
        <select name="category" id="category" class="form-control">
            <?php
                $Data = $Application->data;
            ?>
            <option disabled <?php if(!$Data->category){ echo 'selected'; } ?>>Odaberite...</option>
            <option value="humanisticke" <?php if($Data->category == 'humanisticke'){ echo 'selected'; } ?>>Humanističke znanosti</option>
            <option value="kemija" <?php if($Data->category == 'kemija'){ echo 'selected'; } ?>>Kemija i srodne znanosti</option>
            <option value="fizika" <?php if($Data->category == 'fizika'){ echo 'selected'; } ?>>Fizika i srodne znanosti</option>

            <option value="biomed" <?php if($Data->category == 'biomed'){ echo 'selected'; } ?>>Biologija, medicina i srodne znanosti</option>
            <option value="mathcs" <?php if($Data->category == 'mathcs'){ echo 'selected'; } ?>>Matematika, informatika, elektrotehnika i srodne znanosti</option>
            <option value="ostale" <?php if($Data->category == 'ostale'){ echo 'selected'; } ?>>Ostale znanosti / Interdisciplinaran rad</option>
            <option value="originalresearch" <?php if($Data->category == 'originalresearch'){ echo 'selected'; } ?>>Originalan istraživački rad</option>
        </select>
        
        <label for="drag-drop-area">Video zapis rada</label>
        <?php if($Application->vmssID && ($route[2] ?? '') != 'video'){
            $id = new HTMLString($route[1]);
            $id = $id->print();
            echo '<div>';
            echo '<b>Već ste prenijeli videozapis rada.</b> <a href="/application/'.$id.'/video">Kliknite ovdje da biste ga zamijenili</a>';
            echo '<br><br>Prije zamjene videozapisa, spremite promjene.';
            echo '</div>';
        }
        else echo '<div id="drag-drop-area"></div>';
        ?>
        <hr>
        <?php
        if($Application->pdf && ($route[2] ?? '') != 'pdf'){
            $id = new HTMLString($route[1]);
            $id = $id->print();
            echo '<div>';
            echo '<b>Već ste prenijeli PDF rada.</b> <a href="/application/'.$id.'/pdf">Kliknite ovdje da biste ga zamijenili</a>';
            echo '<br><br>Prije zamjene PDF-a, spremite promjene.';
            echo '</div>';
        }
        else {
            if(($route[2] ?? '') != 'pdf') $stylePDF = 'style="display:none;"';
            else $stylePDF = '';
            echo '<label for="pdfupload-area" '.$stylePDF.' class="pdf" >PDF rada</label>
        <div id="pdfupload-area" class="pdf" '.$stylePDF.'></div>
        <hr>';
        }
        ?>
        <a class="btn btn-primary" role="button" onclick="continueToContestantDataInNewApplication()">Nastavi na natjecatelje &rarr;</a>
    </div>
    <div class="contestantData" style="display:none;" data-aos="fade-up">
        <h1 class="morebreathingspace">Podaci o natjecateljima</h1>
        <b>Natjecatelj 1</b><br>
        <?php if($User->aai == json_decode($Application->teamMembers)->carrier->aai){
            $disabled = '';
            $Competitor = $User;
        }
        else{
            $disabled = 'readonly onclick="return false;"';
            $Competitor = new User($pdo);
            $Competitor->aai = json_decode($Application->teamMembers)->carrier->aai;
            $Competitor->load();
        }
        ?>
        <label for="name1">Ime i prezime</label>
        <input type="text" id="name1" class="form-control" disabled value="<?php new HTMLString($Competitor->firstName.' '.$Competitor->lastName, true); ?>">
        <input type="hidden" name="aai1" value="<?php new HTMLString($Competitor->aai, true); ?>">

        <label for="age1">Dob prvog natjecatelja</label>
        <input type="number" id="age1" class="form-control" name="age1" onkeyup="age('1')" value="<?php new HTMLString(json_decode($Application->teamMembers)->carrier->age, true); ?>" <?php echo $disabled; ?>>
        <div id="agehelp1" style="display:none;">Budući da imaš manje od 16 godina, tvoji roditelji/skrbnici će morati potpisati <a href="/suglasnost">suglasnost</a> da sudjeluješ na natjecanju i poslati je na mbm@educateam.hr.</div>
        <br>
       
        <label for="school1">Škola prvog natjecatelja</label>
        <input type="text" id="school1" name="school1" class="form-control" value="<?php new HTMLString(json_decode($Application->teamMembers)->carrier->school, true); ?>" <?php echo $disabled; ?>>
        <br>

        <br>
        <b>Natjecatelj 2</b><br>
        <p>Preskoči ovaj dio ako radiš samostalno.</p>
         <?php if($User->aai == json_decode($Application->teamMembers)->secondary->aai){
            $disabled = '';
            $Competitor = $User;
        }
        else{
            $disabled = 'readonly onclick="return false;"';
            $Competitor = new User($pdo);
            $Competitor->aai = json_decode($Application->teamMembers)->secondary->aai;
            $Competitor->load();
        }
        ?>
        <label for="name2">Ime i prezime</label>
        <input type="text" id="name2" name="name2" class="form-control" disabled  placeholder="Popunit će se automatski kad uneseš AAI."  value="<?php if($Competitor->firstName ?? '') new HTMLString($Competitor->firstName.' '.$Competitor->lastName, true); ?>">
        <label for="aai2">AAI drugog natjecatelja</label>
        <input type="text" id="aai2" name="aai2" class="form-control" onkeyup="aai(2)" value="<?php new HTMLString(json_decode($Application->teamMembers)->secondary->aai, true); ?>">
        <div id="aaiHelp2" style="display:none;">
            <div class="alert alert-warning"><b>Poslat ćemo email na <span id="aaiData2"></span></b> i pozvati tvog sunatjecatelja da se pridruži ovoj prijavi.</div>  
        </div>
        <label for="age2">Dob drugog natjecatelja</label>
        <input type="number" id="age2" class="form-control" name="age2"  placeholder="Popunit će druga osoba."  onkeyup="age('2')" onkeyup="age('2')" value="<?php new HTMLString(json_decode($Application->teamMembers)->secondary->age, true); ?>" <?php echo $disabled; ?>>
        <div id="agehelp2" style="display:none;">Budući da imaš manje od 16 godina, tvoji roditelji/skrbnici će morati potpisati <a href="/suglasnost">suglasnost</a> da sudjeluješ na natjecanju i poslati je na mbm@educateam.hr.</div>
        <br>
        
        <label for="school2">Škola drugog natjecatelja</label>
        <input type="text" id="school2" name="school2" class="form-control" placeholder="Popunit će druga osoba." value="<?php new HTMLString(json_decode($Application->teamMembers)->secondary->school, true); ?>" <?php echo $disabled; ?>>
        <br>

        <div class="multiCompetitorHelp" style="display:none;">
            <div class="alert alert-warning">Budući da radiš u paru, tvoj sunatjecatelj će se morati pridružiti ovoj prijavi i popuniti podatke o sebi.</div>
        </div>
        <hr>
        <a class="btn btn-primary" role="button" onclick="continueToMentorDataInNewApplication()">Nastavi na mentore &rarr;</a>
    </div>
    <div class="mentorData" style="display:none;" data-aos="fade-up">
        <h1 class="morebreathingspace">Podaci o mentorima</h1>
        <b>Mentor 1</b><br>
        <?php
        $MentorData = json_decode($Application->mentors);
        if($MentorData->first->aai){
            $Mentor1 = new User($pdo);
            $Mentor1->aai = $MentorData->first->aai;
            $Mentor1->load();
        }
        if($MentorData->secondary->aai){
            $Mentor2 = new User($pdo);
            $Mentor2->aai = $MentorData->secondary->aai;
            $Mentor2->load();
        }
        ?>
        <label for="nameMentor1">Ime i prezime prvog mentora</label>
        <input type="text" id="nameMentor1" name="nameMentor1" class="form-control" disabled  placeholder="Popunit će se automatski kad uneseš AAI."  value="<?php if($Mentor1->firstName ?? '') new HTMLString($Mentor1->firstName.' '.$Mentor1->lastName, true); ?>">
        <label for="aaiMentor1">AAI prvog mentora</label>
        <input type="text" name="aaiMentor1" id="aaiMentor1" class="form-control" onkeyup="aai('Mentor1')" value="<?php new HTMLString($MentorData->first->aai, true); ?>">
        <div id="aaiHelpMentor1" style="display:none;">
            <div class="alert alert-warning"><b>Poslat ćemo email na <span id="aaiDataMentor1"></span></b> i pozvati tvog mentora da se pridruži ovoj prijavi.</div>  
        </div>
        <br><br>
        <b>Mentor 2</b><br><p>Preskoči ovaj dio ako imaš jednog mentora.</p>
       <label for="nameMentor2">Ime i prezime drugog mentora</label>
        <input type="text" id="nameMentor2" name="nameMentor2" class="form-control" disabled  placeholder="Popunit će se automatski kad uneseš AAI."  value="<?php if($Mentor2->firstName ?? '') new HTMLString($Mentor2->firstName.' '.$Mentor2->lastName, true); ?>">
        <label for="aaiMentor2">AAI drugog mentora</label>
        <input type="text" name="aaiMentor2" id="aaiMentor2" class="form-control" onkeyup="aai('Mentor2')" value="<?php new HTMLString($MentorData->secondary->aai, true); ?>">
        <div id="aaiHelpMentor2" style="display:none;">
            <div class="alert alert-warning"><b>Poslat ćemo email na <span id="aaiDataMentor2"></span></b> i pozvati tvog mentora da se pridruži ovoj prijavi.</div>  
        </div>
        <div class="form-check">
           <label for="draft" class="form-check-label"> <input type="checkbox" name="draft" id="draft" value="Y" class="form-check-input"> Spremi moju prijavu kao skicu i nemoj je još pokušati predati.</label>
        </div>
        <hr>
        <button class="btn btn-primary">Spremi promjene</button>
        <p><b>Ako odaberete da ne želite spremati skicu, ova prijava će se predati bude li to moguće.</b></p>
    </div>
</div>
    <script src="https://transloadit.edgly.net/releases/uppy/v1.3.0/uppy.min.js"></script>
               <script src="https://code.jquery.com/jquery-3.3.1.min.js" crossorigin="anonymous"></script>
               <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
               <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

               <script>

$('document').ready(function(){
	 <?php if( ! ($Application->vmssID && ($route[2] ?? '') != 'video')){
	 	?>
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
<?php } ?>
		<?php  if(! ($Application->pdf && ($route[2] ?? '') != 'pdf')){
		?>
          var uppy2 = Uppy.Core().use(Uppy.Dashboard, {
              inline: true,
              target: '#pdfupload-area',
              allowMultipleUploads: false,
              restrictions: {
                  maxFileSize: 500000000,
                  maxNumberOfFiles: 1,
                  minNumberOfFiles: 1,
                  allowedFileTypes: [".pdf"]
              },

          }).use(Uppy.XHRUpload, {
              endpoint: '/pdfupload'
          })
          uppy2.on('complete', (result) => {
              $('#pdfid').val(result.successful[0].response.body.filename)
          })
<?php } ?>
});

          $( "#category" ).change(function(){
              if($("#category").val() === 'originalresearch') {
                  $('.pdf').css('display', 'block');
              }
          });
    </script>

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
