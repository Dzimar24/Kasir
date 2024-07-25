<?php
defined('BASEPATH') or exit ('No direct script access allowed');

class Sale extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('level') == null) {
			redirect('Auth');
		}
		$this->load->model('Sale_m');
		$this->load->model('Transaction_m');
		$this->load->library('form_validation');
	}

	//! Table Page Start Sale
	public function getData()
	{
		if ($this->input->is_ajax_request() == true) {
			$this->load->model('Sale_m', 'Sale');
			$list = $this->Sale->get_datatables();
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $field) {

				$no++;
				$row = array();

				$buttonUpdate = "<button type=\"button\" class=\"btn btn-outline-info\" title=\"Edit Data\" onclick=\"update('" . $field->kode_penjualan . "')\"><i class=\"bi bi-pencil-square\"></i></button>";

				$row[] = $no;
				$row[] = $field->kode_penjualan;
				$row[] = $field->tanggal;
				$row[] = $field->total_tagihan;
				$row[] = $field->id_pelanggan;
				$row[] = $buttonUpdate;
				$data[] = $row;
			}

			$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Sale->count_all(),
				"recordsFiltered" => $this->Sale->count_filtered(),
				"data" => $data,
			);
			//output dalam format JSON
			echo json_encode($output);
		} else {
			exit ('Maaf data tidak bisa ditampilkan');
		}
	}

	//! Table Modal Members
	public function getDataMembers()
	{
		if ($this->input->is_ajax_request() == true) {
			$this->load->model('Members_m', 'members');
			$list = $this->members->get_datatables();
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $field) {

				$no++;
				$row = array();

				$buttonUpdate = "<a href=\"Sale/transaction/$field->id_pelanggan\" class=\"btn btn-outline-primary\"><i class=\"bi bi-check\"></i></a>";

				$row[] = $no;
				$row[] = $field->nama;
				$row[] = $field->telp;
				$row[] = $field->alamat;
				$row[] = $buttonUpdate;
				$data[] = $row;
			}

			$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->members->count_all(),
				"recordsFiltered" => $this->members->count_filtered(),
				"data" => $data,
			);
			//output dalam format JSON
			echo json_encode($output);
		} else {
			exit ('Maaf data tidak bisa ditampilkan');
		}
	}

	public function index()
	{
		$data['getData'] = $this->Sale_m->get();
		$data['title'] = 'Sale';
		$this->template->load('template', 'sale', $data);
	}

	public function transaction($id_pelanggan)
	{
		date_default_timezone_set("Asia/Jakarta");
		$date = date('Y-m');
		$this->db->from('penjualan');
		//! di bagian where tanggal ada bagian yang tidak di tambahkan di script yaitu "DATE_FORMAT(tanggal,'%Y-%m')" jika di tambah itu akan error tidak akan menampilkan database penjualan
		$this->db->where('tanggal', $date);
		$total = $this->db->count_all_results();
		$note = date('ymd') . $total + 1;
		// var_dump($note);
		// die;

		$this->db->from('detail_penjualan a');
		$this->db->join('product g', 'a.id_produk=g.id_barang', 'left');
		$this->db->where('a.kode_penjualan', $note);
		$details = $this->db->get()->result_array();

		$this->db->from('temp a');
		$this->db->join('product g', 'a.idBarang=g.id_barang', 'left');
		$this->db->where('a.idUser', $this->session->userdata('id_user'));
		$this->db->where('a.idPelanggan', $id_pelanggan);
		$temp = $this->db->get()->result_array();

		$this->db->from('pelanggan')->where('id_pelanggan', $id_pelanggan);
		$nameMembers = $this->db->get()->row()->nama;

		$data['title'] = 'Transaction';
		$data['id_pelanggan'] = $id_pelanggan;
		$data['nameMembers'] = $nameMembers;
		$data['details'] = $details;
		$data['temp'] = $temp;
		$data['note'] = $this->Transaction_m->transaction();
		$data['product'] = $this->Transaction_m->selectProduct();
		$this->template->load('template', 'transaction', $data);
	}

	public function addCart()
	{

		if ($this->input->is_ajax_request() == true) {
			$code = $this->input->post('kode_penjualan', true);
			$idBarang = $this->input->post('id_produk', true);
			$total = $this->input->post('jumlah', true);

			$this->db->from('detail_penjualan');
			$this->db->where('id_produk', $this->input->post('id_produk'));
			$this->db->where('kode_penjualan', $this->input->post('kode_penjualan'));
			$check = $this->db->get()->result_array();
			// var_dump($check); die;
			if ($check <> null) {
				# code...
				$msg = [
					'wrongTwo' => 'Product has been selected ! & Reload this page'
				];
				echo json_encode($msg);
				// return;
			} else {

				$this->db->where('id_barang', $idBarang);
				$oldStock = $this->db->get('product')->row()->stok;

				$this->db->from('product')->where('id_barang', $this->input->post('id_produk'));
				$price = $this->db->get()->row()->harga;

				$subTotal = (int) $this->input->post('jumlah') * (int) $price;

				$this->form_validation->set_rules('jumlah', 'jumlah', 'required|trim');

				if ($this->form_validation->run() == TRUE) {
					# code...
					if ($oldStock >= $total) {
						# code...
						$this->Transaction_m->add($code, $idBarang, $total, $subTotal);
						$this->Transaction_m->updateStock($idBarang, $total);


						$msg = [
							'success' => 'Successfully added Product to Cart'
						];
					} else {
						# code...
						$msg = [
							'wrong' => 'Insufficient quantity of selected product!'
						];
					}

				} else {
					# code...
					$msg = [
						'error' => [
							'kode_penjualan' => form_error('kode_penjualan'),
							'id_barang' => form_error('id_barang'),
							'jumlah' => form_error('jumlah')
						]
					];
				}

				echo json_encode($msg);
			}
		}
	}

	public function addTemp()
	{
		if ($this->input->is_ajax_request() == true) {
			# code...
			$idBarang = $this->input->post('id_produk', true);
			$total = $this->input->post('jumlah', true);

			$this->db->from('product')->where('id_barang', $idBarang);
			$oldStock = $this->db->get()->row()->stok;

			$this->db->from('temp');
			$this->db->where('idBarang', $this->input->post('id_produk'));
			$this->db->where('idUser', $this->session->userdata('id_user'));
			$this->db->where('idPelanggan', $this->input->post('id_pelanggan'));
			$check = $this->db->get()->result_array();

			if ($oldStock < $total) {
				# code...
				$msg = [
					'wrong' => 'Insufficient quantity of selected product!'
				];
				echo json_encode($msg);
				// return;
			} else if ($check <> null) {
				# code...
				$msg = [
					'wrongTwo' => 'Product has been selected ! & Reload this page'
				];
				echo json_encode($msg);
			} else {
				$idPelanggal = $this->input->post('id_pelanggan');
				$idUser = $this->session->userdata('id_user');
				$idProduct = $this->input->post('id_produk');
				$total = $this->input->post('jumlah');

				$this->form_validation->set_rules('jumlah', 'jumlah', 'required|trim');
				if ($this->form_validation->run() == true) {
					# code...
					$this->Sale_m->addTemp($idPelanggal, $idUser, $idProduct, $total);

					$msg = [
						'success' => 'Successfully added Product to Cart'
					];

					echo json_encode($msg);
				}
			}

		}
	}

	public function deletedTransaction($id_detail_penjualan, $id_barang)
	{

		$this->db->from('detail_penjualan')->where('id_detail_penjualan', $id_detail_penjualan);
		$total = $this->db->get()->row()->jumlah;

		$this->db->from('product')->where('id_barang', $id_barang);
		$oldStock = $this->db->get()->row()->stok;

		$stockNow = $total + $oldStock;

		$data = array('stok' => $stockNow);
		$where = array('id_barang' => $id_barang);
		$this->db->update('product', $data, $where);

		$where = array('id_detail_penjualan' => $id_detail_penjualan);
		$this->db->delete('detail_penjualan', $where);

		$this->session->set_flashdata('flash', 'Deleted');

		redirect($_SERVER['HTTP_REFERER']);
	}

	public function deletedTemp($idTemp)
	{
		$where = array('idTemp' => $idTemp);
		$this->db->delete('temp', $where);

		$this->session->set_flashdata('flash', 'Deleted');

		redirect($_SERVER['HTTP_REFERER']);
	}

	public function checkout()
	{
		$code = $this->input->post('kode_penjualan');
		$id = $this->input->post('id_pelanggan');
		$totalPrice = $this->input->post('total_harga');
		$date = date('Y-m-d');
		$this->Transaction_m->checkout($code, $id, $totalPrice, $date);
		redirect('Sale/invoices/' . $code);
	}

	public function checkoutTransaction()
	{
		date_default_timezone_set("Asia/Jakarta");
		$date = date('Y-m');
		$this->db->from('penjualan');
		//! di bagian where tanggal ada bagian yang tidak di tambahkan di script yaitu "DATE_FORMAT(tanggal,'%Y-%m')" jika di tambah itu akan error tidak akan menampilkan database penjualan
		$this->db->where('tanggal', $date);
		$total = $this->db->count_all_results();
		$note = date('ymd') . $total + 1;

		$id = $this->input->post('id_pelanggan');
		$totalPrice = $this->input->post('total_harga');
		// $totalO = $this->input->post('jumlah');

		$this->db->from('temp q');
		$this->db->join('product p', 'q.idBarang=p.id_barang', 'left');
		$this->db->where('q.idUser', $this->session->userdata('id_user'));
		$this->db->where('q.idPelanggan', $id);
		$temp = $this->db->get()->result_array();
		foreach ($temp as $oi):
			if ($oi['stok'] < $oi['jumlah']):
				// var_dump($oi['stok'] < $oi['jumlah']);
				// die;
				$this->session->set_flashdata('flash', 'Selected product is out of stock!');
				redirect($_SERVER['HTTP_REFERER']);
			endif;
			//?	Input for penjualan Table
			$data = [
				'kode_penjualan' => $note,
				'id_produk' => $oi['id_barang'],
				'jumlah' => $oi['jumlah'],
				'subTotal' => $oi['jumlah'] * $oi['harga']
			];
			$this->db->insert('detail_penjualan', $data);
			//?	Update table product stock
			$data2 = [
				'stok' => $oi['stok'] - $oi['jumlah'],
			];
			$where = ['id_barang' => $oi['id_barang']];
			$this->db->update('product', $data2, $where);
			//? Deleted for Table Temp
			$object = [
				'idPelanggan' => $id,
				'idUser' => $this->session->userdata('id_user')
			];
			$this->db->delete('temp', $object);

		endforeach;

		$date = date('Y-m-d');
		$this->Transaction_m->checkout($note, $id, $totalPrice, $date);
		redirect('Sale/invoices/' . $note);
	}

	public function invoices($kode_penjualan)
	{
		# code...
		$data['title'] = 'Invoices';
		$data['sale'] = $this->Transaction_m->sale($kode_penjualan);
		$data['details'] = $this->Transaction_m->detailInvoices($kode_penjualan);
		$data['note'] = $kode_penjualan;
		$this->template->load('template', 'pages/Invoices/Invoices', $data);
	}

}

