<html lang="hr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Natječi se u komunikaciji znanosti. Pokaži što možeš.">
    <meta name="author" content="Organizacija natjecanja Znanstvenik u meni">
    <meta name="generator" content="">
    <title>Prijavljeni radovi · Znanstvenik u meni</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <style>
        <?php echo file_get_contents('frontend/css/compiled.css'); ?>

    </style>
    <link rel="stylesheet" href="https://cdn.plyr.io/3.5.6/plyr.css" />
    <script src="https://cdn.plyr.io/3.5.6/plyr.polyfilled.js"></script>
<body class="frontpage">

<div class="container">
    <div class="navtoggle">
        <a href="/">
            <img src="https://znanstvenikumeni.org/wp-content/uploads/2019/05/zum-logo-black-w.png" height="60" alt="Together for Knowledge" class="logo">
        </a>
        <div class="navli"><a data-toggle="modal"  data-target="#mobileNav">Izbornik</a></div>
    </div>
    <nav class="frontpagenav">
        <ul class="navul">
            <li class="navli-img">
                <a href="/">
                    <img src="https://znanstvenikumeni.org/wp-content/uploads/2019/05/zum-logo-black-w.png" height="60" alt="Together for Knowledge" class="logo">
                </a>
            </li>
            <li class="navli">
                <a href="https://znanstvenikumeni.org">&larr; Web stranica natjecanja</a>
            </li>
            <li class="navli">
                <a href="/public">Prijavljeni radovi</a>
            </li>
            <li class="navli">
                <a href="/accounts/signin">Prijavi se</a>
            </li>
        </ul>
    </nav>
</div>
<main class="container">
    <section class="introduction">
        <div id="app">
            <?php

            $vmssID = $Application->vmssID;
            $vmssBase = $config->vmssBaseURL;
            $requestEndpoint = $vmssBase . "/video/" . $vmssID;
            $response = file_get_contents($requestEndpoint);
            $response = json_decode($response);
            $response->video->files = json_decode($response->video->files);
            if(!$Application->data->hideVideo) {
                ?>

                <video id="player" playsinline controls
                       data-plyr-config='{ "quality": { default: 480, options: [1080, 720, 480, 360] } }'>
                    <?php if($response->video->files->mp4->{'1080p'}) {?> <source src="<?php echo $vmssBase . '/' . $response->video->files->mp4->{'1080p'}; ?>"
                            size="1080" type="video/mp4"/><?php } ?>
                    <?php if($response->video->files->mp4->{'720p'}) {?><source src="<?php echo $vmssBase . '/' . $response->video->files->mp4->{'720p'}; ?>" size="720"
                            type="video/mp4"/><?php } ?>
                   <?php if($response->video->files->mp4->{'480p'}) {?> <source src="<?php echo $vmssBase . '/' . $response->video->files->mp4->{'480p'}; ?>" size="480"
                            type="video/mp4"/><?php } ?>
                    <?php if($response->video->files->mp4->{'360p'}) {?><source src="<?php echo $vmssBase . '/' . $response->video->files->mp4->{'360p'}; ?>" size="360"
                            type="video/mp4"/><?php } ?>

                    <?php if($response->video->files->webm->{'1080p'}) {?><source src="<?php echo $vmssBase . '/' . $response->video->files->webm->{'1080p'}; ?>"
                            size="1080" type="video/webm"/><?php } ?>
                    <?php if($response->video->files->webm->{'720p'}) {?><source src="<?php echo $vmssBase . '/' . $response->video->files->webm->{'720p'}; ?>"
                            size="720" type="video/webm"/><?php } ?>
                    <?php if($response->video->files->webm->{'480p'}) {?><source src="<?php echo $vmssBase . '/' . $response->video->files->webm->{'480p'}; ?>"
                            size="480" type="video/webm"/><?php } ?>
                    <?php if($response->video->files->webm->{'360p'}) {?><source src="<?php echo $vmssBase . '/' . $response->video->files->webm->{'360p'}; ?>"
                            size="360" type="video/webm"/><?php } ?>

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
            <p>Godina prijave: <?php new HTMLString($Application->year, true); ?> &middot; Oznaka kategorije: <?php  new HTMLString($Application->data->category, true); ?>
            <?php if($Application->data->category == 'originalresearch'){
                ?>
                &middot; <a href="/cdn/<?php new HTMLString($Application->data->pdf, true); ?>.pdf">PDF rada</a>
            <?php
            }
            ?>
            </p>
        </div>
        </div>
        <br><br><br><br>
        <style>

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
