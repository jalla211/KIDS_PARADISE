<?php

session_start();

include "config/database.php";


$cart_count = 0;


// CART NUMBER

if(isset($_SESSION['user_id'])){

    $user_id = $_SESSION['user_id'];


    $cart_result = mysqli_query(
        $conn,
        "SELECT SUM(quantity) AS total 
         FROM cart 
         WHERE user_id='$user_id'"
    );


    $cart_data = mysqli_fetch_assoc($cart_result);


    if($cart_data['total'] != NULL){

        $cart_count = $cart_data['total'];

    }

}



// SEARCH

$search = "";

if(isset($_GET['search'])){

    $search = $_GET['search'];

}



// CATEGORY

$category = "";

if(isset($_GET['category'])){

    $category = $_GET['category'];

}



?>


<!DOCTYPE html>

<html>

<head>

<title>KIDS PARADISE</title>


<style>


body{

font-family:Segoe UI,Arial;

margin:0;

background:#f4f6fb;

}


/* NAVBAR */

.navbar{

background:#1565C0;

color:white;

display:flex;

justify-content:space-between;

align-items:center;

padding:10px 18px;

position:sticky;

top:0;

z-index:100;

}



.logo{

font-size:18px;

font-weight:bold;

}



.menu{

display:flex;

gap:12px;

align-items:center;

}



.menu a{

color:white;

text-decoration:none;

font-size:14px;

}


/* DROPDOWN */


.dropdown{

position:relative;

}



.dropdown-content{

display:none;

position:absolute;

background:white;

top:25px;

min-width:160px;

border-radius:8px;

box-shadow:0 5px 15px rgba(0,0,0,.2);

}



.dropdown-content a{

display:block;

padding:10px;

color:black;

}



.dropdown:hover .dropdown-content{

display:block;

}



/* SEARCH */

.search form{

display:flex;

gap:5px;

}


.search input{

padding:7px 12px;

border-radius:20px;

border:none;

width:170px;

}



.search button{

border:none;

background:white;

color:#1565C0;

border-radius:20px;

padding:7px 12px;

cursor:pointer;

}



/* RIGHT */


.right{

display:flex;

gap:10px;

align-items:center;

}



.cart{

color:white;

text-decoration:none;

}



.btn{

padding:6px 12px;

border-radius:20px;

text-decoration:none;

font-size:12px;

}



.login{

background:#4CAF50;

color:white;

}



.logout{

background:#f44336;

color:white;

}



/* PRODUCTS */


.products{

display:grid;

grid-template-columns:repeat(6,150px);

gap:18px;

padding:25px;

justify-content:center;

}



/* CARD */


.card{

width:150px;

background:white;

border-radius:12px;

overflow:hidden;

box-shadow:0 3px 8px rgba(0,0,0,.15);

transition:.3s;

}



.card:hover{

transform:translateY(-5px);

}



.card img{

width:150px;

height:120px;

object-fit:cover;

}



.card h4{

margin:8px;

font-size:13px;

}



.card p{

margin:8px;

font-size:11px;

height:35px;

overflow:hidden;

}



.category{

margin:8px;

font-size:11px;

color:#777;

}



.price{

margin:8px;

font-weight:bold;

color:#1565C0;

}



.stock{

margin:8px;

font-size:11px;

}



.btn-cart{

display:block;

background:#1565C0;

color:white;

text-align:center;

padding:8px;

text-decoration:none;

font-size:12px;

}



.btn-cart:hover{

background:#0D47A1;

}



.empty{

text-align:center;

font-size:20px;

color:#777;

}



</style>


</head>



<body>



<div class="navbar">


<div class="logo">

🧸 KIDS PARADISE

</div>




<div class="menu">


<a href="home.php">
Home
</a>



<div class="dropdown">


<a href="#">
Categories ▾
</a>


<div class="dropdown-content">


<?php

$cat=mysqli_query($conn,"SELECT * FROM categories");


while($c=mysqli_fetch_assoc($cat)){


?>


<a href="home.php?category=<?=$c['id']?>">

<?=$c['name']?>

</a>


<?php } ?>


</div>


</div>



<a href="about.php">
About
</a>


<a href="contact.php">
Contact
</a>



<a href="my_orders.php">
Track Orders
</a>


</div>




<div class="search">


<form method="GET" action="home.php">


<input 

type="text"

name="search"

placeholder="Search products..."

value="<?=htmlspecialchars($search)?>"



>


<button>

🔍

</button>


</form>


</div>





<div class="right">


<a href="cart.php" class="cart">

🛒 Cart (<?=$cart_count?>)

</a>



<?php if(isset($_SESSION['user_id'])){ ?>


<a href="logout.php" class="btn logout">

Logout

</a>


<?php }else{ ?>


<a href="login.php" class="btn login">

Login

</a>


<?php } ?>


</div>


</div>





<div class="products">


<?php


$sql="

SELECT 

products.*,

categories.name AS category_name


FROM products


LEFT JOIN categories

ON products.category_id=categories.id


WHERE 1

";



if($category!=""){


$sql.=" AND products.category_id='$category'";


}



if($search!=""){


$sql.=" AND (

products.name LIKE '%$search%'

OR products.description LIKE '%$search%'

OR categories.name LIKE '%$search%'

)";


}



$sql.=" ORDER BY products.id DESC";



$result=$conn->query($sql);



if($result && $result->num_rows>0){



while($row=$result->fetch_assoc()){


?>



<div class="card">



<img src="uploads/<?=$row['image']?>">



<h4>

<?=$row['name']?>

</h4>



<p>

<?=$row['description']?>

</p>



<div class="category">

<?=$row['category_name']?>

</div>



<div class="price">

<?=$row['price']?> RWF

</div>



<div class="stock">

Stock: <?=$row['stock']?>

</div>



<a href="add_to_cart.php?id=<?=$row['id']?>" class="btn-cart">

Add to Cart

</a>



</div>



<?php


}


}else{


?>


<div class="empty">

No products found

</div>


<?php

}


?>



</div>



</body>


</html>