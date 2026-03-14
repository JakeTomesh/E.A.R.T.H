<?php
require_once('bootstrap.php');

$errorMessage = $_SESSION['error_message'] ?? 'Page not found.';
$errorTrace   = $_SESSION['error_trace'] ?? null;

unset($_SESSION['error_message']);
unset($_SESSION['error_trace']);

// Send proper 404 header
http_response_code(404);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once 'head.php'; ?>
    <link rel="stylesheet" href="styles/error.css">
</head>

<body>
<div class="backgroundImg">
    <?php require_once 'header.php'; ?>

    <main>
        <div class="error-container">
            <div class="error-title">404 – Page Not Found</div>

            <div>
                <?= htmlspecialchars($errorMessage); ?>
            </div>

            <?php if (defined('APP_ENV') && APP_ENV === 'development' && $errorTrace): ?>
                <div class="dev-warning">
                    Development Mode: Stack Trace Below
                </div>

                <div class="trace-block">
                    <?= htmlspecialchars($errorTrace); ?>
                </div>
            <?php endif; ?>

            <div style="margin-top:2rem;">
                <a href="/dashboard_manager/index.php?controllerRequest=dashboard_nav" style="color:#7C9EB2;">
                    Return to Dashboard
                </a>
            </div>
        </div>
    </main>

    <?php require_once 'footer.php'; ?>
</div>
</body>
</html>