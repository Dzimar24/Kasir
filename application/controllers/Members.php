<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Members extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('level') == null) {
			redirect('Auth');
		}
		//? Modal Members
		$this->load->model('Members_m');
		$this->load->library('form_validation');
	}

	public function getData()
	{
		if ($this->input->is_ajax_request() == true) {
			$this->load->model('Members_m', 'members');
			$list = $this->members->get_datatables();
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $field) {

				$no++;
				$row = array();

				$buttonUpdate = "<button type=\"button\" class=\"btn btn-outline-info\" title=\"Edit Data\" onclick=\"update('" . $field->nama . "')\"><i class=\"bi bi-pencil-square\"></i></button>";
				$buttonDelete = "<button type=\"button\" class=\"btn btn-outline-danger\" title=\"Delete Data\"  onclick=\"deleted('" . $field->nama . "')\"><i class=\"bi bi-trash\"></i></button>";

				$row[] = $no;
				$row[] = $field->nama;
				$row[] = $field->telp;
				$row[] = $field->alamat;
				$row[] = $buttonUpdate . ' ' . $buttonDelete;
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
			exit('Maaf data tidak bisa ditampilkan');
		}
	}

	public function index()
	{
		$data['getData'] = $this->Members_m->get();
		$data['title'] = 'Members';
		$this->template->load('template', 'members', $data);
	}

	public function plusMembers()
	{
		if ($this->input->is_ajax_request() == true) {
			$name = $this->input->post('nama', true);
			$tlp = $this->input->post('telp', true);
			$address = $this->input->post('alamat', true);

			// var_dump($name, $tlp, $address);
			// die;

			$this->form_validation->set_rules('nama', 'nama', 'trim|required');
			$this->form_validation->set_rules('telp', 'telp', 'trim|required|max_length[13]');
			$this->form_validation->set_rules('alamat', 'alamat', 'trim|required');

			if ($this->form_validation->run() == TRUE) {
				# code...
				$this->Members_m->add($name, $tlp, $address);

				$msg = [
					'success' => 'Successfully added Product'
				];
			} else {
				$msg = [
					// 'error' => validation_errors()
					'error' => [
						'nama' => form_error('nama'),
						'telp' => form_error('telp'),
						'alamat' => form_error('alamat')
					]
				];
			}

			echo json_encode($msg);
		}
	}

	public function updateMembers()
	{
		if ($this->input->is_ajax_request() == true) {

			// $nama = $this->input->post('nama', true);
			// $code = $this->input->post('code', true);
			// $stok = $this->input->post('stok', true);
			// $harga = $this->input->post('harga', true);

			$this->Members_m->update();

			$msg = [
				'success' => 'Successfully Updated Product'
			];
			echo json_encode($msg);
		}
	}

	public function modalUpdateMembers()
	{
		if ($this->input->is_ajax_request() == TRUE) {
			# code...
			$nama = $this->input->post('nama', true);

			$getData = $this->Members_m->dataGet($nama);

			if ($getData->num_rows() > 0) {
				# code...
				$row = $getData->row_array();

				$data = [
					'nama' => $nama,
					'id_pelanggan' => $row['id_pelanggan'],
					'telp' => $row['telp'],
					'alamat' => $row['alamat']
				];
			}
			$msg = [
				'success' => $this->load->view('pages/buildkite/modalMembers/modalUpdateMembers', $data, true)
			];
			echo json_encode($msg);
		}
	}

	public function deletedMembers()
	{
		if ($this->input->is_ajax_request() == true) {
			$nama = $this->input->post('nama', true);

			$delete = $this->Members_m->deletedMembers($nama);

			if ($delete) {
				$msg = [
					'success' => 'Product deleted successfully'
				];
			}
			echo json_encode($msg);
		}
	}
}
