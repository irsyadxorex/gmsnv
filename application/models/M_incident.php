<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_incident extends CI_Model
{
    public function getIncident()
    {
        $id_site = $this->session->userdata('id_site');
        $this->db->select('*');
        $this->db->from('gms_incident_reports gir');
        $this->db->join('sites s', 's.id_site = gir.id_site');
        $this->db->join('users u', 'u.id = gir.id_user');
        if ($id_site != 0) {
            $this->db->where('gir.id_site', $id_site);
        }
        $this->db->order_by('gir.id_incident', 'desc');
        $query = $this->db->get();
        return $query;
    }
}
