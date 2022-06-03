<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Rest extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_tag');
    }
    // GMS
    public function get_tag()
    {
        $tags = $this->db->get('gms_qrcode_tags')->result_array();
        if ($tags) {
            $this->response([
                'status' => true,
                'message' => $tags
            ], REST_Controller::HTTP_OK);
        }
    }
    // END GMS

    public function connect_whatsappdevice_get()
    {
        $deviceid = '11c74d86a737667a123b81efa1760530';
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://app.whacenter.com/api/relogDevice");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "device_id=$deviceid");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $output = curl_exec($ch);
        echo $output;
        curl_close($ch);
    }
    public function check_whatsappdevice_get()
    {
        $deviceid = '11c74d86a737667a123b81efa1760530';
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://app.whacenter.com/api/statusDevice?device_id=$deviceid");

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $output = curl_exec($ch);
        echo $output;
        curl_close($ch);
    }
    public function employee_auth_post()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $token = $this->input->post('token');
        $data = $this->m_get->get_employee_auth($email, $password, $token);
        // var_dump($data);
        if ($data) {
            $this->response($data, REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Karyawan tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
    public function admin_auth_post()
    {
        $email = $this->post('email');
        $password = $this->post('password');
        $query = "select au.*,s.site_id,s.site from admin_users au,sites s where s.site_id = au.id_site and email = '$email';";
        $db = $this->db->query($query)->row_array();

        if (password_verify($password, $db['password'])) {
            $this->response($db, REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'User tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
    public function employees_auth_post()
    {
        $email = $this->post('email');
        $password = $this->post('password');
        $data = $this->m_get->get_employees_auth($email, $password);
        if ($data) {
            $this->response($data, REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Karyawan tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    //ABSEN WFH
    public function employees_authab_post()
    {
        $email = $this->post('email');
        $password = $this->post('password');
        $data = $this->m_get->get_employees_authab($email, $password);
        if ($data) {
            $this->response($data, REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Karyawan tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function employee_users_get()
    {
        $email = $this->get('email');
        if ($email) {
            $data = $this->m_get->get_employee_users('email', $email);
        } else {
            $data = $this->m_get->get_employee_users();
        }
        if ($data) {
            $this->response([
                'status' => true,
                'data' => $data
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Karyawan tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
    public function employees_get()
    {
        $nik = $this->get('nik');
        if ($nik) {
            $data = $this->m_get->get_employee($nik);
        } else {
            $data = $this->m_get->get_employee();
        }
        if ($data) {
            $this->response($data, REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Karyawan tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
    public function slip_gajis_get()
    {
        $nik = $this->get('nik');
        if ($nik) {
            $data = $this->m_get->get_slip_gajis($nik);
        } else {
            $data = $this->m_get->get_slip_gajis();
        }
        if ($data) {
            $this->response($data, REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Karyawan tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }



    public function update_contact_post()
    {
        $nik = $this->post('nik');
        $email = $this->post('email');
        $phone = $this->post('phone');
        $this->db->where('nik', $nik);
        $update_employee_users = $this->db->update('employee_users', ['email' => $email]);
        $this->db->where('nik', $nik);
        $update_employees = $this->db->update('employees', ['phone' => $phone]);

        if ($update_employee_users && $update_employees) {
            $this->response([
                'status' => true,
                'message' => 'Update berhasil'
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Update gagal'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
    public function infos_get()
    {
        $nik = $this->get('nik');
        if ($nik) {
            $data = $this->m_get->get_info($nik);
        } else {
            $data = $this->m_get->get_info();
        }
        if ($data) {
            $this->response($data, REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'No Records'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    /////////////////////////// gms mobile need //////////////////////////////////
    public function shiftgms_get()
    {
        $id_site = $this->get('idsite');
        $data = $this->m_gms->get_shifts($id_site);
        if ($data) {
            $this->response($data, REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Karyawan tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
    public function listshift_get()
    {
        $pattern = $this->get('pattern');
        $data = $this->db->get_where('gms_shift', ['pattern' => $pattern])->result_array();
        if ($data) {
            $this->response($data, REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Karyawan tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
    public function siteemployees_get()
    {
        $idsite = $this->get('idsite');
        // $this->db->select('nik,name,id_position');
        // $this->db->where('id_site', $idsite);
        // $this->db->where_in('id_position', [1, 2, 3]);
        $data = $this->db->query("select nik,name,id_position from employees e where id_site = $idsite and id_position in (1,2,3) and nik not in (select nik from gms_attendance_details gad);")->result_array();
        if ($data) {
            $this->response($data, REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Karyawan tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    /////////////////// CHART REQUIREMENT
    public function activeemployeecount_get()
    {
        $data = $this->db->query("select s.site, count(*) as total from employees e, sites s where e.id_site = s.site_id and status in (2,7) group by s.site order by total desc limit 6;")->result_array();
        if ($data) {
            $this->response([
                'status' => true,
                'result' => $data
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
    public function pkwtcount_get()
    {
        $data = $this->db->query("select year(insert_datetime) as tahun, count(*) as total from employees where year(insert_datetime) BETWEEN 2020 and 2022 group by tahun order by tahun asc;")->result_array();
        if ($data) {
            $this->response([
                'status' => true,
                'result' => $data
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
    public function domisilijakarta_get()
    {
        $data = $this->db->query("select iddomisili,count(*) as jumlah from employees where status in (2,7) and iddomisili is not null group by iddomisili order by iddomisili asc;")->result_array();
        if ($data) {
            $this->response([
                'status' => true,
                'result' => $data
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
}
