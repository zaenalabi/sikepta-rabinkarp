<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Sinonim extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->check_login();
		if ($this->session->userdata('id_role') != "1") {
			redirect('', 'refresh');
		}
		$this->load->model('Kemiripan_model');
	}

	public function index()
	{
		$site = $this->Konfigurasi_model->listing();
		$data = array(
			'title' => 'Sinonim | ' . $site['nama_website'],
			'favicon' => $site['favicon'],
			'site' => $site
		);
		$this->template->load('layout/template', 'admin/sinonim', $data);
	}

	public function getDokumen()
	{
		echo json_encode($this->Kemiripan_model->get_all()->result());
	}

	public function list_sinonim()
	{
		$this->load->model('Sinonim_model');
		$data = $this->Sinonim_model->get_all()->result();
		$json_data = array(
			'data' => $data
		);
		echo json_encode($json_data);
	}

	public function tambah_sinonim()
	{
		$this->load->model('Sinonim_model');
		$kata = $this->input->post('kata');
		$artikata = $this->input->post('artikata');
		$res = $this->Sinonim_model->tambah($kata, $artikata);
		if ($res) {
			$data['message'] = "Data berhasil disimpan";
		} else {
			$data['message'] = "Data gagal disimpan";
		}
		$json_data = array(
			'data' => $data
		);
		echo json_encode($json_data);
	}

	public function hapus_sinonim($idSinonim)
	{
		$this->load->model('Sinonim_model');
		$res = $this->Sinonim_model->hapus($idSinonim);
		if ($res) {
			$data['message'] = "Data berhasil dihapus";
		} else {
			$data['message'] = "Data gagal dihapus";
		}
		$json_data = array(
			'data' => $data
		);
		echo json_encode($json_data);
	}

	public function update_sinonim($idSinonim = NULL)
	{
		$this->load->model('Sinonim_model');
		$kata = $this->input->post('kata');
		$artikata = $this->input->post('artikata');
		$res = $this->Sinonim_model->update($idSinonim, $kata, $artikata);
		if ($res) {
			$data['message'] = "Data berhasil diupdate";
		} else {
			$data['message'] = "Data gagal diupdate";
		}
		$json_data = array(
			'data' => $data
		);
		echo json_encode($json_data);
	}
	
}
