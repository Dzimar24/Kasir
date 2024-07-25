<link rel="stylesheet" href="<?= base_url('/src/invoice-page-media-print/') ?>style.css">

<div class="" id="print-area">
	<div class="invoice">
		<div class="invoice-container">
			<div class="invoice-head">
				<div class="invoice-head-top">
					<div class="invoice-head-top-left text-start">
						<img src="<?= base_url('/src/invoice-page-media-print/images/logo.png') ?>">
					</div>
					<div class="invoice-head-top-right text-end">
						<h3>Invoice</h3>
					</div>
				</div>
				<div class="hr"></div>
				<div class="invoice-head-middle">
					<div class="invoice-head-middle-left text-start">
						<p><span class="text-bold">Date </span>:
							<?= date("l, d F Y", strtotime($sale->tanggal)) ?>
						</p>
					</div>
					<div class="invoice-head-middle-right text-end">
						<p>
							<span class="text-bold">Invoice No : </span>#
							<?= $note; ?>
						</p>
					</div>
				</div>
				<div class="hr"></div>
				<div class="invoice-head-bottom">
					<div class="invoice-head-bottom-left">
						<ul>
							<li class='text-bold'>Invoiced To:</li>
							<li>
								<?= $sale->nama; ?>
							</li>
							<li>
								Phone Number :
								<?= $sale->telp; ?>
							</li>
							<li>
								Address :
								<?= $sale->alamat; ?>
							</li>
						</ul>
					</div>
					<div class="invoice-head-bottom-right">
						<ul class="text-end">
							<li class='text-bold'>From :</li>
							<li class="text-bold">Koice Inc.</li>
							<li>015 Rutherford Spur</li>
							<li>(989) 627-9571-98899</li>
							<li>contact@koiceinc.com</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="overflow-view">
				<div class="invoice-body">
					<table>
						<thead>
							<tr>
								<td class="text-bold">No</td>
								<td class="text-bold">Code Product</td>
								<td class="text-bold">Product</td>
								<td class="text-bold">Amount</td>
								<td class="text-bold">Price</td>
								<td class="text-bold">Total</td>
							</tr>
						</thead>
						<tbody>
							<?php $total = 0;
							$no = 1;
							foreach ($details as $ls): ?>
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
									<td style="text-align: center;">
										<?= $ls['jumlah'] ?>
									</td>
									<td>Rp.
										<?= number_format($ls['harga']) ?>
									</td>
									<td class="text-end">Rp.
										<?= number_format($ls['jumlah'] * $ls['harga']) ?>
									</td>
								</tr>
								<?php $total = $total + $ls['jumlah'] * $ls['harga']; endforeach; ?>
						</tbody>
					</table>
					<div class="invoice-body-bottom">
						<div class="invoice-body-info-item border-bottom">
							<div class="info-item-td text-end text-bold">Total Price : </div>
							<div class="info-item-td text-end">Rp.
								<?= number_format($total); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="invoice-foot text-center">
				<p><span class="text-bold text-center">NOTE:&nbsp;</span>This is computer generated receipt and does not
					require physical signature.</p>

				<div class="invoice-btns">
					<a href="<?= site_url('Pdf/loadView/' . $note) ?>" target="_blank" class="btn btn-secondary">
						<i class="fa-solid fa-print"></i> Print to PDF
					</a>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="<?= base_url('/src/invoice-page-media-print/') ?>script.js"></script>
