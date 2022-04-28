<?php
include_once 'include/dbinstall.php';
try {
    $baseName = BASE_NAME;
    $db = getBase("");

    echo "Connecting to server.<br/>";
    //If DB not exists than create it
    if (!$db->select_db($baseName)) {
        $db->query("CREATE DATABASE `$baseName`");
        if ($db->errno) throw new Exception($db->error);
        echo "Base created.<br/>";
        $db->select_db($baseName);
        if ($db->errno) throw new Exception($db->error);
        echo "Base selected.<br/>";
    }
    $db->query("CREATE TABLE `$baseName`.`user` (
		`user` VARCHAR(50) NOT NULL, 
		`pass` TINYTEXT NULL, 
		PRIMARY KEY (`user`),
		UNIQUE INDEX `user` (`user`))
		COLLATE=`utf8_general_ci` ENGINE=InnoDB");

    if ($db->errno) throw new Exception($db->error);
    echo "Table create.<br/>";
    echo "All done.";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "<br/>";
}
?>
