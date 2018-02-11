<?php
/** @var Ffcms\Templex\Template\Template $this */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?= $title ?? 'no title'; ?></title>
    <?= $this->section('css') ?>
</head>
<body>

<?php if($this->section('body')): ?>
    <?= $this->section('body') ?>
<?php else: ?>
    <p>No content found</p>
<?php endif; ?>

<?= $this->section('javascript') ?>

</body>
</html>