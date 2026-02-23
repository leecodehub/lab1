<?php
include "../db.php";
 
$message = "";
 
if (isset($_POST['save'])) {
  $full_name = $_POST['full_name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $address = $_POST['address'];
 
  if ($full_name == "" || $email == "") {
    $message = "Name and Email are required!";
  } else {
    $sql = "INSERT INTO clients (full_name, email, phone, address)
            VALUES ('$full_name', '$email', '$phone', '$address')";
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
    <title>Add New Client</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<?php include "../nav.php"; ?>

<div class="container">
    <div class="page-header">
        <h2>Add New Client</h2>
        <p>Fill out the information below to register a new client.</p>
    </div>

    <?php if ($message != ""): ?>
        <div class="alert alert-danger"><?php echo $message; ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="form-group">
            <label for="full_name">Full Name*</label>
            <input type="text" name="full_name" id="full_name" placeholder="e.g. John Doe" required>
        </div>

        <div class="form-group">
            <label for="email">Email Address*</label>
            <input type="email" name="email" id="email" placeholder="example@mail.com" required>
        </div>

        <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="text" name="phone" id="phone" placeholder="0912 345 6789">
        </div>

        <div class="form-group">
            <label for="address">Home/Office Address</label>
            <textarea name="address" id="address" rows="3" placeholder="Enter complete address"></textarea>
        </div>

        <div style="margin-top: 30px; display: flex; gap: 10px;">
            <button type="submit" name="save" class="btn btn-primary">Save Client</button>
            <a href="clients_list.php" class="btn" style="background: #94a3b8;">Cancel</a>
        </div>
    </form>
</div>

<div class="footer">Assessment &copy; 2026</div>

</body>
</html>