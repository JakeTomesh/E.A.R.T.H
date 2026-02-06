<?php 
    require_once '../include/bootstrap.php';
    require_once '../include/auth.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../include/head.php'; ?>
    <link rel="stylesheet" href="styles/dashboard.css">
</head>
<body>
    <header>
        <?php include '../include/header.php'; ?>
    </header>
    <main>
        <div id="container" class="background_img">
            <div id="title_container">
                <div id="title">
                    <h1>E.A.R.T.H</h1>
                    <h2>Emission and Resource Tracking Hub</h2>
                    <div id="user_div">
                        <a href="user_manager/index.php?controllerRequest=user_logout" 
                        id="logout" class="btn">Logout</a>
                    </div>
                </div>
            </div>
            <div id="animated_line"></div>
            <div id="alert_logs_container">
                <h2>Alert Logs</h2>
                
            </div>
        </div>
    </main>
</body>
</html>