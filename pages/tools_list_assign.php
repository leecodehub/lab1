<?php
include "../db.php";
 
$message = "";
 
// ASSIGN TOOL logic remains the same
if (isset($_POST['assign'])) {
  $booking_id = $_POST['booking_id'];
  $tool_id = $_POST['tool_id'];
  $qty = $_POST['qty_used'];
 
  $toolRow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT quantity_available FROM tools WHERE tool_id=$tool_id"));
 
  if ($qty > $toolRow['quantity_available']) {
    $message = "Not enough available tools!";
  } else {
    mysqli_query($conn, "INSERT INTO booking_tools (booking_id, tool_id, qty_used)
      VALUES ($booking_id, $tool_id, $qty)");
 
    mysqli_query($conn, "UPDATE tools SET quantity_available = quantity_available - $qty WHERE tool_id=$tool_id");
 
    $message = "Tool assigned successfully!";
  }
}
 
$tools = mysqli_query($conn, "SELECT * FROM tools ORDER BY tool_name ASC");
$bookings = mysqli_query($conn, "SELECT booking_id FROM bookings ORDER BY booking_id DESC");
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Tools & Inventory Management</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<?php include "../nav.php"; ?>

<div class="container">
    <div class="page-header">
        <div>
            <h2>Tools / Inventory</h2>
            <p>Monitor equipment levels and assign them to active bookings.</p>
        </div>
    </div>

    <?php if ($message != ""): ?>
        <div class="message-box <?php echo ($message == "Tool assigned successfully!") ? 'message-success' : 'message-error'; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <div class="dashboard-grid">
        <div>
            <h3 style="margin-bottom: 15px; font-size: 1.1rem; color: var(--nav-bg);">Available Equipment</h3>
            <table>
                <thead>
                    <tr>
                        <th>Tool Name</th>
                        <th>Total Stock</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($t = mysqli_fetch_assoc($tools)) { ?>
                        <tr>
                            <td style="font-weight: 600;"><?php echo htmlspecialchars($t['tool_name']); ?></td>
                            <td><?php echo $t['quantity_total']; ?></td>
                            <td>
                                <span class="badge badge-tool">
                                    <?php echo $t['quantity_available']; ?> Available
                                </span>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div style="background: #f8fafc; padding: 25px; border-radius: 20px; border: 1px solid var(--border-subtle); height: fit-content;">
            <h3 style="margin-bottom: 15px; font-size: 1.1rem; color: var(--nav-bg);">Assign to Booking</h3>
            <form method="post">
                <div class="form-group">
                    <label>Booking ID</label>
                    <select name="booking_id">
                        <?php while($b = mysqli_fetch_assoc($bookings)) { ?>
                            <option value="<?php echo $b['booking_id']; ?>">Order #<?php echo $b['booking_id']; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Select Tool</label>
                    <select name="tool_id">
                        <?php 
                        $tools2 = mysqli_query($conn, "SELECT * FROM tools ORDER BY tool_name ASC");
                        while($t2 = mysqli_fetch_assoc($tools2)) { ?>
                            <option value="<?php echo $t2['tool_id']; ?>">
                                <?php echo htmlspecialchars($t2['tool_name']); ?> (<?php echo $t2['quantity_available']; ?> left)
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Quantity to Use</label>
                    <input type="number" name="qty_used" min="1" value="1">
                </div>

                <button type="submit" name="assign" class="btn" style="width: 100%;">Assign Now</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>