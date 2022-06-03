<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_site extends CI_Model
{
    public function getSite()
    {
        $id_site = $this->session->userdata('id_site');
        if ($id_site == 0) {
            $query = $this->db->query("select * from sites s ")->result_array();
        } elseif ($id_site != null) {
            $query = $this->db->query("select * from sites s where s.id_site = $id_site;")->result_array();
        }
        return $query;
    }
    public function getIdsSite($id)
    {
        $query = $this->db->query("select * from sites s where id_site = $id;");
        return $query;
    }
    public function getGmsStatusSite()
    {
        $query = $this->db->query("select * from sites s where id_service =1 order by gms_status desc;");
        return $query;
    }
}
