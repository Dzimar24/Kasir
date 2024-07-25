<?php
defined('BASEPATH') or exit ('No direct script access allowed');

class Auth extends CI_Controller
{
	public function index()
	{
		$data['title'] = 'Login';
		$this->load->view('login', $data);
	}

	public function action()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$this->db->from('user');
		$this->db->where('username', $username);
		$check = $this->db->get()->row();
		// var_dump($check);
		// exit;
		if ($check == NULL) {
			$this->session->set_flashdata('alert', '<div class="form-group position-relative mb-4"><p class="text-danger" style="font-size: 30px;">Password Wrong</p></div>');
			redirect('Auth');
		} else if ($password == $check->password) {
			$data = array(
				'id_user' => $check->id_user,
				'nama' => $check->nama,
				'username' => $check->username,
				'level' => $check->level,
			);
			$this->session->set_userdata($data);
			$this->session->set_flashdata('ok', 'You have successfully login !!');

			redirect('Dashboard');
		} else {
			$this->session->set_flashdata('alert', '
				<div class="form-group position-relative mb-4">
					<p class="text-danger" style="font-size: 30px;">Password Wrong</p>
				</div>
			');
			redirect('Auth');
		}
	}

	public function logOut()
	{
		# code...

		$this->session->sess_destroy();
		redirect('Auth');
	}
}
