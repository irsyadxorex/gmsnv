<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_tag extends CI_Model
{
    public function getTag($id = null)
    {
        if ($id == null) {
            $id_site = $this->session->userdata('id_site');
            if ($id_site == 0) {
                $query = $this->db->query("select *,gqt.status as status_tag from gms_qrcode_tags gqt, sites s where gqt.id_site = s.id_site;");
            } else {
                $query = $this->db->query("select *,gqt.status as status_tag from gms_qrcode_tags gqt, sites s where gqt.id_site = s.id_site and gqt.id_site=$id_site;");
            }
        } else {
            $query = $this->db->query("select * from gms_qrcode_tags gqt, sites s where gqt.id_site = s.id_site and gqt.id_qrcode=$id;");
        }
        return $query;
    }
    public function addTag()
    {
        $data = [
            'id_site' => $this->session->userdata('id_site') != 0 ? $this->session->userdata('id_site') : $this->input->post('id_site', true),
            'label' => strtolower($this->input->post('label', true)),
            'tagid' => $this->input->post('qrcode', true),
            'latitude_longitude' => $this->input->post('latitude_longitude', true),
            'lokasi' => $this->input->post('location', true),
            'is_tag' => $this->input->post('is_tag', true),
            'status' => $this->input->post('status', true)
        ];
        $this->db->insert('gms_qrcode_tags', $data);
    }
}
