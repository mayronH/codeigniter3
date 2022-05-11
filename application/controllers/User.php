<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("UsersModel");
    }

    public function saveUser()
    {
        if (!$this->input->is_ajax_request()) {
            exit("Não permitido");
        }

        $json = array();
        $json["status"] = 1;
        $json["error_list"] = array();

        $data = $this->input->post();

        if (empty($data["user_login"])) {
            $json["status"] = 0;
            $json["error_list"]["#user_login"] = "Login é obrigatório";
        } else {
            if ($this->UsersModel->isDuplicated("user_login", $data["user_login"], $data["user_id"])) {
                $json["status"] = 0;
                $json["error_list"]["#user_login"] = "Login já existe";
            }
        }

        if (empty($data["user_full_name"])) {
            $json["status"] = 0;
            $json["error_list"]["#user_full_name"] = "Nome do usuário é obrigatório";
        }

        if (empty($data["user_email"])) {
            $json["status"] = 0;
            $json["error_list"]["#user_email"] = "E-mail do usuário é obrigatório";
        } else {
            if ($this->UsersModel->isDuplicated("user_email", $data["user_email"], $data["user_id"])) {
                $json["status"] = 0;
                $json["error_list"]["#user_email"] = "E-mail já cadastrado";
            }
        }

        if (empty($data["user_password"])) {
            $json["status"] = 0;
            $json["error_list"]["#user_password"] = "Senha do usuário é obrigatório";
        }

        if ($data["user_email"] != $data["user_email_confirm"]) {
            $json["status"] = 0;
            $json["error_list"]["#user_email_confirm"] = "E-mails não batem";
        }

        if ($data["user_password"] != $data["user_password_confirm"]) {
            $json["status"] = 0;
            $json["error_list"]["#user_password_confirm"] = "Senhas não batem";
        }

        if ($json["status"] == 1) {
            $data["password_hash"] = password_hash($data["user_password"], PASSWORD_DEFAULT);

            unset($data["user_password"]);
            unset($data["user_email_confirm"]);
            unset($data["user_password_confirm"]);


            if (empty($data["user_id"])) {
                $this->UsersModel->insert($data);
            } else {
                $user_id = $data["user_id"];
                unset($data["user_id"]);
                $this->UsersModel->update($user_id, $data);
            }
        }

        echo json_encode($json);
    }

    public function editUser()
    {
        if (!$this->input->is_ajax_request()) {
            exit("Não permitido");
        }

        $json = array();
        $json["input"] = array();

        $user_id = $this->input->post("user_id");

        $data = $this->UsersModel->getData($user_id)->result_array()[0];

        $json["input"]["user_id"] = $data["user_id"];
        $json["input"]["user_login"] = $data["user_login"];
        $json["input"]["user_full_name"] = $data["user_full_name"];
        $json["input"]["user_email"] = $data["user_email"];
        $json["input"]["user_email_confirm"] = $data["user_email"];
        $json["input"]["user_password"] = $data["password_hash"];
        $json["input"]["user_password_confirm"] = $data["password_hash"];

        echo json_encode($json);
    }

    public function deleteUser()
    {
        if (!$this->input->is_ajax_request()) {
            exit("Não permitido");
        }

        $json = array();
        $json["input"] = array();

        $user_id = $this->input->post("user_id");

        $this->UsersModel->delete($user_id);

        echo json_encode($json);
    }

    public function listUsers()
    {
        if (!$this->input->is_ajax_request()) {
            exit("Não permitido");
        }

        $users = $this->UsersModel->getDataTable();

        $data = array();

        foreach ($users as $user) {
            $row = array();
            $row[] = $user->user_login;


            $row[] = $user->user_full_name;
            $row[] = $user->user_email;

            $row[] = '<div class="action-buttons">
                        <button class="btn btn-primary btn-edit-user" user_id="' . $user->user_id . '">
                            <i class="fa fa-edit" ></i>
                        </button>
                        <button class="btn btn-danger btn-delete-user" user_id="' . $user->user_id . '">
                            <i class="fa fa-trash" ></i>
                        </button>
                    </div>';
            $data[] = $row;
        }

        $json = array(
            "draw" => $this->input->post("draw"),
            "recordsTotal" => $this->UsersModel->recordsTotal(),
            "recordsFiltered" => $this->UsersModel->recordsFiltered(),
            "data" => $data
        );

        echo json_encode($json);
    }
}
