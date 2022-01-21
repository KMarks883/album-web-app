<?php

$user = 'markska02';
$pass = 'km2537'; 
$db_info='mysql:host=washington.uww.edu;dbname=cs366-2217_markska02';
try {
    $db = new PDO($db_info, $user, $pass);

} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}


?> 