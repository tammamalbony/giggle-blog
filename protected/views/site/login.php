<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>

<div class="container controls_filters" style="margin-top: 100px;">
    <div class="row">
        <div class="col-12 text-center flex-column d-flex justify-content-center">
            <div class="text-center">
                <h2 class="textGM">Sign In</h2>
            </div>
            <a class="btn btn-primary btnmain btnlight mt-3">Sign In using <strong>Google</strong></a>
            <div class="d-flex justify-content-between mt-5">
                <hr class="mx-2" style="width: -webkit-fill-available;">
                <p style="white-space: nowrap;">or sign in with your email</p>
                <hr class="mx-2" style="width: -webkit-fill-available;">
            </div>
            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'login-form',
                'enableClientValidation'=>true,
                'clientOptions'=>array(
                    'validateOnSubmit'=>true,
                ),
                'htmlOptions'=>array(
                    'class'=>'justify-content-center align-items-center mt-5',
                ),
            )); ?>

            <div class="mb-3">
                <div class="d-flex justify-content-between">
                    <?php echo $form->labelEx($model, 'username', array('class' => 'form-label')); ?>
                </div>
                <?php echo $form->textField($model, 'username', array('class' => 'form-control', 'placeholder' => 'Email Address')); ?>
                <?php echo $form->error($model, 'username'); ?>
            </div>

            <div class="mb-3 password-container">
                <div class="d-flex justify-content-between">
                    <?php echo $form->labelEx($model, 'password', array('class' => 'form-label')); ?>
                    <a href="forgetpassword.html"><u>Forgot Password?</u></a>
                </div>
                <?php echo $form->passwordField($model, 'password', array('class' => 'form-control  password-control', 'placeholder' => 'Password')); ?>
                <div class="input-group-addon">
                    <a class="btn-pass">
                        <img src="/custom/img/s1/eye.svg" alt="" class="eye-close">
                        <img src="/custom/img/s1/eyeopen.svg" alt="" class="eye-open d-none">
                    </a>
                </div>
                <?php echo $form->error($model, 'password'); ?>
            </div>

            <div class="row rememberMe mb-3">
                <div class="col d-flex  justify-content-center align-items-center">
                    <?php echo $form->checkBox($model, 'rememberMe'); ?>
                    <?php echo $form->label($model, 'rememberMe'); ?>
                    <?php echo $form->error($model, 'rememberMe'); ?>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btnmain mt-3">Sign In</button>

            <?php $this->endWidget(); ?>
            <p class="mt-5">
                New to Giggle? <a href="<?php echo Yii::app()->createUrl('user/register'); ?>"><u>Sign Up</u></a>
            </p>
            <div class="d-flex justify-content-between">
                <div>
                    © 2024 Giggle.com
                </div>
                <div class="d-flex justify-content-between textGM">
                    <a href="<?php echo Yii::app()->createUrl('site/conditions'); ?>" class="mx-2"> <u class> Terms and Conditions </u> </a>
                    <a href="<?php echo Yii::app()->createUrl('site/privacy'); ?>" class="mx-1"> <u class> Privacy Policy </u> </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
     document.addEventListener('DOMContentLoaded', function () {
        var form = document.querySelector('.needs-validation');

        const toggleLinks = document.querySelectorAll('.password-container .input-group-addon .btn-pass');
        toggleLinks.forEach(toggle => {
            toggle.addEventListener('click', function (e) {
                e.preventDefault();
                var passwordInput = this.closest('.password-container').querySelector('.password-control');
                var eyeOpen = this.querySelector('.eye-open');
                var eyeClose = this.querySelector('.eye-close');
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    eyeOpen.classList.remove('d-none');
                    eyeClose.classList.add('d-none');
                } else {
                    passwordInput.type = 'password';
                    eyeOpen.classList.add('d-none');
                    eyeClose.classList.remove('d-none');
                }
            });
        });
    });
</script>
