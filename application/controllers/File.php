<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class File extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function upload(){
        $data = array();

        //Memuat Library validasi form
        $this->load->library('form_validation');

        //Memuat file helper
        $this->load->helper('file');

        if($this->input->post('uploadFile')){
            $this->form_validation->set_rules('file', '', 'callback_cek_file');

            if($this->form_validation->run() == true){
                //konfigurasi upload
                $config['upload_path']   = 'upload/file/';
                $config['allowed_types'] = 'gif|jpg|png|pdf';
                $config['max_size']      = 1024;
                $this->load->library('upload', $config);
                //upload file ke direktori
                if($this->upload->do_upload('file')){
                    $uploadData = $this->upload->data();
                    $uploadedFile = $uploadData['file_name'];

                    /*
                     *memasukkan informasi file ke dalam database
                     *.......
                     */

                    $data['success_msg'] = 'File telah berhasil diupload.';
                }else{
                    $data['error_msg'] = $this->upload->display_errors();
                }
            }
        }

        //memuat view
        $this->load->view('file/upload', $data);
    }

    /*
     * format file diperiksa saat validasi
     */
    public function cek_file($str){
        $allowed_mime_type_arr = array('application/pdf','image/gif','image/jpeg','image/pjpeg','image/png','image/x-png');
        $mime = get_mime_by_extension($_FILES['file']['name']);
        if(isset($_FILES['file']['name']) && $_FILES['file']['name']!=""){
            if(in_array($mime, $allowed_mime_type_arr)){
                return true;
            }else{
                $this->form_validation->set_message('cek_file', 'Silahkan pilih hanya file pdf/gif/jpg/png.');
                return false;
            }
        }else{
            $this->form_validation->set_message('cek_file', 'Silakan pilih file untuk diupload.');
            return false;
        }
    }
}
