<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Career</title>
    <link rel="shortcut icon" type="icon" href="img/favicon.ico">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://kit.fontawesome.com/a168cf4844.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    
<link rel="stylesheet" href="style.css">

</head>
<body style="background: url(img/wallpaper.jpeg) 100% no-repeat">

 <!--Navigation Bar -->
    <header class="header">
        <a href="index.html" class="logo"><img src="img/logo.png" alt="Yamiraku" height="80px weight 100px"></a>

        <nav class="navbar">
            <a href="index.html" >Home</a>
            <a href="about.html">About</a>
            <a href="lesson.html">Lesson</a>
            <a href="contact.html">Contact</a>
            <a href="career.php" class="active">Career</a>
            <a href="login.php">Login</a>

        </nav> 

        
    </section></header>
    <section class="home" style="background: url(img/background4.jpg) 70% 63% no-repeat fixed ;height: 600px;">
    <div class="home-content ">
        <h1 >Career</h1>
        <h3>Work with us. With just a simple Click</h3>
        <br><br>
        <div class="form-box">
    <input type="text" class="search-field career" id="searchInput" placeholder="Search Job">
    <select class="search-field location">
        <option value="">Location</option>
        <option value="Kepong">Kepong</option>
        <option value="Muar">Muar</option>
        <option value="Rawang">Rawang</option>
    </select>
    <select class="search-field job-type">
    <option value="">Job-Type</option>
    <option value="Full Time">Full Time</option>
    <option value="Part Time">Part Time</option>
    <option value="Intern">Intern</option>
    </select>
    <br><br>
    <button class="search-btn" type="button">Search</button>
</div>
</section>
<div class="container mt-3 pt-2  text-white">
        <h4 class="text-center">Vacancy List</h4>
        <hr class="divider">
</div>


    
    <section id="list">
    <div class="container mt-3 pt-2 text-white">
       
        <?php
        include 'dbCon.php';

        $vacancies = $db->query("SELECT * FROM vacancy  ORDER BY DATE(vacancyDate) DESC");
while ($row = $vacancies->fetch_assoc()):
    // Determine the CSS class and text based on vacancyStatus
    $statusClass = $row['vacancyStatus'] == 1 ? 'active' : 'inactive';
    $statusText = $row['vacancyStatus'] == 1 ? 'Active' : 'Inactive';
?>

<div class="row mb-3" >
    <div class="col-md-16 mx-4">
        <div class="card vacancy-list text-white <?php echo $statusClass; ?>" id="searchResult" style="width:88%; height: 300px;">
            <div class="card-body text-center ">
                <h3><?php echo $row['vacancyPosition']; ?></h3>
                <p>Location: <?php echo $row['vacancyLocation']; ?></p>
                <p>Type: <?php echo $row['vacancyType']; ?></p>
                <p>Desc: <?php echo $row['vacancyDesc']; ?></p>
                <p class="text-white <?php echo $row['vacancyStatus'] == 1 ? 'bg-success' : 'bg-danger'; ?>">
                Status: <?php echo $statusText; ?>
                </p>
                <a href="view_vacancy.php?id=<?php echo $row['vacancyID']; ?>" class="btn btn-info">View Details</a>
            </div>
        </div>
    </div>
</div>

<?php endwhile; ?>









   
   

      <!-- Go up Button-->
<a href="#" class="to-top">
    <i class="fa-solid fa-arrow-up"></i>
</a>
        

        
    <!--Footer -->
    <footer >
        <p>Yamiraku Music Studio</p>
        <p>Where words fail, music speaks.</p>
        <div class="foot-sci">
        <a href="https://www.facebook.com"><i class='bx bxl-facebook-circle'></i></a>
            <a href="https://www.instagram.com"><i class='bx bxl-instagram'></i></a>
            <a href="https://twitter.com"><i class='bx bxl-twitter'></i></a>
        </div>
        <p style="color: white;">Yamiraku Music Studio, Copyright © 2023</p>
    
    </footer>
    <script src="https://smtpjs.com/v3/smtp.js"></script>
   
    <script>
$(document).ready(function() {
    // Function to load all vacancies
    function loadAllVacancies() {
        $.ajax({
            url: "loadAllVacancies.php", // Create a new PHP file to load all vacancies
            method: "GET",
            success: function(data) {
                $("#list").html(data); // Update the vacancy list with all vacancies
            }
        });
    }

    // Initial load of all vacancies
    loadAllVacancies();

    // Search input keyup event
    $("#searchInput").keyup(function() {
        var input = $(this).val();

        if (input !== "") {
            $.ajax({
                url: "searchVac.php",
                method: "POST",
                data: {
                    input: input
                },
                success: function(data) {
                    $("#list").html(data); // Update the vacancy list with the filtered results
                }
            });
        } else {
            // If input is empty, load all vacancies
            loadAllVacancies();
        }
    });
});

</script>
     
     <script>

document.addEventListener('DOMContentLoaded', function() {
    const searchBtn = document.querySelector('.search-btn');

    searchBtn.addEventListener('click', function() {
        const location = document.querySelector('.location').value;
        const jobType = document.querySelector('.job-type').value;

        // Make an AJAX request to fetch filtered vacancies
        fetch('fetch_vacancies.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `location=${location}&jobType=${jobType}`,
        })
        .then(response => response.json())
        .then(data => {
            // Handle the response and update the vacancy list with the filtered data
            const vacancyList = document.getElementById('list');
            vacancyList.innerHTML = ''; // Clear existing vacancies

            data.forEach(vacancy => {
                const vacancyCard = createVacancyCard(vacancy);
                vacancyList.appendChild(vacancyCard);
            });
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });

    function createVacancyCard(vacancy) {
        const card = document.createElement('div');
        card.className = 'row mb-3';
        card.innerHTML = `
        <div class="col-md-15 mx-4">
            <div class="card vacancy-list text-white size-4 ${vacancy.vacancyStatus === 1 ? 'active' : 'inactive'}" style="width: 88%; height: 300px;">
                <div class="card-body text-center">
                    <h3>${vacancy.vacancyPosition}</h3>
                    <p>Location: ${vacancy.vacancyLocation}</p>
                    <p>Type: ${vacancy.vacancyType}</p>
                    <p>Desc: ${vacancy.vacancyDesc}</p>
                    <p class="text-white ${vacancy.vacancyStatus === 1 ? 'bg-success' : 'bg-danger'}">
                        Status: ${vacancy.vacancyStatus === 1 ? 'Active' : 'Inactive'}
                    </p>
                    <a href="view_vacancy.php?id=${vacancy.vacancyID}" class="btn btn-info">View Details</a>
                </div>
            </div>
        </div>
    `;
        return card;
    }
});


    $('.car-card.vacancy-list').click(function(){
        location.href = "index.php?page=view_vacancy&id=" + $(this).attr('data-id');
    });

    $('#filter').keyup(function(e){
        var filter = $(this).val();

        $('.card.vacancy-list .filter-txt').each(function(){
            var txt = $(this).html();
            
            if((txt.toLowerCase()).includes(filter.toLowerCase())) {
                $(this).closest('.card').toggle(true);
            } else {
                $(this).closest('.card').toggle(false);
            }
        });
    });

    // Get the search input element
const searchInput = document.getElementById('searchInput');

// Get all the vacancy cards
const vacancyCards = document.querySelectorAll('.vacancy-list');

searchInput.addEventListener('input', function () {
    const searchTerm = searchInput.value.toLowerCase();

    // Iterate through each vacancy card and check if it matches the search term
    vacancyCards.forEach((card) => {
        const vacancyPosition = card.querySelector('h3').textContent.toLowerCase();
        const vacancyLocation = card.querySelector('p:contains("Location:")').textContent.toLowerCase();
        const shouldDisplay = vacancyPosition.includes(searchTerm) || vacancyLocation.includes(searchTerm);
        card.style.display = shouldDisplay ? 'block' : 'none';
    });
});



        

    //nav scroll animation
 const body =document.body;
 let lastScroll = 0;
 
 window.addEventListener('scroll',() =>{
     const currentScroll = window.pageYOffset
 
     if (currentScroll <= 0){
         body.classList.remove("scroll-up")
     }
 
     if(currentScroll > lastScroll && !body.classList.contains("scroll-down")){
         body.classList.remove("scroll-up")
         body.classList.add("scroll-down")
     }
 
     if(currentScroll < lastScroll && body.classList.contains("scroll-down")){
         body.classList.remove("scroll-down")
         body.classList.add("scroll-up")
     }
 
     lastScroll = currentScroll;
 })

 //transition css

 const sections = document.querySelectorAll("section");

window.onscroll = () => {
    sections.forEach(sec => {
        let top = window.scrollY;
        let offset = sec.offsetTop - 150; // Removed the semicolon and fixed the offset calculation
        let height = sec.offsetHeight;

        if (top >= offset && top < offset + height) {
            sec.classList.add('show-animate');
        } 
    });
};

//to-top button

const toTop = document.querySelector(".to-top");

window.addEventListener("scroll", () => {
    if (window.pageYOffset > 100) {
        toTop.classList.add("active");
    } else {
        toTop.classList.remove("active");
    }


})

        </script>   
    
</body>
</html>