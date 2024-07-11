<?php
/* @var $this BlogPostController */
/* @var $data BlogPost */
?>

<div class="col-md-4 col-sm-12">
    <div class="card mb-3">
        <div class="row g-0 position-relative">
            <button class="btn btn-outline-primary favBtn">
                <i class="bi bi-heart"></i>
            </button>
            <img src="<?php echo CHtml::encode($data->image); ?>" class="card-img-top clickable-card" data-link="<?php echo $this->createUrl('view', array('id' => $data->id)); ?>" alt="<?php echo CHtml::encode($data->title); ?>">
            <div class="card-body clickable-card" data-link="<?php echo $this->createUrl('view', array('id' => $data->id)); ?>">
                <h5 class="card-title"><?php echo CHtml::encode($data->title); ?></h5>
                <p class="card-text">
                    <i class="bi bi-person-fill text-secondary"></i>
                    <small class="text-body-secondary">Author: <?php echo CHtml::encode($data->author->username); ?></small>
                </p>
                <p class="card-text">
                    <i class="bi bi-tag-fill text-secondary"></i>
                    <small class="text-body-secondary">Category: <?php echo CHtml::encode($data->category->name); ?></small>
                </p>
                <p class="card-text"><?php echo CHtml::encode($data->description); ?></p>
                <div class="d-flex justify-content-between">
                    <div class="d-flex">
                        <i class="bi bi-calendar mx-1 h5 "></i>
                        <strong><small><?php echo CHtml::encode(date('l, d M Y', strtotime($data->created_at))); ?></small></strong>
                    </div>
                    <div class="d-flex">
                        <i class="bi bi-clock mx-1 h5"></i>
                        <strong><small><?php echo CHtml::encode(date('H:i', strtotime($data->created_at))); ?></small></strong>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <div>
                        <strong>Visibility:
                            <span><?php echo CHtml::encode($data->visibility == 1 ? 'Public' : 'Private'); ?></span></strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
