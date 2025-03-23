document.addEventListener("DOMContentLoaded", function () {
    const images = document.querySelectorAll(".stadium-img");
    let currentIndex = 0;

    document.getElementById("left-arrow").addEventListener("click", function () {
        images[currentIndex].classList.remove("active");
        currentIndex = (currentIndex === 0) ? images.length - 1 : currentIndex - 1;
        images[currentIndex].classList.add("active");
    });

    document.getElementById("right-arrow").addEventListener("click", function () {
        images[currentIndex].classList.remove("active");
        currentIndex = (currentIndex === images.length - 1) ? 0 : currentIndex + 1;
        images[currentIndex].classList.add("active");
    });
});
