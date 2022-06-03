<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_get extends CI_Model
{
    public function get_areas()
    {
        return  $this->db->get('areas')->result_array();
    }
    public function get_area_byid($id)
    {
        return $this->db->query('SELECT * FROM `areas` WHERE `area_id` =' . $id)->row('area');
    }
    public function get_idarea($nik)
    {
        return $this->db->get_where('employees', ['nik' => $nik])->row('id_area');
    }
    ////////////////////// POSITION /////////////////////////////////////
    public function get_positions($available = false)
    {
        $this->db->order_by('id_service', 'ASC');
        if ($available) {
            $this->db->where('available', $available);
        }
        return $this->db->get('positions')->result_array();
    }
    public function get_position_byid($id)
    {
        return $this->db->query('SELECT * FROM `positions` WHERE `position_id` =' . $id)->row('position');
    }

    //////////////////////////// SITES ////////////////////////////
    public function get_sites()
    {
        $this->db->order_by('id_service', 'ASC');
        return  $this->db->get('sites')->result_array();
    }
    public function get_site_byid($id)
    {
        return $this->db->query('SELECT * FROM `sites` WHERE `site_id` =' . $id)->row('site');
    }
    public function get_idsite($nik)
    {
        return $this->db->get_where('employees', ['nik' => $nik])->row('id_site');
    }

    //////////////////////////// SERVICE ////////////////////////////
    public function get_services()
    {
        return  $this->db->get('services')->result_array();
    }
    public function get_idservice($nik)
    {
        $employee_idsite = $this->db->get_where('employees', ['nik' => $nik])->row('id_site');
        return $this->db->get_where('sites', ['site_id' => $employee_idsite])->row('id_service');
    }
    ////////////////////////// TOKEN DEVICE /////////////////////////
    public function get_token($nik)
    {
        $this->db->select('token');
        $tokens = $this->db->get_where('device_token', ['nik' => $nik])->result_array();
        $token_array = array();
        foreach ($tokens as $t) {
            array_push($token_array, $t['token']);
        }
        return $token_array;
    }

    /////////////////////// EMPLOYEE //////////////////////////////////
    public function get_employeebynik($nik)
    {
        return $this->db->query("select * from employee_users eu ,employees e ,sites s ,positions p ,areas a WHERE eu.nik = e.nik and e.id_site = s.site_id and e.id_position = p.position_id and e.id_area = a.area_id and e.nik = '" . $nik . "'")->row_array();
    }
    public function get_employee_all($nik = false)
    {
        $this->db->join('positions', 'positions.position_id = employees.id_position');
        $this->db->join('employee_users', 'employee_users.nik = employees.nik');
        $this->db->join('sites', 'sites.site_id = employees.id_site');
        $this->db->join('areas', 'areas.area_id = employees.id_area');
        if ($nik) {
            $this->db->where('employees.nik', $nik);
            return $this->db->get('employees')->row_array();
        } else {
            $this->db->order_by('insert_datetime', 'DESC');
            return $this->db->get('employees')->result_array();
        }
    }
    public function get_employee($nik = false)
    {
        $this->db->join('positions', 'positions.position_id = employees.id_position');
        $this->db->join('employee_users', 'employee_users.nik = employees.nik');
        $this->db->join('sites', 'sites.site_id = employees.id_site');
        $this->db->join('areas', 'areas.area_id = employees.id_area');
        $this->db->where_not_in('status', 5);
        if ($nik) {
            $this->db->where('employees.nik', $nik);
            return $this->db->get('employees')->row_array();
        } else {
            if ($_SESSION['id_area'] != 0) {
                $this->db->where('employees.id_area', $_SESSION['id_area']);
                if ($_SESSION['id_user'] == 9) {
                    $this->db->or_where_in('employees.id_site', [12, 50, 40, 72, 68, 75]);
                }
            }
            $this->db->order_by('insert_datetime', 'DESC');
            return $this->db->get('employees')->result_array();
        }
    }

    public function get_employee_byservice($id_service)
    {
        $this->db->select('*');
        $this->db->from('employees');
        $this->db->join('positions', 'positions.position_id = employees.id_position');
        $this->db->join('sites', 'sites.site_id = employees.id_site');
        $this->db->join('areas', 'areas.area_id = employees.id_area');
        $this->db->where_not_in('status', 5);
        $this->db->where('sites.id_service', $id_service);
        if ($_SESSION['id_area'] != 0) {
            $this->db->where('employees.id_area', $_SESSION['id_area']);
        }
        $this->db->order_by('insert_datetime', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_email($nik)
    {
        return $this->db->get_where('employee_users', ['nik' => $nik])->row('email');
    }
    public function get_phone($nik)
    {
        return $this->db->get_where('employees', ['nik' => $nik])->row('phone');
    }
    public function get_column($table, $nik, $column)
    {
        $this->db->select($column);
        $this->db->where('nik', $nik);
        return $this->db->get($table)->row_array();
    }
    public function get_applicantbynik($nik)
    {
        return $this->db->get_where('op_applicants', ['nik' => $nik])->row_array();
    }
    public function get_imagebyname($name)
    {
        return $this->db->query("select photo from op_applicants where name like '%" . $name . "%';")->row('photo');
    }
    public function get_status_new($nik)
    {
        return $this->db->get_where('employee_users', ['nik' => $nik])->row('new');
    }
    public function get_status($nik)
    {
        return $this->db->get_where('employees', ['nik' => $nik])->row('status');
    }
    public function get_mailingdetail($nik)
    {
        return $this->db->query("select name,status,id_site,email,phone from employees e, employee_users eu where e.nik=eu.nik and e.nik = $nik")->row_array();
    }
    public function get_idposition($nik)
    {
        return $this->db->get_where('employee_users', ['nik' => $nik])->row('id_position');
    }
    public function get_status_old_pkwt($nik)
    {
        return $this->db->get_where('employees', ['nik' => $nik])->row('old_pkwt');
    }
    public function get_name($nik)
    {
        return $this->db->get_where('employees', ['nik' => $nik])->row('name');
    }

    public function count_confirm()
    {
        return $this->db->get_where('employees', ['status' => 0])->num_rows();
    }
    public function count_applicant()
    {
        return $this->db->get_where('op_applicants', ['status' => 1])->num_rows();
    }

    public function get_detail_employee()
    {
        return $this->db->query('SELECT * from employees e, employee_users eu, relations r, positions p, sites s where e.nik = eu.nik and e.nik = r.nik_employee and e.id_position = p.position_id and e.id_site = s.site_id;')->result_array();
    }

    public function get_uploaded($filename)
    {

        $config['upload_path'] = './assets/excel/';
        $config['allowed_types'] = 'xlsx';
        $config['max_size']    = '6048';
        $config['overwrite'] = true;
        $config['file_name'] = $filename;

        $this->load->library('upload', $config, 'upload');
        //$this->upload->initialize($config);
        if ($this->upload->do_upload('file')) {
            $return = array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');
            return $return;
        } else {
            $return = array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());
            return $return;
        }
    }

    //////////////////////////// SLIP GAJI /////////////////////////////

    public function cekslip($nik, $period)
    {
        $this->db->select('notified');
        $cek = $this->db->get_where("slip_gajis", ["nik" => $nik, "periode" => $period])->row_array();
        if ($cek) {
            return true;
        } else {
            return false;
        }
    }
    public function get_slip_gajis($nik = false)
    {
        if ($nik) {
            $this->db->order_by('insert_date', 'DESC');
            $data = $this->db->get_where('slip_gajis', ['nik' => $nik])->result_array();

            // $this->db->select('sum(upah) as jumlah');
            // $this->db->from('slip_gajis');
            // $this->db->where('nik', $nik);
            // $this->db->group_by('nik');
            // $data_add = $this->db->get()->row_array();
            // array_push($data, $data_add);

            return $data;
        } else {
            $this->db->limit(10);
            $this->db->order_by('insert_date', 'DESC');
            return $this->db->get('slip_gajis')->result_array();
        }
    }

    ///////////////////////////////// EMPLOYEE_USERS ////////////////////////////
    public function get_employee_users($column = false, $value = false)
    {
        if ($column && $value) {
            return $this->db->get_where('employee_users', [$column => $value])->result_array();
        } else {
            return $this->db->get('employee_users')->result_array();
        }
    }
    public function get_employee_auth($email, $password, $token)
    {
        $this->db->select('employee_users.nik, name, id_site, site,id_position, email, password, status');
        $this->db->from('employee_users');
        $this->db->join('employees', 'employees.nik = employee_users.nik');
        $this->db->join('sites', 'employees.id_site = sites.site_id');
        $this->db->where('email', $email);
        $user = $this->db->get()->row_array();
        //$this->db->insert('device_token', ['nik' => $user['nik'], 'token' => $token]);
        $this->db->query('INSERT IGNORE INTO device_token (nik,token) VALUES ("' . $user['nik'] . '","' . $token . '");');
        if (password_verify($password, $user['password'])) {
            return $user;
        } else {
            return false;
        }
    }
    public function get_employees_auth($email, $password)
    {
        // $this->db->select('employee_users.nik, name, email, password, status');
        // $this->db->from('employee_users');
        // $this->db->join('employees', 'employees.nik = employee_users.nik');
        // $this->db->where('email', $email);
        $query = "select * from employee_users eu ,employees e ,sites s ,positions p where eu.nik=e.nik and e.id_site = s.site_id and e.id_position = p.position_id and eu.email = '$email'";
        $user = $this->db->query($query)->row_array();
        //$user = $this->db->get()->row_array();
        if (password_verify($password, $user['password'])) {
            return $user;
        } else {
            return false;
        }
    }
    public function get_employees_authab($email, $password)
    {
        // $this->db->select('employee_users.nik, name, email, password, status');
        // $this->db->from('employee_users');
        // $this->db->join('employees', 'employees.nik = employee_users.nik');
        // $this->db->where('email', $email);
        $query = "select * from employees_users where email = '$email'";
        $user = $this->db->query($query)->row_array();
        //$user = $this->db->get()->row_array();
        if ($password == $user['password']) {
            return $user;
        } else {
            return false;
        }
    }
    //////////////////////// LOGS /////////////////////////////////////////////////
    public function get_logs()
    {
        $this->db->from('log_activities');
        $this->db->join('admin_users', 'admin_users.id=log_activities.id_user');
        $this->db->limit(10);
        $this->db->order_by('date_time', 'DESC');
        return $this->db->get()->result_array();
    }

    /////////// INFOS ///////////
    public function get_info($nik = false)
    {
        if ($nik) {
            $this->db->where('nik', null);
            $this->db->or_where('nik', $nik);
        } else {
            $this->db->where('nik', null);
        }
        $this->db->order_by('date_time', 'DESC');
        return $this->db->get('infos')->result_array();
    }

    //////////////////////// APPLICANTS /////////////////////////////
    public function get_applicants($id_area)
    {
        if ($id_area > 1) {
            return $this->db->query("select * from op_applicants o,positions p,areas a where o.id_position = p.position_id and o.id_area = a.area_id and o.id_area = $id_area and o.nik not in (select nik from employees) order by o.insert_date DESC")->result_array();
        } else {
            return $this->db->query('select * from op_applicants o,positions p,areas a where o.id_position = p.position_id and o.id_area = a.area_id and o.nik not in (select nik from employees) order by o.insert_date DESC')->result_array();
        }
    }

    public function get_idsitebyname($name)
    {
        return $this->db->query("select site_id from sites where site like '%" . $name . "%';")->row('site_id');
    }
    public function get_idpositionbyname($name)
    {
        return $this->db->query("select position_id from positions where position like '%" . $name . "%';")->row('position_id');
    }

    public function get_nopkwt($id_service, $id_site)
    {
        if ($id_service > 2 && $id_service != 4) {
            $no_pkwt = $this->db->get_where('sites', ['site_id' => $id_site])->row('number_pkwt');
            $newnumber = $no_pkwt + 1;
            $this->db->where('site_id', $id_site);
            $this->db->update('sites', ['number_pkwt' => $newnumber]);
        } else {
            $no_pkwt = $this->db->get_where('services', ['service_id' => $id_service])->row('number_pkwt');
            $newnumber = $no_pkwt + 1;
            $this->db->where('service_id', $id_service);
            $this->db->update('services', ['number_pkwt' => $newnumber]);
        }
        return $no_pkwt;
    }
}
