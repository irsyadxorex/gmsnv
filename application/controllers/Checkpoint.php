<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Checkpoint extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        // check_role_danru();
        $this->load->model('M_checkpoint');
        $this->load->library('Pdf_report');
    }

    function get_ajax()
    {
        $checkpoints = $this->M_checkpoint->get_datatables();
        $data = array();
        $no = @$_POST['start'];
        foreach ($checkpoints as $check) {
            $no++;
            $row = array();
            $row[] = $no . ".";

            $row[] = indo_date($check->currentdatetime);
            $row[] = indo_time($check->currentdatetime);
            $row[] = $check->nama;
            if ($this->session->userdata('id_site') == 0) {
                $row[] = $check->site;
            }
            $row[] = $check->lokasi;
            $row[] = $check->isclear == 1 ? '<span class="text-success"><i class="fa fa-check"></i></span>' : '<span class="text-danger"><i class="fa fa-ban"></i></span>';
            $row[] = $check->note;

            $data[] = $row;
        }
        $output = array(
            "draw" => @$_POST['draw'],
            "recordsTotal" => $this->M_checkpoint->count_all(),
            "recordsFiltered" => $this->M_checkpoint->count_filtered(),
            "data" => $data,
        );
        // output to json format
        echo json_encode($output);
    }


    public function index()
    {
        $data = [
            'title' => 'Checkpoint',
            'checkpoints' => $this->M_checkpoint->get_checkpoints()

        ];
        $this->template->load('templates/template', 'checkpoints/checkpoint_data', $data);
    }
    public function report()
    {
        // $checkpoints = $this->db->query("select * from sites s , gms_checkpoints gc ,users u, gms_qrcode_tags gqt WHERE gc.id_user = u.id and gc.tagid =gqt.tagid and gqt.id_site = s.id_site order by 'desc' ;")->result_array();
        $data = [
            'title' => 'Checkpoint Report',
            'checkpoints' => $this->M_checkpoint->get_checkpoints(),
            'sites' => $this->M_site->getSite()
        ];
        $this->template->load('templates/template', 'checkpoints/checkpoint_report', $data);
    }

    public function process()
    {
        if ($this->session->userdata('id_site') != 0) {
            $id_site = $this->session->userdata('id_site');
        } else {
            $id_site = $this->input->post('id_site', true);
        }
        $date = $this->input->post('date', true);
        $danru = $this->db->query("select * from users u WHERE id_site = $id_site and id_position = 2;")->result_array();
        $checkpoints = $this->db->query("select * FROM gms_checkpoint_details gcd, users u , sites s, gms_qrcode_tags gqt WHERE gcd.tagid_user =gqt.tagid and u.id =gcd.id_user and gcd.id_site =s.id_site and gcd.id_site =$id_site and tanggal = '$date';")->result_array();
        $data = [
            'site' => $this->db->get_where('sites', ['id_site' => $id_site])->row_array(),
            'date' => $date,
            'danru' => $danru,
            'checkpoints' => $checkpoints
        ];

        if (isset($_POST['export'])) {
            $this->load->view('checkpoints/checkpoint_export', $data);
        } else if (isset($_POST['preview'])) {
            $this->load->view('checkpoints/checkpoint_preview', $data);
        }
        // if (isset($_POST['export'])) {
        //     $this->export_pdf();
        // } else if (isset($_POST['preview'])) {
        //     $this->preview();
        // }
    }


    ////////////////////////////////////
    public function export_pdf()
    {
        if ($this->session->userdata('id_site') != 0) {
            $id_site = $this->session->userdata('id_site');
        } else {
            $id_site = $this->input->post('site_id', true);
        }
        $date = $this->input->post('date', true);
        $danru = $this->db->query("select * from users u WHERE id_site = $id_site and id_position = 2;")->result_array();
        $checkpoints = $this->db->query("select gc.currentdatetime as jam ,u.nama, gqt.lokasi,gc.isclear , gc.note from gms_checkpoints gc ,users u, gms_qrcode_tags gqt WHERE gc.id_user =u.id and gc.tagid =gqt.tagid and u.id_site = $id_site and  date(gc.currentdatetime) = '$date';")->result_array();
        $data = [
            'site' => $this->db->get_where('sites', ['id_site' => $id_site])->row_array(),
            'date' => $date,
            'danru' => $danru,
            'checkpoints' => $checkpoints
        ];
        $this->load->view('checkpoints/checkpoint_export', $data);
    }

    public function preview()
    {
        if ($this->session->userdata('id_site') != 0) {
            $id_site = $this->session->userdata('id_site');
        } else {
            $id_site = $this->input->post('site_id', true);
        }
        $date = $this->input->post('date', true);
        $checkpoints = $this->db->query("select gc.currentdatetime as jam ,e.nama, gqt.lokasi,gc.isclear , gc.note from gms_checkpoints gc ,users u, gms_qrcode_tags gqt WHERE gc.id_user =u.id and gc.tagid =gqt.tagid and u.id_site = $id_site and  date(gc.currentdatetime) = '$date';")->result_array();
        $data = [
            'site' => $this->db->get_where('sites', ['id_site' => $id_site])->row_array(),
            'date' => $date,
            'checkpoints' => $checkpoints
        ];
        $this->load->view('checkpoints/checkpoint_preview', $data);
    }
}
