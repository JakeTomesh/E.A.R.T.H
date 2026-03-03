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
                    <h1>E.A.R.T.H</h1>
                    <h2>Emission and Resource Tracking Hub</h2>
                    <div id="user_nav_div">
                        <a href="emission_manager/index.php?controllerRequest=emission_logs_nav" 
                        id="back" class="btn">Back to Emission Logs</a>
                        <a href="../user_manager/index.php?controllerRequest=user_logout" 
                        id="logout" class="btn">Logout</a>
                    </div>
                </div>
            </div>
            <div id="animated_line"></div>
            <div id="emission_logs_container">
                <h2 id="page_title">Emission Logs</h2>
                <div id="emission_log_details_container">
                    <dl class="log-details">
                        <div>
                            <dt>ID:</dt>
                            <dd><?= htmlspecialchars($logDetails['id']); ?></dd>
                        </div>

                        <div>
                            <dt>Username:</dt>
                            <dd><?= htmlspecialchars($logDetails['username']); ?></dd>
                        </div>

                        <div>
                            <dt>Emission Type:</dt>
                            <dd><?= htmlspecialchars($logDetails['emission_type_name']); ?></dd>
                        </div>

                        <div>
                            <dt>Physical Quantity:</dt>
                            <dd><?= htmlspecialchars(number_format($logDetails['physical_quantity'], 2)).' '.htmlspecialchars($logDetails['physical_unit_type_name']); ?></dd>
                        </div>

                        <div>
                            <dt>CO₂e Quantity:</dt>
                            <dd><?= htmlspecialchars(number_format($logDetails['co2e_quantity'], 2)).' '.htmlspecialchars($logDetails['co2e_unit_type_name']); ?></dd>
                        </div>

                        <div>
                            <dt>Emission Factor:</dt>
                            <dd><?= htmlspecialchars($logDetails['emission_factor']); ?></dd>
                        </div>

                        <div>
                            <dt>Emission Start Date:</dt>
                            <dd><?= htmlspecialchars(formatDate($logDetails['emission_start_date'], 'm-d-Y')); ?></dd>
                        </div>

                        <div>
                            <dt>Emission End Date:</dt>
                            <dd><?= htmlspecialchars(formatDate($logDetails['emission_end_date'], 'm-d-Y')); ?></dd>
                        </div>

                        <div>
                            <dt>Log Date:</dt>
                            <dd><?= htmlspecialchars(date('m-d-Y H:i:s', strtotime($logDetails['date_created']))); ?></dd>
                        </div>

                        <div>
                            <dt>Notes:</dt>
                            <dd><?= isset($logDetails['notes']) 
                                ? htmlspecialchars($logDetails['notes']) 
                                : ''; ?></dd>
                        </div>

                    </dl>
                </div>
            </div>
        </div>
    </main>
</body>
</html>