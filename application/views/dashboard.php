<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

<div class="row mt-3">
	<div class="col-6 col-lg-3 col-md-6">
		<div class="card">
			<div class="card-body px-4 py-4-5">
				<div class="row">
					<div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
						<i class="bi bi-basket fa-2x"></i>
					</div>
					<div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
						<h6 class="text-muted font-semibold"><strong>Sales Today</strong></h6>
						<h6 class="font-extrabold mb-0">Rp.
							<?php
							if ($saleToday == null) {
								# code...
								echo "0";
							} else {
								# code...
								echo number_format($saleToday);
							}
							?>
						</h6>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-6 col-lg-3 col-md-6">
		<div class="card">
			<div class="card-body px-4 py-4-5">
				<div class="row">
					<div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
						<i class="bi bi-basket fa-2x"></i>
					</div>
					<div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
						<h6 class="text-muted font-semibold"><strong>Sales This Month</strong></h6>
						<h6 class="font-extrabold mb-0">Rp.
							<?php
							if ($saleMonth == null) {
								# code...
								echo "0";
							} else {
								# code...
								echo number_format($saleMonth);
							}
							?>
						</h6>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-6 col-lg-3 col-md-6">
		<div class="card">
			<div class="card-body px-4 py-4-5">
				<div class="row">
					<div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
						<i class="bi bi-credit-card fa-2x"></i>
					</div>
					<div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
						<h6 class="text-muted font-semibold"><strong>Transactions Today</strong></h6>
						<h6 class="font-extrabold mb-0">
							<?= $transaction; ?>
						</h6>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-6 col-lg-3 col-md-6">
		<div class="card">
			<div class="card-body px-4 py-4-5">
				<div class="row">
					<div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
						<i class="bi bi-box-seam fa-2x"></i>
					</div>
					<div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
						<h6 class="text-muted font-semibold"><strong>Product</strong></h6>
						<h6 class="font-extrabold mb-0">
							<?= $product; ?>
						</h6>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row mt-3">
	<div class="col-5 me-5">
		<div class="card">
			<div class="card-body">
				<canvas id="myChart" style="width:100%;max-width:600px"></canvas>
			</div>
		</div>
	</div>
	<div class="col-6 ms-4">
		<div class="card col-12">
			<div class="card-header">
				<h4>New Arrival </h4>
			</div>
		</div>
		<?php foreach ($lastProduct as $last): ?>
			<div class="card col-12">
				<div class="row">
					<div class="card-body py-4 px-4">
						<div class="d-flex align-items-center">
							<div class="ms-3 name">
								<h5 class="font-bold">
									<?= $last['nama'] ?> / Code :
									<?= $last['code'] ?>
								</h5>
								<h6 class="text-muted mb-0">
									Rp.
									<?= number_format($last['harga']) ?>
								</h6>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</div>


<?php
$nameNow = date('M');
$nameOne = date('M', strtotime("-1 Months"));
$nameTwo = date('M', strtotime("-2 Months"));
$nameThree = date('M', strtotime("-3 Months"));
$nameFour = date('M', strtotime("-4 Months"));
$nameFive = date('M', strtotime("-5 Months"));

$date = date('Y-m', strtotime("-1 Months"));
$this->db->select('sum(total_tagihan) as total')->from('penjualan')->where("DATE_FORMAT(tanggal,'%Y-%m')", $date);
$monthOne = $this->db->get()->row()->total;
$date = date('Y-m', strtotime("-2 Months"));
$this->db->select('sum(total_tagihan) as total')->from('penjualan')->where("DATE_FORMAT(tanggal,'%Y-%m')", $date);
$monthTwo = $this->db->get()->row()->total;
$date = date('Y-m', strtotime("-3 Months"));
$this->db->select('sum(total_tagihan) as total')->from('penjualan')->where("DATE_FORMAT(tanggal,'%Y-%m')", $date);
$monthThree = $this->db->get()->row()->total;
$date = date('Y-m', strtotime("-4 Months"));
$this->db->select('sum(total_tagihan) as total')->from('penjualan')->where("DATE_FORMAT(tanggal,'%Y-%m')", $date);
$monthFour = $this->db->get()->row()->total;
$date = date('Y-m', strtotime("-5 Months"));
$this->db->select('sum(total_tagihan) as total')->from('penjualan')->where("DATE_FORMAT(tanggal,'%Y-%m')", $date);
$monthFive = $this->db->get()->row()->total;

if ($monthOne == null) {
	# code...
	$monthOne = 0;
}
if ($monthTwo == null) {
	# code...
	$monthTwo = 0;
}
if ($monthThree == null) {
	# code...
	$monthThree = 0;
}
if ($monthFive == null) {
	# code...
	$monthFive = 0;
}

$newMonth = number_format($saleMonth);
?>

<script>
	const xValues = ["<?= $nameFive ?>", "<?= $nameFour ?>", "<?= $nameThree ?>", "<?= $nameTwo ?>", "<?= $nameOne ?>", "<?= $nameNow ?>"];
	const yValues = [<?= $monthFive ?>, <?= $monthFour ?>, <?= $monthThree ?>, <?= $monthTwo ?>, <?= $monthOne ?>, <?= $newMonth ?>];
	const barColors = ["red", "green", "blue", "orange", "brown", "yellow"];

	new Chart("myChart", {
		type: "bar",
		data: {
			labels: xValues,
			datasets: [{
				backgroundColor: barColors,
				data: yValues
			}]
		},
		options: {
			legend: { display: false },
			title: {
				display: true,
				text: "Last 5 Months Sales"
			}
		}
	});
</script>
