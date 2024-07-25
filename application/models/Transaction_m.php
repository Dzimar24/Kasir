<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaction_m extends CI_Model
{
	public function get()
	{
		date_default_timezone_set("Asia/Jakarta");
		$date = date("y-m-d");
		$this->db->select('*')->from('penjualan');
		$this->db->order_by('tanggal', 'DESC');
		$this->db->where('tanggal', $date);
		return $this->db->get()->result_array();
	}

	public function transaction()
	{
		date_default_timezone_set("Asia/Jakarta");
		$date = date('Y-m');
		$this->db->from('penjualan')->where('tanggal', $date);

		$total = $this->db->count_all_results();
		$note = date('ymd') . $total + 1;
		return $note;
	}

	public function selectProduct()
	{
		$this->db->from('product')->where('stok >', 0)->order_by('nama', 'ASC');
		$product = $this->db->get()->result_array();
		return $product;
	}

	public function detailsTransaction()
	{
		$this->db->from('penjualan');
		$total = $this->db->count_all_results();
		$note = date('ymd') . $total + 1;

		$this->db->from('detail_penjualan');
		$this->db->join('product', 'product.id_barang=detail_penjualan.id_produk', 'left');
		$this->db->where('detail_penjualan.kode_penjualan', $note);
		$details = $this->db->get()->result_array();
		return $details;
		// echo "aaa";
	}

	public function add($code, $idBarang, $total, $subTotal)
	{
		$saveData = [
			'kode_penjualan' => $code,
			'id_produk' => $idBarang,
			'jumlah' => $total,
			'subTotal' => $subTotal
		];

		$this->db->insert('detail_penjualan', $saveData);
	}

	public function updateStock($id_produk, $jumlah)
	{
		$this->db->where('id_barang', $id_produk);
		$query = $this->db->get('product')->row()->stok;

		$stok_baru = $query - $jumlah;

		$this->db->where('id_barang', $id_produk);
		$this->db->update('product', array('stok' => $stok_baru));
	}

	public function deletedTransaction($id)
	{
		$where = array('id_detail_penjualan' => $id);
		return $this->db->delete('detail_penjualan', $where);
	}

	public function checkout($code, $id, $totalPrice, $date)
	{
		$saveData = [
			'kode_penjualan' => $code,
			'id_pelanggan' => $id,
			'total_tagihan' => $totalPrice,
			'tanggal' => $date
		];

		$this->db->insert('penjualan', $saveData);
	}

	public function sale($kode_penjualan)
	{
		# code...
		$this->db->select('*');
		$this->db->from('penjualan x')->order_by('x.tanggal', 'DESC')->where('x.kode_penjualan', $kode_penjualan);
		$this->db->join('pelanggan y', 'x.id_pelanggan = y.id_pelanggan', 'left');
		$sale = $this->db->get()->row();
		return $sale;
	}

	public function detailInvoices($kode_penjualan)
	{
		$this->db->from('detail_penjualan t');
		$this->db->join('product o', 't.id_produk=o.id_barang', 'left');
		$this->db->where('t.kode_penjualan', $kode_penjualan);
		$detailInvoices = $this->db->get()->result_array();
		return $detailInvoices;
	}
}
