<?php

$loader = require __DIR__ . '/vendor/autoload.php';
$loader->add('Ffcms\\', __DIR__ . '/vendor/phpffcms/ffcms-templex/src');

$tpl = new \Ffcms\Templex\Engine(__DIR__ . '/example');
$tpl->loadExtensions([new \Ffcms\Templex\Helper\Html\Table(), new \Ffcms\Templex\Helper\Html\Listing()]);

echo $tpl->render('block/body', ['test' => 'some value']);