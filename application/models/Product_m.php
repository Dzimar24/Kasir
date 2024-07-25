<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product_m extends CI_Model
{

	var $table = 'product'; //nama tabel dari database
	var $column_order = array(null, 'code', 'nama', 'stok', 'harga', null); //Sesuaikan dengan field
	var $column_search = array('code', 'nama', 'harga'); //field yang diizin untuk pencarian 
	var $order = array('id_barang' => 'ASC'); // default order 

	private function _get_datatables_query()
	{

		$this->db->from($this->table);

		$i = 0;

		foreach ($this->column_search as $item) // looping awal
		{
			if ($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
			{

				if ($i === 0) // looping awal
				{
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if (count($this->column_search) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}

		if (isset($_POST['order'])) {
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if (isset($this->order)) {
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function get()
	{
		$this->db->select('*')->from('product');
		$this->db->order_by('id_barang', 'ASC');
		return $this->db->get()->result_array();
	}

	public function add($post)
	{
		$saveData['nama'] = $post['nama'];
		$saveData['code'] = $post['code'];
		$saveData['stok'] = $post['stok'];
		$saveData['harga'] = $post['harga'];

		$this->db->insert('product', $saveData);
	}

	public function update()
	{
		$where = array(
			'id_barang' => $this->input->post('id_barang')
		);
		$data = array(
			'nama' => $this->input->post('nama'),
			'code' => $this->input->post('code'),
			'stok' => $this->input->post('stok'),
			'harga' => $this->input->post('harga'),
		);
		$this->db->update('product',$data,$where);
	}

	public function dataGet($nama)
	{
		return $this->db->get_where('product', ['nama' => $nama]);
	}

	public function deletedUser($nama)
	{
		return $this->db->delete('product', ['nama' => $nama]);
	}
}
