<?php

include "config/database.php";


$message="";
$messageType="";


if(isset($_POST['register'])){


$name = trim($_POST['fullname']);
$email = trim($_POST['email']);
$phone = trim($_POST['phone']);
$address = trim($_POST['address']);
$password = $_POST['password'];
$confirm = $_POST['confirm_password'];



if($password != $confirm){

$message="Passwords do not match";
$messageType="error";


}else{


$check=mysqli_query(
$conn,
"SELECT * FROM users WHERE email='$email'"
);



if(mysqli_num_rows($check)>0){


$message="Email already exists";
$messageType="error";


}else{


$hashed=password_hash(
$password,
PASSWORD_DEFAULT
);



$sql="INSERT INTO users
(fullname,email,phone,address,password)
VALUES
('$name','$email','$phone','$address','$hashed')";


if(mysqli_query($conn,$sql)){


$message="Registration successful! You can now login.";
$messageType="success";


}else{


$message="Registration failed";
$messageType="error";


}


}


}


}



?>



<!DOCTYPE html>

<html>

<head>


<title>
KIDS_PARADISE Register
</title>



<style>


*{

box-sizing:border-box;
font-family:'Segoe UI',sans-serif;

}


body{


margin:0;

min-height:100vh;

display:flex;

justify-content:center;

align-items:center;


background:
linear-gradient(
135deg,
#eef7ff,
#ffffff
);


}




.container{


width:950px;

max-width:95%;

background:white;

border-radius:25px;

box-shadow:
0 15px 40px rgba(0,0,0,.12);

display:flex;

overflow:hidden;

animation:appear .8s;


}



@keyframes appear{


from{

opacity:0;

transform:translateY(40px);

}


to{

opacity:1;

transform:translateY(0);

}


}





.info{


width:40%;

background:#1565c0;

color:white;

padding:45px;


}




.info h1{


font-size:35px;

margin-bottom:20px;


}



.info p{


line-height:1.7;

font-size:17px;


}




.form{


width:60%;

padding:40px;


}




.form h2{


text-align:center;

color:#1565c0;


}




input,
textarea{


width:100%;

padding:13px;

margin:8px 0;

border:

1px solid #ddd;

border-radius:12px;

font-size:15px;


}




textarea{


resize:none;

height:70px;


}





input:focus,
textarea:focus{


border-color:#1565c0;

outline:none;

}




button{


width:100%;

padding:14px;

border:none;

border-radius:30px;

background:#1565c0;

color:white;

font-size:17px;

cursor:pointer;

transition:.3s;


}



button:hover{


background:#0d47a1;

transform:translateY(-2px);


}




.message{


margin-top:15px;

text-align:center;

padding:12px;

border-radius:12px;

animation:slide .6s;


}



.success{


background:#d4edda;

color:#155724;


}



.error{


background:#f8d7da;

color:#721c24;


}





@keyframes slide{


from{

opacity:0;

transform:translateY(20px);

}


to{

opacity:1;

transform:translateY(0);

}


}





.switch{


text-align:center;

margin-top:20px;


}


.switch a{


color:#1565c0;

font-weight:bold;

text-decoration:none;


}




@media(max-width:700px){



.container{

display:block;

}



.info,
.form{


width:100%;


}


}



</style>


</head>



<body>



<div class="container">



<div class="info">


<h1>
🧸 KIDS_PARADISE
</h1>


<p>
Create your account and discover amazing products for your children.
</p>


<p>
👕 Clothes
<br>
🧸 Toys
<br>
📚 Books
</p>


</div>




<div class="form">


<h2>
Create Account
</h2>




<form method="POST" onsubmit="return validateRegister()">



<input 
type="text"
id="fullname"
name="fullname"
placeholder="Full Name"
required>



<input 
type="email"
id="email"
name="email"
placeholder="Email Address"
required>




<input 
type="text"
id="phone"
name="phone"
placeholder="Phone Number"
required>




<textarea
name="address"
placeholder="Delivery Address"
required></textarea>




<input
type="password"
id="password"
name="password"
placeholder="Password"
required>




<input
type="password"
id="confirm_password"
name="confirm_password"
placeholder="Confirm Password"
required>





<button name="register">

Register

</button>



</form>



<?php if($message!=""){ ?>

<div class="message <?php echo $messageType; ?>">

<?php echo $message; ?>

</div>

<?php } ?>





<div class="switch">


Already have account?

<a href="login.php">

Login

</a>


</div>



</div>




</div>





<script>


function validateRegister(){


let password=
document.getElementById("password").value;


let confirm=
document.getElementById("confirm_password").value;



if(password.length < 6){


alert(
"Password must contain at least 6 characters"
);


return false;


}



if(password !== confirm){


alert(
"Passwords do not match"
);


return false;


}


return true;


}



</script>




</body>


</html>