<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name . ' - Verification Needed';
$this->breadcrumbs = array(
    'Verification',
);
?>

<div class="container " style="margin-top: 100px;">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <h1 class="display-4">Verification Needed</h1>
            
            <?php if (Yii::app()->user->hasFlash('verificationNeeded')): ?>
                <div class="alert alert-success mt-4">
                    <?php echo Yii::app()->user->getFlash('verificationNeeded'); ?>
                </div>
            <?php endif; ?>
            
            <p class="lead mt-4">Your account is not yet verified. To fully activate your account and access all features, please check your email and follow the instructions to verify your account.</p>
            
            <div class="mt-4">
                <p>If you did not receive the email, <a href="<?php echo $this->createUrl('user/resendVerification'); ?>" class="btn btn-primary">click here to resend it</a>.</p>
            </div>
        </div>
    </div>
</div>
