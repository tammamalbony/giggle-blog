<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */

$this->pageTitle=Yii::app()->name . ' - Register';
$this->breadcrumbs=array(
    'Register',
);
?>

<h1>Register</h1>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'user-form',
    'enableAjaxValidation'=>true,
)); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'first_name'); ?>
        <?php echo $form->textField($model, 'first_name'); ?>
        <?php echo $form->error($model, 'first_name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'last_name'); ?>
        <?php echo $form->textField($model, 'last_name'); ?>
        <?php echo $form->error($model, 'last_name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'username'); ?>
        <?php echo $form->textField($model, 'username'); ?>
        <?php echo $form->error($model, 'username'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'email'); ?>
        <?php echo $form->textField($model, 'email'); ?>
        <?php echo $form->error($model, 'email'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'password'); ?>
        <?php echo $form->passwordField($model, 'password'); ?>
        <?php echo $form->error($model, 'password'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'password_repeat'); ?>
        <?php echo $form->passwordField($model, 'password_repeat'); ?>
        <?php echo $form->error($model, 'password_repeat'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Register'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script>
$('#User_email').on('blur', function() {
    var email = $(this).val();
    $.ajax({
        url: '<?php echo Yii::app()->createUrl("user/ajaxEmailCheck"); ?>',
        type: 'GET',
        data: { email: email },
        success: function(response) {
            var isUnique = JSON.parse(response);
            if (!isUnique) {
                $('#email-validation-message').text('Email is already taken.');
            } else {
                $('#email-validation-message').text('');
            }
        }
    });
});

$('#User_username').on('blur', function() {
    var username = $(this).val();
    $.ajax({
        url: '<?php echo Yii::app()->createUrl("user/actionAjaxUsernameCheck"); ?>',
        type: 'GET',
        data: { username: username },
        success: function(response) {
            var isUnique = JSON.parse(response);
            if (!isUnique) {
                $('#username-validation-message').text('UserName is already taken.');
            } else {
                $('#username-validation-message').text('');
            }
        }
    });
});
</script>
