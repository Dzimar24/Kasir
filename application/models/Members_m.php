<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Members_m extends CI_Model
{

	var $table = 'pelanggan'; //nama tabel dari database
	var $column_order = array(null, 'nama', 'telp', 'alamat', null); //Sesuaikan dengan field
	var $column_search = array('nama', 'alamat'); //field yang diizin untuk pencarian 
	var $order = array('nama' => 'ASC'); // default order 

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
		$this->db->select('*')->from('pelanggan');
		$this->db->order_by('nama', 'ASC');
		return $this->db->get()->result_array();
	}

	public function add($name, $tlp, $address)
	{
		$saveData = [
			'nama' => $name,
			'telp' => $tlp,
			'alamat' => $address
		];

		$this->db->insert('pelanggan', $saveData);
	}

	public function update()
	{
		$where = array(
			'id_pelanggan' => $this->input->post('id_pelanggan')
		);
		$data = array(
			'nama' => $this->input->post('nama'),
			'telp' => $this->input->post('telp'),
			'alamat' => $this->input->post('alamat'),
		);
		$this->db->update('pelanggan', $data, $where);
	}

	public function deletedMembers($nama)
	{
		return $this->db->delete('pelanggan', ['nama' => $nama]);
	}

	public function dataGet($nama)
	{
		return $this->db->get_where('pelanggan', ['nama' => $nama]);
	}
}
