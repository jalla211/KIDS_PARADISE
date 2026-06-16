<?php

include "includes_admin.php";

include "../config/database.php";


$users=mysqli_num_rows(
mysqli_query($conn,"SELECT * FROM users")
);


$products=mysqli_num_rows(
mysqli_query($conn,"SELECT * FROM products")
);


$orders=mysqli_num_rows(
mysqli_query($conn,"SELECT * FROM orders")
);


?>


<!DOCTYPE html>

<html>

<head>

<title>
Admin Dashboard
</title>


<style>


body{

margin:0;

font-family:'Segoe UI';

background:#F5FAFF;

}


.header{

background:#1565C0;

color:white;

padding:25px;

text-align:center;

}



.container{

padding:30px;

}



.cards{

display:grid;

grid-template-columns:
repeat(auto-fit,minmax(200px,1fr));

gap:20px;

}



.card{


background:white;

padding:25px;

border-radius:20px;

box-shadow:
0 8px 20px rgba(0,0,0,.1);

text-align:center;

transition:.3s;


}



.card:hover{

transform:translateY(-5px);

}



.number{

font-size:35px;

font-weight:bold;

color:#1565C0;

}



.menu{


margin-top:30px;

display:flex;

gap:15px;

flex-wrap:wrap;


}



.menu a{


background:#1565C0;

color:white;

padding:15px 25px;

border-radius:25px;

text-decoration:none;


}



.menu a:hover{

background:#0D47A1;

}



</style>


</head>


<body>


<div class="header">


<h1>
KIDS_PARADISE ADMIN PANEL
</h1>


<p>
Welcome <?php echo $_SESSION['name']; ?>
</p>


</div>




<div class="container">


<div class="cards">


<div class="card">

<h3>
Users
</h3>

<div class="number">

<?php echo $users; ?>

</div>

</div>



<div class="card">

<h3>
Products
</h3>

<div class="number">

<?php echo $products; ?>

</div>

</div>




<div class="card">

<h3>
Orders
</h3>

<div class="number">

<?php echo $orders; ?>

</div>

</div>



</div>



<div class="menu">


<a href="add_product.php">
Add Product
</a>


<a href="products.php">
Manage Products
</a>


<a href="manage_orders.php">
Manage Orders
</a>


<a href="../logout.php">
Logout
</a>


<a href="/KIDS_PARADISE/admin/analytics.php">View Analytics</a>

</div>



</div>



</body>

</html>