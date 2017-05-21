<?php
use Viewer\Viewer;

$data = array('It', 'is', 'data', 'sent', 'to', 'the', 'view');
Viewer::show('helloworld', $data);

