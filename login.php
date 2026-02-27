<?php
session_start();
 
// If already logged in, redirect to index
if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
 
$error = "";
 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
 
    // --- Original Logic Maintained ---
    if ($username === "admin" && $password === "admin") {
        $_SESSION['username'] = "ADMIN";
        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid username or password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Management System</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Special centering for the login page */
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .login-container {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .login-header h2 {
            color: var(--nav-bg);
            margin-bottom: 5px;
        }
        .login-header p {
            color: var(--text-muted);
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
 
<div class="login-container">
    <div class="login-header">
        <h2>Welcome Back</h2>
        <p>Please enter your credentials to login.</p>
    </div>
 
    <?php if ($error != ""): ?>
        <div style="background: #fee2e2; color: #991b1b; padding: 12px; border-radius: 8px; margin-bottom: 20px; text-align: center; font-size: 0.85rem; border: 1px solid #fecaca;">
            ⚠️ <?php echo $error; ?>
        </div>
    <?php endif; ?>
 
    <form method="POST">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" placeholder="Enter username" required>
        </div>
 
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="Enter password" required>
        </div>
 
        <button type="submit" class="btn" style="width: 100%; margin-top: 10px;">Login to Dashboard</button>
    </form>
    
    <div style="text-align: center; margin-top: 25px; color: var(--text-muted); font-size: 0.8rem;">
        Assessment &copy; 2026 | Admin Portal
    </div>
</div>
 
</body>
</html>