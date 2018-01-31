<?php 

/** @var \Ffcms\Templex\Template $tpl */
/** @var \Ffcms\Templex\Engine\Renderer $this */

/** @var string $var */

$this->title = "Main block";
?>

<?php $tpl->section('body') ?>

    <h1>Body</h1>

    <p>Body element. Var is: <?= $var ?>

<?php $tpl->stop() ?>