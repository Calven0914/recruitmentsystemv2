<?php
include 'dbCon.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $location = $_POST['location'];
    $jobType = $_POST['jobType'];

    // Initialize an empty WHERE clause for filtering
    $whereClause = "1"; // Always true to select all rows by default

    // Check if a location filter is selected
    if (!empty($location)) {
        $whereClause = "vacancyLocation = ?";
    }

    // Check if a job type filter is selected
    if (!empty($jobType)) {
        // Add the AND keyword if a location filter was also selected
        if (!empty($location)) {
            $whereClause .= " AND ";
        }
        $whereClause .= "vacancyType = ?";
    }

    // Prepare the SQL query with the dynamic WHERE clause
    $query = "SELECT * FROM vacancy WHERE $whereClause";

    $stmt = $db->prepare($query);

    // Bind parameters conditionally
    if (!empty($location) && !empty($jobType)) {
        $stmt->bind_param("ss", $location, $jobType);
    } elseif (!empty($location)) {
        $stmt->bind_param("s", $location);
    } elseif (!empty($jobType)) {
        $stmt->bind_param("s", $jobType);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $vacancies = array();
    while ($row = $result->fetch_assoc()) {
        $vacancies[] = $row;
    }

    echo json_encode($vacancies);
}
?>
