<?php
require 'dbCon.php';

// Query to retrieve all vacancies
$query = "SELECT * FROM vacancy ORDER BY DATE(vacancyDate) DESC";
$result = $db->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Output HTML for each vacancy in the same format as your existing code
        echo '<div class="row mb-3">';
        echo '<div class="col-md-15 mx-4">';
        echo '<div class="card vacancy-list text-white size-4 ' . ($row['vacancyStatus'] == 1 ? 'active' : 'inactive') . '" style="width: 88%; height: 300px;">';
        echo '<div class="card-body text-center">';
        echo '<h3>' . $row['vacancyPosition'] . '</h3>';
        echo '<p>Location: ' . $row['vacancyLocation'] . '</p>';
        echo '<p>Type: ' . $row['vacancyType'] . '</p>';
        echo '<p>Desc: ' . $row['vacancyDesc'] . '</p>';
        echo '<p class="text-white ' . ($row['vacancyStatus'] == 1 ? 'bg-success' : 'bg-danger') . '">';
        echo 'Status: ' . ($row['vacancyStatus'] == 1 ? 'Active' : 'Inactive') . '</p>';
        echo '<a href="view_vacancy.php?id=' . $row['vacancyID'] . '" class="btn btn-info">View Details</a>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo "No vacancies found.";
}
?>
