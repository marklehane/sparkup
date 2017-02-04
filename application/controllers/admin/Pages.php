<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pages extends Admin_Controller
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
        $data['pages'] = $this->Page_model->get_list();

        //Load Template
        $this->template->load('admin', 'default', 'pages/index', $data);
    }

    public function add()
    {
        //Field Rules
        $this->form_validation->set_rules('title', 'Title', 'trim|required|min_length[3]');
        $this->form_validation->set_rules('subject_id', 'Subject', 'trim|required');
        $this->form_validation->set_rules('body', 'Body', 'trim|required');
        $this->form_validation->set_rules('is_published', 'Publish', 'required');
        $this->form_validation->set_rules('is_featured', 'Feature', 'required');
        $this->form_validation->set_rules('order', 'Order', 'integer');

        if ($this->form_validation->run() == false) {

            $subject_options    = array();
            $subject_options[0] = 'Select Subject';

            $subject_list = $this->Subject_model->get_list();

            foreach ($subject_list as $subject) {
                $subject_options[$subject->id] = $subject->name;
            }

            $data['subject_options'] = $subject_options;

            //Load Template
            $this->template->load('admin', 'default', 'pages/add', $data);

        } else {

            $slug = str_replace(' ', '-', $this->input->post('title'));
            $slug = strtolower($slug);

            //Page Data
            $data = array(
                'title'        => $this->input->post('title'),
                'slug'         => $slug,
                'subject_id'   => $this->input->post('subject_id'),
                'body'         => $this->input->post('body'),
                'is_published' => $this->input->post('is_published'),
                'is_published' => $this->input->post('is_published'),
                'is_featured'  => $this->input->post('is_featured'),
                'in_menu'      => $this->input->post('in_menu'),
                'user_id'      => $this->session->userdata('user_id'),
                'order'        => $this->input->post('order'),

            );

            //Add Page
            $this->Page_model->add($data);

            //Activity Array
            $data = array(
                'resource_id' => $this->db->insert_id(),
                'type'        => 'page',
                'action'      => 'added',
                'user_id'      => $this->session->userdata('user_id'),
                'message'     => 'A new page was added (' . $data["title"] . ')',
            );

            //Insert Activity
            $this->Activity_model->add($data);

            //Set Message
            $this->session->set_flashdata('success', 'Page has been added');

            //Redirect
            redirect('admin/pages');

        }

    }

    public function edit($id)
    {
        //Field Rules
        $this->form_validation->set_rules('title', 'Title', 'trim|required|min_length[3]');
        $this->form_validation->set_rules('subject_id', 'Subject', 'trim|required');
        $this->form_validation->set_rules('body', 'Body', 'trim|required');
        $this->form_validation->set_rules('is_published', 'Publish', 'required');
        $this->form_validation->set_rules('is_featured', 'Feature', 'required');
        $this->form_validation->set_rules('order', 'Order', 'integer');

        if ($this->form_validation->run() == false) {

            $data['item'] = $this->Page_model->get($id);

            $subject_options    = array();
            $subject_options[0] = 'Select Subject';

            $subject_list = $this->Subject_model->get_list();

            foreach ($this->Subject_model->get_list() as $subject) {
                $subject_options[$subject->id] = $subject->name;
            }

            $data['subject_options'] = $subject_options;

            $this->template->load('admin', 'default', 'pages/edit', $data);

        } else {

            $slug = str_replace(' ', '-', $this->input->post('title'));
            $slug = strtolower($slug);

            //Page Data
            $data = array(
                'title'        => $this->input->post('title'),
                'slug'         => $slug,
                'subject_id'   => $this->input->post('subject_id'),
                'body'         => $this->input->post('body'),
                'is_published' => $this->input->post('is_published'),
                'is_published' => $this->input->post('is_published'),
                'is_featured'  => $this->input->post('is_featured'),
                'in_menu'      => $this->input->post('in_menu'),
                'user_id'      => $this->session->userdata('user_id'),
                'order'        => $this->input->post('order'),

            );

            //Update Page
            $this->Page_model->update($id, $data);

            //Activity Array
            $data = array(
                'resource_id' => $this->db->insert_id(),
                'type'        => 'page',
                'action'      => 'updated',
                'user_id'      => $this->session->userdata('user_id'),
                'message'     => 'A  page was updated (' . $data["title"] . ')',
            );

            //Insert Activity
            $this->Activity_model->add($data);

            //Set Message
            $this->session->set_flashdata('success', 'Page has been updated');

            //Redirect
            redirect('admin/pages');

        }

    }

    public function delete($id)
    {
        $name = $this->Page_model->get($id)->title;

        //Delete Subject
        $this->Page_model->delete($id);

        //Activity Array
        $data = array(
            'resource_id' => $this->db->insert_id(),
            'type'        => 'page',
            'action'      => 'deleted',
            'user_id'      => $this->session->userdata('user_id'),
            'message'     => 'A page was deleted',
        );

        //Insert Activity
        $this->Activity_model->add($data);

        //Set Message
        $this->session->set_flashdata('success', 'Page has been deleted');

        //Redirect
        redirect('admin/pages');
    }
}
