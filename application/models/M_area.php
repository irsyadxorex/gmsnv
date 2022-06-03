<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_area extends CI_Model
{
    public function getArea()
    {
        $query = $this->db->query("select * from areas where kode='31' or kode='31.01' or kode='31.71' or kode='31.72' or kode='31.73' or kode='31.74' or kode='31.75';")->result_array();
        return $query;
    }
}
