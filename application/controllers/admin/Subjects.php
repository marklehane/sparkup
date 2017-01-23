<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subjects extends CI_Controller 
{
	public function index()
	{
		$this->template->load('admin', 'default', 'subjects/index');
	}

	public function add()
	{
		$this->template->load('admin', 'default', 'subjects/add');
	}

	public function edit()
	{
		$this->template->load('admin', 'default', 'subjects/edit');
	}

	public function delete()
	{

	}
}
