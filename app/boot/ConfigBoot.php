<?php
$config = file_get_contents('../storage/config.json');
$config = json_decode($config);
$keys = file_get_contents('../storage/keys.json');
$keys = json_decode($keys);
