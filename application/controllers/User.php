<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('M_user');
    }

    public function index()
    {
        if ($this->session->userdata('id_site') == 0) {
            $users = $this->M_user->getUser()->result_array();
        } else {
            $users = $this->M_user->getUserSite()->result_array();
        }
        $data = [
            'title' => 'Users',
            'users' => $users,
        ];
        $this->template->load('templates/template', 'users/user_data', $data);
    }

    public function add()
    {
        $data = [
            'title' => 'Add User',
            'sites' => $this->M_site->getSite(),
            'roles' => $this->db->query('select * from roles where not id_role=1')->result_array(),
        ];
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|is_unique[users.username]');
        $this->form_validation->set_rules('password1', 'Password', 'trim|required|matches[password2]');
        $this->form_validation->set_rules('password2', 'Confirm Password', 'trim|required|matches[password1]');
        // $this->form_validation->set_rules('telephone', 'Telephone', 'required');
        $this->form_validation->set_rules('role', 'Role', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');
        if ($this->form_validation->run() == false) {
            $this->template->load('templates/template', 'users/user_add', $data);
        } else {
            $this->M_user->addUserSite();
            $this->session->set_flashdata('message', '<div style="opacity: .6" class="alert alert-success" role="alert">
            Selamat! User baru berhasil ditambahkan!
            </div>');
            redirect('user');
        }
    }

    public function edit($username)
    {
        $data = [
            'title' => 'Update User',
            'sites' => $this->M_site->getSite(),
            'user' => $this->M_user->getUserSite($username)->row_array(),
            'roles' => $this->db->query('select * from roles where not id_role=1')->result_array(),
        ];

        $this->form_validation->set_rules('nama', 'Nama', 'required');
        if ($this->input->post('password1')) {
            $this->form_validation->set_rules('password1', 'Password', 'trim|matches[password2]');
            $this->form_validation->set_rules('password2', 'Confirm Password', 'trim|matches[password1]');
        }
        $this->form_validation->set_rules('role', 'Role', 'required');
        if ($this->form_validation->run() == false) {
            $this->template->load('templates/template', 'users/user_edit', $data);
        } else {
            $this->M_user->editUserSite();
            $this->session->set_flashdata('message', '<div style="opacity: .6" class="alert alert-success" role="alert">
            Selamat! User berhasil diupdate!
            </div>');
            redirect('user');
        }
    }

    public function delete()
    {
        $username = $this->input->post('username');
        // $data = [
        //     'status' => 0,
        // ];
        $this->db->where('username', $username);
        $this->db->delete('users');
        $this->session->set_flashdata('message', '<div style="opacity: .6" class="alert alert-success" role="alert">
            Selamat! User berhasil dihapus!
            </div>');
        redirect('user');
    }
}
