<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Team extends CI_Controller
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
            $teams = $this->M_user->getTeams()->result_array();
        } else {
            $teams = $this->M_user->getTeamsSite();
        }

        $data = [
            'title' => 'Team',
            'users' => $teams,
        ];
        $this->template->load('templates/template', 'teams/team_data', $data);
    }

    public function add()
    {
        $data = [
            'title' => 'Add Team',
            'sites' => $this->M_site->getSite()
        ];
        $this->form_validation->set_rules('username', 'Username', 'trim|required|alpha_dash|is_unique[users.username]');
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        // $this->form_validation->set_rules('password1', 'Password', 'trim|required|matches[password2]');
        // $this->form_validation->set_rules('password2', 'Confirm Password', 'trim|required|matches[password1]');
        // $this->form_validation->set_rules('position', 'Position', 'required');
        // $this->form_validation->set_rules('identitas', 'Identitas', 'required');
        // $this->form_validation->set_rules('jenis_kelamin', 'jenis_kelamin', 'required');
        // $this->form_validation->set_rules('telephone', 'telephone', 'required');
        if ($this->form_validation->run() == false) {
            $this->template->load('templates/template', 'teams/team_add', $data);
        } else {
            $this->M_user->addTeam();
            $this->session->set_flashdata('message', '<div style="opacity: .6" class="alert alert-success" role="alert">
            Selamat! User baru berhasil ditambahkan!
            </div>');
            redirect('team');
        }
    }

    public function edit($username)
    {
        $data = [
            'title' => 'Add Team',
            'sites' => $this->M_site->getSite(),
            'team' => $this->M_user->getTeams($username)->row_array(),
        ];
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        if ($this->input->post('password1')) {
            $this->form_validation->set_rules('password2', 'Confirm Password', 'trim|required|matches[password1]');
            $this->form_validation->set_rules('password1', 'Password', 'trim|required|matches[password2]');
        }
        $this->form_validation->set_rules('position', 'Position', 'required');
        $this->form_validation->set_rules('identitas', 'Identitas', 'required');
        $this->form_validation->set_rules('jenis_kelamin', 'jenis_kelamin', 'required');
        $this->form_validation->set_rules('telephone', 'telephone', 'required');
        if ($this->form_validation->run() == false) {
            $this->template->load('templates/template', 'teams/team_edit', $data);
        } else {
            $this->M_user->editTeam();
            $this->session->set_flashdata('message', '<div style="opacity: .6" class="alert alert-success" role="alert">
            Selamat! User baru berhasil ditambahkan!
            </div>');
            redirect('team');
        }
    }
}
