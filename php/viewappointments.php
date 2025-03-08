<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "medpro");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch doctors from the database
$doctors_query = "SELECT * FROM doctors";
$doctors_result = $conn->query($doctors_query);

// Fetch appointments based on the selected doctor
$appointments = [];
if (isset($_POST['doctorSelect'])) {
    $doctorID = $_POST['doctorSelect'];
    $appointments_query = "SELECT * FROM appointments WHERE doctor_id = $doctorID ORDER BY appointment_date, appointment_time";
    $appointments_result = $conn->query($appointments_query);
    while ($row = $appointments_result->fetch_assoc()) {
        $appointments[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Appointments</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-light bg-light">
        <a class="navbar-brand" href="#">DoctorApp</a>
    </nav>

    <section class="container mt-5">
        <h2 class="text-center">View Appointments</h2>
        <form method="POST" class="mb-4">
            <div class="form-group">
                <label for="doctorSelect">Select Doctor</label>
                <select name="doctorSelect" class="form-control" required>
                    <option value="" disabled selected>Choose...</option>
                    <?php while ($row = $doctors_result->fetch_assoc()) { ?>
                        <option value="<?php echo $row['id']; ?>" <?php if(isset($doctorID) && $doctorID == $row['id']) echo 'selected'; ?>>
                            <?php echo $row['name']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">View Appointments</button>
        </form>

        <?php if (!empty($appointments)) { ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Patient Name</th>
                        <th>Email</th>
                        <th>Mobile Number</th>
                        <th>Date</th>
                        <th>Time</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($appointments as $appointment) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($appointment['patient_name']); ?></td>
                            <td><?php echo htmlspecialchars($appointment['patient_email']); ?></td>
                            <td><?php echo $appointment['Mobile_Number']; ?></td>
                            <td><?php echo $appointment['appointment_date']; ?></td>
                            <td><?php echo $appointment['appointment_time']; ?></td>
                            
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } elseif (isset($_POST['doctorSelect'])) { ?>
            <p class="text-center text-muted">No appointments found for the selected doctor.</p>
        <?php } ?>
    </section>

</body>
</html>