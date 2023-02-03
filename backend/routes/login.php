<?php
header("Access-Control-Allow-Origin: *");
require_once("../controllers/LoginController.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_REQUEST['email'];
  $password = $_REQUEST['password'];

  $login = new Login($email , $password);
  echo json_encode($login->sendUserInfo());
}
