<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); // Starting Session

include("dbCon.php");

if (isset($_POST['add_data'])) {
    $jobID = $_POST['position']; // Get the selected vacancyID as the jobID
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $coverletter = $_POST['coverletter'];

    // Check if a file was uploaded
    if (isset($_FILES['resume'])) {
        $file = $_FILES['resume'];

        // Validate and sanitize file name
        $filename = uniqid() . '-' . basename($file['name']);
        $uploads_dir = 'uploads/'; // Define your target directory

        if (move_uploaded_file($file['tmp_name'], $uploads_dir . $filename)) {
            // File uploaded successfully
            $resumePath = $uploads_dir . $filename;

            $insert_query = "INSERT INTO application(jobID ,firstName, lastName, gender, email, contact, address, coverLetter, resumePath) 
                            VALUES ('$jobID','$firstname', '$lastname', '$gender', '$email', '$contact', '$address', '$coverletter', '$resumePath')";

            $insert_query_run = mysqli_query($db, $insert_query);

            if ($insert_query_run) {
                $_SESSION['message'] = "Application Added Successfully";
                header("Location: application.php");
                exit(0);
            } else {
                $_SESSION["message"] = "Application Not Added";
                header("Location: application.php");
                exit(0);
            }
        } else {
            // File upload failed
            echo "Error: " . mysqli_error($db);
        }
    }
}
?>
