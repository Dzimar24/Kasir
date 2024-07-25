<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_m extends CI_Model
{
	var $table = 'user'; //nama tabel dari database
	var $column_order = array(null, 'username', 'nama', 'level', null); //Sesuaikan dengan field
	var $column_search = array('username', 'nama'); //field yang diizin untuk pencarian 
	var $order = array('username' => 'ASC'); // default order 

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
		$this->db->select('*')->from('user');
		$this->db->order_by('nama', 'ASC');
		return $this->db->get()->result_array();
	}

	public function add($post)
	{
		$saveData['username'] = $post['username'];
		$saveData['nama'] = $post['nama'];
		$saveData['password'] = $post['password'];
		$saveData['level'] = $post['level'];

		$this->db->insert('user', $saveData);
	}

	public function update($username, $level, $nama)
	{
		$update = [
			'level' => $level,
			'nama' => $nama
		];

		$this->db->where('username', $username);
		$this->db->update('user', $update);
	}

	public function dataGet($username)
	{
		return $this->db->get_where('user', ['username' => $username]);
	}

	public function deleteUser($username)
	{
		return $this->db->delete('user', ['username' => $username]);
	}

	public function resetPassword($username)
	{
		$data = array(
			'password' => 1234,
		);

		$this->db->where('username', $username);
		$this->db->update('user', $data);
	}
}

