<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penghuni extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        // check_role();
        // check_role_danru();
    }

    public function index()
    {
        $penghuni = $this->db->query("select * from master_penghuni")->result_array();
        $data = [
            'title' => 'Daftar Penghuni',
            'penghuni' => $penghuni
        ];
        $this->template->load('templates/template', 'penghuni/penghuni_data', $data);
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
