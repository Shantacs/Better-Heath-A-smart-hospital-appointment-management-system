<?php
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'patient') {
    header("Location: ../login.php");
    exit();
}

include_once "../../models/ScheduleModel.php";

if (!isset($_GET['doctor_id'])) {
    echo "Doctor not specified.";
    exit();
}

$doctor_id = intval($_GET['doctor_id']);
$scheduleModel = new ScheduleModel($doctor_id);
$schedule = $scheduleModel->getWeeklySchedule();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Doctor Schedule</title>
    <link rel="stylesheet" href="../../assets/styles/view_schedule.css">
</head>

<body>
    <div class="dashboard-header">
        <h1>Doctor’s Weekly Schedule</h1>
        <p>Check available times to book your appointment</p>
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="error-message" style="color: red;">
                <?php 
                echo htmlspecialchars($_SESSION['error_message']); 
                unset($_SESSION['error_message']);
                ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="dashboard-section">
        <table class="schedule-table">
            <thead>
                <tr>
                    <th>Day</th>
                    <th>Status</th>
                    <th>Time</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $days = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];

                foreach ($days as $day):
                    $daySchedule = $schedule[$day] ?? null;
                    $available = $daySchedule['available'] ?? false;
                    $start = $daySchedule['start'] ?? null;
                    $end = $daySchedule['end'] ?? null;
                ?>
                    <tr class="<?php echo $available ? 'available' : 'unavailable'; ?>">
                        <td><?php echo ucfirst($day); ?></td>
                        <td>
                            <span class="status-badge <?php echo $available ? 'status-active' : 'status-banned'; ?>">
                                <?php echo $available ? 'Available' : 'Unavailable'; ?>
                            </span>
                        </td>
                        <td>
                            <?php echo $available ? htmlspecialchars($start . " - " . $end) : "N/A"; ?>
                        </td>
                        <td>
                            <?php if ($available): ?>
                                <button class="btn-book"
                                    data-doctor="<?php echo $doctor_id; ?>"
                                    data-day="<?php echo $day; ?>"
                                    data-start="<?php echo $start; ?>"
                                    data-end="<?php echo $end; ?>">
                                    Book Appointment
                                </button>
                            <?php else: ?>
                                <button class="btn-book disabled" disabled>Not Available</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Booking Modal -->
    <div id="bookingModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Book Appointment</h2>

            <form id="bookingForm" action="../../controllers/AppointmentController.php" method="GET">
                <input type="hidden" name="doctor_id" id="doctorIdInput">
                <input type="hidden" name="action" id="actionInput" value="request">
                <input type="hidden" name="requested_datetime" id="requestedDateTimeInput">
                <input type="hidden" name="day" id="dayInput">


                <label for="time">Select Time:</label>
                <input type="time" name="time" id="timeInput" required>

                <label for="condition">Health Condition:</label>
                <textarea name="condition" id="conditionInput" rows="3" required></textarea>

                <button type="submit" class="btn-submit">Confirm Appointment</button>
            </form>
        </div>
    </div>


    <script src="../../assets/scripts/view_schedule.js"></script>
</body>

</html>