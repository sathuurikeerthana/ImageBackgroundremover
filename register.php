<?php
$servername = "localhost";
$username = "your_mysql_username";
$password = "your_mysql_password";
$dbname = "community_forum";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_POST["username"];
$email = $_POST["email"];
$password = $_POST["password"];

$sql = "INSERT INTO users (username, email, password) 
        VALUES ('$username', '$email', '$password')";

if ($conn->query($sql) === TRUE) {
    echo "Registration successful.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
