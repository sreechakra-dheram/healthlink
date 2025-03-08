<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload News - Secure MediCloud</title>
    <style>
        /* Header styling */
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

        /* News Upload Form Styling */
        .news-form-container {
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 800px;
        }

        .news-form-container form {
            display: flex;
            flex-direction: column;
        }

        .news-form-container input[type="text"],
        .news-form-container textarea,
        .news-form-container input[type="file"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }

        .news-form-container input[type="submit"] {
            padding: 10px 20px;
            background-color: #45a049;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
        }

        .news-form-container input[type="submit"]:hover {
            background-color: #388e3c;
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
</head>
<body>

    <!-- Header -->
    <header>
        <h1>HEALTH-LINK</h1>
        <h2>Your Trusted One Stop Medical Platform</h2>
        <nav>
            <ul>
                <li><a href="http://localhost/medi_project/php/medifiles.php">Medical Files</a></li>
                <li><a href="http://127.0.0.1:5000/lab_reports">Report Analysis</a></li>
                <li><a href="http://localhost/medi_project/templates/downloadreport.html">Health Log</a></li>
                <li><a href="http://localhost/medi_project/php/news_view.php">News</a></li>
                <li><a href="http://localhost/medi_project/php/account_info.php">Account</a></li>
            </ul>
        </nav>
    </header>

    <!-- News Upload Form Section -->
    <div class="news-form-container">
        <h2>Upload News</h2>

        <?php
        include('db_connection.php');

        // Check if form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = mysqli_real_escape_string($conn, $_POST['title']);
            $content = mysqli_real_escape_string($conn, $_POST['content']);
            $image = $_FILES['news_image']['name'];  // Get the file name

            // Set the target directory for uploading the image
            $target_dir = "../uploads/news_images/";
            $target_file = $target_dir . basename($image);

            // Check if the file is an image
            if (getimagesize($_FILES["news_image"]["tmp_name"]) !== false) {
                // Move the uploaded file to the target directory
                if (move_uploaded_file($_FILES["news_image"]["tmp_name"], $target_file)) {
                    echo "The file ". htmlspecialchars(basename($image)) . " has been uploaded.";

                    // Insert news into the database
                    $sql = "INSERT INTO news (title, content, image) VALUES ('$title', '$content', '$image')";

                    if (mysqli_query($conn, $sql)) {
                        echo " News saved successfully!";
                    } else {
                        echo "Error saving news: " . mysqli_error($conn);
                    }
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            } else {
                echo "File is not an image.";
            }
        }
        ?>

        <!-- HTML Form to Upload News -->
        <form method="POST" enctype="multipart/form-data">
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" required><br><br>
            
            <label for="content">Description:</label><br>
            <textarea name="content" id="content" rows="4" cols="50" required></textarea><br><br>
            
            <label for="news_image">Choose Image:</label>
            <input type="file" name="news_image" id="news_image" required><br><br>
            
            <input type="submit" value="Upload News">
        </form>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Secure MediCloud. All rights reserved.</p>
        <p><a href="/privacy-policy">Privacy Policy</a> | <a href="/terms">Terms of Service</a></p>
    </footer>

</body>
</html>
