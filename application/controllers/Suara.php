<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Suara extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('level') == null) {
			redirect('Auth');
		}
		$this->load->model('Suara_m');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$data['getData'] = $this->Suara_m->get();
		$data['title'] = 'Suara';
		$this->template->load('template', 'suara', $data);
	}

	public function getData()
	{
		if ($this->input->is_ajax_request() == true) {
			$this->load->model('Suara_m', 'suara');
			$list = $this->suara->get_datatables();
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $field) {

				$buttonDeletedProduct = "<button type=\"button\" title=\"Button Deleted\" class=\"btn btn-outline-danger\" onclick=\"deleted('" . $field->nama_tps_24 . "')\"><i class=\"bi bi-trash\"></i></button>";

				$no++;
				$row = array();


				$row[] = $no;
				$row[] = $field->nama_tps_24;
				$row[] = $field->total_suara_sah_24;
				$row[] = $field->total_suara_tidak_sah_24;
				$row[] = $field->suara_no1_24;
				$row[] = $field->suara_no2_24;
				$row[] = $field->suara_no4_24;
				$row[] = $field->total_suara_24;
				$row[] = $buttonDeletedProduct;
				$data[] = $row;
			}

			$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->suara->count_all(),
				"recordsFiltered" => $this->suara->count_filtered(),
				"data" => $data,
			);
			//output dalam format JSON
			echo json_encode($output);
		} else {
			exit('Maaf data tidak bisa ditampilkan');
		}
	}

	public function suaraPlus()
	{
		if ($this->input->is_ajax_request() == true) {

			$this->form_validation->set_rules('total_suara_24', 'total_suara_24', 'required|trim');
			$this->form_validation->set_rules('total_suara_sah_24', 'total_suara_sah_24', 'required|trim');
			$this->form_validation->set_rules('total_suara_tidak_sah_24', 'total_suara_tidak_sah_24', 'required|trim');
			$this->form_validation->set_rules('suara_no1_24', 'suara_no1_24', 'required|trim');
			$this->form_validation->set_rules('suara_no2_24', 'suara_no2_24', 'required|trim');
			$this->form_validation->set_rules('suara_no4_24', 'suara_no4_24', 'required|trim');
			$this->form_validation->set_rules('nama_tps_24', 'nama_tps_24', 'required|trim');

			if ($this->form_validation->run() == TRUE) {
				# code...
				$conditionsOne = $this->input->post('total_suara_sah_24') + $this->input->post('total_suara_tidak_sah_24');
				$alertOne = $this->input->post('total_suara_24') != $conditionsOne;

				$conditionsTwo = $this->input->post('suara_no1_24') + $this->input->post('suara_no2_24') + $this->input->post('suara_no4_24');
				$alertTwo = $this->input->post('total_suara_sah_24') != $conditionsTwo;

				if ($alertOne) {
					# code...
					$msg = [
						'wrong' => 'Total Suara Todak Cukup'
					];
				} elseif ($alertTwo) {
					# code...
					$msg = [
						'wrong' => 'Total Suara Tidak Cocok '
					];
				} else {
					# code...
					$post = $this->input->post(null, TRUE);
					$this->Suara_m->add($post);
					$msg = [
						'success' => 'Successfully added Suara'
					];
				}

			} else {
				$msg = [
					'error' => validation_errors()
				];
			}

			echo json_encode($msg);
		}
	}

	public function deleted()
	{
		if ($this->input->is_ajax_request() == true) {
			$nama_tps_24 = $this->input->post('nama_tps_24', true);

			$delete = $this->Suara_m->deleted($nama_tps_24);

			if ($delete) {
				$msg = [
					'success' => 'Product deleted successfully'
				];
			}
			echo json_encode($msg);
		}
	}
}
