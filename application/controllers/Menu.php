<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('SubMenu_model', 'subMenu');
    }
    public function index()
    {

        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Menu Management';
        $data['menu'] = $this->db->get('user_menu')->result_array();
        $this->form_validation->set_rules('menu', 'Menu', 'required|trim');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('templates/topbar');
            $this->load->view('menu/index');
            $this->load->view('templates/addition');
            $this->load->view('templates/footer');
        } else {
            $this->db->select_max('id');
            $result = $this->db->get('user_menu')->row();
            $add = $result->id + 1;

            $this->db->select_max('menu_id');
            $result2 = $this->db->get('user_access_menu')->row();
            $add2 = $result2->menu_id + 1;

            $this->db->insert('user_menu', ['id' => $add, 'menu' => $this->input->post('menu')]);
            $this->db->insert('user_access_menu', ['role_id' => 1, 'menu_id' => $add2]);
            $this->db->insert('user_access_menu', ['role_id' => 2, 'menu_id' => $add2]);
            $this->session->set_flashdata('success', 'New Menu successfully added!');
            redirect('menu');
        }
    }
    public function submenu()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Submenu Management';
        $data['submenu'] = $this->subMenu->getSubMenu();
        $data['menu'] = $this->subMenu->getMenu();
        $this->form_validation->set_rules('title', 'Title', 'required|trim');
        $this->form_validation->set_rules('url', 'Url', 'required|trim');
        $this->form_validation->set_rules('icon', 'Icon', 'required|trim');
        $this->form_validation->set_rules('status', 'Status', 'required|trim');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('templates/topbar');
            $this->load->view('menu/submenu');
            $this->load->view('templates/addition');
            $this->load->view('templates/footer');
        } else {
            $data = [
                'menu_id' => $this->input->post('menu'),
                'title' => $this->input->post('title'),
                'url' => $this->input->post('url'),
                'icon' => $this->input->post('icon'),
                'is_active' => $this->input->post('status')
            ];
            $this->db->insert('user_sub_menu', $data);
            $this->session->set_flashdata('success', 'New Submenu successfully added!');
            redirect('menu/submenu');
        }
    }
}
