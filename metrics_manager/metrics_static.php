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
                <a href="user_manager/index.php?controllerRequest=user_logout" id="logout" class="btn">Logout</a>
                </div>
            </div>
          </div>
          <div id="animated_line"></div>
          <div id="metrics_static_container">
            <h2>Static Metrics</h2>

            <div id="mbStatusStatic" aria-live="polite"></div>

            <div class="mb-embed-shell">
              <metabase-dashboard
                id="mbDashboardStatic"
                with-title="true"
                with-downloads="true">
              </metabase-dashboard>
            </div>
          </div>
      </div>
    </main>

    <script src="/Assignments/E.A.R.T.H/js/load_metabase_static_metrics.js"></script>
</body>
</html>