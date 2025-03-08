<?php
session_start();
include('db_connection.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "Session is not set!";
    exit();
}
$user_id = $_SESSION['user_id'];

// Fetch user data from the database
$sql = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
} else {
    echo "User not found!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Information - Secure MediCloud</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* Header Styling */
        header {
            background-color: #45a049;
            color: white;
            padding: 15px 0;
            text-align: center;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        header h1 {
            margin: 0;
            font-size: 2rem;
            font-family: 'Arial', sans-serif;
        }

        header h2 {
            margin: 5px 0 10px;
            font-size: 1.2rem;
            font-weight: 400;
            font-style: italic;
        }

        nav {
            background-color: #45a049;
            padding: 10px 0;
        }

        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        nav ul li {
            display: inline;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-size: 1rem;
            font-family: 'Arial', sans-serif;
            transition: color 0.3s;
        }

        nav ul li a:hover {
            color: #d4d4d4;
        }

        /* Account Info Section */
        .container {
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 800px;
        }

        .container h2 {
            font-size: 1.8rem;
            color: #333;
        }

        .container p {
            font-size: 1.2rem;
            color: #555;
        }

        .container a {
            color: #45a049;
            font-weight: bold;
            text-decoration: none;
        }

        .container a:hover {
            text-decoration: underline;
        }

        /* Footer Styling */
        footer {
            background-color: #4CAF50;
            color: white;
            text-align: center;
            padding: 15px 0;
            position: relative;
            bottom: 0;
            width: 100%;
            font-family: 'Arial', sans-serif;
            font-size: 0.9rem;
        }

        footer p {
            margin: 5px 0;
        }

        footer a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        footer a:hover {
            text-decoration: underline;
        }
    </style>
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
</head>
<body>
    <!-- Header -->
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

    <h2>Welcome to your Secure MediCloud account page! Here you can view and manage your personal health information and other related settings.</h2>

    <!-- Account Information Section -->
    <div class="container">
        <h2>Your Account Information</h2>
        <p>Name: <?php echo htmlspecialchars($user['name']); ?></p>
        <p>Mobile: <?php echo htmlspecialchars($user['mobile']); ?></p>
        <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
        <button><a href="logout.php">Logout</a></button>
    </div>

    <p>If you need to update your personal details or account settings, please contact our support team at [support@securemedicloud.com].</p>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Secure MediCloud. All rights reserved.</p>
        <p><a href="/privacy-policy">Privacy Policy</a> | <a href="/terms">Terms of Service</a></p>
    </footer>

</body>
</html>

