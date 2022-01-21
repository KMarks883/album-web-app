<?php
 
$connection = mysqli_connect('washington.uww.edu', 'markska02', 'km2537', 'cs366-2217_markska02');
 
if($connection === false){
    die("Cannot connect " . mysqli_connect_error());
}
?>