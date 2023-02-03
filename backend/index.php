<?php

require_once("./model/index.php");
require_once("./utils/conn.php");

if (!$conn->query(USER)) {
  $conn->close();
  die("Can\'t create the table");
}

$conn->close();
