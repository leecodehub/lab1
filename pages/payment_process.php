<?php
include "../db.php";
 
$booking_id = $_GET['booking_id'];
 
$booking = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM bookings WHERE booking_id=$booking_id"));
 
$paidRow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(SUM(amount_paid),0) AS paid FROM payments WHERE booking_id=$booking_id"));
$total_paid = $paidRow['paid'];
 
$balance = $booking['total_cost'] - $total_paid;
$message = "";
 
if (isset($_POST['pay'])) {
  $amount = $_POST['amount_paid'];
  $method = $_POST['method'];
 
  if ($amount <= 0) {
    $message = "Invalid amount!";
  } else if ($amount > $balance + 0.01) {
    $message = "Amount exceeds balance!";
  } else {
    // 1) Insert payment
    mysqli_query($conn, "INSERT INTO payments (booking_id, amount_paid, method)
      VALUES ($booking_id, $amount, '$method')");
 
    // 2) Recompute total paid
    $paidRow2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(SUM(amount_paid),0) AS paid FROM payments WHERE booking_id=$booking_id"));
    $total_paid2 = $paidRow2['paid'];
 
    // 3) Recompute new balance and update status if finished
    if (($booking['total_cost'] - $total_paid2) <= 0.009) {
      mysqli_query($conn, "UPDATE bookings SET status='PAID' WHERE booking_id=$booking_id");
    }
 
    header("Location: payments_list.php");
    exit;
  }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Process Payment - #<?php echo $booking_id; ?></title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<?php include "../nav.php"; ?>
 
<div class="container" style="max-width: 550px; margin-top: 50px;">
    <div class="page-header" style="text-align: center; display: block;">
        <h2>Process Payment</h2>
        <p>Finalizing transaction for Booking <strong>#<?php echo $booking_id; ?></strong></p>
    </div>
 
    <div class="billing-card">
        <div class="billing-row">
            <span>Service Total</span>
            <span>₱<?php echo number_format($booking['total_cost'], 2); ?></span>
        </div>
        <div class="billing-row" style="color: #059669;">
            <span>Previously Paid</span>
            <span>- ₱<?php echo number_format($total_paid, 2); ?></span>
        </div>
        <div class="billing-total">
            <span>Remaining Balance</span>
            <span>₱<?php echo number_format($balance, 2); ?></span>
        </div>
    </div>
 
    <?php if ($message != ""): ?>
        <div class="message-box message-error">
            ⚠️ <?php echo $message; ?>
        </div>
    <?php endif; ?>
 
    <form method="post">
        <div class="form-group">
            <label>Amount to Pay (₱)</label>
            <input type="number" step="0.01" name="amount_paid" 
                   value="<?php echo number_format($balance, 2, '.', ''); ?>" 
                   max="<?php echo $balance; ?>" required>
            <small class="helper">Enter the amount the client is paying now.</small>
        </div>
 
        <div class="form-group">
            <label>Payment Method</label>
            <select name="method">
                <option value="CASH">Cash</option>
                <option value="GCASH">GCash / Maya</option>
                <option value="BANK TRANSFER">Bank Transfer</option>
                <option value="CARD">Credit/Debit Card</option>
            </select>
        </div>
 
        <div style="display: flex; flex-direction: column; gap: 10px; margin-top: 10px;">
            <button type="submit" name="pay" class="btn">Post Payment</button>
            <a href="bookings_list.php" class="btn" style="background: #f1f5f9; color: #475569; text-align: center;">Cancel</a>
        </div>
    </form>
</div>
 
<div class="footer" style="text-align: center; margin-top: 40px; color: rgba(255,255,255,0.5);">
    Assessment &copy; 2026
</div>
 
</body>
</html>