<?php 
    require_once '../include/bootstrap.php';
    require_once '../include/auth.php'; 

    $oldInput = $_SESSION['old_input'] ?? [];

    $selectedEmissionTypeId = $oldInput['emission_type'] ?? '';
    $selectedUnitTypeId = $oldInput['unit_type'] ?? '';
    $unitQuantity = $oldInput['unit_quantity'] ?? '';
    $emissionStartDate = $oldInput['emission_start_date'] ?? '';
    $emissionEndDate = $oldInput['emission_end_date'] ?? '';
    $notes = $oldInput['notes'] ?? '';
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
                    <div id="user_nav_div">
                        <a href="dashboard_manager/index.php?controllerRequest=dashboard_nav" 
                        id="back" class="btn">Back to Dashboard</a>
                        <a href="user_manager/index.php?controllerRequest=user_logout" 
                        id="logout" class="btn">Logout</a>
                    </div>
                </div>
            </div>
            <div id="animated_line"></div>
            <div id="emission_input_container">
                <div id="emission_input_error_container">
                    <?php
                        //display any error messages from previous submission attempt
                        if(isset($_SESSION['error_message'])){
                            echo '<span class="error_message" id="error_message">' . htmlspecialchars($_SESSION['error_message']) . '</span>';
                            unset($_SESSION['error_message']);
                        }
                        //display pop up alert with input message and alert message if triggered
                        if(isset($_SESSION['show_popup']) && $_SESSION['show_popup']){
                            if (isset($_SESSION['alert_message'])) {
                                $message = $_SESSION['alert_message'] . ' ' . $_SESSION['input_message'];
                                echo '<script>alert(' . json_encode($message) . ');</script>';
                            } else {
                                echo '<script>alert(' . json_encode($_SESSION['input_message']) . ');</script>';
                            }
                            unset($_SESSION['show_popup']);
                            $_SESSION['show_popup'] = false;
                            unset($_SESSION['alert_message']);
                            unset($_SESSION['input_message']);
                        }
                    ?>
                </div>
                <h2 id="page_title">Emission Input Form</h2>
                <form action="emission_manager/index.php" method="POST">
                    <input type="hidden" name="controllerRequest" value="submit_emission_input">
                    <div id="fieldset_container">
                        <fieldset id="emission_type_fieldset">
                            <legend>Emission Type:</legend>
                            <select class="input" name="emission_type" id="emission_type_select" required>

                                <option value=""<?php echo empty($selectedEmissionTypeId) ? ' selected' : ''; ?> disabled hidden> - Select an Emission Type - </option>

                                <?php foreach($emissionTypes as $emissionType): ?>
                                    <option 
                                        value="<?php echo htmlspecialchars($emissionType['id']); ?>"
                                        data-base-unit-type-id="<?php echo htmlspecialchars($emissionType['base_unit_type_id']); ?>"
                                        <?php echo (isset($selectedEmissionTypeId) && $selectedEmissionTypeId == $emissionType['id']) ? ' selected' : ''; ?>>
                                        <?php echo htmlspecialchars($emissionType['name']); ?>
                                    </option>
                                <?php endforeach; ?>

                            </select>
                        </fieldset>
                        <fieldset id="unit_type_fieldset">
                            <legend>Unit Quantity & Unit Type:</legend>
                            <div id="unit_quantity">
                                <input class="input" type="number"  name="unit_quantity" min="0" step=".01" placeholder="00.00" value="<?php echo htmlspecialchars($unitQuantity); ?>" required>
                            </div>
                            <select class="input" name="unit_type" id="unit_type_select" required disabled>

                                <option value="" selected disabled hidden> - Select a Unit Type - </option>

                                <?php foreach($unitTypes as $unitType): ?>
                                    <option value="<?php echo htmlspecialchars($unitType['id']); ?>"
                                        data-base-unit-type-id="<?php echo htmlspecialchars($unitType['base_unit_type_id']); ?>"
                                        data-unit-code="<?php echo htmlspecialchars($unitType['code']); ?>"
                                        <?php echo (isset($selectedUnitTypeId) && $selectedUnitTypeId == $unitType['id']) ? ' selected' : ''; ?>>
                                        <?php echo htmlspecialchars($unitType['name']); ?>
                                    </option>
                                <?php endforeach; ?>

                            </select>
                        </fieldset>
                        <fieldset id="datetime_fieldset">
                            <legend>Emission Date - Start/End:</legend>
                            <div>
                                <label for="emission_start_date">Start:</label>
                                <input class="input" id="start_datepicker" type="date" name="emission_start_date" max="<?= date('Y-m-d') ?>" value="<?php echo htmlspecialchars($emissionStartDate); ?>" required>
                            </div>
                            <div>
                                <label for="emission_end_date">End:</label>
                                <input class="input" id="end_datepicker" type="date" name="emission_end_date" max="<?= date('Y-m-d') ?>" value="<?php echo htmlspecialchars($emissionEndDate); ?>" required>
                            </div>
                        </fieldset>
                        <fieldset id="notes_fieldset">
                            <legend>Notes:</legend>
                            <textarea name="notes" rows="4" cols="50" placeholder="Specific notes about this emission log..."><?php echo htmlspecialchars($notes); ?></textarea>
                        </fieldset>
                    </div>
                    <button type="submit" id="submit">Submit Emission Data</button>
                </form>
                <?php unset($_SESSION['old_input']); ?>
            </div>
        </div>
    </main>
    <script src="js/unit_type_enforcer.js"></script>
    <footer>
        <?php include('../include/footer.php'); ?>
    </footer>
</body>
</html>