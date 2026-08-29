<?php
// session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'doctor') {
    header("Location: ../login.php");
    exit();
}

?>

<?php

// default values
$weekly_schedule = [
    'sunday' => ['start' => '', 'end' => '', 'available' => false],
    'monday' => ['start' => '', 'end' => '', 'available' => false],
    'tuesday' => ['start' => '', 'end' => '', 'available' => false],
    'wednesday' => ['start' => '', 'end' => '', 'available' => false],
    'thursday' => ['start' => '', 'end' => '', 'available' => false],
    'friday' => ['start' => '', 'end' => '', 'available' => false],
    'saturday' => ['start' => '', 'end' => '', 'available' => false]
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Better Health | Doctor Schedule</title>
    <link rel="stylesheet" href="../../assets/styles/schedule.css">
</head>

<body>
    <div class="dashboard-header">
        <h1>My Weekly Schedule</h1>
        <p>Manage your availability and set your weekly consultation hours</p>
    </div>

    <div class="dashboard-section">
        <h2>Weekly Availability</h2>
        <form id="scheduleForm" method="POST" action="../../controllers/scheduleController.php">

            <div class="schedule-days" id="scheduleDaysContainer">
                <?php foreach ($weekly_schedule as $day => $schedule): ?>
                    <div class="schedule-day-card <?php echo $schedule['available'] ? 'available' : 'unavailable'; ?>">
                        <div class="day-header">
                            <h3><?php echo ucfirst($day); ?></h3>
                            <label class="switch">
                                <input type="checkbox" name="available[<?php echo $day; ?>]"
                                    <?php echo $schedule['available'] ? 'checked' : ''; ?>>
                                <span class="slider round"></span>
                            </label>
                        </div>

                        <div class="time-inputs" style="display: <?php echo $schedule['available'] ? 'block' : 'none'; ?>">
                            <div class="form-group">
                                <label>Start Time</label>
                                <input type="time" class="form-control" name="start_time[<?php echo $day; ?>]"
                                    value="<?php echo $schedule['start']; ?>"
                                    <?php echo $schedule['available'] ? '' : 'disabled'; ?>>
                            </div>

                            <div class="form-group">
                                <label>End Time</label>
                                <input type="time" class="form-control" name="end_time[<?php echo $day; ?>]"
                                    value="<?php echo $schedule['end']; ?>"
                                    <?php echo $schedule['available'] ? '' : 'disabled'; ?>>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Save Schedule</button>
            </div>
        </form>
    </div>

    <div class="dashboard-section">
        <h2>Schedule Preview</h2>
        <div class="schedule-preview">
            <div class="preview-header">
                <h3>Your Weekly Schedule</h3>
                <p>This is how your schedule appears to patients</p>
            </div>

            <div class="preview-content">
                <?php foreach ($weekly_schedule as $day => $schedule): ?>
                    <div class="preview-day">
                        <strong><?php echo ucfirst($day); ?>:</strong>
                        <?php if ($schedule['available']): ?>
                            <span><?php echo $schedule['start']; ?> - <?php echo $schedule['end']; ?></span>
                        <?php else: ?>
                            <span class="unavailable-text">Not available</span>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script src="../../assets/scripts/doctor_schedule.js"></script>
</body>

</html>