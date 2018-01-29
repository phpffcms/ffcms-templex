<?php 

/** @var \Ffcms\Templex\Template $tpl */
/** @var \Ffcms\Templex\Engine\Renderer $this */

/** @var string $var */

$this->title = "Main block";
?>

<?php $tpl->section('body') ?>

    <h1>Body</h1>

    <p>Body element. Var is: <?= $var ?>

    <!-- table example -->
    <?= $tpl->table(['class' => 'table table-striped'])
        ->thead(['id' => 'table-one'], function(){
            for ($i=0;$i<=5;$i++) {
                yield ['text' => 'col ' . $i];
            }
        })->display(); ?>

<?php $tpl->stop() ?>