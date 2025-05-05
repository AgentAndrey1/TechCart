<?php
session_start();

// Check if user is logged in or is a guest
$is_guest = isset($_SESSION['role']) && $_SESSION['role'] === 'guest';
$authenticated = isset($_SESSION['user_id']);

if (!$authenticated && !$is_guest) {
    header("Location: login.php");
    exit();
}

$username = $is_guest ? 'Guest' : ($_SESSION['username'] ?? 'User');
$total_sales = 0.00; // Placeholder for now

// Logout logic
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>Dashboard</title>
  <style>
    body {
      margin: 0;
      font-family: 'Inter', sans-serif;
      background-color: #f5f5f5;
    }

    .dashboard {
      display: flex;
      min-height: 100vh;
    }

    .sidebar {
      width: 75px;
      background-color: rgb(44, 147, 135);
      display: flex;
      flex-direction: column;
      align-items: center;
      padding-top: 70px;
      position: relative;
    }

    .sidebar img {
      width: 40px;
      height: 40px;
      margin: 15px 0;
    }

    .main-content {
      flex: 1;
      display: flex;
      flex-direction: column;
    }

    .top-bar {
      height: 60px;
      background-color: #1a675e;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 20px;
      color: #ffffff;
    }

    .top-bar .title {
      font-size: 24px;
      font-weight: 700;
    }

    .top-bar .user-icon {
      width: 40px;
      height: 40px;
      background-color: #ffffff;
      border-radius: 50%;
      cursor: pointer;
    }

    .welcome-section {
      padding: 20px;
      font-size: 32px;
      font-weight: 900;
      color: #333333;
    }

    .cards-section {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      padding: 20px;
    }

    .card {
      background-color: #ffffff;
      border-radius: 10px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
      flex: 1;
      min-width: 300px;
      padding: 20px;
    }

    .card h2 {
      margin-top: 0;
      font-size: 20px;
      color: #359a92;
    }

    .card .value {
      font-size: 36px;
      font-weight: 700;
      color: #333333;
    }

    .chart-section {
      padding: 20px;
    }

    .chart-section h2 {
      color: #359a92;
      font-size: 24px;
      margin-bottom: 10px;
    }

    .image-section {
      padding: 15px;
    }

    .image-section img {
      width: 35%;
      border-radius: 10px;
    }

    @media (max-width: 768px) {
      .cards-section {
        flex-direction: column;
      }
    }

    .logout-btn {
      background-color: #1a675e;
      color: white;
      border: solid 1px;
      padding: 8px 12px;
      font-size: 13px;
      cursor: pointer;
      border-radius: 5px;
      position: absolute;
      bottom: 747px;
      right: -1115px;
    }

    .logout-btn:hover {
      background-color: #45a049;
    }
  </style>
  <!-- Chart.js CDN -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
  <div class="dashboard">
    <div class="sidebar">
      <!-- Updated sidebar with clickable icons -->
      <a href="sales.php"><img src="img/Group.svg" alt="Sales" title="Sales"></a>
      <a href="items.php"><img src="img/gg_list.svg" alt="Item List" title="Item List"></a>
      <a href="categories.php"><img src="img/carbon_categories.svg" alt="Categories" title="Categories"></a>
      <a href="inventory.php"><img src="img/material-symbols_inventory-2-outline-rounded.svg" alt="Inventory" title="Inventory"></a>

      <!-- Log out form -->
      <form method="POST" style="width: 100%;">
        <button type="submit" name="logout" class="logout-btn">Log Out</button>
      </form>
    </div>

    <div class="main-content">
      <div class="top-bar">
        <div class="title">Dashboard</div>
        <!-- Added the user icon clickable section -->
        <div class="user-icon" onclick="window.location.href='profile.php'">
          <img src="img/codicon_account.svg" alt="Profile">
        </div>
      </div>

      <div class="welcome-section">
        Welcome, <?= htmlspecialchars($username) ?>!
      </div>

      <div class="cards-section">
        <div class="card">
          <h2>Total Sales</h2>
          <div class="value">₱<?= number_format($total_sales, 2) ?></div>
        </div>
        <div class="card">
          <h2>Top Products</h2>
          <div class="value">Coming Soon</div>
        </div>
        <div class="card">
          <h2>Hourly Sales</h2>
          <div class="value">Coming Soon</div>
        </div>
      </div>

      <!-- Chart section -->
      <div class="chart-section">
        <h2>Monthly Sales Report</h2>
        <canvas id="monthlySalesChart" height="100"></canvas>
      </div>
    </div>
  </div>

  <!-- Chart script -->
  <script>
    const ctx = document.getElementById('monthlySalesChart').getContext('2d');
    const chart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [{
          label: 'Monthly Sales (₱)',
          data: [1200, 1900, 3000, 2500, 3200, 4100, 3700, 4200, 3900, 4600, 5200, 6100], // sample data
          backgroundColor: 'rgba(26, 103, 94, 0.6)',
          borderColor: '#1a675e',
          borderWidth: 2
        }]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  </script>
</body>
</html>
