<?php 
include('../include/bootstrap.php');
include('../include/auth.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../include/head.php'; ?>
    <link rel="stylesheet" href="styles/register.css">
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
                <div id="register_container">
                    <h2 id="page_title">User Registration Form</h2>
                    <div id="form_register">
                        <form action="user_manager/index.php" method="POST">
                            <input type="hidden" name="controllerRequest" value="user_register">
                    
                            <label for="first_name">First Name:</label>
                            <input type="text" id="first_name" name="first_name" required value="Test">
                            <br>
                            <label for="last_name">Last Name:</label>
                            <input type="text" id="last_name" name="last_name" required value="Test">
                            <br>
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" required value="test@test.com">
                            <br>
                            <label for="password">Password:</label>
                            <input type="password" id="password" name="password" required value="TestPassword">
                            <br>
                            <label for="role">Role:</label>
                            <select id="role" name="role" required>
                                <option value="1">User</option>
                                <option value="2">Admin</option>
                            </select>
                            <br>
                            <label for="licensee_key">Licensee Key:</label>
                            <input type="text" id="licensee_key" name="licensee_key" required value=<?php if($_SESSION['user']->getLicenseeId() == 1){echo 'NFDS-7A9C2E41-B4D8-4F1E-9C3A-8D72E6A91F20';}
                            else if($_SESSION['user']->getLicenseeId() == 2){echo 'HCI-2F8D9B0C-61A4-43F0-A7E9-5C8B12D47AEE';}?>>
                            <br>
                            <button type="submit" id="submit" >Register</button>
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
        </div>
    </main>
    <footer>
        <?php include('../include/footer.php'); ?>
    </footer>
</body>
</html>