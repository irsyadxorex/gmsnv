<?php
defined('BASEPATH') or exit('No direct script access allowed');
require FCPATH . 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;



class Import extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        // check_role_danru();
    }

    // public function index()
    // {
    //     $visitors = $this->db->query('select * from gms_tamu gt order by id DESC limit 5;')->result_array();
    //     $data = [
    //         'title' => 'Dashboard',
    //         'visitors' => $visitors
    //     ];
    //     $this->template->load('templates/template', 'dashboard', $data);
    // }

    public function master_penghuni()
    {
        $this->load->view('import/master_penghuni');
    }
    public function importmp()
    {
        $upload_file = $_FILES['upload_file']['name'];
        $extension = pathinfo($upload_file, PATHINFO_EXTENSION);
        if ($extension == 'csv') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        } elseif ($extension == 'xls') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\xls();
        } else {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\xlsx();
        }
        $spreadsheet = $reader->load($_FILES['upload_file']['tmp_name']);
        $sheetdata = $spreadsheet->getActiveSheet()->toArray();
        // echo '<pre>'; print_r($sheetdata); die;
        $sheetcount = count($sheetdata);
        if ($sheetcount > 1) {

            $data = array();
            for ($i = 1; $i < $sheetcount; $i++) {
                // $id_site = $sheetdata[$i][0];
                $blok = $sheetdata[$i][0];
                $penghuni = $sheetdata[$i][1];
                $kategori = $sheetdata[$i][2];
                $data[] = array(
                    'id_site' => 2,
                    'blok' => $blok,
                    'penghuni' => $penghuni,
                    'kategori' => $kategori,
                );
            }
            $this->db->insert_batch('master_penghuni', $data);
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('message', 'alert("successfuly");');
                redirect('import/master_penghuni');
            } else {
                $this->session->set_flashdata('message', 'alert("failed, try again!")');
                redirect('import/master_penghuni');
            }
        }
        $this->session->set_flashdata('message', 'alert("failed, try again!")');
        redirect('import/master_penghuni');
    }
}
