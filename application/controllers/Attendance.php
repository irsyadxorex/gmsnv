<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Attendance extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    // is_logged_in();
    // check_role_danru();
    $this->load->model('M_attendance');
  }

  public function listcheckpointidsite($idUser = null)
  {
    $idUser = $_GET['idUser'];
    $today = date('Y-m-d');
    $data = $this->db->query("SELECT * FROM gmsnv_db.gms_checkpoints where id_user=$idUser AND date(tanggal)='$today'")->result_array();
    // $data = $this->db->query("select gnc.che_id,gnc.currentdatetime,gnc.isclear,gnc.desc,gnt.location,e.name from gms_qrcode_checkpoints gnc, gms_qrcode_tags gnt,employees e where gnc.tagid = gnt.tagid and e.nik=gnc.nik and gnc.nik = $idsite and date(currentdatetime)='$today' order by currentdatetime desc;")->result_array();
    echo json_encode($data, true);
  }

  public function listcheckpoint($idsite = null)
  {
    $idsite = $_GET['idsite'];
    $data = $this->db->query("select gnt.* from gms_qrcode_tags gnt where gnt.id_site='$idsite' order by id_qrcode asc;")->result_array();
    echo json_encode($data, true);
  }

  public function addactivities()
  {
    $config['upload_path']          = './assets/imagesofgms/activities/';
    $config['allowed_types']        = 'gif|jpg|png';
    $config['file_name']            = date('YmdHi');
    $config['overwrite'] = TRUE;
    $config['max_size']     = '9999';
    $this->load->library('upload', $config);
    $this->upload->initialize($config);
    $upload = $this->upload->do_upload('image');

    if (!$upload) {
      echo $this->upload->display_errors();
    } else {
      $data = [
        'id_user' => $this->input->post('id_user'),
        'activity' => $this->input->post('activity'),
        'images' => $this->upload->data('file_name')
      ];
      $insert = $this->db->insert('gms_activities', $data);
      if ($insert) {
        echo 'success';
      } else {
        echo 'failed db';
      }
    }
  }

  public function uploadaccident()
  {
    $config['upload_path']          = './assets/imagesofgms/accidences/';
    $config['allowed_types']        = 'gif|jpg|png';
    $config['file_name']            = date('YmdHi');
    $config['overwrite'] = TRUE;
    $config['max_size']     = '9999';
    $this->load->library('upload', $config);
    $this->upload->initialize($config);
    $upload = $this->upload->do_upload('image');

    if (!$upload) {
      echo $this->upload->display_errors();
    } else {
      $data = [
        'id_site' => $this->input->post('idsite'),
        'waktu' => $this->input->post('waktu'),
        'tanggal' => $this->input->post('tanggal'),
        'subjek' => $this->input->post('subjek'),
        // 'namapihak' => $this->input->post('namapihak'),
        'pihak_terkait' => $this->input->post('pihakterkait'),
        'kronologi' => $this->input->post('kronologi'),
        'tindakan' => $this->input->post('tindakan'),
        'kesimpulan' => $this->input->post('kesimpulan'),
        'status' => 1,
        'id_user' => $this->input->post('id_user'),
        'dokumentasi' => $this->upload->data('file_name'),
      ];
      $insert = $this->db->insert('gms_incident_reports', $data);
      if ($insert) {
        echo 'success';
      } else {
        echo 'failed db';
      }
    }
  }

  public function uploadvisitor()
  {
    $config['upload_path']          = './assets/imagesofgms/visitor/';
    $config['allowed_types']        = 'gif|jpg|png';
    $config['file_name']            = date('YmdHi');
    $config['overwrite'] = TRUE;
    $config['max_size']     = '9999';
    $this->load->library('upload', $config);
    $this->upload->initialize($config);
    $upload = $this->upload->do_upload('image');

    if (!$upload) {
      echo $this->upload->display_errors();
    } else {
      $result = $this->M_count->no_visitor_generate();
      if (count($result) > 0) {
        $results = (int)$result;
        $results++;
      }

      if ($this->input->post('keterangan_perlu') != '') {
        $data = [
          'no_visitor' => $results,
          'tamu' => $this->input->post('tamu'),
          'tanggal' => $this->input->post('tanggal'),
          'jam' => $this->input->post('jam'),
          'id_penghuni' => $this->input->post('id_penghuni'),
          'id_perlu' => $this->input->post('id_perlu'),
          'keterangan_perlu' => $this->input->post('keterangan_perlu'),
          'id_user' => $this->input->post('id_user'),
          'id_site' => $this->input->post('id_site'),
          'images' => $this->upload->data('file_name'),
          'status' => 1,
        ];
        $insert = $this->db->insert('gms_tamu', $data);
        if ($insert) {
          echo 'success';
        } else {
          echo 'failed db';
        }
      } else {
        $data = [
          'no_visitor' => $results,
          'tamu' => $this->input->post('tamu'),
          'tanggal' => $this->input->post('tanggal'),
          'jam' => $this->input->post('jam'),
          'id_penghuni' => $this->input->post('id_penghuni'),
          'id_perlu' => $this->input->post('id_perlu'),
          'id_user' => $this->input->post('id_user'),
          'id_site' => $this->input->post('id_site'),
          'images' => $this->upload->data('file_name'),
          'status' => 1,
        ];
        $insert = $this->db->insert('gms_tamu', $data);
        if ($insert) {
          echo 'success';
        } else {
          echo 'failed db';
        }
      }
    }
  }

  public function updatevisitor()
  {
    $data = [
      'status' => $this->input->post('status'),
    ];
    $insert = $this->db->update('gms_tamu', $data, ['id_tamu' => $this->input->post('idTamu')]);
    // $insert = $this->db->insert('gms_tamu', $data);
    if ($insert) {
      echo 'success';
    } else {
      echo 'failed db';
    }
  }

  public function listactivitiesidsite($iduser)
  {
    $today = date('Y-m-d');
    $data = $this->db->query("select ga.id_activity AS activityid,e.username AS name, ga.activity, ga.currentdatetime AS date_time, ga.images from gms_activities ga, users e where ga.id_user=e.id and date(ga.currentdatetime)='$today' and ga.id_user='$iduser' order by ga.currentdatetime desc;")->result_array();
    echo json_encode($data, true);
  }

  public function listactivitiesvisitor($idsite)
  {
    $today = date('Y-m-d');
    // print_r($idsite);
    $data = $this->db->query("select ga.*,e.nama, s.blok, s.penghuni from gms_tamu ga, users e, users_detail es, master_penghuni s where e.username=es.username and ga.id_user=e.id and s.id_penghuni = ga.id_penghuni and date(ga.tanggal)='$today' and s.id_site=$idsite order by ga.tanggal desc;")->result_array();
    echo json_encode($data, true);
  }

  public function listmember($idsite)
  {
    $this->db->select('nik,name');
    $this->db->order_by('id_position', 'DESC');
    $data = $this->db->get_where('employees', ['id_site' => $idsite])->result_array();
    echo json_encode($data, true);
  }

  public function listmemberPenghuni($param = null)
  {
    if (!empty($_GET['param'])) {
      $param = $_GET['param'];
      $data = $this->db->query("select master_penghuni.id_penghuni, master_penghuni.blok, master_penghuni.kategori from master_penghuni WHERE blok LIKE'%$param%' order by id_penghuni ASC;")->result_array();
      echo json_encode($data, true);
    } else {
      $data = $this->db->query("select master_penghuni.id_penghuni, master_penghuni.blok, master_penghuni.kategori from master_penghuni order by id_penghuni ASC;")->result_array();
      echo json_encode($data, true);
    }
  }

  public function listKeperluan($param = null)
  {
    if (!empty($_GET['param'])) {
      $param = $_GET['param'];
      $data = $this->db->query("select keperluan.id_perlu, keperluan.perlu from keperluan where perlu LIKE'%$param%' order by id_perlu ASC;")->result_array();
      echo json_encode($data, true);
    } else {
      $data = $this->db->query("select keperluan.id_perlu, keperluan.perlu from keperluan order by id_perlu ASC;")->result_array();
      echo json_encode($data, true);
    }
  }

  public function listabsenstatus()
  {
    $data = $this->db->get('gms_attendance_status')->result_array();
    echo json_encode($data, true);
  }

  public function absenbydanru()
  {
    $post = [
      'datetime_in' => date('Y-m-d H:i:s'),
      'id_user' => $this->input->post('id_user'),
      'tagid' => $this->input->post('tagid'),
      'is_in' => '1',
      'id_shift' => $this->input->post('id_shift'),
      'hours' => $this->input->post('hours'),
      'thetime' => $this->input->post('thetime'),
      'latitude_longitude_in' => $this->input->post('latitude_longitude_in'),
      'created_at' => date('Y-m-d H:i:s'),
    ];

    $this->db->insert('gms_attendances', $post);
  }

  public function absenbydanru_out()
  {
    $post = [
      'datetime_out' => date('Y-m-d H:i:s'),
      'is_in' => '0',
      'tagid_out' => $this->input->post('tagid_out'),
      'thetime_out' => $this->input->post('thetime_out'),
      'latitude_longitude_out' => $this->input->post('latitude_longitude_in'),
      'updated_at' => date('Y-m-d H:i:s'),
      // 'id_user'=> $this->input->post('id_user'),
      // 'tagid' => $this->input->post('tagid'),
      // 'id_shift'=> $this->input->post('id_shift'),
      // 'hours' => $this->input->post('hours'),
    ];

    // $this->db->insert('gms_new_attendances', $post);
    $this->db->update('gms_attendances', $post, ['id_att' => $this->input->post('attrid')]);
  }

  public function checkpointbyqr()
  {
    $tagId = $this->input->post('tagid');
    $nik = $this->input->post('nik');
    $desc = $this->input->post('desc');
    $data = [
      'tagid' => $tagId,
      'nik' => $nik,
      'isclear' => $this->input->post('iskondusif'),
      'desc' => (strlen($desc) > 0) ? $desc : null
    ];
    $datas = $this->db->insert('gms_qrcode_checkpoints', $data);
    echo json_encode($datas, 200);
  }



  public function countTamu()
  {
    $idsite = $_GET['idsite'];
    $today = date('Y-m-d');
    $data = $this->db->query("SELECT count(*) AS total FROM gms_tamu where gms_tamu.idsite=$idsite AND date(thedate)='$today';")->result_array();
    echo json_encode($data, true);
  }

  public function addvisitorcount()
  {
    $counts = $this->input->post('counts');
    $idsite = $this->input->post('idsite');
    $date = date('Y-m-d');
    $data = [
      'counts' => $counts,
      'idsite' => $idsite,
      'thedate' => $date
    ];
    $cek = $this->db->get_where('gms_visitor_report', ['idsite' => $idsite, 'thedate' => $date])->row_array();
    if ($cek) {
      $this->db->update('gms_visitor_report', $data, ['vid' => $cek['vid']]);
    } else {
      $this->db->insert('gms_visitor_report', $data);
    }
  }

  public function listabsenidsite($iduser)
  {
    $today = date('Y-m-d');
    $data = $this->db->query("select gna.id_att,gna.datetime_in,qt.lokasi,gna.id_user,gna.is_in,gna.thetime,e.username from gms_attendances gna, gms_qrcode_tags qt,users e where gna.id_user = e.id and gna.tagid = qt.tagid and e.id = $iduser and date(gna.datetime_in)='$today' order by gna.datetime_in asc;")->result_array();
    echo json_encode($data, true);
  }

  public function listemergencycontact()
  {
    $this->db->select('gms_darurat.nama AS name,gms_darurat.telephone AS phone,gms_darurat.id_service AS service,gms_darurat.maps AS address');
    $data = $this->db->get("gms_darurat")->result_array();
    echo json_encode($data, true);
  }
}
