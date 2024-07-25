<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	public function __construct() {
		parent::__construct();
		if ($this->session->userdata('level') == null) {
			redirect('Auth');
		} 
	}

	public function index()
	{
		date_default_timezone_set("Asia/Jakarta");
		//? Sales Today
		$date = date('Y-m-d');
		$this->db->select('sum(total_tagihan) as total');
		$this->db->from('penjualan')->where("DATE_FORMAT(tanggal,'%Y-%m-%d')", $date);
		$today = $this->db->get()->row()->total;

		//? Transaction
		$product = $this->db->from('product')->count_all_results();

		//? Product
		$this->db->from('penjualan')->where("DATE_FORMAT(tanggal,'%Y-%m-%d')", $date);
		$transaction = $this->db->count_all_results();

		//? Sales this month
		$date = date('Y-m');
		$this->db->select('sum(total_tagihan) as total');
		$this->db->from('penjualan')->where("DATE_FORMAT(tanggal,'%Y-%m')", $date);
		$month = $this->db->get()->row()->total;

		//? Content
		$this->db->from('product');
		$this->db->order_by('id_barang', 'DESC');
		$this->db->limit(3);
		$lastProduct = $this->db->get()->result_array();

		$data['title'] = 'Dashboard';
		$data['saleToday'] = $today;
		$data['saleMonth'] = $month;
		$data['lastProduct'] = $lastProduct;
		$data['transaction'] = $transaction;
		$data['product'] = $product;
		$this->template->load('template', 'Dashboard', $data);
	}
}
