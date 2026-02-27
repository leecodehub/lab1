<?php
include "../db.php";
 
$message = "";
 
if (isset($_POST['save'])) {
  $service_name = $_POST['service_name'];
  $description = $_POST['description'];
  $hourly_rate = $_POST['hourly_rate'];
  $is_active = $_POST['is_active'];
 
  // --- Original Logic Maintained ---
  if ($service_name == "" || $hourly_rate == "") {
    $message = "Service name and hourly rate are required!";
  } else if (!is_numeric($hourly_rate) || $hourly_rate <= 0) {
    $message = "Hourly rate must be a number greater than 0.";
  } else {
    $sql = "INSERT INTO services (service_name, description, hourly_rate, is_active)
            VALUES ('$service_name', '$description', '$hourly_rate', '$is_active')";
    mysqli_query($conn, $sql);
 
    header("Location: services_list.php");
    exit;
  }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Add Service</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<?php include "../nav.php"; ?>

<div class="container" style="max-width: 600px; margin-top: 50px;">
    <div class="page-header">
        <div>
            <h2>Add New Service</h2>
            <p>Create a new offering for your service menu.</p>
        </div>
    </div>

    <?php if ($message != ""): ?>
        <div class="message-box message-error" style="margin-bottom: 20px; color: #991b1b; background: #fef2f2; padding: 10px; border-radius: 8px; border: 1px solid #fee2e2;">
            ⚠️ <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <form method="post">
        <div class="form-group">
            <label>Service Name*</label>
            <input type="text" name="service_name" placeholder="e.g. Graphic Design" required>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description" rows="4" placeholder="Briefly describe what this service includes..."></textarea>
        </div>

        <div class="form-group">
            <label>Hourly Rate (₱)*</label>
            <input type="number" step="0.01" name="hourly_rate" placeholder="0.00" required>
        </div>

        <div class="form-group">
            <label>Availability Status</label>
            <select name="is_active">
                <option value="1">Active (Visible to Clients)</option>
                <option value="0">Inactive (Hidden)</option>
            </select>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 10px;">
            <button type="submit" name="save" class="btn" style="flex: 2;">Save Service</button>
            <a href="services_list.php" class="btn" style="flex: 1; background: #f1f5f9; color: #475569; text-align: center; display: flex; align-items: center; justify-content: center;">Cancel</a>
        </div>
    </form>
</div>

<div class="footer" style="text-align: center; margin-top: 30px; color: rgba(255,255,255,0.6);">
    Assessment &copy; 2026
</div>

</body>
</html>