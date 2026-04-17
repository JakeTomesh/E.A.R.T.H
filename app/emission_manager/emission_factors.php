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
                    <h1>E.A.R.T.H.</h1>
                    <h2>Emission and Resource Tracking Hub</h2>
                    <div id="user_nav_div">
                        <a href="user_manager/index.php?controllerRequest=admin_menu_nav" 
                        id="back" class="btn">Back to Admin Menu</a>
                        <a href="user_manager/index.php?controllerRequest=user_logout" 
                        id="logout" class="btn">Logout</a>
                    </div>
                </div>
                <div class="flex">
                    <h2 id="page_title">Emission Factors</h2>
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
                                <th>ID</th>
                                <th>Emission Type</th>
                                <th>Unit Type</th>
                                <th>Factor</th>
                                <th>Date Updated</th>
                                <th>Edit</th>
                            </tr>
                            <?php foreach($emissionFactors as $emissionFactor): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($emissionFactor['id']); ?></td>
                                    <td><?php echo htmlspecialchars($emissionFactor['emission_type_name']); ?></td>
                                    <td><?php echo htmlspecialchars($emissionFactor['unit_type_name']); ?></td>
                                    <td><?php echo htmlspecialchars($emissionFactor['factor']); ?></td>
                                    <td><?php echo htmlspecialchars(date('m-d-Y', strtotime($emissionFactor['date_updated']))); ?></td>
                                    <td>
                                        <a id="edit_emission_factor" class="btn" href="emission_manager/index.php?controllerRequest=edit_emission_factor_nav&emission_factor_id=<?php echo htmlspecialchars($emissionFactor['id']); ?>">Edit</a>
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
                        <div>
                            <form action="emission_manager/index.php" method="post">
                                <input type="hidden" name="controllerRequest" value="add_emission_factor_nav">
                                <button type="submit" id="submit" class="btn_submit">Add Emission Factor</button>
                            </form>
                        </div>
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