<?php

require __DIR__ . './vendor/autoload.php';

$tpl = new \Ffcms\Templex\Template(__DIR__ . '/example');

// render single template and save all ->section() in $tpl instance
$tpl->render('block/body', ['var' => 'this is value']);


// render layout. use $tpl->section() of $html item
echo $tpl->render('layout');