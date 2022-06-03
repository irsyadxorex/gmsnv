<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_contact extends CI_Model
{
    public function getContact()
    {
        $query = $this->db->query("select * from gms_darurat ")->result_array();
        return $query;
    }

    public function addContact()
    {
        $data = [
            'nama' => $this->input->post('nama', true),
            'telephone' => $this->input->post('telephone', true),
            'id_service' => $this->input->post('service', true),
            'id_site' => $this->session->userdata('id_site') != 0 ? $this->session->userdata('id_site') : $this->input->post('id_site', true),
            'id_area' => $this->input->post('area', true),
            'maps' => $this->input->post('maps', true),
        ];
        $this->db->insert('gms_darurat', $data);
    }
}
