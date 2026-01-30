<?php 
    require_once '../include/auth.php';
    $message = isset($_SESSION['user_message']) ? $_SESSION['user_message'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../include/head.php'; ?>
    <link rel="stylesheet" href="styles/dashboard.css">
</head>
<header>
    <?php include '../include/header.php'; ?>
</header>
<body>
    <main>
        <div id="container" class="background_img">
            <div id="title_container">
                <div id="title">
                    <h1>E.A.R.T.H</h1>
                    <h2>Emission and Resource Tracking Hub</h2>
                    <div id="user_div">
                        <h3 id="title_message"><?php echo htmlspecialchars($message); ?></h3>
                        <a href="user_manager/index.php?controllerRequest=user_logout" 
                        id="logout" class="btn">Logout</a>
                    </div>
                </div>
            </div>
            <div id="animated_line"></div>
            <div id="dashboard_container">
                <a href="../emission_manager/index.php?controllerRequest=emission_input_nav" id="menu_emission_input" class="dashboard_menu_item">
                    <div  >
                        <h3>Emission Input</h3>
                    </div>
                </a>
                <a href="../emission_manager/index.php?controllerRequest=emission_logs_nav" id="menu_emission_logs" class="dashboard_menu_item">
                    <div >
                        <h3>Emission Logs</h3>
                    </div>
                </a>
                <a href="../alert_manager/index.php?controllerRequest=alert_logs_nav" id="menu_alert_logs" class="dashboard_menu_item">
                    <div  >
                        <h3>Alert Logs</h3>
                    </div>
                </a>
                <a href="../metrics_manager/index.php?controllerRequest=view_metrics_nav" id="menu_view_metrics" class="dashboard_menu_item">
                    <div  >
                        <h3>View Metrics</h3>
                    </div>
                </a>
                <a href="../admin_manager/index.php?controllerRequest=admin_menu_nav" id="menu_admin_portal" class="dashboard_menu_item">
                    <div >
                        <h3>Admin Menu</h3>
                    </div>
                </a>
                <div id="menu_quick_metrics" class="dashboard_menu_item">
                    <div>
                        <h3>Quick Metrics Displayed Here</h3>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>