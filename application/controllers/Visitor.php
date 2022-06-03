<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Visitor extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        // check_role_danru();
        $this->load->model('M_visitor');
    }

    function get_ajax()
    {
        $visitors = $this->M_visitor->get_datatables();
        $data = array();
        $no = @$_POST['start'];
        foreach ($visitors as $visitor) {
            $no++;
            $row = array();
            $row[] = $no . ".";

            $row[] = indo_date($visitor->tanggal) . ' - ' . indo_sort_time($visitor->jam);
            $row[] = '[' . $visitor->no_visitor . ']';
            $row[] = $visitor->status_tamu == 1 ? '<span class="label label-warning">Check IN</span>' : '<span class="label label-default">Check Out</span>';
            if ($this->session->userdata('id_site') == 0) {
                $row[] = $visitor->site;
            }
            $row[] = $visitor->tamu;
            $row[] = $visitor->id_perlu == 1 ? $visitor->keterangan_perlu : $visitor->perlu;
            $row[] = $visitor->blok . ' - ' . $visitor->penghuni;
            $row[] = $visitor->nama;
            $row[] =  '<a id="set_detail" class="label label-info" data-toggle="modal" data-target="#modal-detail"  data-images="' . $visitor->images . '"><i class="fa fa-eye"></i>Detail</a>';

            $data[] = $row;
        }
        $output = array(
            "draw" => @$_POST['draw'],
            "recordsTotal" => $this->M_visitor->count_all(),
            "recordsFiltered" => $this->M_visitor->count_filtered(),
            "data" => $data,
        );
        // output to json format
        echo json_encode($output);
    }

    public function index()
    {

        // $site_id = $this->fungsi->user_login()->id_site;
        // if ($site_id == 0) {
        //     $visitors = $this->db->query("select  * FROM gms_visitor_report gvr , sites s WHERE gvr.idsite = s.site_id ORDER by gvr.vid ;")->result_array();
        // } elseif ($site_id != null) {
        //     $visitors = $this->db->query("select  * FROM gms_visitor_report gvr , sites s WHERE gvr.idsite = s.site_id and gvr.idsite = $site_id ORDER by gvr.vid ;")->result_array();
        // }

        $data = [
            'title' => 'Visitor',
            // 'visitors' => $visitors
        ];
        $this->template->load('templates/template', 'visitors/visitor_data', $data);
    }
}
