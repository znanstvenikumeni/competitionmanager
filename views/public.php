<!doctype html>
<html lang="hr">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <title>Prijavljeni radovi &middot; Znanstvenik u meni</title>
  </head>
  <body>
	<nav class="navbar navbar-light bg-light card-2">
	  <a class="navbar-brand" href="/public">Znanstvenik u meni!</a>
	  
	 
	</nav>
	<div class="app-container">
		<div class="container">
			<h2 class="screen-title">Prijavljeni radovi</h2>
			<p class="subtitle screen-explanation">Radovi su sortirani po redu prijave.</p>
			<div class="row">
				<?php foreach($Applications as $Application){
				?>
				<div class="col-lg-4">
					<a href="/public/video/<?php echo $Application->id; ?>" class="text-decoration-none">
						<div class="card card-1">
							<h2 class="card-title"><?php new HTMLString($Application->title, true); ?></h2>
							<p class="card-content"><?php new HTMLString($Application->description, true); ?></p>
							<p class="metadata">Nositelj rada: <?php new HTMLString($Application->teamMembers->carrier->name, true); ?>, <?php new HTMLString($Application->teamMembers->carrier->school, true);  ?></p></div>
				<?php
				}
				?>
				</div>
			</div>
		</div>
	</div>
	<nav class="navbar fixed-bottom navbar-light bg-light card-2">
  <a class="navbar-link-bottom" href="/public"><i class="material-icons">
video_library
</i></a>
  
  <a class="navbar-link-bottom" href="https://znanstvenikumeni.org"><i class="material-icons">
public
</i></a>
</nav>
	<style>
		a:link, a:visited, a:hover, a:focus{
			color: #343a40;
		}
		.card{
			padding: 16px;
		}

.card-1 {
  box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
  transition: all 0.3s cubic-bezier(.25,.8,.25,1);
}

.card-1:hover {
  box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
}

.card-2 {
  box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
}

.card-3 {
  box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);
}

.card-4 {
  box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
}

.card-5 {
  box-shadow: 0 19px 38px rgba(0,0,0,0.30), 0 15px 12px rgba(0,0,0,0.22);
}

	</style>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>