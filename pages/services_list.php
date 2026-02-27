<?php
include "../db.php";

/* ============================
   SOFT DELETE (Deactivate)
   ============================ */
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    
    // Soft delete (set is_active to 0)
    mysqli_query($conn, "UPDATE services SET is_active=0 WHERE service_id=$delete_id");
    
    header("Location: services_list.php");
    exit;
}

/* ============================
   FETCH ALL SERVICES
   ============================ */
// Changed to DESC so newest/active items appear at the top
$result = mysqli_query($conn, "SELECT * FROM services ORDER BY service_id DESC");
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
            <p>Manage your service offerings, rates, and availability.</p>
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
                    <td style="font-weight: 600; color: #1e293b;">
                        <?php echo htmlspecialchars($row['service_name']); ?>
                    </td>
                    <td>₱<?php echo number_format($row['hourly_rate'], 2); ?></td>
                    <td>
                        <?php if($row['is_active'] == 1): ?>
                            <span class="badge badge-active">Active</span>
                        <?php else: ?>
                            <span class="badge" style="background: #fee2e2; color: #991b1b;">Inactive</span>
                        <?php endif; ?>
                    </td>
                    <td style="text-align: center;">
                        <a href="services_edit.php?id=<?php echo $row['service_id']; ?>" 
                           class="btn" style="padding: 6px 12px; font-size: 0.8rem;">Edit</a>
                        
                        <?php if ($row['is_active'] == 1) { ?>
                            <a href="services_list.php?delete_id=<?php echo $row['service_id']; ?>" 
                               class="btn" 
                               style="padding: 6px 12px; font-size: 0.8rem; background: #ef4444;"
                               onclick="return confirm('Are you sure you want to deactivate this service?')">
                               Deactivate
                            </a>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<div class="footer">Assessment &copy; 2026</div>

</body>
</html>