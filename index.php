<?php
include "db.php";
 
$clients = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM clients"))['c'];
$services = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM services"))['c'];
$bookings = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM bookings"))['c'];
 
$revRow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(SUM(amount_paid),0) AS s FROM payments"));
$revenue = $revRow['s'];
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include "nav.php"; ?>

<div class="container">
  <div class="page-header">
    <h2>Dashboard</h2>
    <p>Overview of your business at a glance</p>
  </div>

  <div class="stats-grid">
    <a class="stat-card" href="/assessment_beginner/pages/clients_list.php">
      <div class="label">Total Clients</div>
      <div class="value"><?php echo $clients; ?></div>
      <div class="card-hint">View all clients &rarr;</div>
    </a>
    <a class="stat-card" href="/assessment_beginner/pages/services_list.php">
      <div class="label">Total Services</div>
      <div class="value"><?php echo $services; ?></div>
      <div class="card-hint">View all services &rarr;</div>
    </a>
    <a class="stat-card" href="/assessment_beginner/pages/bookings_list.php">
      <div class="label">Total Bookings</div>
      <div class="value"><?php echo $bookings; ?></div>
      <div class="card-hint">View all bookings &rarr;</div>
    </a>
    <a class="stat-card" href="/assessment_beginner/pages/payments_list.php">
      <div class="label">Total Revenue</div>
      <div class="value">₱<?php echo number_format($revenue,2); ?></div>
      <div class="card-hint">View payments &rarr;</div>
    </a>
  </div>

  <div class="quick-links">
    <a class="btn btn-primary" href="/assessment_beginner/pages/clients_add.php">+ Add Client</a>
    <a class="btn btn-success" href="/assessment_beginner/pages/bookings_create.php">+ Create Booking</a>
  </div>
</div>

<div class="footer">Assessment &copy; 2026</div>

</body>
</html>