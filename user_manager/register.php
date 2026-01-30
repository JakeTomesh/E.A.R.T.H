<?php 
if(!isset($_SESSION)){
    session_start();
}
    $errorMessage = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
    unset($_SESSION['error_message']);
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
            <div id="register_container">
                <div id="title">
                    <h1>E.A.R.T.H</h1>
                    <h2>Emission and Resource Tracking Hub</h2>
                </div>
                <div id="form_register">
                    <form action="user_manager/index.php" method="POST">
                        <input type="hidden" name="controllerRequest" value="user_register">
                    
                        <label for="first_name">First Name:</label>
                        <input type="text" id="first_name" name="first_name" required value="Jake">
                        <br>
                        <label for="last_name">Last Name:</label>
                        <input type="text" id="last_name" name="last_name" required value="Tomesh">
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
                        <input type="text" id="licensee_key" name="licensee_key" required value="NFDS-7A9C2E41-B4D8-4F1E-9C3A-8D72E6A91F20">
                        <br>
                        <button type="submit" id="button_submit">Register</button>
                    </form> 
                    <div>
                        <span class="error_message"><?php echo htmlspecialchars($errorMessage); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>