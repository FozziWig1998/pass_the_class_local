<?php

/**
  * Configuration for database connection
  *
  */

$host       = "192.168.101.40:8889";
$username   = "root";
$password   = "root";
$dbname     = "pass_the_class"; // will use later
$dsn        = "mysql:host=$host;dbname=$dbname"; // will use later
$options    = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
              );
