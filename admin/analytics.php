<?php
include "includes_admin.php";
include "../config/database.php";

/* COUNTS */
$users = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users"));
$products = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM products"));
$orders = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM orders"));

/* REVENUE */
$revenueQuery = mysqli_query($conn, "SELECT SUM(total) AS total_revenue FROM orders WHERE status != 'Cancelled'");
$revenueData = mysqli_fetch_assoc($revenueQuery);
$revenue = $revenueData['total_revenue'] ?? 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Analytics</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body{
            font-family:Segoe UI;
            background:#f5f7ff;
            margin:0;
        }

        .container{
            padding:30px;
        }

        .cards{
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
            gap:20px;
        }

        .card{
            background:white;
            padding:20px;
            border-radius:15px;
            text-align:center;
            box-shadow:0 5px 15px rgba(0,0,0,0.1);
        }

        .number{
            font-size:30px;
            font-weight:bold;
            color:#1565C0;
        }

        canvas{
            margin-top:40px;
            background:white;
            padding:20px;
            border-radius:15px;
        }
    </style>
</head>

<body>

<div class="container">

    <h2>📊 Admin Analytics Dashboard</h2>

    <!-- CARDS -->
    <div class="cards">

        <div class="card">
            <h3>Users</h3>
            <div class="number"><?= $users ?></div>
        </div>

        <div class="card">
            <h3>Products</h3>
            <div class="number"><?= $products ?></div>
        </div>

        <div class="card">
            <h3>Orders</h3>
            <div class="number"><?= $orders ?></div>
        </div>

        <div class="card">
            <h3>Revenue</h3>
            <div class="number"><?= number_format($revenue,2) ?></div>
        </div>

    </div>

    <!-- CHART -->
    <canvas id="myChart"></canvas>

</div>

<script>
let ctx = document.getElementById('myChart');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Users', 'Products', 'Orders', 'Revenue'],
        datasets: [{
            label: 'System Overview',
            data: [
                <?= $users ?>,
                <?= $products ?>,
                <?= $orders ?>,
                <?= $revenue ?>
            ],
            backgroundColor: [
                '#1565C0',
                '#4CAF50',
                '#FF9800',
                '#E91E63'
            ]
        }]
    }
});
</script>

</body>
</html>