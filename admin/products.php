<?php

include "includes_admin.php";

include "../config/database.php";


$result=mysqli_query(
$conn,

"SELECT products.*, categories.name AS category_name

FROM products

JOIN categories

ON products.category_id=categories.id"

);


?>


<!DOCTYPE html>

<html>

<head>

<title>
Manage Products
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



.top{

display:flex;

justify-content:space-between;

align-items:center;

margin-bottom:25px;

}



.top a{

background:#1565C0;

color:white;

padding:12px 20px;

border-radius:25px;

text-decoration:none;

}



table{

width:100%;

background:white;

border-collapse:collapse;

border-radius:15px;

overflow:hidden;

box-shadow:0 10px 25px rgba(0,0,0,.1);

}



th{

background:#1565C0;

color:white;

padding:15px;

}



td{

padding:15px;

text-align:center;

border-bottom:1px solid #eee;

}



img{

width:80px;

height:80px;

object-fit:cover;

border-radius:10px;

}



.edit{

background:#FFB300;

color:white;

padding:8px 15px;

border-radius:20px;

text-decoration:none;

}



.delete{

background:#d32f2f;

color:white;

padding:8px 15px;

border-radius:20px;

text-decoration:none;

}



@media(max-width:700px){


table{

font-size:12px;

}


}



</style>


</head>


<body>



<div class="header">


<h1>
Manage Products
</h1>


</div>



<div class="container">


<div class="top">


<h2>
All Products
</h2>


<a href="add_product.php">
+ Add Product
</a>


</div>



<table>


<tr>

<th>
Image
</th>


<th>
Name
</th>


<th>
Category
</th>


<th>
Price
</th>


<th>
Stock
</th>


<th>
Actions
</th>


</tr>



<?php while($row=mysqli_fetch_assoc($result)){ ?>



<tr>


<td>


<img src="../uploads/<?php echo $row['image']; ?>">


</td>


<td>

<?php echo $row['name']; ?>

</td>


<td>

<?php echo $row['category_name']; ?>

</td>


<td>

<?php echo number_format($row['price']); ?> RWF

</td>



<td>

<?php echo $row['stock']; ?>

</td>



<td>


<a class="edit"

href="edit_product.php?id=<?php echo $row['id']; ?>">

Edit

</a>


<br><br>


<a class="delete"

onclick="return confirm('Delete this product?')"

href="delete_product.php?id=<?php echo $row['id']; ?>">

Delete

</a>



</td>


</tr>



<?php } ?>



</table>


</div>


</body>

</html>