<?php

/** @var Ffcms\Templex\Template\Template $this */

$this->layout('layout', ['title' => 'Test page title']);

class FakeForm extends \Ffcms\Templex\Helper\Html\Form\Model
{
    public $name;
    public $gender = 0; // 0/1/2
    public $about;
    public $pass = 'SecUrEPwD';
    public $hobys = [1];
    public $token = '05e73a0b7f06dd5674e026d534852279';
    public $avatar;

    public $jailed; // true/false

    public $cities = ['kv', 'ms']; // multiple checkboxes

    public function labels(): array
    {
        return [
            'name' => 'Your name',
            'gender' => 'Your gender'
        ];
    }

    public function genders(): array
    {
        return [1 => 'male', 2 => 'female', 0 => 'none'];
    }
}

?>
<?php $this->start('body') ?>
<h1>Hello world</h1>
<?php $this->insert('block/depend') ?>

<?php echo $this->listing('ul', ['class' => 'my-listing'])
    ->li('Text item')
    ->li(['text' => 'Google link', 'link' => ['https://google.com']])
    ->li(['text' => 'Local link', 'link' => ['controller/action', ['id' => 1]], ['class' => 'li-item']])
    ->display(); ?>

<p>~ Table examples:</p>
<div class="table-responsive">
<?php

$table = $this->table(['class' => 'table table-hover']);

$table->selectize(0, 'inputTable1');
$table->sortable([0 => 'idsort']);

$table->head([
   ['text' => 'head1'],
   ['text' => 'head2'],
   ['text' => 'head3'],
   ['text' => 'head4'],
], ['class' => 'thead-control']);
for ($i = 0; $i <= 10; $i++) {
    $row = [];
    for ($j = 0; $j <= 3; $j++) {
        $row[$j] = ['text' => 'test ' . $j];
    }
    $table->row($row, $i);
}

echo $table->display();
?>
</div>
<div class="table-responsive">
<?= $this->table(['class' => 'table table-bordered'])
    ->selectize(0, 'inputCol')
    ->sortable([0 => 'id', 1 => 'colmn1'])
    ->head(['id' => 'test-head-id'], function(){
        $heads = [];
        for ($i=0;$i<=5;$i++) {
            $heads[] = ['text' => 'col ' . $i];
        }
        return $heads;
    })->body(function(){
        $body = [];
        for ($i = 0; $i <= 10; $i++) { // cols
            for ($j = 0; $j <= 5; $j++) { // rows
                $body[$i][$j] = ['text' => 'cell value: ' . $i . ':' . $j];
            }
        }

        return $body;
    }, ['class' => 'table-body'])->display();
?>
</div>

<p>~ Listing example:</p>
<?= $this->listing('ul', ['class' => 'nav'])
    ->li('Item #1')
    ->li('Item #2 with properties', ['class' => 'nav-text'])
    ->li(['text' => 'Link #1', 'link' => ['controller/action', ['id' => 1]]], ['class' => 'nav-link'])
    ->display(); ?>

<p>~ Pagination example (<10 pages):</p>
<?= $this->pagination(['controller/action', ['id' => 'test']])
    ->size(75, 0, 10)
    ->display(); ?>

<p>~ Pagination example (>10 pages):</p>
<?= $this->pagination(['controller/action', ['id' => 'test']])
    ->size(750, (int)$_GET['page'], 10)
    ->display(); ?>

<p>~ Form example:</p>

<?php
$model = new FakeForm();
$form = $this->form($model);

echo $form->start();

echo $form->fieldset()->text('name', null, 'Hey, what is your name?');
echo $form->fieldset()->textarea('about', null, 'Tell something about yourself');
echo $form->fieldset()->select('gender', ['options' => $model->genders(), 'optionsKey' => true], 'What is your gender?');
echo $form->fieldset()->password('pass', null, 'Enter your password');
echo $form->fieldset()->multiselect('hobys', ['options' => [1 => 'programmig', 2 => 'rock', 3 => 'pop'], 'optionsKey' => true]);
echo $form->fieldset()->file('avatar');
echo $form->fieldset()->boolean('jailed');
echo $form->fieldset()->checkboxes('cities', ['options' => ['kv' => 'Kiev', 'ms' => 'Moscow', 'wg' => 'Washington'], 'optionsKey' => true]);

echo $form->field()->hidden('token');

echo $form->button()->submit('send me now ');

echo $form->stop();
?>

<!-- nav example -->
<?= $this->bootstrap()->nav('ul', ['class' => 'nav-tabs'])
    ->menu(['text' => 'Menu #1', 'link' => ['action/test']], ['class' => 'nav-item'])
    ->menu(['text' => 'Menu #2', 'link' => ['action/tesk2']])
    ->menu(['text' => 'Tab 1', 'tab' => 'Lol kek tabcontent', 'tabActive' => true])
    ->menu(['text' => 'Tab 2', 'tab' => function(){
        return '<div>Some strong content body in anonymous function</div>';
    }])->display() ?>

<!-- test alert -->
<?= $this->bootstrap()->alert('primary', 'Test alert message') ?>


<!-- test buttons -->
<?= $this->bootstrap()->button('button', 'My button #1', ['class' => 'btn-success']) ?>
<?= $this->bootstrap()->button('a', 'My button #2', ['href' => \Ffcms\Templex\Url\Url::link(['controller/action']), 'class' => 'btn-danger']) ?>
<?= $this->bootstrap()->button('input', 'My button #3', ['class' => 'btn-primary']); ?>

<?php $this->end(); ?>

<?php $this->push('javascript') ?>
<script>console.log('some javascript render');</script>

<!-- some features for bootstrap 4 -->
<script>
$(document).ready(function(){
    $('table.table-hover > tbody').delegate('tr', 'click', function(event){
        if (event.target.type !== 'checkbox') {
            $(':checkbox', this).trigger('click');
        }
    });
})
</script>

<?php $this->end(); ?>