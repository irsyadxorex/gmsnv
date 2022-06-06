<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Attendances extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    is_logged_in();
    // check_role_danru();
    $this->load->model('M_attendance');
  }

  function get_ajax()
  {
    $attendances = $this->M_attendance->get_datatables();
    $data = array();
    $no = @$_POST['start'];
    foreach ($attendances as $attendance) {
      $no++;
      $row = array();
      $row[] = $no . ".";
      if ($this->session->userdata('id_site') == 0) {
        $row[] = $attendance->site;
      }
      $row[] = $attendance->is_in == 1 ? '<span class="label label-warning">IN</span>' : '<span class="label label-default">OUT</span>';
      $row[] = indo_date($attendance->datetime_in) . ' - ' . indo_time($attendance->datetime_in) . '<br>' . indo_date($attendance->datetime_out) . ' - ' . indo_time($attendance->datetime_out);
      $row[] = $attendance->nama;
      $row[] = $attendance->code;
      // $row[] = $attendance->latitude_longitude_out == $attendance->latitude_longitude ? '<span class="label label-success">Akurat</span>' : '<span class="label label-warning">Tidak Akurat</span>';
      // $row[] = $attendance->latitude_longitude_in == $attendance->latitude_longitude ? '<span class="label label-success">Akurat</span>' : '<span class="label label-warning">Tidak Akurat</span>';
      $row[] =  '<a id="set_detail" class="label label-info" data-toggle="modal" data-target="#modal-detail" data-qrcode="' . $attendance->att_tag . '" data-site="' . $attendance->site . '" data-label="' . $attendance->label . '" data-location="' . $attendance->lokasi . '" data-status="' . $attendance->is_in . '" data-latitude_longitude="' . $attendance->latitude_longitude . '" data-latitude_longitude_in="' . $attendance->latitude_longitude_in . '" data-latitude_longitude_out="' . $attendance->latitude_longitude_out . '" data-time_in="' .  indo_time($attendance->datetime_in) . '" data-time_out="' . indo_time($attendance->datetime_out) . '" data-code_shift="' . $attendance->code . '" data-ket_shift="' . $attendance->keterangan . '" data-nama="' . $attendance->nama . '" ><i class="fa fa-eye"></i>Detail</a>';
      // $row[] =  '<a id="set_detail" class="label label-info" data-toggle="modal" data-target="#modal-detail" data-qrcode="' . $attendance->tagid . '" data-site="" data-label="" data-location="" data-status="" data-latitude_longitude=""><i class="fa fa-eye"></i>Detail</a>';


      $data[] = $row;
    }
    $output = array(
      "draw" => @$_POST['draw'],
      "recordsTotal" => $this->M_attendance->count_all(),
      "recordsFiltered" => $this->M_attendance->count_filtered(),
      "data" => $data,
    );
    // output to json format
    echo json_encode($output);
  }
  public function index()
  {
    // $site_id = $this->fungsi->user_login()->id_site;
    // if ($site_id == 0) {
    //     $attendace = $this->db->query("select *, gas.keterangan as shift from gms_new_attendances gna ,gms_attendance_status gas ,sites s ,employees e WHERE gna.att_status =gas.id and gna.id_site =s.site_id and gna.nik = e.nik order by gna.attid desc")->result_array();
    // } elseif ($site_id != null) {
    //     $attendace = $this->db->query("select *, gas.keterangan as shift from gms_new_attendances gna ,gms_attendance_status gas ,sites s ,employees e WHERE gna.att_status =gas.id and gna.id_site =s.site_id and gna.nik = e.nik and e.id_site = $site_id order by gna.attid desc")->result_array();
    // }
    $data = [
      'title' => 'Absensi',
      // 'attendance' => $attendace
    ];
    $this->template->load('templates/template', 'attendances/attendance_data', $data);
  }

  public function report()
  {
    $data = [
      'title' => 'Attencande Report',
      'sites' => $this->M_site->getSite()
    ];
    $this->template->load('templates/template', 'attendances/attendance_report', $data);
  }

  public function export()
  {
    $date = $this->input->post('date');
    $site_id = $this->input->post('site_id');
    $date_range = explode(" - ", $date);
    print_r($date_range);
    die;
  }
}
