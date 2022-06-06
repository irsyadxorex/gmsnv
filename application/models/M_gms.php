<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_gms extends CI_Model
{
    public function get_codeshift($nik, $date, $month, $year)
    {
        return $this->db->query("select code_shift from gms_attendances ga where day(date_time) = $date and month(date_time)= $month and year(date_time)= $year and nik = $nik and is_in = 1 ORDER by date_time asc limit 1")->row('code_shift');
    }
    function create($data){
       $this->db->insert('gms_checkpoints',$data);
       return $this->db->insert_id();
    }

    public function create_checkpoint_details($data)
    {
      $this->db->insert('gms_checkpoint_details',$data);
    }

    function update_checkpoint_details($data,$id){
      $this->db->where('id_check',$id);
      $this->db->update('gms_checkpoint_details',$data);
    }

    function read_qrcodetag($id=null)
    {
      $sql_query="SELECT * FROM gmsnv_db.gms_qrcode_tags where id_site='$id'";
      $result = $this->db->query($sql_query);
      return $result->result();
    }

}
