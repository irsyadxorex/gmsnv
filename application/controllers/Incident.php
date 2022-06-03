<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Incident extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('M_incident');
    }

    public function index()
    {

        $data = [
            'title' => 'Incident',
            'incidents' => $this->M_incident->getIncident()->result_array()
        ];
        $this->template->load('templates/template', 'incidents/incident_data', $data);
    }

    public function review()
    {
    }
    public function add()
    {

        $data = [
            'title' => 'Laporkan Kejadian',
            'sites' => $this->M_site->getSite()
        ];

        // $this->template->load('templates/template', 'incidents/incident_add', $data);
        $this->form_validation->set_rules('site', 'Site', 'required');
        $this->form_validation->set_rules('subject', 'Subject', 'required');
        $this->form_validation->set_rules('time', 'Time', 'required');
        // $this->form_validation->set_rules('fileIncident', 'File', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');
        if ($this->form_validation->run() == false) {
            $this->template->load('templates/template', 'incidents/incident_add', $data);
        } else {
            $this->process_add();
        }
    }
    public function process_add()
    {
        $conifg['upload_path']     = './uploads/';
        $conifg['allowed_types']    = 'doc|docx|pdf';
        $config['max_size']         = 7999;
        $conifg['file_name']        = 'IncidentReport_' . date('Y-m-d') . '_' . $this->input->post('site');
        $this->load->library('upload', $conifg);

        if (isset($_POST['submit'])) {
            if ($this->upload->do_upload('fileIncident')) {
                // $post['image'] = $this->upload->data('file_name');
                $data = [
                    'doc' => $this->upload->data('file_name'),
                    'thetime' => $this->input->post('time'),
                    'thedate' => $this->input->post('date'),
                    'title' => $this->input->post('subject'),
                    'idsite' => $this->input->post('site_id'),
                    'status' => $this->input->post('status'),
                    'userid' => $this->fungsi->user_login()->id,
                ];
                $this->db->insert('gms_accident_report', $data);
                if ($this->db->affected_rows() > 0) {
                    $this->session->set_flashdata('message', '<div style="opacity: .6" class="alert alert-success" role="alert">
                    Selamat! Incident Report berhasil diupload!
                    </div>');
                    redirect('report/incident');
                }
            } else {
                $error = $this->upload->display_errors();
                $this->session->set_flashdata('message', '<div style="opacity: .6" class="alert alert-danger" role="alert">
                            ' . $error . '
                        </div>');
                redirect('report/incident/upload');
            }
        }
    }

    public function edit($id)
    {
        $incident = $this->db->query("select * from gms_accident_report gar , sites s WHERE gar.idsite =s.site_id and gar.arid = $id;")->row_array();
        $data = [
            'title' => 'Edit Laporkan Kejadian',
            'incident' => $incident
        ];
        $this->form_validation->set_rules('subject', 'Subject', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');

        if ($this->form_validation->run() == false) {
            $this->template->load('templates/template', 'incidents/incident_edit', $data);
        } else {
            $data = [
                'title' => $this->input->post('subject', true),
                'status' => $this->input->post('status', true),
            ];
            $this->db->where('arid', $this->input->post('incident_id', true));

            $this->db->update('gms_accident_report', $data);
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('message', '<div style="opacity: .6" class="alert alert-success" role="alert">
                Selamat! Incident Report berhasil diupdate!
                </div>');
                redirect('report/incident');
            }
        }
    }

    public function report()
    {
        // $site_id = $this->fungsi->user_login()->id_site;
        // if ($site_id == 0) {
        //     $incidents = $this->db->query("select  * FROM gms_accident_report gar , sites s, employees e, admin_users au WHERE gar.idsite =s.site_id and gar.nikreporter = e.nik and gar.userid =au.id order by gar.arid desc;")->result_array();
        // } elseif ($site_id != null) {
        //     $incidents = $this->db->query("select  * FROM gms_accident_report gar , sites s,employees e, admin_users au  WHERE gar.idsite =s.site_id and gar.idsite = $site_id and gar.nikreporter = e.nik and gar.userid =au.id order by gar.arid desc;")->result_array();
        // }

        $site_id = $this->fungsi->user_login()->id_site;
        if ($site_id == 0) {
            $this->db->select('*,gms_accident_report.status as status');
            $this->db->from('gms_accident_report');
            $this->db->join('sites', 'sites.site_id = gms_accident_report.idsite', 'left');
            $this->db->join('employees', 'employees.nik = gms_accident_report.nikreporter', 'left');
            $this->db->join('admin_users', 'admin_users.id = gms_accident_report.userid', 'left');
        } elseif ($site_id != null) {
            $this->db->select('*,gms_accident_report.status as status');
            $this->db->from('gms_accident_report');
            $this->db->join('sites', 'sites.site_id = gms_accident_report.idsite', 'left');
            $this->db->join('employees', 'employees.nik = gms_accident_report.nikreporter', 'left');
            $this->db->join('admin_users', 'admin_users.id = gms_accident_report.userid', 'left');
            $this->db->where('gms_accident_report.idsite', $site_id);
        }
        $this->db->order_by('gms_accident_report.arid', 'desc');
        $incidents = $this->db->get()->result_array();

        $data = [
            'title' => 'Incident',
            'incidents' => $incidents
        ];
        $this->template->load('templates/template', 'incidents/incident_report', $data);
    }
}
