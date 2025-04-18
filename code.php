<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include("dbCon.php");

session_start(); // Start or resume the session






if (isset($_SESSION['staffName'])) {
    // Include the dbCon.php file
    require 'dbCon.php';

    // Retrieve the staff's ID
    $staffID = $_SESSION['staffID'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updatePassword'])) {
        $currentPassword = $_POST['currentPassword'];
        $newPassword = $_POST['newPassword'];
        $confirmNewPassword = $_POST['confirmNewPassword'];

        // Query the database to get the current password
        $query = "SELECT staffPassword FROM yamiraku_staff WHERE StaffID = ?";
        $stmt = mysqli_prepare($db, $query);
        mysqli_stmt_bind_param($stmt, "i", $staffID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            $storedPassword = $row['staffPassword'];

            if ($currentPassword === $storedPassword) {
                if ($newPassword === $confirmNewPassword) {
                    // Update the password in the database
                    $updateQuery = "UPDATE yamiraku_staff SET staffPassword = ? WHERE StaffID = ?";
                    $stmt = mysqli_prepare($db, $updateQuery);
                    mysqli_stmt_bind_param($stmt, "si", $newPassword, $staffID);
                    
                    if (mysqli_stmt_execute($stmt)) {
                        echo '<script>alert("Password Updated Successfully.");</script>';
                echo '<script>window.location = "setting.php";</script>';
                    } else {
                        echo '<script>alert("Password Updated Failed.");</script>';
                echo '<script>window.location = "setting.php";</script>';
                    }
                } else {
                    echo '<script>alert("New Password and Confirm Password not Match");</script>';
                echo '<script>window.location = "setting.php";</script>';
                }
            } else {
                echo '<script>alert("Current Password is incorrect");</script>';
                echo '<script>window.location = "setting.php";</script>';
            }
        } else {
            echo '<script>alert("User Not Found");</script>';
                echo '<script>window.location = "setting.php";</script>';
        }
    }
}




if (isset($_POST['delete_Application'])) {
    // Get the application ID from the POST data
    $app_ID = $_POST['app_ID'];

    $query = "DELETE FROM application WHERE appID = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "i", $app_ID);

    if (mysqli_stmt_execute($stmt)) {
        // Redirect to the application page after successful deletion
        header("Location: application.php");
        exit;
    } else {
        echo 'error'; // Return 'error' if the deletion fails
    }
    
}



if (isset($_POST['updateApplication'])) {
    $app_ID = mysqli_real_escape_string($db, $_POST['appID']);
    $firstName = mysqli_real_escape_string($db, $_POST['firstName']);
    $lastName = mysqli_real_escape_string($db, $_POST['lastName']);
    $gender = mysqli_real_escape_string($db, $_POST['gender']);
    $contact = mysqli_real_escape_string($db, $_POST['contact']);
    $address = mysqli_real_escape_string($db, $_POST['address']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $jobID = mysqli_real_escape_string($db, $_POST['jobID']);
    $processID = mysqli_real_escape_string($db, $_POST['processID']);
    $coverLetter = mysqli_real_escape_string($db, $_POST['coverLetter']);

    // Handle file upload
    if (!empty($_FILES['resumePath']['name'])) {
        $targetPath = "C:/laragon/www/fyp/uploads/" . $targetFileName; // Specify the directory where you want to save the uploaded files
        $targetFileName = basename($_FILES['resumePath']['name']);
        $targetPath = $targetDirectory . $targetFileName;

        if (move_uploaded_file($_FILES['resumePath']['tmp_name'], $targetPath)) {
            // File uploaded successfully, update the resumePath in the database
            $query = "UPDATE application SET firstName='$firstName', lastName='$lastName', gender='$gender', contact='$contact', address='$address', email='$email', jobID='$jobID', processID='$processID', coverLetter='$coverLetter', resumePath='$targetPath' WHERE appID='$app_ID'";
            $query_run = mysqli_query($db, $query);

            if ($query_run) {
                echo '<script>alert("Application Updated Successfully.");</script>';
                echo '<script>window.location = "application.php";</script>';
                exit;
            } else {
                echo '<script>alert("Application Update Failed.");</script>';
            }
        } else {
            echo '<script>alert("File upload failed.");</script>';
        }
    } else {
        // Resume file was not updated, update other fields only
        $query = "UPDATE application SET firstName='$firstName', lastName='$lastName', gender='$gender', contact='$contact', address='$address', email='$email', jobID='$jobID', processID='$processID', coverLetter='$coverLetter' WHERE appID='$app_ID'";
        $query_run = mysqli_query($db, $query);

        if ($query_run) {
            echo '<script>alert("Application Updated Successfully.");</script>';
            echo '<script>window.location = "application.php";</script>';
            exit;
        } else {
            echo '<script>alert("Application Update Failed.");</script>';
        }
    }
}





if (isset($_GET['app_ID'])) {
    $app_ID = mysqli_real_escape_string($db, $_GET['app_ID']);

    $query = "SELECT a.appID, a.firstName, a.lastName, a.gender, a.contact, a.address, a.email, a.jobID, a.processID, a.coverLetter, a.resumePath, v.VacancyPosition
              FROM application a
              JOIN vacancy v ON a.jobID = v.vacancyID
              WHERE a.appID = '$app_ID'";
    $query_run = mysqli_query($db, $query);

    if (mysqli_num_rows($query_run) == 1) {
        $application = mysqli_fetch_assoc($query_run);

        // Build an array with the fields you want to return
        $responseData = [
            'status' => 200,
            'data' => $application,
            'message' => "Application fetched Successfully",
        ];

        // Encode the array as JSON
        echo json_encode($responseData);
        return false;
    } else {
        $res = [
            'status' => 404,
            'message' => "Application ID not Found",
        ];
        echo json_encode($res);
        return false;
    }
    // Regardless of the condition, redirect to the application page
header('Location: application.php');
}






/*--------------- Application  ------------- */

if (isset($_POST['add_Application'])) {
    include("dbCon.php"); // Include your database connection code

    // Get data from the form
    $jobID = $_POST['jobID'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $gender = $_POST['Gender'];
    $email = $_POST['Email'];
    $contact = $_POST['Contact'];
    $address = $_POST['Address'];
    $coverLetter = $_POST['coverLetter'];

 // File Upload Handling
$targetDirectory = "C:/laragon/www/fyp/uploads/";
$targetFile = $targetDirectory . uniqid() . '_' . $_FILES['resumePath']['name'];

if (move_uploaded_file($_FILES['resumePath']['tmp_name'], $targetFile)) {
    // File upload successful

    // Insert application data into the database
    $query = "INSERT INTO application (jobID, firstName, lastName, gender, email, contact, address, coverLetter, resumePath) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($db, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "issssssss", $jobID, $firstName, $lastName, $gender, $email, $contact, $address, $coverLetter, $targetFile);

        if (mysqli_stmt_execute($stmt)) {
            // Insert was successful
            echo '<script>alert("Application Added Successfully.");</script>';
            echo '<script>window.location = "application.php?status=success";</script>';
        } else {
            // Database insertion failed
            echo '<script>alert("Application Added Failed. Please try again later.");</script>';
            echo '<script>window.location = "application.php?status=fail";</script>';
        }
    } else {
        // Statement preparation failed
        echo '<script>alert("Application Added Failed. Please try again later.");</script>';
        echo '<script>window.location = "application.php?status=fail";</script>';
    }
} else {
    // File upload failed, handle the error
    echo '<script>alert("File upload failed. Please try again later.");</script>';
    echo '<script>window.location = "application.php?status=fail";</script>';
}
}

/*
if (isset($_GET['app_id'])) {
    $appID = mysqli_real_escape_string($db, $_GET['appID']); // Change 'vacancy_id' to 'appID'

    $query = "SELECT appID, firstName, lastName, gender, email, contact, address, coverLetter, resumePath FROM application WHERE appID = '$appID'"; // Adjust the SQL query for the 'application' table
    $query_run = mysqli_query($db, $query);

    if (mysqli_num_rows($query_run) == 1) {
        $application = mysqli_fetch_assoc($query_run);

        $res = [
            'status' => 200,
            'data' => $application, // Include the application data in the response
            'message' => "Application fetched Successfully",
        ];
        echo json_encode($res);
        return false;
    } else {
        $res = [
            'status' => 404,
            'message' => "Application ID not Found",
        ];
        echo json_encode($res);
        return false;
    }
}




*/










/*-----------Vacancy --------------  */


if (isset($_POST['updateVacancy'])) {
    $vacancy_id = mysqli_real_escape_string($db, $_POST['vacancy_id']);
    $vacancyPosition = mysqli_real_escape_string($db, $_POST['vacancyPosition']);
    $vacancyLocation = mysqli_real_escape_string($db, $_POST['vacancyLocation']);
    $vacancyType = mysqli_real_escape_string($db, $_POST['vacancyType']);
    $vacancyStatus = mysqli_real_escape_string($db, $_POST['vacancyStatus']);
    $vacancyDesc = mysqli_real_escape_string($db, $_POST['vacancyDesc']);

    // Perform the update
    $query = "UPDATE vacancy SET vacancyPosition='$vacancyPosition', vacancyLocation='$vacancyLocation', vacancyType='$vacancyType', vacancyStatus='$vacancyStatus', vacancyDesc='$vacancyDesc' WHERE vacancyID='$vacancy_id'";
    $query_run = mysqli_query($db, $query);

    if ($query_run) {
        echo '<script>alert("Vacancy Updated Successfully.");</script>';
        echo '<script>window.location = "vacancy.php";</script>';
    exit;
    } else {
        echo '<script>alert("Vacancy Updated Fail.");</script>';
    }
}



if (isset($_GET['vacancy_id'])) {
    $vacancy_id = mysqli_real_escape_string($db, $_GET['vacancy_id']);

    $query = "SELECT vacancyID, vacancyPosition, vacancyLocation, vacancyType, vacancyStatus, vacancyDesc FROM vacancy WHERE vacancyID = '$vacancy_id'";
    $query_run = mysqli_query($db, $query);

    if (mysqli_num_rows($query_run) == 1) {
        $vacancy = mysqli_fetch_assoc($query_run);

        $res = [
            'status' => 200,
            'data' => $vacancy, // Include the data in the response
            'message' => "Vacancy fetched Successfully",
        ];
        echo json_encode($res);
        return false;
    } else {
        $res = [
            'status' => 404,
            'message' => "Vacancy Id not Found",
        ];
        echo json_encode($res);
        return false;
    }
}


if (isset($_POST['add_Vacancy'])) {
    include("dbCon.php"); // Include your database connection code

    $vacancyPosition = $_POST['vacancyPosition'];
    $vacancyLocation = $_POST['vacancyLocation'];
    $vacancyType = $_POST['vacancyType'];
    $vacancyDesc = $_POST['vacancyDesc'];
    

    $query = "INSERT INTO vacancy (vacancyPosition, vacancyLocation, vacancyType, vacancyDesc) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "ssss", $vacancyPosition, $vacancyLocation, $vacancyType, $vacancyDesc);

    if (mysqli_stmt_execute($stmt)) {
        // Insert was successful, show a success alert using JavaScript
        echo '<script>alert("Vacancy Added Successfully.");</script>';
        echo '<script>window.location = "vacancy.php";</script>';
    } else {
        echo '<script>alert("Vacancy Added Failed.");</script>';
    }
    
}


if (isset($_POST['delete_Vacancy'])) {
    // Get the vacancy ID from the POST data
    $vacancy_id = $_POST['vacancy_id'];

    $query = "DELETE FROM vacancy WHERE vacancyID = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "i", $vacancy_id);

    if (mysqli_stmt_execute($stmt)) {
        location.reload();
    } else {
        echo 'error'; // Return 'error' if the deletion fails
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the application data from the form
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $coverLetter = $_POST['coverLetter'];
    $jobID = $_POST['jobID'];

    // Handle file upload for the resume
    if (isset($_FILES['resume']) && $_FILES['resume']['error'] === UPLOAD_ERR_OK) {
        $resumeFileName = $_FILES['resume']['name'];
        $resumePath = 'uploads/' . $resumeFileName; // Adjust the path as needed

        // Move the uploaded file to the desired location
        move_uploaded_file($_FILES['resume']['tmp_name'], $resumePath);
    }

    // Include your database connection code here
    require 'dbCon.php';

    // Prepare the SQL query to insert the application data
    $query = "INSERT INTO application (firstName, lastName, gender, email, contact, address, coverLetter, resumePath, jobID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "ssssssssi", $firstName, $lastName, $gender, $email, $contact, $address, $coverLetter, $resumePath, $jobID);

    // Execute the query
    if (mysqli_stmt_execute($stmt)) {
        // Application data inserted successfully
        echo '<script>alert("Vacancy Successfully Applied! Pay Attention To Your Email For Result.");</script>';
        echo '<script>window.location = "career.php";</script>';
    } else {
        // Error handling for database insertion
        echo '<script>alert("Vacancy Failed to Apply!");</script>';
        echo '<script>window.location = "career.php";</script>';
    }
}











?>
