<?php
$form = \app\core\form\Form::begin('', 'post')
/* @var $model \app\models\User */

?>

<?= $form->inputField($model, 'email')->emailField() ?>
<?= $form->inputField($model, 'password')->passwordField() ?>

<button type="submit" class="btn btn-primary">Login</button>
<?= \app\core\form\Form::end() ?>