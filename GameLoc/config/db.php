<?php
define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
define('DB', 'wf3_team');

$db_options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
);

try {
  $pdo = new PDO('mysql:host='.HOST.';dbname='.DB, USER, PASS, $db_options);
} catch (Exception $e) {
  $errorMsg = $e->getMessage();
  die("$errorMsg");
}

?>