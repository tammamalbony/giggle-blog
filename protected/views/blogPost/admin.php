<?php
/* @var $this BlogPostController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	'Dashboard',
);

?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/custom/vendor/jquery-3.6.0.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/custom/vendor/apexcharts.js"></script>

<h1>Dashboard</h1>

<div class="table-responsive w-100vw" style="margin-top:50px">
	<?php if ($dataProvider->itemCount > 0): ?>
		<table class="table table-bordered table-striped w-100vw">
			<thead>
				<tr>
					<th>Title</th>
					<th>Author</th>
					<th>Category</th>
					<th>Created At</th>
					<th>Visibility</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($dataProvider->data as $post): ?>
					<tr>
						<td><?php echo CHtml::encode($post->title); ?></td>
						<td><?php echo CHtml::encode($post->author->username); ?></td>
						<td><?php echo CHtml::encode($post->category->name); ?></td>
						<td><?php echo CHtml::encode(date('Y-m-d H:i', strtotime($post->created_at))); ?></td>
						<td>
							<div>
								<strong>Visibility:
									<span
										class="visibility-status"><?php echo CHtml::encode($post->visibility == 1 ? 'Public' : 'Private'); ?></span>
								</strong>
								<label class="switch">
									<input type="checkbox" class="visibility-toggle" data-id="<?php echo $post->id; ?>" <?php echo $post->visibility == 1 ? 'checked' : ''; ?>>
									<span class="slider round"></span>
								</label>
							</div>
						</td>
						<td>
							<a href="<?php echo $this->createUrl('view', array('id' => $post->id)); ?>"
								class="btn btn-sm btn-primary"><i class="bi bi-eye"></i></a>
							<a href="<?php echo $this->createUrl('update', array('id' => $post->id)); ?>"
								class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
							<button class="btn btn-sm btn-danger delete-post" data-id="<?php echo $post->id; ?>"><i
									class="bi bi-trash"></i></button>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<div id="areaChart" class=" w-100vw" style="margin-top:50px; overflow-x: hidden; overflow-y:hidden"></div>
	<script>
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
						var statusLabel = visibility == 1 ? 'Public' : 'Private';
						$('.visibility-toggle[data-id="' + postId + '"]').closest('div').find('.visibility-status').text(statusLabel);
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

		$(document).on('click', '.delete-post', function () {
			var postId = $(this).data('id');
			Swal.fire({
				title: 'Are you sure?',
				text: "You won't be able to revert this!",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#d33',
				cancelButtonColor: '#3085d6',
				confirmButtonText: 'Yes, delete it!'
			}).then((result) => {
				if (result.isConfirmed) {
					$.ajax({
						type: 'POST',
						url: '<?php echo Yii::app()->createUrl('blogPost/delete'); ?>',
						data: { id: postId },
						success: function (response) {
							response = JSON.parse(response);
							if (response.status === 'success') {
								Swal.fire(
									'Deleted!',
									'Your post has been deleted.',
									'success'
								);
								location.reload();
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
								text: 'Failed to delete post',
								icon: 'error',
								confirmButtonText: 'OK'
							});
						}
					});
				}
			});
		});
		document.addEventListener("DOMContentLoaded", () => {
			var chartData = <?php echo CJSON::encode($chartData); ?>;

			var dates = chartData.map(data => data.date);
			var interactions =   chartData.map(data => data.likes +   data.comments);

			new ApexCharts(document.querySelector("#areaChart"), {
				series: [{
					name: "Post Interactions",
					data: interactions
				}],
				chart: {
					type: 'area',
					height: 350,
					zoom: {
						enabled: true
					}
				},
				dataLabels: {
					enabled: false
				},
				stroke: {
					colors: ['#EF7D4F']
				},
				fill: {
					type: 'gradient',
					gradient: {
						shadeIntensity: 1,
						opacityFrom: 0.7,
						opacityTo: 0.9,
						stops: [0, 100]
					}
				},
				xaxis: {
					type: 'datetime',
					categories: dates // Use dates from data
				},
				yaxis: {
					opposite: false
				},
				grid: {
					strokeDashArray: 5
				},
				legend: {
					horizontalAlign: 'left'
				}
			}).render();
		});
	</script>

<?php else: ?>
	<div style="margin-top: 50px;">

		<p>No posts available. Click below to create a new post.</p>
		<li><a href="<?php echo Yii::app()->createUrl('blogPost/create'); ?>"><img
					src="<?php echo Yii::app()->request->baseUrl; ?>/custom/img/s1/i1.png" class="icon_image"
					alt="Create New Posts">Create New Post</a></li>
	</div>

<?php endif; ?>