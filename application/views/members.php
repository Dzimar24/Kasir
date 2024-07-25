<section class="section">
	<div class="card mt-3">
		<div class="card-body">
			<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#lok">
				<i class="bi bi-plus"></i> Members
			</button>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table display nowrap" style="width: 100%;" id="myTable">
						<thead>
							<tr>
								<th>No</th>
								<th>Name</th>
								<th>Telephone</th>
								<th>Address</th>
								<th class="col-1">Action</th>
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Modal Plus -->
<div class="modal fade text-left modal-borderless" id="lok" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
	aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalTitle">Modal Title</h5>
				<button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
					<i data-feather="x"></i>
				</button>
			</div>
			<?php $attributes = array('id' => 'formPlusMembers', 'class' => 'form-control'); ?>
			<?= form_open('Members/plusMembers', $attributes) ?>
			<!-- <div class="msg" style="display: none;"></div> -->
			<div class="modal-body">
				<div class="form-body">
					<div class="row">
						<div class="form-group">
							<div class="row g-2">
								<div class="col-md">
									<div class="form-group mandatory">
										<label for="nama">Name</label>
										<div class="position-relative has-validation">
											<input name="nama" type="text" class="form-control mt-2" id="nama"
												placeholder="Input Name Members">
											<div class="invalid-feedback" id="msg">
												<p class="text-danger" id="nama_error"></p>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md">
									<div class="form-group mandatory">
										<label for="telp">Telephone</label>
										<div class="position-relative has-validation">
											<input name="telp" type="text" class="form-control mt-2" id="telp"
												placeholder="Input Telephone Members">
											<div class="invalid-feedback" id="msg">
												<p class="text-danger" id="telp_error"></p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group mandatory">
								<label for="alamat">Address</label>
								<div class="position-relative has-validation">
									<input name="alamat" type="text" class="form-control mt-2" id="alamat"
										placeholder="Input Address Members">
									<div class="invalid-feedback" id="msg">
										<p class="text-danger" id="alamat_error"></p>
									</div>
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
				"url": "<?= site_url('Members/getData') ?>",
				"type": "POST"
			},


			"columnDefs": [{
				"targets": [0],
				"orderable": false,
				"width": 5
			}],

		});
	}

	$(document).ready(function () {

		$('#modalTitle').text("Plus Members")

		viewsData();

		//? Fungsi Agar form telp hanya bisa menginputkan type data number
		$("#telp").keydown(function (event) {
			// Allow only numbers, backspace, and delete keys
			if (
				event.keyCode != 8 &&
				event.keyCode != 46 &&
				event.keyCode != 13 &&
				(event.keyCode < 48 || event.keyCode > 57)
			) {
				event.preventDefault();
			}
		});

		$('#formPlusMembers').submit(function (e) {

			//? Validation before form submit
			$('#formPlusMembers').find('input').each(function () {
				//? Validation Username 
				if ($('#nama').val().length < 5) {
					$('#nama').addClass('is-invalid');
					$('#nama_error').html('');
				} else {
					$('#nama').removeClass('is-invalid');
					$('#nama').addClass('is-valid');
					$('#nama_error').html('');
				}

				//? Validation Name 
				if ($('#telp').val().length < 5) {
					$('#telp').addClass('is-invalid');
					$('#telp_error').html('');
				} else {
					$('#telp').removeClass('is-invalid');
					$('#telp').addClass('is-valid');
					$('#telp_error').html('');
				}

				//? Validation Alamad 
				if ($('#alamat').val().length < 5) {
					$('#alamat').addClass('is-invalid');
					$('#alamat_error').html('');
				} else {
					$('#alamat').removeClass('is-invalid');
					$('#alamat').addClass('is-valid');
					$('#alamat_error').html('');
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

					if (response.success) {
						Swal.fire({
							icon: "success",
							title: "Success Add Data",
							text: response.success,
						});
						viewsData();
						// location.reload(); //Mereload Page
						$('#lok').modal('hide'); // Tutup modal jika berhasil
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

	var urlUpdate = "<?php echo base_url('Members/modalUpdateMembers') ?>"
	var urlDelete = "<?php echo site_url('Members/deletedMembers') ?>"

	//? Featured Model Update
	function update(nama) {
		$.ajax({
			type: "POST",
			url: urlUpdate,
			data: {
				nama: nama
			},
			dataType: "JSON",
			success: function (response) {
				$('.viewModal').html(response.success).show();
				$('#modalUpdateMembers').on('shown.bs.modal', function (e) {
					$('#nama').focus();
				})
				$('#modalUpdateMembers').modal('show');
			}
		});
	}

	//? Function Deleted
	function deleted(nama) {
		Swal.fire({
			title: '<strong>Delete</strong>',
			text: `Are you sure you want to Delete the Members with the Name : ${nama} ?`,
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
						nama: nama,
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
