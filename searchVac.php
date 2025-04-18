<?php
require 'dbCon.php';

if (isset($_POST['input'])) {
    $input = $_POST['input'];

    $query = "SELECT * FROM vacancy WHERE vacancyPosition LIKE '%$input%' OR vacancyLocation LIKE '%$input%'";
    $result = mysqli_query($db, $query);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            // Display the filtered vacancies in the desired card format
            echo '<div class="row mb-3">';
            echo '<div class="col-md-15 mx-4">';
            echo '<div class="card vacancy-list text-white size-4 active" style="width: 88%; height: 300px;">';
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
    }
}
?>
