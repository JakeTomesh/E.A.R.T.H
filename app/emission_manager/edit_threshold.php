<?php 
require_once('../include/bootstrap.php');
require_once('../include/auth.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../include/head.php'; ?>
    <link rel="stylesheet" href="styles/register.css">
</head>
<body>
    <header>
        <?php include '../include/header.php'; ?>
    </header>
    <main>
        <div id="site_container" class="background_img">
            <div id="title">
                <h1>E.A.R.T.H.</h1>
                <h2>Emission and Resource Tracking Hub</h2>
                <div id="user_nav_div">
                    <a href="emission_manager/index.php?controllerRequest=manage_thresholds_nav" 
                    id="back" class="btn">Back to Threshold Menu</a>
                    <a href="user_manager/index.php?controllerRequest=user_logout" 
                    id="logout" class="btn">Logout</a>
                </div>
            </div>
            <div id="register_container">
                <h2 id="page_title">Edit Threshold Form</h2>
                <div id="form_register">
                    <form action="emission_manager/index.php" method="POST">
                        <input type="hidden" name="controllerRequest" value="save_edit_threshold">
                        <input type="hidden" name="threshold_id" value="<?= htmlspecialchars($thresholdToEdit['id']) ?>">
                        <label for="emission_type">Emission Type:</label>
                        <input type="text" id="emission_type" name="emission_type" disabled value="<?php echo htmlspecialchars($thresholdToEdit['emission_type_name']); ?>">
                        <br>
                        <label for="co2e_limit">Co2e Limit:</label>
                        <input type="number" step="0.01" min="0" id="co2e_limit" name="co2e_limit" required value="<?php echo htmlspecialchars($thresholdToEdit['co2e_limit']); ?>">
                        <br>
                        <label for="unit_type">Unit Type:</label>
                        <input type="text" id="unit_type" name="unit_type" disabled value="<?php echo htmlspecialchars($thresholdToEdit['unit_type_name'].'/Day'); ?>">
                        <br>
                        <button type="submit" id="submit" class="btn_submit">Save Changes</button>
                    </form>
                    <div>
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