<div class="modal fade text-left modal-borderless" id="modalUpdateProduct" tabindex="-1" role="dialog"
	aria-labelledby="myModalLabel1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalTitle">Modal Title</h5>
				<button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
					<i data-feather="x"></i>
				</button>
			</div>
			<?php $attributes = array('id' => 'formInputProductUpdate'); ?>
			<?= form_open('Product/updateProduct', $attributes) ?>
			<!-- <div class="msg" style="display: none;"></div> -->
			<input type="hidden" name="id_barang" value="<?= $id_barang ?>">

			<div class="modal-body">
				<div class="form-body">
					<div class="row">
						<div class="form-group">
							<div class="form-group">
								<label for="nama">Name Product</label>
								<div class="position-relative has-validation">
									<input name="nama" value="<?= $nama ?>" type="text" class="form-control mt-2"
										id="nama">
								</div>
							</div>
							<div class="row g-2">
								<div class="col-md">
									<div class="form-group">
										<label for="username">Stock</label>
										<div class="position-relative has-validation">
											<input name="stok" value="<?= $stok ?>" type="number"
												class="form-control mt-2" id="stok">
										</div>
									</div>
								</div>
								<div class="col-md">
									<div class="form-group has-icon-left">
										<label for="username">Price</label>
										<div class="position-relative has-validation">
											<input name="harga" value="<?= $harga ?>" type="number"
												class="form-control mt-2" id="harga">
											<div class="form-control-icon">
												<span>Rp.</span>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="code">Code Product</label>
								<div class="position-relative has-validation">
									<input name="code" value="<?= $code ?>" type="text" class="form-control mt-2"
										id="code">
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
		$('#formInputProductUpdate').submit(function (e) {
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
						$('#modalUpdateProduct').modal('hide');
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
				}
			});

			return false;
		});

		$("#harga").keypress(function (e) {
			if (String.fromCharCode(e.keyCode).match(/[^0-9]/g)) return false;
		});
	});
</script>