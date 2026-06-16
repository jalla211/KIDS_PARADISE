<?php


include "includes_admin.php";

include "../config/database.php";


$id=$_GET['id'];



mysqli_query(
$conn,

"DELETE FROM products WHERE id='$id'"
);



header("Location: products.php");


?>