<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dokumen extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->check_login();
		if ($this->session->userdata('id_role') != "2") {
			redirect('', 'refresh');
		}
		$this->load->model('Kemiripan_model');
	}

	public function index()
	{
		$site = $this->Konfigurasi_model->listing();
		$data = array(
			'title' => 'Dokumen | ' . $site['nama_website'],
			'favicon' => $site['favicon'],
			'site' => $site
		);
		$this->template->load('layoutu/template', 'member/dokumen', $data);
	}

	public function getDokumen()
	{
		echo json_encode($this->Kemiripan_model->get_all()->result());
	}

	public function hapus_dokumen($idProposal, $judul)
	{
		if (unlink('docta/' . $judul)) {
			$res = $this->Kemiripan_model->hapus($idProposal);
			if ($res) {
				$data['message'] = "Data berhasil dihapus";
			} else {
				$data['message'] = "Data gagal dihapus";
			}
			$json_data = array(
				'data' => $data
			);
		} else {
			$data['message'] = "Data gagal dihapus";
			$json_data = array(
				'data' => $data
			);
		}
		echo json_encode($json_data);
	}

}
