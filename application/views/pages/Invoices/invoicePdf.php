<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
		*,
		*::after,
		*::before {
			padding: 0;
			margin: 0;
			box-sizing: border-box;
		}

		:root {
			--blue-color: #0c2f54;
			--dark-color: #535b61;
			--white-color: #fff;
		}

		ul {
			list-style-type: none;
		}

		ul li {
			margin: 2px 0;
		}

		/* text colors */
		.text-dark {
			color: var(--dark-color);
		}

		.text-blue {
			color: var(--blue-color);
		}

		.text-end {
			text-align: right;
		}

		.text-center {
			text-align: center;
		}

		.text-start {
			text-align: left;
		}

		.text-bold {
			font-weight: 700;
		}

		/* hr line */
		.hr {
			height: 1px;
			background-color: rgba(0, 0, 0, 0.1);
		}

		/* border-bottom */
		.border-bottom {
			border-bottom: 1px solid rgba(0, 0, 0, 0.1);
		}

		body {
			font-family: 'Poppins', sans-serif;
			color: var(--dark-color);
			font-size: 14px;
		}

		.invoice-wrapper {
			min-height: 100vh;
			background-color: rgba(0, 0, 0, 0.1);
			padding-top: 20px;
			padding-bottom: 20px;
		}

		.invoice {
			max-width: 850px;
			margin-right: auto;
			margin-left: auto;
			background-color: var(--white-color);
			padding: 70px;
			border: 1px solid rgba(0, 0, 0, 0.2);
			border-radius: 5px;
			min-height: 920px;
		}

		.invoice-head-top-left img {
			width: 130px;
		}

		.invoice-head-top-right h3 {
			font-weight: 500;
			font-size: 27px;
			color: var(--blue-color);
		}

		.invoice-head-middle,
		.invoice-head-bottom {
			padding: 16px 0;
		}

		.invoice-body {
			border: 1px solid rgba(0, 0, 0, 0.1);
			border-radius: 4px;
			overflow: hidden;
		}

		.invoice-body table {
			border-collapse: collapse;
			border-radius: 4px;
			width: 100%;
		}

		.invoice-body table td,
		.invoice-body table th {
			padding: 12px;
		}

		.invoice-body table tr {
			border-bottom: 1px solid rgba(0, 0, 0, 0.1);
		}

		.invoice-body table thead {
			background-color: rgba(0, 0, 0, 0.02);
		}

		.invoice-body-info-item {
			display: grid;
			grid-template-columns: 80% 20%;
		}

		.invoice-body-info-item .info-item-td {
			padding: 12px;
			background-color: rgba(0, 0, 0, 0.02);
		}

		.invoice-foot {
			padding: 30px 0;
		}

		.invoice-foot p {
			font-size: 12px;
		}

		.invoice-head-top,
		.invoice-head-middle,
		.invoice-head-bottom {
			display: grid;
			grid-template-columns: repeat(2, 1fr);
			padding-bottom: 10px;
		}

		@media screen and (max-width: 900px) {
			.invoice {
				padding: 40px;
			}
		}

		@media screen and (max-width: 576px) {

			.invoice-head-top,
			.invoice-head-middle,
			.invoice-head-bottom {
				grid-template-columns: repeat(1, 1fr);
			}

			.invoice-head-bottom-right {
				margin-top: 12px;
				margin-bottom: 12px;
			}

			.invoice * {
				text-align: left;
			}

			.invoice {
				padding: 28px;
			}
		}

		.overflow-view {
			overflow-x: scroll;
		}

		.invoice-body {
			min-width: 600px;
		}

		@media print {
			.print-area {
				visibility: visible;
				width: 100%;
				position: absolute;
				left: 0;
				top: 0;
				overflow: hidden;
			}

			.overflow-view {
				overflow-x: hidden;
			}

			.invoice-btns {
				display: none;
			}
		}
	</style>
</head>

<body>
	<div class="invoice-wrapper" id="print-area">
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
					<p><span class="text-bold text-center">NOTE:&nbsp;</span>This is computer generated receipt and does
						not
						require physical signature.</p>
				</div>
			</div>
		</div>
	</div>

	<script src="<?= base_url('/src/invoice-page-media-print/') ?>script.js"></script>
</body>

</html>
