<?php
include "../db.php";
$result = mysqli_query($conn, "SELECT * FROM clients ORDER BY client_id ASC");
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clients List</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<?php include "../nav.php"; ?>

<div class="container">
    <div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h2>Clients Directory</h2>
            <p>Manage and view all registered customer information.</p>
        </div>
        <a href="clients_add.php" class="btn">+ Add New Client</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Email Address</th>
                <th>Phone</th>
                <th style="text-align: center;">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td>#<?php echo htmlspecialchars($row['client_id']); ?></td>
                    <td style="font-weight: 600; color: #1e293b;"><?php echo htmlspecialchars($row['full_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['phone']); ?></td>
                    <td style="text-align: center;">
                        <a href="clients_edit.php?id=<?php echo $row['client_id']; ?>" class="btn" style="padding: 6px 12px; font-size: 0.8rem; background: #0891b2;">Edit</a>
                    </td>
                </tr>
            <?php } ?>
            <?php if(mysqli_num_rows($result) == 0): ?>
                <tr>
                    <td colspan="5" style="text-align: center; padding: 40px; color: #94a3b8;">No clients found in the database.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="footer">Assessment &copy; 2026</div>

</body>
</html>