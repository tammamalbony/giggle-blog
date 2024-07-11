<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */

$this->pageTitle = Yii::app()->name . ' - Register';
$this->breadcrumbs = array('Register', );
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

            <?php $form = $this->beginWidget(
                'CActiveForm',
                array(
                    'id' => 'user-form',
                    'enableAjaxValidation' => true,
                    'htmlOptions' => array(
                        'class' => 'justify-content-center align-items-center mt-5 needs-validation',
                        'novalidate' => true
                    ),
                )
            ); ?>

            <div class="d-flex justify-content-between">
                <div class="mb-3 mx-2 w-50">
                    <?php echo $form->labelEx($model, 'first_name', array('class' => 'form-label')); ?>
                    <?php echo $form->textField($model, 'first_name', array('class' => 'form-control w-100', 'placeholder' => 'Name', 'required' => true, 'minlength' => 2)); ?>
                    <?php echo $form->error($model, 'first_name', array('class' => 'invalid-feedback')); ?>
                </div>
                <div class="mb-3 mx-2 w-50">
                    <?php echo $form->labelEx($model, 'last_name', array('class' => 'form-label')); ?>
                    <?php echo $form->textField($model, 'last_name', array('class' => 'form-control w-100', 'placeholder' => 'Surname', 'required' => true, 'minlength' => 2)); ?>
                    <?php echo $form->error($model, 'last_name', array('class' => 'invalid-feedback')); ?>
                </div>
            </div>

            <div class="mb-3">
                <?php echo $form->labelEx($model, 'username', array('class' => 'form-label')); ?>
                <?php echo $form->textField($model, 'username', array('class' => 'form-control', 'placeholder' => 'username', 'required' => true)); ?>
                <?php echo $form->error($model, 'username', array('class' => 'invalid-feedback')); ?>
                <span id="username-error" class="invalid-feedback" style="display: none;">Username is already
                    taken.</span>
            </div>

            <div class="mb-3">
                <?php echo $form->labelEx($model, 'email', array('class' => 'form-label')); ?>
                <?php echo $form->textField($model, 'email', array('class' => 'form-control', 'placeholder' => 'Email Address', 'required' => true)); ?>
                <?php echo $form->error($model, 'email', array('class' => 'invalid-feedback')); ?>
                <span id="email-error" class="invalid-feedback" style="display: none;">Email is already taken.</span>
            </div>

            <div class="mb-3 password-container">
                <?php echo $form->labelEx($model, 'password', array('class' => 'form-label')); ?>
                <?php echo $form->passwordField($model, 'password', array('class' => 'form-control password-control', 'placeholder' => 'Password', 'required' => true)); ?>
                <?php echo $form->error($model, 'password', array('class' => 'invalid-feedback')); ?>
                <div class="input-group-addon">
                    <a class="btn-pass">
                        <img src="/custom/img/s1/eye.svg" alt="" class="eye-close">
                        <img src="/custom/img/s1/eyeopen.svg" alt="" class="eye-open d-none">
                    </a>
                </div>
                <div id="password-error" class="invalid-feedback"></div>
            </div>


            <div class="mb-3 password-container">
                <?php echo $form->labelEx($model, 'password_repeat', array('class' => 'form-label')); ?>
                <?php echo $form->passwordField($model, 'password_repeat', array('class' => 'form-control  password-control', 'placeholder' => 'Repeat Password', 'required' => true)); ?>
                <?php echo $form->error($model, 'password_repeat', array('class' => 'invalid-feedback')); ?>
                <div class="input-group-addon">
                    <a class="btn-pass">
                        <img src="/custom/img/s1/eye.svg" alt="" class="eye-close">
                        <img src="/custom/img/s1/eyeopen.svg" alt="" class="eye-open d-none">
                    </a>
                </div>
                <div id="password-repeat-error" class="invalid-feedback"></div>
            </div>
            <div class="form-check d-flex justify-content-start mt-2">
                <?php echo $form->checkBox($model, 'terms', array('class' => 'form-check-input', 'id' => 'User_terms', 'required' => true)); ?>
                <label class="form-check-label mx-2" for="User_terms">
                    <span style="white-space: nowrap;">By Signing Up I agree with </span>
                    <a href="Conditions.html"><u style="white-space: nowrap;">Terms & Conditions</u></a>
                </label>
                <?php echo $form->error($model, 'terms', array('class' => 'invalid-feedback')); ?>
            </div>

            <div class="row buttons">
                <?php echo CHtml::submitButton('Sign Up', array('class' => 'btn btn-primary btnmain mt-3 ')); ?>
            </div>

            <?php $this->endWidget(); ?>

            <p class="mt-5">
                Already have an Account? <a href="<?php echo Yii::app()->createUrl('site/login'); ?>"><u>Sign In</u></a>
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
<style>

</style>

<script>
    (function () {
        'use strict';
        var forms = document.querySelectorAll('.needs-validation');
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        updateSubmitButtonState();
    })();

    let emailTimeout;
    $('#User_email').on('input', function () {
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        var email = $('#User_email').val();
        if (emailRegex.test(email)) {
            clearTimeout(emailTimeout);
            emailTimeout = setTimeout(function () {
                $.ajax({
                    url: '<?php echo Yii::app()->createUrl("user/ajaxEmailCheck"); ?>',
                    type: 'GET',
                    data: { email: email },
                    success: function (response) {
                        var isUnique = JSON.parse(response);
                        if (!isUnique) {
                            $('#email-error').text('Email is already taken.').show().addClass('d-block').removeClass('d-none');
                            $('#User_email').addClass('is-invalid').removeClass('is-valid');
                        } else {
                            $('#email-error').hide().addClass('d-none').removeClass('d-block');
                            $('#User_email').addClass('is-valid').removeClass('is-invalid');
                        }
                        updateSubmitButtonState();
                    }
                });
            }, 2000);
        } else {
            if (email !== '') {
                $('#email-error').text('Please enter a valid email address.').show().addClass('d-block').removeClass('d-none');
                $('#User_email').addClass('is-invalid').removeClass('is-valid');
            } else {
                $('#email-error').hide().addClass('d-none').removeClass('d-block');
                $('#User_email').removeClass('is-invalid is-valid');
            }
        }
        updateSubmitButtonState();
    });


    let usernameTimeout;
    $('#User_username').on('input', function () {
        var username = $('#User_username').val();
        if (username.length >= 3) {
            clearTimeout(usernameTimeout);
            usernameTimeout = setTimeout(function () {
                $.ajax({
                    url: '<?php echo Yii::app()->createUrl("user/ajaxUsernameCheck"); ?>',
                    type: 'GET',
                    data: { username: username },
                    success: function (response) {
                        var isUnique = JSON.parse(response);
                        if (!isUnique) {
                            $('#username-error').show().addClass('d-block').removeClass('d-none');
                            $('#User_username').addClass('is-invalid').removeClass('is-valid');
                        } else {
                            $('#username-error').hide().addClass('d-none').removeClass('d-block');
                            $('#User_username').addClass('is-valid').removeClass('is-invalid');
                        }
                        updateSubmitButtonState();
                    }
                });
            }, 2000);
        } else {
            $('#username-error').hide().addClass('d-none').removeClass('d-block');
            $('#User_username').removeClass('is-invalid is-valid');
        }
        updateSubmitButtonState();
    });

    $('#User_first_name, #User_last_name').on('input', function () {
        if (this.value.length < 2) {
            $(this).addClass('is-invalid').removeClass('is-valid');
            $(this).next('.invalid-feedback').text('Please enter at least 2 characters.').show();
        } else {
            $(this).addClass('is-valid').removeClass('is-invalid');
            $(this).next('.invalid-feedback').hide();
        }
        updateSubmitButtonState();
    });
    $('#User_password').on('input', function () {
        var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z\d]).{8,}$/;
        var password = $(this).val();

        if (passwordRegex.test(password)) {
            $(this).removeClass('is-invalid').addClass('is-valid');
            $('#password-error').hide();
        } else {
            $(this).removeClass('is-valid').addClass('is-invalid');
            $('#password-error').text('Password must be at least 8 characters and include upper/lower case letters, numbers, and symbols.').show();
        }
        updateSubmitButtonState();
    });

    $('#User_password_repeat').on('input', function () {
        var password = $('#User_password').val();
        var confirmPassword = $(this).val();

        if (confirmPassword === password && confirmPassword.length > 0) {
            $(this).removeClass('is-invalid').addClass('is-valid');
            $('#password-repeat-error').hide();
        } else {
            $(this).removeClass('is-valid').addClass('is-invalid');
            $('#password-repeat-error').text('Passwords do not match.').show();
        }
        updateSubmitButtonState();
    });
    $('#User_terms').on('change', function () {
        if (this.checked) {
            $(this).removeClass('is-invalid').addClass('is-valid');
        } else {
            $(this).removeClass('is-valid').addClass('is-invalid');
        }
        updateSubmitButtonState();
    });
    $('#User_email, #User_username, #User_first_name, #User_last_name, #User_password, #User_password_repeat, #User_terms').on('input change', function () {
        updateSubmitButtonState();
    });

    function updateSubmitButtonState() {
        var form = document.querySelector('.needs-validation');
        var allValid = form.checkValidity();
        var button = $(':submit');

        <?php if ($_ENV['APP_DEBUG'] == true) { ?>
            var inputs = form.querySelectorAll('input, select, textarea');
            inputs.forEach(function (input) {
                console.log(input.name, 'validity:', input.validity.valid);
            });
            console.log('Form validity:', allValid);
        <?php } ?>

        if (allValid) {
            button.prop('disabled', false);
        } else {
            button.prop('disabled', true);
        }
    }
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


        form.addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent the default form submission

            if (form.checkValidity()) {
                var formData = new FormData(form);

                var submitButton = $(':submit');
                submitButton.prop('disabled', true).text('Submitting...');
                submitButton.addClass("loading-btn");
                $.ajax({
                    url: '<?php echo Yii::app()->createUrl("user/signUp"); ?>',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Thank you for registering. Please check your email to verify your account.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '<?php echo Yii::app()->createUrl("site/login"); ?>';
                            }
                        });
                    },
                    error: function (response) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Form submission failed. Please try again.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                        console.error('Form submission failed:', response);
                        submitButton.prop('disabled', false).text('Sign Up');
                        submitButton.removeClass("loading-btn");
                    }
                });
            }

            form.classList.add('was-validated');
        }, false);

        updateSubmitButtonState();


    });
</script>