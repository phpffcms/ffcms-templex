<?php 

/** @var \Ffcms\Templex\Template $tpl */
/** @var \Ffcms\Templex\Engine\Renderer $this */

/** @var string $var */

$this->title = "Main block";
?>
<!-- css block extend -->
<?php $tpl->section('css', \Ffcms\Templex\Template::SECTION_APPEND) ?>
<style>
    .someclass {
        padding: 0;
    }
</style>
<?php $tpl->stop() ?>

<!-- main section extend -->
<?php $tpl->section('body') ?>

<h1>Body</h1>
<p>Body element. Var is: <?= $var ?>

<?php $tpl->stop() ?>


<!-- javascript block extend -->
<?php $tpl->section('javascript', \Ffcms\Templex\Template::SECTION_APPEND) ?>
<script>
    $(document).ready(function(){
        console.log('extend 1');
    });
</script>
<?php $tpl->stop() ?>
