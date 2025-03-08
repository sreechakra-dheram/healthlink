<?php
session_start();
$pdo = new PDO("mysql:host=localhost;dbname=medpro", "root", "");

// Secret key for encryption
define("SECRET_KEY", "rSPGnZc6QSW7cl_TAWXcvl9Pf54IXPzVqb0965cY6qc=");

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Please <a href='login.php'>login</a> to access your files.");
}

$user_id = $_SESSION['user_id'];

// Encryption function
function encryptFile($data)
{
    $key = base64_decode(SECRET_KEY);
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
    return base64_encode($iv . $encrypted);
}

// Decryption function
function decryptFile($data)
{
    $key = base64_decode(SECRET_KEY);
    $data = base64_decode($data);
    $iv_len = openssl_cipher_iv_length('aes-256-cbc');
    $iv = substr($data, 0, $iv_len);
    $encrypted_data = substr($data, $iv_len);
    return openssl_decrypt($encrypted_data, 'aes-256-cbc', $key, 0, $iv);
}

// Handle File Upload
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"])) {
    $category = $_POST["category"] ?? '';
    $file_name = $_FILES["file"]["name"];
    $file_tmp = $_FILES["file"]["tmp_name"];
    
    if (!empty($file_tmp)) {
        $file_data = file_get_contents($file_tmp);
        $encrypted_data = encryptFile($file_data);

        $stmt = $pdo->prepare("INSERT INTO medical_files (user_id, file_name, file_data, category) VALUES (?, ?, ?, ?)");
        $stmt->execute([$user_id, $file_name, $encrypted_data, $category]);

        echo "<p style='color:green;'>File uploaded successfully!</p>";
    } else {
        echo "<p style='color:red;'>File upload failed!</p>";
    }
}

// Handle File Download
if (isset($_GET['download'])) {
    $file_id = $_GET['download'];
    $stmt = $pdo->prepare("SELECT file_name, file_data FROM medical_files WHERE id = ? AND user_id = ?");
    $stmt->execute([$file_id, $user_id]);
    $file = $stmt->fetch();

    if ($file) {
        $decrypted_data = decryptFile($file['file_data']);
        header("Content-Disposition: attachment; filename=" . $file['file_name']);
        echo $decrypted_data;
        exit;
    } else {
        echo "<p style='color:red;'>Unauthorized access!</p>";
    }
}

// Handle File Deletion
if (isset($_GET['delete'])) {
    $file_id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM medical_files WHERE id = ? AND user_id = ?");
    $stmt->execute([$file_id, $user_id]);
    echo "<p style='color:red;'>File deleted successfully!</p>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Medical File Manager</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
 
    </style>
    <style>
        
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
        }
        
        form {
            background: white;
            padding: 20px;
            margin: 20px auto;
            width: 50%;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        input, select, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            background-color: #3498db;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #2980b9;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #3498db;
            color: white;
        }
        a {
            text-decoration: none;
            padding: 5px 10px;
            color: white;
            border-radius: 5px;
        }
        .download { background-color: green; }
        .delete { background-color: red; }
        .download:hover { background-color: darkgreen; }
        .delete:hover { background-color: darkred; }
    </style>
</head>
<body>
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
<h1>Secure Medical File Manager</h1>

<form action="" method="POST" enctype="multipart/form-data">
    <label for="file">Upload Medical File:</label>
    <input type="file" name="file" required>
    
    <label for="category">Category:</label>
    <select name="category" required>
        <option value="Prescription">Prescription</option>
        <option value="Lab Report">Lab Report</option>
        <option value="X-Ray">X-Ray</option>
        <option value="MRI Scan">MRI Scan</option>
    </select>
    
    <button type="submit">Upload File</button>
</form>

<h2>Your Uploaded Files</h2>

<table>
    <tr>
        <th>File Name</th>
        <th>Category</th>
        <th>Uploaded On</th>
        <th>Actions</th>
    </tr>
    <?php
    $stmt = $pdo->prepare("SELECT * FROM medical_files WHERE user_id = ? ORDER BY upload_time DESC");
    $stmt->execute([$user_id]);
    while ($row = $stmt->fetch()) {
        echo "<tr>
            <td>{$row['file_name']}</td>
            <td>{$row['category']}</td>
            <td>{$row['upload_time']}</td>
            <td>
                <a class='download' href='?download={$row['id']}'>Download</a>
                <a class='delete' href='?delete={$row['id']}' onclick='return confirm(\"Are you sure?\")'>Delete</a>
            </td>
        </tr>";
    }
    ?>
</table>

</body>
</html>
