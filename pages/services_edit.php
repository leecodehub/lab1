<?php
include "../db.php";
$id = $_GET['id'];
 
$get = mysqli_query($conn, "SELECT * FROM services WHERE service_id = $id");
$service = mysqli_fetch_assoc($get);
 
if (isset($_POST['update'])) {
  $name = mysqli_real_escape_string($conn, $_POST['service_name']);
  $desc = mysqli_real_escape_string($conn, $_POST['description']);
  $rate = $_POST['hourly_rate'];
  $active = $_POST['is_active'];
 
  mysqli_query($conn, "UPDATE services
    SET service_name='$name', description='$desc', hourly_rate='$rate', is_active='$active'
    WHERE service_id=$id");
 
  header("Location: services_list.php");
  exit;
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Edit Service</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<?php include "../nav.php"; ?>

<div class="container">
    <div class="page-header">
        <h2>Edit Service</h2>
        <p>Update the pricing and description for <strong><?php echo htmlspecialchars($service['service_name']); ?></strong>.</p>
    </div>

    <form method="post">
        <div class="form-group">
            <label>Service Name</label>
            <input type="text" name="service_name" value="<?php echo htmlspecialchars($service['service_name']); ?>" required>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description" rows="4"><?php echo htmlspecialchars($service['description']); ?></textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label>Hourly Rate (₱)</label>
                <input type="number" step="0.01" name="hourly_rate" value="<?php echo $service['hourly_rate']; ?>">
            </div>

            <div class="form-group">
                <label>Availability</label>
                <select name="is_active">
                    <option value="1" <?php if($service['is_active'] == 1) echo 'selected'; ?>>Active</option>
                    <option value="0" <?php if($service['is_active'] == 0) echo 'selected'; ?>>Inactive</option>
                </select>
            </div>
        </div>

        <div style="margin-top: 20px; display: flex; gap: 10px;">
            <button type="submit" name="update" class="btn">Save Changes</button>
            <a href="services_list.php" class="btn" style="background: #94a3b8;">Cancel</a>
        </div>
    </form>
</div>

<div class="footer">Assessment &copy; 2026</div>
</body>
</html>