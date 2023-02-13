const links = document.querySelectorAll('.nav-link');
const navBar = document.getElementById('my-navbar');
console.log(navBar);
console.log(links);
console.log('hello');
links.forEach((link) => {
    link.addEventListener('click', (e) => {
        links.forEach((link) => {
            link.classList.remove('active');
        });
        e.preventDefault();
        link.classList.add('active');
    });
});


window.onscroll = () => {
    scrollFunction();
};

function scrollFunction () {
    if (document.body.scrollTop > 30 || document.documentElement.scrollTop > 30) {
        navBar.classList.add('navbar-shadow');
    } else {
        navBar.classList.remove('navbar-shadow');
    }
}