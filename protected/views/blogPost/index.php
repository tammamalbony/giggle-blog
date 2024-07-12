<?php
/* @var $this BlogPostController */
/* @var $dataProvider CActiveDataProvider */
/* @var $authors User[] */
/* @var $categories Category[] */

$this->breadcrumbs = array(
	'Blog Posts',
);

?>

<h1>Blog Posts</h1>

<div class="container-fluid controls_filters" style="margin-top: 50px;">

	<div class="row">
		<div class=" justify-content-start my-1 d-none d-md-flex">
			<h2 class="textGM mx-2">Posts</h2>
		</div>
		<div class="d-flex justify-content-end my-1 max-w-100vw">
			<form action="<?php echo Yii::app()->createUrl('blogPost/index'); ?>" method="GET"
				class="container-fluid d-block filter-form">
				<div class="row">

					<div class="col-custom">
						<div class="input-group flex-nowrap SearchInput px-0">
							<input type="text" name="q" class="form-control" id="SearchInput" placeholder="Search"
								value="<?php echo CHtml::encode(Yii::app()->request->getParam('q')); ?>">
							<button type="submit" class="btn btn-outline-secondary"><i
									class="bi bi-search textGM"></i></button>
						</div>

						<select name="author_id" class="form-control mx-2">
							<option value="">Select Author</option>
							<?php foreach ($authors as $author): ?>
								<option value="<?php echo $author->id; ?>" <?php echo (Yii::app()->request->getParam('author_id') == $author->id) ? 'selected' : ''; ?>>
									<?php if ($author->username == Yii::app()->user->name) { ?>
										you
									<?php } else { ?>
										<?php echo CHtml::encode($author->username); ?>
									<?php } ?>
								</option>
							<?php endforeach; ?>
						</select>
						<select name="category_id" class="form-control">
							<option value="">Select Category</option>
							<?php foreach ($categories as $category): ?>
								<option value="<?php echo $category->id; ?>" <?php echo (Yii::app()->request->getParam('category_id') == $category->id) ? 'selected' : ''; ?>>
									<?php echo CHtml::encode($category->name); ?>
								</option>
							<?php endforeach; ?>
						</select>
						<div class="d-none d-md-flex">
							<button type="submit" class="btn btn-primary mx-2 ">Filter</button>
							<a href="<?php echo Yii::app()->createUrl('blogPost/index'); ?>"
								class="btn btn-secondary mx-2 white-space-nowrap ">Clear Filters</a>
						</div>
					</div>

				</div>
				<div class="row mt-2">
					<div class="col-custom">
						<input type="date" name="date_from" class="form-control"
							value="<?php echo CHtml::encode(Yii::app()->request->getParam('date_from')); ?>">
						<span class="mx-2">to</span>
						<input type="date" name="date_to" class="form-control"
							value="<?php echo CHtml::encode(Yii::app()->request->getParam('date_to')); ?>">
					</div>

				</div>
				<div class="d-flex mt-2 d-md-none">
					<div class="col-custom">
						<button type="submit" class="btn btn-primary mx-2 ">Filter</button>
						<a href="<?php echo Yii::app()->createUrl('blogPost/index'); ?>"
							class="btn btn-secondary mx-2 white-space-nowrap ">Clear Filters</a>
					</div>
				</div>
			</form>
		</div>
	</div>

	<?php $this->widget(
		'zii.widgets.CListView',
		array(
			'dataProvider' => $dataProvider,
			'itemView' => '_view',
			'itemsCssClass' => 'row pt-3 mx-2',
			'template' => "{items}\n{pager}",
			'htmlOptions' => array(
				'class' => '', // Custom class for the overall list view
			),
		)
	); ?>
</div>
<script>
	$(document).ready(function () {
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
						// Update like count
						var likeCountElement = btn.closest('.card').find('.like-count');
						likeCountElement.text(response.likeCount);
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
						if (visibility == 0) {
							$('.card-col-container[data-id="' + postId + '"]').remove();
						}
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
	});
</script>