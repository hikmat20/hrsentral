<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Formabsen extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('master_model');
        $this->load->model('employees_model');
        $this->load->database();
    }

    public function index()
    {
        $type_absen = $this->db->get_where('ms_generate', ['tipe' => 'tipe_absen'])->result();
        // $sql = "select kode_1,kode_2 from ms_generate where tipe='tipe_absen' order by kode_1";
        $data = [
            'type' => $type_absen
        ];
        $this->load->view('Formabsen/index', $data);
    }
}
