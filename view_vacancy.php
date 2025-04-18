
<!DOCTYPE html>
<html>
<head>
    <title>View Vacancy</title>
    <link rel="shortcut icon" type="icon" href="img/favicon.ico">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://kit.fontawesome.com/a168cf4844.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body style="background: url(img/wallpaper.jpeg) 100% no-repeat">

<header class="header">
        <a href="index.html" class="logo"><img src="img/logo.png" alt="Yamiraku" height="80px weight 100px"></a>

        <nav class="navbar">
            <a href="index.html">Home</a>
            <a href="about.html">About</a>
            <a href="lesson.html"  >Lesson</a>
            <a href="contact.html">Contact</a>
            <a href="career.php" class="active">Career</a>
            <a href="login.php">Login</a>
            
            
        
        </nav> 
        

    </header>








    <div class="container pt-5 mt-5">
    <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="card text-center" style="width: 60%;">
            <div class="card-body text-white">
                <h2 class="card-title"></h2><br>
                <?php
// Check if the 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    // Get the vacancy ID from the URL
    $vacancyID = $_GET['id'];

    // Include your database connection code here
    require 'dbCon.php';

    // Query the database to retrieve vacancy details, including vacancyStatus
    $query = "SELECT vacancyPosition, vacancyDesc, vacancyType, vacancyStatus FROM vacancy WHERE vacancyID = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "i", $vacancyID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        // Check if the vacancy is active (vacancyStatus == 1)
        if ($row['vacancyStatus'] == 1) {
            // Display vacancy details with adjusted font sizes
            echo '<h2 class="card-title">' . $row['vacancyPosition'] . '</h2>';
            echo '<p class="card-text" style="font-size: 20px;"><strong>Vacancy Type:</strong> ' . $row['vacancyType'] . '</p>';
            echo '<p class="card-text" style="font-size: 17px;"><strong>Description:</strong> ' . $row['vacancyDesc'] . '</p>';

            // Display the "Apply" button only if the vacancy is active
            echo '<button type="button" class="btn btn-info" data-toggle="modal" data-target="#applyModal">
                    Apply
                </button>';
        } else {
            echo '<h2 class="card-title">' . $row['vacancyPosition'] . '</h2>';
            echo '<p class="card-text fs-3 ">This vacancy is inactive and cannot be applied for.</p>';
        }
    } else {
        echo '<p class="card-text">Vacancy not found.</p>';
    }
} else {
    echo '<p class="card-text">Invalid request. Please provide a valid vacancy ID.</p>';
}
?>






                

            </div>
        </div>
    </div>
</div>


   <!-- Apply Modal -->
<div class="modal fade" id="applyModal" tabindex="-1" role="dialog" aria-labelledby="applyModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
            <h5 class="modal-title text-black" id="applyModalLabel">Apply for <?php echo $row['vacancyPosition']; ?></h5>
                <button type="hidden" class="btn-close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <form method="post" action="code.php" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="firstName">First Name</label>
                        <input type="text" class="form-control" id="firstName" name="firstName" required>
                    </div>
                    <div class="form-group">
                        <label for="lastName">Last Name</label>
                        <input type="text" class="form-control" id="lastName" name="lastName" required>
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select class="form-select" id="gender" name="gender"  >
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="contact">Contact</label>
                        <input type="text" class="form-control" id="contact" name="contact" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea class="form-control" id="address" name="address" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="coverLetter">Cover Letter</label>
                        <textarea class="form-control" id="coverLetter" name="coverLetter" placeholder="Optional"></textarea>
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="resume">Resume (PDF only)</label>
                        <input type="file" class="form-control-file" id="resume" name="resume" accept=".pdf" required>
                    </div>
                    <input type="hidden" name="jobID" value="<?php echo $vacancyID; ?>"> <!-- Pass the jobID as a hidden field -->
                    <br>
                    <!-- Button to submit the form inside the modal -->
                    <button type="submit" class="btn btn-primary">Submit Application</button>
                </form>
            </div>
        </div>
    </div>
</div>


</body>
</html>
