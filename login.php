
<?php
session_start();



// Check if the Logout link was clicked
if (isset($_GET['logout'])) {
    // Destroy the session
    session_destroy();
    header('Location: login.php'); // Redirect to the login page or any other desired page
    exit;
}




?><html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="shortcut icon" type="icon" href="img/favicon.ico">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a168cf4844.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<link rel="stylesheet" href="style.css">

</head>
<body style="background-color: black;">

    <header class="header">
        <a href="index.html" class="logo"><img src="img/logo.png" alt="Yamiraku" height="80px weight 100px"></a>

        <nav class="navbar">
            <a href="index.html">Home</a>
            <a href="about.html">About</a>
            <a href="lesson.html">Lesson</a>
            <a href="contact.html">Contact</a>
            <a href="career.php">Career</a>
            <a href="login.php" class="active">Login</a>
            
            
        
        </nav> 
        

    </header>
    <section class="home" style="height: 450px;">
        <div class="home-content">
            <h1 >Admin Login Page</h1>
            <h3>Excuse if you're not a staff.</h3>
           
        </div>
    </section>

    <!--Login-->
    <div class="wrapper">
    <div class="login-logo">
        <img src="img/favicon.jpg" alt="yamirakulogo">
    </div>
    <div class="text-center mt-4 name">
        Yamiraku Music Studio
    </div>
    <?php
    if (isset($_GET['error'])) {
        echo '<div class="error-message">' . htmlspecialchars($_GET['error']) . '</div>';
    }
    ?>
    <form action="loginExec.php" method="POST" class="p-3 mt-3">
        <div class="form-field d-flex align-items-center">
            <span class="far fa-user"></span>
            <input type="text" name="staffName" placeholder="Username">
        </div>
        <div class="form-field d-flex align-items-center">
            <span class="fas fa-key"></span>
            <input type="password" name="staffPassword" placeholder="Password">
        </div>
        <button type="submit" name="btn" class="btn mt-3">Login</button>
       
    </form>
</div>








<!-- Go up Button-->
<a href="#" class="to-top">
    <i class="fa-solid fa-arrow-up"></i>
</a>


    <!--Footer -->
    <footer>
    <p>Yamiraku Music Studio</p>
    <p><i>Where words fail, music speaks.</i></p>
    <div class="foot-sci">
    <a href="https://www.facebook.com"><i class='bx bxl-facebook-circle'></i></a>
            <a href="https://www.instagram.com"><i class='bx bxl-instagram'></i></a>
            <a href="https://twitter.com"><i class='bx bxl-twitter'></i></a>
    </div>
    <p style="color: white;">Yamiraku Music Studio, Copyright © 2023</p>

</footer>

<script>
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