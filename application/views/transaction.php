<div class="row">
	<div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash') ?>"></div>
	<div class="col-4 m-0 mt-3">
		<!-- //? Form Input Left -->
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title m-0">Please choose a product to buy!</h4>
				</div>
				<div class="card-body">
					<div class="form form-vertical">
						<div class="form-body">
							<div class="row">
								<input type="hidden" name="id_pelanggan" value="<?= $id_pelanggan ?>">
								<div class="col-12 mt-2">
									<div class="form-group">
										<label for="">Name Members</label>
										<input class="form-control mt-2" type="text" name="" value="<?= $nameMembers ?>"
											readonly>
									</div>
								</div>
								<?php $attributes = array('id' => 'formInputTransaction'); ?>
								<?php echo form_open('Sale/addTemp', $attributes, ); ?>
								<input type="hidden" value="<?= $id_pelanggan ?>" name="id_pelanggan">
								<div class="col-12 mt-2">
									<div class="form-group mandatory">
										<label for="id_produk">Product</label>
										<div class="position-relative has-validation">
											<input type="hidden" name="kode_penjualan" value="<?= $note; ?>">
											<select class="choices form-select mt-2" name="id_produk">
												<!-- <option>Select Product</option> -->
												<?php foreach ($product as $key => $pro): ?>
													<option value="<?= $pro['id_barang'] ?>">
														<?= $pro['nama'] ?> -
														<?= $pro['code'] ?>
														[
														<?= $pro['stok'] ?> ]
													</option>
												<?php endforeach; ?>
											</select>
											<div class="invalid-feedback" id="msg">
												<p class="text-danger" id="id_produk_error"></p>
											</div>
										</div>
									</div>
								</div>
								<div class="col-12 mt-2">
									<div class="form-group mandatory">
										<label for="jumlah">Quantity Sold</label>
										<div class="position-relative has-validation">
											<input type="text" id="jumlah" class="form-control mt-2" name="jumlah"
												placeholder="Quantity Sold">
											<div class="invalid-feedback" id="msg">
												<p class="text-danger" id="jumlah_error"></p>
											</div>
										</div>
									</div>
								</div>
								<div class="col-12 mt-3 d-flex justify-content-end">
									<button type="submit" class="btn btn-primary me-1 mb-1"><i class="bi bi-plus"></i><i
											class="bi bi-cart"></i></button>
								</div>
								<?= form_close(); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-8">
		<!-- //? Table trolley Sale -->
		<section class="section col-12">
			<div class="card mt-3">
				<div class="card-body">
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-striped dataTable-table" id="table1">
								<thead>
									<tr>
										<th>No</th>
										<th>Code Product</th>
										<th>Product</th>
										<th>Amount</th>
										<th>Price</th>
										<th>Total</th>
										<th class="col-1">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $total = 0;
									$check = 0;
									// var_dump($details);
									// die;
									$no = 1;
									if ($temp == null) {
										# code...
										echo "";
									} else {
										# code...
										foreach ($temp as $ls): ?>
											<tr>
												<td>
													<?= $no++; ?>
												</td>
												<td>
													<?= $ls['code'] ?>
												</td>
												<td>
													<?= $ls['nama'] ?>
												</td>
												<td>
													<?php
													$check = ($ls['jumlah'] > $ls['stok']) ? 0 : 1;
													if ($check == 0): ?>
														<span class="badge bg-light-danger">Insufficient Stock !!</span>
													<?php else: ?>
														<?php echo $ls['jumlah'] ?>
													<?php endif; ?>
												</td>
												<td>Rp.
													<?= number_format($ls['harga']) ?>
												</td>
												<td>Rp.
													<?= number_format($ls['jumlah'] * $ls['harga']) ?>
												</td>
												<td>
													<a class="btn btn-danger button-deleted"
														href="<?= base_url('Sale/deletedTemp/' . $ls['idTemp']) ?>"><i
															class="bi bi-trash"></i></a>
												</td>
											</tr>
											<?php $total = $total + $ls['jumlah'] * $ls['harga']; endforeach; ?>
									<?php } ?>
								</tbody>
								<tfoot>
									<tr>
										<th>Price Total</th>
										<th></th>
										<th></th>
										<th></th>
										<th>Rp.
											<?= number_format($total) ?>
										</th>
										<th></th>
									</tr>
								</tfoot>
							</table>
							<div class="col-12 mt-3 d-flex justify-content-end">
								<?= form_open('Sale/checkoutTransaction'); ?>
								<input type="hidden" name="id_pelanggan" value="<?= $id_pelanggan ?>">
								<input type="hidden" name="total_harga" value="<?= $total ?>">
								<?php
								// var_dump($details, $check);
								// die;
								if (($details <> null) and ($check == 0)): ?>

								<?php else: ?>
									<button type="submit" class="btn btn-primary me-1 mb-1">
										<i class="bi bi-credit-card-fill"></i>
									</button>
								<?php endif; ?>
								<?= form_close(); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
</div>

<!-- Connection JQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="<?= base_url('/src/mazer/assets/static/js/pages/my.js') ?>"></script>


<!-- Script JQuery -->
<script>
	$(document).ready(function () {

		$('#formInputTransaction').submit(function (e) {

			//? Validation before form submit
			$('#formInputTransaction').find('input').each(function () {
				//? Validation Username 
				if ($('#id_produk').val()) {
					$('#id_produk').addClass('is-invalid');
					$('#id_produk_error').html('');
				} else {
					$('#id_produk').removeClass('is-invalid');
					$('#id_produk').addClass('is-valid');
					$('#id_produk_error').html('');
				}

				if ($('#jumlah').val().length < 1) {
					$('#jumlah').addClass('is-invalid');
					$('#jumlah_error').html('');
				} else {
					$('#jumlah').removeClass('is-invalid');
					$('#jumlah').addClass('is-valid');
					$('#jumlah_error').html('');
				}
			});

			// ? Kirim form melalui AJAX jika validasi dinamis selesai
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
							title: "Success Add to Cart",
							text: response.success,
						});
						$("#formInputTransaction").find('input').val("");
						$("#jumlah").removeClass('is-valid');
						window.location.reload();
					}

					if (response.wrong) {
						Swal.fire({
							icon: "error",
							title: "Oops...",
							text: response.wrong,
						});
						$("#jumlah").addClass('is-invalid');
					}

					if (response.wrongTwo) {
						Swal.fire({
							icon: "error",
							title: "Oops...",
							text: response.wrongTwo,
						});
						$("#formInputTransaction").find('input').val("");
						$("#jumlah").removeClass('is-valid');
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status + "n" + xhr.responseText + "n" + thrownError);
				}
			});

			return false;
		});

		$("#jumlah").keypress(function (e) {
			if (String.fromCharCode(e.keyCode).match(/[^0-9]/g)) return false;
		});
	});

	// var urlDelete = "<?php echo base_url('Sale/deletedTransaction') ?>"

	// function deleted(nama) {
	// 	Swal.fire({
	// 		title: '<strong>Delete</strong>',
	// 		text: `Are You Sure You Want to Remove Product ${nama} From Your Cart?`,
	// 		icon: 'warning',
	// 		showCancelButton: true,
	// 		confirmButtonColor: '#3085d6',
	// 		cancelButtonColor: '#d33',
	// 		confirmButtonText: 'Yes, Delete',
	// 		cancelButtonText: 'Cancel'
	// 	}).then((result) => {
	// 		if (result.value) {
	// 			$.ajax({
	// 				type: "post",
	// 				url: urlDelete,
	// 				data: {
	// 					nama: nama,
	// 				},
	// 				dataType: "json",
	// 				success: function (response) {
	// 					if (response.success) {
	// 						Swal.fire({
	// 							icon: 'success',
	// 							title: 'Confirmation',
	// 							text: response.success
	// 						});
	// 					}
	// 				}
	// 			});
	// 		}
	// 	})
	// }
</script>
