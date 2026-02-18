<?php 
    require_once '../include/bootstrap.php';
    require_once '../include/auth.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../include/head.php'; ?>
    <link rel="stylesheet" href="styles/admin_menu.css">
</head>
<body>
    <header>
        <?php include '../include/header.php'; ?>
    </header>
    <main>
        <div id="container" class="background_img">
            <div id="title_container">
                <div id="title">
                    <h1>E.A.R.T.H</h1>
                    <h2>Emission and Resource Tracking Hub</h2>
                    <div id="user_nav_div">
                        <a href="dashboard_manager/index.php?controllerRequest=dashboard_nav" 
                        id="back" class="btn">Back to Dashboard</a>
                        <a href="user_manager/index.php?controllerRequest=user_logout" 
                        id="logout" class="btn">Logout</a>
                    </div>
                </div>
            </div>
            <div id="animated_line"></div>
            <div id="admin_menu_container">
                <h2 id="page_title">Admin Menu</h2>
                <?php
                    $userMessage = $_SESSION['user_message'] ?? '';
                    unset($_SESSION['user_message']);
                ?>
                <?php if($userMessage): ?>
                    <div id="admin_menu_message">
                        <span class="user_message"><?php echo htmlspecialchars($userMessage); ?></span>
                    </div>
                <?php endif; ?>
                <div id="admin_menu_options">
                    <a href="user_manager/index.php?controllerRequest=user_register_nav" class="dashboard_menu_item">
                        <div>
                            <h3>Register new user</h3>
                        </div>
                    </a>
                    <a href="emission_manager/index.php?controllerRequest=manage_thresholds_nav" class="dashboard_menu_item">
                        <div>
                            <h3>Manage Thresholds</h3>
                        </div>
                    </a>
                    <a href="emission_manager/index.php?controllerRequest=manage_emission_factors_nav" class="dashboard_menu_item">
                        <div>
                            <h3>Manage Emission Factors</h3>
                        </div>
                    </a>
                </div>
                <div id="admin_menu_user_container">
                    <form action="user_manager/index.php" method="POST" id="admin_user_search_form">
                        <input type="hidden" name="controllerRequest" value="admin_user_search">
                        <h3>User Search</h3>
                        <div id="admin_user_search">
                            <input type="text" id="search_input" name="search_term" placeholder="Search by name or email...">
                            <button type="submit" class="btn" class="secondary_text" >Search</button>
                        </div>
                    </form>
                    <table>
                        <thead>
                            <tr>
                                <th>User ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Active Status</th>
                                <th>Date Created</th>
                                <th>Date Updated</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($companyUsers as $user): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($user->getId()); ?></td>
                                    <td><?php echo htmlspecialchars($user->getFirstName()); ?></td>
                                    <td><?php echo htmlspecialchars($user->getLastName()); ?></td>
                                    <td><?php echo htmlspecialchars($user->getEmail()); ?></td>
                                    <td><?php 
                                        $role = $user->getRole();
                                        if($role == 1){
                                            echo "Standard User";
                                        } else if($role == 2){
                                            echo "Admin User";
                                        } else {
                                            echo "Unknown Role";
                                        }
                                    ?></td>
                                    <td><?php 
                                        if($user->getIsActive()== 1){
                                            echo "Active";
                                        } else if($user->getIsActive() == 0){
                                            echo "Inactive";
                                        }
                                    ?></td>
                                    <td><?php echo htmlspecialchars(date('m-d-Y', strtotime($user->getDateCreated()))); ?></td>
                                    <td><?php echo htmlspecialchars(date('m-d-Y', strtotime($user->getDateUpdated()))); ?></td>
                                    <td><a id="edit_user" class="btn" href="user_manager/index.php?controllerRequest=edit_user_nav&user_id=<?php echo htmlspecialchars($user->getId()); ?>">Edit</a></td>
                                </tr>
                            <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </main>
</body>
</html>