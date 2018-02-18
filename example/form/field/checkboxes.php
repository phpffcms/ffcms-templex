<?php

use Ffcms\Templex\Helper\Html\Dom;

/** @var \Ffcms\Templex\Template\Template $this */

// input type=text

/** @var string $label */
/** @var array $properties */
/** @var string|null $helper */
/** @var array $options */
/** @var array|null $value */
/** @var bool $usekey */
/** @var string $fieldname */

$labelProperties = array_merge((array)$labelProperties, ['class' => 'col-md-3']);
?>
<div class="form-group row">
    <?= (new \Ffcms\Templex\Helper\Html\Dom())->label(function() use ($label) {
        return $label;
    }) ?>
    <div class="col-md-9">
        <?php
        foreach ($options as $idx => $option) {
            $isChecked = false;
            if ($usekey) {
                $isChecked = (is_array($value) && in_array($idx, $value));
                $properties['value'] = $idx;
            } else {
                $isChecked = (is_array($value) && in_array($option, $value));
                $properties['value'] = $option;
            }

            if ($isChecked) {
                $properties['checked'] = null;
            } else {
                unset($properties['checked']);
            }
            $properties['id'] = $fieldname . '-' . $idx;

            echo (new Dom())->input(function(){}, $properties); // input type=checkbox
            echo (new Dom())->label(function () use ($option){
                return htmlentities($option, null, 'UTF-8');
            }, ['for' => $fieldname . '-' . $idx]);
        } ?>
        <?php if ($helper): ?>
            <p class="form-text"><?= $helper ?></p>
        <?php endif; ?>
    </div>
</div>