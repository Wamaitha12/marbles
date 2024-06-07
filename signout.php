<?php

session_start();

$query = session_destroy();

if ($query) {
    echo '<script> alert("Signed Out!") 
    window.location.href="sign-in.php";            
    </script>';
} 
// header("location:sign-in.php");
