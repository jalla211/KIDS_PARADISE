<?php

session_start();

include "config/database.php";


if(!isset($_SESSION['user_id'])){

    header("Location: login.php");
    exit;

}


$user_id = $_SESSION['user_id'];



if(isset($_GET['action']) && isset($_GET['id'])){


    $action = $_GET['action'];

    $cart_id = $_GET['id'];



    // PLUS QUANTITY

    if($action == "plus"){


        mysqli_query(
            $conn,
            "UPDATE cart 
             SET quantity = quantity + 1
             WHERE id='$cart_id'
             AND user_id='$user_id'"
        );


    }



    // MINUS QUANTITY

    elseif($action == "minus"){



        // check current quantity

        $check = mysqli_query(
            $conn,
            "SELECT quantity FROM cart
             WHERE id='$cart_id'
             AND user_id='$user_id'"
        );


        $row = mysqli_fetch_assoc($check);



        if($row['quantity'] > 1){


            mysqli_query(
                $conn,
                "UPDATE cart
                 SET quantity = quantity - 1
                 WHERE id='$cart_id'
                 AND user_id='$user_id'"
            );


        }else{


            // if quantity reaches zero remove

            mysqli_query(
                $conn,
                "DELETE FROM cart
                 WHERE id='$cart_id'
                 AND user_id='$user_id'"
            );


        }


    }




    // REMOVE PRODUCT

    elseif($action == "remove"){


        mysqli_query(
            $conn,
            "DELETE FROM cart
             WHERE id='$cart_id'
             AND user_id='$user_id'"
        );


    }



}



header("Location: cart.php");

exit;


?>