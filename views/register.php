<?php
$form = \app\core\form\Form::begin('', 'post')
?>

<div class="row">
  <div class="col">
    <?= $form->field($model, 'firstname') ?>
  </div>
  <div class="col">
    <?= $form->field($model, 'lastname') ?>
  </div>
</div>
<?= $form->field($model, 'email')->emailField() ?>
<?= $form->field($model, 'password')->passwordField() ?>
<?= $form->field($model, 'confirmpassword')->passwordField() ?>

<button type="submit" class="btn btn-primary">Register</button>
<?= \app\core\form\Form::end() ?>