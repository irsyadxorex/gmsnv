<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_count extends CI_Model
{
    ////////////////// gen ///////////////////////////////////////////
    public function count_row($table, $where_array = false)
    {
        if ($where_array) {
            return $this->db->get_where($table, $where_array)->num_rows();
        } else {
            return $this->db->get($table)->num_rows();
        }
    }
    /////////////// EMPLOYEES ///////////////////////////////////////////
    public function count_employees()
    {
        return $this->db->get_where('op_applicants', ['status' => 0])->num_rows();
    }
    public function count_confirm()
    {
        return $this->db->get_where('employees', ['status' => 0])->num_rows();
    }
    public function count_applicant()
    {
        return $this->db->get_where('op_applicants', ['status' => 0])->num_rows();
    }

    ////////////////////////// KEBUTUHAN SUMMARY REPORT ///////////////////
    public function count_active_bysite($id_site)
    {
        return $this->db->query("select count(*) as count from employees where date(insert_datetime) <= date('2020-11-30') and status=2 and id_site=" . $id_site)->row('count');
    }
    public function count_resign_bysite($id_site)
    {
        return $this->db->query("select count(*) as count from employees where date(insert_datetime) <= date('2020-11-30') and status=5 and id_site=" . $id_site)->row('count');
    }
    public function count_nopkwt_bysite($id_site)
    {
        return $this->db->query("select count(*) as count from employees where date(insert_datetime) <= date('2020-11-30') and status=1 and id_site=" . $id_site)->row('count');
    }
    public function count_pkwtonline_bysite($id_site)
    {
        return $this->db->query("select count(*) as count from employees where date(insert_datetime) <= date('2020-11-30') and old_pkwt!=1 and id_site=" . $id_site)->row('count');
    }
    public function count_pkwtoffline_bysite($id_site)
    {
        return $this->db->query("select count(*) as count from employees where date(insert_datetime) <= date('2020-11-30') and old_pkwt=1 and id_site=" . $id_site)->row('count');
    }
    public function count_slipgajiacceptor_bysite($id_site)
    {
        return $this->db->query("select count(*) from slip_gajis where nik in (select nik from employees where id_site='" . $id_site . "' and date(insert_datetime)<='2020-11-30') group by nik")->num_rows();
    }
    public function count_slipgajiacceptor()
    {
        return $this->db->query("select count(*) from slip_gajis where nik in (select nik from employees where date(insert_datetime)<='2020-11-30') group by nik")->num_rows();
    }
    public function count_allemployees()
    {
        return $this->db->query("select count(*) as count from employees where date(insert_datetime) <= date('2020-11-30')")->row('count');
    }
    public function count_active()
    {
        return $this->db->query("select count(*) as count from employees where date(insert_datetime) <= date('2020-11-30') and status=2")->row('count');
    }
    public function count_resign()
    {
        return $this->db->query("select count(*) as count from employees where date(insert_datetime) <= date('2020-11-30') and status=5")->row('count');
    }
    public function count_pkwtonline()
    {
        return $this->db->query("select count(*) as count from employees where date(insert_datetime) <= date('2020-11-30') and old_pkwt!=1")->row('count');
    }
    public function count_pkwtoffline()
    {
        return $this->db->query("select count(*) as count from employees where date(insert_datetime) <= date('2020-11-30') and old_pkwt=1")->row('count');
    }
}
