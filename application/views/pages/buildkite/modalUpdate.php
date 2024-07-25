<div class="modal fade text-left modal-borderless" id="modalUpdate" tabindex="-1" role="dialog"
	aria-labelledby="myModalLabel1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalTitle">Modal Title</h5>
				<button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
					<i data-feather="x"></i>
				</button>
			</div>
			<?php $attributes = array('id' => 'formUpdate'); ?>
			<?= form_open('User/userUpdate', $attributes) ?>
			<!-- <div class="msg" style="display: none;"></div> -->
			<div class="modal-body">
				<div class="form-body">
					<div class="row">
						<div class="form-group">
							<div class="form-group mandatory">
								<label for="username">Username</label>
								<div class="position-relative has-validation">
									<input name="username" type="text" class="form-control mt-2"
										value="<?= $username ?>" id="username" readonly>
								</div>
							</div>
							<div class="form-group mandatory">
								<label for="name">Name</label>
								<div class="position-relative">
									<input name="nama" type="text" class="form-control mt-2" id="name"
										value="<?= $nama ?>">
								</div>
							</div>
							<div class="form-group">
								<label for="level">Level</label>
								<div class="position-relative m-1">
									<select class="form-select" id="level" name="level">
										<option value="Kasir" <?php if ($level == 'Kasir')
											echo 'selected'; ?>>Kasir
										</option>
										<option value="Admin" <?php if ($level == 'Admin')
											echo 'selected'; ?>>Admin
										</option>
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
					<span class="d-none d-sm-block">Close</span>
				</button>
				<button type="submit" class="btn btn-primary ms-1" data-bs-dismiss="modal">
					<span class="d-none d-sm-block">Save</span>
				</button>
			</div>
			<?= form_close() ?>
		</div>
	</div>
</div>

<!-- Script JQuery -->
<script>
	$('#modalTitle').text('Update User');

	$(document).ready(function () {
		//! form Update User
		$('#formUpdate').submit(function (e) {
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
							title: "Success Update Data",
							text: response.success,
						});
						$('#modalUpdate').modal('hide');
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
</script>
