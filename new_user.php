<?php

// session start here...
session_start();
include "validate.php";
// get all 3 strings from the form (and scrub w/ validation function)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $newUser = test_input($_POST['newUser']);
    $newPwd = test_input($_POST['pwd']);
    $repeatPwd = test_input($_POST['repeat']);

// make sure that the two password values match!
    if ($newPwd !== $repeatPwd) {
        echo "Passwords do not match";
        exit;
    }
// create the password_hash using the PASSWORD_DEFAULT argument
    $hashedPwd = password_hash($newPwd, PASSWORD_DEFAULT);

// login to the database
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

    $stmt = $conn->prepare("SELECT username FROM users WHERE username= ?");
    $stmt->bind_param("s", $newUser);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        header("Location: new_user.php?error=username_exists");
        exit;
    } else {
        $insertStmt = $conn->prepare("INSERT INTO users (username, password) VALUES(?, ?)");
        $insertStmt->bind_param("ss", $newUser, $hashedPwd);

        if ($insertStmt->execute()) {
            $_SESSION['user'] = $newUser;
            header("Location: index.php");
            exit;
        } else {
            echo "Error: " . $insertStmt->error;
        }
        $insertStmt->close();
    }

    // make sure that the new user is not already in the database
    // insert username and password hash into db (put the username in the session
    // or make them login)
    $stmt->close();
    $conn->close();
}
?>

