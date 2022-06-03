<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_service extends CI_Model
{
    public function getService()
    {
        $query = $this->db->query("select * from services ")->result_array();
        return $query;
    }
}
