<section class="section">
	<div class="card mt-3">
		<div class="card-body">
			<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#suara">
				<i class="bi bi-plus"></i> Suara
			</button>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table display nowrap" style="width: 100%;" id="myTable">
						<thead>
							<tr>
								<th>No</th>
								<th>Nama TPS</th>
								<th>Total Suara Sah</th>
								<th>Total Suara Tidak Sah</th>
								<th>Suara No 1</th>
								<th>Suara No 2</th>
								<th>Suara No 3</th>
								<th>Total Suara</th>
								<th>Action</th>
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
<div class="modal fade text-left modal-borderless" id="suara" tabindex="-1" role="dialog"
	aria-labelledby="myModalLabel1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalTitle">Modal Title</h5>
				<button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
					<i data-feather="x"></i>
				</button>
			</div>
			<?php $attributes = array('id' => 'formInputSuara', 'class' => 'form-control'); ?>
			<?= form_open('Suara/suaraPlus', $attributes) ?>
			<div class="msg" style="display: none;"></div>
			<!-- <input type="text" name="test"> -->
			<div class="modal-body">
				<div class="form-body">
					<div class="row">
						<div class="form-group">
							<div class="form-group mandatory">
								<label for="total_suara_24">Total Suara</label>
								<div class="position-relative has-validation">
									<input name="total_suara_24" type="text" class="form-control mt-2" id="totalSuara">
								</div>
							</div>
							<div class="row g-2">
								<div class="col-md">
									<div class="form-group mandatory">
										<label for="total_suara_sah_24">Total Suara Sah</label>
										<div class="position-relative has-validation">
											<input name="total_suara_sah_24" type="text" class="form-control mt-2"
												id="total_suara_sah_24">
										</div>
									</div>
								</div>
								<div class="col-md">
									<div class="form-group mandatory">
										<label for="total_suara_tidak_sah_24">Total Suara Tidak Sah</label>
										<div class="position-relative has-validation">
											<input name="total_suara_tidak_sah_24" type="text" class="form-control mt-2"
												id="total_suara_tidak_sah_24">
										</div>
									</div>
								</div>
							</div>
							<div class="row g-2">
								<div class="col-md">
									<div class="form-group mandatory">
										<label for="suara_no1_24">Suara No 1</label>
										<div class="position-relative has-validation">
											<input name="suara_no1_24" type="text" class="form-control mt-2"
												id="suara_no1_24">
										</div>
									</div>
								</div>
								<div class="col-md">
									<div class="form-group mandatory">
										<label for="suara_no2_24">Suara No 2</label>
										<div class="position-relative has-validation">
											<input name="suara_no2_24" type="text" class="form-control mt-2"
												id="suara_no2_24">
										</div>
									</div>
								</div>
								<div class="col-md">
									<div class="form-group mandatory">
										<label for="suara_no4_24">Suara No 3</label>
										<div class="position-relative has-validation">
											<input name="suara_no4_24" type="text" class="form-control mt-2"
												id="suara_no4_24">
										</div>
									</div>
								</div>
							</div>
							<div class="form-group mandatory">
								<label for="nama_tps_24">Nama TPS</label>
								<div class="position-relative has-validation">
									<input name="nama_tps_24" type="text" class="form-control mt-2" id="namaTps">
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

<!-- JQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>

<!-- Script JQuery -->
<script>
	$('#modalTitle').text('Form Suara');

	function viewsData() {
		table = $('#myTable').DataTable({
			responsive: true,
			"destroy": true,
			"processing": true,
			"serverSide": true,
			"order": [],

			"ajax": {
				"url": "<?= site_url('Suara/getData') ?>",
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

		//! form Update User
		$('#formInputSuara').submit(function (e) {
			//? Kirim form melalui AJAX jika validasi dinamis selesai
			$.ajax({
				type: "POST",
				url: $(this).attr('action'),
				data: $(this).serialize(),
				dataType: "JSON",
				success: function (response) {
					if (response.error) {
						$('.msg').html(response.error).show();
					}

					if (response.success) {
						Swal.fire({
							icon: "success",
							title: "Success Add Data",
							text: response.success,
						});
						$('#suara').modal('hide');
						viewsData();
						// location.reload();
					}

					if (response.wrong) {
						Swal.fire({
							icon: "error",
							title: "Oops...",
							text: response.wrong,
						});
						$('#suara').modal('hide');
						viewsData();
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

	var urlDelete = "<?php echo site_url('Suara/deleted') ?>"

	//? Function Deleted
	function deleted(nama_tps_24) {
		Swal.fire({
			title: '<strong>Delete</strong>',
			text: `Are you sure you want to Delete the Suara with the Name TPS : ${nama_tps_24} ?`,
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
						nama_tps_24: nama_tps_24,
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
