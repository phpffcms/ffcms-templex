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
To draw a simple listing you should use ```$this->listing('type', [properties])``` and then call ```li([items], [properties])``` to add each one ```<li></li>``` element. 

Listing can be used inline or as named factory object. Inline object usage are prefered for pre-defined elements that should be displayed "right here":
```php
echo $this->listing('ul')
    ->li('item 1')
    ...
    ->li('item n')
    ->display()
```
Named object can be defined for more complex usage. For example - add elements of listing in cycle:
```php
$listing = $this->listing('ul');

for ($i = 0; $i < 100; $i++) {
    $listing->li('Item #' . $i);
}

echo $listing->display();
```

Complete example with some "magic":
```php
echo $this->listing('ul', ['class' => 'my-listing'])
    ->li('Text item')
    ->li(['text' => 'Google link', 'link' => ['https://google.com']])
    ->li(['text' => 'Local link', 'link' => ['controller/action', ['id' => 1]], 'properties' => ['class' => 'li-item']])
    ->display();
````
will compile to output:
```html
<ul class="my-listing">
  <li>Text item</li>
  <li><a href="https://google.com">Google link</a></li>
  <li class="li-item"><a href="http://localhost/controller/action/1">Local link</a></li>
</ul>
```

#### Table
Tables often used to display structured data. Templex provide helper to draw table simple & fast. To draw table you should use ``$this->table([properties])`` instance and then implement thead ``->head([properties], [items])`` features and tbody ``->row([items], order)`` items and finally call ``->display()`` to get html output.

As a listings, table can be used in inline or names style (careful! code below is symbolic):
```
// inline call:
echo $this->table([properties])
    ->head([properties], [titles])
    ->row([items1])
    ->row([items2])
    ->display();
    
 // named call:
$table = $this->table([properties]);
$table->head([properties], [titles])
for ($i = 0; $i < 100; $i++) {
    $table->row([elements]);
}
echo $table->display();
```

So take a look at complete example:
```php
echo $this->table(['class' => 'table'])
    ->head(['class' => 'table-header'], [
        ['text' => 'column1'],
        ['text' => 'column2'],
        ['text' => 'column3'],
    ])
    ->row([
        ['text' => 'row 1, <strong>column1</strong>', 'html' => true], // html allowed
        ['text' => 'row 1, column2', 'properties' => ['class' => 'alert alert-danger']],
        ['text' => 'row 1, column3']
    ])
    ->row([
        ['text' => 'row 2, column1'],
        ['text' => 'row 2, <em>column2</em>'], // html not allowed!
        ['text' => 'row 2, column3'],
        'properties' => ['class' => 'alert alert-success']
    ])
    ->display();
```
lead to output:
```html
<table class="table">
    <thead class="table-header">
    <tr><th>column1</th>
        <th>column2</th>
        <th>column3</th>
    </tr>
    </thead>
    <tbody>
        <tr>
            <td>row 1, <strong>column1</strong></td>
            <td class="alert alert-danger">row 1, column2</td>
            <td>row 1, column3</td>
        </tr>
        <tr class="alert alert-success">
            <td>row 2, column1</td>
            <td>row 2, &lt;em&gt;column2&lt;/em&gt;</td>
            <td>row 2, column3</td>
        </tr>
    </tbody>
</table>   
```
If you want to use html syntax in ``text`` property you should pass ```'html' = true``` in item array.
##### Selectize column
Table helper provide feature to display multiple checkboxes at table column index. If you want to add at each element of column checkbox input field, use selectize:
```php
$this->table([properties])
    ->selectize(index, name)
```
Note, that ```->selectize()``` should be used before ```->head()``` or ```->row()``` called. 



##### Sortable column
If you want to sort data in tables you can use sorter helper of table building. Sorter add up/down arrow at defined column index with named link. 
```php
$this->table([properties])
    ->sortable([
        0 => 'getname' // will build ?getname=1 and ?getname=2 links as asc/desc sorting query
    ])
```

#### Forms
Form helper provide features of fast form field building, styling and display. 
