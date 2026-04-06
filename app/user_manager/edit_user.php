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
                    <a href="user_manager/index.php?controllerRequest=admin_menu_nav" 
                    id="back" class="btn">Back to Admin Menu</a>
                    <a href="user_manager/index.php?controllerRequest=user_logout" 
                    id="logout" class="btn">Logout</a>
                </div>
            </div>
            <div id="register_container">
                <h2 id="page_title">Edit User Form</h2>
                
                <div id="form_register">
                    <form action="user_manager/index.php" method="POST">
                        <input type="hidden" name="controllerRequest" value="save_edit_user">
                        <input type="hidden" name="user_id" value="<?= htmlspecialchars($userToEdit->getId()) ?>">
                
                        <label for="first_name">First Name:</label>
                        <input type="text" id="first_name" name="first_name" required value="<?php echo htmlspecialchars($userToEdit->getFirstName()); ?>">
                        <br>
                        <label for="last_name">Last Name:</label>
                        <input type="text" id="last_name" name="last_name" required value="<?php echo htmlspecialchars($userToEdit->getLastName()); ?>">
                        <br>
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($userToEdit->getEmail()); ?>">
                        <br>
                        <label for="role">Role:</label>
                        <select id="role" name="role" required>
                            <option value="1" <?php if($userToEdit->getRole() == 1) echo 'selected'; ?>>User</option>
                            <option value="2" <?php if($userToEdit->getRole() == 2) echo 'selected'; ?>>Admin</option>
                        </select>
                        <br>
                        <label for="is_active">Active Status:</label>
                        <select id="is_active" name="is_active" required>
                            <option value="1" <?php if($userToEdit->getIsActive() == 1) echo 'selected'; ?>>Active</option>
                            <option value="0" <?php if($userToEdit->getIsActive() == 0) echo 'selected'; ?>>Inactive</option>
                        </select>
                        <br>
                        <label for="reset_password">Reset Password:</label>
                        <input type="password" id="reset_password" name="reset_password">
                        <br>
                        <label for="confirm_password">Confirm Password:</label>
                        <input type="password" id="confirm_password" name="confirm_password">
                        <br>
                        <div id="show_hide_pass">
                            <input type="checkbox" id="toggle_password">
                            <label for="toggle_password">Show Password</label>
                        </div>
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
                        <?php 
                            $editErrorMessage = $_SESSION['edit_error_message'] ?? '';
                            unset($_SESSION['edit_error_message']);
                        ?>
                        <?php if($editErrorMessage): ?>
                            <span class="error_message"><?php echo htmlspecialchars($editErrorMessage); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="js/show_hide_password.js"></script>
    <footer>
        <?php include('../include/footer.php'); ?>
    </footer>
</body>
</html>