<?php 

/** @var \Ffcms\Templex\Template $self */
/** @var \Ffcms\Templex\Engine\Renderer $this */

$this->title = "Main block";
?>

<?php $this->section('body') ?>

<h1>Body</h1>

<p>Body element. Var is: <?= $self->var ?>

<?php $this->stop() ?>