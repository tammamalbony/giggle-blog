<?php
/* @var $this BlogPostController */
/* @var $data BlogPost */
?>

<div class="col-md-4 col-sm-12">
    <div class="card mb-3">
        <div class="row g-0 position-relative">
            <?php $isLiked = $data->isLikedByCurrentUser(); ?>
            <button class="btn <?php echo $isLiked ? 'btn-primary' : 'btn-outline-primary'; ?> favBtn"
                data-id="<?php echo $data->id; ?>">
                <i class="bi <?php echo $isLiked ? 'bi-hand-thumbs-down' : 'bi-hand-thumbs-up'; ?>"></i>
            </button>
            <img src="<?php echo "/";echo isset($_ENV['UPLOAD_DIR']) ?  $_ENV['UPLOAD_DIR'] : "uploads"; echo "/" ; echo CHtml::encode($data->image); ?>" class="card-img-top clickable-card"
                data-link="<?php echo $this->createUrl('view', array('id' => $data->id)); ?>"
                alt="<?php echo CHtml::encode($data->title); ?>">
            <div class="card-body ">
                <h5 class="card-title clickable-card"
                    data-link="<?php echo $this->createUrl('view', array('id' => $data->id)); ?>">
                    <?php echo CHtml::encode($data->title); ?>
                </h5>
                <p class="card-text clickable-card"
                    data-link="<?php echo $this->createUrl('view', array('id' => $data->id)); ?>">
                    <i class="bi bi-person-fill text-secondary"></i>
                    <small class="text-body-secondary">Author:
                        <?php echo CHtml::encode($data->author->username); ?></small>
                </p>
                <p class="card-text clickable-card"
                    data-link="<?php echo $this->createUrl('view', array('id' => $data->id)); ?>">
                    <i class="bi bi-tag-fill text-secondary"></i>
                    <small class="text-body-secondary">Category:
                        <?php echo CHtml::encode($data->category->name); ?></small>
                </p>
                <p class="card-text clickable-card"
                    data-link="<?php echo $this->createUrl('view', array('id' => $data->id)); ?>">
                    <?php echo CHtml::encode($data->description); ?>
                </p>
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
                            <span
                                class="visibility-status"><?php echo CHtml::encode($data->visibility == 1 ? 'Public' : 'Private'); ?></span></strong>
                        <?php if ($data->author_id == Yii::app()->user->id): ?>
                            <label class="switch">
                                <input type="checkbox" class="visibility-toggle" data-id="<?php echo $data->id; ?>" <?php echo $data->visibility == 1 ? 'checked' : ''; ?>>
                                <span class="slider round"></span>
                            <?php endif; ?>
                        </label>
                    </div>
                    <div>
                        <strong>Comments:
                            <span><?php echo CHtml::encode($data->getCommentCount()); ?></span></strong>
                    </div>
                    <div>
                        <strong>Likes:
                            <span class="like-count"><?php echo CHtml::encode($data->getLikeCount()); ?></span></strong>
                    </div>
                </div>

                <?php if ($data->author_id == Yii::app()->user->id): ?>
                    <div class="d-flex justify-content-end EditPostbtn">
                        <a href="<?php echo $this->createUrl('edit', array('id' => $data->id)); ?>"
                            class="btn btn-secondary btn-sm rounded-pill">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>