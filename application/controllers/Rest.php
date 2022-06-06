<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Rest extends REST_Controller
{

  public function __construct() {
    parent::__construct();
    $this->load->model('M_gms');
  }
    public function personil_auth_post()
    {
        $username = $this->post('username');
        $password = $this->post('password');
        $cek = $this->m_get->get_personil_auth($username, $password);
        if(!empty($cek)) {
          if(password_verify($password, $cek->password)) {
            // $this->response([
            //         'status' => true,
            //         'data' => $cek
            //     ], REST_Controller::HTTP_OK);
            $this->response($cek, REST_Controller::HTTP_OK);
          }else{
            $this->response([
                'status' => false,
                'data' => 'password salah'
            ], REST_Controller::HTTP_NOT_FOUND);
          }
        }else{
          $this->response([
              'status' => false,
              'data' => 'Karyawan tidak ditemukan'
          ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
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

    public function listactivitiesidsite_get()
    {
        $today = date('Y-m-d');
        $data = $this->db->query("select ga.id_activity AS activityid,e.username AS name, ga.activity, ga.currentdatetime AS date_time, ga.images from gms_activities ga, users e where ga.id_user=e.id and date(ga.currentdatetime)='$today' order by ga.currentdatetime desc;")->result_array();
        if(!empty($data)) {
          $this->response([
              'status' => true,
              'data_activity' => $data
          ], REST_Controller::HTTP_OK);
      } else {
          $this->response([
              'status' => false,
              'message' => 'kosongs'
          ], REST_Controller::HTTP_NOT_FOUND);
      }
    }

    public function checkpointbyqr_post()
    {
        $idCheck = $this->input->post('idCheck');
        $tagId = $this->input->post('tagid_user');
        $isClear = $this->input->post('isclear');
        $note = $this->input->post('note');

        $update_data=array(
            'tagid_user'=>$tagId,
            'isclear'=>$isClear,
            'note'=>(strlen($note) > 0) ? $note : null,
            'status'=>1
        );
        $data = $this->M_gms->update_checkpoint_details($update_data,$idCheck);

        if ($data) {
            $this->response([
                'status' => true,
                'data' => 'sukses input data'
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Gagal input data'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function shiftgms_get()
    {
        $id_site = $this->get('idsite');
        $data = $this->M_gms->get_shifts($id_site);
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

    public function listmemberPenghuni_get($param = null)
    {
      if(!empty($_GET['param'])){
        $param =$_GET['param'];
        $data = $this->db->query("select master_penghuni.id_penghuni, master_penghuni.blok, master_penghuni.kategori from master_penghuni WHERE blok LIKE'%$param%' order by id_penghuni ASC;")->result_array();
        if(!empty($data)) {
            $this->response([
                'success' => true,
                'data_penghuni' => $data
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'success' => false,
                'data_penghuni' => $data
            ], REST_Controller::HTTP_NOT_FOUND);
        }
      }else{
        $data = $this->db->query("select master_penghuni.id_penghuni, master_penghuni.blok, master_penghuni.kategori from master_penghuni order by id_penghuni ASC;")->result_array();
        if(!empty($data)) {
            $this->response([
                'success' => true,
                'data_penghuni' => $data
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'success' => false,
                'data_penghuni' => $data
            ], REST_Controller::HTTP_NOT_FOUND);
        }
      }
    }

    public function listcheckpoint_get()
    {
        $idCheckpoint = $this->get('idCheckpoint');
        $data = $this->db->query("select gnt.* from gms_checkpoint_details gnt where gnt.id_checkpoint='$idCheckpoint' order by id_check asc;")->result_array();
        if ($data) {
            $this->response([
                'success' => true,
                'data_checkpoint' => $data
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'success' => false,
                'message' => 'list tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function listcheckpointall_get()
    {
        // $idCheckpoint = $this->get('idCheckpoint');
        $data = $this->db->query("select gnt.* from gms_checkpoint_details gnt where gnt.status=1 order by id_check asc;")->result_array();
        if ($data) {
            $this->response([
                'success' => true,
                'data_checkpoint' => $data
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'success' => false,
                'message' => 'list tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function listKeperluan_get($param=null)
    {
      if(!empty($_GET['param'])){
        $param =$_GET['param'];
        $data = $this->db->query("select keperluan.id_perlu, keperluan.perlu from keperluan where perlu LIKE'%$param%' order by id_perlu ASC;")->result_array();

        if ($data) {
            $this->response([
                'success' => true,
                'data_keperluan' => $data
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'success' => false,
                'message' => 'list tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
      }else{
        $data = $this->db->query("select keperluan.id_perlu, keperluan.perlu from keperluan order by id_perlu ASC;")->result_array();

        if(!empty($data)) {
            $this->response([
                'success' => true,
                'data_keperluan' => $data
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'success' => false,
                'message' => 'list tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
      }
    }

    public function newCheckpoint_post() {
      $idUser = $this->post('idUser');
      $idSite = $this->post('idSite');
      $today = date('Y-m-d');
      $data = $this->db->query("select * from gms_checkpoints where id_user='$idUser' and id_site='$idSite' and date(tanggal)='$today'")->result_array();
      // print_r($data[0]['id']);
      // die();
      if(!empty($data)) {
        $this->response([
            'success' => true,
            'data' => $data[0]['id'],
        ], REST_Controller::HTTP_OK);
      }else{
        $checkpoint=array(
          'id_site'=>$idSite,
          'id_user'=>$idUser,
          'tanggal'=>date('Y-m-d'),
          'status'=>0,
          'createdAt'=>date('Y-m-d H:i:s'),
        );
        $creates = $this->M_gms->create($checkpoint);

        $tags = $this->M_gms->read_qrcodetag($idSite);
        foreach ($tags as $key => $tag) {

          $data=array(
            'id_checkpoint'=>$creates,
            'currentdatetime'=>date('Y-m-d H:i:s'),
            'id_user'=>$idUser,
            'id_site'=>$tag->id_site,
            'label'=>$tag->label,
            'lokasi'=>$tag->lokasi,
            'tagid'=>$tag->tagid,
            'tanggal'=>date('Y-m-d'),
            'latitude_longitude_tag'=>$tag->latitude_longitude,
            'created_at'=>date('Y-m-d H:i:s'),
            'status'=>0,
          );
          $this->M_gms->create_checkpoint_details($data);

        }
        $this->response([
            'success' => true,
            'data' => "$creates",
        ], REST_Controller::HTTP_OK);

      }
    }

    public function checkEmptyCheckPoint_get()
    {
      $idTag = $this->get('idTag');
      $today = date('Y-m-d');
      $data = $this->db->query("select * from gms_checkpoints where tagid='$idTag' and date(tanggal)='$today'")->result_array();
      if(!empty($data)) {
        if ($data) {
            $this->response([
                'success' => true,
                'data' => 1
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'success' => false,
                'data' => 0
            ], REST_Controller::HTTP_OK);
        }
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
