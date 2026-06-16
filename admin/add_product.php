<?php

include "includes_admin.php";

include "../config/database.php";


$message="";


if(isset($_POST['add'])){


$name=$_POST['name'];

$category=$_POST['category'];

$description=$_POST['description'];

$price=$_POST['price'];

$stock=$_POST['stock'];



$image=$_FILES['image']['name'];

$tmp=$_FILES['image']['tmp_name'];



$folder="../uploads/".$image;



move_uploaded_file($tmp,$folder);



$sql="INSERT INTO products
(category_id,name,description,price,image,stock)

VALUES

('$category',
'$name',
'$description',
'$price',
'$image',
'$stock')";



if(mysqli_query($conn,$sql)){


$message="Product added successfully";


}else{


$message="Error adding product";


}



}




?>


<!DOCTYPE html>

<html>

<head>

<title>
Add Product
</title>


<style>


body{

margin:0;

font-family:'Segoe UI';

background:#F5FAFF;

}


.container{

width:600px;

max-width:90%;

margin:40px auto;

background:white;

padding:35px;

border-radius:20px;

box-shadow:0 10px 30px rgba(0,0,0,.1);

}



h2{

text-align:center;

color:#1565C0;

}



input,
textarea,
select{


width:100%;

padding:13px;

margin:10px 0;

border-radius:10px;

border:1px solid #ddd;

}



textarea{

height:100px;

}



button{


width:100%;

padding:15px;

border:none;

border-radius:25px;

background:#1565C0;

color:white;

font-size:17px;

cursor:pointer;


}



button:hover{

background:#0D47A1;

}



.success{

background:#d4edda;

color:#155724;

padding:12px;

border-radius:10px;

text-align:center;

}



</style>


</head>


<body>



<div class="container">


<h2>
Add New Product
</h2>



<?php if($message!=""){ ?>

<div class="success">

<?php echo $message; ?>

</div>

<?php } ?>



<form method="POST" enctype="multipart/form-data">



<input

type="text"

name="name"

placeholder="Product Name"

required>



<select name="category" required>


<option value="">
Select Category
</option>


<?php


$result=mysqli_query(
$conn,
"SELECT * FROM categories"
);


while($row=mysqli_fetch_assoc($result)){


echo "

<option value='".$row['id']."'>
".$row['name']."
</option>

";


}


?>


</select>




<textarea

name="description"

placeholder="Product Description"

required></textarea>




<input

type="number"

name="price"

placeholder="Price in RWF"

required>




<input

type="number"

name="stock"

placeholder="Available Quantity"

required>




<input

type="file"

name="image"

accept="image/*"

required>




<button name="add">

Add Product

</button>



</form>


</div>


</body>

</html>