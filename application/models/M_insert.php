<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_insert extends CI_Model
{
    ////////////////// LOG ACTIVITIES ///////////////////////////////////////////
    public function log_activities($what)
    {
        $data = [
            'id_user' => $_SESSION['id_user'],
            'what' => $what
        ];
        $this->db->insert('log_activities', $data);
    }
}
