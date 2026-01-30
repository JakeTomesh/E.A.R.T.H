<?php 
    session_start();
    $message = isset($_SESSION['user_message']) ? $_SESSION['user_message'] : '';
    unset($_SESSION['user_message']);
    $errorMessage = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
    unset($_SESSION['error_message']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'include/head.php'; ?>
    <link rel="stylesheet" href="styles/login.css">
</head>

<body>
    <header>
        <?php include 'include/header.php';?>
    </header>
    <main>
        <div id="site_container" class="background_img">
            <div id="login_container">
                <div id="title">
                    <h1>E.A.R.T.H</h1>
                    <h2>Emission and Resource Tracking Hub</h2>
                </div>
                <div><span><?php echo htmlspecialchars($message); ?></span></div>
                <div id="form_login">
                    <form action="user_manager/index.php" method="POST">
                        <input type="hidden" name="controllerRequest" value="user_login">
                    
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" required>
                        <br>
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" required>
                        <br>
                        <button type="submit" id="button_submit">Login</button>
                    </form>
                    <?php
                        if(isset($errorMessage) && !empty($errorMessage)){
                            echo '<span class="error_message">' . htmlspecialchars($errorMessage) . '</span>';
                        }
                    ?>
                    
                </div>
                <div id="links">
                    <a href="forgot_password.php">Forgot Password?</a>
                    <a href="register.php">Register a company</a>
                </div>
                <a href="user_manager/index.php?controllerRequest=user_register_nav">Register</a>
            </div>
        </div>
    </main>
</body>
</html>