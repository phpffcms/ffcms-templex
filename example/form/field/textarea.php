<?php
/** @var \Ffcms\Templex\Template\Template $this */

// textarea container

/** @var string $label */
/** @var array $properties */
/** @var string|null $helper */
/** @var string|null $value */

$labelProperties = array_merge((array)$labelProperties, ['class' => 'col-md-3']);
?>
<div class="form-group row">
    <?= (new \Ffcms\Templex\Helper\Html\Dom())->label(function() use ($label) {
        return $label;
    }, ['for' => $properties['id']]) ?>
    <div class="col-md-9">
        <?= (new \Ffcms\Templex\Helper\Html\Dom())->textarea(function() use ($value){
            return $value;
        }, $properties) ?>
        <?php if ($helper): ?>
            <p class="form-text"><?= $helper ?></p>
        <?php endif; ?>
    </div>
</div>