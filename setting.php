<?php
// Start or resume the session
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] !== true) {
    header('Location: login.php'); // Redirect to the login page
    exit;
}

// Check if the staffName session variable is set
if (isset($_SESSION['staffName'])) 

    // Include the dbCon.php file
    require 'dbCon.php';

    // Retrieve the staff's ID 
    $staffID = $_SESSION['staffID'];

    // Query the database to get the staff's image path
    $query = "SELECT * FROM yamiraku_staff WHERE StaffID = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "i", $staffID); // Assuming StaffID is an integer
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    // Get the image path
    $imagePath = $row['image'];
    


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Handle the image upload here
        if (isset($_FILES['newImage']) && $_FILES['newImage']['error'] === UPLOAD_ERR_OK) {
            $newImageData = file_get_contents($_FILES['newImage']['tmp_name']);

            // Update the BLOB data in the database
            $query = "UPDATE yamiraku_staff SET image = ? WHERE StaffID = ?";
            $stmt = mysqli_prepare($db, $query);
            mysqli_stmt_bind_param($stmt, "si", $newImageData, $staffID);
            if (mysqli_stmt_execute($stmt)) {
                // Image updated successfully
                echo '<div class="alert alert-success">Profile picture updated successfully.</div>';
                
            } else {
                echo '<div class="alert alert-danger">Failed to update profile picture.</div>';
            }
        }
    }



    



?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setting</title>
    <link rel="shortcut icon" type="icon" href="img/favicon.ico">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<!-- jQuery (required by Bootstrap) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<!-- Bootstrap JavaScript -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="style.css">
</head>

<body style="background: url(img/wallpaper.jpeg) 100% fixed;">

<!---------Side Navigation ---------->
    <div class="sidebar">
        <ul style="padding-left:0;">
            <li class="dash-logo">
                <a href="dashboard.php">
                    <span class="icon"><img src="img/favicon.jpg"></ion-icon></span>
                    <span class="text">Yamiraku</span>
                </a>
            </li>
            <li >
                <a href="dashboard.php">
                    <span class="icon "><ion-icon name="analytics-outline"></ion-icon></span>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="application.php">
                    <span class="icon"><ion-icon name="laptop-outline"></ion-icon></span>
                    <span class="text">Application</span>
                </a>
            </li>
            <li>
                <a href="vacancy.php">
                    <span class="icon"><ion-icon name="person-add"></ion-icon></span>
                    <span class="text">Vacancy</span>
                </a>
            </li>
            <li>
             <!--   <a href="#">
                    <span class="icon"><ion-icon name="person-outline"></ion-icon></span>
                    <span class="text">Users</span>
                </a>
            </li> -->
            <li class="active">
                <a href="setting.php" >
                    <span class="icon"><ion-icon name="cog-outline"></ion-icon></span>
                    <span class="text">Setting</span>
                </a>
            </li>
            <div class="bottom">
                <li>
                    <a href="">
                        <span class="icon"><div class="imgBx">
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($imagePath);  ?> " >
                        </div></span>
                        <span class="text">  
                            
                        <?php
                        // Start or resume the session
                            echo $_SESSION['staffName']; 
                        ?>
                             
                        </span>
                    </a>
                </li>
            
            <li>
                <a href="login.php?logout=1">
                    <span class="icon"><ion-icon name="log-out-outline"></ion-icon></span>
                    <span class="text">Logout</span>
                </a>
            </li>
        </div>
        </ul>
    </div>

    <!------------- Setting Content ------------------->
<div  style="padding-left:40%;" >
    <h1 style="font-size: 35px; color: white; padding-left:5%;">Update Profile</h1><br>
    
    <img src="data:image/jpeg;base64,<?php echo base64_encode($imagePath);  ?>" alt="Current Profile Picture" style="margin-left:10%;" width="150">
    <br> <br>


    <form method="post" style="margin-left:-9%;" enctype="multipart/form-data">
        <label style="font-size: 20px; color:white;" for="newImage">Upload a new profile picture:</label>
        <input style="font-size: 20px; color:white;" type="file" name="newImage" id="newImage" accept="image/jpeg, image/png, image/gif">
        <br><br>

        



        <button style="margin-left:9%;"  type="submit">Upload</button>
        <button type="button"  data-toggle="modal" data-target="#updatePassModal">
  Update Password
</button>
    </form>
    </div>


   <!-- Modal -->
<div class="modal fade" id="updatePassModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-black" id="exampleModalLabel">Update Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="code.php">
          <label for="currentPassword">Current Password:</label>
          <input type="password" name="currentPassword" id="currentPassword" required> <br>

          <label for="newPassword">New Password:</label>
          <input type="password" name="newPassword" id="newPassword" required>

          <label for="confirmNewPassword">Confirm New Password:</label>
          <input type="password" name="confirmNewPassword" id="confirmNewPassword" required>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="updatePassword" class="btn btn-primary">Save changes</button>
        </form>
      </div>
    </div>
  </div>
</div>




    

</body>



</html>