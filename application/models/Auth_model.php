<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Auth_model extends CI_Model
{
    public $table       = 'tbl_user';
    public $id          = 'tbl_user.id';

    public function __construct()
    {
        parent::__construct();
    }

    public function login($email, $password)
    {
        $query = $this->db->get_where('tbl_user', array('email'=>$email, 'password'=>$password));
        return $query->row_array();
    }

    public function check_account($email)
    {
        //cari email lalu lakukan validasi
        $this->db->where('email', $email);
        $query = $this->db->get($this->table)->row();

        //jika bernilai 1 maka user tidak ditemukan
        if (!$query) {
            return 1;
        }
        //jika bernilai 2 maka user tidak aktif
        if ($query->active == 0) {
            return 2;
        }
        //jika bernilai 3 maka password salah
        if (!hash_verified($this->input->post('password'), $query->password)) {
            return 3;
        }

        return $query;
    }

    public function logout($date, $id)
    {
        $this->db->where('tbl_user.id', $id);
        $this->db->update('tbl_user', $date);
    }
}
