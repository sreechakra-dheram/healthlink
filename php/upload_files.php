<?php
// upload_files.php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file'];
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    $fileExt = strtolower(end(explode('.', $fileName)));
    $allowed = array('pdf', 'jpg', 'jpeg', 'png');

    if (in_array($fileExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 1000000) {
                $fileNameNew = uniqid('', true) . "." . $fileExt;
                $fileDestination = 'uploads/medical_files/' . $fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);
                echo "<script>alert('File uploaded successfully');</script>";
            } else {
                echo "<script>alert('File is too big');</script>";
            }
        } else {
            echo "<script>alert('There was an error uploading your file');</script>";
        }
    } else {
        echo "<script>alert('Invalid file type');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Medical Files</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <form action="upload_files.php" method="POST" enctype="multipart/form-data">
            <h2>Upload Medical Files</h2>
            <label for="file">Select File:</label>
            <input type="file" name="file" id="file" required>

            <button type="submit" name="submit">Upload</button>
        </form>
        <p><a href="account_info.php">Go to Account Info</a></p>
        <p><a href="news_upload.php">Go to News Upload</a></p>
    </div>
</body>
</html>
