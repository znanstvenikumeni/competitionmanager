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
	<nav class="navbar navbar-dark bg-light card-2">
		<a class="navbar-brand" href="/public"><img src="https://znanstvenikumeni.org/wp-content/uploads/2019/05/zum-logo-black-w.png" style="max-height: 64px;" ?></a>


	</nav>
	<div class="app-container">
		<div class="container">
			<?php 
			/** static implementation of new UI features until we've got a real backend running this */
			?>
			<h2 class="screen-title">
				Najbolji na završnici
			</h2>
			<p>Video zapisi prijava radova koji su pobijedili na završnici.</p>
			<div class="row">
				<div class="col-md-4">
					<a href="/public/video/4411055" class="text-decoration-none">
						<div class="card card-1">
							<img src="https://vmss.znanstvenikumeni.org/uploads/525023c9a900a7e959fbf4a41db7b85f60fc3df6d2fedb8603bdab4d8cb08ee6f9c9a2e8aa6303eff81dc561e3f264aaa2ba3950f8dc98afbb7048ec84441f11_thumb.jpg" class="card-img-top">
							<h2 class="card-title">1. Spavanje</h2>
							<p class="card-content">U na&scaron;em video uratku govorimo &scaron;to se doga&dstrok;a s na&scaron;im tijelom dok spavamo&comma; ali i razlozima za&scaron;to je va&zcaron;no spavati&period;</p>
							<p class="metadata">Filip Gajić, Tanja Bertalanić</p>
						</div></a>
					</div>

					<div class="col-md-4">
						<a href="/public/video/4411058" class="text-decoration-none">
							<div class="card card-1">
								<img src="https://vmss.znanstvenikumeni.org/uploads/4edcfe15e1085147dc0607b67633317733c89b2f7ec1ad628745fd49dfd4ad3b55af8f13194beae9e054a8155c6da0388f9fbd32120dbdd36a10acb393fbd692_thumb.jpg" class="card-img-top">
								<h2 class="card-title">2. Tranfuzija i darivanje krvi </h2>
								<p class="card-content">U ovome smo radu ponajprije istra&zcaron;ili &scaron;to je krv i za&scaron;to je bitna za na&scaron; organizam&period;</p>
								<p class="metadata">Lucija Ćavar</p>
							</div>
						</a>
					</div>

					<div class="col-md-4">
						<a href="/public/video/4411045" class="text-decoration-none">
							<div class="card card-1">
								<img src="https://vmss.znanstvenikumeni.org/uploads/1f448265c999834dd4edcd74477c2cb37a90d8edbb241d4fd97adc673085209f9de0e99daee65e7535a0c68f02bbbafdc78ea5d7030c9086388475561d1653e1_thumb.jpg" class="card-img-top">
								<h2 class="card-title">3. Kalendar</h2>
								<p class="card-content">Povijest izrade kalendara i izra&ccaron;un</p>
								<p class="metadata">Tibor Birko, Filip Crnoja</p>
							</div></a>
						</div>
					</div>
				</div>
			</div>
			<div class="app-container">
				<div class="container">
					<h2 class="screen-title">Prijavljeni radovi</h2>
					<p class="subtitle screen-explanation">Radovi su sortirani po redu prijave odozgo prema dolje, s lijeva na desno.</p>
					<div class="card-columns">
						<?php
						foreach($Applications as $Application){
							if($Application->selfHide ?? null) continue;
							if(!$Application->vmssID ?? null) continue;
							$vmssID = $Application->vmssID;
							$vmssBase = $config->vmssBaseURL;
							$requestEndpoint = $vmssBase . "/video/" . $vmssID;
							$response = file_get_contents($requestEndpoint);
							$response = json_decode($response);
							$response->video->data = json_decode($response->video->data);

							?>

							<a href="/public/video/<?php echo $Application->id; ?>" class="text-decoration-none">
								<div class="card card-1">
									<img src="<?php echo $vmssBase.'/'.$response->video->data->thumb; ?>" class="card-img-top">
									<h2 class="card-title"><?php new HTMLString($Application->title, true); ?></h2>
									<p class="card-content"><?php new HTMLString($Application->description, true); ?></p>
									<p class="metadata">Nositelj rada: <?php new HTMLString($Application->teamMembers->carrier->name, true); ?>, <?php new HTMLString($Application->teamMembers->carrier->school, true);  ?></p>
								</div></a>
								<?php
							}
							?>
						</div>
					</div>
				</div>


				<div class="spacer"><hr></div>
				<nav class="navbar fixed-bottom navbar-dark bg-light card-2">
					<a class="navbar-link-bottom" href="/public"><i class="material-icons">
						video_library
					</i></a>

					<a class="navbar-link-bottom" href="https://znanstvenikumeni.org"><i class="material-icons">
						public
					</i></a>
				</nav>
				<style>
					<?php echo file_get_contents(__DIR__.'/css/public.css'); ?>

				</style>
				<!-- Optional JavaScript -->
				<!-- jQuery first, then Popper.js, then Bootstrap JS -->
				<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
				<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
				<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
			</body>
			</html>