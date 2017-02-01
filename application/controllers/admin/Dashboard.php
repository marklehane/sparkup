<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();

        // Check Login
        if (!$this->session->userdata('logged_in')) {
            redirect('admin/login');
        }
    }
    
    public function index()
    {

        //Get Activities
        $data['activities'] = $this->Activity_model->get_list();

        //Load Template
        $this->template->load('admin', 'default', 'dashboard', $data);
    }
}
