<?php 
    $con = new mysqli('localhost','root','','market');

    if(!$con){
        die(mysqli_error($con));
    }
?>