<?php
// --- 1. LOGIC SECTION (Keep the math at the top) ---

// Check if the current page is inside a subfolder (admin or user)
$is_in_subfolder = (strpos($_SERVER['PHP_SELF'], 'admin') !== false || strpos($_SERVER['PHP_SELF'], 'user') !== false);

// Set the base path prefix: either go up two levels or stay in root
$base_prefix = $is_in_subfolder ? '../../' : './';

// Specific paths
$css_link    = $base_prefix . 'assets/css/style.css';
$logout_link = $is_in_subfolder ? '../logout.php' : 'public/logout.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduTrack | Student System</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="<?php echo $css_link; ?>">
</head>
<body>

    <nav class="navbar">
        <div class="nav-container">
            <div class="logo">
                <a href="#" style="color: white; text-decoration: none;">
                    <i class="fas fa-graduation-cap"></i> EduTrack v1.0
                </a>
            </div>
            
            <div class="nav-links">
                <?php if (isset($_SESSION['user_id'])): ?>
                    
                    <span class="user-badge">
                        <i class="fas fa-user-circle"></i> 
                        Logged in: <strong><?php echo ucfirst($_SESSION['role']); ?></strong>
                    </span>
                    
                    <a href="<?php echo $logout_link; ?>" class="logout-link">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>

                <?php else: ?>
                    
                    <span class="secure-tag"><i class="fas fa-lock"></i> Secure Access</span>
                    
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="content-wrapper">