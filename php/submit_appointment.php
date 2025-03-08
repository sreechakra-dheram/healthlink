<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medpro";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$patientName = $_POST['patientName'];
$patientEmail = $_POST['patientEmail'];
$patientnum = $_POST['patientnum'];
$appointmentDate = $_POST['appointmentDate'];
$appointmentTime = $_POST['appointmentTime'];
$doctorID = $_POST['doctorSelect'];

// Insert data into the database
$sql = "INSERT INTO appointments (patient_name, patient_email,Mobile_Number, appointment_date, appointment_time, doctor_id) 
        VALUES ('$patientName', '$patientEmail','$patientnum', '$appointmentDate', '$appointmentTime', '$doctorID')";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Appointment booked successfully!'); window.location.href='appointment.php';</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
