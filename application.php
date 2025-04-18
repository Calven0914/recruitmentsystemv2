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
    $query = "SELECT image FROM yamiraku_staff WHERE StaffID = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "i", $staffID); // Assuming StaffID is an integer
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    // Get the image path
    $imagePath = $row['image'];


    


?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Application</title>
    <link rel="shortcut icon" type="icon" href="img/favicon.ico">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<script src="https://kit.fontawesome.com/a168cf4844.js" crossorigin="anonymous"></script>
<script src="https://cdn.canvasjs.com/ga/canvasjs.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<link rel="stylesheet" href="style.css">


      

</head>

<body style="background: url(img/wallpaper.jpeg) 100% fixed;">

<!---------Side Navigation ---------->
    <div class="sidebar">
        <ul class="ps-0">
            <li class="dash-logo ">
                <a href="dashboard.php">
                    <span class="icon"><img src="img/favicon.jpg"></ion-icon></span>
                    <span class="text">Yamiraku</span>
                </a>
            </li>
            <li>
                <a href="dashboard.php">
                    <span class="icon "><ion-icon name="analytics-outline"></ion-icon></span>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            
            <li class="active">
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
           <!-- <li>
                <a href="#">
                    <span class="icon"><ion-icon name="person-outline"></ion-icon></span>
                    <span class="text">Users</span>
                </a>
            </li>  -->
            <li>
                <a href="setting.php">
                    <span class="icon"><ion-icon name="cog-outline"></ion-icon></span>
                    <span class="text">Setting</span>
                </a>
            </li>
            <div class="bottom">
                <li>
                    <a href="setting.php">
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

    <!--Application content --->
    <div class="container">
    <h1 class="text-white">Application Management <button class="btn btn-info pl-5" data-bs-toggle="modal" data-bs-target="#addApplicationModal">Add Application</button></h1>
    
    <div class="card-body">
    <!-- Vacancy Table -->
    <table id="myTable" class="table table-striped table-bordered table-responsive  table-hover mt-3">
        <thead>
            <tr>
                <th>Application ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Gender</th>
                <th>Email</th>
                <th>Contact</th>
                <th>JobID</th>
                <th>Process ID</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
    <!-- PHP code to populate the table with data from the "vacancy" table -->
    <?php
    require 'dbCon.php';

    $query = "SELECT application.appID, application.firstName, application.lastName, application.gender, application.email, application.contact, application.jobID, application.processID, vacancy.vacancyPosition, hirestatus.statusLabel
          FROM application
          LEFT JOIN vacancy ON application.jobID = vacancy.vacancyID
          LEFT JOIN hirestatus ON application.processID = hirestatus.id";
$query_run = mysqli_query($db, $query);

if (mysqli_num_rows($query_run) > 0) {
    foreach ($query_run as $application) {
        ?>
        <tr>
            <td style="width: 10px;"><?php echo $application['appID']; ?></td>
            <td style="width: 90px;"><?php echo $application['firstName']; ?></td>
            <td style="width: 40px;"><?php echo $application['lastName']; ?></td>
            <td style="width: 60px;"><?php echo $application['gender']; ?></td>
            <td style="width: 80px;"><?php echo $application['email']; ?></td>
            <td style="width: 90px;"><?php echo $application['contact']; ?></td>
            <td style="width: 90px;"><?php echo $application['vacancyPosition']; ?></td>
            <td style="width: 90px;"><?php echo $application['statusLabel']; ?></td>
            <td style="width: 150px;"> 

                <a href="" class="viewApplication" data-value="<?=$application['appID']?>">
                    <i class="fa-regular fa-eye" style="padding-left: 5px; font-size: 25px; text-decoration:none;"></i></a>

                    <a href="" class="editApplication" data-value="<?=$application['appID']?>">
                    <i class=" fa-regular fa-pen-to-square edit-icon" style="padding-left: 5px; font-size: 25px; text-decoration:none;"></i></a>
                
                    <a href="" class="deleteApplication" data-value="<?=$application['appID']?>">
                    <i class=" fa-solid fa-trash edit-icon" style="padding-left: 5px; font-size: 25px; text-decoration:none;"></i></a>

                    <a href="mailto:<?=$application['email']?>" data-value="<?=$application['appID']?>">
                     <i class="fa-regular fa-envelope" style="padding-left: 5px; font-size: 25px; text-decoration:none;"></i>
</a>


                </td>
        </tr>
    <?php
    }
}

?>
</tbody>
</table>
</div>
</div>


<!-- Add Application Modal -->
<div class="modal fade" id="addApplicationModal" tabindex="-1" role="dialog" aria-labelledby="ApplicationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-black" id="viewApplicationModalLabel">Add Application</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addApplicationForm<?php echo $application['appID']; ?>" action="code.php" method="post" enctype="multipart/form-data">
                <div class="modal-body">
    
                   <div class="mb-3">
                   <label for="Job">Job</label>
                    <select name="jobID" class="form-control">
                        <option value="" disabled selected>Select Vacancy Position</option>
                        <?php
                        // Fetch and display available vacancy positions from your database
                        $query = "SELECT vacancyID, vacancyPosition FROM vacancy";
                        $result = mysqli_query($db, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<option value='" . $row['vacancyID'] . "'>" . $row['vacancyPosition'] . "</option>";
                        }
                        ?>
                    </select>
                </div>

                   <div class="mb-3">
                        <label for="firstName">First Name</label>
                        <input type="text" name="firstName" class="form-control" placeholder="Enter First Name" required/>
                   </div>

                   <div class="mb-3">
                        <label for="lastName">Last Name</label>
                        <input type="text" name="lastName" class="form-control" placeholder="Enter Last Name" required/>
                   </div>



                    <div class="mb-3">
                        <label for="gender">Gender</label>
                        <select name="Gender" class="form-select">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="email">Email</label>
                        <input type="email" name="Email" class="form-control" placeholder="Enter Email" email.required/>
                   </div>

                   <div class="mb-3">
                        <label for="contact">Contact</label>
                        <input type="text" name="Contact" class="form-control" placeholder="Enter Contact" required/>
                   </div>

                   <div class="mb-3">
                        <label for="Address">Address</label>
                        <textarea name="Address"  class="form-control" required></textarea>
                        
                    </div>

                    <div class="mb-3">
                        <label for="coverLetter">Cover Letter</label>
                        <textarea name="coverLetter"  class="form-control" placeholder="Optional"></textarea>
                        
                    </div>

                    <div class="mb-3">
                    <label for="resumePath">Resume (Picture Format ONLY!)</label>
                    <input type="file" name="resumePath" class="form-control-file">
                </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="add_Application" class="btn btn-primary">Add Vacancy</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Edit Application Modal -->
<div class="modal fade" id="editApplicationModal" tabindex="-1" role="dialog" aria-labelledby="editApplicationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-black" id="editApplicationModalLabel">Edit Application</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="updateApplication" action="code.php" method="post" enctype="multipart/form-data">
                <div class="modal-body">

               

                <div class="mb-3">
                        <label for="jobID">Job ID</label>
                        <select name="jobID" id="jobID" class="form-select">
                        <option value="" disabled selected>Select Application Position</option>
                        <?php
                        // Fetch and display available vacancy positions from your database
                        $query = "SELECT vacancyID, vacancyPosition FROM vacancy";
                        $result = mysqli_query($db, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<option value='" . $row['vacancyID'] . "'>" . $row['vacancyPosition'] . "</option>";
                        }
                        ?>
                    </select>
                        
                    </div>

                   <div class="mb-3">
                   <label for="Job">App ID</label>
                   <input type="text" name="appID" id="app_ID" class="form-control">
                        
                   
                </div>

                   <div class="mb-3">
                        <label for="firstName">First Name</label>
                        <input type="text" name="firstName" id="firstName" class="form-control" required />
                   </div>

                   <div class="mb-3">
                        <label for="lastName">Last Name</label>
                        <input type="text" name="lastName" id="lastName" class="form-control" required/>
                   </div>



                    <div class="mb-3">
                        <label for="gender">Gender</label>
                        <select name="gender" id="gender" class="form-select">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Enter Email" required/>
                   </div>

                   <div class="mb-3">
                        <label for="contact">Contact</label>
                        <input type="text" name="contact" id="contact" class="form-control" placeholder="Enter Contact" required/>
                   </div>

                   <div class="mb-3">
                        <label for="Address">Address</label>
                        <textarea name="address" id="address"  class="form-control" required></textarea>
                        
                    </div>

                    <div class="mb-3">
                        <label for="coverLetter">Cover Letter</label>
                        <textarea name="coverLetter" id ="coverLetter"  class="form-control"></textarea>
                        
                    </div>

                    <div class="mb-3">
                        <label for="processID">Process</label>
                        <select name="processID" id="processID" class="form-select">
                            <option value="" disabled>Select Process</option>
                            <?php
                            // Fetch and display available hire status labels from your database
                            $query = "SELECT id, statusLabel FROM hirestatus";
                            $result = mysqli_query($db, $query);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='" . $row['id'] . "'>" . $row['statusLabel'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>


                    <div class="mb-3">
                        <label for="resumePath">Resume (PDF/PNG ONLY!)</label>
                        <input type="file" name="resumePath" id="resumePath" class="form-control-file">
                    </div>

                    <div class="mb-3">
                        <label>Download Resume</label>
                        <a id="downloadResumeLink" href="" style="display: none" download>Download Resume</a>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="updateApplication"  class="btn btn-primary">Edit Vacancy</button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- View Application Modal -->
<div class="modal fade" id="viewApplicationModal" tabindex="-1" role="dialog" aria-labelledby="viewApplicationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-black" id="viewApplicationModalLabel">View Application</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form  action="code.php" method="post" enctype="multipart/form-data">
                <div class="modal-body">

               

                <div class="mb-3">
                        <label for="jobID">Job ID</label>
                        <select name="jobID" id="view_jobID" class="form-control" readonly>
                        <option value="" disabled selected>Select Application Position</option>
                        <?php
                        // Fetch and display available vacancy positions from your database
                        $query = "SELECT vacancyID, vacancyPosition FROM vacancy";
                        $result = mysqli_query($db, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<option value='" . $row['vacancyID'] . "'>" . $row['vacancyPosition'] . "</option>";
                        }
                        ?>
                    </select>
                        
                    </div>

                   <div class="mb-3">
                   <label for="Job">App ID</label>
                   <input type="text" name="appID" id="view_app_ID" class="form-control" readonly>
                        
                   
                </div>

                   <div class="mb-3">
                        <label for="firstName">First Name</label>
                        <input type="text" name="firstName" id="view_firstName" class="form-control" readonly />
                   </div>

                   <div class="mb-3">
                        <label for="lastName">Last Name</label>
                        <input type="text" name="lastName" id="view_lastName" class="form-control" readonly/>
                   </div>



                    <div class="mb-3">
                        <label for="gender">Gender</label>
                        <select name="gender" id="view_gender" class="form-control" readonly>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="view_email" class="form-control" placeholder="Enter Email" readonly/>
                   </div>

                   <div class="mb-3">
                        <label for="contact">Contact</label>
                        <input type="text" name="contact" id="view_contact" class="form-control" placeholder="Enter Contact" readonly/>
                   </div>

                   <div class="mb-3">
                        <label for="Address">Address</label>
                        <textarea name="address" id="view_address"  class="form-control" readonly></textarea>
                        
                    </div>

                    <div class="mb-3">
                        <label for="coverLetter">Cover Letter</label>
                        <textarea name="coverLetter" id ="view_coverLetter"  class="form-control" readonly></textarea>
                        
                    </div>

                    <div class="mb-3">
                        <label for="processID">Process</label>
                        <select name="processID" id="view_processID" class="form-control" readonly>
                            <option value="" disabled>Select Process</option>
                            <?php
                            // Fetch and display available hire status labels from your database
                            $query = "SELECT id, statusLabel FROM hirestatus";
                            $result = mysqli_query($db, $query);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='" . $row['id'] . "'>" . $row['statusLabel'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>











<script>
$(document).on('click', '.deleteApplication', function(e) {
    e.preventDefault();
    var app_ID = $(this).data('value'); // Get the app_ID from the data attribute

    if (confirm('Are you sure you want to delete this Application?')) {
        // The user confirmed, proceed with the deletion
        $.ajax({
            type: "POST",
            url: "code.php",
            data: { 
                delete_Application: true,
                app_ID: app_ID, // Use 'app_ID' to match the key in your PHP code
            },
            success: function(response) {
                if (response === 'success') {
                    // Reload the page on successful deletion
                    window.location.href = 'application.php';
                }
            }
        });
    }
});











$(document).on('click', '.viewApplication', function(e) {
    e.preventDefault();
    var app_ID = $(this).data('value'); // Use the correct data attribute name

    $.ajax({
        type: "GET",
        url: "code.php?app_ID=" + app_ID,
        success: function(response) {
            console.log('Response: ' + response); // Debugging statement
            var res = jQuery.parseJSON(response);
            if (res.status == 422) {
                alert(res.message);
            } else if (res.status == 200) {
                $('#view_app_ID').val(res.data.appID);
                $('#view_firstName').val(res.data.firstName);
                $('#view_lastName').val(res.data.lastName);
                $('#view_gender').val(res.data.gender);
                $('#view_contact').val(res.data.contact);
                $('#view_address').val(res.data.address);
                $('#view_email').val(res.data.email);
                $('#view_jobID').val(res.data.jobID); // Check the ID attribute in your HTML
                $('#view_processID').val(res.data.processID); // There's no processID field in your HTML
                $('#view_coverLetter').val(res.data.coverLetter);

                $('#viewApplicationModal').modal('show');
            }
        },
        error: function() {
            console.log("Error occurred during the AJAX request.");
        }
    });
});



  $(document).on('click', '.editApplication', function(e) {
    e.preventDefault();
    console.log('Edit button clicked'); // Debugging statement
    var app_ID = $(this).data('value'); // Use the correct data attribute name
    console.log('app_ID: ' + app_ID); // Debugging statement

    $.ajax({
        type: "GET",
        url: "code.php?app_ID=" + app_ID,
        success: function(response) {
            console.log('Response: ' + response); // Debugging statement
            var res = jQuery.parseJSON(response);
            var resumePath = res.data.resumePath;
            var downloadLink = $('#downloadResumeLink');
            downloadLink.attr('href', resumePath).show();
            if (res.status == 422) {
                alert(res.message);
            } else if (res.status == 200) {
                $('#app_ID').val(res.data.appID);
                $('#firstName').val(res.data.firstName);
                $('#lastName').val(res.data.lastName);
                $('#gender').val(res.data.gender);
                $('#contact').val(res.data.contact);
                $('#address').val(res.data.address);
                $('#email').val(res.data.email);
                $('#jobID').val(res.data.jobID); // Check the ID attribute in your HTML
                $('#processID').val(res.data.processID); // There's no processID field in your HTML
                $('#coverLetter').val(res.data.coverLetter);

                $('#editApplicationModal').modal('show');
            }
        },
        error: function() {
            console.log("Error occurred during the AJAX request.");
        }
    });
});



</script>

</body>
</html>