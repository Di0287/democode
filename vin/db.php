<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

defined('_JEXEC') or die('Restricted access');

	$host     = 'localhost';
    $user     = 'avtomoda_opt';
    $password = '00870202';
    $db     = 'avtomoda_opt';            
    $mysqli = new mysqli($host, $user, $password, $db);
    $mysqli->set_charset("utf8");
    if ($mysqli->connect_errno) {
      echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }