<?php

session_start();

include "config/database.php";


if(!isset($_SESSION['user_id'])){

    header("Location: login.php");
    exit;

}


$user_id = $_SESSION['user_id'];


// Get user details

$user_query = mysqli_query(
$conn,
"SELECT * FROM users WHERE id='$user_id'"
);

$user = mysqli_fetch_assoc($user_query);



// Calculate total

$total = 0;


$cart_query = mysqli_query(
$conn,

"SELECT 
products.price,
cart.quantity

FROM cart

JOIN products

ON cart.product_id = products.id

WHERE cart.user_id='$user_id'"
);



while($item=mysqli_fetch_assoc($cart_query)){

    $total += $item['price'] * $item['quantity'];

}




if(isset($_POST['checkout'])){


    $address = $_POST['address'];

    $phone = $_POST['phone'];

    $payment = $_POST['payment'];



    /*
        STEP 1:
        CREATE ORDER
    */


    mysqli_query(
    $conn,

    "INSERT INTO orders
    (
    user_id,
    total,
    address,
    phone,
    payment_method,
    status
    )

    VALUES

    (
    '$user_id',
    '$total',
    '$address',
    '$phone',
    '$payment',
    'Pending'
    )"
    );



    // Get generated order ID

    $order_id = mysqli_insert_id($conn);




    /*
        STEP 2:
        SAVE ORDER ITEMS
    */


    $items = mysqli_query(
    $conn,

    "SELECT 
    product_id,
    quantity

    FROM cart

    WHERE user_id='$user_id'"
    );



    while($item=mysqli_fetch_assoc($items)){


        $product_id = $item['product_id'];

        $quantity = $item['quantity'];



        // get price

        $product = mysqli_query(
        $conn,

        "SELECT price 
        FROM products
        WHERE id='$product_id'"
        );


        $p=mysqli_fetch_assoc($product);


        $price=$p['price'];




        mysqli_query(
        $conn,

        "INSERT INTO order_items
        (
        order_id,
        product_id,
        quantity,
        price
        )

        VALUES

        (
        '$order_id',
        '$product_id',
        '$quantity',
        '$price'
        )"
        );


    }




    /*
        STEP 3:
        EMPTY CART
    */


    mysqli_query(
    $conn,

    "DELETE FROM cart
    WHERE user_id='$user_id'"
    );




    echo "

    <script>

    alert('Payment successful! Your order has been placed.');

    window.location='home.php';

    </script>

    ";

}



?>



<!DOCTYPE html>

<html>

<head>

<title>
Checkout - KIDS PARADISE
</title>


<style>


body{

font-family:Segoe UI;
background:#f5f7ff;
margin:0;

}


.box{

width:500px;
margin:40px auto;
background:white;
padding:30px;
border-radius:15px;
box-shadow:0 5px 15px rgba(0,0,0,.1);

}



h2{

text-align:center;
color:#1565C0;

}



input,
select{

width:100%;
padding:12px;
margin:10px 0;
border-radius:8px;
border:1px solid #ddd;

}



.total{

font-size:22px;
font-weight:bold;
color:#1565C0;

}



button{

width:100%;
padding:12px;
background:#4CAF50;
border:none;
color:white;
border-radius:20px;
font-size:16px;
cursor:pointer;

}



button:hover{

background:#388E3C;

}



</style>


</head>


<body>


<div class="box">


<h2>
💳 Checkout
</h2>



<p>
Customer:
<b>
<?= $user['fullname']; ?>
</b>
</p>



<p class="total">

Total:
<?= $total; ?> RWF

</p>




<form method="POST" onsubmit="return confirmPayment()">



<input

type="text"

name="address"

placeholder="Delivery address"

required>



<input

type="text"

name="phone"

placeholder="MTN/Airtel Mobile Money number"

required>




<select name="payment">


<option value="MTN Mobile Money">

MTN Mobile Money

</option>


<option value="Airtel Money">

Airtel Money

</option>


</select>




<button name="checkout">

Pay Now

</button>



</form>


</div>





<script>


function confirmPayment(){


let method =
document.querySelector(
"select[name='payment']"
).value;



let phone =
document.querySelector(
"input[name='phone']"
).value;



let amount =
<?= $total ?>;



return confirm(

"Mobile Money Payment\n\n"

+
"Network: "
+
method

+

"\nPhone: "

+
phone

+

"\nAmount: "

+
amount

+

" RWF\n\nConfirm payment?"

);


}



</script>



</body>

</html>