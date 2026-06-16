<?php

$conn = mysqli_connect(
    "database",
    "kids_user",
    "kids_password",
    "kids_paradise_db"
);

if(!$conn){
    die("Database connection failed: " . mysqli_connect_error());
}

?>