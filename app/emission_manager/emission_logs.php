<?php 
    require_once '../include/bootstrap.php';
    require_once '../include/auth.php'; 

    function formatDate($value, $format = 'm-d-Y') {
        if (empty($value)) return '—';
        $ts = strtotime((string)$value);
        return $ts ? date($format, $ts) : '—';
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../include/head.php'; ?>
    <link rel="stylesheet" href="styles/emission_logs.css">
</head>
<body>
    <header>
        <?php include '../include/header.php'; ?>
    </header>
    <main>
        <div id="container" class="background_img">
            <div id="title_container">
                <div id="title">
                    <h1>E.A.R.T.H.</h1>
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
            <div id="emission_logs_container">
                <h2 id="page_title">Emission Logs</h2>
                <div id="emission_logs_table_container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Emission Type</th>
                                <th>Physical Quantity</th>
                                <th>CO2e Quantity</th>
                                <th>Emission Start Date</th>
                                <th>Emission End Date</th>
                                <th>Log Date</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($emissionLogs)): ?>
                                <?php foreach($emissionLogs as $log): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($log['id']); ?></td>
                                        <td><?php echo htmlspecialchars($log['username']); ?></td>
                                        <td><?php echo htmlspecialchars($log['emission_type_name']); ?></td>
                                        <td><?php echo htmlspecialchars(number_format($log['physical_quantity'], 2)).' '.htmlspecialchars($log['physical_unit_type_name']); ?></td>
                                        <td><?php echo htmlspecialchars(number_format($log['co2e_quantity'], 2)).' '.htmlspecialchars($log['co2e_unit_type_name'].'/Day'); ?></td>
                                        <td><?php echo htmlspecialchars(formatDate($log['emission_start_date'], 'm-d-Y')); ?></td>
                                        <td><?php echo htmlspecialchars(formatDate($log['emission_end_date'], 'm-d-Y')); ?></td>

                                        <td><?php echo htmlspecialchars(date('m-d-Y H:i:s', strtotime($log['date_created']))); ?></td>
                                        <td>
                                            <form action="emission_manager/index.php" method="POST">
                                                <input type="hidden" name="controllerRequest" value="emission_log_details_nav">
                                                <input type="hidden" name="log_id" value="<?php echo htmlspecialchars($log['id']); ?>">
                                                <button type="submit" class="btn" id="btn">View Details</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="10">No emission logs found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <?php include('../include/footer.php'); ?>
    </footer>
</body>
</html>