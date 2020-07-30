<?php
defined('BASEPATH') or exit('No direct script access allowed');

//use SynonymAntonym\Dictionary;

ini_set('max_execution_time', 0);
ini_set('memory_limit', '2048M');

require_once(dirname(__FILE__) . '/../../libraries/dompdf/autoload.inc.php');

use Dompdf\Dompdf;

class Kemiripan extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->check_login();
		if ($this->session->userdata('id_role') != "1") {
			redirect('', 'refresh');
		}
		$this->load->helper(array('form', 'url', 'file'));
		$this->load->model('Kemiripan_model');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$site = $this->Konfigurasi_model->listing();
		$data = array(
			'title' => 'Uji Kemiripan | ' . $site['nama_website'],
			'favicon' => $site['favicon'],
			'site' => $site,
		);
		$this->template->load('layout/template', 'admin/kemiripan', $data);
	}

	//kanggo nyimpen dokumen
	public function tambah()
	{

		//Memuat Library validasi form
		$this->load->library('form_validation');

		//Memuat file helper
		// lakukan upload file dengan memanggil function upload yang ada di GambarModel.php
		$data = $this->Kemiripan_model->upload();
		if ($data['stat'] == 1) { // Jika proses upload sukses
			// Panggil function save yang ada di GambarModel.php untuk menyimpan data ke database
			$this->Kemiripan_model->save($data['res']['file_name']);
			//redirect('gambar'); // Redirect kembali ke halaman awal / halaman view data
			$data['message'] = "Data berhasil disimpan"; // Ambil pesan error uploadnya untuk dikirim ke file form dan ditampilkan
		} else { // Jika proses upload gagal
			$data['message'] = "Data gagal disimpan"; // Ambil pesan error uploadnya untuk dikirim ke file form dan ditampilkan
		}
		$json_data = array(
			'data' => $data
		);
		echo json_encode($json_data);
	}

	public function tambahUjiKemiripan()
	{
		$i = 0;
		foreach ($_POST['idProposal'] as $k) {
			$idProposal = $_POST['idProposal'][$i];
			$dokUji = $_POST['dokUji'][$i];
			$persentase = $_POST['persentase'][$i];
			$lamaProses = $_POST['lamaProses'][$i];
			$res = $this->Kemiripan_model->saveUjiKemiripan($idProposal, $dokUji, $persentase, $lamaProses);
			if ($res) {
				$data['message'] = "Data berhasil disimpan";
			} else {
				$data['message'] = "Data ke- " . $i . " gagal disimpan";
			}
			$i++;
		}
		if ($i > 0) {
			$ext = pathinfo($_POST['dokUji'][0], PATHINFO_EXTENSION);
			copy('docuji/test.' . $ext, 'hsldocuji/' . $_POST['dokUji'][0]);
		}
		$json_data = array(
			'data' => $data
		);
		echo json_encode($json_data);
	}

	public function cetakDok()
	{
		$dompdf = new Dompdf();

		// $json = json_encode($fileDokAsli);
 	// 	echo $json;
		$html = '<style type="text/css">
					table {
					  border-collapse: collapse;
					}
					
					table, th, td {
					  border: 1px solid black;
					}
				</style>

				Kemiripan dokumen :
				<table>
					<thead>
					<tr>
					<th>Nama Dokumen</th>
					<th>Waktu Proses</th>
					<th>Persentasi Kemiripan</th>
					</tr>
					</thead>
					<tbody>';
		//$dokAsli = $_GET['dokAsli'];
		$i = 0;
		foreach ($_GET['idProposal'] as $k) {
			$idProposal = $_GET['idProposal'][$i];
			$dokUji = $_GET['dokUji'][$i];
			$persentase = $_GET['persentase'][$i];
			$lamaProses = $_GET['lamaProses'][$i];
			$html .= '<tr>
					<td>' . $dokUji . '</td>
					<td>' . $persentase . '</td>
					<td>' . $lamaProses . '</td>
					</tr>';
			$i++;
		}
		
		
		$html .= '</tbody>
				</table>';
		$dompdf->loadHtml($html);
		$dompdf->render();
		$dompdf->stream();
	}

	public function getRabinKarp()
	{

		$this->load->library('session');
		$this->form_validation->set_rules('file', '', 'callback_cek_file');
		$out = array();
		$res = array();
		$this->load->library('docxconversion');
		$this->load->library('stem');
		$count = count($_FILES['files']['name']);
		delete_files('docuji/');
		$fileDokAsli = '';
		$fileDokAsliExt = '';
		for ($i = 0; $i < $count; $i++) {
			if (!empty($_FILES['files']['name'][$i])) {
				$fileDokAsli = $_FILES['files']['name'][$i];
				$fileDokAsliExt = pathinfo($fileDokAsli, PATHINFO_EXTENSION);
				$_FILES['file']['name'] = $fileDokAsli;
				$_FILES['file']['type'] = $_FILES['files']['type'][$i];
				$_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
				$_FILES['file']['error'] = $_FILES['files']['error'][$i];
				$_FILES['file']['size'] = $_FILES['files']['size'][$i];
				$config['upload_path'] = 'docuji/';
				$config['file_name'] = 'test';
				$config['allowed_types'] = 'docx|pdf';
				$config['max_size'] = 1536;
				$this->load->library('upload', $config);

				//print_r($this->upload->do_upload('file'));die();
				if ($this->upload->do_upload('file')) {
					$uploadData = $this->upload->data();
					$filename = $uploadData['file_name'];
					$out['out'] = '1';
					$out['msg'] = 'Upload file sukses';
				} else {
					// $this->session->set_flashdata('error_msg', 'dokumen gagal di');
					//redirect();
					$out['out'] = '0';
					$out['msg'] = 'Format dokumen tidak sesuai';
					//return $error;
//					print_r($error);
//					die;
//					echo $this->upload->display_errors(); die;
				}
			}
		}

		if ($out['out'] != '0') {
			$dokAsli = $this->docxconversion->convertToText('docuji/test.' . $fileDokAsliExt);
			if (str_word_count($dokAsli) == 0) {
				$out['out'] = '0';
				$out['msg'] = 'Dokumen kosong, silahkan ganti dokumen';
			} else if ($dokAsli == 'Terjadi kesalahan, silahkan konversi file PDF ke Doc/Docx') {
				$out['out'] = '0';
				$out['msg'] = 'Terjadi kesalahan, silahkan konversi file PDF ke Doc/Docx';
			} else {
				$dokUji = array();
				$idDokUji = array();
				$fileDokUji = array();
				$getDir = $this->Kemiripan_model->get_all()->result();
				foreach ($getDir as $row) {
					$dokUji[] = $this->docxconversion->convertToText('docta/' . $row->judul);
					$idDokUji[] = $row->id_proposal;
					$fileDokUji[] = $row->judul;
				}
			

				$kGram = $this->input->post('kGram');
				$dok1 = array();
				$isSinonim = $this->input->post('isSinonim');
				$jmlSinonimAsli = 0;
				$lamaSinonim = 0;
				if ($isSinonim == 'true') {
					$awal = microtime(true);
					$this->load->model('Sinonim_model');
//				$init = new Dictionary;
					$sinonim = array();
					$i = 0;
					foreach ($this->stem->tokenizing($dokAsli) as $item) {
						if (!$this->stem->stopword($item)) {
//						$results = $init->word($item)->synonym();
							$results = $this->Sinonim_model->get_by_kata($item);
							if ($results->num_rows() > 0) {
								$res = array();
								foreach ($results->result() as $re) {
									$res[] = $re->artikata;
								}
								$sinonim[$i]['kata'] = $item;
//							$sinonim[$i]['sin'] = $results['data'];
								$sinonim[$i]['sin'] = $res;
								$i++;
							}
							$dok1[] = $this->stem->stemming($item);
						}
					}
					foreach ($sinonim as $k) {
						foreach ($k['sin'] as $key) {
							$jmlSinonimAsli++;
						}
					}
					$akhir = microtime(true);
					$lamaSinonim = $akhir - $awal;
				} else {
					foreach ($this->stem->tokenizing($dokAsli) as $item) {
						if (!$this->stem->stopword($item)) {
							$dok1[] = $this->stem->stemming($item);
						}
					}
				}
				$Doc1 = implode(' ', $dok1);
				$res = array();
				$this->load->library('rabinkarp1');
				for ($i = 0; $i < count($dokUji); $i++) {
					$awal = microtime(true);
					$dok2 = array();
					$jmlSinonimUji = 0;
					if ($isSinonim == 'true') {
						foreach ($this->stem->tokenizing($dokUji[$i]) as $item) {
							if (!$this->stem->stopword($item)) {
								$newKata = $item;
								foreach ($sinonim as $kt) {
									if ($item == $kt['kata']) {
										break;
									} else {
										foreach ($kt['sin'] as $sin) {
											if ($item == $sin) {
												$newKata = $kt['kata'];
												$jmlSinonimUji++;
												break;
											}
										}
									}
								} 
							
								$dok2[] = $this->stem->stemming($newKata);
							}
						}
					} else {
						foreach ($this->stem->tokenizing($dokUji[$i]) as $item) {
							if (!$this->stem->stopword($item)) {
								$dok2[] = $this->stem->stemming($item);
							}
						}
					}
					$Doc2 = implode(' ', $dok2);
//			$params = array($Doc1, $Doc2, $kGram);
//			$this->load->library('rabinkarp1', $params);
					$this->rabinkarp1->getRabinKarp($Doc1, $Doc2, $kGram);
					$tingkatKemiripan = '';
					if ($this->rabinkarp1->similarity >= 90) {
						$tingkatKemiripan = "Plagiarisme";
					} else if (($this->rabinkarp1->similarity > 5) && ($this->rabinkarp1->similarity < 15)) {
						$tingkatKemiripan = "Rendah";
					} else if (($this->rabinkarp1->similarity >= 15) && ($this->rabinkarp1->similarity <= 50)) {
						$tingkatKemiripan = "Sedang";
					} else if (($this->rabinkarp1->similarity > 50) && ($this->rabinkarp1->similarity <= 90)) {
						$tingkatKemiripan = "Mendekati Plagiarisme";
					} else {
						$tingkatKemiripan = "Tidak ada kemiripan";
					}
					$res[$i]['kGram'] = $kGram;
					$res[$i]['dokAsli'] = $dokAsli; // $this->hightlightText($dokUji[$i], $dokAsli);
					$res[$i]['dokUji'] = $dokUji[$i]; // $this->hightlightText($dokAsli, $dokUji[$i]);
					$res[$i]['fileDokAsli'] = $fileDokAsli;
					$res[$i]['fileDokUji'] = $fileDokUji[$i];
					$res[$i]['idDokUji'] = $idDokUji[$i];
					$res[$i]['jmlPatternSama'] = $this->rabinkarp1->jumPatternSama;
					$res[$i]['perKemiripan'] = $this->rabinkarp1->similarity . " %";
					$res[$i]['tingkatKemiripan'] = $tingkatKemiripan;
					$res[$i]['jmlKataSblmProsesAsli'] = str_word_count($dokAsli) . " kata";
					$res[$i]['jmlKataStlhProsesAsli'] = str_word_count($Doc1) . " kata";
					$res[$i]['jmlPatternAsli'] = $this->rabinkarp1->jumPatternDocAsli;
					$res[$i]['jmlSinonimAsli'] = $jmlSinonimAsli;
					$res[$i]['jmlKataSblmProsesUji'] = str_word_count($dokUji[$i]) . " kata";
					$res[$i]['jmlKataStlhProsesUji'] = str_word_count($Doc2) . " kata";
					$res[$i]['jmlPatternUji'] = $this->rabinkarp1->jumPatternDocUji;
					$res[$i]['jmlSinonimUji'] = $jmlSinonimUji;
					$akhir = microtime(true);
					$lama = ($akhir - $awal) + $lamaSinonim;
					$res[$i]['wktProses'] = round($lama, 2) . " S";
				}

				$out['out'] = '1';
				$out['msg'] = 'Proses berhasil';
			}
		}
		echo json_encode(array(
			$out,
			'data' => $res
		));
	}


	private function tokenizing($kk)
	{
		$toLower = strtolower($kk);
		$ready = preg_replace('/[^a-zA-Z0-9]/', ',', $toLower);
		$exploded = explode(',', $ready);
		return $exploded;
	}

	private function stopword($kk)
	{
		$stopword = cekStopword($kk);
		return $stopword;
	}

	private function stemming($kk)
	{
		$stemming = stemming($kk);
		return $stemming;
	}

	private function hightlightText($doc1, $doc2)
	{
		$searchstrings = preg_replace('/\s+/', ' ', trim($doc1));
		$words = explode(' ', $searchstrings);
		$highlighted = array();
		foreach ($words as $word) {
			$highlighted[] = "<font style='background-color: red;'>" . $word . "</font>";
		}

		return strtr($doc2, array_combine($words, $highlighted));
	}

}
