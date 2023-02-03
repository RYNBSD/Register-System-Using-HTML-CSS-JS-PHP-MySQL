<?php

declare(strict_types=1);
require_once("../utils/filters.php");
require_once("../utils/conn.php");

class Login extends Filter {
  private string $email = "";
  private string $password = "";
  private array $userInfo = array();

  public function __construct(string $email, string $password) {
    $this->email = $this->stringSan($email);
    $this->password = $this->stringSan($password);
  }

  private function checkUser(): bool {
    if (!$this->verifyEmail($this->email)) {
      return false;
    }
    
    global $conn;
    $result = $conn->query("SELECT * FROM `users` WHERE email='".$this->email."' LIMIT 1");

    if (!$result->num_rows) {
      return false;
    }

    $result = $result->fetch_assoc();

    if (!($this->verifyPassword($this->password, $result['password']) && $this->email === $result['email'])) {
      return false;
    }

    $conn->close();
    $this->userInfo = $result;
    return true;
  }

  public function sendUserInfo(): string|array {
    if (!$this->checkUser()) {
      http_response_code(400);
      return "Invalid email or password.";
    }

    return $this->userInfo;
  }
}