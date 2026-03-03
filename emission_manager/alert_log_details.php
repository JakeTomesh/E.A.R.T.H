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
    <link rel="stylesheet" href="styles/alert_logs.css">
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
                    <h1>E.A.R.T.H</h1>
                    <h2>Emission and Resource Tracking Hub</h2>
                    <div id="user_nav_div">
                        <a href="emission_manager/index.php?controllerRequest=alert_logs_nav" 
                        id="back" class="btn">Back to Alert Logs</a>
                        <a href="user_manager/index.php?controllerRequest=user_logout" 
                        id="logout" class="btn">Logout</a>
                    </div>
                </div>
            </div>
            <div id="animated_line"></div>
            <div id="emission_logs_container">
                <div id="alert_log_details_wrapper">
                    <h2 id="page_title">Alert Log Details</h2>
                    <div id="alert_log_details_container">
                        <dl class="alert_log_details">
                            <div>
                                <dt>Alert ID:</dt>
                                <dd><?= htmlspecialchars($alertLogDetails['id']); ?></dd>
                            </div>
                            <div>
                                <dt>Emission Log ID:</dt>
                                <dd><?= htmlspecialchars($alertLogDetails['emission_log_id']); ?></dd>
                            </div>
                            <div>
                                <dt>Emission Type:</dt>
                                <dd><?= htmlspecialchars($alertLogDetails['emission_type_name']); ?></dd>
                            </div>
                            <div>
                                <dt>CO₂e Daily Quantity:</dt>
                                <dd>
                                    <?= htmlspecialchars(number_format($alertLogDetails['co2e_quantity'], 2)); ?>
                                    <?= htmlspecialchars($alertLogDetails['co2e_unit_type_name'].'/Day'); ?>
                                </dd>
                            </div>
                            <div>
                                <dt>CO₂e Limit:</dt>
                                <dd>
                                    <?= htmlspecialchars(number_format($alertLogDetails['co2e_limit'], 2)); ?>
                                    <?= htmlspecialchars($alertLogDetails['co2e_limit_unit_type_name'].'/Day'); ?>
                                </dd>
                            </div>
                            <div>
                                <dt>Alert Date:</dt>
                                <dd><?= htmlspecialchars(date('m-d-Y H:i:s', strtotime($alertLogDetails['date_created']))); ?></dd>
                            </div>
                            <div>
                                <dt>Alert Message:</dt>
                                <dd><?= htmlspecialchars($alertLogDetails['message']); ?></dd>
                            </div>
                        </dl>
                    </div>
                </div>
                <div id="emission_log_details_wrapper">
                    <h2 id="page_title_second">Emission Details</h2>
                    <div id="emission_log_details_container">
                        <dl class="emission_log_details">
                            <div>
                                <dt>Emission ID:</dt>
                                <dd><?= htmlspecialchars($emissionLogDetails['id']); ?></dd>
                            </div>
                            <div>
                                <dt>Username:</dt>
                                <dd><?= htmlspecialchars($emissionLogDetails['username']); ?></dd>
                            </div>
                            <div>
                                <dt>Emission Type:</dt>
                                <dd><?= htmlspecialchars($emissionLogDetails['emission_type_name']); ?></dd>
                            </div>
                            <div>
                                <dt>Physical Quantity:</dt>
                                <dd><?= htmlspecialchars(number_format($emissionLogDetails['physical_quantity'], 2)).' '.htmlspecialchars($emissionLogDetails['physical_unit_type_name']); ?></dd>
                            </div>
                            <div>
                                <dt>CO₂e Quantity:</dt>
                                <dd><?= htmlspecialchars(number_format($emissionLogDetails['co2e_quantity'], 2)).' '.htmlspecialchars($emissionLogDetails['co2e_unit_type_name']); ?></dd>
                            </div>
                            <div>
                                <dt>Emission Factor:</dt>
                                <dd><?= htmlspecialchars($emissionLogDetails['emission_factor']); ?></dd>
                            </div>
                            <div>
                                <dt>Emission Start Date:</dt>
                                <dd><?= htmlspecialchars(formatDate($emissionLogDetails['emission_start_date'], 'm-d-Y')); ?></dd>
                            </div>
                            <div>
                                <dt>Emission End Date:</dt>
                                <dd><?= htmlspecialchars(formatDate($emissionLogDetails['emission_end_date'], 'm-d-Y')); ?></dd>
                            </div>
                            <div>
                                <dt>Log Date:</dt>
                                <dd><?= htmlspecialchars(date('m-d-Y H:i:s', strtotime($emissionLogDetails['date_created']))); ?></dd>
                            </div>
                            <div>
                                <dt>Notes:</dt>
                                <dd><?= isset($emissionLogDetails['notes'])
                                    ? htmlspecialchars($emissionLogDetails['notes'])
                                    : ''; ?></dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>