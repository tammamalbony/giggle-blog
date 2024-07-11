<div class="container controls_filters" style="margin-top: 100px;">
	<div class="row">
		<div class="col-12 text-center flex-column d-flex justify-content-center">
			<div class="text-center">
				<h2>Update Blog Post</h2>
			</div>

			<?php $form = $this->beginWidget(
				'CActiveForm',
				array(
					'id' => 'blog-post-form',
					'enableAjaxValidation' => true,
					'enableClientValidation' => true,
					'htmlOptions' => array(
						'class' => 'justify-content-center align-items-center mt-5 needs-validation',
						'novalidate' => true,
						'enctype' => 'multipart/form-data'
					),
				)
			); ?>
			<?php echo $form->hiddenField($model, 'id'); ?>
			<div class="mb-3">
				<?php echo $form->labelEx($model, 'title', array('class' => 'form-label')); ?>
				<?php echo $form->textField($model, 'title', array('class' => 'form-control', 'placeholder' => 'Title', 'required' => true, 'maxlength' => 255)); ?>
				<?php echo $form->error($model, 'title', array('class' => 'invalid-feedback')); ?>
			</div>

			<div class="mb-3">
				<?php echo $form->labelEx($model, 'description', array('class' => 'form-label')); ?>
				<?php echo $form->textArea($model, 'description', array('class' => 'form-control', 'placeholder' => 'Description', 'rows' => 6, 'required' => true)); ?>
				<?php echo $form->error($model, 'description', array('class' => 'invalid-feedback')); ?>
			</div>

			<div class="mb-3">
				<?php echo $form->labelEx($model, 'content', array('class' => 'form-label')); ?>
				<?php echo $form->textArea($model, 'content', array('class' => 'form-control', 'placeholder' => 'Content', 'rows' => 6, 'required' => true)); ?>
				<?php echo $form->error($model, 'content', array('class' => 'invalid-feedback')); ?>
			</div>

			<div class="mb-3">
				<?php echo $form->labelEx($model, 'visibility', array('class' => 'form-label')); ?>
				<?php echo $form->dropDownList($model, 'visibility', array(1 => 'Public', 0 => 'Private'), array('class' => 'form-control')); ?>
				<?php echo $form->error($model, 'visibility', array('class' => 'invalid-feedback')); ?>
			</div>

			<div class="mb-3 image-preview">
				<?php echo $form->labelEx($model, 'image', array('class' => 'form-label')); ?>
				<input type="file" id="image-file" class="form-control" accept="image/*">
				<?php echo $form->hiddenField($model, 'image', array('id' => 'BlogPost_image')); ?>
				<img id="image-preview" src="<?php echo "/";
				echo isset($_ENV['UPLOAD_DIR']) ? $_ENV['UPLOAD_DIR'] : "uploads";
				echo "/";
				echo CHtml::encode($model->image); ?>" class="img-fluid" alt="Image Preview"
					style="max-width: 100%; display: <?php echo $model->image ? 'block' : 'none'; ?>;">
				<div class="mt-2 btn-container">
					<button type="button" id="upload-image-btn" class="btn btn-secondary mx-1"
						style="display: <?php echo $model->image ? 'inline-block' : 'none'; ?>;">
						<i class="bi bi-cloud-upload"></i> <strong class="d-none d-md-inline-block "> Upload
						</strong></button>
					<button type="button" id="preview-image-btn" class="btn btn-info"
						style="display: <?php echo $model->image ? 'inline-block' : 'none'; ?>;"><i
							class="bi bi-eye"></i><strong class="d-none d-md-inline-block "> Preview</strong></button>
					<button type="button" id="clear-image-btn" class="btn btn-danger"
						style="display: <?php echo $model->image ? 'inline-block' : 'none'; ?>;"><i
							class="bi bi-x-circle"></i><strong class="d-none d-md-inline-block "> Clear
						</strong></button>
				</div>
				<?php echo $form->error($model, 'image', array('class' => 'invalid-feedback')); ?>
			</div>

			<div class="mb-3 image-preview">
				<?php echo $form->labelEx($model, 'cover_image', array('class' => 'form-label')); ?>
				<input type="file" id="cover-image-file" class="form-control" accept="image/*">
				<?php echo $form->hiddenField($model, 'cover_image', array('id' => 'BlogPost_cover_image')); ?>
				<img id="cover-image-preview" src="<?php echo "/";
				echo isset($_ENV['UPLOAD_DIR']) ? $_ENV['UPLOAD_DIR'] : "uploads";
				echo "/";
				echo CHtml::encode($model->cover_image); ?>" class="img-fluid" alt="Cover Image Preview"
					style="max-width: 100%; display: <?php echo $model->cover_image ? 'block' : 'none'; ?>;">
				<div class="mt-2 btn-container">
					<button type="button" id="upload-cover-image-btn" class="btn btn-secondary mx-1"
						style="display: <?php echo $model->cover_image ? 'inline-block' : 'none'; ?>;">
						<i class="bi bi-cloud-upload"></i> <strong class="d-none d-md-inline-block "> Upload
						</strong></button>

					<button type="button" id="preview-cover-image-btn" class="btn btn-info"
						style="display: <?php echo $model->cover_image ? 'inline-block' : 'none'; ?>;"><i
							class="bi bi-eye"></i><strong class="d-none d-md-inline-block "> Preview </strong></button>
					<button type="button" id="clear-cover-image-btn" class="btn btn-danger"
						style="display: <?php echo $model->cover_image ? 'inline-block' : 'none'; ?>;"><i
							class="bi bi-x-circle"></i><strong class="d-none d-md-inline-block"> Clear</strong>
					</button>
				</div>
				<?php echo $form->error($model, 'cover_image', array('class' => 'invalid-feedback')); ?>
			</div>

			<div class="mb-3">
				<?php echo $form->labelEx($model, 'category_id', array('class' => 'form-label')); ?>
				<?php echo $form->dropDownList($model, 'category_id', $categories, array('class' => 'form-control')); ?>
				<?php echo $form->error($model, 'category_id', array('class' => 'invalid-feedback')); ?>
			</div>

			<div class="row buttons">
				<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-primary btnmain mt-3')); ?>
			</div>

			<?php $this->endWidget(); ?>

		</div>
	</div>
</div>

<script>
	(function () {
		'use strict';
		var forms = document.querySelectorAll('.needs-validation');
		Array.prototype.slice.call(forms)
			.forEach(function (form) {
				form.addEventListener('submit', function (event) {
					if (!form.checkValidity()) {
						event.preventDefault();
						event.stopPropagation();
					}
					form.classList.add('was-validated');
				}, false);
			});
	})();

	document.addEventListener('DOMContentLoaded', function () {
		if ($('#BlogPost_image').val()) {
			$('#image-preview').show();
			$('#preview-image-btn').show();
			$('#clear-image-btn').show();
			$('#upload-image-btn').hide();
			checkImageExists($('#BlogPost_image').val(), 'image');
		}

		if ($('#BlogPost_cover_image').val()) {
			$('#cover-image-preview').show();
			$('#preview-cover-image-btn').show();
			$('#clear-cover-image-btn').show();
			$('#upload-cover-image-btn').show();
			$('#upload-cover-image-btn').hide();
			checkImageExists($('#BlogPost_cover_image').val(), 'cover-image');
		}
	});


	function previewImage(input, type, hiddenFieldId) {
		if (input.files && input.files[0]) {
			var file = input.files[0];
			validateImage(file, function (error) {
				if (error) {
					Swal.fire('Error!', error, 'error');
					return;
				}

				var formData = new FormData();
				formData.append(type, file);

				$.ajax({
					url: '<?php echo Yii::app()->createUrl("blogPost/checkImageExists"); ?>',
					type: 'POST',
					data: { url: file.name },
					success: function (response) {
						var data = JSON.parse(response);
						console.log(hiddenFieldId);
						if (data.status !== 'success') {
							if (data.message == "File does not exist") {
								Swal.fire('warning!', "File does not exist At server ", 'warning');
								$("#upload-" + hiddenFieldId + "-btn").show()
							}
							else {
								Swal.fire('Error!', data.message, 'error');
								$("#upload-" + hiddenFieldId + "-btn").hide()
							}
						} else {
							Swal.fire('Success!', data.message, 'success');
							$("#upload-" + hiddenFieldId + "-btn").hide()
						}
					},
					error: function () {
						Swal.fire('Error!', 'Could not verify the image on the server.', 'error');
					}
				});
			});
		}
	}

	function validateImage(file, callback) {
		var img = new Image();
		var reader = new FileReader();

		reader.onload = function (e) {
			img.src = e.target.result;
			img.onload = function () {
				var width = this.width;
				var height = this.height;
				var size = file.size / 1024; // size in KB
				var type = file.type;

				if (width > <?php echo isset($_ENV['MAX_IMAGE_WIDTH']) ? $_ENV['MAX_IMAGE_WIDTH'] : 1023 ?> || height > <?php echo isset($_ENV['MAX_IMAGE_HIGHT']) ? $_ENV['MAX_IMAGE_HIGHT'] : 1024 ?>) {
					callback('Image dimensions should not exceed \n <?php echo isset($_ENV['MAX_IMAGE_WIDTH']) ? $_ENV['MAX_IMAGE_WIDTH'] : 1023 ?>px *  <?php echo isset($_ENV['MAX_IMAGE_HIGHT']) ? $_ENV['MAX_IMAGE_HIGHT'] : 1024 ?>px.');
				} else if (size > <?php echo isset($_ENV['MAX_IMAGE_SIZE']) ? $_ENV['MAX_IMAGE_SIZE'] : 1023 ?>) {
					callback('Image size should not exceed 1024KB.');
				} else if (!type.startsWith('image/')) {
					callback('File type must be an image.');
				} else {
					callback(null);
				}
			};
		};

		reader.readAsDataURL(file);
	}

	function checkImageExists(url, hiddenFieldId) {
		$.ajax({
			url: '<?php echo Yii::app()->createUrl("blogPost/checkImageExists"); ?>',
			type: 'POST',
			data: { url: url },
			success: function (response) {
				var data = JSON.parse(response);
				if (data.status !== 'success') {
					Swal.fire('Error!', data.message, 'error');
					$('#' + hiddenFieldId).val('');
					$('#' + hiddenFieldId.replace('_image', '-image-btn')).show();
				} else {
					Swal.fire('Success!', data.message, 'success');
					$('#' + hiddenFieldId.replace('_image', '-image-btn')).hide();
				}
			},
			error: function () {
				Swal.fire('Error!', 'Could not verify the image on the server.', 'error');
				$('#' + hiddenFieldId).val('');
				$('#' + hiddenFieldId.replace('_image', '-image-btn')).show();
			}
		});
	}


	$('#image-file').on('change', function () {
		previewImage(this, 'image', 'image');

	});

	$('#cover-image-file').on('change', function () {
		previewImage(this, 'cover-image', 'cover-image');
	});

	$('#preview-image-btn').on('click', function () {
		var glightbox = GLightbox({
			elements: [
				{
					'href': $('#image-preview').attr('src'),
					'type': 'image'
				}
			]
		});
		glightbox.open();
	});

	$('#preview-cover-image-btn').on('click', function () {
		var glightbox = GLightbox({
			elements: [
				{
					'href': $('#cover-image-preview').attr('src'),
					'type': 'image'
				}
			]
		});
		glightbox.open();
	});

	$('#clear-image-btn').on('click', function () {
		$('#image-file').val('');
		$('#BlogPost_image').val('');
		$('#image-preview').hide();
		$('#preview-image-btn').hide();
		$('#clear-image-btn').hide();
		$('#upload-image-btn').hide();
	});

	$('#clear-cover-image-btn').on('click', function () {
		$('#cover-image-file').val('');
		$('#BlogPost_cover_image').val('');
		$('#cover-image-preview').hide();
		$('#preview-cover-image-btn').hide();
		$('#clear-cover-image-btn').hide();
		$('#upload-cover-image-btn').hide();
	});

	$('#blog-post-form input[type="text"], #blog-post-form textarea').on('input', function () {
		var minLength = 3;
		if (this.value.length >= minLength) {
			$(this).removeClass('is-invalid').addClass('is-valid');
		} else {
			$(this).removeClass('is-valid').addClass('is-invalid');
		}
	});

	$('#upload-image-btn').on('click', function () {
		var fileInput = $('#image-file')[0];
		if (fileInput.files.length === 0) {
			Swal.fire('Please select an image to upload.');
			return;
		}

		var formData = new FormData();
		formData.append('image', fileInput.files[0]);

		$.ajax({
			url: '<?php echo Yii::app()->createUrl("blogPost/uploadImage"); ?>',
			type: 'POST',
			data: formData,
			contentType: false,
			processData: false,
			success: function (response) {
				var data = JSON.parse(response);
				if (data.status === 'success') {
					$('#BlogPost_image').val(data.url);
					Swal.fire('Success!', 'Image uploaded successfully.', 'success');
					$('#image-file').removeClass('is-invalid').addClass('is-valid');
				} else {
					Swal.fire('Error!', data.message, 'error');
					$('#image-file').addClass('is-invalid');
				}
			},
			error: function () {
				Swal.fire('Error!', 'Image upload failed.', 'error');
				$('#image-file').addClass('is-invalid');
			}
		});
	});

	$('#upload-cover-image-btn').on('click', function () {
		var fileInput = $('#cover-image-file')[0];
		console.log(fileInput);
		if (fileInput.files.length === 0) {
			Swal.fire('Please select a cover image to upload.');
			return;
		}

		var formData = new FormData();
		formData.append('cover_image', fileInput.files[0]);

		$.ajax({
			url: '<?php echo Yii::app()->createUrl("blogPost/uploadImage"); ?>',
			type: 'POST',
			data: formData,
			contentType: false,
			processData: false,
			success: function (response) {
				var data = JSON.parse(response);
				if (data.status === 'success') {
					$('#BlogPost_cover_image').val(data.url);
					Swal.fire('Success!', 'Cover image uploaded successfully.', 'success');
					$('#cover-image-file').removeClass('is-invalid').addClass('is-valid');
				} else {
					Swal.fire('Error!', data.message, 'error');
					$('#cover-image-file').addClass('is-invalid');
				}
			},
			error: function () {
				Swal.fire('Error!', 'Cover image upload failed.', 'error');
				$('#cover-image-file').addClass('is-invalid');
			}
		});
	});


	$('#blog-post-form').on('submit', function (event) {
		event.preventDefault(); // Prevent the default form submission

		var form = $(this);
		var valid = true;



		form.find('input[type="text"], textarea').each(function () {
			if (this.value.length < 3) {
				$(this).addClass('is-invalid');
				valid = false;
			} else {
				$(this).removeClass('is-invalid').addClass('is-valid');
			}
		});

		if (!valid || form[0].checkValidity() === false) {
			event.stopPropagation();
			form.addClass('was-validated');
			return;
		}

		var imageUrl = $('#BlogPost_image').val();
		var coverImageUrl = $('#BlogPost_cover_image').val();

		function checkImageExists(url, callback) {
			$.ajax({
				url: '<?php echo Yii::app()->createUrl("blogPost/checkImageExists"); ?>',
				type: 'POST',
				data: { url: url },
				success: function (response) {
					var data = JSON.parse(response);
					callback(data.status === 'success');
				},
				error: function () {
					callback(false);
				}
			});
		}

		checkImageExists(imageUrl, function (imageExists) {
			if (!imageExists) {
				Swal.fire('Error!', 'The image URL does not exist or is not an image.', 'error');
				$('#image-file').addClass('is-invalid');
				return;
			}

			checkImageExists(coverImageUrl, function (coverImageExists) {
				if (!coverImageExists) {
					Swal.fire('Error!', 'The cover image URL does not exist or is not an image.', 'error');
					$('#cover-image-file').addClass('is-invalid');
					return;
				}

				var submitButton = $('.loading-btn');
				submitButton.prop('disabled', true).text('Submitting...');
				submitButton.addClass("loading-btn");

				var formData = new FormData(form[0]);

				$.ajax({
					url: '<?php echo Yii::app()->createUrl("blogPost/update"); ?>',
					type: 'POST',
					data: formData,
					contentType: false,
					processData: false,
					success: function (response) {
						var data = JSON.parse(response);
						if (data.status === 'success') {
							Swal.fire({
								title: 'Success!',
								text: 'The blog post has been updated successfully.',
								icon: 'success',
								confirmButtonText: 'OK'
							}).then((result) => {
								if (result.isConfirmed) {
									window.location.href = '<?php echo Yii::app()->createUrl("blogPost/view", array("id" => "")); ?>' + "/" + data.id;
								}
							});
						} else {
							Swal.fire('Error!', 'Form submission failed. Please try again.', 'error');
							submitButton.prop('disabled', false).text('Save');
							submitButton.removeClass("loading-btn");
						}
					},
					error: function (response) {
						Swal.fire('Error!', 'Form submission failed. Please try again.', 'error');
						console.error('Form submission failed:', response);
						submitButton.prop('disabled', false).text('Save');
						submitButton.removeClass("loading-btn");
					}
				});
			});
		});
	});

	<?php if (isset($_ENV['EDITOR_ENABLE']) && $_ENV['EDITOR_ENABLE'] === "TRUE") { ?>
		$(document).ready(function () {
			$('#BlogPost_description').summernote({
				height: 300,
				tooltip: false
			});
			$('#BlogPost_content').summernote({
				height: 300,
				tooltip: false
			});
		});
	<?php } ?>
</script>