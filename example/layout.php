<?php
/** @var \Ffcms\Templex\Template $tpl */
/** @var \Ffcms\Templex\Engine\Renderer $this */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?= $this->title ?></title>
</head>
<body>

<?php if($tpl->getSection('body')): ?>
    <?= $tpl->getSection('body') ?>
<?php else: ?>
    <p>No content found</p>
<?php endif; ?>

</body>
</html>