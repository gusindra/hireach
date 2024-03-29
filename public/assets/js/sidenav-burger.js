var sidenav = document.querySelector("aside");
var sidenav_trigger = document.querySelector("[sidenav-trigger]");
var sidenav_close_button = document.querySelector("[sidenav-close-btn]");
var sidenav_burger = sidenav_trigger.firstElementChild;
var top_bread = sidenav_burger.firstElementChild;
var bottom_bread = sidenav_burger.lastElementChild;
sidenav_trigger.addEventListener("click", function() {
    if (pageName != "rtl-page") {
        if (sidenav_trigger.getAttribute("aria-expanded") == "false") {
            sidenav_trigger.setAttribute("aria-expanded", "true");
            sidenav.classList.add("translate-x-0");
            sidenav.classList.remove("-translate-x-full");
            sidenav.classList.add("shadow-soft-xl");
            top_bread.classList.add("translate-x-[5px]");
            bottom_bread.classList.add("translate-x-[5px]");
        } else {
            sidenav_trigger.setAttribute("aria-expanded", "false");
            sidenav.classList.remove("translate-x-0");
            sidenav.classList.add("-translate-x-full");
            sidenav.classList.remove("shadow-soft-xl");
            top_bread.classList.remove("translate-x-[5px]");
            bottom_bread.classList.remove("translate-x-[5px]");
        }
    } else {
        if (sidenav_trigger.getAttribute("aria-expanded") == "false") {
            sidenav_trigger.setAttribute("aria-expanded", "true");
            sidenav.classList.add("translate-x-0");
            sidenav.classList.remove("translate-x-full");
            sidenav.classList.add("shadow-soft-xl");
            top_bread.classList.add("-translate-x-[5px]");
            bottom_bread.classList.add("-translate-x-[5px]");
        } else {
            sidenav_trigger.setAttribute("aria-expanded", "false");
            sidenav.classList.remove("translate-x-0");
            sidenav.classList.add("translate-x-full");
            sidenav.classList.remove("shadow-soft-xl");
            top_bread.classList.remove("-translate-x-[5px]");
            bottom_bread.classList.remove("-translate-x-[5px]");
        }
    }
});
sidenav_close_button.addEventListener("click", function() {
    sidenav_trigger.click();
});
window.addEventListener("click", function(e) {
    if (!sidenav.contains(e.target) && !sidenav_trigger.contains(e.target)) {
        if (sidenav_trigger.getAttribute("aria-expanded") == "true") {
            sidenav_trigger.click();
        }
    }
});
