<section class="section">
	<div class="card mt-3">
		<div class="card-body">
			<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#lok">
				Members
			</button>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table dataTable no-footer" style="width: 100%;" id="table1">
						<thead>
							<tr>
								<th class="col-1">No</th>
								<th>No Nota</th>
								<th>Price</th>
								<th>Name Members</th>
								<th class="col-1">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$total = 0;
							$no = 1;
							foreach ($getData as $key => $data): ?>
								<tr>
									<td>
										<?= $no++; ?>
									</td>
									<td>
										<?= $data['kode_penjualan'] ?>
									</td>
									<td>Rp.
										<?= number_format($data['total_tagihan']) ?>
									</td>
									<td>
										<?= $data['nama'] ?>
									</td>
									<td>
										<a class="btn btn-outline-primary" href="<?= site_url('Sale/invoices/' . $data['kode_penjualan']) ?>">
											<i class="bi bi-eye"></i>
										</a>
									</td>
								</tr>
								<?php $total = $total + $data['total_tagihan']; endforeach; ?>
						</tbody>
						<tfoot>
							<td>Total Price : </td>
							<td></td>
							<td>
								Rp.
								<?= number_format($total) ?>
							</td>
							<td></td>
							<td></td>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Modal Plus -->
<div class="modal fade text-left modal-borderless" id="lok" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
	aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalTitle">Modal Title</h5>
				<button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
					<i data-feather="x"></i>
				</button>
			</div>
			<!-- <div class="msg" style="display: none;"></div> -->
			<div class="modal-body">
				<div class="form-body">
					<div class="row">
						<div class="table-responsive">
							<table class="table display nowrap" style="width: 100%;" id="myTableSale">
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
			<div class="modal-footer">
				<button type="button" class="btn btn-light-primary" data-bs-dismiss="modal">
					Close
				</button>
			</div>
		</div>
	</div>
</div>

<div class="viewModal" style="display: none;"></div>

<!-- JQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>

<script>
	function viewsDataSale() {
		table = $('#myTableSale').DataTable({
			responsive: true,
			"destroy": true,
			"processing": true,
			"serverSide": true,
			"order": [],

			"ajax": {
				"url": "<?= site_url('Sale/getDataMembers') ?>",
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

		$('#modalTitle').text('Plus Members')

		viewsDataSale();
	});

	$('.modal-footer button[type="submit"]').removeAttr('data-bs-dismiss');

	var urlUpdate = "<?php echo base_url('Sale/transaction') ?>"

	//? Featured Model Update
	function transaction(nama) {
		$.ajax({
			type: "POST",
			url: urlUpdate,
			data: {
				nama: nama
			},
			dataType: "JSON",
			success: function (response) {

			}
		});
	}
</script>
