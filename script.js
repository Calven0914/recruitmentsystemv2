let sections = document.querySelectorAll('section');


window.onscroll = () => {
    sections.forEach(sec => {
        let top = window.scrollY;
        let offset = sec.offsetTop;
        let height = sec.offsetHeight;

        if (top >= offset && top < offset + height) {
            sec.classList.add('show-animate');
        } else {
            sec.classList.remove('show-animate');
        }
    });
}


//nav js

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