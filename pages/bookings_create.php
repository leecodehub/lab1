<?php
include "../db.php";
 
$clients = mysqli_query($conn, "SELECT * FROM clients ORDER BY full_name ASC");
$services = mysqli_query($conn, "SELECT * FROM services WHERE is_active=1 ORDER BY service_name ASC");
 
if (isset($_POST['create'])) {
  $client_id = $_POST['client_id'];
  $service_id = $_POST['service_id'];
  $booking_date = $_POST['booking_date'];
  $hours = $_POST['hours'];
 
  // --- Original Logic Maintained ---
  $s = mysqli_fetch_assoc(mysqli_query($conn, "SELECT hourly_rate FROM services WHERE service_id=$service_id"));
  $rate = $s['hourly_rate'];
 
  $total = $rate * $hours;
 
  mysqli_query($conn, "INSERT INTO bookings (client_id, service_id, booking_date, hours, hourly_rate_snapshot, total_cost, status)
    VALUES ($client_id, $service_id, '$booking_date', $hours, $rate, $total, 'PENDING')");
 
  header("Location: bookings_list.php");
  exit;
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>New Booking</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<?php include "../nav.php"; ?>

<div class="container" style="max-width: 600px; margin-top: 50px;">
    <div class="page-header">
        <div>
            <h2>Schedule New Service</h2>
            <p>Create a booking and lock in the current service rates.</p>
        </div>
    </div>

    <form method="post">
        <div class="form-group">
            <label>Select Client</label>
            <select name="client_id" required>
                <option value="" disabled selected>Choose a client...</option>
                <?php while($c = mysqli_fetch_assoc($clients)) { ?>
                    <option value="<?php echo $c['client_id']; ?>"><?php echo htmlspecialchars($c['full_name']); ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group">
            <label>Service Type</label>
            <select name="service_id" required>
                <option value="" disabled selected>Choose a service...</option>
                <?php while($s = mysqli_fetch_assoc($services)) { ?>
                    <option value="<?php echo $s['service_id']; ?>">
                        <?php echo htmlspecialchars($s['service_name']); ?> (₱<?php echo number_format($s['hourly_rate'], 2); ?>/hr)
                    </option>
                <?php } ?>
            </select>
            <small class="helper">The current rate will be saved for this specific booking.</small>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label>Booking Date</label>
                <input type="date" name="booking_date" value="<?php echo date('Y-m-d'); ?>" required>
            </div>

            <div class="form-group">
                <label>Estimated Hours</label>
                <input type="number" name="hours" min="1" step="0.5" value="1" required>
            </div>
        </div>

        <div style="background: #f1f5f9; padding: 15px; border-radius: 10px; margin-bottom: 25px; border-left: 4px solid var(--dark-cyan);">
            <p style="font-size: 0.85rem; color: var(--text-muted);">
                <strong>Note:</strong> Total cost is calculated automatically based on the service rate multiplied by estimated hours.
            </p>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" name="create" class="btn" style="flex: 2;">Confirm Booking</button>
            <a href="bookings_list.php" class="btn" style="flex: 1; background: #e2e8f0; color: #475569; text-align: center; display: flex; align-items: center; justify-content: center;">Back to List</a>
        </div>
    </form>
</div>

<div class="footer" style="text-align: center; margin-top: 30px; color: rgba(255,255,255,0.6);">
    Assessment &copy; 2026
</div>

</body>
</html>