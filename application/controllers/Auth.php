<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function index()
    {
        if ($this->session->userdata('username')) {
            // $user = $this->db->get_where('admin_users', ['email' => $this->session->userdata('email')])->row_array();
            // $role = $this->db->get_where('roles', ['role_id' => $user['id_role']])->row('role');
            // redirect($role);
            redirect('dashboard');
        }
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if ($this->form_validation->run() == false) {
            $this->load->view('auth/login');
        } else {
            $this->_login();
        }
    }

    private function _login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $user = $this->db->get_where('users', ['username' => $username])->row_array();

        if ($user) {
            if ($user['status'] == 1) {
                if (password_verify($password, $user['password'])) {
                    $data = [
                        'username' => $user['username'],
                        'email' => $user['email'],
                        'id_site' => $user['id_site'],
                        'id_role' => $user['id_role'],
                        'id_position' => $user['id_position'],
                        'nama' => $user['nama']
                    ];
                    // var_dump($data);
                    // die;
                    $this->session->set_userdata($data);
                    if ($user['id_role'] == 1) {
                        redirect('dashboard');
                    } elseif ($user['id_role'] == 2) {
                        redirect('dashboard');
                    } else {
                        redirect('auth/blocked');
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    Password salah!
                    </div>');
                    redirect('auth');
                }
            }
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    User tidak aktif!
                    </div>');
            redirect('auth');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    Username tidak terdaftar!
                    </div>');
            redirect('auth');
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Done!</strong> Anda telah keluar!</div>');
        redirect('auth');
    }

    public function blocked()
    {
        if ($_SESSION['id_role'] == 6 || $_SESSION['id_role'] == 2) {
            redirect('dashboard');
        } else {
            echo 'access blocked! Hak akses pengguna dibatasi!';
        }
    }
}
