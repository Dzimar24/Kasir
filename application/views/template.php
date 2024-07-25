<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= $title ?></title>
	<!-- Css -->
	<?php include 'pages/__css.php'?>
</head>

<body>
	<script src="<?= base_url('/src/mazer/') ?>assets/static/js/initTheme.js"></script>
	<div id="app">
		<!-- SideBar -->
		<?php include 'pages/_sidebar.php'; ?>

		<div id="main" class='layout-navbar navbar-fixed'>
			<!-- Navbar -->
			<?php include 'pages/__navbar.php' ?>

			<?php $menu = $this->uri->segment(1); ?>
			<!-- Main Content -->
			<div id="main-content">
				<div class="page-heading">
					<div class="page-title">
						<div class="row">
							<div class="col-12 col-md-6 order-md-1 order-last">
								<?php if ($menu == 'Dashboard') { ?>
									<h3>Hello Diablos</h3>
									<p class="text-subtitle text-muted">Welcome to <b><?= $title ?></b> page.</p>
								<?php } else { ?>
									<h3>Page <?= $title ?></h3>
								<?php } ?>
							</div>
							<div class="col-12 col-md-6 order-md-2 order-first">
								<nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
									<ol class="breadcrumb">
										<li class="breadcrumb-item"><a href="index.html"><?= $title ?></a></li>
										</li>
									</ol>
								</nav>
							</div>
						</div>
					</div>
					<!-- This Content -->
					<section class="section">
						<?= $contents ?>
					</section>
				</div>

			</div>
			
			<!-- Footer -->
			<?php include 'pages/__footer.php'?>
		</div>
	</div>
	
	<!-- Js -->
	<?php include 'pages/__js.php'?>

</body>

</html>
