<!doctype html>
<html lang="hr">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <title>Video &middot; Znanstvenik u meni</title>
    <link rel="stylesheet" href="https://cdn.plyr.io/3.5.6/plyr.css" />
    <script src="https://cdn.plyr.io/3.5.6/plyr.polyfilled.js"></script>

  </head>
  <body>
	<nav class="navbar navbar-dark bg-light card-2">
        <a class="navbar-brand" href="/public"><img src="https://znanstvenikumeni.org/wp-content/uploads/2019/05/zum-logo-black-w.png" style="max-height: 64px;" ?></a>
	  
	 
	</nav>
	<div class="app-container">
		<div class="container">
			<?php
            $Application->data = json_decode($Application->data);

                $vmssID = $Application->vmssID;
                $vmssBase = $config->vmssBaseURL;
                $requestEndpoint = $vmssBase . "/video/" . $vmssID;
                $response = file_get_contents($requestEndpoint);
                $response = json_decode($response);
                $response->video->files = json_decode($response->video->files);
                if(!$Application->data->hideVideo) {
                    ?>

                    <video id="player" playsinline controls
                           data-plyr-config='{ "quality": { default: 1080, options: [1080, 720, 480, 360] } }'>
                        <source src="<?php echo $vmssBase . '/' . $response->video->files->mp4->{'1080p'}; ?>"
                                size="1080" type="video/mp4"/>
                        <source src="<?php echo $vmssBase . '/' . $response->video->files->mp4->{'720p'}; ?>" size="720"
                                type="video/mp4"/>
                        <source src="<?php echo $vmssBase . '/' . $response->video->files->mp4->{'480p'}; ?>" size="480"
                                type="video/mp4"/>
                        <source src="<?php echo $vmssBase . '/' . $response->video->files->mp4->{'360p'}; ?>" size="360"
                                type="video/mp4"/>

                        <source src="<?php echo $vmssBase . '/' . $response->video->files->webm->{'1080p'}; ?>"
                                size="1080" type="video/webm"/>
                        <source src="<?php echo $vmssBase . '/' . $response->video->files->webm->{'720p'}; ?>"
                                size="720" type="video/webm"/>
                        <source src="<?php echo $vmssBase . '/' . $response->video->files->webm->{'480p'}; ?>"
                                size="480" type="video/webm"/>
                        <source src="<?php echo $vmssBase . '/' . $response->video->files->webm->{'360p'}; ?>"
                                size="360" type="video/webm"/>

                    </video>
                    <?php
                }
                else{
                    ?>
                    <div class="alert alert-warning"><?php new HTMLString($Application->data->hideVideo, true);?></div>
            <?php

                }
            ?>
	<h2 class="video-title"><?php new HTMLString($Application->title, true); ?></h2>
            <?php
            if(isset($Application->data->notice)){
                ?>
            <div class="alert alert-danger"><?php new HTMLString($Application->data->notice, true); ?></div>
            <?php
            }
            ?>
	<p class="video-description"><?php new HTMLString($Application->description, true); ?></p>
	<hr>

	<b>Podaci rada</b>
	<p class="video-metadata">Sudionici rada: <ul>
		<?php

		$Application->teamMembers = json_decode($Application->teamMembers);
		 foreach($Application->teamMembers as $Member){
			echo '<li>';
			$UserFactory = new User($pdo);
			$UserFactory->aai = $Member->aai;
			$UserFactory->load();
			new HTMLString($UserFactory->firstName.' '.$UserFactory->lastName, true);
			echo ', ';
			new HTMLString($Member->school, true);
			echo '</li>';
		}
		?>
	</ul>
	<p>Mentori rada:</p> <ul>
		<?php
		$Application->mentors = json_decode($Application->mentors);
		foreach($Application->mentors as $Mentor){
			echo '<li>';
			new HTMLString($Mentor->name, true);
			echo '</li>';
		}
		?>
	</ul>
	<p>Godina prijave: <?php new HTMLString($Application->year, true); ?> &middot; Oznaka kategorije: <?php  new HTMLString($Application->data->category, true); ?></p>
		</div>
	</div>
	<br><br><br><br>
	<nav class="navbar fixed-bottom navbar-dark bg-light card-2">
  <a class="navbar-link-bottom" href="/public"><i class="material-icons">
video_library
</i></a>
 
  <a class="navbar-link-bottom" href="https://znanstvenikumeni.org"><i class="material-icons">
public
</i></a>
</nav>
	<style>
	   <style>
                    <?php echo file_get_contents(__DIR__.'/css/public.css'); ?>

                </style>
	</style>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script>
    	const player = new Plyr('#player');
	</script>

  </body>
</html>