<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["image"])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if the file is an image
    if (getimagesize($_FILES["image"]["tmp_name"])) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // File uploaded successfully, now call the Python script for face detection
            $input_image_path = $target_file;
            $output_image_path = $target_dir . "output_" . uniqid() . ".jpg";
            
            $python_script_path = "path_to_detect_faces.py";
            $command = "python " . $python_script_path . " " . $input_image_path . " " . $output_image_path;
            exec($command);

            // Save the image details (filename and path) to MySQL database
            $servername = "localhost";
            $username = "your_mysql_username";
            $password = "your_mysql_password";
            $dbname = "your_database_name";
            
            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $filename = basename($output_image_path);
            $sql = "INSERT INTO images (filename, filepath) VALUES ('$filename', '$output_image_path')";
            
            if ($conn->query($sql) === true) {
                echo "Image uploaded and faces detected successfully.";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $conn->close();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "File is not an image.";
    }
}
?>
