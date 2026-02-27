<?php
include "../db.php";
 
$sql = "
SELECT p.*, b.booking_date, c.full_name
FROM payments p
JOIN bookings b ON p.booking_id = b.booking_id
JOIN clients c ON b.client_id = c.client_id
ORDER BY p.payment_id DESC
";
$result = mysqli_query($conn, $sql);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Payments History</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<?php include "../nav.php"; ?>

<div class="container">
    <div class="page-header">
        <div>
            <h2>Transaction History</h2>
            <p>A detailed record of all payments received from clients.</p>
        </div>
        <a href="bookings_list.php" class="btn" style="background: #64748b; font-size: 0.8rem;">View Bookings</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Client Name</th>
                <th>Booking Ref</th>
                <th>Amount Paid</th>
                <th>Method</th>
                <th>Date & Time</th>
            </tr>
        </thead>
        <tbody>
            <?php while($p = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td style="color: var(--text-muted);">#<?php echo $p['payment_id']; ?></td>
                    <td style="font-weight: 600; color: var(--text-dark);">
                        <?php echo htmlspecialchars($p['full_name']); ?>
                    </td>
                    <td>
                        <span style="font-family: monospace; background: #f1f5f9; padding: 2px 6px; border-radius: 4px;">
                            BK-<?php echo $p['booking_id']; ?>
                        </span>
                    </td>
                    <td style="font-weight: 800; color: #059669;">
                        ₱<?php echo number_format($p['amount_paid'], 2); ?>
                    </td>
                    <td>
                        <span class="badge" style="background: #e2e8f0; color: #475569;">
                            <?php echo $p['method']; ?>
                        </span>
                    </td>
                    <td style="color: var(--text-muted); font-size: 0.85rem;">
                        <?php echo date("M d, Y | h:i A", strtotime($p['payment_date'])); ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<div class="footer" style="text-align: center; margin-top: 30px; color: rgba(255,255,255,0.6); font-size: 0.8rem;">
    Assessment &copy; 2026 | Financial Records
</div>

</body>
</html>