<?php
// *** Need set real values for the DB
define("BASE_IP", "localhost");
define("BASE_USER", "username");
define("BASE_PASS", " ");
define("BASE_NAME", "basename");

function getBase($base = BASE_NAME)
{
    $db = new mysqli(BASE_IP, BASE_USER, BASE_PASS, $base);
    if ($db->connect_errno) throw new Exception($db->connect_error);
    $db->query("SET CHARACTER SET utf8");
    $db->query("SET NAMES 'utf8'");
    return $db;
}

?>