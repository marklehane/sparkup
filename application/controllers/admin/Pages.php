<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pages extends CI_Controller
{
    public function index()
    {
        $this->template->load('admin', 'default', 'pages/index');
    }

    public function add()
    {
        $subject_options    = array();
        $subject_options[0] = 'Select Subjects';

        $subject_list = $this->Subject_model->get_list();

        foreach ($subject_list as $subject) {
            $subject_options[$subject->id] = $subject->name;
        }

        $data['subject_options'] = $subject_options;

        $this->template->load('admin', 'default', 'pages/add', $data);
    }

    public function edit()
    {
        $this->template->load('admin', 'default', 'pages/edit');
    }

    public function delete()
    {

    }
}
