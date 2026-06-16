<?php
session_start();
include "config/database.php";

if(!isset($_SESSION['user_id'])){
    echo 0;
    exit;
}

$user_id = $_SESSION['user_id'];
$product_id = $_POST['product_id'];

// check if product already in cart
$check = mysqli_query($conn, "
    SELECT * FROM cart 
    WHERE user_id='$user_id' AND product_id='$product_id'
");

if(mysqli_num_rows($check) > 0){

    mysqli_query($conn, "
        UPDATE cart 
        SET quantity = quantity + 1
        WHERE user_id='$user_id' AND product_id='$product_id'
    ");

} else {

    mysqli_query($conn, "
        INSERT INTO cart(user_id, product_id, quantity)
        VALUES('$user_id', '$product_id', 1)
    ");

}

// get updated cart count
$result = mysqli_query($conn, "
    SELECT SUM(quantity) AS total 
    FROM cart 
    WHERE user_id='$user_id'
");

$row = mysqli_fetch_assoc($result);

echo $row['total'] ?? 0;
?>