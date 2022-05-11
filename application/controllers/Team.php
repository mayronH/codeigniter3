<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Team extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("TeamModel");
    }

    public function saveMember()
    {
        if (!$this->input->is_ajax_request()) {
            exit("Não permitido");
        }

        $json = array();
        $json["status"] = 1;
        $json["error_list"] = array();

        $data = $this->input->post();

        if (empty($data["member_name"])) {
            $json["status"] = 0;
            $json["error_list"]["#member_name"] = "Nome do membro é obrigatório";
        }

        if ($json["status"] == 1) {
            if (!empty($data["member_photo"])) {
                $file_name = basename($data["member_photo"]);
                $old_path = getcwd() . "/tmp/" . $file_name;
                $new_path = getcwd() . "/public/images/team/" . $file_name;

                rename($old_path, $new_path);

                $data["member_photo"] = "public/images/team/" . $file_name;
            } else {
                unset($data["member_photo"]);
            }

            if (empty($data["member_id"])) {
                $this->TeamModel->insert($data);
            } else {
                $member_id = $data["member_id"];
                unset($data["member_id"]);
                $this->TeamModel->update($member_id, $data);
            }
        }

        echo json_encode($json);
    }

    public function editMember()
    {
        if (!$this->input->is_ajax_request()) {
            exit("Não permitido");
        }

        $json = array();
        $json["input"] = array();

        $member_id = $this->input->post("member_id");

        $data = $this->TeamModel->getData($member_id)->result_array()[0];

        $json["input"]["member_id"] = $data["member_id"];
        $json["input"]["member_name"] = $data["member_name"];
        $json["input"]["member_description"] = $data["member_description"];

        if ($data["member_photo"]) {
            $json["img"]["member_photo"] = base_url() . $data["member_photo"];
        } else {
            $json["img"]["member_photo"] = "";
        }

        echo json_encode($json);
    }

    public function deleteMember()
    {
        if (!$this->input->is_ajax_request()) {
            exit("Não permitido");
        }

        $json = array();
        $json["input"] = array();

        $member_id = $this->input->post("member_id");

        $this->TeamModel->delete($member_id);

        echo json_encode($json);
    }

    public function listMembers()
    {
        if (!$this->input->is_ajax_request()) {
            exit("Não permitido");
        }

        $team = $this->TeamModel->getDataTable();

        $data = array();

        foreach ($team as $member) {
            $row = array();
            $row[] = $member->member_name;

            if ($member->member_photo) {
                $row[] = '<img src="'.base_url().$member->member_photo.'" class="member-thumbnail">';
            } else {
                $row[] = "";
            }

            $row[] = $member->member_description;

            $row[] = '<div class="action-buttons">
                        <button class="btn btn-primary btn-edit-member" member_id="' . $member->member_id . '">
                            <i class="fa fa-edit" ></i>
                        </button>
                        <button class="btn btn-danger btn-delete-member" member_id="' . $member->member_id . '">
                            <i class="fa fa-trash" ></i>
                        </button>
                    </div>';
            $data[] = $row;
        }

        $json = array(
            "draw" => $this->input->post("draw"),
            "recordsTotal" => $this->TeamModel->recordsTotal(),
            "recordsFiltered" => $this->TeamModel->recordsFiltered(),
            "data" => $data
        );

        echo json_encode($json);
    }
}
