<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - Verification Needed';
$this->breadcrumbs=array(
    'Verification Notice',
);
?>

<h1>Verification Needed</h1>

<?php if(Yii::app()->user->hasFlash('verificationNeeded')): ?>
<div class="flash-success">
    <?php echo Yii::app()->user->getFlash('verificationNeeded'); ?>
</div>
<?php endif; ?>

<p>Your account is not yet verified. To fully activate your account and access all features, please check your email and follow the instructions to verify your account.</p>

<div>
    <p>If you did not receive the email, <a href="<?php echo $this->createUrl('user/resendVerification'); ?>">click here to resend it</a>.</p>
</div>
