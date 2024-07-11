<?php
/* @var $this BlogPostController */
/* @var $model BlogPost */
/* @var $categories array */

$this->breadcrumbs=array(
	'Blog Posts'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List BlogPost', 'url'=>array('index')),
	array('label'=>'Create BlogPost', 'url'=>array('create')),
	array('label'=>'View BlogPost', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage BlogPost', 'url'=>array('admin')),
);
?>

<h1>Update BlogPost <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model' => $model, 'categories' => $categories)); ?>