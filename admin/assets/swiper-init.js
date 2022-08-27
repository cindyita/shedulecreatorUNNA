var swiper = new Swiper(".swipersheduleoverview", {
    slidesPerView: 1,
    spaceBetween: 3,
    breakpoints: {
        640: {
            slidesPerView: 2,
            spaceBetween: 3,
        },
        768: {
            slidesPerView: 3,
            spaceBetween: 5,
        },
        1024: {
            slidesPerView: 3,
            spaceBetween: 5,
        },
        1400: {
            slidesPerView: 5,
            spaceBetween: 5,
        },
        1920: {
            slidesPerView: 7,
            spaceBetween: 5,
        },
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    }
});