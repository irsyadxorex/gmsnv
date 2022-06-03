<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Activity extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        // check_role_danru();
        $this->load->library('Pdf_report');
        $this->load->model('M_activity');
    }


    function get_ajax()
    {
        $activities = $this->M_activity->get_datatables();
        $data = array();
        $no = @$_POST['start'];
        foreach ($activities as $activity) {
            $no++;
            $row = array();
            $row[] = $no . ".";

            $row[] = indo_date($activity->currentdatetime);
            $row[] = indo_time($activity->currentdatetime);
            if ($this->session->userdata('id_site') == 0) {
                $row[] = $activity->site;
            }
            $row[] = $activity->nama;
            $row[] = $activity->activity;
            $row[] =  '<a id="set_detail" class="label label-info" data-toggle="modal" data-target="#modal-detail" data-nama="' . $activity->nama . '" data-site="' . $activity->site . '" data-activity="' . $activity->activity . '" data-images="' . $activity->images . '"><i class="fa fa-eye"></i>Detail</a>';

            $data[] = $row;
        }
        $output = array(
            "draw" => @$_POST['draw'],
            "recordsTotal" => $this->M_activity->count_all(),
            "recordsFiltered" => $this->M_activity->count_filtered(),
            "data" => $data,
        );
        // output to json format
        echo json_encode($output);
    }

    public function index()
    {
        // $site_id = $this->session->userdata('id_site');
        // if ($site_id == 0) {
        //     $activities = $this->db->query("select * FROM gms_activities ga , users u , sites s WHERE ga.id_user =u.id and u.id_site =s.id_site ORDER by ga.id_activity desc;")->result_array();
        // } elseif ($site_id != null) {
        //     $activities = $this->db->query("select * FROM gms_activities ga , users u , sites s WHERE ga.id_user =u.id and u.id_site =s.id_site and u.id_site = $site_id ORDER by ga.id_activity desc ;")->result_array();
        // }
        $data = [
            'title' => 'Aktifitas',
            // 'activities' => $activities
        ];
        $this->template->load('templates/template', 'activities/activity_data', $data);
    }
    public function report()
    {
        $data = [
            'title' => 'Activity Report',
            'sites' => $this->M_site->getSite()
        ];
        $this->template->load('templates/template', 'activities/activity_report', $data);
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

        $activity = $this->db->query("select *, ga.currentdatetime as jam FROM gms_activities ga, users u WHERE ga.id_user =u.id and u.id_site = $id_site and date(ga.currentdatetime) = '$date' ;")->result_array();

        $attendance = $this->db->query("select ga.id_att ,u.nama, p.position , gs.keterangan , ga.datetime_in, ga.datetime_out FROM gms_attendances ga, users u,positions p ,gms_shift gs WHERE ga.id_user =u.id and ga.id_shift = gs.id_shift and u.id_position =p.id_position and u.id_site = $id_site and date(ga.created_at) = '$date' ;")->result_array();

        $visitor = $this->db->query("select count(id_tamu) as counts, id_site, tanggal FROM gms_tamu gt where tanggal = '$date' and id_site = $id_site  group by id_site ;")->row_array();
        $data = [
            'site' => $this->db->get_where('sites', ['id_site' => $id_site])->row_array(),
            'date' => $date,
            'danru' => $danru,
            'activities' => $activity,
            'attendance' => $attendance,
            'visitor' => $visitor
        ];

        if (isset($_POST['export'])) {
            $this->load->view('activities/activity_export', $data);
        } else if (isset($_POST['preview'])) {
            $this->load->view('checkpoints/checkpoint_preview', $data);
        }
    }


    /////////////////////////////////////
    public function export_pdf()
    {
        $site_id = $this->input->post('site_id', true);
        $date = $this->input->post('date', true);
        $danru = $this->db->query("select * from employees e WHERE id_site = $site_id and id_position = 2 and not nik = 2134;")->result_array();
        $activity = $this->db->query("select *, ga.date_time as jam FROM gms_activities ga, employees e WHERE ga.nik =e.nik and e.id_site = $site_id and date(ga.date_time) = '$date' ;")->result_array();
        $attendance = $this->db->query("select gna.attid ,e.name, p.`position` , gas.keterangan , gna.hours FROM gms_new_attendances gna, employees e,positions p ,gms_attendance_status gas WHERE gna.nik =e.nik and gna.att_status = gas.id and e.id_position =p.position_id and gna.id_site = $site_id and date(gna.currentdatetime) = '$date' ;")->result_array();
        $visitor = $this->db->query("select * FROM gms_visitor_report gvr WHERE idsite = $site_id  and thedate ='$date';")->row_array();
        $data = [
            'site' => $this->db->get_where('sites', ['site_id' => $site_id])->row_array(),
            'date' => $date,
            'danru' => $danru,
            'activities' => $activity,
            'attendance' => $attendance,
            'visitor' => $visitor
        ];
        $this->load->view('activities/activity_export', $data);
    }

    public function preview($params = null)
    {
        $this->db->select('*, p_items.name as item_name, t_cart.price as cart_price');
        $this->db->from('t_cart');
        $this->db->join('p_items', 't_cart.item_id = p_items.item_id');
        if ($params != null) {
            $this->db->where($params);
        }
        $this->db->where('user_id', $this->session->userdata('user_id'));
        $query = $this->db->get();
        return $query;
    }
}
