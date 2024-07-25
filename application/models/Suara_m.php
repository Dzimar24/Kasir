<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Suara_m extends CI_Model
{

	var $table = 'suara_24'; //nama tabel dari database
	var $column_order = array(null, 'total_suara_24', 'total_suara_sah_24', 'total_suara_tidak_sah_24', 'suara_no1_24', 'suara_no2_24', 'suara_no3_24', 'nama_tps_24'); //Sesuaikan dengan field
	var $column_search = array('total_suara_24', 'nama_tps_24'); //field yang diizin untuk pencarian 
	var $order = array('nama_tps_24' => 'ASC'); // default order 

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
		$this->db->select('*')->from('suara_24');
		$this->db->order_by('nama_tps_24', 'ASC');
		return $this->db->get()->result_array();
	}

	public function add($post)
	{
		$saveData['total_suara_24'] = $post['total_suara_24'];
		$saveData['total_suara_sah_24'] = $post['total_suara_sah_24'];
		$saveData['total_suara_tidak_sah_24'] = $post['total_suara_tidak_sah_24'];
		$saveData['suara_no1_24'] = $post['suara_no1_24'];
		$saveData['suara_no2_24'] = $post['suara_no2_24'];
		$saveData['suara_no4_24'] = $post['suara_no4_24'];
		$saveData['nama_tps_24'] = $post['nama_tps_24'];

		$this->db->insert('suara_24', $saveData);
	}

	public function deleted($nama_tps_24)
	{
		return $this->db->delete('suara_24', ['nama_tps_24' => $nama_tps_24]);
	}
}
