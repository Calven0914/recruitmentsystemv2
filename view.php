<?
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

include("dbCon.php");

// Initialize the error message variable
$errorMsg = "";

// Check if 'appID' is set
if (isset($_GET['appID'])) {
    $appID = $_GET['appID'];

    // Perform a SQL query to retrieve application data along with vacancyPosition
    $query = "SELECT A.*, V.vacancyPosition FROM application A
              INNER JOIN vacancy V ON A.jobID = V.vacancyID
              WHERE A.appID = ?";

    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "i", $appID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $appData = mysqli_fetch_assoc($result);

            // Display application data
            echo "Position: " . $appData['vacancyPosition'] . "<br>";
            echo "First Name: " . $appData['firstName'] . "<br>";
            echo "Last Name: " . $appData['lastName'] . "<br>";
            echo "Gender: " . $appData['gender'] . "<br>";
            echo "Email: " . $appData['email'] . "<br>";
            echo "Contact: " . $appData['contact'] . "<br>";
            echo "Address: " . $appData['address'] . "<br>";
            echo "Cover Letter: " . $appData['coverLetter'] . "<br>";

            // You can also display the resume if it's stored as a file path in the database
            $resumePath = $appData['resumePath'];
            if (!empty($resumePath)) {
                echo '<a href="' . $resumePath . '" target="_blank">View Resume</a>';
            }
        } else {
            // Set an error message
            $errorMsg = "No data found for this application.";
        }
    } else {
        // Set an error message
        $errorMsg = "Error in the SQL query: " . mysqli_error($db);
    }
} else {
    $errorMsg = "No data found for this application.";
}

// Display the error message on the website
if (!empty($errorMsg)) {
    echo '<script>
        document.getElementById("error-message").innerHTML = "' . $errorMsg . '";
        document.getElementById("error-message").style.display = "block";
    </script>';
}
?>