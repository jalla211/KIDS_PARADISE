<?php

session_start();

include "config/database.php";


if(!isset($_SESSION['user_id'])){

    header("Location: login.php");
    exit;

}


$user_id = $_SESSION['user_id'];



// Mark notifications as read

mysqli_query(
$conn,

"UPDATE notifications

SET status='read'

WHERE user_id='$user_id'"

);



?>


<!DOCTYPE html>

<html>

<head>

<title>
My Orders - KIDS PARADISE
</title>


<style>


body{

font-family:Segoe UI;
background:#f5f7ff;
margin:0;

}



.container{

padding:30px;

}



h1{

text-align:center;
color:#1565C0;

}



.order-card{

background:white;
padding:25px;
margin-bottom:25px;
border-radius:20px;
box-shadow:0 5px 15px rgba(0,0,0,.1);

}



.status{

display:inline-block;
padding:8px 20px;
border-radius:20px;
background:#fff3cd;
color:#856404;
font-weight:bold;

}



table{

width:100%;
border-collapse:collapse;
margin-top:15px;

}



th{

background:#1565C0;
color:white;
padding:10px;

}



td{

padding:10px;
text-align:center;
border-bottom:1px solid #ddd;

}



.product-img{

width:60px;
height:60px;
object-fit:cover;
border-radius:10px;

}



.total{

text-align:right;
font-size:20px;
font-weight:bold;
color:#1565C0;

}



.notification{

background:#e3f2fd;
padding:15px;
margin-top:15px;
border-radius:10px;

}



</style>


</head>



<body>



<div class="container">


<h1>
📦 Track My Orders
</h1>



<?php


$orders=mysqli_query(

$conn,

"SELECT *

FROM orders

WHERE user_id='$user_id'

ORDER BY id DESC"

);



if(mysqli_num_rows($orders)>0){



while($order=mysqli_fetch_assoc($orders)){



?>



<div class="order-card">


<h2>

Order #<?= $order['id']; ?>

</h2>



<p>

Status:

<span class="status">

<?= $order['status']; ?>

</span>

</p>



<p>

Payment:

<b>

<?= $order['payment_method']; ?>

</b>

</p>



<p>

Order Date:

<?= $order['created_at']; ?>

</p>




<h3>
Products
</h3>




<table>


<tr>

<th>Image</th>

<th>Name</th>

<th>Quantity</th>

<th>Price</th>

</tr>



<?php


$items=mysqli_query(

$conn,

"SELECT

order_items.*,

products.name,

products.image


FROM order_items


JOIN products


ON order_items.product_id=products.id


WHERE order_items.order_id='".$order['id']."'"

);



while($item=mysqli_fetch_assoc($items)){


?>



<tr>


<td>

<img class="product-img"

src="uploads/<?= $item['image']; ?>">

</td>


<td>

<?= $item['name']; ?>

</td>



<td>

<?= $item['quantity']; ?>

</td>



<td>

<?= $item['price']; ?> RWF

</td>



</tr>



<?php } ?>


</table>



<p class="total">

Total:

<?= $order['total']; ?> RWF

</p>




<h3>
Updates
</h3>



<?php



$notifications=mysqli_query(

$conn,

"SELECT *

FROM notifications

WHERE user_id='$user_id'

ORDER BY id DESC"

);



if(mysqli_num_rows($notifications)>0){



while($note=mysqli_fetch_assoc($notifications)){


?>



<div class="notification">

<?= $note['message']; ?>


<br>


<small>

<?= $note['created_at']; ?>

</small>


</div>



<?php


}


}else{


echo "No updates yet";


}



?>


</div>



<?php


}


}else{


echo "

<h2 style='text-align:center'>

You have no orders yet

</h2>

";


}



?>


</div>


</body>

</html>