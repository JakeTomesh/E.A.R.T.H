<?php 
    require_once '../include/bootstrap.php';
    require_once '../include/auth.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../include/head.php'; ?>
    <link rel="stylesheet" href="styles/emission_input.css">
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
                    <div id="user_div">
                        <a href="dashboard_manager/index.php?controllerRequest=dashboard_nav" 
                        id="back" class="btn">Back to Dashboard</a>
                        <a href="user_manager/index.php?controllerRequest=user_logout" 
                        id="logout" class="btn">Logout</a>
                    </div>
                </div>
            </div>
            <div id="animated_line"></div>
            <div id="emission_input_container">
                <h2 id="page_title">Emission Input Form</h2>
                <form action="emission_manager/index.php" method="POST">
                    <input type="hidden" name="controllerRequest" value="submit_emission_input">
                    <div id="fieldset_container">
                        <fieldset id="emission_type_fieldset">
                            <legend>Emission Type:</legend>
                            <select class="input">
                                <option value="" selected disabled hidden> - Select an Emission Type - </option>
                                <?php foreach($emissionTypes as $emissionType): ?>
                                    <option value="<?php echo htmlspecialchars($emissionType['id']); ?>">
                                        <?php echo htmlspecialchars($emissionType['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </fieldset>
                        <fieldset id="unit_type_fieldset">
                            <legend>Unit Quantity & Unit Type:</legend>
                            <div id="unit_quantity">
                                <input class="input" type="number"  name="unit_quantity" min="0" placeholder="00.00" required>
                            </div>
                            <select class="input">
                                <option value="" selected disabled hidden> - Select a Unit Type - </option>
                                <?php foreach($unitTypes as $unitType): ?>
                                    <option value="<?php echo htmlspecialchars($unitType['id']); ?>">
                                        <?php echo htmlspecialchars($unitType['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </fieldset>
                        <fieldset id="datetime_fieldset">
                            <legend>Record Date/Time:</legend>
                            <input class="input" id="datepicker" type="date" name="record_datetime" max="<?= date('Y-m-d') ?>" required>
                        </fieldset>
                        <fieldset id="notes_fieldset">
                            <legend>Notes:</legend>
                            <textarea name="notes" rows="4" cols="50" placeholder="Specific notes about this emission log..."></textarea>
                        </fieldset>
                    </div>
                    <button type="submit" id="submit">Submit Emission Data</button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>