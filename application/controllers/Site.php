<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Site extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        // $this->load->model('M_site');
        // check_role_danru();
    }

    public function index()
    {
        $data = [
            'title' => 'Site',
            'sites' => $this->M_site->getGmsStatusSite()->result_array(),
        ];
        $this->template->load('templates/template', 'sites/site_data', $data);
    }

    public function update($id)
    {
        $data = [
            'title' => 'Site',
            'site' => $this->M_site->getIdsSite($id)->row_array(),
        ];
        $this->form_validation->set_rules('gms_status', 'GMS Status', 'required');
        if ($this->form_validation->run() == false) {
            $this->template->load('templates/template', 'sites/site_edit', $data);
        } else {
            $data = [
                'gms_status' => $this->input->post('gms_status', true),
            ];
            $this->db->where('site_id', $this->input->post('site_id', true));
            $this->db->update('sites', $data);

            $this->session->set_flashdata('message', '<div style="opacity: .6" class="alert alert-success" role="alert">
            Selamat! Site berhasil diupdate!
            </div>');
            redirect('site');
        }
    }
}
