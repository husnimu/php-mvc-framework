<?php
$form = \app\core\form\Form::begin('', 'post')
?>

<div class="row">
  <div class="col">
    <?= $form->inputField($model, 'firstname') ?>
  </div>
  <div class="col">
    <?= $form->inputField($model, 'lastname') ?>
  </div>
</div>
<?= $form->inputField($model, 'email')->emailField() ?>
<?= $form->inputField($model, 'password')->passwordField() ?>
<?= $form->inputField($model, 'confirmpassword')->passwordField() ?>

<button type="submit" class="btn btn-primary">Register</button>
<?= \app\core\form\Form::end() ?>