<?php

session_start();

include "config/database.php";


$message="";


if(isset($_POST['login'])){


$email=$_POST['email'];
$password=$_POST['password'];


$result=mysqli_query(
$conn,
"SELECT * FROM users WHERE email='$email'"
);


$user=mysqli_fetch_assoc($result);


if($user && password_verify($password,$user['password'])){
$_SESSION['user_id']=$user['id'];

//$_SESSION['id']=$user['id'];
$_SESSION['role']=$user['role'];
$_SESSION['name']=$user['fullname'];


if($user['role']=="admin"){

header("Location: admin/dashboard.php");

}else{

header("Location: home.php");

}


}else{

$message="Invalid email or password";

}


}

?>


<!DOCTYPE html>
<html>

<head>

<title>
KIDS_PARADISE Login
</title>


<style>


*{

box-sizing:border-box;
font-family:Arial, sans-serif;

}


body{

margin:0;

height:100vh;

display:flex;

justify-content:center;

align-items:center;

background:
linear-gradient(
135deg,
#fff4d6,
#dff6ff
);

}


/* Main box */

.container{

width:900px;

max-width:95%;

background:white;

border-radius:25px;

box-shadow:0 15px 35px rgba(0,0,0,.15);

display:flex;

overflow:hidden;

animation:show .8s ease;

}



@keyframes show{

from{

transform:translateY(-40px);

opacity:0;

}


to{

transform:translateY(0);

opacity:1;

}

}



/* Left side */

.info{

width:45%;

background:#ffc107;

padding:40px;

color:white;

}


.info h1{

font-size:40px;

}


.info p{

font-size:18px;

line-height:1.6;

}



/* Form side */

.form{

width:55%;

padding:40px;

}



.form h2{

text-align:center;

color:#333;

}



input{

width:100%;

padding:14px;

margin:10px 0;

border-radius:10px;

border:1px solid #ddd;

font-size:16px;

}



input:focus{

outline:none;

border-color:#ffc107;

}



button{

width:100%;

padding:14px;

border:none;

border-radius:25px;

background:#ff9800;

color:white;

font-size:18px;

cursor:pointer;

transition:.3s;

}



button:hover{

transform:scale(1.03);

background:#f57c00;

}



.switch{

text-align:center;

margin-top:20px;

}



.switch a{

color:#ff9800;

cursor:pointer;

font-weight:bold;

}



.error{

color:red;

text-align:center;

}



@media(max-width:700px){


.container{

display:block;

}



.info,
.form{

width:100%;

}



.info{

text-align:center;

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
Discover beautiful clothes,
toys and books for your children.
</p>


<p>
Safe shopping. Happy kids.
</p>


</div>



<div class="form">


<h2>
Login
</h2>


<?php echo $message; ?>


<form method="POST" onsubmit="return validateLogin()">



<input 
type="email"
id="email"
name="email"
placeholder="Email address"
required>



<input 
type="password"
id="password"
name="password"
placeholder="Password"
required>



<button name="login">
Login
</button>


</form>



<div class="switch">

Don't have an account?

<a href="register.php">
Create Account
</a>


</div>



</div>



</div>



<script>


function validateLogin(){


let email=
document.getElementById("email").value;


let password=
document.getElementById("password").value;



if(password.length<5){

alert(
"Password must contain at least 5 characters"
);

return false;

}


return true;


}


</script>



</body>

</html>