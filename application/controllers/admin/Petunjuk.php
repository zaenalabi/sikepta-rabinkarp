<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Petunjuk extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->check_login();
        if ($this->session->userdata('id_role') != "1") {
            redirect('', 'refresh');
        }
        $this->load->helper('download');
    }

    public function index()
    {
        $site = $this->Konfigurasi_model->listing();
        $data = array(
            'title' => 'Petunjuk | ' . $site['nama_website'],
            'favicon' => $site['favicon'],
            'site' => $site
        );
        $this->template->load('layout/template', 'admin/petunjuk', $data);
    }

    public function petunjuk_download(){
        force_download('assets/upload/doc/user guide.pdf',NULL);
    }
}
