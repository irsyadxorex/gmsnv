<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_user extends CI_Model
{

    //// Menu User
    public function getUserSite($username = null)
    {
        $id_site = $this->session->userdata('id_site');
        if ($username != null) {
            $users = $this->db->query("select  u.nama,u.username,u.email,u.id_site,u.id_role,u.id_position,u.status,r.role ,s.site,ud.telephone  from users u LEFT JOIN users_detail ud ON u.username =ud.username LEFT JOIN positions p ON u.id_position =p.id_position LEFT JOIN sites s ON u.id_site= s.id_site LEFT JOIN roles r ON u.id_role = r.id_role where u.username='$username' ; ");
        } else {
            $users = $this->db->query("select  u.nama,u.username,u.email,u.id_site,u.id_role,u.id_position,u.status,r.role ,s.site,ud.telephone  from users u LEFT JOIN users_detail ud ON u.username =ud.username LEFT JOIN positions p ON u.id_position =p.id_position LEFT JOIN sites s ON u.id_site= s.id_site LEFT JOIN roles r ON u.id_role = r.id_role where u.id_site=$id_site and u.status = 1 and not u.id_role=1 and not u.id_role=5 ; ");
        }
        return $users;
    }

    //// Menu Admin
    public function getUser()
    {
        // $id_site = $this->session->userdata('id_site');
        $users = $this->db->query("select  u.nama,u.username,u.email,u.id_site,u.id_role,u.id_position,u.status,r.role ,s.site  from users u LEFT JOIN users_detail ud ON u.username =ud.username LEFT JOIN positions p ON u.id_position =p.id_position LEFT JOIN sites s ON u.id_site= s.id_site LEFT JOIN roles r ON u.id_role = r.id_role where  not u.id_role=5 ;  ");
        return $users;
    }

    public function getTeams($username = null)
    {
        // $id_site = $this->session->userdata('id_site');
        if ($username == null) {
            $users = $this->db->query("select u.nama,u.username,u.email,u.id_site,u.id_role,u.id_position,u.status,s.site,p.position,ud.jenis_kelamin,r.`role` from users u INNER JOIN users_detail ud ON u.username =ud.username INNER JOIN positions p ON u.id_position =p.id_position LEFT JOIN sites s ON u.id_site= s.id_site INNER JOIN roles r ON u.id_role = r.id_role WHERE u.id_role =5;");
        } else {
            $users = $this->db->query("select *,ud.alamat as domisili from users u INNER JOIN users_detail ud ON u.username =ud.username INNER JOIN positions p ON u.id_position =p.id_position LEFT JOIN sites s ON u.id_site= s.id_site INNER JOIN roles r ON u.id_role = r.id_role WHERE u.username = '$username'");
        }
        return $users;
    }

    /// Manage Team
    public function getTeamsSite()
    {
        $id_site = $this->session->userdata('id_site');
        $users = $this->db->query("select u.nama,u.username,u.email,u.id_site,u.id_role,u.id_position,u.status,s.site,p.position,ud.jenis_kelamin,r.`role` from users u INNER JOIN users_detail ud ON u.username =ud.username INNER JOIN positions p ON u.id_position =p.id_position INNER JOIN sites s ON u.id_site= s.id_site INNER JOIN roles r ON u.id_role = r.id_role WHERE u.id_role =5 and u.id_site =$id_site;
        ")->result_array();
        return $users;
    }

    //// User
    public function addUserSite()
    {
        $id_site = $this->session->userdata('id_site') == 0 ? $this->input->post('id_site') : $this->session->userdata('id_site');
        $user = [
            'nama' => $this->input->post('nama'),
            'username' => strtolower($this->input->post('username')),
            'email' => $this->input->post('email'),
            'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
            'id_site' => $id_site,
            'id_role' => $this->input->post('role'),
            'id_position' => 0,
            'status' => 1,
        ];
        $detail = [
            'username' => $this->input->post('username'),
            'telephone' => $this->input->post('telephone'),
        ];
        $this->db->insert('users_detail', $detail);
        $this->db->insert('users', $user);
    }

    public function editUserSite()
    {
        $username = $this->input->post('username');
        if ($this->input->post('password1')) {
            $data = [
                'nama' => $this->input->post('nama'),
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'email' => $this->input->post('email'),
                'id_role' => $this->input->post('role'),
                'id_position' => 0,
                'status' => $this->input->post('status'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            $detail = [
                'telephone' => $this->input->post('telephone'),
            ];
        } else {
            $data = [
                'nama' => $this->input->post('nama'),
                'email' => $this->input->post('email'),
                'id_role' => $this->input->post('role'),
                'id_position' => 0,
                'status' => $this->input->post('status'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            $detail = [
                'telephone' => $this->input->post('telephone'),
            ];
        }
        $this->db->where('username', $username);
        $this->db->update('users_detail', $detail);
        $this->db->where('username', $username);
        $this->db->update('users', $data);
    }


    //// Manage Team
    public function addTeam()
    {
        $user = [
            'nama' => $this->input->post('nama'),
            'username' => strtolower($this->input->post('username')),
            'email' => $this->input->post('email'),
            'password' => password_hash($this->input->post('username') . '123', PASSWORD_DEFAULT),
            'id_site' => $this->session->userdata('id_site') != 0 ? $this->session->userdata('id_site') : $this->input->post('id_site'),
            'id_role' => 5,
            'id_position' => $this->input->post('position'),
            'status' => 1,
        ];
        $detail = [
            'username' => strtolower($this->input->post('username')),
            'nik' => $this->input->post('identitas'),
            'telephone' => $this->input->post('telephone'),
            'tempat_lahir' => $this->input->post('tempat_lahir'),
            'tanggal_lahir' => $this->input->post('tanggal_lahir'),
            'alamat' => $this->input->post('alamat'),
            'jenis_kelamin' => $this->input->post('jenis_kelamin'),
            'tmt' => $this->input->post('tmt') != null ? $this->input->post('tmt') : '',
            'resign' => $this->input->post('resign') != null ? $this->input->post('resign') : '',
        ];
        $this->db->insert('users_detail', $detail);
        $this->db->insert('users', $user);
    }

    public function editTeam()
    {
        $username = $this->input->post('username');
        if ($this->input->post('password1')) {
            $user = [
                'nama' => $this->input->post('nama'),
                'email' => $this->input->post('email'),
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'id_position' => $this->input->post('position'),
                'status' => 1,
            ];
            $detail = [
                'nik' => $this->input->post('identitas'),
                'telephone' => $this->input->post('telephone'),
                'tempat_lahir' => $this->input->post('tempat_lahir'),
                'tanggal_lahir' => $this->input->post('tanggal_lahir'),
                'alamat' => $this->input->post('alamat'),
                'jenis_kelamin' => $this->input->post('jenis_kelamin'),
                'tmt' => $this->input->post('tmt') != null ? $this->input->post('tmt') : '',
                'resign' => $this->input->post('resign') != null ? $this->input->post('resign') : '',
            ];
        } else {
            $user = [
                'nama' => $this->input->post('nama'),
                'email' => $this->input->post('email'),
                'id_position' => $this->input->post('position'),
                'status' => 1,
            ];
            $detail = [
                'nik' => $this->input->post('identitas'),
                'telephone' => $this->input->post('telephone'),
                'tempat_lahir' => $this->input->post('tempat_lahir'),
                'tanggal_lahir' => $this->input->post('tanggal_lahir'),
                'alamat' => $this->input->post('alamat'),
                'jenis_kelamin' => $this->input->post('jenis_kelamin'),
                'tmt' => $this->input->post('tmt') != null ? $this->input->post('tmt') : '',
                'resign' => $this->input->post('resign') != null ? $this->input->post('resign') : '',
            ];
        }
        $this->db->where('username', $username);
        $this->db->update('users_detail', $detail);
        $this->db->where('username', $username);
        $this->db->update('users', $user);
    }

    public function getPersonil($id)
    {
        $query = $this->db->query("select * from sites s where id_service =1 and  site_id = $id;");
        return $query;
    }
}
