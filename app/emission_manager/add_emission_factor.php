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
                    <a href="emission_manager/index.php?controllerRequest=manage_emission_factors_nav" 
                    id="back" class="btn">Back to Emission Factors Menu</a>
                    <a href="user_manager/index.php?controllerRequest=user_logout" 
                    id="logout" class="btn">Logout</a>
                </div>
            </div>
            <div id="register_container">
                <h2 id="page_title">Add Emission Factor</h2>
                <div id="form_register">
                    <form action="emission_manager/index.php" method="POST">
                        <input type="hidden" name="controllerRequest" value="save_add_emission_factor">
                        <label for="emission_type">Emission Type:</label>
                        <select name="emission_type" id="emission_type">
                            <option value="">--Select Emission Type--</option>
                            <?php foreach($emissionTypes as $type): ?>
                                <option value="<?php echo htmlspecialchars($type['id']); ?>">
                                    <?php echo htmlspecialchars($type['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <br>
                        <label for="emission_unit_type">Emission Unit Type:</label>
                        <select name="emission_unit_type" id="emission_unit_type">
                            <option value="">--Select Unit Type--</option>
                            <?php foreach($unitTypes as $unit): ?>
                                <option value="<?php echo htmlspecialchars($unit['id']); ?>">
                                    <?php echo htmlspecialchars($unit['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <br>
                        <label for="emission_factor">Factor:</label>
                        <input type="number" step="0.000001" min="0" id="emission_factor" name="emission_factor" required>
                        <br>
                        <button type="submit" id="submit">Add Emission Factor</button>
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