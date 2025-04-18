<?php
// Start or resume the session
session_start();

// Include the dbCon.php file
require 'dbCon.php';

// Check if the user is not logged in
if (!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] !== true) {
    header('Location: login.php'); // Redirect to the login page
    exit;
}

// Check if the staffName session variable is set
if (isset($_SESSION['staffName'])) {
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
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Vacancy</title>
    <link rel="shortcut icon" type="icon" href="img/favicon.ico">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<script src="https://kit.fontawesome.com/a168cf4844.js" crossorigin="anonymous"></script>
<script src="https://cdn.canvasjs.com/ga/canvasjs.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- Include TinyMCE from the CDN -->
<script src="https://cdn.tiny.cloud/1/ikq1vevl53q3cs3smvdue3vob8ieul8o5ribzc0hx6d1p2iv/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
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
            
            <li >
                <a href="application.php">
                    <span class="icon"><ion-icon name="laptop-outline"></ion-icon></span>
                    <span class="text">Application</span>
                </a>
            </li>
            <li class="active" >
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
            </li> -->
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



    <div class="container">
    <h1 class="text-white">Vacancy Management <button class="btn btn-info pl-5" data-bs-toggle="modal" data-bs-target="#addVacancyModal">Add Vacancy</button></h1>
    
    <div class="card-body">
    <!-- Vacancy Table -->
    <table id="myTable" class="table table-striped table-bordered table-responsive  table-hover mt-3">
        <!-- Update your table headers with Font Awesome icons for sorting -->
<thead>
    <tr>
        <th>
            Vacancy ID
            <i class="fa-solid fa-sort sort-button" data-column="0"></i>
        </th>
        <th>
            Position
            <i class="fa-solid fa-sort sort-button" data-column="1"></i>
        </th>
        <th>
            Location
            <i class="fa-solid fa-sort sort-button" data-column="2"></i>
        </th>
        <th>
            Type
            <i class="fa-solid fa-sort sort-button" data-column="3"></i>
        </th>
        <th>
            Status
            
        </th>
        <th>
            Description
            <i class="fa-solid fa-sort sort-button" data-column="5"></i>
        </th>
        <th>Actions</th>
    </tr>
</thead>

        <tbody>
    <!-- PHP code to populate the table with data from the "vacancy" table -->
    <?php
    require 'dbCon.php';

    $query = "SELECT * FROM vacancy";
    $query_run = mysqli_query($db, $query);

    if (mysqli_num_rows($query_run) > 0) {
        foreach ($query_run as $vacancy) {
            $statusClass = ($vacancy['vacancyStatus'] == 1) ? 'bg-success text-white' : 'bg-danger text-white';
            $statusText = ($vacancy['vacancyStatus'] == 1) ? 'Active' : 'Not Active';
            ?>
            <tr>
                <td style="width: 50px;"><?php echo $vacancy['vacancyID']; ?></td>
                <td style="width: 120px;"><?php echo $vacancy['vacancyPosition']; ?></td>
                <td style="width: 50px;"><?php echo $vacancy['vacancyLocation']; ?></td>
                <td style="width: 100px;"><?php echo $vacancy['vacancyType']; ?></td>
                <td style="width: 60px;" class="<?php echo $statusClass; ?> text-center"><?php echo $statusText; ?></td>
                <td style="max-width: 200px; height: 80px; overflow: hidden;  text-overflow: ellipsis; "><?php echo $vacancy['vacancyDesc']; ?></td>
                <td style="width: 150px;"> 

                <a href="" class="viewVacancy" data-vacancyid="<?=$vacancy['vacancyID']?>">
                    <i class="fa-regular fa-eye" style="padding-left: 5px; font-size: 25px; text-decoration:none;"></i></a>
                   
                    <a href=" " class="editVacancy" data-vacancyid="<?=$vacancy['vacancyID']?>">
                    <i class="editVacancy fa-regular fa-pen-to-square edit-icon" style="padding-left: 5px; font-size: 25px; text-decoration:none;"></i></a>

                    <a href="" class="deleteVacancy" data-vacancyid="<?=$vacancy['vacancyID']?>">
                    <i class=" fa-solid fa-trash edit-icon" style="padding-left: 5px; font-size: 25px; text-decoration:none;"></i></a>
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

<!-- Add Vacancy Modal -->
<div class="modal fade" id="addVacancyModal" tabindex="-1" role="dialog" aria-labelledby="addVacancyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Add Vacancy Form (You need to add form fields) -->
                <div class="modal-header">
                    <h5 class="modal-title text-black" id="addVacancyModalLabel">Add Vacancy</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form id="addVacancy" action="code.php" method="post">
                <div class="modal-body">
                    <div class="alert alert-warning d-none">

                    </div>


                   <div class="mb-3">
                    <label for="">Vacancy Position</label>
                    <input type="text" name="vacancyPosition" class="form-control" placeholder="Enter Vacancy Position" required/>
                   </div>
                   <div class="mb-3">
                        <label for="vacancyLocation">Vacancy Location</label>
                        <select name="vacancyLocation" class="form-select">
                            <option value="Muar">Muar</option>
                            <option value="Kepong">Kepong</option>
                            <option value="Rawang">Rawang</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="vacancyType">Vacancy Type</label>
                        <select name="vacancyType" class="form-select">
                            <option value="Full Time">Full Time</option>
                            <option value="Part Time">Part Time</option>
                            <option value="Intern">Intern</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="vacancyDesc">Vacancy Description</label>
                        <textarea name="vacancyDesc" id="vacancyDesc" class="form-control" required></textarea>
                        
                    </div>
            


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="add_Vacancy" class="btn btn-primary">Add Vacancy</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Vacancy Modal -->
<div class="modal fade" id="viewVacancyModal" tabindex="-1" role="dialog" aria-labelledby="viewVacancyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Edit Vacancy Form (You need to add form fields) -->
            
                <div  class="modal-header">
                    <h5 class="modal-title text-black" id="viewVacancyModalLabel">View Vacancy</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">                    
                    </button>
                </div>

                <form action="code.php" method="POST">
                <div class="modal-body">
                    <div class="alert alert-warning d-none" id="errorMessageUpdate"></div>

                    <div class="mb-3">
                        <label for="vacancyPosition">Vacancy Position</label>
                        <input type="text" name="vacancyPosition" id="view_vacancyPosition" class="form-control" readonly />
                    </div>

                    <div class="mb-3">
                        <label for="vacancyLocation">Vacancy Location</label>
                        <input type="text" name="vacancyLocation" id="view_vacancyLocation" class="form-control custom-select"  readonly>
                           
                    </div>

                    <div class="mb-3">
                        <label for="vacancyType">Vacancy Type</label>
                        <input type="text" name="vacancyType" id="view_vacancyType" class="form-control custom-select" readonly>
                            
                    </div>

                    <div class="mb-3">
                        <label for="vacancyStatus">Vacancy Status</label>
                        <input type="text" name="vacancyStatus" id="view_vacancyStatus" class="form-control" readonly />
                    </div>

                    <div class="mb-3">
                        <label for="vacancydesc">Vacancy Description</label>
                        <textarea name="vacancyDesc" id="view_vacancydesc" value="vacancydesc" class="form-control" readonly></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Edit Vacancy Modal -->
<div class="modal fade" id="editVacancyModal" tabindex="-1" role="dialog" aria-labelledby="editVacancyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Edit Vacancy Form (You need to add form fields) -->
            
                <div id="errorMessageUpdate" class="modal-header">
                    <h5 class="modal-title text-black" id="editVacancyModalLabel">Edit Vacancy</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">                    
                    </button>
                </div>

                <form action="code.php" method="POST">
                <div class="modal-body">
                    <div class="alert alert-warning d-none" id="errorMessageUpdate"></div>

                    <div class="mb-3">
                        <label for="vacancy_id">Vacancy ID</label>
                        <input type="text" name="vacancy_id" id="vacancy_id" class="form-control" readonly />
                    </div>

                    <div class="mb-3">
                        <label for="vacancyPosition">Vacancy Position</label>
                        <input type="text" name="vacancyPosition" id="vacancyPosition" class="form-control" required />
                    </div>

                    <div class="mb-3">
                        <label for="vacancyLocation">Vacancy Location</label>
                        <select name="vacancyLocation" id="vacancyLocation" class="form-control custom-select" multiple style="height: 75px;">
                            <option value="Muar">Muar</option>
                            <option value="Kepong">Kepong</option>
                            <option value="Rawang">Rawang</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="vacancyType">Vacancy Type</label>
                        <select name="vacancyType" id="vacancyType" class="form-control custom-select" multiple style="height: 75px;">
                            <option value="Full Time">Full Time</option>
                            <option value="Part Time">Part Time</option>
                            <option value="Intern">Intern</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="vacancyStatus">Vacancy Status</label>
                        <select type="text" name="vacancyStatus" id="vacancyStatus" class="form-select" />
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="vacancydesc">Vacancy Description</label>
                        <textarea name="vacancyDesc" id="vacancydesc" value="vacancydesc" class="form-control" required></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="updateVacancy" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>





















<script>

$(document).ready(function () {
        // Initially, sort in ascending order for all columns
        var sortOrders = Array(6).fill(1);

        $('.sort-button').on('click', function () {
            var column = $(this).data('column');
            sortOrders[column] *= -1; // Toggle sorting order (1 for ASC, -1 for DESC)
            sortTable(column, sortOrders[column]);
        });

        function sortTable(column, order) {
            var $table = $('#myTable');
            var rows = $table.find('tbody > tr').get();

            rows.sort(function (a, b) {
                var keyA = $(a).children('td').eq(column).text();
                var keyB = $(b).children('td').eq(column).text();

                if (column === 4) { // Handle sorting for the "Status" column
                    keyA = keyA === 'Active' ? 1 : 0;
                    keyB = keyB === 'Active' ? 1 : 0;
                }

                return (keyA.localeCompare(keyB)) * order;
            });

            $.each(rows, function (index, row) {
                $table.find('tbody').append(row);
            });
        }
    });
 

 

  $(document).on('click', '.editVacancy', function(e) {
    e.preventDefault();
    var vacancy_id = $(this).data('vacancyid'); // Use data() to access the data attribute
    console.log("Clicked with vacancy_id: " + vacancy_id); // Debugging statement

    $.ajax({
        type: "GET",
        url: "code.php?vacancy_id=" + vacancy_id,
        success: function (response) {
            console.log("AJAX response: " + response); // Debugging statement
            var res = jQuery.parseJSON(response);
            if (res.status == 422) {
                alert(res.message);
            } else if (res.status == 200) {
                // Populate the modal with the vacancy details here
                $('#vacancy_id').val(res.data.vacancyID);
                $('#vacancyPosition').val(res.data.vacancyPosition);
                $('#vacancyLocation').val(res.data.vacancyLocation);
                $('#vacancyType').val(res.data.vacancyType);
                $('#vacancyStatus').val(res.data.vacancyStatus);
                $('#vacancydesc').val(res.data.vacancyDesc);

                $('#editVacancyModal').modal('show');
            }
        }
    });
});



$(document).on('click', '.viewVacancy', function(e) {
    e.preventDefault();
    var vacancy_id = $(this).data('vacancyid'); // Use data() to access the data attribute
    console.log("Clicked with vacancy_id: " + vacancy_id); // Debugging statement

    $.ajax({
        type: "POST",
        url: "code.php?vacancy_id=" + vacancy_id,
        success: function (response) {
            console.log("AJAX response: " + response); // Debugging statement
            var res = jQuery.parseJSON(response);
            if (res.status == 422) {
                alert(res.message);
            } else if (res.status == 200) {
                // Populate the modal with the vacancy details here
                
                $('#view_vacancyPosition').val(res.data.vacancyPosition);
                $('#view_vacancyLocation').val(res.data.vacancyLocation);
                $('#view_vacancyType').val(res.data.vacancyType);
                $('#view_vacancyStatus').val(res.data.vacancyStatus);
                $('#view_vacancydesc').val(res.data.vacancyDesc);

                $('#viewVacancyModal').modal('show');
            }
        }
    });
});

$(document).on('click', '.deleteVacancy', function(e) {
    e.preventDefault();
    var vacancy_id = $(this).data('vacancyid'); // Get the vacancy ID from the data attribute

    if (confirm('Are you sure you want to delete this vacancy?')) {
        // The user confirmed, proceed with the deletion
        $.ajax({
            type: "POST",
            url: "code.php",
            data: { 
                delete_Vacancy: true, // Corrected syntax (use : instead of =)
                vacancy_id: vacancy_id, // Use the variable vacancy_id
            },
            success: function(response) {
                // Handle the response
                if (response === 'success') {
                    // Reload the page
                    location.reload(); // Use window.location to reload the page
                }
            }
        });
    }
});








</script>
</body>
</html>