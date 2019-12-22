<!doctype html>
<html lang="hr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Pregled radova &middot; Znanstvenik u meni</title>
  </head>
  <body>
    <h1>Pregled radova</h1>

	<?php
		foreach($Applications as $Application){
			if($Application->status == 2 && $Application->year == $config->organisationalYear) {
				var_dump($Application);
				echo '<div class="card">';
				echo '<div class="card-title">'.htmlspecialchars($Application->title).'</div>';
				echo '<div class="card-description">'.htmlspecialchars($Application->description).'</div>';
				echo '<div class="card-mentors">Mentori: <ul>';
				$Mentors = $Application->mentors;
				$Mentors = json_decode($Mentors);
				foreach($Mentors as $Mentor){
					echo '<li> '.$Mentor->name.'</li>';
				}
				echo '</ul></div>';
				echo '<div class="card-mentors">Autori rada: <ul>';
				$Members = $Application->teamMembers;
				$Members = json_decode($Members);
				foreach($Members as $Member){
					$User = new User($pdo);
			        $User->aai = $Member->aai;
			        $User->load();
			        $publicData['name'] = $User->firstName.' '.$User->lastName;
					echo '<li>'.$publicData['name'].'</li>';
				}
				$VMSSid = $Application->vmssID;
				$VMSSResponse = file_get_contents($config->vmssBaseURL.'/video/'.$VMSSid);
				var_dump($VMSSResponse); 
				echo '<video id="player" playsinline controls>
					    <source src="/path/to/video.mp4" type="video/mp4" />
					    <source src="/path/to/video.webm" type="video/webm" />
					</video>';
				echo '</ul></div>';
			}
		}
	?>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
