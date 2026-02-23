<?php
include "../db.php";
 
$id = $_GET['id'];
 
$get = mysqli_query($conn, "SELECT * FROM clients WHERE client_id = $id");
$client = mysqli_fetch_assoc($get);
 
$message = "";
 
if (isset($_POST['update'])) {
  $full_name = $_POST['full_name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $address = $_POST['address'];
 
  if ($full_name == "" || $email == "") {
    $message = "Name and Email are required!";
  } else {
    // Sanitizing inputs is recommended for security
    $full_name = mysqli_real_escape_string($conn, $full_name);
    $email = mysqli_real_escape_string($conn, $email);
    $phone = mysqli_real_escape_string($conn, $phone);
    $address = mysqli_real_escape_string($conn, $address);

    $sql = "UPDATE clients
            SET full_name='$full_name', email='$email', phone='$phone', address='$address'
            WHERE client_id=$id";
    mysqli_query($conn, $sql);
    header("Location: clients_list.php");
    exit;
  }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Client</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<?php include "../nav.php"; ?>

<div class="container">
    <div class="page-header">
        <h2>Edit Client Details</h2>
        <p>Update the information for <strong><?php echo htmlspecialchars($client['full_name']); ?></strong>.</p>
    </div>

    <?php if ($message != ""): ?>
        <div class="alert alert-danger"><?php echo $message; ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="form-group">
            <label>Full Name*</label>
            <input type="text" name="full_name" value="<?php echo htmlspecialchars($client['full_name']); ?>" required>
        </div>

        <div class="form-group">
            <label>Email Address*</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($client['email']); ?>" required>
        </div>

        <div class="form-group">
            <label>Phone Number</label>
            <input type="text" name="phone" value="<?php echo htmlspecialchars($client['phone']); ?>">
        </div>

        <div class="form-group">
            <label>Home/Office Address</label>
            <textarea name="address" rows="3"><?php echo htmlspecialchars($client['address']); ?></textarea>
        </div>

        <div style="margin-top: 30px; display: flex; gap: 10px;">
            <button type="submit" name="update" class="btn">Update Information</button>
            <a href="clients_list.php" class="btn" style="background: #94a3b8;">Cancel</a>
        </div>
    </form>
</div>

<div class="footer">Assessment &copy; 2026</div>

</body>
</html>