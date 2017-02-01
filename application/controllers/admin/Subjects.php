<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Subjects extends Admin_Controller
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
        $data['subjects'] = $this->Subject_model->get_list();

        //Load template
        $this->template->load('admin', 'default', 'subjects/index', $data);
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

    public function edit($id)
    {
        $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[3]');

        if ($this->form_validation->run() == false) {

            //Get Current Subject
            $data['item'] = $this->Subject_model->get($id);

            $this->template->load('admin', 'default', 'subjects/edit', $data);
        } else {

            $old_name = $this->Subject_model->get($id)->name;
            $new_name = $this->input->post('name');

            // Create Post Array
            $data = array(
                'name' => $this->input->post('name'),
            );

            //Insert Subject
            $this->Subject_model->update($id, $data);

            //Activity Array
            $data = array(
                'resource_id' => $this->db->insert_id(),
                'type'        => 'subject',
                'action'      => 'updated',
                'user_id'     => 1,
                'message'     => 'A subject (' . $old_name . ') was updated (' . $new_name . ')',
            );

            //Insert Activity
            $this->Activity_model->add($data);

            //Set Message
            $this->session->set_flashdata('success', 'Subject has been updated');

            //Redirect
            redirect('admin/subjects');
        }

    }

    public function delete($id)
    {
        $name = $this->Subject_model->get($id)->name;

        //Delete Subject
        $this->Subject_model->delete($id);

        //Activity Array
        $data = array(
            'resource_id' => $this->db->insert_id(),
            'type'        => 'subject',
            'action'      => 'deleted',
            'user_id'     => 1,
            'message'     => 'A subject was deleted',
        );

        //Insert Activity
        $this->Activity_model->add($data);

        //Set Message
        $this->session->set_flashdata('success', 'Subject has been deleted');

        //Redirect
        redirect('admin/subjects');
    }

}
