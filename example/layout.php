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
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="http://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
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

<!--<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#">Disabled</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown01">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link">Register</a>
                </li>
            </ul>
        </div>
    </div>
</nav>-->

<?php
    echo $this->bootstrap()->navbar(['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top'], true) // (properties, container=false)
    ->id('my-navbar')
    ->brand(['text' => 'My website'])
    ->menu('left', ['text' => 'Item #1', 'link' => ['controller/action']])
    ->menu('left', ['text' => 'Item #2', 'link' => ['controller/action']])
    ->menu('left', ['text' => 'Item #3', 'link' => ['controller/action']])
    ->menu('left', ['text' => 'Item #4', 'dropdown' => [
        ['text' => 'Item #4-1', 'link' => ['con/act1'], 'class' => 'dropdown-item'],
        ['text' => 'Item #4-2', 'link' => ['sdf/act2'], 'class' => 'dropdown-item']
    ]])
    ->menu('right', ['text' => 'Item #1', 'link' => ['controller/action']])
    ->menu('right', ['text' => 'Item #2', 'dropdown' => [
        ['text' => 'Item #2-1', 'link' => ['con/act1'], 'class' => 'dropdown-item'],
        ['text' => 'Item #2-2', 'link' => ['sdf/act2'], 'class' => 'dropdown-item']
    ]])
    ->display()
?>

<div class="container" style="margin-top: 80px;">
    <?php if($this->section('body')): ?>
        <?= $this->section('body') ?>
    <?php else: ?>
        <p>No content found</p>
    <?php endif; ?>
</div>

<?= $this->section('javascript') ?>

<script src="http://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>