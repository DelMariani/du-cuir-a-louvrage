// arrow to top
window.addEventListener('scroll', function(){
    console.log(window.scrollY);
    if(window.scrollY > 400){
        document.getElementById('back-to-top').style.display = 'block';
    }else{
        document.getElementById('back-to-top').style.display = 'none';
    }
});

// ballon heart on click add cart

document.getElementById("addJs").addEventListener("click", function() {
    document.getElementById('balloon-heart').style.display = 'block';
});

// navbar

window.addEventListener('scroll', scrollFunction);

function scrollFunction() {
    if (document.body.scrollTop > 150 || document.documentElement.scrollTop > 150) {
        document.getElementById("my-navbar").style.opacity = 0.8;
    } else {
        document.getElementById("my-navbar").style.opacity = 1;
    }
}
