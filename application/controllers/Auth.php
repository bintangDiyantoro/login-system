<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //load the form validation library, cuz it only can be loaded here
        $this->load->library('form_validation');
    }

    private function _login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        //if user exist
        if ($user) {
            //if user active
            if ($user['is_active'] == 1) {
                //if password correct
                if (password_verify($password, $user['password'])) {
                    $data = [
                        'email' => $user['email'],
                        'role_id' => $user['role_id']
                    ];
                    // set session for user data
                    $this->session->set_userdata($data);
                    if ($user['role_id'] == 1) {
                        redirect('admin');
                    } else {
                        redirect('user');
                    }
                } else {
                    $this->session->set_flashdata('wrongpass', 'Wrong password!');
                }
            } else {
                $this->session->set_flashdata('inactive', 'Email\'s not been activated!');
            }
        } else {
            $this->session->set_flashdata('not_found', 'Email not registered!');
        }
    }

    private function _sendEmail($token, $type)
    {
        $config = [
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_user' => 'temulawakcpw@gmail.com',
            'smtp_pass' => EMAIL_PASSWORD,
            'smtp_port' => 465,
            'mail_type' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n", //heve to be written by quotation mark
            'wordwrap' => true
        ];

        $this->load->library('email', $config);

        $this->email->from(base64_encode(random_bytes(8)) . '@' . base64_encode(random_bytes(4)) . '.com', base64_encode(random_bytes(9)));
        $this->email->to($this->input->post('email'));

        if ($type == 'verify') {
            $this->email->subject('Account Verification');
            $this->email->message('Click this link to activate your account : ' . base_url('auth/verify') . '?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '');
        }

        if ($this->email->send()) {
            return true;
        } else {
            echo $this->email->print_debugger();
            die;
        }
    }

    public function index()
    {
        if ($this->session->userdata('email')) {
            redirect('user');
        }
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Login page';
            $this->load->view('templates/header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/footer');
        } else {
            $this->_login();
            redirect('auth');
        }
    }

    public function registration()
    {
        if ($this->session->userdata('email')) {
            redirect('user');
        }
        // validation
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
            'is_unique' => 'This email has already registered!'
        ]);
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
            'matches' => 'Password not match!',
            'min_length' => 'Password too short!'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Registration page';
            $this->load->view('templates/header', $data);
            $this->load->view('auth/registration');
            $this->load->view('templates/footer');
        } else {
            $email = $this->input->post('email', true);
            $data = [
                'name' => htmlspecialchars($this->input->post('name', true)), //true params to avoid cross site scripting
                'email' => htmlspecialchars($email),
                'image' => 'default.jpg',
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'role_id' => 2,
                'is_active' => 0,
                'date_created' => time()
            ];
            // prepare token
            $token = base64_encode(random_bytes(32));
            $user_token = [
                'email' => $email,
                'token' => $token,
                'date_created' => time(), //optional
            ];

            $this->db->insert('user', $data);
            $this->db->insert('user_token', $user_token);
            $this->_sendEmail($token, 'verify');
            $this->session->set_flashdata('success', 'Data successfully added! Please verify your email');
            redirect('auth');
        }
    }

    public function verify()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');
        $user = $this->db->get_where('user', ['email' => $email])->row_array();
        if ($user) {
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
            if ($user_token) {
                if (time() - $user_token['date_created'] < 60 * 60 * 24) {
                    $this->db->set('is_active', 1);
                    $this->db->where('email', $email);
                    $this->db->update('user');
                    $this->db->delete('user_token', ['email' => $email]);
                    $this->session->set_flashdata('success', 'Account is activated! Please Login');
                    redirect('auth');
                } else {
                    $this->session->set_flashdata('failed', 'Account not activated! Token expired.');
                    $this->db->delete('user', ['email' => $email]);
                    $this->db->delete('user_token', ['email' => $email]);
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('failed', 'Account not activated! Wrong token.');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('failed', 'Account not activated! Email not registered.');
            redirect('auth');
        }
    }

    public function blocked()
    {
        $data['title'] = 'Access Denied';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('auth/blocked');
        $this->load->view('templates/addition');
        $this->load->view('templates/footer');
    }

    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');
        $this->session->set_flashdata('logout', 'You\'ve been logged out!');
        redirect('auth');
    }
}
