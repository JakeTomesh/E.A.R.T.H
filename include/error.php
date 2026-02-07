<?php
require_once('bootstrap.php');
    $errorMessage = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : 'Page not found.';  
    unset($_SESSION['error_message']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once 'head.php'; ?>
</head>
<body>
    <div class="backgroundImg">
        
            <?php require_once 'header.php'; ?>
     
            <main>
                <h1>Page not found!</h1>
                <span><?php echo htmlspecialchars($errorMessage); ?></span>
            </main>
        
            <?php require_once 'footer.php'; ?>
    </div>

</body>
</html>