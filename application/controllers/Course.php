<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Course extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("CoursesModel");
    }

    public function saveCourse()
    {
        if (!$this->input->is_ajax_request()) {
            exit("Não permitido");
        }

        $json = array();
        $json["status"] = 1;
        $json["error_list"] = array();

        $data = $this->input->post();

        if (empty($data["course_name"])) {
            $json["status"] = 0;
            $json["error_list"]["#course_name"] = "Nome do curso é obrigatório";
        } else {
            if ($this->CoursesModel->isDuplicated("course_name", $data["course_name"], $data["course_id"])) {
                $json["status"] = 0;
                $json["error_list"]["#course_name"] = "Nome do curso já existe";
            }
        }

        $data["course_duration"] = floatval($data["course_duration"]);

        if (empty($data["course_duration"])) {
            $json["status"] = 0;
            $json["error_list"]["#course_duration"] = "Duração do curso é obrigatório";
        } else {
            if ($data["course_duration"] <= 0 || $data["course_duration"] >= 100) {
                $json["status"] = 0;
                $json["error_list"]["#course_duration"] = "Duração do curso inválida";
            }
        }

        if ($json["status"] == 1) {
            if (!empty($data["course_img"])) {
                $file_name = basename($data["course_img"]);
                $old_path = getcwd() . "/tmp/" . $file_name;
                $new_path = getcwd() . "/public/images/courses/" . $file_name;

                rename($old_path, $new_path);
                $data["course_img"] = "public/images/courses/" . $file_name;
            } else {
                unset($data["course_img"]);
            }

            if (empty($data["course_id"])) {
                $this->CoursesModel->insert($data);
            } else {
                $course_id = $data["course_id"];
                unset($data["course_id"]);
                $this->CoursesModel->update($course_id, $data);
            }
        }

        echo json_encode($json);
    }

    public function editCourse()
    {
        if (!$this->input->is_ajax_request()) {
            exit("Não permitido");
        }

        $json = array();
        $json["input"] = array();

        $course_id = $this->input->post("course_id");

        $data = $this->CoursesModel->getData($course_id)->result_array()[0];

        $json["input"]["course_id"] = $data["course_id"];
        $json["input"]["course_name"] = $data["course_name"];
        $json["input"]["course_duration"] = $data["course_duration"];
        $json["input"]["course_description"] = $data["course_description"];

        if ($data["course_img"]) {
            $json["img"]["course_img"] = base_url() . $data["course_img"];
        } else {
            $json["img"]["course_img"] = "";
        }

        echo json_encode($json);
    }

    public function deleteCourse()
    {
        if (!$this->input->is_ajax_request()) {
            exit("Não permitido");
        }

        $json = array();
        $json["input"] = array();

        $course_id = $this->input->post("course_id");

        $this->CoursesModel->delete($course_id);

        echo json_encode($json);
    }

    public function listCourses()
    {
        if (!$this->input->is_ajax_request()) {
            exit("Não permitido");
        }

        $courses = $this->CoursesModel->getDataTable();

        $data = array();

        foreach ($courses as $course) {
            $row = array();
            $row[] = $course->course_name;

            if ($course->course_img) {
                $row[] = '<img src="' . base_url() . $course->course_img . '" class="course-thumbnail">';
            } else {
                $row[] = "";
            }

            $row[] = $course->course_duration;
            $row[] = $course->course_description;

            $row[] = '<div class="action-buttons">
                        <button class="btn btn-primary btn-edit-course" course_id="' . $course->course_id . '">
                            <i class="fa fa-edit" ></i>
                        </button>
                        <button class="btn btn-danger btn-delete-course" course_id="' . $course->course_id . '">
                            <i class="fa fa-trash" ></i>
                        </button>
                    </div>';
            $data[] = $row;
        }

        $json = array(
            "draw" => $this->input->post("draw"),
            "recordsTotal" => $this->CoursesModel->recordsTotal(),
            "recordsFiltered" => $this->CoursesModel->recordsFiltered(),
            "data" => $data
        );

        echo json_encode($json);
    }
}
