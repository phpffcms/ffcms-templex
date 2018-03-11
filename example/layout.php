<?php
/** @var Ffcms\Templex\Template\Template $this */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?= $title ?? 'no title'; ?></title>
    <?= $this->section('css') ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <style>
        /** @todo: implement in framework features */
        @media (min-width: 768px) {
            label.control-label {
                padding-top: 7px;
                text-align: right;
                font-weight: bolder;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <?php if($this->section('body')): ?>
        <?= $this->section('body') ?>
    <?php else: ?>
        <p>No content found</p>
    <?php endif; ?>
</div>

<?= $this->section('javascript') ?>

</body>
</html>