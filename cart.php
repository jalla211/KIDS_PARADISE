<?php

session_start();

include "config/database.php";


if(!isset($_SESSION['user_id'])){

    header("Location: login.php");
    exit;

}


$user_id = $_SESSION['user_id'];

?>


<!DOCTYPE html>
<html>

<head>

<title>Your Cart - KIDS PARADISE</title>


<style>

body{

    font-family:Segoe UI;
    background:#f5f7ff;
    margin:0;

}


.container{

    width:90%;
    margin:30px auto;

}


h1{

    text-align:center;
    color:#1565C0;

}


.cart-box{

    background:white;
    padding:20px;
    border-radius:15px;
    box-shadow:0 5px 15px rgba(0,0,0,.1);

}


table{

    width:100%;
    border-collapse:collapse;

}


th{

    background:#1565C0;
    color:white;
    padding:12px;

}


td{

    padding:12px;
    text-align:center;
    border-bottom:1px solid #ddd;

}


.product-img{

    width:70px;
    height:70px;
    object-fit:cover;
    border-radius:10px;

}


.qty-btn{

    padding:5px 10px;
    background:#1565C0;
    color:white;
    text-decoration:none;
    border-radius:5px;

}


.remove{

    background:#f44336;
    color:white;
    padding:7px 12px;
    border-radius:5px;
    text-decoration:none;

}


.total{

    text-align:right;
    margin-top:20px;
    font-size:22px;
    font-weight:bold;

}


.checkout{

    display:block;
    width:200px;
    margin:20px auto;
    text-align:center;
    background:#4CAF50;
    color:white;
    padding:12px;
    border-radius:25px;
    text-decoration:none;

}


</style>

</head>


<body>


<div class="container">


<h1>
🛒 My Shopping Cart
</h1>


<div class="cart-box">


<table>


<tr>

<th>Image</th>

<th>Product</th>

<th>Price</th>

<th>Quantity</th>

<th>Total</th>

<th>Action</th>

</tr>



<?php


$total = 0;


$sql = "

SELECT 
cart.id AS cart_id,
products.name,
products.image,
products.price,
cart.quantity

FROM cart

JOIN products

ON cart.product_id = products.id

WHERE cart.user_id='$user_id'

";


$result=mysqli_query($conn,$sql);



while($row=mysqli_fetch_assoc($result)){


$item_total = $row['price'] * $row['quantity'];


$total += $item_total;


?>


<tr>


<td>

<img class="product-img"
src="uploads/<?= $row['image'] ?>">

</td>



<td>

<?= $row['name'] ?>

</td>



<td>

<?= $row['price'] ?>

</td>



<td>


<a class="qty-btn"
href="update_cart.php?action=minus&id=<?= $row['cart_id'] ?>">
-
</a>


<?= $row['quantity'] ?>


<a class="qty-btn"
href="update_cart.php?action=plus&id=<?= $row['cart_id'] ?>">
+
</a>


</td>



<td>

<?= $item_total ?>

</td>



<td>

<a class="remove"
href="update_cart.php?action=remove&id=<?= $row['cart_id'] ?>">
Remove
</a>

</td>


</tr>


<?php } ?>



</table>


<div class="total">

Total:
<?= $total ?>

</div>



<a class="checkout" href="checkout.php">

Proceed To Checkout

</a>


</div>


</div>


</body>

</html>