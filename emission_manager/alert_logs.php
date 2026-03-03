<?php 
    require_once '../include/bootstrap.php';
    require_once '../include/auth.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../include/head.php'; ?>
    <link rel="stylesheet" href="styles/alert_logs.css">
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
                        <a href="dashboard_manager/index.php?controllerRequest=dashboard_nav" 
                        id="back" class="btn">Back to Dashboard</a>
                        <a href="user_manager/index.php?controllerRequest=user_logout" 
                        id="logout" class="btn">Logout</a>
                    </div>
                </div>
            </div>
            <div id="animated_line"></div>
            <div id="alert_logs_container">
                <h2 id="page_title">Alert Logs</h2>
                <div id="alert_logs_table_container">
                    <table>
                        <thead>
                            <tr>
                                <th>Alert ID</th>
                                <th>Emission Log ID</th>
                                <th>Emission Type</th>
                                <th>CO2e Quantity</th>
                                <th>CO2e Limit</th>
                                <th>Alert Date</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($alertLogs)): ?>
                                <?php foreach($alertLogs as $log): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($log['id']); ?></td>
                                        <td><?php echo htmlspecialchars($log['emission_log_id']); ?></td>
                                        <td><?php echo htmlspecialchars($log['emission_type_name']); ?></td>
                                        <td><?php echo htmlspecialchars(number_format($log['co2e_quantity'], 2)).' '.htmlspecialchars($log['co2e_unit_type_name'].'/Day'); ?></td>
                                        <td><?php echo htmlspecialchars(number_format($log['co2e_limit'], 2)).' '.htmlspecialchars($log['co2e_limit_unit_type_name'].'/Day'); ?></td>
                                        <td><?php echo htmlspecialchars(date('m-d-Y', strtotime($log['date_created']))); ?></td>
                                        <td>
                                            <form action="emission_manager/index.php" method="POST">
                                                <input type="hidden" name="controllerRequest" value="alert_log_details_nav">
                                                <input type="hidden" name="alert_log_id" value="<?php echo htmlspecialchars($log['id']); ?>">
                                                <input type="hidden" name="emission_log_id" value="<?php echo htmlspecialchars($log['emission_log_id']);?>">
                                                <button type="submit" class="btn" id="btn">View Details</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="11">No alert logs found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</body>
</html>