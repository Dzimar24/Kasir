<div class="container text-center">
	<div class="row justify-content-end">
		<div class="col-1 m-1">
			<button type="button" class="btn btn-outline-primary block" data-bs-toggle="modal" data-bs-target="#ok">
				+ User
			</button>
		</div>
	</div>
</div>
<section class="section">
	<div class="card mt-3">
		<div class="card-body">
			<div class="table-responsive">
				<table class="table display nowrap" style="width: 100%;" id="myTable">
					<thead>
						<tr>
							<th>No</th>
							<th>Username</th>
							<th>Name</th>
							<th class="col-1">Level</th>
							<th class="col-1">Action</th>
						</tr>
					</thead>
					<tbody>

					</tbody>
				</table>
			</div>
		</div>
	</div>
</section>

<!-- Modal Plus -->
<div class="modal fade text-left modal-borderless" id="ok" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
	aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalTitle">Modal Title</h5>
				<button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
					<i data-feather="x"></i>
				</button>
			</div>
			<?php $attributes = array('id' => 'formInput', 'class' => 'form-control'); ?>
			<?= form_open('User/userPlus', $attributes) ?>
			<!-- <div class="msg" style="display: none;"></div> -->
			<div class="modal-body">
				<div class="form-body">
					<div class="row">
						<div class="form-group">
							<div class="form-group mandatory">
								<label for="username">Username</label>
								<div class="position-relative has-validation">
									<input name="username" type="text" class="form-control mt-2" id="username">
									<div class="invalid-feedback" id="msg">
										<p class="text-danger" id="username_error"></p>
									</div>
								</div>
							</div>
							<div class="form-group mandatory">
								<label for="name">Name</label>
								<div class="position-relative">
									<input name="nama" type="text" class="form-control mt-2" id="name">
									<div class="invalid-feedback">
										<p class="text-danger" id="nama_error"></p>
									</div>
								</div>
							</div>
							<div class="form-group mandatory">
								<label for="password">Password</label>
								<div class="position-relative">
									<input name="password" type="password" class="form-control mt-2" id="password">
									<div class="invalid-feedback">
										<p class="text-danger" id="password_error"></p>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="level">Level</label>
								<div class="position-relative m-1">
									<select class="form-select" id="level" name="level">
										<option value="">-- Option --</option>
										<option value="Kasir">Kasir</option>
										<option value="Admin">Admin</option>
									</select>
									<p class="text-danger" id="level_error"></p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-light-primary" data-bs-dismiss="modal">
					Close
				</button>
				<button type="submit" class="btn btn-primary ms-1" data-bs-dismiss="modal">
					Save
				</button>
			</div>
			<?= form_close() ?>
		</div>
	</div>
</div>

<div class="viewModal" style="display: none;"></div>

<!-- JQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>

<script>
	function viewsData() {
		table = $('#myTable').DataTable({
			responsive: true,
			"destroy": true,
			"processing": true,
			"serverSide": true,
			"order": [],

			"ajax": {
				"url": "<?= site_url('User/getData') ?>",
				"type": "POST"
			},


			"columnDefs": [{
				"targets": [0],
				"orderable": false,
				"width": 5
			}],

		});
	}



	$('#modalTitle').text('Plus User');
	$('#modalTitleUpdate').text('Update User');

	$(document).ready(function () {

		viewsData();

		//! form Input User
		$('#formInput').submit(function (e) {

			//? Validation before form submit
			$('#formInput').find('input').each(function () {
				//? Validation Username 
				if ($('#username').val().length < 5) {
					$('#username').addClass('is-invalid');
					$('#username_error').html('');
				} else {
					$('#username').removeClass('is-invalid');
					$('#username').addClass('is-valid');
					$('#username_error').html('');
				}

				//? Validation Name 
				if ($('#name').val().length < 5) {
					$('#name').addClass('is-invalid');
					$('#name_error').html('');
				} else {
					$('#name').removeClass('is-invalid');
					$('#name').addClass('is-valid');
					$('#name_error').html('');
				}

				//? Validation Password 
				if ($('#password').val().length < 5) {
					$('#password').addClass('is-invalid');
					$('#password_error').html('');
				} else {
					$('#password').removeClass('is-invalid');
					$('#password').addClass('is-valid');
					$('#password_error').html('');
				}

				//? Validation level 
				if (!$('#level').val()) {
					$('#level').addClass('is-invalid');
					$('#level_error').html('');
				} else {
					$('#level').removeClass('is-invalid');
					$('#level').addClass('is-valid');
					$('#level_error').html('');
				}
			});

			//? Kirim form melalui AJAX jika validasi dinamis selesai
			$.ajax({
				type: "POST",
				url: $(this).attr('action'),
				data: $(this).serialize(),
				dataType: "JSON",
				success: function (response) {
					if (response.error) {
						$.each(response.error, function (field, message) {
							$('#' + field + '_error').html(message);
						});
					}
					/** 
					 * 
						else {
							$('#ok').modal('hide'); // Tutup modal jika berhasil
						}
					*/

					if (response.success) {
						Swal.fire({
							icon: "success",
							title: "Success Add Data",
							text: response.success,
						});
						viewsData();
						$('#ok').modal('hide'); // Tutup modal jika berhasil
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
				}
			});

			return false;
		});
	});

	$('.modal-footer button[type="submit"]').removeAttr('data-bs-dismiss');

	var urlUpdate = "<?php echo base_url('User/modalUpdate') ?>"
	var urlDelete = "<?php echo site_url('User/deleteData') ?>"
	var urlResetPassword = "<?php echo base_url('User/resetPassword') ?>"

	//? Featured Model Update
	function update(username) {
		$.ajax({
			type: "POST",
			url: urlUpdate,
			data: {
				username: username
			},
			dataType: "JSON",
			success: function (response) {
				$('.viewModal').html(response.success).show();
				$('#modalUpdate').on('shown.bs.modal', function (e) {
					$('#nama').focus();
				})
				$('#modalUpdate').modal('show');
			}
		});
	}

	//? Function Deleted
	function deleted(username) {
		Swal.fire({
			title: '<strong>Delete</strong>',
			text: `Are you sure you want to Delete the user data with the username : ${username} ?`,
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, Delete',
			cancelButtonText: 'Cancel'
		}).then((result) => {
			if (result.value) {
				$.ajax({
					type: "post",
					url: urlDelete,
					data: {
						username: username,
					},
					dataType: "json",
					success: function (response) {
						if (response.success) {
							Swal.fire({
								icon: 'success',
								title: 'Confirmation',
								text: response.success
							});
							viewsData();
						}
					}
				});
			}
		})
	}

	function resetPassword(username) {
		Swal.fire({
			title: '<b>Reset Password</b>',
			text: `Are you sure you want to reset the password for username : ${username} ?`,
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, Reset Password',
			cancelButtonText: 'Cancel'
		}).then((result) => {
			if (result.value) {
				$.ajax({
					type: "post",
					url: urlResetPassword,
					data: {
						username: username,
					},
					dataType: "json",
					success: function (response) {
						if (response.success) {
							Swal.fire({
								icon: 'success',
								title: 'Confirmation',
								text: response.success
							});
							viewsData();
						}
					}
				});
			}
		})
	}
</script>
