<?php
use Router\Route;
use Header\Header;

require_once 'app/Routes.php';

$string = Route::run();
Header::run($string);