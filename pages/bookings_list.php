<?php
include "../db.php";
 
// --- Original SQL Logic Maintained ---
$sql = "
SELECT b.*, c.full_name AS client_name, s.service_name
FROM bookings b
JOIN clients c ON b.client_id = c.client_id
JOIN services s ON b.service_id = s.service_id
ORDER BY b.booking_id DESC
";
$result = mysqli_query($conn, $sql);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Bookings Management</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<?php include "../nav.php"; ?>

<div class="container">
    <div class="page-header">
        <div>
            <h2>Bookings Dashboard</h2>
            <p>View and manage all client service appointments.</p>
        </div>
        <a href="bookings_create.php" class="btn">+ Create New Booking</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Client</th>
                <th>Service</th>
                <th>Date</th>
                <th>Hours</th>
                <th>Total Cost</th>
                <th>Status</th>
                <th style="text-align: center;">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while($b = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td style="color: var(--text-muted);">#<?php echo $b['booking_id']; ?></td>
                    <td style="font-weight: 600; color: var(--text-dark);">
                        <?php echo htmlspecialchars($b['client_name']); ?>
                    </td>
                    <td>
                        <span style="background: #f1f5f9; padding: 2px 8px; border-radius: 4px; font-size: 0.85rem;">
                            <?php echo htmlspecialchars($b['service_name']); ?>
                        </span>
                    </td>
                    <td style="color: var(--text-muted); font-size: 0.9rem;">
                        <?php echo date("M d, Y", strtotime($b['booking_date'])); ?>
                    </td>
                    <td><?php echo $b['hours']; ?> <small>hrs</small></td>
                    <td style="font-weight: 700;">₱<?php echo number_format($b['total_cost'], 2); ?></td>
                    <td>
                        <?php 
                            // Using conditional badge styling
                            $statusClass = ($b['status'] == 'PAID') ? 'background: #dcfce7; color: #15803d;' : 'background: #fef9c3; color: #854d0e;';
                        ?>
                        <span class="badge" style="<?php echo $statusClass; ?>">
                            <?php echo $b['status']; ?>
                        </span>
                    </td>
                    <td style="text-align: center;">
                        <?php if($b['status'] !== 'PAID'): ?>
                            <a href="payment_process.php?booking_id=<?php echo $b['booking_id']; ?>" 
                               class="btn" style="padding: 6px 12px; font-size: 0.75rem;">
                               Process Payment
                            </a>
                        <?php else: ?>
                            <span style="color: #059669; font-size: 0.8rem; font-weight: 600;">✓ Completed</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<div class="footer" style="text-align: center; margin-top: 30px; color: rgba(255,255,255,0.6);">
    Assessment &copy; 2026
</div>

</body>
</html>