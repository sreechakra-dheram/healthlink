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

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Appointment Booking</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<header>
        <div class="nav-bar" >
            <h1 class="heading-nav">HEALTH-LINK</h1>
        </div>
        <div class="nav-barr">
            <div class="home" onclick="window.location.href='http://localhost/medi_project/php/medifiles.php'">
                <i class="fa-solid fa-house"></i>
                <p>Home</p>
            </div>
            <div class="home" onclick="window.location.href='http://localhost/medi_project/php/appointment.php'">
              <i class="fa-solid fa-user-doctor"></i>
              <p>Doctor</p>
          </div>
          <div class="home" onclick="window.location.href='../fitlifeforge files/vid.html'">
            <i class="fa-solid fa-video"></i>
            <p>Awareness</p>
        </div>
            <div class="home" onclick="window.location.href='../fitlifeforge files/chatbot.html'">
                <i class="fa-solid fa-message"></i>
                <p>Chatbot</p>
            </div>
            <div class="home" onclick="window.location.href='../fitlifeforge files/amb.html'">
              <i class="fa-solid fa-truck-medical"></i>
                <p>Ambulance</p>
            </div>
            <div class="home" onclick="window.location.href='http://localhost/medi_project/php/medifiles.php'">
                <i class="fa-solid fa-hospital-user"></i>
                <p>Files</p>
            </div>
            <div class="home" onclick="window.location.href='http://127.0.0.1:5000/lab_reports'">
                <i class="fa-solid fa-chart-simple"></i>
                <p>Analysis</p>
            </div>
            <div class="home" onclick="window.location.href='http://localhost/medi_project/templates/downloadreport.html'">
                <i class="fa-solid fa-notes-medical"></i>
                <p>H-log</p>
            </div>
            <div class="home" onclick="window.location.href='http://localhost/medi_project/php/news_view.php'">
                <i class="fa-solid fa-newspaper"></i>
                <p>News</p>
            </div>
            <div class="home" onclick="window.location.href='../fitlifeforge files/home.html'">
                <i class="fa-solid fa-square-caret-down"></i>
                <p>Features</p>
            </div>
            <div class="home" onclick="window.location.href='http://localhost/medi_project/php/account_info.php'">
                <i class="fa-solid fa-user"></i>
                  <p>Account</p>
              </div>
</header>
<style>
        *{
        margin: 0;
        padding: 0;
        font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
    }
    .navbar{
    height: 40px;
    background-color: black;
    color:white;
    display: flex;
    align-items: center;
    justify-content: space-evenly;
    margin: 0;
    padding: 0;
}
.heading-nav{
    font-family: cursive;
    text-align: center;
}
.nav-barr{
    height: 58px;
    width: 100%;
    background-color:#133869dd;
    display: flex;
    color: rgba(239, 234, 226, 0.87);
}
.home{
    padding: 10px;
    text-align: center;

}

.home p{
    font-family:cursive;
}
.doctor-consultation{
    padding: 10px;
    text-align: center;
    padding-left: 100px;
}

.doctor-consultation p{
    font-family:cursive;
}
.awareness{
    padding: 10px;
    text-align: center;
    padding-left: 100px;
}
.awareness i{
    font-size: 25px;

}
.awareness p{
    font-family:cursive;
    font-size: 15px;
}
.chat{
    padding: 10px;
    text-align: center;
    padding-left: 100px;
}
.chat i{
    font-size: 25px;
}
.chat p{
    font-family:cursive;
    font-size: 15px;
}
.ambulance{
    padding: 10px;
    text-align: center;
    padding-left: 100px;
}
.ambulance i{
    font-size: 25px;
}
.ambulance p{
    font-family:cursive;
    font-size: 15px;
}
.medical-record{
    padding: 10px;
    text-align: center;
    padding-left: 100px;
}
.medical-record i{
    font-size: 25px;
}
.medical-record p{
    font-family:cursive;
    font-size: 15px;
}
.accounts{
    padding: 10px;
    text-align: center;
    padding-left: 100px;
}
.accounts i{
    font-size: 25px;
}
.accounts p{
    font-family:cursive;
    font-size: 15px;
}
.nav-bar{
    background-color: #024751;
    color: antiquewhite;
    margin: 0px;
    padding: 0px;
}
    body{
      background-color: rgba(239, 234, 226, 0.87);
    }
    body, header, main, footer {
            margin: 0;
            padding: 0;
        }

        /* Styling footer */
        footer {
            background-color: #333;
            color: #fff;
            padding: 20px 0;
            text-align: center;
        }

        .footer-content {
            max-width: 800px; /* Adjust as needed */
            margin: 0 auto;
        }

        .footer-content p {
            margin: 5px 0;
        }

        .social-links {
            list-style: none;
            padding: 0;
            margin-top: 10px;
        }

        .social-links li {
            display: inline;
            margin-right: 10px;
        }

        .social-links li a {
            color: #fff;
            text-decoration: none;
            font-size: 18px;
        }
        .nav-bar {
    background-color: #024751;
    color: antiquewhite;
    padding: 10px; /* Adjust as needed */
    margin: 0; /* Ensure no extra margin */
}

.nav-barr {
    height: 58px;
    width: 100%;
    background-color: #133869dd;
    display: flex;
    color: rgba(239, 234, 226, 0.87);
    margin: 0;
    padding: 0;
}

 
    </style>
<body>
    <section class="container mt-5">
        <h2 class="text-center">Schedule an Appointment</h2>
        <form id="appointmentForm" action="submit_appointment.php" method="POST">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="patientName">Full Name</label>
                    <input type="text" class="form-control" name="patientName" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="patientEmail">Email</label>
                    <input type="email" class="form-control" name="patientEmail" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="patientnum">Mobile Number</label>
                    <input type="number" class="form-control" name="patientnum" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="appointmentDate">Date</label>
                    <input type="date" class="form-control" name="appointmentDate" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="appointmentTime">Time</label>
                    <input type="time" class="form-control" name="appointmentTime" required>
                </div>
            </div>
            <div class="form-group">
                <label for="doctorSelect">Select Doctor</label>
                <select name="doctorSelect" class="form-control" required>
                    <option value="" disabled selected>Choose...</option>
                    <?php while ($row = $doctors_result->fetch_assoc()) { ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
        </form>
    </section>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</body>
</html>
