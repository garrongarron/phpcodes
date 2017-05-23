<?php
use Router\Route;
use Header\Header;
use MiddleWare\MiddleWare;

require_once 'app/Routes.php';

$string = Route::run();
Header::run($string);
MiddleWare::after();