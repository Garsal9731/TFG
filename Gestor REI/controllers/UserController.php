<?php
require_once __DIR__ . '/../models/User.php';

class UserController {

    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function index() {
        $users = $this->userModel->getAll();
        require 'views/user_list.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->userModel->create(['name' => $_POST['name']]);
            header('Location: index.php?route=user/index');
        } else {
            require 'views/user_create.php';
        }
    }

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->userModel->update(['name' => $_POST['name']], $id);
            header('Location: index.php?route=user/index');
        } else {
            $user = $this->userModel->getById($id);
            require 'views/user_edit.php';
        }
    }

    public function delete($id) {
        $this->userModel->delete($id);
        header('Location: index.php?route=user/index');
    }
}
