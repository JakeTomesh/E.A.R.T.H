<?php 
include('../include/bootstrap.php');
include('../include/auth.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../include/head.php'; ?>
    <link rel="stylesheet" href="styles/thresholds.css">
</head>
<header>
    <?php include '../include/header.php'; ?>
</header>
<body>
    <main>
        <div id="site_container" class="background_img">
            <div id="title_container">
                <div id="title">
                    <h1>E.A.R.T.H</h1>
                    <h2>Emission and Resource Tracking Hub</h2>
                    <div id="user_nav_div">
                        <a href="user_manager/index.php?controllerRequest=admin_menu_nav" 
                        id="back" class="btn">Back to Admin Menu</a>
                        <a href="user_manager/index.php?controllerRequest=user_logout" 
                        id="logout" class="btn">Logout</a>
                    </div>
                </div>
                <div class="flex">
                    <h2 id="page_title">Threshold Calibration</h2>
                    <?php
                        $userMessage = $_SESSION['user_message'] ?? '';
                        unset($_SESSION['user_message']);
                    ?>
                    <?php if($userMessage): ?>
                        <div>
                            <span class="user_message"><?php echo htmlspecialchars($userMessage); ?></span>
                        </div>
                    <?php endif; ?>
                    <div id="threshold_container">
                        <table>
                            <tr>
                                <th>Emission Type</th>
                                <th>Co2e Limit</th>
                                <th>Unit Type</th>
                                <th>Date Updated</th>
                                <th>Edit</th>
                            </tr>
                            <?php foreach($thresholds as $threshold): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($threshold['emission_type_name']); ?></td>
                                    <td><?php echo htmlspecialchars(number_format($threshold['co2e_limit'], 2)); ?></td>
                                    <td><?php echo htmlspecialchars($threshold['unit_type_name'].'/Day'); ?></td>
                                    <td><?php echo htmlspecialchars(date('m-d-Y', strtotime($threshold['date_updated']))); ?></td>
                                    <td>
                                        <a id="edit_threshold" class="btn" href="emission_manager/index.php?controllerRequest=edit_threshold_nav&threshold_id=<?php echo htmlspecialchars($threshold['id']); ?>">Edit</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                        <?php 
                            $errorMessage = $_SESSION['error_message'] ?? '';
                            unset($_SESSION['error_message']);
                        ?>
                        <?php if($errorMessage): ?>
                            <span class="error_message"><?php echo htmlspecialchars($errorMessage); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <?php include('../include/footer.php'); ?>
    </footer>
</body>
</html>