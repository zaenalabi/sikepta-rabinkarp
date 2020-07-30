<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Tentang extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->check_login();
        if ($this->session->userdata('id_role') != "2") {
            redirect('', 'refresh');
        }
    }

    public function index()
    {
        $site = $this->Konfigurasi_model->listing();
        $data = array(
            'title'                 => 'Tentang | '.$site['nama_website'],
            'favicon'               => $site['favicon'],
            'site'                  => $site,
        );
        $this->template->load('layoutu/template', 'member/tentang', $data);
    }
}
