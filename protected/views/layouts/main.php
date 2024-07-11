<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="en">
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">

	<meta name="description" content="Giggle and Post Website" />
	<meta property="og:title" content="Giggle Website" />
	<meta property="og:url" content="https://www.Glitch-it.net/" />
	<meta property="og:description" content="𝑷𝒓𝒐𝒈𝒓𝒂𝒎𝒎𝒊𝒏𝒈" />
	<meta property="og:image" content="https://glitch-it.net/custom/img/bg.png" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css"
		media="screen, projection">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css"
		media="print">
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection">
	<![endif]-->

	<link href="<?php echo Yii::app()->request->baseUrl; ?>/custom/img/favicon.png" rel="icon">
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/custom/img/apple-touch-icon.png" rel="apple-touch-icon">

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700&display=swap"
		rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@100..900&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
		rel="stylesheet">

	<link href="<?php echo Yii::app()->request->baseUrl; ?>/custom/vendor/bootstrap/css/bootstrap.min.css"
		rel="stylesheet">
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/custom/vendor/bootstrap-icons/bootstrap-icons.css"
		rel="stylesheet">
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/custom/vendor/aos/aos.css" rel="stylesheet">
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/custom/vendor/glightbox/css/glightbox.min.css"
		rel="stylesheet">
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/custom/vendor/swiper/swiper-bundle.min.css"
		rel="stylesheet">
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/custom/vendor/sweetAlert2/sweetalert2.min.css"
		rel="stylesheet">

	<!-- <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css"> -->
	<!-- <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css"> -->


	<link href="<?php echo Yii::app()->request->baseUrl; ?>/custom/css/main.css" rel="stylesheet">
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/custom/css/custom.css" rel="stylesheet">

	<link rel="manifest" href="/manifest.json">
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

</head>

<body class="section2-bg">
	<header id="header" class="header fixed-top d-flex align-items-center">
		<div class="container d-flex align-items-center justify-content-between">

			<a href="<?php echo Yii::app()->createUrl('site/index'); ?>"
				class="logo d-flex align-items-center me-auto me-lg-0">
				<img src="<?php echo Yii::app()->request->baseUrl; ?>/custom/img/logoB.png" alt="Giggle Logo">
			</a>
			<?php if (Yii::app()->user->hasFlash('error')): ?>
				<div class="alert alert-danger">
					<?php echo Yii::app()->user->getFlash('error'); ?>
				</div>
			<?php endif; ?>
			<nav id="navbar" class="navbar">
				<ul>
					<li><a href="<?php echo Yii::app()->createUrl('site/index'); ?>" class="ActiveNavIteam">Home</a>
					</li>

					<?php if (!Yii::app()->user->isGuest && Yii::app()->user->getState('isVerified')) { ?>
						<li><a href="<?php echo Yii::app()->createUrl('blogPost/index'); ?>">Blog</a></li>
					<?php } ?>
					<?php if (!Yii::app()->user->isGuest) { ?>
						<li class="dropdown"><a href="#"><img
									src="<?php echo Yii::app()->request->baseUrl; ?>/custom/img/s1/u1.jpg"
									class="img-fluid user_image" alt="User Image">
								<span><?php echo Yii::app()->user->name ?></span></a>
							<ul>

								<?php if (!Yii::app()->user->getState('isVerified')) { ?>
									<li><a href="<?php echo Yii::app()->createUrl('user/verification'); ?>"><img
												src="<?php echo Yii::app()->request->baseUrl; ?>/custom/img/s1/i1.png"
												class="icon_image" alt="Verify">Verify Account</a></li>
								<?php } ?>
								<?php if (!Yii::app()->user->isGuest && Yii::app()->user->getState('isVerified')) { ?>
									<li><a href="<?php echo Yii::app()->createUrl('blogPost/admin'); ?>"><img
												src="<?php echo Yii::app()->request->baseUrl; ?>/custom/img/s1/i4.png"
												class="icon_image" alt="My Posts">My Posts</a></li>
								<?php } ?>
								<li><a href="<?php echo Yii::app()->createUrl('site/logout'); ?>"><img
											src="<?php echo Yii::app()->request->baseUrl; ?>/custom/img/s1/i2.png"
											class="icon_image"
											alt="Logout"><?php echo 'Logout (' . Yii::app()->user->name . ')' ?></a></li>
							</ul>
						</li>
						<?php if (Yii::app()->user->isGuest) { ?>
							<a class="btn-book-a-tabled-block d-md-none w-50"
								href="<?php echo Yii::app()->createUrl('site/login'); ?>" id="loginLink">Login</a>

						<?php } else { ?>
							<a class="btn-book-a-tabled-block d-md-none w-50"
								href="<?php echo Yii::app()->createUrl('site/logout'); ?>"><?php echo 'Logout (' . Yii::app()->user->name . ')' ?></a>

						<?php } ?>
					</ul>
				<?php } else { ?>
					<li><a href="<?php echo Yii::app()->createUrl('site/login'); ?>">Login</a></li>
					<li><a href="<?php echo Yii::app()->createUrl('user/register'); ?>">Register</a></li>
				<?php } ?>
			</nav>
			<div class="input-group flex-nowrap SearchInput">
				<input type="text" class="form-control" id="SearchInput" placeholder="Search">
				<i class="bi bi-search textGM"></i>
			</div>
			<?php if (Yii::app()->user->isGuest) { ?>
				<a class="btn-book-a-table d-none d-md-block" href="<?php echo Yii::app()->createUrl('site/login'); ?>"
					id="loginLink">Login</a>

			<?php } else { ?>
				<a class="btn-book-a-table d-none d-md-block"
					href="<?php echo Yii::app()->createUrl('site/logout'); ?>"><?php echo 'Logout (' . Yii::app()->user->name . ')' ?></a>

			<?php } ?>

			<i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
			<i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>

		</div>
	</header>
	<main id="main">
		<?php echo $content; ?>
	</main>
	<footer id="footer" class="footer mt-5 mb-0 mx-0">

		<div class="container-fluid m-0 p-0 footerleft">
			<div class="row  m-0 p-0 footerright">
				<div class="col-12 footer-links  mt-5 text-center">
					<div>
						<?php if (isset($this->breadcrumbs)): ?>
							<?php $this->widget(
								'zii.widgets.CBreadcrumbs',
								array(
									'links' => $this->breadcrumbs,
								)
							); ?><!-- breadcrumbs -->
						<?php endif ?>
						<img src="<?php echo Yii::app()->request->baseUrl; ?>/custom/img/logo.png" alt="Giggle logo"
							class="img-fluid footerlogo">
					</div>
					<div>
						<div class="social-links d-flex text-center my-3">
							<a href="#" class="twitter"><img
									src="<?php echo Yii::app()->request->baseUrl; ?>/custom/img/s1/icon_x.svg"
									class="img-fluid"></a>
							<a href="#" class="youtube"><img
									src="<?php echo Yii::app()->request->baseUrl; ?>/custom/img/s1/icon_youtube.svg"
									class="img-fluid"></a>
							<a href="#" class="telegram"><img
									src="<?php echo Yii::app()->request->baseUrl; ?>/custom/img/s1/icon_telegram.svg"
									class="img-fluid"></a>
							<a href="#" class="email"><img
									src="<?php echo Yii::app()->request->baseUrl; ?>/custom/img/s1/icon_email.svg"
									class="img-fluid"></a>
						</div>
					</div>
					<div class="my-2">
						<h6>Download Our App to see all Posts and Giggle on your mobile</h6>
					</div>
					<div class="d-flex justify-content-center">
						<img src="<?php echo Yii::app()->request->baseUrl; ?>/custom/img/s1/button-app.svg" class="m-2"
							alt="app store download">
						<img src="<?php echo Yii::app()->request->baseUrl; ?>/custom/img/s1/button-play.svg"
							alt="play store download" class="m-2">
					</div>
					<div class="container">
						<div class="copyright">
							&copy; <strong><span>2023</span></strong>. All Rights Reserved By <strong><span
									class="text-white">Giggle</span></strong>
						</div>
					</div>
					<div class="d-flex justify-content-center endfooter">
						<a href="Conditions.html" class="m-1"> <u class="text-white footer-link"> Terms and Conditions
							</u> </a>
						<a href="#" class="m-1 text-white">|</a>
						<a href="Privacy.html" class="m-1"> <u class="text-white footer-link"> Privacy Policy </u> </a>
						<a href="#" class="m-1 text-white">|</a>
						<a href="#" class="m-1"> <u class="text-white footer-link"> FAQ </u> </a>
					</div>
				</div>
			</div>
		</div>

	</footer>
	<script>
		var clickableCards = document.querySelectorAll(".clickable-card");
		clickableCards.forEach(function (card) {
			card.addEventListener("click", function () {
				var link = card.dataset.link;
				if (link) {
					window.location.href = link;
				}
			});
		});
	</script>
	<a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i
			class="bi bi-arrow-up-short"></i></a>

	<div id="preloader"></div>
	<script
		src="<?php echo Yii::app()->request->baseUrl; ?>/custom/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/custom/vendor/aos/aos.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/custom/vendor/glightbox/js/glightbox.min.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/custom/vendor/purecounter/purecounter_vanilla.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/custom/vendor/swiper/swiper-bundle.min.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/custom/vendor/php-email-form/validate.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/custom/vendor/sweetAlert2/sweetalert2.all.min.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/custom/js/main.js"></script>

</body>

</html>