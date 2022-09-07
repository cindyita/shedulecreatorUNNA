var swiper = new Swiper(".swipersheduleoverview", {
    slidesPerView: 1,
    spaceBetween: 3,
    breakpoints: {
        640: {
            slidesPerView: 2,
            spaceBetween: 2,
        },
        768: {
            slidesPerView: 3,
            spaceBetween: 4,
        },
        1024: {
            slidesPerView: 3,
            spaceBetween: 4,
        },
        1400: {
            slidesPerView: 5,
            spaceBetween: 4,
        },
        1920: {
            slidesPerView: 6,
            spaceBetween: 4,
        },
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    }
});