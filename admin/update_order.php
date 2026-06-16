<?php

include "includes_admin.php";
include "../config/database.php";


// Check if ID exists
if (!isset($_GET['id'])) {
    die("Order ID missing");
}

$id = $_GET['id'];


// Fetch order
$sql = "SELECT * FROM orders WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Order not found");
}

$order = $result->fetch_assoc();


// Update status
if (isset($_POST['update'])) {

    $status = $_POST['status'];


    // 1. Update order status
    $update = "UPDATE orders SET status='$status' WHERE id=$id";


    if ($conn->query($update)) {


        // 2. Get user_id of this order
        $order_user = mysqli_fetch_assoc(
            mysqli_query(
                $conn,
                "SELECT user_id FROM orders WHERE id='$id'"
            )
        );

        $user_id = $order_user['user_id'];


        // 3. Create message based on status
        $message = "";

        if ($status == "Approved") {
            $message = "Your order #$id has been approved and is being prepared.";
        }
        elseif ($status == "Delivered") {
            $message = "Good news! Your order #$id has been delivered.";
        }
        elseif ($status == "Cancelled") {
            $message = "Your order #$id has been cancelled. Please contact support.";
        }
        else {
            $message = "Your order #$id status changed to: $status";
        }


        // 4. Insert notification
        mysqli_query(
            $conn,
            "INSERT INTO notifications
            (user_id, message, status)
            VALUES
            ('$user_id', '$message', 'unread')"
        );


        echo "<script>
        alert('Order updated successfully');
        window.location.href='manage_orders.php';
        </script>";

    } else {
        echo "Error updating order";
    }
}

?>


<h2>Update Order Status</h2>

<form method="POST">

    <label>Order ID:</label>
    <input type="text" value="<?= $order['id'] ?>" disabled><br><br>

    <label>Current Status:</label>
    <b><?= $order['status'] ?></b><br><br>

    <label>Change Status:</label>
    <select name="status" required>
        <option value="Pending" <?= $order['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
        <option value="Approved" <?= $order['status'] == 'Approved' ? 'selected' : '' ?>>Approved</option>
        <option value="Delivered" <?= $order['status'] == 'Delivered' ? 'selected' : '' ?>>Delivered</option>
        <option value="Cancelled" <?= $order['status'] == 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
    </select>

    <br><br>

    <button type="submit" name="update">Update Order</button>

</form>