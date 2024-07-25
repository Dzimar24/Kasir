<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('level') !=  'Admin') {
			redirect('Dashboard');
		}
		$this->load->model('Product_m');
		$this->load->library('form_validation');
	}

	public function getData()
	{
		if ($this->input->is_ajax_request() == true) {
			$this->load->model('Product_m', 'Product');
			$list = $this->Product->get_datatables();
			$data = array();
			$no = $_POST['start'];
			foreach ($list as $field) {

				$no++;
				$row = array();

				$buttonUpdateProduct = "<button type=\"button\" title=\"Button Update\" class=\"btn btn-outline-info\" onclick=\"update('" . $field->nama . "')\"><i class=\"bi bi-pencil-square\"></i></button>";
				$buttonDeletedProduct = "<button type=\"button\" title=\"Button Deleted\" class=\"btn btn-outline-danger\" onclick=\"deleted('" . $field->nama . "')\"><i class=\"bi bi-trash\"></i></button>";

				$row[] = $no;
				$row[] = $field->nama;
				$row[] = $field->code;
				$row[] = $field->stok;
				$row[] = 'Rp. ' . number_format($field->harga);
				$row[] = $buttonUpdateProduct . ' ' . $buttonDeletedProduct;
				$data[] = $row;
			}

			$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->Product->count_all(),
				"recordsFiltered" => $this->Product->count_filtered(),
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
		$data['getData'] = $this->Product_m->get();
		$data['title'] = 'Product';
		$this->template->load('template', 'Product', $data);
	}

	public function productPlus()
	{
		if ($this->input->is_ajax_request() == true) {

			$this->form_validation->set_rules('nama', 'nama', 'trim|required');
			$this->form_validation->set_rules('code', 'code', 'trim|required|min_length[4]|is_unique[product.code]');
			$this->form_validation->set_rules('stok', 'stok', 'trim|required');
			$this->form_validation->set_rules('harga', 'harga', 'trim|required');

			if ($this->form_validation->run() == TRUE) {
				# code...
				$post = $this->input->post(null, TRUE);
				$this->Product_m->add($post);

				$msg = [
					'success' => 'Successfully added Product'
				];
			} else {
				$msg = [
					// 'error' => validation_errors()
					'error' => [
						'nama' => form_error('nama'),
						'code' => form_error('code'),
						'stok' => form_error('stok'),
						'harga' => form_error('harga')
					]
				];
			}

			echo json_encode($msg);
		}
	}

	public function updateProduct()
	{
		if ($this->input->is_ajax_request() == true) {

			// $nama = $this->input->post('nama', true);
			// $code = $this->input->post('code', true);
			// $stok = $this->input->post('stok', true);
			// $harga = $this->input->post('harga', true);

			$this->Product_m->update();

			$msg = [
				'success' => 'Successfully Updated Product'
			];
			echo json_encode($msg);
		}
	}

	public function modalUpdateProduct()
	{
		if ($this->input->is_ajax_request() == TRUE) {
			# code...
			$nama = $this->input->post('nama', true);

			$getData = $this->Product_m->dataGet($nama);

			if ($getData->num_rows() > 0) {
				# code...
				$row = $getData->row_array();

				$data = [
					'nama' => $nama,
					'id_barang' => $row['id_barang'],
					'code' => $row['code'],
					'stok' => $row['stok'],
					'harga' => $row['harga']
				];
			}
			$msg = [
				'success' => $this->load->view('pages/buildkite/modalProduct/modalUpdateProduct', $data, true)
			];
			echo json_encode($msg);
		}
	}

	public function deletedProduct()
	{
		if ($this->input->is_ajax_request() == true) {
			$nama = $this->input->post('nama', true);

			$delete = $this->Product_m->deletedUser($nama);

			if ($delete) {
				$msg = [
					'success' => 'Product deleted successfully'
				];
			}
			echo json_encode($msg);
		}
	}
}
