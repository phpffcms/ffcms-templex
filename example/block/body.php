<?php

use Ffcms\Templex\Template;

/** @var \Ffcms\Templex\Template $tpl */
/** @var \Ffcms\Templex\Engine\Renderer $this */

/** @var string $var */

$this->title = "Main block";
?>
<!-- css block extend -->
<?php $tpl->section('css', Template::SECTION_APPEND) ?>
<style>
    .someclass {
        padding: 0;
    }
</style>
<?php $tpl->stop() ?>

<!-- main section extend -->
<?php $tpl->section('body') ?>

<p>Variable $var="<?= $var ?>"</p>


<p>~ Table example:</p>
<!-- table example -->
<?= $tpl->table(['class' => 'test-table', 'style' => 'border: 1px solid'])
    ->selectize(0, 'inputCol')
    ->sortable([0 => 'id', 1 => 'colmn1'])
    ->thead(['id' => 'test-head-id'], function(){
        $heads = [];
        for ($i=0;$i<=5;$i++) {
            $heads[] = ['text' => 'col ' . $i, 'properties' => ['style' => 'border-bottom: 1px solid #ddd;']];
        }
        return $heads;
    })->tbody(['class' => 'table-body'], function(){
        $body = [];
        for ($i = 0; $i <= 10; $i++) { // cols
            for ($j = 0; $j <= 5; $j++) { // rows
                $body[$i][$j] = ['text' => 'cell value: ' . $i . ':' . $j, 'properties' => ['style' => 'border-bottom: 1px solid #ddd;']];
            }
        }

        return $body;
    })->display();
?>

<p>~ Listing example:</p>

<?= $tpl->listing('ul', ['class' => 'nav'])
    ->li(['class' => 'nav'], function(){
        $res = [];
        for ($i = 1; $i<=10; $i++) {
            if ($i % 2) {
                $res[] = ['link' => ['controller/action', $i], 'text' => 'link: ' . $i, 'properties' => ['class' => 'nav-item']];
            } else {
                $res[] = ['text' => 'index: ' . $i, 'properties' => ['class' => 'nav-item']];
            }
        }
        return $res;
    })->display(); ?>

<?php $tpl->stop() ?>


<!-- javascript block extend -->
<?php $tpl->section('javascript', Template::SECTION_APPEND) ?>
<script>
    $(document).ready(function(){
        console.log('extend 1');
    });
</script>
<?php $tpl->stop() ?>
