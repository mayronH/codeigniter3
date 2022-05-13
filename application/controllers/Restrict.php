<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Restrict extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library("session");

		$config["upload_path"] = "./tmp/";
		$config["allowed_types"] = "jpg|png|webp";
		$config["overwrite"] = true;

		$this->load->library("upload", $config);

		$this->load->model("UsersModel");
	}

	public function index()
	{
		if ($this->session->userdata("user_id")) {
			$data = array(
				"scripts" => array(
					"sweetalert2.all.min.js",
					"datatables.min.js",
					"dataTables.bootstrap.min.js",
					"util.js",
					"restrict.js",
				),
				"styles" => array(
					"restrict.css",
					"datatables.min.css",
					"dataTables.bootstrap.min.css"
				),
				"user_id" => $this->session->userdata("user_id")
			);

			$this->template->show('restrict', $data);
		} else {
			$data = array(
				"scripts" => array("util.js", "login.js"),
				"styles" => array("login.css"),
			);

			$this->template->show('login', $data);
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		header("Location: " . base_url() . "restrict");
	}

	public function ajaxLogin()
	{
		if (!$this->input->is_ajax_request()) {
			exit("Não permitido");
		}

		$json = array();
		$json["status"] = 0;
		$json["error_list"] = array();

		$username = $this->input->post("username");
		$password = $this->input->post("password");

		if (!empty($username)) {
			$result = $this->UsersModel->getUserData($username);

			if ($result) {
				$user_id = $result->user_id;
				$password_hash = $result->password_hash;
				if (password_verify($password, $password_hash)) {
					$this->session->set_userdata("user_id", $user_id);
					$json["status"] = 1;
				}
			}
		}
		if ($json["status"] == 0) {
			$json["error_list"]["#btn_login"] = "Usuário ou senha incorretos";
		}

		echo json_encode($json);
	}

	public function ajaxImportImage()
	{
		if (!$this->input->is_ajax_request()) {
			exit("Não permitido");
		}

		$json = array();
		$json["status"] = 0;

		if ($this->upload->do_upload("image_file")) {
			if ($this->upload->data()["file_size"] <= 2048) {
				$json["status"] = 1;
				$file_name = $this->upload->data()["file_name"];
				$json["img_path"] = base_url() . "tmp/" . $file_name;
			}
		}
		if ($json["status"] == 0) {
			$json["error"] = $this->upload->display_errors("", "");
		}
		echo json_encode($json);
	}
}
