<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'include/head.php'; ?>
</head>
<header>
    <?php include 'include/header.php'; ?>
</header>
<body>
    <main>
        <div id="container">
            <div id="login_container">
                <div id="title">
                    <h1>E.A.R.T.H</h1>
                    <h2>Emission and Resource Tracking Hub</h2>
                </div>
                <div id="form_login">
                    <form action="user_manager/index.php" method="POST">
                        <input type="hidden" name="controllerRequest" value="user_login">
                    
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" required>
                        <br>
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" required>
                        <br>
                        <button type="submit">Login</button>
                    </form>
                </div>
                <div id="links">
                    <a href="forgot_password.php">Forgot Password?</a>
                    <a href="register.php">Register a company</a>
                </div>

            </div>
        </div>
    </main>
</body>
</html>