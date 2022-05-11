<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("CoursesModel");
		$this->load->model("TeamModel");
	}

	public function index()
	{
		$courses = $this->CoursesModel->showCourses();
		$team = $this->TeamModel->showTeam();

		$data = array(
			"scripts" => array(
				"owl.carousel.min.js",
				"cbpAnimatedHeader.js",
				"theme-scripts.js"
			),
			"courses" => $courses,
			"team" => $team,
		);

		$this->template->show('home', $data);
	}
}
