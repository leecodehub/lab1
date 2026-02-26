<?php
include "../db.php";
$result = mysqli_query($conn, "SELECT * FROM services ORDER BY service_id ASC");
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Services List</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<?php include "../nav.php"; ?>

<div class="container">
    <div class="page-header">
        <div>
            <h2>Services Menu</h2>
            <p>Manage your service offerings and hourly rates.</p>
        </div>
        <a href="services_add.php" class="btn">+ Add New Service</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Service Name</th>
                <th>Hourly Rate</th>
                <th>Status</th>
                <th style="text-align: center;">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td>#<?php echo htmlspecialchars($row['service_id']); ?></td>
                    <td style="font-weight: 600; color: #1e293b;"><?php echo htmlspecialchars($row['service_name']); ?></td>
                    <td>₱<?php echo number_format($row['hourly_rate'], 2); ?></td>
                    <td>
                        <?php if($row['is_active']): ?>
                            <span class="badge badge-active">Active</span>
                        <?php else: ?>
                            <span class="badge" style="background: #fee2e2; color: #991b1b;">Inactive</span>
                        <?php endif; ?>
                    </td>
                    <td style="text-align: center;">
                        <a href="services_edit.php?id=<?php echo $row['service_id']; ?>" class="btn" style="padding: 6px 12px; font-size: 0.8rem;">Edit</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<div class="footer">Assessment &copy; 2026</div>
</body>
</html>