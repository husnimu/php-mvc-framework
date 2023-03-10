<?php

use app\core\form\Form;

/** @var $this \app\core\View */
/** @var $model \app\models\Contact */
$this->title = 'Contact';
?>

<h1>Contact</h1>

<?php $form = Form::begin('', 'post') ?>
<?php echo $form->inputField($model, 'subject') ?>
<?php echo $form->inputField($model, 'email') ?>
<?php echo $form->textAreaField($model, 'message') ?>
<button type="submit" class="btn btn-primary">Submit</button>

<?php Form::end() ?>