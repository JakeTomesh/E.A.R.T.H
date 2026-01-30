<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();    
} 
    $errorMessage = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : 'Page not found.';  
unset($_SESSION['error_message']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once '../include/head.php'; ?>
</head>
<body>
    <div class="backgroundImg">
        
            <?php require_once '../include/header.php'; ?>
     
            <main>
                <h1>Page not found!</h1>
                <span><?php echo htmlspecialchars($errorMessage); ?></span>
            </main>
        
            <?php require_once '../include/footer.php'; ?>
    </div>

</body>
</html>