<?php
require_once "../../models/UserModel.php";

$userModel = new UserModel();

function getAllUsers()
{
    global $userModel;
    return $userModel->getAllUsers();
}

