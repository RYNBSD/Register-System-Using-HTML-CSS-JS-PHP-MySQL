<?php

declare(strict_types=1);
require_once("../utils/filters.php");
require_once("../utils/conn.php");

class SignUp extends Filter {

  private string $name = "";
  private string $email = "";
  private string $password = "";
  //private const VERIFY_EMAIL_SQL = "SELECT * FROM 'users' WHERE email=\'?\' LIMIT 1";
  private const CREATE_USER_SQL = "INSERT INTO `users` (name, email, password) VALUES (?, ?, ?)";

  public function __construct(string $name, string $email, string $password) {
    $this->name = $this->stringSan($name);
    $this->email = $this->stringSan($email);
    $this->password = $this->stringSan($password);
  }

  private function createUser(): bool {
    if (!(strlen($this->name) && strlen($this->email) && strlen($this->password))) {
      return false;
    }

    if (strlen($this->password) < 8) {
      return false;
    }

    if (!$this->verifyEmail($this->email)) {
      return false;
    }

    global $conn;

    $result = $conn->query("SELECT * FROM `users` WHERE email='".$this->email."' LIMIT 1");

    if ($result->num_rows) {
      return false;
    }

    $this->password = $this->hashPassword($this->password);

    $stmt = $conn->prepare(self::CREATE_USER_SQL);
    $stmt->bind_param("sss", $this->name, $this->email, $this->password);


    $created = $stmt->execute();
    $conn->close();
    $stmt->close();

    return $created;
  }

  public function newUser(): string {
    if (!$this->createUser()) {
      http_response_code(400);
      return "Failed to create user";
    }

    return "Successfully created user";
  }
}