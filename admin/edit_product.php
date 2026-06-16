<?php


include "includes_admin.php";

include "../config/database.php";



$id=$_GET['id'];



$product=mysqli_fetch_assoc(

mysqli_query(
$conn,

"SELECT * FROM products WHERE id='$id'"

)

);



$message="";



if(isset($_POST['update'])){


$name=$_POST['name'];

$category=$_POST['category'];

$description=$_POST['description'];

$price=$_POST['price'];

$stock=$_POST['stock'];



/* Check image update */


if($_FILES['image']['name']!=""){


$image=$_FILES['image']['name'];

$tmp=$_FILES['image']['tmp_name'];


move_uploaded_file(
$tmp,

"../uploads/".$image
);



$sql="UPDATE products SET

category_id='$category',

name='$name',

description='$description',

price='$price',

stock='$stock',

image='$image'


WHERE id='$id'";


}else{


$sql="UPDATE products SET

category_id='$category',

name='$name',

description='$description',

price='$price',

stock='$stock'


WHERE id='$id'";


}



if(mysqli_query($conn,$sql)){


$message="Product updated successfully";



$product=mysqli_fetch_assoc(

mysqli_query(
$conn,

"SELECT * FROM products WHERE id='$id'"

)

);


}



}



?>



<!DOCTYPE html>

<html>

<head>

<title>
Edit Product
</title>


<style>


body{

margin:0;

font-family:'Segoe UI';

background:#F5FAFF;

}



.container{

width:650px;

max-width:90%;

margin:40px auto;

background:white;

padding:35px;

border-radius:20px;

box-shadow:
0 10px 30px rgba(0,0,0,.1);

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

border:1px solid #ddd;

border-radius:10px;


}



textarea{

height:100px;

}



button{


width:100%;

padding:15px;

background:#1565C0;

border:none;

border-radius:25px;

color:white;

font-size:17px;

cursor:pointer;

}



button:hover{

background:#0D47A1;

}



.message{


background:#d4edda;

color:#155724;

padding:12px;

border-radius:10px;

text-align:center;

margin-bottom:15px;

animation:show .5s;

}




@keyframes show{


from{

opacity:0;

transform:translateY(-20px);

}


to{

opacity:1;

transform:translateY(0);

}


}




.current img{


width:120px;

height:120px;

object-fit:cover;

border-radius:15px;

}




</style>



</head>


<body>



<div class="container">


<h2>
Edit Product
</h2>



<?php if($message!=""){ ?>

<div class="message">

<?php echo $message; ?>

</div>

<?php } ?>





<form method="POST" enctype="multipart/form-data">



<input

type="text"

name="name"

value="<?php echo $product['name']; ?>"

required>



<select name="category">



<?php


$cats=mysqli_query(
$conn,

"SELECT * FROM categories"

);



while($cat=mysqli_fetch_assoc($cats)){


?>


<option

value="<?php echo $cat['id']; ?>"

<?php

if($cat['id']==$product['category_id'])

echo "selected";

?>


>

<?php echo $cat['name']; ?>

</option>



<?php } ?>



</select>





<textarea

name="description"

required>

<?php echo $product['description']; ?>

</textarea>





<input

type="number"

name="price"

value="<?php echo $product['price']; ?>"

required>




<input

type="number"

name="stock"

value="<?php echo $product['stock']; ?>"

required>




<div class="current">

<p>
Current Image
</p>


<img src="../uploads/<?php echo $product['image']; ?>">


</div>




<p>
Change Image (Optional)
</p>


<input

type="file"

name="image"

accept="image/*">





<button name="update">

Update Product

</button>



</form>



</div>



</body>

</html>