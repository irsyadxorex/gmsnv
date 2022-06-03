<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		is_logged_in();
		// check_role_danru();
	}

	public function index()
	{
		$id_site = $this->session->userdata('id_site');
		$date = date("Y-m-d");
		if ($id_site == 0) {
			$count_team = $this->db->query("select COUNT(u.id) as counts from users u where  id_position BETWEEN 1 and 2 group by u.status ;")->row_array();
			$count_checkpoint = $this->db->query("select count(tagid) as counts from gms_checkpoint_details gcd WHERE tanggal='$date';")->row_array();
			$count_checkpoint_user = $this->db->query("select count(tagid_user) as counts from gms_checkpoint_details gcd WHERE tanggal='$date';")->row_array();
			$count_visitor = $this->db->query("select count(gt.id_tamu)as counts from gms_tamu gt WHERE gt.tanggal = '$date';")->row_array();
			$limit_checkpoint = $this->db->query("select * FROM gms_checkpoint_details gcd, users u , sites s, gms_qrcode_tags gqt WHERE gcd.tagid_user =gqt.tagid and u.id =gcd.id_user and gcd.id_site =s.id_site and tanggal='$date'  ORDER BY id_check DESC LIMIT 5;")->result_array();
			$limit_attendance = $this->db->query("select * FROM gms_attendances ga ,users u ,gms_shift gs, sites s WHERE s.id_site =u.id_site and ga.id_user =u.id and ga.id_shift =gs.id_shift and datetime_in='$date' LIMIT 5;")->result_array();
		} else {
			$count_team = $this->db->query("select COUNT(u.id) as counts from users u where  id_position BETWEEN 1 and 2 and id_site = $id_site group by u.id_site ;")->row_array();
			$count_checkpoint = $this->db->query("select count(tagid) as counts from gms_checkpoint_details gcd WHERE id_site =$id_site and tanggal='$date';")->row_array();
			$count_checkpoint_user = $this->db->query("select count(tagid_user) as counts from gms_checkpoint_details gcd WHERE id_site =$id_site and tanggal='$date';")->row_array();
			$count_visitor = $this->db->query("select count(gt.id_tamu)as counts from gms_tamu gt WHERE gt.tanggal = '$date' and id_site=$id_site;")->row_array();
			$limit_checkpoint = $this->db->query("select * FROM gms_checkpoint_details gcd, users u , sites s, gms_qrcode_tags gqt WHERE gcd.tagid_user =gqt.tagid and u.id =gcd.id_user and gcd.id_site =s.id_site and gcd.id_site = $id_site and tanggal='$date' ORDER BY id_check DESC LIMIT 5;")->result_array();
			$limit_attendance = $this->db->query("select * FROM gms_attendances ga ,users u ,gms_shift gs, sites s WHERE s.id_site =u.id_site and ga.id_user =u.id and ga.id_shift =gs.id_shift and u.id_site =$id_site  and datetime_in='$date' LIMIT 5;")->result_array();
		}
		$data = [
			'title' => 'Dashboard',
			'count_team' => $count_team,
			'count_checkpoint' => $count_checkpoint,
			'count_checkpoint_user' => $count_checkpoint_user,
			'count_visitor' => $count_visitor,
			'limit_checkpoint' => $limit_checkpoint,
			'limit_attendance' => $limit_attendance
		];
		$this->template->load('templates/template', 'dashboard', $data);
	}
}
