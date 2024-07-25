<div class="flash-data" data-flashdata="<?= $this->session->flashdata('ok') ?>"></div>
<header>
	<nav class="navbar navbar-expand navbar-light navbar-top">
		<div class="container-fluid">
			<div class="simbol">
				<a href="#" class="burger-btn d-block">
					<i class="bi bi-justify fs-3"></i>
				</a>
			</div>

			<button class="navbar-toggler" type="button" data-bs-toggle="collapse"
				data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
				aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<div class="navbar-nav ms-auto mb-lg-0">
					<div class="dropdown">
						<a href="#" data-bs-toggle="dropdown" aria-expanded="false">
							<div class="user-menu d-flex">
								<div class="user-name text-end me-3">
									<h6 class="mb-0 text-gray-600">
										<?= $this->session->userdata('nama'); ?>
									</h6>
									<p class="mb-0 text-sm text-gray-600">
										<?=
											$this->session->userdata('level');
										?>
									</p>
								</div>
								<div class="user-img d-flex align-items-center">
									<div class="avatar avatar-md">
										<img src="<?= base_url('/src/mazer/') ?>/assets/compiled/jpg/1.jpg">
									</div>
								</div>
							</div>
						</a>
						<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton"
							style="min-width: 11rem;">
							<li>
								<h6 class="dropdown-header">Hello, Diablos!</h6>
							</li>
							<li>
								<a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#exampleModalCenter">
									<i class="bi bi-info-circle me-2"></i>
									Profile Information
								</a>
							</li>
							<hr class="dropdown-divider">
							</li>
							<li><a class="dropdown-item log-out" href="<?= site_url('Auth/logOut') ?>"><i class="icon-mid bi bi-box-arrow-left me-2"></i> Logout</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</nav>
</header>

<!-- Vertically Centered modal Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
	aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalCenterTitle">Information Account</h5>
				<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
					<i data-feather="x"></i>
				</button>
			</div>
			<div class="modal-body">
				<div class="row g-2">
					<div class="col-md">
						<div class="form-group mandatory">
							<label for="total_suara_sah_24">This account has a username : </label>
							<div class="position-relative has-validation mt-2">
								<input class="form-control" readonly
									value="<?= $this->session->userdata('username'); ?>" type="text">

							</div>
						</div>
					</div>
					<div class="col-md">
						<div class="form-group mandatory">
							<label for="total_suara_tidak_sah_24">This account has a Level :</label>
							<div class="position-relative has-validation mt-2">
								<input class="form-control" readonly value="<?= $this->session->userdata('level'); ?>"
									type="text">
							</div>
						</div>
					</div>
					<div class="form-group mandatory">
						<label for="total_suara_tidak_sah_24">This account has a name :</label>
						<div class="position-relative has-validation mt-2">
							<input class="form-control" readonly value="<?= $this->session->userdata('nama'); ?>"
								type="text">
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-light-primary" data-bs-dismiss="modal">
					<i class="bx bx-x d-block d-sm-none"></i>
					<span class="d-none d-sm-block">Close</span>
				</button>
			</div>
		</div>
	</div>
</div>

<!-- Connection JQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="<?= base_url('/src/mazer/assets/static/js/pages/my.js') ?>"></script>
