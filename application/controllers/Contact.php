<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Contact extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        // check_role();
        // check_role_danru();
        $this->load->model('M_service');
        $this->load->model('M_area');
        $this->load->model('M_contact');
    }

    public function index()
    {
        if ($this->session->userdata('id_site') == 0) {
            $contacts = $this->db->query("select * from gms_darurat gd LEFT JOIN sites s ON gd.id_site = s.id_site INNER JOIN services s2 ON gd.id_service =s2.id_service INNER JOIN areas a ON gd.id_area =a.id_area ;")->result_array();
        } else {
            $id_site = $this->session->userdata('id_site');
            $contacts = $this->db->query("select * from gms_darurat gd LEFT JOIN sites s ON gd.id_site = s.id_site INNER JOIN services s2 ON gd.id_service =s2.id_service INNER JOIN areas a ON gd.id_area =a.id_area ;")->result_array();
        }
        $data = [
            'title' => 'List Kontak',
            'contacts' => $contacts
        ];
        $this->template->load('templates/template', 'contacts/contact_data', $data);
    }

    public function add()
    {
        $data = [
            'title' => 'Tambah Kontak Darurat',
            'services' => $this->M_service->getService(),
            'areas' => $this->M_area->getArea(),
        ];
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('telephone', 'Telephone', 'required');
        $this->form_validation->set_rules('service', 'Service', 'required');
        $this->form_validation->set_rules('area', 'Area', 'required');
        if ($this->form_validation->run() == false) {
            $this->template->load('templates/template', 'contacts/contact_add', $data);
        } else {
            $this->M_contact->addContact();
            $this->session->set_flashdata('message', '<div style="opacity: .6" class="alert alert-success" role="alert">
            Selamat! User baru berhasil ditambahkan!
            </div>');
            redirect('contact');
        }
    }
}
