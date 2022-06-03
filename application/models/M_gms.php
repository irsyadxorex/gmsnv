<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_gms extends CI_Model
{
    public function get_codeshift($nik, $date, $month, $year)
    {
        return $this->db->query("select code_shift from gms_attendances ga where day(date_time) = $date and month(date_time)= $month and year(date_time)= $year and nik = $nik and is_in = 1 ORDER by date_time asc limit 1")->row('code_shift');
    }
}
