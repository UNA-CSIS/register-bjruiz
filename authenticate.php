<?php

// start session
session_start();
include "validate.php";
// login to the softball database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "softball";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user']) && isset($_POST['pwd'])) {
    $user = test_input($_POST['user']);
    $pwd = test_input($_POST['pwd']);

// select password from users where username = <what the user typed in>
    $stmt = $conn->prepare("SELECT password FROM users WHERE username= ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
// output data of each row
        $stmt->bind_result($verify);
        $stmt->fetch();

        if (password_verify($pwd, $verify)) {
            $_SESSION['user'] = $user;
            header("Location: index.php");
            exit;
        } else {
            header("Location: index.php");
            exit;
        }
    } else {
        header("Location: index.php");
        exit;
    }
    $stmt->close();
// if no rows, then username is not valid (but don't tell Mallory) just send
// her back to the login
// otherwise, password_verify(password from form, password from db)
// if good, put username in session, otherwise send back to login
}
$conn->close();

?>