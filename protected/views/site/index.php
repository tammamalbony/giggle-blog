<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name;
?>

<div class="container " style="margin-top: 100px;">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <h1>Welcome to <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>
            <p class="lead mt-4">Congratulations! You have successfully created your Yii application.</p>
            <div class="alert alert-info mt-4">
                <p>You may change the content of this page by modifying the following two files:</p>
                <ul class="list-unstyled">
                    <li><strong>View file:</strong> <code><?php echo __FILE__; ?></code></li>
                    <li><strong>Layout file:</strong> <code><?php echo $this->getLayoutFile('main'); ?></code></li>
                </ul>
            </div>
            <p class="mt-4">For more details on how to further develop this application, please read
                the <a href="https://www.yiiframework.com/doc/" class="btn btn-primary">documentation</a>.
                Feel free to ask in the <a href="https://www.yiiframework.com/forum/" class="btn btn-secondary">forum</a>,
                should you have any questions.</p>
        </div>
    </div>
</div>
