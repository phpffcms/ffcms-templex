<?php
/** @var \Ffcms\Templex\Template $self */
/** @var \Ffcms\Templex\Engine\Renderer $this */
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title><?= $self->title; ?>
</head>
<body>

<?php if($self->getSection('body')): ?>
    <?= $self->getSection('body') ?>
<?php else: ?>
    <p>No content found</p>
<?php endif; ?>

</body>
</html>