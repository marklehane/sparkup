<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Subjects extends CI_Controller
{
    public function index()
    {
        $this->template->load('admin', 'default', 'subjects/index');
    }

    public function add()
    {
        $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[3]');

        if ($this->form_validation->run() == false) {
            $this->template->load('admin', 'default', 'subjects/add');
        } else {
            // Create Post Array
            $data = array(
                'name' => $this->input->post('name'),
            );

            //Insert Subject
            $this->Subject_model->add($data);

            //Activity Array
            $data = array(
                'resource_id' => $this->db->insert_id(),
                'type'        => 'subject',
                'action'      => 'added',
                'user_id'     => 1,
                'message'     => 'A new subject was added (' . $data["name"] . ')',
            );

            //Insert Activity
            $this->Activity_model->add($data);

            //Set Message
            $this->session->set_flashdata('success', 'Subject has been added');

            //Redirect
            redirect('admin/subjects');
        }

    }

    public function edit()
    {
        $this->template->load('admin', 'default', 'subjects/edit');
    }

    public function delete()
    {

    }
}
