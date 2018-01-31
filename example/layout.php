<?php
/** @var \Ffcms\Templex\Template $tpl */
/** @var \Ffcms\Templex\Engine\Renderer $this */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?= $this->title ?></title>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <?= $tpl->getSection('css') ?>
</head>
<body>

<?php if($tpl->getSection('body')): ?>
    <?= $tpl->getSection('body') ?>
<?php else: ?>
    <p>No content found</p>
<?php endif; ?>

<!-- table example -->
<?php
echo $tpl->table(['class' => 'test-table', 'style' => 'border: 1px solid'])
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

<?= $tpl->getSection('javascript') ?>

</body>
</html>