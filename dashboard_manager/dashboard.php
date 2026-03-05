<?php 
    require_once '../include/bootstrap.php';
    require_once '../include/auth.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../include/head.php'; ?>
    <link rel="stylesheet" href="styles/dashboard.css">
    <link rel="stylesheet" href="styles/metabase.css">
    <script defer src="http://localhost:3000/app/embed.js"></script>
    <script>
        // Metabase reads this global config
        window.metabaseConfig = {
            theme: { preset: "dark" },
            isGuest: true,
            instanceUrl: "http://localhost:3000"
        };
    </script>
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
                    <div id="user_nav_div">
                        <h3 id="title_message"><?php echo isset($_SESSION['user_welcome_message']) ? htmlspecialchars($_SESSION['user_welcome_message']) : ''; ?></h3>
                        <a href="user_manager/index.php?controllerRequest=user_logout" 
                        id="logout" class="btn">Logout</a>
                    </div>
                    <h4 id="company_name"><?php echo isset($_SESSION['user']) ? htmlspecialchars($_SESSION['user']->getCompanyName()) : ''; ?></h4>
                </div>
            </div>
            <div id="animated_line"></div>
            <div id="dashboard_container">
                <a href="emission_manager/index.php?controllerRequest=emission_input_nav" id="menu_emission_input" class="dashboard_menu_item">
                    <div  >
                        <h3>Emission Input</h3>
                    </div>
                </a>
                <a href="emission_manager/index.php?controllerRequest=emission_logs_nav" id="menu_emission_logs" class="dashboard_menu_item">
                    <div >
                        <h3>Emission Logs</h3>
                    </div>
                </a>
                <a href="emission_manager/index.php?controllerRequest=alert_logs_nav" id="menu_alert_logs" class="dashboard_menu_item">
                    <div  >
                        <h3>Alert Logs</h3>
                    </div>
                </a>
                <a href="metrics_manager/index.php?controllerRequest=view_metrics_nav" id="menu_view_metrics" class="dashboard_menu_item">
                    <div  >
                        <h3>View Metrics</h3>
                    </div>
                </a>
                <?php if(isset($_SESSION['user']) && $_SESSION['user']->getRole() == 2){
                    //show admin portal link
                    echo 
                        '<a href="user_manager/index.php?controllerRequest=admin_menu_nav" id="menu_admin_portal" class="dashboard_menu_item">
                            <div >
                                <h3>Admin Menu</h3>
                            </div>
                        </a>';
                }?>
                
                <div id="menu_quick_metrics" >
                    <div>
                        
                        <div id="mbStatus" aria-live="polite"></div>

                        <!-- IMPORTANT: no token here -->
                       <div class="mb-embed-shell mb-embed-shell--quick">
                            <metabase-dashboard
                                id="mbDashboard"
                                with-title="true"
                                with-downloads="true">
                            </metabase-dashboard>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="/Assignments/E.A.R.T.H/js/load_metabase_dashboard.js"></script>
</body>
</html>