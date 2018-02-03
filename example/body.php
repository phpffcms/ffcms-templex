<?php

/** @var Ffcms\Templex\Template\Template $this */

$this->layout('layout', ['title' => 'lol kek']);

?>
<?php $this->start('body') ?>

<h1>Hello world</h1>
<?php $this->insert('block/depend') ?>

<p>~ Table example:</p>
<?= $this->table(['class' => 'test-table', 'style' => 'border: 1px solid'])
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
<?= $this->listing('ul', ['class' => 'nav'])
    ->li(['class' => 'nav-item'], [
        ['text' => 'Item #1'],
        ['text' => 'Item #2 with properties', 'properties' => ['class' => 'nav-text']],
        ['text' => 'Link #1', 'link' => ['controller/action', ['id' => 1]], 'properties' => ['class' => 'nav-item']]
    ])->display(); ?>

<?php $this->end(); ?>

<?php $this->push('javascript') ?>
<script>console.log('some javascript render');</script>
<?php $this->end(); ?>