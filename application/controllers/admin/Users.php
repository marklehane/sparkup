<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends Admin_Controller
{
    public function index()
    {

        // Check Login
        if (!$this->session->userdata('logged_in')) {
            redirect('admin/login');
        }

        $data['users'] = $this->User_model->get_list();

        //Load Template
        $this->template->load('admin', 'default', 'users/index', $data);
    }

    public function add()
    {

        // Check Login
        if (!$this->session->userdata('logged_in')) {
            redirect('admin/login');
        }

        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|min_length[2]');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|min_length[2]');
        $this->form_validation->set_rules('username', 'username', 'trim|required|min_length[4]');
        $this->form_validation->set_rules('email', 'email', 'trim|required|min_length[7]|valid_email');
        $this->form_validation->set_rules('password', 'password', 'trim|required|min_length[4]|matches[password2]');
        $this->form_validation->set_rules('password2', 'password2', 'trim|required|min_length[4]|matches[password]');

        if ($this->form_validation->run() == false) {
            //Load View Into Template
            $this->template->load('admin', 'default', 'users/add');
        } else {
            //Create Page Data Array
            $data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name'  => $this->input->post('last_name'),
                'email'      => $this->input->post('email'),
                'username'   => $this->input->post('username'),
                'password'   => md5($this->input->post('password')),
            );

            //Add User
            $this->User_model->add($data);

            //Activity Array
            $data = array(
                'resource_id' => $this->db->insert_id(),
                'type'        => 'user',
                'action'      => 'added',
                'user_id' => $this->session->userdata('user_id'),
                'message'     => 'A new user was added (' . $data["username"] . ')',

            );

            //Add Activity
            $this->Activity_model->add($data);

            //Create Message
            $this->session->set_flashdata('success', 'User has been added');

            //Redirect to pages
            redirect('admin/users');
        }

    }

    public function edit($id)
    {
        // Check Login
        if (!$this->session->userdata('logged_in')) {
            redirect('admin/login');
        }

        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|min_length[2]');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|min_length[2]');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|min_length[7]|valid_email');

        if ($this->form_validation->run() == false) {
            // Get Current Subject
            $data['item'] = $this->User_model->get($id);
            //Load View Into Template
            $this->template->load('admin', 'default', 'users/edit', $data);
        } else {
            // Create User Data Array
            $data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name'  => $this->input->post('last_name'),
                'email'      => $this->input->post('email'),
                'username'   => $this->input->post('username'),
            );

            // Update User
            $this->User_model->update($id, $data);

            // Activity Array
            $data = array(
                'resource_id' => $this->db->insert_id(),
                'type'        => 'user',
                'action'      => 'updated',
                'user_id'     => $this->session->userdata('user_id'),
                'message'     => 'A user was updated (' . $data["username"] . ')',
            );

            // Add Activity
            $this->Activity_model->add($data);

            //Create Message
            $this->session->set_flashdata('success', 'User has been updated');

            //Redirect to Users
            redirect('admin/users');
        }
    }

    public function delete($id)
    {
        // Check Login
        if (!$this->session->userdata('logged_in')) {
            redirect('admin/login');
        }

        // Get Username
        $username = $this->User_model->get($id)->username;

        // Delete User
        $this->User_model->delete($id);

        // Activity Array
        $data = array(
            'resource_id' => $this->db->insert_id(),
            'type'        => 'user',
            'action'      => 'deleted',
            'user_id'     => $this->session->userdata('user_id'),
            'message'     => 'A user was deleted',
        );

        // Add Activity
        $this->Activity_model->add($data);

        // Create Message
        $this->session->set_flashdata('success', 'User has been deleted');

        // Redirect to Subjects
        redirect('admin/users');
    }

    public function login()
    {

        $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]');

        if ($this->form_validation->run() == false) {
            //Load View Into Template
            $this->template->load('admin', 'login', 'users/login');
        } else {
            // Get Post Data
            $username     = $this->input->post('username');
            $password     = $this->input->post('password');
            $enc_password = md5($password);

            $user_id = $this->User_model->login($username, $enc_password);

            if ($user_id) {
                $user_data = array(
                    'user_id'   => $user_id,
                    'username'  => $username,
                    'logged_in' => true,
                );

                // Set Session Data
                $this->session->set_userdata($user_data);

                // Create Message
                $this->session->set_flashdata('success', 'You are logged in');

                // Redirect to pages
                redirect('admin');
            } else {
                // Create Error
                $this->session->set_flashdata('error', 'Invalid Login');

                // Redirect to pages
                redirect('admin/users/login');
            }
        }

    }

    public function logout()
    {
        $this->session->unset_userdata('logged_in');
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('username');
        $this->session->sess_destroy();

        // Message
        $this->session->set_flashdata('success', 'You are logged out');
        redirect('admin/users/login');
    }
}
