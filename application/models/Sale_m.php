<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sale_m extends CI_Model
{
	public function get()
	{
		date_default_timezone_set("Asia/Jakarta");
		$date = date("y-m-d");
		$this->db->select('*')->from('penjualan a')->order_by('a.tanggal','DESC')->where('a.tanggal',$date);
		$this->db->join('pelanggan b', 'a.id_pelanggan = b.id_pelanggan', 'left');
		$user = $this->db->get()->result_array();
		return $user;
	}

	public function addTemp($idPelanggal, $idUser, $idProduct, $total)
	{
		# code...
		$saveData = [
			'idPelanggan'	=> 	$idPelanggal,
			'idUser'		=> $idUser,
			'idBarang'		=> $idProduct,
			'jumlah'		=> $total
		];

		$this->db->insert('temp', $saveData);
	}
}
