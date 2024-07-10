/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */

$this->pageTitle=Yii::app()->name . ' - Register';
$this->breadcrumbs=array(
    'Register',
);
?>

<div class="container controls_filters" style="margin-top: 100px;">
    <div class="row">
        <div class="col-12 text-center flex-column d-flex justify-content-center">
            <div class="text-center">
                <h2>Sign Up</h2>
            </div>
            <a class="btn btn-primary btnmain btnlight mt-3">Sign Up using <strong>Google</strong></a>
            <div class="d-flex justify-content-between mt-5">
                <hr class="mx-2" style="width: -webkit-fill-available;">
                <p style="white-space: nowrap;">or sign up with your email</p>
                <hr class="mx-2" style="width: -webkit-fill-available;">
            </div>

            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'user-form',
                'enableAjaxValidation'=>true,
                'htmlOptions'=>array('class'=>'justify-content-center align-items-center mt-5')
            )); ?>

            <div class="d-flex justify-content-between">
                <div class="mb-3 mx-2 w-50">
                    <?php echo $form->labelEx($model, 'first_name', array('class'=>'form-label')); ?>
                    <?php echo $form->textField($model, 'first_name', array('class'=>'form-control w-100', 'placeholder'=>'Name')); ?>
                    <?php echo $form->error($model, 'first_name'); ?>
                </div>
                <div class="mb-3 mx-2 w-50">
                    <?php echo $form->labelEx($model, 'last_name', array('class'=>'form-label')); ?>
                    <?php echo $form->textField($model, 'last_name', array('class'=>'form-control w-100', 'placeholder'=>'Surname')); ?>
                    <?php echo $form->error($model, 'last_name'); ?>
                </div>
            </div>
            
            <div class="mb-3">
                <?php echo $form->labelEx($model, 'username', array('class'=>'form-label')); ?>
                <?php echo $form->textField($model, 'username', array('class'=>'form-control', 'placeholder'=>'username')); ?>
                <?php echo $form->error($model, 'username'); ?>
            </div>

            <div class="mb-3">
                <?php echo $form->labelEx($model, 'email', array('class'=>'form-label')); ?>
                <?php echo $form->textField($model, 'email', array('class'=>'form-control', 'placeholder'=>'Email Address')); ?>
                <?php echo $form->error($model, 'email'); ?>
            </div>
            
            <div class="mb-3">
                <?php echo $form->labelEx($model, 'password', array('class'=>'form-label')); ?>
                <?php echo $form->passwordField($model, 'password', array('class'=>'form-control', 'placeholder'=>'Password')); ?>
                <?php echo $form->error($model, 'password'); ?>
            </div>

            <div class="mb-3">
                <?php echo $form->labelEx($model, 'password_repeat', array('class'=>'form-label')); ?>
                <?php echo $form->passwordField($model, 'password_repeat', array('class'=>'form-control', 'placeholder'=>'Repeat Password')); ?>
                <?php echo $form->error($model, 'password_repeat'); ?>
            </div>

            <div class="form-check d-flex justify-content-start mt-2">
                <?php echo $form->checkBox($model, 'terms', array('class'=>'form-check-input', 'id'=>'defaultCheck1')); ?>
                <label class="form-check-label mx-2" for="defaultCheck1">
                    <span style="white-space: nowrap;">By Signing Up I agree with </span>
                    <a href="Conditions.html"><u style="white-space: nowrap;">Terms & Conditions</u></a>
                </label>
            </div>

            <div class="row buttons">
                <?php echo CHtml::submitButton('Sign Up', array('class'=>'btn btn-primary btnmain mt-3')); ?>
            </div>

            <?php $this->endWidget(); ?>
            
            <p class="mt-5">
                Already have an Account? <a href="signup.html"><u>Sign In</u></a>
            </p>

            <div class="d-flex justify-content-between">
                <div>© 2024 Giggle.com</div>
                <div class="d-flex justify-content-between textGM">
                    <a href="Conditions.html" class="mx-2"><u class="">Terms and Conditions</u></a>
                    <a href="Privacy.html" class="mx-1"><u class="">Privacy Policy</u></a>
                </div>
            </div>
        </div>
    </div>
</div>

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
                alert('Email is already taken.');
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
                alert('Username is already taken.');
            }
        }
    });
});
</script>
