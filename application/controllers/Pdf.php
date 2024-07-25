<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pdf extends CI_Controller
{

	public function __construct()
	{
		# code...
		parent::__construct();
		if ($this->session->userdata('level') == null) {
			redirect('Auth');
		}
		$this->load->library('pdfgenerator');
		$this->load->model('Transaction_m');
	}

	public function loadView($note)
	{
		// var_dump($note);
		// exit;
		$data['title'] = 'Invoices';
		$data['sale'] = $this->Transaction_m->sale($note);
		$data['details'] = $this->Transaction_m->detailInvoices($note);
		$data['note'] = $note;

		$file_pdf = $data['title'];
		$paper = 'A4';
		$orientation = "portrait";
		$html = $this->load->view('pages/Invoices/invoicePdf', $data, true);
		$this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
	}
}
