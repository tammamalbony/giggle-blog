<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name . ' - Verification Needed';
$this->breadcrumbs = array(
    'Verification',
);
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/custom/vendor/jquery-3.6.0.min.js"></script>

<div class="container " style="margin-top: 100px;">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <h1 class="display-4">Verification Needed</h1>

            <?php if (Yii::app()->user->hasFlash('verificationNeeded')): ?>
                <div class="alert alert-success mt-4">
                    <?php echo Yii::app()->user->getFlash('verificationNeeded'); ?>
                </div>
            <?php endif; ?>

            <p class="lead mt-4">Your account is not yet verified. To fully activate your account and access all
                features, please check your email and follow the instructions to verify your account.</p>

            <?php if (isset($_ENV['IS_EMAIL_ENABEL']) &&  strtoupper($_ENV['IS_EMAIL_ENABEL']) === "TRUE") {
                ?>
                <div class="mt-4">
                    <p>If you did not receive the email, <a
                            href="<?php echo $this->createUrl('user/resendVerification'); ?>" class="btn btn-primary"
                            id="resendBtn">click here to resend it</a>.</p>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        var $ = jQuery.noConflict();
                        var resendBtn = document.getElementById('resendBtn');

                        resendBtn.addEventListener('click', function (event) {
                            event.preventDefault(); // Prevent the default link behavior

                            resendBtn.classList.add('loading-btn');
                            resendBtn.setAttribute('disabled', 'true');

                            $.ajax({
                                url: resendBtn.href,
                                type: 'GET',
                                success: function (response) {
                                    Swal.fire({
                                        title: 'Success!',
                                        text: 'Verification email has been resent.',
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                    });
                                },
                                error: function (response) {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'Failed to resend verification email.',
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                },
                                complete: function () {
                                    resendBtn.classList.remove('loading-btn');
                                    resendBtn.removeAttribute('disabled');
                                }
                            });
                        });
                    });

                </script>
                <?php
            } else{ ?>
                <div class="mt-2">
                    <p class="text-danger">The email server is not enabled or not configured so : 
                        <a href="<?php echo $this->createUrl('user/verifyNow', array('id' => Yii::app()->user->id)); ?>"
                            class="btn btn-primary" id="verifyNowBtn">click here to verify your account now</a>
                    </p>
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        var $ = jQuery.noConflict();
                        var verifyNowBtn = document.getElementById('verifyNowBtn');

                        verifyNowBtn.addEventListener('click', function (event) {
                            event.preventDefault(); // Prevent the default link behavior

                            verifyNowBtn.classList.add('loading-btn');
                            verifyNowBtn.setAttribute('disabled', 'true');

                            $.ajax({
                                url: verifyNowBtn.href,
                                type: 'GET',
                                success: function (response) {
                                    Swal.fire({
                                        title: 'Success!',
                                        text: 'Your account has been verified.',
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.href = '<?php echo $this->createUrl('site/index'); ?>';
                                        }
                                    });
                                },
                                error: function (response) {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'Failed to verify your account.',
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                },
                                complete: function () {
                                    verifyNowBtn.classList.remove('loading-btn');
                                    verifyNowBtn.removeAttribute('disabled');
                                }
                            });
                        });
                    });
                </script>
            <?php } ?>

        </div>
    </div>
</div>