<?php
require_once 'EmptyModel.php';

class User extends EmptyModel {
    public function __construct() {
        parent::__construct('users');
    }
}
?>