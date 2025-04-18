<?php
session_start();
include("dbCon.php");

if (isset($_POST['btn'])) { // Assuming your submit button has name "btn"
    if (empty($_POST['staffName']) || empty($_POST['staffPassword'])) {
        $error = "Username or password is invalid";
        header("Location: login.php?error=" . urlencode($error)); // Redirect with an error message
        exit();
    } else {
        $staffName = $_POST['staffName'];
        $staffPassword = $_POST['staffPassword'];
        
        
        // After successful login
        $_SESSION['staffName'] = $staffName; // Set the staffName session variable
        
        $_SESSION['isLoggedIn'] = true; // Set a session variable to indicate the user is logged in

        // Use prepared statements to prevent SQL injection
        $query = "SELECT * FROM yamiraku_staff WHERE staffName = ? AND staffPassword = ?";
        $stmt = mysqli_prepare($db, $query);
        mysqli_stmt_bind_param($stmt, "ss", $staffName, $staffPassword);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            // A staff member with the specified credentials exists
            $_SESSION['staffID'] = $row['StaffID'];
            $_SESSION['staffName'] = $row['staffName'];

            // Redirect the user to the dashboard and exit the script
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "**Username or password is invalid";
            header("Location: login.php?error=" . urlencode($error)); // Redirect with an error message
            exit();
        }
    }
}


?>
