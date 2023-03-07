<?php
$form = \app\core\form\Form::begin('', 'post')
/* @var $model \app\models\User */

?>

<?= $form->field($model, 'email')->emailField() ?>
<?= $form->field($model, 'password')->passwordField() ?>

<button type="submit" class="btn btn-primary">Login</button>
<?= \app\core\form\Form::end() ?>