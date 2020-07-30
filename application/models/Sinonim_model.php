<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sinonim_model extends CI_Model
{

	function get_by_kata($kata)
	{
		return $this->db
			->select('*')
			->where('lower(kata)', $kata)
			->get('sinonim');
	}

	function get_all()
	{
		return $this->db
			->select('*')
			->order_by('kata', 'asc')
			->get('sinonim');
	}

	public function tambah($kata, $artikata)
	{
		$data = array(
			'kata' => $kata,
			'artikata' => $artikata,
		);

		return $this->db->insert('sinonim', $data);
	}

	function hapus($idSinonim)
	{
		return $this->db
			->where('id_sinonim', $idSinonim)
			->delete('sinonim');
	}

	function get_baris($idSinonim)
	{
		return $this->db
			->select('*')
			->where('id_sinonim', $idSinonim)
			->limit(1)
			->get('sinonim');
	}

	function update($idSinonim, $kata, $artikata)
	{
		$dt = array(
			'kata' => $kata,
			'artikata' => $artikata,
		);

		return $this->db
			->where('id_sinonim', $idSinonim)
			->update('sinonim', $dt);
	}

}
