<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kemiripan_model extends CI_Model
{

	function get_all()
	{
		return $this->db
			->select('id_proposal,judul,waktu_upload')
			->order_by('waktu_upload', 'desc')
			->get('proposal');
	}

	// // Fungsi untuk melakukan proses upload file
	public function upload()
	{
		$res = array();
		
		$count = count($_FILES['files']['name']);
		for ($i = 0; $i < $count; $i++) {
			if (!empty($_FILES['files']['name'][$i])) {
				$_FILES['file']['name'] = $_FILES['files']['name'][$i];
				$_FILES['file']['type'] = $_FILES['files']['type'][$i];
				$_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
				$_FILES['file']['error'] = $_FILES['files']['error'][$i];
				$_FILES['file']['size'] = $_FILES['files']['size'][$i];
				$config['upload_path'] = 'docta/';
				$config['allowed_types'] = 'docx|pdf';
				//$config['remove_spaces'] = FALSE;
				$this->load->library('upload', $config);


				if ($this->upload->do_upload('file')) {
					$res['stat'] = 1;
					$res['msg'] = "Dokumen berhasil diupload";
					$res['res'] = $this->upload->data();
				} else {
					$res['stat'] = 0;
					$res['msg'] = 0;
					$res['res'] = $this->upload->display_errors();
				}
			}
		}
		return $res;
	}

	public function validation_doc(){
		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('judul', 'judul', 'required');

		 if($this->form_validation->run()) // Jika validasi benar
			return TRUE; // Maka kembalikan hasilnya dengan TRUE
		else // Jika ada data yang tidak sesuai validasi
			return FALSE; // Maka kembalikan hasilnya dengan FALSE
	}

	// Fungsi untuk menyimpan data ke database
	public function save($judul)
	{
		$data = array(
			'judul' => $judul,
			'waktu_upload' => date("Y-m-d H:i:s")
		);

		$this->db->insert('proposal', $data);
	}

	public function saveUjiKemiripan($idProposal, $dokUji, $persentase, $lamaProses)
	{
		$data = array(
			'id_proposal' => $idProposal,
			'dok_uji' => $dokUji,
			'presentase' => $persentase,
			'lama_proses' => $lamaProses
		);

		return $this->db->insert('uji_kemiripan', $data);
	}

	function hapus($idProposal)
	{
		return $this->db
			->where('id_proposal', $idProposal)
			->delete('proposal');
	}

}
