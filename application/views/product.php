<section class="section">
	<div class="card mt-3">
		<div class="card-body">
			<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#lok">
				<i class="bi bi-plus"></i> Plus Product
			</button>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table display nowrap" style="width: 100%;" id="myTable">
						<thead>
							<tr>
								<th>No</th>
								<th>Name</th>
								<th>Code Product</th>
								<th>Stock</th>
								<th>Price</th>
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
			<?php $attributes = array('id' => 'formInputProduct', 'class' => 'form-control'); ?>
			<?= form_open('Product/productPlus', $attributes) ?>
			<!-- <div class="msg" style="display: none;"></div> -->
			<div class="modal-body">
				<div class="form-body">
					<div class="row">
						<div class="form-group">
							<div class="form-group mandatory">
								<label for="nama">Name Product</label>
								<div class="position-relative has-validation">
									<input name="nama" type="text" class="form-control mt-2" id="nama"
										placeholder="Name Product">
									<div class="invalid-feedback" id="msg">
										<p class="text-danger" id="nama_error"></p>
									</div>
								</div>
							</div>
							<div class="row g-2">
								<div class="col-md">
									<div class="form-group mandatory">
										<label for="stok">Stock</label>
										<div class="position-relative has-validation">
											<input name="stok" type="number" class="form-control mt-2" id="stok"
												placeholder="Input Stock Product">
											<div class="invalid-feedback" id="msg">
												<p class="text-danger" id="stok_error"></p>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md">
									<div class="form-group mandatory has-icon-left">
										<label for="harga">Price</label>
										<div class="position-relative has-validation">
											<input name="harga" type="number" class="form-control mt-2" id="harga"
												placeholder="Input Price Product">
											<div class="form-control-icon">
												<span>Rp.</span>
											</div>
											<div class="invalid-feedback" id="msg">
												<p class="text-danger" id="harga_error"></p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group mandatory">
								<label for="code">Code Product</label>
								<div class="position-relative has-validation">
									<input name="code" type="text" class="form-control mt-2" id="code">
									<div class="invalid-feedback" id="msg">
										<p class="text-danger" id="code_error"></p>
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
				"url": "<?= site_url('Product/getData') ?>",
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
		viewsData();

		$("#harga").keypress(function (e) {
			if (String.fromCharCode(e.keyCode).match(/[^0-9]/g)) return false;
		});

		//? Fungsi Agar form harga hanya bisa menginputkan type data number
		// $("#jsjj").keydown(function (event) {
			// Allow only numbers, backspace, and delete keys
		// 	if (
		// 		event.keyCode != 8 &&
		// 		event.keyCode != 46 &&
		// 		event.keyCode != 13 &&
		// 		(event.keyCode < 48 || event.keyCode > 57)
		// 	) {
		// 		event.preventDefault();
		// 	}
		// });

		//? Fungsi Agar form stok hanya bisa menginputkan type data number
		$("#stok").keydown(function (event) {
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

		//! form Input Product
		$('#formInputProduct').submit(function (e) {

			//? Validation before form submit
			$('#formInputProduct').find('input').each(function () {
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
				if ($('#stok').val().length < 5) {
					$('#stok').addClass('is-invalid');
					$('#stok_error').html('');
				} else {
					$('#stok').removeClass('is-invalid');
					$('#stok').addClass('is-valid');
					$('#stok_error').html('');
				}

				//? Validation Password 
				if ($('#harga').val().length < 5) {
					$('#harga').addClass('is-invalid');
					$('#harga_error').html('');
				} else {
					$('#harga').removeClass('is-invalid');
					$('#harga').addClass('is-valid');
					$('#harga_error').html('');
				}

				//? Validation level 
				if ($('#code').val().length < 5) {
					$('#code').addClass('is-invalid');
					$('#code_error').html('');
				} else {
					$('#code').removeClass('is-invalid');
					$('#code').addClass('is-valid');
					$('#code_error').html('');
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
						location.reload();
						$('#lok').modal('hide'); // Tutup modal jika berhasil
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
				}
			});

			return false;
		});

		$("#lok").on("shown.bs.modal", function () {
			// Dapatkan tanggal dan waktu saat ini
			var date = new Date();

			// Dapatkan tahun, menit, jam, tanggal, bulan, dan detik
			var year = date.getFullYear().toString().slice(-2);
			var month = date.getMonth() + 1; // Bulan dimulai dari 0, jadi tambahkan 1
			var day = date.getDate();
			var hours = date.getHours();
			var minutes = date.getMinutes();
			var seconds = date.getSeconds();

			// Generate kode acak a-z
			var randomCapitalLetter = String.fromCharCode(Math.floor(Math.random() * 26) + 97 - 32);

			// Format tanggal dan waktu
			var formattedDate = "899" + year + month + day + hours + minutes + seconds + randomCapitalLetter;

			// Tampilkan tanggal dan waktu yang diformat
			$("#code").val(formattedDate);
		});

		$("#lok").on("hidden.bs.modal", function () {
			$("#formInputProduct")[0].reset();
			// Dapatkan tanggal dan waktu saat ini
			var date = new Date();

			// Dapatkan tahun, menit, jam, tanggal, bulan, dan detik
			var year = date.getFullYear().toString().slice(-2);
			var month = date.getMonth() + 1; // Bulan dimulai dari 0, jadi tambahkan 1
			var day = date.getDate();
			var hours = date.getHours();
			var minutes = date.getMinutes();
			var seconds = date.getSeconds();

			// Generate kode acak a-z
			var randomLetter = String.fromCharCode(Math.floor(Math.random() * 26) + 97);

			// Format tanggal dan waktu
			var formattedDate = "899" + year + month + day + hours + minutes + seconds + randomLetter;

			// Tampilkan tanggal dan waktu yang diformat
			$("#code").val(formattedDate);
		});
	});

	$('.modal-footer button[type="submit"]').removeAttr('data-bs-dismiss');

	var urlUpdate = "<?php echo base_url('Product/modalUpdateProduct') ?>"
	var urlDelete = "<?php echo site_url('Product/deletedProduct') ?>"

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
				$('#modalUpdateProduct').on('shown.bs.modal', function (e) {
					$('#nama').focus();
				})
				$('#modalUpdateProduct').modal('show');
			}
		});
	}

	//? Function Deleted
	function deleted(nama) {
		Swal.fire({
			title: '<strong>Delete</strong>',
			text: `Are you sure you want to Delete the Product with the Name : ${nama} ?`,
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
