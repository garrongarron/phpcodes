<?php
use Header\Header;
 
Header::set('Content-Type: application/json');
Header::set('Access-Control-Allow-Origin: *');
echo  json_encode($data);