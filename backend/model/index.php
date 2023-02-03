<?php

define("USER", "
  CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT NOT NULL UNIQUE PRIMARY KEY,
    name varchar(255) NOT NULL,
    email varchar(255) NOT NULL UNIQUE,
    password TEXT NOT NULL
  );
");