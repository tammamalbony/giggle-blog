<?php
/* @var $this BlogPostController */
/* @var $model BlogPost */

$this->breadcrumbs = array(
	'Blog Posts' => array('index'),
	$model->title,
);

?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/custom/vendor/jquery-3.6.0.min.js"></script>
<?php if ($model->author_id == Yii::app()->user->id): ?>
	<div class="d-flex justify-content-end EditPostbtn" style="position:fixed !important; margin-top:100px;right:15px">
		<a href="<?php echo $this->createUrl('edit', array('id' => $model->id)); ?>"
			class="btn btn-secondary btn-sm rounded-pill">
			<i class="bi bi-pencil"></i> Edit
		</a>
	</div>
<?php endif; ?>
<?php if (!empty($model->cover_image)): ?>
	<div style="background-image:url('<?php echo "/";
	echo isset($_ENV['UPLOAD_DIR']) ? $_ENV['UPLOAD_DIR'] : "uploads";
	echo "/";
	echo CHtml::encode($model->cover_image); ?>')" class=" mb-4 cover-image" data-aos="slide-up" data-aos-duration="1500"
		data-aos-offset="300" data-aos-easing="ease-in-out" alt="Cover Image">

	</div>
<?php endif; ?>
<div class="container-fluid mt-2" style="">
	<div class="row">
		<div class="col-12 position-relative">
			<h1 class="mb-4"><?php echo CHtml::encode($model->title); ?></h1>
			<?php $isLiked = $model->isLikedByCurrentUser(); ?>
			<button class="btn <?php echo $isLiked ? 'btn-primary' : 'btn-outline-primary'; ?> favBtn"
				data-id="<?php echo $model->id; ?>">
				<i class="bi <?php echo $isLiked ? 'bi-hand-thumbs-down' : 'bi-hand-thumbs-up'; ?>"></i>
			</button>
		</div>
		<div class="col-md-6 col-sm-6 col-12">
			<div class="mb-4">
				<strong>Author: </strong>
				<?php if ($model->author->username == Yii::app()->user->name) {
					echo '<strong class="text-warning">you</strong>';
				} else {
					echo CHtml::encode($model->author->first_name);
					echo CHtml::encode($model->author->last_name);
				}
				?>

			</div>
			<div class="mb-4">
				<strong>Description: </strong>
				<p><?php echo CHtml::encode($model->description); ?></p>
			</div>
			<div class="mb-4">
				<strong>Category: </strong>
				<?php echo CHtml::encode($category->name); ?>
			</div>
		</div>
		<div class="col-md-6 col-sm-6 col-12">
			<?php if (!empty($category->icon)): ?>
				<a href="<?php echo "/";
				echo isset($_ENV['UPLOAD_DIR']) ? $_ENV['UPLOAD_DIR'] : "uploads";
				echo "/";
				echo CHtml::encode($category->icon); ?>" class="glightbox">
					<img src="<?php echo "/";
					echo isset($_ENV['UPLOAD_DIR']) ? $_ENV['UPLOAD_DIR'] : "uploads";
					echo "/";
					echo CHtml::encode($category->icon); ?>" class="img-fluid cat-image" data-aos="slide-up" data-aos-duration="1500"
						data-aos-offset="300" data-aos-easing="ease-in-out" alt="Category Image">
				</a>

			<?php endif; ?>
		</div>
		<div class="col-md-12">
			<div class="mb-4">
				<strong>Content: </strong>
				<p><?php echo nl2br(CHtml::encode($model->content)); ?></p>
			</div>
		</div>
		<div class="col-md-6 col-sm-6 col-12">
			<?php if ($model->author_id == Yii::app()->user->id): ?>
				<div class="mb-4 d-flex">
					<strong>Visibility: </strong>
					<p class="mx-2"><span class="visibility-status"
							data-id="<?php echo $model->id; ?>"><?php echo CHtml::encode($model->visibility == 1 ? 'Public' : 'Private'); ?></span>
					</p>
					<label class="switch">
						<input type="checkbox" class="visibility-toggle" data-id="<?php echo $model->id; ?>" <?php echo $model->visibility == 1 ? 'checked' : ''; ?>>
						<span class="slider round"></span>
					</label>

				</div>
			<?php endif; ?>

			<div class="mb-4">
				<strong>Created At: </strong>
				<p><?php echo CHtml::encode($model->created_at); ?></p>
			</div>

			<div class="mb-4">
				<strong>Updated At: </strong>
				<p><?php echo CHtml::encode($model->updated_at); ?></p>
			</div>
		</div>
		<div class="col-md-6 col-sm-6 col-12">
			<?php if (!empty($model->image)): ?>
				<a href="<?php echo "/";
				echo isset($_ENV['UPLOAD_DIR']) ? $_ENV['UPLOAD_DIR'] : "uploads";
				echo "/";
				echo CHtml::encode($model->image); ?>" class="glightbox">
					<img src="<?php echo "/";
					echo isset($_ENV['UPLOAD_DIR']) ? $_ENV['UPLOAD_DIR'] : "uploads";
					echo "/";
					echo CHtml::encode($model->image); ?>" class="img-fluid cat-image" data-aos="flip-left" data-aos-duration="1000"
						data-aos-mirror="true" data-aos-once="false" alt="Post thumbnail">
				</a>
			<?php endif; ?>

		</div>
		<div class="col-md-12">
			<hr>
		</div>
		<div class="col-md-6 col-12">
			<?php
			$icons = [
				'bi-alarm',
				'bi-bag',
				'bi-battery',
				'bi-bezier',
				'bi-bicycle',
				'bi-binoculars',
				'bi-briefcase',
				'bi-brush',
				'bi-bug',
				'bi-calendar',
				'bi-camera',
				'bi-capslock',
				'bi-cash',
				'bi-chat',
				'bi-clipboard',
				'bi-cloud',
				'bi-code',
				'bi-cpu',
				'bi-cup',
				'bi-droplet'
			];
			?>
			<div class="mb-4">
				<h4>Likes <span class="like-count"><?php echo CHtml::encode($model->getLikeCount()); ?></span>
					<button type="button" class="btn btn-primary" id="showLikesBtn">
						Show Likes
					</button>

				</h4>
				<h4>Comments <?php echo CHtml::encode($model->getCommentCount()); ?></h4>
				<div class="comments-container">
					<?php if (!empty($model->comments)): ?>
						<div class="swiper-container">
							<div class="swiper-wrapper">
								<?php foreach ($model->comments as $comment): ?>
									<div class="swiper-slide">
										<div class="card mb-3">
											<div class="card-body">
												<h5 class="card-title"><?php echo CHtml::encode($comment->author->username); ?>
													<i class="bi <?php $randomIcon = $icons[array_rand($icons)];
													echo $randomIcon; ?>"></i>
												</h5>
												<p class="card-text comment-content-display">
													<?php echo CHtml::encode($comment->content); ?>
												</p>
												<p class="card-text">
													<small
														class="text-muted"><?php echo CHtml::encode($comment->created_at); ?></small>
												</p>
												<?php if ($model->author_id == Yii::app()->user->id): ?>
													<button class="btn btn-danger delete-comment-btn"
														data-comment-id="<?php echo $comment->id; ?>">Delete</button>
												<?php endif ?>
											</div>
										</div>
									</div>
								<?php endforeach; ?>

							</div>
							<!-- Add Pagination -->
							<div class="swiper-pagination"></div>
							<!-- Add Navigation -->
							<div class="swiper-button-next"></div>
							<div class="swiper-button-prev"></div>
						</div>


					<?php endif; ?>

				</div>

			</div>
		</div>
		<div class="col-md-6 col-12">
			<div class="mb-4">
				<?php if (!Yii::app()->user->isGuest && Yii::app()->user->getState('isVerified')) { ?>
					<h4>Add your Comment</h4>
					<?php
					$form = $this->beginWidget(
						'CActiveForm',
						array(
							'id' => 'comment-form',
							'enableAjaxValidation' => true,
							'htmlOptions' => array(
								'class' => 'needs-validation',
								'novalidate' => true,
							),
						)
					);
					?>

					<div class="form-group">
						<?php echo $form->labelEx($commentModel, 'content'); ?>
						<span id="word-counter" class="badge badge-info">0 words, 100 words left</span>
						<?php echo $form->textArea($commentModel, 'content', array('class' => 'form-control', 'rows' => 5, 'required' => true, 'data-error' => 'Please enter at least 5 words and no more than 100 words.')); ?>
						<div class="invalid-feedback">Please enter at least 5 words and no more than 100 words.</div>
						<?php echo $form->error($commentModel, 'content'); ?>
					</div>

					<?php echo $form->hiddenField($commentModel, 'post_id', array('value' => $model->id)); ?>
					<?php echo $form->hiddenField($commentModel, 'author_id', array('value' => Yii::app()->user->id)); ?>

					<div class="form-group mt-2">
						<?php echo CHtml::submitButton('Submit', array('class' => 'btn btn-primary', 'id' => 'submit-comment')); ?>
					</div>

					<?php $this->endWidget(); ?>

					<script>
						$(document).ready(function () {
							const maxWords = <?php echo isset($_ENV['MAX_COMMENT_WORDS']) ? $_ENV['MAX_COMMENT_WORDS'] : 99 ?>;
							const minWords = <?php echo isset($_ENV['MIN_COMMENT_WORDS']) ? $_ENV['MIN_COMMENT_WORDS'] : 4 ?>;
							$('#Comment_content').on('input', function () {
								var content = $(this).val();
								var wordCount = content.trim().split(/\s+/).length;
								if (wordCount >= 5) {
									this.setCustomValidity('');
									$(this).removeClass('is-invalid').addClass('is-valid');
								} else {
									this.setCustomValidity('Please enter at least 5 words.');
									$(this).removeClass('is-valid').addClass('is-invalid');
								}
								updateWordCounter(content);
								if (wordCount < 1) {
									setTimeout(() => {
										$('#comment-form')[0].reset();
										$('#comment-form').removeClass('was-validated');
										$('#Comment_content').removeClass('is-valid');
										$('#Comment_content').removeClass('is-invalid');
										updateWordCounter('');
									}, 100);

								}
							});

							function updateWordCounter(text) {
								var words = text.trim().split(/\s+/);
								var wordCount = words.filter(word => word.length > 0).length;
								var wordsLeft = maxWords - wordCount;

								$('#word-counter').text(`${wordCount} words, ${wordsLeft} words left`);

								if (wordCount >= minWords && wordCount <= maxWords) {
									$('#Comment_content').removeClass('is-invalid').addClass('is-valid');
									$('#Comment_content')[0].setCustomValidity('');
								} else {
									$('#Comment_content').removeClass('is-valid').addClass('is-invalid');
									$('#Comment_content')[0].setCustomValidity('Please enter at least 5 words and no more than 100 words.');
								}
							}
							(function () {
								'use strict';
								window.addEventListener('load', function () {
									var forms = document.getElementsByClassName('needs-validation');
									var validation = Array.prototype.filter.call(forms, function (form) {
										form.addEventListener('submit', function (event) {
											if (form.checkValidity() === false) {
												event.preventDefault();
												event.stopPropagation();
											}
											form.classList.add('was-validated');
										}, false);
									});
								}, false);
							})();

							$('#comment-form').on('submit', function (e) {
								e.preventDefault(); // Prevent the default form submission

								$.ajax({
									type: 'POST',
									url: '<?php echo Yii::app()->createUrl("comment/create"); ?>',
									data: $(this).serialize(),
									success: function (response) {
										let res = JSON.parse(response);
										if (res.success) {
											Swal.fire({
												icon: 'success',
												title: 'Comment Added',
												text: 'Your comment has been added successfully!',
											}).then(() => {
												<?php if (!empty($model->comments)) { ?>
													let newCommentSlide = `
																									<div class="swiper-slide">
																										<div class="card mb-3">
																											<div class="card-body">
																												<h5 class="card-title">${res.comment.author.username}</h5>
																												<p class="card-text">${res.comment.content}</p>
																												<p class="card-text">
																													<small class="text-muted">${res.comment.created_at}</small>
																												</p>
																											</div>
																										</div>
																									</div>`;
													let swiper = document.querySelector('.swiper-container').swiper;
													swiper.appendSlide(newCommentSlide);
													swiper.update();
													$('#comment-form')[0].reset();
													$('#comment-form').removeClass('was-validated');
													$('#Comment_content').removeClass('is-valid');
													$('#Comment_content').removeClass('is-invalid');
													updateWordCounter('');
												<?php } else { ?>
													location.reload();
												<?php } ?>
											});
										} else {
											Swal.fire({
												icon: 'error',
												title: 'Error',
												text: res.message || 'An error occurred while adding your comment.',
											});
										}
									},
									error: function () {
										Swal.fire({
											icon: 'error',
											title: 'Error',
											text: 'An error occurred while adding your comment.',
										});
									}
								});
							});
						});
					</script>


				<?php } else if (!Yii::app()->user->isGuest) { ?>
						<h4>To Add your Comment Please :</h4>
						<a href="<?php echo Yii::app()->createUrl('user/verification'); ?>"
							class="btn btn-outline-secondary"><img
								src="<?php echo Yii::app()->request->baseUrl; ?>/custom/img/s1/i1.png" class="icon_image"
								alt="Verify">Verify Your Account</a>
				<?php } ?>
			</div>
		</div>
	</div>
</div>

<script>
	document.getElementById('showLikesBtn').addEventListener('click', function () {
		$.ajax({
			url: '<?php echo Yii::app()->createUrl("blogPost/getLikes", array("id" => $model->id)); ?>',
			method: 'GET',
			success: function (response) {
				var userList = JSON.parse(response);
				var userListHtml = '<ul>';
				userList.forEach(function (user) {
					userListHtml += '<li>' + user + '</li>';
				});
				userListHtml += '</ul>';
				Swal.fire({
					title: 'Users who liked this post',
					html: userListHtml,
					icon: 'info',
					confirmButtonText: 'Close'
				});
			}
		});
	});
</script>

<script>
	$('.favBtn').on('click', function (event) {
		event.preventDefault();
		var postId = $(this).data('id');
		var btn = $(this);

		$.ajax({
			url: '<?php echo Yii::app()->createUrl("like/toggle"); ?>',
			type: 'POST',
			data: { post_id: postId },
			success: function (response) {
				response = JSON.parse(response);
				if (response.success) {
					btn.toggleClass('btn-outline-primary btn-primary');
					btn.find('i').toggleClass('bi-hand-thumbs-up bi-hand-thumbs-down');
					$('.like-count').text(response.likeCount)
					Swal.fire({
						icon: 'success',
						title: 'Success',
						text: response.message,
						showConfirmButton: false,
						timer: 1500
					});
				} else {
					console.log(response.errors);
					Swal.fire({
						icon: 'error',
						title: 'Error',
						text: response.message,
					});
				}
			},
			error: function () {
				Swal.fire({
					icon: 'error',
					title: 'Error',
					text: 'An unexpected error occurred. Please try again.',
				});
			}
		});
	});

	$(document).on('change', '.visibility-toggle', function () {
		var postId = $(this).data('id');
		var visibility = $(this).is(':checked') ? 1 : 0;

		$.ajax({
			type: 'POST',
			url: '<?php echo Yii::app()->createUrl('blogPost/toggleVisibility'); ?>',
			data: { id: postId, visibility: visibility },
			success: function (response) {
				response = JSON.parse(response);
				if (response.status === 'success') {
					$('.visibility-status[data-id="' + postId + '"]').text(visibility == 1 ? 'Public' : 'Private');
					Swal.fire({
						title: 'Success',
						text: 'Visibility updated successfully.',
						icon: 'success',
						confirmButtonText: 'OK'
					});
				} else {
					Swal.fire({
						title: 'Error',
						text: response.message,
						icon: 'error',
						confirmButtonText: 'OK'
					});
				}
			},
			error: function () {
				Swal.fire({
					title: 'Error',
					text: 'Failed to change visibility',
					icon: 'error',
					confirmButtonText: 'OK'
				});
			}
		});
	});
	<?php if ($model->author_id == Yii::app()->user->id && !empty($model->comments)): ?>
		document.addEventListener('DOMContentLoaded', function () {
			const swiper = new Swiper('.swiper-container', {
				loop: true,
				slidesPerView: 1,
				spaceBetween: 30,
				autoplay: {
					delay: 3000, // 3 seconds
				},
				pagination: {
					el: '.swiper-pagination',
					clickable: true,
				},
				navigation: {
					nextEl: '.swiper-button-next',
					prevEl: '.swiper-button-prev',
				},
			});
			document.querySelectorAll('.delete-comment-btn').forEach(function (button) {

				button.addEventListener('click', function () {
					var commentId = this.getAttribute('data-comment-id');
					var slide = this.closest('.swiper-slide');
					var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content'); // Assuming CSRF token is stored in a meta tag

					Swal.fire({
						title: 'Are you sure?',
						text: "You won't be able to revert this!",
						icon: 'warning',
						showCancelButton: true,
						confirmButtonText: 'Yes, delete it!',
						cancelButtonText: 'No, cancel!',
					}).then((result) => {
						if (result.isConfirmed) {
							$.ajax({
								url: '<?php echo Yii::app()->createUrl("comment/delete", array("id" => "")); ?>' + '/' + commentId,
								type: 'POST',
								data: { YII_CSRF_TOKEN: csrfToken },
								success: function (response) {
									var res = JSON.parse(response);
									if (res.status === 'success') {
										Swal.fire(
											'Deleted!',
											'The comment has been deleted.',
											'success'
										);
										location.reload();
									} else {
										Swal.fire(
											'Error!',
											res.message,
											'error'
										);
									}
								},
								error: function () {
									Swal.fire(
										'Error!',
										'There was an error deleting the comment.',
										'error'
									);
								}
							});
						}
					});
				});
			});
		});


	<?php endif ?>
</script>