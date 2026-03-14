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
                <h1>E.A.R.T.H</h1>
                <h2>Emission and Resource Tracking Hub</h2>
                <div id="user_nav_div">
                    <a href="emission_manager/index.php?controllerRequest=manage_emission_factors_nav" 
                    id="back" class="btn">Back to Emission Factors Menu</a>
                    <a href="user_manager/index.php?controllerRequest=user_logout" 
                    id="logout" class="btn">Logout</a>
                </div>
            </div>
            <div id="register_container">
                <h2 id="page_title">Edit Emission Factor</h2>
                <div id="form_register">
                    <form action="emission_manager/index.php" method="POST">
                        <input type="hidden" name="controllerRequest" value="save_edit_emission_factor">
                        <input type="hidden" name="emission_factor_id" value="<?= htmlspecialchars($emissionFactorToEdit['id']) ?>">
                        <label for="emission_type">Emission Type:</label>
                        <input type="text" id="emission_type" name="emission_type" disabled value="<?php echo htmlspecialchars($emissionFactorToEdit['emission_type_name']); ?>">
                        <br>
                        <label for="emission_unit_type">Emission Unit Type:</label>
                        <input type="text" id="emission_unit_type" name="emission_unit_type" disabled value="<?php echo htmlspecialchars($emissionFactorToEdit['unit_type_name']); ?>">
                        <label for="emission_factor">Factor:</label>
                        <input type="number" step="0.001" min="0" id="emission_factor" name="emission_factor" required value="<?php echo htmlspecialchars($emissionFactorToEdit['factor']); ?>">
                        <br>
                        <button type="submit" id="submit">Save Changes</button>
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