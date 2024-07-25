<div class="modal fade text-left modal-borderless" id="modalUpdateMembers" tabindex="-1" role="dialog"
	aria-labelledby="myModalLabel1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalTitle">Modal Title</h5>
				<button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
					<i data-feather="x"></i>
				</button>
			</div>
			<?php $attributes = array('id' => 'formInputUpdateMembers'); ?>
			<?= form_open('Members/updateMembers', $attributes) ?>
			<!-- <div class="msg" style="display: none;"></div> -->
			<input type="hidden" name="id_pelanggan" value="<?= $id_pelanggan ?>">

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
												value="<?= $nama ?>">
										</div>
									</div>
								</div>
								<div class="col-md">
									<div class="form-group mandatory">
										<label for="telp">Telephone</label>
										<div class="position-relative has-validation">
											<input name="telp" type="text" class="form-control mt-2" id="telp"
												value="<?= $telp ?>">
										</div>
									</div>
								</div>
							</div>
							<div class="form-group mandatory">
								<label for="alamat">Address</label>
								<div class="position-relative has-validation">
									<input name="alamat" type="text" class="form-control mt-2" id="alamat"
										value="<?= $alamat ?>">
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

<!-- Script JQuery -->
<script>
	$('#modalTitle').text('Update Product');

	$(document).ready(function () {
		//! form Update User
		$('#formInputUpdateMembers').submit(function (e) {
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
							title: "Success Update Data",
							text: response.success,
						});
						viewsData();
						$('#modalUpdateMembers').modal('hide');
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
				}
			});

			return false;
		});

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
	});
</script>
