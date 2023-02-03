<?php

declare(strict_types=1);

class Filter {

  private const emailValidatorPattern = "/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix";

  protected function stringSan(string $str): string {
    $str = trim($str);
    $str = addslashes($str);
    $str = filter_var($str, FILTER_SANITIZE_STRING);

    return $str;
  }

  protected function hashPassword(string $password): string|null {

    $password = $this->stringSan($password);

    if (strlen($password) < 8) {
      return null;
    }

    return password_hash($password, PASSWORD_BCRYPT);
  }

  protected function verifyPassword (string $password, string $hash): bool {

    $password = $this->stringSan($password);

    return password_verify($password, $hash);
  }

  protected function verifyEmail(string $email): bool {
    return preg_match(self::emailValidatorPattern, $email) > 0;
  }
}
