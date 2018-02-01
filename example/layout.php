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

<?= $tpl->getSection('javascript') ?>

</body>
</html>