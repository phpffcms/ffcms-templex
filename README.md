# Templex
Templex - native php template system build on top of php plates framework: [thephpleague/plates](https://github.com/thephpleague/plates). Templex used in phpffcms as a basic template engine with pack of html helpers that makes posible fast build html-code output.

## Installation
Using composer: 
```bash
composer require phpffcms/ffcms-templex
```
## Usage
To see complete examples please take a look on ```/example``` directory. 

### Initialize
Here you can see a simple example of template system initialization:
```php
$loader = require __DIR__ . '/vendor/autoload.php';

// initialize template engine
$tpl = new \Ffcms\Templex\Engine(__DIR__ . '/tpl');
// load default ffcms html helpers as extensions
$tpl->loadDefaultExtensions();

// render /tpl/block.body.php example
echo $tpl->render('block/body', ['test' => 'some value']);
```

### Use layouts
The major feature of any template system is a layouts. Plates provide a complete feature to use layouts in templating:
```php
$this->layout('path/to/file', ['var' => 'value']);
```

### Sections extend
Section allow you to make dynamic templates with block override features. To understand how section extending works take a look at simple example:

```/tpl/block/body.php```
```php
<?php
$this->layout('layout', ['title' => 'My first title']);
?>

<?php $this->start('body') ?>
<h1>Hello, world!</h1>
<p>This is my first template</p>
<?php $this->stop(); ?>
```
and ```/tpl/layout.php```:
```php
<doctype html>
<html lang="en">
<head>
<title><?= $title ?></title>
<body>
<?= $this->section('body'); ?>
</body>
</head>
</html>
```
After initialization and executing ```$tpl->render('block/body')``` the output will be:
```html
<doctype html>
<html lang="en">
<head>
<title>My first title</title>
<body>
<h1>Hello, world!</h1>
<p>This is my first template</p>
</body>
</head>
</html>
```
The ```body``` section in ```layout.php``` after rendering accept the result from ```start('body')``` ... ```stop()``` section. You can make a multiple extend by section using ```->push('name')``` instead of ```->start('name')```.

### Html helpers
Templex provide simple and clear php-based html code generator. The main part of developing process in any application is to build html output of tables, listing, grids and forms.

In this section you will see the main features of html code generator helpers. 

#### Listing
To draw a simple listing you should use ```$this->listing('type', [properties])``` and then ```li([items])``` construction in template files. 

Complete example:
```php
echo $this->listing('ul', ['class' => 'my-listing'])
    ->li([
        ['text' => 'Text item'],
        ['text' => 'Google link', 'link' => ['https://google.com']],
        ['text' => 'Local link', 'link' => ['controller/action', ['id' => 1]], 'properties' => ['class' => 'li-item']]
    ])
    ->display();
````
will give output:
```html
<ul class="my-listing">
  <li>Text item</li>
  <li><a href="https://google.com">Google link</a></li>
  <li class="li-item"><a href="http://localhost/controller/action/1">Local link</a></li>
</ul>
```
