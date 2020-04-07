<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->model('crud_model');
	}
	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function upload_gambar($gambar)
	{
		$foto = $_FILES[$gambar]['name'];
		$config['upload_path']          = './upload/';
		$config['allowed_types']        = 'gif|jpg|png|jpeg';
		$config['max_size']             = 10000;
		$config['overwrite']             = true;

		$this->load->library('upload', $config);


		if (!$this->upload->do_upload($gambar)) {
			$data = array('response' => 'error', 'message' => "Gambar Gagal di Upload");
			echo json_encode($data);
		} else {
			$foto = $this->upload->data('file_name');
		}
		return $foto;
	}

	public function getall()
	{
		if ($this->input->is_ajax_request()) {
			$data = $this->crud_model->get_entry();
			echo json_encode($data);
		} else {
			echo "No direct script access allowed";
		}
	}

	public function insert()
	{
		if ($this->input->is_ajax_request()) {
			$this->form_validation->set_rules('name', 'Name', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
			if ($this->form_validation->run() == FALSE) {
				$data = array('response' => 'error', 'message' => validation_errors());
			} else {
				$ajax_data = array(
					'nama' => $this->input->post('name'),
					'email' => $this->input->post('email'),
					'gambar' => $this->upload_gambar('gambar')
				);

				if ($this->crud_model->insert_entry($ajax_data)) {
					$data = array('response' => 'success', 'message' => 'Data added Successfully');
				} else {
					$data = array('response' => 'error', 'message' => 'Failed');
				}
			}
			echo json_encode($data);
		} else {
			echo "No direct script access allowed";
		}
	}



	public function delete()
	{
		if ($this->input->is_ajax_request()) {
			$del_id = $this->input->post('del_id');
			$foto = $this->crud_model->edit_entry($del_id);
			if ($this->crud_model->delete_entry($del_id)) {
				unlink('upload/' . $foto->gambar);
				$data = array("response" => "success");
			} else {
				$data = array("response" => "Failed");
			}
			echo json_encode($data);
		}
	}

	public function edit()
	{
		if ($this->input->is_ajax_request()) {
			$edit_id = $this->input->post('edit_id');

			if ($post = $this->crud_model->edit_entry($edit_id)) {
				$data = array("response" => "success", "post" => $post);
			} else {
				$data = array("response" => "error", "message" => "Failed");
			}
			echo json_encode($data);
		}
	}

	public function update()
	{
		if ($this->input->is_ajax_request()) {
			$this->form_validation->set_rules('edit_name', 'Name', 'required');
			$this->form_validation->set_rules('edit_email', 'Email', 'required|valid_email');
			if ($this->form_validation->run() == FALSE) {
				$data = array('response' => 'error', 'message' => validation_errors());
			} else {
				$edit_id = $this->input->post('edit_id');
				$foto_row = $this->crud_model->edit_entry($edit_id);
				if ($_FILES['gambar'] != '') {
					$foto = $this->upload_gambar('gambar');
					unlink('upload/' . $foto_row->gambar);
				} else {
					$foto = $foto_row->gambar;
				}

				$ajax_edit_data = array(
					'id' => $this->input->post('edit_id'),
					'nama' => $this->input->post('edit_name'),
					'email' => $this->input->post('edit_email'),
					'gambar' => $foto
				);

				if ($this->crud_model->update_entry($ajax_edit_data)) {
					$data = array('response' => 'success', 'message' => 'Data updated Successfully');
				} else {
					$data = array('response' => 'error', 'message' => 'Failed');
				}
			}
			echo json_encode($data);
		} else {
			echo "No direct script access allowed";
		}
	}
}
