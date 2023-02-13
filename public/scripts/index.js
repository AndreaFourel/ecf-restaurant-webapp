let links, navigationBar, currentLocation;

function initialize () {

    links = document.querySelectorAll('.nav-link');
    navigationBar = document.getElementById('my-navbar');
    currentLocation = location.href;

    window.onscroll = () => {
        scrollFunction();
    };

    dynamicLinks();

    console.log(currentLocation)
    console.log(navigationBar);
    console.log(links);
    console.log('hello');
}

const dynamicLinks = () => {
    for(let i = 0; i < links.length; i++) {
        if(links[i].href === currentLocation) {
            links[i].classList.add('active');
            links[i].setAttribute('aria-current', "page");
        }
    }
}



const scrollFunction = () => {
    if (document.body.scrollTop > 30 || document.documentElement.scrollTop > 30) {
        navigationBar.classList.add('navbar-shadow');
    } else {
        navigationBar.classList.remove('navbar-shadow');
    }
}

