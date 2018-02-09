<?php
use Ffcms\Templex\Helper\Html\Dom;

/** @var \Ffcms\Templex\Template\Template $this */
/** @var array $properties */
/** @var array|null $fields */
/** @var array|null $buttons */
?>

<form<?= Dom::applyProperties($properties)?>>
<?php if ($fields): ?>
    <?php foreach ($fields as $field): ?>
    <?= $field ?>
    <?php endforeach; ?>
<?php endif; ?>
<?php if ($buttons): ?>
    <?php foreach ($buttons as $button): ?>
    <?= $button ?>
    <?php endforeach; ?>
<?php endif; ?>
</form>