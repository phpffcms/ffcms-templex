<?php
/** @var \Ffcms\Templex\Template\Template $this */

// select*option container

/** @var string $label */
/** @var array $properties */
/** @var string|null $helper */
/** @var array $value */
/** @var bool $keys */
/** @var iterable $options */

$labelProperties = array_merge((array)$labelProperties, ['class' => 'col-md-3']);
?>
<div class="form-group row">
    <?= (new \Ffcms\Templex\Helper\Html\Dom())->label(function() use ($label) {
        return $label;
    }, ['for' => $properties['id']]) ?>
    <div class="col-md-9">
        <?= (new \Ffcms\Templex\Helper\Html\Dom())->select(function() use ($value, $options, $keys) {
            $opthtml = null;
            foreach ($options as $key => $val) {
                $optpr = [];
                $optpr['value'] = ($keys ? $key : $val);
                if (in_array($optpr['value'], $value)) {
                    $optpr['selected'] = null;
                }

                $opthtml .= (new \Ffcms\Templex\Helper\Html\Dom())->option(function() use ($val) {
                    return htmlentities($val, null, 'UTF-8');
                }, $optpr);
            }

            return $opthtml;
        }, $properties) ?>
        <?php if ($helper): ?>
            <p class="form-text"><?= $helper ?></p>
        <?php endif; ?>
    </div>
</div>