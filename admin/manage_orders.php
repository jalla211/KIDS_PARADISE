<?php

include "includes_admin.php";

include "../config/database.php";

?>


<!DOCTYPE html>

<html>

<head>

<title>
Manage Orders - KIDS PARADISE
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


.order-box{

background:white;
margin-bottom:25px;
padding:20px;
border-radius:15px;
box-shadow:0 5px 15px rgba(0,0,0,.1);

}



.order-header{

display:flex;
justify-content:space-between;
flex-wrap:wrap;

}



.info{

line-height:1.8;

}



.status{

padding:6px 15px;
border-radius:20px;
background:#fff3cd;
color:#856404;

}



table{

width:100%;
border-collapse:collapse;
margin-top:20px;

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



.update{

background:#4CAF50;
color:white;
padding:8px 15px;
border-radius:20px;
text-decoration:none;

}



</style>


</head>


<body>


<div class="container">


<h1>
📦 Manage Orders
</h1>




<?php


$orders = mysqli_query(

$conn,

"SELECT 

orders.*,

users.fullname

FROM orders

JOIN users

ON orders.user_id = users.id

ORDER BY orders.id DESC"

);



if(mysqli_num_rows($orders)>0){



while($order=mysqli_fetch_assoc($orders)){


?>



<div class="order-box">


<div class="order-header">


<div class="info">


<h2>
Order #<?= $order['id']; ?>
</h2>


Customer:

<b>
<?= $order['fullname']; ?>
</b>


<br>


Phone:

<?= $order['phone']; ?>


<br>


Address:

<?= $order['address']; ?>


<br>


Payment:

<?= $order['payment_method']; ?>


</div>




<div>


<p class="status">

<?= $order['status']; ?>

</p>


<a class="update"

href="update_order.php?id=<?= $order['id']; ?>">

Update Status

</a>


</div>


</div>





<h3>
Products
</h3>




<table>


<tr>

<th>Image</th>

<th>Name</th>

<th>Quantity</th>

<th>Price</th>

<th>Subtotal</th>

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

ON order_items.product_id = products.id

WHERE order_items.order_id='".$order['id']."'

"

);



while($item=mysqli_fetch_assoc($items)){



?>


<tr>


<td>

<img class="product-img"

src="../uploads/<?= $item['image']; ?>">

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



<td>

<?= $item['price'] * $item['quantity']; ?> RWF

</td>


</tr>



<?php } ?>



</table>




<p class="total">

Total:

<?= $order['total']; ?> RWF

</p>



</div>




<?php


}


}else{


echo "

<h2 style='text-align:center'>

No orders available

</h2>

";


}


?>



</div>


</body>

</html>