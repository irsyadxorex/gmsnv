<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tag extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        check_role();
        // check_role_danru();
    }

    public function index()
    {
        $tags = $this->db->query("select  *, gnt.nfcid as nfcid from gms_nfc_tags gnt ,sites s WHERE gnt.idsite =s.site_id ORDER by gnt.nfcid DESC ;")->result_array();
        $data = [
            'title' => 'Manage Visitor',
            'tags' => $tags
        ];
        $this->template->load('templates/template', 'tags/tag_data', $data);
    }


    public function edit($id)
    {
        $gnt = $this->db->query("select *, gnt.nfcid as nfcid from gms_nfc_tags gnt ,sites s WHERE gnt.idsite =s.site_id and gnt.nfcid = $id;")->row_array();
        $data = [
            'title' => 'Update Tag',
            'gnt' => $gnt
        ];
        $this->form_validation->set_rules('label', 'Label', 'required');
        if ($this->form_validation->run() ==  false) {
            $this->template->load('templates/template', 'tags/tag_edit', $data);
        } else {
            $data = [
                'label' => $this->input->post('label', true),
                'location' => $this->input->post('location', true),
                'is_active' => $this->input->post('status', true),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $this->db->where('nfcid', $this->input->post('nfcid'));
            $this->db->update('gms_nfc_tags', $data);
            $this->session->set_flashdata('message', '<div style="opacity: .6" class="alert alert-success" role="alert">
            Selamat! Tag  berhasil diupdate!
            </div>');
            redirect('tag');
        }
    }
}
