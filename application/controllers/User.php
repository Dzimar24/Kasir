<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('level') !=  'Admin') {
			redirect('Dashboard');
		}
		$this->load->model('User_m');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$data['getData'] = $this->User_m->get();
		$data['title'] = 'User';
		$this->template->load('template', '/admin/user', $data);
	}

	public function getData()
	{
		if ($this->input->is_ajax_request() == true) {
			$this->load->model('User_m', 'user');
			$list = $this->user->get_datatables();
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $field) {

				$no++;
				$row = array();

				$buttonUpdate = "<button type=\"button\" class=\"btn btn-outline-info\" title=\"Edit Data\" onclick=\"update('" . $field->username . "')\"><i class=\"bi bi-pencil-square\"></i></button>";
				$buttonDelete = "<button type=\"button\" class=\"btn btn-outline-danger\" title=\"Delete Data\"  onclick=\"deleted('" . $field->username . "')\"><i class=\"bi bi-trash\"></i></button>";
				$buttonResetPassword = "<button type=\"button\" onclick=\"resetPassword('" . $field->username . "')\" class=\"btn btn-outline-warning\" title=\"Reset Password\"><i class=\"bi bi-arrow-clockwise\"></i></button>";

				$row[] = $no;
				$row[] = $field->username;
				$row[] = $field->nama;
				$row[] = $field->level;
				$row[] = $buttonUpdate . ' ' . $buttonDelete . ' ' . $buttonResetPassword;
				$data[] = $row;
			}

			$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->user->count_all(),
				"recordsFiltered" => $this->user->count_filtered(),
				"data" => $data,
			);
			//output dalam format JSON
			echo json_encode($output);
		} else {
			exit('Maaf data tidak bisa ditampilkan');
		}
	}
	public function userPlus()
	{
		if ($this->input->is_ajax_request() == true) {

			$this->form_validation->set_rules('username', 'username', 'trim|required|min_length[3]|is_unique[user.username]');
			$this->form_validation->set_rules('nama', 'nama', 'trim|required');
			$this->form_validation->set_rules('password', 'password', 'trim|required');
			$this->form_validation->set_rules('level', 'level', 'required');

			if ($this->form_validation->run() == TRUE) {
				# code...
				$post = $this->input->post(null, TRUE);
				$this->User_m->add($post);

				$msg = [
					'success' => 'Successfully added User'
				];
			} else {
				$msg = [
					// 'error' => validation_errors()
					'error' => [
						'username' => form_error('username'),
						'nama' => form_error('nama'),
						'password' => form_error('password'),
						'level' => form_error('level'),
					]
				];
			}

			echo json_encode($msg);
		}
	}

	public function userUpdate()
	{
		if ($this->input->is_ajax_request() == true) {

			$username = $this->input->post('username', true);
			$nama = $this->input->post('nama', true);
			$level = $this->input->post('level', true);

			$this->User_m->update($username, $level, $nama);

			$msg = [
				'success' => 'Successfully Updated'
			];
			echo json_encode($msg);
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

	public function modalUpdate()
	{
		if ($this->input->is_ajax_request() == TRUE) {
			# code...
			$username = $this->input->post('username', true);

			$getData = $this->User_m->dataGet($username);

			if ($getData->num_rows() > 0) {
				# code...
				$row = $getData->row_array();

				$data = [
					'username' => $username,
					'nama' => $row['nama'],
					'level' => $row['level']
				];
			}
			$msg = [
				'success' => $this->load->view('pages/buildkite/modalUpdate', $data, true)
			];
			echo json_encode($msg);
		}
	}

	public function deleteData()
	{
		if ($this->input->is_ajax_request() == true) {
			$username = $this->input->post('username', true);

			$delete = $this->User_m->deleteUser($username);

			if ($delete) {
				$msg = [
					'success' => 'User deleted successfully'
				];
			}
			echo json_encode($msg);
		}
	}

	public function resetPassword()
	{
		if ($this->input->is_ajax_request() == true) {

			$username = $this->input->post('username', true);

			$this->User_m->resetPassword($username);

			$msg = [
				'success' => 'Successfully Reset Password',
			];
			echo json_encode($msg);
		}
	}
}
