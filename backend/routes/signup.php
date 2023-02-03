<?php
header("Access-Control-Allow-Origin: *");
require_once("../controllers/SignupController.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST')  {
  $name = $_REQUEST['name'];
  $email = $_REQUEST['email'];
  $password = $_REQUEST['password'];

  $login = new SignUp($name, $email , $password);
  echo json_encode($login->newUser());
}
